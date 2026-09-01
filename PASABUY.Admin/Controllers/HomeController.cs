using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Net.Http.Json;
using System.Threading.Tasks;

namespace PASABUY.Admin.Controllers
{
    public class HomeController : Controller
    {
        private readonly HttpClient _http;

        public HomeController(IHttpClientFactory httpClientFactory)
        {
            _http = httpClientFactory.CreateClient();
            _http.BaseAddress = new Uri("http://localhost:5000");
        }

        public async Task<IActionResult> Index()
        {
            ViewData["Title"] = "Dashboard Overview";
            ViewData["ActivePage"] = "Dashboard";

            try
            {
                var stats = await _http.GetFromJsonAsync<DashboardStatsDto>("api/admin/dashboard");
                if (stats != null) return View(stats);
            }
            catch
            {
                // Fallback clean initial state stats
            }

            var defaultStats = new DashboardStatsDto
            {
                TotalStudents = 3,
                VerifiedStudents = 3,
                ActiveListings = 0,
                CompletedTransactions = 0,
                TotalRevenue = 0.00m,
                PendingReports = 0,
                FailedPayments = 0
            };

            return View(defaultStats);
        }

        public IActionResult Listings()
        {
            ViewData["Title"] = "Product Listing Management";
            ViewData["ActivePage"] = "Listings";
            return View();
        }

        public IActionResult Categories()
        {
            ViewData["Title"] = "Marketplace Category Management";
            ViewData["ActivePage"] = "Categories";
            return View();
        }

        public IActionResult Wanted()
        {
            ViewData["Title"] = "Wanted Post Management";
            ViewData["ActivePage"] = "Wanted";
            return View();
        }

        public IActionResult Students()
        {
            ViewData["Title"] = "Student Verification & User Management";
            ViewData["ActivePage"] = "Students";
            return View();
        }

        public IActionResult Reports()
        {
            ViewData["Title"] = "Reports & Content Moderation";
            ViewData["ActivePage"] = "Reports";
            return View();
        }

        public IActionResult Payments()
        {
            ViewData["Title"] = "PayMongo Posting Fee Records";
            ViewData["ActivePage"] = "Payments";
            return View();
        }

        public IActionResult Meetups()
        {
            ViewData["Title"] = "Campus Meetup Locations";
            ViewData["ActivePage"] = "Meetups";
            return View();
        }

        public IActionResult AuditLogs()
        {
            ViewData["Title"] = "Administrative Audit Logs";
            ViewData["ActivePage"] = "AuditLogs";
            return View();
        }
    }

    public class DashboardStatsDto
    {
        public int TotalStudents { get; set; }
        public int VerifiedStudents { get; set; }
        public int ActiveListings { get; set; }
        public int CompletedTransactions { get; set; }
        public decimal TotalRevenue { get; set; }
        public int PendingReports { get; set; }
        public int FailedPayments { get; set; }
    }
}
