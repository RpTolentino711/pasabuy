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
        <div class="position-relative">
            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:14px; top:10px; font-size: 0.85rem;"></i>
            <input type="text" class="form-control rounded-pill ps-4 pe-5 py-1.5 fs-8 border-0 bg-white shadow-xs"
                placeholder="Search equipment by name, category, or owner..." id="exploreSearchInput"
                oninput="handleRentEaseSearch(this.value)">
            <button type="button" class="btn btn-sm position-absolute text-muted p-0 border-0 bg-transparent" 
                    id="clearExploreSearchBtn" style="right:12px; top:6px; display:none;" onclick="clearExploreSearch()">
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
