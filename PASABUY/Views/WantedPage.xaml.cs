using PASABUY.Services;
using System;

namespace PASABUY.Views
{
    public partial class WantedPage : ContentPage
    {
        private readonly DataService _dataService = new DataService();

        public WantedPage()
        {
            InitializeComponent();
            WantedCollectionView.ItemsSource = _dataService.GetSampleWantedPosts();
        }

        private async void OnPostWantedClicked(object sender, EventArgs e)
        {
            await DisplayAlert("Post Wanted Item", "Create a new campus request for items or food pasabuy!", "OK");
        }
    }
}
