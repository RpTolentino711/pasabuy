<!-- ==========================================================
     RentEase Screen 8: User Profile & Lender Portfolio
     Streamlined & Minimized Modern Profile UI
     ========================================================== -->
<div id="tabProfile" style="display:none;" class="pb-5">

    <style>
        .profile-nav-pills {
            background: #F1F5F9;
            border-radius: 999px;
            padding: 3px;
            border: 1px solid #E2E8F0;
        }
        .profile-subtab-btn {
            border-radius: 999px !important;
            padding: 5px 10px !important;
            font-size: 0.78rem !important;
            font-weight: 700 !important;
            border: none !important;
            transition: all 0.2s ease;
        }
        .profile-kpi-card {
            border-radius: 12px;
            padding: 8px 6px;
            transition: all 0.2s ease;
        }
    </style>

    <!-- User Profile Card (Compact & Minimized) -->
    <div class="card border-0 rounded-4 shadow-2xs p-2.5 px-3 bg-white mb-2 d-flex flex-row align-items-center justify-content-between border">
        <div class="d-flex align-items-center gap-2.5">
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&q=80" 
                     class="rounded-circle border border-2 border-white shadow-2xs" width="42" height="42" style="object-fit:cover;" id="profileAvatar" alt="Profile">
                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:10px; height:10px;"></span>
            </div>
            <div>
                <h6 class="fw-bold text-dark fs-8 mb-0" id="profileName">Campus Student</h6>
                <div class="text-muted d-flex align-items-center gap-1.5 flex-wrap" style="font-size:0.7rem;">
                    <span id="profileSub">College Student</span>
                    <span>•</span>
                    <span id="profileStudentNumber">ID: Loading...</span>
                </div>
                <div class="text-muted d-none" id="profileEmail"></div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs position-relative" 
                    id="btnProfileSettingsGear"
                    style="width:34px; height:34px; background:#F8FAFC; border:1px solid #E2E8F0;" 
                    data-bs-toggle="modal" data-bs-target="#settingsHubModal"
                    onclick="openSettingsHubModal()" title="Account & Settings Hub">
                <i class="fa-solid fa-gear text-secondary fs-8"></i>
                <span class="position-absolute top-0 start-100 translate-middle bg-danger border border-2 border-white rounded-circle badge-pulse-glow" 
                      id="settingsGearBadge" 
                      style="display:none; width:10px; height:10px; margin-top:2px; margin-left:-2px;"
                      title="Order Status Updated"></span>
            </button>
        </div>
    </div>

    <!-- 3 Profile Section Tabs (Compact Segmented Pill Bar) -->
    <div class="profile-nav-pills d-flex align-items-center mb-2.5 shadow-2xs gap-1">
        <!-- Subtab 1: Rental Requests / Incoming Orders -->
        <button type="button" class="btn btn-sm flex-grow-1 profile-subtab-btn active text-white d-flex align-items-center justify-content-center gap-1.5" 
                id="btnProfileTabRequests" 
                style="background: linear-gradient(135deg, #5B3FA8, #341F97); box-shadow: 0 2px 8px rgba(91, 63, 168, 0.25);" 
                onclick="switchProfileSubTab('requests')">
            <i class="fa-solid fa-bell fs-9"></i>
            <span>Requests</span>
            <span class="badge rounded-pill bg-danger text-white fw-bold ms-0.5 badge-pulse-glow" id="profileRequestsBadge" style="display:none; font-size:0.62rem; padding: 2px 5px;">0</span>
        </button>

        <!-- Subtab 2: Rent Items / Stock Inventory Monitoring -->
        <button type="button" class="btn btn-sm flex-grow-1 profile-subtab-btn text-secondary d-flex align-items-center justify-content-center gap-1.5" 
                id="btnProfileTabInventory" 
                style="background:transparent;" 
                onclick="switchProfileSubTab('inventory')">
            <i class="fa-solid fa-boxes-stacked fs-9"></i>
            <span>Rent Items</span>
            <span class="badge rounded-pill bg-primary-subtle text-primary fw-bold ms-0.5" id="myRentalCountBadge" style="font-size:0.62rem; padding: 2px 5px;">0</span>
        </button>

        <!-- Subtab 3: Rental History -->
        <button type="button" class="btn btn-sm flex-grow-1 profile-subtab-btn text-secondary d-flex align-items-center justify-content-center gap-1.5" 
                id="btnProfileTabHistory" 
                style="background:transparent;" 
                onclick="switchProfileSubTab('history')">
            <i class="fa-solid fa-clock-rotate-left fs-9"></i>
            <span>History</span>
        </button>
    </div>

    <!-- ==========================================================
         SUBTAB 1: RENTAL REQUESTS / INCOMING ORDERS FROM RENTERS
         ========================================================== -->
    <div id="profileSectionRequests" class="flex-column gap-2 pb-3" style="display:flex;">
        <!-- Compact Status Bar -->
        <div id="profileRequestsAlertBanner" class="p-2 px-3 rounded-pill bg-white border d-flex align-items-center justify-content-between shadow-2xs">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:24px; height:24px; background:linear-gradient(135deg, #5B3FA8, #341F97); font-size:0.7rem;">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <span class="fw-bold text-dark fs-8">Rental Bookings</span>
                <span class="text-muted d-none d-sm-inline" style="font-size:0.68rem;" id="profileRequestsSubtext">• Students asking to rent</span>
            </div>
            <div class="d-flex align-items-center gap-1 px-2 py-0.5 rounded-pill bg-success bg-opacity-10 border border-success-subtle">
                <span class="rounded-circle bg-success d-inline-block" style="width: 5px; height: 5px; box-shadow: 0 0 5px #10B981;"></span>
                <span class="fw-bold text-success" style="letter-spacing: 0.4px; font-size: 0.62rem;">LIVE</span>
            </div>
        </div>

        <!-- Dynamic Rental Orders Container -->
        <div id="ownerRequestsListContainer" class="d-flex flex-column gap-2">
            <div class="card border-0 rounded-4 shadow-2xs p-3.5 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-1.5" style="width:40px; height:40px; color:#5B3FA8;">
                    <i class="fa-solid fa-inbox fs-5"></i>
                </div>
                <h6 class="fw-bold text-dark fs-8 mb-0.5">No Active Rental Requests</h6>
                <p class="text-muted mb-0" style="font-size:0.72rem;">When students rent your equipment, orders appear here for you to accept, monitor, and dispatch.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================================
         SUBTAB 2: RENT ITEMS & STOCK INVENTORY MONITOR
         ========================================================== -->
    <div id="profileSectionInventory" class="flex-column gap-2 pb-3" style="display:none;">
        <!-- Compact Stock Overview KPI Bar -->
        <div class="card border-0 rounded-4 shadow-2xs p-2.5 px-3 bg-white border">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold text-dark fs-8">
                    <i class="fa-solid fa-chart-pie me-1" style="color:#5B3FA8;"></i> Equipment Stock Monitor
                </span>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-2.5 py-0.5 fw-bold d-flex align-items-center gap-1 shadow-2xs" 
                        id="headerPostEquipmentBtn"
                        style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none; font-size:0.72rem;" 
                        onclick="switchTab('sell')">
                    <i class="fa-solid fa-plus fs-9"></i> Post Equipment
                </button>
            </div>
            <div class="row g-1.5 text-center">
                <div class="col-4">
                    <div class="profile-kpi-card bg-light border">
                        <span class="text-muted d-block" style="font-size:0.68rem;">Total Owned</span>
                        <span class="fw-extrabold text-dark fs-7" id="kpiTotalStockOwned">0</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="profile-kpi-card bg-warning-subtle border border-warning-subtle">
                        <span class="text-dark d-block" style="font-size:0.68rem;">Rented Out</span>
                        <span class="fw-extrabold text-warning-emphasis fs-7" id="kpiTotalStockRented">0</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="profile-kpi-card bg-success-subtle border border-success-subtle">
                        <span class="text-dark d-block" style="font-size:0.68rem;">Ready to Rent</span>
                        <span class="fw-extrabold text-success fs-7" id="kpiTotalStockAvailable">0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Equipment Listings Container -->
        <div id="myRentalListingsContainer" class="d-flex flex-column gap-2">
            <div class="card border-0 rounded-4 shadow-2xs p-3.5 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-1.5" style="width:40px; height:40px; color:#5B3FA8;">
                    <i class="fa-solid fa-box-open fs-5"></i>
                </div>
                <h6 class="fw-bold text-dark fs-8 mb-0.5">No Equipment Posted for Rent Yet</h6>
                <p class="text-muted mb-0" style="font-size:0.72rem;">Rent out sound systems, chairs, tables, or cameras to earn daily rental income.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================================
         SUBTAB 3: RENTAL HISTORY & COMPLETED BOOKINGS
         ========================================================== -->
    <div id="profileSectionHistory" class="flex-column gap-2 pb-3" style="display:none;">
        <div class="d-flex align-items-center justify-content-between px-1 mb-1">
            <span class="fw-bold text-dark fs-8">
                <i class="fa-solid fa-clock-rotate-left me-1" style="color:#5B3FA8;"></i> Completed Returns & Rental Logs
            </span>
            <span class="badge bg-light text-secondary border fw-bold" id="historyCountBadge" style="font-size:0.68rem;">0 Records</span>
        </div>

        <!-- Dynamic Rental History Container -->
        <div id="ownerRentalHistoryContainer" class="d-flex flex-column gap-2">
            <div class="card border-0 rounded-4 shadow-2xs p-3.5 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-1.5 text-muted" style="width:40px; height:40px;">
                    <i class="fa-solid fa-receipt fs-5"></i>
                </div>
                <h6 class="fw-bold text-dark fs-8 mb-0.5">No Rental History Yet</h6>
                <p class="text-muted mb-0" style="font-size:0.72rem;">Completed equipment returns and rental receipts will be archived here.</p>
            </div>
        </div>
    </div>

</div>

<!-- ==========================================================
     EDIT EQUIPMENT PRICE & STOCK MODAL (OWNER ONLY)
     ========================================================== -->
<div class="modal fade" id="editRentalStockPriceModal" tabindex="-1" aria-labelledby="editRentalStockPriceModalLabel" aria-hidden="true" style="z-index: 1065;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-2 d-flex align-items-center justify-content-between">
                <h6 class="modal-title fw-bold text-dark fs-7 d-flex align-items-center gap-2 mb-0" id="editRentalStockPriceModalLabel">
                    <i class="fa-solid fa-sliders" style="color:#5B3FA8;"></i> Adjust Price & Stock
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-1">
                <div class="p-2 rounded-3 bg-light border mb-2.5">
                    <div class="fw-bold text-dark fs-8 text-truncate" id="modalEditItemTitle">Equipment Title</div>
                    <span class="text-muted" style="font-size:0.68rem;">Changes reflect immediately across live student search.</span>
                </div>

                <input type="hidden" id="modalEditItemId" value="0">

                <div class="mb-2.5">
                    <label class="form-label fw-bold text-dark fs-8 mb-1">
                        Daily Rental Price (₱ / day) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white fw-bold py-1 px-2.5 border-end-0 fs-8" style="border-radius:10px 0 0 10px; border-color:#E2E8F0; color:#5B3FA8 !important;">₱</span>
                        <input type="number" class="form-control fw-bold fs-7 text-dark py-1 border-start-0" id="modalEditItemPrice" min="1" step="1" style="border-radius:0 10px 10px 0; border-color:#E2E8F0;">
                    </div>
                </div>

                <div class="row g-2 mb-2.5">
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark fs-8 mb-1">
                            Available Stock <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control fw-bold fs-7 text-dark rounded-3 py-1" id="modalEditItemAvailStock" min="0" style="border-color:#E2E8F0;">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark fs-8 mb-1">
                            Total Units <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control fw-bold fs-7 text-dark rounded-3 py-1" id="modalEditItemTotalStock" min="1" style="border-color:#E2E8F0;">
                    </div>
                </div>

                <div class="p-2 rounded-3 border-0 bg-success-subtle text-success d-flex align-items-center gap-1.5" style="font-size:0.72rem;">
                    <i class="fa-solid fa-circle-check fs-8"></i>
                    <span>Rates & stock will sync immediately to live search.</span>
                </div>
            </div>
            <div class="modal-footer border-0 pt-2 d-flex gap-2">
                <button type="button" class="btn btn-light rounded-pill px-3 py-1 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-3.5 py-1 fs-8 fw-bold text-white shadow-2xs" 
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
     ========================================================== -->
<div class="modal fade" id="settingsHubModal" tabindex="-1" aria-labelledby="settingsHubModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-2 d-flex align-items-center justify-content-between">
                <h6 class="modal-title fw-bold text-dark fs-7 d-flex align-items-center gap-2 mb-0" id="settingsHubModalLabel">
                    <i class="fa-solid fa-gear" style="color:#5B3FA8;"></i> Account & Settings
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-1 px-1">
                <!-- User mini profile header with Edit button -->
                <div class="p-2.5 rounded-3 bg-light bg-opacity-75 mb-2.5 d-flex align-items-center justify-content-between border">
                    <div class="d-flex align-items-center gap-2">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" 
                             class="rounded-circle border border-2 border-white shadow-2xs" width="38" height="38" style="object-fit:cover;" id="settingsHubAvatar" alt="Profile">
                        <div>
                            <h6 class="fw-bold text-dark fs-8 mb-0" id="settingsHubName">Romeo Paolo Tolentino</h6>
                            <div class="text-muted" style="font-size:0.68rem;" id="settingsHubSub">BSIT • 4th Yr</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill py-0.5 px-2.5 fw-bold" style="font-size:0.72rem;" 
                            onclick="switchFromSettingsHub(openProfileSettingsModal)">
                        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                    </button>
                </div>

                <!-- Account Navigation Menu -->
                <div class="card border-0 rounded-3 shadow-2xs overflow-hidden bg-white border mb-1">
                    
                    <!-- My Orders -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom position-relative" 
                       id="settingsHubMyOrdersRow"
                       onclick="switchFromSettingsHub(openMyOrdersModal)">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center position-relative" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-receipt fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">My Orders</span>
                        </div>
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="badge rounded-pill bg-danger text-white fw-bold badge-pulse-glow" id="settingsMyOrdersBadge" style="display:none; font-size:0.65rem; padding:2px 6px;">
                                <i class="fa-solid fa-bell me-1"></i> Update
                            </span>
                            <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                        </div>
                    </a>

                    <!-- Purchase History -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub(openPurchaseHistoryModal)">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-regular fa-calendar-check fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Purchase History</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- Saved Addresses -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub(openSavedAddressesModal)">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-location-dot fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Saved Addresses</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- Payment Methods -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub(openPaymentMethodsModal)">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-regular fa-credit-card fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Payment Methods</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- Customer Support (Issue Center) -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub(openIssueReportingModal)">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-headset fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Customer Support</span>
                        </div>
                        <span class="badge rounded-pill bg-danger-subtle text-danger fw-bold" style="font-size:0.68rem;">Issue Center</span>
                    </a>

                    <!-- About RentEase -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub(openAboutRentEaseModal)">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-circle-info fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">About RentEase</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- Log Out -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none" 
                       onclick="switchFromSettingsHub(logoutRentEaseUser)">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-danger bg-opacity-10 d-flex align-items-center justify-content-center text-danger" style="width:30px; height:30px;">
                                <i class="fa-solid fa-arrow-right-from-bracket fs-8"></i>
                            </div>
                            <span class="fw-bold text-danger fs-8">Log Out</span>
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
