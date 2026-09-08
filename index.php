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

    <div class="app-container">
        <!-- App Header (Matching Reference Design) -->
        <div class="app-header bg-white border-bottom px-3 py-2.5 shadow-sm d-flex align-items-center justify-content-between" style="background:#fff; color:#1E293B;">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-3 d-inline-flex align-items-center justify-content-center p-1.5 shadow-sm"
                    style="width:38px; height:38px; background: linear-gradient(135deg, #6C5CE7, #5F27CD); color:#fff;">
                    <i class="fa-solid fa-bag-shopping fs-5"></i>
                </div>
                <div>
                    <div class="fw-extrabold fs-6 text-dark lh-1" style="letter-spacing: -0.3px;">PasaBuy</div>
                    <div class="text-muted fs-9" style="font-size: 0.68rem;">Your Campus, Your Marketplace</div>
                </div>
            </div>
            <div class="align-items-center gap-2" id="headerUserActions" style="display:none !important;">
                <button class="btn btn-light rounded-circle position-relative border-0 shadow-sm p-0 d-flex align-items-center justify-content-center" 
                    onclick="openNotificationsModal()" title="Notifications" style="width:36px; height:36px; background: #F1F5F9;">
                    <i class="fa-solid fa-bell text-secondary fs-7"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem; padding: 2px 4px;">1</span>
                </button>
                <button class="btn btn-light rounded-circle position-relative border-0 shadow-sm p-0 d-flex align-items-center justify-content-center" 
                    onclick="switchTab('messages')" title="Messages" style="width:36px; height:36px; background: #F1F5F9;">
                    <i class="fa-solid fa-comment-dots text-secondary fs-7"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem; padding: 2px 4px;">1</span>
                </button>
                <div class="position-relative d-inline-block" style="cursor:pointer;" onclick="switchTab('profile')">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80"
                        class="rounded-circle border border-2 border-white shadow-sm" width="36" height="36" style="object-fit:cover;" id="homeAvatar">
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:10px; height:10px;"></span>
                </div>
            </div>
        </div>

        <!-- App Body (Dynamic Tab Views) -->
        <!-- App Body (Dynamic PHP Modular Tab Views) -->
        <div class="app-body" id="appBody">
            <?php include 'splash_screen.php'; ?>
            <?php include 'login.php'; ?>
            <?php include 'create_account.php'; ?>
            <?php include 'tab_home.php'; ?>
            <?php include 'tab_explore.php'; ?>
            <?php include 'tab_sell.php'; ?>
            <?php include 'tab_wanted.php'; ?>
            <?php include 'tab_messages.php'; ?>
            <?php include 'tab_profile.php'; ?>
        </div>
          <!-- App Bottom Tab Bar Navigation (Matching Reference Screenshot) -->
        <div class="app-tabbar" style="display:none; height:68px; border-top:1px solid #E2E8F0; background:#fff;">
            <div class="tab-item active" onclick="switchTab('home')" id="tabNavHome">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </div>
            <div class="tab-item" onclick="switchTab('explore')" id="tabNavExplore">
                <i class="fa-solid fa-compass"></i>
                <span>Explore</span>
            </div>
            <!-- Raised Floating Plus Button in Center -->
            <div class="tab-item" onclick="switchTab('sell')" id="tabNavSell" style="position:relative; overflow:visible;">
                <div class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-lg" 
                    style="width:48px; height:48px; background: linear-gradient(135deg, #6C5CE7, #5F27CD); border: 3px solid #FFF; transform: translateY(-12px);">
                    <i class="fa-solid fa-plus text-white fs-5"></i>
                </div>
            </div>
            <div class="tab-item position-relative" onclick="openCartModal()" id="tabNavCart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Cart</span>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCountBadge" style="font-size:0.6rem; display:none; padding:2px 4px;">0</span>
            </div>
            <div class="tab-item" onclick="switchTab('wanted')" id="tabNavWanted">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>Orders</span>
            </div>
            <div class="tab-item" onclick="switchTab('profile')" id="tabNavProfile">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </div>
        </div>
            </div>
        </div>
    </div>

    <!-- Application Modals Component -->
    <?php include 'modals.php'; ?>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    <script>
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

                                    const studentUser = {
                                        id: realUserId,
                                        userId: realUserId,
                                        email: uObj.email || emailInput,
                                        firstName: pObj.firstName || uObj.firstName || emailInput.split('@')[0],
                                        lastName: pObj.lastName || uObj.lastName || '',
                                        studentNumber: pObj.studentNumber || '2024-00123',
                                        course: pObj.course || 'BS Computer Science',
                                        yearLevel: pObj.yearLevel || '3rd Yr',
                                        verificationStatus: 'VERIFIED'
                                    };

                                    localStorage.setItem('pasabuy_student_logged_in', 'true');
                                    localStorage.setItem('pasabuy_student_user', JSON.stringify(studentUser));

                                    document.getElementById('authScreen').style.display = 'none';
                                    document.querySelector('.app-tabbar').style.display = 'flex';
                                    document.getElementById('headerBadge').style.display = 'inline-flex';

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
                            document.getElementById('settingsStudentNumber').value = studentUser.studentNumber || '';
                            document.getElementById('settingsCourse').value = studentUser.course || '';
                            if (studentUser.yearLevel) {
                                document.getElementById('settingsYearLevel').value = studentUser.yearLevel;
                            }

                            const avatarSrc = document.getElementById('profileAvatar').src;
                            document.getElementById('settingsAvatarPreview').src = avatarSrc;
                            newAvatarDataUrl = avatarSrc;

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

                        async function saveProfileSettings() {
                            const firstName = document.getElementById('settingsFirstName').value.trim();
                            const lastName = document.getElementById('settingsLastName').value.trim();
                            const studentNo = document.getElementById('settingsStudentNumber').value.trim();
                            const course = document.getElementById('settingsCourse').value.trim();
                            const yearLevel = document.getElementById('settingsYearLevel').value;

                            if (!firstName || !lastName) {
                                alert('Please enter your First Name and Last Name.');
                                return;
                            }

                            const fullName = `${firstName} ${lastName}`;
                            let subParts = [];
                            if (studentNo) subParts.push(studentNo);
                            if (course) subParts.push(`${course} (${yearLevel})`);
                            const subInfo = subParts.length > 0 ? subParts.join(' • ') : 'Verified Student';

                            const updatedUser = {
                                firstName: firstName,
                                lastName: lastName,
                                studentNumber: studentNo,
                                course: course,
                                yearLevel: yearLevel,
                                profileImage: newAvatarDataUrl
                            };
                            localStorage.setItem('pasabuy_student_user', JSON.stringify(updatedUser));

                            document.getElementById('profileName').innerText = fullName;
                            document.getElementById('profileSub').innerText = subInfo;
                            document.getElementById('homeWelcomeName').innerText = `Good day, ${firstName}!`;
                            if (newAvatarDataUrl) {
                                document.getElementById('profileAvatar').src = newAvatarDataUrl;
                                document.getElementById('homeAvatar').src = newAvatarDataUrl;
                            }

                            if (settingsModalInstance) settingsModalInstance.hide();
                            alert('🎉 Account Profile & Settings saved successfully!');
                        }

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
                            const reason = document.getElementById('reportReason').value;
                            const details = document.getElementById('reportDetails').value;

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

                        function checkStudentSessionOnLoad() {
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

                                        document.getElementById('profileName').innerText = fullName;
                                        document.getElementById('homeWelcomeName').innerText = `Good day, ${firstName}!`;
                                        document.getElementById('profileSub').innerText = `${email} • Verified Student`;
                                        document.getElementById('profileRating').innerText = studentUser.rating || '0.0';
                                        document.getElementById('profileDeals').innerText = studentUser.completedTransactions || 0;
                                        if (studentUser.profileImage) {
                                            document.getElementById('profileAvatar').src = studentUser.profileImage;
                                            document.getElementById('homeAvatar').src = studentUser.profileImage;
                                        }

                                        document.getElementById('authScreen').style.display = 'none';
                                        document.querySelector('.app-tabbar').style.display = 'flex';
                                        document.getElementById('headerBadge').style.display = 'inline-flex';
                                        const userActions = document.getElementById('headerUserActions');
                                        if (userActions) userActions.style.setProperty('display', 'flex', 'important');
                                        switchTab('home');
                                        return;
                                    }
                                }
                            } catch (e) { }

                            document.getElementById('authScreen').style.display = 'block';
                            document.querySelector('.app-tabbar').style.display = 'none';
                            document.getElementById('headerBadge').style.display = 'none';
                            const userActions = document.getElementById('headerUserActions');
                            if (userActions) userActions.style.setProperty('display', 'none', 'important');
                            const tabs = ['tabHome', 'tabExplore', 'tabSell', 'tabWanted', 'tabMessages', 'tabProfile', 'chatView'];
                            tabs.forEach(id => { const el = document.getElementById(id); if (el) el.style.display = 'none'; });
                        }

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
                                        email: pendingRegistrationEmail
                                    };
                                    localStorage.setItem('pasabuy_student_user', JSON.stringify(studentUser));
                                    localStorage.setItem('pasabuy_student_logged_in', 'true');

                                    document.getElementById('profileName').innerText = `${studentUser.firstName} ${studentUser.lastName}`.trim();
                                    document.getElementById('homeWelcomeName').innerText = `Good day, ${studentUser.firstName}!`;
                                    document.getElementById('profileSub').innerText = `${pendingRegistrationEmail} • Verified Student`;

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

                        function checkAndOpenChat(sellerId, sellerName, title, price) {
                            try {
                                const storedUser = localStorage.getItem('pasabuy_student_user');
                                if (storedUser) {
                                    const user = JSON.parse(storedUser);
                                    const currentUserId = user.id || user.userId || user.UserId || 0;
                                    console.log("Checking chat - Current:", currentUserId, "Seller:", sellerId);
                                    if (currentUserId > 0 && parseInt(currentUserId) === parseInt(sellerId)) {
                                        alert('❌ You cannot message yourself. This is your own listing!');
                                        return;
                                    }
                                }
                            } catch (e) { console.error("Chat check error:", e); }
                            openChat(sellerName, title, price);
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
                            const tabs = ['home', 'explore', 'sell', 'wanted', 'messages', 'profile'];
                            tabs.forEach(t => {
                                const el = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
                                const nav = document.getElementById('tabNav' + t.charAt(0).toUpperCase() + t.slice(1));
                                if (el) el.style.display = (t === tabName) ? 'block' : 'none';
                                if (nav) nav.classList.toggle('active', t === tabName);
                            });
                            document.getElementById('chatView').style.display = 'none';
                            document.getElementById('authScreen').style.display = 'none';
                            document.querySelector('.app-tabbar').style.display = 'flex';

                            // Handle Cart Button Positioning per User Request:
                            // If Home tab -> Cart floats above Profile tab icon in bottom navigation bar.
                            // If Other tab -> Cart moves to main top header bar next to Verified Student badge!
                            const headerCartBtn = document.getElementById('headerCartBtn');
                            const homeCartBtn = document.getElementById('homeCartBtn');
                            if (tabName === 'home') {
                                if (headerCartBtn) headerCartBtn.style.setProperty('display', 'none', 'important');
                                if (homeCartBtn) homeCartBtn.style.setProperty('display', 'flex', 'important');
                            } else {
                                if (headerCartBtn) headerCartBtn.style.setProperty('display', 'inline-flex', 'important');
                                if (homeCartBtn) homeCartBtn.style.setProperty('display', 'none', 'important');
                            }

                            if (tabName === 'messages') {
                                loadChatConversationsList();
                            } else if (tabName === 'wanted') {
                                loadWantedPosts();
                            }
                        }

                        async function loadChatConversationsList() {
                            const container = document.getElementById('conversationHeadsList');
                            if (!container) return;

                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 1) : 1;
                            const myName = storedUser ? (storedUser.firstName + ' ' + (storedUser.lastName || '')).trim().toLowerCase() : '';

                            let convs = [];
                            try {
                                const res = await fetch(`/pasabuy_api.php?action=chat_conversations&user_id=${currentUserId}`);
                                if (res.ok) {
                                    convs = await res.json();
                                }
                            } catch (e) { }

                            let localConvs = [];
                            try { localConvs = JSON.parse(localStorage.getItem('pasabuy_local_chat_heads')) || []; } catch (e) { }

                            localConvs.forEach(lc => {
                                if (lc.myId && lc.myId != currentUserId) return;
                                if (!convs.some(c => (c.PartnerId && c.PartnerId == lc.partnerId) || c.SenderId == lc.partnerId || c.ReceiverId == lc.partnerId)) {
                                    convs.push({
                                        PartnerId: lc.partnerId,
                                        PartnerName: lc.partnerName,
                                        SenderId: lc.partnerId,
                                        ReceiverId: currentUserId,
                                        ItemTitle: lc.itemTitle,
                                        MessageText: lc.lastMessage || 'Click to view conversation',
                                        CreatedAt: lc.time || 'Just now'
                                    });
                                }
                            });

                            convs = convs.filter(c => {
                                const pId = c.PartnerId || ((c.SenderId == currentUserId) ? c.ReceiverId : c.SenderId);
                                const pName = (c.PartnerName || c.SenderName || '').toLowerCase().trim();
                                return pId != currentUserId && (myName === '' || pName !== myName);
                            });

                            if (!Array.isArray(convs) || convs.length === 0) {
                                container.innerHTML = `
                <div class="text-center py-5 text-muted fs-8 bg-white rounded-4 border p-4">
                    <i class="fa-solid fa-comments fs-2 d-block mb-2 text-secondary opacity-50"></i>
                    No active chat conversations yet.<br>Click <strong>Message</strong> on any item listing to start chatting!
                </div>`;
                                return;
                            }

                            let html = '';
                            convs.forEach(c => {
                                const partnerId = c.PartnerId || ((c.SenderId == currentUserId) ? c.ReceiverId : c.SenderId);
                                const partnerName = c.PartnerName || (c.SenderId == currentUserId ? 'Campus Seller' : (c.SenderName || 'Campus Buyer'));
                                const itemTitle = c.ItemTitle || 'Campus Item';
                                const lastMsg = c.MessageText || 'Tap to chat';

                                let avatarUrl = c.PartnerAvatar || c.partnerAvatar || '';
                                if (!avatarUrl || avatarUrl === '') {
                                    avatarUrl = `https://api.dicebear.com/7.x/avataaars/svg?seed=${encodeURIComponent(partnerName)}`;
                                }

                                html += `
                <div class="p-3 bg-white rounded-4 border shadow-sm d-flex align-items-center justify-content-between mb-2 position-relative" style="cursor:pointer;" onclick="checkAndOpenChat(${partnerId}, '${partnerName.replace(/'/g, "\\'")}', '${itemTitle.replace(/'/g, "\\'")}', '₱0.00', '${avatarUrl.replace(/'/g, "\\'")}')">
                    <div class="d-flex align-items-center gap-3">
                        <div class="position-relative">
                            <img src="${avatarUrl}" class="rounded-circle border" width="50" height="50" style="object-fit:cover; background:#f0f3f8;">
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" style="width:14px; height:14px;"></span>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="fw-bold mb-0 text-dark fs-7">${partnerName}</h6>
                                <span class="badge bg-primary-subtle text-primary rounded-pill fs-9 fw-semibold px-2 py-0.5">${itemTitle}</span>
                            </div>
                            <div class="text-muted fs-8 text-truncate" style="max-width:200px;">${lastMsg}</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </div>
                </div>`;
                            });

                            container.innerHTML = html;
                        }

                        let uploadedPhotoUrls = [];

                        function previewSellPhotos(event) {
                            const files = event.target.files;
                            const grid = document.getElementById('sellPhotosPreviewGrid');
                            grid.innerHTML = '';
                            uploadedPhotoUrls = [];

                            if (!files || files.length === 0) return;

                            Array.from(files).forEach((file, index) => {
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    const dataUrl = e.target.result;
                                    uploadedPhotoUrls.push(dataUrl);

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
                                };
                                reader.readAsDataURL(file);
                            });
                        }

                        function removePhoto(index) {
                            uploadedPhotoUrls.splice(index, 1);
                            const el = document.getElementById(`photoThumb_${index}`);
                            if (el) el.remove();
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
                                document.getElementById('gatewayAmount').innerText = amountText;
                                document.getElementById('gcashAmountDisplay').innerText = amountText;
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

                                // Save locally so item displays instantly on Home Feed and Profile Tab
                                const newProduct = {
                                    id: currentListingId || Date.now(),
                                    title: title,
                                    price: `₱${price.toFixed(2)}`,
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

                                if (!isMyListing && (p.status === 'RESERVED' || p.status === 'SOLD')) return;

                                if (selectedCat === 'My Items' && !isMyListing) return;
                                if (selectedCat !== 'All' && selectedCat !== 'My Items' && p.condition !== selectedCat && p.category !== selectedCat) return;
                                if (cond !== 'All' && p.condition !== cond) return;
                                if (search && !p.title.toLowerCase().includes(search)) return;

                                let buttonsHtml = '';
                                if (isMyListing) {
                                    if (p.status === 'RESERVED') {
                                        buttonsHtml = `
                        <div class="d-flex flex-column gap-2 w-100">
                            <div class="badge bg-warning text-dark w-100 py-2 rounded-pill fs-8 text-center fw-bold"><i class="fa-solid fa-bookmark me-1"></i> STATUS: RESERVED</div>
                            <button class="btn btn-sm btn-outline-success rounded-pill w-100 fw-bold fs-8" onclick="executeUnreserveListing(${p.id})"><i class="fa-solid fa-rotate-left me-1"></i> Un-Reserve (Put Back Public)</button>
                            <button class="btn btn-sm btn-success rounded-pill w-100 fw-bold fs-8" onclick="executeMarkSoldListing(${p.id})"><i class="fa-solid fa-circle-check me-1"></i> Mark as SOLD</button>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary rounded-pill w-100 fw-bold fs-8" onclick="openEditListingModal(${p.id})"><i class="fa-solid fa-pen-to-square me-1"></i> Edit</button>
                                <button class="btn btn-sm btn-outline-danger rounded-pill w-100 fw-bold fs-8" onclick="confirmDeleteListing(${p.id}, '${p.title.replace(/'/g, "\\'")}', '${p.fee}')"><i class="fa-solid fa-trash me-1"></i> Delete</button>
                            </div>
                        </div>`;
                                    } else if (p.status === 'SOLD') {
                                        buttonsHtml = `
                        <div class="d-flex flex-column gap-2 w-100">
                            <div class="badge bg-success text-white w-100 py-2 rounded-pill fs-8 text-center fw-bold"><i class="fa-solid fa-check-circle me-1"></i> STATUS: SOLD</div>
                            <button class="btn btn-sm btn-outline-danger rounded-pill w-100 fw-bold fs-8" onclick="confirmDeleteListing(${p.id}, '${p.title.replace(/'/g, "\\'")}', '${p.fee}')"><i class="fa-solid fa-trash me-1"></i> Delete Listing</button>
                        </div>`;
                                    } else {
                                        buttonsHtml = `
                        <div class="d-flex flex-column gap-2 w-100">
                            <div class="badge bg-secondary-subtle text-secondary w-100 py-2 rounded-pill fs-8 text-center fw-bold"><i class="fa-solid fa-user-check me-1"></i> Your Active Listing</div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary rounded-pill w-100 fw-bold fs-8" onclick="openEditListingModal(${p.id})"><i class="fa-solid fa-pen-to-square me-1"></i> Edit Listing</button>
                                <button class="btn btn-sm btn-outline-danger rounded-pill w-100 fw-bold fs-8" onclick="confirmDeleteListing(${p.id}, '${p.title.replace(/'/g, "\\'")}', '${p.fee}')"><i class="fa-solid fa-trash me-1"></i> Delete Listing</button>
                            </div>
                        </div>`;
                                    }
                                    const isInCart = (pasabuyCart || []).some(item => (item.listingId && item.listingId == p.id) || item.title === p.title);
                                    let cartBtnHtml = '';
                                    if (isInCart) {
                                        cartBtnHtml = `<button class="btn btn-sm btn-outline-danger rounded-pill w-100 fw-bold fs-8 shadow-sm py-1.5" onclick="toggleCartProduct(event, ${p.id}, '${p.title.replace(/'/g, "\\'")}', '${p.price}', ${p.sellerId}, '${(p.img || '').replace(/'/g, "\\'")}')"><i class="fa-solid fa-cart-xmark me-1"></i> Remove</button>`;
                                    } else {
                                        cartBtnHtml = `<button class="btn btn-sm btn-primary rounded-pill w-100 fw-bold fs-8 shadow-sm py-1.5" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none;" onclick="toggleCartProduct(event, ${p.id}, '${p.title.replace(/'/g, "\\'")}', '${p.price}', ${p.sellerId}, '${(p.img || '').replace(/'/g, "\\'")}')"><i class="fa-solid fa-cart-plus me-1"></i> Add to Cart</button>`;
                                    }

                                    buttonsHtml = `
                    <div class="d-flex flex-column gap-1.5 w-100">
                        ${cartBtnHtml}
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary rounded-pill w-100 fw-bold fs-9 py-1" onclick="checkAndOpenChat(${p.sellerId}, '${p.seller.replace(/'/g, "\\'")}', '${p.title.replace(/'/g, "\\'")}', '${p.price}', '${(p.sellerAvatar || '').replace(/'/g, "\\'")}')"><i class="fa-solid fa-comments me-1"></i> Chat</button>
                            <button class="btn btn-sm btn-primary rounded-pill w-100 fw-bold fs-9 py-1" onclick="checkAndReserve(${p.id}, ${p.sellerId}, '${p.title.replace(/'/g, "\\'")}', '${p.seller.replace(/'/g, "\\'")}', '${(p.sellerAvatar || '').replace(/'/g, "\\'")}')"><i class="fa-solid fa-bookmark me-1"></i> Reserve</button>
                        </div>
                    </div>`;
                                }

                                const origPriceVal = (p.priceVal * 1.15).toFixed(2);
                                const discountTag = p.priceVal > 500 ? '-15%' : '-10%';

                                const mediaHtml = p.videoUrl
                                    ? `<div class="position-relative"><video src="${p.videoUrl}" controls style="width:100%; height:130px; object-fit:cover; border-radius:14px; background:#000;" preload="metadata"></video><span class="badge bg-danger position-absolute top-0 end-0 m-2"><i class="fa-solid fa-video me-1"></i> Video</span></div>`
                                    : `<div class="position-relative"><img src="${p.img}" class="rounded-4" alt="${p.title}" style="width:100%; height:130px; object-fit:cover;"><button class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-2 p-0 d-flex align-items-center justify-content-center shadow-sm" style="width:28px; height:28px; background:rgba(255,255,255,0.9);" onclick="toggleWishlist(this, ${p.id})"><i class="fa-regular fa-heart text-muted fs-8"></i></button></div>`;

                                const cardHtml = `
                <div class="col-6 mb-2">
                    <div class="card border-0 rounded-4 shadow-sm h-100 p-2 bg-white d-flex flex-column justify-content-between position-relative">
                        ${mediaHtml}
                        <div class="pt-2">
                            <h6 class="fw-bold mb-1 text-dark fs-8 text-truncate" title="${p.title}">${p.title}</h6>
                            <div class="d-flex align-items-center gap-1 mb-1 flex-wrap">
                                <span class="fw-extrabold text-primary fs-7">${p.price}</span>
                                <span class="text-muted text-decoration-line-through fs-9" style="font-size:0.65rem;">₱${origPriceVal}</span>
                                <span class="badge bg-danger text-white rounded-pill px-1.5 py-0.5" style="font-size:0.6rem;">${discountTag}</span>
                            </div>
                            <div class="fs-9 text-muted mb-1 text-truncate" style="font-size:0.68rem;">
                                <i class="fa-solid fa-location-dot text-primary me-1"></i>${p.location || 'Campus'}
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5 fw-semibold" style="font-size:0.65rem;">In Stock</span>
                            </div>
                        </div>
                        <div class="pt-1">
                            ${isMyListing ? buttonsHtml : cartBtnHtml}
                        </div>
                    </div>
                </div>`;

                                html += cardHtml;

                                if (isMyListing) {
                                    profileHtml += cardHtml;
                                }
                            });

                            if (exploreList) exploreList.innerHTML = html || '<div class="text-center text-muted py-4">No active marketplace items found.</div>';
                            if (homeContainer) homeContainer.innerHTML = html || '<div class="text-center text-muted py-4">No active listings yet. Be the first student to post on campus!</div>';
                            if (profileContainer) profileContainer.innerHTML = profileHtml || '<div class="text-center text-muted py-4">You have no active item listings. Post an item in the Sell tab to view it here!</div>';
                        }

                        let currentActiveChatSellerId = 0;
                        let liveChatPollingTimer = null;

                        function startLiveChatPolling() {
                            if (liveChatPollingTimer) clearInterval(liveChatPollingTimer);
                            liveChatPollingTimer = setInterval(async () => {
                                try {
                                    const chatVw = document.getElementById('chatView');
                                    const tabMsgs = document.getElementById('tabMessages');

                                    if (chatVw && chatVw.style.display !== 'none' && currentActiveChatSellerId > 0) {
                                        await refreshActiveChatStream();
                                    } else if (tabMsgs && tabMsgs.style.display !== 'none') {
                                        await loadChatConversationsList();
                                    }
                                } catch (e) { }
                            }, 3000);
                        }

                        async function refreshActiveChatStream() {
                            if (!currentActiveChatSellerId) return;
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            try {
                                const res = await fetch(`/pasabuy_api.php?action=chat_messages&sender_id=${currentUserId}&receiver_id=${currentActiveChatSellerId}`);
                                if (res.ok) {
                                    const msgs = await res.json();
                                    const stream = document.getElementById('chatStream') || document.getElementById('chatMessageContainer');
                                    if (stream && Array.isArray(msgs)) {
                                        const partnerName = document.getElementById('chatPartnerName')?.innerText || 'Campus Contact';
                                        const itemTitle = document.getElementById('chatItemTitle')?.innerText || 'Campus Item';
                                        const headerAvatarEl = document.getElementById('chatHeaderAvatar');
                                        const finalAvatar = headerAvatarEl ? headerAvatarEl.src : `https://api.dicebear.com/7.x/avataaars/svg?seed=${encodeURIComponent(partnerName)}`;

                                        let chatHtml = `<div class="text-center text-muted fs-9 mb-2">Connected live with <strong>${partnerName}</strong> regarding ${itemTitle}</div>`;
                                        msgs.forEach(m => {
                                            const isMine = m.SenderId == currentUserId;
                                            chatHtml += `
                                            <div class="d-flex ${isMine ? 'justify-content-end' : 'justify-content-start'} align-items-end gap-2 mb-2">
                                                ${!isMine ? `<img src="${finalAvatar}" class="rounded-circle border mb-1" width="28" height="28" style="object-fit:cover; background:#f0f3f8;">` : ''}
                                                <div class="p-2.5 rounded-3 fs-8 ${isMine ? 'bg-primary text-white' : 'bg-light text-dark border'}" style="max-width:75%;">
                                                    ${m.MessageText}
                                                </div>
                                            </div>`;
                                        });
                                        const isNearBottom = (stream.scrollHeight - stream.scrollTop - stream.clientHeight) < 100;
                                        stream.innerHTML = chatHtml;
                                        if (isNearBottom) stream.scrollTop = stream.scrollHeight;
                                    }
                                }
                            } catch (e) { }
                        }

                        function openChat(partnerId, partnerName, itemTitle, itemPrice) {
                            const pId = parseInt(partnerId) || 104;
                            checkAndOpenChat(pId, partnerName || 'Verified Student', itemTitle || 'Campus Request', itemPrice || '₱0.00', '');
                        }

                        async function checkAndOpenChat(sellerId, sellerName, itemTitle, itemPrice, partnerAvatar) {
                            let storedUser = null;
                            try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
                            const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

                            if (currentUserId === sellerId) {
                                alert("ℹ️ You cannot send a chat message to your own item listing.");
                                return;
                            }

                            currentActiveChatSellerId = sellerId;

                            const partnerNameEl = document.getElementById('chatPartnerName') || document.getElementById('chatRecipientName');
                            if (partnerNameEl) partnerNameEl.innerText = sellerName;

                            let finalAvatar = partnerAvatar || '';
                            if (!finalAvatar || finalAvatar === '') {
                                finalAvatar = `https://api.dicebear.com/7.x/avataaars/svg?seed=${encodeURIComponent(sellerName)}`;
                            }

                            const headerAvatarEl = document.getElementById('chatHeaderAvatar');
                            if (headerAvatarEl) headerAvatarEl.src = finalAvatar;

                            const titleEl = document.getElementById('chatItemTitle');
                            if (titleEl) titleEl.innerText = itemTitle;

                            const priceEl = document.getElementById('chatItemPrice');
                            if (priceEl) priceEl.innerText = itemPrice || '₱0.00';

                            switchTab('messages');
                            const tabMsgs = document.getElementById('tabMessages');
                            const chatVw = document.getElementById('chatView');
                            if (tabMsgs) tabMsgs.style.display = 'none';
                            if (chatVw) chatVw.style.display = 'flex';

                            await refreshActiveChatStream();
                            startLiveChatPolling();
                        }

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

                            input.value = '';

                            const stream = document.getElementById('chatStream') || document.getElementById('chatMessageContainer');
                            if (stream) {
                                stream.innerHTML += `
                                <div class="d-flex justify-content-end mb-2">
                                    <div class="p-2.5 rounded-3 fs-8 bg-primary text-white" style="max-width:75%;">
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
                            if (chatVw) chatVw.style.display = 'none';
                            if (tabMsgs) tabMsgs.style.display = 'block';
                            loadChatConversationsList();
                        }

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
                        let currentEditListingObj = null;

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
                            updateCartBadge();
                            renderCartItems();
                            const modalEl = document.getElementById('cartCheckoutModal');
                            if (modalEl) {
                                if (modalEl.parentElement !== document.body) {
                                    document.body.appendChild(modalEl);
                                }
                                let modalObj = bootstrap.Modal.getInstance(modalEl);
                                if (!modalObj) {
                                    modalObj = new bootstrap.Modal(modalEl);
                                }
                                modalObj.show();
                            }
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
                        // Splash Screen & Auth Screen Flow
                        let splashTimer = null;
                        let splashProgressInterval = null;

                        window.initSplashScreen = function () {
                            const splash = document.getElementById('splashScreen');
                            const auth = document.getElementById('authScreen');
                            const reg = document.getElementById('registerScreen');
                            const progressBar = document.getElementById('splashProgressBar');

                            if (!splash) return;

                            const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in');
                            if (isLoggedIn === 'true') {
                                splash.style.display = 'none';
                                if (auth) auth.style.display = 'none';
                                if (reg) reg.style.display = 'none';
                                return;
                            }

                            splash.style.display = 'flex';
                            if (auth) auth.style.display = 'none';
                            if (reg) reg.style.display = 'none';

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
                            if (splash) {
                                splash.style.opacity = '0';
                                splash.style.transition = 'opacity 0.4s ease';
                                setTimeout(() => {
                                    splash.style.display = 'none';
                                    const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in');
                                    if (isLoggedIn !== 'true') {
                                        const auth = document.getElementById('authScreen');
                                        if (auth) auth.style.display = 'block';
                                    }
                                }, 400);
                            }
                        };

                        window.showLoginScreen = function () {
                            const splash = document.getElementById('splashScreen');
                            const auth = document.getElementById('authScreen');
                            const reg = document.getElementById('registerScreen');
                            if (splash) splash.style.display = 'none';
                            if (auth) auth.style.display = 'block';
                            if (reg) reg.style.display = 'none';
                        };

                        window.showRegisterScreen = function () {
                            const splash = document.getElementById('splashScreen');
                            const auth = document.getElementById('authScreen');
                            const reg = document.getElementById('registerScreen');
                            if (splash) splash.style.display = 'none';
                            if (auth) auth.style.display = 'none';
                            if (reg) reg.style.display = 'block';
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
</body>

</html>