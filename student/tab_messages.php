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

        /* Live Countdown Timer Card */
        .rentchat-timer-card {
            background: linear-gradient(135deg, #312E81 0%, #1E1B4B 100%);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 6px 20px rgba(49, 46, 129, 0.25);
            position: relative;
            overflow: hidden;
        }
        .rentchat-live-pulse {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #34D399;
            box-shadow: 0 0 6px #34D399;
            animation: rentPulseLive 1.4s infinite ease-in-out;
        }
        @keyframes rentPulseLive {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.3); }
        }
        .rentchat-report-unreturned-btn {
            background: rgba(239, 68, 68, 0.15);
            color: #FCA5A5;
            border: 1px solid rgba(239, 68, 68, 0.35);
            border-radius: 999px;
            padding: 3px 12px;
            font-size: 0.72rem;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .rentchat-report-unreturned-btn:hover {
            background: #EF4444;
            color: #FFFFFF;
            border-color: #EF4444;
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
                    <span class="badge rounded-pill fw-bold" style="background:#ECFDF5; color:#059669; font-size:0.62rem; padding: 2px 6px; border:1px solid #A7F3D0;">
                        <i class="fa-solid fa-circle-check me-0.5"></i>Verified Lender
                    </span>
                    <span class="text-muted" style="font-size:0.65rem;">• Active Now</span>
                </div>
            </div>
        </div>
        <button type="button" class="rentchat-report-btn" onclick="openReportModal()" title="Report user or issue">
            <i class="fa-solid fa-shield-halved fs-9"></i> Report
        </button>
    </div>

    <!-- Attached Equipment Banner (Never broken, elegant layout) -->
    <div class="rentchat-item-card p-2.5 mb-2 d-flex align-items-center justify-content-between flex-shrink-0">
        <div class="d-flex align-items-center gap-2.5 min-w-0">
            <div class="position-relative flex-shrink-0">
                <img id="chatItemImage" src="" 
                     class="rounded-3 border" 
                     style="width:44px; height:44px; object-fit:cover; display:none;"
                     onload="this.style.display='block'; document.getElementById('chatItemThumbFallback').style.display='none';"
                     onerror="this.style.display='none'; document.getElementById('chatItemThumbFallback').style.display='flex';"
                     alt="Item Thumbnail">
                <div id="chatItemThumbFallback" class="rounded-3 d-flex align-items-center justify-content-center" 
                     style="width:44px; height:44px; background:linear-gradient(135deg, #EDE9FE, #DDD6FE); color:#6D28D9; font-size:1.1rem; border:1px solid #C4B5FD;">
                    <i class="fa-solid fa-cube"></i>
                </div>
            </div>
            <div class="min-w-0">
                <div class="d-flex align-items-center gap-1.5 mb-0.5">
                    <span class="badge rounded-pill fw-bold" style="background:#EDE9FE; color:#5B3FA8; font-size:0.62rem; padding: 2px 6px;">EQUIPMENT</span>
                    <span class="text-muted fw-semibold" style="font-size:0.65rem;">Campus Handover</span>
                </div>
                <h6 class="fw-bold fs-8 text-dark mb-0 text-truncate" id="chatItemTitle">Campus Item</h6>
                <div class="d-flex align-items-baseline gap-1">
                    <span class="fw-extrabold text-primary fs-7" id="chatItemPrice">₱0.00</span>
                    <span class="text-muted" style="font-size:0.68rem;">/ day</span>
                </div>
            </div>
        </div>
        <div class="flex-shrink-0 ms-2">
            <span class="badge rounded-pill px-2.5 py-1 fw-bold border" style="background:#F8FAFC; color:#64748B; font-size:0.68rem;">
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

        <!-- Owner Action Row (Visible to Romeo) -->
        <div id="chatOwnerActionRow" style="display:none;">
            <button type="button" class="btn rentchat-agree-btn w-100 py-2 fw-extrabold d-flex align-items-center justify-content-center gap-2" 
                    id="btnAgreeStartTimer" onclick="executeAgreeAndStartTimer()">
                <i class="fa-solid fa-circle-play fs-8"></i>
                <span>Agree to Handover &amp; Start Rental Timer</span>
            </button>
            <div class="text-center text-muted mt-1.5" style="font-size:0.67rem;">
                <i class="fa-solid fa-shield-check text-success me-1"></i> Tap once in-person physical inspection is completed
            </div>
        </div>

        <!-- Renter Waiting Notice (Visible to Pogilameg) -->
        <div id="chatRenterWaitingRow" style="display:none;">
            <div class="rentchat-waiting-box p-2.5 rounded-3 d-flex align-items-center gap-2.5">
                <div class="rentchat-spinner-ring">
                    <i class="fa-solid fa-hourglass-half text-warning fs-8"></i>
                </div>
                <div class="flex-grow-1 text-start" style="font-size: 0.72rem;">
                    <div class="fw-bold text-dark">Awaiting Owner Handover</div>
                    <div class="text-muted" style="line-height:1.3;">
                        <strong id="chatReqOwnerName">Owner</strong> will inspect the gear with you on campus and start the timer.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTIVE RENTAL LIVE COUNTDOWN TIMER BANNER -->
    <div id="chatRentalTimerBanner" class="rentchat-timer-card p-3 mb-2 flex-shrink-0 text-white" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-2 pb-1.5 border-bottom border-white border-opacity-10">
            <div class="d-flex align-items-center gap-1.5">
                <span class="rentchat-live-pulse"></span>
                <span class="fs-9 fw-bold text-white-75" style="letter-spacing:0.4px;">RENTAL IN PROGRESS</span>
            </div>
            <span class="badge rounded-pill fw-bold px-2.5 py-0.5 fs-9" id="chatLiveTimerBadge" 
                  style="background:rgba(16, 185, 129, 0.2); color:#34D399; border:1px solid rgba(52, 211, 153, 0.3);">
                <i class="fa-solid fa-play me-1"></i> Timer Active
            </span>
        </div>
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div class="min-w-0">
                <div class="fw-bold fs-8 text-white text-truncate" id="chatTimerItemTitle">POSPT (#RE-10000)</div>
                <div class="fs-9 text-white-50 mt-0.5">
                    <i class="fa-solid fa-clock-rotate-left me-1"></i>Ends: <span id="chatTimerEndDisplay" class="text-white-75 fw-semibold">Oct 17, 2026, 3:45 PM</span>
                </div>
            </div>
            <div class="text-end flex-shrink-0">
                <div class="fs-5 fw-extrabold text-warning font-monospace leading-none" id="chatLiveCountdownText" style="letter-spacing: 0.5px;">00:00:00</div>
                <div class="fs-9 text-white-50 mt-0.5" id="chatCountdownLabel">Time Remaining</div>
            </div>
        </div>
        <!-- Owner Report Unreturned Item Button (Visible for Romeo) -->
        <div id="chatTimerOwnerReportRow" style="display:none;" class="pt-2 mt-2 border-top border-white border-opacity-15 d-flex align-items-center justify-content-between">
            <span class="fs-9 text-white-50">Not returned on time?</span>
            <button type="button" class="btn btn-sm rentchat-report-unreturned-btn" onclick="openReportUnreturnedModalFromChat()">
                <i class="fa-solid fa-flag me-1"></i> Report Unreturned
            </button>
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
