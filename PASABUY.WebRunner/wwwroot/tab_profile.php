<!-- ==========================================================
     RentEase Screen 8: User Profile & Lender Portfolio
     Displays:
     1. User Profile Card (Romeo Paolo Tolentino) + Settings Gear
     2. "My Rental Listings" - items user has posted for rent
        (All account settings/orders/history/addresses are in Settings Hub)
     ========================================================== -->
<div id="tabProfile" style="display:none;" class="pb-5">

    <!-- User Profile Card with Settings Gear -->
    <div class="card border-0 rounded-4 shadow-sm p-3.5 bg-white mb-3 d-flex flex-row align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" 
                     class="rounded-circle border border-2 border-white shadow-2xs" width="52" height="52" style="object-fit:cover;" id="profileAvatar" alt="Romeo Paolo Tolentino">
                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:12px; height:12px;"></span>
            </div>
            <div>
                <h6 class="fw-extrabold text-dark fs-7 mb-0" id="profileName">Romeo Paolo Tolentino</h6>
                <div class="text-muted fs-8" id="profileSub">BSIT • 4th Yr</div>
                <div class="text-muted fs-9" style="font-size:0.7rem;" id="profileStudentNumber">Student ID: 09668257301</div>
                <div class="text-muted fs-9 d-none" id="profileEmail">09668257301</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                    style="width:38px; height:38px; background:#F8FAFC; border:1px solid #E2E8F0;" 
                    data-bs-toggle="modal" data-bs-target="#settingsHubModal"
                    onclick="openSettingsHubModal()" title="Account & Settings Hub">
                <i class="fa-solid fa-gear text-secondary fs-7"></i>
            </button>
        </div>
    </div>

    <!-- 3 Profile Section Tabs (Requested by User) -->
    <div class="bg-light p-1.5 rounded-4 d-flex align-items-center mb-3 border shadow-2xs gap-1">
        <!-- Subtab 1: Rental Requests / Incoming Orders -->
        <button type="button" class="btn btn-sm rounded-pill flex-grow-1 py-2 px-2 fw-extrabold fs-9 d-flex align-items-center justify-content-center gap-1.5 profile-subtab-btn active text-white" 
                id="btnProfileTabRequests" 
                style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" 
                onclick="switchProfileSubTab('requests')">
            <i class="fa-solid fa-bell"></i>
            <span>Requests</span>
            <span class="badge rounded-pill bg-danger text-white fw-bold fs-9 ms-0.5 badge-pulse-glow" id="profileRequestsBadge" style="display:none; font-size:0.65rem;">0</span>
        </button>

        <!-- Subtab 2: Rent Items / Stock Inventory Monitoring -->
        <button type="button" class="btn btn-sm rounded-pill flex-grow-1 py-2 px-2 fw-bold fs-9 d-flex align-items-center justify-content-center gap-1.5 profile-subtab-btn text-secondary" 
                id="btnProfileTabInventory" 
                style="background:transparent; border:none;" 
                onclick="switchProfileSubTab('inventory')">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Rent Items</span>
            <span class="badge rounded-pill bg-primary-subtle text-primary fw-bold fs-9 ms-0.5" id="myRentalCountBadge">0</span>
        </button>

        <!-- Subtab 3: Rental History -->
        <button type="button" class="btn btn-sm rounded-pill flex-grow-1 py-2 px-2 fw-bold fs-9 d-flex align-items-center justify-content-center gap-1.5 profile-subtab-btn text-secondary" 
                id="btnProfileTabHistory" 
                style="background:transparent; border:none;" 
                onclick="switchProfileSubTab('history')">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>History</span>
        </button>
    </div>

    <!-- ==========================================================
         SUBTAB 1: RENTAL REQUESTS / INCOMING ORDERS FROM RENTERS
         ========================================================== -->
    <div id="profileSectionRequests" class="d-flex flex-column gap-3 pb-3">
        <!-- Live Request Alert Banner -->
        <div id="profileRequestsAlertBanner" class="p-3 rounded-4 bg-primary bg-opacity-10 border border-primary-subtle d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" style="width:34px; height:34px; background:linear-gradient(135deg, #5B3FA8, #341F97) !important;">
                    <i class="fa-solid fa-bell fs-7"></i>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0">Incoming Rental Bookings</h6>
                    <span class="fs-9 text-muted" id="profileRequestsSubtext">Students asking to rent your equipment</span>
                </div>
            </div>
            <button class="btn btn-sm btn-light rounded-pill px-2.5 py-1 fs-9 fw-bold border text-primary" onclick="loadOwnerRentalDashboard(true)">
                <i class="fa-solid fa-rotate-right me-1"></i> Refresh
            </button>
        </div>

        <!-- Dynamic Rental Orders Container -->
        <div id="ownerRequestsListContainer" class="d-flex flex-column gap-3">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width:50px; height:50px; color:#5B3FA8;">
                    <i class="fa-solid fa-inbox fs-4"></i>
                </div>
                <h6 class="fw-bold text-dark fs-8 mb-1">No Active Rental Requests</h6>
                <p class="text-muted fs-9 mb-0">When students rent your equipment, their orders and bookings will appear here for you to accept, monitor, and restock.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================================
         SUBTAB 2: RENT ITEMS & STOCK INVENTORY MONITOR
         ========================================================== -->
    <div id="profileSectionInventory" style="display:none;" class="d-flex flex-column gap-3 pb-3">
        <!-- Stock Overview KPI Bar -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="fw-extrabold text-dark fs-8 mb-0">
                    <i class="fa-solid fa-chart-pie me-1" style="color:#5B3FA8;"></i> Equipment Stock Monitor
                </h6>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-bold fs-9 d-flex align-items-center gap-1 shadow-2xs" 
                        id="headerPostEquipmentBtn"
                        style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" 
                        onclick="switchTab('sell')">
                    <i class="fa-solid fa-plus fs-9"></i> Post Equipment
                </button>
            </div>
            <div class="row g-2 text-center">
                <div class="col-4">
                    <div class="p-2 rounded-3 bg-light border">
                        <span class="fs-9 text-muted d-block">Total Owned</span>
                        <span class="fw-extrabold text-dark fs-7" id="kpiTotalStockOwned">0</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 rounded-3 bg-warning-subtle border border-warning-subtle">
                        <span class="fs-9 text-dark d-block">Rented Out</span>
                        <span class="fw-extrabold text-warning-emphasis fs-7" id="kpiTotalStockRented">0</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 rounded-3 bg-success-subtle border border-success-subtle">
                        <span class="fs-9 text-dark d-block">Ready to Rent</span>
                        <span class="fw-extrabold text-success fs-7" id="kpiTotalStockAvailable">0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Equipment Listings Container -->
        <div id="myRentalListingsContainer" class="d-flex flex-column gap-3">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width:60px; height:60px; color:#5B3FA8;">
                    <i class="fa-solid fa-box-open fs-2"></i>
                </div>
                <h6 class="fw-extrabold text-dark fs-7 mb-1">No Equipment Posted for Rent Yet</h6>
                <p class="text-muted fs-8 mb-0">You haven't listed any equipment. Rent out your sound systems, party chairs, tables, cameras, or lights to fellow students.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================================
         SUBTAB 3: RENTAL HISTORY & COMPLETED BOOKINGS
         ========================================================== -->
    <div id="profileSectionHistory" style="display:none;" class="d-flex flex-column gap-3 pb-3">
        <div class="d-flex align-items-center justify-content-between px-1">
            <h6 class="fw-extrabold text-dark fs-8 mb-0">
                <i class="fa-solid fa-clock-rotate-left me-1" style="color:#5B3FA8;"></i> Completed Returns & Rental Logs
            </h6>
            <span class="badge bg-light text-secondary border fs-9" id="historyCountBadge">0 Records</span>
        </div>

        <!-- Dynamic Rental History Container -->
        <div id="ownerRentalHistoryContainer" class="d-flex flex-column gap-3">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-2 text-muted" style="width:48px; height:48px;">
                    <i class="fa-solid fa-receipt fs-4"></i>
                </div>
                <h6 class="fw-bold text-dark fs-8 mb-1">No Rental History Yet</h6>
                <p class="text-muted fs-9 mb-0">Completed equipment returns and your rental receipts will be archived here.</p>
            </div>
        </div>
    </div>

