using Microsoft.Extensions.Configuration;
using System;
using System.Net;
using System.Net.Mail;
using System.Threading.Tasks;

namespace PASABUY.API.Services
{
    public interface IEmailService
    {
        Task<bool> SendOtpEmailAsync(string recipientEmail, string otpCode);
    }

    public class EmailService : IEmailService
    {
        private readonly IConfiguration _config;

        public EmailService(IConfiguration config)
        {
            _config = config;
        }

        public async Task<bool> SendOtpEmailAsync(string recipientEmail, string otpCode)
        {
            try
            {
                var smtpServer = _config["EmailSettings:SmtpServer"] ?? "smtp.hostinger.com";
                var smtpPort = int.Parse(_config["EmailSettings:SmtpPort"] ?? "587");
                var senderEmail = _config["EmailSettings:SenderEmail"] ?? "PASABUY@pasabuy.site";
                var senderName = _config["EmailSettings:SenderName"] ?? "PasaBuy Verification OTP";
                var senderPassword = _config["EmailSettings:SenderPassword"] ?? "Vanossgaming@10";

                using var message = new MailMessage();
                message.From = new MailAddress(senderEmail, senderName);
                message.To.Add(new MailAddress(recipientEmail));
                message.Subject = $"🔑 PasaBuy Verification OTP: {otpCode}";
                message.IsBodyHtml = true;

                message.Body = $@"
                <div style='font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px; text-align: center;'>
                    <div style='max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);'>
                        <h2 style='color: #5F27CD; margin-bottom: 8px;'>🛍️ PasaBuy Campus Marketplace</h2>
                        <p style='color: #64748B; font-size: 14px;'>Student Account Security Verification</p>
                        <hr style='border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;'>
                        <p style='color: #1e293b; font-size: 15px;'>Here is your One-Time Password (OTP) code:</p>
                        <div style='background: #5F27CD; color: #ffffff; font-size: 28px; font-weight: bold; letter-spacing: 6px; padding: 14px 24px; border-radius: 12px; display: inline-block; margin: 16px 0;'>
                            {otpCode}
                        </div>
                        <p style='color: #94a3b8; font-size: 12px; margin-top: 20px;'>This OTP code will expire in 10 minutes. Do not share this code with anyone.</p>
                    </div>
                </div>";

                var portsToTry = new[] { 587, 465, 25 };
                foreach (var port in portsToTry)
                {
                    try
                    {
                        using var client = new SmtpClient(smtpServer, port);
                        client.Credentials = new NetworkCredential(senderEmail, senderPassword);
                        client.EnableSsl = true;
                        client.Timeout = 10000;

                        await client.SendMailAsync(message);
                        Console.WriteLine($"[EmailService] OTP {otpCode} sent successfully to {recipientEmail} via {senderEmail} on port {port}");
                        return true;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine($"[EmailService Port {port} Attempt Failed] {ex.Message}");
                    }
                }
                return false;
            }
            catch (Exception ex)
            {
                Console.WriteLine($"[EmailService Fatal Exception] {ex.Message}");
                return false;
            }
        }
    }
}
