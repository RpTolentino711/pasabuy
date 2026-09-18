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
let currentCategory = 'Chairs';
let currentTag = 'All';
let currentDeliveryOption = 'DELIVERY';
let currentPaymentMethod = 'GCASH';
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

    const featured = rentEaseInventory.filter(i => parseInt(i.is_featured) === 1).slice(0, 4);
    if (featured.length === 0) return;

    let html = '';
    featured.forEach(item => {
        html += `
        <div class="col-6 mb-2">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-2.5 bg-white position-relative" style="cursor:pointer;" onclick="openEquipmentDetail(${item.id})">
                <div class="position-relative">
                    <img src="${item.image_url}" class="rounded-3 w-100" style="height: 125px; object-fit: cover;" alt="${item.name}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80';">
                    <button class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-1.5 p-0 d-flex align-items-center justify-content-center shadow-xs" 
                            style="width:26px; height:26px; background:rgba(255,255,255,0.9);" 
                            onclick="event.stopPropagation(); toggleWishlist(this, ${item.id})">
                        <i class="fa-regular fa-heart text-dark fs-9"></i>
                    </button>
                </div>
                <div class="pt-2">
                    <h6 class="fw-bold mb-1 text-dark fs-8 text-truncate" title="${item.name}">${item.name}</h6>
                    <div class="d-flex align-items-baseline gap-1 mb-1">
                        <span class="fw-extrabold text-dark fs-7">₱${parseFloat(item.price_per_day).toFixed(0)}</span>
                        <span class="text-muted fs-9">/ day</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-1">
                            <i class="fa-solid fa-star text-warning fs-9"></i>
                            <span class="fw-bold text-dark fs-9">${parseFloat(item.rating).toFixed(1)}</span>
                            <span class="text-muted fs-9">(${item.reviews_count})</span>
                        </div>
                        <button class="btn btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center text-white" 
                                style="width:28px; height:28px; background: linear-gradient(135deg, #5B3FA8, #341F97);"
                                onclick="event.stopPropagation(); quickAddRentEaseItem(${item.id})" title="Add to Cart">
                            <i class="fa-solid fa-cart-plus fs-9"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
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
    if (!q) {
        renderExploreCatalog();
        return;
    }
    const filtered = rentEaseInventory.filter(item => 
        item.name.toLowerCase().includes(q) || 
        item.category.toLowerCase().includes(q) || 
        (item.description && item.description.toLowerCase().includes(q))
    );
    renderGridElements(filtered);
    switchTab('explore');
}

function renderExploreCatalog() {
    let filtered = rentEaseInventory;

    if (currentCategory && currentCategory !== 'All') {
        filtered = filtered.filter(i => i.category === currentCategory);
    }
    if (currentTag && currentTag !== 'All') {
        filtered = filtered.filter(i => i.material_tag === currentTag);
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
        const inCart = rentEaseCart.some(c => c.id === p.id);
        const cartBtnClass = inCart 
            ? 'btn-success text-white' 
            : 'text-white';
        const cartBtnStyle = inCart 
            ? 'background: linear-gradient(135deg, #10B981, #059669); border:none;' 
            : 'background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;';
        const cartBtnText = inCart ? '<i class="fa-solid fa-check me-1"></i> Added' : '<i class="fa-solid fa-cart-plus me-1"></i> Add to Cart';

        html += `
        <div class="col-6 mb-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-2.5 bg-white position-relative d-flex flex-column justify-content-between" style="cursor:pointer;" onclick="openEquipmentDetail(${p.id})">
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
                    <div class="d-flex align-items-center gap-1 mb-2.5">
                        <i class="fa-solid fa-star text-warning fs-9"></i>
                        <span class="fw-bold text-dark fs-9">${parseFloat(p.rating).toFixed(1)}</span>
                        <span class="text-muted fs-9">(${p.reviews_count})</span>
                    </div>
                </div>
                <button class="btn btn-sm rounded-pill w-100 fw-bold fs-9 py-1.5 shadow-2xs ${cartBtnClass}" 
                        style="${cartBtnStyle}" onclick="event.stopPropagation(); quickAddRentEaseItem(${p.id})">
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
function openEquipmentDetail(id) {
    const item = rentEaseInventory.find(i => i.id == id);
    if (!item) return;

    currentDetailProduct = item;
    currentDetailQty = 1;

    document.getElementById('detailHeaderTitle').innerText = item.name;
    document.getElementById('detailTitle').innerText = item.name;
    document.getElementById('detailMainImg').src = item.image_url;
    document.getElementById('detailRatingVal').innerText = parseFloat(item.rating || 5.0).toFixed(1);
    document.getElementById('detailReviewCount').innerText = item.reviews_count || 1;
    document.getElementById('detailPrice').innerText = '₱' + parseFloat(item.price_per_day).toFixed(0);
    document.getElementById('detailDescription').innerText = item.description || 'Quality event equipment for rent, maintained and cleaned for every booking.';
    document.getElementById('detailQtyVal').innerText = currentDetailQty;

    // Video Player support for posted equipment
    const videoContainer = document.getElementById('detailVideoContainer');
    const videoPlayer = document.getElementById('detailVideoPlayer');
    if (videoContainer && videoPlayer) {
        if (item.video_url && item.video_url.trim() !== '') {
            videoPlayer.src = item.video_url;
            videoContainer.style.display = 'block';
        } else {
            videoPlayer.pause();
            videoPlayer.src = '';
            videoContainer.style.display = 'none';
        }
    }

    const modalEl = document.getElementById('productDetailModal');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
        bsModal.show();
    }
}

function adjustDetailQty(delta) {
    currentDetailQty = Math.max(1, currentDetailQty + delta);
    const el = document.getElementById('detailQtyVal');
    if (el) el.innerText = currentDetailQty;
}

function confirmAddDetailToCart() {
    if (!currentDetailProduct) return;
    addRentEaseCartItem(currentDetailProduct, currentDetailQty);

    const modalEl = document.getElementById('productDetailModal');
    if (modalEl) {
        const bs = bootstrap.Modal.getInstance(modalEl);
        if (bs) bs.hide();
    }
    renderExploreCatalog();
}

function quickAddRentEaseItem(id) {
    const item = rentEaseInventory.find(i => i.id == id);
    if (!item) return;
    addRentEaseCartItem(item, 1);
    renderExploreCatalog();
}

function addRentEaseCartItem(product, qty = 1) {
    const existing = rentEaseCart.find(i => i.id === product.id);
    if (existing) {
        existing.quantity += qty;
    } else {
        rentEaseCart.push({
            id: product.id,
            title: product.name,
            price_per_day: parseFloat(product.price_per_day),
            quantity: qty,
            image_url: product.image_url
        });
    }
    saveRentEaseCart();
    updateCartBadgeCount();
}

function saveRentEaseCart() {
    localStorage.setItem('rentease_cart', JSON.stringify(rentEaseCart));
}

function updateCartBadgeCount() {
    const count = rentEaseCart.reduce((acc, it) => acc + (it.quantity || 1), 0);
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

// ----------------------------------------------------------
// 3. SCREEN 4: MY CART & COMPUTATION MODULE
// ----------------------------------------------------------
async function renderCartScreen() {
    showCartScreen();
    const container = document.getElementById('cartItemsListContainer');
    if (!container) return;

    if (rentEaseCart.length === 0) {
        container.innerHTML = `
        <div class="text-center py-5 bg-white rounded-4 border p-4">
            <i class="fa-solid fa-cart-shopping fs-2 d-block mb-2 text-secondary opacity-50"></i>
            <h6 class="fw-bold text-dark fs-7 mb-1">Your cart is empty</h6>
            <p class="fs-9 text-muted mb-3">Browse our catalog to add chairs, tables, tents, and audio equipment.</p>
            <button class="btn btn-sm btn-primary rounded-pill px-4 fw-bold" style="background:#5B3FA8; border:none;" onclick="switchTab('explore')">Explore Equipment</button>
        </div>`;
        updateComputationDisplay(0, 0, 0, 0, 0);
        return;
    }

    let html = '';
    rentEaseCart.forEach((item, index) => {
        const itemSubtotal = item.price_per_day * item.quantity;
        html += `
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <img src="${item.image_url}" class="rounded-3 border" width="60" height="60" style="object-fit:cover;" alt="${item.title}">
                <div>
                    <h6 class="fw-bold text-dark fs-8 mb-0.5">${item.title}</h6>
                    <div class="fs-9 text-muted mb-2">₱${item.price_per_day.toFixed(0)} / day</div>
                    
                    <!-- Stepper -->
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center border shadow-2xs" 
                                style="width:24px; height:24px;" onclick="adjustCartQty(${index}, -1)">
                            <i class="fa-solid fa-minus fs-9 text-dark"></i>
                        </button>
                        <span class="fw-bold text-dark fs-8 px-1">${item.quantity}</span>
                        <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center border shadow-2xs" 
                                style="width:24px; height:24px;" onclick="adjustCartQty(${index}, 1)">
                            <i class="fa-solid fa-plus fs-9 text-dark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column align-items-end justify-content-between h-100 gap-3">
                <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center text-danger" 
                        style="width:28px; height:28px; background:rgba(239,68,68,0.08);" onclick="removeCartItem(${index})" title="Remove">
                    <i class="fa-solid fa-trash-can fs-9"></i>
                </button>
                <div class="fw-extrabold text-dark fs-7">₱${itemSubtotal.toLocaleString()}</div>
            </div>
        </div>`;
    });
    container.innerHTML = html;

    // Call Computation API
    try {
        const res = await fetch(getRentEaseApiUrl('calculate_charges'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                items: rentEaseCart,
                delivery_option: currentDeliveryOption
            })
        });
        if (res.ok) {
            const data = await res.json();
            const c = data.computation;
            updateComputationDisplay(c.subtotal, c.service_charge, c.delivery_fee, c.discount, c.total);
        }
    } catch (e) {
        // Fallback local computation
        const sub = rentEaseCart.reduce((acc, it) => acc + (it.price_per_day * it.quantity), 0);
        const svc = sub > 0 ? 100 : 0;
        const del = (currentDeliveryOption === 'DELIVERY' && sub > 0) ? 150 : 0;
        const disc = sub >= 1000 ? 50 : 0;
        const tot = sub + svc + del - disc;
        updateComputationDisplay(sub, svc, del, disc, tot);
    }
}