</div>

<!-- ==========================================================
     EDIT EQUIPMENT PRICE & STOCK MODAL (OWNER ONLY)
     ========================================================== -->
<div class="modal fade" id="editRentalStockPriceModal" tabindex="-1" aria-labelledby="editRentalStockPriceModalLabel" aria-hidden="true" style="z-index: 1065;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3.5 shadow-lg bg-white">
            <div class="modal-header border-0 pb-2 d-flex align-items-center justify-content-between">
                <h6 class="modal-title fw-extrabold text-dark fs-7 d-flex align-items-center gap-2 mb-0" id="editRentalStockPriceModalLabel">
                    <i class="fa-solid fa-sliders" style="color:#5B3FA8;"></i> Adjust Price & Stock
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-1">
                <div class="p-2.5 rounded-3 bg-light border mb-3">
                    <div class="fw-extrabold text-dark fs-8 text-truncate" id="modalEditItemTitle">Equipment Title</div>
                    <span class="fs-9 text-muted">You are editing your own equipment listing. Changes reflect immediately across campus search.</span>
                </div>

                <input type="hidden" id="modalEditItemId" value="0">

                <div class="mb-3">
                    <label class="form-label fw-extrabold text-dark fs-8 mb-1">
                        Daily Rental Price (₱ / day) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white fw-bold text-dark fs-7" style="border-radius:12px 0 0 12px; color:#5B3FA8 !important;">₱</span>
                        <input type="number" class="form-control fw-extrabold fs-6 text-dark" id="modalEditItemPrice" min="1" step="1" style="border-radius:0 12px 12px 0;">
                    </div>
                    <span class="fs-9 text-muted mt-1 d-block">Price charged per 24 hours of equipment booking.</span>
                </div>

                <div class="row g-2.5 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-extrabold text-dark fs-8 mb-1">
                            Available Stock <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control fw-extrabold fs-6 text-dark rounded-3" id="modalEditItemAvailStock" min="0">
                        <span class="fs-9 text-muted mt-1 d-block">Ready to rent now</span>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-extrabold text-dark fs-8 mb-1">
                            Total Units <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control fw-extrabold fs-6 text-dark rounded-3" id="modalEditItemTotalStock" min="1">
                        <span class="fs-9 text-muted mt-1 d-block">Total equipment owned</span>
                    </div>
                </div>

                <div class="p-2.5 rounded-3 border-0 bg-success-subtle text-success fs-9 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check fs-7"></i>
                    <span>Updated rates & stock will sync immediately to the live student catalog.</span>
                </div>
            </div>
            <div class="modal-footer border-0 pt-2 d-flex gap-2">
                <button type="button" class="btn btn-light rounded-pill px-3 py-1.5 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 py-1.5 fs-8 fw-extrabold text-white shadow-sm" 
                        style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" 
                        onclick="saveRentalStockPriceChanges()">
                    <i class="fa-solid fa-check me-1"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================
     SETTINGS & ACCOUNT HUB MODAL
     Triggered by Settings Gear on Profile Tab
     Displays: My Orders, Purchase History, Saved Addresses,
     Payment Methods, Customer Support, About RentEase, Log Out
     ========================================================== -->
