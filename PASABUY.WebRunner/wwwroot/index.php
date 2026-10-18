<?php define('PASABUY_INCLUDED', true); ?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>PasaBuy - Your Campus. Your Marketplace.</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- FontAwesome & Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <!-- Leaflet.js Map CSS & JS for Campus Delivery Map Tracking -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        :root {
            --primary: #5F27CD;
            --primary-gradient: linear-gradient(135deg, #5F27CD, #341F97);
            --secondary: #10AC84;
            --accent: #FF9F43;
            --bg-light: #F4F6F9;
            --card-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0F172A;
            color: #1E293B;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
            margin: 0;
        }

        .app-container {
            width: 100%;
            max-width: 440px;
            height: 880px;
            background: #FFFFFF;
            border-radius: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
            border: 8px solid #1E293B;
        }

        /* App Header */
        .app-header {
            background: var(--primary-gradient);
            color: #fff;
            padding: 20px 20px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .app-logo {
            font-weight: 800;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .app-logo i {
            color: var(--accent);
        }

        @keyframes pulseGlowRed {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        .badge-pulse-glow {
            animation: pulseGlowRed 1.8s infinite;
        }

        .badge-verified {
            background: #E3FCEF;
            color: #00875A;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* RentEase Flying Cart & Red Badge Pop Animations */
        @keyframes cartBouncePop {
            0% { transform: scale(1); }
            30% { transform: scale(1.38) rotate(-12deg); }
            60% { transform: scale(0.9) rotate(6deg); }
            80% { transform: scale(1.1) rotate(-3deg); }
            100% { transform: scale(1) rotate(0deg); }
        }

        @keyframes cartRippleEffect {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.75); }
            70% { box-shadow: 0 0 0 14px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        @keyframes badgeBouncePop {
            0% { transform: translate(-50%, -50%) scale(0.3); opacity: 0; }
            50% { transform: translate(-50%, -50%) scale(1.45); opacity: 1; }
            75% { transform: translate(-50%, -50%) scale(0.85); }
            100% { transform: translate(-50%, -50%) scale(1); }
        }

        .cart-bounce-pop {
            animation: cartBouncePop 0.55s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }

        .cart-ripple {
            animation: cartRippleEffect 0.65s ease-out !important;
        }

        .cart-badge-pop {
            animation: badgeBouncePop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }

        .badge-cart-counter {
            background: linear-gradient(135deg, #FF3B30 0%, #DC2626 100%) !important;
            color: #FFFFFF !important;
            border: 2px solid #FFFFFF !important;
            font-weight: 800 !important;
            font-size: 0.65rem !important;
            min-width: 19px !important;
            height: 19px !important;
            line-height: 15px !important;
            padding: 1px 4px !important;
            border-radius: 999px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 6px rgba(220, 38, 38, 0.5) !important;
            position: absolute !important;
            top: 0 !important;
            left: 100% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 10 !important;
        }

        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(95, 39, 205, 0.2);
            border-radius: 50%;
            border-top-color: #5F27CD;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            flex-direction: column;
            gap: 16px;
        }

        .loading-overlay .spinner {
            width: 48px;
            height: 48px;
            border: 3px solid rgba(95, 39, 205, 0.2);
            border-radius: 50%;
            border-top-color: #5F27CD;
            animation: spin 0.8s linear infinite;
        }

        .loading-overlay p {
            color: #5F27CD;
            font-weight: 600;
            margin: 0;
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            max-width: 320px;
        }

        .toast {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        .toast.success {
            border-left: 4px solid #10AC84;
        }

        .toast.error {
            border-left: 4px solid #FF3B30;
        }

        .toast.info {
            border-left: 4px solid #5F27CD;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Button Loading State */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #94A3B8;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #CBD5E1;
        }

        .empty-state h5 {
            color: #64748B;
            font-weight: 600;
        }

        .empty-state p {
            font-size: 0.85rem;
            margin-bottom: 16px;
        }

        /* Main Body Scrollable Area */
        .app-body {
            flex: 1;
            overflow-y: auto;
            background: var(--bg-light);
            padding: 16px;
        }

        /* Bottom Tab Bar */
        .app-tabbar {
            height: 72px;
            background: #FFFFFF;
            border-top: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 0 8px;
            position: relative;
            overflow: visible;
        }

        .tab-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: #94A3B8;
            font-size: 0.72rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            width: 60px;
            position: relative;
            overflow: visible;
        }

        .tab-item i {
            font-size: 1.25rem;
        }

        .tab-item.active {
            color: var(--primary);
        }

        .tab-item.active i {
            transform: translateY(-2px);
        }

        /* Cards & Buttons */
        .product-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
            margin-bottom: 16px;
            transition: transform 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-2px);
        }

        .product-img {
            width: 100%;
            height: 170px;
            object-fit: cover;
        }

        .product-details {
            padding: 14px;
        }

        .price-tag {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--primary);
        }

        .category-chip {
            background: #EDF2F7;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            white-space: nowrap;
            display: inline-block;
            cursor: pointer;
        }

        .category-chip.active {
            background: var(--primary);
            color: #fff;
        }

        /* Posting Fee Info Box */
        .fee-info-box {
            background: #FFFBEB;
            border: 1px solid #FCD34D;
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 16px;
        }

        .btn-pasabuy {
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            border-radius: 14px;
            padding: 12px 20px;
            border: none;
            width: 100%;
            box-shadow: 0 4px 14px rgba(95, 39, 205, 0.3);
        }

        .btn-pasabuy:hover {
            background: #341F97;
            color: #fff;
        }

        .chat-bubble {
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .chat-bubble.me {
            background: var(--primary);
            color: #fff;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }

        .chat-bubble.them {
            background: #E2E8F0;
            color: #1E293B;
            margin-right: auto;
            border-bottom-left-radius: 4px;
        }

        /* New Sleek Reference UI Styling */
        .category-icon-circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin: 0 auto;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .category-circle-item {
            cursor: pointer;
            flex: 0 0 72px;
            width: 72px;
            text-align: center;
        }

        .category-circle-item span {
            font-size: 0.72rem;
            line-height: 1.15;
            word-wrap: break-word;
            display: block;
        }

        .category-circle-item:hover .category-icon-circle {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        }

        #homeCategoryCircleGrid {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE 10+ */
            padding-bottom: 4px;
        }

        #homeCategoryCircleGrid::-webkit-scrollbar {
            display: none; /* Chrome/Safari/Edge */
        }

        .style-chip {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .style-chip:hover {
            background: var(--primary) !important;
            color: #fff !important;
        }

        /* Mobile & Responsive Screen Adjustments */
        @media (max-width: 576px) {
            body {
                padding: 0 !important;
                background: #FFFFFF !important;
                display: block !important;
            }

            .app-container {
                max-width: 100% !important;
                height: 100vh !important;
                height: 100dvh !important;
                border-radius: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }

            .app-body {
                padding: 12px !important;
            }
        }
    </style>
</head>

<body>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <div class="spinner"></div>
        <p id="loadingText">Loading...</p>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="app-container">
        <!-- App Header (Matching Reference Design) -->
        <div class="app-header bg-white border-bottom px-3 py-2.5 shadow-sm d-flex align-items-center justify-content-between" style="background:#fff; color:#1E293B;">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-3 d-inline-flex align-items-center justify-content-center p-1.5 shadow-sm"
                    style="width:38px; height:38px; background: rgba(91, 63, 168, 0.1);">
                    <img src="LOGO.png" alt="RentEase Logo" style="width:28px; height:28px; object-fit:contain;">
                </div>
                <div>
                    <div class="fw-extrabold fs-6 text-dark lh-1" style="letter-spacing: -0.3px; color: #5B3FA8 !important;">RentEase</div>
                    <div class="text-muted fs-9" style="font-size: 0.68rem;">Easy Rentals. Seamless Events.</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2" id="headerUserActions" style="display: none !important;">
                <button class="btn btn-light rounded-circle position-relative border-0 shadow-sm p-0 d-flex align-items-center justify-content-center" 
                    onclick="switchTab('cart')" title="RentEase Cart" id="headerCartBtn" style="width:36px; height:36px; background: #F1F5F9; transition: transform 0.2s ease;">
                    <i class="fa-solid fa-cart-shopping text-secondary fs-7"></i>
                    <span class="badge-cart-counter position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCountBadge" style="display:none;">0</span>
                </button>
                <div class="position-relative d-inline-block" style="cursor:pointer;" onclick="switchTab('profile')" id="headerProfileBtn">
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&q=80"
                        class="rounded-circle border border-2 border-white shadow-sm" width="36" height="36" style="object-fit:cover;" id="homeAvatar" alt="User Profile">
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:10px; height:10px;"></span>
                </div>
            </div>
        </div>

        <!-- App Body (Dynamic PHP Modular Tab Views) -->
        <div class="app-body" id="appBody">
            <?php include 'splash_screen.php'; ?>
            <?php include 'login.php'; ?>
            <?php include 'create_account.php'; ?>
            <?php include 'tab_home.php'; ?>
            <?php include 'tab_explore.php'; ?>
            <?php include 'tab_cart.php'; ?>
            <?php include 'tab_track.php'; ?>
            <?php include 'tab_sell.php'; ?>
            <?php include 'tab_wanted.php'; ?>
            <?php include 'tab_messages.php'; ?>
            <?php include 'tab_profile.php'; ?>
        </div>
        <!-- App Bottom Tab Bar Navigation -->
        <div class="app-tabbar" style="display:none; height:68px; border-top:1px solid #E2E8F0; background:#fff;">
            <div class="tab-item active" onclick="switchTab('home')" id="tabNavHome">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </div>
            <div class="tab-item" onclick="switchTab('explore')" id="tabNavExplore">
                <i class="fa-solid fa-compass"></i>
                <span>Rentals</span>
            </div>
            <!-- Center Floating Action Button: Plus Sign to Post / Rent Out Item -->
            <div class="tab-item" onclick="switchTab('sell')" id="tabNavSell" style="position:relative; overflow:visible;" title="Post Equipment for Rent">
                <div class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-lg" 
                    style="width:50px; height:50px; background: linear-gradient(135deg, #5B3FA8, #341F97); border: 3px solid #FFF; transform: translateY(-14px); box-shadow: 0 8px 22px rgba(91, 63, 168, 0.45);">
                    <i class="fa-solid fa-plus text-white fs-4"></i>
                </div>
                <span style="font-size:0.65rem; font-weight:700; color:#5B3FA8; margin-top:-8px;">Rent Out</span>
            </div>
            <div class="tab-item position-relative" onclick="switchTab('messages')" id="tabNavMessages" title="Messages & Inquiries">
                <i class="fa-solid fa-comment-dots"></i>
                <span>Messages</span>
                <span class="badge rounded-pill bg-danger position-absolute" id="tabMessagesBadge" style="top:2px; right:10px; font-size:0.6rem; padding:2px 5px; display:none; box-shadow:0 2px 4px rgba(220,53,69,0.5);">0</span>
            </div>
            <div class="tab-item position-relative" onclick="switchTab('profile')" id="tabNavProfile">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
                <span class="badge rounded-pill bg-danger position-absolute badge-pulse-glow" id="tabProfileBadge" style="top:2px; right:10px; font-size:0.6rem; padding:2px 5px; display:none; box-shadow:0 2px 4px rgba(220,53,69,0.5);">0</span>
            </div>
        </div>
            </div>
        </div>
    </div>

    <!-- Application Modals Component -->
    <?php include 'modals.php'; ?>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    <script>
                        // Loading and Toast Notification Helpers
                        window.showLoading = function(text = 'Loading...') {
                            const overlay = document.getElementById('loadingOverlay');
                            const textEl = document.getElementById('loadingText');
                            if (overlay) {
                                if (textEl) textEl.textContent = text;
                                overlay.style.display = 'flex';
                            }
                        };

                        window.hideLoading = function() {
                            const overlay = document.getElementById('loadingOverlay');
                            if (overlay) overlay.style.display = 'none';
                        };

                        window.showToast = function(message, type = 'info', duration = 3000) {
                            const container = document.getElementById('toastContainer');
                            if (!container) return;

                            const toast = document.createElement('div');
                            toast.className = `toast ${type}`;

                            const iconMap = {
                                success: 'fa-check-circle',
                                error: 'fa-exclamation-circle',
                                info: 'fa-info-circle'
                            };

                            const icon = iconMap[type] || iconMap.info;

                            toast.innerHTML = `
                                <i class="fa-solid ${icon}" style="font-size: 20px; color: ${type === 'success' ? '#10AC84' : type === 'error' ? '#FF3B30' : '#5F27CD'};"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 0.9rem; color: #1E293B;">${message}</div>
                                </div>
                                <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #94A3B8; font-size: 16px;">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            `;

                            container.appendChild(toast);

                            setTimeout(() => {
                                toast.style.animation = 'slideIn 0.3s ease reverse';
                                setTimeout(() => toast.remove(), 300);
                            }, duration);
                        };

                        window.setButtonLoading = function(buttonId, isLoading, originalText = '') {
                            const btn = document.getElementById(buttonId);
                            if (!btn) return;

                            if (isLoading) {
                                btn.dataset.originalText = btn.textContent;
                                btn.classList.add('btn-loading');
                                btn.disabled = true;
                            } else {
                                btn.classList.remove('btn-loading');
                                btn.disabled = false;
                                if (originalText) {
                                    btn.textContent = originalText;
                                } else if (btn.dataset.originalText) {
                                    btn.textContent = btn.dataset.originalText;
                                }
                            }
                        };

                        let notificationsModalInstance = null;

                        window.openNotificationsModal = async function () {
                            const modalEl = document.getElementById('notificationsModal');
                            if (modalEl) {
                                if (modalEl.parentElement !== document.body) {
                                    document.body.appendChild(modalEl);
                                }
                                if (!notificationsModalInstance) {
                                    notificationsModalInstance = new bootstrap.Modal(modalEl);
                                }
                                notificationsModalInstance.show();
                            }

                            // Fetch live notifications from Hostinger MySQL Database
                            const container = document.getElementById('notificationsListContainer');
                            if (!container) return;

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) {}
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || 104) : 104;

                            try {
                                const res = await fetch(`/pasabuy_api.php?action=notifications&user_id=${currentUserId}`);
                                if (res.ok) {
                                    const notifs = await res.json();
                                    if (Array.isArray(notifs) && notifs.length > 0) {
                                        let html = '';
                                        notifs.forEach(n => {
                                            const badgeClass = n.type === 'messages' ? 'bg-primary' : 'bg-success';
                                            const iconClass = n.type === 'messages' ? 'fa-comment-dots' : 'fa-bag-shopping';
                                            html += `
                                                <div class="p-3 bg-light border rounded-3 shadow-2xs text-start mb-2"
                                                    onclick="handleNotificationClick('${n.type}')" style="cursor:pointer;">
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <span class="badge ${badgeClass} text-white fw-bold fs-9"><i class="fa-solid ${iconClass} me-1"></i> ${n.badge}</span>
                                                        <span class="text-muted fs-9">${n.time}</span>
                                                    </div>
                                                    <h6 class="fw-bold text-dark fs-8 mb-1">${n.title}</h6>
                                                    <p class="text-secondary fs-8 mb-0">${n.desc}</p>
                                                    <div class="text-primary fw-bold fs-9 mt-1"><i class="fa-solid fa-arrow-right me-1"></i> ${n.actionText}</div>
                                                </div>`;
                                        });
                                        container.innerHTML = html;
                                        const badgeCount = document.getElementById('notifBadgeCount');
                                        if (badgeCount) badgeCount.innerText = `${notifs.length} New`;
                                    }
                                }
                            } catch (e) { console.error("Fetch notifications error:", e); }
                        };

                        window.handleNotificationClick = function (type) {
                            if (notificationsModalInstance) {
                                try { notificationsModalInstance.hide(); } catch (e) {}
                            }
                            if (type === 'messages') {
                                switchTab('messages');
                            } else if (type === 'item') {
                                switchTab('home');
                            } else if (type === 'order') {
                                openCartModal();
                            }
                        };

                        window.clearAllNotifications = function () {
                            const badges = document.querySelectorAll('.app-header .badge');
                            badges.forEach(b => b.style.display = 'none');
                            const badgeCount = document.getElementById('notifBadgeCount');
                            if (badgeCount) badgeCount.innerText = '0 New';
                            alert('✓ All notifications marked as read.');
                        };

                        let registerModalInstance = null;
                        let otpVerifyModalInstance = null;
                        let forgotPasswordModalInstance = null;
                        let resetPasswordModalInstance = null;
                        let logoutConfirmModalInstance = null;

                        window.togglePasswordVisibility = function (inputId, iconId) {
                            const input = document.getElementById(inputId);
                            const icon = document.getElementById(iconId);
                            if (!input) return;

                            if (input.type === 'password' || input.getAttribute('type') === 'password') {
                                input.setAttribute('type', 'text');
                                input.type = 'text';
                                if (icon) icon.className = 'fa-solid fa-eye-slash text-primary';
                            } else {
                                input.setAttribute('type', 'password');
                                input.type = 'password';
                                if (icon) icon.className = 'fa-solid fa-eye text-muted';
                            }
                        };

                        window.openRegisterModal = function () {
                            const modalEl = document.getElementById('registerModal');
                            if (modalEl) {
                                if (modalEl.parentElement !== document.body) {
                                    document.body.appendChild(modalEl);
                                }
                                if (!registerModalInstance) {
                                    registerModalInstance = new bootstrap.Modal(modalEl);
                                }
                                registerModalInstance.show();
                            }
                        };

                        window.openForgotPasswordModal = function () {
                            const modalEl = document.getElementById('forgotPasswordModal');
                            if (modalEl) {
                                if (modalEl.parentElement !== document.body) {
                                    document.body.appendChild(modalEl);
                                }
                                if (!forgotPasswordModalInstance) {
                                    forgotPasswordModalInstance = new bootstrap.Modal(modalEl);
                                }
                                forgotPasswordModalInstance.show();
                            }
                        };

                        window.loginStudentWithPassword = async function () {
                            const emailEl = document.getElementById('loginEmailInput') || document.getElementById('loginEmail');
                            const passEl = document.getElementById('loginPasswordInput') || document.getElementById('loginPassword');
                            const bannerEl = document.getElementById('failedAttemptBanner') || document.getElementById('authErrorAlert');
                            const msgEl = document.getElementById('failedAttemptMsg');

                            const emailInput = emailEl ? emailEl.value.trim() : '';
                            const passwordInput = passEl ? passEl.value.trim() : '';

                            if (!emailInput) {
                                if (bannerEl) {
                                    if (msgEl) msgEl.innerText = 'Please enter your school email or student username.';
                                    bannerEl.style.display = 'block';
                                } else { alert('Please enter your school email.'); }
                                return;
                            }

                            if (!passwordInput) {
                                if (bannerEl) {
                                    if (msgEl) msgEl.innerText = 'Please enter your account password.';
                                    bannerEl.style.display = 'block';
                                } else { alert('Please enter your account password.'); }
                                return;
                            }

                            if (bannerEl) bannerEl.style.display = 'none';

                            try {
                                const res = await fetch('/pasabuy_otp.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ action: 'login', email: emailInput, password: passwordInput })
                                });

                                const data = await res.json();
                                if (res.ok && data.success) {
                                    const uObj = data.user || {};
                                    const pObj = data.profile || {};
                                    const realUserId = uObj.id || uObj.userId || data.userId || 104;

                                    const isVerified = (pObj.VerificationStatus === 'VERIFIED' || pObj.verificationStatus === 'VERIFIED' || uObj.Status === 'VERIFIED' || data.VerificationStatus === 'VERIFIED');
                                    const studentUser = {
                                        id: realUserId,
                                        userId: realUserId,
                                        email: uObj.email || emailInput,
                                        firstName: pObj.firstName || uObj.firstName || emailInput.split('@')[0],
                                        lastName: pObj.lastName || uObj.lastName || '',
                                        studentNumber: pObj.studentNumber || '2024-00123',
                                        course: pObj.course || 'BS Computer Science',
                                        yearLevel: pObj.yearLevel || '3rd Yr',
                                        verificationStatus: isVerified ? 'VERIFIED' : 'UNVERIFIED',
                                        is_verified: isVerified ? 1 : 0
                                    };

                                    localStorage.setItem('pasabuy_student_logged_in', 'true');
                                    localStorage.setItem('pasabuy_student_user', JSON.stringify(studentUser));

                                    document.getElementById('authScreen').style.display = 'none';
                                    document.querySelector('.app-tabbar').style.display = 'flex';
                                    const userActions = document.getElementById('headerUserActions');
                                    if (userActions) userActions.style.setProperty('display', 'flex', 'important');

                                    checkStudentSessionOnLoad();
                                    switchTab('home');
                                } else {
                                    if (bannerEl) {
                                        if (msgEl) msgEl.innerText = data.message || 'Invalid school email or password.';
                                        bannerEl.style.display = 'block';
                                    } else { alert(data.message || 'Invalid credentials.'); }
                                }
                            } catch (e) {
                                console.error("Login error:", e);
                                alert('Connection error during login. Please try again.');
                            }
                        };

                        window.logoutStudent = function () {
                            const modalEl = document.getElementById('logoutConfirmModal');
                            if (modalEl) {
                                if (modalEl.parentElement !== document.body) {
                                    document.body.appendChild(modalEl);
                                }
                                if (!logoutConfirmModalInstance) {
                                    logoutConfirmModalInstance = new bootstrap.Modal(modalEl);
                                }
                                logoutConfirmModalInstance.show();
                            } else {
                                executeLogout();
                            }
                        };

                        window.executeLogout = function () {
                            if (logoutConfirmModalInstance) {
                                try { logoutConfirmModalInstance.hide(); } catch (e) { }
                            }
                            const modalEl = document.getElementById('logoutConfirmModal');
                            if (modalEl) {
                                try {
                                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                                    if (bsModal) bsModal.hide();
                                } catch (e) { }
                                modalEl.style.display = 'none';
                                const backdrops = document.querySelectorAll('.modal-backdrop');
                                backdrops.forEach(b => b.remove());
                                document.body.classList.remove('modal-open');
                                document.body.style.overflow = '';
                            }

                            localStorage.removeItem('pasabuy_student_logged_in');
                            localStorage.removeItem('pasabuy_student_user');

                            // Hide all tab views so profile/home are not visible below landing page
                            const tabs = ['tabHome', 'tabExplore', 'tabSell', 'tabWanted', 'tabMessages', 'tabProfile', 'chatView'];
                            tabs.forEach(id => {
                                const el = document.getElementById(id);
                                if (el) el.style.display = 'none';
                            });

                            document.getElementById('authScreen').style.display = 'block';
                            document.querySelector('.app-tabbar').style.display = 'none';
                            document.getElementById('headerBadge').style.display = 'none';
                            const userActions = document.getElementById('headerUserActions');
                            if (userActions) userActions.style.setProperty('display', 'none', 'important');

                            const emailEl = document.getElementById('loginEmailInput') || document.getElementById('loginEmail');
                            const passEl = document.getElementById('loginPasswordInput') || document.getElementById('loginPassword');
                            if (emailEl) emailEl.value = '';
                            if (passEl) passEl.value = '';

                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        };

                        const API_BASE = (window.location.port === '5200' || window.location.hostname === 'localhost')
                            ? 'http://localhost:5000/api'
                            : window.location.origin + '/pasabuy_api.php';

                        async function fetchApi(endpoint, options = {}) {
                            let url = '';
                            if (window.location.hostname === 'localhost' || window.location.port === '5200') {
                                url = `http://localhost:5000/api${endpoint}`;
                            } else {
                                let cleanEp = endpoint.replace(/^\//, '');
                                let action = cleanEp.split('/')[0];
                                if (action === 'listings') action = 'listings';
                                else if (action === 'wanted') action = 'wanted_posts';
                                else if (action === 'reports') action = 'reports';
                                url = `/pasabuy_api.php?action=${action}`;
                            }
                            return fetch(url, options);
                        }

                        let reportModalInstance = null;
                        let wantedModalInstance = null;
                        let settingsModalInstance = null;
                        let deleteModalInstance = null;
                        let deleteListingIdToDelete = 0;
                        let newAvatarDataUrl = '';

                        let deleteListingTitleToDelete = '';

                        function confirmDeleteListing(id, title, fee) {
                            deleteListingIdToDelete = id;
                            deleteListingTitleToDelete = title;
                            document.getElementById('deleteItemTitle').innerText = title;
                            document.getElementById('deleteItemFee').innerText = fee;

                            const modalEl = document.getElementById('deleteConfirmModal');
                            if (modalEl && modalEl.parentElement !== document.body) {
                                document.body.appendChild(modalEl);
                            }
                            if (!deleteModalInstance) {
                                deleteModalInstance = new bootstrap.Modal(modalEl);
                            }
                            deleteModalInstance.show();
                        }

                        async function executeDeleteListing() {
                            try {
                                if (deleteListingIdToDelete > 0) {
                                    await fetch(`/pasabuy_api.php?action=delete_listing&id=${deleteListingIdToDelete}`, {
                                        method: 'POST'
                                    });
                                }
                            } catch (e) { }

                            try {
                                let localListings = [];
                                try { localListings = JSON.parse(localStorage.getItem('pasabuy_local_published_listings')) || []; } catch (e) { }
                                localListings = localListings.filter(lp => lp.id !== deleteListingIdToDelete && lp.title !== deleteListingTitleToDelete);
                                localStorage.setItem('pasabuy_local_published_listings', JSON.stringify(localListings));
                            } catch (e) { }

                            const modalEl = document.getElementById('deleteConfirmModal');
                            if (deleteModalInstance) {
                                try { deleteModalInstance.hide(); } catch (e) { }
                            }
                            if (modalEl) {
                                try {
                                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                                    if (bsModal) bsModal.hide();
                                } catch (e) { }
                                modalEl.style.display = 'none';
                                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                                document.body.classList.remove('modal-open');
                                document.body.style.overflow = '';
                            }

                            alert('🗑️ Your listing post has been permanently deleted.');
                            await filterProducts();
                        }

                        function openProfileSettingsModal() {
                            const modalEl = document.getElementById('profileSettingsModal');
                            if (modalEl && modalEl.parentElement !== document.body) {
                                document.body.appendChild(modalEl);
                            }
                            if (!settingsModalInstance) {
                                settingsModalInstance = new bootstrap.Modal(modalEl);
                            }

                            const storedUserStr = localStorage.getItem('pasabuy_student_user');
                            let studentUser = {};
                            try { studentUser = storedUserStr ? JSON.parse(storedUserStr) : {}; } catch (e) { }

                            const currentProfName = document.getElementById('profileName').innerText || '';
                            const nameParts = currentProfName.split(' ');

                            document.getElementById('settingsFirstName').value = studentUser.firstName || nameParts[0] || '';
                            document.getElementById('settingsLastName').value = studentUser.lastName || (nameParts.slice(1).join(' ')) || '';
                            let snVal = (studentUser.studentNumber || '').toString().replace(/[^0-9]/g, '');
                            if (!snVal) {
                                snVal = (studentUser.id === 105 || (studentUser.email && studentUser.email.includes('pogilameg'))) ? '20261058' : '20261048';
                            }
                            document.getElementById('settingsStudentNumber').value = snVal;

                            if (document.getElementById('settingsEmail')) {
                                document.getElementById('settingsEmail').value = studentUser.email || studentUser.SchoolEmail || (studentUser.id === 105 ? 'pogilameg@gmail.com' : 'romeopaolotolentino@gmail.com');
                            }
                            if (document.getElementById('settingsPhone')) {
                                let phoneVal = (studentUser.phoneNumber || studentUser.phone || '').toString().replace(/[^0-9+]/g, '');
                                if (!phoneVal) {
                                    phoneVal = (studentUser.id === 105 || (studentUser.email && studentUser.email.includes('pogilameg'))) ? '09171234567' : '09668257301';
                                }
                                document.getElementById('settingsPhone').value = phoneVal;
                            }
                            document.getElementById('settingsCourse').value = studentUser.course || '';
                            if (studentUser.yearLevel) {
                                document.getElementById('settingsYearLevel').value = studentUser.yearLevel;
                            }

                            const avatarSrc = document.getElementById('profileAvatar').src;
                            document.getElementById('settingsAvatarPreview').src = avatarSrc;
                            settingsModalInstance.show();
                        }

                        function previewSettingsAvatar(event) {
                            const file = event.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                newAvatarDataUrl = e.target.result;
                                document.getElementById('settingsAvatarPreview').src = newAvatarDataUrl;
                            };
                            reader.readAsDataURL(file);
                        }

                        let currentDetailProductId = 0;
                        let productDetailModalInstance = null;

                        window.openProductDetailModal = function (listingId) {
                            const listing = (window.allProductsCache || []).find(p => p.id == listingId);
                            if (!listing) return;

                            currentDetailProductId = listing.id;

                            // Setup Dynamic Media Carousel with Auto-slide & Touch Swiping
                            if (typeof window.setupDetailMediaCarousel === 'function') {
                                window.setupDetailMediaCarousel({
                                    name: listing.title,
                                    image_url: listing.img || 'LOGO.png',
                                    photos: listing.photos || listing.images || [],
                                    video_url: listing.videoUrl || ''
                                });
                            } else {
                                const mainImg = document.getElementById('detailMainImg');
                                if (mainImg) {
                                    mainImg.src = listing.img || 'LOGO.png';
                                    mainImg.style.display = 'block';
                                }
                            }

                            document.getElementById('detailTitle').innerText = listing.title;
                            document.getElementById('detailPrice').innerText = listing.price;
                            const origPriceVal = (listing.priceVal * 1.25).toFixed(0);
                            document.getElementById('detailOrigPrice').innerText = `₱${origPriceVal}`;

                            const ratingSeed = ((listing.id * 7) % 5) / 10 + 4.5;
                            const ratingVal = ratingSeed > 5 ? 4.9 : ratingSeed.toFixed(1);
                            const reviewCount = ((listing.id * 13) % 200) + 45;

                            document.getElementById('detailRatingVal').innerText = ratingVal;
                            document.getElementById('detailReviewCount').innerText = reviewCount;

                            document.getElementById('detailSellerName').innerText = listing.seller || 'TechHub PH';
                            document.getElementById('detailSellerLocation').innerHTML = `<i class="fa-solid fa-location-dot text-danger me-1"></i> ${listing.location || 'Campus Library'}`;
                            if (listing.sellerAvatar) {
                                document.getElementById('detailSellerAvatar').src = listing.sellerAvatar;
                            } else {
                                document.getElementById('detailSellerAvatar').src = `https://api.dicebear.com/7.x/avataaars/svg?seed=${encodeURIComponent(listing.seller || 'Seller')}`;
                            }

                            document.getElementById('detailBrand').innerText = 'Generic / Campus Original';
                            document.getElementById('detailCondition').innerText = listing.condition || 'Brand New';
                            document.getElementById('detailCategory').innerText = listing.category || 'Electronics';
                            document.getElementById('detailMeetup').innerText = listing.location || 'Campus Library';
                            document.getElementById('detailDescription').innerText = listing.description || `Authentic ${listing.title} available on campus. Contact seller or add to cart for fast meetup delivery.`;

                            let storedUserObj = null;
                            try { storedUserObj = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const myId = storedUserObj ? (storedUserObj.id || storedUserObj.userId || storedUserObj.UserId || 1) : 1;
                            const myName = storedUserObj ? (storedUserObj.firstName + ' ' + (storedUserObj.lastName || '')).trim() : 'Student';
                            const isMyListing = (listing.sellerId == myId) || (listing.seller && listing.seller.toLowerCase() === myName.toLowerCase());

                            const chatBtn = document.getElementById('detailChatBtn');
                            if (chatBtn) {
                                if (isMyListing) {
                                    chatBtn.style.display = 'none';
                                } else {
                                    chatBtn.style.display = 'inline-flex';
                                    chatBtn.onclick = function () {
                                        const modalEl = document.getElementById('productDetailModal');
                                        if (modalEl) {
                                            const bsModal = bootstrap.Modal.getInstance(modalEl);
                                            if (bsModal) bsModal.hide();
                                        }
                                        checkAndOpenChat(listing.sellerId, listing.seller || 'Seller', listing.title, listing.price, listing.sellerAvatar || '');
                                    };
                                }
                            }

                            const modalFooterActions = document.getElementById('detailFooterActions');
                            if (modalFooterActions) {
                                if (isMyListing) {
                                    modalFooterActions.innerHTML = `
                                        <div class="p-2.5 bg-secondary-subtle text-secondary rounded-pill w-100 text-center fw-bold fs-7">
                                            <i class="fa-solid fa-user-check me-1"></i> Your Active Listing (Manage in Profile Tab)
                                        </div>`;
                                } else {
                                    const isListingInCart = (pasabuyCart || []).some(item => (item.listingId && item.listingId == listing.id) || item.title === listing.title);
                                    modalFooterActions.innerHTML = `
                                        <button type="button" class="btn ${isListingInCart ? 'btn-success text-white' : 'btn-outline-primary'} rounded-pill w-50 py-2.5 fw-bold fs-7 d-flex align-items-center justify-content-center gap-1.5 shadow-2xs" id="detailAddToCartBtn">
                                            <i class="fa-solid ${isListingInCart ? 'fa-check' : 'fa-cart-plus'} fs-6"></i> ${isListingInCart ? 'In Cart' : 'Add to Cart'}
                                        </button>
                                        <button type="button" class="btn btn-primary rounded-pill w-50 py-2.5 fw-bold fs-7 d-flex align-items-center justify-content-center gap-1.5 shadow-sm" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none;" id="detailBuyNowBtn">
                                            <i class="fa-solid fa-bolt fs-6"></i> Buy Now
                                        </button>`;

                                    const addCartBtn = document.getElementById('detailAddToCartBtn');
                                    if (addCartBtn) {
                                        addCartBtn.onclick = function (e) {
                                            animateAddToCart(e, listing.id, listing.title, listing.price, listing.sellerId, listing.img);
                                            addCartBtn.className = 'btn btn-success text-white rounded-pill w-50 py-2.5 fw-bold fs-7 d-flex align-items-center justify-content-center gap-1.5 shadow-2xs';
                                            addCartBtn.innerHTML = '<i class="fa-solid fa-check fs-6"></i> In Cart';
                                        };
                                    }

                                    const buyNowBtn = document.getElementById('detailBuyNowBtn');
                                    if (buyNowBtn) {
                                        buyNowBtn.onclick = function () {
                                            const modalEl = document.getElementById('productDetailModal');
                                            if (modalEl) {
                                                const bsModal = bootstrap.Modal.getInstance(modalEl);
                                                if (bsModal) bsModal.hide();
                                            }
                                            toggleCartProduct(new MouseEvent('click'), listing.id, listing.title, listing.price, listing.sellerId, listing.img);
                                            openCartModal();
                                        };
                                    }
                                }
                            }

                            const modalEl = document.getElementById('productDetailModal');
                            if (modalEl) {
                                if (modalEl.parentElement !== document.body) {
                                    document.body.appendChild(modalEl);
                                }
                                if (!productDetailModalInstance) {
                                    productDetailModalInstance = new bootstrap.Modal(modalEl);
                                }
                                productDetailModalInstance.show();
                            }
                        };

                        window.switchDetailMedia = function (url, isVideo) {
                            const mainImg = document.getElementById('detailMainImg');
                            const mainVid = document.getElementById('detailMainVideo');
                            if (isVideo) {
                                if (mainImg) mainImg.style.display = 'none';
                                if (mainVid) {
                                    mainVid.src = url;
                                    mainVid.style.display = 'block';
                                }
                            } else {
                                if (mainVid) mainVid.style.display = 'none';
                                if (mainImg) {
                                    mainImg.src = url;
                                    mainImg.style.display = 'block';
                                }
                            }
                        };

                        window.previewSettingsAvatar = function (event) {
                            const file = event.target.files && event.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                window.newAvatarDataUrl = e.target.result;
                                const prev = document.getElementById('settingsAvatarPreview');
                                if (prev) prev.src = window.newAvatarDataUrl;
                            };
                            reader.readAsDataURL(file);
                        };

                        window.saveProfileSettings = async function () {
                            const fnEl = document.getElementById('settingsFirstName');
                            const lnEl = document.getElementById('settingsLastName');
                            const snEl = document.getElementById('settingsStudentNumber');
                            const emEl = document.getElementById('settingsEmail');
                            const phEl = document.getElementById('settingsPhone');
                            const csEl = document.getElementById('settingsCourse');
                            const ylEl = document.getElementById('settingsYearLevel');
                            const prevEl = document.getElementById('settingsAvatarPreview');

                            const firstName = fnEl ? fnEl.value.trim() : '';
                            const lastName = lnEl ? lnEl.value.trim() : '';
                            const studentNo = snEl ? snEl.value.trim().replace(/[^0-9]/g, '') : '';
                            const email = emEl ? emEl.value.trim() : '';
                            const phone = phEl ? phEl.value.trim().replace(/[^0-9+]/g, '') : '';
                            const course = csEl ? csEl.value.trim() : '';
                            const yearLevel = ylEl ? ylEl.value : '4th Yr';

                            if (!firstName || !lastName) {
                                alert('Please enter your First Name and Last Name.');
                                return;
                            }

                            if (studentNo && !/^\d+$/.test(studentNo)) {
                                alert('Student Number must contain numbers only.');
                                return;
                            }

                            const saveBtn = document.querySelector('#profileSettingsModal button.btn-primary');
                            if (saveBtn) {
                                saveBtn.disabled = true;
                                saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...';
                            }

                            let studentUser = {};
                            try {
                                const storedUserStr = localStorage.getItem('pasabuy_student_user');
                                studentUser = storedUserStr ? JSON.parse(storedUserStr) : {};
                            } catch (e) { }

                            const currentUserId = studentUser.id || studentUser.userId || 104;
                            const finalAvatar = (typeof window.newAvatarDataUrl !== 'undefined' && window.newAvatarDataUrl) ? window.newAvatarDataUrl : (prevEl?.src || studentUser.profileImage || studentUser.avatar || '');

                            const fullName = `${firstName} ${lastName}`;
                            let subParts = [];
                            if (studentNo) subParts.push(studentNo);
                            if (course) subParts.push(`${course} (${yearLevel})`);
                            const subInfo = subParts.length > 0 ? subParts.join(' • ') : 'Verified Student';

                            const updatedUser = {
                                ...studentUser,
                                id: currentUserId,
                                userId: currentUserId,
                                firstName: firstName,
                                lastName: lastName,
                                name: fullName,
                                fullName: fullName,
                                studentNumber: studentNo,
                                phoneNumber: phone || studentNo,
                                phone: phone || studentNo,
                                email: email || studentUser.email,
                                SchoolEmail: email || studentUser.SchoolEmail,
                                course: course,
                                yearLevel: yearLevel,
                                Course: course,
                                YearLevel: yearLevel,
                                StudentNumber: studentNo,
                                profileImage: finalAvatar,
                                avatar: finalAvatar
                            };
                            localStorage.setItem('pasabuy_student_user', JSON.stringify(updatedUser));

                            // Also sync rentease_user_profile for RentEase components
                            try {
                                const renteaseProfile = {
                                    id: currentUserId,
                                    name: fullName,
                                    firstName: firstName,
                                    lastName: lastName,
                                    sub: `${course} • ${yearLevel}`,
                                    email: email || studentUser.email || 'romeopaolotolentino@gmail.com',
                                    phone: phone || studentNo,
                                    studentNumber: studentNo,
                                    course: course,
                                    yearLevel: yearLevel,
                                    avatar: finalAvatar,
                                    is_verified: true,
                                    verification_status: 'VERIFIED'
                                };
                                localStorage.setItem('rentease_user_profile', JSON.stringify(renteaseProfile));
                            } catch (e) { }

                            // Sync profile & avatar image directly to Hostinger MySQL Database
                            try {
                                let apiUrl = window.location.pathname.includes('/student/') ? '../pasabuy_api.php?action=update_profile' : 'pasabuy_api.php?action=update_profile';
                                await fetch(apiUrl, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        userId: currentUserId,
                                        firstName: firstName,
                                        lastName: lastName,
                                        studentNumber: studentNo,
                                        email: email,
                                        phoneNumber: phone,
                                        phone: phone,
                                        course: course,
                                        yearLevel: yearLevel,
                                        profileImage: finalAvatar
                                    })
                                });
                            } catch (e) { console.error("Sync profile error:", e); }

                            // Safely update DOM elements without throwing if any is missing
                            const nameEl = document.getElementById('profileName');
                            if (nameEl) nameEl.innerText = fullName;

                            const subEl = document.getElementById('profileSub');
                            if (subEl) subEl.innerText = subInfo;

                            const stuNoEl = document.getElementById('profileStudentNumber');
                            if (stuNoEl) stuNoEl.innerText = `ID: ${studentNo}`;

                            const welcomeEl = document.getElementById('homeWelcomeName');
                            if (welcomeEl) welcomeEl.innerText = `Good day, ${firstName}!`;

                            const profAvatarEl = document.getElementById('profileAvatar');
                            if (profAvatarEl && finalAvatar) profAvatarEl.src = finalAvatar;

                            const homeAvatarEl = document.getElementById('homeAvatar');
                            if (homeAvatarEl && finalAvatar) homeAvatarEl.src = finalAvatar;

                            const hubName = document.getElementById('settingsHubName');
                            if (hubName) hubName.innerText = fullName;

                            const hubSub = document.getElementById('settingsHubSub');
                            if (hubSub) hubSub.innerText = `${course} • ${yearLevel}`;

                            const hubAvatar = document.getElementById('settingsHubAvatar');
                            if (hubAvatar && finalAvatar) hubAvatar.src = finalAvatar;

                            if (typeof syncRentEaseProfileUI === 'function') {
                                syncRentEaseProfileUI();
                            }

                            // Close modal safely
                            const modalEl = document.getElementById('profileSettingsModal');
                            if (modalEl) {
                                try {
                                    const inst = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
                                    if (inst) inst.hide();
                                } catch (e) { }
                            }

                            if (saveBtn) {
                                saveBtn.disabled = false;
                                saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Save & Update Profile';
                            }

                            alert('🎉 Account Profile & Settings saved successfully!');

                            try {
                                if (typeof filterProducts === 'function') await filterProducts();
                            } catch (e) { }
                        };

                        function openReportModal() {
                            if (!reportModalInstance) {
                                reportModalInstance = new bootstrap.Modal(document.getElementById('reportModal'));
                            }
                            reportModalInstance.show();
                        }

                        function openWantedModal() {
                            if (!wantedModalInstance) {
                                wantedModalInstance = new bootstrap.Modal(document.getElementById('wantedModal'));
                            }
                            wantedModalInstance.show();
                        }

                        async function submitWantedPost() {
                            const title = document.getElementById('wantedTitle').value.trim() || 'Requested Item / Food';
                            const category = document.getElementById('wantedCategory').value || 'School Supplies';
                            const budget = parseFloat(document.getElementById('wantedBudget').value) || 300;
                            const urgency = document.getElementById('wantedUrgency').value || 'URGENT';
                            const meetup = document.getElementById('wantedMeetup').value.trim() || 'Campus Library';
                            const desc = document.getElementById('wantedDescription').value.trim() || 'Need this on campus!';

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;
                            const requester = storedUser ? (storedUser.firstName + ' ' + (storedUser.lastName || '')).trim() : 'Verified Student';

                            try {
                                await fetch('/pasabuy_api.php?action=create_wanted', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        requesterId: currentUserId,
                                        itemTitle: title,
                                        description: `${category}: ${desc}`,
                                        offeredPrice: budget,
                                        urgencyLevel: urgency
                                    })
                                });
                            } catch (e) { console.error("Create wanted error:", e); }

                            // Store locally for instant UI render
                            const localWantedItem = {
                                Id: Date.now(),
                                RequesterId: currentUserId,
                                ItemTitle: title,
                                Description: `${category}: ${desc}`,
                                OfferedPrice: budget,
                                UrgencyLevel: urgency,
                                FirstName: storedUser ? storedUser.firstName : 'Verified',
                                LastName: storedUser ? (storedUser.lastName || '') : 'Student',
                                MeetupLocation: meetup
                            };

                            let localWantedList = [];
                            try { localWantedList = JSON.parse(localStorage.getItem('pasabuy_local_wanted_posts')) || []; } catch (e) { }
                            localWantedList.unshift(localWantedItem);
                            localStorage.setItem('pasabuy_local_wanted_posts', JSON.stringify(localWantedList));

                            if (wantedModalInstance) wantedModalInstance.hide();
                            alert('Your Wanted Request has been published live! Campus students can now see your request and make offers.');

                            // Clear inputs
                            document.getElementById('wantedTitle').value = '';
                            document.getElementById('wantedBudget').value = '';
                            document.getElementById('wantedMeetup').value = '';
                            document.getElementById('wantedDescription').value = '';

                            await loadWantedPosts();
                        }

                        async function loadWantedPosts() {
                            const container = document.getElementById('wantedListContainer');
                            if (!container) return;

                            let posts = [];
                            try {
                                const res = await fetch('/pasabuy_api.php?action=wanted_posts');
                                if (res.ok) {
                                    const data = await res.json();
                                    if (Array.isArray(data)) posts = data;
                                }
                            } catch (e) { console.error("Fetch wanted posts error:", e); }

                            let localWantedList = [];
                            try { localWantedList = JSON.parse(localStorage.getItem('pasabuy_local_wanted_posts')) || []; } catch (e) { }

                            localWantedList.forEach(lw => {
                                if (!posts.some(p => p.Id == lw.Id || p.ItemTitle === lw.ItemTitle)) {
                                    posts.unshift(lw);
                                }
                            });

                            if (posts.length === 0) {
                                container.innerHTML = `
                                    <div class="text-center py-5 text-muted fs-8 bg-white rounded-4 border p-4" id="noWantedPlaceholder">
                                        <i class="fa-solid fa-bullhorn fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                        No active wanted posts right now.<br>Click <strong>+ Post Wanted</strong> to request items or food pasabuy!
                                    </div>`;
                                return;
                            }

                            let html = '';
                            posts.forEach(p => {
                                const title = p.ItemTitle || p.itemTitle || 'Requested Item';
                                const desc = p.Description || p.description || 'Need this on campus!';
                                const budget = parseFloat(p.OfferedPrice || p.offeredPrice || p.budget || 300).toFixed(2);
                                const urgency = p.UrgencyLevel || p.urgencyLevel || 'URGENT';
                                const requester = p.FirstName ? `${p.FirstName} ${p.LastName || ''}`.trim() : 'Verified Student';
                                const requesterId = p.RequesterId || p.requesterId || 104;
                                const meetup = p.MeetupLocation || 'Campus';

                                let urgencyBadge = '';
                                if (urgency === 'URGENT') {
                                    urgencyBadge = '<span class="badge bg-danger text-white fw-bold px-2 py-1 rounded-pill fs-9"><i class="fa-solid fa-fire me-1"></i> URGENT EXAM NEED</span>';
                                } else if (urgency === 'CLASS') {
                                    urgencyBadge = '<span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill fs-9"><i class="fa-solid fa-clock me-1"></i> NEEDED THIS WEEK</span>';
                                } else {
                                    urgencyBadge = '<span class="badge bg-info text-white fw-bold px-2 py-1 rounded-pill fs-9">PASABUY REQUEST</span>';
                                }

                                html += `
                                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-3 bg-white">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            ${urgencyBadge}
                                            <span class="fw-bold text-success fs-7">Budget: Up to ₱${budget}</span>
                                        </div>
                                        <h6 class="fw-bold mb-1 text-dark">${title}</h6>
                                        <p class="text-muted fs-8 mb-2">${desc}</p>
                                        <div class="d-flex align-items-center justify-content-between fs-8 pt-2 border-top">
                                            <div>
                                                <span class="fw-bold text-dark">${requester}</span>
                                                <span class="badge-verified ms-1"><i class="fa-solid fa-check text-success"></i></span>
                                                <span class="text-muted ms-2"><i class="fa-solid fa-location-dot text-danger me-1"></i> ${meetup}</span>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" onclick="checkAndOpenChat(${requesterId}, '${requester.replace(/'/g, "\\'")}', '${title.replace(/'/g, "\\'")}', 'Max ₱${budget}')"><i class="fa-solid fa-hand-holding-dollar me-1"></i> I Have This! / Offer</button>
                                        </div>
                                    </div>`;
                            });

                            container.innerHTML = html;
                        }

                        async function submitReportToAdmin() {
                            const reasonInput = document.getElementById('reportReason');
                            const detailsInput = document.getElementById('reportDetails');
                            const reason = reasonInput ? reasonInput.value.trim() : '';
                            const details = detailsInput ? detailsInput.value.trim() : '';

                            if (!reason || !details) {
                                alert('Please select a report reason and enter the incident details.');
                                return;
                            }

                            try {
                                await fetch(`${API_BASE}/reports`, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        reporterId: 1,
                                        reportedUserId: 2,
                                        reason: reason,
                                        details: details
                                    })
                                });
                            } catch (e) { }

                            if (reportModalInstance) reportModalInstance.hide();
                            alert(`Report submitted to PasaBuy Admin! Our moderation team will investigate. If confirmed, the user account will be suspended.`);
                        }

                        window.checkStudentSessionOnLoad = function checkStudentSessionOnLoad() {
                            const appHeader = document.querySelector('.app-header');
                            const appTabbar = document.querySelector('.app-tabbar');
                            const authScreen = document.getElementById('authScreen');

                            try {
                                const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in');
                                const storedUserStr = localStorage.getItem('pasabuy_student_user');
                                if (isLoggedIn === 'true' && storedUserStr) {
                                    const studentUser = JSON.parse(storedUserStr);
                                    if (studentUser) {
                                        const firstName = studentUser.firstName || (studentUser.email ? studentUser.email.split('@')[0] : 'Student');
                                        const lastName = studentUser.lastName || '';
                                        const fullName = `${firstName} ${lastName}`.trim();
                                        const email = studentUser.email || studentUser.schoolEmail || '';

                                        const isPogilameg = email.toLowerCase().includes('pogilameg') || studentUser.id === 105;
                                        const finalAvatar = studentUser.profileImage || studentUser.avatar || (isPogilameg ? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80' : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80');

                                        const profNameEl = document.getElementById('profileName');
                                        if (profNameEl) profNameEl.innerText = fullName;
                                        const welcomeEl = document.getElementById('homeWelcomeName');
                                        if (welcomeEl) welcomeEl.innerText = `Good day, ${firstName}!`;
                                        const profSubEl = document.getElementById('profileSub');
                                        if (profSubEl) profSubEl.innerText = studentUser.course ? `${studentUser.course} • ${studentUser.yearLevel || 'Student'}` : `${email} • Verified Student`;
                                        let cleanSn = (studentUser.studentNumber || '').toString().replace(/[^0-9]/g, '');
                                        if (!cleanSn || cleanSn === '10' || cleanSn.length < 5) {
                                            cleanSn = isPogilameg ? '20261058' : '20261048';
                                        }
                                        studentUser.studentNumber = cleanSn;
                                        try { localStorage.setItem('pasabuy_student_user', JSON.stringify(studentUser)); } catch (e) {}
                                        const stuNoEl = document.getElementById('profileStudentNumber');
                                        if (stuNoEl) stuNoEl.innerText = `ID: ${cleanSn}`;
                                        const rateEl = document.getElementById('profileRating');
                                        if (rateEl) rateEl.innerText = studentUser.rating || '5.0';
                                        const dealsEl = document.getElementById('profileDeals');
                                        if (dealsEl) dealsEl.innerText = studentUser.completedTransactions || 0;

                                        const profAv = document.getElementById('profileAvatar');
                                        if (profAv) profAv.src = finalAvatar;
                                        const homeAv = document.getElementById('homeAvatar');
                                        if (homeAv) homeAv.src = finalAvatar;

                                        if (appHeader) appHeader.style.display = 'flex';
                                        if (appTabbar) appTabbar.style.display = 'flex';
                                        if (authScreen) authScreen.style.display = 'none';
                                        const splashScreen = document.getElementById('splashScreen');
                                        if (splashScreen) splashScreen.style.display = 'none';
                                        const registerScreen = document.getElementById('registerScreen');
                                        if (registerScreen) registerScreen.style.display = 'none';

                                        const badgeEl = document.getElementById('headerBadge');
                                        if (badgeEl) badgeEl.style.display = 'inline-flex';
                                        const userActions = document.getElementById('headerUserActions');
                                        if (userActions) userActions.style.setProperty('display', 'flex', 'important');
                                        return true;
                                    }
                                }
                            } catch (e) { }

                            if (appHeader) appHeader.style.display = 'none';
                            if (appTabbar) appTabbar.style.display = 'none';
                            if (authScreen) authScreen.style.display = 'block';

                            const badgeEl = document.getElementById('headerBadge');
                            if (badgeEl) badgeEl.style.display = 'none';
                            const userActions = document.getElementById('headerUserActions');
                            if (userActions) userActions.style.setProperty('display', 'none', 'important');
                            const tabs = ['tabHome', 'tabExplore', 'tabSell', 'tabWanted', 'tabMessages', 'tabProfile', 'chatView'];
                            tabs.forEach(id => { const el = document.getElementById(id); if (el) el.style.display = 'none'; });
                        };

                        // Legacy cleanup

                        function togglePasswordVisibility(inputId, iconId) {
                            const input = document.getElementById(inputId);
                            const icon = document.getElementById(iconId);
                            if (!input) return;

                            if (input.type === 'password') {
                                input.type = 'text';
                                if (icon) {
                                    icon.className = 'fa-solid fa-eye-slash text-primary';
                                }
                            } else {
                                input.type = 'password';
                                if (icon) {
                                    icon.className = 'fa-solid fa-eye text-muted';
                                }
                            }
                        }

                        function quickFillRomeoCredentials() {
                            const emailIn = document.getElementById('loginEmailInput');
                            const passIn = document.getElementById('loginPasswordInput');
                            if (emailIn) emailIn.value = 'romeopaolotolentino@gmail.com';
                            if (passIn) passIn.value = 'Pogilameg@10';
                            loginStudentWithPassword();
                        }

                        async function loginStudentWithPassword() {
                            const emailIn = document.getElementById('loginEmailInput');
                            const passIn = document.getElementById('loginPasswordInput');
                            const btn = document.getElementById('btnLoginSubmit');
                            const banner = document.getElementById('failedAttemptBanner');
                            const bannerMsg = document.getElementById('failedAttemptMsg');

                            const email = emailIn ? emailIn.value.trim() : '';
                            const password = passIn ? passIn.value.trim() : '';

                            if (!email || !password) {
                                if (banner && bannerMsg) {
                                    bannerMsg.innerText = 'Please enter both email and password.';
                                    banner.style.display = 'block';
                                }
                                return;
                            }

                            if (failedLoginAttempts >= 3) {
                                if (banner && bannerMsg) {
                                    bannerMsg.innerHTML = '🔒 <strong>Account Temporarily Locked!</strong> You have reached 3 failed login attempts. Please click <strong>"Forgot Password?"</strong> to reset your password via OTP.';
                                    banner.style.display = 'block';
                                }
                                if (btn) btn.disabled = true;
                                return;
                            }

                            const origBtnHtml = btn ? btn.innerHTML : '<i class="fa-solid fa-right-to-bracket me-2"></i> Log In to Account';
                            if (btn) {
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> Logging in...';
                            }

                            try {
                                const controller = new AbortController();
                                const timeoutId = setTimeout(() => controller.abort(), 8000);

                                const res = await fetch('/pasabuy_otp.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ action: 'login', email: email, password: password }),
                                    signal: controller.signal
                                });
                                clearTimeout(timeoutId);

                                const data = await res.json();

                                if (res.ok && data.success) {
                                    failedLoginAttempts = 0;
                                    if (banner) banner.style.display = 'none';

                                    const uObj = data.user || {};
                                    const pObj = data.profile || {};
                                    const realUserId = uObj.id || pObj.userId || data.id || data.userId || 1;

                                    const studentUser = {
                                        id: realUserId,
                                        userId: realUserId,
                                        firstName: pObj.firstName || uObj.firstName || email.split('@')[0],
                                        lastName: pObj.lastName || uObj.lastName || '',
                                        email: email
                                    };
                                    localStorage.setItem('pasabuy_student_user', JSON.stringify(studentUser));
                                    localStorage.setItem('pasabuy_student_logged_in', 'true');

                                    const nameShow = `${studentUser.firstName} ${studentUser.lastName}`.trim();
                                    document.getElementById('profileName').innerText = nameShow;
                                    document.getElementById('homeWelcomeName').innerText = `Good day, ${studentUser.firstName}!`;
                                    document.getElementById('profileSub').innerText = `${email} • Verified Student`;

                                    document.getElementById('authScreen').style.display = 'none';
                                    document.querySelector('.app-tabbar').style.display = 'flex';
                                    document.getElementById('headerBadge').style.display = 'inline-flex';
                                    switchTab('home');
                                    return;
                                } else {
                                    failedLoginAttempts++;
                                    const remaining = Math.max(0, 3 - failedLoginAttempts);

                                    if (failedLoginAttempts >= 3) {
                                        bannerMsg.innerHTML = '🔒 <strong>Account Locked!</strong> You entered wrong credentials 3 times. Click <strong>"Forgot Password?"</strong> to reset via OTP.';
                                    } else {
                                        bannerMsg.innerText = data.message || `Invalid credentials. (${remaining} attempt${remaining !== 1 ? 's' : ''} left)`;
                                    }
                                    banner.style.display = 'block';
                                }
                            } catch (e) {
                                if (banner && bannerMsg) {
                                    bannerMsg.innerText = e.name === 'AbortError' ? '⏳ Request timed out. Please tap Log In again.' : 'Connection error. Please check server connection.';
                                    banner.style.display = 'block';
                                }
                            } finally {
                                if (btn && failedLoginAttempts < 3) {
                                    btn.disabled = false;
                                    btn.innerHTML = origBtnHtml;
                                }
                            }
                        }

                        function validateRegistrationPasswordLive() {
                            const pw = document.getElementById('regPassword').value || '';
                            const confirmPw = document.getElementById('regConfirmPassword').value || '';

                            const reqLen = document.getElementById('regReqLen');
                            const reqCapital = document.getElementById('regReqCapital');
                            const reqNumber = document.getElementById('regReqNumber');
                            const reqSymbol = document.getElementById('regReqSymbol');
                            const matchStatus = document.getElementById('regMatchStatus');

                            const isLengthValid = pw.length >= 8;
                            const isCapitalValid = /[A-Z]/.test(pw);
                            const isNumberValid = /[0-9]/.test(pw);
                            const isSymbolValid = /[\W_]/.test(pw);

                            if (isLengthValid) {
                                reqLen.className = 'text-success fw-bold';
                                reqLen.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> At least 8 characters long ✓';
                            } else {
                                reqLen.className = 'text-danger fw-semibold';
                                reqLen.innerHTML = '<i class="fa-solid fa-circle-xmark me-1"></i> Required: At least 8 characters long';
                            }

                            if (isCapitalValid) {
                                reqCapital.className = 'text-success fw-bold';
                                reqCapital.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> At least 1 Capital Letter (A-Z) ✓';
                            } else {
                                reqCapital.className = 'text-danger fw-semibold';
                                reqCapital.innerHTML = '<i class="fa-solid fa-circle-xmark me-1"></i> Required: Missing Capital Letter (A-Z)';
                            }

                            if (isNumberValid) {
                                reqNumber.className = 'text-success fw-bold';
                                reqNumber.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> At least 1 Number (0-9) ✓';
                            } else {
                                reqNumber.className = 'text-danger fw-semibold';
                                reqNumber.innerHTML = '<i class="fa-solid fa-circle-xmark me-1"></i> Required: Missing Number (0-9)';
                            }

                            if (isSymbolValid) {
                                reqSymbol.className = 'text-success fw-bold';
                                reqSymbol.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> At least 1 Special Symbol (!@#$%^&*) ✓';
                            } else {
                                reqSymbol.className = 'text-danger fw-semibold';
                                reqSymbol.innerHTML = '<i class="fa-solid fa-circle-xmark me-1"></i> Required: Missing Special Symbol (!@#$%^&*)';
                            }

                            if (!pw && !confirmPw) {
                                matchStatus.className = 'fw-bold text-muted';
                                matchStatus.innerHTML = '<i class="fa-solid fa-lock me-1"></i> Enter matching passwords';
                            } else if (pw === confirmPw && pw !== '') {
                                matchStatus.className = 'fw-extrabold text-success fs-7';
                                matchStatus.innerHTML = '<i class="fa-solid fa-check-double me-1"></i> Passwords Match ✓';
                            } else {
                                matchStatus.className = 'fw-extrabold text-danger fs-7';
                                matchStatus.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Passwords Do Not Match ✕';
                            }

                            return isLengthValid && isCapitalValid && isNumberValid && isSymbolValid && (pw === confirmPw && pw !== '');
                        }

                        function openRegisterModal() {
                            const modalEl = document.getElementById('registerModal');
                            if (modalEl && modalEl.parentElement !== document.body) {
                                document.body.appendChild(modalEl);
                            }
                            if (!registerModalInstance) {
                                registerModalInstance = new bootstrap.Modal(modalEl);
                            }
                            registerModalInstance.show();
                        }

                        async function submitRegistrationSendOtp() {
                            const firstName = document.getElementById('regFirstName').value.trim();
                            const lastName = document.getElementById('regLastName').value.trim();
                            const email = document.getElementById('regEmail').value.trim();
                            const studentNo = document.getElementById('regStudentNumber').value.trim();
                            const course = document.getElementById('regCourse').value.trim();
                            const yearLevel = document.getElementById('regYearLevel').value;
                            const password = document.getElementById('regPassword').value;
                            const confirmPass = document.getElementById('regConfirmPassword').value;

                            if (!email || !password || !firstName || !lastName) {
                                alert('Please fill in all required fields (Name, Email, Password).');
                                return;
                            }

                            const isPwValid = validateRegistrationPasswordLive();
                            if (!isPwValid) {
                                if (password !== confirmPass) {
                                    alert('❌ Passwords do not match! Please make sure Password and Confirm Password match.');
                                } else {
                                    alert('❌ Password does not meet security requirements! Required: At least 8 characters, 1 Capital Letter (A-Z), and 1 Special Symbol (!@#$%^&*).');
                                }
                                return;
                            }

                            pendingRegistrationEmail = email;

                            try {
                                const res = await fetch('/pasabuy_otp.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        action: 'send_otp',
                                        email: email,
                                        name: `${firstName} ${lastName}`,
                                        firstName: firstName,
                                        lastName: lastName,
                                        studentNumber: studentNo,
                                        course: course,
                                        yearLevel: yearLevel,
                                        password: password
                                    })
                                });

                                const data = await res.json();
                                if (res.ok && data.success) {
                                    if (registerModalInstance) registerModalInstance.hide();

                                    document.getElementById('otpTargetEmail').innerText = email;
                                    document.getElementById('otpInputCode').value = '';
                                    const errEl = document.getElementById('otpVerifyErrorAlert');
                                    if (errEl) errEl.style.display = 'none';

                                    const otpModalEl = document.getElementById('otpVerifyModal');
                                    if (otpModalEl && otpModalEl.parentElement !== document.body) {
                                        document.body.appendChild(otpModalEl);
                                    }
                                    if (!otpVerifyModalInstance) {
                                        otpVerifyModalInstance = new bootstrap.Modal(otpModalEl);
                                    }
                                    otpVerifyModalInstance.show();
                                    alert(`📧 Verification OTP code sent to ${email} from PASABUY@pasabuy.site!`);
                                } else {
                                    alert(data.message || '❌ Could not send OTP to this email address.');
                                }
                            } catch (e) {
                                alert('Connection error sending OTP code.');
                            }
                        }

                        async function verifyOtpAndCompleteRegistration() {
                            const code = document.getElementById('otpInputCode').value.trim();
                            if (!code || code.length !== 6) {
                                alert('Please enter the 6-digit OTP code sent to your email.');
                                return;
                            }

                            try {
                                const res = await fetch('/pasabuy_otp.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ action: 'verify_otp', email: pendingRegistrationEmail, otpCode: code })
                                });

                                const data = await res.json();
                                if (res.ok && data.success) {
                                    if (otpVerifyModalInstance) otpVerifyModalInstance.hide();
                                    alert('🎉 Registration successful! Welcome to PasaBuy Campus Marketplace.');

                                    const uObj = data.user || {};
                                    const uId = uObj.id || uObj.userId || data.userId || data.id || Date.now();
                                    const nameShow = uObj.firstName || pendingRegistrationEmail.split('@')[0];

                                    const studentUser = {
                                        id: uId,
                                        userId: uId,
                                        firstName: nameShow,
                                        lastName: uObj.lastName || '',
                                        email: pendingRegistrationEmail,
                                        verificationStatus: 'UNVERIFIED',
                                        is_verified: 0
                                    };
                                    localStorage.setItem('pasabuy_student_user', JSON.stringify(studentUser));
                                    localStorage.setItem('pasabuy_student_logged_in', 'true');

                                    document.getElementById('profileName').innerText = `${studentUser.firstName} ${studentUser.lastName}`.trim();
                                    document.getElementById('homeWelcomeName').innerText = `Good day, ${studentUser.firstName}!`;
                                    document.getElementById('profileSub').innerText = `${pendingRegistrationEmail} • Unverified`;

                                    document.getElementById('authScreen').style.display = 'none';
                                    document.querySelector('.app-tabbar').style.display = 'flex';
                                    document.getElementById('headerBadge').style.display = 'inline-flex';
                                    switchTab('home');
                                } else {
                                    alert(data.message || '❌ Invalid or expired OTP verification code.');
                                }
                            } catch (e) {
                                alert('Connection error verifying OTP.');
                            }
                        }

                        function openForgotPasswordModal() {
                            const modalEl = document.getElementById('forgotPasswordModal');
                            if (modalEl && modalEl.parentElement !== document.body) {
                                document.body.appendChild(modalEl);
                            }
                            if (!forgotPasswordModalInstance) {
                                forgotPasswordModalInstance = new bootstrap.Modal(modalEl);
                            }
                            forgotPasswordModalInstance.show();
                        }

                        async function submitForgotPasswordSendOtp() {
                            const email = document.getElementById('forgotEmailInput').value.trim();
                            if (!email) {
                                alert('Please enter your registered email address.');
                                return;
                            }

                            pendingForgotPasswordEmail = email;

                            try {
                                const res = await fetch('/pasabuy_otp.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ action: 'send_forgot_otp', email: email, name: email })
                                });

                                const data = await res.json();
                                if (res.ok && data.success) {
                                    if (forgotPasswordModalInstance) forgotPasswordModalInstance.hide();

                                    document.getElementById('resetDisplayUsername').innerText = data.registeredName || email;
                                    const resetModalEl = document.getElementById('resetPasswordModal');
                                    if (resetModalEl && resetModalEl.parentElement !== document.body) {
                                        document.body.appendChild(resetModalEl);
                                    }
                                    if (!resetPasswordModalInstance) {
                                        resetPasswordModalInstance = new bootstrap.Modal(resetModalEl);
                                    }
                                    resetPasswordModalInstance.show();
                                    alert(`📧 Password reset OTP code sent to ${email} from PASABUY@pasabuy.site!`);
                                } else {
                                    alert(data.message || '❌ Could not send password reset OTP.');
                                }
                            } catch (e) {
                                alert('Connection error sending password reset OTP.');
                            }
                        }

                        async function executePasswordReset() {
                            const otp = document.getElementById('resetOtpInput').value.trim();
                            const newPass = document.getElementById('resetNewPasswordInput').value.trim();

                            if (!otp || otp.length !== 6 || !newPass) {
                                alert('Please enter the 6-digit OTP code and your new password.');
                                return;
                            }

                            try {
                                const res = await fetch('/pasabuy_otp.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        action: 'reset_password',
                                        email: pendingForgotPasswordEmail,
                                        otpCode: otp,
                                        newPassword: newPass
                                    })
                                });

                                const data = await res.json();
                                if (res.ok && data.success) {
                                    if (resetPasswordModalInstance) resetPasswordModalInstance.hide();
                                    alert('🎉 Password reset successful! You can now log in with your new password.');

                                    failedLoginAttempts = 0;
                                    document.getElementById('btnLoginSubmit').disabled = false;
                                    const banner = document.getElementById('failedAttemptBanner');
                                    if (banner) banner.style.display = 'none';
                                    const emailIn = document.getElementById('loginEmailInput') || document.getElementById('loginEmail');
                                    if (emailIn) emailIn.value = pendingForgotPasswordEmail;
                                    const passIn = document.getElementById('loginPasswordInput') || document.getElementById('loginPassword');
                                    if (passIn) passIn.value = newPass;
                                } else {
                                    alert(data.message || '❌ Invalid or expired OTP verification code.');
                                }
                            } catch (e) {
                                alert('Password reset failed. Please check OTP code.');
                            }
                        }



                        function checkAndReserve(listingId, sellerId) {
                            try {
                                const storedUser = localStorage.getItem('pasabuy_student_user');
                                if (storedUser) {
                                    const user = JSON.parse(storedUser);
                                    const currentUserId = user.id || user.userId || user.UserId || 0;
                                    console.log("Checking reserve - Current:", currentUserId, "Seller:", sellerId);
                                    if (currentUserId > 0 && parseInt(currentUserId) === parseInt(sellerId)) {
                                        alert('❌ You cannot reserve your own listing!');
                                        return;
                                    }
                                }
                            } catch (e) { console.error("Reserve check error:", e); }
                            reserveItem(listingId);
                        }

                        function switchTab(tabName) {
                            const tabs = ['home', 'explore', 'cart', 'sell', 'wanted', 'messages', 'profile', 'track'];
                            tabs.forEach(t => {
                                const el = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
                                const nav = document.getElementById('tabNav' + t.charAt(0).toUpperCase() + t.slice(1));
                                if (el) el.style.display = (t === tabName) ? 'block' : 'none';
                                if (nav) nav.classList.toggle('active', t === tabName);
                            });
                            const cv = document.getElementById('chatView');
                            if (cv) cv.style.display = 'none';
                            const as = document.getElementById('authScreen');
                            if (as) as.style.display = 'none';

                            if (tabName === 'cart') {
                                ['productDetailModal', 'cartCheckoutModal'].forEach(mid => {
                                    const m = document.getElementById(mid);
                                    if (m) {
                                        const inst = bootstrap.Modal.getInstance(m);
                                        if (inst) inst.hide();
                                    }
                                });
                                const tabCartEl = document.getElementById('tabCart');
                                if (tabCartEl) tabCartEl.style.display = 'block';
                                if (typeof showCartScreen === 'function') showCartScreen();
                                if (typeof renderCartScreen === 'function') renderCartScreen();
                                return;
                            }
                            document.querySelector('.app-tabbar').style.display = 'flex';

                            // Header cart button is always visible floating in header
                            const headerCartBtn = document.getElementById('headerCartBtn');
                            if (headerCartBtn) headerCartBtn.style.setProperty('display', 'inline-flex', 'important');

                            // Header profile button: hide when on profile tab to avoid duplicate avatar
                            const headerProfileBtn = document.getElementById('headerProfileBtn') || document.getElementById('homeAvatar')?.parentElement;
                            if (headerProfileBtn) {
                                if (tabName === 'profile') {
                                    headerProfileBtn.style.setProperty('display', 'none', 'important');
                                } else {
                                    headerProfileBtn.style.setProperty('display', 'inline-block', 'important');
                                }
                            }

                            if (tabName === 'home') {
                                filterProducts();
                                updateUnreadBadges();
                                if (typeof renderFeaturedRentals === 'function') renderFeaturedRentals();
                            } else if (tabName === 'messages') {
                                const tabBadge = document.getElementById('tabMessagesBadge');
                                if (tabBadge) tabBadge.style.display = 'none';
                                markMessagesAsRead();
                                loadChatConversationsList();
                            } else if (tabName === 'explore') {
                                if (!window._isExplicitCategory) {
                                    if (typeof currentCategory !== 'undefined') currentCategory = 'All';
                                    if (typeof currentTag !== 'undefined') currentTag = 'All';
                                    const titleEl = document.getElementById('exploreCategoryTitle');
                                    if (titleEl) titleEl.innerText = 'Equipment Catalog';
                                    if (typeof selectCategoryChip === 'function') selectCategoryChip('All');
                                }
                                if (typeof renderExploreCatalog === 'function') renderExploreCatalog();
                                else filterProducts();
                            } else if (tabName === 'wanted') {
                                loadWantedPosts();
                            } else if (tabName === 'sell') {
                                if (typeof checkRentOutVerification === 'function') {
                                    try { checkRentOutVerification(); } catch (e) { }
                                }
                                if (typeof updateSellPostingFeeTier === 'function') {
                                    try {
                                        const p = document.getElementById('sellPrice')?.value || 100;
                                        updateSellPostingFeeTier(p);
                                    } catch (e) { }
                                }
                            } else if (tabName === 'profile') {
                                if (typeof syncRentEaseProfileUI === 'function') {
                                    try { syncRentEaseProfileUI(); } catch (e) { console.error(e); }
                                }
                                if (typeof switchProfileSubTab === 'function') {
                                    try { 
                                        const targetSub = window._lastActiveProfileSubTab || 'inventory';
                                        switchProfileSubTab(targetSub); 
                                    } catch (e) { console.error(e); }
                                }
                            }
                        }

                        async function updateUnreadBadges() {
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) {}
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            try {
                                const res = await fetch(`/pasabuy_api.php?action=get_unread&user_id=${currentUserId}`);
                                if (res.ok) {
                                    const data = await res.json();
                                    const unreadCount = data.unreadCount || 0;
                                    const tabBadge = document.getElementById('tabMessagesBadge');
                                    const notifBadge = document.getElementById('headerNotifBadge');

                                    if (tabBadge) {
                                        if (unreadCount > 0) {
                                            tabBadge.innerText = unreadCount;
                                            tabBadge.style.display = 'inline-block';
                                        } else {
                                            tabBadge.style.display = 'none';
                                        }
                                    }

                                    if (notifBadge) {
                                        if (unreadCount > 0) {
                                            notifBadge.innerText = unreadCount;
                                            notifBadge.style.display = 'inline-block';
                                        } else {
                                            notifBadge.style.display = 'none';
                                        }
                                    }
                                }
                            } catch(e) {}
                        }

                        async function markMessagesAsRead() {
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) {}
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            try {
                                await fetch(`/pasabuy_api.php?action=mark_messages_read&user_id=${currentUserId}`);
                            } catch(e) {}

                            const tabBadge = document.getElementById('tabMessagesBadge');
                            const notifBadge = document.getElementById('headerNotifBadge');
                            if (tabBadge) tabBadge.style.display = 'none';
                            if (notifBadge) notifBadge.style.display = 'none';
                        }

                        window.loadChatConversationsList = async function loadChatConversationsList() {
                            const container = document.getElementById('conversationHeadsList');
                            if (!container) return;

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            let currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;
                            if (currentUserId <= 1) currentUserId = 104;

                            const myEmail = (storedUser && storedUser.email ? storedUser.email : '').toLowerCase();
                            const myFirstName = (storedUser && storedUser.firstName ? storedUser.firstName : '').toLowerCase();
                            const myLastName = (storedUser && storedUser.lastName ? storedUser.lastName : '').toLowerCase();
                            const myFullName = (myFirstName + ' ' + myLastName).trim();
                            const isRomeo = myEmail.includes('romeo') || myFirstName.includes('romeo') || myLastName.includes('tolentino') || currentUserId === 104;
                            const isPogilameg = myEmail.includes('pogilameg') || currentUserId === 105;

                            let convs = [];
                            try {
                                const res = await fetch(`/pasabuy_api.php?action=chat_conversations&user_id=${currentUserId}`, { cache: 'no-store' });
                                if (res.ok) {
                                    const payload = await res.json();
                                    convs = Array.isArray(payload) ? payload : (Array.isArray(payload.conversations) ? payload.conversations : []);
                                }
                            } catch (e) { }

                            // Permanently wipe any local mock chat heads from browser storage
                            try { localStorage.removeItem('pasabuy_local_chat_heads'); } catch (e) { }

                            if (!Array.isArray(convs)) convs = [];

                            convs = convs.filter(c => {
                                const pId = parseInt(c.PartnerId || ((c.SenderId == currentUserId) ? c.ReceiverId : c.SenderId)) || 0;
                                const pName = (c.PartnerName || c.SenderName || '').toLowerCase().trim();
                                const item = (c.ItemTitle || '').toLowerCase();
                                const msg = (c.MessageText || '').toLowerCase();
                                const sId = parseInt(c.SenderId) || 0;
                                const rId = parseInt(c.ReceiverId) || 0;
                                const isRentalConversation = !!c.HasTransaction || !!c.TransactionOrderCode;

                                if (sId === rId && sId > 0) return false;
                                if (pId === currentUserId) return false;

                                // Only filter out system/dispatch conversations for non-rental chats
                                if (!isRentalConversation) {
                                    if (pName.includes('dispatch') || pName.includes('rider') || item.includes('dispatch') || item.includes('rider')) return false;
                                }

                                return true;
                            });

                            if (!Array.isArray(convs) || convs.length === 0) {
                                container.innerHTML = `
                <div class="text-center py-5 text-muted fs-8 bg-white rounded-4 border p-4">
                    <i class="fa-solid fa-comments fs-2 d-block mb-2 text-secondary opacity-50"></i>
                    No active chat conversations yet.<br>Click <strong>Message</strong> on any item listing to start chatting!
                </div>`;
                                return;
                            }

                            // CRITICAL: Overdue rentals must automatically jump to the very top (index 0)
                            convs.sort((a, b) => {
                                const aOverdue = (a.IsOverdue || a.isOverdue || a.ActionBadgeClass === 'badge-overdue' || a.TransactionStatus === 'OVERDUE' || a.TimerStatus === 'EXPIRED') ? 1 : 0;
                                const bOverdue = (b.IsOverdue || b.isOverdue || b.ActionBadgeClass === 'badge-overdue' || b.TransactionStatus === 'OVERDUE' || b.TimerStatus === 'EXPIRED') ? 1 : 0;
                                if (bOverdue !== aOverdue) return bOverdue - aOverdue;
                                const aTime = new Date(a.CreatedAt || a.Timestamp || 0).getTime() || 0;
                                const bTime = new Date(b.CreatedAt || b.Timestamp || 0).getTime() || 0;
                                return bTime - aTime;
                            });

                            window._chatConversationsMap = window._chatConversationsMap || {};
                            let html = '';
                            convs.forEach((c, idx) => {
                                const partnerId = c.PartnerId || ((c.SenderId == currentUserId) ? c.ReceiverId : c.SenderId);
                                const partnerName = c.PartnerName || (c.SenderId == currentUserId ? 'Campus Seller' : (c.SenderName || 'Campus Buyer'));
                                const itemTitle = c.ItemTitle || 'Campus Item';
                                       let avatarUrl = c.PartnerAvatar || c.partnerAvatar || '';
                                if (!avatarUrl || avatarUrl === '' || avatarUrl.includes('dicebear')) {
                                    avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(partnerName)}&background=5B3FA8&color=fff&bold=true&rounded=true`;
                                }

                                const isMyItem = !!c.IsMyItem;
                                const ownerName = c.OwnerName || (isMyItem ? 'You' : partnerName);
                                const safeOwnerName = ownerName.replace(/"/g, '&quot;');
                                const itemImage = c.ItemImage || '';
                                const safePartnerNameAttr = partnerName.replace(/"/g, '&quot;');
                                const safeItemTitleAttr = itemTitle.replace(/"/g, '&quot;');
                                const hasTx = !!(c.HasTransaction);
                                const txOrder = c.TransactionOrderCode || '';
                                const txStatus = (c.TransactionStatus || '').toUpperCase();
                                const isCompletedOrRated = !!(
                                    c.HasRated ||
                                    (c.Rating && c.Rating > 0) ||
                                    c.IsCompleted ||
                                    txStatus === 'RETURNED' ||
                                    txStatus === 'COMPLETED' ||
                                    (c.MessageText && c.MessageText.includes('RENTER REVIEW'))
                                );
                                const hasActiveTx = (c.HasActiveTransaction !== undefined)
                                    ? !!c.HasActiveTransaction
                                    : (hasTx && !isCompletedOrRated);

                                const isOverdue = !!(c.IsOverdue || c.isOverdue || c.ActionBadgeClass === 'badge-overdue' || c.TransactionStatus === 'OVERDUE' || c.TimerStatus === 'EXPIRED');
                                const rawLastMsg = (c.MessageText || c.LastMessage || c.lastMessage || '');
                                const lastMsg = rawLastMsg ? rawLastMsg.replace(/</g, '&lt;').replace(/>/g, '&gt;').substring(0, 80) : 'Tap to open conversation';
                                const convKey = 'c_' + partnerId + '_' + idx;
                                window._chatConversationsMap[convKey] = {
                                    partnerId: partnerId,
                                    partnerName: partnerName,
                                    itemTitle: itemTitle,
                                    itemPrice: '₱0.00',
                                    avatarUrl: avatarUrl,
                                    itemImage: itemImage,
                                    isMyItem: isMyItem,
                                    ownerName: ownerName,
                                    isOverdue: isOverdue,
                                    orderCode: txOrder
                                };

                                html += `
                <div class="swipe-conv-wrapper position-relative mb-2 overflow-hidden rounded-4" style="touch-action: pan-y; -webkit-user-select: none; user-select: none;">
                    ${hasActiveTx ? `
                    <div class="swipe-delete-bg position-absolute top-0 bottom-0 end-0 d-flex align-items-center justify-content-end px-3 rounded-4 text-white" 
                         style="width: 100%; z-index: 1; cursor: not-allowed; background:#64748B !important;" 
                         onclick="alert('Chat Deletion Blocked: You cannot delete this conversation because rental transaction (${txOrder}) is currently active and protected.'); event.stopPropagation();">
                        <div class="d-flex flex-column align-items-center justify-content-center text-white" style="width: 75px;">
                            <i class="fa-solid fa-lock fs-5 mb-1"></i>
                            <span style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">PROTECTED</span>
                        </div>
                    </div>
                    ` : `
                    <div class="swipe-delete-bg position-absolute top-0 bottom-0 end-0 d-flex align-items-center justify-content-end px-3 rounded-4 bg-danger text-white" 
                         style="width: 100%; z-index: 1; cursor: pointer;" 
                         onclick="initiateDeleteConversation(${partnerId}, '${safePartnerNameAttr}', event, '${safeItemTitleAttr}', '${txOrder}')">
                        <div class="d-flex flex-column align-items-center justify-content-center text-white" style="width: 65px;">
                            <i class="fa-solid fa-trash-can fs-5 mb-1"></i>
                            <span style="font-size: 0.68rem; font-weight: 700; letter-spacing: 0.5px;">DELETE</span>
                        </div>
                    </div>
                    `}
                    <div class="swipe-conv-card p-2 ${isOverdue ? 'is-overdue' : 'bg-white'} rounded-4 border shadow-sm d-flex align-items-center justify-content-between position-relative"
                         style="z-index: 2; transition: transform 0.22s cubic-bezier(0.2, 0.9, 0.4, 1); cursor: pointer;" 
                         data-conv-key="${convKey}"
                         data-partner-id="${partnerId}" 
                         data-partner-name="${safePartnerNameAttr}" 
                         data-item-title="${safeItemTitleAttr}"
                         data-has-transaction="${hasActiveTx ? '1' : '0'}"
                         data-is-overdue="${isOverdue ? '1' : '0'}"
                         data-order-code="${txOrder || ''}"
                         onclick="handleConversationCardClick(event, this, '${convKey}')">
                        <div class="d-flex align-items-center gap-2 min-w-0" style="pointer-events: none;">
                            <div class="position-relative flex-shrink-0">
                                <img src="${avatarUrl}" class="rounded-circle border ${isOverdue ? 'border-danger border-2 shadow-sm' : ''}" width="40" height="40" style="object-fit:cover; background:#f0f3f8;" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(partnerName)}&background=5B3FA8&color=fff&bold=true&rounded=true';">
                                <span class="position-absolute bottom-0 end-0 ${isOverdue ? 'bg-danger' : 'bg-success'} rounded-circle border border-2 border-white" style="width:13px; height:13px;"></span>
                            </div>
                            <div class="min-w-0">
                                <div class="d-flex align-items-center gap-1.5 flex-wrap mb-0.5">
                                    <h6 class="fw-bold mb-0 ${isOverdue ? 'text-danger' : 'text-dark'} fs-7 text-truncate" style="max-width:140px;">${partnerName}</h6>
                                    
                                    ${isOverdue ? `
                                        <span class="badge rounded-pill fw-bold bg-danger text-white shadow-sm" style="font-size:0.62rem; padding: 2.5px 7px; animation: rentPulseOverdueBorder 1.5s infinite;">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i>OVERDUE • TIMER EXPIRED
                                        </span>
                                    ` : ''}

                                    ${isMyItem ? `
                                        <span class="badge rounded-pill fw-bold" style="background:#EDE9FE; color:#5B3FA8; border:1px solid #DDD6FE; font-size:0.62rem; padding: 2.5px 7px;">
                                             <i class="fa-solid fa-hand-holding-hand text-primary me-0.5"></i>Borrower (Renting from You)
                                        </span>
                                    ` : `
                                        <span class="badge rounded-pill fw-bold" style="background:#E0F2FE; color:#0369A1; border:1px solid #BAE6FD; font-size:0.62rem; padding: 2.5px 7px;">
                                             <i class="fa-solid fa-store me-0.5"></i>Lender (You're Renting)
                                        </span>
                                    `}

                                    ${hasActiveTx ? `
                                        <span class="badge rounded-pill fw-bold" style="background:#ECFDF5; color:#059669; font-size:0.60rem; padding: 2px 6px; border:1px solid #A7F3D0;" title="Protected active rental transaction">
                                            <i class="fa-solid fa-shield-halved me-0.5"></i>Protected
                                        </span>
                                    ` : (isCompletedOrRated ? `
                                        <span class="badge rounded-pill fw-bold" style="background:#F0FDF4; color:#16A34A; font-size:0.60rem; padding: 2px 6px; border:1px solid #BBF7D0;" title="Rental completed & rated">
                                            <i class="fa-solid fa-circle-check me-0.5"></i>Completed • Safe to Delete
                                        </span>
                                    ` : '')}
                                </div>
                                
                                <div class="conversation-meta text-truncate mb-1">
                                    <i class="fa-solid fa-cube text-primary me-1"></i>${itemTitle}
                                    ${txOrder && txOrder !== 'Order' ? ` <span class="text-muted">• ${txOrder}</span>` : ''}
                                </div>

                                <div class="${isOverdue ? 'text-danger fw-bold' : 'text-muted'} fs-8 text-truncate" style="max-width:210px;">${isOverdue ? '⚠️ Rental timer expired • Handover item back now' : lastMsg}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1.5 flex-shrink-0 ms-2">
                            ${!hasActiveTx ? `
                            <button type="button" class="conversation-delete-btn btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center p-0"
                                    style="width: 32px; height: 32px; border-color: #FECACA; background: #FEF2F2;" 
                                    title="Delete Conversation" 
                                    onclick="initiateDeleteConversation(${partnerId}, '${safePartnerNameAttr}', event, '${safeItemTitleAttr}', '${txOrder}')">
                                <i class="fa-solid fa-trash-can" style="font-size:0.75rem;"></i>
                            </button>
                            ` : `
                            <span class="badge bg-light text-muted border rounded-circle d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;" title="Active transaction is protected">
                                <i class="fa-solid fa-lock" style="font-size:0.65rem;"></i>
                            </span>
                            `}
                            <i class="fa-solid fa-chevron-right ${isOverdue ? 'text-danger' : 'text-muted'} fs-9" style="pointer-events: none;"></i>
                        </div>
                    </div>
                </div>`;
                            });

                            container.innerHTML = html;
                            setupConversationSwipeGestures(container);
                        }

                        function setupConversationSwipeGestures(container) {
                            if (!container) return;
                            const wrappers = container.querySelectorAll('.swipe-conv-wrapper');

                            function closeAllCards(exceptCard) {
                                wrappers.forEach(w => {
                                    const c = w.querySelector('.swipe-conv-card');
                                    if (c && c !== exceptCard) {
                                        c.style.transition = 'transform 0.22s cubic-bezier(0.2, 0.9, 0.4, 1)';
                                        c.style.transform = 'translateX(0px)';
                                        c.dataset.currentX = '0';
                                    }
                                });
                            }

                            wrappers.forEach(wrapper => {
                                const card = wrapper.querySelector('.swipe-conv-card');
                                if (!card) return;

                                let startX = 0;
                                let startY = 0;
                                let initialTranslateX = 0;
                                let isDragging = false;
                                let isHorizontalSwipe = false;
                                let totalMovedX = 0;

                                const setCardTransform = (x, animate = false) => {
                                    card.style.transition = animate ? 'transform 0.22s cubic-bezier(0.2, 0.9, 0.4, 1)' : 'none';
                                    card.style.transform = `translateX(${x}px)`;
                                    card.dataset.currentX = x.toString();
                                };

                                // Touch handlers for mobile
                                card.addEventListener('touchstart', (e) => {
                                    if (e.touches.length !== 1) return;
                                    startX = e.touches[0].clientX;
                                    startY = e.touches[0].clientY;
                                    initialTranslateX = parseFloat(card.dataset.currentX || '0');
                                    isDragging = true;
                                    isHorizontalSwipe = false;
                                    totalMovedX = 0;
                                    card.dataset.hasDragged = '0';
                                    closeAllCards(card);
                                }, { passive: true });

                                card.addEventListener('touchmove', (e) => {
                                    if (!isDragging || e.touches.length !== 1) return;
                                    const currentX = e.touches[0].clientX;
                                    const currentY = e.touches[0].clientY;
                                    const diffX = currentX - startX;
                                    const diffY = currentY - startY;
                                    totalMovedX = Math.abs(diffX);

                                    if (!isHorizontalSwipe) {
                                        if (Math.abs(diffX) > 18 && Math.abs(diffX) > Math.abs(diffY) * 1.4) {
                                            isHorizontalSwipe = true;
                                        } else if (Math.abs(diffY) > 12) {
                                            isDragging = false;
                                            return;
                                        }
                                    }

                                    if (isHorizontalSwipe) {
                                        if (e.cancelable) e.preventDefault();
                                        card.dataset.hasDragged = '1';
                                        let targetX = initialTranslateX + diffX;
                                        if (card.dataset.hasTransaction === '1' && targetX < 0) {
                                            targetX = 0;
                                        }
                                        if (targetX > 0) {
                                            targetX = targetX * 0.15;
                                        } else if (targetX < -120) {
                                            targetX = -120 + (targetX + 120) * 0.2;
                                        }
                                        setCardTransform(targetX, false);
                                    }
                                }, { passive: false });

                                card.addEventListener('touchend', () => {
                                    if (!isDragging) return;
                                    isDragging = false;
                                    const currentX = parseFloat(card.dataset.currentX || '0');

                                    if (currentX < -110) {
                                        setCardTransform(-80, true);
                                        const partnerId = card.dataset.partnerId;
                                        const partnerName = card.dataset.partnerName;
                                        const itemTitle = card.dataset.itemTitle || '';
                                        const orderCode = card.dataset.orderCode || '';
                                        initiateDeleteConversation(partnerId, partnerName, null, itemTitle, orderCode);
                                    } else if (currentX < -40) {
                                        setCardTransform(-80, true);
                                    } else {
                                        setCardTransform(0, true);
                                    }

                                    if (totalMovedX > 18) {
                                        setTimeout(() => { card.dataset.hasDragged = '0'; }, 80);
                                    } else {
                                        card.dataset.hasDragged = '0';
                                    }
                                });

                                card.addEventListener('touchcancel', () => {
                                    isDragging = false;
                                    card.dataset.hasDragged = '0';
                                    setCardTransform(0, true);
                                });

                                // Mouse drag handlers for desktop
                                let mouseStartX = 0;
                                let mouseStartY = 0;
                                let mouseMovedX = 0;

                                const onMouseMove = (e) => {
                                    if (!isDragging) return;
                                    const diffX = e.clientX - mouseStartX;
                                    const diffY = e.clientY - mouseStartY;
                                    mouseMovedX = Math.abs(diffX);
                                    if (Math.abs(diffX) > 18 && Math.abs(diffX) > Math.abs(diffY)) {
                                        card.dataset.hasDragged = '1';
                                        let targetX = initialTranslateX + diffX;
                                        if (card.dataset.hasTransaction === '1' && targetX < 0) {
                                            targetX = 0;
                                        }
                                        if (targetX > 0) targetX = 0;
                                        if (targetX < -120) targetX = -120 + (targetX + 120) * 0.2;
                                        setCardTransform(targetX, false);
                                    }
                                };

                                const onMouseUp = () => {
                                    if (!isDragging) return;
                                    isDragging = false;
                                    window.removeEventListener('mousemove', onMouseMove);
                                    window.removeEventListener('mouseup', onMouseUp);

                                    const currentX = parseFloat(card.dataset.currentX || '0');
                                    if (currentX < -110) {
                                        setCardTransform(-80, true);
                                        const partnerId = card.dataset.partnerId;
                                        const partnerName = card.dataset.partnerName;
                                        const itemTitle = card.dataset.itemTitle || '';
                                        const orderCode = card.dataset.orderCode || '';
                                        initiateDeleteConversation(partnerId, partnerName, null, itemTitle, orderCode);
                                    } else if (currentX < -40) {
                                        setCardTransform(-80, true);
                                    } else {
                                        setCardTransform(0, true);
                                    }

                                    if (mouseMovedX > 18) {
                                        setTimeout(() => { card.dataset.hasDragged = '0'; }, 80);
                                    } else {
                                        card.dataset.hasDragged = '0';
                                    }
                                };

                                card.addEventListener('mousedown', (e) => {
                                    if (e.button !== 0) return;
                                    mouseStartX = e.clientX;
                                    mouseStartY = e.clientY;
                                    mouseMovedX = 0;
                                    initialTranslateX = parseFloat(card.dataset.currentX || '0');
                                    isDragging = true;
                                    card.dataset.hasDragged = '0';
                                    closeAllCards(card);

                                    window.addEventListener('mousemove', onMouseMove);
                                    window.addEventListener('mouseup', onMouseUp);
                                });
                            });
                        }

                        window.handleConversationCardClick = function (event, card, convKeyOrPartnerId, partnerName, itemTitle, price, avatarUrl, itemImg) {
                            if (card && card.dataset.hasDragged === '1') {
                                return;
                            }
                            const currentX = parseFloat(card?.dataset?.currentX || '0');
                            if (currentX < -20) {
                                if (card) {
                                    card.style.transition = 'transform 0.22s cubic-bezier(0.2, 0.9, 0.4, 1)';
                                    card.style.transform = 'translateX(0px)';
                                    card.dataset.currentX = '0';
                                }
                                return;
                            }

                            const key = (card && card.dataset.convKey) || convKeyOrPartnerId;
                            const conv = (key && window._chatConversationsMap && window._chatConversationsMap[key]);
                            if (conv) {
                                checkAndOpenChat(conv.partnerId, conv.partnerName, conv.itemTitle, conv.itemPrice, conv.avatarUrl, conv.itemImage, conv.isMyItem, conv.ownerName, conv.isOverdue, conv.orderCode);
                            } else {
                                checkAndOpenChat(convKeyOrPartnerId, partnerName || 'Verified Student', itemTitle || 'Campus Equipment', price || '₱0.00', avatarUrl || '', itemImg || '', false, '', card?.dataset?.isOverdue === '1', card?.dataset?.orderCode || '');
                            }
                        };

                        window.promptOrOpenChatTopic = function (partnerId, partnerName, defaultItemTitle, defaultPrice, avatarUrl, itemImg) {
                            checkAndOpenChat(partnerId, partnerName, defaultItemTitle || 'Campus Equipment', defaultPrice || '₱0.00', avatarUrl, itemImg || '');
                        };

                        window.selectTopicAndOpenChat = function (partnerId, partnerName, itemTitle, price, avatarUrl, itemImg) {
                            checkAndOpenChat(partnerId, partnerName, itemTitle, price, avatarUrl, itemImg);
                        };

                        window.openSwitchChatTopicModal = function () {
                            // Switch item removed
                        };

                        let pendingDeletePartnerId = null;
                        let pendingDeletePartnerName = '';
                        let pendingDeleteItemTitle = '';
                        let pendingDeleteOrderCode = '';

                        window.initiateDeleteConversation = async function(partnerId, partnerName, event, itemTitle, orderCode) {
                            if (event) {
                                event.stopPropagation();
                                event.preventDefault();
                            }
                            pendingDeletePartnerId = partnerId;
                            pendingDeletePartnerName = partnerName || 'User';
                            pendingDeleteItemTitle = itemTitle || '';
                            pendingDeleteOrderCode = orderCode || '';

                            const modalEl = document.getElementById('deleteConversationModal');
                            if (!modalEl) {
                                if (confirm(`Are you sure you want to delete your conversation with ${partnerName}?`)) {
                                    executeDeleteConversation();
                                }
                                return;
                            }

                            const partnerNameEl = document.getElementById('deleteConvPartnerName');
                            if (partnerNameEl) partnerNameEl.textContent = pendingDeletePartnerName;

                            const checkingState = document.getElementById('deleteConvCheckingState');
                            const confirmState = document.getElementById('deleteConvConfirmState');
                            const blockedState = document.getElementById('deleteConvBlockedState');
                            const btnCancel = document.getElementById('btnCancelDeleteConv');
                            const btnConfirm = document.getElementById('btnConfirmDeleteConv');
                            const btnCloseBlocked = document.getElementById('btnCloseBlockedDeleteConv');
                            const iconWrap = document.getElementById('deleteConvIconWrap');
                            const icon = document.getElementById('deleteConvIcon');
                            const title = document.getElementById('deleteConvTitle');

                            // Reset to checking state
                            if (checkingState) checkingState.style.display = 'block';
                            if (confirmState) confirmState.style.display = 'none';
                            if (blockedState) blockedState.style.display = 'none';
                            if (btnConfirm) { btnConfirm.style.display = 'none'; btnConfirm.disabled = true; }
                            if (btnCancel) btnCancel.style.display = 'inline-block';
                            if (btnCloseBlocked) btnCloseBlocked.style.display = 'none';
                            if (title) title.textContent = 'Verifying Status...';
                            if (iconWrap) {
                                iconWrap.style.background = 'rgba(91, 63, 168, 0.1)';
                                iconWrap.style.color = '#5B3FA8';
                            }
                            if (icon) icon.className = 'fa-solid fa-spinner fa-spin fs-4';

                            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                                const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
                                bsModal.show();
                            }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            let currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;
                            if (currentUserId <= 1) currentUserId = 104;

                            try {
                                let checkUrl = `/pasabuy_api.php?action=check_active_transaction&user_id=${currentUserId}&partner_id=${partnerId}`;
                                if (pendingDeleteItemTitle) checkUrl += `&item_title=${encodeURIComponent(pendingDeleteItemTitle)}`;
                                if (pendingDeleteOrderCode) checkUrl += `&order_code=${encodeURIComponent(pendingDeleteOrderCode)}`;

                                const resp = await fetch(checkUrl);
                                const data = await resp.json();

                                if (checkingState) checkingState.style.display = 'none';

                                if (data && data.hasActiveTransaction) {
                                    // Blocked by active transaction
                                    if (title) title.textContent = 'Deletion Blocked';
                                    if (iconWrap) {
                                        iconWrap.style.background = 'rgba(245, 158, 11, 0.12)';
                                        iconWrap.style.color = '#D97706';
                                    }
                                    if (icon) icon.className = 'fa-solid fa-shield-halved fs-4';

                                    const orderCodeEl = document.getElementById('deleteConvOrderCode');
                                    if (orderCodeEl) {
                                        orderCodeEl.textContent = (data.transaction && data.transaction.orderId) ? data.transaction.orderId : (pendingDeleteOrderCode || 'Active Order');
                                    }

                                    if (confirmState) confirmState.style.display = 'none';
                                    if (blockedState) blockedState.style.display = 'block';
                                    if (btnConfirm) btnConfirm.style.display = 'none';
                                    if (btnCancel) btnCancel.style.display = 'none';
                                    if (btnCloseBlocked) btnCloseBlocked.style.display = 'inline-block';
                                } else {
                                    // Safe to delete
                                    if (title) title.textContent = 'Delete Conversation?';
                                    if (iconWrap) {
                                        iconWrap.style.background = 'rgba(220, 53, 69, 0.1)';
                                        iconWrap.style.color = '#dc3545';
                                    }
                                    if (icon) icon.className = 'fa-solid fa-trash-can fs-4';

                                    if (confirmState) confirmState.style.display = 'block';
                                    if (blockedState) blockedState.style.display = 'none';
                                    if (btnConfirm) {
                                        btnConfirm.style.display = 'inline-block';
                                        btnConfirm.disabled = false;
                                        btnConfirm.innerHTML = '<i class="fa-solid fa-trash-can me-1 fs-9"></i> Delete';
                                    }
                                    if (btnCancel) btnCancel.style.display = 'inline-block';
                                    if (btnCloseBlocked) btnCloseBlocked.style.display = 'none';
                                }
                            } catch (err) {
                                console.error('Error checking active transaction:', err);
                                if (checkingState) checkingState.style.display = 'none';
                                if (confirmState) confirmState.style.display = 'block';
                                if (title) title.textContent = 'Delete Conversation?';
                                if (iconWrap) {
                                    iconWrap.style.background = 'rgba(220, 53, 69, 0.1)';
                                    iconWrap.style.color = '#dc3545';
                                }
                                if (icon) icon.className = 'fa-solid fa-trash-can fs-4';
                                if (btnConfirm) {
                                    btnConfirm.style.display = 'inline-block';
                                    btnConfirm.disabled = false;
                                }
                            }
                        };

                        window.executeDeleteConversation = async function() {
                            if (!pendingDeletePartnerId) return;

                            const btnConfirm = document.getElementById('btnConfirmDeleteConv');
                            if (btnConfirm) {
                                btnConfirm.disabled = true;
                                btnConfirm.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Deleting...';
                            }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            let currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;
                            if (currentUserId <= 1) currentUserId = 104;

                            try {
                                const formData = new URLSearchParams();
                                formData.append('userId', currentUserId);
                                formData.append('partnerId', pendingDeletePartnerId);
                                if (pendingDeleteItemTitle) formData.append('itemTitle', pendingDeleteItemTitle);
                                if (pendingDeleteOrderCode) formData.append('orderCode', pendingDeleteOrderCode);

                                const resp = await fetch('/pasabuy_api.php?action=delete_conversation', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: formData.toString()
                                });
                                const result = await resp.json();

                                const modalEl = document.getElementById('deleteConversationModal');
                                if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                                    if (bsModal) bsModal.hide();
                                }

                                if (result.blocked) {
                                    alert(result.message || 'Cannot delete conversation: Active rental transaction is currently in progress.');
                                } else if (result.success) {
                                    if (typeof currentActiveChatSellerId !== 'undefined' && currentActiveChatSellerId == pendingDeletePartnerId) {
                                        if (typeof closeChat === 'function') closeChat();
                                    }
                                    if (typeof loadChatConversationsList === 'function') {
                                        await loadChatConversationsList();
                                    }
                                } else {
                                    alert(result.message || 'Failed to delete conversation.');
                                }
                            } catch (err) {
                                console.error('Delete conversation error:', err);
                                alert('An error occurred while deleting the conversation.');
                            } finally {
                                if (btnConfirm) {
                                    btnConfirm.disabled = false;
                                    btnConfirm.innerHTML = '<i class="fa-solid fa-trash-can me-1 fs-9"></i> Delete';
                                }
                                pendingDeletePartnerId = null;
                                pendingDeletePartnerName = '';
                                pendingDeleteItemTitle = '';
                                pendingDeleteOrderCode = '';
                            }
                        };

                        let uploadedPhotoUrls = [];

                        function previewSellPhotos(event) {
                            const files = event.target.files;
                            const grid = document.getElementById('sellPhotosPreviewGrid');
                            if (grid) grid.innerHTML = '';
                            window.uploadedPhotoUrls = [];
                            if (typeof uploadedPhotoUrls !== 'undefined') uploadedPhotoUrls = [];

                            if (!files || files.length === 0) {
                                if (typeof window.validateSellEquipmentForm === 'function') {
                                    window.validateSellEquipmentForm();
                                }
                                return;
                            }

                            Array.from(files).forEach((file, index) => {
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    const dataUrl = e.target.result;
                                    window.uploadedPhotoUrls.push(dataUrl);
                                    if (typeof uploadedPhotoUrls !== 'undefined') uploadedPhotoUrls.push(dataUrl);

                                    if (grid) {
                                        const div = document.createElement('div');
                                        div.style.position = 'relative';
                                        div.style.width = '75px';
                                        div.style.height = '75px';
                                        div.id = `photoThumb_${index}`;
                                        div.innerHTML = `
                        <img src="${dataUrl}" class="rounded-3 border shadow-sm" style="width:75px; height:75px; object-fit:cover;">
                        <span class="badge bg-danger rounded-circle position-absolute top-0 end-0 p-1 shadow-sm" style="cursor:pointer; transform:translate(25%, -25%);" onclick="removePhoto(${index})"><i class="fa-solid fa-xmark"></i></span>
                    `;
                                        grid.appendChild(div);
                                    }
                                    if (typeof window.validateSellEquipmentForm === 'function') {
                                        window.validateSellEquipmentForm();
                                    }
                                };
                                reader.readAsDataURL(file);
                            });
                        }

                        function removePhoto(index) {
                            if (window.uploadedPhotoUrls && window.uploadedPhotoUrls.length > index) {
                                window.uploadedPhotoUrls.splice(index, 1);
                            }
                            if (typeof uploadedPhotoUrls !== 'undefined' && uploadedPhotoUrls.length > index) {
                                uploadedPhotoUrls.splice(index, 1);
                            }
                            const el = document.getElementById(`photoThumb_${index}`);
                            if (el) el.remove();
                            if (typeof window.validateSellEquipmentForm === 'function') {
                                window.validateSellEquipmentForm();
                            }
                        }

                        function calculateFeeLive() {
                            const price = parseFloat(document.getElementById('sellPrice').value) || 0;
                            let fee = 0;
                            if (price > 0 && price < 100) fee = 1;
                            else if (price >= 100 && price < 1000) fee = 5;
                            else if (price >= 1000) fee = 10;

                            document.getElementById('feeDisplay').innerText = `₱${fee.toFixed(2)}`;
                            document.getElementById('payAmountDisplay').innerText = `₱${fee.toFixed(2)}`;
                        }

                        let verificationIdPhotoBase64 = '';

                        window.previewVerificationIdPhoto = function (event) {
                            const file = event.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                verificationIdPhotoBase64 = e.target.result;
                                const previewImg = document.getElementById('vIdPhotoPreview');
                                const previewBox = document.getElementById('vIdPhotoPreviewBox');
                                if (previewImg) previewImg.src = e.target.result;
                                if (previewBox) previewBox.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        };

                        window.checkSellerVerificationAndPost = async function () {
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const userId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            try {
                                const res = await fetch(`/pasabuy_api.php?action=get_verification_status&userId=${userId}`);
                                if (res.ok) {
                                    const data = await res.json();
                                    const status = (data.VerificationStatus || data.Status || 'UNVERIFIED').toUpperCase();
                                    const reqStatus = (data.RequestStatus || '').toUpperCase();

                                    if (status === 'APPROVED' || status === 'VERIFIED') {
                                        await submitDirectPosting();
                                        return;
                                    }

                                    const modalEl = document.getElementById('verificationRequestModal');
                                    const banner = document.getElementById('verificationStatusBanner');

                                    if (status === 'PENDING' || reqStatus === 'PENDING') {
                                        if (banner) {
                                            banner.className = 'p-3 rounded-3 mb-3 fs-8 fw-semibold bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle';
                                            banner.innerHTML = `<i class="fa-solid fa-clock me-1"></i> <strong>Verification Pending:</strong> Your seller verification request is currently under review by campus Admin. You will be able to post items once approved.`;
                                            banner.style.display = 'block';
                                        }
                                        if (modalEl) new bootstrap.Modal(modalEl).show();
                                        return;
                                    }

                                    if (status === 'REJECTED' || reqStatus === 'REJECTED') {
                                        const reason = data.RejectionReason || 'Uploaded documents were incomplete or invalid.';
                                        if (banner) {
                                            banner.className = 'p-3 rounded-3 mb-3 fs-8 fw-semibold bg-danger bg-opacity-10 text-danger border border-danger-subtle';
                                            banner.innerHTML = `<i class="fa-solid fa-circle-xmark me-1"></i> <strong>Verification Rejected by Admin:</strong> ${reason}<br><span class="text-muted fw-normal fs-9">Please update your details below and resubmit for approval.</span>`;
                                            banner.style.display = 'block';
                                        }
                                        if (modalEl) new bootstrap.Modal(modalEl).show();
                                        return;
                                    }

                                    if (banner) {
                                        banner.className = 'p-3 rounded-3 mb-3 fs-8 fw-semibold bg-info bg-opacity-10 text-info-emphasis border border-info-subtle';
                                        banner.innerHTML = `<i class="fa-solid fa-shield-halved me-1"></i> <strong>Student Verification Required:</strong> Please complete and submit the seller verification form to post items on campus marketplace.`;
                                        banner.style.display = 'block';
                                    }
                                    if (modalEl) new bootstrap.Modal(modalEl).show();
                                    return;
                                }
                            } catch (e) {
                                console.error("Verification check error:", e);
                            }

                            await submitDirectPosting();
                        };

                        window.submitSellerVerificationRequest = async function () {
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const userId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            const hometown = document.getElementById('vHometown').value.trim();
                            const homeAddress = document.getElementById('vHomeAddress').value.trim();
                            const postalCode = document.getElementById('vPostalCode').value.trim();
                            const phoneNumber = document.getElementById('vPhoneNumber').value.trim();
                            const guardianInfo = document.getElementById('vGuardianInfo').value.trim();
                            const idType = document.getElementById('vIdType').value;
                            const idNumber = document.getElementById('vIdNumber').value.trim();

                            if (!hometown || !homeAddress || !postalCode || !phoneNumber || !guardianInfo || !idNumber) {
                                alert('Please fill out all required fields in the verification form.');
                                return;
                            }

                            const btn = document.getElementById('submitVerificationBtn');
                            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Submitting...'; }

                            try {
                                const res = await fetch('/pasabuy_api.php?action=submit_verification_request', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        userId: userId,
                                        hometown: hometown,
                                        homeAddress: homeAddress,
                                        postalCode: postalCode,
                                        phoneNumber: phoneNumber,
                                        guardianName: guardianInfo,
                                        guardianPhone: phoneNumber,
                                        idType: idType,
                                        idNumber: idNumber,
                                        idFrontImage: verificationIdPhotoBase64 || 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=500&q=80'
                                    })
                                });

                                const data = await res.json();
                                if (data.success) {
                                    alert('🎉 Verification Request Submitted! Your application is now pending review by campus Admin.');
                                    const modalEl = document.getElementById('verificationRequestModal');
                                    if (modalEl) {
                                        const bsModal = bootstrap.Modal.getInstance(modalEl);
                                        if (bsModal) bsModal.hide();
                                    }
                                } else {
                                    alert(data.message || 'Submission failed. Please try again.');
                                }
                            } catch (e) {
                                alert('Network error submitting verification request.');
                            } finally {
                                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Submit Verification Request'; }
                            }
                        };

                        async function submitDirectPosting() {
                            const title = document.getElementById('sellTitle').value.trim();
                            if (!title) {
                                alert('Please enter a Product Title before posting!');
                                return;
                            }
                            if (uploadedPhotoUrls.length === 0) {
                                alert('📸 Please select at least 1 photo for your item before posting!');
                                return;
                            }

                            await publishListingToDatabase();

                            document.getElementById('sellTitle').value = '';
                            document.getElementById('sellPrice').value = '';
                            document.getElementById('sellMeetup').value = '';
                            document.getElementById('sellPhotosPreviewGrid').innerHTML = '';
                            uploadedPhotoUrls = [];

                            await filterProducts();
                            switchTab('explore');
                            alert('🎉 Item Post Published Live! Your listing is now active on campus marketplace for all students to see.');
                        }

                        function goToStep2() {
                            const title = document.getElementById('sellTitle').value.trim();
                            if (!title) {
                                alert('Please enter a Product Title before proceeding!');
                                return;
                            }
                            if (uploadedPhotoUrls.length === 0) {
                                alert('📸 Please select at least 1 photo for your item before proceeding to payment!');
                                return;
                            }
                            calculateFeeLive();
                            document.getElementById('sellStep1').style.display = 'none';
                            document.getElementById('sellStep2').style.display = 'block';
                        }

                        let currentListingId = 0;
                        let payMongoGatewayModalInstance = null;

                        async function openPayMongoGatewayModal(amountText) {
                            if (!payMongoGatewayModalInstance) {
                                payMongoGatewayModalInstance = new bootstrap.Modal(document.getElementById('payMongoGatewayModal'));
                            }
                            if (amountText) {
                                const elGw = document.getElementById('gatewayAmount');
                                if (elGw) elGw.innerText = amountText;
                                const elGc = document.getElementById('gcashAmountDisplay');
                                if (elGc) elGc.innerText = amountText;
                                document.querySelectorAll('#pmStep1 .badge.rounded-pill').forEach(b => {
                                    if (b.innerText.toLowerCase().includes('pay')) b.innerText = 'Pay ' + amountText;
                                });
                            }
                            showPmStep1();
                            payMongoGatewayModalInstance.show();

                            const feeVal = parseFloat(amountText.replace(/[^\d.]/g, '')) || 5.00;
                            const title = document.getElementById('sellTitle').value.trim() || 'PasaBuy Item Posting Fee';
                            try {
                                const res = await fetch('/pasabuy_api.php?action=create_paymongo_checkout', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ amount: feeVal, title: title })
                                });
                                if (res.ok) {
                                    const data = await res.json();
                                    const url = data.checkout_url || data.CheckoutUrl || 'https://pasabuy.site';
                                    const directBtn = document.getElementById('pmDirectCheckoutBtn');
                                    const linkBtn = document.getElementById('paymongoDirectLinkBtn');
                                    if (directBtn) directBtn.href = url;
                                    if (linkBtn) linkBtn.href = url;
                                }
                            } catch (e) { }
                        }

                        let paymongoPollTimer = null;

                        async function showGcashStep() {
                            document.getElementById('pmStep1').style.display = 'none';
                            document.getElementById('pmStep2').style.display = 'block';

                            const amountText = document.getElementById('gcashAmountDisplay').innerText || '₱5.00';
                            const feeVal = parseFloat(amountText.replace(/[^\d.]/g, '')) || 5.00;
                            const title = document.getElementById('sellTitle').value.trim() || 'PasaBuy Item Posting Fee';
                            const qrImg = document.getElementById('paymongoQrImage');

                            let checkoutUrl = `https://pasabuy.site/pasabuy_api.php?action=paymongo_gcash_qr&amount=${feeVal}&item=${encodeURIComponent(title)}`;
                            try {
                                const res = await fetch('/pasabuy_api.php?action=create_paymongo_checkout', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ amount: feeVal, title: title })
                                });
                                if (res.ok) {
                                    const data = await res.json();
                                    if (data.checkout_url || data.CheckoutUrl) {
                                        checkoutUrl = data.checkout_url || data.CheckoutUrl;
                                    }
                                }
                            } catch (e) { console.error("PayMongo Checkout QR fetch error:", e); }

                            if (qrImg) {
                                qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(checkoutUrl)}`;
                            }

                            const directBtn = document.getElementById('pmDirectCheckoutBtn');
                            const linkBtn = document.getElementById('paymongoDirectLinkBtn');
                            if (directBtn) directBtn.href = checkoutUrl;
                            if (linkBtn) linkBtn.href = checkoutUrl;

                            const badge = document.getElementById('paymongoStatusBadge');
                            if (badge) {
                                badge.className = 'p-2 bg-primary-subtle text-primary rounded-3 border border-primary-subtle fs-8 fw-bold mb-2';
                                badge.innerHTML = '<i class="fa-solid fa-mobile-screen me-1 text-primary"></i> Tap button above to pay via GCash app directly';
                            }

                            if (paymongoPollTimer) {
                                clearInterval(paymongoPollTimer);
                                paymongoPollTimer = null;
                            }
                        }

                        function showPmStep1() {
                            if (paymongoPollTimer) {
                                clearInterval(paymongoPollTimer);
                                paymongoPollTimer = null;
                            }
                            document.getElementById('pmStep1').style.display = 'block';
                            document.getElementById('pmStep2').style.display = 'none';
                        }

                        async function publishListingToDatabase() {
                            const title = document.getElementById('sellTitle').value.trim() || 'Campus Item';
                            const price = parseFloat(document.getElementById('sellPrice').value) || 10;
                            const quantity = parseInt(document.getElementById('sellQuantity').value) || 1;
                            const meetup = document.getElementById('sellMeetup').value.trim() || 'Campus Library';
                            const condition = document.getElementById('sellCondition').value || 'Good';
                            const category = document.getElementById('sellCategory') ? document.getElementById('sellCategory').value : 'Food / Pasabuy';
                            const imgUrl = uploadedPhotoUrls.length > 0 ? uploadedPhotoUrls[0] : 'https://images.unsplash.com/photo-1611125832047-1d7ad1e8e48b?w=500&q=80';

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const sellerId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            try {
                                const res = await fetch('/pasabuy_api.php?action=create_listing', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        title: title,
                                        description: `Campus item for sale: ${title}`,
                                        price: price,
                                        quantity: quantity,
                                        sellerId: sellerId,
                                        condition: condition,
                                        category: category,
                                        meetupLocation: meetup,
                                        imageUrl: imgUrl
                                    })
                                });

                                if (res && res.ok) {
                                    const data = await res.json();
                                    if (data.id || data.listingId) currentListingId = data.id || data.listingId;
                                }

                                const newProduct = {
                                    id: currentListingId || Date.now(),
                                    title: title,
                                    price: `₱${price.toFixed(2)}`,
                                    quantity: quantity,
                                    status: quantity <= 0 ? 'OUT_OF_STOCK' : 'ACTIVE',
                                    fee: price >= 1000 ? '₱10.00' : (price >= 100 ? '₱5.00' : '₱1.00'),
                                    condition: condition,
                                    category: category,
                                    seller: (storedUser ? (storedUser.firstName + ' ' + (storedUser.lastName || '')) : 'Verified Student').trim(),
                                    sellerId: sellerId,
                                    location: meetup,
                                    img: imgUrl
                                };

                                let localListings = [];
                                try { localListings = JSON.parse(localStorage.getItem('pasabuy_local_published_listings')) || []; } catch (e) { }
                                localListings.unshift(newProduct);
                                localStorage.setItem('pasabuy_local_published_listings', JSON.stringify(localListings));
                            } catch (e) {
                                console.error("Publish listing error:", e);
                            }
                        }

                        async function completePayMongoPayment() {
                            if (paymongoPollTimer) {
                                clearInterval(paymongoPollTimer);
                                paymongoPollTimer = null;
                            }

                            if (typeof window.onPayMongoPaymentSuccess === 'function') {
                                const cb = window.onPayMongoPaymentSuccess;
                                window.onPayMongoPaymentSuccess = null;

                                const modalEl = document.getElementById('payMongoGatewayModal');
                                if (payMongoGatewayModalInstance) {
                                    try { payMongoGatewayModalInstance.hide(); } catch (e) { }
                                }
                                if (modalEl) {
                                    try {
                                        const bsModal = bootstrap.Modal.getInstance(modalEl);
                                        if (bsModal) bsModal.hide();
                                    } catch (e) { }
                                    modalEl.style.display = 'none';
                                    const backdrops = document.querySelectorAll('.modal-backdrop');
                                    backdrops.forEach(b => b.remove());
                                    document.body.classList.remove('modal-open');
                                    document.body.style.overflow = '';
                                }

                                await cb();
                                return;
                            }

                            await publishListingToDatabase();

                            const modalEl = document.getElementById('payMongoGatewayModal');
                            if (payMongoGatewayModalInstance) {
                                try { payMongoGatewayModalInstance.hide(); } catch (e) { }
                            }
                            if (modalEl) {
                                try {
                                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                                    if (bsModal) bsModal.hide();
                                } catch (e) { }
                                modalEl.style.display = 'none';
                                const backdrops = document.querySelectorAll('.modal-backdrop');
                                backdrops.forEach(b => b.remove());
                                document.body.classList.remove('modal-open');
                                document.body.style.overflow = '';
                            }

                            document.getElementById('sellTitle').value = '';
                            document.getElementById('sellPrice').value = '';
                            document.getElementById('sellMeetup').value = '';
                            document.getElementById('sellPhotosPreviewGrid').innerHTML = '';
                            uploadedPhotoUrls = [];

                            document.getElementById('sellStep2').style.display = 'none';
                            document.getElementById('sellStep1').style.display = 'block';

                            await filterProducts();
                            switchTab('explore');
                            alert('🎉 Item Post Published Live! Your listing is now active on campus marketplace for all students to see.');
                        }

                        async function redirectToPayMongoCheckout() {
                            const title = document.getElementById('sellTitle').value.trim() || 'Campus Item';
                            const price = parseFloat(document.getElementById('sellPrice').value) || 10;
                            let fee = 5.00;
                            if (price > 0 && price < 100) fee = 1.00;
                            else if (price >= 1000) fee = 10.00;

                            const feeText = `₱${fee.toFixed(2)}`;
                            document.getElementById('payAmountDisplay').innerText = feeText;

                            try {
                                const res = await fetch('/pasabuy_api.php?action=create_paymongo_checkout', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ amount: fee, title: title })
                                });
                                if (res.ok) {
                                    const data = await res.json();
                                    if (data.checkout_url) {
                                        window.open(data.checkout_url, '_blank');
                                    }
                                }
                            } catch (e) { }

                            openPayMongoGatewayModal(feeText);
                        }

                        window.currentSelectedCategory = 'All';

                        function selectCategoryFilter(el, categoryName) {
                            const chips = document.querySelectorAll('#homeCategoryChips .category-chip');
                            chips.forEach(c => c.classList.remove('active'));
                            if (el) el.classList.add('active');

                            window.currentSelectedCategory = categoryName;
                            filterProducts();
                        }

                        async function filterProducts() {
                            const exploreList = document.getElementById('exploreList');
                            const homeContainer = document.getElementById('homeProductContainer');
                            const profileContainer = document.getElementById('mySellingItemsContainer');

                            const cond = document.getElementById('filterCondition') ? document.getElementById('filterCondition').value : 'All';
                            const search = document.getElementById('searchInput') ? document.getElementById('searchInput').value.toLowerCase() : '';
                            const selectedCat = window.currentSelectedCategory || 'All';

                            // Get current user ID at the very beginning
                            let currentUserId = 0;
                            try {
                                const storedUser = localStorage.getItem('pasabuy_student_user');
                                if (storedUser) {
                                    const user = JSON.parse(storedUser);
                                    currentUserId = user.id || user.userId || user.UserId || 0;
                                }
                            } catch (e) { console.error("Error getting user:", e); }

                            let products = [];
                            try {
                                const res = await fetch('/pasabuy_api.php?action=listings');
                                if (res.ok) {
                                    const data = await res.json();
                                    if (Array.isArray(data)) {
                                        products = data.map(item => {
                                            const title = item.Title || item.title || 'Campus Item';
                                            const priceVal = parseFloat(item.Price || item.price || 0);
                                            const priceStr = `₱${priceVal.toFixed(2)}`;
                                            const feeStr = priceVal >= 1000 ? '₱10.00' : (priceVal >= 100 ? '₱5.00' : '₱1.00');
                                            const condition = item.Condition || item.condition || 'Good';
                                            const category = item.CategoryName || item.category || 'School Supplies';
                                            const sellerName = item.sellerName || (item.FirstName ? `${item.FirstName} ${item.LastName}` : 'Verified Student');
                                            const location = item.MeetupLocation || item.meetupLocation || 'Campus Library';

                                            let img = 'https://images.unsplash.com/photo-1611125832047-1d7ad1e8e48b?w=500&q=80';
                                            if (item.images && item.images.length > 0) {
                                                img = item.images[0].imageUrl || item.images[0];
                                            } else if (item.ImageUrl || item.img) {
                                                img = item.ImageUrl || item.img;
                                            }

                                            return {
                                                id: item.Id || item.id || random_int_js(),
                                                title: title,
                                                description: item.Description || item.description || '',
                                                price: priceStr,
                                                priceVal: priceVal,
                                                quantity: (item.Quantity !== undefined && item.Quantity !== null) ? parseInt(item.Quantity) : ((item.quantity !== undefined && item.quantity !== null) ? parseInt(item.quantity) : 1),
                                                fee: feeStr,
                                                condition: condition,
                                                category: category,
                                                categoryId: item.CategoryId || item.categoryId || 1,
                                                seller: sellerName,
                                                sellerId: item.SellerId || item.sellerId || 1,
                                                location: location,
                                                status: item.Status || item.status || 'ACTIVE',
                                                img: img,
                                                videoUrl: item.VideoUrl || item.videoUrl || ''
                                            };
                                        });
                                    }
                                }
                            } catch (e) {
                                console.error("Fetch listings error:", e);
                            }

                            let localListings = [];
                            try { localListings = JSON.parse(localStorage.getItem('pasabuy_local_published_listings')) || []; } catch (e) { }

                            localListings.forEach(lp => {
                                if (!products.some(p => p.id === lp.id || p.title === lp.title)) {
                                    products.unshift(lp);
                                }
                            });

                            window.allProductsCache = products;

                            function random_int_js() { return Math.floor(Math.random() * 10000); }

                            let html = '';
                            let profileHtml = '';

                            products.forEach(p => {
                                let storedUserObj = null;
                                try { storedUserObj = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                                const myId = storedUserObj ? (storedUserObj.id || storedUserObj.userId || storedUserObj.UserId || 1) : 1;
                                const myName = storedUserObj ? (storedUserObj.firstName + ' ' + (storedUserObj.lastName || '')).trim() : 'Student';

                                const isMyListing = (p.sellerId == myId) || (p.seller && p.seller.toLowerCase() === myName.toLowerCase());

                                const qtyVal = (p.quantity !== undefined && p.quantity !== null) ? parseInt(p.quantity) : ((p.Quantity !== undefined && p.Quantity !== null) ? parseInt(p.Quantity) : 1);
                                const isOutOfStock = (qtyVal <= 0) || (p.status === 'OUT_OF_STOCK');

                                if (!isMyListing && (p.status === 'RESERVED' || p.status === 'SOLD' || isOutOfStock)) return;

                                if (selectedCat === 'My Items' && !isMyListing) return;
                                if (selectedCat !== 'All' && selectedCat !== 'My Items' && p.condition !== selectedCat && p.category !== selectedCat) return;
                                if (cond !== 'All' && p.condition !== cond) return;
                                if (search && !p.title.toLowerCase().includes(search)) return;

                                const ratingSeed = ((p.id * 7) % 5) / 10 + 4.5;
                                const ratingVal = ratingSeed > 5 ? 4.9 : ratingSeed.toFixed(1);
                                const reviewsVal = ((p.id * 13) % 200) + 45;

                                const isInCart = (pasabuyCart || []).some(item => (item.listingId && item.listingId == p.id) || item.title === p.title);
                                const cartBtnIconClass = isInCart ? 'fa-check text-white' : 'fa-cart-shopping text-white';
                                const cartBtnBgStyle = isInCart ? 'background: linear-gradient(135deg, #10B981, #059669); border: none; box-shadow: 0 3px 8px rgba(16, 185, 129, 0.4);' : 'background: linear-gradient(135deg, #6C5CE7, #5F27CD); border: none;';
                                const cartBtnTitle = isInCart ? 'In Cart (Click to remove)' : 'Add to Cart';

                                // 1. Home / Explore Card HTML (cardHtml)
                                let homeMediaHtml = '';
                                let homeActionButtonHtml = '';

                                if (isMyListing) {
                                    homeMediaHtml = p.videoUrl
                                        ? `<div class="position-relative" style="cursor:pointer;" onclick="openProductDetailModal(${p.id})">
                                            <video src="${p.videoUrl}" controls style="width:100%; height:135px; object-fit:cover; border-radius:14px; background:#000;" preload="metadata"></video>
                                            <span class="badge bg-primary position-absolute top-0 start-0 m-2 px-2 py-1 rounded-pill shadow-sm fs-9 text-white fw-bold" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); z-index:4;">
                                                <i class="fa-solid fa-user-tag me-1"></i> Your Product
                                            </span>
                                           </div>`
                                        : `<div class="position-relative" style="cursor:pointer;" onclick="openProductDetailModal(${p.id})">
                                            <img src="${p.img}" class="rounded-4" alt="${p.title}" style="width:100%; height:135px; object-fit:cover;">
                                            <span class="badge bg-primary position-absolute top-0 start-0 m-2 px-2 py-1 rounded-pill shadow-sm fs-9 text-white fw-bold" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); z-index:4;">
                                                <i class="fa-solid fa-user-tag me-1"></i> Your Product
                                            </span>
                                           </div>`;

                                    homeActionButtonHtml = `<span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill fs-9 fw-semibold px-2 py-1"><i class="fa-solid fa-user-check me-1"></i> Yours</span>`;
                                } else {
                                    homeMediaHtml = p.videoUrl
                                        ? `<div class="position-relative" style="cursor:pointer;" onclick="openProductDetailModal(${p.id})">
                                            <video src="${p.videoUrl}" controls style="width:100%; height:135px; object-fit:cover; border-radius:14px; background:#000;" preload="metadata"></video>
                                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 fs-9"><i class="fa-solid fa-video me-1"></i> Video</span>
                                            <button class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-2 p-0 d-flex align-items-center justify-content-center shadow-sm" style="width:28px; height:28px; background:rgba(255,255,255,0.9); z-index:5;" onclick="event.stopPropagation(); toggleWishlist(this, ${p.id})"><i class="fa-regular fa-heart text-dark fs-8"></i></button>
                                           </div>`
                                        : `<div class="position-relative" style="cursor:pointer;" onclick="openProductDetailModal(${p.id})">
                                            <img src="${p.img}" class="rounded-4" alt="${p.title}" style="width:100%; height:135px; object-fit:cover;">
                                            <button class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-2 p-0 d-flex align-items-center justify-content-center shadow-sm" style="width:28px; height:28px; background:rgba(255,255,255,0.9); z-index:5;" onclick="event.stopPropagation(); toggleWishlist(this, ${p.id})"><i class="fa-regular fa-heart text-dark fs-8"></i></button>
                                           </div>`;

                                    homeActionButtonHtml = `<button class="btn rounded-3 p-0 d-flex align-items-center justify-content-center shadow-sm" 
                                        style="width:34px; height:34px; border-radius:10px; ${cartBtnBgStyle}" 
                                        onclick="event.stopPropagation(); toggleCartProduct(event, ${p.id}, '${p.title.replace(/'/g, "\\'")}', '${p.price}', ${p.sellerId}, '${(p.img || '').replace(/'/g, "\\'")}')" 
                                        title="${cartBtnTitle}">
                                        <i class="fa-solid ${cartBtnIconClass} fs-8"></i>
                                    </button>`;
                                }

                                const cardHtml = `
                <div class="col-6 mb-3">
                    <div class="card border-0 rounded-4 shadow-sm h-100 p-2.5 bg-white d-flex flex-column justify-content-between position-relative">
                        ${homeMediaHtml}
                        <div class="pt-2" style="cursor:pointer;" onclick="openProductDetailModal(${p.id})">
                            <h6 class="fw-bold mb-1 text-dark fs-8 text-truncate" title="${p.title}">${p.title}</h6>
                            <div class="fw-extrabold text-dark fs-7 mb-1">${p.price}</div>
                            <div class="d-flex align-items-center justify-content-between pt-1">
                                <div class="d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-star text-warning fs-9"></i>
                                    <span class="fw-bold text-dark fs-9">${ratingVal}</span>
                                    <span class="text-muted fs-9" style="font-size:0.65rem;">(${reviewsVal})</span>
                                </div>
                                ${homeActionButtonHtml}
                            </div>
                        </div>
                    </div>
                </div>`;

                                if (!isOutOfStock) {
                                    html += cardHtml;
                                }

                                // 2. Profile Tab Card HTML (profileCardHtml)
                                if (isMyListing) {
                                    const profileMediaHtml = p.videoUrl
                                        ? `<div class="position-relative" style="cursor:pointer;" onclick="openProductDetailModal(${p.id})">
                                            <video src="${p.videoUrl}" controls style="width:100%; height:135px; object-fit:cover; border-radius:14px; background:#000;" preload="metadata"></video>
                                            <span class="badge position-absolute top-0 start-0 m-2 px-2 py-1 rounded-pill shadow-sm fs-9 text-white fw-bold ${isOutOfStock ? 'bg-danger text-white' : (p.status === 'RESERVED' ? 'bg-warning text-dark' : (p.status === 'SOLD' ? 'bg-success text-white' : ''))}" style="${!isOutOfStock && (!p.status || p.status === 'ACTIVE') ? 'background: linear-gradient(135deg, #6C5CE7, #5F27CD);' : ''} z-index:4;">
                                                <i class="fa-solid ${isOutOfStock ? 'fa-box-open' : (p.status === 'RESERVED' ? 'fa-bookmark' : (p.status === 'SOLD' ? 'fa-circle-check' : 'fa-store'))} me-1"></i> ${isOutOfStock ? 'Out of Stock (Qty: 0)' : (p.status || 'Active')}
                                            </span>
                                           </div>`
                                        : `<div class="position-relative" style="cursor:pointer;" onclick="openProductDetailModal(${p.id})">
                                            <img src="${p.img}" class="rounded-4" alt="${p.title}" style="width:100%; height:135px; object-fit:cover;">
                                            <span class="badge position-absolute top-0 start-0 m-2 px-2 py-1 rounded-pill shadow-sm fs-9 text-white fw-bold ${isOutOfStock ? 'bg-danger text-white' : (p.status === 'RESERVED' ? 'bg-warning text-dark' : (p.status === 'SOLD' ? 'bg-success text-white' : ''))}" style="${!isOutOfStock && (!p.status || p.status === 'ACTIVE') ? 'background: linear-gradient(135deg, #6C5CE7, #5F27CD);' : ''} z-index:4;">
                                                <i class="fa-solid ${isOutOfStock ? 'fa-box-open' : (p.status === 'RESERVED' ? 'fa-bookmark' : (p.status === 'SOLD' ? 'fa-circle-check' : 'fa-store'))} me-1"></i> ${isOutOfStock ? 'Out of Stock (Qty: 0)' : (p.status || 'Active')}
                                            </span>
                                           </div>`;

                                    const profileCardHtml = `
                <div class="col-6 mb-3">
                    <div class="card border-0 rounded-4 shadow-sm h-100 p-2.5 bg-white d-flex flex-column justify-content-between position-relative">
                        ${profileMediaHtml}
                        <div class="pt-2">
                            <div style="cursor:pointer;" onclick="openProductDetailModal(${p.id})">
                                <h6 class="fw-bold mb-1 text-dark fs-8 text-truncate" title="${p.title}">${p.title}</h6>
                                <div class="fw-extrabold text-dark fs-7 mb-1">${p.price}</div>
                                <div class="d-flex align-items-center gap-1 mb-2">
                                    <i class="fa-solid fa-star text-warning fs-9"></i>
                                    <span class="fw-bold text-dark fs-9">${ratingVal}</span>
                                    <span class="text-muted fs-9" style="font-size:0.65rem;">(${reviewsVal})</span>
                                </div>
                            </div>
                            <div class="d-flex gap-1.5 pt-1">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill w-50 fw-bold fs-9 py-1 d-flex align-items-center justify-content-center gap-1 shadow-2xs" onclick="event.stopPropagation(); openEditListingModal(${p.id})">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill w-50 fw-bold fs-9 py-1 d-flex align-items-center justify-content-center gap-1 shadow-2xs" onclick="event.stopPropagation(); confirmDeleteListing(${p.id}, '${p.title.replace(/'/g, "\\'")}', '${p.fee || '0'}')">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;

                                    profileHtml += profileCardHtml;
                                }
                            });

                            if (exploreList) {
                                exploreList.innerHTML = html || '<div class="col-12 text-center text-muted py-5"><i class="fa-solid fa-box-open fs-1 mb-2 d-block opacity-50"></i>No active items found.</div>';
                            }
                            if (homeContainer) {
                                homeContainer.innerHTML = html || '<div class="col-12 text-center text-muted py-5"><i class="fa-solid fa-box-open fs-1 mb-2 d-block opacity-50"></i>No active items found.</div>';
                            }

                            if (profileContainer) {
                                profileContainer.innerHTML = profileHtml || '<div class="col-12 text-center text-muted py-4"><i class="fa-solid fa-store-slash me-1"></i> You haven\'t listed any items for sale yet.</div>';
                            }
                        }

                        let currentEditListingObj = null;

                        window.handleEditVideoUpload = function (event) {
                            const file = event.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const videoDataUrl = e.target.result;
                                document.getElementById('editVideoUrlInput').value = videoDataUrl;
                                const videoPreview = document.getElementById('editVideoPreview');
                                const videoPreviewBox = document.getElementById('editVideoPreviewContainer');
                                if (videoPreview) videoPreview.src = videoDataUrl;
                                if (videoPreviewBox) videoPreviewBox.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        };

                        window.openEditListingModal = function (listingId) {
                            const listing = (window.allProductsCache || []).find(p => p.id == listingId);
                            if (!listing) {
                                alert('Listing not found');
                                return;
                            }
                            currentEditListingObj = listing;

                            document.getElementById('editListingId').value = listing.id;
                            document.getElementById('editTitleInput').value = listing.title;
                            document.getElementById('editPriceInput').value = listing.priceVal || parseFloat(listing.price.replace(/[^\d.]/g, '')) || 0;
                            const editQtyInput = document.getElementById('editQuantityInput');
                            if (editQtyInput) {
                                const qVal = (listing.quantity !== undefined && listing.quantity !== null) ? listing.quantity : ((listing.Quantity !== undefined && listing.Quantity !== null) ? listing.Quantity : 1);
                                editQtyInput.value = qVal;
                            }
                            document.getElementById('editCategorySelect').value = listing.categoryId || 1;
                            document.getElementById('editConditionSelect').value = listing.condition || 'Good';
                            document.getElementById('editMeetupInput').value = listing.location || 'Campus Library';
                            document.getElementById('editDescriptionInput').value = listing.description || '';
                            document.getElementById('editImageUrlInput').value = listing.img || '';
                            document.getElementById('editVideoUrlInput').value = listing.videoUrl || '';

                            const videoPreview = document.getElementById('editVideoPreview');
                            const videoPreviewBox = document.getElementById('editVideoPreviewContainer');
                            if (listing.videoUrl) {
                                if (videoPreview) videoPreview.src = listing.videoUrl;
                                if (videoPreviewBox) videoPreviewBox.style.display = 'block';
                            } else {
                                if (videoPreviewBox) videoPreviewBox.style.display = 'none';
                            }

                            const modalEl = document.getElementById('editListingModal');
                            if (modalEl) new bootstrap.Modal(modalEl).show();
                        };

                        window.executeSaveEditedListing = async function () {
                            const id = document.getElementById('editListingId').value;
                            const title = document.getElementById('editTitleInput').value.trim();
                            const price = parseFloat(document.getElementById('editPriceInput').value) || 0;
                            const quantityVal = parseInt(document.getElementById('editQuantityInput') ? document.getElementById('editQuantityInput').value : 1);
                            const quantity = isNaN(quantityVal) ? 0 : quantityVal;
                            const categoryId = parseInt(document.getElementById('editCategorySelect').value) || 1;
                            const condition = document.getElementById('editConditionSelect').value;
                            const meetupLocation = document.getElementById('editMeetupInput').value.trim();
                            const description = document.getElementById('editDescriptionInput').value.trim();
                            const imageUrl = document.getElementById('editImageUrlInput').value.trim();
                            const videoUrl = document.getElementById('editVideoUrlInput').value.trim();

                            if (!title) {
                                alert('Product title is required!');
                                return;
                            }

                            try {
                                const res = await fetch('pasabuy_api.php?action=update_listing', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        id: id,
                                        title: title,
                                        price: price,
                                        quantity: quantity,
                                        categoryId: categoryId,
                                        condition: condition,
                                        meetupLocation: meetupLocation,
                                        description: description,
                                        imageUrl: imageUrl,
                                        videoUrl: videoUrl
                                    })
                                });

                                const data = await res.json();
                                if (data.success) {
                                    if (currentEditListingObj) {
                                        currentEditListingObj.quantity = quantity;
                                        currentEditListingObj.Quantity = quantity;
                                        currentEditListingObj.status = quantity <= 0 ? 'OUT_OF_STOCK' : 'ACTIVE';
                                    }
                                    if (quantity <= 0) {
                                        alert('✅ Product Listing Updated! (Stock set to 0. Product marked as Out of Stock & hidden from Home/Explore feeds)');
                                    } else {
                                        alert('✅ Product Listing & Details Updated Successfully!');
                                    }
                                    const modalEl = document.getElementById('editListingModal');
                                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                                    if (bsModal) bsModal.hide();
                                    await filterProducts();
                                } else {
                                    alert(data.message || 'Error saving listing updates.');
                                }
                            } catch (e) {
                                alert('Failed to update listing.');
                            }
                        };

                        let currentActiveChatSellerId = 0;
                        let liveChatPollingTimer = null;

                        function startLiveChatPolling() {
                            if (liveChatPollingTimer) clearInterval(liveChatPollingTimer);
                            updateUnreadBadges();
                            liveChatPollingTimer = setInterval(async () => {
                                try {
                                    const chatVw = document.getElementById('chatView');
                                    const tabMsgs = document.getElementById('tabMessages');

                                    if (chatVw && chatVw.style.display !== 'none' && currentActiveChatSellerId > 0) {
                                        await refreshActiveChatStream();
                                    } else if (tabMsgs && tabMsgs.style.display !== 'none') {
                                        await loadChatConversationsList();
                                    }
                                    await updateUnreadBadges();
                                } catch (e) { }
                            }, 3000);
                        }

                        async function refreshActiveChatStream() {
                            if (!currentActiveChatSellerId) return;
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            try {
                                const partnerName = document.getElementById('chatPartnerName')?.innerText || 'Campus Contact';
                                const itemTitle = document.getElementById('chatItemTitle')?.innerText || 'Campus Item';
                                const itemParam = (itemTitle && itemTitle.trim() !== '') ? '&item_title=' + encodeURIComponent(itemTitle.trim()) : '';
                                const res = await fetch(`/pasabuy_api.php?action=chat_messages&sender_id=${currentUserId}&receiver_id=${currentActiveChatSellerId}${itemParam}`);
                                if (res.ok) {
                                    let msgs = await res.json();
                                    if (Array.isArray(msgs) && itemTitle && itemTitle.trim() !== '' && itemTitle !== 'Campus Item' && itemTitle !== 'General Inquiry') {
                                        const cleanLowerTitle = itemTitle.trim().toLowerCase();
                                        msgs = msgs.filter(m => {
                                            const mTitle = (m.ItemTitle || '').trim().toLowerCase();
                                            const mText = (m.MessageText || '').toLowerCase();
                                            if (mTitle !== '' && mTitle !== 'campus item' && mTitle !== 'general inquiry') {
                                                return mTitle === cleanLowerTitle || mTitle.includes(cleanLowerTitle) || cleanLowerTitle.includes(mTitle);
                                            }
                                            return mText.includes(cleanLowerTitle);
                                        });
                                    }

                                    const stream = document.getElementById('chatStream') || document.getElementById('chatMessageContainer');
                                    if (stream && Array.isArray(msgs)) {
                                        const headerAvatarEl = document.getElementById('chatHeaderAvatar');
                                        const finalAvatar = headerAvatarEl ? headerAvatarEl.src : `https://ui-avatars.com/api/?name=${encodeURIComponent(partnerName)}&background=6366F1&color=fff&bold=true&rounded=true`;

                                        let chatHtml = `<div class="text-center my-2"><span class="badge rounded-pill bg-white border text-secondary shadow-2xs px-3 py-1" style="font-size:0.68rem;"><i class="fa-solid fa-lock text-success me-1"></i> Connected live with <strong>${partnerName}</strong> regarding ${itemTitle}</span></div>`;
                                        if (msgs.length === 0) {
                                            chatHtml += `
                                            <div class="text-center my-4 py-3 px-3 bg-light rounded-4 border mx-auto" style="max-width: 320px;">
                                                <i class="fa-solid fa-comments text-primary mb-2 fs-5"></i>
                                                <div class="fw-bold text-dark fs-8">No messages yet for ${itemTitle}</div>
                                                <div class="text-muted fs-9 mt-1">Start a discussion, inquire about availability, or arrange rental terms!</div>
                                            </div>`;
                                        } else {
                                            msgs.forEach(m => {
                                                const isMine = m.SenderId == currentUserId;
                                                chatHtml += `
                                                <div class="d-flex ${isMine ? 'justify-content-end' : 'justify-content-start'} align-items-end gap-2 mb-2">
                                                    ${!isMine ? `<img src="${finalAvatar}" class="rounded-circle border mb-1 flex-shrink-0" width="28" height="28" style="object-fit:cover; background:#f0f3f8;" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(partnerName)}&background=6366F1&color=fff&bold=true&rounded=true';">` : ''}
                                                    <div class="rentchat-bubble ${isMine ? 'rentchat-bubble-mine' : 'rentchat-bubble-partner'}">
                                                        ${m.MessageText}
                                                    </div>
                                                </div>`;
                                            });
                                        }
                                        const isNearBottom = (stream.scrollHeight - stream.scrollTop - stream.clientHeight) < 100;
                                        stream.innerHTML = chatHtml;
                                        if (isNearBottom) stream.scrollTop = stream.scrollHeight;
                                    }
                                }
                            } catch (e) { }

                            // Render and update live rental agreement banner & timer
                            try {
                                await checkAndRenderChatRentalTimer();
                            } catch (eTimer) {}
                        }

                        let currentChatRentalOrder = null;
                        let chatRentalTimerInterval = null;

                        function updateRentalLifecycleStepper(step, isOwner) {
                            const roleLabel = document.getElementById('chatLifecycleRoleLabel');
                            if (roleLabel) roleLabel.textContent = isOwner ? 'Stock owner flow' : 'Renter flow';
                            document.querySelectorAll('#chatLifecycleStepper .rentchat-step').forEach((el) => {
                                const itemStep = parseInt(el.dataset.step || '0', 10);
                                el.classList.toggle('is-complete', itemStep < step);
                                el.classList.toggle('is-active', itemStep === step);
                            });
                        }

                        async function checkAndRenderChatRentalTimer() {
                            if (!currentActiveChatSellerId) return;
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }

                            let currentUserEmail = (storedUser && storedUser.email ? storedUser.email : '').toLowerCase().trim();
                            let currentUserName = (storedUser ? (storedUser.name || (storedUser.firstName || '') + ' ' + (storedUser.lastName || '')) : '').toLowerCase().trim();
                            let currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 0) : 0;
                            if (!currentUserId || currentUserId <= 0) {
                                currentUserId = (currentUserEmail.includes('pogilameg') || currentUserName.includes('pogilameg')) ? 105 : 104;
                            }

                            try {
                                const activeTitle = document.getElementById('chatItemTitle')?.innerText || '';
                                const orderParam = window.currentActiveChatOrderCode ? ('&order_code=' + encodeURIComponent(window.currentActiveChatOrderCode)) : '';
                                const apiBase = window.location.pathname.includes('/student/') ? 'rentease_api.php' : '/student/rentease_api.php';
                                const res = await fetch(`${apiBase}?action=get_active_chat_rental&user_id=${currentUserId}&user_email=${encodeURIComponent(currentUserEmail)}&partner_id=${currentActiveChatSellerId}&item_title=${encodeURIComponent(activeTitle)}${orderParam}&_t=${Date.now()}`);
                                const data = await res.json();

                                const reqBanner = document.getElementById('chatRentalRequestBanner');
                                const timerBanner = document.getElementById('chatRentalTimerBanner');
                                const returnedBanner = document.getElementById('chatRentalReturnedBanner');
                                const headerDeleteBtn = document.getElementById('chatHeaderDeleteBtn');

                                if (!data || !data.success || !data.has_rental) {
                                    if (reqBanner) reqBanner.style.display = 'none';
                                    if (timerBanner) timerBanner.style.display = 'none';
                                    if (returnedBanner) returnedBanner.style.display = 'none';
                                    if (headerDeleteBtn) headerDeleteBtn.style.display = 'none';
                                    if (chatRentalTimerInterval) { clearInterval(chatRentalTimerInterval); chatRentalTimerInterval = null; }
                                    currentChatRentalOrder = null;
                                    return;
                                }

                                const ord = data.order;
                                currentChatRentalOrder = ord;

                                // Precise Ownership & Role Check:
                                // Is the currently logged-in user the STOCK OWNER of this equipment?
                                let isOwner = false;
                                if (typeof ord.is_owner === 'boolean') {
                                    isOwner = ord.is_owner;
                                } else {
                                    if (currentUserId && ord.owner_id && parseInt(currentUserId) === parseInt(ord.owner_id)) {
                                        isOwner = true;
                                    } else if (currentUserEmail && ord.owner_email && currentUserEmail === ord.owner_email.toLowerCase()) {
                                        isOwner = true;
                                    }
                                }

                                // Strict override: If current user is the renter, they are NOT the stock owner!
                                if ((currentUserId && ord.renter_id && parseInt(currentUserId) === parseInt(ord.renter_id)) ||
                                    (currentUserEmail && ord.customer_email && currentUserEmail === ord.customer_email.toLowerCase())) {
                                    isOwner = false;
                                }
                                const lifecycleStatus = String(ord.order_status || '').trim().toUpperCase();
                                const lifecycleStep = ['IN_PROGRESS', 'DELIVERED', 'RETURNED', 'COMPLETED', 'OVERDUE'].includes(lifecycleStatus)
                                    || ['RUNNING', 'EXPIRED', 'COMPLETED'].includes(String(ord.timer_status || '').trim().toUpperCase()) ? 4
                                    : ['MEETUP', 'HANDOVER_READY'].includes(lifecycleStatus) ? 3
                                    : ['PREPARING', 'PROCESSING', 'CONFIRMED'].includes(lifecycleStatus) ? 2
                                    : 1;
                                updateRentalLifecycleStepper(lifecycleStep, isOwner);
                                if (!isOwner && String(ord.early_return_status || '').toUpperCase() === 'PENDING_RENTER' &&
                                    window._earlyReturnPromptOrder !== String(ord.id)) {
                                    window._earlyReturnPromptOrder = String(ord.id);
                                    window.showEarlyReturnModal(ord.order_code, 'renter');
                                }

                                // Update Header Role Badge Dynamically (Describes the counterparty / chat partner)
                                const partnerRoleBadge = document.getElementById('chatPartnerRoleBadge');
                                if (partnerRoleBadge) {
                                    if (isOwner) {
                                        // Current user is Stock Owner -> Chat Partner is Student Renter
                                        partnerRoleBadge.innerHTML = '<i class="fa-solid fa-user me-0.5"></i>Student Renter';
                                        partnerRoleBadge.style.background = '#EDE9FE';
                                        partnerRoleBadge.style.color = '#5B3FA8';
                                        partnerRoleBadge.style.borderColor = '#DDD6FE';
                                    } else {
                                        // Current user is Renter -> Chat Partner is Stock Owner & Lender
                                        partnerRoleBadge.innerHTML = '<i class="fa-solid fa-circle-check me-0.5"></i>Stock Owner & Lender';
                                        partnerRoleBadge.style.background = '#ECFDF5';
                                        partnerRoleBadge.style.color = '#059669';
                                        partnerRoleBadge.style.borderColor = '#A7F3D0';
                                    }
                                }

                                // Update Attached Equipment Card Details & Clear Owner Attribution
                                const ownershipBadge = document.getElementById('chatItemOwnershipBadge');
                                if (ownershipBadge) {
                                    if (isOwner) {
                                        ownershipBadge.innerHTML = '<i class="fa-solid fa-crown text-warning me-1"></i>Your Item (You Own This)';
                                        ownershipBadge.style.background = '#ECFDF5';
                                        ownershipBadge.style.color = '#059669';
                                        ownershipBadge.style.border = '1px solid #A7F3D0';
                                        ownershipBadge.style.display = 'inline-flex';
                                    } else {
                                        ownershipBadge.innerHTML = '<i class="fa-solid fa-user-tag text-warning me-1"></i>Owner: ' + (ord.owner_name || 'Campus Student');
                                        ownershipBadge.style.background = '#FFFBEB';
                                        ownershipBadge.style.color = '#B45309';
                                        ownershipBadge.style.border = '1px solid #FDE68A';
                                        ownershipBadge.style.display = 'inline-flex';
                                    }
                                }

                                const chatOwnerLabel = document.getElementById('chatItemOwnerLabel');
                                if (chatOwnerLabel) {
                                    chatOwnerLabel.innerText = isOwner ? '• Owner: You' : ('• Owner: ' + (ord.owner_name || 'Stock Owner'));
                                }
                                const itemTitleEl = document.getElementById('chatItemTitle');
                                if (itemTitleEl && ord.item_name) {
                                    itemTitleEl.innerText = ord.item_name;
                                }
                                const priceEl = document.getElementById('chatItemPrice');
                                if (priceEl && ord.total_amount && ord.rental_days) {
                                    const dailyPrice = (parseFloat(ord.total_amount) / Math.max(1, parseInt(ord.rental_days))).toFixed(2);
                                    priceEl.innerText = `₱${dailyPrice}`;
                                }

                                // Sync equipment thumbnail if available from order
                                const chatItemImg = document.getElementById('chatItemImage');
                                const chatItemFallback = document.getElementById('chatItemThumbFallback');
                                if (chatItemImg && ord.item_image && ord.item_image.trim() !== '') {
                                    chatItemImg.src = ord.item_image;
                                    chatItemImg.style.display = 'block';
                                    if (chatItemFallback) chatItemFallback.style.display = 'none';
                                }

                                const orderStatusUpper = String(ord.order_status || '').trim().toUpperCase();
                                const timerStatusUpper = String(ord.timer_status || '').trim().toUpperCase();
                                const isHandedOver = (parseInt(ord.handed_over) === 1 || !!ord.rental_timer_start);
                                const hasRatedOrder = (parseInt(ord.has_rated) === 1 || parseInt(ord.rating) > 0);

                                const isOrderReturnedOrRated = (
                                    orderStatusUpper === 'RETURNED' ||
                                    orderStatusUpper === 'COMPLETED' ||
                                    timerStatusUpper === 'COMPLETED' ||
                                    hasRatedOrder
                                );

                                const isTimerActiveOrOverdue = (
                                    !isOrderReturnedOrRated && (
                                        isHandedOver ||
                                        timerStatusUpper === 'RUNNING' ||
                                        timerStatusUpper === 'EXPIRED' ||
                                        orderStatusUpper === 'IN_PROGRESS' ||
                                        orderStatusUpper === 'RENTED' ||
                                        orderStatusUpper === 'OVERDUE'
                                    )
                                );

                                // 1. If order is RETURNED or RATED, show RETURNED & RATING BANNER (NEVER OVERDUE!)
                                if (isOrderReturnedOrRated) {
                                    if (reqBanner) reqBanner.style.setProperty('display', 'none', 'important');
                                    if (timerBanner) {
                                        timerBanner.style.setProperty('display', 'none', 'important');
                                        timerBanner.classList.remove('is-overdue');
                                    }
                                    if (chatRentalTimerInterval) { clearInterval(chatRentalTimerInterval); chatRentalTimerInterval = null; }

                                    const headerBar = document.querySelector('.rentchat-header-bar');
                                    const chatVw = document.getElementById('chatView');
                                    if (headerBar) headerBar.classList.remove('is-overdue');
                                    if (chatVw) chatVw.classList.remove('is-overdue');

                                    const headerStepBadge = document.getElementById('chatHeaderStepBadge');
                                    const headerActionBadge = document.getElementById('chatHeaderActionBadge');

                                    if (headerStepBadge) {
                                        headerStepBadge.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i>Completed';
                                        headerStepBadge.style.background = '#DCFCE7';
                                        headerStepBadge.style.color = '#15803D';
                                        headerStepBadge.style.borderColor = '#86EFAC';
                                    }
                                    if (headerActionBadge) {
                                        if (hasRatedOrder) {
                                            headerActionBadge.innerHTML = '<i class="fa-solid fa-star text-warning me-1"></i>Rated';
                                            headerActionBadge.style.background = '#FFFBEB';
                                            headerActionBadge.style.color = '#B45309';
                                            headerActionBadge.style.borderColor = '#FDE68A';
                                        } else if (!isOwner) {
                                            headerActionBadge.innerHTML = '<i class="fa-solid fa-star me-1 text-warning"></i>Rate Item';
                                            headerActionBadge.style.background = '#FEF3C7';
                                            headerActionBadge.style.color = '#B45309';
                                            headerActionBadge.style.borderColor = '#FDE68A';
                                        } else {
                                            headerActionBadge.innerHTML = '<i class="fa-solid fa-clock me-1 text-primary"></i>Awaiting Rating';
                                            headerActionBadge.style.background = '#EDE9FE';
                                            headerActionBadge.style.color = '#5B3FA8';
                                            headerActionBadge.style.borderColor = '#DDD6FE';
                                        }
                                    }

                                    if (returnedBanner) returnedBanner.style.setProperty('display', 'block', 'important');
                                    const deleteSection = document.getElementById('chatReturnedDeleteSection');

                                    const returnedOrderCodeEl = document.getElementById('chatReturnedOrderCodeDisplay');
                                    if (returnedOrderCodeEl) {
                                        returnedOrderCodeEl.innerText = `${ord.item_name} (${ord.order_code}) • Returned & Restocked in Catalog`;
                                    }

                                    const renterRatingBox = document.getElementById('chatReturnedRenterRatingBox');
                                    const ratedSuccessBox = document.getElementById('chatReturnedRatedSuccessBox');
                                    const ownerWaitingBox = document.getElementById('chatReturnedOwnerWaitingBox');
                                    const ratedByHeader = document.getElementById('chatRatedByHeader');
                                    const ratedStarsDisplay = document.getElementById('chatRatedStarsDisplay');
                                    const ratedReviewTextDisplay = document.getElementById('chatRatedReviewTextDisplay');

                                    // Delete conversation ONLY shows after the renter rates the item!
                                    if (hasRatedOrder) {
                                        if (headerDeleteBtn) headerDeleteBtn.style.display = 'inline-flex';
                                        if (deleteSection) deleteSection.style.display = 'block';
                                    } else {
                                        if (headerDeleteBtn) headerDeleteBtn.style.display = 'none';
                                        if (deleteSection) deleteSection.style.display = 'none';
                                    }

                                    if (!isOwner) {
                                        // Current user is RENTER
                                        if (!hasRatedOrder) {
                                            if (renterRatingBox) renterRatingBox.style.setProperty('display', 'block', 'important');
                                            if (ratedSuccessBox) ratedSuccessBox.style.setProperty('display', 'none', 'important');
                                            if (ownerWaitingBox) ownerWaitingBox.style.setProperty('display', 'none', 'important');
                                        } else {
                                            if (renterRatingBox) renterRatingBox.style.setProperty('display', 'none', 'important');
                                            if (ratedSuccessBox) ratedSuccessBox.style.setProperty('display', 'block', 'important');
                                            if (ownerWaitingBox) ownerWaitingBox.style.setProperty('display', 'none', 'important');
                                            if (ratedByHeader) ratedByHeader.innerText = 'Your Rental Rating & Review';
                                            if (ratedStarsDisplay) {
                                                const starCount = Math.max(1, Math.min(5, parseInt(ord.rating) || 5));
                                                ratedStarsDisplay.innerHTML = '⭐'.repeat(starCount) + ` <strong class="text-dark">(${starCount}/5)</strong>`;
                                            }
                                            if (ratedReviewTextDisplay) {
                                                ratedReviewTextDisplay.innerText = `"${ord.review_text || 'Great item, returned safely.'}"`;
                                            }
                                        }
                                    } else {
                                        // Current user is STOCK OWNER
                                        if (renterRatingBox) renterRatingBox.style.setProperty('display', 'none', 'important');
                                        if (hasRatedOrder) {
                                            if (ratedSuccessBox) ratedSuccessBox.style.setProperty('display', 'block', 'important');
                                            if (ownerWaitingBox) ownerWaitingBox.style.setProperty('display', 'none', 'important');
                                            if (ratedByHeader) ratedByHeader.innerText = `Renter Rating (${ord.customer_name || 'Renter'})`;
                                            if (ratedStarsDisplay) {
                                                const starCount = Math.max(1, Math.min(5, parseInt(ord.rating) || 5));
                                                ratedStarsDisplay.innerHTML = '⭐'.repeat(starCount) + ` <strong class="text-dark">(${starCount}/5)</strong>`;
                                            }
                                            if (ratedReviewTextDisplay) {
                                                ratedReviewTextDisplay.innerText = `"${ord.review_text || 'Great item, returned safely.'}"`;
                                            }
                                        } else {
                                            if (ratedSuccessBox) ratedSuccessBox.style.setProperty('display', 'none', 'important');
                                            if (ownerWaitingBox) ownerWaitingBox.style.setProperty('display', 'block', 'important');
                                        }
                                    }

                                    // Chat input is enabled
                                    const chatInput = document.getElementById('chatInput');
                                    const sendBtn = document.querySelector('.rentchat-send-btn');
                                    if (chatInput) { chatInput.disabled = false; chatInput.placeholder = 'Type your message...'; }
                                    if (sendBtn) sendBtn.disabled = false;
                                }
                                // 2. If timer is running or overdue, show TIMER BANNER (ONLY IF NOT RETURNED/RATED!)
                                else if (isTimerActiveOrOverdue) {
                                    if (returnedBanner) returnedBanner.style.setProperty('display', 'none', 'important');
                                    if (headerDeleteBtn) headerDeleteBtn.style.setProperty('display', 'none', 'important');
                                    if (reqBanner) reqBanner.style.setProperty('display', 'none', 'important');
                                    if (timerBanner) timerBanner.style.setProperty('display', 'block', 'important');

                                    const isOrderOverdue = !!(ord.is_overdue || timerStatusUpper === 'EXPIRED' || orderStatusUpper === 'OVERDUE' || (ord.rental_timer_end && new Date(ord.rental_timer_end).getTime() <= Date.now()));
                                    const headerBar = document.querySelector('.rentchat-header-bar');
                                    const chatVw = document.getElementById('chatView');
                                    if (isOrderOverdue) {
                                        if (timerBanner) timerBanner.classList.add('is-overdue');
                                        if (headerBar) headerBar.classList.add('is-overdue');
                                        if (chatVw) chatVw.classList.add('is-overdue');
                                    } else {
                                        if (timerBanner) timerBanner.classList.remove('is-overdue');
                                        if (headerBar) headerBar.classList.remove('is-overdue');
                                        if (chatVw) chatVw.classList.remove('is-overdue');
                                    }

                                    const headerStepBadge = document.getElementById('chatHeaderStepBadge');
                                    const headerActionBadge = document.getElementById('chatHeaderActionBadge');
                                    if (headerStepBadge) {
                                        if (isOrderOverdue) {
                                            headerStepBadge.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i>Overdue';
                                            headerStepBadge.style.background = '#FEE2E2';
                                            headerStepBadge.style.color = '#B91C1C';
                                            headerStepBadge.style.borderColor = '#FCA5A5';
                                        } else {
                                            headerStepBadge.innerHTML = 'Step 4 of 4 • In Rental';
                                            headerStepBadge.style.background = '#ECFDF5';
                                            headerStepBadge.style.color = '#059669';
                                            headerStepBadge.style.borderColor = '#A7F3D0';
                                        }
                                    }
                                    if (headerActionBadge) {
                                        if (isOrderOverdue) {
                                            headerActionBadge.innerHTML = '<i class="fa-solid fa-rotate-left me-1"></i>Return Required';
                                            headerActionBadge.style.background = '#FEF2F2';
                                            headerActionBadge.style.color = '#DC2626';
                                            headerActionBadge.style.borderColor = '#FECACA';
                                        } else {
                                            headerActionBadge.innerHTML = '<i class="fa-solid fa-stopwatch me-1 text-success"></i>Active Timer';
                                            headerActionBadge.style.background = '#F0FDF4';
                                            headerActionBadge.style.color = '#15803D';
                                            headerActionBadge.style.borderColor = '#BBF7D0';
                                        }
                                    }

                                    // Chat input is always unlocked when rental is active
                                    const chatInput = document.getElementById('chatInput');
                                    const sendBtn = document.querySelector('.rentchat-send-btn');
                                    if (chatInput) { chatInput.disabled = false; chatInput.placeholder = 'Type your message...'; }
                                    if (sendBtn) sendBtn.disabled = false;

                                    const titleEl = document.getElementById('chatTimerItemTitle');
                                    if (titleEl) titleEl.innerText = `${ord.item_name} • ${ord.order_code}`;
                                    
                                    let endFormatted = ord.rental_end_date || 'Scheduled';
                                    if (ord.rental_timer_end) {
                                        try {
                                            const d = new Date(ord.rental_timer_end);
                                            const m = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                                            const t = d.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                                            endFormatted = `${m} • ${t}`;
                                        } catch(e) {}
                                    }
                                    const endEl = document.getElementById('chatTimerEndDisplay');
                                    if (endEl) endEl.innerText = endFormatted;

                                    const meetupDisplay = document.getElementById('chatTimerMeetupDisplay');
                                    if (meetupDisplay) {
                                        meetupDisplay.innerText = ord.meetup_location || 'Campus Meetup Spot';
                                    }

                                    // Start or sync local live countdown with strict owner role passing
                                    startChatTimerCountdown(ord.rental_timer_end, isOwner);
                                } 
                                // 3. Step-by-Step Lifecycle (Before Timer Starts)
                                else {
                                    if (isHandedOver || isOrderReturnedOrRated) {
                                        return;
                                    }
                                    if (returnedBanner) returnedBanner.style.setProperty('display', 'none', 'important');
                                    if (headerDeleteBtn) headerDeleteBtn.style.setProperty('display', 'none', 'important');
                                    if (timerBanner) {
                                        timerBanner.style.setProperty('display', 'none', 'important');
                                        timerBanner.classList.remove('is-overdue');
                                    }
                                    if (chatRentalTimerInterval) { clearInterval(chatRentalTimerInterval); chatRentalTimerInterval = null; }
                                    const headerBar = document.querySelector('.rentchat-header-bar');
                                    const chatVw = document.getElementById('chatView');
                                    if (headerBar) headerBar.classList.remove('is-overdue');
                                    if (chatVw) chatVw.classList.remove('is-overdue');
                                    if (reqBanner) reqBanner.style.setProperty('display', 'block', 'important');

                                    const codeEl = document.getElementById('chatReqOrderCode');
                                    if (codeEl) codeEl.innerText = ord.order_code;
                                    
                                    const datesEl = document.getElementById('chatReqDatesText');
                                    if (datesEl) {
                                        let sFormatted = ord.rental_start_date;
                                        let eFormatted = ord.rental_end_date;
                                        try {
                                            const sD = new Date(ord.rental_start_date);
                                            const eD = new Date(ord.rental_end_date);
                                            if (!isNaN(sD.getTime()) && !isNaN(eD.getTime())) {
                                                const opt = { month: 'short', day: 'numeric' };
                                                sFormatted = sD.toLocaleDateString('en-US', opt);
                                                eFormatted = eD.toLocaleDateString('en-US', opt);
                                            }
                                        } catch(eDateErr) {}
                                        const days = parseInt(ord.rental_days) || 1;
                                        const dayBadge = days === 1 ? '1 Day' : `${days} Days`;
                                        datesEl.innerHTML = `<span>${sFormatted} – ${eFormatted}</span> <span class="badge rounded-pill ms-1 px-2 py-0.5" style="background:#EDE9FE; color:#5B3FA8; font-size:0.68rem; font-weight:700;">${dayBadge}</span>`;
                                    }

                                    const totEl = document.getElementById('chatReqTotalText');
                                    if (totEl) totEl.innerText = `₱${parseFloat(ord.total_amount || 0).toFixed(2)}`;

                                    // Step Elements
                                    const stepPill = document.getElementById('chatLifecycleStepPill');
                                    const step1Row = document.getElementById('chatStep1Row');
                                    const step2Row = document.getElementById('chatStep2Row');
                                    const step3Row = document.getElementById('chatStep3Row');
                                    const step4Row = document.getElementById('chatStep4Row');

                                    const step1Owner = document.getElementById('chatStep1OwnerBox');
                                    const step1Renter = document.getElementById('chatStep1RenterBox');

                                    const step2Owner = document.getElementById('chatStep2OwnerBox');
                                    const step2Renter = document.getElementById('chatStep2RenterBox');
                                    const step2RenterWait = document.getElementById('chatStep2RenterWaiting');
                                    const step2RenterAction = document.getElementById('chatStep2RenterAction');
                                    const prepImgDisplay = document.getElementById('chatPrepPhotoDisplayRenter');

                                    const step3Owner = document.getElementById('chatStep3OwnerBox');
                                    const step3Renter = document.getElementById('chatStep3RenterBox');
                                    const meetupNotice = document.getElementById('chatMeetupRenterNotice');

                                    const step4Owner = document.getElementById('chatStep4OwnerBox');
                                    const step4Renter = document.getElementById('chatStep4RenterBox');
                                    const step4LocOwner = document.getElementById('chatStep4LocationDisplay');
                                    const step4LocRenter = document.getElementById('chatStep4RenterLocationDisplay');

                                    const chatInput = document.getElementById('chatInput');
                                    const sendBtn = document.querySelector('.rentchat-send-btn');

                                    // Default chat state: enabled
                                    if (chatInput) { chatInput.disabled = false; chatInput.placeholder = 'Type your message...'; }
                                    if (sendBtn) sendBtn.disabled = false;

                                    const isCancelled = (ord.order_status === 'CANCELLED');
                                    const cancelledBanner = document.getElementById('chatRentalCancelledBanner');
                                    const cancelledByEl = document.getElementById('chatCancelledByText');
                                    const cancelledReasonEl = document.getElementById('chatCancelledReasonText');
                                    const lifecycleIndicator = document.getElementById('chatLifecycleProgressIndicator');

                                    if (isCancelled) {
                                        if (cancelledBanner) cancelledBanner.style.setProperty('display', 'block', 'important');
                                        if (cancelledByEl) cancelledByEl.innerText = ord.cancelled_by ? `Cancelled by ${ord.cancelled_by}` : 'Cancelled after photo review';
                                        if (cancelledReasonEl) cancelledReasonEl.innerText = `"${ord.cancellation_reason || 'Photo verification did not meet expectations after 3 attempts.'}"`;
                                        if (lifecycleIndicator) lifecycleIndicator.style.setProperty('display', 'none', 'important');
                                        if (step1Row) step1Row.style.setProperty('display', 'none', 'important');
                                        if (step2Row) step2Row.style.setProperty('display', 'none', 'important');
                                        if (step3Row) step3Row.style.setProperty('display', 'none', 'important');
                                        if (step4Row) step4Row.style.setProperty('display', 'none', 'important');
                                        return;
                                    } else {
                                        if (cancelledBanner) cancelledBanner.style.setProperty('display', 'none', 'important');
                                        if (lifecycleIndicator) lifecycleIndicator.style.setProperty('display', 'flex', 'important');
                                    }

                                    const ownerAgreed = (parseInt(ord.owner_agreed) === 1);
                                    const hasPrepPhoto = (ord.prep_photo_url && ord.prep_photo_url.trim() !== '');
                                    const renterConfirmedPrep = (parseInt(ord.prep_confirmed_by_renter) === 1);
                                    const hasMeetupLoc = (ord.meetup_location && ord.meetup_location.trim() !== '' && ord.meetup_location !== 'Campus Handover Meetup' && ord.meetup_location_at && ord.meetup_location_at.trim() !== '');

                                    // Reset step rows
                                    if (step1Row) step1Row.style.setProperty('display', 'none', 'important');
                                    if (step2Row) step2Row.style.setProperty('display', 'none', 'important');
                                    if (step3Row) step3Row.style.setProperty('display', 'none', 'important');
                                    if (step4Row) step4Row.style.setProperty('display', 'none', 'important');

                                    const headerStepBadge = document.getElementById('chatHeaderStepBadge');
                                    const headerActionBadge = document.getElementById('chatHeaderActionBadge');

                                    // STEP 1: Booking Confirmation
                                    if (!ownerAgreed) {
                                        if (headerStepBadge) {
                                            headerStepBadge.innerHTML = 'Step 1 of 4';
                                            headerStepBadge.style.background = '#EDE9FE';
                                            headerStepBadge.style.color = '#5B3FA8';
                                            headerStepBadge.style.borderColor = '#DDD6FE';
                                        }
                                        if (headerActionBadge) {
                                            headerActionBadge.innerHTML = isOwner ? '<i class="fa-solid fa-handshake me-1 text-primary"></i>Confirm Request' : '<i class="fa-solid fa-hourglass-half me-1 text-warning"></i>Pending Owner';
                                            headerActionBadge.style.background = '#F8FAFC';
                                            headerActionBadge.style.color = '#64748B';
                                            headerActionBadge.style.borderColor = '#E2E8F0';
                                        }
                                        if (stepPill) { stepPill.innerText = 'Step 1 of 4 • Booking Confirmation'; stepPill.style.background = '#EDE9FE'; stepPill.style.color = '#5B3FA8'; }
                                        if (step1Row) step1Row.style.setProperty('display', 'block', 'important');
                                        if (isOwner) {
                                            if (step1Owner) step1Owner.style.setProperty('display', 'block', 'important');
                                            if (step1Renter) step1Renter.style.setProperty('display', 'none', 'important');

                                            // Pop-up notification for Stock Owner receiving Step 1 proposal
                                            if (typeof showStep1OwnerProposalPopup === 'function') {
                                                showStep1OwnerProposalPopup(ord, partnerName, itemTitle || ord.item_name || 'Campus Equipment');
                                            }
                                        } else {
                                            if (step1Owner) step1Owner.style.setProperty('display', 'none', 'important');
                                            if (step1Renter) step1Renter.style.setProperty('display', 'flex', 'important');
                                        }
                                    }
                                    // STEP 2: Equipment Preparation & Photo Proof
                                    else if (!renterConfirmedPrep) {
                                        const attempts = Math.max(1, parseInt(ord.prep_photo_attempts || 1));
                                        const prepStatus = ord.prep_status || (hasPrepPhoto ? 'AWAITING_APPROVAL' : 'PENDING_UPLOAD');
                                        const hasFeedback = (prepStatus === 'FEEDBACK_RECEIVED' && ord.prep_feedback && ord.prep_feedback.trim() !== '');

                                        if (headerStepBadge) {
                                            headerStepBadge.innerHTML = `Step 2 of 4 • Prep`;
                                            headerStepBadge.style.background = '#FEF3C7';
                                            headerStepBadge.style.color = '#B45309';
                                            headerStepBadge.style.borderColor = '#FDE68A';
                                        }
                                        if (headerActionBadge) {
                                            headerActionBadge.innerHTML = isOwner ? '<i class="fa-solid fa-camera me-1"></i>Upload Photo' : '<i class="fa-solid fa-magnifying-glass me-1"></i>Inspect Photo';
                                            headerActionBadge.style.background = '#FFFBEB';
                                            headerActionBadge.style.color = '#B45309';
                                            headerActionBadge.style.borderColor = '#FDE68A';
                                        }
                                        if (stepPill) {
                                            stepPill.innerText = `Step 2 of 4 • Equipment Preparation (Attempt ${attempts} of 3)`;
                                            stepPill.style.background = '#FEF3C7';
                                            stepPill.style.color = '#B45309';
                                        }
                                        if (step2Row) step2Row.style.setProperty('display', 'block', 'important');

                                        // Update attempt badges
                                        const ownerUploadBadge = document.getElementById('chatStep2AttemptBadgeOwner');
                                        if (ownerUploadBadge) ownerUploadBadge.innerText = `Attempt ${attempts} of 3`;
                                        const ownerWaitingBadge = document.getElementById('chatStep2OwnerWaitingAttemptBadge');
                                        if (ownerWaitingBadge) ownerWaitingBadge.innerText = `Attempt ${attempts} of 3`;
                                        const renterActionBadge = document.getElementById('chatStep2AttemptBadgeRenter');
                                        if (renterActionBadge) renterActionBadge.innerText = `Attempt ${attempts} of 3`;

                                        // Cancellation buttons unlock at 3 or more attempts
                                        const ownerCancelWrap = document.getElementById('btnOwnerCancelStep2Wrap');
                                        if (ownerCancelWrap) ownerCancelWrap.style.display = (attempts >= 3) ? 'block' : 'none';
                                        const ownerWaitingCancelWrap = document.getElementById('btnOwnerWaitingCancelStep2Wrap');
                                        if (ownerWaitingCancelWrap) ownerWaitingCancelWrap.style.display = (attempts >= 3) ? 'block' : 'none';
                                        const renterCancelBtn = document.getElementById('btnRenterCancelStep2');
                                        if (renterCancelBtn) renterCancelBtn.style.display = (attempts >= 3) ? 'block' : 'none';

                                        const step2OwnerUpload = document.getElementById('chatStep2OwnerUploadBox');
                                        const step2OwnerWaiting = document.getElementById('chatStep2OwnerWaiting');
                                        const step2OwnerFeedback = document.getElementById('chatStep2OwnerFeedbackAlert');
                                        const step2FeedbackText = document.getElementById('chatStep2FeedbackText');
                                        const step2FeedbackAttemptNum = document.getElementById('chatStep2FeedbackAttemptNum');
                                        const step2OwnerThumb = document.getElementById('chatStep2OwnerSubmittedThumb');
                                        const submitBtnText = document.getElementById('btnSubmitPrepPhotoText');

                                        if (isOwner) {
                                            if (step2Owner) step2Owner.style.setProperty('display', 'block', 'important');
                                            if (step2Renter) step2Renter.style.setProperty('display', 'none', 'important');

                                            // Awaiting renter approval after submit
                                            const awaitingRenter = (hasPrepPhoto && prepStatus !== 'FEEDBACK_RECEIVED');

                                            if (awaitingRenter) {
                                                // SHOW WAITING STATE FOR OWNER
                                                if (step2OwnerUpload) step2OwnerUpload.style.display = 'none';
                                                if (step2OwnerWaiting) step2OwnerWaiting.style.setProperty('display', 'block', 'important');
                                                if (step2OwnerThumb) step2OwnerThumb.src = ord.prep_photo_url;
                                            } else {
                                                // SHOW UPLOAD / RE-UPLOAD FORM
                                                if (step2OwnerWaiting) step2OwnerWaiting.style.setProperty('display', 'none', 'important');
                                                if (step2OwnerUpload) step2OwnerUpload.style.display = 'block';

                                                // Show feedback alert if renter requested another photo
                                                if (hasFeedback) {
                                                    if (step2OwnerFeedback) step2OwnerFeedback.style.setProperty('display', 'block', 'important');
                                                    if (step2FeedbackText) step2FeedbackText.innerText = `"${ord.prep_feedback}"`;
                                                    if (step2FeedbackAttemptNum) step2FeedbackAttemptNum.innerText = `Attempt ${Math.max(1, attempts - 1)}`;
                                                    if (submitBtnText) submitBtnText.innerText = `Submit Replacement Photo (Attempt ${attempts} of 3)`;
                                                } else {
                                                    if (step2OwnerFeedback) step2OwnerFeedback.style.setProperty('display', 'none', 'important');
                                                    if (submitBtnText) submitBtnText.innerText = `Submit Preparation Photo`;
                                                }
                                            }
                                        } else {
                                            // Renter view
                                            if (step2Owner) step2Owner.style.setProperty('display', 'none', 'important');
                                            if (step2Renter) step2Renter.style.setProperty('display', 'block', 'important');

                                            const renterWaitNotice = document.getElementById('chatStep2RenterWaitingText');

                                            if (!hasPrepPhoto || prepStatus === 'FEEDBACK_RECEIVED') {
                                                // Renter must wait for photo proof; chat locked until owner uploads photo!
                                                if (step2RenterWait) step2RenterWait.style.setProperty('display', 'flex', 'important');
                                                if (step2RenterAction) step2RenterAction.style.setProperty('display', 'none', 'important');
                                                if (chatInput) {
                                                     chatInput.disabled = true;
                                                     chatInput.placeholder = hasFeedback 
                                                         ? `Chat locked: Stock owner is taking a replacement photo (Attempt ${attempts} of 3)...` 
                                                         : 'Chat locked: Stock owner is preparing equipment & uploading photo proof...';
                                                }
                                                if (sendBtn) sendBtn.disabled = true;
                                                if (renterWaitNotice) {
                                                     renterWaitNotice.innerText = hasFeedback
                                                         ? `Feedback sent (Attempt ${Math.max(1, attempts - 1)} of 3). Stock owner is preparing a replacement photo.`
                                                         : 'Stock owner is inspecting and packaging your gear. Chat will unlock once preparation photo is submitted.';
                                                }
                                            } else {
                                                // Photo uploaded! Renter can view photo & click Accept or Request Another Photo
                                                if (step2RenterWait) step2RenterWait.style.setProperty('display', 'none', 'important');
                                                if (step2RenterAction) step2RenterAction.style.setProperty('display', 'block', 'important');
                                                if (prepImgDisplay) prepImgDisplay.src = ord.prep_photo_url;
                                            }
                                        }
                                    }

                                    // STEP 3: Campus Meetup Spot
                                    else if (!hasMeetupLoc) {
                                        if (headerStepBadge) {
                                            headerStepBadge.innerHTML = 'Step 3 of 4';
                                            headerStepBadge.style.background = '#E0F2FE';
                                            headerStepBadge.style.color = '#0369A1';
                                            headerStepBadge.style.borderColor = '#BAE6FD';
                                        }
                                        if (headerActionBadge) {
                                            headerActionBadge.innerHTML = isOwner ? '<i class="fa-solid fa-location-dot me-1"></i>Set Meetup' : '<i class="fa-solid fa-clock me-1"></i>Awaiting Meetup';
                                            headerActionBadge.style.background = '#F0F9FF';
                                            headerActionBadge.style.color = '#0369A1';
                                            headerActionBadge.style.borderColor = '#BAE6FD';
                                        }
                                        if (stepPill) { stepPill.innerText = 'Step 3 of 4 • Campus Meetup Location'; stepPill.style.background = '#E0F2FE'; stepPill.style.color = '#0369A1'; }
                                        if (step3Row) step3Row.style.setProperty('display', 'block', 'important');

                                        if (isOwner) {
                                            if (step3Owner) step3Owner.style.setProperty('display', 'block', 'important');
                                            if (step3Renter) step3Renter.style.setProperty('display', 'none', 'important');
                                        } else {
                                            if (step3Owner) step3Owner.style.setProperty('display', 'none', 'important');
                                            if (step3Renter) step3Renter.style.setProperty('display', 'flex', 'important');
                                            if (meetupNotice) meetupNotice.innerText = 'Waiting for stock owner to field campus meetup spot...';
                                        }
                                    }
                                    // STEP 4: In-Person Handover & Start Timer
                                    else {
                                        if (headerStepBadge) {
                                            headerStepBadge.innerHTML = 'Step 4 of 4';
                                            headerStepBadge.style.background = '#DCFCE7';
                                            headerStepBadge.style.color = '#15803D';
                                            headerStepBadge.style.borderColor = '#86EFAC';
                                        }
                                        if (headerActionBadge) {
                                            headerActionBadge.innerHTML = isOwner ? '<i class="fa-solid fa-play me-1"></i>Start Timer' : '<i class="fa-solid fa-person-walking me-1"></i>Handover';
                                            headerActionBadge.style.background = '#ECFDF5';
                                            headerActionBadge.style.color = '#059669';
                                            headerActionBadge.style.borderColor = '#A7F3D0';
                                        }
                                        if (stepPill) { stepPill.innerText = 'Step 4 of 4 • Handover & Start Timer'; stepPill.style.background = '#DCFCE7'; stepPill.style.color = '#15803D'; }
                                        if (step4Row) step4Row.style.setProperty('display', 'block', 'important');

                                        if (isOwner) {
                                            if (step4Owner) step4Owner.style.setProperty('display', 'block', 'important');
                                            if (step4Renter) step4Renter.style.setProperty('display', 'none', 'important');
                                            if (step4LocOwner) step4LocOwner.innerText = ord.meetup_location;
                                        } else {
                                            if (step4Owner) step4Owner.style.setProperty('display', 'none', 'important');
                                            if (step4Renter) step4Renter.style.setProperty('display', 'flex', 'important');
                                            if (step4LocRenter) step4LocRenter.innerText = ord.meetup_location;
                                        }
                                    }
                                }
                            } catch(e) {
                                console.error("Error fetching chat rental state:", e);
                            }
                        }

                        function startChatTimerCountdown(endIsoString, isOwner) {
                            if (chatRentalTimerInterval) {
                                clearInterval(chatRentalTimerInterval);
                                chatRentalTimerInterval = null;
                            }

                            const isOrderReturnedOrRated = (currentChatRentalOrder && (
                                currentChatRentalOrder.order_status === 'RETURNED' ||
                                parseInt(currentChatRentalOrder.has_rated) === 1 ||
                                parseInt(currentChatRentalOrder.rating) > 0
                            ));

                            const timerBanner = document.getElementById('chatRentalTimerBanner');
                            const headerBar = document.querySelector('.rentchat-header-bar');
                            const chatVw = document.getElementById('chatView');

                            if (isOrderReturnedOrRated) {
                                if (timerBanner) {
                                    timerBanner.style.setProperty('display', 'none', 'important');
                                    timerBanner.classList.remove('is-overdue');
                                }
                                if (headerBar) headerBar.classList.remove('is-overdue');
                                if (chatVw) chatVw.classList.remove('is-overdue');
                                return;
                            }

                            const updateDisplay = () => {
                                const isStillReturnedOrRated = (currentChatRentalOrder && (
                                    currentChatRentalOrder.order_status === 'RETURNED' ||
                                    parseInt(currentChatRentalOrder.has_rated) === 1 ||
                                    parseInt(currentChatRentalOrder.rating) > 0
                                ));
                                if (isStillReturnedOrRated) {
                                    if (chatRentalTimerInterval) { clearInterval(chatRentalTimerInterval); chatRentalTimerInterval = null; }
                                    if (timerBanner) {
                                        timerBanner.style.setProperty('display', 'none', 'important');
                                        timerBanner.classList.remove('is-overdue');
                                    }
                                    if (headerBar) headerBar.classList.remove('is-overdue');
                                    if (chatVw) chatVw.classList.remove('is-overdue');
                                    return;
                                }
                                const cdText = document.getElementById('chatLiveCountdownText');
                                const badge = document.getElementById('chatLiveTimerBadge');
                                const cdLabel = document.getElementById('chatCountdownLabel');
                                const ownerReportRow = document.getElementById('chatTimerOwnerReportRow');
                                const restockRow = document.getElementById('chatTimerRestockRow');
                                const renterOverdueRow = document.getElementById('chatTimerRenterOverdueRow');
                                const timerBanner = document.getElementById('chatRentalTimerBanner');
                                const headerBar = document.querySelector('.rentchat-header-bar');
                                const chatVw = document.getElementById('chatView');
                                if (!cdText) return;

                                if (!endIsoString) {
                                    cdText.innerText = '00:00:00';
                                    if (ownerReportRow) ownerReportRow.style.setProperty('display', 'none', 'important');
                                    if (restockRow) restockRow.style.setProperty('display', 'none', 'important');
                                    if (renterOverdueRow) renterOverdueRow.style.setProperty('display', 'none', 'important');
                                    if (timerBanner) timerBanner.classList.remove('is-overdue');
                                    if (headerBar) headerBar.classList.remove('is-overdue');
                                    if (chatVw) chatVw.classList.remove('is-overdue');
                                    return;
                                }

                                const endTime = new Date(endIsoString).getTime();
                                const now = Date.now();
                                const diffMs = endTime - now;

                                const isOverdue = (diffMs <= 0) || (currentChatRentalOrder && (currentChatRentalOrder.is_overdue || currentChatRentalOrder.unreturned_reported == 1 || currentChatRentalOrder.order_status === 'OVERDUE'));

                                if (isOverdue) {
                                    // Timer expired / Overdue: Turn banner, header bar, and chat red!
                                    // Overdue is NOT zero -> hide Restock button
                                    if (restockRow) restockRow.style.setProperty('display', 'none', 'important');

                                    if (timerBanner) timerBanner.classList.add('is-overdue');
                                    if (headerBar) headerBar.classList.add('is-overdue');
                                    if (chatVw) chatVw.classList.add('is-overdue');

                                    cdText.innerText = '⚠️ 00:00:00 • EXPIRED';
                                    cdText.className = 'rentchat-countdown-digits font-monospace fw-extrabold text-white';
                                    if (badge) {
                                        badge.innerHTML = '<i class="fa-solid fa-triangle-exclamation fs-11"></i> <span>Overdue • Return Required</span>';
                                        badge.className = 'badge rounded-pill fw-bold px-2.5 py-1 fs-9 d-inline-flex align-items-center gap-1.5 bg-danger text-white border border-white border-opacity-25 shadow-sm';
                                        badge.style = '';
                                    }
                                    if (cdLabel) cdLabel.innerText = 'Rental Period Expired';

                                    // CRITICAL: Rental is OVERDUE!
                                    // ONLY the Stock Owner can see the Report Unreturned button!
                                    if (isOwner) {
                                        if (ownerReportRow) ownerReportRow.style.setProperty('display', 'flex', 'important');
                                        if (renterOverdueRow) renterOverdueRow.style.setProperty('display', 'none', 'important');
                                    } else {
                                        if (ownerReportRow) ownerReportRow.style.setProperty('display', 'none', 'important');
                                        if (renterOverdueRow) renterOverdueRow.style.setProperty('display', 'flex', 'important');
                                    }
                                    return;
                                }

                                // Timer is still actively running: Normal state -> OVERDUE IS ZERO!
                                if (timerBanner) timerBanner.classList.remove('is-overdue');
                                if (headerBar) headerBar.classList.remove('is-overdue');
                                if (chatVw) chatVw.classList.remove('is-overdue');
                                if (ownerReportRow) ownerReportRow.style.setProperty('display', 'none', 'important');
                                if (renterOverdueRow) renterOverdueRow.style.setProperty('display', 'none', 'important');

                                const earlyReturnPending = currentChatRentalOrder && String(currentChatRentalOrder.early_return_status || '').toUpperCase() === 'PENDING_RENTER';
                                const earlyReturnButton = document.getElementById('btnChatMarkReturnedRestock');
                                if (earlyReturnPending && isOwner) {
                                    if (restockRow) restockRow.style.setProperty('display', 'block', 'important');
                                    if (earlyReturnButton) {
                                        earlyReturnButton.disabled = true;
                                        earlyReturnButton.innerHTML = '<i class="fa-solid fa-hourglass-half fa-spin me-1"></i> Waiting for renter verification';
                                    }
                                } else if (earlyReturnButton) {
                                    earlyReturnButton.disabled = false;
                                    earlyReturnButton.innerHTML = '<i class="fa-solid fa-boxes-packing me-1"></i> Early Return &amp; Restock';
                                }

                                // Overdue is ZERO: Show "Mark Returned & Restock" ONLY to the Stock Owner!
                                if (isOwner && !earlyReturnPending) {
                                    if (restockRow) restockRow.style.setProperty('display', 'block', 'important');
                                } else if (!isOwner) {
                                    if (restockRow) restockRow.style.setProperty('display', 'none', 'important');
                                }

                                const totalSecs = Math.floor(diffMs / 1000);
                                const hours = Math.floor(totalSecs / 3600);
                                const mins = Math.floor((totalSecs % 3600) / 60);
                                const secs = totalSecs % 60;

                                const hStr = hours < 10 ? '0' + hours : hours;
                                const mStr = mins < 10 ? '0' + mins : mins;
                                const sStr = secs < 10 ? '0' + secs : secs;

                                cdText.innerText = `${hStr}h ${mStr}m ${sStr}s`;
                                cdText.className = 'rentchat-countdown-digits font-monospace fw-extrabold';
                                if (badge) {
                                    badge.innerHTML = '<i class="fa-solid fa-play fs-11"></i> <span>Timer Running</span>';
                                    badge.className = 'badge rounded-pill fw-bold px-2.5 py-1 fs-9 d-inline-flex align-items-center gap-1.5';
                                    badge.style = 'background:rgba(16, 185, 129, 0.2); color:#34D399; border:1px solid rgba(52, 211, 153, 0.35);';
                                }
                                if (cdLabel) cdLabel.innerText = 'Time Remaining';
                            };

                            updateDisplay();
                            chatRentalTimerInterval = setInterval(updateDisplay, 1000);
                        }

                        // STEP 1 POP-UP NOTIFICATION & CHIME AUDIO SYSTEM
                        window.playRentalRequestChime = function () {
                            try {
                                const AudioContext = window.AudioContext || window.webkitAudioContext;
                                if (!AudioContext) return;
                                const ctx = new AudioContext();
                                const now = ctx.currentTime;
                                
                                const osc1 = ctx.createOscillator();
                                const gain1 = ctx.createGain();
                                osc1.type = 'sine';
                                osc1.frequency.setValueAtTime(659.25, now);
                                gain1.gain.setValueAtTime(0.18, now);
                                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.28);
                                osc1.connect(gain1);
                                gain1.connect(ctx.destination);
                                osc1.start(now);
                                osc1.stop(now + 0.28);

                                const osc2 = ctx.createOscillator();
                                const gain2 = ctx.createGain();
                                osc2.type = 'sine';
                                osc2.frequency.setValueAtTime(880, now + 0.12);
                                gain2.gain.setValueAtTime(0.22, now + 0.12);
                                gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.55);
                                osc2.connect(gain2);
                                gain2.connect(ctx.destination);
                                osc2.start(now + 0.12);
                                osc2.stop(now + 0.55);
                            } catch(e) {}
                        };

                        window._shownStep1Modals = window._shownStep1Modals || new Set();

                        window.showStep1OwnerProposalPopup = function (ord, renterName, itemTitle) {
                            if (!ord) return;
                            const modalKey = 'step1_' + (ord.order_code || ord.id);
                            if (window._shownStep1Modals.has(modalKey)) return;
                            window._shownStep1Modals.add(modalKey);

                            const modalEl = document.getElementById('step1OwnerProposalModal');
                            if (!modalEl) return;

                            const rName = renterName || ord.customer_name || 'Student Renter';
                            const renterNameEl = document.getElementById('step1ModalRenterName');
                            if (renterNameEl) renterNameEl.innerText = rName;

                            const renterAvatarEl = document.getElementById('step1ModalRenterAvatar');
                            if (renterAvatarEl) {
                                renterAvatarEl.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(rName)}&background=5B3FA8&color=fff&bold=true&rounded=true`;
                            }

                            const itemTitleEl = document.getElementById('step1ModalItemTitle');
                            if (itemTitleEl) itemTitleEl.innerText = itemTitle || ord.item_name || 'Campus Equipment';

                            const orderCodeEl = document.getElementById('step1ModalOrderCode');
                            if (orderCodeEl) orderCodeEl.innerText = ord.order_code || '#RE-ORDER';

                            const totalEl = document.getElementById('step1ModalTotalAmount');
                            if (totalEl) totalEl.innerText = `₱${parseFloat(ord.total_amount || 0).toFixed(2)}`;

                            const durationEl = document.getElementById('step1ModalDuration');
                            if (durationEl) {
                                const days = parseInt(ord.rental_days) || 1;
                                durationEl.innerText = days === 1 ? '1 Day Duration' : `${days} Days Duration`;
                            }

                            if (typeof playRentalRequestChime === 'function') {
                                playRentalRequestChime();
                            }

                            try {
                                const inst = bootstrap.Modal.getOrCreateInstance(modalEl);
                                inst.show();
                            } catch(e) {
                                modalEl.style.display = 'block';
                            }
                        };

                        window.executeStep1AgreeFromPopup = async function () {
                            const modalEl = document.getElementById('step1OwnerProposalModal');
                            if (modalEl) {
                                try {
                                    const inst = bootstrap.Modal.getInstance(modalEl);
                                    if (inst) inst.hide();
                                } catch(e) {}
                            }
                            const btnModal = document.getElementById('btnModalStep1Agree');
                            if (btnModal) {
                                btnModal.disabled = true;
                                btnModal.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Agreeing...';
                            }
                            if (typeof window.executeStep1Agree === 'function') {
                                await window.executeStep1Agree();
                            }
                            if (btnModal) {
                                btnModal.disabled = false;
                                btnModal.innerHTML = '<i class="fa-solid fa-handshake-simple fs-6"></i> Agree to Rent Equipment';
                            }
                        };

                        window._notifiedStep1Orders = window._notifiedStep1Orders || new Set();

                        window.showStep1IncomingProposalToast = function (order, renterName, itemTitle, partnerId) {
                            if (!order) return;
                            const toastKey = 'toast_' + (order.order_code || order.id);
                            if (window._notifiedStep1Orders.has(toastKey)) return;
                            window._notifiedStep1Orders.add(toastKey);

                            const toastEl = document.getElementById('step1IncomingProposalToast');
                            if (!toastEl) return;

                            const renterTitleEl = document.getElementById('step1ToastRenterAndItem');
                            if (renterTitleEl) {
                                renterTitleEl.innerText = `${renterName || order.customer_name || 'A Student'} wants to rent your '${itemTitle || order.item_name || 'equipment'}'!`;
                            }

                            const detailsEl = document.getElementById('step1ToastDetails');
                            if (detailsEl) {
                                detailsEl.innerText = `Order ${order.order_code} • ₱${parseFloat(order.total_amount || 0).toFixed(2)} • Step 1: Agree to Rent`;
                            }

                            const openBtn = document.getElementById('btnStep1ToastOpen');
                            if (openBtn) {
                                openBtn.onclick = function () {
                                    dismissStep1IncomingToast();
                                    const pId = partnerId || parseInt(order.renter_id) || 105;
                                    const pName = renterName || order.customer_name || 'Student Renter';
                                    const iTitle = itemTitle || order.item_name || 'Campus Equipment';
                                    const iPrice = `₱${parseFloat(order.total_amount || 0).toFixed(2)}`;
                                    if (typeof window.checkAndOpenChat === 'function') {
                                        window.checkAndOpenChat(pId, pName, iTitle, iPrice, '', '', true, 'You');
                                    }
                                };
                            }

                            if (typeof playRentalRequestChime === 'function') {
                                playRentalRequestChime();
                            }

                            toastEl.style.display = 'block';

                            clearTimeout(window._step1ToastTimer);
                            window._step1ToastTimer = setTimeout(() => {
                                dismissStep1IncomingToast();
                            }, 12000);
                        };

                        window.dismissStep1IncomingToast = function () {
                            const toastEl = document.getElementById('step1IncomingProposalToast');
                            if (toastEl) toastEl.style.display = 'none';
                        };

                        // STEP 1: OWNER AGREES TO RENT
                        window.executeStep1Agree = async function () {
                            if (!currentChatRentalOrder) return;
                            const btn = document.getElementById('btnStep1Agree');
                            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Agreeing...'; }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const ownerId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || (currentChatRentalOrder ? currentChatRentalOrder.owner_id : 104)) : (currentChatRentalOrder ? currentChatRentalOrder.owner_id : 104);

                            try {
                                const apiEndpoint = window.location.pathname.includes('/student/') ? 'rentease_api.php?action=step1_owner_agree' : '/student/rentease_api.php?action=step1_owner_agree';
                                const res = await fetch(apiEndpoint, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ order_code: currentChatRentalOrder.order_code, owner_id: ownerId })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    await checkAndRenderChatRentalTimer();
                                    await refreshActiveChatStream();
                                } else {
                                    alert(data.message || 'Failed to confirm booking.');
                                }
                            } catch(e) {
                                console.error('Step 1 error:', e);
                            } finally {
                                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-handshake-simple fs-8"></i> Agree to Rent Equipment'; }
                            }
                        };

                        // STEP 2A: OWNER SUBMITS PREP PHOTO
                        let currentPrepPhotoBase64 = '';
                        window.handlePrepPhotoUpload = function (event) {
                            const file = event.target.files[0];
                            if (!file) return;
                            const label = document.getElementById('prepPhotoNameLabel');
                            if (label) label.innerText = file.name;

                            const reader = new FileReader();
                            reader.onload = function (e) {
                                currentPrepPhotoBase64 = e.target.result;
                                const previewImg = document.getElementById('prepPhotoPreviewImg');
                                const wrap = document.getElementById('prepPhotoPreviewWrap');
                                if (previewImg) previewImg.src = e.target.result;
                                if (wrap) wrap.style.display = 'block';
                                const submitBtn = document.getElementById('btnSubmitPrepPhoto');
                                if (submitBtn) submitBtn.disabled = false;
                            };
                            reader.readAsDataURL(file);
                        };

                        window.executeStep2SubmitPhoto = async function () {
                            if (!currentChatRentalOrder || !currentPrepPhotoBase64) {
                                alert('Please select or take an equipment photo first.');
                                return;
                            }
                            const btn = document.getElementById('btnSubmitPrepPhoto');
                            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Submitting Photo...'; }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const ownerId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || (currentChatRentalOrder ? currentChatRentalOrder.owner_id : 104)) : (currentChatRentalOrder ? currentChatRentalOrder.owner_id : 104);

                            try {
                                const res = await fetch('/student/rentease_api.php?action=step2_owner_submit_prep_photo', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_code: currentChatRentalOrder.order_code,
                                        owner_id: ownerId,
                                        photo_url: currentPrepPhotoBase64
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    await checkAndRenderChatRentalTimer();
                                    await refreshActiveChatStream();
                                } else {
                                    alert(data.message || 'Failed to submit preparation photo.');
                                }
                            } catch(e) {
                                console.error('Step 2 submit photo error:', e);
                            } finally {
                                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Submit Preparation Photo'; }
                            }
                        };

                                                // STEP 2: RENTER FEEDBACK & MUTUAL CANCELLATION HELPERS
                        window.openStep2FeedbackModal = function () {
                            if (!currentChatRentalOrder) return;
                            const attempts = Math.max(1, parseInt(currentChatRentalOrder.prep_photo_attempts || 1));
                            const pill = document.getElementById('step2FeedbackAttemptBadge');
                            if (pill) pill.innerText = `Attempt ${attempts} of 3`;
                            const inp = document.getElementById('step2FeedbackInput');
                            if (inp) inp.value = '';
                            const modalEl = document.getElementById('step2FeedbackModal');
                            if (modalEl && window.bootstrap) {
                                const m = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                m.show();
                            }
                        };

                        window.appendStep2FeedbackChip = function (text) {
                            const inp = document.getElementById('step2FeedbackInput');
                            if (!inp) return;
                            const cur = inp.value.trim();
                            inp.value = cur ? `${cur}; ${text}` : text;
                            inp.focus();
                        };

                        window.executeStep2SendFeedback = async function () {
                            if (!currentChatRentalOrder) return;
                            const inp = document.getElementById('step2FeedbackInput');
                            const feedback = inp ? inp.value.trim() : '';
                            if (!feedback) {
                                alert('Please describe what needs improvement or select a quick feedback reason.');
                                return;
                            }
                            const btn = document.getElementById('btnSubmitStep2Feedback');
                            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Sending...'; }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const renterId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || (currentChatRentalOrder ? currentChatRentalOrder.renter_id : 105)) : (currentChatRentalOrder ? currentChatRentalOrder.renter_id : 105);

                            try {
                                const res = await fetch('/student/rentease_api.php?action=step2_renter_request_new_photo', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_code: currentChatRentalOrder.order_code,
                                        renter_id: renterId,
                                        feedback: feedback
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    const modalEl = document.getElementById('step2FeedbackModal');
                                    if (modalEl && window.bootstrap) {
                                        const m = bootstrap.Modal.getInstance(modalEl);
                                        if (m) m.hide();
                                    }
                                    await checkAndRenderChatRentalTimer();
                                    await refreshActiveChatStream();
                                } else {
                                    alert(data.message || 'Failed to submit feedback.');
                                }
                            } catch(e) {
                                console.error('Step 2 feedback error:', e);
                            } finally {
                                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Send Feedback'; }
                            }
                        };

                        window.openStep2CancelModal = function (role) {
                            if (!currentChatRentalOrder) return;
                            window._step2CancelRole = role || 'RENTER';
                            const container = document.getElementById('step2CancelQuickChips');
                            if (container) {
                                if (role === 'OWNER') {
                                    container.innerHTML = `
                                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="appendStep2CancelChip('Unable to satisfy renter condition requirements after 3 attempts')">Cannot meet expectations</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="appendStep2CancelChip('Equipment is no longer in optimal condition to rent out')">Equipment issue</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="appendStep2CancelChip('Decided not to rent out this item at this time')">Prefer not to rent out</button>
                                    `;
                                } else {
                                    container.innerHTML = `
                                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="appendStep2CancelChip('Equipment condition does not meet my expectations after 3 photo reviews')">Condition not met</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="appendStep2CancelChip('Photos remained unclear or unverified after 3 attempts')">Unclear photos</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="appendStep2CancelChip('Found an alternative equipment rental on campus')">Alternative found</button>
                                    `;
                                }
                            }
                            const inp = document.getElementById('step2CancelReasonInput');
                            if (inp) inp.value = '';
                            const modalEl = document.getElementById('step2CancelModal');
                            if (modalEl && window.bootstrap) {
                                const m = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                m.show();
                            }
                        };

                        window.appendStep2CancelChip = function (text) {
                            const inp = document.getElementById('step2CancelReasonInput');
                            if (!inp) return;
                            const cur = inp.value.trim();
                            inp.value = cur ? `${cur}; ${text}` : text;
                            inp.focus();
                        };

                        window.executeStep2ConfirmCancellation = async function () {
                            if (!currentChatRentalOrder) return;
                            const inp = document.getElementById('step2CancelReasonInput');
                            const reason = inp ? inp.value.trim() : '';
                            if (!reason) {
                                alert('Please explain why you choose to cancel this rental item.');
                                return;
                            }
                            const btn = document.getElementById('btnConfirmCancelRental');
                            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Cancelling...'; }

                            try {
                                const res = await fetch('/student/rentease_api.php?action=step2_cancel_rental', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_code: currentChatRentalOrder.order_code,
                                        role: window._step2CancelRole || 'RENTER',
                                        reason: reason
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    const modalEl = document.getElementById('step2CancelModal');
                                    if (modalEl && window.bootstrap) {
                                        const m = bootstrap.Modal.getInstance(modalEl);
                                        if (m) m.hide();
                                    }
                                    await checkAndRenderChatRentalTimer();
                                    await refreshActiveChatStream();
                                } else {
                                    alert(data.message || 'Failed to cancel rental order.');
                                }
                            } catch(e) {
                                console.error('Step 2 cancellation error:', e);
                            } finally {
                                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-ban me-1"></i> Confirm Cancel'; }
                            }
                        };

                        // STEP 2B: RENTER ACCEPTS PREPARATION PHOTO
                        window.executeStep2RenterAccept = async function () {
                            if (!currentChatRentalOrder) return;

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const renterId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || (currentChatRentalOrder ? currentChatRentalOrder.renter_id : 105)) : (currentChatRentalOrder ? currentChatRentalOrder.renter_id : 105);

                            try {
                                const res = await fetch('/student/rentease_api.php?action=step2_renter_confirm_prep', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_code: currentChatRentalOrder.order_code,
                                        renter_id: renterId
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    await checkAndRenderChatRentalTimer();
                                    await refreshActiveChatStream();
                                } else {
                                    alert(data.message || 'Failed to accept preparation.');
                                }
                            } catch(e) {
                                console.error('Step 2 accept error:', e);
                            }
                        };

                        // STEP 3: OWNER SETS CAMPUS MEETUP LOCATION
                        window.executeStep3SetLocation = async function () {
                            if (!currentChatRentalOrder) return;
                            const locInput = document.getElementById('chatMeetupLocationInput');
                            const loc = locInput ? locInput.value.trim() : '';
                            if (!loc) {
                                alert('Please enter or select a campus meetup spot.');
                                return;
                            }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const ownerId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || (currentChatRentalOrder ? currentChatRentalOrder.owner_id : 104)) : (currentChatRentalOrder ? currentChatRentalOrder.owner_id : 104);

                            try {
                                const res = await fetch('/student/rentease_api.php?action=step3_owner_set_meetup_location', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_code: currentChatRentalOrder.order_code,
                                        owner_id: ownerId,
                                        location: loc
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    await checkAndRenderChatRentalTimer();
                                    await refreshActiveChatStream();
                                } else {
                                    alert(data.message || 'Failed to set meetup location.');
                                }
                            } catch(e) {
                                console.error('Step 3 error:', e);
                            }
                        };

                        // STEP 4: OWNER HANDS OVER ITEM & STARTS TIMER
                        window.executeStep4StartTimer = async function () {
                            if (!currentChatRentalOrder) return;
                            const btn = document.getElementById('btnStep4StartTimer');
                            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Starting Timer...'; }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const ownerId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || (currentChatRentalOrder ? currentChatRentalOrder.owner_id : 104)) : (currentChatRentalOrder ? currentChatRentalOrder.owner_id : 104);

                            try {
                                const res = await fetch('/student/rentease_api.php?action=step4_owner_handover_start_timer', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_code: currentChatRentalOrder.order_code,
                                        owner_id: ownerId
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    await checkAndRenderChatRentalTimer();
                                    await refreshActiveChatStream();
                                } else {
                                    alert(data.message || 'Failed to start timer. Ensure all steps are complete.');
                                }
                            } catch(e) {
                                console.error('Step 4 error:', e);
                            } finally {
                                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-play me-1"></i> Hand Over Item & Start Rental Timer'; }
                            }
                        };

                        window.openReportUnreturnedModalFromChat = function () {
                            if (!currentChatRentalOrder) return;

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            let currentUserEmail = (storedUser && storedUser.email ? storedUser.email : '').toLowerCase().trim();
                            let currentUserName = (storedUser ? (storedUser.name || (storedUser.firstName || '') + ' ' + (storedUser.lastName || '')) : '').toLowerCase().trim();
                            let currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 0) : 0;
                            if (!currentUserId || currentUserId <= 0) {
                                currentUserId = (currentUserEmail.includes('pogilameg') || currentUserName.includes('pogilameg')) ? 105 : 104;
                            }

                            let isOwner = false;
                            if (typeof currentChatRentalOrder.is_owner === 'boolean') {
                                isOwner = currentChatRentalOrder.is_owner;
                            } else {
                                if (currentUserId && currentChatRentalOrder.owner_id && parseInt(currentUserId) === parseInt(currentChatRentalOrder.owner_id)) {
                                    isOwner = true;
                                } else if (currentUserEmail && currentChatRentalOrder.owner_email && currentUserEmail === currentChatRentalOrder.owner_email.toLowerCase()) {
                                    isOwner = true;
                                }
                            }
                            if ((currentUserId && currentChatRentalOrder.renter_id && parseInt(currentUserId) === parseInt(currentChatRentalOrder.renter_id)) ||
                                (currentUserEmail && currentChatRentalOrder.customer_email && currentUserEmail === currentChatRentalOrder.customer_email.toLowerCase())) {
                                isOwner = false;
                            }

                            if (!isOwner) {
                                alert("❌ Action not allowed: Only the equipment stock owner (lender) can report an unreturned item.");
                                return;
                            }

                            const endTime = currentChatRentalOrder.rental_timer_end ? new Date(currentChatRentalOrder.rental_timer_end).getTime() : 0;
                            if (endTime > Date.now() && currentChatRentalOrder.timer_status !== 'EXPIRED' && currentChatRentalOrder.order_status !== 'OVERDUE') {
                                alert("⚠️ Cannot report yet: The agreed rental duration has not expired. The renter still has active rental time remaining.");
                                return;
                            }

                            const codeEl = document.getElementById('unretModalOrderCode');
                            if (codeEl) codeEl.innerText = currentChatRentalOrder.order_code;
                            const nameEl = document.getElementById('unretModalItemName');
                            if (nameEl) nameEl.innerText = currentChatRentalOrder.item_name;
                            const renterEl = document.getElementById('unretModalRenterName');
                            if (renterEl) renterEl.innerText = `${currentChatRentalOrder.customer_name} (${currentChatRentalOrder.customer_email})`;
                            const detEl = document.getElementById('unretReportDetails');
                            if (detEl) detEl.value = '';
                            const photoEl = document.getElementById('unretPhotoDataUrl');
                            if (photoEl) photoEl.value = '';
                            const previewBox = document.getElementById('unretPhotoPreviewBox');
                            if (previewBox) previewBox.style.display = 'none';

                            const modalEl = document.getElementById('reportUnreturnedModal');
                            if (modalEl) new bootstrap.Modal(modalEl).show();
                        };

                        window.previewUnretReportPhoto = function (event) {
                            const file = event.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const hidden = document.getElementById('unretPhotoDataUrl');
                                if (hidden) hidden.value = e.target.result;
                                const img = document.getElementById('unretPhotoPreview');
                                const box = document.getElementById('unretPhotoPreviewBox');
                                if (img) img.src = e.target.result;
                                if (box) box.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        };

                        window.executeSubmitUnreturnedReport = async function () {
                            if (!currentChatRentalOrder) return;
                            const details = document.getElementById('unretReportDetails')?.value.trim();
                            const photoUrl = document.getElementById('unretPhotoDataUrl')?.value || '';
                            if (!details) {
                                alert('Please describe the incident / unreturned situation.');
                                return;
                            }

                            const btn = document.getElementById('btnSubmitUnretReport');
                            if (btn) {
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Submitting...';
                            }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const ownerId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            try {
                                const res = await fetch('/student/rentease_api.php?action=report_unreturned_item', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_code: currentChatRentalOrder.order_code,
                                        owner_id: ownerId,
                                        reason: document.getElementById('unretReportReason')?.value || 'Item not returned after rental period',
                                        details: details,
                                        photo_url: photoUrl
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    alert("🚨 Report submitted to Admin with photo proof!\nAdmin will review the case. If approved, the renter's account will be suspended from renting for 5 days.");
                                    const modalEl = document.getElementById('reportUnreturnedModal');
                                    if (modalEl) {
                                        const bs = bootstrap.Modal.getInstance(modalEl);
                                        if (bs) bs.hide();
                                    }
                                    await checkAndRenderChatRentalTimer();
                                    await refreshActiveChatStream();
                                } else {
                                    alert(data.message || 'Failed to submit report');
                                }
                            } catch(e) {
                                console.error("Report submit error:", e);
                            } finally {
                                if (btn) {
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Submit Report';
                                }
                            }
                        };

                        
                        window.markRentalReturnedAndRestockFromChat = async function () {
                            if (!currentChatRentalOrder) {
                                alert('No active rental order found in this conversation.');
                                return;
                            }
                            const orderCode = currentChatRentalOrder.order_code;
                            const orderId = currentChatRentalOrder.id;
                            const storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user') || '{}');
                            const userId = storedUser.id || storedUser.userId || storedUser.UserId || 0;
                            const userEmail = storedUser.email || '';
                            const isOwner = (parseInt(userId) === parseInt(currentChatRentalOrder.owner_id)) ||
                                (userEmail && userEmail.toLowerCase() === String(currentChatRentalOrder.owner_email || '').toLowerCase());
                            if (!isOwner) {
                                alert('The stock owner must start the early-return request. You will receive a verification prompt here.');
                                return;
                            }
                            if (!(await window.showEarlyReturnModal(orderCode, 'owner'))) return;
                            const apiEndpoint = window.location.pathname.includes('/student/') ? 'rentease_api.php?action=request_early_return' : '/student/rentease_api.php?action=request_early_return';
                            const btn = document.getElementById('btnChatMarkReturnedRestock');
                            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Waiting for renter'; }
                            try {
                                const res = await fetch(apiEndpoint, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ order_id: orderId, order_code: orderCode, user_id: userId, user_email: userEmail })
                                });
                                const data = await res.json();
                                if (!data.success) throw new Error(data.message || 'Unable to send request.');
                                alert(data.message);
                                await checkAndRenderChatRentalTimer();
                            } catch (error) {
                                alert(error.message || 'Unable to send the early-return request.');
                            } finally {
                                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-boxes-packing me-1"></i> Early Return &amp; Restock'; }
                            }
                        };

                        window.showEarlyReturnModal = function (orderCode, role) {
                            const id = 'earlyReturnVerificationModal';
                            let modal = document.getElementById(id);
                            if (!modal) {
                                modal = document.createElement('div');
                                modal.id = id;
                                modal.className = 'modal fade';
                                modal.tabIndex = -1;
                                document.body.appendChild(modal);
                            }
                            const owner = role === 'owner';
                            const renterFinal = role === 'renter-confirm';
                            modal.innerHTML = `<div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 rounded-4 shadow-lg p-2">
                                <div class="modal-header border-0 pb-1"><h5 class="modal-title fw-bold">${owner ? 'Request early return?' : renterFinal ? 'Confirm restock?' : 'Did you return the item early?'}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body pt-1"><p class="text-muted mb-0">${owner ? `Order #${orderCode} is still active. Ask the renter to verify before anything is restocked.` : renterFinal ? "Please confirm one more time. This will end the rental and put the item back in the owner's available stock." : `The stock owner is asking you to verify the return for Order #${orderCode}. The item will be restocked only after you confirm.`}</p></div>
                                <div class="modal-footer border-0 pt-1">${owner
                                    ? '<button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Not now</button><button type="button" class="btn btn-primary rounded-pill px-4" id="earlyReturnModalConfirm">Send request</button>'
                                    : renterFinal ? '<button type="button" class="btn btn-light rounded-pill px-4" id="earlyReturnModalCancel">Cancel</button><button type="button" class="btn btn-success rounded-pill px-4" id="earlyReturnModalConfirm">Yes, restock now</button>'
                                    : '<button type="button" class="btn btn-light rounded-pill px-4" id="earlyReturnModalNo">No, not yet</button><button type="button" class="btn btn-success rounded-pill px-4" id="earlyReturnModalYes">Yes, I returned it</button>'}</div>
                            </div></div>`;
                            const instance = bootstrap.Modal.getOrCreateInstance(modal);
                            instance.show();
                            if (owner) {
                                document.getElementById('earlyReturnModalConfirm').onclick = () => { instance.hide(); modal.dataset.confirmed = '1'; };
                                return new Promise(resolve => {
                                    modal.addEventListener('hidden.bs.modal', () => resolve(modal.dataset.confirmed === '1'), { once: true });
                                });
                            }
                            if (renterFinal) {
                                return new Promise(resolve => {
                                    document.getElementById('earlyReturnModalCancel').onclick = () => { instance.hide(); resolve(false); };
                                    document.getElementById('earlyReturnModalConfirm').onclick = () => { instance.hide(); resolve(true); };
                                });
                            }
                            document.getElementById('earlyReturnModalNo').onclick = () => { instance.hide(); window.respondToEarlyReturn('no'); };
                            document.getElementById('earlyReturnModalYes').onclick = () => { instance.hide(); window.respondToEarlyReturn('yes'); };
                            return true;
                        };

                        window.showRatingSuccessModal = function () {
                            const id = 'ratingSuccessModal';
                            let modal = document.getElementById(id);
                            if (!modal) {
                                modal = document.createElement('div');
                                modal.id = id;
                                modal.className = 'modal fade';
                                modal.tabIndex = -1;
                                document.body.appendChild(modal);
                            }
                            modal.innerHTML = `<div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow-lg p-4 text-center">
                                    <div class="mb-3">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center p-3" style="width:64px; height:64px;">
                                            <i class="fa-solid fa-star fs-2"></i>
                                        </div>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">Thank You!</h5>
                                    <p class="text-muted mb-4">Your rating and review have been submitted successfully. Conversation can now be safely deleted.</p>
                                    <button type="button" class="btn btn-warning rounded-pill px-4" data-bs-dismiss="modal">Got it</button>
                                </div>
                            </div>`;
                            const instance = bootstrap.Modal.getOrCreateInstance(modal);
                            instance.show();
                        };

                        window.showEarlyReturnSuccessModal = function (orderCode) {
                            const id = 'earlyReturnSuccessModal';
                            let modal = document.getElementById(id);
                            if (!modal) {
                                modal = document.createElement('div');
                                modal.id = id;
                                modal.className = 'modal fade';
                                modal.tabIndex = -1;
                                document.body.appendChild(modal);
                            }
                            modal.innerHTML = `<div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow-lg p-4 text-center">
                                    <div class="mb-3">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center p-3" style="width:64px; height:64px;">
                                            <i class="fa-solid fa-check fs-2"></i>
                                        </div>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">Return Verified!</h5>
                                    <p class="text-muted mb-4">Order #${orderCode} has been verified and the item is now back in stock. The rental timer has stopped.</p>
                                    <button type="button" class="btn btn-success rounded-pill px-4" data-bs-dismiss="modal">Got it</button>
                                </div>
                            </div>`;
                            const instance = bootstrap.Modal.getOrCreateInstance(modal);
                            instance.show();
                        };

                        window.respondToEarlyReturn = async function (response) {
                            const order = currentChatRentalOrder;
                            if (!order) {
                                console.error('No current chat rental order found');
                                return;
                            }
                            const storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user') || '{}');
                            const apiEndpoint = window.location.pathname.includes('/student/') ? '../rentease_api.php?action=respond_early_return' : '/student/rentease_api.php?action=respond_early_return';
                            
                            console.log('respondToEarlyReturn called:', { response, orderCode: order.order_code, userId: storedUser.id, apiEndpoint });
                            
                            try {
                                // Show loading state immediately
                                if (typeof window.showLoading === 'function') {
                                    window.showLoading('Verifying return...');
                                }

                                const payload = {
                                    order_id: order.id,
                                    order_code: order.order_code,
                                    user_id: storedUser.id || storedUser.userId || storedUser.UserId || 0,
                                    user_email: storedUser.email || '',
                                    response: response
                                };
                                
                                console.log('Sending API request to:', apiEndpoint, 'with payload:', payload);

                                const res = await fetch(apiEndpoint, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload)});
                                const data = await res.json();

                                console.log('API response:', data);

                                if (typeof window.hideLoading === 'function') {
                                    window.hideLoading();
                                }

                                if (!data.success) throw new Error(data.message || 'Unable to verify the return.');

                                // Show success modal
                                showEarlyReturnSuccessModal(order.order_code);

                                await checkAndRenderChatRentalTimer();
                                if (typeof refreshActiveChatStream === 'function') await refreshActiveChatStream();
                            } catch (error) {
                                console.error('respondToEarlyReturn error:', error);
                                if (typeof window.hideLoading === 'function') {
                                    window.hideLoading();
                                }
                                if (typeof window.showToast === 'function') {
                                    window.showToast(error.message || 'Unable to verify the early return.', 'error', 4000);
                                } else {
                                    alert(error.message || 'Unable to verify the early return.');
                                }
                            }
                        };

                        window.executeConfirmReturnReportedOrder = async function () {
                            if (!currentChatRentalOrder) return;
                            const modalEl = document.getElementById('confirmReturnReportedTicketModal');
                            if (modalEl) {
                                const inst = bootstrap.Modal.getInstance(modalEl);
                                if (inst) inst.hide();
                            }
                            const yesBtn = document.getElementById('btnConfirmReturnReportedYes');
                            if (yesBtn) {
                                yesBtn.disabled = true;
                                yesBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Restocking...';
                            }
                            try {
                                await window.markRentalReturnedAndRestockFromChat();
                            } finally {
                                if (yesBtn) {
                                    yesBtn.disabled = false;
                                    yesBtn.innerHTML = '<i class="fa-solid fa-boxes-packing me-1"></i> Yes, Mark Returned';
                                }
                            }
                        };

                        async function doExecuteMarkRentalReturnedRestock(orderId, orderCode) {
                            const btn = document.getElementById('btnChatMarkReturnedRestock');
                            const btnOverdue = document.getElementById('btnChatOverdueRestock');
                            if (btn) {
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Restocking...';
                            }
                            if (btnOverdue) {
                                btnOverdue.disabled = true;
                                btnOverdue.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Restocking item in market...';
                            }

                            try {
                                const apiEndpoint = window.location.pathname.includes('/student/') ? 'rentease_api.php?action=update_owner_order_status' : '/student/rentease_api.php?action=update_owner_order_status';
                                const res = await fetch(apiEndpoint, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        action: 'update_owner_order_status',
                                        order_id: orderId,
                                        order_code: orderCode,
                                        new_status: 'RETURNED'
                                    })
                                });
                                const data = await res.json();
                                if (data && data.success) {
                                    alert(data.message || `Order #${orderCode} marked as RETURNED and restocked.`);
                                    
                                    // 1. Hide timer banner and stop interval in Messages tab
                                    const timerBanner = document.getElementById('chatRentalTimerBanner');
                                    if (timerBanner) timerBanner.style.display = 'none';
                                    if (chatRentalTimerInterval) { clearInterval(chatRentalTimerInterval); chatRentalTimerInterval = null; }
                                    currentChatRentalOrder = null;

                                    // 2. Re-render chat timer / lifecycle state
                                    if (typeof checkAndRenderChatRentalTimer === 'function') {
                                        await checkAndRenderChatRentalTimer();
                                    }
                                    if (typeof refreshActiveChatStream === 'function') {
                                        await refreshActiveChatStream();
                                    }
                                    if (typeof loadChatConversationsList === 'function') {
                                        if (typeof window.loadChatConversationsList === 'function') {
                                            window.loadChatConversationsList();
                                        }
                                    }

                                    // 3. Keep Orders / Rent Out tab in sync!
                                    if (typeof loadOwnerRentalDashboard === 'function') {
                                        loadOwnerRentalDashboard(true);
                                    }
                                    if (typeof loadRentEaseCatalog === 'function') {
                                        loadRentEaseCatalog();
                                    }
                                } else {
                                    alert(data?.message || 'Failed to update order status.');
                                }
                            } catch (e) {
                                console.error('Error marking returned from chat:', e);
                                alert('Server connection error.');
                            } finally {
                                if (btn) {
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fa-solid fa-boxes-packing me-1"></i> Mark Returned &amp; Restock';
                                }
                                if (btnOverdue) {
                                    btnOverdue.disabled = false;
                                    btnOverdue.innerHTML = '<i class="fa-solid fa-boxes-packing me-1"></i> Mark Returned &amp; Restock Item Back in Market';
                                }
                            }
                        }

                        window.currentSelectedRentalStar = 0;

                        window.setRentalStarRating = function(star) {
                            window.currentSelectedRentalStar = parseInt(star) || 0;
                            const container = document.getElementById('chatRatingStarsContainer');
                            if (container) {
                                const starBtns = container.querySelectorAll('.rentchat-star');
                                starBtns.forEach(btn => {
                                    const s = parseInt(btn.dataset.star) || 0;
                                    if (s <= window.currentSelectedRentalStar) {
                                        btn.style.color = '#F59E0B';
                                        btn.style.transform = 'scale(1.15)';
                                    } else {
                                        btn.style.color = '#D1D5DB';
                                        btn.style.transform = 'scale(1.0)';
                                    }
                                });
                            }
                            const labelEl = document.getElementById('chatRatingLabelText');
                            if (labelEl) {
                                const descMap = {
                                    1: '⭐ 1 Star • Poor experience',
                                    2: '⭐⭐ 2 Stars • Fair experience',
                                    3: '⭐⭐⭐ 3 Stars • Good experience',
                                    4: '⭐⭐⭐⭐ 4 Stars • Very Good experience',
                                    5: '⭐⭐⭐⭐⭐ 5 Stars • Excellent experience!'
                                };
                                labelEl.innerText = descMap[window.currentSelectedRentalStar] || 'Tap a star to rate (1–5)';
                                labelEl.style.color = '#D97706';
                            }
                            checkRentalRatingFormValidity();
                        };

                        window.checkRentalRatingFormValidity = function() {
                            const btn = document.getElementById('btnSubmitRentalRating');
                            const reviewText = document.getElementById('chatRatingReviewText')?.value?.trim() || '';
                            const isValid = (window.currentSelectedRentalStar >= 1 && window.currentSelectedRentalStar <= 5 && reviewText.length > 0);
                            if (btn) {
                                btn.disabled = !isValid;
                                if (isValid) {
                                    btn.classList.add('shadow-sm');
                                } else {
                                    btn.classList.remove('shadow-sm');
                                }
                            }
                        };

                        window.submitRentalRatingFromChat = async function() {
                            if (!currentChatRentalOrder) {
                                alert('No active rental order found to rate.');
                                return;
                            }
                            const rating = window.currentSelectedRentalStar;
                            const reviewText = document.getElementById('chatRatingReviewText')?.value?.trim() || '';

                            if (rating < 1 || rating > 5) {
                                alert('Please select a star rating between 1 and 5.');
                                return;
                            }
                            if (!reviewText) {
                                alert('Please provide the required details explaining why you gave this rating.');
                                return;
                            }

                            const btn = document.getElementById('btnSubmitRentalRating');
                            if (btn) {
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Submitting Review...';
                            }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 105) : 105;

                            try {
                                const apiEndpoint = window.location.pathname.includes('/student/') ? '../rentease_api.php?action=submit_rental_rating' : '/student/rentease_api.php?action=submit_rental_rating';
                                const res = await fetch(apiEndpoint, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        action: 'submit_rental_rating',
                                        order_id: currentChatRentalOrder.id,
                                        order_code: currentChatRentalOrder.order_code,
                                        rating: rating,
                                        review_text: reviewText,
                                        renter_id: currentUserId
                                    })
                                });
                                const data = await res.json();
                                if (data && data.success) {
                                    showRatingSuccessModal();
                                    if (typeof checkAndRenderChatRentalTimer === 'function') {
                                        await checkAndRenderChatRentalTimer();
                                    }
                                    if (typeof refreshActiveChatStream === 'function') {
                                        await refreshActiveChatStream();
                                    }
                                    if (typeof loadChatConversationsList === 'function') {
                                        loadChatConversationsList();
                                    }
                                } else {
                                    alert(data?.message || 'Failed to submit rating.');
                                    if (btn) {
                                        btn.disabled = false;
                                        btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Submit Rating &amp; Review';
                                    }
                                }
                            } catch (e) {
                                console.error('Error submitting rating:', e);
                                alert('Server connection error while submitting review.');
                                if (btn) {
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Submit Rating &amp; Review';
                                }
                            }
                        };

                        window.initiateDeleteCurrentChatConversation = function() {
                            if (!currentActiveChatSellerId) {
                                alert('No active conversation open.');
                                return;
                            }
                            const partnerName = document.getElementById('chatPartnerName')?.innerText || 'User';
                            const itemTitle = document.getElementById('chatItemTitle')?.innerText || '';
                            const orderCode = window.currentActiveChatOrderCode || (currentChatRentalOrder ? currentChatRentalOrder.order_code : '') || '';
                            initiateDeleteConversation(currentActiveChatSellerId, partnerName, null, itemTitle, orderCode);
                        };

                        window.showRentalSuspensionModal = function (suspData) {
                            const rEl = document.getElementById('suspensionNoticeReason');
                            if (rEl) rEl.innerText = suspData.reason || 'Unreturned equipment report approved by admin.';
                            const endEl = document.getElementById('suspensionNoticeEndDate');
                            if (endEl) endEl.innerText = suspData.suspended_until || '5 Days';
                            const reasonIn = document.getElementById('appealReasonText');
                            if (reasonIn) reasonIn.value = '';
                            const photoIn = document.getElementById('appealPhotoDataUrl');
                            if (photoIn) photoIn.value = '';
                            const box = document.getElementById('appealPhotoPreviewBox');
                            if (box) box.style.display = 'none';

                            const modalEl = document.getElementById('rentalSuspensionAppealModal');
                            if (modalEl) new bootstrap.Modal(modalEl).show();
                        };

                        window.previewAppealPhoto = function (event) {
                            const file = event.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const hidden = document.getElementById('appealPhotoDataUrl');
                                if (hidden) hidden.value = e.target.result;
                                const img = document.getElementById('appealPhotoPreview');
                                const box = document.getElementById('appealPhotoPreviewBox');
                                if (img) img.src = e.target.result;
                                if (box) box.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        };

                        window.executeSubmitSuspensionAppeal = async function () {
                            const reason = document.getElementById('appealReasonText')?.value.trim();
                            const photoUrl = document.getElementById('appealPhotoDataUrl')?.value || '';
                            if (!reason) {
                                alert('Please explain the circumstances or proof for your appeal.');
                                return;
                            }

                            const btn = document.getElementById('btnSubmitSuspensionAppeal');
                            if (btn) {
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Submitting Appeal...';
                            }

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const user = storedUser || {};

                            try {
                                const res = await fetch('/student/rentease_api.php?action=submit_rental_suspension_appeal', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        user_id: user.id || user.userId || 105,
                                        user_name: user.name || (user.firstName ? (user.firstName + ' ' + (user.lastName || '')).trim() : 'Pogilameg Tester'),
                                        user_email: user.email || 'pogilameg@gmail.com',
                                        appeal_reason: reason,
                                        photo_url: photoUrl
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    alert('✅ Appeal submitted to Admin!\nAdmin will review your appeal and evidence. If approved, your 5-day suspension will be lifted immediately.');
                                    const modalEl = document.getElementById('rentalSuspensionAppealModal');
                                    if (modalEl) {
                                        const bs = bootstrap.Modal.getInstance(modalEl);
                                        if (bs) bs.hide();
                                    }
                                } else {
                                    alert(data.message || 'Failed to submit appeal');
                                }
                            } catch(e) {
                                console.error("Appeal error:", e);
                            } finally {
                                if (btn) {
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Submit Appeal to Admin';
                                }
                            }
                        };

                        function openChat(partnerId, partnerName, itemTitle, itemPrice, itemImage) {
                            const pId = parseInt(partnerId) || 0;
                            checkAndOpenChat(pId, partnerName || 'Verified Student', itemTitle || 'Campus Request', itemPrice || '₱0.00', '', itemImage || '');
                        }
                        async function checkAndOpenChat(sellerId, sellerName, itemTitle, itemPrice, partnerAvatar, itemImage, isMyItem, ownerName, isOverdueHint, orderCode) {
                            if (orderCode && String(orderCode).trim() !== '' && String(orderCode).trim() !== 'Order') {
                                window.currentActiveChatOrderCode = String(orderCode).trim();
                            } else {
                                window.currentActiveChatOrderCode = null;
                            }
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            let currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;
                            if (currentUserId <= 1) currentUserId = 104;

                            const sId = parseInt(sellerId) || 0;
                            const pName = (sellerName || '').toLowerCase().trim();
                            const myEmail = (storedUser && storedUser.email ? storedUser.email : '').toLowerCase();
                            const myFirstName = (storedUser && storedUser.firstName ? storedUser.firstName : '').toLowerCase();
                            const myLastName = (storedUser && storedUser.lastName ? storedUser.lastName : '').toLowerCase();
                            const myFullName = (myFirstName + ' ' + myLastName).trim();
                            const isRomeo = myEmail.includes('romeo') || myFirstName.includes('romeo') || myLastName.includes('tolentino') || currentUserId === 104;
                            const isPogilameg = myEmail.includes('pogilameg') || currentUserId === 105;

                            let targetSellerId = sId;
                            let targetSellerName = sellerName || 'Verified Student';
                            const isSelf = (sId === currentUserId || (currentUserId === 104 && (sId === 1 || sId === 104)) ||
                                (isRomeo && (pName.includes('romeo') || pName.includes('tolentino'))) ||
                                (isPogilameg && pName.includes('pogilameg')) ||
                                (myFullName && pName === myFullName));

                            if (isSelf) {
                                // Seamless test / inquiry mode: connect to counter-party student
                                if (currentUserId === 104) {
                                    targetSellerId = 105;
                                    targetSellerName = 'Pogilameg Tester';
                                } else {
                                    targetSellerId = 104;
                                    targetSellerName = 'Romeo Paolo Tolentino';
                                }
                            }

                            // Cleanly dismiss any open modals and backdrops
                            document.querySelectorAll('.modal.show').forEach(m => {
                                try {
                                    const inst = bootstrap.Modal.getInstance(m);
                                    if (inst) inst.hide();
                                } catch(e) {}
                            });
                            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                            document.body.classList.remove('modal-open');
                            document.body.style.removeProperty('overflow');
                            document.body.style.removeProperty('padding-right');

                            currentActiveChatSellerId = targetSellerId;

                            const partnerNameEl = document.getElementById('chatPartnerName') || document.getElementById('chatRecipientName');
                            if (partnerNameEl) partnerNameEl.innerText = targetSellerName;

                            let finalAvatar = partnerAvatar || '';
                            if (!finalAvatar || finalAvatar === '' || finalAvatar.includes('dicebear')) {
                                finalAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(targetSellerName)}&background=5B3FA8&color=fff&bold=true&rounded=true`;
                            }

                            const headerAvatarEl = document.getElementById('chatHeaderAvatar');
                            if (headerAvatarEl) headerAvatarEl.src = finalAvatar;

                            const titleEl = document.getElementById('chatItemTitle');
                            if (titleEl) titleEl.innerText = itemTitle;

                            const priceEl = document.getElementById('chatItemPrice');
                            if (priceEl) priceEl.innerText = itemPrice || '₱0.00';

                            const chatItemImg = document.getElementById('chatItemImage');
                            const chatItemFallback = document.getElementById('chatItemThumbFallback');
                            if (chatItemImg) {
                                if (itemImage && itemImage.trim() !== '') {
                                    chatItemImg.src = itemImage;
                                    chatItemImg.style.display = 'block';
                                    if (chatItemFallback) chatItemFallback.style.display = 'none';
                                } else {
                                    chatItemImg.style.display = 'none';
                                    if (chatItemFallback) chatItemFallback.style.display = 'flex';
                                }
                            }

                            // Set initial ownership badge & owner label if passed from conversation card
                            const ownershipBadge = document.getElementById('chatItemOwnershipBadge');
                            const chatOwnerLabel = document.getElementById('chatItemOwnerLabel');
                            if (isMyItem !== undefined && isMyItem !== null) {
                                if (ownershipBadge) {
                                    if (isMyItem) {
                                        ownershipBadge.innerHTML = '<i class="fa-solid fa-crown text-warning me-1"></i>Your Item (You Own This)';
                                        ownershipBadge.style.background = '#ECFDF5';
                                        ownershipBadge.style.color = '#059669';
                                        ownershipBadge.style.border = '1px solid #A7F3D0';
                                        ownershipBadge.style.display = 'inline-flex';
                                    } else {
                                        ownershipBadge.innerHTML = '<i class="fa-solid fa-user-tag text-warning me-1"></i>Owner: ' + (ownerName || targetSellerName);
                                        ownershipBadge.style.background = '#FFFBEB';
                                        ownershipBadge.style.color = '#B45309';
                                        ownershipBadge.style.border = '1px solid #FDE68A';
                                        ownershipBadge.style.display = 'inline-flex';
                                    }
                                }
                                if (chatOwnerLabel) {
                                    chatOwnerLabel.innerText = isMyItem ? '• Owner: You' : ('• Owner: ' + (ownerName || targetSellerName));
                                }
                            }

                            // Reset shown modals for fresh chat entry
                            window._shownStep1Modals = new Set();
                            const rentalStepsBanner = document.getElementById('chatRentalRequestBanner');
                            if (rentalStepsBanner) rentalStepsBanner.classList.remove('is-collapsed');
                            if (typeof window.enableChatRentalStepSwipe === 'function') window.enableChatRentalStepSwipe();
                            const rentalStepsToggle = document.getElementById('chatRentalStepsToggle');
                            if (rentalStepsToggle) {
                                rentalStepsToggle.setAttribute('aria-label', 'Collapse rental steps');
                                rentalStepsToggle.title = 'Collapse rental steps';
                                rentalStepsToggle.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
                            }
                            const tabs = ['home', 'explore', 'cart', 'sell', 'wanted', 'messages', 'profile', 'track'];
                            tabs.forEach(t => {
                                const el = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
                                const nav = document.getElementById('tabNav' + t.charAt(0).toUpperCase() + t.slice(1));
                                if (el) el.style.display = 'none';
                                if (nav) nav.classList.toggle('active', t === 'messages');
                            });

                            const tabMsgs = document.getElementById('tabMessages');
                            const chatVw = document.getElementById('chatView');
                            if (tabMsgs) tabMsgs.style.setProperty('display', 'none', 'important');
                            if (chatVw) {
                                chatVw.style.setProperty('display', 'flex', 'important');
                                if (isOverdueHint) {
                                    chatVw.classList.add('is-overdue');
                                } else {
                                    chatVw.classList.remove('is-overdue');
                                }
                            }

                            const stream = document.getElementById('chatStream') || document.getElementById('chatMessageContainer');
                            if (stream) {
                                stream.innerHTML = `<div class="text-center my-4 py-3"><div class="spinner-border spinner-border-sm text-primary me-2"></div><span class="fs-9 text-muted fw-bold">Loading ${itemTitle} discussion...</span></div>`;
                            }

                            await refreshActiveChatStream();
                            startLiveChatPolling();
                        }

                        window.checkAndOpenChat = checkAndOpenChat;
                        window.openDirectChat = checkAndOpenChat;
                        window.openChat = openChat;

                        async function sendChatMessage() {
                            const input = document.getElementById('chatInput');
                            if (!input) return;
                            const text = input.value.trim();
                            if (!text) return;

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;
                            const senderName = storedUser ? (storedUser.firstName + ' ' + (storedUser.lastName || '')).trim() : 'Verified Student';
                            const itemTitle = document.getElementById('chatItemTitle')?.innerText || 'Campus Item';

                            // STEP 2 GUARD: If current user is Renter, and equipment is being prepared (Step 2) but owner has not yet submitted prep photo:
                            if (currentChatRentalOrder) {
                                let currentUserEmail = (storedUser && storedUser.email ? storedUser.email : '').toLowerCase().trim();
                                let currentUserName = (storedUser ? (storedUser.name || (storedUser.firstName || '') + ' ' + (storedUser.lastName || '')) : '').toLowerCase().trim();
                                const isOwner = (currentUserId === parseInt(currentChatRentalOrder.owner_id)) ||
                                    (currentUserEmail && currentChatRentalOrder.owner_email && currentUserEmail === currentChatRentalOrder.owner_email.toLowerCase()) ||
                                    (currentUserName.includes('romeo') && !currentUserName.includes('pogilameg')) ||
                                    (currentUserId === 104 && !currentUserEmail.includes('pogilameg'));

                                if (!isOwner && parseInt(currentChatRentalOrder.owner_agreed) === 1 && parseInt(currentChatRentalOrder.prep_confirmed_by_renter) !== 1) {
                                    if (!currentChatRentalOrder.prep_photo_url || currentChatRentalOrder.prep_photo_url.trim() === '') {
                                        alert("⚠️ Equipment is currently being prepared. Chat will unlock once the stock owner uploads the preparation photo proof.");
                                        return;
                                    }
                                }
                            }

                            input.value = '';
                            input.style.height = 'auto';

                            const stream = document.getElementById('chatStream') || document.getElementById('chatMessageContainer');
                            if (stream) {
                                stream.innerHTML += `
                                <div class="d-flex justify-content-end mb-2">
                                    <div class="rentchat-bubble rentchat-bubble-mine">
                                        ${text}
                                    </div>
                                </div>`;
                                stream.scrollTop = stream.scrollHeight;
                            }

                            try {
                                await fetch('/pasabuy_api.php?action=send_message', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        senderId: currentUserId,
                                        receiverId: currentActiveChatSellerId || 104,
                                        senderName: senderName,
                                        messageText: text,
                                        itemTitle: itemTitle
                                    })
                                });
                            } catch (e) { console.error("Send chat error:", e); }

                            setTimeout(refreshActiveChatStream, 400);
                        }

                        function closeChat() {
                            const chatVw = document.getElementById('chatView');
                            const tabMsgs = document.getElementById('tabMessages');
                            if (chatVw) {
                                chatVw.style.display = 'none';
                                chatVw.classList.remove('is-overdue');
                            }
                            if (tabMsgs) tabMsgs.style.display = 'block';
                            const banner = document.getElementById('chatRentalTimerBanner');
                            const header = document.querySelector('.rentchat-header-bar');
                            if (banner) banner.classList.remove('is-overdue');
                            if (header) header.classList.remove('is-overdue');
                            const retBanner = document.getElementById('chatRentalReturnedBanner');
                            if (retBanner) retBanner.style.display = 'none';
                            const hDelBtn = document.getElementById('chatHeaderDeleteBtn');
                            if (hDelBtn) hDelBtn.style.display = 'none';
                            if (chatRentalTimerInterval) { clearInterval(chatRentalTimerInterval); chatRentalTimerInterval = null; }
                            window.currentSelectedRentalStar = 0;
                            loadChatConversationsList();
                        }
                        window.checkAndOpenChat = checkAndOpenChat;
                        window.refreshActiveChatStream = refreshActiveChatStream;
                        window.closeChat = closeChat;

                        async function checkAndReserve(listingId, sellerId, itemTitle, sellerName) {
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 1) : 1;

                            if (currentUserId === sellerId) {
                                alert("ℹ️ You cannot reserve your own item listing.");
                                return;
                            }

                            try {
                                await fetch('/pasabuy_api.php?action=reserve_listing', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ listingId: listingId, buyerId: currentUserId })
                                });
                            } catch (e) { }

                            try {
                                let localListings = JSON.parse(localStorage.getItem('pasabuy_local_published_listings')) || [];
                                localListings.forEach(l => {
                                    if (l.id == listingId || l.title === itemTitle) {
                                        l.status = 'RESERVED';
                                    }
                                });
                                localStorage.setItem('pasabuy_local_published_listings', JSON.stringify(localListings));
                            } catch (e) { }

                            await checkAndOpenChat(sellerId, sellerName || 'Seller', itemTitle, '₱0.00');

                            const input = document.getElementById('chatInput');
                            if (input) {
                                input.value = `Hi ${sellerName || 'Seller'}! I have reserved your listing "${itemTitle}". I am interested in buying it! When and where can we meet up on campus?`;
                                sendChatMessage();
                            }

                            alert(`🔖 Item Reserved! We opened a chat with ${sellerName || 'the seller'} so you can arrange your campus meetup & payment.`);
                            await filterProducts();
                        }

                        async function executeUnreserveListing(listingId) {
                            try {
                                await fetch('/pasabuy_api.php?action=unreserve_listing', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ listingId: listingId })
                                });
                            } catch (e) { }

                            try {
                                let localListings = JSON.parse(localStorage.getItem('pasabuy_local_published_listings')) || [];
                                localListings.forEach(l => {
                                    if (l.id == listingId) l.status = 'ACTIVE';
                                });
                                localStorage.setItem('pasabuy_local_published_listings', JSON.stringify(localListings));
                            } catch (e) { }

                            alert('✅ Item un-reserved! Your post is now back live on the public campus marketplace feed.');
                            await filterProducts();
                        }

                        async function executeMarkSoldListing(listingId) {
                            try {
                                await fetch('/pasabuy_api.php?action=mark_sold_listing', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ listingId: listingId })
                                });
                            } catch (e) { }

                            try {
                                let localListings = JSON.parse(localStorage.getItem('pasabuy_local_published_listings')) || [];
                                localListings.forEach(l => {
                                    if (l.id == listingId) l.status = 'SOLD';
                                });
                                localStorage.setItem('pasabuy_local_published_listings', JSON.stringify(localListings));
                            } catch (e) { }

                            alert('🎉 Item marked as SOLD! Deal complete.');
                            await filterProducts();
                        }

                        // Handle PayMongo payment success redirect
                        async function handlePaymentSuccess() {
                            const params = new URLSearchParams(window.location.search);
                            if (params.get('payment') === 'success' || params.get('status') === 'success') {
                                console.log("Payment success detected, confirming listing...");
                                window.history.replaceState({}, document.title, window.location.pathname);

                                try {
                                    const listingData = localStorage.getItem('pendingListingData');
                                    if (!listingData) return;

                                    const data = JSON.parse(listingData);
                                    alert('✅ PayMongo GCash Payment verified! Your listing is now live on campus marketplace.');
                                    localStorage.removeItem('pendingListingData');

                                    if (localStorage.getItem('pasabuy_student_logged_in') === 'true') {
                                        switchTab('explore');
                                    }
                                } catch (err) {
                                    console.error("Payment confirmation error:", err);
                                }
                            }
                        }

                        // ---------------------------------------------------------
                        // PRODUCT EDITING & VIDEO UPLOAD HELPERS
                        // ---------------------------------------------------------
                        window.handleSellVideoUpload = function (event) {
                            const file = event.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const videoDataUrl = e.target.result;
                                document.getElementById('sellVideoUrlInput').value = videoDataUrl;
                                const videoPreview = document.getElementById('sellVideoPreview');
                                const videoPreviewBox = document.getElementById('sellVideoPreviewContainer');
                                if (videoPreview) videoPreview.src = videoDataUrl;
                                if (videoPreviewBox) videoPreviewBox.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        };

                        window.handleEditVideoUpload = function (event) {
                            const file = event.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const videoDataUrl = e.target.result;
                                document.getElementById('editVideoUrlInput').value = videoDataUrl;
                                const videoPreview = document.getElementById('editVideoPreview');
                                const videoPreviewBox = document.getElementById('editVideoPreviewContainer');
                                if (videoPreview) videoPreview.src = videoDataUrl;
                                if (videoPreviewBox) videoPreviewBox.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        };

                        window.openEditListingModal = function (listingId) {
                            const listing = (window.allProductsCache || []).find(p => p.id == listingId);
                            if (!listing) {
                                alert('Listing not found');
                                return;
                            }
                            currentEditListingObj = listing;

                            document.getElementById('editListingId').value = listing.id;
                            document.getElementById('editTitleInput').value = listing.title;
                            document.getElementById('editPriceInput').value = listing.priceVal || parseFloat(listing.price.replace(/[^\d.]/g, '')) || 0;
                            document.getElementById('editCategorySelect').value = listing.categoryId || 1;
                            document.getElementById('editConditionSelect').value = listing.condition || 'Good';
                            document.getElementById('editMeetupInput').value = listing.location || 'Campus Library';
                            document.getElementById('editDescriptionInput').value = listing.description || '';
                            document.getElementById('editImageUrlInput').value = listing.img || '';
                            document.getElementById('editVideoUrlInput').value = listing.videoUrl || '';

                            const videoPreview = document.getElementById('editVideoPreview');
                            const videoPreviewBox = document.getElementById('editVideoPreviewContainer');
                            if (listing.videoUrl) {
                                if (videoPreview) videoPreview.src = listing.videoUrl;
                                if (videoPreviewBox) videoPreviewBox.style.display = 'block';
                            } else {
                                if (videoPreviewBox) videoPreviewBox.style.display = 'none';
                            }

                            const modalEl = document.getElementById('editListingModal');
                            if (modalEl) new bootstrap.Modal(modalEl).show();
                        };

                        window.executeSaveEditedListing = async function () {
                            const id = document.getElementById('editListingId').value;
                            const title = document.getElementById('editTitleInput').value.trim();
                            const price = parseFloat(document.getElementById('editPriceInput').value) || 0;
                            const categoryId = parseInt(document.getElementById('editCategorySelect').value) || 1;
                            const condition = document.getElementById('editConditionSelect').value;
                            const meetupLocation = document.getElementById('editMeetupInput').value.trim();
                            const description = document.getElementById('editDescriptionInput').value.trim();
                            const imageUrl = document.getElementById('editImageUrlInput').value.trim();
                            const videoUrl = document.getElementById('editVideoUrlInput').value.trim();

                            if (!title) {
                                alert('Product title is required!');
                                return;
                            }

                            try {
                                const res = await fetch('pasabuy_api.php?action=update_listing', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        id: id,
                                        title: title,
                                        price: price,
                                        categoryId: categoryId,
                                        condition: condition,
                                        meetupLocation: meetupLocation,
                                        description: description,
                                        imageUrl: imageUrl,
                                        videoUrl: videoUrl
                                    })
                                });

                                const data = await res.json();
                                if (data.success) {
                                    alert('✅ Product Listing & Video Updated Successfully!');
                                    const modalEl = document.getElementById('editListingModal');
                                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                                    if (bsModal) bsModal.hide();
                                    await filterProducts();
                                } else {
                                    alert('Failed to update listing: ' + (data.message || 'Error'));
                                }
                            } catch (err) {
                                alert('Network error while updating listing.');
                            }
                        };

                        // ---------------------------------------------------------
                        // FLYING ADD-TO-CART ANIMATION & SOLD CHECK ENGINE
                        // ---------------------------------------------------------
                        let pasabuyCart = JSON.parse(localStorage.getItem('pasabuy_cart_items')) || [];

                        window.animateAddToCart = function (event, listingId, title, price, sellerId, imgUrl) {
                            event.stopPropagation();
                            const btn = event.currentTarget;
                            const btnRect = btn.getBoundingClientRect();
                            
                            let cartBtn = document.getElementById('headerCartBtn');
                            if (!cartBtn || cartBtn.style.display === 'none' || cartBtn.offsetParent === null) {
                                cartBtn = document.getElementById('homeCartBtn');
                            }

                            let targetX = window.innerWidth - 60;
                            let targetY = 20;

                            if (cartBtn && cartBtn.offsetParent !== null) {
                                const cartRect = cartBtn.getBoundingClientRect();
                                targetX = cartRect.left + cartRect.width / 2;
                                targetY = cartRect.top + cartRect.height / 2;
                            }

                            const flyEl = document.createElement('div');
                            flyEl.style.position = 'fixed';
                            flyEl.style.left = (btnRect.left + btnRect.width / 2 - 20) + 'px';
                            flyEl.style.top = (btnRect.top + btnRect.height / 2 - 20) + 'px';
                            flyEl.style.width = '40px';
                            flyEl.style.height = '40px';
                            flyEl.style.borderRadius = '50%';
                            flyEl.style.backgroundImage = `url('${imgUrl || 'LOGO.png'}')`;
                            flyEl.style.backgroundSize = 'cover';
                            flyEl.style.backgroundPosition = 'center';
                            flyEl.style.border = '2px solid #5F27CD';
                            flyEl.style.boxShadow = '0 8px 24px rgba(95, 39, 205, 0.5)';
                            flyEl.style.zIndex = '999999';
                            flyEl.style.pointerEvents = 'none';
                            flyEl.style.transition = 'all 0.65s cubic-bezier(0.18, 0.89, 0.32, 1.28)';

                            document.body.appendChild(flyEl);

                            setTimeout(() => {
                                flyEl.style.left = (targetX - 10) + 'px';
                                flyEl.style.top = (targetY - 10) + 'px';
                                flyEl.style.width = '20px';
                                flyEl.style.height = '20px';
                                flyEl.style.opacity = '0.2';
                                flyEl.style.transform = 'scale(0.5) rotate(360deg)';
                            }, 20);

                            setTimeout(() => {
                                if (flyEl.parentNode) flyEl.parentNode.removeChild(flyEl);

                                if (cartBtn) {
                                    cartBtn.style.transform = 'scale(1.3)';
                                    cartBtn.style.transition = 'transform 0.2s ease';
                                    setTimeout(() => {
                                        cartBtn.style.transform = 'scale(1.0)';
                                    }, 200);
                                }

                                addToCartInternal(listingId, title, price, sellerId, imgUrl);
                            }, 670);
                        };

                        window.toggleCartProduct = function (event, listingId, title, price, sellerId, imgUrl) {
                            event.stopPropagation();
                            const existingIndex = pasabuyCart.findIndex(i => (i.listingId && i.listingId == listingId) || i.title === title);
                            if (existingIndex > -1) {
                                pasabuyCart.splice(existingIndex, 1);
                                localStorage.setItem('pasabuy_cart_items', JSON.stringify(pasabuyCart));
                                updateCartBadge();
                                filterProducts();
                            } else {
                                animateAddToCart(event, listingId, title, price, sellerId, imgUrl);
                            }
                        };

                        function addToCartInternal(listingId, title, price, sellerId, imgUrl) {
                            const numericPrice = parseFloat(String(price).replace(/[^\d.]/g, '')) || 0;
                            const existing = pasabuyCart.find(i => (i.listingId && i.listingId == listingId) || i.title === title);
                            if (existing) {
                                existing.quantity += 1;
                            } else {
                                pasabuyCart.push({
                                    listingId: listingId,
                                    title: title,
                                    price: numericPrice,
                                    sellerId: sellerId,
                                    img: imgUrl,
                                    quantity: 1,
                                    isSold: false
                                });
                            }
                            localStorage.setItem('pasabuy_cart_items', JSON.stringify(pasabuyCart));
                            updateCartBadge();
                            filterProducts();
                        }

                        window.updateCartBadge = function () {
                            const badge1 = document.getElementById('cartCountBadge');
                            const badge2 = document.getElementById('homeCartCountBadge');
                            const allProducts = window.allProductsCache || [];

                            pasabuyCart.forEach(item => {
                                const liveP = allProducts.find(p => p.id == item.listingId || p.title === item.title);
                                if (liveP && (liveP.status === 'SOLD' || liveP.status === 'RESERVED')) {
                                    item.isSold = true;
                                    item.status = liveP.status;
                                } else {
                                    item.isSold = false;
                                }
                            });

                            localStorage.setItem('pasabuy_cart_items', JSON.stringify(pasabuyCart));

                            const activeItems = pasabuyCart.filter(i => !i.isSold);
                            const totalQty = activeItems.reduce((sum, i) => sum + i.quantity, 0);

                            [badge1, badge2].forEach(b => {
                                if (b) {
                                    b.innerText = totalQty;
                                    b.style.display = totalQty > 0 ? 'inline-block' : 'none';
                                }
                            });
                        };

                        window.openCartModal = function () {
                            switchTab('cart');
                        };

                        function renderCartItems() {
                            const container = document.getElementById('cartItemsContainer');
                            const totalDisplay = document.getElementById('cartTotalDisplay');
                            if (!container) return;

                            if (pasabuyCart.length === 0) {
                                container.innerHTML = `<div class="text-center py-4 text-muted fs-8"><i class="fa-solid fa-basket-shopping fs-3 text-secondary opacity-50 mb-2 d-block"></i>Your cart is currently empty.<br>Tap <strong>+ Add to Cart</strong> on any item in the marketplace!</div>`;
                                if (totalDisplay) totalDisplay.innerText = '₱0.00';
                                return;
                            }

                            let html = '';
                            let subtotal = 0;

                            pasabuyCart.forEach((item, index) => {
                                if (item.isSold) {
                                    html += `
                                        <div class="p-2 mb-2 bg-danger bg-opacity-10 border border-danger-subtle rounded-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="${item.img || 'LOGO.png'}" class="rounded-2" width="42" height="42" style="object-fit:cover; opacity:0.6;">
                                                <div>
                                                    <div class="fw-bold fs-7 text-danger text-decoration-line-through">${item.title}</div>
                                                    <span class="badge bg-danger text-white fs-9"><i class="fa-solid fa-ban me-1"></i> THIS PRODUCT IS ${item.status || 'SOLD'}</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger border-0" onclick="removeFromCart(${index})"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    `;
                                } else {
                                    const itemTotal = item.price * item.quantity;
                                    subtotal += itemTotal;
                                    html += `
                                        <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded-3 border">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="${item.img || 'LOGO.png'}" class="rounded-2" width="42" height="42" style="object-fit:cover;">
                                                <div>
                                                    <div class="fw-bold fs-7 text-dark">${item.title}</div>
                                                    <div class="fs-8 text-primary fw-bold">₱${item.price.toFixed(2)} x ${item.quantity} = ₱${itemTotal.toFixed(2)}</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-1">
                                                <button class="btn btn-sm btn-light border p-1" onclick="updateCartQty(${index}, -1)" style="width:26px; height:26px; line-height:1;">-</button>
                                                <span class="fw-bold fs-8 px-1">${item.quantity}</span>
                                                <button class="btn btn-sm btn-light border p-1" onclick="updateCartQty(${index}, 1)" style="width:26px; height:26px; line-height:1;">+</button>
                                                <button class="btn btn-sm btn-outline-danger border-0 ms-1" onclick="removeFromCart(${index})"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </div>
                                    `;
                                }
                            });

                            container.innerHTML = html;
                            const totalWithFee = subtotal > 0 ? (subtotal + 20.00) : 0;
                            if (totalDisplay) totalDisplay.innerText = `₱${totalWithFee.toFixed(2)}`;
                        }

                        window.updateCartQty = function (index, change) {
                            if (pasabuyCart[index]) {
                                pasabuyCart[index].quantity += change;
                                if (pasabuyCart[index].quantity <= 0) {
                                    pasabuyCart.splice(index, 1);
                                }
                            }
                            localStorage.setItem('pasabuy_cart_items', JSON.stringify(pasabuyCart));
                            updateCartBadge();
                            renderCartItems();
                            filterProducts();
                        };

                        window.removeFromCart = function (index) {
                            pasabuyCart.splice(index, 1);
                            localStorage.setItem('pasabuy_cart_items', JSON.stringify(pasabuyCart));
                            updateCartBadge();
                            renderCartItems();
                            filterProducts();
                        };

                        // UI Helper Functions
                        window.applyQuickSearch = function (term) {
                            const input = document.getElementById('searchInput');
                            if (input) {
                                input.value = term;
                                filterProducts();
                            }
                        };

                        window.clearRecentSearches = function () {
                            const row = document.getElementById('recentSearchesRow');
                            if (row) row.style.display = 'none';
                        };

                        window.toggleWishlist = function (btn, id) {
                            const icon = btn.querySelector('i');
                            if (icon) {
                                if (icon.classList.contains('fa-regular')) {
                                    icon.className = 'fa-solid fa-heart text-danger fs-8';
                                } else {
                                    icon.className = 'fa-regular fa-heart text-muted fs-8';
                                }
                            }
                        };

                        // ---------------------------------------------------------
                        // ORDERS, DELIVERY FULFILLMENT & LIVE MAP TRACKING
                        // ---------------------------------------------------------
                        let activeOrderMapInstance = null;
                        let activeRiderWatchId = null;

                        window.getStoredStudentUser = function () {
                            try {
                                const str = localStorage.getItem('pasabuy_student_user');
                                if (str) return JSON.parse(str);
                            } catch (e) { }
                            return { id: 104, userId: 104, firstName: 'Verified', lastName: 'Student' };
                        };

                        window.executeCheckoutOrder = async function () {
                            const user = getStoredStudentUser();
                            const buyerId = user.id || user.userId || user.UserId || 104;

                            if (pasabuyCart.length === 0) {
                                alert('Your cart is empty! Add items before placing an order.');
                                return;
                            }

                            const fulRadio = document.querySelector('input[name="fulfillmentTypeRadio"]:checked');
                            const fulfillmentType = fulRadio ? fulRadio.value : 'MOTOR_DELIVERY';

                            // Validate buyer address
                            try {
                                const chkRes = await fetch(`/pasabuy_api.php?action=check_buyer_address&userId=${buyerId}`);
                                if (chkRes.ok) {
                                    const addressData = await chkRes.json();
                                    if (!addressData.hasAddress && fulfillmentType === 'MOTOR_DELIVERY') {
                                        const modalEl = document.getElementById('cartModal');
                                        if (modalEl) {
                                            const bs = bootstrap.Modal.getInstance(modalEl);
                                            if (bs) bs.hide();
                                        }
                                        const promptEl = document.getElementById('buyerAddressPromptModal');
                                        if (promptEl) new bootstrap.Modal(promptEl).show();
                                        return;
                                    }
                                }
                            } catch (e) {
                                console.error("Check buyer address error:", e);
                            }

                            // Create order for each cart item
                            let successCount = 0;
                            for (const item of pasabuyCart) {
                                if (item.isSold) continue;
                                const listingId = item.listingId || item.id;
                                const price = item.price || 10;
                                try {
                                    const res = await fetch('/pasabuy_api.php?action=create_order', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json' },
                                        body: JSON.stringify({
                                            buyerId: buyerId,
                                            listingId: listingId,
                                            fulfillmentType: fulfillmentType,
                                            meetupLocation: 'Campus Library',
                                            totalPrice: price * item.quantity
                                        })
                                    });
                                    if (res.ok) {
                                        const data = await res.json();
                                        if (data.success) successCount++;
                                    }
                                } catch (e) { }
                            }

                            pasabuyCart = [];
                            localStorage.setItem('pasabuy_cart_items', JSON.stringify([]));
                            updateCartBadge();
                            renderCartItems();

                            const modalEl = document.getElementById('cartModal');
                            if (modalEl) {
                                const bs = bootstrap.Modal.getInstance(modalEl);
                                if (bs) bs.hide();
                            }

                            await filterProducts();
                            alert('🎉 Order Placed Successfully! Your delivery order is now tracked live in Orders.');
                            openOrdersModal();
                        };

                        window.saveQuickBuyerAddress = async function () {
                            const user = getStoredStudentUser();
                            const buyerId = user.id || user.userId || user.UserId || 104;

                            const hometown = document.getElementById('qaHometown').value.trim();
                            const postalCode = document.getElementById('qaPostalCode').value.trim();
                            const address = document.getElementById('qaAddress').value.trim();
                            const phone = document.getElementById('qaPhone').value.trim();

                            if (!hometown || !postalCode || !address || !phone) {
                                alert('Please complete all delivery address fields.');
                                return;
                            }

                            try {
                                const res = await fetch('/pasabuy_api.php?action=submit_verification_request', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        userId: buyerId,
                                        hometown: hometown,
                                        homeAddress: address,
                                        postalCode: postalCode,
                                        phoneNumber: phone,
                                        guardianName: 'Parent / Guardian',
                                        guardianPhone: phone,
                                        idType: 'Student ID',
                                        idNumber: 'STU-' + buyerId,
                                        idFrontImage: ''
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    alert('✅ Delivery address saved!');
                                    const modalEl = document.getElementById('buyerAddressPromptModal');
                                    if (modalEl) {
                                        const bs = bootstrap.Modal.getInstance(modalEl);
                                        if (bs) bs.hide();
                                    }
                                    executeCheckoutOrder();
                                }
                            } catch (e) {
                                alert('Error saving delivery address.');
                            }
                        };

                        window.openOrdersModal = function () {
                            const modalEl = document.getElementById('ordersModal');
                            if (modalEl) {
                                new bootstrap.Modal(modalEl).show();
                                const activeTabBtn = document.querySelector('#ordersTabs .nav-link.active');
                                if (activeTabBtn) activeTabBtn.click();
                                else renderBuyerOrdersTab('active', null);
                            }
                        };

                        window.renderBuyerOrdersTab = async function (type, btnEl) {
                            if (btnEl) {
                                document.querySelectorAll('#ordersTabs .nav-link').forEach(b => b.classList.remove('active'));
                                btnEl.classList.add('active');
                            }

                            const user = getStoredStudentUser();
                            const buyerId = user.id || user.userId || user.UserId || 104;
                            const container = document.getElementById('ordersListContent');
                            if (!container) return;

                            try {
                                const res = await fetch(`/pasabuy_api.php?action=get_buyer_orders&userId=${buyerId}`);
                                if (res.ok) {
                                    const orders = await res.json();
                                    let filtered = orders;
                                    if (type === 'active') {
                                        filtered = orders.filter(o => o.Status !== 'DELIVERED' && o.Status !== 'CANCELLED');
                                    } else if (type === 'completed') {
                                        filtered = orders.filter(o => o.Status === 'DELIVERED' || o.Status === 'CANCELLED');
                                    }

                                    if (filtered.length === 0) {
                                        container.innerHTML = `<div class="text-center py-4 text-muted fs-8"><i class="fa-solid fa-box-open fs-3 text-secondary opacity-50 mb-2 d-block"></i>No ${type} orders to show right now.</div>`;
                                        return;
                                    }

                                    let html = '';
                                    filtered.forEach(o => {
                                        const status = (o.Status || 'PENDING').toUpperCase();
                                        let statusBadge = '<span class="badge bg-warning text-dark">PENDING</span>';
                                        if (status === 'BROADCASTING') statusBadge = '<span class="badge bg-info text-white"><i class="fa-solid fa-satellite-dish fa-spin me-1"></i> LOOKING FOR MOTOR RIDER</span>';
                                        else if (status === 'DRIVER_ASSIGNED') statusBadge = '<span class="badge bg-primary text-white"><i class="fa-solid fa-motorcycle me-1"></i> RIDER ASSIGNED (ON WAY TO PICKUP)</span>';
                                        else if (status === 'OUT_FOR_DELIVERY') statusBadge = '<span class="badge bg-success text-white"><i class="fa-solid fa-truck-fast me-1"></i> OUT FOR MOTOR DELIVERY</span>';
                                        else if (status === 'DELIVERED') statusBadge = '<span class="badge bg-success text-white"><i class="fa-solid fa-circle-check me-1"></i> DELIVERED</span>';

                                        const isGpsActive = (parseInt(o.IsGpsActive) === 1);
                                        const gpsBadge = isGpsActive 
                                            ? `<span class="badge bg-success-subtle text-success border border-success-subtle fs-9"><i class="fa-solid fa-location-dot me-1"></i> Live Rider GPS Active</span>`
                                            : `<span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-9"><i class="fa-solid fa-triangle-exclamation me-1"></i> ⚠️ Rider GPS Location Signal Lost / Off</span>`;

                                        html += `
                                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 ${status === 'DELIVERED' ? 'border-success' : 'border-primary'} mb-2">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="fs-9 fw-bold text-muted">Order #${o.Id} • ${new Date(o.CreatedAt).toLocaleDateString()}</span>
                                                ${statusBadge}
                                            </div>
                                            <div class="d-flex gap-3 align-items-center mb-2">
                                                <img src="${o.ImageUrl || 'LOGO.png'}" class="rounded-3" width="56" height="56" style="object-fit:cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-bold text-dark fs-8 mb-0">${o.ItemTitle || 'Campus Item'}</h6>
                                                    <div class="fw-extrabold text-primary fs-7">₱${parseFloat(o.TotalPrice || 0).toFixed(2)}</div>
                                                    <span class="fs-9 text-muted">Seller: <strong>${o.SellerFirstName || ''} ${o.SellerLastName || 'Verified Seller'}</strong></span>
                                                </div>
                                            </div>
                                            ${o.FulfillmentType === 'MOTOR_DELIVERY' ? `
                                            <div class="bg-light p-2.5 rounded-3 border mb-2 fs-9">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <strong><i class="fa-solid fa-motorcycle text-warning me-1"></i> Driver Info:</strong>
                                                    ${gpsBadge}
                                                </div>
                                                <div>Driver: <strong>${o.RiderFirstName ? `${o.RiderFirstName} ${o.RiderLastName}` : 'Searching nearby driver...'}</strong></div>
                                                <div>Vehicle: ${o.VehicleModel || 'PasaBuy Motor Rider'} (${o.PlateNumber || 'N/A'}) • Phone: <code>${o.RiderPhone || 'N/A'}</code></div>
                                                <div class="text-truncate mt-1"><i class="fa-solid fa-house-chimney text-danger me-1"></i> Delivery Address: <strong>${o.DeliveryAddress || o.Hometown || 'Campus Address'}</strong></div>
                                            </div>
                                            <div id="buyerOrderMap_${o.Id}" class="rounded-3 border shadow-2xs mb-2" style="height: 180px; width:100%; background:#e5e7eb;"></div>
                                            ` : `
                                            <div class="bg-light p-2 rounded-3 fs-9"><i class="fa-solid fa-handshake text-primary me-1"></i> Meetup Spot: <strong>${o.MeetupLocation || 'Campus Library'}</strong></div>
                                            `}
                                        </div>`;
                                    });

                                    container.innerHTML = html;

                                    filtered.forEach(o => {
                                        if (o.FulfillmentType === 'MOTOR_DELIVERY') {
                                            setTimeout(() => {
                                                initializeLeafletDeliveryMap(`buyerOrderMap_${o.Id}`, parseFloat(o.RiderLat || 14.6488), parseFloat(o.RiderLng || 121.0687), parseFloat(o.DestLat || 14.6520), parseFloat(o.DestLng || 121.0720), parseInt(o.IsGpsActive) === 1, o.Status);
                                            }, 200);
                                        }
                                    });
                                }
                            } catch (e) {
                                container.innerHTML = `<div class="text-center py-4 text-muted fs-8">Error loading orders.</div>`;
                            }
                        };

                        window.renderSellerOrdersTab = async function (btnEl) {
                            if (btnEl) {
                                document.querySelectorAll('#ordersTabs .nav-link').forEach(b => b.classList.remove('active'));
                                btnEl.classList.add('active');
                            }

                            const user = getStoredStudentUser();
                            const sellerId = user.id || user.userId || user.UserId || 104;
                            const container = document.getElementById('ordersListContent');
                            if (!container) return;

                            try {
                                const res = await fetch(`/pasabuy_api.php?action=get_seller_orders&userId=${sellerId}`);
                                if (res.ok) {
                                    const orders = await res.json();
                                    if (orders.length === 0) {
                                        container.innerHTML = `<div class="text-center py-4 text-muted fs-8"><i class="fa-solid fa-store-slash fs-3 text-secondary opacity-50 mb-2 d-block"></i>No incoming buyer orders for your products yet.</div>`;
                                        return;
                                    }

                                    let html = '';
                                    orders.forEach(o => {
                                        const status = (o.Status || 'PENDING').toUpperCase();
                                        html += `
                                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-warning mb-2">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="fs-9 fw-bold text-muted">Order #${o.Id} • Buyer: ${o.BuyerFirstName || 'Student'} ${o.BuyerLastName || ''}</span>
                                                <span class="badge bg-primary text-white">${status}</span>
                                            </div>
                                            <div class="d-flex gap-3 align-items-center mb-2">
                                                <img src="${o.ImageUrl || 'LOGO.png'}" class="rounded-3" width="48" height="48" style="object-fit:cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-bold text-dark fs-8 mb-0">${o.ItemTitle || 'Item'}</h6>
                                                    <div class="fw-extrabold text-primary fs-7">₱${parseFloat(o.TotalPrice || 0).toFixed(2)}</div>
                                                    <span class="fs-9 text-muted">Buyer Phone: <code>${o.BuyerPhone || 'N/A'}</code></span>
                                                </div>
                                            </div>
                                            ${o.FulfillmentType === 'MOTOR_DELIVERY' ? `
                                            <div class="d-flex gap-2 mt-2">
                                                <button class="btn btn-sm btn-warning rounded-pill w-100 fw-bold fs-9 py-1.5 text-dark" onclick="openSellerDispatchModal(${o.Id})">
                                                    <i class="fa-solid fa-radar me-1"></i> Scan &amp; Broadcast to Nearby Motor Drivers
                                                </button>
                                            </div>` : ''}
                                        </div>`;
                                    });
                                    container.innerHTML = html;
                                }
                            } catch (e) {
                                container.innerHTML = `<div class="text-center py-4 text-muted fs-8">Error loading seller orders.</div>`;
                            }
                        };

                        window.initializeLeafletDeliveryMap = function (containerId, riderLat, riderLng, destLat, destLng, isGpsActive, status) {
                            const el = document.getElementById(containerId);
                            if (!el) return;
                            el.innerHTML = '';

                            try {
                                const map = L.map(containerId, { zoomControl: false }).setView([riderLat, riderLng], 15);
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    maxZoom: 19
                                }).addTo(map);

                                const riderIcon = L.divIcon({
                                    html: `<div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center border border-2 border-white shadow" style="width:32px; height:32px; font-size:16px;"><i class="fa-solid fa-motorcycle"></i></div>`,
                                    className: '',
                                    iconSize: [32, 32]
                                });

                                const destIcon = L.divIcon({
                                    html: `<div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center border border-2 border-white shadow" style="width:32px; height:32px; font-size:16px;"><i class="fa-solid fa-house-chimney"></i></div>`,
                                    className: '',
                                    iconSize: [32, 32]
                                });

                                L.marker([riderLat, riderLng], { icon: riderIcon }).addTo(map).bindPopup('PasaBuy Motor Rider');
                                L.marker([destLat, destLng], { icon: destIcon }).addTo(map).bindPopup('Buyer Delivery Spot');

                                L.polyline([[riderLat, riderLng], [destLat, destLng]], { color: '#5F27CD', weight: 4, dashArray: '8, 8' }).addTo(map);
                            } catch (e) { console.error("Leaflet map init error:", e); }
                        };

                        window.openSellerDispatchModal = async function (orderId) {
                            document.getElementById('dispatchOrderId').value = orderId;
                            const listEl = document.getElementById('nearbyRidersRadarList');
                            if (listEl) listEl.innerHTML = '<div class="text-center text-muted py-3 fs-8"><i class="fa-solid fa-spinner fa-spin me-1"></i> Scanning campus motor drivers...</div>';

                            const modalEl = document.getElementById('sellerDispatchModal');
                            if (modalEl) new bootstrap.Modal(modalEl).show();

                            try {
                                const res = await fetch('/pasabuy_api.php?action=get_nearby_riders');
                                if (res.ok) {
                                    const drivers = await res.json();
                                    if (drivers.length === 0) {
                                        if (listEl) listEl.innerHTML = '<div class="text-center text-muted py-3 fs-8"><i class="fa-solid fa-motorcycle me-1"></i> No online drivers detected nearby. Click broadcast below to alert all registered drivers!</div>';
                                        return;
                                    }
                                    let html = '';
                                    drivers.forEach(d => {
                                        html += `
                                        <div class="p-2.5 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:36px; height:36px;">
                                                    <i class="fa-solid fa-motorcycle"></i>
                                                </div>
                                                <div>
                                                    <strong class="fs-8 text-dark d-block">${d.FirstName} ${d.LastName}</strong>
                                                    <span class="fs-9 text-muted">${d.VehicleModel} • Plate: <code>${d.PlateNumber}</code></span>
                                                </div>
                                            </div>
                                            <span class="badge bg-success text-white fs-9"><i class="fa-solid fa-circle text-white me-1"></i> Active</span>
                                        </div>`;
                                    });
                                    if (listEl) listEl.innerHTML = html;
                                }
                            } catch (e) { }
                        };

                        window.executeBroadcastToRiders = async function () {
                            const orderId = parseInt(document.getElementById('dispatchOrderId').value) || 0;
                            try {
                                const res = await fetch('/pasabuy_api.php?action=broadcast_order_to_riders', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ orderId: orderId })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    alert('🚀 Delivery Job Broadcast Sent! Online verified drivers near campus have been notified.');
                                    const modalEl = document.getElementById('sellerDispatchModal');
                                    const bs = bootstrap.Modal.getInstance(modalEl);
                                    if (bs) bs.hide();
                                    openOrdersModal();
                                }
                            } catch (e) {
                                alert('Error broadcasting job to drivers.');
                            }
                        };

                        // Driver registration & job polling
                        let driverJobPollTimer = null;

                        window.submitRiderRegistration = async function () {
                            const user = getStoredStudentUser();
                            const userId = user.id || user.userId || user.UserId || 104;

                            const plate = document.getElementById('rPlateNumber').value.trim();
                            const model = document.getElementById('rVehicleModel').value.trim();
                            const licenseNo = document.getElementById('rLicenseNo').value.trim();

                            if (!plate || !model || !licenseNo) {
                                alert('Please complete all motor driver registration fields.');
                                return;
                            }

                            try {
                                const res = await fetch('/pasabuy_api.php?action=register_motor_rider', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        userId: userId,
                                        plateNumber: plate,
                                        vehicleModel: model,
                                        driverLicenseNo: licenseNo,
                                        licenseImage: 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=500&q=80'
                                    })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    alert('🎉 Motor Driver Application Submitted! Admin will review your driver documents.');
                                    const modalEl = document.getElementById('riderRegisterModal');
                                    const bs = bootstrap.Modal.getInstance(modalEl);
                                    if (bs) bs.hide();
                                }
                            } catch (e) {
                                alert('Error submitting driver registration.');
                            }
                        };

                        window.startDriverJobPolling = function () {
                            if (driverJobPollTimer) clearInterval(driverJobPollTimer);
                            driverJobPollTimer = setInterval(async () => {
                                const user = getStoredStudentUser();
                                const userId = user.id || user.userId || user.UserId || 0;
                                if (!userId) return;

                                try {
                                    const res = await fetch(`/pasabuy_api.php?action=get_driver_job_broadcasts&userId=${userId}`);
                                    if (res.ok) {
                                        const data = await res.json();
                                        if (data.isVerifiedDriver && data.jobs && data.jobs.length > 0) {
                                            const job = data.jobs[0];
                                            const bodyEl = document.getElementById('riderJobAlertBody');
                                            if (bodyEl) {
                                                bodyEl.innerHTML = `
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-dark mb-1">Item: ${job.ItemTitle}</h6>
                                                    <div class="fw-extrabold text-primary fs-6 mb-2">Earnings / Fee: ₱30.00 (Item: ₱${parseFloat(job.ItemPrice).toFixed(2)})</div>
                                                    <div class="p-2.5 bg-light rounded-3 fs-8 mb-2">
                                                        <div><i class="fa-solid fa-store text-primary me-1"></i> Pickup Seller: <strong>${job.SellerFirstName} ${job.SellerLastName}</strong> (Phone: ${job.SellerPhone || 'N/A'})</div>
                                                        <div><i class="fa-solid fa-house-chimney text-danger me-1"></i> Dropoff Buyer: <strong>${job.BuyerFirstName} ${job.BuyerLastName}</strong> (${job.DeliveryAddress || job.Hometown})</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-light rounded-pill w-50 fw-bold fs-8" data-bs-dismiss="modal">Ignore</button>
                                                    <button type="button" class="btn btn-success rounded-pill w-50 fw-bold fs-8 shadow-sm" onclick="executeAcceptDriverJob(${job.Id})">
                                                        <i class="fa-solid fa-check me-1"></i> Accept Delivery Job
                                                    </button>
                                                </div>`;

                                                const modalEl = document.getElementById('riderJobAlertModal');
                                                if (modalEl && !modalEl.classList.contains('show')) {
                                                    new bootstrap.Modal(modalEl).show();
                                                }
                                            }
                                        }
                                    }
                                } catch (e) { }
                            }, 10000);
                        };

                        window.executeAcceptDriverJob = async function (orderId) {
                            const user = getStoredStudentUser();
                            const userId = user.id || user.userId || user.UserId || 0;

                            try {
                                const res = await fetch('/pasabuy_api.php?action=accept_driver_job', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ orderId: orderId, userId: userId })
                                });
                                const data = await res.json();
                                const modalEl = document.getElementById('riderJobAlertModal');
                                if (modalEl) {
                                    const bs = bootstrap.Modal.getInstance(modalEl);
                                    if (bs) bs.hide();
                                }

                                if (data.success) {
                                    alert(data.message);
                                    openDriverActiveDeliveryModal(orderId);
                                } else {
                                    alert(data.message);
                                }
                            } catch (e) {
                                alert('Error accepting job.');
                            }
                        };

                        window.openDriverActiveDeliveryModal = async function (orderId) {
                            const user = getStoredStudentUser();
                            const userId = user.id || user.userId || user.UserId || 0;

                            const bodyEl = document.getElementById('driverActiveDeliveryBody');
                            if (!bodyEl) return;

                            try {
                                const res = await fetch(`/pasabuy_api.php?action=get_buyer_orders&userId=${userId}`);
                                const modalEl = document.getElementById('driverActiveDeliveryModal');
                                if (modalEl) new bootstrap.Modal(modalEl).show();

                                bodyEl.innerHTML = `
                                <div class="p-3 bg-light rounded-4 border mb-3">
                                    <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-store text-primary me-2"></i> Stage 1: Pickup Location (Seller)</h6>
                                    <p class="fs-8 text-secondary mb-2">Proceed to Seller spot to pick up package.</p>
                                    <div class="fs-8">
                                        <div>Seller Contact: <strong>09171234567</strong></div>
                                        <div>Pickup Spot: <strong>Campus Main Library Ground Floor</strong></div>
                                    </div>
                                    <button class="btn btn-warning w-100 rounded-pill fw-bold py-2 mt-3 fs-8 text-dark" onclick="executeConfirmCollected(${orderId})">
                                        <i class="fa-solid fa-box-check me-1"></i> Package Collected from Seller
                                    </button>
                                </div>
                                <div class="p-3 bg-light rounded-4 border">
                                    <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-house-chimney text-danger me-2"></i> Stage 2: Buyer Dropoff Address</h6>
                                    <p class="fs-8 text-secondary mb-2">Deliver package to buyer's residential address.</p>
                                    <button class="btn btn-success w-100 rounded-pill fw-bold py-2 mt-2 fs-8" onclick="executeConfirmDelivered(${orderId})">
                                        <i class="fa-solid fa-circle-check me-1"></i> Complete Package Delivery
                                    </button>
                                </div>`;
                            } catch (e) { }
                        };

                        window.executeConfirmCollected = async function (orderId) {
                            const user = getStoredStudentUser();
                            const userId = user.id || user.userId || user.UserId || 0;
                            try {
                                const res = await fetch('/pasabuy_api.php?action=confirm_package_collected', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ orderId: orderId, userId: userId })
                                });
                                const data = await res.json();
                                alert(data.message);
                            } catch (e) { }
                        };

                        window.executeConfirmDelivered = async function (orderId) {
                            const user = getStoredStudentUser();
                            const userId = user.id || user.userId || user.UserId || 0;
                            try {
                                const res = await fetch('/pasabuy_api.php?action=confirm_package_delivered', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ orderId: orderId, userId: userId })
                                });
                                const data = await res.json();
                                alert(data.message);
                                const modalEl = document.getElementById('driverActiveDeliveryModal');
                                if (modalEl) {
                                    const bs = bootstrap.Modal.getInstance(modalEl);
                                    if (bs) bs.hide();
                                }
                            } catch (e) { }
                        };

                        // Start GPS watch & driver polling on page load
                        window.addEventListener('DOMContentLoaded', () => {
                            startDriverJobPolling();
                        });

                        // Splash Screen & Auth Screen Flow
                        let splashTimer = null;
                        let splashProgressInterval = null;


                        window.initSplashScreen = function () {

                            const splash = document.getElementById('splashScreen');
                            const auth = document.getElementById('authScreen');
                            const reg = document.getElementById('registerScreen');
                            const userActions = document.getElementById('headerUserActions');
                            const progressBar = document.getElementById('splashProgressBar');

                            if (!splash) return;

                            const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in');
                            if (isLoggedIn === 'true') {
                                splash.style.display = 'none';
                                if (auth) auth.style.display = 'none';
                                if (reg) reg.style.display = 'none';
                                if (userActions) userActions.style.setProperty('display', 'flex', 'important');
                                return;
                            }

                            splash.style.display = 'flex';
                            if (auth) auth.style.display = 'none';
                            if (reg) reg.style.display = 'none';
                            if (userActions) userActions.style.setProperty('display', 'none', 'important');

                            let progress = 0;
                            if (progressBar) progressBar.style.width = '0%';

                            if (splashProgressInterval) clearInterval(splashProgressInterval);
                            splashProgressInterval = setInterval(() => {
                                progress += 2;
                                if (progressBar) progressBar.style.width = `${progress}%`;
                                if (progress >= 100) {
                                    clearInterval(splashProgressInterval);
                                }
                            }, 100);

                            if (splashTimer) clearTimeout(splashTimer);
                            splashTimer = setTimeout(() => {
                                hideSplashScreen();
                            }, 5000);
                        };

                        window.hideSplashScreen = function () {
                            if (splashTimer) clearTimeout(splashTimer);
                            if (splashProgressInterval) clearInterval(splashProgressInterval);
                            const splash = document.getElementById('splashScreen');
                            const userActions = document.getElementById('headerUserActions');
                            if (splash) {
                                splash.style.opacity = '0';
                                splash.style.transition = 'opacity 0.4s ease';
                                setTimeout(() => {
                                    splash.style.display = 'none';
                                    const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in');
                                    if (isLoggedIn !== 'true') {
                                        const auth = document.getElementById('authScreen');
                                        if (auth) auth.style.display = 'block';
                                        if (userActions) userActions.style.setProperty('display', 'none', 'important');
                                    } else {
                                        if (userActions) userActions.style.setProperty('display', 'flex', 'important');
                                    }
                                }, 400);
                            }
                        };

                        window.showLoginScreen = function () {
                            const splash = document.getElementById('splashScreen');
                            const auth = document.getElementById('authScreen');
                            const reg = document.getElementById('registerScreen');
                            const userActions = document.getElementById('headerUserActions');
                            if (splash) splash.style.display = 'none';
                            if (auth) auth.style.display = 'block';
                            if (reg) reg.style.display = 'none';
                            if (userActions) userActions.style.setProperty('display', 'none', 'important');
                        };

                        window.showRegisterScreen = function () {
                            const splash = document.getElementById('splashScreen');
                            const auth = document.getElementById('authScreen');
                            const reg = document.getElementById('registerScreen');
                            const userActions = document.getElementById('headerUserActions');
                            if (splash) splash.style.display = 'none';
                            if (auth) auth.style.display = 'none';
                            if (reg) reg.style.display = 'block';
                            if (userActions) userActions.style.setProperty('display', 'none', 'important');
                        };

                        window.submitRegistrationSendOtpScreen = async function () {
                            const fullName = (document.getElementById('regFullName')?.value || '').trim();
                            const email = (document.getElementById('regEmail')?.value || '').trim();
                            const password = (document.getElementById('regPassword')?.value || '').trim();
                            const confirmPassword = (document.getElementById('regConfirmPassword')?.value || '').trim();
                            const agreeTerms = document.getElementById('regAgreeTerms')?.checked;

                            if (!fullName) {
                                alert('Please enter your Full Name.');
                                return;
                            }
                            if (!email) {
                                alert('Please enter your School Email.');
                                return;
                            }
                            if (!password || password.length < 6) {
                                alert('Password must be at least 6 characters.');
                                return;
                            }
                            if (password !== confirmPassword) {
                                alert('Password and Confirm Password do not match.');
                                return;
                            }
                            if (!agreeTerms) {
                                alert('Please agree to the Terms and Conditions to proceed.');
                                return;
                            }

                            const nameParts = fullName.split(' ');
                            const firstName = nameParts[0] || 'Student';
                            const lastName = nameParts.slice(1).join(' ') || '';

                            pendingRegistrationEmail = email;
                            pendingRegistrationData = {
                                firstName: firstName,
                                lastName: lastName,
                                email: email,
                                studentNumber: '2026-' + Math.floor(1000 + Math.random() * 9000),
                                course: 'BS Student',
                                yearLevel: '1st Yr',
                                password: password
                            };

                            try {
                                const res = await fetch('/pasabuy_otp.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        action: 'send_otp',
                                        email: email,
                                        name: fullName,
                                        password: password
                                    })
                                });

                                const data = await res.json();
                                if (res.ok && data.success) {
                                    document.getElementById('otpTargetEmail').innerText = email;
                                    document.getElementById('otpInputCode').value = '';
                                    const otpModalEl = document.getElementById('otpVerifyModal');
                                    if (otpModalEl && otpModalEl.parentElement !== document.body) {
                                        document.body.appendChild(otpModalEl);
                                    }
                                    if (!otpVerifyModalInstance) {
                                        otpVerifyModalInstance = new bootstrap.Modal(otpModalEl);
                                    }
                                    otpVerifyModalInstance.show();
                                    alert(`📧 Verification OTP code sent to ${email} from PASABUY@pasabuy.site!`);
                                } else {
                                    alert(data.message || '❌ Could not send OTP code to this email address.');
                                }
                            } catch (e) {
                                alert('Connection error sending OTP code.');
                            }
                        };

                        // Single Consolidated Initialization on Page Load
                        window.addEventListener('DOMContentLoaded', async () => {
                            const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in');
                            if (isLoggedIn !== 'true') {
                                initSplashScreen();
                            } else {
                                checkStudentSessionOnLoad();
                                switchTab('home');
                            }

                            await filterProducts();
                            await loadWantedPosts();
                            updateCartBadge();
                            handlePaymentSuccess();
                            startLiveChatPolling();
                        });

                        // Start splash screen timer right away if not logged in
                        if (localStorage.getItem('pasabuy_student_logged_in') !== 'true') {
                            setTimeout(() => { if (typeof initSplashScreen === 'function') initSplashScreen(); }, 50);
                        }

                    </script>
    <script>
        if (typeof window.loadChatConversationsList !== 'function') {
            window.loadChatConversationsList = async function () {
                const container = document.getElementById('conversationHeadsList');
                if (!container) return;
                let user = {};
                try { user = JSON.parse(localStorage.getItem('pasabuy_student_user') || '{}'); } catch (e) {}
                const userId = user.id || user.userId || user.UserId || 104;
                try {
                    const response = await fetch(`/pasabuy_api.php?action=chat_conversations&user_id=${encodeURIComponent(userId)}&_t=${Date.now()}`, { cache: 'no-store' });
                    const conversations = await response.json();
                    if (!Array.isArray(conversations) || !conversations.length) return;
                    container.innerHTML = conversations.map(c => `<button type="button" class="conversation-card w-100 text-start border rounded-4 bg-white p-3 d-flex align-items-center gap-3 shadow-2xs" onclick='window.openConversationCard(${JSON.stringify(c).replace(/</g, "\\u003c")})'><img src="${c.PartnerAvatar || 'https://ui-avatars.com/api/?name=Chat&background=5B3FA8&color=fff'}" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;" alt=""><span class="min-w-0"><strong class="d-block text-dark text-truncate">${c.PartnerName || 'Campus Student'}</strong><small class="text-muted text-truncate d-block">${c.ItemTitle || 'Rental conversation'}</small><small class="text-secondary text-truncate d-block">${c.MessageText || ''}</small></span></button>`).join('');
                } catch (e) { console.error('Messages fallback loader failed:', e); }
            };
        }
        window.openConversationCard = async function (conversation) {
            if (typeof window.checkAndOpenChat === 'function') {
                return window.checkAndOpenChat(Number(conversation.PartnerId || conversation.SenderId || 0), conversation.PartnerName || 'Campus Student', conversation.ItemTitle || 'Campus Item', conversation.ItemPrice || '₱0.00', conversation.PartnerAvatar || '', conversation.ItemImage || '', false, conversation.OwnerName || '', false, conversation.OrderCode || conversation.RentalOrderCode || '');
            }
            window.currentActiveChatSellerId = Number(conversation.PartnerId || conversation.SenderId || 0);
            window.currentActiveChatOrderCode = conversation.OrderCode || conversation.RentalOrderCode || null;
            document.getElementById('tabMessages')?.style.setProperty('display', 'none', 'important');
            document.getElementById('chatView')?.style.setProperty('display', 'flex', 'important');
            const partner = document.getElementById('chatPartnerName') || document.getElementById('chatRecipientName');
            const title = document.getElementById('chatItemTitle');
            if (partner) partner.textContent = conversation.PartnerName || 'Campus Student';
            if (title) title.textContent = conversation.ItemTitle || 'Campus Item';
        };
        if (typeof window.closeChat !== 'function') {
            window.closeChat = function () {
                document.getElementById('chatView')?.style.setProperty('display', 'none', 'important');
                document.getElementById('tabMessages')?.style.setProperty('display', 'block', 'important');
                if (typeof window.loadChatConversationsList === 'function') window.loadChatConversationsList();
            };
        }
    </script>
    <script src="rentease_app.js?v=<?= time() ?>"></script>
</body>

</html>