namespace PASABUY.API.Services
{
    public interface IFeeCalculationService
    {
        decimal CalculatePostingFee(decimal price);
    }

    public class FeeCalculationService : IFeeCalculationService
    {
        public decimal CalculatePostingFee(decimal price)
        {
            if (price <= 0) return 0m;
            if (price < 100m) return 1m;       // ₱1 – ₱99 = ₱1 fee
            if (price < 1000m) return 5m;      // ₱100 – ₱999 = ₱5 fee
            return 10m;                        // ₱1,000+ = ₱10 fee
        }
    }
}
