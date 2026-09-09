<!-- SELL TAB (PHP COMPONENT) -->
<div id="tabSell" style="display:none;">
    <h5 class="fw-bold mb-2">Create New Listing</h5>
    <p class="text-muted fs-8 mb-3">PasaBuy collects only a small posting fee via PayMongo. Product payment is arranged face-to-face!</p>

    <div id="sellStep1">
        <div class="mb-3">
            <label class="form-label fw-bold fs-7">Product Title</label>
            <input type="text" class="form-control rounded-3 fs-7" id="sellTitle"
                placeholder="e.g. Scientific Calculator FX-991ES">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold fs-7">Category</label>
            <select class="form-select rounded-3 fs-7" id="sellCategory">
                <option value="Food / Pasabuy">Food / Pasabuy</option>
                <option value="School Supplies" selected>School Supplies</option>
                <option value="Electronics">Electronics</option>
                <option value="Books">Books</option>
                <option value="Gadgets">Gadgets</option>
                <option value="Dorm Items">Dorm Items</option>
            </select>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <label class="form-label fw-bold fs-7">Selling Price (₱)</label>
                <input type="number" class="form-control rounded-3 fs-7" id="sellPrice" value="500"
                    oninput="calculateFeeLive()">
            </div>
            <div class="col-6">
                <label class="form-label fw-bold fs-7">Available Stock</label>
                <input type="number" class="form-control rounded-3 fs-7" id="sellQuantity" value="1" min="0" placeholder="Qty">
            </div>
        </div>

        <!-- Server Fee Live Calculation Box -->
        <div class="fee-info-box">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="fw-bold fs-8 text-warning-emphasis"><i class="fa-solid fa-calculator me-1"></i>
                    Calculated PasaBuy Fee:</span>
                <span class="fw-extrabold fs-6 text-dark" id="feeDisplay">₱5.00</span>
            </div>
            <p class="mb-0 fs-9 text-muted">
                ₱1–₱99 = ₱1 | ₱100–₱999 = ₱5 | ₱1,000+ = ₱10 fee.
            </p>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold fs-7">Condition</label>
            <select class="form-select rounded-3 fs-7" id="sellCondition">
                <option>Like New</option>
                <option selected>Good</option>
                <option>Fair</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold fs-7">Meetup Location <span
                    class="text-muted fw-normal fs-8">(Optional)</span></label>
            <input type="text" class="form-control rounded-3 fs-7" id="sellMeetup"
                placeholder="e.g. Library Lobby, Gate 1, Cafeteria, or Any (Optional)">
        </div>

        <!-- Photo Upload Section (Select Multiple Photos) -->
        <div class="mb-3">
            <label class="form-label fw-bold fs-7 d-flex align-items-center justify-content-between">
                <span><i class="fa-solid fa-camera text-primary me-1"></i> Product Photos <span
                        class="text-danger">*</span></span>
                <span class="text-muted fw-normal fs-8">Select 1 or multiple photos</span>
            </label>
            <input type="file" class="form-control rounded-3 fs-7 mb-2" id="sellPhotosInput"
                accept="image/*" multiple onchange="previewSellPhotos(event)">

            <!-- Image Preview Grid -->
            <div class="d-flex gap-2 flex-wrap mt-2" id="sellPhotosPreviewGrid">
            </div>
        </div>

        <!-- Video Upload Section (Optional Product Video) -->
        <div class="mb-3">
            <label class="form-label fw-bold fs-7 d-flex align-items-center justify-content-between">
                <span><i class="fa-solid fa-video text-danger me-1"></i> Product Video <span class="text-muted fw-normal fs-8">(Optional)</span></span>
                <span class="text-muted fw-normal fs-8">Upload MP4 video or paste link</span>
            </label>
            <input type="file" class="form-control rounded-3 fs-7 mb-2" id="sellVideoFileInput" accept="video/*" onchange="handleSellVideoUpload(event)">
            <input type="text" class="form-control rounded-3 fs-7" id="sellVideoUrlInput" placeholder="or paste Video URL (e.g. https://.../video.mp4)">
            <div id="sellVideoPreviewContainer" class="mt-2" style="display:none;">
                <video id="sellVideoPreview" controls style="width:100%; max-height:180px; border-radius:8px; background:#000;"></video>
            </div>
        </div>

        <button class="btn btn-pasabuy" onclick="checkSellerVerificationAndPost()"><i class="fa-solid fa-paper-plane me-2"></i> Verify & Post Live Now</button>
    </div>

    <!-- PayMongo GCash Payment Step -->
    <div id="sellStep2" style="display:none;">
        <div class="text-center p-4 bg-white rounded-4 border shadow-sm mb-4">
            <h6 class="fw-bold mb-1">Pay Posting Fee via GCash</h6>
            <p class="text-muted fs-8 mb-3">Pay via GCash E-Wallet to publish item post live</p>
            <div class="fw-bold fs-3 text-primary mb-3" id="payAmountDisplay">₱1.00</div>

            <div
                class="p-3 bg-primary bg-opacity-10 rounded-4 mb-3 text-center border border-primary-subtle">
                <span class="badge bg-primary text-white fw-bold px-3 py-2 rounded-pill mb-2"><i
                        class="fa-solid fa-mobile-screen-button me-1"></i> Official GCash Payment</span>
                <p class="fs-9 text-muted mb-0">Click <strong>Pay via GCash App</strong> below to open the official PayMongo GCash payment window!</p>
            </div>

            <div>
                <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill fs-8"><i
                        class="fa-solid fa-shield-halved me-1"></i> PayMongo GCash Live API Connected</span>
            </div>
        </div>

        <button class="btn btn-pasabuy mb-2" onclick="redirectToPayMongoCheckout()"><i
                class="fa-solid fa-mobile-screen me-1"></i> Pay via GCash App</button>
        <button class="btn btn-outline-secondary w-100 rounded-pill fw-bold"
            onclick="simulatePaymentSuccess()"><i class="fa-solid fa-check-circle me-1"></i> Confirm Payment Completed & Post Live</button>
    </div>
</div>