<div class="modal fade" id="settingsHubModal" tabindex="-1" aria-labelledby="settingsHubModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-2 d-flex align-items-center justify-content-between">
                <h6 class="modal-title fw-extrabold text-dark fs-7 d-flex align-items-center gap-2 mb-0" id="settingsHubModalLabel">
                    <i class="fa-solid fa-gear" style="color:#5B3FA8;"></i> Account & Settings
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-1 px-1">
                <!-- User mini profile header with Edit button -->
                <div class="p-3 rounded-4 bg-light bg-opacity-75 mb-3 d-flex align-items-center justify-content-between border">
                    <div class="d-flex align-items-center gap-2.5">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" 
                             class="rounded-circle border border-2 border-white shadow-2xs" width="44" height="44" style="object-fit:cover;" id="settingsHubAvatar" alt="Profile">
                        <div>
                            <h6 class="fw-extrabold text-dark fs-8 mb-0" id="settingsHubName">Romeo Paolo Tolentino</h6>
                            <div class="text-muted fs-9" id="settingsHubSub">BSIT • 4th Yr</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill fs-9 py-1 px-2.5 fw-bold" 
                            onclick="switchFromSettingsHub(openProfileSettingsModal)">
                        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                    </button>
                </div>

                <!-- Account Navigation Menu -->
                <div class="card border-0 rounded-4 shadow-2xs overflow-hidden bg-white border mb-2">
                    
                    <!-- My Orders -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub(openMyOrdersModal)">
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
                       onclick="switchFromSettingsHub(openPurchaseHistoryModal)">
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
                       onclick="switchFromSettingsHub(openSavedAddressesModal)">
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
                       onclick="switchFromSettingsHub(openPaymentMethodsModal)">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-2 bg-light d-flex align-items-center justify-content-center" style="width:34px; height:34px; color:#5B3FA8;">
                                <i class="fa-regular fa-credit-card fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Payment Methods</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- Customer Support (Issue Center) -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub(openIssueReportingModal)">
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
                       onclick="switchFromSettingsHub(openAboutRentEaseModal)">
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
                       onclick="switchFromSettingsHub(logoutRentEaseUser)">
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
        </div>
    </div>
</div>

<script>
window.switchFromSettingsHub = function(actionCallback) {
    const hub = document.getElementById('settingsHubModal');
    if (hub && typeof bootstrap !== 'undefined') {
        const inst = bootstrap.Modal.getInstance(hub) || bootstrap.Modal.getOrCreateInstance(hub);
        inst.hide();
    }
    setTimeout(() => {
        if (typeof actionCallback === 'function') actionCallback();
    }, 200);
};

window.openSettingsHubModal = function() {
    const modalEl = document.getElementById('settingsHubModal');
    if (!modalEl) return;
    if (typeof syncRentEaseProfileUI === 'function') syncRentEaseProfileUI();
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    } else {
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
    }
};
</script>
