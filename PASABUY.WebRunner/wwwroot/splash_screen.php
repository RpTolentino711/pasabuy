<!-- 1. 5-SECOND SPLASH SCREEN (PHP COMPONENT) -->
<div id="splashScreen" style="display:flex; flex-direction:column; align-items:center; justify-content:space-between; position:absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(180deg, #6C5CE7 0%, #5F27CD 50%, #341F97 100%); color:#fff; z-index:9999; padding: 40px 24px; text-align:center; overflow:hidden; cursor:pointer;" onclick="hideSplashScreen()">
    <!-- Top Header Bar inside Splash -->
    <div class="w-100 d-flex justify-content-between align-items-center fs-8 text-white-50">
        <span class="fw-semibold">9:41</span>
        <div class="d-flex gap-2 fs-9 align-items-center">
            <i class="fa-solid fa-signal"></i>
            <i class="fa-solid fa-wifi"></i>
            <i class="fa-solid fa-battery-full"></i>
        </div>
    </div>

    <!-- Main Branding Logo -->
    <div class="my-auto d-flex flex-column align-items-center">
        <div class="bg-white rounded-4 p-3 shadow-lg d-inline-flex align-items-center justify-content-center mb-3" style="width:88px; height:88px;">
            <img src="LOGO.png" alt="PasaBuy Logo" style="width:60px; height:60px; object-fit:contain;" onerror="this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-bag-shopping display-4\' style=\'color:#5F27CD;\'></i>';">
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
        <div class="progress bg-white bg-opacity-25 rounded-pill overflow-hidden mx-auto mb-2" style="height: 6px; max-width: 160px;">
            <div class="progress-bar bg-white rounded-pill" id="splashProgressBar" style="width: 0%; height: 100%; transition: width 0.1s linear;"></div>
        </div>
        <span class="fs-9 text-white-50 d-block" style="font-size:0.68rem;">Tap anywhere to skip...</span>
    </div>
</div>

<script>
(function() {
    let splashProgress = 0;
    let splashInterval = null;
    let splashTimeout = null;

    window.hideSplashScreen = function() {
        if (splashInterval) clearInterval(splashInterval);
        if (splashTimeout) clearTimeout(splashTimeout);
        const splash = document.getElementById('splashScreen');
        const auth = document.getElementById('authScreen');
        if (splash) {
            splash.style.opacity = '0';
            splash.style.transition = 'opacity 0.35s ease';
            setTimeout(function() {
                splash.style.display = 'none';
                const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in');
                if (isLoggedIn !== 'true' && auth) {
                    auth.style.display = 'block';
                }
            }, 350);
        }
    };

    window.initSplashScreen = function() {
        const splash = document.getElementById('splashScreen');
        const auth = document.getElementById('authScreen');
        const bar = document.getElementById('splashProgressBar');
        if (!splash) return;

        const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in');
        if (isLoggedIn === 'true') {
            splash.style.display = 'none';
            if (auth) auth.style.display = 'none';
            return;
        }

        splash.style.display = 'flex';
        splash.style.opacity = '1';
        if (auth) auth.style.display = 'none';

        splashProgress = 0;
        if (bar) bar.style.width = '0%';

        if (splashInterval) clearInterval(splashInterval);
        splashInterval = setInterval(function() {
            splashProgress += 2;
            if (bar) bar.style.width = splashProgress + '%';
            if (splashProgress >= 100) {
                clearInterval(splashInterval);
            }
        }, 100);

        if (splashTimeout) clearTimeout(splashTimeout);
        splashTimeout = setTimeout(function() {
            hideSplashScreen();
        }, 5000);
    };

    if (localStorage.getItem('pasabuy_student_logged_in') !== 'true') {
        setTimeout(initSplashScreen, 10);
    }
})();
</script>
