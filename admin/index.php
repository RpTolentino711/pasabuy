<?php
// PasaBuy Admin Portal (PHP Component)
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasaBuy - Admin Portal</title>
    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <style>
        :root {
            --admin-primary: #5F27CD;
            --admin-dark: #0F172A;
            --admin-bg: #F8FAFC;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            color: #1E293B;
            min-height: 100vh;
        }
        .admin-navbar {
            background: linear-gradient(135deg, #1E1B4B, #312E81);
            padding: 14px 24px;
        }
        .admin-sidebar {
            width: 260px;
            background: #FFFFFF;
            border-right: 1px solid #E2E8F0;
            min-height: calc(100vh - 64px);
        }
        .nav-link-admin {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: #64748B;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }
        .nav-link-admin:hover, .nav-link-admin.active {
            background: #F1F5F9;
            color: var(--admin-primary);
        }
        .card-stat {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .table-custom {
            background: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #E2E8F0;
        }
        .auth-card {
            max-width: 440px;
            margin: 80px auto 0;
            background: #FFFFFF;
            border-radius: 24px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 20px 40px rgba(15,23,42,0.08);
            overflow: hidden;
        }
        .auth-header {
            background: linear-gradient(135deg, #1E1B4B, #312E81);
            color: #FFFFFF;
            padding: 32px 24px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- ADMIN LOGIN LANDING VIEW (DEFAULT WHEN UNAUTHENTICATED) -->
    <div id="adminAuthView" style="display:block;">
        <div class="auth-card">
            <div class="auth-header" style="background: linear-gradient(135deg, #1E1B4B, #5B3FA8);">
                <div class="mb-2 text-center">
                    <img src="LOGO.png" alt="RentEase Logo" style="height:65px; width:auto; object-fit:contain; filter: drop-shadow(0 4px 10px rgba(255, 255, 255, 0.3));">
                </div>
                <h4 class="fw-extrabold mb-1">RentEase Admin Portal</h4>
                <p class="text-white-50 fs-8 mb-0">Easy Rentals. Seamless Events. Management Hub</p>
            </div>
            <div class="p-4">
                
                <div id="adminErrorBanner" class="p-3 bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-3 fs-8 mb-3" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> <span id="adminErrorMsg">Invalid admin credentials.</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Admin Username / Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 fs-7" id="adminUsernameInput" placeholder="admin" value="admin">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold fs-7">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-key text-muted"></i></span>
                        <input type="password" class="form-control border-start-0 border-end-0 fs-7" id="adminPasswordInput" placeholder="Pogilameg" value="Pogilameg">
                        <button type="button" class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white" onclick="togglePasswordVisibility('adminPasswordInput', 'adminEyeIcon')">
                            <i class="fa-solid fa-eye text-muted" id="adminEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button class="btn btn-primary w-100 rounded-pill fw-bold py-2 fs-7 mb-3 shadow-sm" style="background:#5B3FA8; border:none;" onclick="executeAdminLogin()"><i class="fa-solid fa-right-to-bracket me-2"></i> Log In to Operations Dashboard</button>

                <div class="text-center pt-3 border-top">
                    <a href="../student/index.php" class="text-decoration-none fs-8 text-muted fw-semibold"><i class="fa-solid fa-store me-1"></i> Open RentEase Student App</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN ADMIN DASHBOARD VIEW (SHOWN AFTER AUTHENTICATION) -->
    <div id="adminMainDashboardView" style="display:none;">
        
        <!-- Admin Top Navbar -->
        <nav class="admin-navbar navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(135deg, #1E1B4B, #5B3FA8);">
            <div class="container-fluid">
                <a class="navbar-brand fw-extrabold d-flex align-items-center gap-2" href="#">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center p-1 shadow-sm" style="width:36px; height:36px; flex-shrink:0;">
                        <img src="LOGO.png" alt="RentEase Logo" style="height:24px; width:auto; object-fit:contain;">
                    </div>
                    <span class="fs-5 text-white">RentEase <span class="badge bg-warning text-dark fs-9 rounded-pill ms-1">OPERATIONS PORTAL</span></span>
                </a>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white-50 fs-8"><i class="fa-solid fa-circle text-success me-1"></i> MySQL Database &amp; PayMongo Live Connected</span>
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold text-white" onclick="logoutAdmin()"><i class="fa-solid fa-right-from-bracket me-1"></i> Log Out</button>
                </div>
            </div>
        </nav>

        <div class="d-flex">
            <!-- Sidebar Navigation -->
            <aside class="admin-sidebar p-3" style="width:280px;">
                <div class="text-uppercase text-muted fw-bold fs-9 mb-2 px-2">RentEase Platform Modules</div>
                <nav class="nav flex-column mb-3">
                    <a href="#" class="nav-link-admin active" onclick="showAdminSection('inventory', this)"><i class="fa-solid fa-boxes-stacked text-primary"></i> Rental Inventory (Live)</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('issues', this)"><i class="fa-solid fa-headset text-danger"></i> Customer Support / Tickets <span class="badge bg-danger ms-auto rounded-pill" id="adminIssuesBadge">3</span></a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('packages', this)"><i class="fa-solid fa-gift text-warning"></i> Event Package Bundles</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('rentalOrders', this)"><i class="fa-solid fa-truck-ramp-box text-success"></i> Rental Orders &amp; Dispatch</a>
                </nav>

                <div class="text-uppercase text-muted fw-bold fs-9 mb-2 px-2">Campus Marketplace Control</div>
                <nav class="nav flex-column">
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('dashboard', this)"><i class="fa-solid fa-chart-pie"></i> Overview Analytics</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('verifications', this)"><i class="fa-solid fa-id-card text-primary"></i> Verification Requests</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('riders', this)"><i class="fa-solid fa-motorcycle text-warning"></i> Delivery Riders</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('students', this)"><i class="fa-solid fa-user-graduate"></i> Registered Users</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('payments', this)"><i class="fa-solid fa-receipt text-success"></i> Digital Payments Log</a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-grow-1 p-4">

                <!-- Section 1: RentEase Executive Operations Overview -->
                <div id="sectionDashboard">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-chart-pie me-2" style="color:#5B3FA8;"></i>RentEase Operations Hub &amp; Executive Analytics</h4>
                            <p class="text-muted fs-8 mb-0">Real-time equipment utilization, rental booking revenue, delivery dispatch, and customer issue resolution.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm rounded-pill fw-bold px-3" onclick="fetchAdminDashboardStats()"><i class="fa-solid fa-rotate me-1"></i> Refresh Metrics</button>
                        </div>
                    </div>

                    <!-- Stat Cards Row (RentEase Executive KPIs) -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4" style="border-left-color:#5B3FA8 !important;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Total Equipment Stock</span>
                                    <div class="stat-icon text-white" style="background:#5B3FA8;"><i class="fa-solid fa-boxes-stacked"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1" id="dashExecutiveStock">720</h2>
                                <span class="badge bg-success-subtle text-success fw-bold fs-9"><i class="fa-solid fa-check me-1"></i> <span id="dashExecutiveAvailable">488</span> Units Ready</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-success">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Gross Rental Value</span>
                                    <div class="stat-icon bg-success text-white"><i class="fa-solid fa-peso-sign"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-success" id="dashExecutiveRevenue">₱125,450</h2>
                                <span class="text-muted fs-8">184 Bookings Recorded</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-warning">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Active Deliveries</span>
                                    <div class="stat-icon bg-warning text-dark"><i class="fa-solid fa-truck-ramp-box"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-warning-emphasis" id="dashExecutiveDeliveries">8 Active</h2>
                                <span class="text-muted fs-8">Juan Dela Cruz &amp; Fleet En Route</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-danger">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Support Incident Rate</span>
                                    <div class="stat-icon bg-danger text-white"><i class="fa-solid fa-headset"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-danger" id="dashExecutiveIssues">1 Pending</h2>
                                <span class="badge bg-success-subtle text-success fw-bold fs-9">96.8% Resolved Satisfied</span>
                            </div>
                        </div>
                    </div>

                    <!-- Strategic Targets Banner (Matching RentEase.pdf Rubric) -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                                <span class="text-muted fw-bold fs-9 text-uppercase mb-1"><i class="fa-solid fa-bullseye text-primary me-1"></i> Target Customers / Month</span>
                                <h5 class="fw-extrabold text-dark mb-1">100–150 Clients</h5>
                                <p class="text-muted fs-9 mb-0">Ideal customer base: Student councils, organizations, university events, and family parties.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                                <span class="text-muted fw-bold fs-9 text-uppercase mb-1"><i class="fa-solid fa-arrow-trend-up text-success me-1"></i> Monthly Transactions</span>
                                <h5 class="fw-extrabold text-success mb-1">150–200 Bookings</h5>
                                <p class="text-muted fs-9 mb-0">High-volume bookings with automated cart computation &amp; transparent fees.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                                <span class="text-muted fw-bold fs-9 text-uppercase mb-1"><i class="fa-solid fa-mobile-screen-button text-warning me-1"></i> Online Channel Ratio</span>
                                <h5 class="fw-extrabold text-primary mb-1">75% Online / 25% Assisted</h5>
                                <p class="text-muted fs-9 mb-0">Primary customer self-service via RentEase app with direct GCash checkout.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Student Verification Requests Moderation (PHP + JS) -->
                <div id="sectionVerifications" style="display:none;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h4 class="fw-bold mb-1"><i class="fa-solid fa-id-card text-primary me-2"></i>Student Seller Verification Requests</h4>
                            <p class="text-muted fs-8 mb-0">Review student hometown, address, guardian info, and postal/school IDs to approve or reject selling access.</p>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" onclick="fetchAdminVerificationRequests()"><i class="fa-solid fa-rotate me-1"></i> Refresh Requests</button>
                    </div>

                    <div class="table-custom p-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Student &amp; ID Info</th>
                                    <th>Hometown &amp; Address</th>
                                    <th>Contact &amp; Guardian Info</th>
                                    <th>Submitted ID Photo</th>
                                    <th>Status</th>
                                    <th>Moderation Actions</th>
                                </tr>
                            </thead>
                            <tbody id="adminVerificationsTableBody">
                                <tr><td colspan="6" class="text-center text-muted py-4"><i class="fa-solid fa-spinner fa-spin me-1"></i> Loading student verification requests...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 2B: Motor Driver Verifications -->
                <div id="sectionRiders" style="display:none;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h4 class="fw-bold mb-1"><i class="fa-solid fa-motorcycle text-warning me-2"></i>Motor Delivery Driver Applications</h4>
                            <p class="text-muted fs-8 mb-0">Approve or reject student motor driver applications to enable campus express delivery.</p>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" onclick="fetchAdminMotorRiders()"><i class="fa-solid fa-rotate me-1"></i> Refresh Drivers</button>
                    </div>

                    <div class="table-custom p-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Driver Name</th>
                                    <th>Vehicle Details</th>
                                    <th>Driver License #</th>
                                    <th>License Image</th>
                                    <th>Status</th>
                                    <th>Moderation Actions</th>
                                </tr>
                            </thead>
                            <tbody id="adminRidersTableBody">
                                <tr><td colspan="6" class="text-center text-muted py-4"><i class="fa-solid fa-spinner fa-spin me-1"></i> Loading motor driver applications...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 3: Registered Students -->
                <div id="sectionStudents" style="display:none;">
                    <h4 class="fw-bold mb-1">Registered Student Accounts</h4>
                    <p class="text-muted fs-8 mb-4">View or suspend registered student marketplace profiles.</p>
                    
                    <div class="table-custom p-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Student #</th>
                                    <th>Course &amp; Year</th>
                                    <th>School Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="adminStudentsTableBody">
                                <tr><td colspan="6" class="text-center text-muted py-4">Loading registered students...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 4: Listings Moderation -->
                <div id="sectionListings" style="display:none;">
                    <h4 class="fw-bold mb-1">Marketplace Listings Moderation</h4>
                    <p class="text-muted fs-8 mb-4">View and delete prohibited or spam listings.</p>
                    <div id="adminListingsContainer" class="row g-3">
                        <!-- Populated dynamically via API -->
                    </div>
                </div>

                <!-- Section 5: PayMongo Payments Ledger -->
                <div id="sectionPayments" style="display:none;">
                    <h4 class="fw-bold mb-1">PayMongo Live Fee Collection Ledger</h4>
                    <p class="text-muted fs-8 mb-4">Audit log of all ₱1.00 / ₱5.00 / ₱10.00 posting fees paid via GCash.</p>
                    
                    <div class="table-custom p-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Transaction Ref</th>
                                    <th>Listing Title</th>
                                    <th>Fee Amount</th>
                                    <th>Status</th>
                                    <th>Date &amp; Time</th>
                                </tr>
                            </thead>
                            <tbody id="adminPaymentsTableBody">
                                <tr><td colspan="5" class="text-center text-muted py-4">Loading PayMongo fee transactions...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 6: Scam & Abuse Reports -->
                <div id="sectionReports" style="display:none;">
                    <h4 class="fw-bold mb-1">Scam &amp; Moderation Reports</h4>
                    <p class="text-muted fs-8 mb-4">Investigate student safety reports.</p>
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center py-5 text-muted">
                        <i class="fa-solid fa-shield-cat fs-1 text-secondary opacity-50 mb-2"></i>
                        <h6>No Pending Reports</h6>
                        <p class="fs-8 text-muted">Campus marketplace community guidelines are currently clean.</p>
                    </div>
                </div>

                <!-- Section 7: Meetup Locations -->
                <div id="sectionMeetups" style="display:none;">
                    <h4 class="fw-bold mb-1">Approved Campus Meetup Locations</h4>
                    <p class="text-muted fs-8 mb-4">Manage safe campus pickup locations for student transactions.</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                                <h6 class="fw-bold mb-1"><i class="fa-solid fa-location-dot text-danger me-1"></i> Library Lobby</h6>
                                <p class="fs-8 text-muted mb-0">Main Campus University Library Ground Floor</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                                <h6 class="fw-bold mb-1"><i class="fa-solid fa-location-dot text-danger me-1"></i> Student Cafeteria</h6>
                                <p class="fs-8 text-muted mb-0">Central Food Court &amp; Dining Area</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                                <h6 class="fw-bold mb-1"><i class="fa-solid fa-location-dot text-danger me-1"></i> Main Gate Entrance</h6>
                                <p class="fs-8 text-muted mb-0">Main Campus Pedestrian Entrance near Guard Post</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: RentEase Live Inventory Management Module (Rubric: 10%) -->
                <div id="sectionInventory" style="display:block;">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-boxes-stacked me-2" style="color:#5B3FA8;"></i>Event Rentals Inventory Module</h4>
                            <p class="text-muted fs-8 mb-0">Real-time stock control, availability tracking, rental status, and maintenance counts.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm rounded-pill fw-bold px-3" onclick="fetchAdminInventory()"><i class="fa-solid fa-rotate me-1"></i> Refresh Stock</button>
                            <button class="btn text-white btn-sm rounded-pill fw-bold px-3 shadow-sm" style="background:#5B3FA8;" onclick="openAddInventoryModal()"><i class="fa-solid fa-plus me-1"></i> Add Rental Item</button>
                        </div>
                    </div>

                    <!-- Inventory Summary KPI Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4" style="border-left-color:#5B3FA8 !important;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Total Stock</span>
                                    <div class="stat-icon text-white" style="background:#5B3FA8;"><i class="fa-solid fa-boxes-stacked"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1" id="dashInventoryTotal">720</h2>
                                <span class="text-muted fs-8">All Rental Units</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-success">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Available Now</span>
                                    <div class="stat-icon bg-success-subtle text-success"><i class="fa-solid fa-circle-check"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-success" id="dashInventoryAvailable">488</h2>
                                <span class="badge bg-success-subtle text-success fw-bold fs-9">Ready for Customer Booking</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-warning">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Currently Rented</span>
                                    <div class="stat-icon bg-warning-subtle text-warning-emphasis"><i class="fa-solid fa-truck-ramp-box"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-warning-emphasis" id="dashInventoryRented">202</h2>
                                <span class="text-muted fs-8">Out in Active Events</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-danger">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Maintenance / Repair</span>
                                    <div class="stat-icon bg-danger-subtle text-danger"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-danger" id="dashInventoryMaintenance">30</h2>
                                <span class="badge bg-danger-subtle text-danger fw-bold fs-9">Quality Inspection</span>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Table -->
                    <div class="table-custom shadow-sm">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
                            <div class="fw-bold fs-7 text-dark"><i class="fa-solid fa-table-list me-2 text-primary"></i>Live Inventory Database Records</div>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm rounded-pill fs-8" placeholder="Search inventory..." id="inventorySearchInput" oninput="filterAdminInventoryTable()" style="width:200px;">
                                <select class="form-select form-select-sm rounded-pill fs-8" id="inventoryCategoryFilter" onchange="filterAdminInventoryTable()" style="width:140px;">
                                    <option value="">All Categories</option>
                                    <option value="Chairs">Chairs</option>
                                    <option value="Tables">Tables</option>
                                    <option value="Tents">Tents</option>
                                    <option value="Sound System">Sound System</option>
                                    <option value="Lights">Lights</option>
                                    <option value="Decorations">Decorations</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 fs-8">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Category / Material</th>
                                        <th>Daily Rate</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center text-success">Available</th>
                                        <th class="text-center text-warning">Rented</th>
                                        <th class="text-center text-danger">Maintenance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="adminInventoryTableBody">
                                    <tr><td colspan="8" class="text-center py-4 text-muted"><i class="fa-solid fa-spinner fa-spin me-2"></i>Loading live inventory...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Section: Customer Support & Issue Center (Rubric: 10%) -->
                <div id="sectionIssues" style="display:none;">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-headset me-2 text-danger"></i>Customer Support &amp; Issue Resolution Center</h4>
                            <p class="text-muted fs-8 mb-0">Manage customer reported incidents (Damaged items, Late delivery, Missing accessories) and workflow resolution.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm rounded-pill fw-bold px-3" onclick="fetchAdminIssues()"><i class="fa-solid fa-rotate me-1"></i> Refresh Tickets</button>
                        </div>
                    </div>

                    <!-- Issues Summary KPI Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-secondary">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Total Tickets</span>
                                    <div class="stat-icon bg-light text-secondary"><i class="fa-solid fa-ticket"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1" id="dashIssuesTotal">3</h2>
                                <span class="text-muted fs-8">Logged in System</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-danger">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Reported / Pending</span>
                                    <div class="stat-icon bg-danger-subtle text-danger"><i class="fa-solid fa-triangle-exclamation"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-danger" id="dashIssuesPending">1</h2>
                                <span class="badge bg-danger-subtle text-danger fw-bold fs-9">Requires Attention</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-warning">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">In Progress</span>
                                    <div class="stat-icon bg-warning-subtle text-warning-emphasis"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-warning-emphasis" id="dashIssuesInProgress">1</h2>
                                <span class="text-muted fs-8">Support Team Reviewing</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-success">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Resolved</span>
                                    <div class="stat-icon bg-success-subtle text-success"><i class="fa-solid fa-circle-check"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-success" id="dashIssuesResolved">1</h2>
                                <span class="badge bg-success-subtle text-success fw-bold fs-9">Closed Satisfactorily</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tickets Table -->
                    <div class="table-custom shadow-sm">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
                            <div class="fw-bold fs-7 text-dark"><i class="fa-solid fa-ticket-simple me-2 text-danger"></i>Active Support Incident Log</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 fs-8">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ticket ID</th>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Resolution Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="adminIssuesTableBody">
                                    <tr><td colspan="7" class="text-center py-4 text-muted"><i class="fa-solid fa-spinner fa-spin me-2"></i>Loading support tickets...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Section: Event Packages Bundling (Rubric: 10% Marketing Strategy) -->
                <div id="sectionPackages" style="display:none;">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-gift me-2 text-warning"></i>Event Package Bundling &amp; Marketing Promotions</h4>
                            <p class="text-muted fs-8 mb-0">Pre-bundled packages with built-in equipment discounts for high-volume customer events.</p>
                        </div>
                    </div>

                    <div class="row g-3" id="adminPackagesContainer">
                        <!-- Loaded dynamically via JS -->
                    </div>
                </div>

                <!-- Section: Rental Orders & Dispatch Tracking -->
                <div id="sectionRentalOrders" style="display:none;">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-truck-ramp-box me-2 text-success"></i>Rental Orders &amp; Delivery Tracking</h4>
                            <p class="text-muted fs-8 mb-0">Live customer order queue, fulfillment dispatch status, and driver assignments.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success btn-sm rounded-pill fw-bold px-3" onclick="fetchAdminRentalOrders()"><i class="fa-solid fa-rotate me-1"></i> Refresh Orders</button>
                        </div>
                    </div>

                    <div class="table-custom shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 fs-8">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Customer</th>
                                        <th>Fulfillment / Address</th>
                                        <th>Rental Date</th>
                                        <th>Grand Total</th>
                                        <th>Payment</th>
                                        <th>Dispatch Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="adminRentalOrdersTableBody">
                                    <tr><td colspan="8" class="text-center py-4 text-muted"><i class="fa-solid fa-spinner fa-spin me-2"></i>Loading rental orders...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    <!-- RENTEASE ADD EQUIPMENT MODAL -->
    <div class="modal fade" id="addEquipmentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
                <div class="modal-header border-0 pb-1">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-plus-circle me-2" style="color:#5B3FA8;"></i>Add Rental Equipment to Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <div class="mb-2">
                        <label class="form-label fw-bold fs-8 mb-1">Equipment Name *</label>
                        <input type="text" class="form-control rounded-3 fs-8" id="newEquipName" placeholder="e.g. VIP Tiffany Chair">
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-8 mb-1">Category</label>
                            <select class="form-select rounded-3 fs-8" id="newEquipCategory">
                                <option value="Chairs">Chairs</option>
                                <option value="Tables">Tables</option>
                                <option value="Tents">Tents</option>
                                <option value="Sound System">Sound System</option>
                                <option value="Lights">Lights</option>
                                <option value="Decorations">Decorations</option>
                                <option value="Stages">Stages</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-8 mb-1">Material Tag</label>
                            <select class="form-select rounded-3 fs-8" id="newEquipMaterial">
                                <option value="Plastic">Plastic</option>
                                <option value="Wooden">Wooden</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-8 mb-1">Daily Rental Rate (₱) *</label>
                            <input type="number" class="form-control rounded-3 fs-8" id="newEquipPrice" value="50" min="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-8 mb-1">Total Stock Units *</label>
                            <input type="number" class="form-control rounded-3 fs-8" id="newEquipQty" value="50" min="1">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold fs-8 mb-1">Image URL</label>
                        <input type="text" class="form-control rounded-3 fs-8" id="newEquipImage" value="https://images.unsplash.com/photo-1592078615290-033ee584e267?w=500&q=80">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-8 mb-1">Description</label>
                        <textarea class="form-control rounded-3 fs-8" id="newEquipDesc" rows="2" placeholder="Item description, durability, event suitability..."></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill w-50 fw-bold fs-8 text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn text-white rounded-pill w-50 fw-bold fs-8 shadow-sm" style="background:#5B3FA8;" onclick="executeAdminAddEquipment()"><i class="fa-solid fa-save me-1"></i> Add Equipment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RENTEASE EDIT STOCK MODAL -->
    <div class="modal fade" id="editStockModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
                <div class="modal-header border-0 pb-1">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-sliders me-2 text-primary"></i>Adjust Equipment Stock &amp; Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <input type="hidden" id="editStockItemId">
                    <h6 class="fw-extrabold text-dark mb-3" id="editStockItemTitle">Monoblock Chair</h6>
                    
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-8 mb-1">Available Units</label>
                            <input type="number" class="form-control rounded-3 fs-8 border-success" id="editStockAvailable" min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-8 mb-1">Currently Rented</label>
                            <input type="number" class="form-control rounded-3 fs-8 border-warning" id="editStockRented" min="0">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-8 mb-1">In Maintenance</label>
                            <input type="number" class="form-control rounded-3 fs-8 border-danger" id="editStockMaintenance" min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-8 mb-1">Daily Rate (₱)</label>
                            <input type="number" class="form-control rounded-3 fs-8" id="editStockPrice" min="1">
                        </div>
                    </div>

                    <div class="p-2.5 rounded-3 bg-light border mb-3">
                        <span class="fs-9 text-muted d-block mb-1">Quick Maintenance Action:</span>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 fs-9" onclick="quickShiftMaintenance(5)">Send 5 to Repair</button>
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1 fs-9" onclick="quickRestoreMaintenance()">Restore all to Ready</button>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill w-50 fw-bold fs-8 text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary rounded-pill w-50 fw-bold fs-8 shadow-sm" onclick="executeAdminSaveStock()"><i class="fa-solid fa-check me-1"></i> Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RENTEASE ASSIGN RIDER / DISPATCH MODAL -->
    <div class="modal fade" id="assignRiderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
                <div class="modal-header border-0 pb-1">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-truck-ramp-box me-2 text-success"></i>Dispatch Order &amp; Assign Rider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <input type="hidden" id="dispatchOrderNumber">
                    <div class="mb-3">
                        <strong class="text-dark d-block fs-7" id="dispatchOrderHeader">Order #RE-10245</strong>
                        <span class="text-muted fs-8" id="dispatchOrderCustomer">Bea Solis • San Pablo Laguna</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-8 mb-1">Assigned Delivery Rider</label>
                        <select class="form-select rounded-3 fs-8" id="dispatchRiderSelect">
                            <option value="Juan Dela Cruz|0917-123-4567">Juan Dela Cruz (Plate: MC-8888-JY • 4.9 ★)</option>
                            <option value="Joey Mendoza|0917-888-9999">Joey Mendoza (Plate: MC-5555-JM • 4.8 ★)</option>
                            <option value="Carlos Santos|0918-222-3333">Carlos Santos (Van Fleet: VN-1020-CS • 5.0 ★)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-8 mb-1">Delivery Dispatch Status</label>
                        <select class="form-select rounded-3 fs-8" id="dispatchStatusSelect">
                            <option value="PREPARING">Preparing Equipment at Warehouse</option>
                            <option value="PICKUP">Equipment Loaded &amp; Dispatched</option>
                            <option value="ON_THE_WAY" selected>Out for Delivery (En Route to Venue)</option>
                            <option value="DELIVERED">Delivered &amp; Inspected at Venue</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill w-50 fw-bold fs-8 text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success rounded-pill w-50 fw-bold fs-8 shadow-sm" onclick="executeAdminSaveDispatch()"><i class="fa-solid fa-paper-plane me-1"></i> Update Dispatch</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ID PHOTO FULLSCREEN PREVIEW MODAL -->
    <div class="modal fade" id="viewIdPhotoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
                <div class="modal-header border-0 pb-1">
                    <h6 class="fw-bold mb-0 text-dark" id="viewIdModalTitle">Submitted Verification ID Document</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center pt-2">
                    <img id="viewIdModalImg" class="img-fluid rounded-3 border shadow-sm" style="max-height: 480px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <!-- REJECTION REASON MODAL -->
    <div class="modal fade" id="rejectReasonModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
                <div class="modal-header border-0 pb-1">
                    <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-circle-xmark me-2"></i>Reject Seller Verification Request</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="fs-8 text-muted mb-3">Please specify the reason why this student's seller verification request is being rejected. This reason will be displayed to the student.</p>
                    <input type="hidden" id="rejectRequestId">
                    <input type="hidden" id="rejectUserId">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7">Rejection Reason / Notes <span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3 fs-7" id="rejectReasonText" rows="3" placeholder="e.g. Unreadable ID photo, Student number does not match record, or missing guardian details."></textarea>
                    </div>
                    <div class="d-flex gap-2 pt-2">
                        <button type="button" class="btn btn-light rounded-pill w-50 fw-bold fs-7 text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger rounded-pill w-50 fw-bold fs-7 shadow-sm" onclick="executeAdminRejectVerification()"><i class="fa-solid fa-ban me-1"></i> Confirm Rejection</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function checkAdminSessionOnLoad() {
            try {
                const sessionStr = localStorage.getItem('pasabuy_admin_session');
                if (sessionStr) {
                    const session = JSON.parse(sessionStr);
                    if (session && session.loggedIn) {
                        document.getElementById('adminAuthView').style.display = 'none';
                        document.getElementById('adminMainDashboardView').style.display = 'block';
                        fetchAdminInventory();
                        fetchAdminIssues();
                        return;
                    }
                }
            } catch (e) {}

            document.getElementById('adminAuthView').style.display = 'block';
            document.getElementById('adminMainDashboardView').style.display = 'none';
        }

        window.addEventListener('DOMContentLoaded', checkAdminSessionOnLoad);

        async function executeAdminLogin() {
            const user = document.getElementById('adminUsernameInput').value.trim();
            const pass = document.getElementById('adminPasswordInput').value.trim();
            const errBanner = document.getElementById('adminErrorBanner');
            const errMsg = document.getElementById('adminErrorMsg');

            if (!user || !pass) {
                errMsg.innerText = 'Please enter both Admin username and password.';
                errBanner.style.display = 'block';
                return;
            }

            const validUsers = ['admin', 'admin@pasabuy.site', 'admin@pasabuy.edu.ph'];
            const validPasses = ['Pogilameg', 'Pogilameg#10', 'Pogilameg@10'];

            if (validUsers.includes(user.toLowerCase()) && validPasses.includes(pass)) {
                errBanner.style.display = 'none';
                localStorage.setItem('pasabuy_admin_session', JSON.stringify({ loggedIn: true, user: user, loginTime: Date.now() }));
                document.getElementById('adminAuthView').style.display = 'none';
                document.getElementById('adminMainDashboardView').style.display = 'block';
                fetchAdminInventory();
                fetchAdminIssues();
                return;
            }

            errMsg.innerText = 'Invalid Admin credentials! Use username: admin and password: Pogilameg';
            errBanner.style.display = 'block';
        }

        function logoutAdmin() {
            localStorage.removeItem('pasabuy_admin_session');
            document.getElementById('adminMainDashboardView').style.display = 'none';
            document.getElementById('adminAuthView').style.display = 'block';
            document.getElementById('adminPasswordInput').value = '';
        }

        function showAdminSection(sectionName, element) {
            const sections = ['inventory', 'issues', 'packages', 'rentalOrders', 'dashboard', 'verifications', 'riders', 'students', 'listings', 'payments', 'reports', 'meetups'];
            sections.forEach(s => {
                const el = document.getElementById('section' + s.charAt(0).toUpperCase() + s.slice(1));
                if (el) el.style.display = (s === sectionName) ? 'block' : 'none';
            });
            document.querySelectorAll('.nav-link-admin').forEach(l => l.classList.remove('active'));
            if (element) element.classList.add('active');

            if (sectionName === 'inventory') fetchAdminInventory();
            else if (sectionName === 'issues') fetchAdminIssues();
            else if (sectionName === 'packages') fetchAdminPackages();
            else if (sectionName === 'rentalOrders') fetchAdminRentalOrders();
            else if (sectionName === 'dashboard') fetchAdminDashboardStats();
            else if (sectionName === 'verifications') fetchAdminVerificationRequests();
            else if (sectionName === 'riders') fetchAdminMotorRiders();
            else if (sectionName === 'students') fetchAdminStudents();
            else if (sectionName === 'listings') fetchAdminListings();
            else if (sectionName === 'payments') fetchAdminPayments();
            else if (sectionName === 'reports') fetchAdminReports();
        }

        async function fetchAdminMotorRiders() {
            const tbody = document.getElementById('adminRidersTableBody');
            if (!tbody) return;

            try {
                const res = await fetch('/pasabuy_api.php?action=admin_get_riders');
                if (res.ok) {
                    const data = await res.json();
                    if (!Array.isArray(data) || data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4"><i class="fa-solid fa-motorcycle me-1 opacity-50"></i> No motor driver applications submitted yet.</td></tr>';
                        return;
                    }

                    let html = '';
                    data.forEach(r => {
                        const name = `${r.FirstName || 'Driver'} ${r.LastName || ''}`.trim();
                        const status = (r.VerificationStatus || 'PENDING').toUpperCase();
                        let badgeHtml = '';
                        if (status === 'VERIFIED' || status === 'APPROVED') {
                            badgeHtml = '<span class="badge bg-success text-white fw-bold px-3 py-1 rounded-pill"><i class="fa-solid fa-shield-check me-1"></i> VERIFIED DRIVER</span>';
                        } else if (status === 'REJECTED') {
                            badgeHtml = '<span class="badge bg-danger text-white fw-bold px-3 py-1 rounded-pill"><i class="fa-solid fa-circle-xmark me-1"></i> REJECTED</span>';
                        } else {
                            badgeHtml = '<span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill"><i class="fa-solid fa-clock me-1"></i> PENDING REVIEW</span>';
                        }

                        const imgUrl = r.LicenseImage || 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=500&q=80';

                        html += `
                        <tr>
                            <td>
                                <strong class="text-dark d-block">${name}</strong>
                                <span class="text-muted fs-9">Phone: ${r.PhoneNumber || 'N/A'}</span>
                            </td>
                            <td>
                                <strong class="fs-8 text-dark d-block">${r.VehicleModel || 'Motorcycle'}</strong>
                                <span class="badge bg-light text-dark border fs-9">Plate: <code>${r.PlateNumber || 'N/A'}</code></span>
                            </td>
                            <td><code>${r.DriverLicenseNo || 'N/A'}</code></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-pill border fs-9 py-0 px-2" onclick="openViewIdModal('${imgUrl.replace(/'/g, "\\'")}', '${name.replace(/'/g, "\\'")}')">
                                    <i class="fa-solid fa-image text-primary me-1"></i> License Image
                                </button>
                            </td>
                            <td>${badgeHtml}</td>
                            <td>
                                ${status === 'PENDING' ? `
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-success rounded-pill px-3 fw-bold fs-9" onclick="adminVerifyRider(${r.Id}, 'VERIFIED')">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold fs-9" onclick="adminVerifyRider(${r.Id}, 'REJECTED')">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                </div>` : (status === 'REJECTED' ? `
                                <button class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold fs-9" onclick="adminVerifyRider(${r.Id}, 'VERIFIED')">
                                    <i class="fa-solid fa-check me-1"></i> Re-Approve
                                </button>` : `
                                <span class="text-success fs-8 fw-semibold"><i class="fa-solid fa-shield-check me-1"></i> Verified</span>
                                `)}
                            </td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                }
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Error loading motor driver applications.</td></tr>';
            }
        }

        async function adminVerifyRider(riderId, status) {
            if (!confirm(`Admin Confirmation: ${status} this motor driver application?`)) return;
            try {
                const res = await fetch('/pasabuy_api.php?action=admin_verify_rider', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ riderId: riderId, status: status })
                });
                const data = await res.json();
                if (data.success) {
                    alert(`🎉 Motor Rider status updated to ${status}!`);
                    fetchAdminMotorRiders();
                } else {
                    alert(data.message || 'Error updating rider status.');
                }
            } catch (e) {
                alert('Network error updating rider status.');
            }
        }

        async function fetchAdminDashboardStats() {
            try {
                const res = await fetch('/pasabuy_api.php?action=admin_verification_requests');
                if (res.ok) {
                    const data = await res.json();
                    if (Array.isArray(data)) {
                        const pending = data.filter(r => r.Status === 'PENDING').length;
                        const approved = data.filter(r => r.Status === 'APPROVED').length;
                        document.getElementById('dashPendingVerifications').innerText = pending || 0;
                        document.getElementById('dashVerifiedStudents').innerText = approved || 0;
                    }
                }
            } catch (e) {}

            try {
                const listRes = await fetch('/pasabuy_api.php?action=listings');
                if (listRes.ok) {
                    const list = await listRes.json();
                    if (Array.isArray(list)) {
                        document.getElementById('dashActiveListings').innerText = list.length || 0;
                    }
                }
            } catch (e) {}
        }

        async function fetchAdminVerificationRequests() {
            const tbody = document.getElementById('adminVerificationsTableBody');
            if (!tbody) return;

            try {
                const res = await fetch('/pasabuy_api.php?action=admin_verification_requests');
                if (res.ok) {
                    const data = await res.json();
                    if (!Array.isArray(data) || data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4"><i class="fa-solid fa-id-card me-1 opacity-50"></i> No seller verification requests submitted yet. Student requests will appear here for Admin moderation!</td></tr>';
                        return;
                    }

                    let html = '';
                    data.forEach(req => {
                        const name = `${req.FirstName || 'Student'} ${req.LastName || ''}`.trim();
                        const status = (req.Status || 'PENDING').toUpperCase();
                        let badgeHtml = '';
                        if (status === 'APPROVED' || status === 'VERIFIED') {
                            badgeHtml = '<span class="badge bg-success text-white fw-bold px-3 py-1 rounded-pill"><i class="fa-solid fa-circle-check me-1"></i> VERIFIED SELLER</span>';
                        } else if (status === 'REJECTED') {
                            badgeHtml = `<span class="badge bg-danger text-white fw-bold px-3 py-1 rounded-pill" title="${req.RejectionReason || ''}"><i class="fa-solid fa-circle-xmark me-1"></i> REJECTED</span>`;
                        } else {
                            badgeHtml = '<span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill"><i class="fa-solid fa-clock me-1"></i> PENDING REVIEW</span>';
                        }

                        const imgUrl = req.IdFrontImage || 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=500&q=80';

                        html += `
                        <tr>
                            <td>
                                <strong class="text-dark d-block">${name}</strong>
                                <span class="text-muted fs-9 d-block">Student #: <code>${req.StudentNumber || 'N/A'}</code></span>
                                <span class="text-muted fs-9">${req.SchoolEmail || ''}</span>
                            </td>
                            <td>
                                <strong class="fs-8 text-dark d-block">${req.Hometown || 'N/A'}</strong>
                                <span class="text-muted fs-9 d-block">${req.HomeAddress || 'N/A'}</span>
                                <span class="badge bg-light text-dark border fs-9">Zip: ${req.PostalCode || 'N/A'}</span>
                            </td>
                            <td>
                                <span class="fs-8 text-dark d-block"><i class="fa-solid fa-phone me-1 text-primary"></i> ${req.PhoneNumber || 'N/A'}</span>
                                <span class="text-muted fs-9 d-block">Guardian: <strong>${req.GuardianName || 'N/A'}</strong></span>
                                <span class="text-muted fs-9">Guardian Contact: ${req.GuardianPhone || 'N/A'}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-9">${req.IdType || 'ID Card'}</span>
                                    <span class="fs-9 text-muted">ID #: <code>${req.IdNumber || 'N/A'}</code></span>
                                    <button class="btn btn-sm btn-light rounded-pill border fs-9 py-0 px-2 mt-1" onclick="openViewIdModal('${imgUrl.replace(/'/g, "\\'")}', '${name.replace(/'/g, "\\'")}')">
                                        <i class="fa-solid fa-image text-primary me-1"></i> View ID Photo
                                    </button>
                                </div>
                            </td>
                            <td>${badgeHtml}</td>
                            <td>
                                ${status === 'PENDING' ? `
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-success rounded-pill px-3 fw-bold fs-9" onclick="adminApproveVerification(${req.Id}, ${req.UserId})">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold fs-9" onclick="openRejectReasonModal(${req.Id}, ${req.UserId})">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                </div>` : (status === 'REJECTED' ? `
                                <button class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold fs-9" onclick="adminApproveVerification(${req.Id}, ${req.UserId})">
                                    <i class="fa-solid fa-check me-1"></i> Re-Approve
                                </button>` : `
                                <span class="text-success fs-8 fw-semibold"><i class="fa-solid fa-shield-check me-1"></i> Approved</span>
                                `)}
                            </td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                }
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Error loading verification requests.</td></tr>';
            }
        }

        function openViewIdModal(imgUrl, studentName) {
            document.getElementById('viewIdModalTitle').innerText = `Submitted Verification ID - ${studentName}`;
            document.getElementById('viewIdModalImg').src = imgUrl;
            new bootstrap.Modal(document.getElementById('viewIdPhotoModal')).show();
        }

        async function adminApproveVerification(requestId, userId) {
            if (!confirm('Admin Confirmation: Approve seller verification for this student user?')) return;

            try {
                const res = await fetch('/pasabuy_api.php?action=admin_approve_verification', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ requestId: requestId, userId: userId })
                });
                const data = await res.json();
                if (data.success) {
                    alert('🎉 Student Seller Verification APPROVED! Student can now sell items on campus.');
                    fetchAdminVerificationRequests();
                    fetchAdminDashboardStats();
                } else {
                    alert(data.message || 'Error approving request.');
                }
            } catch (e) {
                alert('Network error approving verification request.');
            }
        }

        function openRejectReasonModal(requestId, userId) {
            document.getElementById('rejectRequestId').value = requestId;
            document.getElementById('rejectUserId').value = userId;
            document.getElementById('rejectReasonText').value = '';
            new bootstrap.Modal(document.getElementById('rejectReasonModal')).show();
        }

        async function executeAdminRejectVerification() {
            const requestId = parseInt(document.getElementById('rejectRequestId').value) || 0;
            const userId = parseInt(document.getElementById('rejectUserId').value) || 0;
            const reason = document.getElementById('rejectReasonText').value.trim();

            if (!reason) {
                alert('Please enter a rejection reason for the student.');
                return;
            }

            try {
                const res = await fetch('/pasabuy_api.php?action=admin_reject_verification', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ requestId: requestId, userId: userId, reason: reason })
                });
                const data = await res.json();
                if (data.success) {
                    alert('❌ Verification request rejected. Student has been notified with your reason.');
                    const modalEl = document.getElementById('rejectReasonModal');
                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                    if (bsModal) bsModal.hide();
                    fetchAdminVerificationRequests();
                    fetchAdminDashboardStats();
                } else {
                    alert(data.message || 'Error rejecting request.');
                }
            } catch (e) {
                alert('Network error rejecting verification request.');
            }
        }

        async function fetchAdminStudents() {
            const tbody = document.getElementById('adminStudentsTableBody');
            if (!tbody) return;
            try {
                const res = await fetch('/pasabuy_api.php?action=admin_students');
                if (res.ok) {
                    const data = await res.json();
                    if (!Array.isArray(data) || data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4"><i class="fa-solid fa-users-slash me-1"></i> No registered student accounts in database yet. Students who register via the app will appear here!</td></tr>';
                        return;
                    }
                    let html = '';
                    data.forEach(user => {
                        const name = (user.FirstName || user.FirstName === '') ? `${user.FirstName} ${user.LastName}` : (user.name || 'Student User');
                        html += `
                        <tr>
                            <td><strong class="text-dark">${name}</strong></td>
                            <td><code>${user.StudentNumber || user.studentNumber || 'N/A'}</code></td>
                            <td>${user.Course || user.course || 'N/A'} (${user.YearLevel || user.yearLevel || 'N/A'})</td>
                            <td>${user.SchoolEmail || user.email}</td>
                            <td><span class="badge ${user.VerificationStatus === 'VERIFIED' ? 'bg-success' : 'bg-warning text-dark'} fw-bold px-3 py-1 rounded-pill">${user.VerificationStatus || 'UNVERIFIED'}</span></td>
                            <td>
                                ${user.Status === 'SUSPENDED'
                                    ? '<span class="text-muted fs-8 fw-semibold">Suspended</span>' 
                                    : `<button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold" onclick="suspendStudentUser(${user.Id || user.id})">Suspend</button>`}
                            </td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                }
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No registered student accounts in database yet.</td></tr>';
            }
        }

        async function suspendStudentUser(userId) {
            if (confirm('Admin Action: Suspend this student user account?')) {
                try {
                    await fetch(`/pasabuy_api.php?action=suspend_user&id=${userId}`, { method: 'POST' });
                    alert('Student account suspended.');
                    fetchAdminStudents();
                } catch (e) {
                    alert('Error suspending user.');
                }
            }
        }

        async function fetchAdminPayments() {
            const tbody = document.getElementById('adminPaymentsTableBody');
            if (!tbody) return;
            try {
                const res = await fetch('/pasabuy_api.php?action=admin_payments');
                if (res.ok) {
                    const data = await res.json();
                    if (!Array.isArray(data) || data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4"><i class="fa-solid fa-receipt me-1"></i> No PayMongo fee payments recorded in database yet. Paid GCash fees will appear here automatically!</td></tr>';
                        return;
                    }
                    let html = '';
                    data.forEach(p => {
                        html += `
                        <tr>
                            <td><code>${p.providerReference || ('PM-CHK-' + p.id)}</code></td>
                            <td>${p.listingTitle || 'Campus Listing'}</td>
                            <td><strong class="text-success">₱${parseFloat(p.amount).toFixed(2)}</strong></td>
                            <td><span class="badge bg-success text-white fw-bold px-3 py-1 rounded-pill"><i class="fa-solid fa-check me-1"></i> ${p.status}</span></td>
                            <td>${new Date(p.createdAt).toLocaleString()}</td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                }
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No PayMongo fee payments recorded yet.</td></tr>';
            }
        }

        async function fetchAdminListings() {
            const container = document.getElementById('adminListingsContainer');
            if (!container) return;

            try {
                const res = await fetch('/pasabuy_api.php?action=listings');
                if (res.ok) {
                    const data = await res.json();
                    let html = '';
                    data.forEach(item => {
                        html += `
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                                <img src="${(item.images && item.images.length > 0) ? (item.images[0].imageUrl || item.images[0]) : (item.ImageUrl || 'https://images.unsplash.com/photo-1611125832047-1d7ad1e8e48b?w=500&q=80')}" class="rounded-3 mb-2" style="height:140px; object-fit:cover;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <strong class="text-primary fs-7">₱${parseFloat(item.Price || item.price || 0).toFixed(2)}</strong>
                                    <span class="badge bg-warning-subtle text-warning fw-bold px-2 py-1 rounded-pill fs-9">Fee Paid</span>
                                </div>
                                <h6 class="fw-bold text-dark fs-8 mb-2">${item.Title || item.title}</h6>
                                <button class="btn btn-sm btn-outline-danger rounded-pill w-100 fw-bold fs-8" onclick="adminDeleteListing(${item.Id || item.id})"><i class="fa-solid fa-trash me-1"></i> Admin Delete</button>
                            </div>
                        </div>`;
                    });
                    container.innerHTML = html || '<div class="col-12 text-muted">No active listings to show.</div>';
                }
            } catch (e) {
                console.error(e);
            }
        }

        async function adminDeleteListing(id) {
            if (confirm('Admin Action: Delete this listing from campus marketplace?')) {
                try {
                    await fetch(`/pasabuy_api.php?action=delete_listing&id=${id}`, { method: 'POST' });
                    alert('Listing deleted by Admin.');
                    fetchAdminListings();
                } catch (e) {
                    alert('Error deleting listing.');
                }
            }
        }

        /* ==========================================================================
           RENTEASE EVENT PLATFORM OPERATIONAL LOGIC & MODULES
           ========================================================================== */
        window.adminInventoryCache = [];

        async function fetchAdminInventory() {
            const tbody = document.getElementById('adminInventoryTableBody');
            if (!tbody) return;

            try {
                const res = await fetch('../rentease_api.php?action=get_inventory');
                const data = await res.json();
                if (data.success && Array.isArray(data.items)) {
                    window.adminInventoryCache = data.items;

                    // Compute KPI Summary Counts
                    let totalUnits = 0;
                    let availableUnits = 0;
                    let rentedUnits = 0;
                    let maintUnits = 0;

                    data.items.forEach(item => {
                        totalUnits += parseInt(item.qty_total) || 0;
                        availableUnits += parseInt(item.qty_available) || 0;
                        rentedUnits += parseInt(item.qty_rented) || 0;
                        maintUnits += parseInt(item.qty_maintenance) || 0;
                    });

                    if (document.getElementById('dashInventoryTotal')) document.getElementById('dashInventoryTotal').innerText = totalUnits;
                    if (document.getElementById('dashInventoryAvailable')) document.getElementById('dashInventoryAvailable').innerText = availableUnits;
                    if (document.getElementById('dashInventoryRented')) document.getElementById('dashInventoryRented').innerText = rentedUnits;
                    if (document.getElementById('dashInventoryMaintenance')) document.getElementById('dashInventoryMaintenance').innerText = maintUnits;

                    renderAdminInventoryTable(data.items);
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">No inventory items found.</td></tr>';
                }
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-danger">Connection error fetching inventory.</td></tr>';
            }
        }

        function renderAdminInventoryTable(items) {
            const tbody = document.getElementById('adminInventoryTableBody');
            if (!tbody) return;

            if (items.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">No matching rental items found.</td></tr>';
                return;
            }

            let html = '';
            items.forEach(item => {
                const price = parseFloat(item.price_per_day || 0).toFixed(2);
                html += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="${item.image_url}" class="rounded-3 shadow-xs" style="width:44px; height:44px; object-fit:cover;">
                            <div>
                                <strong class="text-dark d-block fs-8">${item.name}</strong>
                                <span class="text-muted fs-9">ID: #REN-${String(item.id).padStart(4, '0')}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border px-2 py-1">${item.category}</span>
                        <span class="badge text-white px-2 py-1" style="background:#5B3FA8;">${item.material_tag || 'Standard'}</span>
                    </td>
                    <td><strong class="text-dark">₱${price}</strong><span class="text-muted fs-9">/day</span></td>
                    <td class="text-center fw-bold text-dark">${item.qty_total}</td>
                    <td class="text-center"><span class="badge bg-success-subtle text-success fw-bold px-2 py-1 fs-9">${item.qty_available} units</span></td>
                    <td class="text-center"><span class="badge bg-warning-subtle text-warning-emphasis fw-bold px-2 py-1 fs-9">${item.qty_rented} units</span></td>
                    <td class="text-center"><span class="badge bg-danger-subtle text-danger fw-bold px-2 py-1 fs-9">${item.qty_maintenance} units</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-0 fs-9" onclick="openEditStockModal(${item.id})">
                                <i class="fa-solid fa-sliders me-1"></i> Adjust
                            </button>
                        </div>
                    </td>
                </tr>`;
            });
            tbody.innerHTML = html;
        }

        function filterAdminInventoryTable() {
            const query = (document.getElementById('inventorySearchInput')?.value || '').toLowerCase().trim();
            const category = document.getElementById('inventoryCategoryFilter')?.value || '';

            let filtered = window.adminInventoryCache || [];
            if (category) {
                filtered = filtered.filter(i => (i.category || '').toLowerCase() === category.toLowerCase());
            }
            if (query) {
                filtered = filtered.filter(i => 
                    (i.name || '').toLowerCase().includes(query) || 
                    (i.category || '').toLowerCase().includes(query) ||
                    (i.material_tag || '').toLowerCase().includes(query)
                );
            }
            renderAdminInventoryTable(filtered);
        }

        function openAddInventoryModal() {
            const modalEl = document.getElementById('addEquipmentModal');
            if (modalEl) new bootstrap.Modal(modalEl).show();
        }

        async function executeAdminAddEquipment() {
            const name = document.getElementById('newEquipName').value.trim();
            const category = document.getElementById('newEquipCategory').value;
            const material = document.getElementById('newEquipMaterial').value;
            const price = parseFloat(document.getElementById('newEquipPrice').value) || 50;
            const qty = parseInt(document.getElementById('newEquipQty').value) || 50;
            const img = document.getElementById('newEquipImage').value.trim();
            const desc = document.getElementById('newEquipDesc').value.trim();

            if (!name) {
                alert('Please enter equipment name.');
                return;
            }

            try {
                const res = await fetch('../rentease_api.php?action=admin_add_equipment', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        name: name,
                        category: category,
                        material_tag: material,
                        price_per_day: price,
                        qty_total: qty,
                        image_url: img,
                        description: desc
                    })
                });
                const data = await res.json();
                if (data.success) {
                    alert(`✅ Equipment "${name}" added to RentEase catalog!`);
                    const modalEl = document.getElementById('addEquipmentModal');
                    if (modalEl) bootstrap.Modal.getInstance(modalEl).hide();
                    fetchAdminInventory();
                } else {
                    alert(data.message || 'Error adding equipment.');
                }
            } catch (e) {
                alert('Network error adding equipment.');
            }
        }

        function openEditStockModal(id) {
            const item = (window.adminInventoryCache || []).find(i => parseInt(i.id) === parseInt(id));
            if (!item) return;

            document.getElementById('editStockItemId').value = item.id;
            document.getElementById('editStockItemTitle').innerText = `${item.name} (#REN-${String(item.id).padStart(4, '0')})`;
            document.getElementById('editStockAvailable').value = item.qty_available;
            document.getElementById('editStockRented').value = item.qty_rented;
            document.getElementById('editStockMaintenance').value = item.qty_maintenance;
            document.getElementById('editStockPrice').value = item.price_per_day;

            const modalEl = document.getElementById('editStockModal');
            if (modalEl) new bootstrap.Modal(modalEl).show();
        }

        function quickShiftMaintenance(qty) {
            const availInput = document.getElementById('editStockAvailable');
            const maintInput = document.getElementById('editStockMaintenance');
            let avail = parseInt(availInput.value) || 0;
            let maint = parseInt(maintInput.value) || 0;

            if (avail >= qty) {
                availInput.value = avail - qty;
                maintInput.value = maint + qty;
            }
        }

        function quickRestoreMaintenance() {
            const availInput = document.getElementById('editStockAvailable');
            const maintInput = document.getElementById('editStockMaintenance');
            let avail = parseInt(availInput.value) || 0;
            let maint = parseInt(maintInput.value) || 0;

            availInput.value = avail + maint;
            maintInput.value = 0;
        }

        async function executeAdminSaveStock() {
            const id = parseInt(document.getElementById('editStockItemId').value);
            const avail = parseInt(document.getElementById('editStockAvailable').value) || 0;
            const rented = parseInt(document.getElementById('editStockRented').value) || 0;
            const maint = parseInt(document.getElementById('editStockMaintenance').value) || 0;
            const price = parseFloat(document.getElementById('editStockPrice').value) || 0;
            const total = avail + rented + maint;

            try {
                const res = await fetch('../rentease_api.php?action=admin_update_stock', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: id,
                        qty_total: total,
                        qty_available: avail,
                        qty_rented: rented,
                        qty_maintenance: maint,
                        price_per_day: price
                    })
                });
                const data = await res.json();
                if (data.success) {
                    alert('✅ Equipment stock changes saved!');
                    const modalEl = document.getElementById('editStockModal');
                    if (modalEl) bootstrap.Modal.getInstance(modalEl).hide();
                    fetchAdminInventory();
                } else {
                    alert(data.message || 'Error updating stock.');
                }
            } catch (e) {
                alert('Network error saving stock.');
            }
        }

        /* Support & Issues Tickets */
        async function fetchAdminIssues() {
            const tbody = document.getElementById('adminIssuesTableBody');
            if (!tbody) return;

            try {
                const res = await fetch('../rentease_api.php?action=get_issues');
                const data = await res.json();
                if (data.success && Array.isArray(data.issues)) {
                    let total = data.issues.length;
                    let pending = 0;
                    let inProgress = 0;
                    let resolved = 0;

                    data.issues.forEach(i => {
                        const s = (i.status || '').toLowerCase();
                        if (s === 'reported' || s === 'open') pending++;
                        else if (s === 'in progress' || s === 'reviewing') inProgress++;
                        else if (s === 'resolved') resolved++;
                    });

                    if (document.getElementById('dashIssuesTotal')) document.getElementById('dashIssuesTotal').innerText = total;
                    if (document.getElementById('dashIssuesPending')) document.getElementById('dashIssuesPending').innerText = pending;
                    if (document.getElementById('dashIssuesInProgress')) document.getElementById('dashIssuesInProgress').innerText = inProgress;
                    if (document.getElementById('dashIssuesResolved')) document.getElementById('dashIssuesResolved').innerText = resolved;
                    if (document.getElementById('adminIssuesBadge')) document.getElementById('adminIssuesBadge').innerText = pending + inProgress;

                    let html = '';
                    data.issues.forEach(ticket => {
                        const status = ticket.status || 'Reported';
                        let badgeClass = 'bg-danger text-white';
                        if (status === 'Reviewing') badgeClass = 'bg-primary text-white';
                        else if (status === 'In Progress') badgeClass = 'bg-warning text-dark';
                        else if (status === 'Resolved') badgeClass = 'bg-success text-white';

                        html += `
                        <tr>
                            <td><code>#${ticket.ticket_number}</code></td>
                            <td><span class="badge bg-light text-dark border">#${ticket.order_number || 'N/A'}</span></td>
                            <td>
                                <strong class="text-dark d-block">${ticket.customer_name || 'Customer'}</strong>
                                <span class="text-muted fs-9">${ticket.customer_email || 'customer@rentease.ph'}</span>
                            </td>
                            <td><span class="badge bg-secondary-subtle text-secondary fw-semibold">${ticket.category}</span></td>
                            <td><span class="fs-8 text-dark">${ticket.description}</span></td>
                            <td><span class="badge ${badgeClass} fw-bold px-3 py-1 rounded-pill">${status}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary py-0 px-2 fs-9" onclick="updateAdminIssueStatus(${ticket.id}, 'Reviewing')" title="Mark Reviewing">Review</button>
                                    <button class="btn btn-outline-warning py-0 px-2 fs-9" onclick="updateAdminIssueStatus(${ticket.id}, 'In Progress')" title="Mark In Progress">Progress</button>
                                    <button class="btn btn-outline-success py-0 px-2 fs-9" onclick="updateAdminIssueStatus(${ticket.id}, 'Resolved')" title="Resolve Ticket">Resolve</button>
                                </div>
                            </td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                }
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">Error loading tickets.</td></tr>';
            }
        }

        async function updateAdminIssueStatus(issueId, newStatus) {
            try {
                const res = await fetch('../rentease_api.php?action=update_issue_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ issue_id: issueId, status: newStatus })
                });
                const data = await res.json();
                if (data.success) {
                    alert(`✅ Ticket #${issueId} status successfully updated to "${newStatus}"!`);
                    fetchAdminIssues();
                } else {
                    alert(data.message || 'Could not update ticket status.');
                }
            } catch (e) {
                alert('Network error updating ticket status.');
            }
        }

        /* Event Packages */
        async function fetchAdminPackages() {
            const container = document.getElementById('adminPackagesContainer');
            if (!container) return;

            try {
                const res = await fetch('../rentease_api.php?action=get_packages');
                const data = await res.json();
                if (data.success && Array.isArray(data.packages)) {
                    let html = '';
                    data.packages.forEach(pkg => {
                        const standardPrice = parseFloat(pkg.standard_price || 0).toFixed(2);
                        const bundlePrice = parseFloat(pkg.bundle_price || 0).toFixed(2);
                        const savings = parseFloat(pkg.savings || 0).toFixed(2);

                        let itemsHtml = '';
                        if (Array.isArray(pkg.included_items)) {
                            itemsHtml = pkg.included_items.map(it => `
                                <li class="d-flex justify-content-between align-items-center py-1 border-bottom fs-8">
                                    <span>${it.name}</span>
                                    <span class="badge bg-primary text-white">${it.qty} units</span>
                                </li>
                            `).join('');
                        }

                        html += `
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-warning text-dark fw-bold mb-1"><i class="fa-solid fa-sparkles me-1"></i> Featured Event Bundle</span>
                                        <h5 class="fw-bold text-dark mb-0">${pkg.name}</h5>
                                    </div>
                                    <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill">Save ₱${savings}</span>
                                </div>
                                <p class="fs-8 text-muted mb-3">${pkg.description}</p>

                                <div class="mb-3">
                                    <strong class="fs-8 text-dark d-block mb-1">Included Equipment:</strong>
                                    <ul class="list-unstyled mb-0">${itemsHtml}</ul>
                                </div>

                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="text-muted text-decoration-line-through fs-8">Standard: ₱${standardPrice}</span>
                                        <div class="fw-extrabold fs-5" style="color:#5B3FA8;">Bundle: ₱${bundlePrice}</div>
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm rounded-pill fw-bold px-3" onclick="alert('Package promo is currently active on the customer mobile app.')">
                                        <i class="fa-solid fa-circle-check me-1"></i> Active
                                    </button>
                                </div>
                            </div>
                        </div>`;
                    });
                    container.innerHTML = html;
                }
            } catch (e) {}
        }

        /* Rental Orders & Dispatch */
        async function fetchAdminRentalOrders() {
            const tbody = document.getElementById('adminRentalOrdersTableBody');
            if (!tbody) return;

            try {
                const res = await fetch('../rentease_api.php?action=get_admin_dashboard');
                const data = await res.json();
                if (data.success && Array.isArray(data.recent_orders)) {
                    let html = '';
                    data.recent_orders.forEach(ord => {
                        const total = parseFloat(ord.total_amount || 0).toFixed(2);
                        html += `
                        <tr>
                            <td><strong class="text-dark">#${ord.order_number}</strong></td>
                            <td>
                                <strong class="text-dark d-block">${ord.customer_name}</strong>
                                <span class="text-muted fs-9">${ord.customer_phone || ord.customer_email || '0917-123-4567'}</span>
                            </td>
                            <td>
                                <span class="badge ${ord.fulfillment_type === 'Delivery' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary'} fw-bold mb-1">${ord.fulfillment_type}</span>
                                <div class="fs-9 text-muted">${ord.delivery_address || 'Store Pickup'}</div>
                            </td>
                            <td><span class="fs-8 text-dark">${ord.rental_start_date} (${ord.rental_days} day)</span></td>
                            <td><strong class="text-success fs-7">₱${total}</strong></td>
                            <td><span class="badge bg-light text-dark border">${ord.payment_method}</span></td>
                            <td><span class="badge bg-info-subtle text-info fw-bold px-3 py-1 rounded-pill">${ord.status}</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-0 fs-9" onclick="alert('Order #${ord.order_number} dispatched with Rider Juan Dela Cruz.')">
                                    <i class="fa-solid fa-truck-fast me-1"></i> Track
                                </button>
                            </td>
                        </tr>`;
                    });
                    tbody.innerHTML = html || '<tr><td colspan="8" class="text-center py-4 text-muted">No rental orders recorded yet.</td></tr>';
                }
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">Error loading rental orders.</td></tr>';
            }
        }
    </script>
</body>
</html>
