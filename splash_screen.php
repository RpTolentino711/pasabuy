<!-- 1. 5-SECOND SPLASH SCREEN (PHP COMPONENT) -->
<div id="splashScreen" style="display:flex; flex-direction:column; align-items:center; justify-content:space-between; position:absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(180deg, #6C5CE7 0%, #5F27CD 50%, #341F97 100%); color:#fff; z-index:9999; padding: 40px 24px; text-align:center; overflow:hidden;" onclick="hideSplashScreen()">
    <!-- Top Header Bar inside Splash -->
    <div class="w-100 d-flex justify-content-between align-items-center fs-8 text-white-50">
        <span class="fw-semibold">9:41</span>
        <div class="d-flex gap-1 fs-9"><i class="fa-solid fa-signal"></i><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
    </div>

    <!-- Main Branding Logo -->
    <div class="my-auto d-flex flex-column align-items-center">
        <div class="bg-white rounded-4 p-3 shadow-lg d-inline-flex align-items-center justify-content-center mb-3" style="width:84px; height:84px;">
            <i class="fa-solid fa-bag-shopping display-4" style="color: #5F27CD;"></i>
        </div>
        <h1 class="fw-extrabold text-white mb-1" style="font-size: 2.4rem; letter-spacing: -0.5px;">PasaBuy</h1>
        <p class="text-white-50 fs-7 mb-4">Your Campus, Your Marketplace</p>

        <!-- Campus Student Illustration -->
        <div class="my-3 px-2 w-100">
            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&q=80" 
                class="img-fluid rounded-4 shadow-lg border border-2 border-white border-opacity-25" 
                style="max-height: 200px; width:100%; object-fit:cover;">
        </div>
    </div>

    <!-- Bottom Tagline & 5-Second Progress Bar -->
    <div class="w-100 mt-auto pt-3 text-center">
        <h5 class="fw-extrabold text-white mb-1">Buy. Sell. Connect.</h5>
        <p class="text-white-50 fs-7 mb-3">All in One Place.</p>
        
        <!-- 5-Second Progress Bar -->
        <div class="progress bg-white bg-opacity-25 rounded-pill overflow-hidden mx-auto" style="height: 4px; max-width: 140px;">
            <div class="progress-bar bg-white" id="splashProgressBar" style="width: 0%; transition: width 0.1s linear;"></div>
        </div>
        <span class="fs-9 text-white-50 mt-2 d-block" style="font-size:0.68rem;">Tap anywhere to skip...</span>
    </div>
</div>
