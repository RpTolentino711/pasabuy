using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using PASABUY.API.Data;
using PASABUY.API.Models;
using PASABUY.API.Services;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace PASABUY.API.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class AuthController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public AuthController(PasaBuyDbContext db) { _db = db; }

        [HttpPost("register")]
        public async Task<IActionResult> Register([FromBody] RegisterRequest req)
        {
            if (string.IsNullOrWhiteSpace(req.Email) || string.IsNullOrWhiteSpace(req.Password))
                return BadRequest(new { message = "Email and Password are required." });

            if (await _db.Users.AnyAsync(u => u.Email == req.Email))
                return BadRequest(new { message = "An account with this email already exists." });

            var user = new User
            {
                Email = req.Email,
                PasswordHash = req.Password, // Hashed in production
                Role = "STUDENT",
                Status = "VERIFIED"
            };
            _db.Users.Add(user);
            await _db.SaveChangesAsync();

            var profile = new StudentProfile
            {
                UserId = user.Id,
                FirstName = req.FirstName ?? "Student",
                LastName = req.LastName ?? "User",
                StudentNumber = req.StudentNumber ?? $"2024-{Random.Shared.Next(10000, 99999)}",
                SchoolEmail = req.SchoolEmail ?? req.Email,
                Course = req.Course ?? "BS General",
                YearLevel = req.YearLevel ?? "1st Year",
                VerificationStatus = "VERIFIED",
                Rating = 5.0,
                CompletedTransactions = 0
            };
            _db.StudentProfiles.Add(profile);
            await _db.SaveChangesAsync();

            return Ok(new { token = $"jwt_token_simulated_{user.Id}", userId = user.Id, email = user.Email, name = $"{profile.FirstName} {profile.LastName}", role = user.Role });
        }

        [HttpPost("login")]
        public async Task<IActionResult> Login([FromBody] LoginRequest req)
        {
            var user = await _db.Users.Include(u => u.StudentProfile).FirstOrDefaultAsync(u => u.Email == req.Email);
            if (user == null || user.PasswordHash != req.Password)
                return BadRequest(new { message = "Invalid email or password." });

            if (user.Status == "SUSPENDED")
                return BadRequest(new { message = "Your account has been suspended due to policy violations." });

            user.LastLoginAt = DateTime.UtcNow;
            await _db.SaveChangesAsync();

            var profileName = user.StudentProfile != null ? $"{user.StudentProfile.FirstName} {user.StudentProfile.LastName}" : "Campus User";
            return Ok(new { token = $"jwt_token_simulated_{user.Id}", userId = user.Id, email = user.Email, name = profileName, role = user.Role, status = user.Status, profile = user.StudentProfile });
        }
    }

    public class RegisterRequest
    {
        public string Email { get; set; } = string.Empty;
        public string Password { get; set; } = string.Empty;
        public string FirstName { get; set; } = string.Empty;
        public string LastName { get; set; } = string.Empty;
        public string StudentNumber { get; set; } = string.Empty;
        public string SchoolEmail { get; set; } = string.Empty;
        public string Course { get; set; } = string.Empty;
        public string YearLevel { get; set; } = string.Empty;
    }

    public class LoginRequest
    {
        public string Email { get; set; } = string.Empty;
        public string Password { get; set; } = string.Empty;
    }

    [ApiController]
    [Route("api/[controller]")]
    public class ListingsController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        private readonly IFeeCalculationService _feeCalc;
        private readonly IPayMongoService _payMongo;

        public ListingsController(PasaBuyDbContext db, IFeeCalculationService feeCalc, IPayMongoService payMongo)
        {
            _db = db;
            _feeCalc = feeCalc;
            _payMongo = payMongo;
        }

        [HttpGet]
        public async Task<IActionResult> GetListings([FromQuery] string? search, [FromQuery] int? categoryId, [FromQuery] decimal? minPrice, [FromQuery] decimal? maxPrice, [FromQuery] string? condition, [FromQuery] string? sort)
        {
            var query = _db.Listings
                .Include(l => l.Category)
                .Include(l => l.MeetupLocation)
                .Include(l => l.Images)
                .Include(l => l.Seller).ThenInclude(s => s!.StudentProfile)
                .Where(l => l.Status == "ACTIVE");

            if (!string.IsNullOrWhiteSpace(search))
                query = query.Where(l => l.Title.Contains(search) || l.Description.Contains(search));

            if (categoryId.HasValue && categoryId.Value > 0)
                query = query.Where(l => l.CategoryId == categoryId.Value);

            if (minPrice.HasValue) query = query.Where(l => l.Price >= minPrice.Value);
            if (maxPrice.HasValue) query = query.Where(l => l.Price <= maxPrice.Value);
            if (!string.IsNullOrWhiteSpace(condition) && condition != "All") query = query.Where(l => l.Condition == condition);

            query = sort switch
            {
                "lowest" => query.OrderBy(l => l.Price),
                "highest" => query.OrderByDescending(l => l.Price),
                "oldest" => query.OrderBy(l => l.CreatedAt),
                "most_viewed" => query.OrderByDescending(l => l.Views),
                _ => query.OrderByDescending(l => l.CreatedAt)
            };

            var result = await query.ToListAsync();
            return Ok(result);
        }

        [HttpGet("{id}")]
        public async Task<IActionResult> GetListingById(int id)
        {
            var listing = await _db.Listings
                .Include(l => l.Category)
                .Include(l => l.MeetupLocation)
                .Include(l => l.Images)
                .Include(l => l.Seller).ThenInclude(s => s!.StudentProfile)
                .FirstOrDefaultAsync(l => l.Id == id);

            if (listing == null) return NotFound();

            listing.Views += 1;
            await _db.SaveChangesAsync();

            return Ok(listing);
        }

        [HttpPost]
        public async Task<IActionResult> CreateListing([FromBody] CreateListingRequest req)
        {
            var sellerId = req.SellerId > 0 ? req.SellerId : 1;
            var categoryId = req.CategoryId > 0 ? req.CategoryId : 1;
            var meetupId = req.MeetupLocationId > 0 ? req.MeetupLocationId : 1;

            var fee = _feeCalc.CalculatePostingFee(req.Price);

            var listing = new Listing
            {
                SellerId = sellerId,
                CategoryId = categoryId,
                Title = string.IsNullOrWhiteSpace(req.Title) ? "Campus Item" : req.Title,
                Description = string.IsNullOrWhiteSpace(req.Description) ? "Campus item for sale" : req.Description,
                Price = req.Price,
                Condition = string.IsNullOrWhiteSpace(req.Condition) ? "Good" : req.Condition,
                MeetupLocationId = meetupId,
                Status = "PENDING_PAYMENT"
            };

            _db.Listings.Add(listing);
            await _db.SaveChangesAsync();

            if (req.ImageUrls != null && req.ImageUrls.Count > 0)
            {
                for (int i = 0; i < req.ImageUrls.Count; i++)
                {
                    _db.ListingImages.Add(new ListingImage
                    {
                        ListingId = listing.Id,
                        ImageUrl = req.ImageUrls[i],
                        SortOrder = i + 1,
                        IsPrimary = (i == 0)
                    });
                }
                await _db.SaveChangesAsync();
            }

            var paymentIntent = await _payMongo.CreatePostingFeePaymentAsync(listing.Id, fee, listing.Title);

            var paymentRecord = new PaymentRecord
            {
                UserId = req.SellerId,
                ListingId = listing.Id,
                Amount = fee,
                Currency = "PHP",
                Provider = "PayMongo",
                ProviderReference = paymentIntent.PaymentId,
                Status = "PENDING"
            };
            _db.Payments.Add(paymentRecord);
            await _db.SaveChangesAsync();

            return Ok(new { listingId = listing.Id, postingFee = fee, payment = paymentIntent });
        }

        [HttpPost("{id}/reserve")]
        public async Task<IActionResult> ReserveListing(int id, [FromQuery] int buyerId)
        {
            var listing = await _db.Listings.FindAsync(id);
            if (listing == null || listing.Status != "ACTIVE") return BadRequest(new { message = "Listing is not available for reservation." });

            listing.Status = "RESERVED";
            listing.ReservedAt = DateTime.UtcNow;

            var transaction = new TransactionRecord
            {
                ListingId = listing.Id,
                BuyerId = buyerId,
                SellerId = listing.SellerId,
                AgreedPrice = listing.Price,
                MeetupLocationId = listing.MeetupLocationId,
                Status = "RESERVED"
            };
            _db.Transactions.Add(transaction);
            await _db.SaveChangesAsync();

            return Ok(new { message = "Listing successfully reserved!", transactionId = transaction.Id });
        }

        [HttpPost("{id}/sold")]
        public async Task<IActionResult> MarkSold(int id)
        {
            var listing = await _db.Listings.FindAsync(id);
            if (listing == null) return NotFound();

            listing.Status = "SOLD";
            listing.SoldAt = DateTime.UtcNow;

            var transaction = await _db.Transactions.FirstOrDefaultAsync(t => t.ListingId == id && t.Status == "RESERVED");
            if (transaction != null)
            {
                transaction.Status = "COMPLETED";
                transaction.CompletedAt = DateTime.UtcNow;

                var sellerProfile = await _db.StudentProfiles.FirstOrDefaultAsync(p => p.UserId == listing.SellerId);
                if (sellerProfile != null) sellerProfile.CompletedTransactions += 1;

                var buyerProfile = await _db.StudentProfiles.FirstOrDefaultAsync(p => p.UserId == transaction.BuyerId);
                if (buyerProfile != null) buyerProfile.CompletedTransactions += 1;
            }

            await _db.SaveChangesAsync();
            return Ok(new { message = "Item marked as SOLD and transaction completed!" });
        }

        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteListing(int id)
        {
            var listing = await _db.Listings.FindAsync(id);
            if (listing == null) return NotFound(new { message = "Listing not found." });

            listing.Status = "REMOVED";
            listing.UpdatedAt = DateTime.UtcNow;
            await _db.SaveChangesAsync();

            return Ok(new { message = "Listing removed successfully." });
        }
    }

    public class CreateListingRequest
    {
        public int SellerId { get; set; }
        public int CategoryId { get; set; }
        public string Title { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public decimal Price { get; set; }
        public string Condition { get; set; } = "Good";
        public int MeetupLocationId { get; set; }
        public List<string> ImageUrls { get; set; } = new();
    }

    [ApiController]
    [Route("api/[controller]")]
    public class PaymentsController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public PaymentsController(PasaBuyDbContext db) { _db = db; }

        [HttpPost("webhook")]
        public async Task<IActionResult> Webhook([FromBody] PayMongoWebhookPayload payload)
        {
            if (payload == null || string.IsNullOrEmpty(payload.PaymentId)) return BadRequest();

            var payment = await _db.Payments.FirstOrDefaultAsync(p => p.ProviderReference == payload.PaymentId);
            if (payment != null)
            {
                payment.Status = "PAID";
                payment.PaidAt = DateTime.UtcNow;

                var listing = await _db.Listings.FindAsync(payment.ListingId);
                if (listing != null)
                {
                    listing.Status = "ACTIVE";
                }

                _db.PaymentWebhooks.Add(new PaymentWebhook
                {
                    Provider = "PayMongo",
                    EventId = payload.EventId ?? Guid.NewGuid().ToString(),
                    EventType = "payment.paid",
                    PayloadReference = payload.PaymentId,
                    Processed = true
                });

                await _db.SaveChangesAsync();
            }

            return Ok(new { status = "success" });
        }

        [HttpPost("confirm-simulation/{listingId}")]
        public async Task<IActionResult> ConfirmSimulation(int listingId)
        {
            var payment = await _db.Payments.FirstOrDefaultAsync(p => p.ListingId == listingId);
            if (payment != null)
            {
                payment.Status = "PAID";
                payment.PaidAt = DateTime.UtcNow;
            }

            var listing = await _db.Listings.FindAsync(listingId);
            if (listing != null)
            {
                listing.Status = "ACTIVE";
            }

            await _db.SaveChangesAsync();
            return Ok(new { message = "Payment confirmed! Listing is now ACTIVE." });
        }
    }

    public class PayMongoWebhookPayload
    {
        public string EventId { get; set; } = string.Empty;
        public string PaymentId { get; set; } = string.Empty;
    }

    [ApiController]
    [Route("api/[controller]")]
    public class CategoriesController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public CategoriesController(PasaBuyDbContext db) { _db = db; }

        [HttpGet]
        public async Task<IActionResult> GetCategories()
        {
            var categories = await _db.Categories.Where(c => c.IsActive).OrderBy(c => c.SortOrder).ToListAsync();
            return Ok(categories);
        }
    }

    [ApiController]
    [Route("api/[controller]")]
    public class MeetupLocationsController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public MeetupLocationsController(PasaBuyDbContext db) { _db = db; }

        [HttpGet]
        public async Task<IActionResult> GetMeetupLocations()
        {
            var locations = await _db.MeetupLocations.Where(m => m.IsActive).ToListAsync();
            return Ok(locations);
        }
    }

    [ApiController]
    [Route("api/[controller]")]
    public class UsersController : ControllerBase
    {
        private readonly PasaBuyDbContext _db;
        public UsersController(PasaBuyDbContext db) { _db = db; }

        [HttpGet("{id}/profile")]
        public async Task<IActionResult> GetProfile(int id)
        {
            var user = await _db.Users.Include(u => u.StudentProfile).FirstOrDefaultAsync(u => u.Id == id);
            if (user == null) return NotFound();
            return Ok(user.StudentProfile);
        }

        [HttpPut("{id}/profile")]
        public async Task<IActionResult> UpdateProfile(int id, [FromBody] UpdateProfileRequest req)
        {
            var user = await _db.Users.Include(u => u.StudentProfile).FirstOrDefaultAsync(u => u.Id == id);
            if (user == null) return NotFound(new { message = "User not found." });

            if (user.StudentProfile == null)
            {
                user.StudentProfile = new StudentProfile { UserId = user.Id };
                _db.StudentProfiles.Add(user.StudentProfile);
            }

            if (!string.IsNullOrWhiteSpace(req.FirstName)) user.StudentProfile.FirstName = req.FirstName;
            if (!string.IsNullOrWhiteSpace(req.LastName)) user.StudentProfile.LastName = req.LastName;
            if (!string.IsNullOrWhiteSpace(req.StudentNumber)) user.StudentProfile.StudentNumber = req.StudentNumber;
            if (!string.IsNullOrWhiteSpace(req.Course)) user.StudentProfile.Course = req.Course;
            if (!string.IsNullOrWhiteSpace(req.YearLevel)) user.StudentProfile.YearLevel = req.YearLevel;
            if (!string.IsNullOrWhiteSpace(req.ProfileImage)) user.StudentProfile.ProfileImage = req.ProfileImage;

            await _db.SaveChangesAsync();

            return Ok(new
            {
                message = "Profile updated successfully!",
                name = $"{user.StudentProfile.FirstName} {user.StudentProfile.LastName}",
                profile = user.StudentProfile
            });
        }
    }

    public class UpdateProfileRequest
    {
        public string FirstName { get; set; } = string.Empty;
        public string LastName { get; set; } = string.Empty;
        public string StudentNumber { get; set; } = string.Empty;
        public string Course { get; set; } = string.Empty;
        public string YearLevel { get; set; } = string.Empty;
        public string ProfileImage { get; set; } = string.Empty;
    }
}
