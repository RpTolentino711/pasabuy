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
                <p class="text-muted mb-0" style="font-size:0.72rem;">When students rent your equipment, bookings appear here to inspect and coordinate face-to-face campus handover.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================================
         MODE 2: POST NEW EQUIPMENT FOR RENT (CLEAN & MINIMIZED)
         ========================================================== -->
    <div id="rentoutSectionPost" class="flex-column gap-2.5 mb-3" style="display:flex;">

        <!-- Minimized Sleek Promo Strip -->
        <div class="rentout-mini-hero px-3 py-2 text-white d-flex align-items-center mb-1">
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

            <!-- Condition (Pickup Hub removed: In-Campus Handover via In-App Chat) -->
            <div class="mb-0">
                <label class="rentout-input-label" for="sellCondition">
                    <span>Condition</span>
                </label>
                <select class="form-select rentout-control" id="sellCondition">
                    <option value="Brand New">Brand New</option>
                    <option value="Like New" selected>Like New</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                </select>
                <div class="d-flex align-items-center gap-1.5 mt-1.5 text-muted px-1" style="font-size:0.7rem;">
                    <i class="fa-solid fa-comments text-primary fs-8"></i>
                    <span><strong>Campus Handover:</strong> Coordinate pickup &amp; return directly with renters via in-app chat.</span>
                </div>
                <!-- Hidden location for backend API compatibility -->
                <input type="hidden" id="sellMeetup" value="Campus / In-App Chat">
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
                               id="sellPrice" value="100" min="1" 
                               oninput="updateSellPostingFeeTier(this.value)" 
                               onkeyup="updateSellPostingFeeTier(this.value)" 
                               onchange="updateSellPostingFeeTier(this.value)" 
                               style="border-radius:0 10px 10px 0;">
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

        <!-- Final CTA Button: Triggers Review Modal -->
        <button type="button" class="btn rentout-publish-btn w-100 d-flex align-items-center justify-content-center gap-2 mb-1" 
                id="btnPublishRentalItem"
                onclick="openEquipmentReviewModal()">
            <i class="fa-solid fa-clipboard-check fs-8"></i> <span>Review &amp; Publish Equipment</span>
        </button>

        <!-- Lender Protection Note (Clean & Minimal) -->
        <div class="text-center text-muted py-1" style="font-size:0.7rem;">
            <i class="fa-solid fa-shield-check text-success me-1"></i> Verified student renters & signed inspection agreement
        </div>

    </div> <!-- End rentoutSectionPost -->

</div>

<!-- ==========================================================
     FINAL REVIEW EQUIPMENT LISTING MODAL
     Review all details before proceeding to payment
     ========================================================== -->
