<?php
if (!defined('PASABUY_INCLUDED')) {
    define('PASABUY_INCLUDED', true);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>PasaBuy - Splash Screen</title><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" /><style>body { font-family: "Plus Jakarta Sans", sans-serif; background: #0F172A; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; } .app-container { width: 100%; max-width: 440px; height: 880px; background: #FFF; position: relative; overflow: hidden; display: flex; flex-direction: column; border-radius: 40px; border: 8px solid #1E293B; }</style></head><body><div class="app-container">';
    $is_standalone = true;
} else {
    $is_standalone = false;
}
?>

<!-- 1. 5-SECOND SPLASH SCREEN (PHP COMPONENT) -->
<div id="splashScreen" style="display:flex; flex-direction:column; align-items:center; justify-content:space-between; position:absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(180deg, #6C5CE7 0%, #5F27CD 50%, #341F97 100%); color:#fff; z-index:9999; padding: 40px 24px; text-align:center; overflow:hidden; cursor:pointer;" onclick="hideSplashScreen()">
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
        if (splash) {
            splash.style.opacity = '0';
            splash.style.transition = 'opacity 0.35s ease';
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 350);
        } else {
            window.location.href = 'index.php';
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
