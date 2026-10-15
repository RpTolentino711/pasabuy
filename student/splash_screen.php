<?php
if (!defined('PASABUY_INCLUDED')) {
    define('PASABUY_INCLUDED', true);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>PasaBuy - Splash Screen</title><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" /><style>body { font-family: "Plus Jakarta Sans", sans-serif; background: #0F172A; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; } .app-container { width: 100%; max-width: 440px; height: 880px; background: #FFF; position: relative; overflow: hidden; display: flex; flex-direction: column; border-radius: 40px; border: 8px solid #1E293B; }</style></head><body><div class="app-container">';
    $is_standalone = true;
} else {
    $is_standalone = false;
}
?>

<style>
@keyframes splashSpin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes splashSpinRev {
    0% { transform: rotate(360deg); }
    100% { transform: rotate(0deg); }
}
</style>

<!-- 1. 5-SECOND SPLASH SCREEN (PHP COMPONENT) -->
<div id="splashScreen" style="display:flex; flex-direction:column; align-items:center; justify-content:space-between; position:absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(180deg, #5B3FA8 0%, #341F97 50%, #1E1B4B 100%); color:#fff; z-index:9999; padding: 40px 24px; text-align:center; overflow:hidden; cursor:pointer;" onclick="hideSplashScreen()">
    <!-- Main Branding Logo with Rotating White Loading Spinner Ring -->
    <div class="my-auto d-flex flex-column align-items-center">
        <!-- Circular Loading Animation with LOGO.png -->
        <div class="position-relative d-flex align-items-center justify-content-center mb-4" style="width: 140px; height: 140px;">
            <!-- Outer Spinning White Loading Ring -->
            <div class="splash-spinner-ring position-absolute" 
                 style="width: 140px; height: 140px; border-radius: 50%; border: 4px solid rgba(255, 255, 255, 0.15); border-top: 4px solid #ffffff; border-right: 4px solid rgba(255, 255, 255, 0.85); animation: splashSpin 1.1s cubic-bezier(0.5, 0, 0.5, 1) infinite; box-shadow: 0 0 20px rgba(255, 255, 255, 0.35); pointer-events: none;"></div>
            
            <!-- Secondary Ambient Pulsing Ring -->
            <div class="position-absolute" 
                 style="width: 154px; height: 154px; border-radius: 50%; border: 1.5px dashed rgba(255, 255, 255, 0.25); animation: splashSpinRev 8s linear infinite; pointer-events: none;"></div>

            <!-- Central Clean White Circular Base for Logo -->
            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-lg" 
                 style="width: 112px; height: 112px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35); z-index: 2;">
                <img src="LOGO.png" alt="RentEase Logo" 
                     style="width: 76px; height: 76px; object-fit: contain;" 
                     onerror="if (this.src.indexOf('../LOGO.png') === -1) { this.src='../LOGO.png'; } else { this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-chair display-5\' style=\'color:#5B3FA8;\'></i>'; }">
            </div>
        </div>

        <h1 class="fw-extrabold text-white mb-1" style="font-size: 2.3rem; letter-spacing: -0.5px;">RentEase</h1>
        <p class="text-white-50 fs-7 mb-3">Easy Rentals. Seamless Events.</p>

        <!-- Dynamic Status Indicator -->
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);">
            <span class="spinner-grow spinner-grow-sm text-white" role="status" style="width: 7px; height: 7px; animation-duration: 0.9s;"></span>
            <span class="text-white fs-9 fw-semibold" style="letter-spacing: 0.3px;">Loading Campus Hub...</span>
        </div>
    </div>

    <!-- Bottom Tagline & 5-Second Progress Bar -->
    <div class="w-100 mt-auto pt-3 text-center">
        <h5 class="fw-extrabold text-white mb-1">Rent. Book. Celebrate.</h5>
        <p class="text-white-50 fs-7 mb-3">Quality Equipment for Every Occasion.</p>
        
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
        const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in') === 'true';

        if (splash) {
            splash.style.opacity = '0';
            splash.style.transition = 'opacity 0.35s ease';
            setTimeout(function() {
                splash.style.display = 'none';
                if (typeof window.checkAuthState === 'function') {
                    window.checkAuthState();
                } else if (auth && !isLoggedIn) {
                    auth.style.display = 'block';
                }
            }, 350);
        } else if (typeof window.checkAuthState === 'function') {
            window.checkAuthState();
        }
    };

    window.initSplashScreen = function() {
        const splash = document.getElementById('splashScreen');
        const bar = document.getElementById('splashProgressBar');
        if (!splash) return;

        splash.style.display = 'flex';
        splash.style.opacity = '1';

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
        }, 3000);
    };

    setTimeout(initSplashScreen, 10);
})();
</script>

<?php
if ($is_standalone) {
    echo '</div></body></html>';
}
?>
