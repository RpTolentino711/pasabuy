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

    <!-- Chat Stream -->
    <div id="chatStream" style="flex:1; overflow-y:auto; padding-right:4px;" class="mb-2">
    </div>

    <!-- Input Box -->
    <div class="d-flex gap-2 pt-2 border-top bg-white flex-shrink-0"
        style="background:#ffffff; position:relative; z-index:100;">
        <input type="text" class="form-control rounded-pill fs-8" id="chatInput"
            placeholder="Type a message..." onkeydown="if(event.key==='Enter') sendChatMessage()">
        <button
            class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
            style="width:38px; height:38px;" onclick="sendChatMessage()"><i
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
