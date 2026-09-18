<!-- ==========================================================
     RentEase Screen 1: Home Discovery Feed
     UIDESIFNAPP.png Screen 1
     ========================================================== -->
<div id="tabHome" style="display:none;">

    <!-- Top Search Input -->
    <div class="mb-3">
        <div class="position-relative">
            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:16px; top:13px; font-size: 0.95rem;"></i>
            <input type="text" class="form-control rounded-pill ps-5 pe-4 py-2.5 fs-7 border-0 bg-white shadow-xs"
                placeholder="Search for equipment..." id="searchInput"
                onkeyup="handleRentEaseSearch(this.value)">
        </div>
    </div>

    <!-- Hero Promotional Banner: "Make Your Event Special" -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden position-relative" 
         style="background: linear-gradient(135deg, #5B3FA8 0%, #341F97 100%); min-height: 145px;">
        <div class="row g-0 h-100 align-items-center">
            <div class="col-7 p-3.5 z-2">
                <h5 class="fw-extrabold mb-1" style="font-size: 1.05rem; letter-spacing: -0.3px; line-height: 1.25;">
                    Make Your<br>Event Special
                </h5>
                <p class="fs-9 text-white-50 mb-2.5" style="line-height: 1.3;">
                    Quality equipment<br>for every occasion.
                </p>
                <button class="btn btn-warning btn-sm rounded-pill fw-bold fs-9 px-3 py-1 text-dark shadow-sm" 
                        style="background: #F4B942; border: none;" onclick="openCategoryTab('All')">
                    Rent Now
                </button>
            </div>
            <div class="col-5 h-100 position-relative">
                <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&q=80" 
                     alt="Event Tent" class="w-100 h-100 position-absolute top-0 end-0" 
                     style="object-fit: cover; opacity: 0.88; mask-image: linear-gradient(to left, black 65%, transparent 100%); -webkit-mask-image: linear-gradient(to left, black 65%, transparent 100%);">
            </div>
        </div>
    </div>

    <!-- Categories Grid (2 Rows of 4 matching UIDESIFNAPP.png Screen 1) -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-extrabold mb-0 text-dark fs-7">Categories</h6>
            <a href="javascript:void(0)" class="text-decoration-none fs-8 fw-bold" style="color: #5B3FA8;" onclick="openCategoryTab('All')">See All <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>

        <!-- Row 1: Chairs, Tables, Tents, Sound System -->
        <div class="row g-2 mb-2">
            <div class="col-3 text-center" onclick="openCategoryTab('Chairs')" style="cursor: pointer;">
                <div class="p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1 transition-hover" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-chair fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block text-truncate">Chairs</span>
            </div>
            <div class="col-3 text-center" onclick="openCategoryTab('Tables')" style="cursor: pointer;">
                <div class="p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1 transition-hover" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-table fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block text-truncate">Tables</span>
            </div>
            <div class="col-3 text-center" onclick="openCategoryTab('Tents')" style="cursor: pointer;">
                <div class="p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1 transition-hover" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-campground fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block text-truncate">Tents</span>
            </div>
            <div class="col-3 text-center" onclick="openCategoryTab('Sound System')" style="cursor: pointer;">
                <div class="p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1 transition-hover" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-volume-high fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block text-truncate">Sound System</span>
            </div>
        </div>

        <!-- Row 2: Lights, Decorations, Stages, Others -->
        <div class="row g-2">
            <div class="col-3 text-center" onclick="openCategoryTab('Lights')" style="cursor: pointer;">
                <div class="p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1 transition-hover" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-lightbulb fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block text-truncate">Lights</span>
            </div>
            <div class="col-3 text-center" onclick="openCategoryTab('Decorations')" style="cursor: pointer;">
                <div class="p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1 transition-hover" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-wand-magic-sparkles fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block text-truncate">Decorations</span>
            </div>
            <div class="col-3 text-center" onclick="openCategoryTab('Stages')" style="cursor: pointer;">
                <div class="p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1 transition-hover" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-monument fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block text-truncate">Stages</span>
            </div>
            <div class="col-3 text-center" onclick="openCategoryTab('Others')" style="cursor: pointer;">
                <div class="p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1 transition-hover" style="width: 58px; height: 58px;">
                    <i class="fa-solid fa-cubes-stacked fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block text-truncate">Others</span>
            </div>
        </div>
    </div>

    <!-- Featured Rentals Cards (Matching Screen 1) -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-extrabold mb-0 text-dark fs-7">Featured Rentals</h6>
            <a href="javascript:void(0)" class="text-decoration-none fs-8 fw-bold" style="color: #5B3FA8;" onclick="openCategoryTab('All')">See All <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-2.5" id="homeFeaturedContainer">
            <!-- Dynamic Live Featured Equipment populated from database by loadRentEaseCatalog() -->
            <div class="col-12 text-center py-4 text-secondary">
                <i class="fa-solid fa-spinner fa-spin fs-4 text-primary mb-2"></i>
                <div class="fs-8">Loading live equipment inventory...</div>
            </div>
        </div>
    </div>

    <!-- Event Packages Banner (Marketing Strategy - 10%) -->
    <div class="mb-3" id="homePackagesSection">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="fw-extrabold mb-0 text-dark fs-7"><i class="fa-solid fa-box-open text-warning me-1"></i> Event Packages</h6>
            <span class="badge rounded-pill text-white fw-bold fs-9" style="background: linear-gradient(135deg, #10B981, #059669);">Save up to 25%</span>
        </div>
        <div id="homePackagesContainer">
            <!-- Dynamically populated from database -->
            <div class="p-3 bg-white rounded-4 border shadow-xs d-flex align-items-center justify-content-between" style="cursor:pointer;" onclick="openPackageDetails(1)">
                <div>
                    <span class="badge bg-warning-subtle text-warning-emphasis fw-bold fs-9 mb-1">Birthday Celebration Package</span>
                    <h6 class="fw-bold text-dark fs-8 mb-0">50 Chairs + 5 Tables + Event Tent</h6>
                    <div class="fs-9 text-muted">Complete party setup • Starts at <strong>₱1,499</strong></div>
                </div>
                <button class="btn btn-sm btn-primary rounded-pill px-3 py-1 fs-9 fw-bold flex-shrink-0" style="background: #5B3FA8; border:none;">
                    Book
                </button>
            </div>
        </div>
    </div>

</div>
