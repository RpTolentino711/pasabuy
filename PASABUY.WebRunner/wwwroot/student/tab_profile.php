<!-- PROFILE TAB (PHP COMPONENT) -->
<div id="tabProfile" style="display:none;">
    <div class="text-center p-3 bg-white rounded-4 border shadow-sm mb-3">
        <div class="position-relative d-inline-block mb-2">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80"
                class="rounded-circle border shadow-sm" width="80" height="80" style="object-fit:cover;"
                id="profileAvatar">
            <button class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 p-1"
                style="width:28px; height:28px; transform:translate(10%, 10%);"
                onclick="openProfileSettingsModal()"><i class="fa-solid fa-camera fs-9"></i></button>
        </div>
        <h6 class="fw-bold mb-0" id="profileName">John Doe</h6>
        <span class="badge-verified mb-2" id="profileBadge"><i class="fa-solid fa-circle-check"></i>
            Verified Student</span>
        <div class="fs-8 text-muted mb-2" id="profileSub">2023-00123 • BS Computer Science (3rd Yr)</div>

        <button class="btn btn-sm btn-outline-primary rounded-pill px-4 fw-bold mb-1"
            onclick="openProfileSettingsModal()"><i class="fa-solid fa-gear me-1"></i> Edit Profile &
            Settings</button>

        <div class="d-flex justify-content-center gap-4 mt-3 pt-2 border-top">
            <div>
                <div class="fw-bold text-dark fs-6"><span id="profileRating">0.0</span> <i
                        class="fa-solid fa-star text-warning"></i></div>
                <div class="fs-8 text-muted">Rating</div>
            </div>
            <div>
                <div class="fw-bold text-dark fs-6" id="profileDeals">0</div>
                <div class="fs-8 text-muted">Deals Done</div>
            </div>
        </div>
    </div>

    <!-- MY SELLING ITEMS & INTERESTED BUYERS SECTION -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-3 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold mb-0"><i class="fa-solid fa-store text-primary me-2"></i>My Selling Items</h6>
            <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold shadow-sm" onclick="switchTab('sell')"><i class="fa-solid fa-plus me-1"></i> Post Another Product</button>
        </div>

        <div id="mySellingItemsContainer" class="row g-2 mb-3">
            <div class="col-12 text-center py-4 text-muted fs-8" id="noSellingItemsPlaceholder">
                <i class="fa-solid fa-box-open fs-3 d-block mb-2 text-secondary"></i>
                You have no active selling items yet. Go to <strong>+ Sell</strong> to post your first item!
            </div>
        </div>
    </div>

    <!-- LOGOUT BUTTON -->
    <button class="btn btn-outline-danger w-100 rounded-pill fw-bold py-2 mb-3" onclick="logoutStudent()"><i
            class="fa-solid fa-right-from-bracket me-2"></i> Log Out Account</button>
</div>
