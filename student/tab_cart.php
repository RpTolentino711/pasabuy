<!-- ==========================================================
     RentEase Screen 4, 5 & 6: Cart, Checkout & Digital Payment
     UIDESIFNAPP.png Screens 4, 5, 6
     ========================================================== -->
<div id="tabCart" style="display:none;">

    <!-- VIEW 4A: MY CART (Screen 4) -->
    <div id="cartScreenView">
        <div class="d-flex align-items-center justify-content-between mb-3 pb-1">
            <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                    style="width:34px; height:34px; background:#fff;" onclick="switchTab('home')">
                <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
            </button>
            <h5 class="fw-extrabold mb-0 text-dark fs-6">My Cart</h5>
            <div style="width:34px;"></div>
        </div>

        <!-- Cart Line Items Container -->
        <div id="cartItemsListContainer" class="d-flex flex-column gap-2.5 mb-3">
            <!-- Dynamically populated from localStorage: rentease_cart -->
        </div>

        <!-- Rental Duration Card (Screen 4) -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3" id="cartDurationCard">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-extrabold text-dark fs-8"><i class="fa-regular fa-calendar-days me-1.5" style="color:#5B3FA8 !important;"></i> Rental Duration</div>
                    <div class="text-muted fs-9">How many days will you rent this equipment?</div>
                </div>
                <!-- Stepper for Days -->
                <div class="d-flex align-items-center gap-1.5 bg-light border rounded-pill px-2.5 py-1">
                    <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                            style="width:26px; height:26px; background:#fff;" onclick="adjustRentalDaysCart(-1)">
                        <i class="fa-solid fa-minus fs-9 text-dark"></i>
                    </button>
                    <span class="fw-extrabold text-dark fs-8 px-1" id="cartRentalDaysVal">1</span>
                    <span class="fs-9 fw-semibold text-secondary" id="cartRentalDaysUnit">day</span>
                    <button type="button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                            style="width:26px; height:26px; background:#fff;" onclick="adjustRentalDaysCart(1)">
                        <i class="fa-solid fa-plus fs-9 text-dark"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Computation Summary Card (Screen 4) -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3" id="cartSummaryCard">
            <h6 class="fw-extrabold text-dark fs-8 mb-2.5">Summary</h6>
            <div class="d-flex justify-content-between fs-8 text-secondary mb-1.5">
                <span id="cartSubtotalLabel">Rental Subtotal (1 day)</span>
                <span class="fw-bold text-dark" id="cartRentalSubtotal">₱0</span>
            </div>
            <div class="d-flex justify-content-between fs-8 text-secondary mb-1.5">
                <span>Service Charge</span>
                <span class="fw-bold text-dark" id="cartServiceCharge">₱0</span>
            </div>
            <div class="d-flex justify-content-between fs-8 text-secondary mb-1.5">
                <span>Delivery Fee</span>
                <span class="fw-bold text-dark" id="cartDeliveryFee">₱0</span>
            </div>
            <div class="d-flex justify-content-between fs-8 text-success mb-2">
                <span>Discount</span>
                <span class="fw-bold text-success" id="cartDiscount">₱0</span>
            </div>
            <hr class="my-2 border-secondary opacity-25">
            <div class="d-flex justify-content-between align-items-center pt-1">
                <span class="fw-extrabold text-dark fs-7">Total</span>
                <span class="fw-extrabold fs-6" style="color: #5B3FA8;" id="cartGrandTotal">₱0</span>
            </div>
        </div>

        <button class="btn btn-primary w-100 py-3 rounded-4 fw-extrabold shadow-sm fs-7" 
                style="background: #5B3FA8; border: none;" onclick="openCheckoutScreen()">
            Proceed to Checkout
        </button>
    </div>

    <!-- VIEW 4B: CHECKOUT (Screen 5) -->
    <div id="checkoutScreenView" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-3 pb-1">
            <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                    style="width:34px; height:34px; background:#fff;" onclick="showCartScreen()">
                <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
            </button>
            <h5 class="fw-extrabold mb-0 text-dark fs-6">Checkout</h5>
            <div style="width:34px;"></div>
        </div>

        <!-- Delivery Option Selector (Pickup vs Delivery) -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3">
            <h6 class="fw-extrabold text-dark fs-8 mb-2.5">Delivery Option</h6>
            
            <div class="form-check p-2.5 rounded-3 mb-2 border d-flex align-items-center" style="cursor:pointer;" onclick="selectDeliveryOption('PICKUP')">
                <input class="form-check-input ms-0 me-3" type="radio" name="deliveryOptionRadio" id="optPickup">
                <label class="form-check-label w-100" for="optPickup" style="cursor:pointer;">
                    <div class="fw-bold text-dark fs-8"><i class="fa-solid fa-warehouse text-secondary me-1.5"></i> Pickup (Free)</div>
                    <div class="text-muted fs-9">Pick up at our warehouse</div>
                </label>
            </div>

            <div class="form-check p-2.5 rounded-3 border d-flex align-items-center border-primary bg-primary-subtle bg-opacity-25" style="cursor:pointer;" onclick="selectDeliveryOption('DELIVERY')">
                <input class="form-check-input ms-0 me-3" type="radio" name="deliveryOptionRadio" id="optDelivery" checked>
                <label class="form-check-label w-100" for="optDelivery" style="cursor:pointer;">
                    <div class="fw-bold text-dark fs-8"><i class="fa-solid fa-truck text-primary me-1.5"></i> Delivery</div>
                    <div class="text-muted fs-9">We'll deliver to your location</div>
                </label>
            </div>
        </div>

        <!-- Delivery Address -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="fw-extrabold text-dark fs-8">Delivery Address</span>
                <a href="javascript:void(0)" class="fs-9 fw-bold text-decoration-none" style="color:#5B3FA8;" onclick="changeDeliveryAddress()">Change</a>
            </div>
            <div class="d-flex align-items-center gap-2 pt-1">
                <i class="fa-solid fa-location-dot fs-6" style="color: #5B3FA8;"></i>
                <span class="fs-8 text-dark fw-semibold" id="checkoutAddressText">San Pablo, Laguna</span>
            </div>
        </div>

        <!-- Rental Duration & Date Picker -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-extrabold text-dark fs-8"><i class="fa-regular fa-calendar-days text-primary me-1.5" style="color:#5B3FA8;"></i> Rental Duration</span>
                <span class="badge bg-primary-subtle text-primary fw-bold fs-9" id="checkoutDurationBadge">1 Day Rent</span>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="form-label fs-9 text-muted mb-1">Rental Start Date</label>
                    <input type="date" class="form-control form-control-sm rounded-3 fs-8 fw-semibold" id="checkoutDateInput" onchange="onRentalDurationChanged()">
                </div>
                <div class="col-6">
                    <label class="form-label fs-9 text-muted mb-1">Duration (Days)</label>
                    <div class="d-flex align-items-center justify-content-between border rounded-3 p-1 bg-light">
                        <button type="button" class="btn btn-sm btn-white p-0 rounded-circle border shadow-2xs" style="width:26px; height:26px; background:#fff;" onclick="adjustRentalDays(-1)">
                            <i class="fa-solid fa-minus fs-9"></i>
                        </button>
                        <span class="fw-bold fs-8 text-dark" id="checkoutDaysVal">1</span>
                        <button type="button" class="btn btn-sm btn-white p-0 rounded-circle border shadow-2xs" style="width:26px; height:26px; background:#fff;" onclick="adjustRentalDays(1)">
                            <i class="fa-solid fa-plus fs-9"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-2 rounded-3 bg-light border text-muted fs-9 d-flex align-items-center justify-content-between">
                <span><i class="fa-solid fa-arrow-rotate-left text-secondary me-1"></i> Due Return Date:</span>
                <strong class="text-dark" id="checkoutDueDateText">Tomorrow</strong>
            </div>
        </div>

        <!-- Items Checklist (Screen 5) -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3">
            <h6 class="fw-extrabold text-dark fs-8 mb-2.5">Items</h6>
            <div id="checkoutItemsListContainer" class="d-flex flex-column gap-2">
                <!-- Populated dynamically -->
            </div>
            <div class="pt-2 text-end">
                <a href="javascript:void(0)" class="fs-9 fw-bold text-decoration-none" style="color:#5B3FA8;" onclick="showCartScreen()">View Computation Details</a>
            </div>
        </div>

        <button class="btn btn-primary w-100 py-3 rounded-4 fw-extrabold shadow-sm fs-7" 
                style="background: #5B3FA8; border: none;" onclick="openPaymentScreen()">
            Continue to Payment
        </button>
    </div>

    <!-- VIEW 4C: DIGITAL PAYMENT (Screen 6) -->
    <div id="paymentScreenView" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-3 pb-1">
            <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                    style="width:34px; height:34px; background:#fff;" onclick="openCheckoutScreen()">
                <i class="fa-solid fa-arrow-left text-dark fs-8"></i>
            </button>
            <h5 class="fw-extrabold mb-0 text-dark fs-6">Payment Options</h5>
            <div style="width:34px;"></div>
        </div>

        <!-- Payment Option: Full Payment vs COD with Downpayment -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3">
            <h6 class="fw-extrabold text-dark fs-8 mb-2">Rental Course Payment Plan</h6>
            
            <!-- Plan 1: Full Payment -->
            <div class="form-check p-2.5 rounded-3 mb-2 border d-flex align-items-center border-primary bg-primary-subtle bg-opacity-25" 
                 id="payPlanFullCard" style="cursor:pointer;" onclick="selectPaymentPlan('FULL')">
                <input class="form-check-input ms-0 me-3" type="radio" name="paymentPlanRadio" id="planFull" checked>
                <label class="form-check-label w-100" for="planFull" style="cursor:pointer;">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-dark fs-8"><i class="fa-solid fa-circle-check text-primary me-1.5" style="color:#5B3FA8;"></i> Full Payment (Entire Course)</span>
                        <span class="badge bg-primary text-white fs-9">100% Upfront</span>
                    </div>
                    <div class="text-muted fs-9">Pay the entire rental course upfront. Zero cash needed on delivery.</div>
                </label>
            </div>

            <!-- Plan 2: COD with Downpayment -->
            <div class="form-check p-2.5 rounded-3 border d-flex align-items-center" 
                 id="payPlanCodCard" style="cursor:pointer;" onclick="selectPaymentPlan('DOWNPAYMENT_COD')">
                <input class="form-check-input ms-0 me-3" type="radio" name="paymentPlanRadio" id="planCod">
                <label class="form-check-label w-100" for="planCod" style="cursor:pointer;">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-dark fs-8"><i class="fa-solid fa-hand-holding-dollar text-success me-1.5"></i> COD (Cash on Delivery)</span>
                        <span class="badge bg-warning-subtle text-warning-emphasis fs-9">30% Downpayment</span>
                    </div>
                    <div class="text-muted fs-9">Requires 30% downpayment now to secure equipment. Pay remaining 70% cash on arrival.</div>
                </label>
            </div>
        </div>

        <!-- Payment Method Options (GCash, Card, COD) -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3" id="paymentMethodCard">
            <h6 class="fw-extrabold text-dark fs-8 mb-2.5" id="paymentMethodTitle">Digital Gateway (for Downpayment / Full Payment)</h6>

            <!-- GCash -->
            <div class="form-check p-2.5 rounded-3 mb-2 border d-flex align-items-center border-primary bg-primary-subtle bg-opacity-25" 
                 style="cursor:pointer;" onclick="selectPaymentMethod('GCASH')">
                <input class="form-check-input ms-0 me-3" type="radio" name="paymentRadio" id="payGCash" checked>
                <label class="form-check-label w-100 d-flex align-items-center justify-content-between" for="payGCash" style="cursor:pointer;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-3 text-white fw-bold px-2 py-1" style="background:#005CE6; font-size:0.75rem;">GCash</span>
                        <span class="fw-bold text-dark fs-8">GCash e-Wallet</span>
                    </div>
                    <i class="fa-solid fa-circle-check text-primary fs-7" id="checkGCash"></i>
                </label>
            </div>

            <!-- Credit / Debit Card -->
            <div class="form-check p-2.5 rounded-3 mb-2 border d-flex align-items-center" 
                 style="cursor:pointer;" onclick="selectPaymentMethod('CARD')">
                <input class="form-check-input ms-0 me-3" type="radio" name="paymentRadio" id="payCard">
                <label class="form-check-label w-100 d-flex align-items-center justify-content-between" for="payCard" style="cursor:pointer;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-regular fa-credit-card text-secondary fs-6"></i>
                        <span class="fw-bold text-dark fs-8">Credit / Debit Card</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Order Summary Breakdown (Screen 6) -->
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3">
            <h6 class="fw-extrabold text-dark fs-8 mb-2.5">Order Summary (<span id="payDurationLabel">1 day</span>)</h6>
            <div class="d-flex justify-content-between fs-8 text-secondary mb-1.5">
                <span>Rental Subtotal</span>
                <span class="fw-bold text-dark" id="paySubtotal">₱0</span>
            </div>
            <div class="d-flex justify-content-between fs-8 text-secondary mb-1.5">
                <span>Service Charge</span>
                <span class="fw-bold text-dark" id="payServiceCharge">₱100</span>
            </div>
            <div class="d-flex justify-content-between fs-8 text-secondary mb-1.5">
                <span>Delivery Fee</span>
                <span class="fw-bold text-dark" id="payDeliveryFee">₱150</span>
            </div>
            <div class="d-flex justify-content-between fs-8 text-success mb-2">
                <span>Discount</span>
                <span class="fw-bold text-success" id="payDiscount">- ₱0</span>
            </div>
            <hr class="my-2 border-secondary opacity-25">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-extrabold text-dark fs-7">Total Rental Cost</span>
                <span class="fw-extrabold fs-6" style="color: #5B3FA8;" id="payGrandTotal">₱0</span>
            </div>

            <!-- COD Downpayment Highlight Box -->
            <div id="codDownpaymentBox" style="display:none;" class="p-2.5 rounded-3 bg-warning bg-opacity-10 border border-warning-subtle mt-2">
                <div class="d-flex justify-content-between fs-8 text-warning-emphasis mb-1">
                    <span><i class="fa-solid fa-shield-halved me-1"></i> Downpayment Due Now (30%):</span>
                    <strong class="fs-7" id="payDownpaymentVal">₱0</strong>
                </div>
                <div class="d-flex justify-content-between fs-8 text-dark">
                    <span><i class="fa-solid fa-hand-holding-dollar me-1"></i> Remaining COD Balance:</span>
                    <strong class="text-secondary" id="payBalanceVal">₱0</strong>
                </div>
                <div class="fs-9 text-muted mt-1">Pay 30% downpayment now to secure booking. Pay remaining 70% cash upon arrival.</div>
            </div>
        </div>

        <!-- Pay Now Action Button -->
        <button class="btn btn-primary w-100 py-3 rounded-4 fw-extrabold shadow-sm fs-7" 
                style="background: #5B3FA8; border: none;" id="btnExecutePayment" onclick="executeRentEasePayment()">
            Pay Full Rental (₱0)
        </button>
    </div>

</div>
