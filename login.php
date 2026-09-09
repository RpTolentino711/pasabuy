<?php
if (!defined('PASABUY_INCLUDED')) {
    define('PASABUY_INCLUDED', true);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>PasaBuy - Sign In</title><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" /><style>body { font-family: "Plus Jakarta Sans", sans-serif; background: #0F172A; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; } .app-container { width: 100%; max-width: 440px; height: 880px; background: #FFF; position: relative; overflow-y: auto; display: flex; flex-direction: column; border-radius: 40px; border: 8px solid #1E293B; padding: 24px 20px; }</style></head><body><div class="app-container">';
    $is_standalone = true;
} else {
    $is_standalone = false;
}
?>

<!-- 2. WELCOME BACK / LOGIN SCREEN (PHP COMPONENT - MATCHING REFERENCE DESIGN) -->
<div id="authScreen" style="<?php echo $is_standalone ? 'display:block;' : 'display:none;'; ?>" class="py-2">
    <!-- Top Status Bar (9:41) -->
    <div class="w-100 d-flex justify-content-between align-items-center fs-8 text-muted mb-4 px-1">
        <span class="fw-bold text-dark">9:41</span>
        <div class="d-flex gap-2 fs-9 align-items-center text-dark">
            <i class="fa-solid fa-signal"></i>
            <i class="fa-solid fa-wifi"></i>
            <i class="fa-solid fa-battery-full"></i>
        </div>
    </div>

    <!-- Main Branding Header (Exact Match to Reference UI) -->
    <div class="text-center mb-4 pt-2">
        <div class="d-inline-block mb-2">
            <i class="fa-solid fa-bag-shopping" style="font-size: 3.8rem; color: #6C5CE7;"></i>
        </div>
        <h2 class="fw-extrabold mb-1" style="color: #2D0C57; font-size: 2.1rem; letter-spacing: -0.6px;">PasaBuy</h2>
        <p class="text-muted fs-8 fw-semibold mb-0" style="color: #7A869A !important;">Your Campus, Your Marketplace</p>
    </div>

    <!-- Welcome Back Subheader -->
    <div class="text-center mb-4">
        <h4 class="fw-extrabold text-dark mb-1" style="font-size: 1.4rem;">Welcome Back!</h4>
        <p class="text-muted fs-8 mb-0" style="color: #64748B !important;">Sign in to continue</p>
    </div>

    <!-- Failed Attempt Banner -->
    <div id="failedAttemptBanner"
        class="p-3 bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-3 fs-8 mb-3 text-start"
        style="display:none;">
        <i class="fa-solid fa-shield-exclamation me-1"></i> <strong id="failedAttemptMsg">Invalid credentials.</strong>
    </div>

    <!-- Email Input -->
    <div class="text-start mb-3">
        <label class="form-label fw-bold fs-8 text-secondary mb-1.5" style="color: #475569 !important;">Email Address</label>
        <input type="email" class="form-control rounded-3 py-2.5 px-3 fs-7 border-1" id="loginEmailInput"
            style="background: #F8FAFC; border-color: #E2E8F0;"
            placeholder="you@school.edu.ph" value=""
            onkeydown="if(event.key==='Enter') loginStudentWithPassword()">
    </div>

    <!-- Password Input -->
    <div class="text-start mb-3">
        <label class="form-label fw-bold fs-8 text-secondary mb-1.5" style="color: #475569 !important;">Password</label>
        <div class="input-group">
            <input type="password" class="form-control border-end-0 rounded-start-3 py-2.5 px-3 fs-7"
                style="background: #F8FAFC; border-color: #E2E8F0;"
                id="loginPasswordInput" placeholder="••••••••" value=""
                onkeydown="if(event.key==='Enter') loginStudentWithPassword()">
            <button type="button"
                class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white"
                style="border-color: #E2E8F0;"
                onclick="togglePasswordVisibility('loginPasswordInput', 'loginEyeIcon')">
                <i class="fa-solid fa-eye text-muted fs-7" id="loginEyeIcon"></i>
            </button>
        </div>
        <div class="text-end mt-2">
            <a href="javascript:void(0)" class="text-decoration-none fs-8 fw-bold" style="color: #6C5CE7;"
                onclick="openForgotPasswordModal(); return false;">Forgot Password?</a>
        </div>
    </div>

    <!-- Sign In Button -->
    <button class="btn btn-primary w-100 rounded-3 py-3 fw-bold fs-7 shadow-sm mb-4 text-white" 
        style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none; border-radius: 14px !important;" 
        id="btnLoginSubmit" onclick="loginStudentWithPassword()">
        Sign In
    </button>

    <!-- Sign Up Link -->
    <div class="pt-2 text-center fs-8 text-muted">
        Don't have an account? 
        <a href="javascript:void(0)" class="fw-bold text-decoration-none ms-1" style="color: #6C5CE7;" onclick="showRegisterScreen()">Sign Up</a>
    </div>
</div>

<?php
if ($is_standalone) {
    echo '</div></body></html>';
}
?>
