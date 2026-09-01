static void LoadDotEnv()
{
    var envFile = Path.Combine(AppContext.BaseDirectory, ".env");
    var rootEnvFile = Path.Combine(Directory.GetCurrentDirectory(), ".env");
    var candidate = File.Exists(envFile) ? envFile : rootEnvFile;

    if (!File.Exists(candidate)) return;

    foreach (var line in File.ReadAllLines(candidate))
    {
        if (string.IsNullOrWhiteSpace(line) || line.TrimStart().StartsWith("#")) continue;

        var parts = line.Split('=', 2);
        if (parts.Length != 2) continue;

        var key = parts[0].Trim();
        var value = parts[1].Trim().Trim('"');

        if (!string.IsNullOrWhiteSpace(key) && !string.IsNullOrWhiteSpace(value))
            Environment.SetEnvironmentVariable(key, value);
    }
}

LoadDotEnv();

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
builder.Services.AddControllersWithViews();
builder.Services.AddHttpClient();

var app = builder.Build();

// Configure the HTTP request pipeline.
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Home/Error");
}
app.UseStaticFiles();
app.UseRouting();

app.UseAuthorization();

app.MapControllerRoute(
    name: "default",
    pattern: "{controller=Home}/{action=Index}/{id?}");

app.Run();
