<!-- ==========================================================
     RentEase Screen 2: Category & Equipment Listing ("Chairs")
     UIDESIFNAPP.png Screen 2
     ========================================================== -->
<div id="tabExplore" style="display:none;">

    <!-- Category Header Bar -->
    <div class="d-flex align-items-center justify-content-between mb-3 pb-1">
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:34px; height:34px; background:#fff;" onclick="switchTab('home')">
            <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
        </button>
        <h5 class="fw-extrabold mb-0 text-dark fs-6" id="exploreCategoryTitle">Chairs</h5>
        <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                style="width:34px; height:34px; background:#fff;" onclick="document.getElementById('searchInput').focus(); switchTab('home');">
            <i class="fa-solid fa-magnifying-glass text-dark fs-8"></i>
        </button>
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
        <!-- Rendered dynamically by renderExploreCatalog() -->
    </div>

</div>
