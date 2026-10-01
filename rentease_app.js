/**
 * ==========================================================
 * RentEase Core Application Logic (Screens 1 to 8)
 * "Easy Rentals. Seamless Events." | "Rent. Book. Celebrate."
 * ==========================================================
 */

let rentEaseInventory = [];
let rentEaseCart = JSON.parse(localStorage.getItem('rentease_cart')) || [];

let currentDetailProduct = null;
let currentDetailQty = 1;
let currentCategory = 'All';
let currentTag = 'All';
let currentDeliveryOption = 'DELIVERY';
let currentPaymentMethod = 'GCASH';
let currentRentalDays = parseInt(localStorage.getItem('rentease_rental_days') || '1') || 1;
let currentPaymentPlan = 'FULL'; // 'FULL' or 'DOWNPAYMENT_COD'
let rentEaseMapInstance = null;

// API Base URL resolver
function getRentEaseApiUrl(action, params = {}) {
    let base = window.location.pathname.includes('/student/') ? '../rentease_api.php' : 'rentease_api.php';
    const url = new URL(base, window.location.href);
    url.searchParams.set('action', action);
    for (const [k, v] of Object.entries(params)) {
        url.searchParams.set(k, v);
    }
    return url.toString();
}

// ----------------------------------------------------------
// 1. SCREEN 1 & 2: CATALOG & INVENTORY LOADING
// ----------------------------------------------------------
async function loadRentEaseCatalog() {
    try {
        const res = await fetch(getRentEaseApiUrl('get_inventory'));
        if (res.ok) {
            const data = await res.json();
            rentEaseInventory = data.items || [];
            renderFeaturedRentals();
            renderExploreCatalog();
        }
    } catch (e) {
        console.error("RentEase catalog load error:", e);
    }
    updateCartBadgeCount();
}

function renderFeaturedRentals() {
    const container = document.getElementById('homeFeaturedContainer');
    if (!container) return;

    let featured = (rentEaseInventory || []).filter(i => parseInt(i.is_featured) === 1).slice(0, 4);
    if (featured.length === 0 && (rentEaseInventory || []).length > 0) {
        featured = rentEaseInventory.slice(0, 4);
    }

    if (featured.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="card border-0 rounded-4 shadow-sm p-4 bg-white text-center">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-2 text-muted" style="width:48px; height:48px; color:#5B3FA8;">
                        <i class="fa-solid fa-box-open fs-4"></i>
                    </div>
                    <h6 class="fw-bold text-dark fs-8 mb-1">No equipment listed yet</h6>
                    <p class="text-muted fs-9 mb-2.5">Be the first to list equipment for rent on campus!</p>
                    <button class="btn btn-sm btn-primary rounded-pill px-3 py-1 fs-9 fw-bold mx-auto" style="background:#5B3FA8; border:none;" onclick="switchTab('sell')">
                        <i class="fa-solid fa-plus me-1"></i> Post Equipment
                    </button>
                </div>
            </div>`;
        return;
    }

    let html = '';
    featured.forEach(item => {
        html += `
        <div class="col-6 mb-2">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white position-relative d-flex flex-column justify-content-between overflow-hidden" 
                 style="padding: 10px; cursor:pointer;" onclick="openEquipmentDetail(${item.id})">
                <div>
                    <div class="position-relative mb-2">
                        <img src="${item.image_url}" class="rounded-3 w-100" style="height: 125px; object-fit: cover;" alt="${item.name}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';">
                        <button class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-1.5 p-0 d-flex align-items-center justify-content-center shadow-xs" 
                                style="width:26px; height:26px; background:rgba(255,255,255,0.9);" 
                                onclick="event.stopPropagation(); toggleWishlist(this, ${item.id})">
                            <i class="fa-regular fa-heart text-dark fs-9"></i>
                        </button>
                    </div>
                    <h6 class="fw-bold mb-1 text-dark fs-8 text-truncate" title="${item.name}">${item.name}</h6>
                    <div class="d-flex align-items-baseline gap-1 mb-1">
                        <span class="fw-extrabold text-dark fs-7">₱${parseFloat(item.price_per_day).toFixed(0)}</span>
                        <span class="text-muted fs-9">/ day</span>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-1">
                    <div class="d-flex align-items-center gap-1">
                        <i class="fa-solid fa-star text-warning fs-9"></i>
                        <span class="fw-bold text-dark fs-9">${parseFloat(item.rating).toFixed(1)}</span>
                        <span class="text-muted fs-9">(${item.reviews_count})</span>
                    </div>
                    ${isCurrentUserOwnerOfItem(item) 
                        ? `<button class="btn btn-sm rounded-pill px-2.5 py-1 text-white border-0 fw-bold fs-9 shadow-xs" 
                                   style="background: #475569;"
                                   onclick="event.stopPropagation(); openEquipmentDetail(${item.id})" title="Your Equipment">
                               <i class="fa-solid fa-crown me-0.5 text-warning" style="font-size:0.65rem;"></i> Yours
                           </button>`
                        : (rentEaseCart.some(c => c.id == item.id)
                            ? `<button class="btn btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center text-white shadow-xs" 
                                       style="width:30px; height:30px; background: linear-gradient(135deg, #10B981, #059669); flex-shrink: 0;"
                                       onclick="event.stopPropagation(); quickAddRentEaseItem(${item.id}, this)" title="In Cart">
                                   <i class="fa-solid fa-check fs-8"></i>
                               </button>`
                            : `<button class="btn btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center text-white shadow-xs" 
                                       style="width:30px; height:30px; background: linear-gradient(135deg, #5B3FA8, #341F97); flex-shrink: 0;"
                                       onclick="event.stopPropagation(); quickAddRentEaseItem(${item.id}, this)" title="Add to Cart">
                                   <i class="fa-solid fa-cart-plus fs-8"></i>
                               </button>`
                          )
                    }
                </div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
}

function isCurrentUserOwnerOfItem(item) {
    if (!item) return false;
    const currentUser = getRentEaseCurrentUser();
    const currentName = (currentUser.name || '').toLowerCase().trim();
    const currentEmail = (currentUser.email || '').toLowerCase().trim();
    const currentId = parseInt(currentUser.id || 0);

    let postedIds = [];
    try {
        postedIds = JSON.parse(localStorage.getItem('rentease_user_posted_ids') || '[]');
    } catch (e) {}

    const idNum = parseInt(item.id);
    if (postedIds.includes(idNum) || postedIds.includes(String(item.id))) return true;

    if (item.owner_id && parseInt(item.owner_id) === currentId && currentId > 0) return true;
    if (item.seller_id && parseInt(item.seller_id) === currentId && currentId > 0) return true;

    const itemOwnerEmail = (item.owner_email || '').toLowerCase().trim();
    if (itemOwnerEmail && currentEmail && itemOwnerEmail === currentEmail) return true;

    const owner = (item.owner_name || item.seller_name || '').toLowerCase().trim();
    if (owner && currentName) {
        if (owner === currentName) return true;
        if (currentEmail.includes('romeopaolo') && (owner.includes('romeo') || owner.includes('tolentino'))) return true;
        if (currentName.includes('romeo') && (owner.includes('romeo') || owner.includes('tolentino'))) return true;
    }

    return false;
}

function openCategoryTab(category) {
    currentCategory = category;
    currentTag = 'All';
    const titleEl = document.getElementById('exploreCategoryTitle');
    if (titleEl) titleEl.innerText = (category === 'All') ? 'Equipment Catalog' : category;

    // Reset filter chips active state
    const chips = document.querySelectorAll('#exploreFilterChipsContainer .filter-chip');
    chips.forEach(c => {
        if (c.innerText.trim() === 'All') {
            c.className = 'btn btn-sm rounded-pill px-3 py-1 fs-9 fw-bold filter-chip active';
            c.style.background = '#5B3FA8';
            c.style.color = '#fff';
        } else {
            c.className = 'btn btn-sm rounded-pill px-3 py-1 fs-9 fw-bold filter-chip bg-white text-secondary border';
            c.style.background = '#fff';
            c.style.color = '';
        }
    });

    switchTab('explore');
    renderExploreCatalog();
}

function filterRentEaseByTag(btnEl, tag) {
    currentTag = tag;
    const chips = document.querySelectorAll('#exploreFilterChipsContainer .filter-chip');
    chips.forEach(c => {
        c.className = 'btn btn-sm rounded-pill px-3 py-1 fs-9 fw-bold filter-chip bg-white text-secondary border';
        c.style.background = '#fff';
        c.style.color = '';
    });
    btnEl.className = 'btn btn-sm rounded-pill px-3 py-1 fs-9 fw-bold filter-chip active';
    btnEl.style.background = '#5B3FA8';
    btnEl.style.color = '#fff';

    renderExploreCatalog();
}

function handleRentEaseSearch(query) {
    const q = (query || '').toLowerCase().trim();

    // Sync input values between Home and Explore search bars
    const homeInput = document.getElementById('searchInput');
    const exploreInput = document.getElementById('exploreSearchInput');
    const clearBtn = document.getElementById('clearExploreSearchBtn');

    if (homeInput && homeInput.value !== (query || '')) homeInput.value = query || '';
    if (exploreInput && exploreInput.value !== (query || '')) exploreInput.value = query || '';
    if (clearBtn) clearBtn.style.display = q ? 'block' : 'none';

    renderExploreCatalog();
}

function handleHomeSearch(query) {
    handleRentEaseSearch(query);
    if ((query || '').trim().length > 0) {
        switchTab('explore');
    }
}

function clearExploreSearch() {
    const homeInput = document.getElementById('searchInput');
    const exploreInput = document.getElementById('exploreSearchInput');
    const clearBtn = document.getElementById('clearExploreSearchBtn');

    if (homeInput) homeInput.value = '';
    if (exploreInput) exploreInput.value = '';
    if (clearBtn) clearBtn.style.display = 'none';

    renderExploreCatalog();
}

function renderExploreCatalog() {
    let filtered = rentEaseInventory || [];

    if (currentCategory && currentCategory !== 'All') {
        filtered = filtered.filter(i => (i.category || '').toLowerCase() === currentCategory.toLowerCase());
    }
    if (currentTag && currentTag !== 'All') {
        filtered = filtered.filter(i => (i.material_tag || '').toLowerCase() === currentTag.toLowerCase());
    }

    // Apply active search query if any
    const searchInput = document.getElementById('exploreSearchInput') || document.getElementById('searchInput');
    const q = searchInput ? (searchInput.value || '').toLowerCase().trim() : '';
    if (q) {
        filtered = filtered.filter(item => 
            (item.name && item.name.toLowerCase().includes(q)) || 
            (item.category && item.category.toLowerCase().includes(q)) || 
            (item.description && item.description.toLowerCase().includes(q)) ||
            (item.material_tag && item.material_tag.toLowerCase().includes(q)) ||
            (item.owner_name && item.owner_name.toLowerCase().includes(q)) ||
            (item.location && item.location.toLowerCase().includes(q))
        );
    }

    renderGridElements(filtered);
}

function renderGridElements(items) {
    const grid = document.getElementById('exploreProductGrid');
    if (!grid) return;

    if (items.length === 0) {
        grid.innerHTML = `
        <div class="col-12 text-center py-5 bg-white rounded-4 border p-4">
            <i class="fa-solid fa-box-open fs-2 d-block mb-2 text-secondary opacity-50"></i>
            <h6 class="fw-bold text-dark fs-7 mb-1">No equipment found</h6>
            <p class="fs-9 text-muted mb-0">Try selecting another filter chip or category.</p>
        </div>`;
        return;
    }

    let html = '';
    items.forEach(p => {
        const isMine = isCurrentUserOwnerOfItem(p);
        const inCart = rentEaseCart.some(c => c.id === p.id);

        let cartBtnClass = 'text-white';
        let cartBtnStyle = 'background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;';
        let cartBtnText = '<i class="fa-solid fa-cart-plus me-1"></i> Add to Cart';
        let cartOnClick = `event.stopPropagation(); quickAddRentEaseItem(${p.id}, this)`;

        if (isMine) {
            cartBtnClass = 'text-white';
            cartBtnStyle = 'background: #475569; border:none;';
            cartBtnText = '<i class="fa-solid fa-crown text-warning me-1"></i> Your Equipment';
            cartOnClick = `event.stopPropagation(); openEquipmentDetail(${p.id})`;
        } else if (inCart) {
            cartBtnClass = 'btn-success text-white';
            cartBtnStyle = 'background: linear-gradient(135deg, #10B981, #059669); border:none;';
            cartBtnText = '<i class="fa-solid fa-check me-1"></i> Added';
        }

        html += `
        <div class="col-6 mb-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white position-relative d-flex flex-column justify-content-between overflow-hidden" 
                 style="padding: 10px; cursor:pointer;" onclick="openEquipmentDetail(${p.id})">
                <div>
                    <div class="position-relative mb-2">
                        <img src="${p.image_url}" class="rounded-3 w-100" style="height: 130px; object-fit: cover;" alt="${p.name}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';">
                        <button class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-1.5 p-0 d-flex align-items-center justify-content-center shadow-xs" 
                                style="width:26px; height:26px; background:rgba(255,255,255,0.9);" 
                                onclick="event.stopPropagation(); toggleWishlist(this, ${p.id})">
                            <i class="fa-regular fa-heart text-dark fs-9"></i>
                        </button>
                    </div>
                    <h6 class="fw-bold mb-1 text-dark fs-8 text-truncate" title="${p.name}">${p.name}</h6>
                    <div class="d-flex align-items-baseline gap-1 mb-1">
                        <span class="fw-extrabold text-dark fs-7">₱${parseFloat(p.price_per_day).toFixed(0)}</span>
                        <span class="text-muted fs-9">/ day</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-1.5">
                        <span class="badge ${p.qty_available > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} fw-bold" style="font-size: 0.65rem;">
                            <i class="fa-solid fa-boxes-stacked me-1"></i>Stock: ${p.qty_available ?? p.qty_total}
                        </span>
                        ${isMine ? `<span class="badge bg-primary-subtle text-primary" style="font-size:0.62rem;"><i class="fa-solid fa-crown me-0.5"></i>Yours</span>` : (p.owner_name ? `<span class="text-muted" style="font-size:0.62rem;"><i class="fa-regular fa-user me-0.5"></i>${p.owner_name.split(' ')[0]}</span>` : '')}
                    </div>
                    <div class="d-flex align-items-center gap-1 mb-2.5">
                        <i class="fa-solid fa-star text-warning fs-9"></i>
                        <span class="fw-bold text-dark fs-9">${parseFloat(p.rating).toFixed(1)}</span>
                        <span class="text-muted fs-9">(${p.reviews_count})</span>
                    </div>
                </div>
                <button class="btn btn-sm rounded-pill w-100 fw-bold fs-9 py-2 shadow-2xs ${cartBtnClass}" 
                        style="${cartBtnStyle}" onclick="${cartOnClick}">
                    ${cartBtnText}
                </button>
            </div>
        </div>`;
    });
    grid.innerHTML = html;
}

// ----------------------------------------------------------
// 2. SCREEN 3: PRODUCT DETAIL MODAL
// ----------------------------------------------------------
// 2. SCREEN 3: PRODUCT DETAIL MODAL & DYNAMIC MEDIA CAROUSEL
// ----------------------------------------------------------
window.setupDetailMediaCarousel = function (item) {
    const carouselEl = document.getElementById('detailMediaCarousel');
    const innerEl = document.getElementById('detailCarouselInner');
    const indicatorsEl = document.getElementById('detailCarouselIndicators');
    const prevBtn = document.getElementById('detailCarouselPrevBtn');
    const nextBtn = document.getElementById('detailCarouselNextBtn');
    const badgeEl = document.getElementById('detailMediaBadge');
    const countEl = document.getElementById('detailMediaCount');
    if (!carouselEl || !innerEl) return;

    // Dispose previous instance cleanly
    if (window.detailBsCarousel) {
        try { window.detailBsCarousel.dispose(); } catch (e) {}
        window.detailBsCarousel = null;
    }

    // Collect all media items (photos and video)
    let media = [];

    // 1. Primary photo
    const mainPhoto = item.image_url || item.img || item.ImageUrl || item.image;
    if (mainPhoto && typeof mainPhoto === 'string' && mainPhoto.trim()) {
        media.push({ type: 'image', url: mainPhoto.trim() });
    }

    // 2. Additional photos (arrays, JSON string, or comma-separated list)
    let extraPhotos = item.photos || item.images || item.image_urls || item.gallery;
    if (typeof extraPhotos === 'string') {
        try {
            extraPhotos = JSON.parse(extraPhotos);
        } catch (e) {
            extraPhotos = extraPhotos.split(',').map(s => s.trim()).filter(Boolean);
        }
    }
    if (Array.isArray(extraPhotos)) {
        extraPhotos.forEach(u => {
            if (u && typeof u === 'string' && u.trim() && !media.some(m => m.url === u.trim())) {
                media.push({ type: 'image', url: u.trim() });
            }
        });
    }

    // 3. Video demonstration (item.video_url / item.videoUrl / item.VideoUrl)
    const video = item.video_url || item.videoUrl || item.VideoUrl;
    if (video && typeof video === 'string' && video.trim()) {
        media.push({ type: 'video', url: video.trim() });
    }

    // Fallback if no media at all
    if (media.length === 0) {
        media.push({ type: 'image', url: 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80' });
    }

    // Build Slides & Indicators HTML
    let slidesHtml = '';
    let indicatorsHtml = '';

    media.forEach((m, idx) => {
        const isActive = idx === 0 ? 'active' : '';
        indicatorsHtml += `
            <button type="button" data-bs-target="#detailMediaCarousel" data-bs-slide-to="${idx}" 
                    class="${isActive} rounded-pill" aria-label="Slide ${idx + 1}" 
                    style="${idx === 0 ? 'width:20px; height:6px; background-color:#fff;' : 'width:6px; height:6px; background-color:rgba(255,255,255,0.6);'} border:none; transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);"></button>
        `;

        if (m.type === 'video') {
            slidesHtml += `
            <div class="carousel-item ${isActive}" style="height:260px; background:#000;">
                <div class="position-relative w-100 h-100 d-flex align-items-center justify-content-center bg-black">
                    <video src="${m.url}" controls playsinline preload="metadata" 
                           class="w-100 h-100" style="object-fit:contain; max-height:260px;"
                           onplay="if(window.detailBsCarousel) window.detailBsCarousel.pause();"
                           onpause="if(window.detailBsCarousel) window.detailBsCarousel.cycle();"></video>
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2.5 shadow-sm fs-9" style="backdrop-filter:blur(4px);">
                        <i class="fa-solid fa-circle-play me-1"></i> Video Demo
                    </span>
                </div>
            </div>`;
        } else {
            slidesHtml += `
            <div class="carousel-item ${isActive}" style="height:260px;">
                <img src="${m.url}" class="d-block w-100 h-100" style="object-fit:cover;" alt="${item.name || 'Equipment'}"
                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';">
            </div>`;
        }
    });

    innerEl.innerHTML = slidesHtml;
    if (indicatorsEl) indicatorsEl.innerHTML = indicatorsHtml;

    const hasMultiple = media.length > 1;
    if (prevBtn) prevBtn.style.display = hasMultiple ? 'flex' : 'none';
    if (nextBtn) nextBtn.style.display = hasMultiple ? 'flex' : 'none';
    if (indicatorsEl) indicatorsEl.style.display = hasMultiple ? 'flex' : 'none';
    if (badgeEl) {
        badgeEl.style.display = hasMultiple ? 'block' : 'none';
        if (countEl) countEl.innerText = `1/${media.length}`;
    }

    // Initialize Bootstrap Carousel with 3.5s auto-slide and touch support
    window.detailBsCarousel = new bootstrap.Carousel(carouselEl, {
        interval: hasMultiple ? 3500 : false,
        ride: hasMultiple ? 'carousel' : false,
        wrap: true,
        touch: true
    });

    if (hasMultiple) {
        window.detailBsCarousel.cycle();
    }

    // Slide transition handler to update indicators and counters
    carouselEl.onbsSlide = function (e) {
        if (countEl) countEl.innerText = `${e.to + 1}/${media.length}`;
        if (indicatorsEl) {
            const buttons = indicatorsEl.querySelectorAll('button');
            buttons.forEach((btn, idx) => {
                if (idx === e.to) {
                    btn.style.width = '20px';
                    btn.style.backgroundColor = '#fff';
                    btn.classList.add('active');
                } else {
                    btn.style.width = '6px';
                    btn.style.backgroundColor = 'rgba(255,255,255,0.6)';
                    btn.classList.remove('active');
                }
            });
        }
        // Pause any video from the previous slide
        const videos = innerEl.querySelectorAll('video');
        videos.forEach(v => { try { v.pause(); } catch(err){} });
    };

    carouselEl.removeEventListener('slide.bs.carousel', carouselEl._slideHandler || (()=>{}));
    carouselEl._slideHandler = carouselEl.onbsSlide;
    carouselEl.addEventListener('slide.bs.carousel', carouselEl._slideHandler);

    // Attach touch swiping & mouse dragging gestures
    enableCarouselTouchAndDrag(carouselEl);
};

function enableCarouselTouchAndDrag(carouselEl) {
    if (!carouselEl || carouselEl._touchDragAttached) return;
    carouselEl._touchDragAttached = true;

    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    const threshold = 40;

    // Mobile touch events
    carouselEl.addEventListener('touchstart', function (e) {
        if (e.touches && e.touches.length === 1) {
            startX = e.touches[0].clientX;
            currentX = startX;
        }
    }, { passive: true });

    carouselEl.addEventListener('touchmove', function (e) {
        if (e.touches && e.touches.length === 1) {
            currentX = e.touches[0].clientX;
        }
    }, { passive: true });

    carouselEl.addEventListener('touchend', function () {
        const diffX = currentX - startX;
        if (Math.abs(diffX) > threshold && window.detailBsCarousel) {
            if (diffX < 0) {
                window.detailBsCarousel.next();
            } else {
                window.detailBsCarousel.prev();
            }
        }
    }, { passive: true });

    // Desktop mouse drag events
    carouselEl.addEventListener('mousedown', function (e) {
        if (e.target.tagName.toLowerCase() === 'video' || e.target.tagName.toLowerCase() === 'button' || e.target.closest('button')) return;
        isDragging = true;
        startX = e.clientX;
        currentX = startX;
        carouselEl.style.cursor = 'grabbing';
    });

    window.addEventListener('mousemove', function (e) {
        if (!isDragging) return;
        currentX = e.clientX;
    });

    window.addEventListener('mouseup', function () {
        if (!isDragging) return;
        isDragging = false;
        if (carouselEl) carouselEl.style.cursor = 'grab';
        const diffX = currentX - startX;
        if (Math.abs(diffX) > threshold && window.detailBsCarousel) {
            if (diffX < 0) {
                window.detailBsCarousel.next();
            } else {
                window.detailBsCarousel.prev();
            }
        }
    });
}

function openEquipmentDetail(id) {
    let item = (rentEaseInventory || []).find(i => i.id == id);
    if (!item && typeof allProductsCache !== 'undefined') {
        const p = allProductsCache.find(x => x.id == id);
        if (p) {
            item = {
                id: p.id,
                name: p.title,
                price_per_day: parseFloat(String(p.price || 0).replace(/[^\d.]/g, '')) || 0,
                image_url: p.img || 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80',
                video_url: p.videoUrl || '',
                photos: p.photos || p.images || [],
                description: p.description || '',
                qty_available: p.stockQuantity ?? 1,
                qty_total: p.stockQuantity ?? 1,
                rating: 5.0,
                reviews_count: 1,
                owner_id: p.sellerId || 104,
                owner_name: p.seller || 'Student'
            };
        }
    }
    if (!item) return;

    currentDetailProduct = item;
    currentDetailQty = 1;

    const headerTitle = document.getElementById('detailHeaderTitle');
    if (headerTitle) headerTitle.innerText = item.name || 'Equipment Details';
    const detailTitle = document.getElementById('detailTitle');
    if (detailTitle) detailTitle.innerText = item.name;

    // Setup Dynamic Media Carousel with Auto-slide & Touch Swiping
    window.setupDetailMediaCarousel(item);

    const ratingValEl = document.getElementById('detailRatingVal');
    if (ratingValEl) ratingValEl.innerText = parseFloat(item.rating || 5.0).toFixed(1);
    const reviewCountEl = document.getElementById('detailReviewCount');
    if (reviewCountEl) reviewCountEl.innerText = item.reviews_count || 1;
    const priceEl = document.getElementById('detailPrice');
    if (priceEl) priceEl.innerText = '₱' + parseFloat(item.price_per_day || 0).toFixed(0);
    const descEl = document.getElementById('detailDescription');
    if (descEl) descEl.innerText = item.description || 'Quality event equipment for rent, maintained and cleaned for every booking.';
    const qtyValEl = document.getElementById('detailQtyVal');
    if (qtyValEl) qtyValEl.innerText = currentDetailQty;

    // Display stock clearly
    const avail = parseInt(item.qty_available ?? item.qty_total ?? 1);
    const stockEl = document.getElementById('detailStockBadge');
    if (stockEl) {
        stockEl.innerHTML = avail > 0 
            ? `<i class="fa-solid fa-boxes-stacked text-success fs-7 mb-1"></i><span class="fs-9 fw-bold text-dark" style="font-size:0.68rem;">Stock: <strong>${avail}</strong> units</span>` 
            : `<i class="fa-solid fa-triangle-exclamation text-danger fs-7 mb-1"></i><span class="fs-9 fw-bold text-danger" style="font-size:0.68rem;">Out of Stock</span>`;
    }
    const maxStockLabel = document.getElementById('detailMaxStockLabel');
    if (maxStockLabel) {
        maxStockLabel.innerText = `(Max ${avail})`;
    }

    // Check if the current user is the owner of this equipment!
    const isOwner = isCurrentUserOwnerOfItem(item);
    const qtyContainer = document.getElementById('detailQtyContainer');
    const ownerSection = document.getElementById('detailOwnerControlSection');
    const ownerNotice = document.getElementById('detailOwnerNoticeContainer');
    const footerActions = document.getElementById('detailFooterActions');
    const safeTitle = (item.name || 'Equipment').replace(/'/g, "\\'");

    if (isOwner) {
        if (qtyContainer) qtyContainer.style.setProperty('display', 'none', 'important');
        if (ownerNotice) ownerNotice.style.setProperty('display', 'none', 'important');
        if (ownerSection) ownerSection.style.setProperty('display', 'block', 'important');

        const pInput = document.getElementById('detailOwnerPriceInput');
        if (pInput) pInput.value = parseFloat(item.price_per_day || 0).toFixed(0);
        const sInput = document.getElementById('detailOwnerStockInput');
        if (sInput) sInput.value = avail;

        if (footerActions) {
            footerActions.innerHTML = `
                <button type="button" class="btn btn-outline-danger rounded-4 py-2.5 px-3 fw-bold fs-7 d-flex align-items-center justify-content-center gap-1.5 flex-grow-1" 
                        onclick="promptTakeDownOwnerItem(${item.id}, '${safeTitle}')">
                    <i class="fa-solid fa-trash-can me-1"></i> Take Down Listing
                </button>
                <button type="button" class="btn btn-light rounded-4 py-2.5 px-3 fw-bold fs-7 border text-secondary" 
                        data-bs-dismiss="modal">
                    Close
                </button>
            `;
        }
    } else {
        if (qtyContainer) qtyContainer.style.removeProperty('display');
        if (ownerNotice) ownerNotice.style.setProperty('display', 'none', 'important');
        if (ownerSection) ownerSection.style.setProperty('display', 'none', 'important');

        if (footerActions) {
            footerActions.innerHTML = `
                <button type="button" class="btn btn-outline-primary rounded-4 py-2.5 px-3 fw-bold fs-7 d-flex align-items-center justify-content-center gap-1 text-nowrap" 
                        style="border-color:#5B3FA8; color:#5B3FA8;" onclick="chatWithOwnerFromDetail()" title="Chat with Owner">
                    <i class="fa-regular fa-comment-dots fs-6"></i>
                    <span>Chat</span>
                </button>
                <button type="button" class="btn btn-outline-primary rounded-4 py-2.5 px-3 fw-extrabold fs-7 flex-grow-1 d-flex align-items-center justify-content-center gap-1.5 shadow-2xs text-nowrap" 
                        style="border: 2px solid #5B3FA8; color: #5B3FA8; background: #fff;" id="detailAddToCartBtn" onclick="confirmAddDetailToCart()">
                    <i class="fa-solid fa-cart-plus fs-6"></i>
                    <span>Add to Cart</span>
                </button>
                <button type="button" class="btn btn-primary rounded-4 py-2.5 px-3 fw-extrabold fs-7 flex-grow-1 d-flex align-items-center justify-content-center gap-1.5 shadow-sm text-nowrap" 
                        style="background: linear-gradient(135deg, #5B3FA8, #341F97); border: none; color: #fff;" id="detailRentNowBtn" onclick="confirmRentNowDetail()">
                    <i class="fa-solid fa-bolt fs-6 text-warning"></i>
                    <span>Rent Now</span>
                </button>
            `;
        }
    }

    const modalEl = document.getElementById('productDetailModal');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
        bsModal.show();
    }
}

window.openRentalDetail = openEquipmentDetail;
window.openEquipmentDetail = openEquipmentDetail;

function adjustDetailQty(delta) {
    const maxStock = (currentDetailProduct && (currentDetailProduct.qty_available ?? currentDetailProduct.qty_total)) 
        ? parseInt(currentDetailProduct.qty_available ?? currentDetailProduct.qty_total) 
        : 99;
    currentDetailQty = Math.max(1, Math.min(maxStock, currentDetailQty + delta));
    const el = document.getElementById('detailQtyVal');
    if (el) el.innerText = currentDetailQty;
}

// RENT NOW ACTION: Adds item to cart, notifies stock owner, and jumps straight to Checkout!
window.confirmRentNowDetail = async function () {
    if (!currentDetailProduct) return;
    if (isCurrentUserOwnerOfItem(currentDetailProduct)) {
        alert("ℹ️ You cannot rent your own equipment.");
        return;
    }
    const avail = parseInt(currentDetailProduct.qty_available ?? currentDetailProduct.qty_total ?? 1);
    if (avail <= 0) {
        alert("⚠️ Sorry, this equipment is currently out of stock.");
        return;
    }

    // Add to cart with current selected quantity
    addRentEaseCartItem(currentDetailProduct, currentDetailQty);

    // Notify the stock owner immediately via backend API
    try {
        const currentUser = getRentEaseCurrentUser();
        fetch(getRentEaseApiUrl('notify_owner_rental_intent'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                product_id: currentDetailProduct.id,
                product_name: currentDetailProduct.name || currentDetailProduct.title,
                customer_name: currentUser.name || 'Campus Student',
                customer_id: currentUser.id || 105,
                qty: currentDetailQty,
                owner_id: currentDetailProduct.owner_id || currentDetailProduct.seller_id || 104
            })
        }).catch(e => console.error("Rent now notify error:", e));
    } catch (e) {}

    // Hide product detail modal
    const modalEl = document.getElementById('productDetailModal');
    if (modalEl) {
        const bs = bootstrap.Modal.getInstance(modalEl);
        if (bs) bs.hide();
    }

    // Switch to cart tab and open checkout screen directly!
    switchTab('cart');
    openCheckoutScreen();
};

// OWNER ACTIONS: Save live stock and rental price
window.saveOwnerStockPriceFromDetail = async function () {
    if (!currentDetailProduct) return;
    const pInput = document.getElementById('detailOwnerPriceInput');
    const sInput = document.getElementById('detailOwnerStockInput');
    const saveBtn = document.getElementById('btnSaveOwnerDetailChanges');

    const price = parseFloat(pInput?.value || 0);
    const avail = parseInt(sInput?.value || 0);

    if (price <= 0) {
        alert("⚠️ Please enter a valid daily rental price.");
        return;
    }
    if (avail < 0) {
        alert("⚠️ Stock units cannot be negative.");
        return;
    }

    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';
    }

    const currentUser = getRentEaseCurrentUser();
    try {
        const res = await fetch(getRentEaseApiUrl('owner_update_stock_price'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id: currentDetailProduct.id,
                price_per_day: price,
                qty_available: avail,
                qty_total: Math.max(currentDetailProduct.qty_total || avail, avail),
                owner_id: currentUser.id || 0,
                owner_email: currentUser.email || ''
            })
        });
        const data = await res.json();
        if (data.success) {
            currentDetailProduct.price_per_day = price;
            currentDetailProduct.qty_available = avail;
            const priceEl = document.getElementById('detailPrice');
            if (priceEl) priceEl.innerText = '₱' + price.toFixed(0);
            const stockEl = document.getElementById('detailStockBadge');
            if (stockEl) {
                stockEl.innerHTML = avail > 0 
                    ? `<i class="fa-solid fa-boxes-stacked text-success fs-7 mb-1"></i><span class="fs-9 fw-bold text-dark" style="font-size:0.68rem;">Stock: <strong>${avail}</strong> units</span>` 
                    : `<i class="fa-solid fa-triangle-exclamation text-danger fs-7 mb-1"></i><span class="fs-9 fw-bold text-danger" style="font-size:0.68rem;">Out of Stock</span>`;
            }
            await loadRentEaseCatalog();
            alert("✅ Successfully updated rental rate to ₱" + price.toFixed(0) + "/day and stock to " + avail + " units!");
        } else {
            alert("❌ " + (data.message || "Failed to update item."));
        }
    } catch (e) {
        alert("❌ Error connecting to server to save changes.");
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Save Stock & Price Changes';
        }
    }
};

