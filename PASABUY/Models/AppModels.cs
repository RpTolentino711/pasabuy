using System;
using System.Collections.Generic;

namespace PASABUY.Models
{
    public class StudentUserModel
    {
        public int UserId { get; set; }
        public string Email { get; set; } = string.Empty;
        public string Name { get; set; } = string.Empty;
        public string StudentNumber { get; set; } = string.Empty;
        public string SchoolEmail { get; set; } = string.Empty;
        public string Course { get; set; } = string.Empty;
        public string YearLevel { get; set; } = string.Empty;
        public string VerificationStatus { get; set; } = "VERIFIED";
        public bool IsVerified => VerificationStatus == "VERIFIED";
        public double Rating { get; set; } = 5.0;
        public int CompletedTransactions { get; set; } = 0;
    }

    public class ProductItem
    {
        public int Id { get; set; }
        public string Title { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public decimal Price { get; set; }
        public string PriceFormatted => $"₱{Price:N2}";
        public decimal PostingFee { get; set; }
        public string Condition { get; set; } = "Good";
        public string CategoryName { get; set; } = "General";
        public string ImageUrl { get; set; } = "https://images.unsplash.com/photo-1611125832047-1d7ad1e8e48b?w=500&q=80";
        public string MeetupLocation { get; set; } = "School Gate";
        public string SellerName { get; set; } = "Verified Student";
        public bool SellerVerified { get; set; } = true;
        public double SellerRating { get; set; } = 4.9;
        public int SellerCompletedDeals { get; set; } = 18;
        public string Status { get; set; } = "ACTIVE"; // ACTIVE, RESERVED, SOLD, PENDING_PAYMENT
        public bool IsFavorite { get; set; } = false;
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }

    public class CategoryItem
    {
        public int Id { get; set; }
        public string Name { get; set; } = string.Empty;
        public string Icon { get; set; } = "tag";
        public bool IsSelected { get; set; } = false;
    }

    public class WantedItem
    {
        public int Id { get; set; }
        public string Title { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public decimal MaximumBudget { get; set; }
        public string BudgetFormatted => $"Up to ₱{MaximumBudget:N2}";
        public string Condition { get; set; } = "Any";
        public string RequesterName { get; set; } = "Campus Student";
        public bool RequesterVerified { get; set; } = true;
        public string MeetupLocation { get; set; } = "Library Lobby";
        public string ImageUrl { get; set; } = "https://images.unsplash.com/photo-1553406830-ef2513450d76?w=500&q=80";
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }

    public class ChatMessageItem
    {
        public int Id { get; set; }
        public int SenderId { get; set; }
        public string SenderName { get; set; } = string.Empty;
        public string MessageText { get; set; } = string.Empty;
        public bool IsFromMe { get; set; }
        public DateTime Timestamp { get; set; } = DateTime.UtcNow;
        public string TimeFormatted => Timestamp.ToString("h:mm tt");
    }

    public class ConversationItem
    {
        public int Id { get; set; }
        public string OtherUserName { get; set; } = string.Empty;
        public string ProductTitle { get; set; } = string.Empty;
        public string ProductPrice { get; set; } = string.Empty;
        public string LastMessage { get; set; } = string.Empty;
        public string TimeAgo { get; set; } = "Just now";
        public bool HasUnread { get; set; } = true;
    }
}
