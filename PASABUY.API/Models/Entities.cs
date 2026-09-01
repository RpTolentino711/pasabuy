using System;
using System.Collections.Generic;

namespace PASABUY.API.Models
{
    public class User
    {
        public int Id { get; set; }
        public string Email { get; set; } = string.Empty;
        public string PasswordHash { get; set; } = string.Empty;
        public string Role { get; set; } = "STUDENT"; // STUDENT, ADMIN
        public string Status { get; set; } = "VERIFIED"; // UNVERIFIED, PENDING, VERIFIED, SUSPENDED
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        public DateTime UpdatedAt { get; set; } = DateTime.UtcNow;
        public DateTime? LastLoginAt { get; set; }

        public StudentProfile? StudentProfile { get; set; }
    }

    public class StudentProfile
    {
        public int Id { get; set; }
        public int UserId { get; set; }
        public string FirstName { get; set; } = string.Empty;
        public string LastName { get; set; } = string.Empty;
        public string StudentNumber { get; set; } = string.Empty;
        public string SchoolEmail { get; set; } = string.Empty;
        public string Course { get; set; } = string.Empty;
        public string YearLevel { get; set; } = string.Empty;
        public string ProfileImage { get; set; } = string.Empty;
        public string VerificationStatus { get; set; } = "VERIFIED"; // UNVERIFIED, PENDING, VERIFIED, SUSPENDED
        public double Rating { get; set; } = 5.0;
        public int CompletedTransactions { get; set; } = 0;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        public DateTime UpdatedAt { get; set; } = DateTime.UtcNow;
    }

    public class Category
    {
        public int Id { get; set; }
        public string Name { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public string IconClass { get; set; } = "tag";
        public int SortOrder { get; set; } = 0;
        public bool IsActive { get; set; } = true;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }

    public class Listing
    {
        public int Id { get; set; }
        public int SellerId { get; set; }
        public int CategoryId { get; set; }
        public string Title { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public decimal Price { get; set; }
        public string Condition { get; set; } = "Good"; // New, Like New, Good, Fair, Used
        public string Status { get; set; } = "ACTIVE"; // DRAFT, PENDING_PAYMENT, ACTIVE, RESERVED, SOLD, EXPIRED, REMOVED, REJECTED
        public int MeetupLocationId { get; set; }
        public int Views { get; set; } = 0;
        public int FavoritesCount { get; set; } = 0;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        public DateTime UpdatedAt { get; set; } = DateTime.UtcNow;
        public DateTime? ExpiresAt { get; set; }
        public DateTime? ReservedAt { get; set; }
        public DateTime? SoldAt { get; set; }

        public User? Seller { get; set; }
        public Category? Category { get; set; }
        public MeetupLocation? MeetupLocation { get; set; }
        public List<ListingImage> Images { get; set; } = new();
    }

    public class ListingImage
    {
        public int Id { get; set; }
        public int ListingId { get; set; }
        public string ImageUrl { get; set; } = string.Empty;
        public int SortOrder { get; set; } = 0;
        public bool IsPrimary { get; set; } = false;
    }

    public class ListingFavorite
    {
        public int Id { get; set; }
        public int UserId { get; set; }
        public int ListingId { get; set; }
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }

    public class WantedPost
    {
        public int Id { get; set; }
        public int UserId { get; set; }
        public int CategoryId { get; set; }
        public string Title { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public decimal MaximumBudget { get; set; }
        public string Condition { get; set; } = "Any";
        public string ImageUrl { get; set; } = string.Empty;
        public int MeetupLocationId { get; set; }
        public string Status { get; set; } = "ACTIVE"; // ACTIVE, FULFILLED, EXPIRED, CANCELLED, REMOVED
        public DateTime? ExpiresAt { get; set; }
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        public DateTime UpdatedAt { get; set; } = DateTime.UtcNow;

        public User? User { get; set; }
        public Category? Category { get; set; }
        public MeetupLocation? MeetupLocation { get; set; }
    }

    public class WantedResponse
    {
        public int Id { get; set; }
        public int WantedPostId { get; set; }
        public int SellerId { get; set; }
        public string Message { get; set; } = string.Empty;
        public decimal OfferPrice { get; set; }
        public string Condition { get; set; } = "Good";
        public string Status { get; set; } = "PENDING"; // PENDING, ACCEPTED, DECLINED
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;

        public User? Seller { get; set; }
    }

    public class Conversation
    {
        public int Id { get; set; }
        public int? ListingId { get; set; }
        public int? WantedPostId { get; set; }
        public string Status { get; set; } = "ACTIVE";
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        public DateTime UpdatedAt { get; set; } = DateTime.UtcNow;

        public Listing? Listing { get; set; }
        public WantedPost? WantedPost { get; set; }
        public List<ConversationParticipant> Participants { get; set; } = new();
        public List<Message> Messages { get; set; } = new();
    }

    public class ConversationParticipant
    {
        public int Id { get; set; }
        public int ConversationId { get; set; }
        public int UserId { get; set; }
        public DateTime JoinedAt { get; set; } = DateTime.UtcNow;

