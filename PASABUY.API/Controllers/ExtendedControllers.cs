using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using PASABUY.API.Data;
using PASABUY.API.Models;
using System;
using System.Linq;
using System.Threading.Tasks;

namespace PASABUY.API.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class WantedController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public WantedController(PasaBuyDbContext db) { _db = db; }

        [HttpGet]
        public async Task<IActionResult> GetWantedPosts()
        {
            var posts = await _db.WantedPosts
                .Include(w => w.Category)
                .Include(w => w.MeetupLocation)
                .Include(w => w.User).ThenInclude(u => u!.StudentProfile)
                .Where(w => w.Status == "ACTIVE")
                .OrderByDescending(w => w.CreatedAt)
                .ToListAsync();

            return Ok(posts);
        }

        [HttpPost]
        public async Task<IActionResult> CreateWantedPost([FromBody] CreateWantedRequest req)
        {
            var post = new WantedPost
            {
                UserId = req.UserId,
                CategoryId = req.CategoryId,
                Title = req.Title,
                Description = req.Description,
                MaximumBudget = req.MaximumBudget,
                Condition = req.Condition,
                ImageUrl = string.IsNullOrWhiteSpace(req.ImageUrl) ? "https://images.unsplash.com/photo-1553406830-ef2513450d76?w=500&q=80" : req.ImageUrl,
                MeetupLocationId = req.MeetupLocationId,
                Status = "ACTIVE"
            };

            _db.WantedPosts.Add(post);
            await _db.SaveChangesAsync();
            return Ok(post);
        }
    }

    public class CreateWantedRequest
    {
        public int UserId { get; set; }
        public int CategoryId { get; set; }
        public string Title { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public decimal MaximumBudget { get; set; }
        public string Condition { get; set; } = "Any";
        public string ImageUrl { get; set; } = string.Empty;
        public int MeetupLocationId { get; set; }
    }

    [ApiController]
    [Route("api/[controller]")]
    public class ConversationsController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public ConversationsController(PasaBuyDbContext db) { _db = db; }

        [HttpGet]
        public async Task<IActionResult> GetUserConversations([FromQuery] int userId)
        {
            var convIds = await _db.ConversationParticipants
                .Where(cp => cp.UserId == userId)
                .Select(cp => cp.ConversationId)
                .ToListAsync();

            var conversations = await _db.Conversations
                .Include(c => c.Listing).ThenInclude(l => l!.Images)
                .Include(c => c.Participants).ThenInclude(p => p.User).ThenInclude(u => u!.StudentProfile)
                .Include(c => c.Messages)
                .Where(c => convIds.Contains(c.Id))
                .OrderByDescending(c => c.UpdatedAt)
                .ToListAsync();

            return Ok(conversations);
        }

        [HttpPost("{conversationId}/messages")]
        public async Task<IActionResult> SendMessage(int conversationId, [FromBody] SendMessageRequest req)
        {
            var msg = new Message
            {
                ConversationId = conversationId,
                SenderId = req.SenderId,
                MessageType = req.MessageType ?? "text",
                MessageText = req.MessageText,
                AttachmentUrl = req.AttachmentUrl ?? string.Empty
            };

            _db.Messages.Add(msg);

            var conv = await _db.Conversations.FindAsync(conversationId);
            if (conv != null) conv.UpdatedAt = DateTime.UtcNow;

            await _db.SaveChangesAsync();
            return Ok(msg);
        }
    }

    public class SendMessageRequest
    {
        public int SenderId { get; set; }
        public string MessageText { get; set; } = string.Empty;
        public string MessageType { get; set; } = "text";
        public string AttachmentUrl { get; set; } = string.Empty;
    }

    [ApiController]
    [Route("api/[controller]")]
    public class ReportsController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public ReportsController(PasaBuyDbContext db) { _db = db; }

        [HttpGet]
        public async Task<IActionResult> GetReports()
        {
            var reports = await _db.Reports
                .Include(r => r.Reporter).ThenInclude(u => u!.StudentProfile)
                .Include(r => r.ReportedUser).ThenInclude(u => u!.StudentProfile)
                .Include(r => r.Listing)
                .OrderByDescending(r => r.CreatedAt)
                .ToListAsync();

            return Ok(reports);
        }

        [HttpPost]
        public async Task<IActionResult> CreateReport([FromBody] CreateReportRequest req)
        {
            var report = new Report
            {
                ReporterId = req.ReporterId,
                ReportedUserId = req.ReportedUserId,
                ListingId = req.ListingId,
                Reason = req.Reason ?? "Scam",
                Details = req.Details ?? string.Empty,
                Status = "PENDING"
            };

            _db.Reports.Add(report);
            await _db.SaveChangesAsync();
            return Ok(new { message = "Report submitted successfully! PasaBuy Admin will review it shortly.", reportId = report.Id });
        }
    }

    public class CreateReportRequest
    {
        public int ReporterId { get; set; }
        public int? ReportedUserId { get; set; }
        public int? ListingId { get; set; }
        public string Reason { get; set; } = "Scam";
        public string Details { get; set; } = string.Empty;
    }

    [ApiController]
    [Route("api/[controller]")]
    public class AdminController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public AdminController(PasaBuyDbContext db) { _db = db; }

        [HttpGet("dashboard")]
        public async Task<IActionResult> GetDashboard()
        {
            var totalStudents = await _db.Users.CountAsync(u => u.Role == "STUDENT");
            var verifiedStudents = await _db.Users.CountAsync(u => u.Role == "STUDENT" && u.Status == "VERIFIED");
            var activeListings = await _db.Listings.CountAsync(l => l.Status == "ACTIVE");
            var completedTransactions = await _db.Transactions.CountAsync(t => t.Status == "COMPLETED");
            var totalRevenue = await _db.Payments.Where(p => p.Status == "PAID").SumAsync(p => p.Amount);
            var pendingReports = await _db.Reports.CountAsync(r => r.Status == "PENDING");
            var failedPayments = await _db.Payments.CountAsync(p => p.Status == "FAILED");

            return Ok(new
            {
                totalStudents,
                verifiedStudents,
                activeListings,
                completedTransactions,
                totalRevenue, // Listing fees only!
                pendingReports,
                failedPayments
            });
        }

        [HttpPost("users/{userId}/suspend")]
        public async Task<IActionResult> SuspendUser(int userId, [FromBody] SuspendUserRequest? req)
        {
            var user = await _db.Users.Include(u => u.StudentProfile).FirstOrDefaultAsync(u => u.Id == userId);
            if (user == null) return NotFound(new { message = "User not found." });

            user.Status = "SUSPENDED";
            if (user.StudentProfile != null) user.StudentProfile.VerificationStatus = "SUSPENDED";

            _db.AuditLogs.Add(new AuditLog
            {
                AdminId = 1,
                Action = "USER_SUSPENDED",
                TargetType = "User",
                TargetId = userId.ToString(),
                Details = req?.Reason ?? "Policy Violation / Report Investigation"
            });

            await _db.SaveChangesAsync();
            return Ok(new { message = $"Student {user.Email} has been SUSPENDED / BANNED.", status = "SUSPENDED" });
        }

        [HttpPost("users/{userId}/restore")]
        public async Task<IActionResult> RestoreUser(int userId)
        {
            var user = await _db.Users.Include(u => u.StudentProfile).FirstOrDefaultAsync(u => u.Id == userId);
            if (user == null) return NotFound();

            user.Status = "VERIFIED";
            if (user.StudentProfile != null) user.StudentProfile.VerificationStatus = "VERIFIED";

            await _db.SaveChangesAsync();
            return Ok(new { message = $"Student {user.Email} has been RESTORED.", status = "VERIFIED" });
        }

        [HttpGet("listings")]
        public async Task<IActionResult> GetListings()
        {
            var listings = await _db.Listings
                .Include(l => l.Category)
                .Include(l => l.MeetupLocation)
                .Include(l => l.Seller).ThenInclude(s => s!.StudentProfile)
                .Include(l => l.Images)
                .OrderByDescending(l => l.CreatedAt)
                .ToListAsync();

            return Ok(listings);
        }

        [HttpDelete("listings/{id}")]
        public async Task<IActionResult> DeleteListing(int id)
        {
            var listing = await _db.Listings.FindAsync(id);
            if (listing == null) return NotFound();

            listing.Status = "REMOVED";
            _db.AuditLogs.Add(new AuditLog
            {
                AdminId = 1,
                Action = "LISTING_REMOVED",
                TargetType = "Listing",
                TargetId = id.ToString(),
                Details = "Admin removed listing for policy compliance"
            });

            await _db.SaveChangesAsync();
            return Ok(new { message = "Listing removed successfully." });
        }

        [HttpGet("payments")]
        public async Task<IActionResult> GetPayments()
        {
            var payments = await _db.Payments
                .Include(p => p.User).ThenInclude(u => u!.StudentProfile)
                .Include(p => p.Listing)
                .OrderByDescending(p => p.CreatedAt)
                .ToListAsync();

            return Ok(payments);
        }

        [HttpGet("students")]
        public async Task<IActionResult> GetStudents()
        {
            var students = await _db.Users
                .Include(u => u.StudentProfile)
                .Where(u => u.Role == "STUDENT")
                .OrderByDescending(u => u.CreatedAt)
                .ToListAsync();

            return Ok(students);
        }

        [HttpPost("students/{id}/verify")]
        public async Task<IActionResult> VerifyStudent(int id)
        {
            var user = await _db.Users.Include(u => u.StudentProfile).FirstOrDefaultAsync(u => u.Id == id);
            if (user == null) return NotFound();

            user.Status = "VERIFIED";
            if (user.StudentProfile != null) user.StudentProfile.VerificationStatus = "VERIFIED";

            _db.AuditLogs.Add(new AuditLog
            {
                AdminId = 1,
                Action = "USER_VERIFIED",
                TargetType = "User",
                TargetId = id.ToString(),
                Details = "Student account manually verified by admin"
            });

            await _db.SaveChangesAsync();
            return Ok(new { message = "Student verified successfully." });
        }

        [HttpPost("reports/{id}/dismiss")]
        public async Task<IActionResult> DismissReport(int id)
        {
            var report = await _db.Reports.FindAsync(id);
            if (report == null) return NotFound();

            report.Status = "DISMISSED";
            await _db.SaveChangesAsync();
            return Ok(new { message = "Report dismissed." });
        }
    }

    public class SuspendUserRequest
    {
        public string Reason { get; set; } = "Policy Violation";
    }
}
