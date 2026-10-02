<!-- ==========================================================
     RentEase Screen 1: Home Discovery Feed (Compact Sleek Layout)
     UIDESIFNAPP.png Screen 1
     ========================================================== -->
<div id="tabHome" style="display:none;">

    <!-- Top Search Input (Compact) -->
    <div class="mb-2">
        <div class="position-relative">
            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:14px; top:10px; font-size: 0.85rem;"></i>
            <input type="text" class="form-control rounded-pill ps-4 pe-3 py-1.5 fs-8 border-0 bg-white shadow-xs"
                placeholder="Search for equipment, sound, camera..." id="searchInput"
                oninput="handleHomeSearch(this.value)">
        </div>
    </div>

    <!-- Hero Promotional Banner: "Make Your Event Special" (Compact Ribbon) -->
    <div class="card border-0 rounded-4 shadow-sm mb-2.5 text-white overflow-hidden position-relative" 
         style="background: linear-gradient(135deg, #5B3FA8 0%, #341F97 100%); min-height: 96px;">
        <div class="row g-0 h-100 align-items-center">
            <div class="col-7 p-2.5 ps-3 z-2">
                <h5 class="fw-extrabold mb-0.5 text-white" style="font-size: 0.92rem; letter-spacing: -0.2px; line-height: 1.2;">
                    Make Your Event Special
                </h5>
                <p class="text-white-50 mb-1.5" style="font-size: 0.72rem; line-height: 1.2;">
                    Quality equipment for every occasion.
                </p>
                <button class="btn btn-warning btn-sm rounded-pill fw-bold text-dark shadow-sm" 
                        style="background: #F4B942; border: none; font-size: 0.72rem; padding: 2px 10px;" onclick="openCategoryTab('All')">
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

    <!-- Categories Horizontal Scroll Wheel (Compact) -->
    <div class="mb-2.5">
        <div class="d-flex align-items-center justify-content-between mb-1.5">
            <h6 class="fw-extrabold mb-0 text-dark fs-8">Categories</h6>
            <a href="javascript:void(0)" class="text-decoration-none fs-9 fw-bold" style="color: #5B3FA8;" onclick="openCategoryTab('All')">See All <i class="fa-solid fa-arrow-right ms-0.5"></i></a>
        </div>

        <style>
            .category-scroll-wheel::-webkit-scrollbar { display: none; }
            .category-wheel-item:hover .cat-icon-box {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(91,63,168,0.18) !important;
                border-color: #5B3FA8 !important;
            }
            .category-wheel-item:active .cat-icon-box {
                transform: scale(0.95);
            }
        </style>

        <!-- Horizontal Scroll Wheel Track (Compact 44px Icons) -->
        <div class="d-flex gap-2 overflow-auto py-1 px-0.5 category-scroll-wheel" id="categoryScrollWheel"
             style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none; ms-overflow-style: none; scroll-behavior: smooth;"
             onwheel="if(event.deltaY!==0){event.preventDefault(); this.scrollLeft += event.deltaY;}">
            
            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Chairs')" style="cursor: pointer; width: 58px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-chair fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Chairs</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Tables')" style="cursor: pointer; width: 58px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-table fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Tables</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Tents')" style="cursor: pointer; width: 58px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-campground fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Tents</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Sound System')" style="cursor: pointer; width: 62px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-volume-high fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Sound</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Cameras')" style="cursor: pointer; width: 58px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-camera fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Cameras</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Lights')" style="cursor: pointer; width: 58px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-lightbulb fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Lights</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Decorations')" style="cursor: pointer; width: 62px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-wand-magic-sparkles fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Decor</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Stages')" style="cursor: pointer; width: 58px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-monument fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Stages</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Catering')" style="cursor: pointer; width: 58px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-utensils fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Catering</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Generators')" style="cursor: pointer; width: 60px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-bolt fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Power</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Others')" style="cursor: pointer; width: 58px; scroll-snap-align: start;">
                <div class="cat-icon-box rounded-3 bg-white shadow-2xs border d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 44px; height: 44px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-cubes-stacked fs-6" style="color: #5B3FA8;"></i>
                </div>
                <span class="fw-bold text-dark d-block" style="font-size: 10px; line-height: 1.15;">Others</span>
            </div>
        </div>
    </div>

    <!-- Featured Rentals Cards (Matching Screen 1 - Compact) -->
    <div class="mb-2.5">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="fw-extrabold mb-0 text-dark fs-8">Featured Rentals</h6>
            <a href="javascript:void(0)" class="text-decoration-none fs-9 fw-bold" style="color: #5B3FA8;" onclick="openCategoryTab('All')">See All <i class="fa-solid fa-arrow-right ms-0.5"></i></a>
        </div>

        <div class="row g-2" id="homeFeaturedContainer">
            <!-- Dynamic Live Featured Equipment populated from database by loadRentEaseCatalog() -->
            <div class="col-12">
                <div class="card border-0 rounded-4 shadow-sm p-3 bg-white text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-1.5 text-muted" style="width:40px; height:40px; background: rgba(91,63,168,0.08) !important;">
                        <i class="fa-solid fa-box-open fs-5" style="color:#5B3FA8;"></i>
                    </div>
                    <h6 class="fw-bold text-dark fs-8 mb-0.5">Empty Stocks</h6>
                    <p class="text-muted fs-9 mb-2" style="font-size: 0.72rem;">No equipment currently available for rent.</p>
                    <button class="btn btn-sm btn-primary rounded-pill px-3 py-1 fs-9 fw-bold mx-auto" style="background:#5B3FA8; border:none;" onclick="switchTab('sell')">
                        <i class="fa-solid fa-plus me-1"></i> Post Equipment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Packages Banner (Compact) -->
    <div class="mb-2" id="homePackagesSection" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-1.5">
            <h6 class="fw-extrabold mb-0 text-dark fs-8"><i class="fa-solid fa-box-open text-warning me-1"></i> Event Packages</h6>
            <span class="badge rounded-pill text-white fw-bold fs-9" style="background: linear-gradient(135deg, #10B981, #059669); font-size: 0.65rem;">Save up to 25%</span>
        </div>
        <div id="homePackagesContainer">
            <!-- Dynamically populated if packages exist in database -->
        </div>
    </div>

</div>
