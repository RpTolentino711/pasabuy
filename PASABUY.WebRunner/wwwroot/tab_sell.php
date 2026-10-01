<!-- ==========================================================
     RentEase: Post Equipment for Rent ("Rent Out") Tab
     Streamlined & Minimized Modern Lender Studio UI
     ========================================================== -->
<div id="tabSell" style="display:none;" class="pb-5">

    <style>
        .rentout-mini-hero {
            background: linear-gradient(135deg, #4A1D96 0%, #5B3FA8 60%, #341F97 100%);
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(91, 63, 168, 0.18);
            position: relative;
            overflow: hidden;
        }
        .rentout-section-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #ECEFF5;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }
        .rentout-section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #F1F5F9;
        }
        .rentout-icon-box {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.76rem;
            flex-shrink: 0;
        }
        .rentout-input-label {
            font-size: 0.74rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .rentout-control {
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            padding: 6px 10px;
            font-size: 0.82rem;
            transition: all 0.2s ease;
            background-color: #FAFAFC;
        }
        .rentout-control:focus {
            background-color: #FFFFFF;
            border-color: #5B3FA8;
            box-shadow: 0 0 0 3px rgba(91, 63, 168, 0.12);
            outline: none;
        }
        .rentout-dropzone {
            border: 1.5px dashed #C4B5FD;
            background: #FAF5FF;
            border-radius: 12px;
            padding: 10px 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .rentout-dropzone:hover {
            background: #F3E8FF;
            border-color: #8B5CF6;
        }
        .rentout-fee-banner {
            background: #FAF5FF;
            border: 1px solid #E9D5FF;
            border-radius: 10px;
            padding: 6px 10px;
        }
        .rentout-publish-btn {
            background: linear-gradient(135deg, #5B3FA8 0%, #341F97 100%);
            border: none;
            border-radius: 14px;
            padding: 10px 16px;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.88rem;
            box-shadow: 0 6px 20px rgba(91, 63, 168, 0.28);
            transition: all 0.2s ease;
        }
        .rentout-publish-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(91, 63, 168, 0.38);
            color: #ffffff;
        }
        .rentout-publish-btn:active {
            transform: translateY(0);
        }
        .rentout-publish-btn.disabled,
        .rentout-publish-btn:disabled {
            background: #94A3B8 !important;
            border-color: #94A3B8 !important;
            color: #FFFFFF !important;
            box-shadow: none !important;
            cursor: not-allowed !important;
            opacity: 0.75 !important;
            transform: none !important;
        }
        .rentout-nav-pills {
            background: #F1F5F9;
            border-radius: 999px;
            padding: 3px;
            border: 1px solid #E2E8F0;
        }
        .rentout-subtab-btn {
            border-radius: 999px !important;
            padding: 6px 12px !important;
            font-size: 0.78rem !important;
            font-weight: 700 !important;
            border: none !important;
            transition: all 0.2s ease;
        }
    </style>

    <!-- Top Action Header (Compact & Minimized) -->
    <div class="d-flex align-items-center justify-content-between mb-2 pt-1">
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs border" 
                style="width:32px; height:32px; background:#fff;" onclick="switchTab('home')" title="Back to Home">
            <i class="fa-solid fa-arrow-left text-dark" style="font-size:0.75rem;"></i>
        </button>
        <div class="text-center">
            <h6 class="fw-bold mb-0 text-dark fs-7" style="letter-spacing:-0.2px;">Lender Studio</h6>
            <span class="text-muted fw-semibold" style="font-size:0.68rem;">Equipment Owner Management</span>
        </div>
        <div style="width:32px;"></div>
    </div>

    <!-- Mode Switcher: Prepare Orders vs Post New Equipment -->
    <div class="rentout-nav-pills d-flex align-items-center mb-2.5 shadow-2xs gap-1">
        <button type="button" class="btn btn-sm flex-grow-1 rentout-subtab-btn d-flex align-items-center justify-content-center gap-1.5 text-secondary" 
                id="btnRentoutTabPrepare" 
                style="background:transparent;" 
                onclick="switchRentOutSubTab('prepare')">
            <i class="fa-solid fa-boxes-packing fs-9"></i>
            <span>Orders to Prepare</span>
            <span class="badge rounded-pill bg-danger text-white fw-bold ms-0.5" id="rentoutPendingBadge" style="display:none; font-size:0.62rem; padding: 2px 5px;">0</span>
        </button>
        <button type="button" class="btn btn-sm flex-grow-1 rentout-subtab-btn active text-white d-flex align-items-center justify-content-center gap-1.5" 
                id="btnRentoutTabPost" 
                style="background: linear-gradient(135deg, #5B3FA8, #341F97); box-shadow: 0 2px 8px rgba(91, 63, 168, 0.25);" 
                onclick="switchRentOutSubTab('post')">
            <i class="fa-solid fa-plus-circle fs-9"></i>
            <span>Post Equipment</span>
        </button>
    </div>

    <!-- ==========================================================
         MODE 1: ORDERS TO PREPARE & FULFILL (STOCK OWNER ACTION)
         ========================================================== -->
    <div id="rentoutSectionPrepare" class="flex-column gap-2 mb-3" style="display:none;">
        <!-- Compact Status Bar -->
        <div class="p-2 px-3 rounded-pill bg-white border d-flex align-items-center justify-content-between shadow-2xs">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:24px; height:24px; background:linear-gradient(135deg, #5B3FA8, #341F97); font-size:0.7rem;">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>
                <span class="fw-bold text-dark fs-8">Fulfillment Hub</span>
                <span class="text-muted d-none d-sm-inline" style="font-size:0.7rem;">• Inspect & dispatch</span>
            </div>
            <div class="d-flex align-items-center gap-1 px-2 py-0.5 rounded-pill bg-success bg-opacity-10 border border-success-subtle">
                <span class="rounded-circle bg-success d-inline-block" style="width:5px; height:5px; box-shadow: 0 0 5px #10B981;"></span>
                <span class="fw-bold text-success" style="letter-spacing: 0.4px; font-size: 0.62rem;">LIVE</span>
            </div>
        </div>

        <!-- Dynamic Container For Incoming Orders Needing Packaging/Dispatch -->
        <div id="rentoutPrepareListContainer" class="d-flex flex-column gap-2">
            <div class="card border-0 rounded-4 shadow-2xs p-3.5 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-1.5" style="width:40px; height:40px; color:#5B3FA8;">
                    <i class="fa-solid fa-inbox fs-5"></i>
                </div>
                <h6 class="fw-bold text-dark fs-8 mb-0.5">No Orders Awaiting Preparation</h6>
                <p class="text-muted mb-0" style="font-size:0.72rem;">When students rent your equipment, bookings appear here to inspect and hand off to fleet drivers.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================================
         MODE 2: POST NEW EQUIPMENT FOR RENT (CLEAN & MINIMIZED)
         ========================================================== -->
    <div id="rentoutSectionPost" class="flex-column gap-2.5 mb-3" style="display:flex;">

        <!-- Minimized Sleek Promo Strip (No awkward overflowing tags) -->
        <div class="rentout-mini-hero px-3 py-2 text-white d-flex align-items-center justify-content-between mb-1">
            <div class="d-flex align-items-center gap-2 text-truncate">
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="background: rgba(255,255,255,0.2); width:28px; height:28px; flex-shrink:0;">
                    <i class="fa-solid fa-hand-holding-dollar text-warning fs-8"></i>
                </div>
                <div class="text-truncate">
                    <div class="fw-bold fs-8 leading-tight">Monetize Your Campus Gear</div>
                    <div class="text-white-50 text-truncate" style="font-size:0.68rem;">Earn daily rental income from idle sound, tents, cameras & tables</div>
                </div>
            </div>
            <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-2 py-1 fw-semibold flex-shrink-0 ms-2" style="font-size:0.66rem;">
                <i class="fa-solid fa-shield-halved text-warning me-1"></i>Verified
            </span>
        </div>

        <!-- Minimized User Verification Required Alert -->
        <div id="sellVerificationBanner" class="p-2 px-3 rounded-3 shadow-2xs mb-1" style="display:none; background:#FFFBEB; border: 1px solid #FDE68A;">
            <div class="d-flex align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-warning fs-7"></i>
                    <div>
                        <div class="fw-bold text-dark fs-8 leading-tight">Account Verification Required</div>
                        <div class="text-muted" style="font-size:0.68rem;">Verify student ID to list equipment safely</div>
                    </div>
                </div>
                <button type="button" class="btn btn-warning btn-sm rounded-pill px-2.5 py-0.5 fw-bold text-dark flex-shrink-0" style="font-size:0.72rem;" onclick="openVerificationModal()">
                    Verify Profile
                </button>
            </div>
        </div>

        <!-- Section 1: Equipment Identification & Specs -->
        <div class="rentout-section-card p-3">
            <div class="rentout-section-header">
                <div class="rentout-icon-box" style="background:#EDE9FE; color:#5B3FA8;">
                    <i class="fa-solid fa-cube"></i>
                </div>
                <div>
                    <span class="fw-bold fs-8 text-dark d-block leading-tight">Equipment Details</span>
                    <span class="text-muted" style="font-size:0.68rem;">What item are you offering for rent?</span>
                </div>
            </div>

            <!-- Title -->
            <div class="mb-2">
                <label class="rentout-input-label" for="sellTitle">
                    <span>Title / Name <span class="text-danger">*</span></span>
                    <span class="text-muted fw-normal" style="font-size:0.68rem;">e.g. JBL PartyBox 310</span>
                </label>
                <input type="text" class="form-control rentout-control" id="sellTitle"
                       placeholder="e.g. JBL PartyBox 310, White Tiffany Chairs (Set of 10)">
            </div>

            <!-- Category & Material -->
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="rentout-input-label" for="sellCategory">
                        <span>Category <span class="text-danger">*</span></span>
                    </label>
                    <select class="form-select rentout-control" id="sellCategory">
                        <option value="Chairs">Chairs</option>
                        <option value="Tables">Tables</option>
                        <option value="Tents">Tents</option>
                        <option value="Sound System">Sound System</option>
                        <option value="Lights">Lights</option>
                        <option value="Decorations">Decorations</option>
                        <option value="Stages">Stages</option>
                        <option value="Others" selected>Others</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="rentout-input-label" for="sellMaterialTag">
                        <span>Material / Type</span>
                    </label>
                    <select class="form-select rentout-control" id="sellMaterialTag">
                        <option value="All">Standard</option>
                        <option value="Plastic" selected>Plastic</option>
                        <option value="Wooden">Wooden</option>
                        <option value="Premium">Premium</option>
                        <option value="Metal">Metal / Steel</option>
                        <option value="Fabric">Fabric / Linen</option>
                        <option value="Electronics">Electronics</option>
                    </select>
                </div>
            </div>

            <!-- Condition & Location -->
            <div class="row g-2">
                <div class="col-5">
                    <label class="rentout-input-label" for="sellCondition">
                        <span>Condition</span>
                    </label>
                    <select class="form-select rentout-control" id="sellCondition">
                        <option value="Brand New">Brand New</option>
                        <option value="Like New" selected>Like New</option>
                        <option value="Good">Good</option>
                        <option value="Fair">Fair</option>
                    </select>
                </div>
                <div class="col-7">
                    <label class="rentout-input-label" for="sellMeetup">
                        <span>Pickup Hub</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 py-1 px-2" style="border-radius:10px 0 0 10px; border-color:#E2E8F0;">
                            <i class="fa-solid fa-location-dot fs-9" style="color:#5B3FA8;"></i>
                        </span>
                        <input type="text" class="form-control rentout-control border-start-0 py-1" id="sellMeetup" 
                               value="San Pablo, Laguna" placeholder="Campus Hub / Gate 1" style="border-radius:0 10px 10px 0;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Rental Rate, Units & Posting Fee Tier -->
        <div class="rentout-section-card p-3">
            <div class="rentout-section-header">
                <div class="rentout-icon-box" style="background:#DCFCE7; color:#16A34A;">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <span class="fw-bold fs-8 text-dark d-block leading-tight">Rate & Stock</span>
                    <span class="text-muted" style="font-size:0.68rem;">Daily rental price and inventory quantity</span>
                </div>
            </div>

            <!-- Pricing & Quantity Side-by-Side -->
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="rentout-input-label" for="sellPrice">
                        <span>Daily Rate (₱) <span class="text-danger">*</span></span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white fw-bold border-end-0 py-1 px-2.5 fs-8" style="border-radius:10px 0 0 10px; border-color:#E2E8F0; color:#5B3FA8 !important;">₱</span>
                        <input type="number" class="form-control rentout-control border-start-0 fw-bold fs-7 text-dark py-1" 
                               id="sellPrice" value="100" min="1" oninput="updateSellPostingFeeTier(this.value)" style="border-radius:0 10px 10px 0;">
                    </div>
                </div>
                <div class="col-6">
                    <label class="rentout-input-label" for="sellQuantity">
                        <span>Stock Units <span class="text-danger">*</span></span>
                    </label>
                    <div class="input-group">
                        <input type="number" class="form-control rentout-control fw-bold fs-7 text-dark py-1" 
                               id="sellQuantity" value="10" min="1" placeholder="Qty">
                        <span class="input-group-text bg-white text-muted border-start-0 py-1 px-2" style="border-radius:0 10px 10px 0; border-color:#E2E8F0; font-size:0.7rem;">Units</span>
                    </div>
                </div>
            </div>

            <!-- Sleek Inline Posting Fee Pill (Compact & Informative) -->
            <div id="sellPostingFeeContainer" class="rentout-fee-banner d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-receipt text-primary fs-9"></i>
                    <span class="text-dark fw-bold" style="font-size:0.72rem;">Platform Fee:</span>
                </div>
                <span class="badge rounded-pill fw-bold px-2.5 py-1" id="sellPostingFeeBadge" 
                      style="background:#7C3AED; color:#ffffff; font-size:0.7rem;">
                    ₱15.00 (Tier: ₱100 - ₱500)
                </span>
            </div>
        </div>

        <!-- Section 3: Description & Inclusions -->
        <div class="rentout-section-card p-3">
            <div class="rentout-section-header">
                <div class="rentout-icon-box" style="background:#E0F2FE; color:#0284C7;">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div>
                    <span class="fw-bold fs-8 text-dark d-block leading-tight">Description</span>
                    <span class="text-muted" style="font-size:0.68rem;">Accessories, condition, or usage guidelines</span>
                </div>
            </div>

            <div>
                <textarea class="form-control rentout-control" id="sellDescription" rows="2" 
                          placeholder="e.g. Includes power cords and protective carry case. Tested & disinfected."></textarea>
            </div>
        </div>

        <!-- Section 4: Media Showcase (Photos & Optional Video) -->
        <div class="rentout-section-card p-3">
            <div class="rentout-section-header">
                <div class="rentout-icon-box" style="background:#FEE2E2; color:#DC2626;">
                    <i class="fa-solid fa-camera"></i>
                </div>
                <div>
                    <span class="fw-bold fs-8 text-dark d-block leading-tight">Photos & Video</span>
                    <span class="text-muted" style="font-size:0.68rem;">Upload pictures of your equipment</span>
                </div>
            </div>

            <!-- Compact Photos Dropzone -->
            <div class="mb-2">
                <div class="rentout-dropzone d-flex align-items-center justify-content-between p-2.5" onclick="document.getElementById('sellPhotosInput').click()">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-primary" 
                             style="width:32px; height:32px; background:#EDE9FE;">
                            <i class="fa-solid fa-cloud-arrow-up fs-8"></i>
                        </div>
                        <div class="text-start">
                            <div class="fw-bold fs-8 text-dark leading-tight">Upload Equipment Photos</div>
                            <div class="text-muted" style="font-size:0.68rem;">Tap to select PNG, JPG, or WebP</div>
                        </div>
                    </div>
                    <span class="badge rounded-pill bg-white text-primary border px-2.5 py-1 fw-bold shadow-2xs" style="font-size:0.7rem;">
                        <i class="fa-solid fa-images me-1"></i>Browse
                    </span>
                </div>

                <!-- Hidden File Input -->
                <input type="file" class="d-none" id="sellPhotosInput" accept="image/*" multiple onchange="previewSellPhotos(event)">
                
                <!-- Direct URL Input (Slim) -->
                <div class="input-group mt-1.5">
                    <span class="input-group-text bg-white text-muted border-end-0 py-1 px-2" style="border-radius:10px 0 0 10px; border-color:#E2E8F0; font-size:0.7rem;">
                        <i class="fa-solid fa-link"></i>
                    </span>
                    <input type="text" class="form-control rentout-control border-start-0 py-1 fs-9" id="sellPhotoUrlInput" 
                           placeholder="or paste image URL (https://...)" style="border-radius:0 10px 10px 0;">
                </div>

                <!-- Preview Grid -->
                <div class="d-flex gap-2 flex-wrap mt-2" id="sellPhotosPreviewGrid"></div>
            </div>

            <!-- Demonstration Video (Collapsible to save vertical space) -->
            <div class="pt-2 border-top">
                <div class="d-flex align-items-center justify-content-between" style="cursor:pointer;" 
                     onclick="const box=document.getElementById('sellVideoCollapseBox'); const icon=document.getElementById('sellVideoToggleIcon'); if(box.style.display==='none'){box.style.display='block'; icon.className='fa-solid fa-chevron-up text-muted fs-9';}else{box.style.display='none'; icon.className='fa-solid fa-chevron-down text-muted fs-9';}">
                    <span class="fw-bold text-dark" style="font-size:0.74rem;">
                        <i class="fa-solid fa-film text-danger me-1"></i> Demonstration Video <span class="badge bg-light text-secondary border fw-normal" style="font-size:0.62rem;">Optional</span>
                    </span>
                    <i class="fa-solid fa-chevron-down text-muted fs-9" id="sellVideoToggleIcon"></i>
                </div>

                <div id="sellVideoCollapseBox" style="display:none;" class="mt-2 pt-1">
                    <div class="d-flex gap-1.5 mb-1.5">
                        <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 text-dark shadow-2xs fw-bold" style="font-size:0.72rem;" 
                                onclick="document.getElementById('sellVideoFileInput').click()">
                            <i class="fa-solid fa-video me-1 text-danger"></i> Choose Video File
                        </button>
                        <input type="file" class="d-none" id="sellVideoFileInput" accept="video/*" onchange="handleSellVideoUpload(event)">
                    </div>

                    <input type="text" class="form-control rentout-control py-1 fs-9" id="sellVideoUrlInput" 
                           placeholder="or paste video URL (https://.../demo.mp4)">

                    <!-- Preview Container -->
                    <div id="sellVideoPreviewContainer" class="mt-2" style="display:none;">
                        <video id="sellVideoPreview" controls class="w-100 rounded-3 shadow-sm" style="max-height:160px; background:#000; object-fit:contain;"></video>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Locked Alert Box (Above Publish CTA) -->
        <div id="sellPublishVerificationWarning" class="p-2.5 px-3 rounded-3 shadow-2xs mb-2 border border-warning-subtle text-dark" style="display:none; background:#FFFBEB;">
            <div class="d-flex align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-lock text-warning fs-7 flex-shrink-0"></i>
                    <div>
                        <div class="fw-bold fs-9 text-dark leading-tight">Verification Required to Publish</div>
                        <div class="text-muted" style="font-size:0.68rem;">Only admin-verified student accounts can list equipment for rent.</div>
                    </div>
                </div>
                <button type="button" class="btn btn-warning btn-sm rounded-pill px-2.5 py-1 fw-bold text-dark flex-shrink-0 fs-9 shadow-xs" onclick="openVerificationModal()">
                    Verify Now
                </button>
            </div>
        </div>

        <!-- Final CTA Button -->
        <button type="button" class="btn rentout-publish-btn w-100 d-flex align-items-center justify-content-center gap-2 mb-1" 
                id="btnPublishRentalItem"
                onclick="postRentalItemLive()">
            <i class="fa-solid fa-paper-plane fs-8"></i> <span>Publish Equipment for Rent</span>
        </button>

        <!-- Lender Protection Note (Clean & Minimal) -->
        <div class="text-center text-muted py-1" style="font-size:0.7rem;">
            <i class="fa-solid fa-shield-check text-success me-1"></i> Verified student renters & signed inspection agreement
        </div>

    </div> <!-- End rentoutSectionPost -->

</div>

<script>
window.switchRentOutSubTab = function(mode) {
    const secPrep = document.getElementById('rentoutSectionPrepare');
    const secPost = document.getElementById('rentoutSectionPost');
    const btnPrep = document.getElementById('btnRentoutTabPrepare');
    const btnPost = document.getElementById('btnRentoutTabPost');

    if (mode === 'prepare') {
        if (secPrep) {
            secPrep.classList.remove('d-none');
            secPrep.style.setProperty('display', 'flex', 'important');
        }
        if (secPost) {
            secPost.classList.add('d-none');
            secPost.style.setProperty('display', 'none', 'important');
        }

        if (btnPrep) {
            btnPrep.classList.add('active', 'text-white');
            btnPrep.classList.remove('text-secondary');
            btnPrep.style.background = 'linear-gradient(135deg, #5B3FA8, #341F97)';
            btnPrep.style.boxShadow = '0 2px 8px rgba(91, 63, 168, 0.25)';
        }
        if (btnPost) {
            btnPost.classList.remove('active', 'text-white');
            btnPost.classList.add('text-secondary');
            btnPost.style.background = 'transparent';
            btnPost.style.boxShadow = 'none';
        }
        if (typeof loadOwnerRentalDashboard === 'function') {
            loadOwnerRentalDashboard(true);
        }
    } else {
        if (secPrep) {
            secPrep.classList.add('d-none');
            secPrep.style.setProperty('display', 'none', 'important');
        }
        if (secPost) {
            secPost.classList.remove('d-none');
            secPost.style.setProperty('display', 'flex', 'important');
        }

        if (btnPost) {
            btnPost.classList.add('active', 'text-white');
            btnPost.classList.remove('text-secondary');
            btnPost.style.background = 'linear-gradient(135deg, #5B3FA8, #341F97)';
            btnPost.style.boxShadow = '0 2px 8px rgba(91, 63, 168, 0.25)';
        }
        if (btnPrep) {
            btnPrep.classList.remove('active', 'text-white');
            btnPrep.classList.add('text-secondary');
            btnPrep.style.background = 'transparent';
            btnPrep.style.boxShadow = 'none';
        }
    }
};
</script>
