using Microsoft.Extensions.Logging;
using PASABUY.Services;
using PASABUY.ViewModels;

namespace PASABUY
{
    public static class MauiProgram
    {
        public static MauiApp CreateMauiApp()
        {
            var builder = MauiApp.CreateBuilder();
            builder
                .UseMauiApp<App>()
                .ConfigureFonts(fonts =>
                {
                    fonts.AddFont("OpenSans-Regular.ttf", "OpenSansRegular");
                    fonts.AddFont("OpenSans-Semibold.ttf", "OpenSansSemibold");
                });

            // Register Services
            builder.Services.AddSingleton<IFeeCalculator, FeeCalculator>();
            builder.Services.AddSingleton<DataService>();

            // Register ViewModels
            builder.Services.AddSingleton<HomeViewModel>();
            builder.Services.AddSingleton<ExploreViewModel>();
            builder.Services.AddSingleton<SellViewModel>();
            builder.Services.AddSingleton<WantedViewModel>();
            builder.Services.AddSingleton<MessagesViewModel>();
            builder.Services.AddSingleton<ProfileViewModel>();

#if DEBUG
            builder.Logging.AddDebug();
#endif

            return builder.Build();
        }
    }
}
