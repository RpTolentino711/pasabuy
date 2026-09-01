using Microsoft.Extensions.Configuration;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;

namespace PASABUY.API.Services
{
    public class PayMongoPaymentResponse
    {
        public string PaymentId { get; set; } = string.Empty;
        public decimal Amount { get; set; }
        public string QrCodeUrl { get; set; } = string.Empty;
        public string CheckoutUrl { get; set; } = string.Empty;
        public string Status { get; set; } = "PENDING";
    }

    public interface IPayMongoService
    {
        Task<PayMongoPaymentResponse> CreatePostingFeePaymentAsync(int listingId, decimal amount, string title);
    }

    public class PayMongoService : IPayMongoService
    {
        private readonly IConfiguration _config;
        private readonly HttpClient _http;

        public PayMongoService(IConfiguration config, IHttpClientFactory httpClientFactory)
        {
            _config = config;
            _http = httpClientFactory.CreateClient();
        }

        public async Task<PayMongoPaymentResponse> CreatePostingFeePaymentAsync(int listingId, decimal amount, string title)
        {
            var secretKey = _config["PayMongo:SecretKey"];
            var testSecretKey = _config["PayMongo:TestSecretKey"] ?? "YOUR_PAYMONGO_TEST_SECRET_KEY";

            // Try SecretKey first, fallback to TestSecretKey if unauthorized or inactive
            var keysToTry = new List<string>();
            if (!string.IsNullOrWhiteSpace(secretKey)) keysToTry.Add(secretKey);
            if (!string.IsNullOrWhiteSpace(testSecretKey) && testSecretKey != secretKey) keysToTry.Add(testSecretKey);

            foreach (var key in keysToTry)
            {
                try
                {
                    var requestMessage = new HttpRequestMessage(HttpMethod.Post, "https://api.paymongo.com/v1/checkout_sessions");
                    var authBytes = Encoding.ASCII.GetBytes($"{key}:");
                    requestMessage.Headers.Authorization = new AuthenticationHeaderValue("Basic", Convert.ToBase64String(authBytes));

                    var amountInCents = (int)(amount * 100);
                    if (amountInCents < 100) amountInCents = 100; // PayMongo minimum 100 cents (₱1.00)

                    var appBaseUrl = _config["PayMongo:AppBaseUrl"] ?? "http://localhost:5200";
                    if (appBaseUrl.EndsWith("/")) appBaseUrl = appBaseUrl.TrimEnd('/');

                    var payload = new
                    {
                        data = new
                        {
                            attributes = new
                            {
                                send_email_receipt = true,
                                show_description = true,
                                show_line_items = true,
                                cancel_url = appBaseUrl,
                                success_url = $"{appBaseUrl}?payment=success",
                                description = $"PasaBuy Campus Marketplace Listing Fee (#{listingId})",
                                line_items = new[]
                                {
                                    new
                                    {
                                        currency = "PHP",
                                        amount = amountInCents,
                                        name = $"PasaBuy Listing Fee: {title}",
                                        quantity = 1
                                    }
                                },
                                payment_method_types = new[] { "gcash", "paymaya", "card" }
                            }
                        }
                    };

                    requestMessage.Content = new StringContent(JsonSerializer.Serialize(payload), Encoding.UTF8, "application/json");

                    var response = await _http.SendAsync(requestMessage);
                    var json = await response.Content.ReadAsStringAsync();

                    if (response.IsSuccessStatusCode)
                    {
                        using var doc = JsonDocument.Parse(json);
                        var data = doc.RootElement.GetProperty("data");
                        var id = data.GetProperty("id").GetString() ?? "";
                        var attributes = data.GetProperty("attributes");
                        var checkoutUrl = attributes.GetProperty("checkout_url").GetString() ?? "";

                        return new PayMongoPaymentResponse
                        {
                            PaymentId = id,
                            Amount = amount,
                            QrCodeUrl = $"https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={Uri.EscapeDataString(checkoutUrl)}",
                            CheckoutUrl = checkoutUrl,
                            Status = "PENDING"
                        };
                    }
                    else
                    {
                        Console.WriteLine($"[PayMongo API Key '{key.Substring(0, Math.Min(10, key.Length))}...'] Returned Status: {response.StatusCode}, Content: {json}");
                    }
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"[PayMongo Exception] {ex.Message}");
                }
            }

            // Fallback Simulation Mode
            var refId = $"PM-{DateTime.UtcNow.Ticks.ToString().Substring(10)}";
            return new PayMongoPaymentResponse
            {
                PaymentId = refId,
                Amount = amount,
                QrCodeUrl = $"https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PAYMONGO_PASABUY_FEE_{refId}_{amount}",
                CheckoutUrl = $"https://www.paymongo.com",
                Status = "PENDING"
            };
        }
    }
}
