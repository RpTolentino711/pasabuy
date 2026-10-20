<!-- ==========================================================
     RentEase Screen 7: Live Face-to-Face Rental Tracking
     Ultra-Compact, Minimized, Modernized & Sleek
     ========================================================== -->
<div id="tabTrack" style="display:none;" class="pb-3">

    <style>
        /* Scoped Minimized Tracking UI Styles */
        .renttrack-header {
            background: #FFFFFF;
            border-bottom: 1px solid #ECEFF5;
            padding: 8px 12px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            margin-bottom: 10px;
        }
        .renttrack-back-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .renttrack-back-btn:hover {
            background: #EEF2FF;
            color: #4F46E5;
            border-color: #C7D2FE;
            transform: translateX(-1px);
        }
        .renttrack-details-btn {
            background: #FAF5FF;
            color: #6D28D9;
            border: 1px solid #E9D5FF;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .renttrack-details-btn:hover {
            background: #F3E8FF;
            color: #5B21B6;
            border-color: #D8B4FE;
        }

        /* Compact Partner Card */
        .renttrack-partner-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 10px 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            margin-bottom: 8px;
        }
        .renttrack-avatar-box {
            position: relative;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
        }
        .renttrack-avatar-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #E2E8F0;
            background: #F1F5F9;
        }
        .renttrack-online-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 9px;
            height: 9px;
            background: #10B981;
            border: 1.5px solid #FFFFFF;
            border-radius: 50%;
            box-shadow: 0 0 4px rgba(16, 185, 129, 0.6);
        }
        .renttrack-icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            color: #5B3FA8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .renttrack-icon-btn:hover {
            background: #EEF2FF;
            color: #4338CA;
            border-color: #C7D2FE;
            transform: translateY(-1px);
        }

        /* Compact Meetup Location Strip */
        .renttrack-meetup-card {
            background: linear-gradient(135deg, #FAF5FF 0%, #FFFFFF 100%);
            border: 1px solid #E9D5FF;
            border-left: 3.5px solid #6D28D9;
            border-radius: 12px;
            padding: 9px 12px;
            box-shadow: 0 2px 6px rgba(109, 40, 217, 0.04);
            margin-bottom: 8px;
        }
        .renttrack-meetup-icon-box {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, #6D28D9 0%, #5B21B6 100%);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(109, 40, 217, 0.25);
        }

        /* Compact Timeline */
        .renttrack-timeline-card {
            background: #FFFFFF;
            border: 1px solid #ECEFF5;
            border-radius: 14px;
            padding: 12px 14px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            margin-bottom: 8px;
        }
        .renttrack-step-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            position: relative;
        }
        .renttrack-step-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-shrink: 0;
        }
        .renttrack-step-circle,
        .renttrack-step-indicator > div:first-child {
            width: 22px !important;
            height: 22px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 0.65rem !important;
            z-index: 2 !important;
            flex-shrink: 0 !important;
            transition: all 0.25s ease !important;
        }
        .renttrack-step-line {
            width: 2px;
            background: #E2E8F0;
            min-height: 14px;
            margin: 2px 0;
            flex-grow: 1;
        }

        /* Compact Emergency Strip */
        .renttrack-help-strip {
            background: #FFFDF5;
            border: 1px dashed #FDE68A;
            border-radius: 10px;
            padding: 7px 10px;
            margin-bottom: 8px;
        }
        .renttrack-flag-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            color: #B45309;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            flex-shrink: 0;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .renttrack-flag-btn:hover {
            background: #FDE68A;
            color: #92400E;
            transform: scale(1.05);
        }
    </style>

    <!-- Unified Compact Header Bar (Back, Title, Order Ref, Details in one row) -->
    <div class="renttrack-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="renttrack-back-btn" onclick="switchTab('home')" title="Back to Home">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <div>
                <div class="fw-extrabold text-dark" style="font-size:0.86rem; line-height:1.2;">Track Rental</div>
                <div class="d-flex align-items-center gap-1.5 mt-0.5">
                    <span class="badge font-monospace fw-bold" style="background:#EDE9FE; color:#5B3FA8; font-size:0.65rem; padding:1px 6px;" id="trackOrderCodeTitle">Order Tracking</span>
                    <span class="text-muted" style="font-size:0.65rem;">• Live Status</span>
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" class="renttrack-details-btn" onclick="toggleOrderItemsModal()">
            <i class="fa-solid fa-receipt fs-9"></i>
            <span>Details</span>
        </a>
    </div>

    <!-- Stock Owner Action Hub (Only shown when viewer is Stock Owner) -->
    <div class="card border-0 rounded-4 shadow-sm p-2.5 mb-2" id="stockOwnerTrackActionCard" 
         style="display:none; background: linear-gradient(135deg, #FAF5FF 0%, #F3E8FF 100%); border: 1.5px solid #D8B4FE !important;">
        <div class="d-flex align-items-center justify-content-between mb-1.5">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" 
                     style="width:28px; height:28px; background:linear-gradient(135deg, #5B3FA8, #341F97); font-size:0.75rem;">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark mb-0" style="font-size:0.8rem;">Stock Owner Action</h6>
                    <span class="text-muted" style="font-size:0.68rem;" id="stockOwnerActionSub">Equipment Preparation &amp; Handover</span>
                </div>
            </div>
            <span class="badge rounded-pill bg-primary fw-bold" style="font-size:0.68rem;" id="stockOwnerCurrentBadge">CONFIRMED</span>
        </div>
        <p class="text-dark mb-2" style="font-size:0.72rem; line-height:1.35;" id="stockOwnerActionInstruction">
            Inspect your equipment and chat with the student renter to agree on an on-campus meetup location and time.
        </p>
        <div id="stockOwnerTrackBtnContainer">
            <!-- Dynamic action buttons rendered via openTrackScreen -->
        </div>
        <div class="mt-1.5 text-center">
            <a href="javascript:void(0)" onclick="if(typeof switchProfileSubTab==='function') switchProfileSubTab('requests'); switchTab('profile');" 
               class="fw-bold text-decoration-none" style="font-size:0.7rem; color:#5B3FA8;">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Open Stock Owner Dashboard
            </a>
        </div>
    </div>

    <!-- Direct Contact Partner Micro-Card (Renter sees Owner, Owner sees Renter) -->
    <div class="renttrack-partner-card" id="trackPartnerCard">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 min-w-0">
                <div class="renttrack-avatar-box">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" 
                         class="renttrack-avatar-img" 
                         id="trackPartnerAvatar"
                         onerror="this.src='https://ui-avatars.com/api/?name=User&background=5B3FA8&color=fff&bold=true&rounded=true';"
                         alt="Partner">
                    <span class="renttrack-online-dot"></span>
                </div>
                <div class="min-w-0">
                    <h6 class="fw-extrabold text-dark mb-0 text-truncate" style="font-size:0.82rem;" id="trackPartnerName">Partner</h6>
                    <span class="badge rounded-pill fw-semibold text-truncate d-inline-block mt-0.5" 
                          style="background:#F1F5F9; color:#475569; font-size:0.63rem; padding:2px 7px; max-width:180px;" 
                          id="trackPartnerRole">Equipment Owner • Verified Student</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-1.5 flex-shrink-0 ms-2">
                <a href="tel:09668257301" class="renttrack-icon-btn" id="trackCallPartnerBtn" title="Call Partner">
                    <i class="fa-solid fa-phone"></i>
                </a>
                <button type="button" class="renttrack-icon-btn" onclick="chatWithOwnerFromTracking()" id="trackChatPartnerBtn" title="Chat Partner">
                    <i class="fa-solid fa-comment-dots"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Campus Meetup Location & Coordination Card (Clean, Single Row, Zero Overlap) -->
    <div class="renttrack-meetup-card d-flex align-items-center justify-content-between gap-2.5">
        <div class="d-flex align-items-center gap-2 min-w-0">
            <div class="renttrack-meetup-icon-box">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="min-w-0">
                <div class="d-flex align-items-center gap-1 mb-0.5">
                    <span class="fw-extrabold text-muted text-uppercase" style="font-size:0.6rem; letter-spacing:0.5px;">Campus Handover Spot</span>
                    <span class="badge rounded-pill fw-bold" style="background:#EDE9FE; color:#6D28D9; font-size:0.6rem; padding:1px 5px;">FACE-TO-FACE</span>
                </div>
                <div class="fw-extrabold text-dark text-truncate" style="font-size:0.78rem;" id="trackMeetupLocation">Campus CS Building / San Pablo Hub</div>
            </div>
        </div>
        <button type="button" class="btn btn-sm rounded-pill fw-bold flex-shrink-0 px-2.5 py-1 d-flex align-items-center gap-1"
                style="background:#F3E8FF; color:#6D28D9; font-size:0.7rem; border:1px solid #DDD6FE;" 
                onclick="chatWithOwnerFromTracking()" title="Coordinate Meetup in Chat">
            <i class="fa-regular fa-comment-dots"></i>
            <span>Coordinate</span>
        </button>
    </div>

    <!-- Minimized Vertical Timeline Stages (Direct Face-to-Face Flow) -->
    <div class="renttrack-timeline-card" id="trackTimelineContainer">
        
        <!-- Stage 1: Booking Confirmed -->
        <div class="renttrack-step-row mb-2">
            <div class="renttrack-step-indicator">
                <div class="renttrack-step-circle text-white shadow-2xs" 
                     id="stageConfirmedCircle" style="background:#10B981;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="renttrack-step-line" id="stageConfirmedLine" style="background:#10B981;"></div>
            </div>
            <div class="pt-0.5 min-w-0">
                <h6 class="fw-extrabold text-dark mb-0" style="font-size:0.78rem;" id="stageConfirmedTitle">Booking Confirmed</h6>
                <div class="text-muted" style="font-size:0.68rem;" id="stageConfirmedTime">Order Verified &amp; Reserved</div>
            </div>
        </div>

        <!-- Stage 2: Preparing Equipment -->
        <div class="renttrack-step-row mb-2">
            <div class="renttrack-step-indicator">
                <div class="renttrack-step-circle border border-2 border-secondary text-secondary" 
                     id="stagePreparingCircle" style="background:#fff;">
                    <i class="fa-regular fa-circle"></i>
                </div>
                <div class="renttrack-step-line" id="stagePreparingLine" style="background:#E2E8F0;"></div>
            </div>
            <div class="pt-0.5 min-w-0">
                <h6 class="fw-bold text-dark mb-0" style="font-size:0.78rem;" id="stagePreparingTitle">Equipment Prepared</h6>
                <div class="text-muted" style="font-size:0.68rem;" id="stagePreparingTime">Stock owner packaging &amp; inspecting gear</div>
            </div>
        </div>

        <!-- Stage 3: Meetup & Handover Coordination -->
        <div class="renttrack-step-row mb-2">
            <div class="renttrack-step-indicator">
                <div class="renttrack-step-circle border border-2 border-secondary text-secondary" 
                     id="stagePickupCircle" style="background:#fff;">
                    <i class="fa-regular fa-circle"></i>
                </div>
                <div class="renttrack-step-line" id="stagePickupLine" style="background:#E2E8F0;"></div>
            </div>
            <div class="pt-0.5 min-w-0">
                <h6 class="fw-bold text-dark mb-0" style="font-size:0.78rem;" id="stagePickupTitle">Campus Meetup &amp; Handover</h6>
                <div class="text-muted" style="font-size:0.68rem;" id="stagePickupTime">Coordinating face-to-face meeting on campus</div>
            </div>
        </div>

        <!-- Stage 4: Handed Over & Active Rental -->
        <div class="renttrack-step-row mb-2">
            <div class="renttrack-step-indicator">
                <div class="renttrack-step-circle border border-2 border-secondary text-secondary" 
                     id="stageDeliveredCircle" style="background:#fff;">
                    <i class="fa-regular fa-circle"></i>
                </div>
                <div class="renttrack-step-line" style="background:#E2E8F0;"></div>
            </div>
            <div class="pt-0.5 min-w-0">
                <h6 class="fw-bold text-muted mb-0" style="font-size:0.78rem;" id="stageDeliveredText">Handed Over &amp; Active Rental</h6>
                <div class="text-muted" style="font-size:0.68rem;" id="stageDeliveredSub">Equipment in renter care for rental course</div>
            </div>
        </div>

        <!-- Stage 5: Returned to Owner Stock -->
        <div class="renttrack-step-row">
            <div class="renttrack-step-indicator">
                <div class="renttrack-step-circle border border-2 border-secondary text-secondary" 
                     id="stageReturnedCircle" style="background:#fff;">
                    <i class="fa-regular fa-circle"></i>
                </div>
            </div>
            <div class="pt-0.5 min-w-0">
                <h6 class="fw-bold text-muted mb-0" style="font-size:0.78rem;" id="stageReturnedText">Returned &amp; Restocked</h6>
                <div class="text-muted" style="font-size:0.68rem;" id="stageReturnedSub">Face-to-face return completed &amp; gear restocked</div>
            </div>
        </div>

    </div>

    <!-- Renter Handover Receipt Confirmation Card -->
    <div class="card border-0 rounded-4 shadow-sm p-2.5 mb-2" id="renterReceivedActionCard" 
         style="display:none; background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); border: 1.5px solid #6EE7B7 !important;">
        <div id="renterUnconfirmedBox">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" 
                     style="width:30px; height:30px; background:linear-gradient(135deg, #10B981, #059669); font-size:0.75rem;">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark mb-0.5" style="font-size:0.78rem;">Did you meet and receive your equipment?</h6>
                    <span class="text-muted" style="font-size:0.67rem;">Confirm face-to-face inspection &amp; receipt.</span>
                </div>
            </div>
            <button type="button" class="btn btn-success w-100 rounded-pill py-2 fw-extrabold text-white shadow-xs" 
                    style="font-size:0.78rem;" id="btnRenterConfirmReceived" onclick="renterConfirmReceivedPackage()">
                <i class="fa-solid fa-handshake me-1.5"></i> Confirm Face-to-Face Handover
            </button>
        </div>
        <div id="renterConfirmedBox" style="display:none;">
            <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border border-success shadow-2xs">
                <i class="fa-solid fa-circle-check text-success fs-6"></i>
                <div>
                    <h6 class="fw-extrabold text-success mb-0" style="font-size:0.78rem;">Equipment Handover Verified</h6>
                    <span class="text-muted" style="font-size:0.67rem;" id="renterReceivedTimestampText">Active rental course is running.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Equipment to Owner Action Card -->
    <div class="card border-0 rounded-4 shadow-sm p-2.5 bg-white mb-2" id="returnActionCard" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-1.5">
            <div class="d-flex align-items-center gap-1.5">
                <i class="fa-solid fa-rotate-left text-primary fs-8" style="color:#5B3FA8;"></i>
                <span class="fw-extrabold text-dark" style="font-size:0.78rem;">Rental Course Completion</span>
            </div>
            <span class="badge bg-secondary-subtle text-secondary" style="font-size:0.65rem;" id="returnStatusBadge">Rental Active</span>
        </div>
        <p class="text-muted mb-2" style="font-size:0.7rem; line-height:1.3;">
            When your rental ends, meet face-to-face on campus to return the gear in good condition.
        </p>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary rounded-pill py-1.5 px-3 fw-bold flex-grow-1" 
                    style="border-color:#5B3FA8; color:#5B3FA8; font-size:0.74rem;" onclick="chatWithOwnerFromTracking()">
                <i class="fa-regular fa-comment-dots me-1"></i> Chat Owner
            </button>
            <button type="button" class="btn btn-primary rounded-pill py-1.5 px-3 fw-bold flex-grow-1 text-white" 
                    style="background: linear-gradient(135deg, #10B981, #059669); border:none; font-size:0.74rem;" 
                    id="btnDispatchReturn" onclick="dispatchReturnDelivery()">
                <i class="fa-solid fa-handshake me-1"></i> Return Gear
            </button>
        </div>
    </div>

    <!-- Minimized Admin Assistance Strip -->
    <div class="renttrack-help-strip d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2 min-w-0">
            <i class="fa-solid fa-shield-halved text-warning fs-8 flex-shrink-0"></i>
            <div class="min-w-0">
                <div class="fw-extrabold text-dark text-truncate" style="font-size:0.72rem;">Need Admin Assistance at this step?</div>
                <div class="text-muted text-truncate" style="font-size:0.63rem;" id="trackReportStepSub">File an issue report directly to Admin Operations</div>
            </div>
        </div>
        <button type="button" class="renttrack-flag-btn" 
                title="Report Step to Admin" 
                aria-label="Report Step to Admin" 
                onclick="openReportToAdminModal()">
            <i class="fa-solid fa-flag"></i>
        </button>
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

                <button type="button" class="btn btn-warning w-100 py-2.5 rounded-3 fw-extrabold fs-8 text-dark d-flex align-items-center justify-content-center gap-1.5" id="btnSubmitAdminReport" onclick="submitReportToAdmin()">
                    <i class="fa-solid fa-paper-plane"></i> Send Report to Admin
                </button>
            </div>
        </div>
    </div>
</div>