<div class="modal fade" id="modalReviewEquipmentListing" tabindex="-1" aria-labelledby="modalReviewEquipmentListingLabel" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:32px; height:32px; background:linear-gradient(135deg, #5B3FA8, #341F97);">
                        <i class="fa-solid fa-clipboard-check fs-8"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-dark fs-7 mb-0" id="modalReviewEquipmentListingLabel">Final Listing Review</h6>
                        <span class="text-muted" style="font-size:0.68rem;">Review your equipment details before payment</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-2 px-1">
                <!-- Equipment Summary Card -->
                <div class="card border-0 rounded-4 shadow-2xs p-2.5 bg-light mb-2.5 border">
                    <div class="d-flex gap-2.5 align-items-start">
                        <img id="reviewEquipmentImg" src="https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80" 
                             class="rounded-3 border shadow-2xs" 
                             style="width:72px; height:72px; object-fit:cover; flex-shrink:0;" 
                             alt="Equipment Preview">
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center gap-1.5 mb-1 flex-wrap">
                                <span class="badge bg-primary-subtle text-primary fw-bold fs-9" id="reviewEquipmentCategory">Chairs</span>
                                <span class="badge bg-white text-secondary border fs-9" id="reviewEquipmentMaterial">Plastic</span>
                                <span class="badge bg-success-subtle text-success fs-9 fw-bold" id="reviewEquipmentCondition">Brand New</span>
                            </div>
                            <h6 class="fw-extrabold text-dark fs-8 mb-1 text-truncate" id="reviewEquipmentTitle">Equipment Title</h6>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="fw-extrabold text-primary fs-7" id="reviewEquipmentRate">₱ 100</span>
                                <span class="text-muted" style="font-size:0.7rem;">/ day</span>
                                <span class="text-muted">•</span>
                                <span class="fw-bold text-dark fs-8" id="reviewEquipmentStock">10 Units</span>
                            </div>
                        </div>
                    </div>

                    <!-- Campus Handover Badge -->
                    <div class="d-flex align-items-center gap-1.5 mt-2 pt-2 border-top text-muted" style="font-size:0.7rem;">
                        <i class="fa-solid fa-comments text-primary fs-8"></i>
                        <span><strong>Campus Handover:</strong> Coordinate pickup &amp; return directly via in-app chat.</span>
                    </div>
                </div>

                <!-- Description Preview -->
                <div class="p-2.5 rounded-3 bg-white border mb-2.5 shadow-2xs">
                    <span class="text-muted d-block fw-bold mb-1" style="font-size:0.68rem; text-transform:uppercase; letter-spacing:0.5px;">Description &amp; Notes</span>
                    <p class="text-dark mb-0 fs-9 text-break" id="reviewEquipmentDesc" style="white-space: pre-line; max-height:80px; overflow-y:auto;">
                        No additional description provided.
                    </p>
                </div>

                <!-- Platform Posting Fee Card -->
                <div class="p-2.5 rounded-3 border d-flex align-items-center justify-content-between mb-1" style="background: rgba(91,63,168,0.06); border-color: rgba(91,63,168,0.2) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:28px; height:28px; background:#7C3AED; font-size:0.7rem;">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div>
                            <span class="fw-bold text-dark fs-8 d-block">Platform Posting Fee</span>
                            <span class="text-muted" style="font-size:0.65rem;">PayMongo Live Gateway • GCash / Maya</span>
                        </div>
                    </div>
                    <span class="fw-extrabold fs-7" style="color:#5B3FA8;" id="reviewEquipmentFee">₱15.00</span>
                </div>
            </div>

            <div class="modal-footer border-0 pt-2 d-flex gap-2">
                <button type="button" class="btn btn-light rounded-pill px-3 py-2 fs-8 fw-bold text-secondary flex-grow-1 border" data-bs-dismiss="modal">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Form
                </button>
                <button type="button" class="btn btn-primary rounded-pill px-3 py-2 fs-8 fw-extrabold text-white flex-grow-1 shadow-2xs" 
                        id="btnConfirmReviewAndPay"
                        style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" 
                        onclick="proceedFromReviewToPayment()">
                    <i class="fa-solid fa-credit-card me-1"></i> Proceed to Payment
                </button>
            </div>
        </div>
    </div>
</div>

<script>
window.updateSellPostingFeeTier = function(price) {
    const num = parseFloat(price);
    let fee = 15;
    let tier = '₱100 – ₱500';

    if (isNaN(num) || num <= 0) {
        fee = 10;
        tier = 'Under ₱100';
    } else if (num < 100) {
        fee = 10;
        tier = '₱1 – ₱99';
    } else if (num >= 100 && num <= 500) {
        fee = 15;
        tier = '₱100 – ₱500';
    } else if (num > 500 && num <= 1000) {
        fee = 20;
        tier = '₱501 – ₱1,000';
    } else if (num > 1000 && num <= 2500) {
        fee = 30;
        tier = '₱1,001 – ₱2,500';
    } else if (num > 2500 && num <= 5000) {
        fee = 50;
        tier = '₱2,501 – ₱5,000';
    } else if (num > 5000) {
        fee = 100;
        tier = 'Above ₱5,000';
    }

    const badge = document.getElementById('sellPostingFeeBadge');
    if (badge) {
        badge.innerText = `₱${fee.toFixed(2)} (Tier: ${tier})`;
    }
};

(function initSellPriceListeners() {
    function bindPrice() {
        const priceEl = document.getElementById('sellPrice');
        if (priceEl) {
            ['input', 'keyup', 'change', 'paste'].forEach(evt => {
                priceEl.addEventListener(evt, function() {
                    window.updateSellPostingFeeTier(this.value);
                });
            });
            window.updateSellPostingFeeTier(priceEl.value);
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindPrice);
    } else {
        bindPrice();
    }
})();

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

window.checkRentOutVerification = function() {
    let currentUser = {};
    try {
        if (typeof getRentEaseCurrentUser === 'function') {
            currentUser = getRentEaseCurrentUser();
        } else {
            const raw = localStorage.getItem('pasabuy_student_user') || localStorage.getItem('pasabuy_user');
            if (raw) currentUser = JSON.parse(raw);
        }
    } catch(e) {}

    const email = (currentUser.email || currentUser.SchoolEmail || '').toLowerCase();
    const isRomeo = (email === 'romeopaolotolentino@gmail.com' || (currentUser.id == 104));
    let isVerified = isRomeo || (currentUser.is_verified === 1 || currentUser.is_verified === true || currentUser.verification_status === 'VERIFIED' || currentUser.Status === 'VERIFIED');

    if (typeof updateSellVerificationState === 'function') {
        updateSellVerificationState(isVerified);
    }

    const uId = currentUser.id || currentUser.Id || currentUser.userId || currentUser.UserId || 0;
    if (uId > 0 && !isRomeo) {
        fetch(`/pasabuy_api.php?action=get_verification_status&userId=${uId}`)
            .then(r => r.ok ? r.json() : null)
            .then(data => {
                if (!data) return;
                const st = (data.VerificationStatus || data.Status || '').toUpperCase();
                const liveVerified = (st === 'VERIFIED' || st === 'APPROVED');
                if (typeof updateSellVerificationState === 'function') {
                    updateSellVerificationState(liveVerified);
                }
            })
            .catch(() => {});
    }
};

setTimeout(function() {
    if (typeof checkRentOutVerification === 'function') checkRentOutVerification();
}, 200);

window.openEquipmentReviewModal = function() {
    const currentUser = typeof getRentEaseCurrentUser === 'function' ? getRentEaseCurrentUser() : {};
    const isRomeo = (currentUser.email === 'romeopaolotolentino@gmail.com');
    const isVerified = isRomeo || (currentUser.is_verified === 1 || currentUser.verification_status === 'VERIFIED');

    if (!isVerified) {
        alert('🔒 Account Verification Required\n\nOnly admin-verified student accounts can publish equipment for rent.\n\nPlease submit your student ID verification under your Profile to get verified by Admin.');
        if (typeof openVerificationModal === 'function') openVerificationModal();
        else if (typeof switchTab === 'function') switchTab('profile');
        return;
    }

    const title = document.getElementById('sellTitle')?.value.trim();
    const price = parseFloat(document.getElementById('sellPrice')?.value) || 0;
    const quantity = parseInt(document.getElementById('sellQuantity')?.value) || 1;
    const category = document.getElementById('sellCategory')?.value || 'Others';
    const materialTag = document.getElementById('sellMaterialTag')?.value || 'Plastic';
    const condition = document.getElementById('sellCondition')?.value || 'Good';
    const description = document.getElementById('sellDescription')?.value.trim() || 'No additional guidelines specified.';

    if (!title) {
        alert('⚠️ Please enter an equipment title / name before reviewing.');
        document.getElementById('sellTitle')?.focus();
        return;
    }

    if (price <= 0) {
        alert('⚠️ Please enter a valid daily rental price.');
        document.getElementById('sellPrice')?.focus();
        return;
    }

    let photoUrl = 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';
    if (typeof uploadedPhotoUrls !== 'undefined' && uploadedPhotoUrls.length > 0) {
        photoUrl = uploadedPhotoUrls[0];
    } else {
        const customUrl = document.getElementById('sellPhotoUrlInput')?.value.trim();
        if (customUrl) photoUrl = customUrl;
    }

    let fee = 15;
    if (price > 0 && price < 100) fee = 10;
    else if (price >= 100 && price <= 500) fee = 15;
    else if (price > 500 && price <= 1000) fee = 20;
    else if (price > 1000 && price <= 2500) fee = 30;
    else if (price > 2500 && price <= 5000) fee = 50;
    else if (price > 5000) fee = 100;

    const elImg = document.getElementById('reviewEquipmentImg');
    const elTitle = document.getElementById('reviewEquipmentTitle');
    const elCat = document.getElementById('reviewEquipmentCategory');
    const elMat = document.getElementById('reviewEquipmentMaterial');
    const elCond = document.getElementById('reviewEquipmentCondition');
    const elRate = document.getElementById('reviewEquipmentRate');
    const elStock = document.getElementById('reviewEquipmentStock');
    const elDesc = document.getElementById('reviewEquipmentDesc');
    const elFee = document.getElementById('reviewEquipmentFee');
    const elBtnPay = document.getElementById('btnConfirmReviewAndPay');

    if (elImg) elImg.src = photoUrl;
    if (elTitle) elTitle.innerText = title;
    if (elCat) elCat.innerText = category;
    if (elMat) elMat.innerText = materialTag;
    if (elCond) elCond.innerText = condition;
    if (elRate) elRate.innerText = '₱ ' + price.toLocaleString();
    if (elStock) elStock.innerText = quantity + ' Unit' + (quantity > 1 ? 's' : '');
    if (elDesc) elDesc.innerText = description;
    if (elFee) elFee.innerText = '₱' + fee.toFixed(2);
    if (elBtnPay) elBtnPay.innerHTML = '<i class="fa-solid fa-credit-card me-1"></i> Proceed to Payment (₱' + fee.toFixed(2) + ')';

    const modalEl = document.getElementById('modalReviewEquipmentListing');
    if (modalEl) {
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else {
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
        }
    }
};

window.proceedFromReviewToPayment = function() {
    const modalEl = document.getElementById('modalReviewEquipmentListing');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const inst = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
        inst.hide();
    }

    const price = parseFloat(document.getElementById('sellPrice')?.value) || 0;
    let fee = 15;
    if (price > 0 && price < 100) fee = 10;
    else if (price >= 100 && price <= 500) fee = 15;
    else if (price > 500 && price <= 1000) fee = 20;
    else if (price > 1000 && price <= 2500) fee = 30;
    else if (price > 2500 && price <= 5000) fee = 50;
    else if (price > 5000) fee = 100;

    const feeText = '₱' + fee.toFixed(2);

    const pmModal = document.getElementById('payMongoGatewayModal');
    if (pmModal && typeof openPayMongoGatewayModal === 'function') {
        window.onPayMongoPaymentSuccess = function() {
            window.executePostRentalItemLive(fee);
        };
        openPayMongoGatewayModal(feeText);
    } else {
        window.executePostRentalItemLive(fee);
    }
};

