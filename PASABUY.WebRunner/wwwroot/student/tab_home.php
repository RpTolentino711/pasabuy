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
                placeholder="Search for equipment, sound, camera..." id="searchInput"
                oninput="handleHomeSearch(this.value)">
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

    <!-- Categories Horizontal Scroll Wheel -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-2.5">
            <h6 class="fw-extrabold mb-0 text-dark fs-7">Categories</h6>
            <a href="javascript:void(0)" class="text-decoration-none fs-8 fw-bold" style="color: #5B3FA8;" onclick="openCategoryTab('All')">See All <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>

        <style>
            .category-scroll-wheel::-webkit-scrollbar { display: none; }
            .category-wheel-item:hover .cat-icon-box {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(91,63,168,0.18) !important;
                border-color: #5B3FA8 !important;
            }
            .category-wheel-item:active .cat-icon-box {
                transform: scale(0.95);
            }
        </style>

        <!-- Horizontal Scroll Wheel Track -->
        <div class="d-flex gap-2.5 overflow-auto py-1 px-1 category-scroll-wheel" id="categoryScrollWheel"
             style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none; ms-overflow-style: none; scroll-behavior: smooth;"
             onwheel="if(event.deltaY!==0){event.preventDefault(); this.scrollLeft += event.deltaY;}">
            
            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Chairs')" style="cursor: pointer; width: 72px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-chair fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Chairs</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Tables')" style="cursor: pointer; width: 72px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-table fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Tables</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Tents')" style="cursor: pointer; width: 72px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-campground fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Tents</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Sound System')" style="cursor: pointer; width: 76px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-volume-high fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Sound System</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Cameras')" style="cursor: pointer; width: 72px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-camera fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Cameras</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Lights')" style="cursor: pointer; width: 72px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-lightbulb fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Lights</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Decorations')" style="cursor: pointer; width: 76px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-wand-magic-sparkles fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Decorations</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Stages')" style="cursor: pointer; width: 72px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-monument fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Stages</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Catering')" style="cursor: pointer; width: 72px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-utensils fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Catering</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Generators')" style="cursor: pointer; width: 74px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-bolt fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Generators</span>
            </div>

            <div class="category-wheel-item text-center flex-shrink-0" onclick="openCategoryTab('Others')" style="cursor: pointer; width: 72px; scroll-snap-align: start;">
                <div class="cat-icon-box p-2.5 rounded-4 bg-white shadow-xs border d-flex align-items-center justify-content-center mx-auto mb-1.5" style="width: 58px; height: 58px; transition: all 0.2s ease;">
                    <i class="fa-solid fa-cubes-stacked fs-5" style="color: #5B3FA8;"></i>
                </div>
                <span class="fs-9 fw-bold text-dark d-block" style="font-size: 11px; line-height: 1.2;">Others</span>
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
    <div class="mb-3" id="homePackagesSection" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="fw-extrabold mb-0 text-dark fs-7"><i class="fa-solid fa-box-open text-warning me-1"></i> Event Packages</h6>
            <span class="badge rounded-pill text-white fw-bold fs-9" style="background: linear-gradient(135deg, #10B981, #059669);">Save up to 25%</span>
        </div>
        <div id="homePackagesContainer">
            <!-- Dynamically populated if packages exist in database -->
        </div>
    </div>

</div>
