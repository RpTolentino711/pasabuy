<!-- ==========================================================
     RentEase Screen 7: Live Delivery & Order Tracking
     UIDESIFNAPP.png Screen 7 (Standout Feature)
     ========================================================== -->
<div id="tabTrack" style="display:none;">

    <!-- Header Bar -->
    <div class="d-flex align-items-center justify-content-between mb-2 pb-1">
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:34px; height:34px; background:#fff;" onclick="switchTab('home')">
            <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
        </button>
        <h5 class="fw-extrabold mb-0 text-dark fs-6">Track Order</h5>
        <div style="width:34px;"></div>
    </div>

    <!-- Order Code & Details Header Banner -->
    <div class="d-flex align-items-center justify-content-between px-1 mb-3">
        <span class="fw-extrabold text-dark fs-7" id="trackOrderCodeTitle">Order #RE-10245</span>
        <a href="javascript:void(0)" class="fs-9 fw-bold text-decoration-none" style="color: #5B3FA8;" onclick="toggleOrderItemsModal()">Details</a>
    </div>

    <!-- Vertical Timeline Stages (Matching Screen 7) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3 position-relative">
        
        <!-- Stage 1: Order Confirmed -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" 
                     style="width:26px; height:26px; background:#10B981; font-size:0.75rem; z-index:2;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-grow-1" style="width:2px; background:#10B981; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-extrabold text-dark fs-8 mb-0">Order Confirmed</h6>
                <div class="fs-9 text-muted">May 25, 2026 • 10:30 AM</div>
            </div>
        </div>

        <!-- Stage 2: Preparing Equipment -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" 
                     style="width:26px; height:26px; background:#10B981; font-size:0.75rem; z-index:2;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-grow-1" style="width:2px; background:#10B981; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-extrabold text-dark fs-8 mb-0">Preparing Equipment</h6>
                <div class="fs-9 text-muted">May 25, 2026 • 12:00 PM</div>
            </div>
        </div>

        <!-- Stage 3: Pickup -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" 
                     style="width:26px; height:26px; background:#10B981; font-size:0.75rem; z-index:2;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-grow-1" style="width:2px; background:#5B3FA8; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-extrabold text-dark fs-8 mb-0">Pickup</h6>
                <div class="fs-9 text-muted">May 25, 2026 • 2:00 PM</div>
            </div>
        </div>

        <!-- Stage 4: On the Way (Active with delivery truck icon) -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" 
                     style="width:28px; height:28px; background:#5B3FA8; font-size:0.8rem; z-index:2;">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="flex-grow-1" style="width:2px; background:#E2E8F0; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-extrabold text-dark fs-8 mb-0" style="color: #5B3FA8 !important;">On the Way</h6>
                <div class="fs-9 fw-semibold text-primary" style="color: #5B3FA8 !important;" id="trackEstimatedArrivalText">Estimated Arrival: 4:30 PM</div>
            </div>
        </div>

        <!-- Stage 5: Delivered -->
        <div class="d-flex gap-3 position-relative">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     style="width:26px; height:26px; background:#fff; font-size:0.75rem; z-index:2;" id="stageDeliveredCircle">
                    <i class="fa-regular fa-circle"></i>
                </div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-muted fs-8 mb-0" id="stageDeliveredText">Delivered</h6>
                <div class="fs-9 text-muted" id="stageDeliveredSub">Pending destination handover</div>
            </div>
        </div>

    </div>

    <!-- Live Interactive Leaflet Delivery Route Map (Screen 7) -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-3 bg-white">
        <div id="renteaseTrackMap" style="width:100%; height:190px; z-index:1;"></div>
    </div>

    <!-- Assigned Driver Card: Juan Dela Cruz (Screen 7) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white d-flex flex-row align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center gap-2.5">
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" 
                     class="rounded-circle border border-2 border-white shadow-2xs" width="44" height="44" style="object-fit:cover;" id="trackRiderAvatar">
                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:11px; height:11px;"></span>
            </div>
            <div>
                <h6 class="fw-extrabold text-dark fs-8 mb-0" id="trackRiderName">Juan Dela Cruz</h6>
                <span class="fs-9 text-muted" id="trackRiderRole">Delivery Rider</span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="tel:09187654321" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
               style="width:36px; height:36px; background:#F1F5F9; color:#5B3FA8;" id="trackCallRiderBtn" title="Call Rider">
                <i class="fa-solid fa-phone fs-8"></i>
            </a>
            <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                    style="width:36px; height:36px; background:#F1F5F9; color:#5B3FA8;" onclick="alert('💬 RentEase Messenger: Driver is 1.2 km away from your location.')" title="Chat Rider">
                <i class="fa-solid fa-comment fs-8"></i>
            </button>
        </div>
    </div>

</div>
