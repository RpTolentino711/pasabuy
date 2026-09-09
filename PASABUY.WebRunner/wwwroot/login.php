<?php
if (!defined('PASABUY_INCLUDED')) {
    define('PASABUY_INCLUDED', true);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>PasaBuy - Sign In</title><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" /><style>body { font-family: "Plus Jakarta Sans", sans-serif; background: #0F172A; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; } .app-container { width: 100%; max-width: 440px; height: 880px; background: #FFF; position: relative; overflow-y: auto; display: flex; flex-direction: column; border-radius: 40px; border: 8px solid #1E293B; padding: 16px; }</style></head><body><div class="app-container">';
    $is_standalone = true;
} else {
    $is_standalone = false;
}
?>

<!-- 2. WELCOME BACK / LOGIN SCREEN (PHP COMPONENT) -->
<div id="authScreen" style="<?php echo $is_standalone ? 'display:block;' : 'display:none;'; ?>">
    <div class="text-center p-4 bg-white rounded-4 border shadow-sm my-2">
        <div class="mb-3 text-center">
            <div class="bg-primary bg-opacity-10 text-primary rounded-4 p-2.5 d-inline-flex align-items-center justify-content-center shadow-sm mb-2" style="width:64px; height:64px;">
                <img src="LOGO.png" alt="PasaBuy Logo" style="width:42px; height:42px; object-fit:contain;" onerror="this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-bag-shopping fs-2\' style=\'color:#5F27CD;\'></i>';">
            </div>
            <h4 class="fw-extrabold text-dark mb-0">PasaBuy</h4>
            <p class="text-muted fs-8">Your Campus, Your Marketplace</p>
        </div>

        <h5 class="fw-extrabold text-dark mb-1">Welcome Back!</h5>
        <p class="text-muted fs-8 mb-4">Sign in to continue</p>

        <!-- Failed Attempt Banner -->
        <div id="failedAttemptBanner"
            class="p-3 bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-3 fs-8 mb-3 text-start"
            style="display:none;">
            <i class="fa-solid fa-shield-exclamation me-1"></i> <strong id="failedAttemptMsg">Invalid credentials.</strong>
        </div>

        <div class="text-start mb-3">
            <label class="form-label fw-bold fs-8 text-secondary">Email Address</label>
            <input type="email" class="form-control rounded-3 py-2.5 px-3 fs-7" id="loginEmailInput"
                placeholder="you@school.edu.ph" value=""
                onkeydown="if(event.key==='Enter') loginStudentWithPassword()">
        </div>

        <div class="text-start mb-3">
            <label class="form-label fw-bold fs-8 text-secondary d-flex justify-content-between">
                <span>Password</span>
            </label>
            <div class="input-group">
                <input type="password" class="form-control border-end-0 rounded-start-3 py-2.5 px-3 fs-7"
                    id="loginPasswordInput" placeholder="••••••••" value=""
                    onkeydown="if(event.key==='Enter') loginStudentWithPassword()">
                <button type="button"
                    class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white"
                    onclick="togglePasswordVisibility('loginPasswordInput', 'loginEyeIcon')">
                    <i class="fa-solid fa-eye text-muted" id="loginEyeIcon"></i>
                </button>
            </div>
            <div class="text-end mt-1.5">
                <a href="javascript:void(0)" class="text-decoration-none fs-8 text-primary fw-bold"
                    onclick="openForgotPasswordModal(); return false;">Forgot Password?</a>
            </div>
        </div>

        <button class="btn btn-primary w-100 rounded-3 py-3 fw-bold fs-7 shadow-sm mb-3 text-white" 
            style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none;" 
            id="btnLoginSubmit" onclick="loginStudentWithPassword()">
            Sign In
        </button>

        <div class="d-flex align-items-center my-3 text-muted fs-8">
            <hr class="flex-grow-1 my-0"><span class="px-2 fw-semibold text-secondary">OR</span><hr class="flex-grow-1 my-0">
        </div>

        <!-- Social Login Buttons -->
        <button class="btn btn-outline-secondary w-100 rounded-3 py-2.5 fs-8 fw-semibold mb-2 d-flex align-items-center justify-content-center gap-2" 
            onclick="quickFillRomeoCredentials()">
            <i class="fa-brands fa-google text-danger fs-6"></i> Continue with Google
        </button>
        <button class="btn btn-outline-secondary w-100 rounded-3 py-2.5 fs-8 fw-semibold mb-3 d-flex align-items-center justify-content-center gap-2" 
            onclick="quickFillRomeoCredentials()">
            <i class="fa-brands fa-facebook text-primary fs-6"></i> Continue with Facebook
        </button>

        <div class="pt-2 text-center fs-8 text-muted">
            Don't have an account? 
            <a href="create_account.php" class="text-primary fw-bold text-decoration-none ms-1">Sign Up</a>
        </div>
    </div>
</div>

<?php
if ($is_standalone) {
    echo '</div></body></html>';
}
?>