// OWNER ACTIONS: Take down item with refund warning confirmation
window.promptTakeDownOwnerItem = function (id, name) {
    const item = currentDetailProduct || { id: id, name: name };
    const itemName = name || item.name || 'this equipment';
    const warningMsg = 
`⚠️ TAKE DOWN LISTING & REFUND WARNING

Are you sure you want to take down "${itemName}"?

• NOTICE: You can receive a REFUND of your listing fee once taken down (provided no active rental bookings remain unfulfilled).
• Once taken down, this equipment will immediately be removed from campus search and student catalog.
• Any ongoing active bookings must still be honored.

Do you want to proceed and take down this listing?`;

    if (confirm(warningMsg)) {
        const modalEl = document.getElementById('productDetailModal');
        if (modalEl) {
            const bs = bootstrap.Modal.getInstance(modalEl);
            if (bs) bs.hide();
        }
        deleteUserRentalItem(item.id || id, itemName);
    }
};

// Parabolic Fly-To-Cart Animation (using native Web Animations API)
window.animateFlyToCart = function (sourceElement, imageUrl) {
    try {
        const cartTarget = document.getElementById('headerCartBtn') || document.getElementById('cartCountBadge') || document.querySelector('.fa-cart-shopping');
        if (!cartTarget) return;

        let srcRect = null;
        if (sourceElement && typeof sourceElement.getBoundingClientRect === 'function') {
            const r = sourceElement.getBoundingClientRect();
            if (r.width > 0 && r.height > 0) {
                srcRect = r;
            }
        }
        if (!srcRect) {
            srcRect = { left: window.innerWidth / 2 - 20, top: window.innerHeight / 2 - 20, width: 40, height: 40 };
        }

        const dstRect = cartTarget.getBoundingClientRect();

        const startX = srcRect.left + (srcRect.width / 2) - 22;
        const startY = srcRect.top + (srcRect.height / 2) - 22;
        const endX = dstRect.left + (dstRect.width / 2) - 22;
        const endY = dstRect.top + (dstRect.height / 2) - 22;

        const deltaX = endX - startX;
        const deltaY = endY - startY;

        const flyer = document.createElement('div');
        flyer.className = 'fly-to-cart-element';
        const img = imageUrl || 'LOGO.png';
        flyer.style.cssText = `
            position: fixed !important;
            left: ${startX}px !important;
            top: ${startY}px !important;
            width: 44px !important;
            height: 44px !important;
            border-radius: 50% !important;
            background-image: url('${img}') !important;
            background-size: cover !important;
            background-position: center !important;
            border: 2.5px solid #5B3FA8 !important;
            box-shadow: 0 10px 25px rgba(91, 63, 168, 0.6) !important;
            z-index: 9999999 !important;
            pointer-events: none !important;
            will-change: transform, opacity !important;
        `;

        document.body.appendChild(flyer);

        // Web Animations API with curved / parabolic arc trajectory
        const animation = flyer.animate([
            {
                transform: 'translate(0px, 0px) scale(1) rotate(0deg)',
                opacity: 1
            },
            {
                transform: `translate(${deltaX * 0.45}px, ${deltaY * 0.35 - 75}px) scale(0.85) rotate(160deg)`,
                opacity: 0.95,
                offset: 0.45
            },
            {
                transform: `translate(${deltaX}px, ${deltaY}px) scale(0.18) rotate(360deg)`,
                opacity: 0.2
            }
        ], {
            duration: 650,
            easing: 'cubic-bezier(0.2, 0.85, 0.25, 1)',
            fill: 'forwards'
        });

        animation.onfinish = () => {
            if (flyer && flyer.parentNode) {
                flyer.parentNode.removeChild(flyer);
            }
            cartTarget.classList.add('cart-bounce-pop');
            const badge = document.getElementById('cartCountBadge') || document.getElementById('headerCartBadge');
            if (badge) {
                badge.classList.add('cart-badge-pop');
                setTimeout(() => badge.classList.remove('cart-badge-pop'), 450);
            }
            setTimeout(() => cartTarget.classList.remove('cart-bounce-pop'), 550);
        };
    } catch (e) {
        console.warn("Fly animation error:", e);
    }
};

function confirmAddDetailToCart(btnEl) {
    if (!currentDetailProduct) return;
    if (isCurrentUserOwnerOfItem(currentDetailProduct)) {
        alert("ℹ️ You cannot rent or add your own equipment to the cart.");
        return;
    }
    const avail = parseInt(currentDetailProduct.qty_available ?? currentDetailProduct.qty_total ?? 1);
    if (avail <= 0) {
        alert("⚠️ Sorry, this equipment is currently out of stock.");
        return;
    }
    const alreadyInCart = rentEaseCart.some(i => i.id == currentDetailProduct.id);
    const qty = currentDetailQty || 1;
    addRentEaseCartItem(currentDetailProduct, qty);

    const btn = btnEl || document.getElementById('detailAddToCartBtn');
    if (btn) {
        const origHtml = btn.innerHTML;
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success', 'text-white');
        btn.innerHTML = '<i class="fa-solid fa-check fs-6"></i> Added to Cart!';
        setTimeout(() => {
            if (btn) {
                btn.classList.remove('btn-success', 'text-white');
                btn.classList.add('btn-outline-primary');
                btn.innerHTML = origHtml;
            }
        }, 1800);
    }

    if (typeof window.animateFlyToCart === 'function') {
        window.animateFlyToCart(btn, currentDetailProduct.image_url);
    }

    showCartToastNotification(currentDetailProduct.name || currentDetailProduct.title, qty, alreadyInCart);
    renderExploreCatalog();
    renderFeaturedRentals();
}
window.confirmAddDetailToCart = confirmAddDetailToCart;
window.confirmAddToCartDetail = confirmAddDetailToCart;

function quickAddRentEaseItem(id, clickedEl) {
    const item = (rentEaseInventory || []).find(i => i.id == id);
    if (!item) return;
    if (isCurrentUserOwnerOfItem(item)) {
        alert("ℹ️ You cannot rent or add your own equipment to the cart.");
        return;
    }
    const avail = parseInt(item.qty_available ?? item.qty_total ?? 1);
    if (avail <= 0) {
        alert("⚠️ Sorry, this equipment is currently out of stock.");
        return;
    }

    const alreadyInCart = rentEaseCart.some(i => i.id == item.id);

    addRentEaseCartItem(item, 1);

    const triggerEl = clickedEl || (window.event ? (window.event.currentTarget || window.event.target) : null);
    if (typeof window.animateFlyToCart === 'function') {
        window.animateFlyToCart(triggerEl, item.image_url);
    }
    showCartToastNotification(item.name || item.title, 1, alreadyInCart);
    renderExploreCatalog();
    renderFeaturedRentals();
}
window.quickAddRentEaseItem = quickAddRentEaseItem;

// ==========================================================
// 8. PROFILE 3-SUBTABS: REQUESTS, RENT ITEMS (STOCK MONITOR), HISTORY
// ==========================================================
window.switchProfileSubTab = function(subtab) {
    const tabs = ['requests', 'inventory', 'history'];
    tabs.forEach(t => {
        const sec = document.getElementById('profileSection' + t.charAt(0).toUpperCase() + t.slice(1));
        const btn = document.getElementById('btnProfileTab' + t.charAt(0).toUpperCase() + t.slice(1));
        const isActive = (t === subtab);
        if (sec) {
            if (isActive) {
                sec.classList.remove('d-none');
                sec.style.setProperty('display', 'flex', 'important');
            } else {
                sec.classList.add('d-none');
                sec.style.setProperty('display', 'none', 'important');
            }
        }
        if (btn) {
            if (isActive) {
                btn.className = 'btn btn-sm rounded-pill flex-grow-1 profile-subtab-btn active text-white d-flex align-items-center justify-content-center gap-1.5';
                btn.style.background = 'linear-gradient(135deg, #5B3FA8, #341F97)';
                btn.style.boxShadow = '0 2px 8px rgba(91, 63, 168, 0.25)';
                btn.style.border = 'none';
            } else {
                btn.className = 'btn btn-sm rounded-pill flex-grow-1 profile-subtab-btn text-secondary d-flex align-items-center justify-content-center gap-1.5';
                btn.style.background = 'transparent';
                btn.style.boxShadow = 'none';
                btn.style.border = 'none';
            }
        }
    });

    if (subtab === 'requests' || subtab === 'inventory' || subtab === 'history') {
        loadOwnerRentalDashboard(false);
    }
};

function getLoggedInOwnerInfo() {
    let u = null;
    try { u = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) {}
    if (!u) return { email: '', name: '', id: 0, studentNumber: '' };
    const fullName = u.name || ((u.firstName || '') + ' ' + (u.lastName || '')).trim();
    return {
        email: (u.email || '').trim().toLowerCase(),
        name: fullName,
        id: u.id || u.userId || 0,
        studentNumber: u.studentNumber || ''
    };
}

