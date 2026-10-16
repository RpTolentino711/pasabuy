<!-- MESSAGES TAB (PHP COMPONENT) -->
<div id="tabMessages" style="display:none;">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Messages</h5>
        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 fs-9 fw-bold"><i
                class="fa-solid fa-comments me-1"></i> Active Chats</span>
    </div>

    <!-- Chat Conversations List (Messenger Heads) -->
    <div id="conversationHeadsList" class="d-flex flex-column gap-2">
        <div class="text-center py-5 text-muted fs-8 bg-white rounded-4 border p-4">
            <i class="fa-solid fa-comments fs-2 d-block mb-2 text-secondary opacity-50"></i>
            No active chat conversations yet.<br>Click <strong>Message</strong> on any item listing to start chatting!
        </div>
    </div>
</div>

<!-- CHAT VIEW (SUB-SCREEN) -->
<div id="chatView" style="display:none; height:100%; flex-direction:column;">
    <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom flex-shrink-0">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-light rounded-circle" onclick="closeChat()"><i
                    class="fa-solid fa-arrow-left"></i></button>
            <img id="chatHeaderAvatar" src="https://api.dicebear.com/7.x/avataaars/svg?seed=Student"
                class="rounded-circle border" width="36" height="36"
                style="object-fit:cover; background:#f0f3f8;">
            <span class="fw-bold fs-7" id="chatPartnerName">Student</span>
        </div>
        <button class="btn btn-sm btn-outline-danger rounded-pill fs-8" onclick="openReportModal()">Report User</button>
    </div>

    <!-- Attached Item Header -->
    <div class="p-2 bg-white rounded-3 border mb-2 d-flex align-items-center gap-2 flex-shrink-0">
        <img src="https://images.unsplash.com/photo-1611125832047-1d7ad1e8e48b?w=100&q=80" class="rounded-2"
            width="40" height="40" style="object-fit:cover;">
        <div>
            <div class="fw-bold fs-8" id="chatItemTitle">Campus Item</div>
            <div class="text-primary fw-bold fs-8" id="chatItemPrice">₱0.00</div>
        </div>
    </div>

    <!-- Safety Reminder -->
    <div class="p-2 bg-warning-subtle text-warning-emphasis rounded-3 fs-9 mb-2 flex-shrink-0">
        <i class="fa-solid fa-shield-halved me-1"></i> Meet in a safe public location and inspect the item before paying cash.
    </div>

    <!-- ACTIVE RENTAL REQUEST & ACTION BANNER (Dynamic) -->
    <div id="chatRentalRequestBanner" class="alert alert-info border-0 rounded-4 shadow-sm p-3 mb-2 flex-shrink-0" style="display:none; background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%); border: 1.5px solid #C7D2FE !important;">
        <div class="d-flex align-items-center justify-content-between mb-1.5">
            <span class="fw-extrabold fs-8 text-primary"><i class="fa-solid fa-handshake-simple me-1"></i> Rental Agreement Request</span>
            <span class="badge bg-warning text-dark fw-bold fs-9" id="chatRentalReqStatusBadge">Pending Approval</span>
        </div>
        <div class="p-2 rounded-3 bg-white border mb-2 fs-9 text-dark">
            <div class="d-flex justify-content-between mb-0.5">
                <span class="text-muted">Order:</span>
                <strong id="chatReqOrderCode">#RE-10000</strong>
            </div>
            <div class="d-flex justify-content-between mb-0.5">
                <span class="text-muted">Schedule:</span>
                <span id="chatReqDatesText">Oct 16 - Oct 17 (1 day)</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Total:</span>
                <strong class="text-primary fw-bold" id="chatReqTotalText">₱0.00</strong>
            </div>
        </div>
        <!-- Owner Action Row (Visible to Romeo) -->
        <div id="chatOwnerActionRow" style="display:none;">
            <button type="button" class="btn btn-success btn-sm rounded-pill w-100 py-1.5 fw-bold fs-8 shadow-xs d-flex align-items-center justify-content-center gap-1.5" 
                    id="btnAgreeStartTimer" onclick="executeAgreeAndStartTimer()">
                <i class="fa-solid fa-play fs-9"></i> Agree to Rent & Start Timer
            </button>
        </div>
        <!-- Renter Waiting Notice (Visible to Pogilameg) -->
        <div id="chatRenterWaitingRow" style="display:none;" class="text-center text-muted fs-9">
            <i class="fa-solid fa-hourglass-half text-warning me-1"></i> Waiting for owner (<span id="chatReqOwnerName">Romeo</span>) to agree and start timer.
        </div>
    </div>

    <!-- ACTIVE RENTAL LIVE COUNTDOWN TIMER BANNER -->
    <div id="chatRentalTimerBanner" class="card border-0 rounded-4 shadow-sm p-2.5 mb-2 flex-shrink-0 text-white" style="display:none; background: linear-gradient(135deg, #4F46E5 0%, #312E81 100%);">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <span class="fs-9 fw-bold text-white-50"><i class="fa-solid fa-stopwatch me-1 text-warning"></i> RENTAL IN PROGRESS</span>
            <span class="badge bg-success text-white fw-bold fs-9" id="chatLiveTimerBadge">Timer Active</span>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <div class="fw-bold fs-8 text-white text-truncate" style="max-width:180px;" id="chatTimerItemTitle">POSPT (#RE-10000)</div>
                <div class="fs-9 text-white-50">Ends: <span id="chatTimerEndDisplay">Oct 17, 2026, 3:45 PM</span></div>
            </div>
            <div class="text-end">
                <div class="fs-6 fw-extrabold text-warning font-monospace" id="chatLiveCountdownText">00:00:00</div>
                <div class="fs-9 text-white-50" id="chatCountdownLabel">Time Remaining</div>
            </div>
        </div>
        <!-- Owner Report Unreturned Item Button (Visible for Romeo) -->
        <div id="chatTimerOwnerReportRow" style="display:none;" class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex align-items-center justify-content-between">
            <span class="fs-9 text-white-50">Not returned on time?</span>
            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 py-1 fs-9 fw-bold shadow-xs d-flex align-items-center gap-1" onclick="openReportUnreturnedModalFromChat()">
                <i class="fa-solid fa-flag fs-9"></i> Report Unreturned Item
            </button>
        </div>
    </div>

    <!-- Chat Stream -->
    <div id="chatStream" style="flex:1; overflow-y:auto; padding-right:4px;" class="mb-2">
    </div>

    <!-- Input Box -->
    <div class="d-flex gap-2 pt-2 border-top bg-white flex-shrink-0 align-items-end"
        style="background:#ffffff; position:relative; z-index:100;">
        <textarea class="form-control fs-8" id="chatInput" rows="1"
            placeholder="Type a message..."
            style="resize: none; overflow-y: auto; max-height: 120px; min-height: 38px; border-radius: 20px; padding: 8px 16px; line-height: 1.4; transition: height 0.1s ease;"
            oninput="this.style.height = 'auto'; this.style.height = Math.min(this.scrollHeight, 120) + 'px';"
            onkeydown="if(event.key==='Enter' && !event.shiftKey){ event.preventDefault(); sendChatMessage(); }"></textarea>
        <button
            class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs mb-0.5"
            style="width:38px; height:38px;" onclick="sendChatMessage()" title="Send Message"><i
                class="fa-solid fa-paper-plane"></i></button>
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