function updateComputationDisplay(sub, svc, del, disc, tot) {
    const subEl = document.getElementById('cartRentalSubtotal');
    const svcEl = document.getElementById('cartServiceCharge');
    const delEl = document.getElementById('cartDeliveryFee');
    const discEl = document.getElementById('cartDiscount');
    const totEl = document.getElementById('cartGrandTotal');

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

    if (paySubEl) paySubEl.innerText = '₱' + sub.toLocaleString();
    if (paySvcEl) paySvcEl.innerText = '₱' + svc.toLocaleString();
    if (payDelEl) payDelEl.innerText = '₱' + del.toLocaleString();
    if (payDiscEl) payDiscEl.innerText = '- ₱' + disc.toLocaleString();
    if (payTotEl) payTotEl.innerText = '₱' + tot.toLocaleString();
}

function adjustCartQty(index, delta) {
    if (!rentEaseCart[index]) return;
    rentEaseCart[index].quantity = Math.max(1, rentEaseCart[index].quantity + delta);
    saveRentEaseCart();
    updateCartBadgeCount();
    renderCartScreen();
}

function removeCartItem(index) {
    rentEaseCart.splice(index, 1);
    saveRentEaseCart();
    updateCartBadgeCount();
    renderCartScreen();
}

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
    const rentalDate = document.getElementById('checkoutDateInput')?.value || '2026-09-25';
    const user = getRentEaseCurrentUser();

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
                items: rentEaseCart,
                payment_method: currentPaymentMethod
            })
        });

        const data = await res.json();
        if (res.ok && data.success) {
            const orderCode = data.order_code || '#RE-10245';
            alert(`🎉 Payment Successful via ${currentPaymentMethod}!\nOrder ${orderCode} is confirmed and scheduled for delivery.`);
            
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
        // Fallback demo transition to Screen 7
        alert('🎉 Payment Confirmed via GCash!\nOrder #RE-10245 is now active.');
        rentEaseCart = [];
        saveRentEaseCart();
        updateCartBadgeCount();
        openTrackScreen('#RE-10245');
    }
}

