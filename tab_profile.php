<!-- ==========================================================
     RentEase Screen 8: User Profile & Lender Portfolio
     Displays:
     1. User Profile Card (Romeo Paolo Tolentino) + Settings Gear
     2. "My Rental Listings" - items user has posted for rent
        (All account settings/orders/history/addresses are in Settings Hub)
     ========================================================== -->
<div id="tabProfile" style="display:none;" class="pb-5">

    <!-- User Profile Card with Settings Gear -->
    <div class="card border-0 rounded-4 shadow-sm p-3.5 bg-white mb-3 d-flex flex-row align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" 
                     class="rounded-circle border border-2 border-white shadow-2xs" width="52" height="52" style="object-fit:cover;" id="profileAvatar" alt="Romeo Paolo Tolentino">
                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width:12px; height:12px;"></span>
            </div>
            <div>
                <h6 class="fw-extrabold text-dark fs-7 mb-0" id="profileName">Romeo Paolo Tolentino</h6>
                <div class="text-muted fs-8" id="profileSub">BSIT • 4th Yr</div>
                <div class="text-muted fs-9" style="font-size:0.7rem;" id="profileStudentNumber">Student ID: 09668257301</div>
                <div class="text-muted fs-9 d-none" id="profileEmail">09668257301</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                    style="width:38px; height:38px; background:#F8FAFC; border:1px solid #E2E8F0;" 
                    onclick="openSettingsHubModal()" title="Account & Settings Hub">
                <i class="fa-solid fa-gear text-secondary fs-7"></i>
            </button>
        </div>
    </div>

    <!-- My Rental Equipment Section Header -->
    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
        <div class="d-flex align-items-center gap-2">
            <h6 class="fw-extrabold text-dark fs-7 mb-0">
                <i class="fa-solid fa-boxes-stacked me-1" style="color:#5B3FA8;"></i> My Rental Listings
            </h6>
            <span class="badge rounded-pill bg-primary-subtle text-primary fw-bold fs-9" id="myRentalCountBadge">0</span>
        </div>
        <button class="btn btn-sm btn-primary rounded-pill px-3 py-1.5 fw-bold fs-8 d-flex align-items-center gap-1 shadow-2xs" 
                style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" 
                onclick="switchTab('sell')">
            <i class="fa-solid fa-plus fs-9"></i> Post Equipment
        </button>
    </div>

    <!-- Dynamic Equipment Listings Container (Items posted for rent) -->
    <div id="myRentalListingsContainer" class="d-flex flex-column gap-3 pb-3">
        <!-- Populated dynamically via loadUserRentedOutItems() -->
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
    </div>

</div>

