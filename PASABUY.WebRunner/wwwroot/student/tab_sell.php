<!-- ==========================================================
     RentEase: Post Equipment for Rent ("Rent Out") Tab
     Redesigned Modern Lender Studio UI
     ========================================================== -->
<div id="tabSell" style="display:none;" class="pb-5">

    <style>
        .rentout-hero-card {
            background: linear-gradient(135deg, #4A1D96 0%, #5B3FA8 60%, #341F97 100%);
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(91, 63, 168, 0.22);
            position: relative;
            overflow: hidden;
        }
        .rentout-hero-card::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .rentout-section-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #ECEFF5;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }
        .rentout-section-card:hover {
            box-shadow: 0 6px 24px rgba(91, 63, 168, 0.06);
        }
        .rentout-section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid #F1F5F9;
        }
        .rentout-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .rentout-input-label {
            font-size: 0.76rem;
            font-weight: 800;
            color: #1E293B;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .rentout-control {
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            padding: 9px 12px;
            font-size: 0.84rem;
            transition: all 0.2s ease;
            background-color: #FAFAFC;
        }
        .rentout-control:focus {
            background-color: #FFFFFF;
            border-color: #5B3FA8;
            box-shadow: 0 0 0 3.5px rgba(91, 63, 168, 0.12);
            outline: none;
        }
        .rentout-dropzone {
            border: 2px dashed #C4B5FD;
            background: #FAF5FF;
            border-radius: 16px;
            padding: 20px 14px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .rentout-dropzone:hover {
            background: #F3E8FF;
            border-color: #8B5CF6;
        }
        .rentout-fee-banner {
            background: linear-gradient(135deg, #FAF5FF 0%, #F3E8FF 100%);
            border: 1.5px solid #E9D5FF;
            border-radius: 14px;
            padding: 12px 14px;
        }
        .rentout-publish-btn {
            background: linear-gradient(135deg, #5B3FA8 0%, #341F97 100%);
            border: none;
            border-radius: 16px;
            padding: 14px 20px;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.92rem;
            box-shadow: 0 8px 24px rgba(91, 63, 168, 0.32);
            transition: all 0.25s ease;
        }
        .rentout-publish-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(91, 63, 168, 0.42);
            color: #ffffff;
        }
        .rentout-publish-btn:active {
            transform: translateY(0);
        }
    </style>

    <!-- Top Action Header -->
    <div class="d-flex align-items-center justify-content-between mb-3 pt-1">
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs border" 
                style="width:36px; height:36px; background:#fff;" onclick="switchTab('home')" title="Back to Home">
            <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
        </button>
        <div class="text-center">
            <h5 class="fw-extrabold mb-0 text-dark fs-6" style="letter-spacing:-0.3px;">Lender Studio</h5>
            <span class="fs-9 text-muted fw-bold">Equipment Owner Management</span>
        </div>
        <div style="width:36px;"></div>
    </div>

    <!-- Stock Owner Studio Mode Switcher: Prepare Orders vs Post New Equipment -->
    <div class="bg-light p-1.5 rounded-4 d-flex align-items-center mb-3 border shadow-2xs gap-1">
        <button type="button" class="btn btn-sm rounded-pill flex-grow-1 py-2 px-2 fw-extrabold fs-9 d-flex align-items-center justify-content-center gap-1.5 rentout-subtab-btn active text-white" 
                id="btnRentoutTabPrepare" 
                style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" 
                onclick="switchRentOutSubTab('prepare')">
            <i class="fa-solid fa-boxes-packing"></i>
            <span>Orders to Prepare</span>
            <span class="badge rounded-pill bg-danger text-white fw-bold fs-9 ms-0.5" id="rentoutPendingBadge" style="display:none; font-size:0.65rem;">0</span>
        </button>
        <button type="button" class="btn btn-sm rounded-pill flex-grow-1 py-2 px-2 fw-bold fs-9 d-flex align-items-center justify-content-center gap-1.5 rentout-subtab-btn text-secondary" 
                id="btnRentoutTabPost" 
                style="background:transparent; border:none;" 
                onclick="switchRentOutSubTab('post')">
            <i class="fa-solid fa-plus-circle"></i>
            <span>Post Equipment</span>
        </button>
    </div>

    <!-- ==========================================================
         MODE 1: ORDERS TO PREPARE & FULFILL (STOCK OWNER ACTION)
         ========================================================== -->
    <div id="rentoutSectionPrepare" class="d-flex flex-column gap-3 mb-4">
        <div class="p-3 rounded-4 bg-primary bg-opacity-10 border border-primary-subtle d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs" style="width:34px; height:34px; background:linear-gradient(135deg, #5B3FA8, #341F97) !important;">
                    <i class="fa-solid fa-boxes-packing fs-7"></i>
                </div>
                <div>
                    <h6 class="fw-extrabold text-dark fs-8 mb-0">Stock Owner Fulfillment Hub</h6>
                    <span class="fs-9 text-muted">Inspect & package equipment, then notify fleet drivers</span>
                </div>
            </div>
            <button class="btn btn-sm btn-light rounded-pill px-2.5 py-1 fs-9 fw-bold border text-primary" onclick="loadOwnerRentalDashboard(true)">
                <i class="fa-solid fa-rotate-right me-1"></i> Refresh
            </button>
        </div>

        <!-- Dynamic Container For Incoming Orders Needing Packaging/Dispatch -->
        <div id="rentoutPrepareListContainer" class="d-flex flex-column gap-3">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width:50px; height:50px; color:#5B3FA8;">
                    <i class="fa-solid fa-inbox fs-4"></i>
                </div>
                <h6 class="fw-bold text-dark fs-8 mb-1">No Orders Awaiting Preparation</h6>
                <p class="text-muted fs-9 mb-0">When students rent your equipment, their orders will appear here for you to package, inspect, and notify fleet drivers.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================================
         MODE 2: POST NEW EQUIPMENT FOR RENT
         ========================================================== -->
    <div id="rentoutSectionPost" style="display:none;">

    <!-- Promo Hero Card -->
    <div class="rentout-hero-card p-3.5 text-white mb-3">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                 style="background: rgba(255,255,255,0.22); width:48px; height:48px; flex-shrink:0;">
                <i class="fa-solid fa-hand-holding-dollar text-warning fs-4"></i>
            </div>
            <div>
                <h6 class="fw-extrabold mb-1 fs-7">Monetize Your Campus Equipment</h6>
                <p class="fs-9 text-white-50 mb-2">Turn idle sound systems, chairs, tables, tents, or camera gear into steady daily rental earnings.</p>
                <div class="d-flex gap-1.5 flex-wrap">
                    <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-2 py-0.5 fs-9 fw-semibold">
                        <i class="fa-solid fa-shield-halved text-warning me-1"></i> ID Verified Renters
                    </span>
                    <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-2 py-0.5 fs-9 fw-semibold">
                        <i class="fa-solid fa-bolt text-warning me-1"></i> Direct Payout
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- User Verification Required Banner -->
    <div id="sellVerificationBanner" class="alert alert-warning border-0 rounded-4 shadow-sm p-3 mb-3" style="display:none; background:#FFFBEB; border-left: 4px solid #F59E0B !important;">
        <div class="d-flex align-items-start gap-2.5">
            <i class="fa-solid fa-shield-halved text-warning fs-5 mt-0.5"></i>
            <div>
                <h6 class="fw-extrabold text-dark fs-7 mb-0.5">Account Verification Required to List Equipment</h6>
                <p class="fs-9 text-muted mb-2">Only verified campus lenders can post items for rent to protect renter deposits and ensure equipment safety.</p>
                <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 py-1 fs-8 fw-bold text-dark shadow-2xs" onclick="switchTab('profile')">
                    <i class="fa-solid fa-id-card me-1"></i> Submit Account Verification in Profile
                </button>
            </div>
        </div>
    </div>

    <!-- Card 1: Equipment Identification & Specs -->
    <div class="rentout-section-card p-3.5 mb-3">
        <div class="rentout-section-header">
            <div class="rentout-icon-box" style="background:#EDE9FE; color:#5B3FA8;">
                <i class="fa-solid fa-cube"></i>
            </div>
            <div>
                <span class="fw-extrabold fs-7 text-dark d-block leading-tight">Equipment Details</span>
                <span class="fs-9 text-muted">What item are you offering for rent?</span>
            </div>
        </div>

        <!-- 1. Equipment Title -->
        <div class="mb-3">
            <label class="rentout-input-label" for="sellTitle">
                <span>Equipment Name / Title <span class="text-danger">*</span></span>
                <span class="text-muted fw-normal fs-9">Clear & descriptive</span>
            </label>
            <input type="text" class="form-control rentout-control" id="sellTitle"
                   placeholder="e.g. JBL PartyBox 310 Sound System, White Tiffany Chairs (Set of 10)">
        </div>

        <!-- 2. Category & Material -->
        <div class="row g-2.5 mb-3">
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

        <!-- 3. Condition & Location -->
        <div class="row g-2.5">
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
                    <span>Pickup Location</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-secondary" style="border-radius:12px 0 0 12px; border-color:#E2E8F0;">
                        <i class="fa-solid fa-location-dot" style="color:#5B3FA8;"></i>
                    </span>
                    <input type="text" class="form-control rentout-control border-start-0" id="sellMeetup" 
                           value="San Pablo, Laguna" placeholder="Campus Hub / Gate 1" style="border-radius:0 12px 12px 0;">
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Rental Rate, Units & Posting Fee Tier -->
    <div class="rentout-section-card p-3.5 mb-3">
        <div class="rentout-section-header">
            <div class="rentout-icon-box" style="background:#DCFCE7; color:#16A34A;">
                <i class="fa-solid fa-coins"></i>
            </div>
            <div>
                <span class="fw-extrabold fs-7 text-dark d-block leading-tight">Rates & Inventory</span>
                <span class="fs-9 text-muted">Set your rental rate per day and available stock</span>
            </div>
        </div>

        <!-- Pricing & Quantity Side-by-Side -->
        <div class="row g-2.5 mb-2.5">
            <div class="col-6">
                <label class="rentout-input-label" for="sellPrice">
                    <span>Daily Rate (₱) <span class="text-danger">*</span></span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white fw-bold text-dark border-end-0 fs-7" style="border-radius:12px 0 0 12px; border-color:#E2E8F0; color:#5B3FA8 !important;">₱</span>
                    <input type="number" class="form-control rentout-control border-start-0 fw-extrabold fs-6 text-dark" 
                           id="sellPrice" value="100" min="1" oninput="updateSellPostingFeeTier(this.value)" style="border-radius:0 12px 12px 0;">
                </div>
                <span class="fs-9 text-muted mt-1 d-block">Charged per day</span>
            </div>
            <div class="col-6">
                <label class="rentout-input-label" for="sellQuantity">
                    <span>Available Stock <span class="text-danger">*</span></span>
                </label>
                <div class="input-group">
                    <input type="number" class="form-control rentout-control fw-extrabold fs-6 text-dark" 
                           id="sellQuantity" value="10" min="1" placeholder="Units">
                    <span class="input-group-text bg-white text-muted border-start-0 fs-9" style="border-radius:0 12px 12px 0; border-color:#E2E8F0;">Units</span>
                </div>
                <span class="fs-9 text-muted mt-1 d-block">Total equipment units</span>
            </div>
        </div>

        <!-- Transparent Full-Width Posting Fee Breakdown (Never Squished) -->
        <div id="sellPostingFeeContainer" class="rentout-fee-banner mt-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-2xs" 
                         style="width:34px; height:34px; background:#7C3AED; color:#ffffff; flex-shrink:0;">
                        <i class="fa-solid fa-receipt fs-8"></i>
                    </div>
                    <div>
                        <div class="fs-8 fw-extrabold text-dark leading-tight">Transparent Platform Fee</div>
                        <div class="fs-9 text-muted">Tiered student listing coverage</div>
                    </div>
                </div>
                <span class="badge rounded-pill fw-extrabold px-3 py-1.5 shadow-2xs" id="sellPostingFeeBadge" 
                      style="background:#7C3AED; color:#ffffff; font-size:0.75rem; letter-spacing:0.3px;">
                    ₱15.00 (Tier: ₱100 - ₱500)
                </span>
            </div>
        </div>
    </div>

    <!-- Card 3: Description & Inclusions -->
    <div class="rentout-section-card p-3.5 mb-3">
        <div class="rentout-section-header">
            <div class="rentout-icon-box" style="background:#E0F2FE; color:#0284C7;">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <div>
                <span class="fw-extrabold fs-7 text-dark d-block leading-tight">Description & Inclusions</span>
                <span class="fs-9 text-muted">Accessories, cables, rules, or condition remarks</span>
            </div>
        </div>

        <div class="mb-1">
            <textarea class="form-control rentout-control" id="sellDescription" rows="3" 
                      placeholder="e.g. Complete with protective padded covers, 10m power cord, and audio auxiliary adapter. Tested and disinfected before every booking."></textarea>
        </div>
    </div>

    <!-- Card 4: Media Showcase (Photos & Video) -->
    <div class="rentout-section-card p-3.5 mb-4">
        <div class="rentout-section-header">
            <div class="rentout-icon-box" style="background:#FEE2E2; color:#DC2626;">
                <i class="fa-solid fa-camera-retro"></i>
            </div>
            <div>
                <span class="fw-extrabold fs-7 text-dark d-block leading-tight">Media Showcase</span>
                <span class="fs-9 text-muted">Add clear equipment photos & optional demonstration video</span>
            </div>
        </div>

        <!-- Modern Photos Dropzone -->
        <div class="mb-3">
            <label class="rentout-input-label">
                <span>Equipment Photos <span class="text-danger">*</span></span>
                <span class="text-muted fw-normal fs-9">PNG, JPG, WebP supported</span>
            </label>
            
            <div class="rentout-dropzone mb-2" onclick="document.getElementById('sellPhotosInput').click()">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow-2xs" 
                     style="width:46px; height:46px; background:#EDE9FE; color:#5B3FA8;">
                    <i class="fa-solid fa-cloud-arrow-up fs-5"></i>
                </div>
                <h6 class="fw-extrabold fs-8 text-dark mb-0.5">Tap to Select Equipment Photos</h6>
                <p class="fs-9 text-muted mb-2">High-res photos get up to 3x more bookings</p>
                <span class="badge rounded-pill bg-white text-dark border px-3 py-1 fs-9 fw-bold shadow-2xs">
                    <i class="fa-solid fa-images me-1 text-primary"></i> Browse Gallery
                </span>
            </div>

            <!-- Hidden File Input (controlled by dropzone) -->
            <input type="file" class="d-none" id="sellPhotosInput" accept="image/*" multiple onchange="previewSellPhotos(event)">
            
            <!-- Direct URL Fallback Input -->
            <div class="input-group">
                <span class="input-group-text bg-white text-muted border-end-0 fs-9" style="border-radius:12px 0 0 12px; border-color:#E2E8F0;">
                    <i class="fa-solid fa-link"></i>
                </span>
                <input type="text" class="form-control rentout-control border-start-0 fs-8" id="sellPhotoUrlInput" 
                       placeholder="or paste direct Image URL (https://images.unsplash.com/...)" style="border-radius:0 12px 12px 0;">
            </div>

            <!-- Dynamic Image Preview Grid -->
            <div class="d-flex gap-2 flex-wrap mt-2.5" id="sellPhotosPreviewGrid">
                <!-- Populated dynamically via JS previewSellPhotos() -->
            </div>
        </div>

        <!-- Video Demonstration Showcase (Optional) -->
        <div class="pt-2 border-top">
            <label class="rentout-input-label mt-1">
                <span><i class="fa-solid fa-video text-danger me-1"></i> Demonstration Video <span class="badge bg-light text-secondary border fw-normal fs-9">Optional</span></span>
                <span class="text-muted fw-normal fs-9">Short MP4 clip</span>
            </label>

            <div class="d-flex gap-2 mb-2">
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 fs-8 fw-bold text-dark shadow-2xs" 
                        onclick="document.getElementById('sellVideoFileInput').click()">
                    <i class="fa-solid fa-film me-1 text-danger"></i> Choose Video File
                </button>
                <input type="file" class="d-none" id="sellVideoFileInput" accept="video/*" onchange="handleSellVideoUpload(event)">
            </div>

            <input type="text" class="form-control rentout-control fs-8" id="sellVideoUrlInput" 
                   placeholder="or paste direct video URL (e.g. https://.../demo.mp4)">

            <!-- Live Video Player Preview Container -->
            <div id="sellVideoPreviewContainer" class="mt-2.5" style="display:none;">
                <video id="sellVideoPreview" controls class="w-100 rounded-3 shadow-sm" style="max-height:190px; background:#000; object-fit:contain;"></video>
            </div>
        </div>
    </div>

    <!-- Final CTA Button & Guarantees -->
    <button type="button" class="btn rentout-publish-btn w-100 d-flex align-items-center justify-content-center gap-2 mb-3" 
            id="btnPublishRentalItem"
            onclick="postRentalItemLive()">
        <i class="fa-solid fa-paper-plane fs-7"></i> <span>Publish Equipment for Rent</span>
    </button>

    <div class="p-3 rounded-4 bg-light border text-center shadow-2xs">
        <div class="d-flex align-items-center justify-content-center gap-2 text-dark fs-8 fw-bold mb-1">
            <i class="fa-solid fa-shield-check text-success fs-7"></i> RentEase Lender Protection
        </div>
        <p class="text-muted fs-9 mb-0">
            Listed immediately in live search. Renter identity is validated with student ID & signed inspection agreement.
        </p>
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
        if (secPrep) secPrep.style.display = 'flex';
        if (secPost) secPost.style.display = 'none';

        if (btnPrep) {
            btnPrep.classList.add('active', 'text-white');
            btnPrep.classList.remove('text-secondary');
            btnPrep.style.background = 'linear-gradient(135deg, #5B3FA8, #341F97)';
        }
        if (btnPost) {
            btnPost.classList.remove('active', 'text-white');
            btnPost.classList.add('text-secondary');
            btnPost.style.background = 'transparent';
        }
        if (typeof loadOwnerRentalDashboard === 'function') {
            loadOwnerRentalDashboard(true);
        }
    } else {
        if (secPrep) secPrep.style.display = 'none';
        if (secPost) secPost.style.display = 'block';

        if (btnPost) {
            btnPost.classList.add('active', 'text-white');
            btnPost.classList.remove('text-secondary');
            btnPost.style.background = 'linear-gradient(135deg, #5B3FA8, #341F97)';
        }
        if (btnPrep) {
            btnPrep.classList.remove('active', 'text-white');
            btnPrep.classList.add('text-secondary');
            btnPrep.style.background = 'transparent';
        }
    }
};
</script>