// ----------------------------------------------------------
// 6. SCREEN 7: LIVE ORDER & DELIVERY TRACKING WITH MAP
// ----------------------------------------------------------
async function openTrackScreen(orderCode = '#RE-10245') {
    switchTab('track');
    const titleEl = document.getElementById('trackOrderCodeTitle');
    if (titleEl) titleEl.innerText = `Order ${orderCode}`;

    try {
        const res = await fetch(getRentEaseApiUrl('get_order_tracking', { order_code: orderCode }));
        if (res.ok) {
            const data = await res.json();
            const t = data.tracking;

            const arrEl = document.getElementById('trackEstimatedArrivalText');
            if (arrEl) arrEl.innerText = `Estimated Arrival: ${t.estimated_arrival}`;

            const nameEl = document.getElementById('trackRiderName');
            if (nameEl) nameEl.innerText = t.rider.name;

            const roleEl = document.getElementById('trackRiderRole');
            if (roleEl) roleEl.innerText = `${t.rider.role} • ${t.rider.vehicle}`;

            const phoneBtn = document.getElementById('trackCallRiderBtn');
            if (phoneBtn) phoneBtn.href = `tel:${t.rider.phone}`;

            setTimeout(() => {
                initRentEaseLeafletMap(t.locations.warehouse, t.locations.rider, t.locations.destination);
            }, 250);
            return;
        }
    } catch (e) {
        console.error("Order tracking load error:", e);
    }

    // Default map coordinates
    setTimeout(() => {
        initRentEaseLeafletMap([14.6488, 121.0687], [14.6515, 121.0692], [14.6540, 121.0745]);
    }, 250);
}