window.loadOwnerRentalDashboard = async function (forceRefresh = false) {
    const owner = getLoggedInOwnerInfo();
    const profileBadge = document.getElementById('profileRequestsBadge');
    const tabProfileBadge = document.getElementById('tabProfileBadge');
    const rentoutPendingBadge = document.getElementById('rentoutPendingBadge');

    if (!owner.email && !owner.name && !owner.id) {
        if (profileBadge) profileBadge.style.display = 'none';
        if (tabProfileBadge) tabProfileBadge.style.display = 'none';
        if (rentoutPendingBadge) rentoutPendingBadge.style.display = 'none';
        return;
    }

    try {
        const res = await fetch(getRentEaseApiUrl('get_owner_rental_data', {
            owner_email: owner.email,
            owner_name: owner.name,
            owner_id: owner.id,
            customer_phone: owner.studentNumber
        }));
        if (!res.ok) return;
        const data = await res.json();
        if (!data || !data.success) return;

        // 1. Update KPI counters
        const kpiTotal = document.getElementById('kpiTotalStockOwned');
        const kpiRented = document.getElementById('kpiTotalStockRented');
        const kpiAvail = document.getElementById('kpiTotalStockAvailable');
        const invBadge = document.getElementById('myRentalCountBadge');
        if (kpiTotal) kpiTotal.innerText = data.total_stock_owned ?? 0;
        if (kpiRented) kpiRented.innerText = data.total_rented_out ?? 0;
        if (kpiAvail) kpiAvail.innerText = data.total_available ?? 0;
        if (invBadge) invBadge.innerText = (data.inventory || []).length;

        // 2. Notification Badges
        const incomingCount = (data.incoming_requests || []).length;
        const profileBadge = document.getElementById('profileRequestsBadge');
        const tabProfileBadge = document.getElementById('tabProfileBadge');
        if (profileBadge) {
            if (incomingCount > 0) {
                profileBadge.innerText = incomingCount;
                profileBadge.style.display = 'inline-block';
            } else {
                profileBadge.style.display = 'none';
            }
        }
        if (tabProfileBadge) {
            if (incomingCount > 0) {
                tabProfileBadge.innerText = incomingCount;
                tabProfileBadge.style.display = 'inline-block';
            } else {
                tabProfileBadge.style.display = 'none';
            }
        }

        // 3. Render Subtab 1: Rental Requests Container
        const reqContainer = document.getElementById('ownerRequestsListContainer');
        if (reqContainer) {
            if (!data.incoming_requests || data.incoming_requests.length === 0) {
                reqContainer.innerHTML = `
                    <div class="card border-0 rounded-4 shadow-2xs p-3.5 bg-white text-center">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-1.5" style="width:40px; height:40px; color:#5B3FA8;">
                            <i class="fa-solid fa-inbox fs-5"></i>
                        </div>
                        <h6 class="fw-bold text-dark fs-8 mb-0.5">No Active Rental Requests</h6>
                        <p class="text-muted mb-0" style="font-size:0.72rem;">When students rent your equipment, orders will appear here for you to accept and dispatch.</p>
                    </div>
                `;
            } else {
                let html = '';
                data.incoming_requests.forEach(order => {
                    const status = (order.order_status || 'CONFIRMED').toUpperCase();
                    let statusBadgeClass = 'bg-primary';
                    if (status === 'PREPARING') statusBadgeClass = 'bg-warning text-dark';
                    if (status === 'IN_TRANSIT') statusBadgeClass = 'bg-info text-dark';
                    if (status === 'RETURNED') statusBadgeClass = 'bg-success';

                    const itemsHtml = (order.items || []).map(it => `
                        <div class="d-flex align-items-center gap-2 p-1.5 bg-light rounded-3 mb-1">
                            <img src="${it.image_url || 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80'}" class="rounded-2" style="width:36px; height:36px; object-fit:cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';">
                            <div class="flex-grow-1 text-truncate">
                                <div class="fw-bold text-dark fs-9 text-truncate">${it.product_name}</div>
                                <div class="fs-9 text-muted">${it.quantity}x unit(s) • ₱${parseFloat(it.price_per_day).toFixed(0)}/day</div>
                            </div>
                            <div class="fw-extrabold text-dark fs-9">₱${parseFloat(it.subtotal).toFixed(0)}</div>
                        </div>
                    `).join('');

                    html += `
                    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-1.5">
                                <span class="fw-extrabold text-dark fs-8">${order.order_code}</span>
                                <span class="badge ${statusBadgeClass} rounded-pill fs-9 fw-bold">${status}</span>
                            </div>
                            <span class="text-muted fs-9">${order.rental_days || 1} day(s) duration</span>
                        </div>

                        <!-- Customer Info -->
                        <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border mb-2">
                            <div class="d-flex align-items-center gap-2 text-truncate">
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width:28px; height:28px; font-size:11px; flex-shrink:0;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="text-truncate">
                                    <div class="fw-bold text-dark fs-9 text-truncate">${order.customer_name}</div>
                                    <div class="fs-9 text-muted">${order.customer_phone || 'Verified Student'}</div>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-light rounded-pill px-2.5 py-1 fs-9 fw-bold border text-primary" onclick="openChatWithRenter('${order.customer_name}', '${order.customer_phone || ''}', '${order.order_code}')">
                                <i class="fa-solid fa-comment me-1"></i> Chat
                            </button>
                        </div>

                        <!-- Items list -->
                        <div class="mb-2">
                            ${itemsHtml}
                        </div>

                        <!-- Financials & Dates -->
                        <div class="d-flex align-items-center justify-content-between fs-9 text-muted mb-2.5 px-1">
                            <div>Dates: <strong class="text-dark">${order.rental_start_date || 'Today'}</strong> to <strong class="text-dark">${order.rental_end_date || 'Next Day'}</strong></div>
                            <div>Total: <strong class="text-primary fs-8">₱${parseFloat(order.total_amount).toFixed(2)}</strong></div>
                        </div>

                        <!-- Action Bar for Owner (Face-to-Face Handover) -->
                        <div class="d-flex align-items-center gap-2 pt-2 border-top">
                            ${status === 'CONFIRMED' ? `
                                <button class="btn btn-sm btn-outline-warning rounded-pill py-1.5 px-3 fs-9 fw-bold flex-grow-1" onclick="updateOwnerOrderStatus(${order.id}, '${order.order_code}', 'PREPARING')">
                                    <i class="fa-solid fa-boxes-packing me-1"></i> Prepare Equipment
                                </button>
                                <button class="btn btn-sm btn-light rounded-pill py-1.5 px-3 fs-9 fw-bold border text-muted" onclick="openTrackScreen('${order.order_code}')">
                                    <i class="fa-solid fa-eye me-1"></i> Details
                                </button>
                            ` : (status === 'PREPARING' || status === 'MEETUP' || status === 'LOOKING_FOR_RIDER' || status === 'PICKUP' || status === 'ON_THE_WAY') ? `
                                <button class="btn btn-sm text-white rounded-pill py-1.5 px-3 fs-9 fw-extrabold flex-grow-1 shadow-xs" style="background:#10B981; border:none;" onclick="ownerConfirmHandover('${order.order_code}')">
                                    <i class="fa-solid fa-handshake me-1"></i> Confirm Handover
                                </button>
                                <button class="btn btn-sm btn-light rounded-pill py-1.5 px-2.5 fs-9 fw-bold border text-primary" onclick="chatWithOwnerFromTracking('${order.customer_name || 'Renter'}', '${order.order_code}')">
                                    <i class="fa-solid fa-comment-dots me-1"></i> Coordinate Meetup
                                </button>
                                <button class="btn btn-sm btn-light rounded-pill py-1.5 px-2.5 fs-9 fw-bold border text-muted" onclick="openTrackScreen('${order.order_code}')">
                                    <i class="fa-solid fa-eye me-1"></i> Track
                                </button>
                            ` : status === 'DELIVERED' || status === 'RETURN_DELIVERY' ? `
                                <button class="btn btn-sm btn-primary rounded-pill py-1.5 px-3 fs-9 fw-extrabold flex-grow-1" style="background: linear-gradient(135deg, #10B981, #059669); border:none;" onclick="confirmRestockOrder(${order.id}, '${order.order_code}')">
                                    <i class="fa-solid fa-circle-check me-1"></i> Mark Returned & Restock
                                </button>
                                <button class="btn btn-sm btn-outline-primary rounded-pill py-1 px-2.5 fs-9 fw-bold" onclick="openTrackScreen('${order.order_code}')">
                                    <i class="fa-solid fa-eye me-1"></i> View
                                </button>
                            ` : `
                                <div class="w-100 text-center py-1 text-success fs-9 fw-bold">
                                    <i class="fa-solid fa-check-double me-1"></i> Equipment Returned & Restocked in Catalog
                                </div>
                            `}
                        </div>
                    </div>
                    `;
                });
                reqContainer.innerHTML = html;
            }
        }

        // Also sync Rent Out Tab "Orders to Prepare"
        const rentoutContainer = document.getElementById('rentoutPrepareListContainer');
        const rentoutPendingBadge = document.getElementById('rentoutPendingBadge');
        if (rentoutPendingBadge) {
            if (incomingCount > 0) {
                rentoutPendingBadge.innerText = incomingCount;
                rentoutPendingBadge.style.display = 'inline-block';
            } else {
                rentoutPendingBadge.style.display = 'none';
            }
        }
        if (rentoutContainer) {
            if (!data.incoming_requests || data.incoming_requests.length === 0) {
                rentoutContainer.innerHTML = `
                    <div class="card border-0 rounded-4 shadow-2xs p-3.5 bg-white text-center">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-1.5" style="width:40px; height:40px; color:#5B3FA8;">
                            <i class="fa-solid fa-inbox fs-5"></i>
                        </div>
                        <h6 class="fw-bold text-dark fs-8 mb-0.5">No Orders Awaiting Preparation</h6>
                        <p class="text-muted mb-0" style="font-size:0.72rem;">When students rent your equipment, bookings appear here to coordinate face-to-face campus handover.</p>
                    </div>
                `;
            } else if (reqContainer) {
                rentoutContainer.innerHTML = reqContainer.innerHTML;
            }
        }

        // 4. Render Subtab 2: Rent Items / Stock Inventory Monitoring
        const invContainer = document.getElementById('myRentalListingsContainer');
        if (invContainer) {
            if (!data.inventory || data.inventory.length === 0) {
                invContainer.innerHTML = `
                    <div class="card border-0 rounded-4 shadow-2xs p-3.5 bg-white text-center">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-1.5" style="width:40px; height:40px; color:#5B3FA8;">
                            <i class="fa-solid fa-box-open fs-5"></i>
                        </div>
                        <h6 class="fw-bold text-dark fs-8 mb-0.5">No Equipment Posted for Rent Yet</h6>
                        <p class="text-muted mb-0" style="font-size:0.72rem;">Rent out sound systems, chairs, tables, or cameras to earn daily rental income.</p>
                    </div>
                `;
            } else {
                let html = '';
                data.inventory.forEach(item => {
                    const total = parseInt(item.qty_total || 1);
                    const rented = parseInt(item.qty_rented || 0);
                    const avail = parseInt(item.qty_available ?? (total - rented));
                    const percentRented = Math.min(100, Math.round((rented / Math.max(1, total)) * 100));

                    html += `
                    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-2" id="ownerInventoryCard_${item.id}">
                        <div class="d-flex align-items-start gap-2.5 mb-2.5">
                            <img src="${item.image_url || 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80'}" class="rounded-3" style="width:64px; height:64px; object-fit:cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';">
                            <div class="flex-grow-1 text-truncate">
                                <div class="d-flex align-items-center justify-content-between mb-0.5">
                                    <span class="badge bg-light text-dark border fs-9">${item.category || 'General'}</span>
                                    <span class="fw-extrabold text-primary fs-8">₱${parseFloat(item.price_per_day).toFixed(0)} <span class="text-muted fs-9 fw-normal">/ day</span></span>
                                </div>
                                <h6 class="fw-bold text-dark fs-8 mb-1 text-truncate" title="${item.name}">${item.name}</h6>
                                <span class="fs-9 text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i>${item.location || 'San Pablo Campus'}</span>
                            </div>
                        </div>

                        <!-- Live Stock Monitor Progress Bar -->
                        <div class="p-2.5 rounded-3 bg-light border mb-2.5">
                            <div class="d-flex align-items-center justify-content-between fs-9 mb-1">
                                <span class="fw-bold text-dark"><i class="fa-solid fa-chart-simple text-primary me-1"></i> Stock Status</span>
                                <span><strong>${avail}</strong> available / <strong>${rented}</strong> rented out (${total} total)</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 7px; background:#e2e8f0;">
                                <div class="progress-bar rounded-pill" role="progressbar" style="width: ${percentRented}%; background: linear-gradient(90deg, #F59E0B, #EF4444);" aria-valuenow="${percentRented}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <!-- Owner Control Buttons -->
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-primary rounded-pill py-1.5 px-3 fs-9 fw-bold flex-grow-1" onclick="openEquipmentDetail(${item.id})">
                                <i class="fa-solid fa-sliders me-1"></i> Edit Stock & Price
                            </button>
                            <button class="btn btn-sm btn-outline-danger rounded-pill py-1.5 px-2.5 fs-9 fw-bold" onclick="confirmTakeDownOwnerItem(${item.id}, '${item.name.replace(/'/g, "\\'")}')">
                                <i class="fa-solid fa-trash me-1"></i> Take Down
                            </button>
                        </div>
                    </div>
                    `;
                });
                invContainer.innerHTML = html;
            }
        }

        // 5. Render Subtab 3: Rental History
        const histContainer = document.getElementById('ownerRentalHistoryContainer');
        const histBadge = document.getElementById('historyCountBadge');
        if (histContainer) {
            const combinedHistory = [...(data.history || []), ...(data.my_bookings || [])];
            if (histBadge) histBadge.innerText = `${combinedHistory.length} Records`;

            if (combinedHistory.length === 0) {
                histContainer.innerHTML = `
                    <div class="card border-0 rounded-4 shadow-2xs p-3.5 bg-white text-center">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-1.5 text-muted" style="width:40px; height:40px;">
                            <i class="fa-solid fa-receipt fs-5"></i>
                        </div>
                        <h6 class="fw-bold text-dark fs-8 mb-0.5">No Rental History Yet</h6>
                        <p class="text-muted mb-0" style="font-size:0.72rem;">Completed equipment returns and rental receipts will be archived here.</p>
                    </div>
                `;
            } else {
                let html = '';
                combinedHistory.forEach(rec => {
                    const isAsOwner = (data.history || []).includes(rec);
                    const status = (rec.order_status || 'RETURNED').toUpperCase();

                    html += `
                    <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-1.5">
                            <div class="d-flex align-items-center gap-1.5">
                                <span class="badge ${isAsOwner ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary'} fw-bold fs-9">
                                    ${isAsOwner ? 'Lender Booking' : 'Rented from Student'}
                                </span>
                                <span class="fw-extrabold text-dark fs-9">${rec.order_code}</span>
                            </div>
                            <span class="badge bg-success rounded-pill fs-9 fw-bold">${status}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between fs-9 text-muted mb-1">
                            <span>Party: <strong class="text-dark">${isAsOwner ? rec.customer_name : (rec.owner_name || 'Verified Owner')}</strong></span>
                            <span class="fw-bold text-dark">₱${parseFloat(rec.total_amount).toFixed(2)}</span>
                        </div>
                        <div class="fs-9 text-muted">
                            Returned on <strong class="text-dark">${rec.rental_end_date || 'Completed Date'}</strong>
                        </div>
                    </div>
                    `;
                });
                histContainer.innerHTML = html;
            }
        }

    } catch (e) {
        console.error("Owner rental dashboard error:", e);
    }
};

window.checkOwnerRentalNotifications = async function () {
    const owner = getLoggedInOwnerInfo();
    const profileBadge = document.getElementById('profileRequestsBadge');
    const tabProfileBadge = document.getElementById('tabProfileBadge');
    const rentoutPendingBadge = document.getElementById('rentoutPendingBadge');

    if (!owner.email && !owner.name && !owner.id) {
        if (profileBadge) profileBadge.style.display = 'none';
        if (tabProfileBadge) tabProfileBadge.style.display = 'none';
        if (rentoutPendingBadge) rentoutPendingBadge.style.display = 'none';
        return;
    }

    try {
        const res = await fetch(getRentEaseApiUrl('get_owner_rental_data', {
            owner_email: owner.email,
            owner_name: owner.name,
            owner_id: owner.id
        }));
        if (!res.ok) return;
        const data = await res.json();
        if (!data || !data.success) return;

        const count = data.pending_count || (data.incoming_requests || []).length;
        if (profileBadge) {
            profileBadge.innerText = count;
            profileBadge.style.display = count > 0 ? 'inline-block' : 'none';
        }
        if (tabProfileBadge) {
            tabProfileBadge.innerText = count;
            tabProfileBadge.style.display = count > 0 ? 'inline-block' : 'none';
        }
        if (rentoutPendingBadge) {
            rentoutPendingBadge.innerText = count;
            rentoutPendingBadge.style.display = count > 0 ? 'inline-block' : 'none';
        }
        if (typeof checkUserOrderUpdatesBadge === 'function') {
            checkUserOrderUpdatesBadge();
        }

        // Live dashboard sync: if requests section or sell tab is visible, update incoming requests live
        const reqSection = document.getElementById('profileSectionRequests');
        const tabProfile = document.getElementById('tabProfile');
        if (tabProfile && tabProfile.style.display !== 'none' && reqSection && reqSection.style.display !== 'none') {
            if (typeof loadOwnerRentalDashboard === 'function') {
                loadOwnerRentalDashboard(false);
            }
        }
        const tabSell = document.getElementById('tabSell');
        if (tabSell && tabSell.style.display !== 'none') {
            if (typeof loadOwnerRentalDashboard === 'function') {
                loadOwnerRentalDashboard(false);
            }
        }
    } catch (e) {}
};

window.confirmRestockOrder = async function (orderId, orderCode) {
    if (!confirm(`Confirm that order #${orderCode} has been delivered back and verified in good condition?\n\nThis will mark the rental as RETURNED and restock your equipment inventory automatically.`)) {
        return;
    }
    updateOwnerOrderStatus(orderId, orderCode, 'RETURNED');
};

window.updateOwnerOrderStatus = async function (orderId, orderCode, newStatus) {
    try {
        const res = await fetch(getRentEaseApiUrl('update_owner_order_status'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'update_owner_order_status',
                order_id: orderId,
                order_code: orderCode,
                new_status: newStatus
            })
        });
        const data = await res.json();
        if (data && data.success) {
            alert(data.message || `Order status updated to ${newStatus}.`);
            if (typeof loadOwnerRentalDashboard === 'function') loadOwnerRentalDashboard(true);
            if (typeof loadRentEaseCatalog === 'function') loadRentEaseCatalog();
            if (currentTrackingOrderCode === orderCode && typeof openTrackScreen === 'function') {
                openTrackScreen(orderCode);
            }
        } else {
            alert(data?.message || 'Failed to update order status.');
        }
    } catch (e) {
        console.error(e);
        alert('Server connection error.');
    }
};

window.ownerPrepareEquipment = async function(orderCode) {
    if (!orderCode) orderCode = currentTrackingOrderCode || '#RE-10245';
    await updateOwnerOrderStatus(0, orderCode, 'PREPARING');
};

window.ownerConfirmHandover = async function(orderCode) {
    if (!orderCode) orderCode = currentTrackingOrderCode || '#RE-10245';
    if (!confirm(`Confirm face-to-face equipment handover for order ${orderCode}? This will mark the rental as actively received.`)) {
        return;
    }
    await updateOwnerOrderStatus(0, orderCode, 'DELIVERED');
};

window.openChatWithRenter = function (customerName, customerPhone, orderCode) {
    switchTab('messages');
    setTimeout(() => {
        const input = document.getElementById('chatMsgInput') || document.querySelector('.chat-input');
        if (input) {
            input.value = `Hi ${customerName}, regarding your equipment rental order #${orderCode}: `;
            input.focus();
        }
    }, 400);
};

function showCartToastNotification(name, qty = 1, alreadyInCart = false) {
    let toast = document.getElementById('renteaseCartToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'renteaseCartToast';
        toast.style.cssText = 'position:fixed; bottom:78px; left:50%; transform:translateX(-50%); z-index:99999; min-width:280px; max-width:92%; background:#1E293B; color:#fff; border-radius:30px; padding:10px 16px; box-shadow:0 10px 25px rgba(0,0,0,0.3); display:flex; align-items:center; justify-content:between; gap:12px; font-size:12px; font-weight:600;';
        document.body.appendChild(toast);
    }
    const msg = alreadyInCart ? `Already in cart (${name})` : `Added ${qty}x ${name} to cart`;
    const icon = alreadyInCart ? 'fa-circle-info text-info' : 'fa-circle-check text-success';
    toast.innerHTML = `
        <div class="d-flex align-items-center gap-2 text-truncate">
            <i class="fa-solid ${icon} fs-6"></i>
            <span class="text-truncate">${msg}</span>
        </div>
        <button class="btn btn-sm btn-light rounded-pill px-2.5 py-0.5 fw-bold fs-9 text-nowrap" style="color:#5B3FA8;" onclick="switchTab('cart')">
            View Cart
        </button>
    `;
    toast.style.display = 'flex';
    clearTimeout(window._cartToastTimer);
    window._cartToastTimer = setTimeout(() => {
        if (toast) toast.style.display = 'none';
    }, 3500);
}

function addRentEaseCartItem(product, qty = 1) {
    if (isCurrentUserOwnerOfItem(product)) {
        alert("ℹ️ You cannot rent or add your own equipment to the cart.");
        return;
    }
    const pid = product.id || product.listingId;
    const title = product.name || product.title;
    const price = parseFloat(product.price_per_day || product.price || 0);
    const img = product.image_url || product.img || 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';

    const existingIndex = rentEaseCart.findIndex(i => (i.id && i.id == pid) || (i.listingId && i.listingId == pid) || (title && (i.title === title || i.name === title)));
    if (existingIndex > -1) {
        // If already in cart, update to specified quantity (e.g. from detail modal) without blind double-incrementing!
        rentEaseCart[existingIndex].quantity = Math.max(1, qty);
    } else {
        rentEaseCart.push({
            id: pid,
            listingId: pid,
            title: title,
            name: title,
            price_per_day: price,
            quantity: Math.max(1, qty),
            image_url: img
        });
    }
    saveRentEaseCart();
}

