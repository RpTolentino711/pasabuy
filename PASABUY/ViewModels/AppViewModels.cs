using CommunityToolkit.Mvvm.ComponentModel;
using CommunityToolkit.Mvvm.Input;
using PASABUY.Models;
using PASABUY.Services;
using System;
using System.Collections.ObjectModel;
using System.Linq;
using System.Threading.Tasks;

namespace PASABUY.ViewModels
{
    public partial class BaseViewModel : ObservableObject
    {
        [ObservableProperty]
        private bool isBusy;

        [ObservableProperty]
        private string title = string.Empty;
    }

    public partial class HomeViewModel : BaseViewModel
    {
        private readonly DataService _dataService;

        [ObservableProperty]
        private StudentUserModel currentUser;

        [ObservableProperty]
        private string searchText = string.Empty;

        [ObservableProperty]
        private ObservableCollection<ProductItem> recommendedProducts;

        [ObservableProperty]
        private ObservableCollection<ProductItem> recentlyListedProducts;

        [ObservableProperty]
        private ObservableCollection<WantedItem> wantedPosts;

        public HomeViewModel(DataService dataService)
        {
            Title = "Home";
            _dataService = dataService;
            CurrentUser = _dataService.CurrentUser;
            var sample = _dataService.GetSampleProducts();
            RecommendedProducts = new ObservableCollection<ProductItem>(sample);
            RecentlyListedProducts = new ObservableCollection<ProductItem>(sample.Reverse());
            WantedPosts = _dataService.GetSampleWantedPosts();
        }

        [RelayCommand]
        private async Task PerformSearchAsync()
        {
            if (string.IsNullOrWhiteSpace(SearchText)) return;
            var filtered = _dataService.GetSampleProducts()
                .Where(p => p.Title.Contains(SearchText, StringComparison.OrdinalIgnoreCase) ||
                            p.Description.Contains(SearchText, StringComparison.OrdinalIgnoreCase))
                .ToList();
            RecommendedProducts = new ObservableCollection<ProductItem>(filtered);
            await Task.CompletedTask;
        }

        [RelayCommand]
        private void ToggleFavorite(ProductItem product)
        {
            if (product != null)
            {
                product.IsFavorite = !product.IsFavorite;
            }
        }
    }

    public partial class ExploreViewModel : BaseViewModel
    {
        private readonly DataService _dataService;

        [ObservableProperty]
        private ObservableCollection<ProductItem> products;

        [ObservableProperty]
        private string selectedCategory = "All";

        [ObservableProperty]
        private string selectedSort = "Newest";

        public ExploreViewModel(DataService dataService)
        {
            Title = "Explore Marketplace";
            _dataService = dataService;
            Products = _dataService.GetSampleProducts();
        }

        [RelayCommand]
        private void FilterByCategory(string category)
        {
            SelectedCategory = category;
            if (category == "All")
            {
                Products = _dataService.GetSampleProducts();
            }
            else
            {
                var filtered = _dataService.GetSampleProducts()
                    .Where(p => p.CategoryName.Equals(category, StringComparison.OrdinalIgnoreCase))
                    .ToList();
                Products = new ObservableCollection<ProductItem>(filtered);
            }
        }
    }

    public partial class SellViewModel : BaseViewModel
    {
        private readonly DataService _dataService;

        [ObservableProperty]
        private string itemTitle = string.Empty;

        [ObservableProperty]
        private string itemDescription = string.Empty;

        [ObservableProperty]
        private decimal itemPrice = 500m;

        [ObservableProperty]
        private decimal calculatedPostingFee = 5m;

        [ObservableProperty]
        private string selectedCondition = "Good";

        [ObservableProperty]
        private string selectedMeetup = "Library Lobby";

        [ObservableProperty]
        private bool isPreviewing = false;

        [ObservableProperty]
        private bool isPayingFee = false;

        [ObservableProperty]
        private string payMongoQrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PAYMONGO_PASABUY_FEE_SIMULATED";

        public SellViewModel(DataService dataService)
        {
            Title = "Sell Product";
            _dataService = dataService;
            RecalculateFee();
        }

        partial void OnItemPriceChanged(decimal value)
        {
            RecalculateFee();
        }

        private void RecalculateFee()
        {
            CalculatedPostingFee = _dataService.CalculateFee(ItemPrice);
        }

        [RelayCommand]
        private void ProceedToPreview()
        {
            if (string.IsNullOrWhiteSpace(ItemTitle)) return;
            IsPreviewing = true;
        }

        [RelayCommand]
        private void ProceedToPayMongoPayment()
        {
            IsPreviewing = false;
            IsPayingFee = true;
            PayMongoQrUrl = $"https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PAYMONGO_PASABUY_FEE_{ItemPrice}_{CalculatedPostingFee}";
        }

        [RelayCommand]
        private async Task ConfirmPaymentAndPublishAsync()
        {
            IsPayingFee = false;
            var newProduct = new ProductItem
            {
                Id = Random.Shared.Next(100, 999),
                Title = ItemTitle,
                Description = ItemDescription,
                Price = ItemPrice,
                PostingFee = CalculatedPostingFee,
                Condition = SelectedCondition,
                MeetupLocation = SelectedMeetup,
                SellerName = _dataService.CurrentUser.Name,
                SellerVerified = true,
                Status = "ACTIVE",
                ImageUrl = "https://images.unsplash.com/photo-1611125832047-1d7ad1e8e48b?w=500&q=80"
            };

            _dataService.GetSampleProducts().Add(newProduct);
            ItemTitle = string.Empty;
            ItemDescription = string.Empty;
            await Task.CompletedTask;
        }
    }

    public partial class WantedViewModel : BaseViewModel
    {
        private readonly DataService _dataService;

        [ObservableProperty]
        private ObservableCollection<WantedItem> wantedItems;

        public WantedViewModel(DataService dataService)
        {
            Title = "Wanted Requests";
            _dataService = dataService;
            WantedItems = _dataService.GetSampleWantedPosts();
        }
    }

    public partial class MessagesViewModel : BaseViewModel
    {
        private readonly DataService _dataService;

        [ObservableProperty]
        private ObservableCollection<ConversationItem> conversations;

        public MessagesViewModel(DataService dataService)
        {
            Title = "Messages & Chat";
            _dataService = dataService;
            Conversations = _dataService.GetSampleConversations();
        }
    }

    public partial class ProfileViewModel : BaseViewModel
    {
        private readonly DataService _dataService;

        [ObservableProperty]
        private StudentUserModel userProfile;

        [ObservableProperty]
        private ObservableCollection<ProductItem> myListings;

        public ProfileViewModel(DataService dataService)
        {
            Title = "Student Profile";
            _dataService = dataService;
            UserProfile = _dataService.CurrentUser;
            MyListings = _dataService.GetSampleProducts();
        }
    }
}
