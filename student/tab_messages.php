<!-- ==========================================================
     RentEase: Modern Messages & Active Rental Chat System
     Ultra-Premium, Modernized Aesthetics & Seamless UX
     ========================================================== -->

<!-- MESSAGES TAB (PHP COMPONENT) -->
<div id="tabMessages" style="display:none;" class="pb-4">
    <style>
        /* Modern Chat & Messaging Styles */
        .rentchat-header-bar {
            background: #FFFFFF;
            border-bottom: 1px solid #ECEFF5;
            padding: 10px 14px;
            border-radius: 16px 16px 0 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }
        .rentchat-back-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.84rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .rentchat-back-btn:hover {
            background: #EEF2FF;
            color: #4F46E5;
            border-color: #C7D2FE;
            transform: translateX(-1px);
        }
        .rentchat-avatar-wrapper {
            position: relative;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
        }
        .rentchat-avatar-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #E0E7FF;
            background: #F8FAFC;
        }
        .rentchat-online-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 10px;
            height: 10px;
            background: #10B981;
            border: 2px solid #FFFFFF;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(16, 185, 129, 0.6);
        }
        .rentchat-report-btn {
            background: #FFF1F2;
            color: #E11D48;
            border: 1px solid #FFE4E6;
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 0.72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .rentchat-report-btn:hover {
            background: #FFE4E6;
            color: #BE123C;
            border-color: #FECDD3;
            transform: translateY(-1px);
        }

        /* Attached Equipment Card */
        .rentchat-item-card {
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }
        .rentchat-item-card:hover {
            border-color: #CBD5E1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Safety Banner */
        .rentchat-safety-banner {
            background: #FFFBEB;
            border: 1px solid #FEF3C7;
            border-left: 3.5px solid #F59E0B;
            border-radius: 10px;
        }
        .rentchat-safety-icon {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            background: #FDE68A;
            color: #B45309;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Rental Agreement Request Card */
        .rentchat-agreement-card {
            background: linear-gradient(135deg, #FAF5FF 0%, #EEF2FF 100%);
            border: 1.5px solid #C7D2FE !important;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.08);
            position: relative;
            overflow: hidden;
        }
        .rentchat-agreement-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #6366F1, #8B5CF6, #3B82F6);
        }
        .rentchat-card-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: #EDE9FE;
            color: #6D28D9;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .rentchat-overdue-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .rentchat-flex-row {
            display: flex;
            align-items: center;
        }
        .rentchat-badge-pending {
            background: #FEF3C7;
            color: #B45309;
            border: 1px solid #FDE68A;
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 0.68rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .rentchat-pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #F59E0B;
            box-shadow: 0 0 6px #F59E0B;
            animation: rentPulseDot 1.6s infinite ease-in-out;
        }
        @keyframes rentPulseDot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.4; }
        }
        .rentchat-specs-grid {
            background: #FFFFFF;
            border: 1px solid #ECEFF5;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }
        .rentchat-agree-btn {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            border: none;
            border-radius: 12px;
            color: #FFFFFF;
            font-weight: 800;
            font-size: 0.84rem;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
        }
        .rentchat-agree-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
            color: #FFFFFF;
        }
        .rentchat-agree-btn:active {
            transform: translateY(0);
        }
        .rentchat-waiting-box {
            background: #FFFFFF;
            border: 1px solid #FDE68A;
            box-shadow: 0 2px 6px rgba(245, 158, 11, 0.05);
        }
        .rentchat-spinner-ring {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #FFFBEB;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Ultra-Modern Live Countdown Timer Card */
        .rentchat-timer-card {
            background: linear-gradient(135deg, #1E1B4B 0%, #2E1065 100%);
            border-radius: 18px;
            border: 1px solid rgba(167, 139, 250, 0.25);
            box-shadow: 0 10px 25px -5px rgba(30, 27, 75, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.15);
            position: relative;
            overflow: hidden;
        }
        .rentchat-timer-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 130px;
            height: 130px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%);
            pointer-events: none;
        }
        .rentchat-live-pulse-ring {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .rentchat-live-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 8px #10B981;
            animation: rentPulseLive 1.4s infinite ease-in-out;
        }
        @keyframes rentPulseLive {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.3); }
        }
        .rentchat-timer-display-box {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.3);
        }
        .rentchat-countdown-digits {
            font-size: 1.35rem;
            color: #FBBF24;
            letter-spacing: 1px;
            text-shadow: 0 0 12px rgba(251, 191, 36, 0.3);
            line-height: 1.2;
        }
        .rentchat-timer-meta-grid {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }
        .rentchat-report-unreturned-btn {
            background: rgba(239, 68, 68, 0.2);
            color: #FCA5A5;
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 999px;
            padding: 4px 14px;
            font-size: 0.72rem;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .rentchat-report-unreturned-btn:hover {
            background: #EF4444;
            color: #FFFFFF;
            border-color: #EF4444;
        }

        /* OVERDUE RED STYLING: Triggers when rental timer runs out */
        .rentchat-timer-card.is-overdue {
            background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%) !important;
            border: 2px solid #EF4444 !important;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.25) !important;
            animation: rentPulseOverdueBorder 2s infinite ease-in-out;
        }
        .rentchat-timer-card.is-overdue::before {
            background: radial-gradient(circle, rgba(239, 68, 68, 0.5) 0%, transparent 70%) !important;
        }
        .rentchat-timer-card.is-overdue .rentchat-live-pulse-ring {
            background: rgba(239, 68, 68, 0.25) !important;
        }
        .rentchat-timer-card.is-overdue .rentchat-live-pulse {
            background: #EF4444 !important;
            box-shadow: 0 0 10px #EF4444 !important;
        }
        .rentchat-timer-card.is-overdue .rentchat-timer-display-box {
            background: rgba(69, 10, 10, 0.8) !important;
            border: 1px solid rgba(239, 68, 68, 0.5) !important;
        }
        @keyframes rentPulseOverdueBorder {
            0%, 100% { box-shadow: 0 10px 30px rgba(220, 38, 38, 0.45); }
            50% { box-shadow: 0 10px 42px rgba(239, 68, 68, 0.85); }
        }

        #chatView.is-overdue {
            background: #FFF5F5 !important;
        }
        #chatView.is-overdue .rentchat-header-bar,
        .rentchat-header-bar.is-overdue {
            border-bottom: 2.5px solid #EF4444 !important;
            background: #FEE2E2 !important;
        }
        #chatView.is-overdue #chatStream {
            background: linear-gradient(180deg, rgba(254, 226, 226, 0.45) 0%, rgba(255, 255, 255, 0.85) 140px) !important;
        }

        /* OVERDUE RED CONVERSATION CARD */
        .swipe-conv-card.is-overdue {
            background: #FFF5F5 !important;
            border: 2px solid #EF4444 !important;
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.28) !important;
            position: relative;
        }
        .swipe-conv-card.is-overdue::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
            background: #EF4444;
            border-radius: 16px 0 0 16px;
        }

        /* Chat Bubbles */
        .rentchat-bubble {
            max-width: 78%;
            padding: 9px 14px;
            font-size: 0.82rem;
            line-height: 1.45;
            word-break: break-word;
        }
        .rentchat-bubble-mine {
            background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
            color: #FFFFFF;
            border-radius: 18px 18px 4px 18px;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.2);
        }
        .rentchat-bubble-partner {
            background: #FFFFFF;
            color: #0F172A;
            border: 1px solid #E2E8F0;
            border-radius: 18px 18px 18px 4px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        /* Chat Input Bar */
        .rentchat-input-bar {
            border-top: 1px solid #ECEFF5;
            background: #FFFFFF;
            border-radius: 0 0 16px 16px;
        }
        .rentchat-textarea {
            resize: none;
            overflow-y: auto;
            max-height: 120px;
            min-height: 40px;
            border-radius: 20px;
            padding: 9px 16px;
            font-size: 0.84rem;
            line-height: 1.4;
            border: 1.5px solid #E2E8F0;
            background: #F8FAFC;
            transition: all 0.2s ease;
        }
        .rentchat-textarea:focus {
            background: #FFFFFF;
            border-color: #6366F1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
            outline: none;
        }
        .rentchat-send-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
            border: none;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.88rem;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .rentchat-send-btn:hover {
            transform: translateY(-1px) scale(1.04);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
            color: #FFFFFF;
        }
    </style>

    <div class="d-flex align-items-center justify-content-between mb-3 pt-1">
        <div>
            <h5 class="fw-bold mb-0 text-dark fs-6" style="letter-spacing:-0.2px;">Messages</h5>
            <span class="text-muted" style="font-size:0.7rem;">Campus Equipment Inquiries &amp; Handover</span>
        </div>
        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 fs-9 fw-bold border border-primary-subtle">
            <i class="fa-solid fa-comments me-1"></i> Active Chats
        </span>
    </div>

    <!-- Chat Conversations List (Messenger Heads) -->
    <div id="conversationHeadsList" class="d-flex flex-column gap-2">
        <div class="text-center py-5 text-muted fs-8 bg-white rounded-4 border p-4 shadow-2xs">
            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width:48px; height:48px; color:#6366F1;">
                <i class="fa-solid fa-comments fs-4"></i>
            </div>
            <h6 class="fw-bold text-dark fs-8 mb-1">No Active Conversations</h6>
            <p class="text-muted mb-0" style="font-size:0.74rem;">Tap <strong>Message</strong> on any equipment listing to coordinate with verified student lenders.</p>
        </div>
    </div>
</div>

<!-- CHAT VIEW (SUB-SCREEN) -->
<div id="chatView" style="display:none; height:100%; flex-direction:column;">
    
    <!-- Modern Chat Header -->
    <div class="rentchat-header-bar d-flex align-items-center justify-content-between mb-2 flex-shrink-0">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="rentchat-back-btn" onclick="closeChat()" title="Back to Messages">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <div class="rentchat-avatar-wrapper">
                <img id="chatHeaderAvatar" src="https://ui-avatars.com/api/?name=Student&background=6366F1&color=fff&bold=true&rounded=true"
                     class="rentchat-avatar-img" 
                     onerror="this.src='https://ui-avatars.com/api/?name=User&background=6366F1&color=fff&bold=true&rounded=true';"
                     alt="Chat Avatar">
                <span class="rentchat-online-dot"></span>
            </div>
            <div>
                <div class="fw-extrabold text-dark" style="font-size:0.86rem; letter-spacing:-0.2px; line-height:1.2;" id="chatPartnerName">Student</div>
                <div class="d-flex align-items-center gap-1 mt-0.5">
                    <span class="badge rounded-pill fw-bold" style="background:#ECFDF5; color:#059669; font-size:0.62rem; padding: 2px 6px; border:1px solid #A7F3D0;" id="chatPartnerRoleBadge">
                        <i class="fa-solid fa-circle-check me-0.5"></i>Stock Owner &amp; Lender
                    </span>
                    <span class="text-muted" style="font-size:0.65rem;">• Active Now</span>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-1">
            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1" id="chatHeaderDeleteBtn" onclick="initiateDeleteCurrentChatConversation()" style="font-size:0.72rem; display:none;" title="Delete this conversation safely">
                <i class="fa-solid fa-trash-can me-1"></i> Delete
            </button>
            <button type="button" class="rentchat-report-btn" onclick="openReportModal()" title="Report user or issue">
                <i class="fa-solid fa-shield-halved fs-9"></i> Report
            </button>
        </div>
    </div>

    <!-- Attached Equipment Banner (Never broken, elegant layout) -->
    <div class="rentchat-item-card p-2.5 mb-2 d-flex align-items-center justify-content-between flex-shrink-0">
        <div class="d-flex align-items-center gap-2.5 min-w-0">
            <div class="position-relative flex-shrink-0">
                <img id="chatItemImage" src="" 
                     class="rounded-circle border" 
                     style="width:44px; height:44px; border-radius:50%; object-fit:cover; display:none;"
                     onload="this.style.display='block'; document.getElementById('chatItemThumbFallback').style.display='none';"
                     onerror="this.style.display='none'; document.getElementById('chatItemThumbFallback').style.display='flex';"
                     alt="Item Thumbnail">
                <div id="chatItemThumbFallback" class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg, #EDE9FE, #DDD6FE); color:#6D28D9; font-size:1.1rem; border:1px solid #C4B5FD;">
                    <i class="fa-solid fa-cube"></i>
                </div>
            </div>
            <div class="min-w-0">
                <div class="d-flex align-items-center gap-1.5 mb-0.5 flex-wrap">
                    <span class="badge rounded-pill fw-bold" style="background:#EDE9FE; color:#5B3FA8; font-size:0.62rem; padding: 2px 6px;">EQUIPMENT</span>
                    <span class="badge rounded-pill fw-bold" id="chatItemOwnershipBadge" style="display:none; font-size:0.62rem; padding: 2px 7px;"></span>
                    <span class="text-muted fw-semibold" style="font-size:0.65rem; display:none;" id="chatItemOwnerLabel"></span>
                </div>
                <h6 class="fw-bold fs-8 text-dark mb-0 text-truncate" id="chatItemTitle">Campus Item</h6>
                <div class="d-flex align-items-baseline gap-1">
                    <span class="fw-extrabold text-primary fs-7" id="chatItemPrice">₱0.00</span>
                    <span class="text-muted" style="font-size:0.68rem;">/ day</span>
                </div>
            </div>
        </div>
        <div class="flex-shrink-0 ms-2 d-flex flex-column align-items-end gap-1">
            <span class="badge rounded-pill fw-bold" id="chatHeaderStepBadge" style="background:#EDE9FE; color:#5B3FA8; font-size:0.68rem; padding: 4px 10px; border:1px solid #DDD6FE;">
                Step 1 of 4
            </span>
            <span class="badge rounded-pill px-2 py-0.5 fw-bold border" id="chatHeaderActionBadge" style="background:#F8FAFC; color:#64748B; font-size:0.62rem;">
                <i class="fa-solid fa-handshake me-1 text-primary"></i>In Chat
            </span>
        </div>
    </div>

    <!-- Safety Reminder -->
    <div class="rentchat-safety-banner p-2 px-2.5 mb-2 d-flex align-items-center gap-2 flex-shrink-0">
        <div class="rentchat-safety-icon">
            <i class="fa-solid fa-shield-halved fs-9"></i>
        </div>
        <div style="font-size:0.72rem; line-height:1.3; color:#92400E;">
            <strong>Campus Handover Safety:</strong> Meet in public campus spots &amp; inspect equipment before payment.
        </div>
    </div>

    <!-- ACTIVE RENTAL REQUEST & ACTION BANNER (Dynamic & Clean) -->
    <div id="chatRentalRequestBanner" class="rentchat-agreement-card p-3 mb-2 flex-shrink-0" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-indigo-subtle">
            <div class="d-flex align-items-center gap-2">
                <div class="rentchat-card-icon-box">
                    <i class="fa-solid fa-handshake-simple fs-8"></i>
                </div>
                <div>
                    <div class="fw-extrabold text-dark" style="font-size:0.82rem; letter-spacing:-0.2px;">Rental Agreement Request</div>
                    <div class="text-muted" style="font-size:0.65rem;">Campus Handover &amp; Inspection Terms</div>
                </div>
            </div>
            <span class="rentchat-badge-pending" id="chatRentalReqStatusBadge">
                <span class="rentchat-pulse-dot"></span>
                <span>Pending Approval</span>
            </span>
        </div>

        <!-- Specs Grid -->
        <div class="rentchat-specs-grid p-2.5 rounded-3 mb-2.5">
            <div class="d-flex align-items-center justify-content-between py-1 border-bottom border-light">
                <span class="text-muted fw-semibold fs-9 d-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-hashtag text-primary opacity-75"></i> Order Ref
                </span>
                <span class="badge bg-light text-dark border fw-extrabold font-monospace px-2 py-0.5 fs-9" id="chatReqOrderCode">#RE-10000</span>
            </div>
            <div class="d-flex align-items-center justify-content-between py-1 border-bottom border-light">
                <span class="text-muted fw-semibold fs-9 d-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-calendar-days text-primary opacity-75"></i> Duration
                </span>
                <span class="fw-bold text-dark fs-9 text-end" id="chatReqDatesText">Oct 16 – Oct 17 (1 Day)</span>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-1">
                <span class="text-muted fw-semibold fs-9 d-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-coins text-primary opacity-75"></i> Rental Fee
                </span>
                <div class="text-end">
                    <span class="fw-extrabold text-primary fs-7" id="chatReqTotalText">₱0.00</span>
                    <span class="text-muted" style="font-size:0.68rem;">(Cash on Handover)</span>
                </div>
            </div>
        </div>

        <!-- RENTAL CANCELLED BANNER (Shown when order_status === 'CANCELLED') -->
        <div id="chatRentalCancelledBanner" style="display:none !important;" class="alert alert-danger p-2.5 rounded-3 mb-2 text-start border-danger shadow-xs">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <div class="d-flex align-items-center gap-1.5 text-danger fw-extrabold fs-8">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <span>Rental Agreement Cancelled</span>
                </div>
                <span class="badge bg-danger text-white" style="font-size:0.62rem;">Cancelled</span>
            </div>
            <div class="text-dark fw-bold mb-1" style="font-size:0.73rem;" id="chatCancelledByText">Cancelled by counterparty</div>
            <div class="bg-white p-2 rounded-2 border border-danger-subtle text-secondary fst-italic" style="font-size:0.68rem;" id="chatCancelledReasonText">"Reason..."</div>
        </div>

        <!-- STEP PROGRESS INDICATOR -->
        <div id="chatLifecycleProgressIndicator" class="d-flex align-items-center justify-content-between px-1 mb-2.5 pb-2 border-bottom border-indigo-subtle" style="font-size:0.68rem;">
            <span class="fw-bold text-dark d-flex align-items-center gap-1.5">
                <i class="fa-solid fa-list-check text-primary"></i> Handover Lifecycle
            </span>
            <span class="badge rounded-pill fw-bold" id="chatLifecycleStepPill" style="background:#EDE9FE; color:#5B3FA8; font-size:0.65rem;">
                Step 1 of 4
            </span>
        </div>

        <!-- STEP 1: BOOKING CONFIRMATION -->
        <div id="chatStep1Row" style="display:none !important;" class="mb-2">
            <!-- Owner View: Agree to Rent (STRICTLY SHOWN ONLY TO STOCK OWNER) -->
            <div id="chatStep1OwnerBox" style="display:none !important;">
                <button type="button" class="btn rentchat-agree-btn w-100 py-2.5 fw-extrabold d-flex align-items-center justify-content-center gap-2 shadow-sm" 
                        id="btnStep1Agree" onclick="executeStep1Agree()">
                    <i class="fa-solid fa-handshake-simple fs-8"></i>
                    <span>Agree to Rent Equipment</span>
                </button>
                <div class="text-center text-muted mt-1.5" style="font-size:0.68rem;">
                    <i class="fa-solid fa-shield-halved text-success me-1"></i> Confirm request to unlock equipment preparation
                </div>
            </div>
            <!-- Renter View: Waiting for Owner Agreement -->
            <div id="chatStep1RenterBox" style="display:none !important;" class="rentchat-waiting-box p-3 rounded-3 d-flex align-items-center gap-2.5">
                <div class="rentchat-spinner-ring">
                    <i class="fa-solid fa-hourglass-half text-warning fs-8 fa-spin-pulse"></i>
                </div>
                <div style="font-size:0.72rem;">
                    <div class="fw-bold text-dark d-flex align-items-center gap-1.5">
                        Awaiting Stock Owner Confirmation
                        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning-subtle px-1.5 py-0.2" style="font-size:0.6rem;">Pending</span>
                    </div>
                    <div class="text-muted mt-0.5">Stock owner is reviewing your rental booking. You will be notified once agreed.</div>
                </div>
            </div>
        </div>

        <!-- STEP 2: EQUIPMENT PREPARATION & PHOTO PROOF -->
        <div id="chatStep2Row" style="display:none !important;" class="mb-2">
            <!-- Owner View: Upload Preparation Photo OR Waiting for Renter Approval -->
            <div id="chatStep2OwnerBox" style="display:none !important;">
                <!-- Sub-state A: Upload Photo (Initial or Re-upload after renter feedback) -->
                <div id="chatStep2OwnerUploadBox" style="display:block;">
                    <div class="p-2.5 rounded-3 border bg-light mb-2 text-start">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="fw-bold text-dark fs-9"><i class="fa-solid fa-camera text-primary me-1"></i> Step 2: Equipment Preparation Photo</div>
                            <span class="badge bg-warning text-dark" id="chatStep2AttemptBadgeOwner" style="font-size:0.62rem;">Attempt 1 of 3</span>
                        </div>

                        <!-- Feedback banner if renter requested another photo -->
                        <div id="chatStep2OwnerFeedbackAlert" style="display:none !important;" class="alert alert-warning py-2 px-2.5 mb-2 rounded-3 border-warning shadow-2xs">
                            <div class="d-flex align-items-center gap-1.5 fw-bold text-warning-emphasis" style="font-size:0.72rem;">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Renter Feedback (<span id="chatStep2FeedbackAttemptNum">Attempt 1</span>):</span>
                            </div>
                            <div id="chatStep2FeedbackText" class="mt-1 text-dark fw-medium fst-italic bg-white p-2 rounded-2 border border-warning-subtle" style="font-size:0.7rem;">
                                "Photo is blurry, please show the lens clearly."
                            </div>
                            <div class="text-secondary mt-1" style="font-size:0.65rem;">
                                Please upload another photo addressing the renter's notes above.
                            </div>
                        </div>

                        <div class="text-muted" style="font-size:0.68rem;">Inspect the equipment and upload a condition photo proof before meeting the renter:</div>
                        <div class="mt-2 d-flex gap-2 align-items-center">
                            <input type="file" id="prepPhotoFileInput" accept="image/*" class="d-none" onchange="handlePrepPhotoUpload(event)">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fs-9 fw-bold" onclick="document.getElementById('prepPhotoFileInput').click()">
                                <i class="fa-solid fa-upload me-1"></i> Choose / Take Photo
                            </button>
                            <span id="prepPhotoNameLabel" class="text-muted fs-9 text-truncate" style="max-width:140px;">No photo selected</span>
                        </div>
                        <div id="prepPhotoPreviewWrap" style="display:none !important;" class="mt-2 text-center">
                            <img id="prepPhotoPreviewImg" src="" class="rounded-3 border" style="max-height:100px; max-width:100%; object-fit:contain;">
                        </div>
                    </div>
                    <button type="button" class="btn rentchat-agree-btn w-100 py-2 fw-extrabold" id="btnSubmitPrepPhoto" onclick="executeStep2SubmitPhoto()" disabled>
                        <i class="fa-solid fa-paper-plane me-1"></i> <span id="btnSubmitPrepPhotoText">Submit Preparation Photo</span>
                    </button>
                    <!-- Owner Cancellation Button (Unlocks if attempts >= 3) -->
                    <div id="btnOwnerCancelStep2Wrap" style="display:none;" class="mt-2 text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 rounded-pill py-1.5 fw-bold" style="font-size:0.74rem;" onclick="openStep2CancelModal('OWNER')">
                            <i class="fa-solid fa-ban me-1"></i> Cancel Rental (3 Attempts Reached)
                        </button>
                    </div>
                </div>

                <!-- Sub-state B: Waiting for Renter Approval (After successful submit) -->
                <div id="chatStep2OwnerWaiting" style="display:none !important;" class="rentchat-waiting-box p-3 rounded-3 text-start mb-2" style="background:#FFFDF5; border:1px solid #FDE68A;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                            <div>
                                <div class="fw-bold text-dark" style="font-size:0.76rem;">Waiting for Renter Approval</div>
                                <div class="text-muted" style="font-size:0.65rem;">Waiting for renter to approve if the item looks good</div>
                            </div>
                        </div>
                        <span class="badge bg-warning text-dark" id="chatStep2OwnerWaitingAttemptBadge" style="font-size:0.62rem;">Attempt 1 of 3</span>
                    </div>
                    <div class="text-center p-2 rounded-2 bg-white border mb-2">
                        <img id="chatStep2OwnerSubmittedThumb" src="" class="rounded-2 border" style="max-height:120px; max-width:100%; object-fit:contain;">
                        <div class="text-muted mt-1" style="font-size:0.63rem;">
                            <i class="fa-solid fa-circle-check text-success me-1"></i> Submitted condition photo proof
                        </div>
                    </div>
                    <div class="text-muted mb-1" style="font-size:0.66rem;">
                        <i class="fa-solid fa-circle-info text-primary me-1"></i> The student renter is inspecting your item photo. If they approve, you'll proceed to Step 3 (Set Campus Meetup Spot). If they request another photo, you will receive their feedback here.
                    </div>
                    <!-- Owner Cancellation Button in Waiting State (Unlocks if attempts >= 3) -->
                    <div id="btnOwnerWaitingCancelStep2Wrap" style="display:none;" class="mt-2 text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 rounded-pill py-1.5 fw-bold" style="font-size:0.74rem;" onclick="openStep2CancelModal('OWNER')">
                            <i class="fa-solid fa-ban me-1"></i> Cancel Rental (3 Attempts Reached)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Renter View: Waiting or Inspecting Photo -->
            <div id="chatStep2RenterBox" style="display:none !important;">
                <!-- If photo not yet submitted by owner -->
                <div id="chatStep2RenterWaiting" style="display:none !important;" class="rentchat-waiting-box p-3 rounded-3 d-flex align-items-center gap-2.5">
                    <div class="rentchat-spinner-ring">
                        <i class="fa-solid fa-screwdriver-wrench text-warning fs-8"></i>
                    </div>
                    <div style="font-size:0.72rem;">
                        <div class="fw-bold text-dark">Equipment Being Prepared</div>
                        <div class="text-muted mt-0.5" id="chatStep2RenterWaitingText">Stock owner is inspecting and packaging your gear. Chat will unlock once preparation photo is submitted.</div>
                    </div>
                </div>
                <!-- If photo is submitted, renter inspects and clicks "Accept" or "Request Another Photo" -->
                <div id="chatStep2RenterAction" style="display:none !important;" class="p-2.5 rounded-3 border bg-light text-start">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="fw-bold text-dark fs-9"><i class="fa-solid fa-circle-check text-success me-1"></i> Equipment Ready - Review Photo</div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle" id="chatStep2AttemptBadgeRenter" style="font-size:0.62rem;">Attempt 1 of 3</span>
                    </div>
                    <div class="text-muted mb-2" style="font-size:0.68rem;">Stock owner submitted this photo of your gear:</div>
                    <div class="text-center mb-2">
                        <img id="chatPrepPhotoDisplayRenter" src="" class="rounded-3 border shadow-xs" style="max-height:130px; max-width:100%; object-fit:contain;">
                    </div>
                    <div class="d-flex flex-column gap-1.5">
                        <button type="button" class="btn btn-success w-100 rounded-pill py-2 fw-bold text-white fs-8 shadow-xs" onclick="executeStep2RenterAccept()">
                            <i class="fa-solid fa-thumbs-up me-1"></i> Looks Good! Accept &amp; Proceed to Meetup
                        </button>
                        <button type="button" class="btn btn-outline-warning w-100 rounded-pill py-1.5 fw-bold text-dark fs-8 border-warning-subtle" style="background:#FFFDF5;" onclick="openStep2FeedbackModal()">
                            <i class="fa-solid fa-camera-rotate text-warning me-1"></i> Request Another Photo / Give Feedback
                        </button>
                        <button type="button" id="btnRenterCancelStep2" style="display:none;" class="btn btn-outline-danger w-100 rounded-pill py-1.5 fw-bold fs-8" onclick="openStep2CancelModal('RENTER')">
                            <i class="fa-solid fa-ban me-1"></i> Cancel Rental (3 Attempts Reached)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: CAMPUS MEETUP LOCATION -->
        <div id="chatStep3Row" style="display:none !important;" class="mb-2">
            <!-- Owner View: Field a Location -->
            <div id="chatStep3OwnerBox" style="display:none !important;">
                <div class="p-2.5 rounded-3 border bg-light mb-2 text-start">
                    <div class="fw-bold text-dark fs-9 mb-1"><i class="fa-solid fa-location-dot text-danger me-1"></i> Step 3: Set Campus Meetup Spot</div>
                    <div class="text-muted mb-2" style="font-size:0.68rem;">Field where on campus you will meet the renter to hand over the gear:</div>
                    <input type="text" id="chatMeetupLocationInput" class="form-control form-control-sm rounded-pill px-3 py-1.5 fs-8 mb-2" 
                           placeholder="e.g. Campus Activity Center - Main Entrance">
                    <div class="d-flex flex-wrap gap-1 mb-2">
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="document.getElementById('chatMeetupLocationInput').value='Campus Activity Center'">Activity Center</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="document.getElementById('chatMeetupLocationInput').value='Main Quadrangle'">Quadrangle</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size:0.65rem;" onclick="document.getElementById('chatMeetupLocationInput').value='Library Lobby'">Library</button>
                    </div>
                    <button type="button" class="btn rentchat-agree-btn w-100 py-2 fw-extrabold" onclick="executeStep3SetLocation()">
                        <i class="fa-solid fa-map-pin me-1"></i> Confirm Meetup Location
                    </button>
                </div>
            </div>

            <!-- Renter View: Waiting for location or view location -->
            <div id="chatStep3RenterBox" style="display:none !important;">
                <div class="rentchat-waiting-box p-3 rounded-3 d-flex align-items-center gap-2.5">
                    <div class="rentchat-spinner-ring">
                        <i class="fa-solid fa-location-crosshairs text-primary fs-8"></i>
                    </div>
                    <div style="font-size:0.72rem;">
                        <div class="fw-bold text-dark">Campus Meetup Spot</div>
                        <div class="text-muted mt-0.5" id="chatMeetupRenterNotice">Waiting for stock owner to field campus meetup spot...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 4: IN-PERSON HANDOVER & START TIMER -->
        <div id="chatStep4Row" style="display:none !important;" class="mb-2">
            <!-- Owner View: Hand Over Gear & Start Timer (Only unlocked after steps 1, 2, 3) -->
            <div id="chatStep4OwnerBox" style="display:none !important;">
                <div class="p-2.5 rounded-3 border bg-light mb-2 text-start">
                    <div class="fw-bold text-dark fs-9 mb-1"><i class="fa-solid fa-handshake text-success me-1"></i> Step 4: Face-to-Face Handover</div>
                    <div class="text-muted mb-2" style="font-size:0.68rem;">
                        Meet on campus at <strong id="chatStep4LocationDisplay" class="text-dark">Campus Activity Center</strong>. Once you have handed over the gear, tap below to start the rental timer:
                    </div>
                    <button type="button" class="btn rentchat-agree-btn w-100 py-2 fw-extrabold" id="btnStep4StartTimer" onclick="executeStep4StartTimer()">
                        <i class="fa-solid fa-play me-1"></i> Hand Over Item &amp; Start Rental Timer
                    </button>
                </div>
            </div>

            <!-- Renter View: Awaiting Handover on campus -->
            <div id="chatStep4RenterBox" style="display:none !important;">
                <div class="rentchat-waiting-box p-3 rounded-3 d-flex align-items-center gap-2.5">
                    <div class="rentchat-spinner-ring">
                        <i class="fa-solid fa-person-walking text-primary fs-8"></i>
                    </div>
                    <div style="font-size:0.72rem;">
                        <div class="fw-bold text-dark">Meet Owner for Handover</div>
                        <div class="text-muted mt-0.5">Meet the owner at <strong id="chatStep4RenterLocationDisplay" class="text-dark">Meetup Spot</strong> to receive the equipment. The owner will start the rental timer upon handover.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTIVE RENTAL LIVE COUNTDOWN TIMER BANNER (Sleek Redesign) -->
    <div id="chatRentalTimerBanner" class="rentchat-timer-card p-3 mb-2 flex-shrink-0 text-white" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-white border-opacity-10">
            <div class="d-flex align-items-center gap-2">
                <div class="rentchat-live-pulse-ring">
                    <span class="rentchat-live-pulse"></span>
                </div>
                <div>
                    <div class="fw-extrabold text-white" style="font-size:0.8rem; letter-spacing:0.2px;">Active Rental Period</div>
                    <div class="text-white-50 fs-10 font-monospace" id="chatTimerItemTitle">POSPT • #RE-10000</div>
                </div>
            </div>
            <span class="badge rounded-pill fw-bold px-2.5 py-1 fs-9 d-inline-flex align-items-center gap-1.5" id="chatLiveTimerBadge" 
                  style="background:rgba(16, 185, 129, 0.2); color:#34D399; border:1px solid rgba(52, 211, 153, 0.35);">
                <i class="fa-solid fa-play fs-11"></i>
                <span>Timer Running</span>
            </span>
        </div>

        <!-- Center Digital Countdown Display Board -->
        <div class="rentchat-timer-display-box rounded-3 p-2.5 text-center mb-2">
            <div class="text-white-50 fs-10 text-uppercase fw-bold mb-1" style="letter-spacing:0.8px;" id="chatCountdownLabel">Time Remaining Until Return</div>
            <div class="rentchat-countdown-digits font-monospace fw-extrabold" id="chatLiveCountdownText">
                23h 57m 04s
            </div>
        </div>

        <!-- Return Details Grid (Formatted cleanly without awkward wraps) -->
        <div class="rentchat-timer-meta-grid rounded-3 p-2">
            <div class="d-flex align-items-center justify-content-between py-1 border-bottom border-white border-opacity-10 fs-9">
                <span class="text-white-50 d-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-clock-rotate-left text-warning opacity-75"></i> Return Deadline
                </span>
                <span class="fw-bold text-white text-end" id="chatTimerEndDisplay">Oct 18, 2026 • 12:55 AM</span>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-1 fs-9">
                <span class="text-white-50 d-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-location-dot text-danger opacity-75"></i> Handover Spot
                </span>
                <span class="fw-semibold text-white text-end text-truncate ms-2" id="chatTimerMeetupDisplay" style="max-width: 170px;">Campus Activity Center</span>
            </div>
        </div>

                <!-- Owner Mark Returned & Restock Button (Visible for Stock Owner ONLY when rental is active and overdue is zero) -->
        <div id="chatTimerRestockRow" style="display:none !important;" class="pt-2 mt-2 border-top border-white border-opacity-15">
            <div class="d-flex align-items-center justify-content-between w-100 gap-2 flex-wrap">
                <span class="fs-9 text-white d-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <span>Item received back from renter?</span>
                </span>
                <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fs-9 fw-extrabold text-white shadow-sm flex-grow-1 flex-sm-grow-0" 
                        style="background: linear-gradient(135deg, #10B981, #059669); border:none;" 
                        id="btnChatMarkReturnedRestock"
                        onclick="markRentalReturnedAndRestockFromChat()">
                    <i class="fa-solid fa-boxes-packing me-1"></i> Mark Returned &amp; Restock
                </button>
            </div>
        </div>
        <!-- Owner Report & Restock Actions (Visible for Stock Owner ONLY when rental is overdue) -->
        <div id="chatTimerOwnerReportRow" style="display:none !important;" class="pt-2 mt-2 border-top border-white border-opacity-15 rentchat-overdue-row flex-column gap-2">
            <div class="d-flex align-items-center justify-content-between w-100">
                <span class="fs-9 text-warning fw-bold d-flex align-items-center gap-1">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Item overdue</span>
                </span>
                <button type="button" class="btn btn-sm rentchat-report-unreturned-btn py-1 px-2.5 fs-9" onclick="openReportUnreturnedModalFromChat()">
                    <i class="fa-solid fa-flag me-1"></i> Report Unreturned
                </button>
            </div>
            <button type="button" class="btn btn-sm rounded-pill w-100 py-1.5 px-3 fs-9 fw-extrabold text-white shadow-sm d-flex align-items-center justify-content-center gap-1.5" 
                    style="background: linear-gradient(135deg, #10B981, #059669); border:none;" 
                    id="btnChatOverdueRestock"
                    onclick="markRentalReturnedAndRestockFromChat()">
                <i class="fa-solid fa-boxes-packing"></i>
                <span>Mark Returned &amp; Restock Item Back in Market</span>
            </button>
        </div>
        <!-- Renter Overdue Warning (Visible for Renter ONLY when rental is overdue) -->
        <div id="chatTimerRenterOverdueRow" style="display:none !important;" class="pt-2 mt-2 border-top border-white border-opacity-15 rentchat-overdue-row">
            <span class="fs-9 text-warning"><i class="fa-solid fa-clock-rotate-left me-1"></i> Rental expired — please return gear to owner immediately</span>
        </div>
    </div>

    <!-- RENTAL RETURNED & RATING / REVIEW BANNER (Shown when order_status === 'RETURNED') -->
    <div id="chatRentalReturnedBanner" class="rentchat-returned-card p-3 mb-2 flex-shrink-0" style="display:none; background: #FFFFFF; border-radius: 16px; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
        <!-- Top Status Bar -->
        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-light">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:34px; height:34px; background:#DCFCE7; color:#15803D;">
                    <i class="fa-solid fa-boxes-packing fs-8"></i>
                </div>
                <div>
                    <div class="fw-extrabold text-dark" style="font-size:0.82rem; letter-spacing:-0.2px;">Rental Returned &amp; Restocked</div>
                    <div class="text-muted" style="font-size:0.65rem;" id="chatReturnedOrderCodeDisplay">Item safely back in owner stock</div>
                </div>
            </div>
            <span class="badge rounded-pill fw-bold px-2 py-0.5" style="background:#DCFCE7; color:#15803D; font-size:0.68rem; border:1px solid #BBF7D0;">
                <i class="fa-solid fa-circle-check me-1"></i>Completed
            </span>
        </div>

        <!-- RENTER VIEW: Rate 1 to 5 Stars & Required Review -->
        <div id="chatReturnedRenterRatingBox" style="display:none;">
            <div class="p-2.5 rounded-3 mb-2" style="background:#F8FAFC; border:1px solid #E2E8F0;">
                <div class="fw-bold text-dark fs-9 mb-1">
                    <i class="fa-solid fa-star text-warning me-1"></i> Rate Your Rental Experience
                </div>
                <div class="text-muted mb-2" style="font-size:0.68rem;">
                    Please rate this item from 1 to 5 stars and tell us why you gave this rating:
                </div>

                <!-- Interactive 1-5 Star Picker -->
                <div class="d-flex align-items-center justify-content-center gap-2 py-1 mb-1" id="chatRatingStarsContainer">
                    <button type="button" class="btn p-0 border-0 fs-3 rentchat-star" data-star="1" onclick="setRentalStarRating(1)" style="color:#D1D5DB; transition:all 0.15s ease;"><i class="fa-solid fa-star"></i></button>
                    <button type="button" class="btn p-0 border-0 fs-3 rentchat-star" data-star="2" onclick="setRentalStarRating(2)" style="color:#D1D5DB; transition:all 0.15s ease;"><i class="fa-solid fa-star"></i></button>
                    <button type="button" class="btn p-0 border-0 fs-3 rentchat-star" data-star="3" onclick="setRentalStarRating(3)" style="color:#D1D5DB; transition:all 0.15s ease;"><i class="fa-solid fa-star"></i></button>
                    <button type="button" class="btn p-0 border-0 fs-3 rentchat-star" data-star="4" onclick="setRentalStarRating(4)" style="color:#D1D5DB; transition:all 0.15s ease;"><i class="fa-solid fa-star"></i></button>
                    <button type="button" class="btn p-0 border-0 fs-3 rentchat-star" data-star="5" onclick="setRentalStarRating(5)" style="color:#D1D5DB; transition:all 0.15s ease;"><i class="fa-solid fa-star"></i></button>
                </div>
                <div class="text-center fw-bold fs-9 mb-2" id="chatRatingLabelText" style="color:#64748B;">Tap a star to rate (1–5)</div>

                <!-- Required Details Textarea -->
                <label class="form-label fw-bold text-dark mb-1" style="font-size:0.7rem;">
                    Why did you give this item this rating? <span class="text-danger">* (Required)</span>
                </label>
                <textarea class="form-control rounded-3 p-2 fs-8 mb-2" id="chatRatingReviewText" rows="2" 
                          placeholder="Please describe item condition, pickup/return smoothness, and your overall experience..."
                          oninput="checkRentalRatingFormValidity()"></textarea>

                <button type="button" class="btn rentchat-agree-btn w-100 py-2 fw-extrabold" id="btnSubmitRentalRating" onclick="submitRentalRatingFromChat()" disabled>
                    <i class="fa-solid fa-paper-plane me-1"></i> Submit Rating &amp; Review
                </button>
            </div>
        </div>

        <!-- RENTER ALREADY RATED or OWNER VIEWING SUBMITTED RATING -->
        <div id="chatReturnedRatedSuccessBox" style="display:none;" class="mb-2">
            <div class="p-2.5 rounded-3 text-start" style="background:#F0FDF4; border:1px solid #BBF7D0;">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="fw-bold text-success fs-9 d-flex align-items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i>
                        <span id="chatRatedByHeader">Renter Rating Submitted</span>
                    </span>
                    <div id="chatRatedStarsDisplay" class="text-warning fs-9">
                    </div>
                </div>
                <div class="bg-white p-2 rounded-2 border border-success-subtle text-dark fs-8 fst-italic mb-1" id="chatRatedReviewTextDisplay">
                    "Great experience!"
                </div>
                <div class="text-muted" style="font-size:0.65rem;">
                    <i class="fa-solid fa-shield-halved text-success me-0.5"></i> Rental finalized. Both parties can now safely delete this conversation.
                </div>
            </div>
        </div>

        <!-- OWNER VIEW: Waiting for renter rating -->
        <div id="chatReturnedOwnerWaitingBox" style="display:none;" class="mb-2">
            <div class="rentchat-waiting-box p-2.5 rounded-3 d-flex align-items-center gap-2">
                <div class="spinner-border spinner-border-sm text-warning flex-shrink-0" role="status"></div>
                <div style="font-size:0.72rem;">
                    <div class="fw-bold text-dark">Item Restocked • Awaiting Renter Review</div>
                    <div class="text-muted mt-0.5">The student renter is completing their 1–5 star rating and feedback.</div>
                </div>
            </div>
        </div>

        <!-- SAFE DELETE CONVERSATION BUTTON (Visible to BOTH owner and renter once returned) -->
        <div id="chatReturnedDeleteSection" class="pt-2 border-top border-light text-center">
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill w-100 py-2 fw-bold d-flex align-items-center justify-content-center gap-1.5 shadow-2xs" 
                    id="btnChatReturnedDeleteConv" 
                    onclick="initiateDeleteCurrentChatConversation()">
                <i class="fa-solid fa-trash-can fs-9"></i>
                <span>Delete Conversation Safely</span>
            </button>
            <div class="text-muted mt-1" style="font-size:0.65rem;">
                <i class="fa-solid fa-lock-open me-0.5 text-secondary"></i> Safe to delete: Rental is returned and restocked in inventory.
            </div>
        </div>
    </div>

    <!-- Chat Stream -->
    <div id="chatStream" style="flex:1; overflow-y:auto; padding-right:4px;" class="mb-2">
    </div>

    <!-- Input Box -->
    <div class="rentchat-input-bar d-flex gap-2 p-2 bg-white flex-shrink-0 align-items-end"
        style="position:relative; z-index:100;">
        <div class="flex-grow-1 position-relative">
            <textarea class="form-control rentchat-textarea" id="chatInput" rows="1"
                placeholder="Type your message..."
                oninput="this.style.height = 'auto'; this.style.height = Math.min(this.scrollHeight, 120) + 'px';"
                onkeydown="if(event.key==='Enter' && !event.shiftKey){ event.preventDefault(); sendChatMessage(); }"></textarea>
        </div>
        <button type="button" class="rentchat-send-btn flex-shrink-0 mb-0.5" onclick="sendChatMessage()" title="Send Message">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>
</div>

<!-- DELETE CONVERSATION CONFIRMATION MODAL -->
<div class="modal fade" id="deleteConversationModal" tabindex="-1" aria-labelledby="deleteConversationModalLabel" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 360px;">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-body text-center p-2">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                     id="deleteConvIconWrap"
                     style="width: 56px; height: 56px; background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                    <i class="fa-solid fa-trash-can fs-4" id="deleteConvIcon"></i>
                </div>
                
                <h6 class="fw-bold text-dark fs-7 mb-2" id="deleteConvTitle">Delete Conversation?</h6>
                
                <!-- Checking Status Loading indicator -->
                <div id="deleteConvCheckingState" class="py-3 text-secondary" style="display:none;">
                    <i class="fa-solid fa-spinner fa-spin text-primary fs-5 mb-2"></i>
                    <div class="fs-9">Verifying rental transaction status...</div>
                </div>

                <!-- Normal Confirmation State -->
                <div id="deleteConvConfirmState">
                    <p class="text-muted fs-8 mb-3">
                        Are you sure you want to delete your conversation with <strong id="deleteConvPartnerName" class="text-dark">User</strong>? All chat messages will be permanently removed.
                    </p>
                </div>

                <!-- Blocked by Active Transaction State -->
                <div id="deleteConvBlockedState" style="display:none;" class="mb-3 text-start">
                    <div class="alert alert-warning border-0 rounded-3 p-2.5 mb-0" style="background:#FFFBEB; border:1px solid #FDE68A !important;">
                        <div class="d-flex gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-warning fs-6 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <div class="fw-bold text-dark fs-8 mb-1">Active Transaction Ongoing</div>
                                <p class="text-muted mb-0" style="font-size:0.75rem; line-height: 1.4;">
                                    You have an active ongoing transaction (<strong id="deleteConvOrderCode" class="text-dark">#RE-ORDER</strong>) with this user.
                                    <br><br>
                                    Chat history cannot be deleted while a transaction is pending or in progress to protect both renter and lender. You can delete this conversation once the rental is completed or returned.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                    <button type="button" class="btn btn-light rounded-pill px-3.5 py-1.5 fs-8 fw-bold" data-bs-dismiss="modal" id="btnCancelDeleteConv">Cancel</button>
                    <button type="button" class="btn btn-danger rounded-pill px-3.5 py-1.5 fs-8 fw-bold text-white shadow-2xs" id="btnConfirmDeleteConv" onclick="executeDeleteConversation()">
                        <i class="fa-solid fa-trash-can me-1 fs-9"></i> Delete
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 py-1.5 fs-8 fw-bold text-white shadow-2xs" id="btnCloseBlockedDeleteConv" data-bs-dismiss="modal" style="display:none; background:#5B3FA8; border:none;">
                        Understood
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STEP 1 OWNER PROPOSAL POP-UP NOTIFICATION MODAL -->
<div class="modal fade" id="step1OwnerProposalModal" tabindex="-1" aria-labelledby="step1OwnerProposalModalLabel" aria-hidden="true" style="z-index: 1080;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
        <div class="modal-content rounded-4 border-0 shadow-lg bg-white overflow-hidden">
            <!-- Modal Header -->
            <div class="p-3 text-white text-center position-relative" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #9333EA 100%);">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="font-size: 0.75rem;"></button>
                <div class="rounded-circle bg-white bg-opacity-20 d-inline-flex align-items-center justify-content-center p-2 mb-2 shadow-2xs" style="width: 56px; height: 56px;">
                    <i class="fa-solid fa-handshake-simple fs-3 text-white"></i>
                </div>
                <div class="badge rounded-pill bg-white text-primary fw-extrabold px-2.5 py-1 mb-1.5 shadow-2xs" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                    STEP 1 OF 4 • BOOKING CONFIRMATION
                </div>
                <h5 class="fw-extrabold mb-0 text-white" style="letter-spacing: -0.3px;">Rental Proposal Received!</h5>
                <p class="text-white text-opacity-90 fs-9 mb-0 mt-1">A verified student wants to rent your equipment</p>
            </div>

            <div class="modal-body p-3 pt-3 text-center">
                <!-- Renter Box -->
                <div class="p-2.5 rounded-3 mb-2.5 text-start d-flex align-items-center gap-2.5" style="background: #F8FAFC; border: 1px solid #E2E8F0;">
                    <img id="step1ModalRenterAvatar" src="https://ui-avatars.com/api/?name=Student&background=5B3FA8&color=fff" class="rounded-circle border" width="42" height="42" style="object-fit:cover;">
                    <div class="min-w-0">
                        <div class="text-muted" style="font-size: 0.68rem; font-weight: 600;">BORROWER REQUEST</div>
                        <div class="fw-bold text-dark fs-8 text-truncate" id="step1ModalRenterName">Pogilameg Tester</div>
                        <span class="badge rounded-pill" style="background:#E0F2FE; color:#0369A1; font-size:0.60rem; padding: 2px 6px;">
                            <i class="fa-solid fa-cart-shopping me-0.5"></i> Student Renter
                        </span>
                    </div>
                </div>

                <!-- Item Details Card -->
                <div class="p-3 rounded-3 text-start mb-2.5" style="background: #F5F3FF; border: 1px solid #DDD6FE;">
                    <div class="d-flex align-items-center justify-content-between mb-1.5">
                        <span class="badge rounded-pill fw-bold" style="background:#ECFDF5; color:#059669; border:1px solid #A7F3D0; font-size:0.65rem; padding: 2px 8px;">
                            <i class="fa-solid fa-crown text-warning me-1"></i>Your Item (You Own This)
                        </span>
                        <span class="font-monospace text-muted fw-bold" style="font-size: 0.68rem;" id="step1ModalOrderCode">#RE-00000</span>
                    </div>
                    <h6 class="fw-extrabold text-dark mb-1" id="step1ModalItemTitle" style="font-size: 0.95rem;">Equipment</h6>
                    <div class="d-flex align-items-center justify-content-between pt-1 border-top border-purple-subtle" style="font-size: 0.75rem;">
                        <div>
                            <span class="text-muted">Rental Fee: </span>
                            <span class="fw-extrabold text-primary" id="step1ModalTotalAmount">₱0.00</span>
                            <span class="text-muted fs-9">(Cash on Handover)</span>
                        </div>
                        <div class="text-secondary fw-semibold" id="step1ModalDuration">1 Day Duration</div>
                    </div>
                </div>

                <!-- Guidance Alert -->
                <div class="alert alert-light border text-start p-2.5 rounded-3 mb-3 d-flex align-items-start gap-2" style="background:#FFFBEB; border-color:#FDE68A !important;">
                    <i class="fa-solid fa-circle-info text-warning fs-6 mt-0.5 flex-shrink-0"></i>
                    <div style="font-size: 0.72rem; line-height: 1.35; color: #92400E;">
                        <strong>Action Required:</strong> Agree to this booking request to accept the rental and unlock <strong>Step 2 (Equipment Preparation &amp; Condition Proof)</strong>.
                    </div>
                </div>

                <!-- Buttons -->
                <button type="button" class="btn btn-success w-100 py-2.5 rounded-pill fw-extrabold text-white shadow-sm d-flex align-items-center justify-content-center gap-2 mb-2"
                        id="btnModalStep1Agree" onclick="executeStep1AgreeFromPopup()" style="background:#059669; border:none; font-size: 0.88rem;">
                    <i class="fa-solid fa-handshake-simple fs-6"></i>
                    <span>Agree to Rent Equipment</span>
                </button>
                <button type="button" class="btn btn-light w-100 py-2 rounded-pill fw-bold text-secondary border"
                        data-bs-dismiss="modal" style="font-size: 0.78rem;">
                    Review in Chat First
                </button>
            </div>
        </div>
    </div>
</div>

<!-- STEP 2: RENTER FEEDBACK & REQUEST ANOTHER PHOTO MODAL -->
<div class="modal fade" id="step2FeedbackModal" tabindex="-1" aria-labelledby="step2FeedbackModalLabel" aria-hidden="true" style="z-index: 1075;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-1 pt-1 px-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 36px; height: 36px; background: #FFFBEB; color: #D97706;">
                        <i class="fa-solid fa-camera-rotate fs-6"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-extrabold text-dark mb-0 fs-8">Request Another Photo</h6>
                        <div class="text-muted" style="font-size: 0.65rem;">Stock owner will receive feedback &amp; re-upload</div>
                    </div>
                </div>
                <span class="badge bg-warning text-dark" id="step2FeedbackAttemptBadge" style="font-size:0.65rem;">Attempt 1 of 3</span>
            </div>

            <div class="modal-body p-1 pt-2">
                <div class="alert alert-light border p-2 rounded-3 mb-2" style="background: #FFFDF5; border-color: #FDE68A !important; font-size: 0.7rem; color: #92400E;">
                    <i class="fa-solid fa-circle-info text-warning me-1"></i>
                    Let the stock owner know what needs improvement or what angle/condition you want verified before accepting.
                </div>

                <!-- Quick Reasons Selection -->
                <div class="mb-2">
                    <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.72rem;">Quick Feedback (Tap to fill):</label>
                    <div class="d-flex flex-wrap gap-1">
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size: 0.65rem;" onclick="appendStep2FeedbackChip('Photo is blurry or poorly lit')">Blurry / Poor lighting</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size: 0.65rem;" onclick="appendStep2FeedbackChip('Please show back, ports & lens clearly')">Show other angles</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size: 0.65rem;" onclick="appendStep2FeedbackChip('Visible scratch or damage not in listing')">Scratch / wear concern</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size: 0.65rem;" onclick="appendStep2FeedbackChip('Please verify if charger / accessories are included')">Check accessories</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill py-0.5 px-2" style="font-size: 0.65rem;" onclick="appendStep2FeedbackChip('Item model or color looks different than listing')">Model mismatch</button>
                    </div>
                </div>

                <!-- Custom Feedback Notes -->
                <div class="mb-3">
                    <label for="step2FeedbackInput" class="form-label text-dark fw-bold mb-1" style="font-size: 0.72rem;">Specific Notes / Request:</label>
                    <textarea class="form-control rounded-3 fs-8" id="step2FeedbackInput" rows="3" 
                              placeholder="e.g. Please show the screen powered on and lens condition clearly..."></textarea>
                    <div class="text-muted mt-1" style="font-size:0.64rem;">
                        <i class="fa-solid fa-clock-rotate-left me-1"></i> Max 3 attempts. If expectations are not met after 3 attempts, you and the owner can cancel.
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill flex-fill py-2 fw-semibold fs-8 text-secondary border" data-bs-dismiss="modal">
                        Back to Review
                    </button>
                    <button type="button" class="btn btn-warning rounded-pill flex-fill py-2 fw-extrabold fs-8 text-dark shadow-xs" id="btnSubmitStep2Feedback" onclick="executeStep2SendFeedback()">
                        <i class="fa-solid fa-paper-plane me-1"></i> Send Feedback
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STEP 2: MUTUAL CANCELLATION MODAL (ACCESSIBLE AT 3 ATTEMPTS) -->
<div class="modal fade" id="step2CancelModal" tabindex="-1" aria-labelledby="step2CancelModalLabel" aria-hidden="true" style="z-index: 1080;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-1 pt-1 px-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 38px; height: 38px; background: #FEE2E2; color: #DC2626;">
                        <i class="fa-solid fa-ban fs-5"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-extrabold text-danger mb-0 fs-8">Cancel Rental Agreement</h6>
                        <div class="text-muted" style="font-size: 0.65rem;">3 photo review attempts reached</div>
                    </div>
                </div>
                <span class="badge bg-danger text-white" style="font-size:0.65rem;">3 of 3 Attempts</span>
            </div>

            <div class="modal-body p-1 pt-2">
                <div class="alert alert-danger p-2 rounded-3 mb-2.5 border-danger-subtle" style="font-size: 0.7rem;">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                    Expectations were not met across 3 photo attempts. Both you and the counterparty can now cancel this rental order. Please explain why you chose to cancel.
                </div>

                <!-- Quick Reasons Selection -->
                <div class="mb-2">
                    <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.72rem;">Reason for cancellation (Select or write below):</label>
                    <div class="d-flex flex-wrap gap-1" id="step2CancelQuickChips">
                        <!-- Populated dynamically based on role (Renter vs Stock Owner) -->
                    </div>
                </div>

                <!-- Custom Explanation Textarea -->
                <div class="mb-3">
                    <label for="step2CancelReasonInput" class="form-label text-dark fw-bold mb-1" style="font-size: 0.72rem;">Explanation details:</label>
                    <textarea class="form-control rounded-3 fs-8" id="step2CancelReasonInput" rows="3" 
                              placeholder="Explain why you didn't like to rent out or rent the item..."></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill flex-fill py-2 fw-semibold fs-8 text-secondary border" data-bs-dismiss="modal">
                        Keep Agreement
                    </button>
                    <button type="button" class="btn btn-danger rounded-pill flex-fill py-2 fw-extrabold fs-8 text-white shadow-xs" id="btnConfirmCancelRental" onclick="executeStep2ConfirmCancellation()">
                        <i class="fa-solid fa-ban me-1"></i> Confirm Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- APP-WIDE INCOMING PROPOSAL POP-UP TOAST -->
<div id="step1IncomingProposalToast" class="shadow-lg" style="display:none; position: fixed; top: 16px; left: 50%; transform: translateX(-50%); z-index: 1090; width: 92%; max-width: 440px; background: #ffffff; border: 1.5px solid #8B5CF6; border-radius: 16px; padding: 12px 14px; animation: slideDownBounce 0.35s cubic-bezier(0.18, 0.89, 0.32, 1.28);">
    <div class="d-flex align-items-start gap-2.5">
        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-2xs" style="width: 42px; height: 42px; background: linear-gradient(135deg, #EDE9FE, #DDD6FE); color: #6D28D9;">
            <i class="fa-solid fa-handshake-simple fs-6"></i>
        </div>
        <div class="min-w-0 flex-grow-1">
            <div class="d-flex align-items-center justify-content-between mb-0.5">
                <span class="badge rounded-pill fw-bold" style="background:#EDE9FE; color:#5B3FA8; font-size:0.62rem; padding: 2px 7px;">
                    <i class="fa-solid fa-bell me-1"></i>STEP 1: RENTAL PROPOSAL
                </span>
                <button type="button" class="btn-close" style="font-size: 0.65rem;" onclick="dismissStep1IncomingToast()"></button>
            </div>
            <div class="fw-extrabold text-dark fs-8 text-truncate" id="step1ToastRenterAndItem">
                Pogilameg Tester wants to rent your item!
            </div>
            <div class="text-muted fs-9 text-truncate mb-2" id="step1ToastDetails">
                Order #RE-00000 • ₱0.00 • Tap to Agree
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-bold fs-9 text-white d-flex align-items-center gap-1 shadow-2xs" id="btnStep1ToastOpen">
                    <i class="fa-solid fa-handshake-simple"></i> View &amp; Agree
                </button>
                <button type="button" class="btn btn-sm btn-light rounded-pill px-2.5 py-1 fw-semibold fs-9 text-muted border" onclick="dismissStep1IncomingToast()">
                    Later
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slideDownBounce {
    0% { transform: translate(-50%, -40px); opacity: 0; }
    60% { transform: translate(-50%, 8px); opacity: 1; }
    100% { transform: translate(-50%, 0); opacity: 1; }
}
</style>