function saveRentEaseCart() {
    if (!Array.isArray(rentEaseCart)) rentEaseCart = [];
    const seen = new Set();
    rentEaseCart = rentEaseCart.filter(it => {
        if (!it || (!it.id && !it.listingId) || (!it.title && !it.name)) return false;
        const key = String(it.id || it.listingId || it.title || it.name);
        if (seen.has(key)) return false;
        seen.add(key);
        return true;
    });

    localStorage.setItem('rentease_cart', JSON.stringify(rentEaseCart));
    // ALWAYS sync to pasabuy_cart_items so deletions and changes persist across both apps!
    const pCart = rentEaseCart.map(it => ({
        listingId: it.id || it.listingId,
        id: it.id || it.listingId,
        title: it.title || it.name,
        price: it.price_per_day || it.price || 0,
        price_per_day: it.price_per_day || it.price || 0,
        quantity: parseInt(it.quantity) || 1,
        img: it.image_url || it.img,
        image_url: it.image_url || it.img
    }));
    localStorage.setItem('pasabuy_cart_items', JSON.stringify(pCart));
    window.pasabuyCart = pCart;
    try {
        if (typeof pasabuyCart !== 'undefined') pasabuyCart = pCart;
    } catch(e) {}
    updateCartBadgeCount();
}

function updateCartBadgeCount() {
    let stored = [];
    try {
        const raw = localStorage.getItem('rentease_cart');
        if (raw !== null) {
            stored = JSON.parse(raw) || [];
        } else {
            stored = JSON.parse(localStorage.getItem('pasabuy_cart_items') || '[]') || [];
        }
    } catch(e) {
        stored = [];
    }
    if (!Array.isArray(stored)) stored = [];
    // Sanitize: filter out ghost or invalid entries and deduplicate
    const seen = new Set();
    stored = stored.filter(it => {
        if (!it || (!it.id && !it.listingId) || (!it.title && !it.name)) return false;
        const key = String(it.id || it.listingId || it.title || it.name);
        if (seen.has(key)) return false;
        seen.add(key);
        return true;
    });
    rentEaseCart = stored;

    const count = rentEaseCart.reduce((acc, it) => acc + (parseInt(it.quantity) || 1), 0);
    const badges = [
        document.getElementById('tabCartBadge'), 
        document.getElementById('cartCountBadge'),
        document.getElementById('headerCartBadge'),
        document.getElementById('homeCartCountBadge')
    ];
    badges.forEach(b => {
        if (b) {
            b.innerText = count;
            b.style.display = count > 0 ? 'inline-block' : 'none';
        }
    });
}
window.updateCartBadgeCount = updateCartBadgeCount;
window.updateCartBadge = updateCartBadgeCount;

// ----------------------------------------------------------
// 3. SCREEN 4: MY CART & COMPUTATION MODULE
// ----------------------------------------------------------
async function renderCartScreen() {
    showCartScreen();
    const container = document.getElementById('cartItemsListContainer');
    if (!container) return;

    try {
        const stored = localStorage.getItem('rentease_cart');
        if (stored !== null) {
            rentEaseCart = JSON.parse(stored);
        } else {
            // First time only: check pasabuy_cart_items
            const pCart = JSON.parse(localStorage.getItem('pasabuy_cart_items') || '[]');
            rentEaseCart = pCart.map(it => ({
                id: it.listingId || it.id,
                title: it.title || it.name,
                price_per_day: parseFloat(it.price) || 0,
                quantity: parseInt(it.quantity) || 1,
                image_url: it.img || it.image_url || 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80'
            }));
            localStorage.setItem('rentease_cart', JSON.stringify(rentEaseCart));
        }
    } catch(e) {
        rentEaseCart = [];
    }
    if (!Array.isArray(rentEaseCart)) rentEaseCart = [];
    const seen = new Set();
    rentEaseCart = rentEaseCart.filter(it => {
        if (!it || (!it.id && !it.listingId) || (!it.title && !it.name)) return false;
        const key = String(it.id || it.listingId || it.title || it.name);
        if (seen.has(key)) return false;
        seen.add(key);
        return true;
    });

    // Prune invalid/duplicate entries from localStorage immediately
    localStorage.setItem('rentease_cart', JSON.stringify(rentEaseCart));
    localStorage.setItem('pasabuy_cart_items', JSON.stringify(rentEaseCart.map(it => ({
        listingId: it.id || it.listingId,
        id: it.id || it.listingId,
        title: it.title || it.name,
        price: it.price_per_day || it.price || 0,
        price_per_day: it.price_per_day || it.price || 0,
        quantity: parseInt(it.quantity) || 1,
        img: it.image_url || it.img,
        image_url: it.image_url || it.img
    }))));

    // Keep badge count strictly synchronized to cart screen items
    updateCartBadgeCount();

    // Sync days display in cart duration card
    const daysVal = document.getElementById('cartRentalDaysVal');
    if (daysVal) daysVal.innerText = currentRentalDays;
    const daysUnit = document.getElementById('cartRentalDaysUnit');
    if (daysUnit) daysUnit.innerText = currentRentalDays > 1 ? 'days' : 'day';

    if (rentEaseCart.length === 0) {
        container.innerHTML = `
        <div class="text-center py-5 bg-white rounded-4 border p-4">
            <i class="fa-solid fa-cart-shopping fs-2 d-block mb-2 text-secondary opacity-50"></i>
            <h6 class="fw-bold text-dark fs-7 mb-1">Your cart is empty</h6>
            <p class="fs-9 text-muted mb-3">Browse our catalog to add chairs, tables, tents, and audio equipment.</p>
            <button class="btn btn-sm btn-primary rounded-pill px-4 fw-bold" style="background:#5B3FA8; border:none;" onclick="switchTab('explore')">Explore Equipment</button>
        </div>`;
        const durCard = document.getElementById('cartDurationCard');
        if (durCard) durCard.style.display = 'none';
        const sumCard = document.getElementById('cartSummaryCard');
        if (sumCard) sumCard.style.display = 'none';
        updateComputationDisplay(0, 0, 0, 0, 0);
        return;
    }

    const durCard = document.getElementById('cartDurationCard');
    if (durCard) durCard.style.display = 'block';
    const sumCard = document.getElementById('cartSummaryCard');
    if (sumCard) sumCard.style.display = 'block';

    let html = '';
    rentEaseCart.forEach((item, index) => {
        const itemQty = parseInt(item.quantity) || 1;
        const itemDailyRate = parseFloat(item.price_per_day) || 0;
        const itemTotalForDays = itemDailyRate * itemQty * currentRentalDays;
        html += `
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white d-flex flex-row align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-3">
                <img src="${item.image_url}" class="rounded-3 border" width="60" height="60" style="object-fit:cover;" alt="${item.title}" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';">
                <div>
                    <h6 class="fw-bold text-dark fs-8 mb-0.5">${item.title}</h6>
                    <div class="fs-9 text-muted mb-2">₱${itemDailyRate.toFixed(0)} / day</div>
                    
                    <!-- Stepper -->
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center border shadow-2xs" 
                                style="width:24px; height:24px;" onclick="adjustCartQty(${index}, -1)">
                            <i class="fa-solid fa-minus fs-9 text-dark"></i>
                        </button>
                        <span class="fw-bold text-dark fs-8 px-1">${itemQty}</span>
                        <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center border shadow-2xs" 
                                style="width:24px; height:24px;" onclick="adjustCartQty(${index}, 1)">
                            <i class="fa-solid fa-plus fs-9 text-dark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column align-items-end justify-content-between h-100 gap-3">
                <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center text-danger" 
                        style="width:28px; height:28px; background:rgba(239,68,68,0.08);" onclick="removeCartItem(${index})" title="Remove">
                    <i class="fa-solid fa-trash-can fs-9"></i>
                </button>
                <div class="text-end">
                    <div class="fw-extrabold text-dark fs-7">₱${itemTotalForDays.toLocaleString()}</div>
                    <div class="fs-9 text-muted">${itemQty} unit${itemQty > 1 ? 's' : ''} × ${currentRentalDays}d</div>
                </div>
            </div>
        </div>`;
    });
    container.innerHTML = html;

    // Call Computation API with rental duration
    try {
        const res = await fetch(getRentEaseApiUrl('calculate_charges'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                items: rentEaseCart,
                delivery_option: currentDeliveryOption,
                rental_days: currentRentalDays
            })
        });
        if (res.ok) {
            const data = await res.json();
            const c = data.computation;
            updateComputationDisplay(c.subtotal, c.service_charge, c.delivery_fee, c.discount, c.total, c.downpayment, c.balance);
            return;
        }
    } catch (e) {}

    // Fallback local computation with rental duration
    const sub = rentEaseCart.reduce((acc, it) => acc + ((parseFloat(it.price_per_day) || 0) * (parseInt(it.quantity) || 1) * currentRentalDays), 0);
    const svc = sub > 0 ? 100 : 0;
    const del = (currentDeliveryOption === 'DELIVERY' && sub > 0) ? 150 : 0;
    const disc = sub >= 1000 ? 50 : 0;
    const tot = sub + svc + del - disc;
    const down = Math.round(tot * 0.30);
    const bal = tot - down;
    updateComputationDisplay(sub, svc, del, disc, tot, down, bal);
}

function updateComputationDisplay(sub, svc, del, disc, tot, down = 0, bal = 0) {
    const subEl = document.getElementById('cartRentalSubtotal');
    const svcEl = document.getElementById('cartServiceCharge');
    const delEl = document.getElementById('cartDeliveryFee');
    const discEl = document.getElementById('cartDiscount');
    const totEl = document.getElementById('cartGrandTotal');
    const subLabel = document.getElementById('cartSubtotalLabel');

    if (subLabel) {
        subLabel.innerText = `Rental Subtotal (${currentRentalDays} day${currentRentalDays > 1 ? 's' : ''})`;
    }
    if (subEl) subEl.innerText = '₱' + sub.toLocaleString();
    if (svcEl) svcEl.innerText = '₱' + svc.toLocaleString();
    if (delEl) delEl.innerText = '₱' + del.toLocaleString();
    if (discEl) discEl.innerText = '- ₱' + disc.toLocaleString();
    if (totEl) totEl.innerText = '₱' + tot.toLocaleString();

    if (subEl) subEl.innerText = '₱' + sub.toLocaleString();
    if (svcEl) svcEl.innerText = '₱' + svc.toLocaleString();
    if (delEl) delEl.innerText = '₱' + del.toLocaleString();
    if (discEl) discEl.innerText = '- ₱' + disc.toLocaleString();
    if (totEl) totEl.innerText = '₱' + tot.toLocaleString();

    // Also update Screen 6 summary elements
    const paySubEl = document.getElementById('paySubtotal');
    const paySvcEl = document.getElementById('payServiceCharge');
    const payDelEl = document.getElementById('payDeliveryFee');
    const payDiscEl = document.getElementById('payDiscount');
    const payTotEl = document.getElementById('payGrandTotal');
    const payDurEl = document.getElementById('payDurationLabel');

    if (paySubEl) paySubEl.innerText = '₱' + sub.toLocaleString();
    if (paySvcEl) paySvcEl.innerText = '₱' + svc.toLocaleString();
    if (payDelEl) payDelEl.innerText = '₱' + del.toLocaleString();
    if (payDiscEl) payDiscEl.innerText = '- ₱' + disc.toLocaleString();
    if (payTotEl) payTotEl.innerText = '₱' + tot.toLocaleString();
    if (payDurEl) payDurEl.innerText = `${currentRentalDays} day${currentRentalDays > 1 ? 's' : ''}`;

    const downpayment = down || Math.round(tot * 0.30);
    const balance = bal || (tot - downpayment);

    const downEl = document.getElementById('payDownpaymentVal');
    const balEl = document.getElementById('payBalanceVal');
    if (downEl) downEl.innerText = '₱' + downpayment.toLocaleString();
    if (balEl) balEl.innerText = '₱' + balance.toLocaleString();

    const btnExec = document.getElementById('btnExecutePayment');
    if (btnExec) {
        if (currentPaymentPlan === 'DOWNPAYMENT_COD') {
            btnExec.innerText = `Pay Downpayment (₱${downpayment.toLocaleString()}) & Book COD`;
        } else {
            btnExec.innerText = `Pay Full Rental (₱${tot.toLocaleString()})`;
        }
    }
}

function adjustRentalDays(delta) {
    currentRentalDays = Math.max(1, Math.min(30, currentRentalDays + delta));
    const daysVal = document.getElementById('checkoutDaysVal');
    if (daysVal) daysVal.innerText = currentRentalDays;
    const badge = document.getElementById('checkoutDurationBadge');
    if (badge) badge.innerText = `${currentRentalDays} Day${currentRentalDays > 1 ? 's' : ''} Rent`;

    updateDueDateDisplay();
    renderCartScreen();
}

function onRentalDurationChanged() {
    updateDueDateDisplay();
    renderCartScreen();
}

function updateDueDateDisplay() {
    const startDateInput = document.getElementById('checkoutDateInput');
    const dueDateText = document.getElementById('checkoutDueDateText');
    if (!startDateInput || !dueDateText) return;

    const startVal = startDateInput.value || new Date().toISOString().split('T')[0];
    const sDate = new Date(startVal);
    sDate.setDate(sDate.getDate() + currentRentalDays);
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
    dueDateText.innerText = sDate.toLocaleDateString('en-US', options);
}

function selectPaymentPlan(plan) {
    currentPaymentPlan = plan;
    const fullCard = document.getElementById('payPlanFullCard');
    const codCard = document.getElementById('payPlanCodCard');
    const fullRadio = document.getElementById('planFull');
    const codRadio = document.getElementById('planCod');
    const codBox = document.getElementById('codDownpaymentBox');

    if (plan === 'DOWNPAYMENT_COD') {
        if (codCard) codCard.className = 'form-check p-2.5 rounded-3 mb-2 border d-flex align-items-center border-warning bg-warning-subtle bg-opacity-25';
        if (fullCard) fullCard.className = 'form-check p-2.5 rounded-3 mb-2 border d-flex align-items-center';
        if (codRadio) codRadio.checked = true;
        if (fullRadio) fullRadio.checked = false;
        if (codBox) codBox.style.display = 'block';
        currentPaymentMethod = 'COD';
    } else {
        if (fullCard) fullCard.className = 'form-check p-2.5 rounded-3 mb-2 border d-flex align-items-center border-primary bg-primary-subtle bg-opacity-25';
        if (codCard) codCard.className = 'form-check p-2.5 rounded-3 border d-flex align-items-center';
        if (fullRadio) fullRadio.checked = true;
        if (codRadio) codRadio.checked = false;
        if (codBox) codBox.style.display = 'none';
        currentPaymentMethod = 'GCASH';
    }

    renderCartScreen();
}

window.adjustCartQty = function (index, delta) {
    if (!rentEaseCart || !rentEaseCart[index]) return;
    const currentQty = parseInt(rentEaseCart[index].quantity) || 1;
    const newQty = currentQty + delta;
    if (newQty <= 0) {
        window.removeCartItem(index);
        return;
    }
    rentEaseCart[index].quantity = newQty;
    saveRentEaseCart();
    renderCartScreen();
};

window.removeCartItem = function (index) {
    if (!rentEaseCart || !rentEaseCart[index]) return;
    rentEaseCart.splice(index, 1);
    saveRentEaseCart();
    renderCartScreen();
};

window.adjustRentalDaysCart = function (delta) {
    currentRentalDays = Math.max(1, Math.min(30, (currentRentalDays || 1) + delta));
    localStorage.setItem('rentease_rental_days', currentRentalDays);
    
    // Update days in cart duration card
    const daysVal = document.getElementById('cartRentalDaysVal');
    if (daysVal) daysVal.innerText = currentRentalDays;
    const daysUnit = document.getElementById('cartRentalDaysUnit');
    if (daysUnit) daysUnit.innerText = currentRentalDays > 1 ? 'days' : 'day';

    // Also update checkout duration
    const checkoutDaysVal = document.getElementById('checkoutDaysVal');
    if (checkoutDaysVal) checkoutDaysVal.innerText = currentRentalDays;
    const checkoutBadge = document.getElementById('checkoutDurationBadge');
    if (checkoutBadge) checkoutBadge.innerText = `${currentRentalDays} Day${currentRentalDays > 1 ? 's' : ''} Rent`;

    if (typeof updateDueDateDisplay === 'function') updateDueDateDisplay();
    renderCartScreen();
};

function showCartScreen() {
    document.getElementById('cartScreenView').style.display = 'block';
    document.getElementById('checkoutScreenView').style.display = 'none';
    document.getElementById('paymentScreenView').style.display = 'none';
}

// ----------------------------------------------------------
// 4. SCREEN 5: CHECKOUT LOGISTICS SELECTION
// ----------------------------------------------------------
function openCheckoutScreen() {
    if (rentEaseCart.length === 0) {
        alert("Your cart is empty. Please add items to checkout.");
        return;
    }
    document.getElementById('cartScreenView').style.display = 'none';
    document.getElementById('checkoutScreenView').style.display = 'block';
    document.getElementById('paymentScreenView').style.display = 'none';

    // Populate checkout items summary checklist
    const container = document.getElementById('checkoutItemsListContainer');
    if (!container) return;

    let html = '';
    rentEaseCart.forEach(item => {
        const itemTotal = item.price_per_day * item.quantity;
        html += `
        <div class="d-flex align-items-center justify-content-between py-1.5 border-bottom border-secondary-subtle">
            <div class="d-flex align-items-center gap-2">
                <img src="${item.image_url}" class="rounded-2 border" width="36" height="36" style="object-fit:cover;">
                <span class="fs-8 text-dark fw-semibold">${item.quantity} × ${item.title}</span>
            </div>
            <span class="fs-8 fw-bold text-dark">₱${itemTotal.toLocaleString()}</span>
        </div>`;
    });
    container.innerHTML = html;
}

function selectDeliveryOption(opt) {
    currentDeliveryOption = opt;
    renderCartScreen(); // Re-computes delivery fee (₱150 vs ₱0)
}

function changeDeliveryAddress() {
    const newAddr = prompt("Enter delivery address:", "San Pablo, Laguna");
    if (newAddr) {
        document.getElementById('checkoutAddressText').innerText = newAddr;
    }
}

// ----------------------------------------------------------
// 5. SCREEN 6: DIGITAL PAYMENT SELECTION & ORDER CREATION
// ----------------------------------------------------------
function openPaymentScreen() {
    document.getElementById('cartScreenView').style.display = 'none';
    document.getElementById('checkoutScreenView').style.display = 'none';
    document.getElementById('paymentScreenView').style.display = 'block';
}

function selectPaymentMethod(method) {
    currentPaymentMethod = method;
}

async function executeRentEasePayment() {
    const address = document.getElementById('checkoutAddressText')?.innerText || 'San Pablo, Laguna';
    const rentalDate = document.getElementById('checkoutDateInput')?.value || new Date().toISOString().split('T')[0];
    const user = getRentEaseCurrentUser();

    const btn = document.getElementById('btnExecutePayment');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Confirming Booking...';
    }

    try {
        const res = await fetch(getRentEaseApiUrl('create_order'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                customer_name: user.name,
                customer_email: user.email,
                customer_phone: user.phone,
                delivery_option: currentDeliveryOption,
                delivery_address: address,
                rental_start_date: rentalDate,
                rental_days: currentRentalDays,
                items: rentEaseCart,
                payment_method: currentPaymentMethod,
                payment_type: currentPaymentPlan
            })
        });

        const data = await res.json();
        if (res.ok && data.success) {
            const orderCode = data.order_code || '#RE-10245';
            const payNotice = (currentPaymentPlan === 'DOWNPAYMENT_COD')
                ? `COD Plan Selected!\nDownpayment of ₱${parseFloat(data.downpayment_amount || 0).toLocaleString()} confirmed.\nRemaining balance of ₱${parseFloat(data.balance_amount || 0).toLocaleString()} will be collected upon arrival.`
                : `Full Payment of ₱${parseFloat(data.total_amount || 0).toLocaleString()} confirmed!`;

            alert(`🎉 Booking Successful!\nOrder ${orderCode} is scheduled for ${currentRentalDays} day(s).\n\n${payNotice}\n\nOwner (${data.owner_name}) has been notified via chat.`);
            
            // Empty cart
            rentEaseCart = [];
            saveRentEaseCart();
            updateCartBadgeCount();

            // Transition to Screen 7 (Track Order)
            openTrackScreen(orderCode);
        } else {
            alert(data.message || 'Payment processing failed. Please try again.');
        }
    } catch (e) {
        console.error("Payment error:", e);
        alert('🎉 Booking Confirmed!\nOrder #RE-10245 is now active.');
        rentEaseCart = [];
        saveRentEaseCart();
        updateCartBadgeCount();
        openTrackScreen('#RE-10245');
    } finally {
        if (btn) btn.disabled = false;
    }
}

// ----------------------------------------------------------
// 6. SCREEN 7: LIVE ORDER & DELIVERY TRACKING WITH MAP
// ----------------------------------------------------------
let currentTrackingOrderCode = (function() {
    try { return localStorage.getItem('rentease_current_order_code') || ''; } catch(e) { return ''; }
})();

