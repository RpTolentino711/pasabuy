<!-- HOME TAB (PHP COMPONENT) -->
<div id="tabHome" style="display:none;">

    <!-- Search Input with Filter Button & Voice Mic -->
    <div class="d-flex gap-2 align-items-center mb-3">
        <div class="position-relative flex-grow-1">
            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:14px; top:12px; font-size: 0.9rem;"></i>
            <input type="text" class="form-control rounded-pill ps-5 pe-5 py-2 fs-7 border-0 bg-white shadow-sm"
                placeholder="Search products, food, school supplies..." id="searchInput"
                onkeyup="filterProducts()">
            <i class="fa-solid fa-microphone position-absolute text-muted" style="right:14px; top:12px; font-size: 0.9rem; cursor:pointer;" title="Voice Search" onclick="alert('🎙️ Voice Search active...')"></i>
        </div>
        <button class="btn btn-primary rounded-3 d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" 
            style="width:40px; height:40px; background: linear-gradient(135deg, #6C5CE7, #5F27CD); border: none;" onclick="switchTab('explore')">
            <i class="fa-solid fa-sliders text-white fs-7"></i>
        </button>
    </div>

    <!-- Recent Searches Bar -->
    <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="fs-8 text-muted fw-semibold"><i class="fa-solid fa-clock-rotate-left me-1"></i> Recent Searches</span>
            <a href="javascript:void(0)" class="text-decoration-none fs-9 text-primary fw-semibold" onclick="clearRecentSearches()">Clear <i class="fa-solid fa-chevron-down ms-0.5"></i></a>
        </div>
        <div class="d-flex gap-2 overflow-x-auto pb-1" id="recentSearchesRow">
            <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 fs-8 fw-normal style-chip shadow-2xs" onclick="applyQuickSearch('laptop')">laptop</span>
            <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 fs-8 fw-normal style-chip shadow-2xs" onclick="applyQuickSearch('notebook')">notebook</span>
            <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 fs-8 fw-normal style-chip shadow-2xs" onclick="applyQuickSearch('airpods')">airpods</span>
            <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 fs-8 fw-normal style-chip shadow-2xs" onclick="applyQuickSearch('uniform')">uniform</span>
        </div>
    </div>

    <!-- Hero Deals Carousel Banner -->
    <div class="card border-0 rounded-4 p-4 text-white mb-4 shadow-sm position-relative overflow-hidden" 
        style="background: linear-gradient(135deg, #6C5CE7, #5F27CD, #341F97);">
        <div class="row align-items-center">
            <div class="col-8">
                <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill fs-9 mb-1">Back to School</span>
                <h3 class="fw-extrabold mb-1 text-white" style="font-size: 1.5rem; letter-spacing: -0.5px;">Deals</h3>
                <p class="fs-9 text-white-50 mb-3">Save more on your campus essentials.</p>
                <button class="btn btn-light rounded-pill fw-bold fs-9 px-3 py-1.5 text-primary shadow-sm" onclick="switchTab('explore')">
                    Shop Now <i class="fa-solid fa-arrow-right ms-1"></i>
                </button>
            </div>
            <div class="col-4 text-end">
                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=300&q=80" class="img-fluid rounded-3 shadow-sm" style="max-height: 90px; object-fit: cover;">
            </div>
        </div>
        <!-- Banner Indicators -->
        <div class="d-flex justify-content-center gap-1.5 mt-2">
            <span class="rounded-circle bg-white" style="width: 8px; height: 8px; opacity: 1;"></span>
            <span class="rounded-circle bg-white" style="width: 8px; height: 8px; opacity: 0.4;"></span>
            <span class="rounded-circle bg-white" style="width: 8px; height: 8px; opacity: 0.4;"></span>
        </div>
    </div>

    <!-- Categories Circular Grid -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold mb-0 text-dark">Categories</h6>
            <a href="javascript:void(0)" class="text-decoration-none fs-8 fw-bold text-primary" onclick="switchTab('explore')">See All <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>
        <div class="d-flex justify-content-between gap-2 overflow-x-auto pb-2" id="homeCategoryCircleGrid">
            <div class="text-center category-circle-item" onclick="selectCategoryFilter(this, 'School Supplies')">
                <div class="category-icon-circle bg-primary bg-opacity-10 text-primary mb-1">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <span class="fs-9 fw-semibold text-dark d-block">School Supplies</span>
            </div>
            <div class="text-center category-circle-item" onclick="selectCategoryFilter(this, 'Food / Pasabuy')">
                <div class="category-icon-circle bg-danger bg-opacity-10 text-danger mb-1">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <span class="fs-9 fw-semibold text-dark d-block">Food & Snacks</span>
            </div>
            <div class="text-center category-circle-item" onclick="selectCategoryFilter(this, 'Electronics')">
                <div class="category-icon-circle bg-info bg-opacity-10 text-info mb-1">
                    <i class="fa-solid fa-laptop"></i>
                </div>
                <span class="fs-9 fw-semibold text-dark d-block">Electronics</span>
            </div>
            <div class="text-center category-circle-item" onclick="selectCategoryFilter(this, 'Clothes')">
                <div class="category-icon-circle bg-success bg-opacity-10 text-success mb-1">
                    <i class="fa-solid fa-shirt"></i>
                </div>
                <span class="fs-9 fw-semibold text-dark d-block">Clothes</span>
            </div>
            <div class="text-center category-circle-item" onclick="selectCategoryFilter(this, 'Books')">
                <div class="category-icon-circle bg-warning bg-opacity-10 text-warning-emphasis mb-1">
                    <i class="fa-solid fa-book"></i>
                </div>
                <span class="fs-9 fw-semibold text-dark d-block">Books</span>
            </div>
            <div class="text-center category-circle-item" onclick="switchTab('explore')">
                <div class="category-icon-circle bg-secondary bg-opacity-10 text-secondary mb-1">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>
                <span class="fs-9 fw-semibold text-dark d-block">More</span>
            </div>
        </div>
    </div>

    <!-- Recommended For You Feed -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0 text-dark">Recommended For You</h6>
        <a href="javascript:void(0)" class="text-decoration-none fs-8 fw-bold text-primary" onclick="switchTab('explore')">See All <i class="fa-solid fa-arrow-right ms-1"></i></a>
    </div>

    <div id="homeProductContainer" class="row row-cols-2 g-2 mb-3">
        <div class="col-12 text-center py-5 text-muted fs-8 bg-white rounded-4 border p-4">
            <i class="fa-solid fa-store-slash fs-2 d-block mb-2 text-secondary opacity-50"></i>
            No campus listings published yet.<br>Go to <strong class="text-primary">+ Sell</strong> to post your first item!
        </div>
    </div>
</div>
