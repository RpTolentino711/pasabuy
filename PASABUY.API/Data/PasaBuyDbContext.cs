using Microsoft.EntityFrameworkCore;
using PASABUY.API.Models;
using System;

namespace PASABUY.API.Data
{
    public class PasaBuyDbContext : DbContext
    {
        public PasaBuyDbContext(DbContextOptions<PasaBuyDbContext> options) : base(options) { }

        public DbSet<User> Users { get; set; }
        public DbSet<StudentProfile> StudentProfiles { get; set; }
        public DbSet<Category> Categories { get; set; }
        public DbSet<Listing> Listings { get; set; }
        public DbSet<ListingImage> ListingImages { get; set; }
        public DbSet<ListingFavorite> ListingFavorites { get; set; }
        public DbSet<WantedPost> WantedPosts { get; set; }
        public DbSet<WantedResponse> WantedResponses { get; set; }
        public DbSet<Conversation> Conversations { get; set; }
        public DbSet<ConversationParticipant> ConversationParticipants { get; set; }
        public DbSet<Message> Messages { get; set; }
        public DbSet<BlockedUser> BlockedUsers { get; set; }
        public DbSet<TransactionRecord> Transactions { get; set; }
        public DbSet<Review> Reviews { get; set; }
        public DbSet<Report> Reports { get; set; }
        public DbSet<Notification> Notifications { get; set; }
        public DbSet<PaymentRecord> Payments { get; set; }
        public DbSet<PaymentWebhook> PaymentWebhooks { get; set; }
        public DbSet<MeetupLocation> MeetupLocations { get; set; }
        public DbSet<AdminUser> AdminUsers { get; set; }
        public DbSet<AuditLog> AuditLogs { get; set; }
        public DbSet<PlatformSetting> PlatformSettings { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            // Seed Categories
            modelBuilder.Entity<Category>().HasData(
                new Category { Id = 1, Name = "Electronics", Description = "Laptops, monitors, gadgets", IconClass = "laptop", SortOrder = 1 },
                new Category { Id = 2, Name = "Gadgets", Description = "Earphones, chargers, cables", IconClass = "headphones", SortOrder = 2 },
                new Category { Id = 3, Name = "School Supplies", Description = "Calculators, pens, pads, drafting", IconClass = "calculator", SortOrder = 3 },
                new Category { Id = 4, Name = "Books", Description = "Textbooks, reviewer books, novels", IconClass = "book", SortOrder = 4 },
                new Category { Id = 5, Name = "Clothing", Description = "Campus hoodies, uniforms, shirts", IconClass = "shirt", SortOrder = 5 },
                new Category { Id = 6, Name = "Shoes", Description = "Sneakers, school shoes, boots", IconClass = "shoe", SortOrder = 6 },
                new Category { Id = 7, Name = "Accessories", Description = "Bags, caps, watches", IconClass = "watch", SortOrder = 7 },
                new Category { Id = 8, Name = "Dorm Items", Description = "Lamps, fans, organizers, utensils", IconClass = "home", SortOrder = 8 },
                new Category { Id = 9, Name = "Sports", Description = "Balls, rackets, gym gear", IconClass = "football", SortOrder = 9 },
                new Category { Id = 10, Name = "Beauty", Description = "Skincare, cosmetics, personal care", IconClass = "sparkles", SortOrder = 10 },
                new Category { Id = 11, Name = "Food", Description = "Snacks, home-baked treats, pasabuy food", IconClass = "fast-food", SortOrder = 11 },
                new Category { Id = 12, Name = "Other", Description = "Miscellaneous student goods", IconClass = "grid", SortOrder = 12 }
            );

            // Seed Meetup Locations
            modelBuilder.Entity<MeetupLocation>().HasData(
                new MeetupLocation { Id = 1, Name = "School Gate Main Entrance", Description = "Primary security booth entrance", LocationDetails = "Gate 1 Near Guard Post", Latitude = 14.5995, Longitude = 120.9842 },
                new MeetupLocation { Id = 2, Name = "University Library Lobby", Description = "Ground floor study lounge", LocationDetails = "Near information desk", Latitude = 14.5998, Longitude = 120.9845 },
                new MeetupLocation { Id = 3, Name = "Student Center Cafeteria", Description = "Main dining hall", LocationDetails = "Tables near Central Pavilion", Latitude = 14.5991, Longitude = 120.9839 },
                new MeetupLocation { Id = 4, Name = "Student Plaza", Description = "Open air plaza with benches", LocationDetails = "Near Fountain Monument", Latitude = 14.5993, Longitude = 120.9848 },
                new MeetupLocation { Id = 5, Name = "Campus Gymnasium", Description = "Sports complex lobby", LocationDetails = "Gym ticket booth area", Latitude = 14.5989, Longitude = 120.9851 }
            );

            // Seed Users (Only Student Accounts for Auth)
            modelBuilder.Entity<User>().HasData(
                new User { Id = 1, Email = "john.doe@student.edu.ph", PasswordHash = "AQAAAAEAACcQAAAAEH...", Role = "STUDENT", Status = "VERIFIED" },
                new User { Id = 2, Email = "maria.santos@student.edu.ph", PasswordHash = "AQAAAAEAACcQAAAAEH...", Role = "STUDENT", Status = "VERIFIED" },
                new User { Id = 3, Email = "kevin.ramos@student.edu.ph", PasswordHash = "AQAAAAEAACcQAAAAEH...", Role = "STUDENT", Status = "VERIFIED" },
                new User { Id = 4, Email = "admin@pasabuy.edu.ph", PasswordHash = "AQAAAAEAACcQAAAAEH...", Role = "ADMIN", Status = "VERIFIED" }
            );

            // Seed Student Profiles
            modelBuilder.Entity<StudentProfile>().HasData(
                new StudentProfile { Id = 1, UserId = 1, FirstName = "John", LastName = "Doe", StudentNumber = "2023-00123", SchoolEmail = "john.doe@student.edu.ph", Course = "BS Computer Science", YearLevel = "3rd Year", VerificationStatus = "VERIFIED", Rating = 5.0, CompletedTransactions = 0 },
                new StudentProfile { Id = 2, UserId = 2, FirstName = "Maria", LastName = "Santos", StudentNumber = "2023-00456", SchoolEmail = "maria.santos@student.edu.ph", Course = "BS Civil Engineering", YearLevel = "2nd Year", VerificationStatus = "VERIFIED", Rating = 5.0, CompletedTransactions = 0 },
                new StudentProfile { Id = 3, UserId = 3, FirstName = "Kevin", LastName = "Ramos", StudentNumber = "2024-00891", SchoolEmail = "kevin.ramos@student.edu.ph", Course = "BS Electrical Engineering", YearLevel = "1st Year", VerificationStatus = "VERIFIED", Rating = 5.0, CompletedTransactions = 0 }
            );
        }
    }
}