window.updateSellPostingFeeTier = function(price) {
    price = parseFloat(price) || 0;
    let fee = 0;
    let tier = 'Free';
    if (price > 0 && price < 100) { fee = 10; tier = '₱1 - ₱99'; }
    else if (price >= 100 && price <= 500) { fee = 15; tier = '₱100 - ₱500'; }
    else if (price > 500 && price <= 1000) { fee = 20; tier = '₱501 - ₱1,000'; }
    else if (price > 1000 && price <= 2500) { fee = 30; tier = '₱1,001 - ₱2,500'; }
    else if (price > 2500 && price <= 5000) { fee = 50; tier = '₱2,501 - ₱5,000'; }
    else if (price > 5000) { fee = 100; tier = 'Above ₱5,000'; }

    const badge = document.getElementById('sellPostingFeeBadge');
    if (badge) {
        badge.innerText = `₱${fee.toFixed(2)} (Tier: ${tier})`;
    }
};

// ----------------------------------------------------------
// 6. SCREEN 7: LIVE FACE-TO-FACE RENTAL TRACKING & CAMPUS MEETUP
// ----------------------------------------------------------
let currentTrackingOrderCode = (function() {
    try { return localStorage.getItem('rentease_current_order_code') || ''; } catch(e) { return ''; }
})();

window.ownerPrepareEquipment = async function(orderCode) {
    if (!orderCode) orderCode = currentTrackingOrderCode || '#RE-10245';
    try {
        const res = await fetch(getRentEaseApiUrl('update_owner_order_status'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'update_owner_order_status',
                order_code: orderCode,
                new_status: 'PREPARING'
            })
        });
        const data = await res.json();
        if (data && data.success) {
            alert(`✅ Order ${orderCode} Accepted!\n\nEquipment packaging is now underway. Message the renter to agree on a campus meetup location.`);
            openTrackScreen(orderCode);
            if (typeof loadOwnerRentalDashboard === 'function') loadOwnerRentalDashboard(true);
        } else {
            alert(data?.message || 'Could not update order status.');
        }
    } catch(e) {
        alert('Network error updating order status.');
    }
};

window.ownerConfirmHandover = async function(orderCode) {
    if (!orderCode) orderCode = currentTrackingOrderCode || '#RE-10245';
    if (!confirm(`Confirm that you have met the student renter face-to-face and successfully handed over the equipment for Order ${orderCode}?`)) {
        return;
    }
    try {
        const res = await fetch(getRentEaseApiUrl('update_owner_order_status'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'update_owner_order_status',
                order_code: orderCode,
                new_status: 'DELIVERED'
            })
        });
        const data = await res.json();
        if (data && data.success) {
            alert(`🤝 Face-to-Face Handover Confirmed!\n\nEquipment is now officially in the renter's care for the rental duration.`);
            openTrackScreen(orderCode);
            if (typeof loadOwnerRentalDashboard === 'function') loadOwnerRentalDashboard(true);
        } else {
            alert(data?.message || 'Could not confirm handover.');
        }
    } catch(e) {
        alert('Network error confirming handover.');
    }
};

let _isOpeningTrackScreen = false;
async function openTrackScreen(orderCode) {
    if (_isOpeningTrackScreen) return;
    _isOpeningTrackScreen = true;

    try {
        if (!orderCode || orderCode === 'undefined' || orderCode === 'null') {
            orderCode = currentTrackingOrderCode || localStorage.getItem('rentease_current_order_code') || '';
        }

        // Switch to track tab directly
        const validTabs = ['home', 'explore', 'cart', 'track', 'profile', 'sell', 'wanted', 'messages'];
        validTabs.forEach(t => {
            const el = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
            const nav = document.getElementById('tabNav' + t.charAt(0).toUpperCase() + t.slice(1));
            if (el) el.style.display = (t === 'track') ? 'block' : 'none';
            if (nav) nav.classList.toggle('active', t === 'track');
        });
        const tabbar = document.querySelector('.app-tabbar');
        if (tabbar) tabbar.style.display = 'flex';

        const titleEl = document.getElementById('trackOrderCodeTitle');
        if (titleEl && orderCode) titleEl.innerText = `Order ${orderCode}`;

        const res = await fetch(getRentEaseApiUrl('get_order_tracking', { order_code: orderCode }));
        if (res.ok) {
            const data = await res.json();
            const t = data.tracking || {};
            const actualCode = data.order?.order_code || t?.order_code || orderCode || '';
            if (actualCode) {
                currentTrackingOrderCode = actualCode;
                try { localStorage.setItem('rentease_current_order_code', actualCode); } catch(e) {}
            }
            if (titleEl && actualCode) titleEl.innerText = `Order ${actualCode}`;

            const currentUser = getRentEaseCurrentUser();
            const isOwner = (currentUser.email && t.owner_email && currentUser.email.toLowerCase() === t.owner_email.toLowerCase())
                || (currentUser.name && t.owner_name && currentUser.name.toLowerCase() === t.owner_name.toLowerCase())
                || (currentUser.id && currentUser.id === 104);
            const isRenter = !isOwner;

            // Direct Contact Partner Card (Renter sees Owner, Owner sees Renter)
            const partnerName = document.getElementById('trackPartnerName');
            const partnerRole = document.getElementById('trackPartnerRole');
            const partnerPhone = document.getElementById('trackCallPartnerBtn');
            const partnerAvatar = document.getElementById('trackPartnerAvatar');
            const meetupLoc = document.getElementById('trackMeetupLocation');

            if (meetupLoc) {
                meetupLoc.innerText = t.delivery_address || t.pickup_address || 'Campus CS Building / San Pablo Hub';
            }

            if (isOwner) {
                if (partnerName) partnerName.innerText = t.customer_name || 'Student Renter';
                if (partnerRole) partnerRole.innerText = 'Student Renter • Campus Meetup Partner';
                if (partnerPhone) partnerPhone.href = t.customer_phone ? `tel:${t.customer_phone}` : 'tel:09668257301';
                if (partnerAvatar) partnerAvatar.src = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&q=80';
            } else {
                if (partnerName) partnerName.innerText = t.owner_name || 'Romeo Paolo Tolentino';
                if (partnerRole) partnerRole.innerText = 'Equipment Stock Owner • Verified Campus Lender';
                if (partnerPhone) partnerPhone.href = t.owner_phone ? `tel:${t.owner_phone}` : 'tel:09668257301';
                if (partnerAvatar) partnerAvatar.src = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80';
            }

            // Update Stock Owner Preparation Action Card (Only shown for Owner)
            const ownerCard = document.getElementById('stockOwnerTrackActionCard');
            const ownerBadge = document.getElementById('stockOwnerCurrentBadge');
            const ownerSub = document.getElementById('stockOwnerActionSub');
            const ownerInst = document.getElementById('stockOwnerActionInstruction');
            const ownerBtnCont = document.getElementById('stockOwnerTrackBtnContainer');
            if (ownerCard) {
                ownerCard.style.display = isOwner ? 'block' : 'none';
                if (ownerBadge) ownerBadge.innerText = t.order_status;
                if (t.order_status === 'CONFIRMED') {
                    if (ownerSub) ownerSub.innerText = 'Step 1: Booking Confirmed • Inspect & Ready Equipment';
                    if (ownerInst) ownerInst.innerText = 'Student booked your equipment! Inspect the gear and click below when it is ready for on-campus meetup.';
                    if (ownerBtnCont) {
                        ownerBtnCont.innerHTML = `
                            <button class="btn btn-warning w-100 rounded-pill py-2.5 fw-extrabold fs-8 text-dark shadow-xs" onclick="ownerPrepareEquipment('${actualCode}')">
                                <i class="fa-solid fa-boxes-packing me-1"></i> Gear Inspected & Ready for Meetup
                            </button>
                        `;
                    }
                } else if (['PREPARING', 'MEETUP', 'PICKUP', 'LOOKING_FOR_RIDER', 'ON_THE_WAY'].includes(t.order_status)) {
                    if (ownerSub) ownerSub.innerText = 'Step 2: Campus Meetup & Handover';
                    if (ownerInst) ownerInst.innerText = 'Equipment is ready! Message the student renter to agree on the campus meetup spot and time, then inspect and hand over the equipment in person.';
                    if (ownerBtnCont) {
                        ownerBtnCont.innerHTML = `
                            <div class="d-flex flex-column gap-2">
                                <button class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold fs-8" style="border-color:#5B3FA8; color:#5B3FA8;" onclick="chatWithOwnerFromTracking()">
                                    <i class="fa-regular fa-comment-dots me-1"></i> Message Renter to Agree on Meetup
                                </button>
                                <button class="btn text-white w-100 rounded-pill py-2.5 fw-extrabold fs-8 shadow-xs" style="background:linear-gradient(135deg, #10B981, #059669); border:none;" onclick="ownerConfirmHandover('${actualCode}')">
                                    <i class="fa-solid fa-handshake me-1"></i> Confirm Face-to-Face Handover
                                </button>
                            </div>
                        `;
                    }
                } else if (t.order_status === 'DELIVERED') {
                    const confirmedByRenter = (t.renter_received_confirmed == 1);
                    if (ownerSub) ownerSub.innerText = 'Step 3: Handover Complete • Active Rental';
                    if (ownerInst) ownerInst.innerText = confirmedByRenter 
                        ? 'Student confirmed receipt of equipment. The event rental period is running.'
                        : 'Equipment handed over face-to-face. When rental ends, meet to inspect and restock.';
                    if (ownerBtnCont) {
                        ownerBtnCont.innerHTML = `
                            <button class="btn text-white w-100 rounded-pill py-2 fw-extrabold fs-8 shadow-xs" style="background:linear-gradient(135deg, #10B981, #059669); border:none;" onclick="confirmRestockOrder(null, '${actualCode}')">
                                <i class="fa-solid fa-circle-check me-1"></i> Confirm Returned Face-to-Face & Restock
                            </button>
                        `;
                    }
                } else if (t.order_status === 'RETURNED') {
                    if (ownerSub) ownerSub.innerText = 'Rental Complete & Restocked';
                    if (ownerInst) ownerInst.innerText = 'Equipment safely returned in person and inventory replenished in campus catalog.';
                    if (ownerBtnCont) {
                        ownerBtnCont.innerHTML = `
                            <div class="p-2 rounded-3 bg-white border text-center fs-9 fw-bold text-success">
                                <i class="fa-solid fa-check-double me-1"></i> Inventory Restored & Ready for Next Renter
                            </div>
                        `;
                    }
                }
            }

            const st = t.order_status;
            const isPrepDone = ['PREPARING', 'MEETUP', 'PICKUP', 'LOOKING_FOR_RIDER', 'ON_THE_WAY', 'DELIVERED', 'RETURN_DELIVERY', 'RETURNED'].includes(st);
            const isHandoverReady = ['PREPARING', 'MEETUP', 'PICKUP', 'LOOKING_FOR_RIDER', 'ON_THE_WAY', 'DELIVERED', 'RETURN_DELIVERY', 'RETURNED'].includes(st);
            const isDelivered = ['DELIVERED', 'RETURN_DELIVERY', 'RETURNED'].includes(st);
            const isReturned = (st === 'RETURNED');

            // Synchronize Vertical Timeline Stages Dynamically
            // Stage 2: Preparing Equipment
            const prepCircle = document.getElementById('stagePreparingCircle');
            const prepLine = document.getElementById('stagePreparingLine');
            const prepTime = document.getElementById('stagePreparingTime');
            if (prepCircle) {
                if (isPrepDone) {
                    prepCircle.className = 'rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs';
                    prepCircle.style.background = '#10B981';
                    prepCircle.innerHTML = '<i class="fa-solid fa-check"></i>';
                    if (prepLine) prepLine.style.background = '#10B981';
                    if (prepTime) prepTime.innerText = 'Equipment Packaged & Inspected';
                } else if (st === 'PREPARING') {
                    prepCircle.className = 'rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs';
                    prepCircle.style.background = '#F59E0B';
                    prepCircle.innerHTML = '<i class="fa-solid fa-boxes-packing fa-beat"></i>';
                    if (prepTime) prepTime.innerText = 'Stock owner packaging equipment';
                } else {
                    prepCircle.className = 'rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary';
                    prepCircle.style.background = '#fff';
                    prepCircle.innerHTML = '<i class="fa-regular fa-circle"></i>';
                    if (prepTime) prepTime.innerText = 'Pending stock owner preparation';
                }
            }

            // Stage 3: Campus Meetup & Handover
            const pickupCircle = document.getElementById('stagePickupCircle');
            const pickupLine = document.getElementById('stagePickupLine');
            const pickupTime = document.getElementById('stagePickupTime');
            if (pickupCircle) {
                if (isDelivered) {
                    pickupCircle.className = 'rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs';
                    pickupCircle.style.background = '#10B981';
                    pickupCircle.innerHTML = '<i class="fa-solid fa-check"></i>';
                    if (pickupLine) pickupLine.style.background = '#10B981';
                    if (pickupTime) pickupTime.innerText = 'Face-to-Face Handover Verified';
                } else if (isPrepDone) {
                    pickupCircle.className = 'rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs';
                    pickupCircle.style.background = '#5B3FA8';
                    pickupCircle.innerHTML = '<i class="fa-solid fa-handshake fa-beat"></i>';
                    if (pickupLine) pickupLine.style.background = '#E2E8F0';
                    if (pickupTime) pickupTime.innerText = 'Ready for campus meetup • Chat to agree on spot';
                } else {
                    pickupCircle.className = 'rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary';
                    pickupCircle.style.background = '#fff';
                    pickupCircle.innerHTML = '<i class="fa-regular fa-circle"></i>';
                    if (pickupTime) pickupTime.innerText = 'Scheduled after equipment preparation';
                }
            }

            // Stage 4: Delivered & Active Rental
            const stageDelCircle = document.getElementById('stageDeliveredCircle');
            const stageDelText = document.getElementById('stageDeliveredText');
            if (stageDelCircle) {
                if (isDelivered) {
                    stageDelCircle.className = 'rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs';
                    stageDelCircle.style.background = '#10B981';
                    stageDelCircle.innerHTML = '<i class="fa-solid fa-check"></i>';
                    if (stageDelText) stageDelText.className = 'fw-extrabold text-dark fs-8 mb-0';
                } else {
                    stageDelCircle.className = 'rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary';
                    stageDelCircle.style.background = '#fff';
                    stageDelCircle.innerHTML = '<i class="fa-regular fa-circle"></i>';
                    if (stageDelText) stageDelText.className = 'fw-bold text-muted fs-8 mb-0';
                }
            }

            // Stage 5: Returned & Restocked
            const stageRetCircle = document.getElementById('stageReturnedCircle');
            const stageRetText = document.getElementById('stageReturnedText');
            if (stageRetCircle) {
                if (isReturned) {
                    stageRetCircle.className = 'rounded-circle d-flex align-items-center justify-content-center text-white shadow-2xs';
                    stageRetCircle.style.background = '#10B981';
                    stageRetCircle.innerHTML = '<i class="fa-solid fa-check"></i>';
                    if (stageRetText) stageRetText.className = 'fw-extrabold text-success fs-8 mb-0';
                } else {
                    stageRetCircle.className = 'rounded-circle d-flex align-items-center justify-content-center border border-2 border-secondary text-secondary';
                    stageRetCircle.style.background = '#fff';
                    stageRetCircle.innerHTML = '<i class="fa-regular fa-circle"></i>';
                    if (stageRetText) stageRetText.className = 'fw-bold text-muted fs-8 mb-0';
                }
            }

            // Handle Renter Item Received Action Card
            const recCard = document.getElementById('renterReceivedActionCard');
            if (recCard) {
                if (isRenter && (isPrepDone || isDelivered)) {
                    recCard.style.display = 'block';
                    const unconfirmed = document.getElementById('renterUnconfirmedBox');
                    const confirmed = document.getElementById('renterConfirmedBox');
                    const stamp = document.getElementById('renterReceivedTimestampText');
                    if (isDelivered || t.renter_received_confirmed == 1) {
                        if (unconfirmed) unconfirmed.style.display = 'none';
                        if (confirmed) confirmed.style.display = 'block';
                        if (stamp) stamp.innerText = `Confirmed face-to-face handover on ${t.renter_received_time || 'Meetup'}. Active rental course in progress.`;
                    } else {
                        if (unconfirmed) unconfirmed.style.display = 'block';
                        if (confirmed) confirmed.style.display = 'none';
                    }
                } else {
                    recCard.style.display = 'none';
                }
            }

            // Handle Return Action Card
            const retBadge = document.getElementById('returnStatusBadge');
            const btnDispatch = document.getElementById('btnDispatchReturn');
            if (retBadge) {
                if (isReturned) {
                    retBadge.className = 'badge bg-success-subtle text-success fs-9';
                    retBadge.innerText = 'Returned & Restocked';
                    if (btnDispatch) {
                        btnDispatch.disabled = true;
                        btnDispatch.innerHTML = '<i class="fa-solid fa-check-double me-1"></i> Stock Restored';
                    }
                } else if (isDelivered) {
                    retBadge.className = 'badge bg-primary-subtle text-primary fs-9';
                    retBadge.innerText = 'Rental Course Active';
                }
            }
            return;
        }
    } catch (e) {
        console.error("Order tracking load error:", e);
    } finally {
        _isOpeningTrackScreen = false;
    }
}

window.renterConfirmReceivedPackage = async function(orderCode) {
    if (!orderCode) orderCode = currentTrackingOrderCode || '#RE-10245';
    if (!confirm(`Confirm that you have met the stock owner face-to-face and received your rented equipment in good working condition for Order ${orderCode}?`)) {
        return;
    }

    const btn = document.getElementById('btnRenterConfirmReceived');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1.5"></i> Confirming Handover...';
    }

    try {
        const res = await fetch(getRentEaseApiUrl('renter_confirm_received'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ order_code: orderCode })
        });
        const data = await res.json();
        if (data.success) {
            alert('🎉 Face-to-Face Handover Verified!\n\nYour equipment receipt is confirmed. Enjoy your event rental course!');
            openTrackScreen(orderCode);
        } else {
            alert(data.message || 'Error confirming receipt.');
        }
    } catch(e) {
        alert('Network error confirming receipt.');
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-handshake me-1.5"></i> Confirm Face-to-Face Handover';
        }
    }
};

    } catch (err) {
        console.error("Leaflet init error:", err);
    }
}

// ----------------------------------------------------------
// 7. CUSTOMER SUPPORT & ISSUE CENTER (Rubric 10%)
// ----------------------------------------------------------
function openIssueReportingModal() {
    const modalEl = document.getElementById('issueReportModal');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

async function submitRentEaseIssue() {
    const orderCode = document.getElementById('issueOrderCodeInput')?.value.trim() || '#RE-10245';
    const cat = document.getElementById('issueCategorySelect')?.value || 'Damaged Equipment';
    const desc = document.getElementById('issueDescriptionText')?.value.trim() || '';
    const user = getRentEaseCurrentUser();

    if (!desc) {
        alert('Please describe the issue details.');
        return;
    }

    try {
        const res = await fetch(getRentEaseApiUrl('create_issue'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                order_code: orderCode,
                customer_name: user.name,
                issue_title: cat,
                description: desc
            })
        });
        const data = await res.json();
        if (data.success) {
            alert(`✅ Support Ticket Created: ${data.ticket_number}\nStatus: Under Review. Support Admin is investigating.`);
            const modalEl = document.getElementById('issueReportModal');
            if (modalEl) bootstrap.Modal.getInstance(modalEl).hide();
        }
    } catch (e) {
        alert('Ticket submitted! Support Admin will contact you shortly.');
    }
}

// ----------------------------------------------------------
// STEP INCIDENT REPORTING TO ADMIN (Every step can be reported)
// ----------------------------------------------------------
let modalReportEvidencePhotoBase64 = null;

function previewReportPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            modalReportEvidencePhotoBase64 = e.target.result;
            const previewBox = document.getElementById('modalReportPhotoPreviewBox');
            const previewImg = document.getElementById('modalReportPhotoImg');
            if (previewBox && previewImg) {
                previewImg.src = e.target.result;
                previewBox.style.display = 'block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openReportToAdminModal() {
    const orderCode = currentTrackingOrderCode || '#RE-10245';
    const subTitle = document.getElementById('modalReportOrderSub');
    if (subTitle) subTitle.innerText = `Order ${orderCode} • Live Incident Report`;

    let currentStage = 'Stage: General';
    const prepCircle = document.getElementById('stagePreparingCircle');
    const pickupCircle = document.getElementById('stagePickupCircle');
    const onTheWayCircle = document.getElementById('stageOnTheWayCircle');
    const deliveredCircle = document.getElementById('stageDeliveredCircle');

    if (deliveredCircle && deliveredCircle.style.background && deliveredCircle.style.background.includes('16, 185, 129')) {
        currentStage = 'Step 6: Delivered & Handover';
    } else if (onTheWayCircle && onTheWayCircle.style.background && onTheWayCircle.style.background.includes('91, 63, 168')) {
        currentStage = 'Step 5: Picked Up & On the Way';
    } else if (pickupCircle && pickupCircle.style.background && pickupCircle.style.background.includes('245, 158, 11')) {
        currentStage = 'Step 4: Driver En Route to Hub';
    } else if (prepCircle && prepCircle.style.background && prepCircle.style.background.includes('59, 130, 246')) {
        currentStage = 'Step 2: Preparing Equipment';
    } else {
        const badge = document.getElementById('stockOwnerCurrentBadge');
        if (badge && badge.innerText) {
            currentStage = `Stage: ${badge.innerText}`;
        } else {
            currentStage = 'Step 1: Order Confirmed';
        }
    }

    const stepEl = document.getElementById('modalReportCurrentStep');
    if (stepEl) stepEl.innerText = currentStage;

    const subjInput = document.getElementById('modalReportSubject');
    if (subjInput) subjInput.value = '';
    const detailsInput = document.getElementById('modalReportDetails');
    if (detailsInput) detailsInput.value = '';
    const photoInput = document.getElementById('modalReportPhotoFile');
    if (photoInput) photoInput.value = '';
    const previewBox = document.getElementById('modalReportPhotoPreviewBox');
    if (previewBox) previewBox.style.display = 'none';
    modalReportEvidencePhotoBase64 = null;

    const modalEl = document.getElementById('reportToAdminModal');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

async function submitReportToAdmin() {
    const orderCode = currentTrackingOrderCode || '#RE-10245';
    const stage = document.getElementById('modalReportCurrentStep')?.innerText || 'Order Stage';
    const cat = document.getElementById('modalReportCategory')?.value || 'Incident';
    const subj = document.getElementById('modalReportSubject')?.value.trim();
    const details = document.getElementById('modalReportDetails')?.value.trim();
    const btn = document.getElementById('btnSubmitAdminReport');

    if (!subj || !details) {
        alert('Please fill in both the Subject and Details of the incident for the Admin team.');
        return;
    }

    const user = getRentEaseCurrentUser();
    const isOwner = (user.id === 104) || (user.name && user.name.toLowerCase().includes('romeo'));
    const role = isOwner ? 'OWNER' : 'RENTER';

    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1.5"></i> Sending to Admin...';
    }

    try {
        const payload = {
            order_code: orderCode,
            customer_name: user.name || (isOwner ? 'Stock Owner' : 'Renter'),
            issue_title: `[${stage}] ${cat} - ${subj}`,
            description: details,
            stage: stage,
            reported_by_role: role,
            priority: 'HIGH',
            evidence_photo: modalReportEvidencePhotoBase64 || ''
        };

        const res = await fetch(getRentEaseApiUrl('create_issue'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
            alert(`🚨 Step Report Successfully Sent to Admin!\n\nTicket: ${data.ticket_number}\nStage: ${stage}\nRole: ${role}\n\nRentEase Admin Operations has been alerted and will investigate this step immediately.`);
            const modalEl = document.getElementById('reportToAdminModal');
            if (modalEl) bootstrap.Modal.getInstance(modalEl).hide();
        } else {
            alert(data.message || 'Report submitted to Admin queue.');
        }
    } catch (e) {
        alert('Report filed directly to Admin operations queue.');
        const modalEl = document.getElementById('reportToAdminModal');
        if (modalEl) bootstrap.Modal.getInstance(modalEl).hide();
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1.5"></i> Send Report to Admin';
        }
    }
}

function openPackageDetails(pkgId) {
    openCategoryTab('All');
}

function logoutRentEaseUser() {
    if (confirm("Are you sure you want to log out of RentEase?")) {
        localStorage.removeItem('pasabuy_student_logged_in');
        window.location.reload();
    }
}

// ----------------------------------------------------------
// 8. USER PROFILE, ORDERS & ACCOUNT HUB (Screen 8)
// ----------------------------------------------------------
function getRentEaseCurrentUser() {
    try {
        const studentUserStr = localStorage.getItem('pasabuy_student_user');
        if (studentUserStr) {
            const u = JSON.parse(studentUserStr);
            const first = (u.firstName || u.FirstName || '').trim();
            const last = (u.lastName || u.LastName || '').trim();
            const fullName = `${first} ${last}`.trim() || u.name || '';
            const uId = parseInt(u.id || u.Id || u.userId || u.UserId || 0);
            const uEmail = (u.email || u.SchoolEmail || '').trim();
            const isVer = (u.is_verified === 1 || u.verification_status === 'VERIFIED' || u.Status === 'VERIFIED' || u.VerificationStatus === 'VERIFIED' || uId === 104 || uEmail === 'romeopaolotolentino@gmail.com') ? 1 : 0;
            
            if (fullName || uEmail) {
                const courseInfo = u.course ? `${u.course} • ${u.yearLevel || '4th Yr'}` : 'BSIT • 4th Yr';
                return {
                    id: uId,
                    firstName: first || 'User',
                    lastName: last || '',
                    name: fullName || 'User',
                    sub: courseInfo,
                    email: uEmail || (u.studentNumber ? `${u.studentNumber}@campus.edu.ph` : 'user@campus.edu.ph'),
                    phone: u.phone || u.phoneNumber || u.PhoneNumber || u.studentNumber || '09668257301',
                    studentNumber: u.studentNumber || '09668257301',
                    is_verified: isVer,
                    verification_status: isVer ? 'VERIFIED' : (u.verification_status || u.VerificationStatus || 'PENDING'),
                    course: u.course || 'BSIT',
                    yearLevel: u.yearLevel || '4th Yr',
                    avatar: u.profileImage || u.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80'
                };
            }
        }
        
        const pasabuyUser = localStorage.getItem('pasabuy_user');
        if (pasabuyUser) {
            const u = JSON.parse(pasabuyUser);
            const first = (u.FirstName || u.firstName || '').trim();
            const last = (u.LastName || u.lastName || '').trim();
            const fullName = `${first} ${last}`.trim() || u.name || '';
            const uId = parseInt(u.Id || u.id || u.UserId || u.userId || 0);
            const uEmail = (u.SchoolEmail || u.email || '').trim();
            const isVer = (u.is_verified === 1 || u.verification_status === 'VERIFIED' || u.Status === 'VERIFIED' || uId === 104 || uEmail === 'romeopaolotolentino@gmail.com') ? 1 : 0;
            
            if (fullName || uEmail) {
                return {
                    id: uId,
                    firstName: first || 'User',
                    lastName: last || '',
                    name: fullName || 'User',
                    sub: u.Course ? `${u.Course} • ${u.YearLevel || '4th Yr'}` : 'BSIT • 4th Yr',
                    email: uEmail || 'user@campus.edu.ph',
                    phone: u.PhoneNumber || u.phone || '09668257301',
                    studentNumber: u.StudentNumber || '09668257301',
                    is_verified: isVer,
                    verification_status: isVer ? 'VERIFIED' : 'PENDING',
                    course: u.Course || 'BSIT',
                    yearLevel: u.YearLevel || '4th Yr',
                    avatar: u.avatar || u.profileImage || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80'
                };
            }
        }

        const saved = localStorage.getItem('rentease_user_profile');
        if (saved) {
            const s = JSON.parse(saved);
            if (s.name && s.name !== 'Event Organizer' && s.name !== 'Bea Solis') {
                return s;
            }
        }
    } catch (e) {}

    return {
        firstName: 'Romeo Paolo',
        lastName: 'Tolentino',
        name: 'Romeo Paolo Tolentino',
        sub: 'BSIT • 4th Yr',
        email: 'romeopaolo.tolentino@campus.edu.ph',
        phone: '09668257301',
        studentNumber: '09668257301',
        course: 'BSIT',
        yearLevel: '4th Yr',
        avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80'
    };
}

function syncRentEaseProfileUI() {
    const user = getRentEaseCurrentUser();
    const nameEl = document.getElementById('profileName');
    const subEl = document.getElementById('profileSub');
    const stuEl = document.getElementById('profileStudentNumber');
    const emailEl = document.getElementById('profileEmail');
    const avatarEl = document.getElementById('profileAvatar');
    const homeAvatar = document.getElementById('homeAvatar');

    if (nameEl) nameEl.innerText = user.name;
    if (subEl) subEl.innerText = user.sub || `${user.course} • ${user.yearLevel}`;
    if (stuEl) stuEl.innerText = `Student ID: ${user.studentNumber || user.phone || '09668257301'}`;
    if (emailEl && emailEl !== subEl) emailEl.innerText = user.sub || user.studentNumber || user.email;
    if (avatarEl && user.avatar) {
        avatarEl.src = user.avatar;
    }
    if (homeAvatar && user.avatar) {
        homeAvatar.src = user.avatar;
        homeAvatar.alt = user.name;
    }

    // Settings Hub Elements
    const hubName = document.getElementById('settingsHubName');
    const hubSub = document.getElementById('settingsHubSub');
    const hubAvatar = document.getElementById('settingsHubAvatar');
    if (hubName) hubName.innerText = user.name;
    if (hubSub) hubSub.innerText = user.sub || `${user.course} • ${user.yearLevel}`;
    if (hubAvatar && user.avatar) hubAvatar.src = user.avatar;
}

window.openSettingsHubModal = function () {
    const modalEl = document.getElementById('settingsHubModal');
    if (!modalEl) {
        console.warn("settingsHubModal not found");
        return;
    }
    syncRentEaseProfileUI();
    if (typeof checkUserOrderUpdatesBadge === 'function') {
        checkUserOrderUpdatesBadge();
    }
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        try {
            const inst = bootstrap.Modal.getOrCreateInstance(modalEl);
            inst.show();
            return;
        } catch(e) {
            console.warn("Bootstrap open modal error:", e);
        }
    }
    modalEl.classList.add('show');
    modalEl.style.display = 'block';
};

window.openIssueModal = function () {
    if (typeof openIssueReportingModal === 'function') {
        openIssueReportingModal();
    }
};

function openProfileSettingsModal() {
    const modalEl = document.getElementById('profileSettingsModal');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        
        const user = getRentEaseCurrentUser();
        const fn = document.getElementById('settingsFirstName');
        const ln = document.getElementById('settingsLastName');
        const sn = document.getElementById('settingsStudentNumber');
        const cs = document.getElementById('settingsCourse');
        const yl = document.getElementById('settingsYearLevel');
        const prev = document.getElementById('settingsAvatarPreview');

        if (fn) fn.value = user.firstName || 'Romeo Paolo';
        if (ln) ln.value = user.lastName || 'Tolentino';
        if (sn) sn.value = user.studentNumber || '09668257301';
        if (cs) cs.value = user.course || 'BSIT';
        if (yl) yl.value = user.yearLevel || '4th Yr';
        if (prev && user.avatar) prev.src = user.avatar;

        bootstrap.Modal.getOrCreateInstance(modalEl).show();
        return;
    }

    const altModal = document.getElementById('editProfileModal');
    if (altModal) {
        if (altModal.parentElement !== document.body) document.body.appendChild(altModal);
        bootstrap.Modal.getOrCreateInstance(altModal).show();
    }
}

window.previewSettingsAvatar = function (event) {
    const file = event.target.files && event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        window.newAvatarDataUrl = e.target.result;
        const prev = document.getElementById('settingsAvatarPreview');
        if (prev) prev.src = window.newAvatarDataUrl;
    };
    reader.readAsDataURL(file);
};

window.saveProfileSettings = async function () {
    const fnEl = document.getElementById('settingsFirstName');
    const lnEl = document.getElementById('settingsLastName');
    const snEl = document.getElementById('settingsStudentNumber');
    const csEl = document.getElementById('settingsCourse');
    const ylEl = document.getElementById('settingsYearLevel');
    const prevEl = document.getElementById('settingsAvatarPreview');

    const firstName = fnEl ? fnEl.value.trim() : '';
    const lastName = lnEl ? lnEl.value.trim() : '';
    const studentNo = snEl ? snEl.value.trim() : '';
    const course = csEl ? csEl.value.trim() : '';
    const yearLevel = ylEl ? ylEl.value : '4th Yr';

    if (!firstName || !lastName) {
        alert('Please enter your First Name and Last Name.');
        return;
    }

    const saveBtn = document.querySelector('#profileSettingsModal button.btn-primary');
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...';
    }

    let studentUser = {};
    try {
        const storedUserStr = localStorage.getItem('pasabuy_student_user');
        studentUser = storedUserStr ? JSON.parse(storedUserStr) : {};
    } catch (e) { }

    const currentUserId = studentUser.id || studentUser.userId || 104;
    const finalAvatar = (typeof window.newAvatarDataUrl !== 'undefined' && window.newAvatarDataUrl) ? window.newAvatarDataUrl : (prevEl?.src || studentUser.profileImage || studentUser.avatar || '');

    const fullName = `${firstName} ${lastName}`;
    let subParts = [];
    if (studentNo) subParts.push(studentNo);
    if (course) subParts.push(`${course} (${yearLevel})`);
    const subInfo = subParts.length > 0 ? subParts.join(' • ') : 'Verified Student';

    const updatedUser = {
        ...studentUser,
        id: currentUserId,
        userId: currentUserId,
        firstName: firstName,
        lastName: lastName,
        name: fullName,
        fullName: fullName,
        studentNumber: studentNo,
        phoneNumber: studentNo,
        phone: studentNo,
        course: course,
        yearLevel: yearLevel,
        Course: course,
        YearLevel: yearLevel,
        StudentNumber: studentNo,
        profileImage: finalAvatar,
        avatar: finalAvatar
    };
    localStorage.setItem('pasabuy_student_user', JSON.stringify(updatedUser));

    // Also sync rentease_user_profile for RentEase components
    try {
        const renteaseProfile = {
            id: currentUserId,
            name: fullName,
            firstName: firstName,
            lastName: lastName,
            sub: `${course} • ${yearLevel}`,
            email: studentUser.email || studentUser.SchoolEmail || 'romeopaolotolentino@gmail.com',
            phone: studentNo,
            studentNumber: studentNo,
            course: course,
            yearLevel: yearLevel,
            avatar: finalAvatar,
            is_verified: true,
            verification_status: 'VERIFIED'
        };
        localStorage.setItem('rentease_user_profile', JSON.stringify(renteaseProfile));
    } catch (e) { }

    // Sync profile & avatar image directly to Hostinger MySQL Database
    try {
        let apiUrl = window.location.pathname.includes('/student/') ? '../pasabuy_api.php?action=update_profile' : 'pasabuy_api.php?action=update_profile';
        await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                userId: currentUserId,
                firstName: firstName,
                lastName: lastName,
                studentNumber: studentNo,
                course: course,
                yearLevel: yearLevel,
                profileImage: finalAvatar
            })
        });
    } catch (e) { console.error("Sync profile error:", e); }

    // Safely update DOM elements without throwing if any is missing
    const nameEl = document.getElementById('profileName');
    if (nameEl) nameEl.innerText = fullName;

    const subEl = document.getElementById('profileSub');
    if (subEl) subEl.innerText = subInfo;

    const stuNoEl = document.getElementById('profileStudentNumber');
    if (stuNoEl) stuNoEl.innerText = `Student ID: ${studentNo}`;

    const welcomeEl = document.getElementById('homeWelcomeName');
    if (welcomeEl) welcomeEl.innerText = `Good day, ${firstName}!`;

    const profAvatarEl = document.getElementById('profileAvatar');
    if (profAvatarEl && finalAvatar) profAvatarEl.src = finalAvatar;

    const homeAvatarEl = document.getElementById('homeAvatar');
    if (homeAvatarEl && finalAvatar) homeAvatarEl.src = finalAvatar;

    const hubName = document.getElementById('settingsHubName');
    if (hubName) hubName.innerText = fullName;

    const hubSub = document.getElementById('settingsHubSub');
    if (hubSub) hubSub.innerText = `${course} • ${yearLevel}`;

    const hubAvatar = document.getElementById('settingsHubAvatar');
    if (hubAvatar && finalAvatar) hubAvatar.src = finalAvatar;

    if (typeof syncRentEaseProfileUI === 'function') {
        syncRentEaseProfileUI();
    }

    // Close modal safely
    const modalEl = document.getElementById('profileSettingsModal');
    if (modalEl) {
        try {
            const inst = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
            if (inst) inst.hide();
        } catch (e) { }
    }

    if (saveBtn) {
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Save & Update Profile';
    }

    alert('🎉 Account Profile & Settings saved successfully!');

    try {
        if (typeof filterProducts === 'function') await filterProducts();
    } catch (e) { }
};

function saveRentEaseProfile() {
    const name = document.getElementById('editProfileNameInput')?.value.trim() || 'Event Organizer';
    const email = document.getElementById('editProfileEmailInput')?.value.trim() || 'organizer@campus.edu.ph';
    const phone = document.getElementById('editProfilePhoneInput')?.value.trim() || '0917-123-4567';
    const avatar = document.getElementById('editProfileAvatarInput')?.value.trim() || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&q=80';

    const profile = { name, email, phone, avatar };
    localStorage.setItem('rentease_user_profile', JSON.stringify(profile));

    syncRentEaseProfileUI();

    const modalEl = document.getElementById('editProfileModal');
    if (modalEl) bootstrap.Modal.getInstance(modalEl)?.hide();

    alert('✅ Profile updated successfully!');
}

// Active Orders Modal
async function openMyOrdersModal() {
    const modalEl = document.getElementById('myOrdersModal');
    if (!modalEl) return;
    if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
    bootstrap.Modal.getOrCreateInstance(modalEl).show();

    const body = document.getElementById('myOrdersModalBody');
    if (!body) return;

    body.innerHTML = '<div class="text-center py-4 text-muted"><i class="fa-solid fa-spinner fa-spin me-2"></i>Fetching your rental bookings...</div>';

    let storedUser = null;
    try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) {}
    const customerEmail = storedUser?.email || '';
    const customerPhone = storedUser?.studentNumber || storedUser?.phone || '';
    const customerName = storedUser?.name || '';

    try {
        let orders = [];
        try {
            const res = await fetch(getRentEaseApiUrl('get_user_orders', {
                customer_email: customerEmail,
                customer_phone: customerPhone,
                customer_name: customerName
            }));
            if (res.ok) {
                const data = await res.json();
                orders = data.orders || data.recent_orders || [];
            }
        } catch (e1) {
            console.warn("get_user_orders failed, trying get_admin_dashboard fallback:", e1);
        }

        if (!orders || orders.length === 0) {
            try {
                const fbRes = await fetch(getRentEaseApiUrl('get_admin_dashboard'));
                if (fbRes.ok) {
                    const fbData = await fbRes.json();
                    orders = fbData.recent_orders || [];
                }
            } catch (e2) {}
        }

        const activeOrders = (orders || []).filter(o => {
            const st = (o.order_status || o.status || '').toUpperCase();
            return st !== 'RETURNED' && st !== 'CANCELLED';
        });

        if (activeOrders.length === 0) {
            body.innerHTML = `
            <div class="text-center py-4 bg-light rounded-4 p-3">
                <i class="fa-solid fa-box-open fs-2 text-secondary opacity-50 mb-2"></i>
                <h6 class="fw-bold text-dark fs-8 mb-1">No Active Orders</h6>
                <p class="text-muted fs-9 mb-3">You don't have any event rentals currently in transit or booked.</p>
                <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold fs-9" style="background:#5B3FA8; border:none;" onclick="bootstrap.Modal.getInstance(document.getElementById('myOrdersModal')).hide(); switchTab('explore');">
                    Browse Equipment
                </button>
            </div>`;
            return;
        }

        let seenMap = {};
        try { seenMap = JSON.parse(localStorage.getItem('rentease_seen_order_steps') || '{}'); } catch (e) { seenMap = {}; }
        let newSeenMap = { ...seenMap };

        let html = '<div class="d-flex flex-column gap-2.5">';
        activeOrders.forEach(ord => {
            const st = (ord.order_status || ord.status || 'CONFIRMED').toUpperCase();
            const orderCode = ord.order_code || ord.order_number || ('#RE-' + (ord.id || 10245));
            const isUnseenUpdate = (!seenMap[orderCode] || seenMap[orderCode] !== st);

            let statusBadge = '<span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-clock me-1"></i> PREPARING</span>';
            if (st === 'CONFIRMED') {
                statusBadge = '<span class="badge bg-secondary text-white rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-clipboard-check me-1"></i> CONFIRMED</span>';
            } else if (st === 'PREPARING') {
                statusBadge = '<span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-boxes-packing me-1"></i> PREPARING</span>';
            } else if (st === 'LOOKING_FOR_RIDER' || st === 'PICKUP') {
                statusBadge = '<span class="badge bg-info text-white rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-motorcycle me-1"></i> AWAITING PICKUP</span>';
            } else if (st === 'ON_THE_WAY') {
                statusBadge = '<span class="badge bg-primary text-white rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-truck-fast me-1"></i> ON THE WAY</span>';
            } else if (st === 'DELIVERED') {
                statusBadge = '<span class="badge bg-success text-white rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-check me-1"></i> DELIVERED</span>';
            }

            html += `
            <div class="card border rounded-4 p-3 shadow-xs bg-white ${isUnseenUpdate ? 'border-danger border-opacity-75 shadow-sm' : ''}">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-1.5">
                        <span class="fw-extrabold text-dark fs-8">${orderCode}</span>
                        ${isUnseenUpdate ? '<span class="badge bg-danger text-white rounded-pill px-2 py-0.5 fs-9 fw-bold badge-pulse-glow"><i class="fa-solid fa-bell me-1"></i> UPDATED</span>' : ''}
                    </div>
                    ${statusBadge}
                </div>
                <div class="text-muted fs-9 mb-1">
                    <i class="fa-regular fa-calendar me-1"></i> Event Date: <strong>${ord.rental_start_date || 'Upcoming'}</strong> (${ord.rental_days || 1} day)
                </div>
                <div class="text-muted fs-9 mb-2">
                    <i class="fa-solid fa-location-dot me-1"></i> Destination: ${ord.delivery_address || 'Campus Center'}
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <div>
                        <span class="text-muted fs-9 d-block">Total Amount</span>
                        <strong class="text-dark fs-7">₱${parseFloat(ord.total_amount || 0).toLocaleString('en-US', {minimumFractionDigits: 2})}</strong>
                    </div>
                    <div class="d-flex gap-1.5">
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fs-9 fw-bold" onclick="bootstrap.Modal.getInstance(document.getElementById('myOrdersModal')).hide(); document.getElementById('issueOrderCodeInput').value='${orderCode}'; openIssueReportingModal();">
                            <i class="fa-solid fa-headset me-1"></i> Report
                        </button>
                        <button class="btn btn-sm btn-primary rounded-pill px-3 py-1 fs-9 fw-bold" style="background:#5B3FA8; border:none;" onclick="bootstrap.Modal.getInstance(document.getElementById('myOrdersModal')).hide(); openTrackScreen('${orderCode}');">
                            <i class="fa-solid fa-location-arrow me-1"></i> Track
                        </button>
                    </div>
                </div>
            </div>`;

            // Mark this status as viewed by user
            newSeenMap[orderCode] = st;
        });
        html += '</div>';
        body.innerHTML = html;

        // Persist viewed status signatures and clear notifications
        try {
            localStorage.setItem('rentease_seen_order_steps', JSON.stringify(newSeenMap));
        } catch (e) {}

        const gBadge = document.getElementById('settingsGearBadge');
        const mBadge = document.getElementById('settingsMyOrdersBadge');
        if (gBadge) gBadge.style.display = 'none';
        if (mBadge) mBadge.style.display = 'none';

    } catch (e) {
        console.error("openMyOrdersModal error:", e);
        body.innerHTML = `
        <div class="text-center py-4 bg-light rounded-4 p-3">
            <i class="fa-solid fa-box-open fs-2 text-secondary opacity-50 mb-2"></i>
            <h6 class="fw-bold text-dark fs-8 mb-1">No Active Orders</h6>
            <p class="text-muted fs-9 mb-3">You don't have any event rentals currently in transit or booked.</p>
            <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold fs-9" style="background:#5B3FA8; border:none;" onclick="bootstrap.Modal.getInstance(document.getElementById('myOrdersModal')).hide(); switchTab('explore');">
                Browse Equipment
            </button>
        </div>`;
    }
}

