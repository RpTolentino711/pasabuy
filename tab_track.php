<!-- ==========================================================
     RentEase Screen 7: Live Face-to-Face Rental Tracking
     Direct Stock Owner & Renter Campus Meetup (No Riders)
     ========================================================== -->
<div id="tabTrack" style="display:none;">

    <!-- Header Bar -->
    <div class="d-flex align-items-center justify-content-between mb-2 pb-1">
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:34px; height:34px; background:#fff;" onclick="switchTab('home')">
            <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
        </button>
        <h5 class="fw-extrabold mb-0 text-dark fs-6">Track Rental</h5>
        <div style="width:34px;"></div>
    </div>

    <!-- Order Code & Details Header Banner -->
    <div class="d-flex align-items-center justify-content-between px-1 mb-3">
        <span class="fw-extrabold text-dark fs-7" id="trackOrderCodeTitle">Order Tracking</span>
        <a href="javascript:void(0)" class="fs-9 fw-bold text-decoration-none" style="color: #5B3FA8;" onclick="toggleOrderItemsModal()">Details</a>
    </div>

    <!-- Stock Owner Action Hub (Only shown when viewer is Stock Owner) -->
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
            Inspect your equipment and chat with the student renter to agree on an on-campus meetup location and time.
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

    <!-- Direct Contact Partner Card (Renter sees Owner, Owner sees Renter) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3" id="trackPartnerCard">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2.5">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" 
                         class="rounded-circle border border-2 border-white shadow-2xs" width="44" height="44" style="object-fit:cover;" id="trackPartnerAvatar">
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:11px; height:11px;"></span>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0" id="trackPartnerName">Romeo Paolo Tolentino</h6>
                    <span class="fs-9 text-muted" id="trackPartnerRole">Equipment Owner • Verified Student</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="tel:09668257301" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                   style="width:36px; height:36px; background:#F1F5F9; color:#5B3FA8;" id="trackCallPartnerBtn" title="Call">
                    <i class="fa-solid fa-phone fs-8"></i>
                </a>
                <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                        style="width:36px; height:36px; background:#F1F5F9; color:#5B3FA8;" onclick="chatWithOwnerFromTracking()" id="trackChatPartnerBtn" title="Chat Directly">
                    <i class="fa-solid fa-comment-dots fs-8"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Campus Meetup Location & Coordination Card -->
    <div class="card border-0 rounded-4 shadow-sm p-3 mb-3 bg-white" style="border-left: 4px solid #5B3FA8 !important;">
        <div class="d-flex align-items-start gap-2.5">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs mt-0.5" 
                 style="width:32px; height:32px; background:linear-gradient(135deg, #5B3FA8, #341F97); flex-shrink:0;">
                <i class="fa-solid fa-location-dot fs-8"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <h6 class="fw-extrabold text-dark fs-8 mb-0">Campus Meetup Location</h6>
                    <span class="badge bg-purple bg-opacity-10 fw-bold fs-9" style="color:#5B3FA8;">FACE-TO-FACE</span>
                </div>
                <div class="fw-bold text-dark fs-8 mb-1" id="trackMeetupLocation">Campus CS Building / San Pablo Hub</div>
                <p class="fs-9 text-muted mb-2">
                    Both parties meet directly in person. Chat to agree on the exact meetup spot and time, then inspect the equipment together before handover.
                </p>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3 fw-bold fs-9" 
                        style="border-color:#5B3FA8; color:#5B3FA8;" onclick="chatWithOwnerFromTracking()">
                    <i class="fa-regular fa-comment-dots me-1"></i> Message to Coordinate Meetup
                </button>
            </div>
        </div>
    </div>

    <!-- Vertical Timeline Stages (Direct Face-to-Face Flow) -->
    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3 position-relative" id="trackTimelineContainer">
        
        <!-- Stage 1: Booking Confirmed -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" 
                     id="stageConfirmedCircle" style="width:26px; height:26px; background:#10B981; font-size:0.75rem; z-index:2;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-grow-1" id="stageConfirmedLine" style="width:2px; background:#10B981; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-extrabold text-dark fs-8 mb-0" id="stageConfirmedTitle">Booking Confirmed</h6>
                <div class="fs-9 text-muted" id="stageConfirmedTime">Order Verified &amp; Reserved</div>
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
                <h6 class="fw-bold text-dark fs-8 mb-0" id="stagePreparingTitle">Equipment Prepared</h6>
                <div class="fs-9 text-muted" id="stagePreparingTime">Stock owner packaging &amp; inspecting gear</div>
            </div>
        </div>

        <!-- Stage 3: Meetup & Handover Coordination -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     id="stagePickupCircle" style="width:26px; height:26px; background:#fff; font-size:0.75rem; z-index:2;">
                    <i class="fa-regular fa-circle"></i>
                </div>
                <div class="flex-grow-1" id="stagePickupLine" style="width:2px; background:#E2E8F0; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-dark fs-8 mb-0" id="stagePickupTitle">Campus Meetup &amp; Handover</h6>
                <div class="fs-9 text-muted" id="stagePickupTime">Coordinating face-to-face meeting on campus</div>
            </div>
        </div>

        <!-- Stage 4: Handed Over & Active Rental -->
        <div class="d-flex gap-3 position-relative mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     style="width:26px; height:26px; background:#fff; font-size:0.75rem; z-index:2;" id="stageDeliveredCircle">
                    <i class="fa-regular fa-circle"></i>
                </div>
                <div class="flex-grow-1" style="width:2px; background:#E2E8F0; min-height:26px; margin:2px 0;"></div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-muted fs-8 mb-0" id="stageDeliveredText">Handed Over &amp; Active Rental</h6>
                <div class="fs-9 text-muted" id="stageDeliveredSub">Equipment in renter care for rental course</div>
            </div>
        </div>

        <!-- Stage 5: Returned to Owner Stock -->
        <div class="d-flex gap-3 position-relative">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary" 
                     style="width:26px; height:26px; background:#fff; font-size:0.75rem; z-index:2;" id="stageReturnedCircle">
                    <i class="fa-regular fa-circle"></i>
                </div>
            </div>
            <div class="pt-0.5">
                <h6 class="fw-bold text-muted fs-8 mb-0" id="stageReturnedText">Returned &amp; Restocked</h6>
                <div class="fs-9 text-muted" id="stageReturnedSub">Face-to-face return completed &amp; gear restocked</div>
            </div>
        </div>

    </div>

    <!-- Renter Handover Receipt Confirmation Card -->
    <div class="card border-0 rounded-4 shadow-sm p-3 mb-3" id="renterReceivedActionCard" style="display:none; background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); border: 1.5px solid #6EE7B7 !important;">
        <div id="renterUnconfirmedBox">
            <div class="d-flex align-items-center gap-2.5 mb-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" style="width:36px; height:36px; background:linear-gradient(135deg, #10B981, #059669); flex-shrink:0;">
                    <i class="fa-solid fa-handshake fs-7"></i>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0.5">Did you meet and receive your equipment?</h6>
                    <span class="fs-9 text-muted">Confirm that you have met face-to-face and inspected the gear.</span>
                </div>
            </div>
            <button type="button" class="btn btn-success w-100 rounded-pill py-2.5 fw-extrabold fs-8 shadow-sm text-white" id="btnRenterConfirmReceived" onclick="renterConfirmReceivedPackage()">
                <i class="fa-solid fa-handshake me-1.5"></i> Confirm Face-to-Face Handover
            </button>
        </div>
        <div id="renterConfirmedBox" style="display:none;">
            <div class="d-flex align-items-center gap-2.5 p-2 rounded-3 bg-white border border-success shadow-2xs">
                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                <div>
                    <h6 class="fw-extrabold text-success fs-8 mb-0">Equipment Handover Verified</h6>
                    <span class="fs-9 text-muted" id="renterReceivedTimestampText">Active rental course is running.</span>
                </div>
            </div>
        </div>
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
            When your rental course is finished, meet the stock owner face-to-face on campus to return the equipment in good working condition.
        </p>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary rounded-3 py-2 px-3 fw-bold fs-8 flex-grow-1" 
                    style="border-color:#5B3FA8; color:#5B3FA8;" onclick="chatWithOwnerFromTracking()">
                <i class="fa-regular fa-comment-dots me-1"></i> Chat Owner for Return
            </button>
            <button type="button" class="btn btn-primary rounded-3 py-2 px-3 fw-bold fs-8 flex-grow-1" 
                    style="background: linear-gradient(135deg, #10B981, #059669); border:none;" 
                    id="btnDispatchReturn" onclick="dispatchReturnDelivery()">
                <i class="fa-solid fa-handshake me-1"></i> Meet &amp; Return to Owner
            </button>
        </div>
    </div>

    <!-- Step Issue Reporting to Admin Card -->
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
            Every stage of this order is monitored live by Admin Operations. If you notice damaged gear, missing accessories, or no-show at meetup, report it now for admin assistance.
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
                        <option value="Meetup Delay / No-Show">Meetup Delay / No-Show</option>
                        <option value="Stock Owner Unresponsive">Stock Owner Unresponsive / Cancelled Handover</option>
                        <option value="Dispute on Handover">Dispute on Equipment Handover</option>
                        <option value="Payment / Platform Safety Concern">Payment or Platform Safety Concern</option>
                        <option value="Other Step Inquiry">Other Step Concern</option>
                    </select>
                </div>

                <div class="mb-2.5">
                    <label class="form-label fs-9 fw-bold text-dark mb-1">Subject Summary <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="modalReportSubject" placeholder="e.g. Owner late for meetup, damaged lens mount...">
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
