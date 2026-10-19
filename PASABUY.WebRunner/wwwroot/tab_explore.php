<!-- ==========================================================
     RentEase Screen 2: Category & Equipment Listing ("Chairs" - Compact)
     UIDESIFNAPP.png Screen 2
     ========================================================== -->
<div id="tabExplore" style="display:none;">

    <!-- Category Header Bar (Compact) -->
    <div class="d-flex align-items-center justify-content-between mb-1.5 pb-1">
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:30px; height:30px; background:#fff;" onclick="switchTab('home')">
            <i class="fa-solid fa-arrow-left text-dark fs-9"></i>
        </button>
        <h5 class="fw-extrabold mb-0 text-dark fs-7" id="exploreCategoryTitle">Equipment Catalog</h5>
        <div style="width:30px; height:30px;"></div>
    </div>

    <!-- Active Search Bar inside Rentals / Explore (Compact) -->
    <div class="mb-2">
        <div class="position-relative d-flex align-items-center">
            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:14px; top:50%; transform:translateY(-50%); font-size: 0.85rem; pointer-events:none; z-index:5;"></i>
            <input type="text" class="form-control rounded-pill py-1.5 fs-8 border-0 bg-white shadow-xs"
                style="padding-left: 38px !important; padding-right: 36px !important;"
                placeholder="Search equipment by name, category, or owner..." id="exploreSearchInput"
                oninput="handleRentEaseSearch(this.value)">
            <button type="button" class="btn btn-sm position-absolute text-muted p-0 border-0 bg-transparent" 
                    id="clearExploreSearchBtn" style="right:14px; top:50%; transform:translateY(-50%); display:none; z-index:5;" onclick="clearExploreSearch()">
                <i class="fa-solid fa-circle-xmark fs-8"></i>
            </button>
        </div>
    </div>

    <!-- Categories Filter Chips (Scrollable) -->
    <div class="d-flex gap-1.5 overflow-x-auto pb-1.5 mb-2 no-scrollbar" id="exploreFilterChipsContainer" style="scrollbar-width:none; -webkit-overflow-scrolling:touch;">
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip active" 
                data-category="All"
                style="background: #5B3FA8; color: #fff; border: 1px solid #5B3FA8; font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'All')">
            All
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Chairs"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Chairs')">
            Chairs
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Tables"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Tables')">
            Tables
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Tents"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Tents')">
            Tents
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Sound System"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Sound System')">
            Sound
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Cameras"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Cameras')">
            Cameras
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Lights"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Lights')">
            Lights
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Decorations"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Decorations')">
            Decor
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Stages"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Stages')">
            Stages
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Catering"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Catering')">
            Catering
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Generators"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Generators')">
            Power
        </button>
        <button class="btn btn-sm rounded-pill px-2.5 py-0.5 fs-9 fw-bold filter-chip bg-white text-secondary border" 
                data-category="Others"
                style="font-size: 0.72rem; white-space: nowrap;" onclick="filterRentEaseByCategory(this, 'Others')">
            Others
        </button>
    </div>

    <!-- Discovery Sorting Bar (Most Popular, Recent/Newest, In Stock, All) -->
    <div class="d-flex align-items-center mb-2.5 px-0.5 overflow-x-auto no-scrollbar" style="scrollbar-width:none; -webkit-overflow-scrolling:touch;">
        <div class="d-flex align-items-center gap-1.5 flex-nowrap" id="exploreSortFilterChips">
            <button type="button" class="btn btn-sm rounded-pill px-2.5 py-1 fs-9 fw-bold explore-sort-chip active" 
                    id="sortChipPopular"
                    onclick="setRentEaseCatalogSort('popular', this)" 
                    style="background:#FFF1F2; color:#E11D48; border:1px solid #FECDD3; font-size:0.7rem; white-space:nowrap; transition:all 0.15s ease;">
                <i class="fa-solid fa-heart me-1 text-danger"></i>Most Popular
            </button>
            <button type="button" class="btn btn-sm rounded-pill px-2.5 py-1 fs-9 fw-bold explore-sort-chip bg-white text-secondary border" 
                    id="sortChipRecent"
                    onclick="setRentEaseCatalogSort('recent', this)" 
                    style="font-size:0.7rem; white-space:nowrap; border-color:#E2E8F0 !important; transition:all 0.15s ease;">
                <i class="fa-solid fa-clock-rotate-left me-1 text-primary"></i>Recent &amp; Newest
            </button>
            <button type="button" class="btn btn-sm rounded-pill px-2.5 py-1 fs-9 fw-bold explore-sort-chip bg-white text-secondary border" 
                    id="sortChipInStock"
                    onclick="setRentEaseCatalogSort('instock', this)" 
                    style="font-size:0.7rem; white-space:nowrap; border-color:#E2E8F0 !important; transition:all 0.15s ease;">
                <i class="fa-solid fa-box-check me-1 text-success"></i>Available Now
            </button>
            <button type="button" class="btn btn-sm rounded-pill px-2.5 py-1 fs-9 fw-bold explore-sort-chip bg-white text-secondary border" 
                    id="sortChipAll"
                    onclick="setRentEaseCatalogSort('all', this)" 
                    style="font-size:0.7rem; white-space:nowrap; border-color:#E2E8F0 !important; transition:all 0.15s ease;">
                <i class="fa-solid fa-layer-group me-1 text-muted"></i>All Gear
            </button>
        </div>
    </div>

    <!-- 2-Column Product Grid (Compact) -->
    <div class="row g-2" id="exploreProductGrid">
        <div class="col-12 text-center py-3 bg-white rounded-4 border p-3">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-1.5 text-muted" style="width:40px; height:40px; background: rgba(91,63,168,0.08) !important;">
                <i class="fa-solid fa-box-open fs-5" style="color:#5B3FA8;"></i>
            </div>
            <h6 class="fw-bold text-dark fs-8 mb-0.5">Empty Stocks</h6>
            <p class="fs-9 text-muted mb-2" style="font-size: 0.72rem;">No equipment currently available in this category.</p>
            <button class="btn btn-sm btn-primary rounded-pill px-3 py-1 fs-9 fw-bold mx-auto" style="background:#5B3FA8; border:none;" onclick="switchTab('sell')">
                <i class="fa-solid fa-plus me-1"></i> Post Equipment
            </button>
        </div>
    </div>

</div>
