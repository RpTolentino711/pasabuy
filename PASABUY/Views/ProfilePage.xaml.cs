using PASABUY.Services;
using System;

namespace PASABUY.Views
{
    public partial class ProfilePage : ContentPage
    {
        private readonly DataService _dataService = new DataService();

        public ProfilePage()
        {
            InitializeComponent();
            MyListingsCollectionView.ItemsSource = _dataService.GetSampleProducts();
        }

        private async void OnEditProfileClicked(object sender, EventArgs e)
        {
            await DisplayAlert("Account Profile & Settings", "Update your profile picture, student number, course, or year level.", "OK");
        }

        private async void OnDeletePostClicked(object sender, EventArgs e)
        {
            bool confirm = await DisplayAlert("Delete Selling Post?",
                "Are you sure you want to delete this listing?\n\n⚠️ Note on Paid Posting Fee:\nYou already paid ₱1.00 posting fee via PayMongo for this item post. Deleting this post is permanent and the posting fee is non-refundable.",
                "Yes, Delete Post", "Keep Post");

            if (confirm)
            {
                await DisplayAlert("Deleted", "Your selling post has been removed from campus marketplace.", "OK");
            }
        }

        private async void OnLogoutClicked(object sender, EventArgs e)
        {
            bool logout = await DisplayAlert("Log Out", "Are you sure you want to log out of your account?", "Log Out", "Cancel");
            if (logout)
            {
                await DisplayAlert("Logged Out", "You have been logged out.", "OK");
            }
        }
    }
}