window.executePostRentalItemLive = async function(fee) {
    const title = document.getElementById('sellTitle')?.value.trim();
    const category = document.getElementById('sellCategory')?.value || 'Others';
    const materialTag = document.getElementById('sellMaterialTag')?.value || 'Plastic';
    const price = parseFloat(document.getElementById('sellPrice')?.value) || 0;
    const quantity = parseInt(document.getElementById('sellQuantity')?.value) || 1;
    const condition = document.getElementById('sellCondition')?.value || 'Good';
    const location = document.getElementById('sellMeetup')?.value.trim() || 'Campus / In-App Chat';
    const description = document.getElementById('sellDescription')?.value.trim();
    
    let photoUrl = (typeof uploadedPhotoUrls !== 'undefined' && uploadedPhotoUrls.length > 0) 
        ? uploadedPhotoUrls[0] 
        : (document.getElementById('sellPhotoUrlInput')?.value.trim() || '');
    if (!photoUrl) photoUrl = 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';
    
    const videoUrl = document.getElementById('sellVideoUrlInput')?.value.trim() || '';

    const btn = document.getElementById('btnPublishRentalItem');
    const oldBtnHtml = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Publishing Equipment...';
    }

    try {
        const currentUser = typeof getRentEaseCurrentUser === 'function' ? getRentEaseCurrentUser() : {};
        const apiUrl = typeof getRentEaseApiUrl === 'function' ? getRentEaseApiUrl('post_item') : 'rentease_api.php?action=post_item';
        const res = await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: title,
                category: category,
                material_tag: materialTag,
                price_per_day: price,
                qty_total: quantity,
                image_url: photoUrl,
                photos: (typeof uploadedPhotoUrls !== 'undefined' && uploadedPhotoUrls.length > 0) ? uploadedPhotoUrls : [photoUrl],
                video_url: videoUrl,
                item_condition: condition,
                location: location,
                description: description,
                posting_fee: fee || 15,
                owner_id: currentUser.id || (currentUser.email === 'romeopaolotolentino@gmail.com' ? 104 : 0),
                owner_name: currentUser.name || 'Romeo Paolo Tolentino',
                owner_email: currentUser.email || 'romeopaolotolentino@gmail.com',
                owner_contact: currentUser.phone || '09668257301'
            })
        });

        const data = await res.json();
        if (data.success) {
            if (data.id) {
                try {
                    let postedIds = JSON.parse(localStorage.getItem('rentease_user_posted_ids') || '[]');
                    postedIds.push(parseInt(data.id));
                    localStorage.setItem('rentease_user_posted_ids', JSON.stringify(postedIds));
                } catch(e) {}
            }

            const feeInfo = data.posting_fee ? `\n🏷️ Posting Fee: ₱${parseFloat(data.posting_fee).toFixed(2)}` : '';
            alert(`🎉 Success!\n\n"${title}" has been published live for rent on RentEase!${feeInfo}\nStudents can now rent this equipment from you.`);
            
            if (document.getElementById('sellTitle')) document.getElementById('sellTitle').value = '';
            if (document.getElementById('sellDescription')) document.getElementById('sellDescription').value = '';
            if (document.getElementById('sellPhotoUrlInput')) document.getElementById('sellPhotoUrlInput').value = '';
            if (document.getElementById('sellVideoUrlInput')) document.getElementById('sellVideoUrlInput').value = '';
            if (document.getElementById('sellPhotosPreviewGrid')) document.getElementById('sellPhotosPreviewGrid').innerHTML = '';
            if (document.getElementById('sellVideoPreviewContainer')) document.getElementById('sellVideoPreviewContainer').style.display = 'none';
            if (typeof uploadedPhotoUrls !== 'undefined') uploadedPhotoUrls = [];

            if (typeof loadRentEaseCatalog === 'function') await loadRentEaseCatalog();
            if (typeof switchTab === 'function') switchTab('profile');
        } else {
            alert(data.message || '❌ Failed to post equipment. Please try again.');
        }
    } catch (e) {
        console.error("Error posting rental item:", e);
        alert('❌ Error connecting to server to post item.');
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = oldBtnHtml;
        }
    }
};

window.postRentalItemLive = function() {
    window.openEquipmentReviewModal();
};
</script>
