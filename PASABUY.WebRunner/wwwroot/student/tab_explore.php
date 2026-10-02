<!-- ==========================================================
     RentEase Screen 2: Category & Equipment Listing ("Chairs")
     UIDESIFNAPP.png Screen 2
     ========================================================== -->
<div id="tabExplore" style="display:none;">

    <!-- Category Header Bar -->
    <div class="d-flex align-items-center justify-content-between mb-2 pb-1">
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:34px; height:34px; background:#fff;" onclick="switchTab('home')">
            <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
        </button>
        <h5 class="fw-extrabold mb-0 text-dark fs-6" id="exploreCategoryTitle">Equipment Catalog</h5>
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:34px; height:34px; background:#fff;" onclick="const el=document.getElementById('exploreSearchInput'); if(el){el.focus();}">
            <i class="fa-solid fa-magnifying-glass text-dark fs-8"></i>
        </button>
    </div>

    <!-- Active Search Bar inside Rentals / Explore -->
    <div class="mb-3">
        <div class="position-relative">
            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:16px; top:12px; font-size: 0.9rem;"></i>
            <input type="text" class="form-control rounded-pill ps-5 pe-5 py-2 fs-7 border-0 bg-white shadow-xs"
                placeholder="Search equipment by name, category, or owner..." id="exploreSearchInput"
                oninput="handleRentEaseSearch(this.value)">
            <button type="button" class="btn btn-sm position-absolute text-muted p-0 border-0 bg-transparent" 
                    id="clearExploreSearchBtn" style="right:14px; top:8px; display:none;" onclick="clearExploreSearch()">
                <i class="fa-solid fa-circle-xmark fs-7"></i>
            </button>
        </div>
    </div>

    <!-- Filter Chips: All, Plastic, Wooden, Premium (Matching Screen 2) -->
    <div class="d-flex gap-2 overflow-x-auto pb-2 mb-3 no-scrollbar" id="exploreFilterChipsContainer">
        <button class="btn btn-sm rounded-pill px-3 py-1 fs-9 fw-bold filter-chip active" 
                style="background: #5B3FA8; color: #fff; border:none;" onclick="filterRentEaseByTag(this, 'All')">
            All
        </button>
        <button class="btn btn-sm rounded-pill px-3 py-1 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                onclick="filterRentEaseByTag(this, 'Plastic')">
            Plastic
        </button>
        <button class="btn btn-sm rounded-pill px-3 py-1 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                onclick="filterRentEaseByTag(this, 'Wooden')">
            Wooden
        </button>
        <button class="btn btn-sm rounded-pill px-3 py-1 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                onclick="filterRentEaseByTag(this, 'Premium')">
            Premium
        </button>
    </div>

    <!-- 2-Column Product Grid (Matching Screen 2) -->
    <div class="row g-2.5" id="exploreProductGrid">
        <div class="col-12 text-center py-5 bg-white rounded-4 border p-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-2 text-muted" style="width:52px; height:52px; background: rgba(91,63,168,0.08) !important;">
                <i class="fa-solid fa-box-open fs-3" style="color:#5B3FA8;"></i>
            </div>
            <h6 class="fw-bold text-dark fs-7 mb-1">Empty Stocks</h6>
            <p class="fs-9 text-muted mb-2.5">No equipment currently available in this category.</p>
            <button class="btn btn-sm btn-primary rounded-pill px-3 py-1 fs-9 fw-bold mx-auto" style="background:#5B3FA8; border:none;" onclick="switchTab('sell')">
                <i class="fa-solid fa-plus me-1"></i> Post Equipment
            </button>
        </div>
    </div>

</div>