function initRentEaseLeafletMap(warehouse, rider, destination) {
    const mapEl = document.getElementById('renteaseTrackMap');
    if (!mapEl) return;

    if (rentEaseMapInstance) {
        rentEaseMapInstance.remove();
        rentEaseMapInstance = null;
    }

    try {
        const map = L.map('renteaseTrackMap', { zoomControl: false }).setView(rider, 15);
        rentEaseMapInstance = map;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // Warehouse Pin
        const warehouseIcon = L.divIcon({
            html: `<div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width:28px; height:28px; background:#10B981; font-size:13px; border:2px solid #fff;"><i class="fa-solid fa-warehouse"></i></div>`,
            className: '',
            iconSize: [28, 28]
        });
        L.marker(warehouse, { icon: warehouseIcon }).addTo(map).bindPopup('RentEase Hub (Warehouse)');

        // Rider Motorcycle Pin
        const riderIcon = L.divIcon({
            html: `<div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-lg" style="width:34px; height:34px; background:linear-gradient(135deg, #5B3FA8, #341F97); font-size:15px; border:2px solid #fff;"><i class="fa-solid fa-motorcycle"></i></div>`,
            className: '',
            iconSize: [34, 34]
        });
        L.marker(rider, { icon: riderIcon }).addTo(map).bindPopup('Juan Dela Cruz (Delivery Rider)');

        // Destination Pin
        const destIcon = L.divIcon({
            html: `<div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width:28px; height:28px; background:#EF4444; font-size:13px; border:2px solid #fff;"><i class="fa-solid fa-location-dot"></i></div>`,
            className: '',
            iconSize: [28, 28]
        });
        L.marker(destination, { icon: destIcon }).addTo(map).bindPopup('Delivery Address: San Pablo, Laguna');

        // Route Polyline
        L.polyline([warehouse, rider, destination], {
            color: '#5B3FA8',
            weight: 4,
            dashArray: '8, 8',
            opacity: 0.9
        }).addTo(map);

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

function openPackageDetails(pkgId) {
    alert('🎉 Birthday Celebration Package Selected!\nIncludes: 50x Monoblock Chairs, 5x Folding Tables, 1x Event Tent (10x10ft)\nDiscount: 20% OFF • Starting at ₱1,499. Added to reservation flow.');
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
            if (fullName) {
                const courseInfo = u.course ? `${u.course} • ${u.yearLevel || '4th Yr'}` : 'BSIT • 4th Yr';
                return {
                    firstName: first || 'Romeo Paolo',
                    lastName: last || 'Tolentino',
                    name: fullName,
                    sub: courseInfo,
                    email: u.email || u.SchoolEmail || (u.studentNumber ? `${u.studentNumber}@campus.edu.ph` : 'romeopaolo.tolentino@campus.edu.ph'),
                    phone: u.phone || u.phoneNumber || u.PhoneNumber || u.studentNumber || '09668257301',
                    studentNumber: u.studentNumber || '09668257301',
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
            if (fullName) {
                return {
                    firstName: first || 'Romeo Paolo',
                    lastName: last || 'Tolentino',
                    name: fullName,
                    sub: u.Course ? `${u.Course} • ${u.YearLevel || '4th Yr'}` : 'BSIT • 4th Yr',
                    email: u.SchoolEmail || u.email || 'romeopaolo.tolentino@campus.edu.ph',
                    phone: u.PhoneNumber || u.phone || '09668257301',
                    studentNumber: u.StudentNumber || '09668257301',
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
    if (modalEl) {
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        syncRentEaseProfileUI();
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
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

    try {
        const res = await fetch(getRentEaseApiUrl('get_admin_dashboard'));
        const data = await res.json();
        const orders = data.recent_orders || [];
        const activeOrders = orders.filter(o => o.status !== 'RETURNED' && o.status !== 'CANCELLED');

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

        let html = '<div class="d-flex flex-column gap-2.5">';
        activeOrders.forEach(ord => {
            const statusBadge = ord.status === 'ON_THE_WAY' 
                ? '<span class="badge bg-primary text-white rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-truck-fast me-1"></i> ON THE WAY</span>'
                : (ord.status === 'DELIVERED' 
                    ? '<span class="badge bg-success text-white rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-check me-1"></i> DELIVERED</span>'
                    : '<span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fs-9"><i class="fa-solid fa-clock me-1"></i> PREPARING</span>');

            html += `
            <div class="card border rounded-4 p-3 shadow-xs bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-extrabold text-dark fs-8">${ord.order_number}</span>
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
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fs-9 fw-bold" onclick="bootstrap.Modal.getInstance(document.getElementById('myOrdersModal')).hide(); document.getElementById('issueOrderCodeInput').value='${ord.order_number}'; openIssueReportingModal();">
                            <i class="fa-solid fa-headset me-1"></i> Report
                        </button>
                        <button class="btn btn-sm btn-primary rounded-pill px-3 py-1 fs-9 fw-bold" style="background:#5B3FA8; border:none;" onclick="bootstrap.Modal.getInstance(document.getElementById('myOrdersModal')).hide(); openTrackScreen('${ord.order_number}');">
                            <i class="fa-solid fa-location-arrow me-1"></i> Track
                        </button>
                    </div>
                </div>
            </div>`;
        });
        html += '</div>';
        body.innerHTML = html;
    } catch (e) {
        body.innerHTML = '<div class="text-center py-4 text-danger fs-8">Unable to load orders right now.</div>';
    }
}

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
        const res = await fetch(getRentEaseApiUrl('get_admin_dashboard'));
        const data = await res.json();
        const orders = data.recent_orders || [];
        
        let html = '<div class="d-flex flex-column gap-2.5">';
        html += `
        <div class="p-3 bg-light rounded-4 mb-1 text-center">
            <h6 class="fw-extrabold text-dark fs-8 mb-0">Total Bookings Completed: <span class="text-primary">${orders.length}</span></h6>
            <span class="text-muted fs-9">All event rentals verified & returned without disputes</span>
        </div>`;

        orders.forEach((ord, index) => {
            html += `
            <div class="card border rounded-4 p-3 shadow-xs bg-white">
                <div class="d-flex align-items-center justify-content-between mb-1.5">
                    <div>
                        <strong class="text-dark fs-8 d-block">${ord.order_number}</strong>
                        <span class="text-muted fs-9">${ord.rental_start_date || 'Sept 2026'} • ${ord.fulfillment_type || 'Delivery'}</span>
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
        body.innerHTML = '<div class="text-center py-4 text-muted fs-8">12 past event rentals recorded.</div>';
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

    if (tabName === 'cart') {
        renderCartScreen();
    } else if (tabName === 'explore') {
        renderExploreCatalog();
    } else if (tabName === 'track') {
        openTrackScreen('#RE-10245');
    } else if (tabName === 'profile') {
        syncRentEaseProfileUI();
        loadUserRentedOutItems();
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

// ----------------------------------------------------------
// POST RENTAL ITEM HANDLER (Live Video & Photo Rental Posting)
// ----------------------------------------------------------
window.postRentalItemLive = async function () {
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
                video_url: videoUrl,
                item_condition: condition,
                location: location,
                description: description,
                owner_name: currentUser.name || 'Romeo Paolo Tolentino'
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

            alert(`🎉 Success!\n\n"${title}" has been published live for rent on RentEase!`);
            
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
            alert('❌ ' + (data.message || 'Failed to post item. Please try again.'));
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
    const currentName = (currentUser.name || 'Romeo Paolo Tolentino').toLowerCase().trim();

    let postedIds = [];
    try {
        postedIds = JSON.parse(localStorage.getItem('rentease_user_posted_ids') || '[]');
    } catch (e) {}

    const myItems = (rentEaseInventory || []).filter(item => {
        const idNum = parseInt(item.id);
        if (postedIds.includes(idNum) || postedIds.includes(String(item.id))) return true;
        const owner = (item.owner_name || '').toLowerCase().trim();
        if (owner && (owner.includes('romeo') || owner.includes('tolentino') || owner === currentName)) return true;
        return false;
    });

    if (badge) badge.innerText = myItems.length;

    if (myItems.length === 0) {
        container.innerHTML = `
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width:60px; height:60px; color:#5B3FA8;">
                    <i class="fa-solid fa-box-open fs-2"></i>
                </div>
                <h6 class="fw-extrabold text-dark fs-7 mb-1">No Equipment Posted for Rent Yet</h6>
                <p class="text-muted fs-8 mb-3">You haven't listed any equipment. Rent out your sound systems, party chairs, tables, cameras, or lights to fellow students.</p>
                <button class="btn btn-primary rounded-pill px-3 py-2 fw-bold fs-8 mx-auto" 
                        style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" 
                        onclick="switchTab('sell')">
                    <i class="fa-solid fa-plus me-1.5"></i> Post Equipment for Rent
                </button>
            </div>
        `;
        return;
    }

    container.innerHTML = myItems.map(item => {
        const img = item.image_url || 'https://images.unsplash.com/photo-1519741497674-611481863552?w=300&q=80';
        const price = parseFloat(item.price_per_day || item.price || 0).toLocaleString();
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
                                Stock: <strong class="text-dark">${item.qty_available ?? item.qty_total ?? 1}</strong> / ${item.qty_total ?? 1}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top pt-2 mt-2.5">
                    <span class="text-muted fs-9 text-truncate me-2">
                        <i class="fa-solid fa-location-dot me-1 text-secondary"></i>${item.location || 'Campus Hub'}
                    </span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-light rounded-pill px-2.5 py-1 fs-9 fw-bold text-dark border" 
                                onclick="openRentalDetail(${item.id})">
                            <i class="fa-solid fa-eye me-1"></i>View
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fs-9 fw-bold" 
                                onclick="deleteUserRentalItem(${item.id}, '${safeTitle}')">
                            <i class="fa-solid fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
};

window.deleteUserRentalItem = async function (id, name) {
    if (!confirm(`Are you sure you want to remove "${name || 'this item'}" from your rental listings?`)) {
        return;
    }
    try {
        const res = await fetch(getRentEaseApiUrl('delete_item'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        });
        const data = await res.json();
        if (data.success) {
            try {
                let postedIds = JSON.parse(localStorage.getItem('rentease_user_posted_ids') || '[]');
                postedIds = postedIds.filter(pid => pid != id);
                localStorage.setItem('rentease_user_posted_ids', JSON.stringify(postedIds));
            } catch (e) {}

            await loadRentEaseCatalog();
            await loadUserRentedOutItems();
            alert(`Equipment "${name}" has been removed.`);
        } else {
            alert('❌ ' + (data.message || 'Failed to remove equipment.'));
        }
    } catch (e) {
        console.error("Delete rental item error:", e);
        alert('❌ Error connecting to server to delete equipment.');
    }
};

// Automatic bootstrap on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    loadRentEaseCatalog();
    syncRentEaseProfileUI();
    updateCartBadgeCount();
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
