<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentEase - Delivery & Logistics Fleet Portal</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome & Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <!-- Leaflet.js Map CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        :root {
            --primary: #5B3FA8;
            --primary-dark: #341F97;
            --secondary: #10B981;
            --dark-bg: #0F172A;
            --card-bg: #1E293B;
            --accent: #F4B942;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark-bg);
            color: #F8FAFC;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .rider-app-wrapper {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            background: #0F172A;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            border-left: 1px solid #1E293B;
            border-right: 1px solid #1E293B;
        }

        .rider-header {
            background: linear-gradient(135deg, #1E1B4B, #5B3FA8);
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .rider-card {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .status-badge-verified {
            background: rgba(16, 185, 129, 0.15);
            color: #10B981;
            border: 1px solid rgba(16, 185, 129, 0.3);
            font-weight: 700;
            font-size: 0.72rem;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .nav-btn-stage {
            background: linear-gradient(135deg, #5B3FA8, #341F97);
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-weight: 800;
            width: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .nav-btn-stage:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(91, 63, 168, 0.4);
            color: #fff;
        }

        .leaflet-map-container {
            height: 230px;
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid #334155;
            margin-top: 12px;
        }

        .pulse-online {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse 1.6s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .manifest-pill {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid #334155;
            padding: 8px 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>

<div class="rider-app-wrapper">

    <!-- 1. RIDER LOGIN VIEW -->
    <div id="riderAuthView" style="display: block;" class="p-4 my-auto">
        <div class="text-center mb-4 pt-3">
            <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-4 mb-3 shadow-lg" style="background: rgba(91, 63, 168, 0.2); width: 88px; height: 88px; border: 2px solid rgba(255, 255, 255, 0.15);">
                <img src="LOGO.png" alt="RentEase Logo" style="height: 54px; width: auto; object-fit: contain;">
            </div>
            <h2 class="fw-extrabold text-white mb-1" style="letter-spacing: -0.5px;">RentEase Fleet</h2>
            <p class="text-secondary fs-7">Event Logistics &amp; Equipment Delivery Dispatch</p>
        </div>

        <div class="rider-card shadow-lg">
            <div id="riderLoginErrorAlert" class="alert alert-danger p-2 fs-8 mb-3" style="display: none;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> <span id="riderLoginErrorMsg">Invalid credentials.</span>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary fw-bold fs-8 mb-1">Fleet Driver Username / Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-secondary"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="form-control bg-dark text-white border-secondary fs-7" id="riderUsernameInput" placeholder="joey" value="joey">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-secondary fw-bold fs-8 mb-1">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-secondary"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" class="form-control bg-dark text-white border-secondary fs-7" id="riderPasswordInput" placeholder="••••••••" value="Pogilameg">
                </div>
            </div>

            <button class="btn btn-primary w-100 py-3 fw-extrabold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #5B3FA8, #341F97); border: none;" onclick="executeRiderLogin()">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Log In to Fleet Dispatch
            </button>

            <div class="mt-3 text-center pt-2 border-top border-secondary border-opacity-25">
                <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 py-1 fs-8 fw-semibold" onclick="quickFillRider('joey', 'Pogilameg')">
                    <i class="fa-solid fa-bolt me-1"></i> Quick Test: Juan Dela Cruz (Fleet Rider)
                </button>
            </div>
        </div>

        <div class="text-center text-secondary fs-8 mt-3">
            <a href="../student/index.php" class="text-decoration-none text-secondary"><i class="fa-solid fa-store me-1"></i> Open RentEase Customer App</a>
        </div>
    </div>

    <!-- 2. RIDER DASHBOARD MAIN VIEW -->
    <div id="riderMainDashboardView" style="display: none;" class="flex-column flex-grow-1">
        
        <!-- Header -->
        <div class="rider-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" id="riderAvatarImg" class="rounded-circle border border-2 border-white" width="44" height="44" style="object-fit:cover;" alt="Juan Dela Cruz">
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:12px; height:12px;"></span>
                </div>
                <div>
                    <div class="fw-extrabold text-white fs-7 mb-0" id="riderNameText">Juan Dela Cruz</div>
                    <span class="status-badge-verified"><i class="fa-solid fa-shield-check me-1"></i> VERIFIED FLEET DRIVER</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-light btn-sm rounded-circle" onclick="fetchRiderJobAlerts()" title="Refresh Dispatch">
                    <i class="fa-solid fa-rotate"></i>
                </button>
                <button class="btn btn-outline-danger btn-sm rounded-circle" onclick="logoutRider()" title="Logout">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </div>
        </div>

        <!-- Dashboard Content Body -->
        <div class="p-3 flex-grow-1 overflow-y-auto">

            <!-- Driver Vehicle Info Card -->
            <div class="rider-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-secondary fw-bold fs-8"><i class="fa-solid fa-truck-ramp-box me-1 text-warning"></i> Assigned Delivery Fleet</span>
                    <span class="badge bg-success bg-opacity-25 text-success fw-bold fs-9" id="riderPlateBadge"><i class="fa-solid fa-motorcycle me-1"></i> MC-8888-JY</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-extrabold text-white mb-0" id="riderVehicleModelText">Honda Click 125i (Cargo Rig)</h6>
                        <span class="text-secondary fs-9" id="riderLicenseText">License: N02-24-123456 • Rating: 4.9 ★</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="riderGpsToggle" checked onchange="toggleRiderGps(this)">
                        <label class="form-check-label text-white fs-8 ms-1 fw-bold"><span class="pulse-online me-1"></span> Live GPS</label>
                    </div>
                </div>
            </div>

            <!-- KPI Row -->
            <div class="row g-2 mb-3">
                <div class="col-4">
                    <div class="p-2.5 rounded-3 text-center" style="background:#1E293B; border:1px solid #334155;">
                        <span class="text-secondary fs-9 fw-bold text-uppercase d-block">Delivered</span>
                        <strong class="text-success fs-6">4 Events</strong>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2.5 rounded-3 text-center" style="background:#1E293B; border:1px solid #334155;">
                        <span class="text-secondary fs-9 fw-bold text-uppercase d-block">Active Trip</span>
                        <strong class="text-warning fs-6">1 Order</strong>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2.5 rounded-3 text-center" style="background:#1E293B; border:1px solid #334155;">
                        <span class="text-secondary fs-9 fw-bold text-uppercase d-block">Earnings</span>
                        <strong class="text-info fs-6">₱1,850</strong>
                    </div>
                </div>
            </div>

            <!-- Active Event Rental Delivery Dispatch Card (Screen 7 Sync) -->
            <div id="riderActiveJobCard" class="rider-card border-primary shadow-lg mb-3" style="background: rgba(30, 41, 59, 0.95);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge text-white fw-extrabold fs-8 px-2.5 py-1" style="background:#5B3FA8;" id="riderJobStageBadge">
                        <i class="fa-solid fa-truck-fast me-1"></i> STAGE: OUT FOR DELIVERY
                    </span>
                    <span class="text-warning fw-bold fs-7" id="riderJobFeeText">Delivery Fee: ₱150.00</span>
                </div>

                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <h5 class="fw-extrabold text-white mb-0" id="riderJobTitle">Assigned Equipment Delivery</h5>
                        <span class="text-secondary fs-8">Order <strong class="text-info" id="riderJobCode">#RE-10245</strong> • Total: <span id="riderJobTotalText">₱1,749.00</span></span>
                    </div>
                </div>

                <p class="text-secondary fs-8 mb-3 mt-1" id="riderJobAddressesText">
                    <i class="fa-solid fa-warehouse me-1 text-success"></i> <strong id="riderPickupText">Pasabuy Hub, Lipa City</strong> ➔ 
                    <i class="fa-solid fa-location-dot me-1 text-danger"></i> <strong id="riderDropoffText">San Pablo, Laguna (Student Center)</strong>
                </p>

                <!-- Equipment Manifest Checklist -->
                <div class="mb-3">
                    <strong class="fs-8 text-white d-block mb-1.5"><i class="fa-solid fa-clipboard-check me-1 text-warning"></i> Equipment Manifest Checklist:</strong>
                    <div id="riderManifestContainer">
                        <div class="manifest-pill">
                            <span class="fs-8 text-white"><i class="fa-solid fa-box text-primary me-2"></i>Event Rental Equipment</span>
                            <span class="badge bg-primary text-white">1 set</span>
                        </div>
                    </div>
                </div>

                <!-- Contacts -->
                <div class="p-2.5 rounded-3 mb-3" style="background: rgba(15, 23, 42, 0.8); border: 1px solid #334155;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-secondary fs-8"><i class="fa-solid fa-user text-success me-1"></i> Customer: <strong class="text-white" id="riderJobCustomerName">Pogilameg Tester</strong></span>
                        <a href="tel:09981234567" id="riderCallCustomerBtn" class="btn btn-outline-success btn-sm py-0 px-2 fs-9"><i class="fa-solid fa-phone me-1"></i> Call Customer</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-secondary fs-8"><i class="fa-solid fa-store text-warning me-1"></i> Stock Owner: <strong class="text-white" id="riderJobOwnerName">Romeo Paolo Tolentino</strong></span>
                        <a href="tel:09668257301" id="riderCallOwnerBtn" class="btn btn-outline-warning btn-sm py-0 px-2 fs-9"><i class="fa-solid fa-phone me-1"></i> Call Owner</a>
                    </div>
                </div>

                <!-- Leaflet Stage Route Map -->
                <div class="leaflet-map-container mb-3" id="riderDriverMap"></div>

                <!-- Stage Action Buttons -->
                <div class="d-flex flex-column gap-2" id="riderStageActionContainer">
                    <button class="nav-btn-stage shadow-lg" id="btnRiderStageAction" onclick="advanceRentalDeliveryStage()">
                        <i class="fa-solid fa-circle-check me-2"></i> Confirm Delivery &amp; Inspection Completed
                    </button>
                    <button class="btn btn-outline-danger btn-sm w-100 py-2 fw-bold fs-8 rounded-3" id="btnRiderCancelPickup" onclick="cancelCurrentRiderJob()">
                        <i class="fa-solid fa-ban me-1.5"></i> Cancel Pickup (Vehicle Issue / Emergency)
                    </button>
                </div>
            </div>

            <!-- Standby message when no active job is accepted -->
            <div id="riderNoActiveJobNotice" class="rider-card text-center p-4 mb-3 text-secondary" style="display:none;">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:50px; height:50px; background:rgba(255,255,255,0.05);">
                    <i class="fa-solid fa-motorcycle text-warning fs-5"></i>
                </div>
                <h6 class="text-white fw-bold fs-7 mb-1">No Active Delivery Trip</h6>
                <p class="fs-9 mb-0">Check the available broadcast deliveries below and click <strong>Accept Delivery Job</strong> to claim a package.</p>
            </div>

            <!-- Open Scheduled Deliveries Broadcast Section -->
            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="fw-extrabold text-white mb-0"><i class="fa-solid fa-satellite-dish me-1 text-warning"></i> Open Broadcast Deliveries</h6>
                    <button class="btn btn-dark btn-sm fs-9 text-secondary py-1" onclick="fetchRiderJobAlerts()"><i class="fa-solid fa-rotate me-1"></i> Refresh</button>
                </div>

                <div id="riderJobAlertsListContainer">
                    <div class="text-center p-4 rider-card text-secondary fs-8">
                        <i class="fa-solid fa-circle-check me-2 text-success"></i> All current event deliveries assigned. Standing by for next reservation dispatch.
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
let currentRiderUser = null;
let currentActiveOrder = null;
let currentStageIndex = 2; // Default ON_THE_WAY
let riderLeafletMap = null;
let riderMarker = null;

const warehouse = [14.1800, 121.2600];
const riderCoords = [14.1870, 121.2650];
const destination = [14.1950, 121.2720];

const stages = [
    { key: 'CONFIRMED', badge: 'STAGE 1: ORDER CONFIRMED', btnText: 'Start Equipment Preparation', icon: 'fa-boxes-packing', next: 'PREPARING' },
    { key: 'PREPARING', badge: 'STAGE 2: PREPARING EQUIPMENT', btnText: 'Confirm Equipment Loaded (Out for Delivery)', icon: 'fa-truck-ramp-box', next: 'ON_THE_WAY' },
    { key: 'ON_THE_WAY', badge: 'STAGE 3: OUT FOR DELIVERY', btnText: 'Confirm Delivery & Handover Completed', icon: 'fa-circle-check', next: 'DELIVERED' },
    { key: 'DELIVERED', badge: 'STAGE 4: DELIVERED AT VENUE', btnText: 'Order Completed (Ready for Event)', icon: 'fa-champagne-glasses', next: 'CONFIRMED' }
];

function quickFillRider(u, p) {
    document.getElementById('riderUsernameInput').value = u;
    document.getElementById('riderPasswordInput').value = p;
    executeRiderLogin();
}

async function executeRiderLogin() {
    const user = document.getElementById('riderUsernameInput').value.trim();
    const pass = document.getElementById('riderPasswordInput').value.trim();
    const errAlert = document.getElementById('riderLoginErrorAlert');
    const errMsg = document.getElementById('riderLoginErrorMsg');

    if (!user || !pass) {
        errMsg.innerText = 'Please enter both username and password.';
        errAlert.style.display = 'block';
        return;
    }

    try {
        let res;
        try {
            res = await fetch('../pasabuy_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'login', email: user, password: pass })
            });
        } catch (e1) {
            res = await fetch('/pasabuy_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'login', email: user, password: pass })
            });
        }
        const data = await res.json();

        if (res.ok && data.success) {
            currentRiderUser = data.user;
            localStorage.setItem('rentease_rider_session', JSON.stringify(data));
            errAlert.style.display = 'none';

            document.getElementById('riderAuthView').style.display = 'none';
            document.getElementById('riderMainDashboardView').style.display = 'flex';
            document.getElementById('riderNameText').innerText = `Juan Dela Cruz (Joey)`;

            initRiderMap();
            fetchRiderJobAlerts();
            startRiderGpsPinger();
        } else {
            errMsg.innerText = data.message || 'Invalid Rider credentials.';
            errAlert.style.display = 'block';
        }
    } catch (e) {
        errMsg.innerText = 'Connection error logging into Fleet Portal.';
        errAlert.style.display = 'block';
    }
}

function checkRiderSessionOnLoad() {
    try {
        const sessStr = localStorage.getItem('rentease_rider_session') || localStorage.getItem('pasabuy_rider_session');
        if (sessStr) {
            const sess = JSON.parse(sessStr);
            if (sess && sess.user) {
                currentRiderUser = sess.user;
                document.getElementById('riderAuthView').style.display = 'none';
                document.getElementById('riderMainDashboardView').style.display = 'flex';
                document.getElementById('riderNameText').innerText = `Juan Dela Cruz (Joey)`;

                setTimeout(initRiderMap, 200);
                fetchRiderJobAlerts();
                startRiderGpsPinger();
                return;
            }
        }
    } catch (e) {}

    document.getElementById('riderAuthView').style.display = 'block';
    document.getElementById('riderMainDashboardView').style.display = 'none';
}

window.addEventListener('DOMContentLoaded', checkRiderSessionOnLoad);

function logoutRider() {
    localStorage.removeItem('rentease_rider_session');
    localStorage.removeItem('pasabuy_rider_session');
    document.getElementById('riderMainDashboardView').style.display = 'none';
    document.getElementById('riderAuthView').style.display = 'block';
}

function initRiderMap() {
    const mapDiv = document.getElementById('riderDriverMap');
    if (!mapDiv) return;

    if (riderLeafletMap) {
        riderLeafletMap.remove();
        riderLeafletMap = null;
    }

    try {
        const map = L.map('riderDriverMap', { zoomControl: false }).setView(riderCoords, 14);
        riderLeafletMap = map;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // Warehouse Marker
        const whIcon = L.divIcon({
            html: `<div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow" style="width:28px; height:28px; background:#10B981; border:2px solid #fff;"><i class="fa-solid fa-warehouse fs-9"></i></div>`,
            className: '',
            iconSize: [28, 28]
        });
        L.marker(warehouse, { icon: whIcon }).addTo(map).bindPopup('Owner Stock / Pickup Location');

        // Rider Marker
        const rIcon = L.divIcon({
            html: `<div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-lg" style="width:34px; height:34px; background:linear-gradient(135deg, #5B3FA8, #341F97); border:2px solid #fff;"><i class="fa-solid fa-truck-fast fs-8"></i></div>`,
            className: '',
            iconSize: [34, 34]
        });
        riderMarker = L.marker(riderCoords, { icon: rIcon }).addTo(map).bindPopup('You (Fleet Driver Juan Dela Cruz)').openPopup();

        // Venue Destination Marker
        const destIcon = L.divIcon({
            html: `<div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow" style="width:28px; height:28px; background:#EF4444; border:2px solid #fff;"><i class="fa-solid fa-location-dot fs-9"></i></div>`,
            className: '',
            iconSize: [28, 28]
        });
        L.marker(destination, { icon: destIcon }).addTo(map).bindPopup('Renter Delivery Destination');

        // Route Polyline
        L.polyline([warehouse, riderCoords, destination], {
            color: '#5B3FA8',
            weight: 4,
            dashArray: '6, 6',
            opacity: 0.9
        }).addTo(map);

    } catch (e) {
        console.error("Leaflet map init error:", e);
    }
}

async function fetchRiderJobAlerts() {
    try {
        let apiUrl = '../rentease_api.php?action=rider_get_jobs&rider_id=1&rider_name=Juan+Dela+Cruz';
        let res = await fetch(apiUrl);
        if (!res.ok) {
            res = await fetch('/rentease_api.php?action=rider_get_jobs&rider_id=1&rider_name=Juan+Dela+Cruz');
        }
        const data = await res.json();
        
        const activeCard = document.getElementById('riderActiveJobCard');
        const noActiveNotice = document.getElementById('riderNoActiveJobNotice');
        const container = document.getElementById('riderJobAlertsListContainer');

        // Handle Active Assigned Job
        if (data.success && data.active_order) {
            currentActiveOrder = data.active_order;
            if (activeCard) activeCard.style.display = 'block';
            if (noActiveNotice) noActiveNotice.style.display = 'none';

            const ord = data.active_order;
            document.getElementById('riderJobCode').innerText = ord.order_code || '#RE-10245';
            document.getElementById('riderJobTotalText').innerText = `₱${parseFloat(ord.total_amount || 0).toLocaleString('en-US', {minimumFractionDigits:2})}`;
            document.getElementById('riderPickupText').innerText = ord.pickup_address || 'Pasabuy Hub, Lipa City';
            document.getElementById('riderDropoffText').innerText = ord.delivery_address || 'San Pablo, Laguna';
            document.getElementById('riderJobCustomerName').innerText = `${ord.customer_name || 'Pogilameg Tester'} (${ord.customer_phone || '09981234567'})`;
            document.getElementById('riderJobOwnerName').innerText = `${ord.owner_name || 'Romeo Paolo Tolentino'}`;

            if (ord.customer_phone) document.getElementById('riderCallCustomerBtn').href = `tel:${ord.customer_phone}`;

            // Render manifest
            const mContainer = document.getElementById('riderManifestContainer');
            if (mContainer) {
                if (Array.isArray(ord.items) && ord.items.length > 0) {
                    mContainer.innerHTML = ord.items.map(it => `
                        <div class="manifest-pill">
                            <span class="fs-8 text-white"><i class="fa-solid fa-box text-primary me-2"></i>${it.product_name}</span>
                            <span class="badge bg-primary text-white">${it.quantity} units</span>
                        </div>
                    `).join('');
                } else {
                    mContainer.innerHTML = `
                        <div class="manifest-pill">
                            <span class="fs-8 text-white"><i class="fa-solid fa-box text-primary me-2"></i>Rental Equipment</span>
                            <span class="badge bg-primary text-white">Package</span>
                        </div>
                    `;
                }
            }

            // Sync Stage Badge
            const st = ord.order_status || 'ON_THE_WAY';
            const badge = document.getElementById('riderJobStageBadge');
            const btn = document.getElementById('btnRiderStageAction');
            if (st === 'DELIVERED') {
                badge.innerHTML = `<i class="fa-solid fa-circle-check me-1"></i> STAGE: DELIVERED`;
                btn.className = 'btn btn-success w-100 py-3 fw-extrabold rounded-3 shadow-lg';
                btn.innerHTML = `<i class="fa-solid fa-circle-check me-2"></i> Handover Completed`;
            } else {
                badge.innerHTML = `<i class="fa-solid fa-truck-fast me-1"></i> STAGE: OUT FOR DELIVERY`;
                btn.className = 'nav-btn-stage shadow-lg';
                btn.innerHTML = `<i class="fa-solid fa-circle-check me-2"></i> Confirm Delivery & Inspection Completed`;
            }
        } else {
            currentActiveOrder = null;
            if (activeCard) activeCard.style.display = 'none';
            if (noActiveNotice) noActiveNotice.style.display = 'block';
        }

        // Render Broadcast Deliveries (Open for acceptance)
        if (container) {
            if (data.success && Array.isArray(data.broadcast_jobs) && data.broadcast_jobs.length > 0) {
                let html = '';
                data.broadcast_jobs.forEach(job => {
                    const itemsText = Array.isArray(job.items) && job.items.length > 0 
                        ? job.items.map(i => `${i.quantity}x ${i.product_name}`).join(', ')
                        : 'Rental Equipment Package';

                    html += `
                    <div class="rider-card border-secondary mb-2.5 p-3">
                        <div class="d-flex align-items-center justify-content-between mb-1.5">
                            <span class="badge text-white fw-bold fs-9" style="background:#5B3FA8;">${job.order_code}</span>
                            <span class="badge bg-warning text-dark fw-bold fs-9">Fee: ₱150.00</span>
                        </div>
                        <h6 class="fw-extrabold text-white mb-1 fs-8">${job.customer_name} • Total ₱${parseFloat(job.total_amount).toFixed(2)}</h6>
                        <div class="fs-9 text-secondary mb-1">
                            <i class="fa-solid fa-warehouse text-success me-1"></i> Pickup: <strong class="text-white">${job.pickup_address || 'Stock Location'}</strong>
                        </div>
                        <div class="fs-9 text-secondary mb-2">
                            <i class="fa-solid fa-location-dot text-danger me-1"></i> Deliver to: <strong class="text-white">${job.delivery_address || 'Address'}</strong>
                        </div>
                        <div class="p-1.5 rounded-2 mb-2" style="background:rgba(255,255,255,0.06);">
                            <span class="fs-9 text-white"><i class="fa-solid fa-box text-warning me-1"></i> ${itemsText}</span>
                        </div>
                        <button class="btn btn-warning btn-sm w-100 fw-bold fs-8 rounded-pill text-dark shadow-sm" onclick="acceptRiderJob('${job.order_code}')">
                            <i class="fa-solid fa-bolt me-1"></i> Accept Delivery Job
                        </button>
                    </div>`;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div class="text-center p-3 rider-card text-secondary fs-8">
                        <i class="fa-solid fa-circle-check me-2 text-success"></i> All current event deliveries assigned. Standing by for next reservation dispatch.
                    </div>`;
            }
        }
    } catch (e) {
        console.error("fetchRiderJobAlerts error:", e);
    }
}

async function acceptRiderJob(orderCode) {
    if (!confirm(`Do you want to ACCEPT the delivery job for Order ${orderCode}?`)) return;

    try {
        let apiUrl = '../rentease_api.php?action=rider_accept_job';
        let res = await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                order_code: orderCode,
                rider_id: 1,
                rider_name: 'Juan Dela Cruz',
                rider_phone: '09187654321',
                rider_vehicle: 'Honda Click 125i (MC-8888-JY)',
                lat: riderCoords[0],
                lng: riderCoords[1]
            })
        });

        if (!res.ok) {
            res = await fetch('/rentease_api.php?action=rider_accept_job', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    order_code: orderCode,
                    rider_id: 1,
                    rider_name: 'Juan Dela Cruz',
                    rider_phone: '09187654321',
                    rider_vehicle: 'Honda Click 125i (MC-8888-JY)',
                    lat: riderCoords[0],
                    lng: riderCoords[1]
                })
            });
        }

        const data = await res.json();
        if (data.success) {
            alert(`🎉 Success!\n\nYou have accepted the delivery for Order ${orderCode}.\nProceed to the stock owner's pickup location.`);
            fetchRiderJobAlerts();
        } else {
            alert(data.message || '⚠️ Unable to accept job. It may have been claimed by another rider.');
            fetchRiderJobAlerts();
        }
    } catch (e) {
        alert('Connection error accepting delivery job.');
    }
}

async function cancelCurrentRiderJob() {
    if (!currentActiveOrder) {
        alert('No active delivery job to cancel.');
        return;
    }

    const orderCode = currentActiveOrder.order_code;
    const reason = prompt(`Please enter cancellation reason for Order ${orderCode}:`, 'Flat tire / emergency mechanical delay');
    if (!reason) return;

    try {
        let apiUrl = '../rentease_api.php?action=rider_cancel_job';
        let res = await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                order_code: orderCode,
                rider_name: 'Juan Dela Cruz',
                reason: reason
            })
        });

        if (!res.ok) {
            res = await fetch('/rentease_api.php?action=rider_cancel_job', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    order_code: orderCode,
                    rider_name: 'Juan Dela Cruz',
                    reason: reason
                })
            });
        }

        const data = await res.json();
        if (data.success) {
            alert(`⚠️ Delivery Cancelled.\n\nOrder ${orderCode} has been cancelled by driver.\nThe stock owner has been notified and can re-notify riders.`);
            currentActiveOrder = null;
            fetchRiderJobAlerts();
        } else {
            alert(data.message || 'Error cancelling delivery job.');
        }
    } catch (e) {
        alert('Connection error cancelling delivery job.');
    }
}

async function advanceRentalDeliveryStage() {
    if (!currentActiveOrder) {
        alert('No active delivery order.');
        return;
    }

    const orderCode = currentActiveOrder.order_code;
    const nextStage = 'DELIVERED';

    try {
        let apiUrl = '../rentease_api.php?action=rider_update_stage';
        let res = await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                order_code: orderCode,
                stage: nextStage,
                lat: destination[0],
                lng: destination[1]
            })
        });

        if (!res.ok) {
            res = await fetch('/rentease_api.php?action=rider_update_stage', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    order_code: orderCode,
                    stage: nextStage,
                    lat: destination[0],
                    lng: destination[1]
                })
            });
        }

        const data = await res.json();
        alert(`🎉 Event Delivery Confirmed!\n\nOrder ${orderCode} successfully handed over and inspection completed.`);
        fetchRiderJobAlerts();
    } catch (e) {
        alert('Error updating delivery stage.');
    }
}

function startRiderGpsPinger() {
    setInterval(() => {
        const isGpsActive = document.getElementById('riderGpsToggle')?.checked;
        if (isGpsActive && riderMarker) {
            const jitterLat = (Math.random() - 0.5) * 0.0005;
            const jitterLng = (Math.random() - 0.5) * 0.0005;
            riderMarker.setLatLng([riderCoords[0] + jitterLat, riderCoords[1] + jitterLng]);
        }
    }, 4000);
}

function toggleRiderGps(checkbox) {
    if (!checkbox.checked) {
        alert('⚠️ Live GPS beacon turned OFF. Customers will see last known coordinates.');
    } else {
        alert('📍 Live GPS beacon activated. Transmitting vehicle coordinates.');
    }
}
</script>

</body>
</html>
