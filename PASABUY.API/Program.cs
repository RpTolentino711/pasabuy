using Microsoft.EntityFrameworkCore;
using PASABUY.API.Data;
using PASABUY.API.Services;

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
builder.Services.AddControllers()
    .AddJsonOptions(options =>
    {
        options.JsonSerializerOptions.ReferenceHandler = System.Text.Json.Serialization.ReferenceHandler.IgnoreCycles;
    });

builder.Services.AddHttpClient();
builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen();

// Configure MySQL / SQLite Database
var connectionString = builder.Configuration.GetConnectionString("DefaultConnection") ?? "Server=localhost;Port=3306;Database=pasabuy_db;User=root;Password=;";
builder.Services.AddDbContext<PasaBuyDbContext>(options =>
{
    try
    {
        var serverVersion = ServerVersion.AutoDetect(connectionString);
        options.UseMySql(connectionString, serverVersion);
    }
    catch
    {
        var dbPath = Path.Combine(builder.Environment.ContentRootPath, "pasabuy.db");
        options.UseSqlite($"Data Source={dbPath}");
    }
});

// Services Dependency Injection
builder.Services.AddScoped<IFeeCalculationService, FeeCalculationService>();
builder.Services.AddScoped<IPayMongoService, PayMongoService>();
builder.Services.AddScoped<IEmailService, EmailService>();

// CORS policy for Web Admin and Mobile App
builder.Services.AddCors(options =>
{
    options.AddPolicy("AllowAll", policy =>
    {
        policy.AllowAnyOrigin().AllowAnyHeader().AllowAnyMethod();
    });
});

var app = builder.Build();

// Auto initialize and seed database
using (var scope = app.Services.CreateScope())
{
    var db = scope.ServiceProvider.GetRequiredService<PasaBuyDbContext>();
    db.Database.EnsureCreated();
}

// Configure HTTP pipeline
app.UseSwagger();
app.UseSwaggerUI();

app.UseCors("AllowAll");
app.UseAuthorization();
app.MapControllers();

app.Run();
