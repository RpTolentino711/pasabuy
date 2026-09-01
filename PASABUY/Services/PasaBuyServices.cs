using PASABUY.Models;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Threading.Tasks;

namespace PASABUY.Services
{
    public interface IFeeCalculator
    {
        decimal CalculatePostingFee(decimal price);
    }

    public class FeeCalculator : IFeeCalculator
    {
        public decimal CalculatePostingFee(decimal price)
        {
            if (price <= 0) return 0m;
            if (price < 100m) return 1m;       // ₱1 – ₱99 = ₱1 fee
            if (price < 1000m) return 5m;      // ₱100 – ₱999 = ₱5 fee
            return 10m;                        // ₱1,000+ = ₱10 fee
        }
    }

    public class DataService
    {
        private readonly IFeeCalculator _feeCalc = new FeeCalculator();

        public StudentUserModel CurrentUser { get; set; } = new StudentUserModel
        {
            UserId = 1,
            Name = "John Doe",
            Email = "john.doe@student.edu.ph",
            StudentNumber = "2023-00123",
            SchoolEmail = "john.doe@student.edu.ph",
            Course = "BS Computer Science",
            YearLevel = "3rd Year",
            VerificationStatus = "VERIFIED",
            Rating = 4.9,
            CompletedTransactions = 18
        };

        public ObservableCollection<ProductItem> GetSampleProducts()
        {
            return new ObservableCollection<ProductItem>
            {
                new ProductItem
                {
                    Id = 1,
                    Title = "Casio Scientific Calculator FX-991ES Plus",
                    Description = "Used for 1 semester. Working 100% with solar panel and battery. Required for CS, Engineering, and Math courses.",
                    Price = 500m,
                    PostingFee = 5m,
                    Condition = "Good",
                    CategoryName = "School Supplies",
                    ImageUrl = "https://images.unsplash.com/photo-1611125832047-1d7ad1e8e48b?w=500&q=80",
                    MeetupLocation = "Library Lobby",
                    SellerName = "Maria Santos",
                    SellerVerified = true,
                    SellerRating = 5.0,
                    SellerCompletedDeals = 24
                },
                new ProductItem
                {
                    Id = 2,
                    Title = "Rotring Mechanical Pencil 0.5mm + Leads",
                    Description = "High quality drafting pencil. Solid metal body with ergonomic grip. Comes with 2 spare 2B lead tubes.",
                    Price = 250m,
                    PostingFee = 5m,
                    Condition = "Like New",
                    CategoryName = "School Supplies",
                    ImageUrl = "https://images.unsplash.com/photo-1585336261026-6757c54e3ed7?w=500&q=80",
                    MeetupLocation = "Student Cafeteria",
                    SellerName = "John Doe",
                    SellerVerified = true,
                    SellerRating = 4.9,
                    SellerCompletedDeals = 18
                },
                new ProductItem
                {
                    Id = 3,
                    Title = "Logitech Wireless Mouse M185",
                    Description = "Smooth 2.4GHz wireless connection. Compact portable mouse for campus laptops. Battery included.",
                    Price = 350m,
                    PostingFee = 5m,
                    Condition = "Good",
                    CategoryName = "Electronics",
                    ImageUrl = "https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=500&q=80",
                    MeetupLocation = "Main Gate Entrance",
                    SellerName = "John Doe",
                    SellerVerified = true,
                    SellerRating = 4.9,
                    SellerCompletedDeals = 18
                },
                new ProductItem
                {
                    Id = 4,
                    Title = "Anker PowerBank 10000mAh Dual Port",
                    Description = "Slim power bank with fast charging support. Keeps your smartphone charged all day during classes.",
                    Price = 750m,
                    PostingFee = 5m,
                    Condition = "Like New",
                    CategoryName = "Gadgets",
                    ImageUrl = "https://images.unsplash.com/photo-1609592424074-b5f7e7161b36?w=500&q=80",
                    MeetupLocation = "Student Plaza",
                    SellerName = "Kevin Ramos",
                    SellerVerified = true,
                    SellerRating = 4.8,
                    SellerCompletedDeals = 10
                }
            };
        }

        public ObservableCollection<WantedItem> GetSampleWantedPosts()
        {
            return new ObservableCollection<WantedItem>
            {
                new WantedItem
                {
                    Id = 1,
                    Title = "Looking for Arduino Uno R3 Starter Kit",
                    Description = "Need an Arduino kit with sensors and jumper wires for Embedded Systems lab project.",
                    MaximumBudget = 800m,
                    Condition = "Good",
                    RequesterName = "Maria Santos",
                    RequesterVerified = true,
                    MeetupLocation = "Library Lobby",
                    ImageUrl = "https://images.unsplash.com/photo-1553406830-ef2513450d76?w=500&q=80"
                },
                new WantedItem
                {
                    Id = 2,
                    Title = "Wanted: Data Structures & Algorithms Textbook",
                    Description = "Looking for secondhand copy of Goodrich & Tamassia textbook in readable condition.",
                    MaximumBudget = 450m,
                    Condition = "Any",
                    RequesterName = "Kevin Ramos",
                    RequesterVerified = true,
                    MeetupLocation = "Student Plaza",
                    ImageUrl = "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80"
                }
            };
        }

        public ObservableCollection<ConversationItem> GetSampleConversations()
        {
            return new ObservableCollection<ConversationItem>
            {
                new ConversationItem
                {
                    Id = 1,
                    OtherUserName = "Maria Santos",
                    ProductTitle = "Casio Scientific Calculator FX-991ES",
                    ProductPrice = "₱500.00",
                    LastMessage = "Sure! We can meet at the Library Lobby tomorrow at 2 PM.",
                    TimeAgo = "2m ago",
                    HasUnread = true
                },
                new ConversationItem
                {
                    Id = 2,
                    OtherUserName = "Kevin Ramos",
                    ProductTitle = "Arduino Uno R3 Starter Kit",
                    ProductPrice = "₱800.00 (Wanted Offer)",
                    LastMessage = "I have an available kit with extra LEDs if you want.",
                    TimeAgo = "15m ago",
                    HasUnread = false
                }
            };
        }

        public decimal CalculateFee(decimal price)
        {
            return _feeCalc.CalculatePostingFee(price);
        }
    }
}
