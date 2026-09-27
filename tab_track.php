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

    <!-- Stock Owner Equipment Preparation & Action Hub -->
    <div class="card border-0 rounded-4 shadow-sm p-3 mb-3" id="stockOwnerTrackActionCard" style="background: linear-gradient(135deg, #FAF5FF 0%, #F3E8FF 100%); border: 1.5px solid #D8B4FE !important;">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" style="width:32px; height:32px; background:linear-gradient(135deg, #5B3FA8, #341F97);">
                    <i class="fa-solid fa-boxes-packing fs-8"></i>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0">Stock Owner Action Hub</h6>
                    <span class="fs-9 text-muted" id="stockOwnerActionSub">Equipment Preparation & Handover</span>
                </div>
            </div>
            <span class="badge rounded-pill bg-primary fw-bold fs-9" id="stockOwnerCurrentBadge">CONFIRMED</span>
        </div>
        <p class="fs-9 text-dark mb-2.5" id="stockOwnerActionInstruction">
            As the equipment stock owner, inspect and package the items before calling a rider.
        </p>
        <div id="stockOwnerTrackBtnContainer">
            <!-- Dynamic action buttons rendered via openTrackScreen -->
        </div>
        <div class="mt-2 text-center">
            <a href="javascript:void(0)" onclick="if(typeof switchProfileSubTab==='function') switchProfileSubTab('requests'); switchTab('profile');" class="fs-9 fw-bold text-decoration-none" style="color:#5B3FA8;">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Open Stock Owner Lender Dashboard
            </a>
        </div>
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

    <!-- Verified Proof of Pickup Card (Shown on ON_THE_WAY, DELIVERED, RETURNED) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3" id="proofOfPickupCard" style="display:none; border-left: 4px solid #F59E0B !important;">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-box-archive text-warning fs-6"></i>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0">Proof of Package Pickup</h6>
                    <span class="fs-9 text-muted" id="pickupProofTime">Verified Hub Collection</span>
                </div>
            </div>
            <span class="badge bg-warning bg-opacity-10 text-dark fw-bold fs-9">PICKED UP</span>
        </div>
        <div class="rounded-3 overflow-hidden mb-2 text-center bg-light border" style="max-height: 180px;">
            <img id="pickupProofPhotoImg" src="" alt="Proof of Pickup" class="w-100 object-fit-cover" style="max-height: 180px; display:none;">
        </div>
        <div class="p-2 rounded-3 bg-light border fs-9 text-dark mb-2">
            <div class="mb-1"><i class="fa-solid fa-motorcycle text-primary me-1"></i> Courier: <strong id="pickupProofRiderName">—</strong></div>
            <div id="pickupProofNote" class="text-secondary"><i class="fa-solid fa-quote-left text-muted me-1"></i> Equipment inspected and collected safely.</div>
        </div>
        <div class="p-1.5 rounded-2 bg-success bg-opacity-10 text-success fs-9 text-center">
            <i class="fa-solid fa-envelope-circle-check me-1"></i> Pickup confirmation with photo has been emailed to the renter.
        </div>
    </div>

    <!-- Verified Shopee-Style Proof of Delivery Card (Shown on DELIVERED) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3" id="shopeeProofOfDeliveryCard" style="display:none; border-left: 4px solid #10B981 !important;">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check text-success fs-6"></i>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0">Proof of Delivery (Handover)</h6>
                    <span class="fs-9 text-muted" id="trackPodTime">Doorstep Handover Verified</span>
                </div>
            </div>
            <span class="badge bg-success bg-opacity-10 text-success fw-bold fs-9">HANDOVER VERIFIED</span>
        </div>
        <div class="rounded-3 overflow-hidden mb-2 text-center bg-light border" style="max-height: 180px;">
            <img id="trackPodPhotoImg" src="" alt="Proof of Delivery" class="w-100 object-fit-cover" style="max-height: 180px;">
        </div>
        <div class="p-2 rounded-3 bg-light border fs-9 text-dark mb-1.5">
            <div class="d-flex justify-content-between mb-1">
                <span><i class="fa-solid fa-user-check text-success me-1"></i> Recipient:</span>
                <strong id="trackPodRecipient">Verified Student</strong>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span><i class="fa-solid fa-motorcycle text-info me-1"></i> Delivery Rig:</span>
                <span id="trackPodVehiclePlate">Motorcycle • MC-8888-JY</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span><i class="fa-solid fa-id-badge text-primary me-1"></i> Courier:</span>
                <span id="trackPodRiderName">—</span>
            </div>
            <div id="trackPodNote" class="text-secondary mt-1 pt-1 border-top"><i class="fa-solid fa-quote-left text-muted me-1"></i> Package handed over safely.</div>
        </div>
    </div>

    <!-- Step 6: Renter "Item Received / Received Package" Action Card -->
    <div class="card border-0 rounded-4 shadow-sm p-3 mb-3" id="renterReceivedActionCard" style="display:none; background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); border: 1.5px solid #6EE7B7 !important;">
        <div id="renterUnconfirmedBox">
            <div class="d-flex align-items-center gap-2.5 mb-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" style="width:36px; height:36px; background:linear-gradient(135deg, #10B981, #059669); flex-shrink:0;">
                    <i class="fa-solid fa-box-open fs-7"></i>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0.5">Did you receive your equipment?</h6>
                    <span class="fs-9 text-muted">Confirm that the courier has handed over the package.</span>
                </div>
            </div>
            <button type="button" class="btn btn-success w-100 rounded-pill py-2.5 fw-extrabold fs-8 shadow-sm text-white" id="btnRenterConfirmReceived" onclick="renterConfirmReceivedPackage()">
                <i class="fa-solid fa-circle-check me-1.5"></i> I Have Received the Package
            </button>
        </div>
        <div id="renterConfirmedBox" style="display:none;">
            <div class="d-flex align-items-center gap-2.5 p-2 rounded-3 bg-white border border-success shadow-2xs">
                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                <div>
                    <h6 class="fw-extrabold text-success fs-8 mb-0">Item Received &amp; Verified by Renter</h6>
                    <span class="fs-9 text-muted" id="renterReceivedTimestampText">Active rental course is running.</span>
                </div>
            </div>
        </div>
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
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3" id="returnActionCard">
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

    <!-- Step Issue Reporting to Admin Card (Every step can be reported to the admin) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 mb-4" style="background: linear-gradient(135deg, #FFFDF5 0%, #FEF9C3 100%); border: 1.5px dashed #F59E0B !important;">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-warning shadow-2xs" style="width:34px; height:34px; background:#FEF3C7; flex-shrink:0;">
                    <i class="fa-solid fa-shield-halved fs-7 text-warning"></i>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0.5">Need Admin Assistance at this Step?</h6>
                    <span class="fs-9 text-muted" id="trackReportStepSub">File a direct report to RentEase Admin Operations</span>
                </div>
            </div>
            <button type="button" class="btn btn-warning text-dark rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs flex-shrink-0" 
                    style="width:34px; height:34px;" 
                    title="Report Step to Admin" 
                    aria-label="Report Step to Admin" 
                    onclick="openReportToAdminModal()">
                <i class="fa-solid fa-flag fs-8"></i>
            </button>
        </div>
        <p class="fs-9 text-dark mb-0">
            Every stage of this order is monitored live by Admin Operations. If you notice delayed pickup, damaged gear, or courier problems, report it now to trigger immediate admin intervention.
        </p>
    </div>

</div>

<!-- Report Issue to Admin at Current Step Modal -->
<div class="modal fade" id="reportToAdminModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-2xl overflow-hidden">
            <div class="modal-header border-0 pb-0" style="background:#FFFBEB;">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:36px; height:36px; background:linear-gradient(135deg, #F59E0B, #D97706);">
                        <i class="fa-solid fa-triangle-exclamation fs-7"></i>
                    </div>
                    <div>
                        <h6 class="fw-extrabold text-dark mb-0 fs-7">Report Step to Admin Operations</h6>
                        <span class="fs-9 text-muted" id="modalReportOrderSub">Order Incident Report</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 pt-2">
                <!-- Current Step Indicator -->
                <div class="p-2 rounded-3 mb-3 d-flex align-items-center justify-content-between" style="background:#F1F5F9; border: 1px solid #E2E8F0;">
                    <div class="fs-9 text-muted"><i class="fa-solid fa-clock-rotate-left me-1 text-primary"></i> Order Stage:</div>
                    <span class="badge bg-primary text-white fw-bold fs-9" id="modalReportCurrentStep">Step 1: Confirmed</span>
                </div>

                <div class="mb-2.5">
                    <label class="form-label fs-9 fw-bold text-dark mb-1">Issue Category / Reason <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" id="modalReportCategory">
                        <option value="Damage / Equipment Condition Issue" selected>Equipment Damaged / Defective / Missing Parts</option>
                        <option value="Pickup Delay / Courier No-Show">Courier Delay / Pickup No-Show</option>
                        <option value="Stock Owner Unresponsive">Stock Owner Unresponsive / Cancelled Handover</option>
                        <option value="Wrong Delivery Destination">Delivery Location / Address Issue</option>
                        <option value="Dispute on Handover">Dispute on Equipment Handover</option>
                        <option value="Payment / Platform Safety Concern">Payment or Platform Safety Concern</option>
                        <option value="Other Step Inquiry">Other Step Concern</option>
                    </select>
                </div>

                <div class="mb-2.5">
                    <label class="form-label fs-9 fw-bold text-dark mb-1">Subject Summary <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="modalReportSubject" placeholder="e.g. Courier late for pickup, damaged lens mount...">
                </div>

                <div class="mb-2.5">
                    <label class="form-label fs-9 fw-bold text-dark mb-1">Details &amp; Explanation <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-sm" id="modalReportDetails" rows="3" placeholder="Provide full details of what happened at this stage for the Admin team to investigate..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fs-9 fw-bold text-dark mb-1"><i class="fa-solid fa-camera me-1 text-secondary"></i> Attach Photo Evidence (Optional)</label>
                    <input type="file" class="form-control form-control-sm" id="modalReportPhotoFile" accept="image/*" onchange="previewReportPhoto(this)">
                    <div id="modalReportPhotoPreviewBox" class="mt-2 text-center rounded-3 overflow-hidden border bg-light" style="display:none; max-height:140px;">
                        <img id="modalReportPhotoImg" src="" style="max-height:140px; width:100%; object-fit:cover;">
                    </div>
                </div>

                <button type="button" class="btn btn-warning w-100 py-2.5 rounded-3 fw-extrabold fs-8 shadow-sm text-dark d-flex align-items-center justify-content-center gap-1.5" id="btnSubmitAdminReport" onclick="submitReportToAdmin()">
                    <i class="fa-solid fa-paper-plane"></i> Send Report to Admin
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Messenger-Styled Notify Rider Confirmation Modal -->
<div class="modal fade" id="notifyRiderConfirmModal" tabindex="-1" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 360px;">
        <div class="modal-content rounded-4 border-0 shadow-2xl overflow-hidden text-center position-relative">
            <!-- Messenger Header Accent Gradient -->
            <div style="height: 6px; background: linear-gradient(90deg, #00C6FF, #0078FF, #A033FF);"></div>
            <div class="modal-body p-4 pt-3">
                <!-- Messenger Icon with Arrow -->
                <div class="position-relative d-inline-block mb-2.5">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-lg mx-auto" 
                         style="width: 66px; height: 66px; background: linear-gradient(135deg, #00B2FE 0%, #006AFF 50%, #A033FF 100%);">
                        <i class="fa-solid fa-paper-plane fs-3" style="transform: rotate(15deg) translate(-2px, 2px);"></i>
                    </div>
                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-1" style="width:14px; height:14px;"></span>
                </div>
                
                <h6 class="fw-extrabold text-dark fs-7 mb-1" id="notifyRiderModalTitle">Notifying Rider</h6>
                <div class="d-inline-block badge rounded-pill bg-light text-primary border px-2.5 py-1 mb-2.5 fw-bold fs-9" id="notifyRiderModalBadge">
                    Order <span id="notifyRiderModalOrderCode">#RE-10245</span>
                </div>
                
                <p class="fs-8 text-secondary mb-3 px-1" id="notifyRiderModalPrompt">
                    Notifying rider: Are you sure you want to broadcast this pickup request to nearby fleet couriers?
                </p>
                
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-3 py-2 text-muted fw-bold fs-8 border flex-grow-1" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn text-white rounded-pill px-4 py-2 fw-extrabold fs-8 shadow-sm flex-grow-1 d-flex align-items-center justify-content-center gap-1.5" 
                            id="btnConfirmNotifyRiderGo"
                            style="background: linear-gradient(135deg, #0084FF 0%, #006AFF 100%); border: none;"
                            onclick="confirmNotifyRiderBroadcast()">
                        <span>Go</span>
                        <i class="fa-solid fa-paper-plane fs-9"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Rider Request Confirmation Modal -->
<div class="modal fade" id="cancelRiderRequestModal" tabindex="-1" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 360px;">
        <div class="modal-content rounded-4 border-0 shadow-2xl overflow-hidden text-center position-relative">
            <div style="height: 6px; background: linear-gradient(90deg, #EF4444, #F97316);"></div>
            <div class="modal-body p-4 pt-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-danger bg-danger-subtle mx-auto mb-2.5" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-ban fs-3"></i>
                </div>
                <h6 class="fw-extrabold text-dark fs-7 mb-1">Cancel Rider Request?</h6>
                <div class="d-inline-block badge rounded-pill bg-light text-danger border px-2.5 py-1 mb-2.5 fw-bold fs-9">
                    Order <span id="cancelRiderModalOrderCode">#RE-10245</span>
                </div>
                <p class="fs-8 text-secondary mb-3 px-1">
                    Are you sure? This will cancel the fleet broadcast and return the order to equipment packaging. You can request a rider again whenever you are ready.
                </p>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-3 py-2 text-muted fw-bold fs-8 border flex-grow-1" data-bs-dismiss="modal">
                        Keep Waiting
                    </button>
                    <button type="button" class="btn btn-danger rounded-pill px-3 py-2 fw-extrabold fs-8 shadow-sm flex-grow-1" 
                            id="btnConfirmCancelRider"
                            onclick="confirmCancelRiderRequest()">
                        Yes, Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

