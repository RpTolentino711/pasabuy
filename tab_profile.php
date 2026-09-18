<!-- ==========================================================
     RentEase Screen 8: User Profile & Support Hub
     UIDESIFNAPP.png Screen 8
     ========================================================== -->
<div id="tabProfile" style="display:none;">

    <!-- RentEase Header with Settings Gear (Screen 8) -->
    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
        <div class="d-flex align-items-center gap-2">
            <img src="LOGO.png" alt="RentEase Logo" style="height: 38px; width: auto; object-fit: contain;">
            <div>
                <h6 class="fw-extrabold text-dark fs-7 mb-0" style="letter-spacing: -0.2px;">RentEase</h6>
                <div class="text-muted fs-9" style="font-size:0.65rem;">Rent. Book. Celebrate.</div>
            </div>
        </div>
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:34px; height:34px; background:#fff;" onclick="openProfileSettingsModal()">
            <i class="fa-solid fa-gear text-secondary fs-8"></i>
        </button>
    </div>

    <!-- User Profile Card (Screen 8) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3 d-flex flex-row align-items-center justify-content-between" 
         style="cursor:pointer;" onclick="openProfileSettingsModal()" title="Click to edit profile">
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&q=80" 
                     class="rounded-circle border border-2 border-white shadow-2xs" width="50" height="50" style="object-fit:cover;" id="profileAvatar" alt="User Avatar">
                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:12px; height:12px;"></span>
            </div>
            <div>
                <h6 class="fw-extrabold text-dark fs-7 mb-0" id="profileName">Event Organizer</h6>
                <div class="text-muted fs-8" id="profileEmail">organizer@campus.edu.ph</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-primary border rounded-pill fs-9 py-1 px-2">Edit</span>
            <i class="fa-solid fa-chevron-right text-muted fs-8"></i>
        </div>
    </div>

    <!-- Account Navigation Menu (Screen 8) -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden bg-white mb-3">
        
        <!-- My Orders -->
        <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom" 
           onclick="openMyOrdersModal()">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-light d-flex align-items-center justify-content-center" style="width:34px; height:34px; color:#5B3FA8;">
                    <i class="fa-solid fa-receipt fs-8"></i>
                </div>
                <span class="fw-bold text-dark fs-8">My Orders</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
        </a>

        <!-- Purchase History -->
        <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom" 
           onclick="openPurchaseHistoryModal()">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-light d-flex align-items-center justify-content-center" style="width:34px; height:34px; color:#5B3FA8;">
                    <i class="fa-regular fa-calendar-check fs-8"></i>
                </div>
                <span class="fw-bold text-dark fs-8">Purchase History</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
        </a>

        <!-- Saved Addresses -->
        <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom" 
           onclick="openSavedAddressesModal()">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-light d-flex align-items-center justify-content-center" style="width:34px; height:34px; color:#5B3FA8;">
                    <i class="fa-solid fa-location-dot fs-8"></i>
                </div>
                <span class="fw-bold text-dark fs-8">Saved Addresses</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
        </a>

        <!-- Payment Methods -->
        <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom" 
           onclick="openPaymentMethodsModal()">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-light d-flex align-items-center justify-content-center" style="width:34px; height:34px; color:#5B3FA8;">
                    <i class="fa-regular fa-credit-card fs-8"></i>
                </div>
                <span class="fw-bold text-dark fs-8">Payment Methods</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
        </a>

        <!-- Customer Support (Customer Support Module - 10%) -->
        <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom" 
           onclick="openIssueReportingModal()">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-light d-flex align-items-center justify-content-center" style="width:34px; height:34px; color:#5B3FA8;">
                    <i class="fa-solid fa-headset fs-8"></i>
                </div>
                <span class="fw-bold text-dark fs-8">Customer Support</span>
            </div>
            <span class="badge rounded-pill bg-danger-subtle text-danger fw-bold fs-9 me-1">Issue Center</span>
        </a>

        <!-- About RentEase -->
        <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom" 
           onclick="openAboutRentEaseModal()">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-light d-flex align-items-center justify-content-center" style="width:34px; height:34px; color:#5B3FA8;">
                    <i class="fa-solid fa-circle-info fs-8"></i>
                </div>
                <span class="fw-bold text-dark fs-8">About RentEase</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
        </a>

        <!-- Log Out -->
        <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none" 
           onclick="logoutRentEaseUser()">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-danger bg-opacity-10 d-flex align-items-center justify-content-center text-danger" style="width:34px; height:34px;">
                    <i class="fa-solid fa-arrow-right-from-bracket fs-8"></i>
                </div>
                <span class="fw-extrabold text-danger fs-8">Log Out</span>
            </div>
            <i class="fa-solid fa-chevron-right text-danger opacity-50 fs-9"></i>
        </a>

    </div>

</div>
