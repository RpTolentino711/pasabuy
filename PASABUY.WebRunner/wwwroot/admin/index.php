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
            <div class="auth-header">
                <div class="mb-2 text-center">
                    <img src="LOGO.png" alt="PasaBuy Logo" style="height:65px; width:auto; object-fit:contain; filter: drop-shadow(0 4px 10px rgba(255, 255, 255, 0.3));">
                </div>
                <h4 class="fw-extrabold mb-1">PasaBuy Admin Portal</h4>
                <p class="text-white-50 fs-8 mb-0">Campus Marketplace Management System</p>
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

                <button class="btn btn-primary w-100 rounded-pill fw-bold py-2 fs-7 mb-3 shadow-sm" style="background:var(--admin-primary); border:none;" onclick="executeAdminLogin()"><i class="fa-solid fa-right-to-bracket me-2"></i> Log In to Admin Dashboard</button>

                <div class="text-center pt-3 border-top">
                    <a href="../index.php" class="text-decoration-none fs-8 text-muted fw-semibold"><i class="fa-solid fa-store me-1"></i> Return to Student Marketplace App</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN ADMIN DASHBOARD VIEW (SHOWN AFTER AUTHENTICATION) -->
    <div id="adminMainDashboardView" style="display:none;">
        
        <!-- Admin Top Navbar -->
        <nav class="admin-navbar navbar navbar-expand-lg navbar-dark shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fw-extrabold d-flex align-items-center gap-2" href="#">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center p-1 shadow-sm" style="width:36px; height:36px; flex-shrink:0;">
                        <img src="LOGO.png" alt="PasaBuy Logo" style="height:24px; width:auto; object-fit:contain;">
                    </div>
                    <span class="fs-5 text-white">PasaBuy <span class="badge bg-warning text-dark fs-9 rounded-pill ms-1">ADMIN PORTAL</span></span>
                </a>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white-50 fs-8"><i class="fa-solid fa-circle text-success me-1"></i> Connected to Hostinger MySQL &amp; PayMongo Live</span>
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold text-white" onclick="logoutAdmin()"><i class="fa-solid fa-right-from-bracket me-1"></i> Log Out</button>
                </div>
            </div>
        </nav>

        <div class="d-flex">
            <!-- Sidebar Navigation -->
            <aside class="admin-sidebar p-3">
                <div class="text-uppercase text-muted fw-bold fs-9 mb-3 px-2">Moderation &amp; Control</div>
                <nav class="nav flex-column">
                    <a href="#" class="nav-link-admin active" onclick="showAdminSection('dashboard', this)"><i class="fa-solid fa-chart-pie"></i> Overview Dashboard</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('verifications', this)"><i class="fa-solid fa-id-card text-primary"></i> Verification Requests</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('students', this)"><i class="fa-solid fa-user-graduate"></i> Registered Students</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('listings', this)"><i class="fa-solid fa-box-open"></i> Marketplace Listings</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('payments', this)"><i class="fa-solid fa-receipt text-success"></i> PayMongo Live Fees</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('reports', this)"><i class="fa-solid fa-flag text-danger"></i> Scam Reports</a>
                    <a href="#" class="nav-link-admin" onclick="showAdminSection('meetups', this)"><i class="fa-solid fa-location-dot"></i> Meetup Locations</a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-grow-1 p-4">

                <!-- Section 1: Dashboard Overview -->
                <div id="sectionDashboard">
                    <h4 class="fw-bold mb-1">Campus Marketplace Overview</h4>
                    <p class="text-muted fs-8 mb-4">Monitor student activity, verification requests, live listings, and fee revenues.</p>

                    <!-- Stat Cards Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-primary">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Total Students</span>
                                    <div class="stat-icon bg-primary-subtle text-primary"><i class="fa-solid fa-users"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1" id="dashTotalStudents">0</h2>
                                <span class="badge bg-success-subtle text-success fw-bold fs-9"><i class="fa-solid fa-check me-1"></i> <span id="dashVerifiedStudents">0</span> Verified</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-warning">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Pending Verifications</span>
                                    <div class="stat-icon bg-warning-subtle text-warning-emphasis"><i class="fa-solid fa-clock"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1 text-warning-emphasis" id="dashPendingVerifications">0</h2>
                                <span class="text-muted fs-8">Awaiting Admin Review</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-success">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-bold text-uppercase">Live Listings</span>
                                    <div class="stat-icon bg-success-subtle text-success"><i class="fa-solid fa-tags"></i></div>
                                </div>
                                <h2 class="fw-extrabold mb-1" id="dashActiveListings">0</h2>
                                <span class="text-muted fs-8">Active on Campus</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-stat border-start border-4 border-warning bg-dark text-white">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-warning fs-8 fw-bold text-uppercase">PayMongo Revenue</span>
                                    <div class="stat-icon bg-warning text-dark"><i class="fa-solid fa-wallet"></i></div>
                                </div>
                                <h2 class="fw-extrabold text-warning mb-1" id="dashPayMongoRevenue">₱0.00</h2>
                                <span class="text-white-50 fs-8"><i class="fa-solid fa-bolt text-warning me-1"></i> Live GCash / Card Fees</span>
                            </div>
                        </div>
                    </div>

                    <!-- PayMongo Live Account Banner -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-dark text-white">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                                    <i class="fa-solid fa-shield-check fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-white mb-1"><i class="fa-solid fa-bolt text-warning me-2"></i>PayMongo Live API Account Connected</h5>
                                    <p class="text-white-50 fs-8 mb-0">Public Key: <code>pk_live_vNqaV125GXHhGtsY8Atqgbxc</code> • Domain: <strong>pasabuy.site</strong></p>
                                </div>
                            </div>
                            <a href="https://dashboard.paymongo.com" target="_blank" class="btn btn-warning rounded-pill fw-bold px-4"><i class="fa-solid fa-external-link me-1"></i> PayMongo Dashboard</a>
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

            </main>
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
                        fetchAdminDashboardStats();
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

            if ((user.toLowerCase() === 'admin' || user.toLowerCase() === 'admin@pasabuy.site') && pass === 'Pogilameg') {
                errBanner.style.display = 'none';
                localStorage.setItem('pasabuy_admin_session', JSON.stringify({ loggedIn: true, user: user, loginTime: Date.now() }));
                document.getElementById('adminAuthView').style.display = 'none';
                document.getElementById('adminMainDashboardView').style.display = 'block';
                fetchAdminDashboardStats();
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
            const sections = ['dashboard', 'verifications', 'students', 'listings', 'payments', 'reports', 'meetups'];
            sections.forEach(s => {
                const el = document.getElementById('section' + s.charAt(0).toUpperCase() + s.slice(1));
                if (el) el.style.display = (s === sectionName) ? 'block' : 'none';
            });
            document.querySelectorAll('.nav-link-admin').forEach(l => l.classList.remove('active'));
            if (element) element.classList.add('active');

            if (sectionName === 'dashboard') fetchAdminDashboardStats();
            else if (sectionName === 'verifications') fetchAdminVerificationRequests();
            else if (sectionName === 'students') fetchAdminStudents();
            else if (sectionName === 'listings') fetchAdminListings();
            else if (sectionName === 'payments') fetchAdminPayments();
            else if (sectionName === 'reports') fetchAdminReports();
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
    </script>
</body>
</html>
