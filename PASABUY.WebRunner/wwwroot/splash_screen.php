<?php
if (!defined('PASABUY_INCLUDED')) {
    define('PASABUY_INCLUDED', true);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>RentEase - Welcome</title><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" /><style>body { font-family: "Plus Jakarta Sans", sans-serif; background: #0F172A; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; } .app-container { width: 100%; max-width: 440px; height: 880px; background: #1E1B4B; position: relative; overflow: hidden; display: flex; flex-direction: column; border-radius: 40px; border: 8px solid #1E293B; box-shadow: 0 25px 60px rgba(0,0,0,0.6); }</style></head><body><div class="app-container">';
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
@keyframes splashPulseGlow {
    0%, 100% { transform: scale(1); filter: drop-shadow(0 0 10px rgba(255,255,255,0.4)); }
    50% { transform: scale(1.02); filter: drop-shadow(0 0 20px rgba(255,255,255,0.7)); }
}
</style>

<!-- 1. 5-SECOND SPLASH SCREEN (PHP COMPONENT) -->
<div id="splashScreen" style="display:flex; flex-direction:column; align-items:center; justify-content:space-between; position:absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(180deg, #5B3FA8 0%, #341F97 45%, #1E1B4B 100%) !important; color:#fff; z-index:9999; padding: 40px 24px; text-align:center; overflow:hidden; cursor:pointer;" onclick="hideSplashScreen()">
    <!-- Top Spacer to achieve true vertical centering -->
    <div style="height: 30px; width: 100%;"></div>

    <!-- Center Hero Branding (Dead Middle) -->
    <div class="d-flex flex-column align-items-center justify-content-center my-auto">
        <!-- Circular Loading Animation with LOGO.png -->
        <div class="position-relative d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
            <!-- Outer Spinning White Loading Ring -->
            <div class="splash-spinner-ring position-absolute" 
                 style="width: 146px; height: 146px; border-radius: 50%; border: 4px solid rgba(255, 255, 255, 0.2); border-top: 4px solid #ffffff; border-right: 4px solid #ffffff; animation: splashSpin 1.1s linear infinite; box-shadow: 0 0 25px rgba(255, 255, 255, 0.45); pointer-events: none;"></div>
            
            <!-- Secondary Ambient Pulsing Ring -->
            <div class="position-absolute" 
                 style="width: 160px; height: 160px; border-radius: 50%; border: 1.5px dashed rgba(255, 255, 255, 0.35); animation: splashSpinRev 7s linear infinite; pointer-events: none;"></div>

            <!-- Central Clean White Circular Base for Logo with Glow -->
            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-lg" 
                 style="width: 116px; height: 116px; box-shadow: 0 10px 35px rgba(0, 0, 0, 0.4); z-index: 2; animation: splashPulseGlow 2.5s ease-in-out infinite;">
                <img src="LOGO.png" alt="RentEase Logo" 
                     style="width: 80px; height: 80px; object-fit: contain;" 
                     onerror="if (this.src.indexOf('../LOGO.png') === -1) { this.src='../LOGO.png'; } else { this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-chair display-5\' style=\'color:#5B3FA8;\'></i>'; }">
            </div>
        </div>

        <h1 class="fw-extrabold text-white mb-1" style="font-size: 2.3rem; letter-spacing: -0.5px;">RentEase</h1>
        <p class="text-white-50 fs-7 mb-0">Easy Rentals. Seamless Events.</p>
    </div>

    <!-- Bottom Tagline -->
    <div class="w-100 pb-2 text-center" style="opacity: 0.85;">
        <h6 class="fw-bold text-white mb-0.5" style="font-size: 0.88rem;">Rent. Book. Celebrate.</h6>
        <p class="text-white-50 mb-0" style="font-size: 0.72rem;">Quality Equipment for Every Occasion.</p>
    </div>
</div>

<script>
(function() {
    let splashTimeout = null;

    window.hideSplashScreen = function() {
        if (splashTimeout) clearTimeout(splashTimeout);

        // If standalone splash_screen.php, immediately forward to student index.php
        if (window.location.pathname.indexOf('splash_screen.php') !== -1) {
            window.location.href = 'index.php';
            return;
        }

        const splash = document.getElementById('splashScreen');
        const auth = document.getElementById('authScreen');
        const isLoggedIn = localStorage.getItem('pasabuy_student_logged_in') === 'true';

        if (splash) {
            splash.style.opacity = '0';
            splash.style.transition = 'opacity 0.3s ease';
            setTimeout(function() {
                splash.style.setProperty('display', 'none', 'important');
                if (typeof window.checkStudentSessionOnLoad === 'function') {
                    window.checkStudentSessionOnLoad();
                } else if (auth && !isLoggedIn) {
                    auth.style.display = 'block';
                }
                if (typeof switchTab === 'function') {
                    switchTab('home');
                }
            }, 300);
        } else {
            if (typeof window.checkStudentSessionOnLoad === 'function') {
                window.checkStudentSessionOnLoad();
            }
            if (typeof switchTab === 'function') {
                switchTab('home');
            }
        }
    };

    window.initSplashScreen = function() {
        const splash = document.getElementById('splashScreen');
        if (!splash) return;

        splash.style.display = 'flex';
        splash.style.opacity = '1';

        if (splashTimeout) clearTimeout(splashTimeout);
        splashTimeout = setTimeout(function() {
            hideSplashScreen();
        }, 1800);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSplashScreen);
    } else {
        setTimeout(initSplashScreen, 10);
    }
})();
</script>

<?php
if ($is_standalone) {
    echo '</div></body></html>';
}
?>
