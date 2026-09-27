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
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3 position-relative" id="trackTimelineContainer">
        
        <!-- Stage 1: Order Confirmed -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" 
                     id="stageConfirmedCircle" style="width:26px; height:26px; background:#10B981; font-size:0.75rem; z-index:2;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-grow-1" id="stageConfirmedLine" style="width:2px; background:#10B981; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-extrabold text-dark fs-8 mb-0" id="stageConfirmedTitle">Order Confirmed</h6>
                <div class="fs-9 text-muted" id="stageConfirmedTime">Order Verified</div>
            </div>
        </div>

        <!-- Stage 2: Preparing Equipment -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     id="stagePreparingCircle" style="width:26px; height:26px; background:#fff; font-size:0.75rem; z-index:2;">
                    <i class="fa-regular fa-circle"></i>
                </div>
                <div class="flex-grow-1" id="stagePreparingLine" style="width:2px; background:#E2E8F0; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-dark fs-8 mb-0" id="stagePreparingTitle">Preparing Equipment</h6>
                <div class="fs-9 text-muted" id="stagePreparingTime">Stock owner packaging equipment</div>
            </div>
        </div>

        <!-- Stage 3: Pickup from Owner -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     id="stagePickupCircle" style="width:26px; height:26px; background:#fff; font-size:0.75rem; z-index:2;">
                    <i class="fa-regular fa-circle"></i>
                </div>
                <div class="flex-grow-1" id="stagePickupLine" style="width:2px; background:#E2E8F0; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-dark fs-8 mb-0" id="stagePickupTitle">Package Pickup</h6>
                <div class="fs-9 text-muted" id="stagePickupTime">Awaiting driver pickup from owner</div>
            </div>
        </div>

        <!-- Stage 4: On the Way (Out for Delivery) -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     id="stageOnTheWayCircle" style="width:28px; height:28px; background:#fff; font-size:0.8rem; z-index:2;">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="flex-grow-1" id="stageOnTheWayLine" style="width:2px; background:#E2E8F0; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-dark fs-8 mb-0" id="stageOnTheWayTitle">On the Way (Out for Delivery)</h6>
                <div class="fs-9 text-muted" id="trackEstimatedArrivalText">Estimated Arrival: Pending Pickup</div>
            </div>
        </div>

        <!-- Stage 5: Delivered & Active Rental -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     style="width:26px; height:26px; background:#fff; font-size:0.75rem; z-index:2;" id="stageDeliveredCircle">
                    <i class="fa-regular fa-circle"></i>
                </div>
                <div class="flex-grow-1" style="width:2px; background:#E2E8F0; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-muted fs-8 mb-0" id="stageDeliveredText">Delivered & Active Rental</h6>
                <div class="fs-9 text-muted" id="stageDeliveredSub">Equipment with renter for rental course</div>
            </div>
        </div>

        <!-- Stage 6: Return Delivery & Stock Restored -->
        <div class="d-flex gap-3 position-relative">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     style="width:26px; height:26px; background:#fff; font-size:0.75rem; z-index:2;" id="stageReturnedCircle">
                    <i class="fa-regular fa-circle"></i>
                </div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-muted fs-8 mb-0" id="stageReturnedText">Returned to Owner Stock</h6>
                <div class="fs-9 text-muted" id="stageReturnedSub">Delivered back to owner & inventory replenished</div>
            </div>
        </div>

    </div>

    <!-- Live Interactive Leaflet Delivery Route Map (Shown ONLY when package has been picked up by rider) -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-3 bg-white" id="renteaseTrackMapCard" style="display:none;">
        <div id="renteaseTrackMap" style="width:100%; height:190px; z-index:1;"></div>
    </div>

    <!-- Assigned Driver Card: Shown when rider is assigned / en route -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white d-flex flex-row align-items-center justify-content-between mb-3" id="trackRiderCard" style="display:none;">
        <div class="d-flex align-items-center gap-2.5">
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" 
                     class="rounded-circle border border-2 border-white shadow-2xs" width="44" height="44" style="object-fit:cover;" id="trackRiderAvatar">
                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:11px; height:11px;"></span>
            </div>
            <div>
                <h6 class="fw-extrabold text-dark fs-8 mb-0" id="trackRiderName">Assigned Driver</h6>
                <span class="fs-9 text-muted" id="trackRiderRole">Delivery Rider • Motorcycle</span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="tel:09187654321" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
               style="width:36px; height:36px; background:#F1F5F9; color:#5B3FA8;" id="trackCallRiderBtn" title="Call Rider">
                <i class="fa-solid fa-phone fs-8"></i>
            </a>
            <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                    style="width:36px; height:36px; background:#F1F5F9; color:#5B3FA8;" onclick="alert('💬 RentEase Courier Messenger: Driver is active.')" title="Chat Rider">
                <i class="fa-solid fa-comment fs-8"></i>
            </button>
        </div>
    </div>

    <!-- Rider Broadcast Status Card (When searching for nearby drivers) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 mb-3" id="riderBroadcastWaitingCard" style="display:none; background: #EFF6FF; border: 1px solid #BFDBFE !important;">
        <div class="d-flex align-items-center gap-2.5">
            <div class="rounded-circle d-flex align-items-center justify-content-center p-2 text-primary shadow-2xs" style="background:#DBEAFE; width:40px; height:40px; flex-shrink:0;">
                <i class="fa-solid fa-satellite-dish fa-beat text-primary fs-6"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="fw-extrabold text-dark fs-8 mb-0.5">Looking for Fleet Driver...</h6>
                <p class="fs-9 text-muted mb-0">Delivery request broadcasted across active motor riders. Nearby riders can review and accept this trip.</p>
            </div>
        </div>
    </div>

    <!-- Rider Cancelled Alert Card (Allows Stock Owner to Notify Riders Again) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 mb-3" id="riderCancelledAlertCard" style="display:none; background: #FFF1F2; border: 1px solid #FECDD3 !important;">
        <div class="d-flex align-items-start gap-2.5 mb-2.5">
            <div class="rounded-circle d-flex align-items-center justify-content-center p-2 text-danger shadow-2xs" style="background:#FFE4E6; width:38px; height:38px; flex-shrink:0;">
                <i class="fa-solid fa-triangle-exclamation text-danger fs-6"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="fw-extrabold text-danger fs-8 mb-0.5">Delivery Cancelled by Driver</h6>
                <p class="fs-9 text-dark mb-0" id="riderCancelledReasonText">The assigned driver cancelled pickup due to emergency / vehicle conflict. Package is safe at stock owner's inventory.</p>
            </div>
        </div>
        <button type="button" class="btn btn-warning w-100 rounded-3 py-2 fw-extrabold fs-8 text-dark shadow-sm" onclick="stockOwnerNotifyRidersAgain()">
            <i class="fa-solid fa-satellite-dish me-1"></i> Notify Delivery Riders Again
        </button>
    </div>

    <!-- Return Equipment to Owner Action Card -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-4" id="returnActionCard">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-rotate-left text-primary fs-7" style="color:#5B3FA8;"></i>
                <span class="fw-extrabold text-dark fs-8">Rental Course Completion</span>
            </div>
            <span class="badge bg-secondary-subtle text-secondary fs-9" id="returnStatusBadge">Rental Active</span>
        </div>
        <p class="fs-9 text-muted mb-2.5">
            When your rental course is finished, dispatch the return delivery. The courier will collect the equipment and deliver it back to the owner's stock inventory.
        </p>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary rounded-3 py-2 px-3 fw-bold fs-8 flex-grow-1" 
                    style="border-color:#5B3FA8; color:#5B3FA8;" onclick="chatWithOwnerFromTracking()">
                <i class="fa-regular fa-comment-dots me-1"></i> Chat Owner
            </button>
            <button type="button" class="btn btn-primary rounded-3 py-2 px-3 fw-bold fs-8 flex-grow-1" 
                    style="background: linear-gradient(135deg, #10B981, #059669); border:none;" 
                    id="btnDispatchReturn" onclick="dispatchReturnDelivery()">
                <i class="fa-solid fa-truck-ramp-box me-1"></i> Deliver Back to Owner
            </button>
        </div>
    </div>

</div>