        public User? User { get; set; }
    }

    public class Message
    {
        public int Id { get; set; }
        public int ConversationId { get; set; }
        public int SenderId { get; set; }
        public string MessageType { get; set; } = "text"; // text, image, offer
        public string MessageText { get; set; } = string.Empty;
        public string AttachmentUrl { get; set; } = string.Empty;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        public DateTime? ReadAt { get; set; }
        public DateTime? DeletedAt { get; set; }

        public User? Sender { get; set; }
    }

    public class BlockedUser
    {
        public int Id { get; set; }
        public int BlockerId { get; set; }
        public int BlockedId { get; set; }
        public string Reason { get; set; } = string.Empty;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }

    public class TransactionRecord
    {
        public int Id { get; set; }
        public int ListingId { get; set; }
        public int BuyerId { get; set; }
        public int SellerId { get; set; }
        public decimal AgreedPrice { get; set; }
        public int MeetupLocationId { get; set; }
        public string Status { get; set; } = "RESERVED"; // RESERVED, COMPLETED, CANCELLED, DISPUTED
        public DateTime ReservedAt { get; set; } = DateTime.UtcNow;
        public DateTime? CompletedAt { get; set; }
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;

        public Listing? Listing { get; set; }
        public User? Buyer { get; set; }
        public User? Seller { get; set; }
        public MeetupLocation? MeetupLocation { get; set; }
    }

    public class Review
    {
        public int Id { get; set; }
        public int TransactionId { get; set; }
        public int ReviewerId { get; set; }
        public int ReviewedUserId { get; set; }
        public int Rating { get; set; } = 5;
        public string Comment { get; set; } = string.Empty;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;

        public User? Reviewer { get; set; }
        public User? ReviewedUser { get; set; }
    }

    public class Report
    {
        public int Id { get; set; }
        public int ReporterId { get; set; }
        public int? ReportedUserId { get; set; }
        public int? ListingId { get; set; }
        public string Reason { get; set; } = "Scam"; // Scam, Fake Item, Prohibited Item, Misleading Description, Inappropriate Content, Stolen Item, Other
        public string Details { get; set; } = string.Empty;
        public string Status { get; set; } = "PENDING"; // PENDING, INVESTIGATING, RESOLVED, REJECTED
        public string InternalNotes { get; set; } = string.Empty;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        public DateTime UpdatedAt { get; set; } = DateTime.UtcNow;

        public User? Reporter { get; set; }
        public User? ReportedUser { get; set; }
        public Listing? Listing { get; set; }
    }

    public class Notification
    {
        public int Id { get; set; }
        public int UserId { get; set; }
        public string Title { get; set; } = string.Empty;
        public string Message { get; set; } = string.Empty;
        public string Type { get; set; } = "GENERAL";
        public int? RelatedEntityId { get; set; }
        public bool IsRead { get; set; } = false;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }

    public class PaymentRecord
    {
        public int Id { get; set; }
        public int UserId { get; set; }
        public int ListingId { get; set; }
        public decimal Amount { get; set; }
        public string Currency { get; set; } = "PHP";
        public string Provider { get; set; } = "PayMongo";
        public string ProviderReference { get; set; } = string.Empty;
        public string Status { get; set; } = "PAID"; // PENDING, PAID, FAILED, CANCELLED, REFUNDED
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        public DateTime? PaidAt { get; set; }

        public User? User { get; set; }
        public Listing? Listing { get; set; }
    }

    public class PaymentWebhook
    {
        public int Id { get; set; }
        public string Provider { get; set; } = "PayMongo";
        public string EventId { get; set; } = string.Empty;
        public string EventType { get; set; } = string.Empty;
        public string PayloadReference { get; set; } = string.Empty;
        public bool Processed { get; set; } = true;
        public DateTime? ProcessedAt { get; set; } = DateTime.UtcNow;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }

    public class MeetupLocation
    {
        public int Id { get; set; }
        public string Name { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public string LocationDetails { get; set; } = string.Empty;
        public double Latitude { get; set; }
        public double Longitude { get; set; }
        public bool IsActive { get; set; } = true;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }

    public class AdminUser
    {
        public int Id { get; set; }
        public int UserId { get; set; }
        public string AdminRole { get; set; } = "SuperAdmin";
        public string Permissions { get; set; } = "ALL";
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;

        public User? User { get; set; }
    }

    public class AuditLog
    {
        public int Id { get; set; }
        public int AdminId { get; set; }
        public string Action { get; set; } = string.Empty;
        public string TargetType { get; set; } = string.Empty;
        public string TargetId { get; set; } = string.Empty;
        public string Details { get; set; } = string.Empty;
        public DateTime Timestamp { get; set; } = DateTime.UtcNow;
        public string IpAddress { get; set; } = "127.0.0.1";
    }

    public class PlatformSetting
    {
        public int Id { get; set; }
        public string Key { get; set; } = string.Empty;
        public string Value { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public DateTime UpdatedAt { get; set; } = DateTime.UtcNow;
    }
}