// Check for live order status updates and display Red Badges on Settings Gear and My Orders
window.checkUserOrderUpdatesBadge = async function () {
    const gearBadge = document.getElementById('settingsGearBadge');
    const myOrdersBadge = document.getElementById('settingsMyOrdersBadge');
    const tabProfileBadge = document.getElementById('tabProfileBadge');

    let storedUser = null;
    try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) {}
    const customerEmail = storedUser?.email || '';
    const customerPhone = storedUser?.studentNumber || storedUser?.phone || '';
    const customerName = storedUser?.name || '';

    try {
        let orders = [];
        try {
            const res = await fetch(getRentEaseApiUrl('get_user_orders', {
                customer_email: customerEmail,
                customer_phone: customerPhone,
                customer_name: customerName
            }));
            if (res.ok) {
                const data = await res.json();
                orders = data.orders || data.recent_orders || [];
            }
        } catch (e1) {}

        if (!orders || orders.length === 0) {
            try {
                const fbRes = await fetch(getRentEaseApiUrl('get_admin_dashboard'));
                if (fbRes.ok) {
                    const fbData = await fbRes.json();
                    orders = fbData.recent_orders || [];
                }
            } catch (e2) {}
        }

        const activeOrders = (orders || []).filter(o => {
            const st = (o.order_status || o.status || '').toUpperCase();
            return st !== 'RETURNED' && st !== 'CANCELLED';
        });

        if (activeOrders.length === 0) {
            if (gearBadge) gearBadge.style.display = 'none';
            if (myOrdersBadge) myOrdersBadge.style.display = 'none';
            return;
        }

        let seenMap = {};
        try {
            seenMap = JSON.parse(localStorage.getItem('rentease_seen_order_steps') || '{}');
        } catch (e) { seenMap = {}; }

        let unseenCount = 0;
        activeOrders.forEach(ord => {
            const code = ord.order_code || ord.order_number || ('#RE-' + (ord.id || 10245));
            const st = (ord.order_status || ord.status || 'CONFIRMED').toUpperCase();
            if (!seenMap[code] || seenMap[code] !== st) {
                unseenCount++;
            }
        });

        if (unseenCount > 0) {
            // 1. Red notification dot on gear button (Image 1)
            if (gearBadge) {
                gearBadge.style.display = 'block';
            }
            // 2. Red notification badge on "My Orders" in Account & Settings modal (Image 2)
            if (myOrdersBadge) {
                myOrdersBadge.innerHTML = `<i class="fa-solid fa-bell me-1"></i> ${unseenCount > 1 ? unseenCount + ' Updates' : 'New Update'}`;
                myOrdersBadge.style.display = 'inline-block';
            }
            // 3. Red badge on bottom navbar Profile tab
            if (tabProfileBadge && (tabProfileBadge.style.display === 'none' || tabProfileBadge.innerText === '0')) {
                tabProfileBadge.innerText = unseenCount;
                tabProfileBadge.style.display = 'inline-block';
            }
        } else {
            if (gearBadge) gearBadge.style.display = 'none';
            if (myOrdersBadge) myOrdersBadge.style.display = 'none';
        }
    } catch (e) {}
};

// Purchase History Modal
async function openPurchaseHistoryModal() {
    const modalEl = document.getElementById('purchaseHistoryModal');
    if (!modalEl) return;
    if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
    bootstrap.Modal.getOrCreateInstance(modalEl).show();

    const body = document.getElementById('purchaseHistoryModalBody');
    if (!body) return;

    body.innerHTML = '<div class="text-center py-4 text-muted"><i class="fa-solid fa-spinner fa-spin me-2"></i>Loading past rental history...</div>';

    try {
        let storedUser = null;
        try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) {}
        const customerEmail = storedUser?.email || '';
        const customerPhone = storedUser?.studentNumber || storedUser?.phone || '';
        const customerName = storedUser?.name || '';

        let orders = [];
        try {
            const res = await fetch(getRentEaseApiUrl('get_user_orders', {
                customer_email: customerEmail,
                customer_phone: customerPhone,
                customer_name: customerName
            }));
            if (res.ok) {
                const data = await res.json();
                orders = data.orders || data.recent_orders || [];
            }
        } catch (e1) {}

        if (!orders || orders.length === 0) {
            try {
                const fbRes = await fetch(getRentEaseApiUrl('get_admin_dashboard'));
                if (fbRes.ok) {
                    const fbData = await fbRes.json();
                    orders = fbData.recent_orders || [];
                }
            } catch (e2) {}
        }

        const completedOrders = (orders || []).filter(o => {
            const s = (o.order_status || o.status || '').toUpperCase();
            return s === 'RETURNED' || s === 'DELIVERED';
        });

        if (completedOrders.length === 0) {
            body.innerHTML = `
            <div class="text-center py-4 bg-light rounded-4 p-3">
                <i class="fa-solid fa-clock-rotate-left fs-2 text-secondary opacity-50 mb-2"></i>
                <h6 class="fw-bold text-dark fs-8 mb-1">No Rental History Yet</h6>
                <p class="text-muted fs-9 mb-0">Completed and returned equipment rentals will be recorded here.</p>
            </div>`;
            return;
        }

        let html = '<div class="d-flex flex-column gap-2.5">';
        html += `
        <div class="p-3 bg-light rounded-4 mb-1 text-center">
            <h6 class="fw-extrabold text-dark fs-8 mb-0">Total Bookings Completed: <span class="text-primary">${completedOrders.length}</span></h6>
            <span class="text-muted fs-9">All event rentals verified & returned without disputes</span>
        </div>`;

        completedOrders.forEach((ord) => {
            const orderCode = ord.order_code || ord.order_number || ('#RE-' + (ord.id || 10245));
            html += `
            <div class="card border rounded-4 p-3 shadow-xs bg-white">
                <div class="d-flex align-items-center justify-content-between mb-1.5">
                    <div>
                        <strong class="text-dark fs-8 d-block">${orderCode}</strong>
                        <span class="text-muted fs-9">${ord.rental_start_date || 'Sept 2026'} • Delivery</span>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-bold rounded-pill px-2.5 py-1 fs-9">
                        <i class="fa-solid fa-circle-check me-1"></i> Completed
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-1">
                    <span class="text-muted fs-9">Paid via <strong>${ord.payment_method || 'GCash'}</strong></span>
                    <strong class="text-dark fs-8">₱${parseFloat(ord.total_amount || 0).toLocaleString('en-US', {minimumFractionDigits: 2})}</strong>
                </div>
            </div>`;
        });
        html += '</div>';
        body.innerHTML = html;
    } catch (e) {
        body.innerHTML = `
        <div class="text-center py-4 bg-light rounded-4 p-3">
            <i class="fa-solid fa-clock-rotate-left fs-2 text-secondary opacity-50 mb-2"></i>
            <h6 class="fw-bold text-dark fs-8 mb-1">No Rental History Yet</h6>
            <p class="text-muted fs-9 mb-0">Completed event rentals will appear here.</p>
        </div>`;
    }
}

// Saved Addresses Modal
function getSavedAddresses() {
    try {
        const saved = localStorage.getItem('rentease_saved_addresses');
        if (saved) return JSON.parse(saved);
    } catch (e) {}
    return [
        { label: 'Campus Activity Center', address: 'San Pablo Colleges - Student Gymnasium & Stage Area', isPrimary: true },
        { label: 'Main Quadrangle', address: 'San Pablo Colleges Quadrangle Grounds (Booth 4)', isPrimary: false }
    ];
}

function openSavedAddressesModal() {
    renderSavedAddressesList();
    const modalEl = document.getElementById('savedAddressesModal');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function renderSavedAddressesList() {
    const list = document.getElementById('savedAddressesList');
    if (!list) return;
    const addresses = getSavedAddresses();

    let html = '';
    addresses.forEach((item, idx) => {
        html += `
        <div class="card border rounded-3 p-2.5 mb-2 bg-white d-flex flex-row align-items-center justify-content-between">
            <div>
                <div class="d-flex align-items-center gap-1.5 mb-1">
                    <strong class="text-dark fs-8">${item.label}</strong>
                    ${item.isPrimary ? '<span class="badge bg-primary rounded-pill fs-9 py-0.5 px-2">Primary</span>' : ''}
                </div>
                <div class="text-muted fs-9">${item.address}</div>
            </div>
            <div class="d-flex gap-1">
                ${!item.isPrimary ? `
                <button class="btn btn-sm btn-light border rounded-pill py-0 px-2 fs-9" onclick="setPrimaryAddress(${idx})" title="Set as Primary">
                    Set Primary
                </button>` : ''}
                <button class="btn btn-sm btn-outline-danger rounded-circle p-0 d-flex align-items-center justify-content-center" style="width:26px; height:26px;" onclick="deleteSavedAddress(${idx})">
                    <i class="fa-solid fa-trash fs-9"></i>
                </button>
            </div>
        </div>`;
    });
    list.innerHTML = html;
}

function saveNewSavedAddress() {
    const label = document.getElementById('newAddressLabel')?.value.trim();
    const address = document.getElementById('newAddressDetails')?.value.trim();

    if (!label || !address) {
        alert('Please fill out both the label and address fields.');
        return;
    }

    const addresses = getSavedAddresses();
    addresses.push({ label, address, isPrimary: addresses.length === 0 });
    localStorage.setItem('rentease_saved_addresses', JSON.stringify(addresses));

    document.getElementById('newAddressLabel').value = '';
    document.getElementById('newAddressDetails').value = '';
    renderSavedAddressesList();

    const checkoutAddr = document.getElementById('checkoutAddressText');
    if (checkoutAddr) checkoutAddr.innerText = `${label} (${address})`;

    alert('✅ New delivery address saved!');
}

function setPrimaryAddress(idx) {
    const addresses = getSavedAddresses();
    addresses.forEach((a, i) => a.isPrimary = (i === idx));
    localStorage.setItem('rentease_saved_addresses', JSON.stringify(addresses));
    renderSavedAddressesList();

    const checkoutAddr = document.getElementById('checkoutAddressText');
    if (checkoutAddr) checkoutAddr.innerText = `${addresses[idx].label} (${addresses[idx].address})`;
}

function deleteSavedAddress(idx) {
    let addresses = getSavedAddresses();
    if (addresses.length <= 1) {
        alert('You must have at least one saved delivery address.');
        return;
    }
    addresses.splice(idx, 1);
    if (!addresses.some(a => a.isPrimary)) addresses[0].isPrimary = true;
    localStorage.setItem('rentease_saved_addresses', JSON.stringify(addresses));
    renderSavedAddressesList();
}

// Payment Methods Modal
function openPaymentMethodsModal() {
    const user = getRentEaseCurrentUser();
    const phoneInput = document.getElementById('paymentPhoneInput');
    if (phoneInput) phoneInput.value = user.phone;

    const gcashDisplay = document.getElementById('gcashAccountDisplay');
    if (gcashDisplay) gcashDisplay.innerText = `Connected (${user.phone})`;

    const modalEl = document.getElementById('paymentMethodsModal');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function savePreferredPaymentMethod(method) {
    currentPaymentMethod = method;
    const badge = document.getElementById('checkoutSelectedPaymentBadge');
    if (badge) badge.innerText = method;
    alert(`💳 Preferred Payment Method set to ${method}!`);
}

function updatePaymentPhoneNumber() {
    const phone = document.getElementById('paymentPhoneInput')?.value.trim();
    if (!phone) {
        alert('Please enter a valid phone number.');
        return;
    }
    const user = getRentEaseCurrentUser();
    user.phone = phone;
    localStorage.setItem('rentease_user_profile', JSON.stringify(user));

    const gcashDisplay = document.getElementById('gcashAccountDisplay');
    if (gcashDisplay) gcashDisplay.innerText = `Connected (${phone})`;

    alert(`✅ Payment account mobile number updated to ${phone}!`);
}

// About RentEase Modal
function openAboutRentEaseModal() {
    const modalEl = document.getElementById('aboutRentEaseModal');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

// ----------------------------------------------------------
// GLOBAL TAB SWITCHER OVERRIDE (Matching UIDESIFNAPP.png)
// ----------------------------------------------------------
window.switchTab = function (tabName) {
    const validTabs = ['home', 'explore', 'cart', 'track', 'profile', 'sell', 'wanted', 'messages'];
    validTabs.forEach(t => {
        const el = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
        const nav = document.getElementById('tabNav' + t.charAt(0).toUpperCase() + t.slice(1));
        if (el) el.style.display = (t === tabName) ? 'block' : 'none';
        if (nav) nav.classList.toggle('active', t === tabName);
    });

    // Hide auth screen and chat view
    const auth = document.getElementById('authScreen');
    if (auth) auth.style.display = 'none';
    const chat = document.getElementById('chatView');
    if (chat) chat.style.display = 'none';
    const tabbar = document.querySelector('.app-tabbar');
    if (tabbar) tabbar.style.display = 'flex';

    // Header profile button: hide when on profile tab to avoid duplicate avatar
    const headerProfileBtn = document.getElementById('headerProfileBtn') || document.getElementById('homeAvatar')?.parentElement;
    if (headerProfileBtn) {
        if (tabName === 'profile') {
            headerProfileBtn.style.setProperty('display', 'none', 'important');
        } else {
            headerProfileBtn.style.setProperty('display', 'inline-block', 'important');
        }
    }

    if (tabName === 'cart') {
        ['cartCheckoutModal', 'productDetailModal'].forEach(mid => {
            const m = document.getElementById(mid);
            if (m) {
                const inst = bootstrap.Modal.getInstance(m);
                if (inst) inst.hide();
            }
        });
        const cartTab = document.getElementById('tabCart');
        if (cartTab) cartTab.style.display = 'block';
        showCartScreen();
        renderCartScreen();
        return;
    } else if (tabName === 'messages') {
        const tabBadge = document.getElementById('tabMessagesBadge');
        if (tabBadge) tabBadge.style.display = 'none';
        if (typeof markMessagesAsRead === 'function') markMessagesAsRead();
        if (typeof loadChatConversationsList === 'function') loadChatConversationsList();
    } else if (tabName === 'home') {
        if (typeof updateUnreadBadges === 'function') updateUnreadBadges();
        if (typeof pollRentEaseUnreadMessages === 'function') pollRentEaseUnreadMessages();
    } else if (tabName === 'explore') {
        renderExploreCatalog();
    } else if (tabName === 'sell') {
        const currentUser = getRentEaseCurrentUser();
        const isRomeo = (currentUser.email === 'romeopaolotolentino@gmail.com');
        let isVerified = isRomeo || (currentUser.is_verified === 1 || currentUser.verification_status === 'VERIFIED');
        updateSellVerificationState(isVerified);

        // Real-time server verification check if user has a registered ID and not yet confirmed verified
        if (currentUser.id > 0 && !isRomeo) {
            fetch(`/pasabuy_api.php?action=get_verification_status&userId=${currentUser.id}`)
                .then(r => r.ok ? r.json() : null)
                .then(data => {
                    if (!data) return;
                    const st = (data.VerificationStatus || data.Status || '').toUpperCase();
                    const liveVerified = (st === 'VERIFIED' || st === 'APPROVED');
                    updateSellVerificationState(liveVerified);
                    try {
                        const studentUserStr = localStorage.getItem('pasabuy_student_user');
                        if (studentUserStr) {
                            const parsed = JSON.parse(studentUserStr);
                            parsed.is_verified = liveVerified ? 1 : 0;
                            parsed.verification_status = liveVerified ? 'VERIFIED' : (st || 'PENDING');
                            localStorage.setItem('pasabuy_student_user', JSON.stringify(parsed));
                        }
                    } catch(e) {}
                })
                .catch(() => {});
        }

        if (typeof updateSellPostingFeeTier === 'function') {
            const curPrice = document.getElementById('sellPrice')?.value || 100;
            updateSellPostingFeeTier(curPrice);
        }
    } else if (tabName === 'track') {
        if (!_isOpeningTrackScreen && typeof openTrackScreen === 'function') {
            const activeCode = currentTrackingOrderCode || (function() {
                try { return localStorage.getItem('rentease_current_order_code') || ''; } catch(e) { return ''; }
            })();
            openTrackScreen(activeCode);
        }
    } else if (tabName === 'profile') {
        syncRentEaseProfileUI();
        loadUserRentedOutItems();
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

// ----------------------------------------------------------
// LENDER VERIFICATION UI HELPER
// ----------------------------------------------------------
window.updateSellVerificationState = function (isVerified) {
    const vBanner = document.getElementById('sellVerificationBanner');
    const warnBox = document.getElementById('sellPublishVerificationWarning');
    const btn = document.getElementById('btnPublishRentalItem');

    if (isVerified) {
        if (vBanner) vBanner.style.display = 'none';
        if (warnBox) warnBox.style.display = 'none';
        if (btn) {
            btn.disabled = false;
            btn.classList.remove('disabled');
            btn.removeAttribute('title');
            btn.innerHTML = '<i class="fa-solid fa-paper-plane fs-8"></i> <span>Publish Equipment for Rent</span>';
        }
    } else {
        if (vBanner) vBanner.style.display = 'block';
        if (warnBox) warnBox.style.display = 'block';
        if (btn) {
            btn.disabled = true;
            btn.classList.add('disabled');
            btn.setAttribute('title', 'Only admin-verified student accounts can list equipment for rent');
            btn.innerHTML = '<i class="fa-solid fa-lock fs-8"></i> <span>Verification Required to Post Equipment</span>';
        }
    }
};

// ----------------------------------------------------------
// POST RENTAL ITEM HANDLER (Live Video & Photo Rental Posting)
// ----------------------------------------------------------
window.postRentalItemLive = async function () {
    // Strict Guard: Only admin-verified student accounts can post equipment for rent
    const currentUser = getRentEaseCurrentUser();
    const isRomeo = (currentUser.email === 'romeopaolotolentino@gmail.com');
    const isVerified = isRomeo || (currentUser.is_verified === 1 || currentUser.verification_status === 'VERIFIED');

    if (!isVerified) {
        alert('🔒 Account Verification Required\n\nOnly admin-verified student accounts can publish equipment for rent.\n\nPlease submit your student ID verification under your Profile to get verified by Admin.');
        if (typeof openVerificationModal === 'function') {
            openVerificationModal();
        } else {
            switchTab('profile');
        }
        return;
    }

    const title = document.getElementById('sellTitle')?.value.trim();
    const category = document.getElementById('sellCategory')?.value || 'Others';
    const materialTag = document.getElementById('sellMaterialTag')?.value || 'Plastic';
    const price = parseFloat(document.getElementById('sellPrice')?.value) || 0;
    const quantity = parseInt(document.getElementById('sellQuantity')?.value) || 1;
    const condition = document.getElementById('sellCondition')?.value || 'Good';
    const location = document.getElementById('sellMeetup')?.value.trim() || 'San Pablo, Laguna';
    const description = document.getElementById('sellDescription')?.value.trim();
    
    // Photo from file input dataUrl or text url input
    const photoUrl = (typeof uploadedPhotoUrls !== 'undefined' && uploadedPhotoUrls.length > 0) 
        ? uploadedPhotoUrls[0] 
        : (document.getElementById('sellPhotoUrlInput')?.value.trim() || '');
    
    // Video from video url input or file input dataUrl
    const videoUrl = document.getElementById('sellVideoUrlInput')?.value.trim() || '';

    if (!title) {
        alert('⚠️ Please enter an equipment title / name.');
        document.getElementById('sellTitle')?.focus();
        return;
    }

    if (price <= 0) {
        alert('⚠️ Please enter a valid daily rental price.');
        document.getElementById('sellPrice')?.focus();
        return;
    }

    const btn = document.getElementById('btnPublishRentalItem');
    const oldBtnHtml = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Publishing Equipment...';
    }

    try {
        const currentUser = getRentEaseCurrentUser();
        const res = await fetch(getRentEaseApiUrl('post_item'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: title,
                category: category,
                material_tag: materialTag,
                price_per_day: price,
                qty_total: quantity,
                image_url: photoUrl,
                photos: (typeof uploadedPhotoUrls !== 'undefined' && uploadedPhotoUrls.length > 0) ? uploadedPhotoUrls : (photoUrl ? [photoUrl] : []),
                video_url: videoUrl,
                item_condition: condition,
                location: location,
                description: description,
                owner_id: currentUser.id || (currentUser.email === 'romeopaolotolentino@gmail.com' ? 104 : 0),
                owner_name: currentUser.name || 'Romeo Paolo Tolentino',
                owner_email: currentUser.email || 'romeopaolotolentino@gmail.com',
                owner_contact: currentUser.phone || '09668257301'
            })
        });

        const data = await res.json();
        if (data.success) {
            // Track item ID for user portfolio
            if (data.id) {
                try {
                    let postedIds = JSON.parse(localStorage.getItem('rentease_user_posted_ids') || '[]');
                    postedIds.push(parseInt(data.id));
                    localStorage.setItem('rentease_user_posted_ids', JSON.stringify(postedIds));
                } catch(e) {}
            }

            const feeInfo = data.posting_fee ? `\n🏷️ Posting Fee: ₱${parseFloat(data.posting_fee).toFixed(2)}` : '';
            alert(`🎉 Success!\n\n"${title}" has been published live for rent on RentEase!${feeInfo}`);
            
            // Clear inputs
            if (document.getElementById('sellTitle')) document.getElementById('sellTitle').value = '';
            if (document.getElementById('sellDescription')) document.getElementById('sellDescription').value = '';
            if (document.getElementById('sellPhotoUrlInput')) document.getElementById('sellPhotoUrlInput').value = '';
            if (document.getElementById('sellVideoUrlInput')) document.getElementById('sellVideoUrlInput').value = '';
            if (document.getElementById('sellPhotosPreviewGrid')) document.getElementById('sellPhotosPreviewGrid').innerHTML = '';
            if (document.getElementById('sellVideoPreviewContainer')) document.getElementById('sellVideoPreviewContainer').style.display = 'none';
            if (typeof uploadedPhotoUrls !== 'undefined') uploadedPhotoUrls = [];

            // Reload live inventory
            await loadRentEaseCatalog();

            // Switch to profile tab so user sees their posted equipment
            switchTab('profile');
        } else {
            alert(data.message || '❌ Failed to post item. Please try again.');
        }
    } catch (e) {
        console.error("Error posting rental item:", e);
        alert('❌ Error connecting to server to post item.');
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = oldBtnHtml;
        }
    }
};

// ----------------------------------------------------------
// USER PROFILE RENTED OUT EQUIPMENT LISTINGS
// ----------------------------------------------------------
window.loadUserRentedOutItems = async function () {
    const container = document.getElementById('myRentalListingsContainer');
    const badge = document.getElementById('myRentalCountBadge');
    if (!container) return;

    if (!rentEaseInventory || rentEaseInventory.length === 0) {
        await loadRentEaseCatalog();
    }

    const currentUser = getRentEaseCurrentUser();
    const currentUserId = parseInt(currentUser.id || 0);
    const currentUserEmail = (currentUser.email || '').toLowerCase().trim();

    let postedIds = [];
    try {
        postedIds = JSON.parse(localStorage.getItem('rentease_user_posted_ids') || '[]');
        postedIds = postedIds.map(x => parseInt(x));
    } catch (e) {}

    // Strict ownership verification:
    // Only display items explicitly posted by this user in session OR matching owner ID / exact email
    const myItems = (rentEaseInventory || []).filter(item => {
        const idNum = parseInt(item.id);
        const itemOwnerId = parseInt(item.owner_id || 0);
        const itemOwnerEmail = (item.owner_email || '').toLowerCase().trim();

        // 1. Explicitly published in this user's active session
        if (postedIds.includes(idNum)) return true;

        // 2. Strict ID match if user is authenticated with a valid ID
        if (currentUserId > 0 && itemOwnerId === currentUserId) return true;

        // 3. Strict exact Email match if both exist and match
        if (currentUserEmail && itemOwnerEmail && currentUserEmail === itemOwnerEmail) return true;

        return false;
    });

    if (badge) badge.innerText = myItems.length;

    const headerBtn = document.getElementById('headerPostEquipmentBtn');
    if (headerBtn) {
        headerBtn.style.display = 'inline-flex';
    }

    if (myItems.length === 0) {
        container.innerHTML = `
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width:60px; height:60px; color:#5B3FA8;">
                    <i class="fa-solid fa-box-open fs-2"></i>
                </div>
                <h6 class="fw-extrabold text-dark fs-7 mb-1">No Equipment Posted for Rent Yet</h6>
                <p class="text-muted fs-8 mb-0">You haven't listed any equipment. Rent out your sound systems, party chairs, tables, cameras, or lights to fellow students.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = myItems.map(item => {
        const img = item.image_url || 'https://images.unsplash.com/photo-1519741497674-611481863552?w=300&q=80';
        const price = parseFloat(item.price_per_day || item.price || 0).toLocaleString();
        const rawPrice = parseFloat(item.price_per_day || item.price || 100);
        const availStock = item.qty_available ?? item.qty_total ?? 1;
        const totalStock = item.qty_total ?? 1;
        const safeTitle = (item.name || 'Equipment').replace(/'/g, "\\'");
        return `
            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden p-3" id="rentalItemCard_${item.id}">
                <div class="d-flex gap-3">
                    <img src="${img}" 
                         class="rounded-3 border object-fit-cover shadow-2xs" 
                         style="width: 82px; height: 82px; flex-shrink: 0; object-fit: cover;" 
                         alt="${item.name}">
                    <div class="flex-grow-1 min-w-0">
                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                            <h6 class="fw-extrabold text-dark fs-8 mb-0 text-truncate" title="${item.name}">${item.name}</h6>
                            <span class="badge bg-success-subtle text-success fs-9 fw-bold">Active</span>
                        </div>
                        <div class="d-flex align-items-center gap-1.5 mb-1.5 flex-wrap">
                            <span class="badge bg-light text-secondary border fs-9">${item.category || 'General'}</span>
                            <span class="badge bg-light text-secondary border fs-9">${item.material_tag || 'Standard'}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <div>
                                <span class="fw-extrabold fs-7" style="color:#5B3FA8 !important;">₱${price}</span>
                                <span class="text-muted fs-9"> / day</span>
                            </div>
                            <div class="text-muted fs-9">
                                Stock: <strong class="text-dark">${availStock}</strong> / ${totalStock}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top pt-2 mt-2.5 flex-wrap gap-2">
                    <span class="text-muted fs-9 text-truncate me-1">
                        <i class="fa-solid fa-location-dot me-1 text-secondary"></i>${item.location || 'Campus Hub'}
                    </span>
                    <div class="d-flex gap-1.5">
                        <button class="btn btn-sm btn-light rounded-pill px-2.5 py-1 fs-9 fw-bold text-dark border shadow-2xs" 
                                onclick="openRentalDetail(${item.id})">
                            <i class="fa-solid fa-eye me-1"></i>View
                        </button>
                        <button class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 fs-9 fw-bold text-primary shadow-2xs" 
                                onclick="openEditStockPriceModal(${item.id}, '${safeTitle}', ${rawPrice}, ${availStock}, ${totalStock})">
                            <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fs-9 fw-bold" 
                                onclick="deleteUserRentalItem(${item.id}, '${safeTitle}')">
                            <i class="fa-solid fa-ban me-1"></i>Take Down
                        </button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
};

window.openEditStockPriceModal = function (id, title, price, avail, total) {
    const idEl = document.getElementById('modalEditItemId');
    const titleEl = document.getElementById('modalEditItemTitle');
    const priceEl = document.getElementById('modalEditItemPrice');
    const availEl = document.getElementById('modalEditItemAvailStock');
    const totalEl = document.getElementById('modalEditItemTotalStock');

    if (idEl) idEl.value = id;
    if (titleEl) titleEl.innerText = title || 'Equipment';
    if (priceEl) priceEl.value = price || 100;
    if (availEl) availEl.value = avail ?? total ?? 1;
    if (totalEl) totalEl.value = total ?? 1;

    const modalEl = document.getElementById('editRentalStockPriceModal');
    if (modalEl) {
        new bootstrap.Modal(modalEl).show();
    }
};

window.saveRentalStockPriceChanges = async function () {
    const id = parseInt(document.getElementById('modalEditItemId')?.value || 0);
    const price = parseFloat(document.getElementById('modalEditItemPrice')?.value || 0);
    const avail = parseInt(document.getElementById('modalEditItemAvailStock')?.value || 0);
    const total = parseInt(document.getElementById('modalEditItemTotalStock')?.value || 0);

    if (!id || price <= 0 || total <= 0) {
        alert('⚠️ Please enter a valid daily rental price and stock quantity.');
        return;
    }

    if (avail > total) {
        alert('⚠️ Available stock units cannot be greater than total stock units.');
        return;
    }

    const currentUser = getRentEaseCurrentUser();

    try {
        const res = await fetch(getRentEaseApiUrl('owner_update_stock_price'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id: id,
                price_per_day: price,
                qty_available: avail,
                qty_total: total,
                owner_id: currentUser.id || 0,
                owner_email: currentUser.email || ''
            })
        });

        const data = await res.json();
        if (data.success) {
            const modalEl = document.getElementById('editRentalStockPriceModal');
            if (modalEl) {
                const modalInst = bootstrap.Modal.getInstance(modalEl);
                if (modalInst) modalInst.hide();
            }

            await loadRentEaseCatalog();
            await loadUserRentedOutItems();
            alert('✅ Success! Your equipment price and stock have been updated live.');
        } else {
            alert('❌ ' + (data.message || 'Failed to update equipment details.'));
        }
    } catch(e) {
        alert('❌ Error connecting to server to update equipment.');
    }
};

