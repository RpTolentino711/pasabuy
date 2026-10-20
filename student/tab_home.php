<!-- ==========================================================
     RentEase Screen 1: Home Discovery Feed (Compact Sleek Layout)
     UIDESIFNAPP.png Screen 1
     ========================================================== -->
<div id="tabHome" style="display:none;">

    <!-- Top Search Input (Compact) -->
    <div class="mb-2">
        <div class="position-relative d-flex align-items-center">
            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:14px; top:50%; transform:translateY(-50%); font-size: 0.85rem; pointer-events:none; z-index:5;"></i>
            <input type="text" class="form-control rounded-pill py-1.5 fs-8 border-0 bg-white shadow-xs"
                style="padding-left: 38px !important; padding-right: 14px;"
                placeholder="Search for equipment, sound, camera..." id="searchInput"
                oninput="handleHomeSearch(this.value)">
        </div>
    </div>

    <!-- Hero Banner Carousel (Dynamic: Most Loved · Get Verified · Rent Now) -->
    <style>
        #heroBannerCarousel {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            margin-bottom: 10px;
            height: 110px;
            cursor: pointer;
        }
        /* All slides stacked absolutely — only active-slide is visible */
        .hero-slide {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            opacity: 0;
            transform: translateX(100%);
            transition: transform 0.55s cubic-bezier(0.4, 0, 0.2, 1),
                        opacity 0.45s ease;
            will-change: transform, opacity;
            z-index: 1;
        }
        /* Incoming slide slides in from the right */
        .hero-slide.active-slide {
            opacity: 1;
            transform: translateX(0%);
            z-index: 3;
        }
        /* Outgoing slide exits to the left */
        .hero-slide.slide-exit {
            opacity: 0;
            transform: translateX(-100%);
            z-index: 2;
        }
        .hero-slide-inner {
            display: flex;
            align-items: center;
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 2;
        }
        .hero-slide-text {
            padding: 14px 10px 14px 16px;
            flex: 1;
            z-index: 3;
        }
        .hero-slide-media {
            flex: 0 0 38%;
            height: 110px;
            position: relative;
            overflow: hidden;
        }
        .hero-slide-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
            mask-image: linear-gradient(to left, black 55%, transparent 100%);
            -webkit-mask-image: linear-gradient(to left, black 55%, transparent 100%);
        }
        /* Dots indicator */
        #heroBannerDots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
        }
        .hero-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255,255,255,0.40);
            transition: all 0.35s ease;
            cursor: pointer;
        }
        .hero-dot.active {
            width: 18px;
            border-radius: 3px;
            background: rgba(255,255,255,0.95);
        }
    </style>

    <div id="heroBannerCarousel" style="box-shadow: 0 6px 22px rgba(91,63,168,0.22);">
        <!-- Slides injected by initHeroBannerCarousel() in rentease_app.js -->
        <!-- Fallback skeleton while JS initialises -->
        <div class="hero-slide active-slide" style="background: linear-gradient(135deg, #5B3FA8 0%, #341F97 100%);">
            <div class="hero-slide-inner">
                <div class="hero-slide-text">
                    <div class="d-inline-flex align-items-center gap-1 badge rounded-pill px-2 py-0.5 mb-1 text-white"
                         style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);font-size:0.6rem;border:1px solid rgba(255,255,255,0.22);">
                        <i class="fa-solid fa-spinner fa-spin" style="font-size:0.55rem;"></i> Loading...
                    </div>
                    <h5 class="fw-extrabold mb-1 text-white" style="font-size:0.9rem;letter-spacing:-0.2px;line-height:1.2;">RentEase Campus</h5>
                    <p class="text-white-50 mb-0" style="font-size:0.7rem;line-height:1.3;">Seamless equipment rentals for your events.</p>
                </div>
            </div>
        </div>
        <div id="heroBannerDots"></div>
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
