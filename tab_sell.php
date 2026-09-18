<!-- ==========================================================
     RentEase: Post Equipment for Rent ("Rent Out") Tab
     Allows users to post equipment with photos, videos, pricing, stock, & description
     ========================================================== -->
<div id="tabSell" style="display:none;" class="pb-5">

    <!-- Top Action Header -->
    <div class="d-flex align-items-center justify-content-between mb-3 pb-1">
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:34px; height:34px; background:#fff;" onclick="switchTab('home')">
            <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
        </button>
        <h5 class="fw-extrabold mb-0 text-dark fs-6">Rent Out Equipment</h5>
        <div style="width:34px;"></div>
    </div>

    <!-- Promo Banner Card -->
    <div class="card border-0 rounded-4 shadow-sm p-3.5 text-white mb-3 position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, #5B3FA8 0%, #341F97 100%);">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center p-2 shadow-sm" 
                 style="background: rgba(255,255,255,0.2); width:46px; height:46px; flex-shrink:0;">
                <i class="fa-solid fa-hand-holding-dollar text-warning fs-5"></i>
            </div>
            <div>
                <h6 class="fw-extrabold mb-0.5 fs-7">Earn with RentEase</h6>
                <p class="fs-9 text-white-50 mb-0">List your chairs, tables, tents, sound systems, lights, or event supplies for rent to verified campus clients.</p>
            </div>
        </div>
    </div>

    <!-- Main Listing Form -->
    <div class="card border-0 rounded-4 shadow-sm p-3.5 bg-white mb-4">

        <!-- 1. Equipment Title -->
        <div class="mb-3">
            <label class="form-label fw-extrabold text-dark fs-8 mb-1">
                Equipment Title / Name <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control rounded-3 fs-7" id="sellTitle"
                   placeholder="e.g. JBL PartyBox 310 Sound System, White Tiffany Chairs (Set of 10)">
        </div>

        <!-- 2. Category & Material Tag -->
        <div class="row g-2 mb-3">
            <div class="col-6">
                <label class="form-label fw-extrabold text-dark fs-8 mb-1">
                    Category <span class="text-danger">*</span>
                </label>
                <select class="form-select rounded-3 fs-7" id="sellCategory">
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
                <label class="form-label fw-extrabold text-dark fs-8 mb-1">
                    Material / Type
                </label>
                <select class="form-select rounded-3 fs-7" id="sellMaterialTag">
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

        <!-- 3. Rental Rate (Per Day) & Quantity -->
        <div class="row g-2 mb-3">
            <div class="col-6">
                <label class="form-label fw-extrabold text-dark fs-8 mb-1">
                    Rental Rate (₱ / day) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light fw-bold fs-7">₱</span>
                    <input type="number" class="form-control rounded-end-3 fs-7 fw-bold" id="sellPrice" value="100" min="1">
                </div>
            </div>
            <div class="col-6">
                <label class="form-label fw-extrabold text-dark fs-8 mb-1">
                    Available Stock / Units <span class="text-danger">*</span>
                </label>
                <input type="number" class="form-control rounded-3 fs-7 fw-bold" id="sellQuantity" value="10" min="1" placeholder="Quantity">
            </div>
        </div>

        <!-- 4. Condition & Location -->
        <div class="row g-2 mb-3">
            <div class="col-5">
                <label class="form-label fw-extrabold text-dark fs-8 mb-1">Condition</label>
                <select class="form-select rounded-3 fs-7" id="sellCondition">
                    <option value="Brand New">Brand New</option>
                    <option value="Like New" selected>Like New</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                </select>
            </div>
            <div class="col-7">
                <label class="form-label fw-extrabold text-dark fs-8 mb-1">Pickup / Warehouse Location</label>
                <input type="text" class="form-control rounded-3 fs-7" id="sellMeetup" value="San Pablo, Laguna" placeholder="e.g. San Pablo Laguna / Campus Hub">
            </div>
        </div>

        <!-- 5. Description & Inclusions -->
        <div class="mb-3">
            <label class="form-label fw-extrabold text-dark fs-8 mb-1">Description & Inclusions</label>
            <textarea class="form-control rounded-3 fs-7" id="sellDescription" rows="2" 
                      placeholder="e.g. Complete with protective covers and cords. Cleaned and sanitized before every booking."></textarea>
        </div>

        <!-- 6. Photos Upload Section -->
        <div class="mb-3 p-3 rounded-4 border bg-light bg-opacity-50">
            <label class="form-label fw-extrabold text-dark fs-8 d-flex align-items-center justify-content-between mb-1">
                <span><i class="fa-solid fa-camera me-1.5" style="color:#5B3FA8;"></i> Equipment Photos <span class="text-danger">*</span></span>
                <span class="text-muted fw-normal fs-9">Select 1 or more images</span>
            </label>
            
            <input type="file" class="form-control rounded-3 fs-7 mb-2" id="sellPhotosInput"
                   accept="image/*" multiple onchange="previewSellPhotos(event)">
            <input type="text" class="form-control rounded-3 fs-8 mb-2" id="sellPhotoUrlInput" 
                   placeholder="or paste Image URL (e.g. https://images.unsplash.com/...)">

            <!-- Dynamic Image Preview Grid -->
            <div class="d-flex gap-2 flex-wrap mt-1" id="sellPhotosPreviewGrid">
                <!-- Populated dynamically via JS -->
            </div>
        </div>

        <!-- 7. Video Upload Section (Playable Demo Video) -->
        <div class="mb-4 p-3 rounded-4 border bg-light bg-opacity-50">
            <label class="form-label fw-extrabold text-dark fs-8 d-flex align-items-center justify-content-between mb-1">
                <span><i class="fa-solid fa-video text-danger me-1.5"></i> Equipment Video <span class="badge bg-secondary-subtle text-secondary fs-9">Optional</span></span>
                <span class="text-muted fw-normal fs-9">Upload MP4 or paste video link</span>
            </label>

            <input type="file" class="form-control rounded-3 fs-7 mb-2" id="sellVideoFileInput" 
                   accept="video/*" onchange="handleSellVideoUpload(event)">
            <input type="text" class="form-control rounded-3 fs-8" id="sellVideoUrlInput" 
                   placeholder="or paste direct video URL (e.g. https://.../video.mp4)">

            <!-- Live Video Player Preview Container -->
            <div id="sellVideoPreviewContainer" class="mt-2.5" style="display:none;">
                <video id="sellVideoPreview" controls class="w-100 rounded-3 shadow-xs" style="max-height:190px; background:#000; object-fit:contain;"></video>
            </div>
        </div>

        <!-- 8. Submit Button -->
        <button type="button" class="btn btn-primary w-100 py-3 rounded-4 fw-extrabold shadow-md fs-7" 
                id="btnPublishRentalItem"
                style="background: linear-gradient(135deg, #5B3FA8, #341F97); border: none;" 
                onclick="postRentalItemLive()">
            <i class="fa-solid fa-paper-plane me-2"></i> Publish Equipment for Rent
        </button>

        <p class="text-center text-muted fs-9 mt-2.5 mb-0">
            <i class="fa-solid fa-shield-check text-success me-1"></i> Listed immediately in the live RentEase catalog across all user and rider views.
        </p>
    </div>

</div>