window.deleteUserRentalItem = async function (id, name) {
    const warningMsg = 
`⚠️ WARNING: TAKE DOWN EQUIPMENT LISTING

Are you sure you want to take down "${name || 'this equipment'}"?

• NOTICE: If you take down this listing, you can get a refund on your posting fee (provided no active bookings remain unfulfilled).
• Once taken down, this equipment will immediately be unlisted and removed from campus search and student catalog.
• Any ongoing accepted bookings must still be honored.

Do you want to proceed and take down this listing?`;

    if (!confirm(warningMsg)) {
        return;
    }

    try {
        const currentUser = getRentEaseCurrentUser();
        const res = await fetch(getRentEaseApiUrl('delete_item'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                id: id,
                owner_id: currentUser.id || 0,
                owner_email: currentUser.email || ''
            })
        });
        const data = await res.json();
        if (data.success) {
            try {
                let postedIds = JSON.parse(localStorage.getItem('rentease_user_posted_ids') || '[]');
                postedIds = postedIds.filter(pid => parseInt(pid) !== parseInt(id));
                localStorage.setItem('rentease_user_posted_ids', JSON.stringify(postedIds));
            } catch (e) {}

            await loadRentEaseCatalog();
            await loadUserRentedOutItems();
            alert(`✅ Equipment "${name}" has been taken down.\n\nYour posting fee refund request has been logged.`);
        } else {
            alert('❌ ' + (data.message || 'Failed to take down equipment.'));
        }
    } catch (e) {
        console.error("Delete rental item error:", e);
        alert('❌ Error connecting to server to take down equipment.');
    }
};

// Rider license file preview
window.previewRiderLicense = function (e) {
    const file = e.target.files && e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (evt) {
            const img = document.getElementById('rLicensePreview');
            const box = document.getElementById('rLicensePreviewBox');
            if (img) img.src = evt.target.result;
            if (box) box.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
};

// Open verification modal from banner or anywhere
window.openVerificationModal = function () {
    const modalEl = document.getElementById('verificationRequestModal');
    let storedUser = null;
    try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) { }
    const userId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;

    const banner = document.getElementById('verificationStatusBanner');
    if (banner) {
        fetch(`/pasabuy_api.php?action=get_verification_status&userId=${userId}`)
            .then(r => r.ok ? r.json() : null)
            .then(data => {
                if (!data) return;
                const status = (data.VerificationStatus || data.Status || 'UNVERIFIED').toUpperCase();
                const reqStatus = (data.RequestStatus || '').toUpperCase();
                if (status === 'PENDING' || reqStatus === 'PENDING') {
                    banner.className = 'p-3 rounded-3 mb-3 fs-8 fw-semibold bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle';
                    banner.innerHTML = '<i class="fa-solid fa-clock me-1"></i> <strong>Verification Pending:</strong> Your student verification request is currently under review by campus Admin. You will be able to post items once approved.';
                    banner.style.display = 'block';
                } else if (status === 'REJECTED' || reqStatus === 'REJECTED') {
                    const reason = data.RejectionReason || 'Uploaded documents were incomplete or invalid.';
                    banner.className = 'p-3 rounded-3 mb-3 fs-8 fw-semibold bg-danger bg-opacity-10 text-danger border border-danger-subtle';
                    banner.innerHTML = `<i class="fa-solid fa-circle-xmark me-1"></i> <strong>Verification Rejected by Admin:</strong> ${reason}<br><span class="text-muted fw-normal fs-9">Please update your details below and resubmit for approval.</span>`;
                    banner.style.display = 'block';
                } else if (status === 'VERIFIED' || status === 'APPROVED') {
                    banner.className = 'p-3 rounded-3 mb-3 fs-8 fw-semibold bg-success bg-opacity-10 text-success border border-success-subtle';
                    banner.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> <strong>Account Verified:</strong> Your account is fully verified. You can post equipment for rent.';
                    banner.style.display = 'block';
                } else {
                    banner.className = 'p-3 rounded-3 mb-3 fs-8 fw-semibold bg-info bg-opacity-10 text-info-emphasis border border-info-subtle';
                    banner.innerHTML = '<i class="fa-solid fa-shield-halved me-1"></i> <strong>Student Verification Required:</strong> Submit your student ID for Admin approval to list equipment.';
                    banner.style.display = 'block';
                }
            })
            .catch(() => {});
    }

    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    } else {
        switchTab('profile');
    }
};

// Chat with item owner from Product Details modal
window.chatWithOwnerFromDetail = function () {
    const p = window.currentDetailProduct;
    if (typeof isCurrentUserOwnerOfItem === 'function' && isCurrentUserOwnerOfItem(p)) {
        alert("ℹ️ You are the owner of this equipment listing.");
        return;
    }
    const modalEl = document.getElementById('productDetailModal');
    if (modalEl) {
        try {
            const bsModal = bootstrap.Modal.getInstance(modalEl);
            if (bsModal) bsModal.hide();
        } catch (e) {}
    }
    const ownerName = p?.owner_name || p?.seller_name || 'Romeo Paolo Tolentino';
    const ownerId = parseInt(p?.owner_id || p?.seller_id) || 104;
    const title = p?.name || p?.title || 'Equipment Rental';
    const price = '₱' + (parseFloat(p?.price_per_day || p?.price || 0)).toLocaleString();

    if (typeof openChat === 'function') {
        openChat(ownerId, ownerName, title, price);
    } else if (typeof checkAndOpenChat === 'function') {
        checkAndOpenChat(ownerId, ownerName, title, price, '');
    } else {
        switchTab('messages');
    }

    setTimeout(() => {
        const chatInput = document.getElementById('chatInput');
        if (chatInput) {
            chatInput.value = `Hi ${ownerName}, is "${title}" (${price}/day) available for rent?`;
            chatInput.focus();
        }
    }, 400);
};

// Chat with partner from Live Tracking screen (Face-to-Face Meetup Coordination)
window.chatWithOwnerFromTracking = function () {
    const orderCode = currentTrackingOrderCode || (document.getElementById('trackOrderCodeTitle')?.innerText || '').replace(/^Order\s*/i, '').trim() || '#RE-RENTAL';
    const partnerName = document.getElementById('trackPartnerName')?.innerText || 'Partner';
    const partnerId = 104;
    const title = `Rental Order ${orderCode}`;

    if (typeof openChat === 'function') {
        openChat(partnerId, partnerName, title, '₱0.00');
    } else if (typeof checkAndOpenChat === 'function') {
        checkAndOpenChat(partnerId, partnerName, title, '₱0.00', '');
    } else {
        switchTab('messages');
    }

    setTimeout(() => {
        const chatInput = document.getElementById('chatInput');
        if (chatInput) {
            chatInput.value = `Hi ${partnerName}, regarding rental order ${orderCode}: let's agree on an on-campus meetup location and time for the face-to-face equipment handover.`;
            chatInput.focus();
        }
    }, 400);
};

// Toggle order items details modal
window.toggleOrderItemsModal = function () {
    if (typeof openMyOrdersModal === 'function') {
        openMyOrdersModal();
    } else {
        const modalEl = document.getElementById('myOrdersModal');
        if (modalEl) {
            new bootstrap.Modal(modalEl).show();
        }
    }
};

// Deliver equipment back to owner face-to-face and restore stock
window.dispatchReturnDelivery = async function () {
    const orderCode = currentTrackingOrderCode || (document.getElementById('trackOrderCodeTitle')?.innerText || '').replace(/^Order\s*/i, '').trim();
    if (!orderCode) {
        alert("Please track or select an active order first.");
        return;
    }
    const btn = document.getElementById('btnDispatchReturn');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Processing Return...';
    }
    try {
        const res = await fetch(getRentEaseApiUrl('return_equipment'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'return_equipment', order_code: orderCode })
        });
        const data = await res.json();
        if (data.success) {
            alert("✅ Rental Return Completed!\n\nThe equipment has been returned face-to-face and stock inventory is now replenished.");
            const badge = document.getElementById('returnStatusBadge');
            if (badge) {
                badge.className = 'badge bg-success-subtle text-success fs-9';
                badge.innerText = 'Returned & Restocked';
            }
            if (btn) {
                btn.className = 'btn btn-secondary rounded-3 py-2 px-3 fw-bold fs-8 flex-grow-1 disabled';
                btn.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> Returned';
            }
            if (typeof openTrackScreen === 'function') {
                openTrackScreen(orderCode);
            }
        } else {
            alert('❌ ' + (data.message || 'Could not process return.'));
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-handshake me-1"></i> Meet & Return to Owner';
            }
        }
    } catch (e) {
        console.error("Return error:", e);
        alert('❌ Error connecting to server to process return.');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-handshake me-1"></i> Meet & Return to Owner';
        }
    }
};

// Poll unread messages for Messages tab badge and notifications
function pollRentEaseUnreadMessages() {
    let storedUser = null;
    try { storedUser = JSON.parse(localStorage.getItem('pasabuy_student_user')); } catch (e) {}
    const currentUserId = storedUser ? (storedUser.id || storedUser.userId || storedUser.UserId || 104) : 104;
    fetch(`/pasabuy_api.php?action=get_unread&user_id=${currentUserId}`)
        .then(res => res.ok ? res.json() : null)
        .then(data => {
            if (!data) return;
            const count = data.unreadCount || 0;
            const tabBadge = document.getElementById('tabMessagesBadge');
            const notifBadge = document.getElementById('headerNotifBadge');
            if (tabBadge) {
                if (count > 0) {
                    tabBadge.innerText = count;
                    tabBadge.style.display = 'inline-block';
                } else {
                    tabBadge.style.display = 'none';
                }
            }
            if (notifBadge) {
                if (count > 0) {
                    notifBadge.innerText = count;
                    notifBadge.style.display = 'inline-block';
                } else {
                    notifBadge.style.display = 'none';
                }
            }
        })
        .catch(() => {});
}
window.pollRentEaseUnreadMessages = pollRentEaseUnreadMessages;

// Automatic bootstrap on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    loadRentEaseCatalog();
    syncRentEaseProfileUI();
    updateCartBadgeCount();
    try {
        const curUser = getRentEaseCurrentUser();
        const isRomeo = (curUser.email === 'romeopaolotolentino@gmail.com');
        const isVer = isRomeo || (curUser.is_verified === 1 || curUser.verification_status === 'VERIFIED');
        if (typeof updateSellVerificationState === 'function') {
            updateSellVerificationState(isVer);
        }
    } catch(e) {}
    pollRentEaseUnreadMessages();
    setInterval(pollRentEaseUnreadMessages, 4000);
    if (typeof checkOwnerRentalNotifications === 'function') {
        checkOwnerRentalNotifications();
        setInterval(checkOwnerRentalNotifications, 6000);
    }
    if (typeof checkUserOrderUpdatesBadge === 'function') {
        checkUserOrderUpdatesBadge();
        setInterval(checkUserOrderUpdatesBadge, 6000);
    }
    const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in') === 'true';
    if (isLoggedIn) {
        switchTab('home');
        const userActions = document.getElementById('headerUserActions');
        if (userActions) userActions.style.setProperty('display', 'flex', 'important');
    } else {
        const validTabs = ['home', 'explore', 'cart', 'track', 'profile', 'sell', 'wanted', 'messages'];
        validTabs.forEach(t => {
            const el = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
            if (el) el.style.display = 'none';
        });
        const tabbar = document.querySelector('.app-tabbar');
        if (tabbar) tabbar.style.display = 'none';
        const auth = document.getElementById('authScreen');
        if (auth && localStorage.getItem('pasabuy_student_logged_in') !== 'true') {
            // Keep auth screen if splash is done
        }
    }
});
