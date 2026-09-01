@echo off
title PasaBuy - Campus Marketplace Runner
echo ========================================================
echo         PasaBuy - Your Campus. Your Marketplace.
echo ========================================================
echo Starting Backend ASP.NET Core API on http://localhost:5000 ...
start "PasaBuy API" /min dotnet run --project PASABUY.API/PASABUY.API.csproj --urls "http://localhost:5000"

timeout /t 3 >nul

echo Starting Web Admin Portal on http://localhost:5150 ...
start "PasaBuy Admin Portal" /min dotnet run --project PASABUY.Admin/PASABUY.Admin.csproj --urls "http://localhost:5150"

echo Starting Student Web Runner App on http://localhost:5200 ...
start "PasaBuy Student App Runner" /min dotnet run --project PASABUY.WebRunner/PASABUY.WebRunner.csproj --urls "http://localhost:5200"

timeout /t 4 >nul

echo ========================================================
echo Opening Admin Portal & Student App Runner in browser...
echo Admin Portal: http://localhost:5150
echo Student App:  http://localhost:5200
echo API Swagger:  http://localhost:5000/swagger
echo ========================================================

start http://localhost:5150
start http://localhost:5200

echo PasaBuy platform is running! Press Ctrl+C or close windows to stop.
pause
