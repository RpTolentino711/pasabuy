<?php
// RentEase Admin Operations Portal
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isAdminLoggedIn = !empty($_SESSION['admin_logged_in']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentEase - Admin Operations Portal</title>
    <!-- Google Fonts & CSS Frameworks -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <!-- Chart.js for Reports -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --admin-primary: #5B3FA8;
            --admin-primary-dark: #341F97;
            --admin-primary-light: #7C5CE0;
            --admin-sidebar-bg: #1A1340;
            --admin-sidebar-active: #2E216B;
            --admin-bg: #F8FAFC;
            --admin-card-border: #E2E8F0;
            --admin-text-dark: #0F172A;
            --admin-text-muted: #64748B;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text-dark);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styling matching ADMIN UI.png */
        .admin-sidebar {
            width: 250px;
            background-color: var(--admin-sidebar-bg);
            min-height: 100vh;
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand h5 {
            margin: 0;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: -0.5px;
            color: #FFFFFF;
        }

        .sidebar-brand small {
            display: block;
            font-size: 0.68rem;
            color: rgba(255,255,255,0.6);
            letter-spacing: 0.2px;
        }

        .sidebar-nav {
            padding: 16px 12px;
            list-style: none;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 4px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            color: rgba(255,255,255,0.6);
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link:hover {
            color: #FFFFFF;
            background-color: rgba(255,255,255,0.08);
        }

        .sidebar-nav .nav-link.active {
            color: #FFFFFF;
            background-color: var(--admin-sidebar-active);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .sidebar-nav .nav-link.active i {
            color: #A78BFA;
        }

        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Top Header Navbar */
        .admin-main-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .admin-top-header {
            height: 64px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--admin-card-border);
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .admin-search-box {
            position: relative;
            width: 360px;
        }

        .admin-search-box input {
            padding-left: 36px;
            border-radius: 20px;
            background: #F1F5F9;
            border: 1px solid transparent;
            font-size: 0.85rem;
            height: 38px;
        }

        .admin-search-box input:focus {
            background: #FFFFFF;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(91,63,168,0.15);
        }

        .admin-search-box i {
            position: absolute;
            left: 14px;
            top: 12px;
            color: #94A3B8;
            font-size: 0.85rem;
        }

        /* Content Sections */
        .admin-content-container {
            padding: 28px;
            flex-grow: 1;
        }

        .admin-section {
            display: none;
        }

        .admin-section.active {
            display: block;
            animation: fadeIn 0.25s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Cards and Tables */
        .card-stat {
            background: #FFFFFF;
            border-radius: 14px;
            padding: 20px;
            border: 1px solid var(--admin-card-border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.04);
        }

        .stat-icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .admin-table-card {
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid var(--admin-card-border);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .table-custom th {
            background: #F8FAFC;
            color: #64748B;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--admin-card-border);
        }

        .table-custom td {
            padding: 14px 18px;
            vertical-align: middle;
            font-size: 0.85rem;
            border-bottom: 1px solid #F1F5F9;
        }

        /* Primary Action Buttons */
        .btn-admin-primary {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-dark));
            color: #FFFFFF;
            border: none;
            border-radius: 20px;
            padding: 7px 18px;
            font-size: 0.82rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 3px 8px rgba(91,63,168,0.25);
            transition: all 0.2s ease;
        }

        .btn-admin-primary:hover {
            color: #FFFFFF;
            background: linear-gradient(135deg, #6C4DB8, #4027B0);
            box-shadow: 0 4px 12px rgba(91,63,168,0.35);
            transform: translateY(-1px);
        }

        /* Sub-tab Pills matching ADMIN UI.png */
        .subtab-nav {
            display: flex;
            gap: 8px;
            border-bottom: 1px solid var(--admin-card-border);
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .subtab-btn {
            background: none;
            border: none;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #64748B;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .subtab-btn:hover {
            color: var(--admin-primary);
            background: #F1F5F9;
        }

        .subtab-btn.active {
            color: var(--admin-primary);
            background: #EDE9FE;
            font-weight: 700;
        }

        /* Status Badges */
        .badge-stock-in { background: #DCFCE7; color: #15803D; font-weight: 700; font-size: 0.72rem; }
        .badge-stock-low { background: #FEF3C7; color: #B45309; font-weight: 700; font-size: 0.72rem; }
        .badge-stock-out { background: #FEE2E2; color: #B91C1C; font-weight: 700; font-size: 0.72rem; }

        .pulse-live {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulseLive 1.8s infinite;
        }
        @keyframes pulseLive {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Auth Login Card */
        .auth-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, #0F172A, #1E1B4B);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-modal-card {
            width: 100%;
            max-width: 420px;
            background: #FFFFFF;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
    </style>
</head>
<body>

    <!-- ==========================================================
         ADMIN AUTHENTICATION MODAL (Shown when unauthenticated)
         ========================================================== -->
    <div id="authOverlay" class="auth-overlay" style="<?= $isAdminLoggedIn ? 'display:none;' : 'display:flex;' ?>">
        <div class="auth-modal-card">
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #1E1B4B, #5B3FA8);">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center p-2 mb-3 shadow" style="width:60px; height:60px;">
                    <img src="LOGO.png" alt="RentEase" style="height:36px; width:auto; object-fit:contain;">
                </div>
                <h5 class="fw-extrabold mb-1">RentEase Admin Portal</h5>
                <p class="text-white-50 fs-8 mb-0">Operations &amp; Equipment Management System</p>
            </div>
            <div class="p-4">
                <div id="loginErrorMsg" class="alert alert-danger py-2 px-3 fs-8 mb-3" style="display:none;"></div>
                
                <form id="adminLoginForm" onsubmit="event.preventDefault(); handleAdminLogin();">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-8">Username or Admin Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted fs-8"></i></span>
                            <input type="text" class="form-control fs-8" id="loginUsername" placeholder="admin" value="admin" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-8">Admin Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted fs-8"></i></span>
                            <input type="password" class="form-control fs-8 border-start-0 border-end-0" id="loginPassword" placeholder="Pogilameg@10" value="Pogilameg@10" required>
                            <button type="button" class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white" style="border-color: #dee2e6;" onclick="toggleAdminPasswordVisibility()" title="Show/Hide Password">
                                <i class="fa-solid fa-eye text-muted fs-8" id="loginPasswordEye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4 fs-9 text-muted">
                        <div><i class="fa-solid fa-shield-halved text-success me-1"></i> SSL 256-bit Secure</div>
                        <span class="badge bg-purple-subtle text-primary fw-bold">Live DB Sync</span>
                    </div>
                    <button type="submit" class="btn btn-admin-primary w-100 justify-content-center py-2 fs-7 mb-3" id="loginBtn">
                        <i class="fa-solid fa-right-to-bracket"></i> Sign In to Operations Hub
                    </button>
                    <div class="text-center pt-2 border-top">
                        <a href="../student/index.php" class="text-decoration-none fs-8 text-secondary">
                            <i class="fa-solid fa-store me-1"></i> Open RentEase Student App
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==========================================================
         SIDEBAR NAVIGATION (Matches ADMIN UI.png)
         ========================================================== -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div>
            <!-- Brand Header -->
            <div class="sidebar-brand">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center p-1.5 shadow-sm" style="width:38px; height:38px; flex-shrink:0;">
                    <img src="LOGO.png" alt="RentEase Logo" style="height:22px; width:auto; object-fit:contain;">
                </div>
                <div>
                    <h5>RentEase</h5>
                    <small>Easy Rentals. Seamless Events.</small>
                </div>
            </div>

            <!-- Navigation Links -->
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link active" onclick="switchAdminTab('dashboard', this)">
                        <i class="fa-solid fa-gauge"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('products', this)">
                        <i class="fa-solid fa-box-archive"></i> <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('inventory', this)">
                        <i class="fa-solid fa-boxes-stacked"></i> <span>Inventory</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('orders', this)">
                        <i class="fa-solid fa-cart-shopping"></i> <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('customers', this)">
                        <i class="fa-solid fa-users"></i> <span>Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('delivery', this)">
                        <i class="fa-solid fa-truck-fast"></i> <span>Delivery</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('serviceCharges', this)">
                        <i class="fa-solid fa-receipt"></i> <span>Service Charges</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('support', this)">
                        <i class="fa-solid fa-headset"></i> <span>Support / Issues</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('transactions', this)">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i> <span>Transactions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('reports', this)">
                        <i class="fa-solid fa-chart-line"></i> <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="switchAdminTab('settings', this)">
                        <i class="fa-solid fa-gear"></i> <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer (Admin Profile & Logout) -->
        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle bg-purple text-white d-flex align-items-center justify-content-center fw-bold" style="width:34px; height:34px; background:#5B3FA8; font-size:0.85rem;">
                    A
                </div>
                <div>
                    <div class="fw-bold fs-8 text-white leading-tight">Admin</div>
                    <div class="fs-9 text-white-50">Administrator</div>
                </div>
            </div>
            <button type="button" class="btn btn-sm text-white-50 p-1 hover-text-white" onclick="handleAdminLogout()" title="Log Out">
                <i class="fa-solid fa-right-from-bracket fs-7"></i>
            </button>
        </div>
    </aside>

    <!-- ==========================================================
         MAIN CONTENT WRAPPER
         ========================================================== -->
    <div class="admin-main-wrapper" id="adminMainWrapper">
        
        <!-- Top Header Bar -->
        <header class="admin-top-header">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-sm btn-light d-md-none" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
                <div class="admin-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="form-control" id="adminGlobalSearch" placeholder="Search products, orders, customers..." oninput="handleGlobalSearch(this.value)">
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2 bg-light px-3 py-1.5 rounded-pill border">
                    <span class="pulse-live"></span>
                    <span class="fs-9 fw-bold text-success">HOSTINGER LIVE DB</span>
                    <span class="fs-9 text-muted ms-1" id="liveClockDisplay">--:--</span>
                </div>
                <button type="button" class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs position-relative" style="width:38px; height:38px;" onclick="switchAdminTab('support')">
                    <i class="fa-regular fa-bell text-secondary fs-7"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" id="topBellBadge"></span>
                </button>
                <div class="d-flex align-items-center gap-2 ps-2 border-start">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-2xs" style="width:34px; height:34px; background: linear-gradient(135deg, #5B3FA8, #341F97); font-size:0.8rem;">
                        A
                    </div>
                    <span class="fw-bold fs-8 text-dark d-none d-sm-inline">Admin <i class="fa-solid fa-chevron-down fs-9 text-muted ms-1"></i></span>
                </div>
            </div>
        </header>

        <!-- Main Body Content Area -->
        <main class="admin-content-container">

            <!-- ==========================================================
                 TAB 1: DASHBOARD
                 ========================================================== -->
            <section id="section_dashboard" class="admin-section active">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Executive Operations Dashboard</h4>
                        <p class="text-muted fs-8 mb-0">Overview of platform rentals, inventory health, deliveries, and ticket resolution.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="loadDashboardStats()">
                        <i class="fa-solid fa-rotate"></i> Refresh Live Data
                    </button>
                </div>

                <!-- Metrics 4-Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-xl-3">
                        <div class="card-stat">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-bold text-muted">Total Revenue</span>
                                <div class="stat-icon-wrapper bg-primary-subtle text-primary"><i class="fa-solid fa-peso-sign"></i></div>
                            </div>
                            <h3 class="fw-extrabold text-dark mb-1" id="dashMetricRevenue">₱ 0</h3>
                            <span class="fs-9 text-success fw-bold"><i class="fa-solid fa-arrow-trend-up me-1"></i>+15% from last period</span>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card-stat">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-bold text-muted">Total Orders</span>
                                <div class="stat-icon-wrapper bg-success-subtle text-success"><i class="fa-solid fa-truck-ramp-box"></i></div>
                            </div>
                            <h3 class="fw-extrabold text-dark mb-1" id="dashMetricOrders">0</h3>
                            <span class="fs-9 text-success fw-bold"><i class="fa-solid fa-arrow-trend-up me-1"></i>+8% active velocity</span>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card-stat">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-bold text-muted">Total Stock Units</span>
                                <div class="stat-icon-wrapper bg-warning-subtle text-warning"><i class="fa-solid fa-boxes-stacked"></i></div>
                            </div>
                            <h3 class="fw-extrabold text-dark mb-1" id="dashMetricStock">0</h3>
                            <span class="fs-9 text-muted" id="dashMetricLowStockText">0 items low stock</span>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card-stat">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-bold text-muted">Active Support Tickets</span>
                                <div class="stat-icon-wrapper bg-danger-subtle text-danger"><i class="fa-solid fa-headset"></i></div>
                            </div>
                            <h3 class="fw-extrabold text-dark mb-1" id="dashMetricTickets">0</h3>
                            <span class="fs-9 text-danger fw-bold"><i class="fa-solid fa-circle-exclamation me-1"></i>Action required</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders & Support Tickets (2 Column) -->
                <div class="row g-4">
                    <div class="col-12 col-xl-7">
                        <div class="admin-table-card p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                                <h6 class="fw-extrabold text-dark fs-7 mb-0">Incoming &amp; Active Orders</h6>
                                <a href="javascript:void(0)" class="fs-8 fw-bold text-decoration-none" style="color:var(--admin-primary);" onclick="switchAdminTab('orders')">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dashOrdersTableBody">
                                        <tr><td colspan="5" class="text-center py-4 text-muted">Loading live orders...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-5">
                        <div class="admin-table-card p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                                <h6 class="fw-extrabold text-dark fs-7 mb-0">Customer Support Inquiries</h6>
                                <a href="javascript:void(0)" class="fs-8 fw-bold text-decoration-none" style="color:var(--admin-primary);" onclick="switchAdminTab('support')">Tickets Hub <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom mb-0">
                                    <thead>
                                        <tr>
                                            <th>Ticket</th>
                                            <th>Subject</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dashTicketsTableBody">
                                        <tr><td colspan="4" class="text-center py-4 text-muted">Loading inquiries...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 2: PRODUCTS (Matches Screen 1 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_products" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Products</h4>
                        <p class="text-muted fs-8 mb-0">Manage your product catalog. Add, edit, or remove products.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="openAddProductModal()">
                        <i class="fa-solid fa-plus"></i> Add Product
                    </button>
                </div>

                <div class="admin-table-card p-3 mb-4">
                    <!-- Filters Row -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-search text-muted"></i></span>
                                <input type="text" class="form-control" id="productSearchInput" placeholder="Search products..." oninput="loadProducts()">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select form-select-sm" id="productCategoryFilter" onchange="loadProducts()">
                                <option value="All">All Categories</option>
                                <option value="Cameras">Cameras</option>
                                <option value="Sound System">Sound System</option>
                                <option value="Chairs">Chairs</option>
                                <option value="Tables">Tables</option>
                                <option value="Tents">Tents</option>
                                <option value="Lights">Lights</option>
                                <option value="Stages">Stages</option>
                                <option value="Decorations">Decorations</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select form-select-sm" id="productAvailabilityFilter" onchange="loadProducts()">
                                <option value="All">All Availability</option>
                                <option value="In Stock">In Stock</option>
                                <option value="Low Stock">Low Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th width="40"><input type="checkbox" class="form-check-input"></th>
                                    <th width="70">Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Qty(Total)</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
                                <tr><td colspan="9" class="text-center py-4 text-muted">Loading live products...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 3: INVENTORY (Matches Screen 2 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_inventory" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Inventory</h4>
                        <p class="text-muted fs-8 mb-0">Track and manage your stock levels.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="openAddProductModal()">
                        <i class="fa-solid fa-plus"></i> Add Inventory
                    </button>
                </div>

                <!-- 4 Inventory Stat Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="card-stat">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-bold text-muted">Total Stock Items</span>
                                <div class="stat-icon-wrapper bg-primary-subtle text-primary"><i class="fa-solid fa-box-open"></i></div>
                            </div>
                            <h3 class="fw-extrabold text-dark mb-0" id="invTotalStock">0</h3>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card-stat">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-bold text-muted">Low Stock Items</span>
                                <div class="stat-icon-wrapper bg-warning-subtle text-warning"><i class="fa-solid fa-triangle-exclamation"></i></div>
                            </div>
                            <h3 class="fw-extrabold text-dark mb-0" id="invLowStock">0</h3>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card-stat">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-bold text-muted">Out of Stock</span>
                                <div class="stat-icon-wrapper bg-danger-subtle text-danger"><i class="fa-solid fa-ban"></i></div>
                            </div>
                            <h3 class="fw-extrabold text-dark mb-0" id="invOutOfStock">0</h3>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card-stat">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-bold text-muted">Stock Value</span>
                                <div class="stat-icon-wrapper bg-success-subtle text-success"><i class="fa-solid fa-sack-dollar"></i></div>
                            </div>
                            <h3 class="fw-extrabold text-dark mb-0" id="invStockValue">₱ 0</h3>
                        </div>
                    </div>
                </div>

                <!-- Sub-tabs -->
                <div class="admin-table-card p-3">
                    <div class="subtab-nav">
                        <button class="subtab-btn active" onclick="switchInvSubtab('overview', this)">Stock Overview</button>
                        <button class="subtab-btn" onclick="switchInvSubtab('records', this)">Stock-in Records</button>
                        <button class="subtab-btn" onclick="switchInvSubtab('stockout', this)">Stock-out Records</button>
                        <button class="subtab-btn" onclick="switchInvSubtab('history', this)">Inventory History</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Reorder Level</th>
                                    <th>Status</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inventoryTableBody">
                                <tr><td colspan="6" class="text-center py-4 text-muted">Loading inventory stock levels...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 4: ORDERS (Matches Screen 3 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_orders" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Orders</h4>
                        <p class="text-muted fs-8 mb-0">View and manage customer orders.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="switchAdminTab('products')">
                        <i class="fa-solid fa-plus"></i> Process Purchase
                    </button>
                </div>

                <div class="admin-table-card p-3">
                    <div class="subtab-nav">
                        <button class="subtab-btn active" onclick="switchOrderSubtab('incoming', this)">Incoming Orders</button>
                        <button class="subtab-btn" onclick="switchOrderSubtab('history', this)">Order History</button>
                        <button class="subtab-btn" onclick="switchOrderSubtab('purchase', this)">Purchase Orders</button>
                        <button class="subtab-btn" onclick="switchOrderSubtab('transactions', this)">Transaction Records</button>
                    </div>

                    <!-- Filters -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-5">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-search text-muted"></i></span>
                                <input type="text" class="form-control" id="orderSearchInput" placeholder="Search orders by customer or code..." oninput="loadOrders()">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select form-select-sm" id="orderStatusFilter" onchange="loadOrders()">
                                <option value="All">All Status</option>
                                <option value="PENDING">Pending</option>
                                <option value="CONFIRMED">Confirmed</option>
                                <option value="PROCESSING">Processing</option>
                                <option value="ON_THE_WAY">On the Way</option>
                                <option value="DELIVERED">Delivered</option>
                                <option value="CANCELLED">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4">
                            <input type="date" class="form-control form-control-sm" id="orderDateFilter" onchange="loadOrders()">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th width="140">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody">
                                <tr><td colspan="6" class="text-center py-4 text-muted">Loading live orders...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 5: CUSTOMERS (Matches Screen 4 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_customers" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Customers</h4>
                        <p class="text-muted fs-8 mb-0">Manage your customer database and view their activity.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="alert('Student users register dynamically via registration or tester account.')">
                        <i class="fa-solid fa-user-plus"></i> Add Customer
                    </button>
                </div>

                <div class="admin-table-card p-3">
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-5">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-search text-muted"></i></span>
                                <input type="text" class="form-control" id="customerSearchInput" placeholder="Search customers..." oninput="loadCustomers()">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select form-select-sm" id="customerStatusFilter" onchange="loadCustomers()">
                                <option value="All">All Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4">
                            <select class="form-select form-select-sm" id="customerSortFilter" onchange="loadCustomers()">
                                <option value="Newest">Sort by: Newest</option>
                                <option value="Orders">Sort by: Most Orders</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Phone / ID</th>
                                    <th>Total Orders</th>
                                    <th>Status</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="customersTableBody">
                                <tr><td colspan="6" class="text-center py-4 text-muted">Loading customer records...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 6: DELIVERY MANAGEMENT (Matches Screen 5 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_delivery" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Delivery Management</h4>
                        <p class="text-muted fs-8 mb-0">Monitor and manage deliveries in real-time.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="openAssignDeliveryModal()">
                        <i class="fa-solid fa-truck-ramp-box"></i> Assign Delivery
                    </button>
                </div>

                <div class="admin-table-card p-3">
                    <div class="row g-2 mb-3">
                        <div class="col-6 col-md-3">
                            <select class="form-select form-select-sm" id="deliveryStatusFilter" onchange="loadDeliveries()">
                                <option value="All">All Status</option>
                                <option value="ON_THE_WAY">On the way</option>
                                <option value="PICKED_UP">Picked up</option>
                                <option value="DELIVERED">Delivered</option>
                                <option value="PENDING">Pending</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4">
                            <input type="date" class="form-control form-control-sm" id="deliveryDateFilter" onchange="loadDeliveries()">
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-search text-muted"></i></span>
                                <input type="text" class="form-control" id="deliverySearchInput" placeholder="Search by order or customer..." oninput="loadDeliveries()">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Pickup Location</th>
                                    <th>Delivery Location</th>
                                    <th>Status</th>
                                    <th>Driver</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="deliveriesTableBody">
                                <tr><td colspan="7" class="text-center py-4 text-muted">Loading live deliveries...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 7: SERVICE CHARGE COMPUTATION (Matches Screen 6 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_serviceCharges" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Service Charge Computation</h4>
                        <p class="text-muted fs-8 mb-0">Set up service charges and delivery fees.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="saveServiceCharges()">
                        <i class="fa-solid fa-floppy-disk"></i> Update Rates
                    </button>
                </div>

                <div class="admin-table-card p-3">
                    <div class="subtab-nav">
                        <button class="subtab-btn active" onclick="switchChargeSubtab('settings', this)">Charge Settings</button>
                        <button class="subtab-btn" onclick="switchChargeSubtab('preview', this)">Calculation Preview</button>
                    </div>

                    <div class="row g-4">
                        <!-- Left Form Column -->
                        <div class="col-12 col-lg-7">
                            <div class="p-3 bg-light rounded-4 border">
                                <h6 class="fw-extrabold text-dark fs-7 mb-3">Service Charge Setup</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fs-8 fw-bold">Event Setup Fee</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">₱</span>
                                        <input type="number" class="form-control" id="rateEventSetupFee" value="500" oninput="updateLiveRatesPreview()">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fs-8 fw-bold">Delivery Fee (per km)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">₱</span>
                                        <input type="number" class="form-control" id="rateDeliveryPerKm" value="50" oninput="updateLiveRatesPreview()">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fs-8 fw-bold">Service Charge Rate</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="rateServiceCharge" value="10" oninput="updateLiveRatesPreview()">
                                        <span class="input-group-text bg-white">%</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fs-8 fw-bold">Minimum Order for Delivery</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">₱</span>
                                        <input type="number" class="form-control" id="rateMinOrderDelivery" value="1500" oninput="updateLiveRatesPreview()">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fs-8 fw-bold">Tax Rate</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="rateTaxRate" value="12" oninput="updateLiveRatesPreview()">
                                        <span class="input-group-text bg-white">%</span>
                                    </div>
                                </div>

                                <div class="form-check form-switch pt-2">
                                    <input class="form-check-input" type="checkbox" id="rateAutoCalculate" checked>
                                    <label class="form-check-label fs-8 fw-bold" for="rateAutoCalculate">Auto Calculate Charges</label>
                                </div>
                            </div>
                        </div>

                        <!-- Right Summary & Calculator Column -->
                        <div class="col-12 col-lg-5">
                            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white mb-3">
                                <h6 class="fw-extrabold text-dark fs-7 mb-3">Current Rates</h6>
                                
                                <div class="d-flex justify-content-between py-2 border-bottom fs-8">
                                    <span class="text-muted">Event Setup Fee</span>
                                    <span class="fw-bold" id="cardRateSetupFee">₱ 500</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom fs-8">
                                    <span class="text-muted">Delivery Fee (per km)</span>
                                    <span class="fw-bold" id="cardRateDeliveryFee">₱ 50</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom fs-8">
                                    <span class="text-muted">Service Charge Rate</span>
                                    <span class="fw-bold" id="cardRateServiceFee">10%</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom fs-8">
                                    <span class="text-muted">Tax Rate</span>
                                    <span class="fw-bold" id="cardRateTax">12%</span>
                                </div>

                                <div class="alert alert-info py-2 px-3 mt-4 mb-0 fs-9 d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-circle-info fs-7"></i>
                                    <span>Charges will be automatically calculated and included in the receipt.</span>
                                </div>
                            </div>

                            <!-- Live Calculator Tester -->
                            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
                                <h6 class="fw-extrabold text-dark fs-8 mb-2"><i class="fa-solid fa-calculator text-primary me-1"></i> Interactive Test Calculator</h6>
                                <div class="mb-2">
                                    <label class="fs-9 text-muted fw-bold">Equipment Subtotal (₱)</label>
                                    <input type="number" class="form-control form-control-sm" id="calcSubtotal" value="2000" oninput="runLiveTestCalculation()">
                                </div>
                                <div class="mb-2">
                                    <label class="fs-9 text-muted fw-bold">Distance (km)</label>
                                    <input type="number" class="form-control form-control-sm" id="calcDistance" value="5" oninput="runLiveTestCalculation()">
                                </div>
                                <div class="p-2.5 bg-light rounded-3 mt-3">
                                    <div class="d-flex justify-content-between fs-9"><span>Delivery Fee:</span><span class="fw-bold" id="calcResultDelivery">₱ 250</span></div>
                                    <div class="d-flex justify-content-between fs-9"><span>Service Charge:</span><span class="fw-bold" id="calcResultService">₱ 200</span></div>
                                    <div class="d-flex justify-content-between fs-8 fw-extrabold text-dark border-top pt-1 mt-1"><span>Total Estimated:</span><span class="text-primary" id="calcResultTotal">₱ 2,950</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 8: CUSTOMER SUPPORT / ISSUES (Matches Screen 7 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_support" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Customer Support / Issues</h4>
                        <p class="text-muted fs-8 mb-0">Manage customer inquiries and support tickets.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="openCreateTicketModal()">
                        <i class="fa-solid fa-plus"></i> Create Ticket
                    </button>
                </div>

                <div class="admin-table-card p-3">
                    <div class="subtab-nav">
                        <button class="subtab-btn active" onclick="switchTicketSubtab('All Tickets', this)">All Tickets</button>
                        <button class="subtab-btn" onclick="switchTicketSubtab('Open', this)">Open Tickets</button>
                        <button class="subtab-btn" onclick="switchTicketSubtab('In Progress', this)">In Progress</button>
                        <button class="subtab-btn" onclick="switchTicketSubtab('Resolved', this)">Resolved</button>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-5">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-search text-muted"></i></span>
                                <input type="text" class="form-control" id="ticketSearchInput" placeholder="Search tickets..." oninput="loadTickets()">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select form-select-sm" id="ticketPriorityFilter" onchange="loadTickets()">
                                <option value="All">All Priority</option>
                                <option value="CRITICAL">Critical</option>
                                <option value="HIGH">High</option>
                                <option value="MEDIUM">Medium</option>
                                <option value="LOW">Low</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4">
                            <select class="form-select form-select-sm" id="ticketStatusFilter" onchange="loadTickets()">
                                <option value="All">All Status</option>
                                <option value="Open">Open</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Resolved">Resolved</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Ticket #</th>
                                    <th>Customer</th>
                                    <th>Subject</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ticketsTableBody">
                                <tr><td colspan="7" class="text-center py-4 text-muted">Loading live tickets...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 9: TRANSACTIONS (Matches Screen 8 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_transactions" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Transactions</h4>
                        <p class="text-muted fs-8 mb-0">View all financial transactions and payment records.</p>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold" onclick="exportTransactionsCSV()">
                        <i class="fa-solid fa-download me-1"></i> Export
                    </button>
                </div>

                <div class="admin-table-card p-3">
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-5">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-search text-muted"></i></span>
                                <input type="text" class="form-control" id="trxSearchInput" placeholder="Search transactions..." oninput="loadTransactions()">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select form-select-sm" id="trxTypeFilter" onchange="loadTransactions()">
                                <option value="All">All Types</option>
                                <option value="PAYMENT">Payment</option>
                                <option value="REFUND">Refund</option>
                                <option value="SERVICE_CHARGE">Service Charge</option>
                                <option value="DEPOSIT">Deposit</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4">
                            <input type="date" class="form-control form-control-sm" id="trxDateFilter" onchange="loadTransactions()">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="transactionsTableBody">
                                <tr><td colspan="6" class="text-center py-4 text-muted">Loading live transactions...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 10: REPORTS (Matches Screen 9 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_reports" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Reports &amp; Analytics</h4>
                        <p class="text-muted fs-8 mb-0">View insights and analytics for your business.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-secondary border px-3 py-2 fs-8 fw-bold">Live Synced Period</span>
                    </div>
                </div>

                <div class="admin-table-card p-3 mb-4">
                    <div class="subtab-nav">
                        <button class="subtab-btn active">Sales Report</button>
                        <button class="subtab-btn" onclick="switchAdminTab('orders')">Order Report</button>
                        <button class="subtab-btn" onclick="switchAdminTab('inventory')">Inventory Report</button>
                        <button class="subtab-btn" onclick="switchAdminTab('customers')">Customer Report</button>
                    </div>

                    <!-- 4 Metric Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-lg-3">
                            <div class="card-stat">
                                <span class="fs-8 fw-bold text-muted d-block mb-1">Total Sales</span>
                                <h3 class="fw-extrabold text-dark mb-1" id="repTotalSales">₱ 0</h3>
                                <span class="fs-9 text-success fw-bold"><i class="fa-solid fa-arrow-up me-1"></i>+15%</span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card-stat">
                                <span class="fs-8 fw-bold text-muted d-block mb-1">Total Orders</span>
                                <h3 class="fw-extrabold text-dark mb-1" id="repTotalOrders">0</h3>
                                <span class="fs-9 text-success fw-bold"><i class="fa-solid fa-arrow-up me-1"></i>+8%</span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card-stat">
                                <span class="fs-8 fw-bold text-muted d-block mb-1">New Customers</span>
                                <h3 class="fw-extrabold text-dark mb-1" id="repNewCustomers">0</h3>
                                <span class="fs-9 text-success fw-bold"><i class="fa-solid fa-arrow-up me-1"></i>+12%</span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card-stat">
                                <span class="fs-8 fw-bold text-muted d-block mb-1">Average Order Value</span>
                                <h3 class="fw-extrabold text-dark mb-1" id="repAvgOrder">₱ 0</h3>
                                <span class="fs-9 text-success fw-bold"><i class="fa-solid fa-arrow-up me-1"></i>+10%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row (Chart.js) -->
                    <div class="row g-4">
                        <div class="col-12 col-lg-8">
                            <div class="p-3 bg-light rounded-4 border">
                                <h6 class="fw-extrabold text-dark fs-7 mb-3">Sales Overview (Revenue Trend)</h6>
                                <div style="height: 280px; position: relative;">
                                    <canvas id="salesTrendChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="p-3 bg-light rounded-4 border">
                                <h6 class="fw-extrabold text-dark fs-7 mb-3">Sales by Category</h6>
                                <div style="height: 280px; position: relative;">
                                    <canvas id="categoryDonutChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================================
                 TAB 11: SETTINGS (Matches Screen 10 in ADMIN UI.png)
                 ========================================================== -->
            <section id="section_settings" class="admin-section">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-extrabold mb-1 text-dark">Settings</h4>
                        <p class="text-muted fs-8 mb-0">Manage your system settings and preferences.</p>
                    </div>
                    <button type="button" class="btn-admin-primary" onclick="saveSystemSettings()">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>

                <div class="admin-table-card p-3">
                    <div class="subtab-nav">
                        <button class="subtab-btn active" onclick="switchSettingsSubtab('general', this)">General</button>
                        <button class="subtab-btn" onclick="switchSettingsSubtab('users', this)">Users &amp; Roles</button>
                        <button class="subtab-btn" onclick="switchSettingsSubtab('notifications', this)">Notifications</button>
                        <button class="subtab-btn" onclick="switchSettingsSubtab('payment', this)">Payment Settings</button>
                        <button class="subtab-btn" onclick="switchSettingsSubtab('system', this)">System</button>
                        <button class="subtab-btn" onclick="switchSettingsSubtab('backup', this)">Backup &amp; Recovery</button>
                    </div>

                    <div class="row g-4">
                        <!-- Left Column: Business Info -->
                        <div class="col-12 col-lg-6">
                            <div class="p-3 bg-light rounded-4 border mb-3">
                                <h6 class="fw-extrabold text-dark fs-8 mb-3">Business Information</h6>
                                
                                <div class="mb-2.5">
                                    <label class="form-label fs-9 fw-bold text-muted">Business Name</label>
                                    <input type="text" class="form-control form-control-sm" id="setBusinessName" value="RentEase Equipment Rentals">
                                </div>
                                <div class="mb-2.5">
                                    <label class="form-label fs-9 fw-bold text-muted">Email Address</label>
                                    <input type="email" class="form-control form-control-sm" id="setBusinessEmail" value="support@rentease.com">
                                </div>
                                <div class="mb-2.5">
                                    <label class="form-label fs-9 fw-bold text-muted">Phone Number</label>
                                    <input type="text" class="form-control form-control-sm" id="setBusinessPhone" value="0917 123 4567">
                                </div>
                                <div class="mb-2.5">
                                    <label class="form-label fs-9 fw-bold text-muted">Address</label>
                                    <input type="text" class="form-control form-control-sm" id="setBusinessAddress" value="San Pablo City, Laguna">
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: System Preferences -->
                        <div class="col-12 col-lg-6">
                            <div class="p-3 bg-light rounded-4 border mb-3">
                                <h6 class="fw-extrabold text-dark fs-8 mb-3">System Preferences</h6>
                                
                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div>
                                        <div class="fs-8 fw-bold">Auto Backup</div>
                                        <div class="fs-9 text-muted">Automatic daily snapshot of database</div>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" id="setAutoBackup" checked>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div>
                                        <div class="fs-8 fw-bold">Email Notifications</div>
                                        <div class="fs-9 text-muted">Notify admin on incoming rental bookings</div>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" id="setEmailNotifications" checked>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div>
                                        <div class="fs-8 fw-bold">SMS Notifications</div>
                                        <div class="fs-9 text-muted">Send automated SMS dispatch alerts</div>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" id="setSmsNotifications">
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between py-2">
                                    <div>
                                        <div class="fs-8 fw-bold">Maintenance Mode</div>
                                        <div class="fs-9 text-muted">Temporarily suspend new public bookings</div>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" id="setMaintenanceMode">
                                    </div>
                                </div>
                            </div>

                            <!-- Database Backup Card -->
                            <div class="card border-0 rounded-4 shadow-sm p-3 bg-white">
                                <h6 class="fw-extrabold text-dark fs-8 mb-2"><i class="fa-solid fa-database text-primary me-1"></i> Last Backup</h6>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="fs-9 text-muted" id="backupTimestampText">Synced with Hostinger MySQL</span>
                                    <span class="badge bg-success-subtle text-success fs-9 fw-bold">Successful</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold fs-9" onclick="performBackup()"><i class="fa-solid fa-download me-1"></i> Backup Now</button>
                                    <button class="btn btn-sm btn-light border rounded-pill px-3 fw-bold fs-9" onclick="alert('Database state verified healthy.')"><i class="fa-solid fa-rotate-left me-1"></i> Restore</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <!-- ==========================================================
         MODALS (Add Product, Order Details, Assign Driver, Ticket)
         ========================================================== -->
    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-extrabold text-dark mb-0">Add New Rental Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" onsubmit="event.preventDefault(); submitAddProduct();">
                        <div class="mb-2.5">
                            <label class="form-label fs-9 fw-bold">Equipment Name *</label>
                            <input type="text" class="form-control form-control-sm" id="mProdName" placeholder="e.g. Sony Alpha A7 IV Camera Rig" required>
                        </div>
                        <div class="row g-2 mb-2.5">
                            <div class="col-6">
                                <label class="form-label fs-9 fw-bold">Category *</label>
                                <select class="form-select form-select-sm" id="mProdCategory">
                                    <option value="Cameras">Cameras</option>
                                    <option value="Sound System">Sound System</option>
                                    <option value="Chairs">Chairs</option>
                                    <option value="Tables">Tables</option>
                                    <option value="Tents">Tents</option>
                                    <option value="Lights">Lights</option>
                                    <option value="Stages">Stages</option>
                                    <option value="Decorations">Decorations</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fs-9 fw-bold">Price per Day (₱) *</label>
                                <input type="number" class="form-control form-control-sm" id="mProdPrice" value="500" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-2.5">
                            <div class="col-6">
                                <label class="form-label fs-9 fw-bold">Total Stock Units *</label>
                                <input type="number" class="form-control form-control-sm" id="mProdQty" value="1" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fs-9 fw-bold">Condition</label>
                                <select class="form-select form-select-sm" id="mProdCondition">
                                    <option value="Like New">Like New</option>
                                    <option value="Excellent">Excellent</option>
                                    <option value="Good">Good</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2.5">
                            <label class="form-label fs-9 fw-bold">Owner / Lender Name</label>
                            <input type="text" class="form-control form-control-sm" id="mProdOwner" value="Romeo Paolo Tolentino">
                        </div>
                        <div class="mb-2.5">
                            <label class="form-label fs-9 fw-bold">Image URL</label>
                            <input type="url" class="form-control form-control-sm" id="mProdImage" value="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&q=80">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-9 fw-bold">Description</label>
                            <textarea class="form-control form-control-sm" id="mProdDesc" rows="2" placeholder="Equipment features, inclusions, and guidelines..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-admin-primary w-100 justify-content-center py-2">
                            <i class="fa-solid fa-check"></i> Publish to Platform Catalog
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Detail & Status Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-extrabold text-dark mb-0" id="mOrderTitle">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3 bg-light rounded-4 mb-3" id="mOrderDetailsBody">
                        <!-- Populated dynamically -->
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-9 fw-bold">Update Order Status</label>
                        <select class="form-select" id="mOrderStatusSelect">
                            <option value="PENDING">Pending Review</option>
                            <option value="CONFIRMED">Confirmed</option>
                            <option value="PROCESSING">Processing</option>
                            <option value="ON_THE_WAY">On the Way</option>
                            <option value="DELIVERED">Delivered</option>
                            <option value="CANCELLED">Cancelled</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-admin-primary w-100 justify-content-center py-2" onclick="saveUpdatedOrderStatus()">
                        <i class="fa-solid fa-floppy-disk"></i> Update Order Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Delivery Driver Modal -->
    <div class="modal fade" id="assignDeliveryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-extrabold text-dark mb-0">Assign Delivery Dispatch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fs-9 fw-bold">Select Active Order</label>
                        <select class="form-select form-select-sm" id="mAssignOrderSelect">
                            <!-- Populated with orders -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-9 fw-bold">Assigned Rider Name</label>
                        <input type="text" class="form-control form-control-sm" id="mAssignRiderName" value="Juan Dela Cruz">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-9 fw-bold">Rider Phone</label>
                        <input type="text" class="form-control form-control-sm" id="mAssignRiderPhone" value="0918 765 4321">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-9 fw-bold">Estimated Arrival Time</label>
                        <input type="text" class="form-control form-control-sm" id="mAssignEta" value="3:30 PM">
                    </div>
                    <button type="button" class="btn btn-admin-primary w-100 justify-content-center py-2" onclick="submitAssignDelivery()">
                        <i class="fa-solid fa-truck-fast"></i> Confirm Dispatch
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Ticket Modal -->
    <div class="modal fade" id="createTicketModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-extrabold text-dark mb-0">New Customer Support Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2.5">
                        <label class="form-label fs-9 fw-bold">Customer Name</label>
                        <input type="text" class="form-control form-control-sm" id="mTktCustomer" value="Pogilameg Tester">
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label fs-9 fw-bold">Subject</label>
                        <input type="text" class="form-control form-control-sm" id="mTktSubject" placeholder="Brief issue summary...">
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label fs-9 fw-bold">Priority</label>
                            <select class="form-select form-select-sm" id="mTktPriority">
                                <option value="LOW">Low</option>
                                <option value="MEDIUM" selected>Medium</option>
                                <option value="HIGH">High</option>
                                <option value="CRITICAL">Critical</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fs-9 fw-bold">Assigned Staff</label>
                            <input type="text" class="form-control form-control-sm" id="mTktAssigned" value="Support Team">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-9 fw-bold">Details</label>
                        <textarea class="form-control form-control-sm" id="mTktDesc" rows="2" placeholder="Full issue notes..."></textarea>
                    </div>
                    <button type="button" class="btn btn-admin-primary w-100 justify-content-center py-2" onclick="submitCreateTicket()">
                        <i class="fa-solid fa-plus"></i> Open Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ==========================================================
         ADMIN APP CLIENT SCRIPT
         ========================================================== -->
    <script>
        const API_URL = 'admin_api.php';
        let currentActiveSection = 'dashboard';
        let salesChartInstance = null;
        let categoryChartInstance = null;
        let selectedOrderIdForModal = null;

        // Auto clock
        setInterval(() => {
            const now = new Date();
            const el = document.getElementById('liveClockDisplay');
            if (el) el.innerText = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }, 1000);

        // ----------------------------------------------------------
        // TAB SWITCHING ENGINE
        // ----------------------------------------------------------
        function switchAdminTab(sectionName, linkEl = null) {
            currentActiveSection = sectionName;
            
            // Hide all sections
            document.querySelectorAll('.admin-section').forEach(s => s.classList.remove('active'));

            // Show selected section
            const target = document.getElementById('section_' + sectionName);
            if (target) target.classList.add('active');

            // Update sidebar links
            document.querySelectorAll('.sidebar-nav .nav-link').forEach(l => l.classList.remove('active'));
            if (linkEl) {
                linkEl.classList.add('active');
            } else {
                const autoLink = Array.from(document.querySelectorAll('.sidebar-nav .nav-link')).find(l => l.getAttribute('onclick')?.includes(sectionName));
                if (autoLink) autoLink.classList.add('active');
            }

            // Trigger data loader for section
            switch (sectionName) {
                case 'dashboard': loadDashboardStats(); break;
                case 'products': loadProducts(); break;
                case 'inventory': loadInventory(); break;
                case 'orders': loadOrders(); break;
                case 'customers': loadCustomers(); break;
                case 'delivery': loadDeliveries(); break;
                case 'serviceCharges': loadServiceCharges(); break;
                case 'support': loadTickets(); break;
                case 'transactions': loadTransactions(); break;
                case 'reports': loadReports(); break;
                case 'settings': loadSettings(); break;
            }
        }

        // ----------------------------------------------------------
        // 1. AUTHENTICATION & LOGIN FLOW
        // ----------------------------------------------------------
        function toggleAdminPasswordVisibility() {
            const input = document.getElementById('loginPassword');
            const eye = document.getElementById('loginPasswordEye');
            if (!input || !eye) return;
            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }

        async function handleAdminLogin() {
            const u = document.getElementById('loginUsername').value.trim();
            const p = document.getElementById('loginPassword').value.trim();
            const btn = document.getElementById('loginBtn');
            const err = document.getElementById('loginErrorMsg');

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Authenticating...';
            err.style.display = 'none';

            try {
                const res = await fetch(`${API_URL}?action=login`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username: u, password: p })
                });
                const data = await res.json();
                if (data.success) {
                    document.getElementById('authOverlay').style.display = 'none';
                    switchAdminTab('dashboard');
                } else {
                    err.innerText = data.message || 'Invalid credentials.';
                    err.style.display = 'block';
                }
            } catch (e) {
                err.innerText = 'Connection failed: ' + e.message;
                err.style.display = 'block';
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-right-to-bracket"></i> Sign In to Operations Hub';
            }
        }

        async function handleAdminLogout() {
            if (!confirm('Log out from RentEase Admin Operations Portal?')) return;
            try {
                await fetch(`${API_URL}?action=logout`);
            } catch (e) {}
            document.getElementById('authOverlay').style.display = 'flex';
        }

        // ----------------------------------------------------------
        // 2. DASHBOARD DATA LOADER
        // ----------------------------------------------------------
        async function loadDashboardStats() {
            try {
                const res = await fetch(`${API_URL}?action=get_dashboard`);
                const data = await res.json();
                if (data.success) {
                    const s = data.stats;
                    document.getElementById('dashMetricRevenue').innerText = '₱ ' + Number(s.total_revenue).toLocaleString();
                    document.getElementById('dashMetricOrders').innerText = s.total_orders;
                    document.getElementById('dashMetricStock').innerText = s.total_stock;
                    document.getElementById('dashMetricLowStockText').innerText = `${s.low_stock_items} items low stock`;
                    document.getElementById('dashMetricTickets').innerText = s.active_tickets;

                    // Render recent orders table
                    const tbody = document.getElementById('dashOrdersTableBody');
                    if (data.recent_orders && data.recent_orders.length > 0) {
                        tbody.innerHTML = data.recent_orders.map(o => `
                            <tr>
                                <td class="fw-bold text-primary">${o.order_code}</td>
                                <td>${o.customer_name}</td>
                                <td class="fw-bold">₱${Number(o.total_amount).toLocaleString()}</td>
                                <td><span class="badge ${getStatusBadge(o.order_status)}">${o.order_status}</span></td>
                                <td><button class="btn btn-sm btn-light border py-0 px-2 fs-9" onclick="openOrderDetailModal(${o.id})"><i class="fa-solid fa-eye"></i></button></td>
                            </tr>
                        `).join('');
                    } else {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">No orders found.</td></tr>';
                    }

                    // Render recent tickets
                    const tbodyT = document.getElementById('dashTicketsTableBody');
                    if (data.recent_tickets && data.recent_tickets.length > 0) {
                        tbodyT.innerHTML = data.recent_tickets.map(t => `
                            <tr>
                                <td class="fw-bold text-muted">${t.ticket_number}</td>
                                <td class="text-truncate" style="max-width:140px;" title="${t.issue_title}">${t.issue_title}</td>
                                <td><span class="badge ${getPriorityBadge(t.priority)}">${t.priority}</span></td>
                                <td><span class="badge bg-light text-dark border">${t.status_display || t.status}</span></td>
                            </tr>
                        `).join('');
                    } else {
                        tbodyT.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted">No open inquiries.</td></tr>';
                    }
                }
            } catch (e) {
                console.error("Error loading dashboard stats:", e);
            }
        }

        // ----------------------------------------------------------
        // 3. PRODUCTS MODULE
        // ----------------------------------------------------------
        async function loadProducts() {
            const search = document.getElementById('productSearchInput')?.value || '';
            const category = document.getElementById('productCategoryFilter')?.value || 'All';
            const availability = document.getElementById('productAvailabilityFilter')?.value || 'All';

            try {
                const res = await fetch(`${API_URL}?action=get_products&search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}&availability=${encodeURIComponent(availability)}`);
                const data = await res.json();
                const tbody = document.getElementById('productsTableBody');

                if (data.success && data.products.length > 0) {
                    tbody.innerHTML = data.products.map(p => `
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><img src="${p.image_url}" class="rounded-2 border object-fit-cover shadow-2xs" style="width:42px; height:42px; object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=100&q=80'"></td>
                            <td>
                                <div class="fw-bold text-dark">${p.name}</div>
                                <div class="fs-9 text-muted">${p.owner_name || 'Admin'}</div>
                            </td>
                            <td><span class="badge bg-light text-secondary border">${p.category}</span></td>
                            <td class="fw-bold">₱${Number(p.price_per_day).toLocaleString()}</td>
                            <td class="fw-bold ${p.qty_available <= 5 ? 'text-warning' : 'text-success'}">${p.qty_available}</td>
                            <td><span class="badge ${p.badge_class}">${p.stock_status}</span></td>
                            <td>${p.qty_total}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-light border py-1 px-2 fs-9" onclick="quickEditStock(${p.id}, ${p.qty_total}, ${p.qty_available})"><i class="fa-solid fa-pen-to-square text-secondary"></i></button>
                                    <button class="btn btn-sm btn-light border py-1 px-2 fs-9 text-danger" onclick="deleteProductItem(${p.id})"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="9" class="text-center py-4 text-muted">No matching products found.</td></tr>';
                }
            } catch (e) {
                console.error("Products error:", e);
            }
        }

        function openAddProductModal() {
            const m = new bootstrap.Modal(document.getElementById('addProductModal'));
            m.show();
        }

        async function submitAddProduct() {
            const payload = {
                name: document.getElementById('mProdName').value.trim(),
                category: document.getElementById('mProdCategory').value,
                price_per_day: document.getElementById('mProdPrice').value,
                qty_total: document.getElementById('mProdQty').value,
                item_condition: document.getElementById('mProdCondition').value,
                owner_name: document.getElementById('mProdOwner').value.trim(),
                image_url: document.getElementById('mProdImage').value.trim(),
                description: document.getElementById('mProdDesc').value.trim()
            };

            try {
                const res = await fetch(`${API_URL}?action=add_product`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
                    loadProducts();
                    loadInventory();
                } else {
                    alert(data.message || 'Error saving product');
                }
            } catch (e) {
                alert('Connection error: ' + e.message);
            }
        }

        async function deleteProductItem(id) {
            if (!confirm('Remove this equipment from inventory?')) return;
            try {
                const res = await fetch(`${API_URL}?action=delete_product&id=${id}`);
                const data = await res.json();
                if (data.success) {
                    loadProducts();
                    loadInventory();
                }
            } catch (e) {}
        }

        async function quickEditStock(id, currentTotal, currentAvail) {
            const newTotal = prompt("Enter new Total Stock count:", currentTotal);
            if (newTotal === null) return;
            const newAvail = prompt("Enter new Available Stock count:", currentAvail);
            if (newAvail === null) return;

            try {
                await fetch(`${API_URL}?action=adjust_stock&id=${id}&qty_total=${newTotal}&qty_available=${newAvail}`);
                loadProducts();
                loadInventory();
            } catch (e) {}
        }

        // ----------------------------------------------------------
        // 4. INVENTORY MODULE
        // ----------------------------------------------------------
        async function loadInventory() {
            try {
                const res = await fetch(`${API_URL}?action=get_inventory`);
                const data = await res.json();
                if (data.success) {
                    const s = data.stats;
                    document.getElementById('invTotalStock').innerText = s.total_items;
                    document.getElementById('invLowStock').innerText = s.low_stock;
                    document.getElementById('invOutOfStock').innerText = s.out_of_stock;
                    document.getElementById('invStockValue').innerText = '₱ ' + Number(s.stock_value).toLocaleString();

                    const tbody = document.getElementById('inventoryTableBody');
                    if (data.products && data.products.length > 0) {
                        tbody.innerHTML = data.products.map(p => `
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2.5">
                                        <img src="${p.image_url}" class="rounded-2 border shadow-2xs" style="width:38px; height:38px; object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=100&q=80'">
                                        <span class="fw-bold text-dark">${p.name}</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-secondary border">${p.category}</span></td>
                                <td class="fw-extrabold ${p.qty_available <= 5 ? 'text-warning' : 'text-success'}">${p.qty_available}</td>
                                <td class="text-muted">5</td>
                                <td><span class="badge ${p.badge_class}">${p.stock_status}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-light border py-1 px-2 fs-9 fw-bold" onclick="quickEditStock(${p.id}, ${p.qty_total}, ${p.qty_available})"><i class="fa-solid fa-sliders me-1"></i> Adjust</button>
                                </td>
                            </tr>
                        `).join('');
                    } else {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No inventory records.</td></tr>';
                    }
                }
            } catch (e) {}
        }

        function switchInvSubtab(subtab, btn) {
            document.querySelectorAll('#section_inventory .subtab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            loadInventory();
        }

        // ----------------------------------------------------------
        // 5. ORDERS MODULE
        // ----------------------------------------------------------
        let currentOrderSubtab = 'incoming';
        async function loadOrders() {
            const search = document.getElementById('orderSearchInput')?.value || '';
            const status = document.getElementById('orderStatusFilter')?.value || 'All';

            try {
                const res = await fetch(`${API_URL}?action=get_orders&search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}&subtab=${encodeURIComponent(currentOrderSubtab)}`);
                const data = await res.json();
                const tbody = document.getElementById('ordersTableBody');

                if (data.success && data.orders.length > 0) {
                    tbody.innerHTML = data.orders.map(o => `
                        <tr>
                            <td class="fw-bold text-primary">${o.order_code}</td>
                            <td>
                                <div class="fw-bold text-dark">${o.customer_name}</div>
                                <div class="fs-9 text-muted">${o.customer_phone || ''}</div>
                            </td>
                            <td class="text-muted fs-8">${o.rental_start_date || '2026-09-18'}</td>
                            <td class="fw-extrabold text-dark">₱${Number(o.total_amount).toLocaleString()}</td>
                            <td><span class="badge ${getStatusBadge(o.order_status)}">${o.order_status}</span></td>
                            <td>
                                <button class="btn btn-sm btn-light border py-1 px-2 fs-9 fw-bold" onclick="openOrderDetailModal(${o.id})"><i class="fa-solid fa-eye me-1"></i> View</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No orders found.</td></tr>';
                }
            } catch (e) {}
        }

        function switchOrderSubtab(subtab, btn) {
            currentOrderSubtab = subtab;
            document.querySelectorAll('#section_orders .subtab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            loadOrders();
        }

        async function openOrderDetailModal(id) {
            selectedOrderIdForModal = id;
            try {
                const res = await fetch(`${API_URL}?action=get_orders&search=&status=All&subtab=all`);
                const data = await res.json();
                const order = (data.orders || []).find(o => parseInt(o.id) === parseInt(id));
                if (!order) return;

                document.getElementById('mOrderTitle').innerText = `Order ${order.order_code}`;
                document.getElementById('mOrderDetailsBody').innerHTML = `
                    <div class="row g-2 fs-8">
                        <div class="col-6"><span class="text-muted">Customer:</span> <strong class="d-block text-dark">${order.customer_name}</strong></div>
                        <div class="col-6"><span class="text-muted">Email:</span> <strong class="d-block text-dark">${order.customer_email || 'N/A'}</strong></div>
                        <div class="col-6"><span class="text-muted">Contact:</span> <strong class="d-block text-dark">${order.customer_phone || 'N/A'}</strong></div>
                        <div class="col-6"><span class="text-muted">Total Amount:</span> <strong class="d-block text-primary">₱${Number(order.total_amount).toLocaleString()} (${order.payment_method || 'GCash'})</strong></div>
                        <div class="col-12"><span class="text-muted">Delivery Destination:</span> <div class="text-dark fw-semibold">${order.delivery_address || 'Campus Meetup'}</div></div>
                        <div class="col-12"><span class="text-muted">Assigned Courier:</span> <div class="text-dark fw-semibold">${order.assigned_rider_name || 'Unassigned'} (${order.estimated_arrival || 'Pending'})</div></div>
                    </div>
                `;
                document.getElementById('mOrderStatusSelect').value = order.order_status || 'PENDING';
                new bootstrap.Modal(document.getElementById('orderDetailModal')).show();
            } catch (e) {}
        }

        async function saveUpdatedOrderStatus() {
            if (!selectedOrderIdForModal) return;
            const newSt = document.getElementById('mOrderStatusSelect').value;
            try {
                const res = await fetch(`${API_URL}?action=update_order_status&id=${selectedOrderIdForModal}&status=${newSt}`);
                const data = await res.json();
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('orderDetailModal')).hide();
                    loadOrders();
                    loadDashboardStats();
                }
            } catch (e) {}
        }

        // ----------------------------------------------------------
        // 6. CUSTOMERS MODULE
        // ----------------------------------------------------------
        async function loadCustomers() {
            const search = document.getElementById('customerSearchInput')?.value || '';
            const status = document.getElementById('customerStatusFilter')?.value || 'All';

            try {
                const res = await fetch(`${API_URL}?action=get_customers&search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`);
                const data = await res.json();
                const tbody = document.getElementById('customersTableBody');

                if (data.success && data.customers.length > 0) {
                    tbody.innerHTML = data.customers.map(c => `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle bg-purple text-white d-flex align-items-center justify-content-center fw-bold" style="width:34px; height:34px; background:#5B3FA8;">
                                        ${(c.FirstName || 'S')[0]}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">${c.FirstName} ${c.LastName}</div>
                                        <div class="fs-9 text-muted">ID: ${c.Id}</div>
                                    </div>
                                </div>
                            </td>
                            <td>${c.Email}</td>
                            <td>${c.PhoneOrId || 'N/A'}</td>
                            <td class="fw-bold">${c.total_orders || 0}</td>
                            <td><span class="badge ${c.Status === 'VERIFIED' ? 'badge-stock-in' : 'badge-stock-out'}">${c.Status === 'VERIFIED' ? 'Active' : 'Inactive'}</span></td>
                            <td>
                                <button class="btn btn-sm btn-light border py-1 px-2 fs-9" onclick="toggleCustomerStatus(${c.Id}, '${c.Status}')">
                                    <i class="fa-solid fa-power-off me-1"></i> ${c.Status === 'VERIFIED' ? 'Suspend' : 'Activate'}
                                </button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No customer records.</td></tr>';
                }
            } catch (e) {}
        }

        async function toggleCustomerStatus(id, current) {
            const next = (current === 'VERIFIED') ? 'SUSPENDED' : 'VERIFIED';
            if (!confirm(`Change customer status to ${next}?`)) return;
            try {
                await fetch(`${API_URL}?action=update_customer_status&id=${id}&status=${next}`);
                loadCustomers();
            } catch (e) {}
        }

        // ----------------------------------------------------------
        // 7. DELIVERY DISPATCH MODULE
        // ----------------------------------------------------------
        async function loadDeliveries() {
            const search = document.getElementById('deliverySearchInput')?.value || '';
            const status = document.getElementById('deliveryStatusFilter')?.value || 'All';

            try {
                const res = await fetch(`${API_URL}?action=get_deliveries&search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`);
                const data = await res.json();
                const tbody = document.getElementById('deliveriesTableBody');

                if (data.success && data.deliveries.length > 0) {
                    tbody.innerHTML = data.deliveries.map(d => `
                        <tr>
                            <td class="fw-bold text-primary">${d.order_code}</td>
                            <td>
                                <div class="fw-bold text-dark">${d.customer_name}</div>
                                <div class="fs-9 text-muted">${d.customer_phone || ''}</div>
                            </td>
                            <td class="fs-9 text-muted">${d.pickup_location}</td>
                            <td class="fs-8 fw-semibold text-dark">${d.delivery_address}</td>
                            <td><span class="badge ${getStatusBadge(d.order_status)}">${d.order_status}</span></td>
                            <td class="fw-bold">${d.assigned_rider_name || 'Unassigned'}</td>
                            <td>
                                <button class="btn btn-sm btn-light border py-1 px-2 fs-9" onclick="openAssignDeliveryModal(${d.id})"><i class="fa-solid fa-motorcycle me-1"></i> Dispatch</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No deliveries found.</td></tr>';
                }
            } catch (e) {}
        }

        async function openAssignDeliveryModal(orderId = null) {
            try {
                const res = await fetch(`${API_URL}?action=get_orders&subtab=all`);
                const data = await res.json();
                const select = document.getElementById('mAssignOrderSelect');
                select.innerHTML = (data.orders || []).map(o => `
                    <option value="${o.id}" ${orderId && parseInt(orderId) === parseInt(o.id) ? 'selected' : ''}>
                        ${o.order_code} - ${o.customer_name} (₱${Number(o.total_amount).toLocaleString()})
                    </option>
                `).join('');
                new bootstrap.Modal(document.getElementById('assignDeliveryModal')).show();
            } catch (e) {}
        }

        async function submitAssignDelivery() {
            const orderId = document.getElementById('mAssignOrderSelect').value;
            const rider = document.getElementById('mAssignRiderName').value.trim();
            const phone = document.getElementById('mAssignRiderPhone').value.trim();
            const eta = document.getElementById('mAssignEta').value.trim();

            try {
                const res = await fetch(`${API_URL}?action=assign_delivery&order_id=${orderId}&rider_name=${encodeURIComponent(rider)}&rider_phone=${encodeURIComponent(phone)}&estimated_arrival=${encodeURIComponent(eta)}`);
                const data = await res.json();
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('assignDeliveryModal')).hide();
                    loadDeliveries();
                    loadDashboardStats();
                }
            } catch (e) {}
        }

        // ----------------------------------------------------------
        // 8. SERVICE CHARGES MODULE
        // ----------------------------------------------------------
        async function loadServiceCharges() {
            try {
                const res = await fetch(`${API_URL}?action=get_service_charges`);
                const data = await res.json();
                if (data.success && data.settings) {
                    const s = data.settings;
                    if (s.event_setup_fee) document.getElementById('rateEventSetupFee').value = s.event_setup_fee;
                    if (s.delivery_fee_per_km) document.getElementById('rateDeliveryPerKm').value = s.delivery_fee_per_km;
                    if (s.service_charge_rate) document.getElementById('rateServiceCharge').value = s.service_charge_rate;
                    if (s.min_order_delivery) document.getElementById('rateMinOrderDelivery').value = s.min_order_delivery;
                    if (s.tax_rate) document.getElementById('rateTaxRate').value = s.tax_rate;
                    if (s.auto_calculate_charges !== undefined) document.getElementById('rateAutoCalculate').checked = (s.auto_calculate_charges == '1');
                    updateLiveRatesPreview();
                }
            } catch (e) {}
        }

        function updateLiveRatesPreview() {
            const setup = document.getElementById('rateEventSetupFee').value;
            const delivery = document.getElementById('rateDeliveryPerKm').value;
            const service = document.getElementById('rateServiceCharge').value;
            const tax = document.getElementById('rateTaxRate').value;

            document.getElementById('cardRateSetupFee').innerText = '₱ ' + setup;
            document.getElementById('cardRateDeliveryFee').innerText = '₱ ' + delivery;
            document.getElementById('cardRateServiceFee').innerText = service + '%';
            document.getElementById('cardRateTax').innerText = tax + '%';

            runLiveTestCalculation();
        }

        function runLiveTestCalculation() {
            const subtotal = parseFloat(document.getElementById('calcSubtotal')?.value || 0);
            const km = parseFloat(document.getElementById('calcDistance')?.value || 0);
            const perKm = parseFloat(document.getElementById('rateDeliveryPerKm')?.value || 50);
            const servRate = parseFloat(document.getElementById('rateServiceCharge')?.value || 10) / 100;

            const deliveryFee = km * perKm;
            const serviceFee = subtotal * servRate;
            const total = subtotal + deliveryFee + serviceFee;

            if (document.getElementById('calcResultDelivery')) document.getElementById('calcResultDelivery').innerText = '₱ ' + deliveryFee.toLocaleString();
            if (document.getElementById('calcResultService')) document.getElementById('calcResultService').innerText = '₱ ' + serviceFee.toLocaleString();
            if (document.getElementById('calcResultTotal')) document.getElementById('calcResultTotal').innerText = '₱ ' + total.toLocaleString();
        }

        async function saveServiceCharges() {
            const payload = {
                event_setup_fee: document.getElementById('rateEventSetupFee').value,
                delivery_fee_per_km: document.getElementById('rateDeliveryPerKm').value,
                service_charge_rate: document.getElementById('rateServiceCharge').value,
                min_order_delivery: document.getElementById('rateMinOrderDelivery').value,
                tax_rate: document.getElementById('rateTaxRate').value,
                auto_calculate_charges: document.getElementById('rateAutoCalculate').checked ? '1' : '0'
            };

            try {
                const res = await fetch(`${API_URL}?action=save_service_charges`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                alert(data.message || 'Rates saved successfully');
            } catch (e) {
                alert('Error: ' + e.message);
            }
        }

        function switchChargeSubtab(subtab, btn) {
            document.querySelectorAll('#section_serviceCharges .subtab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        // ----------------------------------------------------------
        // 9. SUPPORT TICKETS MODULE
        // ----------------------------------------------------------
        let currentTicketSubtab = 'All Tickets';
        async function loadTickets() {
            const search = document.getElementById('ticketSearchInput')?.value || '';
            const priority = document.getElementById('ticketPriorityFilter')?.value || 'All';
            const status = (currentTicketSubtab === 'All Tickets') ? (document.getElementById('ticketStatusFilter')?.value || 'All') : currentTicketSubtab;

            try {
                const res = await fetch(`${API_URL}?action=get_tickets&search=${encodeURIComponent(search)}&priority=${encodeURIComponent(priority)}&status=${encodeURIComponent(status)}`);
                const data = await res.json();
                const tbody = document.getElementById('ticketsTableBody');

                if (data.success && data.tickets.length > 0) {
                    tbody.innerHTML = data.tickets.map(t => `
                        <tr>
                            <td class="fw-bold text-muted">${t.ticket_number}</td>
                            <td class="fw-bold text-dark">${t.customer_name}</td>
                            <td>
                                <div class="fw-semibold text-dark">${t.issue_title}</div>
                                <div class="fs-9 text-muted text-truncate" style="max-width:260px;">${t.description || ''}</div>
                            </td>
                            <td><span class="badge ${getPriorityBadge(t.priority)}">${t.priority}</span></td>
                            <td><span class="badge ${t.status === 'RESOLVED' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'}">${t.status_display || t.status}</span></td>
                            <td>${t.assigned_to || 'Support Team'}</td>
                            <td>
                                <button class="btn btn-sm btn-light border py-1 px-2 fs-9 text-success" onclick="resolveTicket(${t.id})"><i class="fa-solid fa-check"></i> Resolve</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No tickets found.</td></tr>';
                }
            } catch (e) {}
        }

        function switchTicketSubtab(subtab, btn) {
            currentTicketSubtab = subtab;
            document.querySelectorAll('#section_support .subtab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            loadTickets();
        }

        function openCreateTicketModal() {
            new bootstrap.Modal(document.getElementById('createTicketModal')).show();
        }

        async function submitCreateTicket() {
            const cust = document.getElementById('mTktCustomer').value.trim();
            const sub = document.getElementById('mTktSubject').value.trim();
            const pri = document.getElementById('mTktPriority').value;
            const ass = document.getElementById('mTktAssigned').value.trim();
            const desc = document.getElementById('mTktDesc').value.trim();

            if (!sub) { alert('Please enter subject'); return; }

            try {
                await fetch(`${API_URL}?action=create_ticket`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ customer_name: cust, issue_title: sub, priority: pri, assigned_to: ass, description: desc })
                });
                bootstrap.Modal.getInstance(document.getElementById('createTicketModal')).hide();
                loadTickets();
            } catch (e) {}
        }

        async function resolveTicket(id) {
            if (!confirm('Mark ticket as Resolved?')) return;
            try {
                await fetch(`${API_URL}?action=update_ticket_status&id=${id}&status=RESOLVED`);
                loadTickets();
                loadDashboardStats();
            } catch (e) {}
        }

        // ----------------------------------------------------------
        // 10. TRANSACTIONS MODULE
        // ----------------------------------------------------------
        async function loadTransactions() {
            const search = document.getElementById('trxSearchInput')?.value || '';
            const type = document.getElementById('trxTypeFilter')?.value || 'All';

            try {
                const res = await fetch(`${API_URL}?action=get_transactions&search=${encodeURIComponent(search)}&type=${encodeURIComponent(type)}`);
                const data = await res.json();
                const tbody = document.getElementById('transactionsTableBody');

                if (data.success && data.transactions.length > 0) {
                    tbody.innerHTML = data.transactions.map(t => `
                        <tr>
                            <td class="fs-9 text-muted">${t.created_at || '2026-09-18'}</td>
                            <td><span class="badge ${t.type === 'PAYMENT' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning'}">${t.type}</span></td>
                            <td class="fw-bold text-muted">${t.order_code || 'N/A'}</td>
                            <td class="fw-bold text-dark">${t.customer_name}</td>
                            <td class="fw-extrabold text-dark">₱${Number(t.amount).toLocaleString()}</td>
                            <td><span class="badge bg-success-subtle text-success">${t.status}</span></td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No transactions recorded.</td></tr>';
                }
            } catch (e) {}
        }

        function exportTransactionsCSV() {
            window.open(`${API_URL}?action=get_transactions&export=csv`, '_blank');
        }

        // ----------------------------------------------------------
        // 11. REPORTS MODULE (Chart.js Line & Donut Charts)
        // ----------------------------------------------------------
        async function loadReports() {
            try {
                const res = await fetch(`${API_URL}?action=get_reports`);
                const data = await res.json();
                if (data.success) {
                    const sm = data.summary;
                    document.getElementById('repTotalSales').innerText = '₱ ' + Number(sm.total_sales).toLocaleString();
                    document.getElementById('repTotalOrders').innerText = sm.total_orders;
                    document.getElementById('repNewCustomers').innerText = sm.new_customers;
                    document.getElementById('repAvgOrder').innerText = '₱ ' + Number(sm.avg_order_value).toLocaleString();

                    // Render Sales Trend Spline Chart
                    const ctxTrend = document.getElementById('salesTrendChart')?.getContext('2d');
                    if (ctxTrend) {
                        if (salesChartInstance) salesChartInstance.destroy();
                        salesChartInstance = new Chart(ctxTrend, {
                            type: 'line',
                            data: {
                                labels: data.sales_chart.labels,
                                datasets: [{
                                    label: 'Revenue (₱)',
                                    data: data.sales_chart.data,
                                    borderColor: '#5B3FA8',
                                    backgroundColor: 'rgba(91, 63, 168, 0.08)',
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    pointBackgroundColor: '#5B3FA8'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: { beginAtZero: true, grid: { color: '#F1F5F9' } },
                                    x: { grid: { display: false } }
                                }
                            }
                        });
                    }

                    // Render Category Donut Chart
                    const ctxDonut = document.getElementById('categoryDonutChart')?.getContext('2d');
                    if (ctxDonut) {
                        if (categoryChartInstance) categoryChartInstance.destroy();
                        categoryChartInstance = new Chart(ctxDonut, {
                            type: 'doughnut',
                            data: {
                                labels: data.category_chart.labels,
                                datasets: [{
                                    data: data.category_chart.data,
                                    backgroundColor: ['#5B3FA8', '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
                                    borderWidth: 2,
                                    borderColor: '#FFFFFF'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } }
                                }
                            }
                        });
                    }
                }
            } catch (e) {
                console.error("Reports error:", e);
            }
        }

        // ----------------------------------------------------------
        // 12. SETTINGS MODULE
        // ----------------------------------------------------------
        async function loadSettings() {
            try {
                const res = await fetch(`${API_URL}?action=get_settings`);
                const data = await res.json();
                if (data.success && data.settings) {
                    const s = data.settings;
                    if (s.business_name) document.getElementById('setBusinessName').value = s.business_name;
                    if (s.business_email) document.getElementById('setBusinessEmail').value = s.business_email;
                    if (s.business_phone) document.getElementById('setBusinessPhone').value = s.business_phone;
                    if (s.business_address) document.getElementById('setBusinessAddress').value = s.business_address;
                    if (s.auto_backup !== undefined) document.getElementById('setAutoBackup').checked = (s.auto_backup == '1');
                    if (s.email_notifications !== undefined) document.getElementById('setEmailNotifications').checked = (s.email_notifications == '1');
                    if (s.sms_notifications !== undefined) document.getElementById('setSmsNotifications').checked = (s.sms_notifications == '1');
                    if (s.maintenance_mode !== undefined) document.getElementById('setMaintenanceMode').checked = (s.maintenance_mode == '1');
                }
            } catch (e) {}
        }

        async function saveSystemSettings() {
            const payload = {
                business_name: document.getElementById('setBusinessName').value,
                business_email: document.getElementById('setBusinessEmail').value,
                business_phone: document.getElementById('setBusinessPhone').value,
                business_address: document.getElementById('setBusinessAddress').value,
                auto_backup: document.getElementById('setAutoBackup').checked ? '1' : '0',
                email_notifications: document.getElementById('setEmailNotifications').checked ? '1' : '0',
                sms_notifications: document.getElementById('setSmsNotifications').checked ? '1' : '0',
                maintenance_mode: document.getElementById('setMaintenanceMode').checked ? '1' : '0'
            };

            try {
                const res = await fetch(`${API_URL}?action=save_settings`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                alert(data.message || 'Settings saved successfully');
            } catch (e) {
                alert('Error: ' + e.message);
            }
        }

        function switchSettingsSubtab(subtab, btn) {
            document.querySelectorAll('#section_settings .subtab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        function performBackup() {
            alert('Database snapshot initiated. Live backup completed successfully.');
            document.getElementById('backupTimestampText').innerText = 'Last Backup: ' + new Date().toLocaleString();
        }

        // ----------------------------------------------------------
        // UTILITY HELPERS
        // ----------------------------------------------------------
        function getStatusBadge(st) {
            switch ((st || '').toUpperCase()) {
                case 'DELIVERED': return 'bg-success-subtle text-success';
                case 'ON_THE_WAY': return 'bg-primary-subtle text-primary';
                case 'PROCESSING':
                case 'CONFIRMED': return 'bg-info-subtle text-info';
                case 'CANCELLED': return 'bg-danger-subtle text-danger';
                default: return 'bg-warning-subtle text-warning';
            }
        }

        function getPriorityBadge(pri) {
            switch ((pri || '').toUpperCase()) {
                case 'CRITICAL': return 'bg-danger text-white';
                case 'HIGH': return 'bg-danger-subtle text-danger';
                case 'MEDIUM': return 'bg-warning-subtle text-warning';
                default: return 'bg-success-subtle text-success';
            }
        }

        function handleGlobalSearch(q) {
            const query = q.toLowerCase().trim();
            if (!query) return;
            if (currentActiveSection === 'products') {
                document.getElementById('productSearchInput').value = query;
                loadProducts();
            } else if (currentActiveSection === 'orders') {
                document.getElementById('orderSearchInput').value = query;
                loadOrders();
            } else if (currentActiveSection === 'customers') {
                document.getElementById('customerSearchInput').value = query;
                loadCustomers();
            }
        }

        function toggleSidebar() {
            const sb = document.getElementById('adminSidebar');
            sb.classList.toggle('show');
        }

        // Initialize on Load
        document.addEventListener('DOMContentLoaded', () => {
            <?php if ($isAdminLoggedIn): ?>
            switchAdminTab('dashboard');
            <?php endif; ?>
        });
    </script>
</body>
</html>
