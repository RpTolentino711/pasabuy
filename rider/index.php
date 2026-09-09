<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasaBuy - Express Motor Driver Portal</title>
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
            --primary: #5F27CD;
            --primary-dark: #341F97;
            --secondary: #10AC84;
            --dark-bg: #0F172A;
            --card-bg: #1E293B;
            --accent: #FF9F43;
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
            background: linear-gradient(135deg, #6C5CE7, #341F97);
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .rider-card {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .status-badge-verified {
            background: rgba(16, 172, 132, 0.15);
            color: #10AC84;
            border: 1px solid rgba(16, 172, 132, 0.3);
            font-weight: 700;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .nav-btn-stage {
            background: linear-gradient(135deg, #10AC84, #059669);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 800;
            width: 100%;
        }

        .leaflet-map-container {
            height: 240px;
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            border: 2px solid #334155;
            margin-top: 12px;
        }

        .pulse-online {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #10AC84;
            box-shadow: 0 0 0 0 rgba(16, 172, 132, 0.7);
            animation: pulse 1.6s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 172, 132, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 172, 132, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 172, 132, 0); }
        }
    </style>
</head>
<body>

<div class="rider-app-wrapper">

    <!-- 1. RIDER LOGIN VIEW -->
    <div id="riderAuthView" style="display: block;" class="p-4 my-auto">
        <div class="text-center mb-4 pt-3">
            <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-4 mb-3" style="background: rgba(108, 92, 231, 0.15); width: 88px; height: 88px;">
                <i class="fa-solid fa-motorcycle text-primary display-4"></i>
            </div>
            <h2 class="fw-extrabold text-white mb-1" style="letter-spacing: -0.5px;">PasaBuy Rider</h2>
            <p class="text-secondary fs-7">Campus Express Motor Delivery Portal</p>
        </div>

        <div class="rider-card shadow-lg">
            <div id="riderLoginErrorAlert" class="alert alert-danger p-2 fs-8 mb-3" style="display: none;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> <span id="riderLoginErrorMsg">Invalid credentials.</span>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary fw-bold fs-8 mb-1">Rider Username / Email</label>
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

            <button class="btn btn-primary w-100 py-3 fw-extrabold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border: none;" onclick="executeRiderLogin()">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Log In to Driver Dashboard
            </button>
        </div>

        <div class="text-center text-secondary fs-8 mt-3">
            Not a registered rider? Apply via student app or contact Admin.
        </div>
    </div>

    <!-- 2. RIDER DASHBOARD MAIN VIEW -->
    <div id="riderMainDashboardView" style="display: none;" class="flex-column flex-grow-1">
        
        <!-- Header -->
        <div class="rider-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" id="riderAvatarImg" class="rounded-circle border border-2 border-white" width="44" height="44" style="object-fit:cover;">
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:12px; height:12px;"></span>
                </div>
                <div>
                    <div class="fw-extrabold text-white fs-7 mb-0" id="riderNameText">Joey Mendoza</div>
                    <span class="status-badge-verified"><i class="fa-solid fa-circle-check me-1"></i> VERIFIED DRIVER</span>
                </div>
            </div>
            <button class="btn btn-outline-light btn-sm rounded-circle" onclick="logoutRider()" title="Logout">
                <i class="fa-solid fa-power-off"></i>
            </button>
        </div>

        <!-- Dashboard Content Body -->
        <div class="p-3 flex-grow-1 overflow-y-auto">

            <!-- Driver Vehicle Info Card -->
            <div class="rider-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-secondary fw-bold fs-8"><i class="fa-solid fa-shield-halved me-1 text-primary"></i> Registered Vehicle</span>
                    <span class="badge bg-success bg-opacity-25 text-success fw-bold fs-9" id="riderPlateBadge"><i class="fa-solid fa-motorcycle me-1"></i> MC-8888-JY</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-extrabold text-white mb-0" id="riderVehicleModelText">Honda Click 125i</h6>
                        <span class="text-secondary fs-9" id="riderLicenseText">License: N02-24-123456</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="riderGpsToggle" checked onchange="toggleRiderGps(this)">
                        <label class="form-check-label text-white fs-8 ms-1 fw-bold"><span class="pulse-online me-1"></span> Online</label>
                    </div>
                </div>
            </div>

            <!-- Stage 1 & 2 Active Delivery Dashboard -->
            <div id="riderActiveJobCard" class="rider-card border-warning" style="display: none; background: rgba(30, 41, 59, 0.95);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge bg-warning text-dark fw-extrabold fs-8" id="riderJobStageBadge"><i class="fa-solid fa-box me-1"></i> STAGE 1: SELLER PICKUP</span>
                    <span class="text-warning fw-bold fs-8" id="riderJobOrderPrice">₱450.00</span>
                </div>

                <h5 class="fw-extrabold text-white mb-1" id="riderJobItemTitle">Calculus 11th Edition Textbook</h5>
                <p class="text-secondary fs-8 mb-3" id="riderJobAddressesText">Pickup: Campus Library ➔ Dropoff: 123 Katipunan Ave</p>

                <!-- Contacts -->
                <div class="p-2.5 rounded-3 mb-3" style="background: rgba(15, 23, 42, 0.8); border: 1px solid #334155;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="text-secondary fs-8"><i class="fa-solid fa-store me-1 text-info"></i> Seller: <strong class="text-white" id="riderJobSellerName">Campus Seller</strong></span>
                        <a href="tel:09171112222" class="btn btn-outline-info btn-sm py-0 px-2 fs-9" id="riderJobSellerPhone"><i class="fa-solid fa-phone me-1"></i> Call Seller</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-secondary fs-8"><i class="fa-solid fa-user me-1 text-success"></i> Buyer: <strong class="text-white" id="riderJobBuyerName">Romeo Paolo</strong></span>
                        <a href="tel:09171234567" class="btn btn-outline-success btn-sm py-0 px-2 fs-9" id="riderJobBuyerPhone"><i class="fa-solid fa-phone me-1"></i> Call Buyer</a>
                    </div>
                </div>

                <!-- Leaflet Stage Route Map -->
                <div class="leaflet-map-container" id="riderDriverMap"></div>

                <!-- Stage Action Buttons -->
                <div class="mt-3" id="riderStageActionContainer">
                    <button class="nav-btn-stage shadow-lg" id="btnRiderStageAction" onclick="executeCurrentRiderStageAction()">
                        <i class="fa-solid fa-box-archive me-2"></i> Confirm Package Collected from Seller
                    </button>
                </div>
            </div>

            <!-- Open Job Alerts Section -->
            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="fw-extrabold text-white mb-0"><i class="fa-solid fa-bell me-1 text-warning"></i> Incoming Delivery Broadcasts</h6>
                    <button class="btn btn-dark btn-sm fs-9 text-secondary py-1" onclick="fetchRiderJobAlerts()"><i class="fa-solid fa-rotate me-1"></i> Refresh</button>
                </div>

                <div id="riderJobAlertsListContainer">
                    <div class="text-center p-4 rider-card text-secondary fs-8">
                        <i class="fa-solid fa-radar fa-spin me-2 text-primary"></i> Listening for nearby express delivery job broadcasts...
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
let currentRiderUser = null;
let currentActiveOrder = null;
let riderLeafletMap = null;
let riderMarker = null;
let targetMarker = null;

async function executeRiderLogin() {
    const user = document.getElementById('riderUsernameInput').value.trim();
    const pass = document.getElementById('riderPasswordInput').value.trim();
    const errAlert = document.getElementById('riderLoginErrorAlert');
    const errMsg = document.getElementById('riderLoginErrorMsg');

    if (!user || !pass) {
        errMsg.innerText = 'Please enter both username/email and password.';
        errAlert.style.display = 'block';
        return;
    }

    try {
        const res = await fetch('/pasabuy_otp.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'login', email: user, password: pass })
        });
        const data = await res.json();

        if (res.ok && data.success) {
            currentRiderUser = data.user;
            localStorage.setItem('pasabuy_rider_session', JSON.stringify(data));
            errAlert.style.display = 'none';

            document.getElementById('riderAuthView').style.display = 'none';
            document.getElementById('riderMainDashboardView').style.display = 'flex';
            document.getElementById('riderNameText').innerText = `${data.profile.firstName || 'Joey'} ${data.profile.lastName || 'Mendoza'}`.trim();

            fetchRiderJobAlerts();
            setInterval(fetchRiderJobAlerts, 5000);
            startRiderGpsPinger();
        } else {
            errMsg.innerText = data.message || 'Invalid Rider credentials.';
            errAlert.style.display = 'block';
        }
    } catch (e) {
        errMsg.innerText = 'Connection error logging into Rider Portal.';
        errAlert.style.display = 'block';
    }
}

function checkRiderSessionOnLoad() {
    try {
        const sessStr = localStorage.getItem('pasabuy_rider_session');
        if (sessStr) {
            const sess = JSON.parse(sessStr);
            if (sess && sess.user) {
                currentRiderUser = sess.user;
                document.getElementById('riderAuthView').style.display = 'none';
                document.getElementById('riderMainDashboardView').style.display = 'flex';
                document.getElementById('riderNameText').innerText = `${sess.profile.firstName || 'Joey'} ${sess.profile.lastName || 'Mendoza'}`.trim();

                fetchRiderJobAlerts();
                setInterval(fetchRiderJobAlerts, 5000);
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
    localStorage.removeItem('pasabuy_rider_session');
    document.getElementById('riderMainDashboardView').style.display = 'none';
    document.getElementById('riderAuthView').style.display = 'block';
}

async function fetchRiderJobAlerts() {
    if (!currentRiderUser) return;
    const userId = currentRiderUser.id || currentRiderUser.userId || 4;

    try {
        const res = await fetch(`/pasabuy_api.php?action=get_driver_job_broadcasts&user_id=${userId}`);
        if (res.ok) {
            const data = await res.json();
            const jobs = data.jobs || [];
            const container = document.getElementById('riderJobAlertsListContainer');

            if (jobs.length === 0) {
                container.innerHTML = `
                    <div class="text-center p-4 rider-card text-secondary fs-8">
                        <i class="fa-solid fa-circle-check me-2 text-success"></i> No pending broadcast jobs right now. You are online and ready!
                    </div>`;
                return;
            }

            let html = '';
            jobs.forEach(j => {
                html += `
                    <div class="rider-card border-primary mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-primary text-white fw-bold fs-9"><i class="fa-solid fa-bolt me-1"></i> EXPRESS DELIVERY JOB</span>
                            <span class="text-success fw-extrabold fs-8">₱${parseFloat(j.TotalPrice).toFixed(2)}</span>
                        </div>
                        <h6 class="fw-extrabold text-white mb-1">${j.ItemTitle}</h6>
                        <p class="text-secondary fs-8 mb-2"><i class="fa-solid fa-location-dot me-1 text-danger"></i> Dropoff: ${j.DeliveryAddress || 'Loyola Heights, Quezon City'}</p>
                        <button class="btn btn-success w-100 fw-extrabold fs-8 py-2 rounded-3" onclick="acceptRiderJob(${j.Id})">
                            <i class="fa-solid fa-hand-holding-hand me-1"></i> Accept Delivery Job
                        </button>
                    </div>`;
            });
            container.innerHTML = html;
        }
    } catch (e) {}
}

async function acceptRiderJob(orderId) {
    if (!currentRiderUser) return;
    const userId = currentRiderUser.id || currentRiderUser.userId || 4;

    try {
        const res = await fetch('/pasabuy_api.php?action=accept_driver_job', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ orderId: orderId, userId: userId })
        });
        const data = await res.json();

        if (res.ok && data.success) {
            alert('🎉 You accepted the delivery job! Starting Stage 1: Pickup from Seller.');
            fetchRiderActiveOrder(orderId);
        } else {
            alert(data.message || '⚠️ Job already accepted by another driver.');
            fetchRiderJobAlerts();
        }
    } catch (e) {
        alert('Connection error accepting job.');
    }
}

async function fetchRiderActiveOrder(orderId) {
    const userId = currentRiderUser.id || currentRiderUser.userId || 4;
    try {
        const res = await fetch(`/pasabuy_api.php?action=get_seller_orders&user_id=${userId}`);
        if (res.ok) {
            const orders = await res.json();
            const ord = orders.find(o => parseInt(o.Id) === parseInt(orderId)) || orders[0];
            if (ord) {
                renderActiveRiderJobCard(ord);
            }
        }
    } catch (e) {}
}

function renderActiveRiderJobCard(ord) {
    currentActiveOrder = ord;
    const card = document.getElementById('riderActiveJobCard');
    const badge = document.getElementById('riderJobStageBadge');
    const btn = document.getElementById('btnRiderStageAction');

    card.style.display = 'block';
    document.getElementById('riderJobItemTitle').innerText = ord.ItemTitle;
    document.getElementById('riderJobOrderPrice').innerText = `₱${parseFloat(ord.TotalPrice).toFixed(2)}`;
    document.getElementById('riderJobAddressesText').innerText = `Pickup: Campus Library ➔ Dropoff: ${ord.DeliveryAddress || 'Direct Address'}`;

    if (ord.Status === 'DRIVER_ASSIGNED') {
        badge.className = 'badge bg-warning text-dark fw-extrabold fs-8';
        badge.innerHTML = '<i class="fa-solid fa-box me-1"></i> STAGE 1: SELLER PICKUP';
        btn.className = 'nav-btn-stage shadow-lg';
        btn.innerHTML = '<i class="fa-solid fa-box-archive me-2"></i> Confirm Package Collected from Seller';
    } else if (ord.Status === 'OUT_FOR_DELIVERY') {
        badge.className = 'badge bg-info text-dark fw-extrabold fs-8';
        badge.innerHTML = '<i class="fa-solid fa-truck-fast me-1"></i> STAGE 2: BUYER DROPOFF';
        btn.className = 'btn btn-success w-100 fw-extrabold py-3 rounded-3 shadow-lg';
        btn.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Complete & Confirm Delivery to Buyer';
    } else if (ord.Status === 'DELIVERED') {
        card.style.display = 'none';
        alert('🎉 Delivery Job Completed!');
        return;
    }

    initRiderMap(ord);
}

function initRiderMap(ord) {
    const mapDiv = document.getElementById('riderDriverMap');
    if (!mapDiv) return;

    const riderLat = parseFloat(ord.RiderLat || 14.6488);
    const riderLng = parseFloat(ord.RiderLng || 121.0687);
    const targetLat = ord.Status === 'DRIVER_ASSIGNED' ? parseFloat(ord.SellerLat || 14.6488) : parseFloat(ord.DestLat || 14.6520);
    const targetLng = ord.Status === 'DRIVER_ASSIGNED' ? parseFloat(ord.SellerLng || 121.0687) : parseFloat(ord.DestLng || 121.0720);

    if (riderLeafletMap) {
        riderLeafletMap.remove();
        riderLeafletMap = null;
    }

    riderLeafletMap = L.map('riderDriverMap').setView([riderLat, riderLng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(riderLeafletMap);

    riderMarker = L.marker([riderLat, riderLng]).addTo(riderLeafletMap).bindPopup('🛵 Your Motorcycle Position').openPopup();
    targetMarker = L.marker([targetLat, targetLng]).addTo(riderLeafletMap).bindPopup(ord.Status === 'DRIVER_ASSIGNED' ? '📍 Seller Pickup Location' : '🏠 Buyer Dropoff Address');
}

async function executeCurrentRiderStageAction() {
    if (!currentActiveOrder || !currentRiderUser) return;
    const orderId = currentActiveOrder.Id;
    const userId = currentRiderUser.id || currentRiderUser.userId || 4;

    if (currentActiveOrder.Status === 'DRIVER_ASSIGNED') {
        const res = await fetch('/pasabuy_api.php?action=confirm_package_collected', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ orderId: orderId, userId: userId })
        });
        const data = await res.json();
        if (data.success) {
            alert('📦 Package Collected! Starting Stage 2: Route to Buyer Dropoff.');
            fetchRiderActiveOrder(orderId);
        }
    } else if (currentActiveOrder.Status === 'OUT_FOR_DELIVERY') {
        const res = await fetch('/pasabuy_api.php?action=confirm_package_delivered', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ orderId: orderId, userId: userId })
        });
        const data = await res.json();
        if (data.success) {
            alert('✅ Delivery completed successfully to buyer!');
            document.getElementById('riderActiveJobCard').style.display = 'none';
            fetchRiderJobAlerts();
        }
    }
}

function startRiderGpsPinger() {
    setInterval(async () => {
        if (!currentRiderUser) return;
        const userId = currentRiderUser.id || currentRiderUser.userId || 4;
        const isGpsActive = document.getElementById('riderGpsToggle').checked ? 1 : 0;

        if (navigator.geolocation && isGpsActive) {
            navigator.geolocation.getCurrentPosition(async (pos) => {
                await fetch('/pasabuy_api.php?action=update_rider_location', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        userId: userId,
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude,
                        isGpsActive: 1
                    })
                });
            }, async (err) => {
                await fetch('/pasabuy_api.php?action=update_rider_location', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ userId: userId, lat: 14.6488, lng: 121.0687, isGpsActive: 0 })
                });
            });
        }
    }, 10000);
}

function toggleRiderGps(checkbox) {
    if (!checkbox.checked) {
        alert('⚠️ GPS location sharing turned OFF. Buyers and sellers will see a GPS Lost warning.');
    }
}
</script>

</body>
</html>
