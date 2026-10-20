<?php
if (!defined('PASABUY_INCLUDED')) {
    define('PASABUY_INCLUDED', true);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>RentEase - Create Account</title><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" /><style>body { font-family: "Plus Jakarta Sans", sans-serif; background: #0F172A; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; } .app-container { width: 100%; max-width: 440px; height: 880px; background: #FFF; position: relative; overflow-y: auto; display: flex; flex-direction: column; border-radius: 40px; border: 8px solid #1E293B; padding: 24px 20px; }</style></head><body><div class="app-container">';
    $is_standalone = true;
} else {
    $is_standalone = false;
}
?>

<!-- 3. CREATE AN ACCOUNT / REGISTER SCREEN (RENTEASE) -->
<div id="registerScreen" style="<?php echo $is_standalone ? 'display:block;' : 'display:none;'; ?>">
    <div class="p-2 position-relative">
        <!-- Back Button -->
        <button type="button" class="btn btn-light rounded-circle position-absolute top-0 start-0 border-0 shadow-2xs d-flex align-items-center justify-content-center" style="width:38px; height:38px;" onclick="window.location.href='login.php'">
            <i class="fa-solid fa-arrow-left text-dark fs-7"></i>
        </button>

        <!-- Official RentEase Logo and Branding Header -->
        <div class="text-center mb-3 pt-1">
            <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-4 mb-2 shadow-sm" style="background: rgba(91, 63, 168, 0.08); width: 80px; height: 80px;">
                <img src="LOGO.png" alt="RentEase Logo" style="width: 56px; height: 56px; object-fit: contain;" onerror="this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-boxes-packing fs-2\' style=\'color:#5B3FA8;\'></i>';">
            </div>
            <h2 class="fw-extrabold mb-1" style="color: #5B3FA8; font-size: 2rem; letter-spacing: -0.6px;">RentEase</h2>
            <p class="text-muted fs-8 fw-semibold mb-0" style="color: #7A869A !important;">Easy Rentals. Seamless Events.</p>
        </div>

        <!-- Create Account Subheader -->
        <div class="text-center mb-3">
            <h4 class="fw-extrabold text-dark mb-1" style="font-size: 1.35rem;">Create an Account</h4>
            <p class="text-muted fs-8 mb-0" style="color: #64748B !important;">Join our campus rental marketplace</p>
        </div>

        <!-- Error Alert Banner -->
        <div id="regErrorAlert" class="p-2.5 bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-3 fs-8 mb-3 text-start" style="display:none;">
            <i class="fa-solid fa-circle-exclamation me-1"></i> <span id="regErrorMsg">Please check your details.</span>
        </div>

        <!-- Full Name -->
        <div class="text-start mb-2.5">
            <label class="form-label fw-bold fs-8 text-secondary mb-1" style="color: #475569 !important;">Full Name</label>
            <input type="text" class="form-control rounded-3 py-2 px-3 fs-7 border-1" id="regFullName"
                style="background: #F8FAFC; border-color: #E2E8F0;" placeholder="Juan Dela Cruz">
        </div>

        <!-- School Email -->
        <div class="text-start mb-2.5">
            <label class="form-label fw-bold fs-8 text-secondary mb-1" style="color: #475569 !important;">School Email</label>
            <input type="email" class="form-control rounded-3 py-2 px-3 fs-7 border-1" id="regEmail"
                style="background: #F8FAFC; border-color: #E2E8F0;" placeholder="you@school.edu.ph">
        </div>

        <!-- Password -->
        <div class="text-start mb-2.5">
            <label class="form-label fw-bold fs-8 text-secondary mb-1" style="color: #475569 !important;">Password</label>
            <div class="input-group">
                <input type="password" class="form-control border-end-0 rounded-start-3 py-2 px-3 fs-7" id="regPassword"
                    style="background: #F8FAFC; border-color: #E2E8F0;" placeholder="At least 6 characters">
                <button type="button" class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white"
                    style="border-color: #E2E8F0;" onclick="togglePasswordVisibility('regPassword', 'regEyeIcon2')">
                    <i class="fa-solid fa-eye text-muted fs-7" id="regEyeIcon2"></i>
                </button>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="text-start mb-2.5">
            <label class="form-label fw-bold fs-8 text-secondary mb-1" style="color: #475569 !important;">Confirm Password</label>
            <div class="input-group">
                <input type="password" class="form-control border-end-0 rounded-start-3 py-2 px-3 fs-7" id="regConfirmPassword"
                    style="background: #F8FAFC; border-color: #E2E8F0;" placeholder="Repeat your password">
                <button type="button" class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white"
                    style="border-color: #E2E8F0;" onclick="togglePasswordVisibility('regConfirmPassword', 'regConfirmEyeIcon2')">
                    <i class="fa-solid fa-eye text-muted fs-7" id="regConfirmEyeIcon2"></i>
                </button>
            </div>
        </div>

        <!-- Terms and Conditions Checkbox -->
        <div class="form-check text-start mb-3">
            <input class="form-check-input" type="checkbox" id="regAgreeTerms" checked>
            <label class="form-check-label fs-8 text-muted" for="regAgreeTerms">
                I agree to the <a href="javascript:void(0)" class="fw-bold text-decoration-none" style="color: #5B3FA8;" onclick="alert('📋 RentEase Terms: Campus equipment rental registration requires valid student credentials.')">Terms and Conditions</a>
            </label>
        </div>

        <!-- Sign Up Button -->
        <button class="btn btn-primary w-100 rounded-3 py-3 fw-bold fs-7 shadow-sm mb-3 text-white" 
            style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none; border-radius: 14px !important;" 
            id="btnSignUp"
            onclick="submitRegistrationSendOtpScreen()">
            Sign Up
        </button>

        <!-- Sign In Link -->
        <div class="pt-1 text-center fs-8 text-muted">
            Already have an account? 
            <a href="login.php" class="fw-bold text-decoration-none ms-1" style="color: #5B3FA8;">Sign In</a>
        </div>
    </div>
</div>

<!-- OTP VERIFICATION MODAL (RENTEASE) -->
<div class="modal fade" id="otpVerifyModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4 shadow-lg text-center position-relative overflow-hidden">
            <div style="height:6px; background: linear-gradient(90deg, #5B3FA8, #341F97, #6C5CE7); position:absolute; top:0; left:0; right:0;"></div>

            <div class="modal-body py-2">
                <div class="mb-3 position-relative d-inline-block">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm"
                        style="width:72px; height:72px; background: rgba(91, 63, 168, 0.1); color: #5B3FA8;">
                        <i class="fa-solid fa-paper-plane fs-2"></i>
                    </div>
                    <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center border border-2 border-white shadow-sm"
                        style="width:26px; height:26px; font-size:11px;">
                        <i class="fa-solid fa-check"></i>
                    </span>
                </div>

                <h5 class="fw-extrabold text-dark mb-1">OTP Verification Code Sent!</h5>
                <p class="fs-8 text-muted mb-3">We sent a 6-digit security code to <br><strong
                        class="fs-7" style="color: #5B3FA8;" id="otpTargetEmail">user@school.edu.ph</strong>
                </p>

                <!-- OTP Code Input Box -->
                <div class="p-3 bg-light rounded-4 border mb-3">
                    <label class="form-label fw-bold fs-8 text-uppercase text-muted tracking-wider mb-2">Enter
                        6-Digit Verification Code</label>
                    <input type="text"
                        class="form-control text-center fw-extrabold fs-2 rounded-3 border-2 bg-white shadow-sm"
                        id="otpInputCode" maxlength="6" placeholder="0 0 0 0 0 0"
                        style="letter-spacing: 10px; font-family: monospace; border-color: #5B3FA8 !important;"
                        onkeydown="if(event.key==='Enter') verifyOtpAndCompleteRegistration()">
                    <span class="fs-9 text-muted mt-2 d-block"><i
                            class="fa-solid fa-clock-rotate-left me-1 text-warning"></i> Code expires in <strong
                            class="text-dark">10 minutes</strong></span>
                </div>

                <div id="otpVerifyErrorAlert" class="alert alert-danger rounded-3 fs-8 p-2 mb-3"
                    style="display:none;"></div>

                <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold py-2.5 fs-7 shadow-sm mb-2 text-white"
                    style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;"
                    id="btnVerifyOtpSubmit"
                    onclick="verifyOtpAndCompleteRegistration()"><i class="fa-solid fa-shield-check me-1"></i>
                    Verify OTP & Complete Registration</button>
                <button type="button" class="btn btn-light w-100 rounded-pill text-muted fs-8 fw-semibold"
                    data-bs-dismiss="modal">Cancel Registration</button>
            </div>
        </div>
    </div>
</div>

<!-- OTP SUCCESS / VERIFIED MODAL -->
<div class="modal fade" id="otpSuccessModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4 shadow-lg text-center position-relative overflow-hidden">
            <div style="height:6px; background: linear-gradient(90deg, #10B981, #059669, #34D399); position:absolute; top:0; left:0; right:0;"></div>
            <div class="modal-body py-3">
                <div class="mb-3 position-relative d-inline-block">
                    <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width:76px; height:76px;">
                        <i class="fa-solid fa-circle-check fs-1 text-success"></i>
                    </div>
                </div>
                <h4 class="fw-extrabold text-dark mb-1">OTP Verified Successfully!</h4>
                <p class="fs-7 text-muted mb-3">Your RentEase student account has been created successfully.</p>
                
                <div class="p-3 bg-light rounded-4 border mb-3">
                    <div class="d-flex align-items-center justify-content-center gap-2 text-primary fw-semibold fs-8" style="color: #5B3FA8 !important;">
                        <i class="fa-solid fa-spinner fa-spin"></i>
                        <span>Auto-directing to login field in <strong id="otpSuccessCountdown">2</strong> seconds...</span>
                    </div>
                </div>

                <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold py-2.5 fs-7 shadow-sm text-white" 
                    style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" 
                    onclick="proceedToLoginAfterOtpSuccess()">
                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Proceed to Login Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let otpVerifyModalInstance = null;
let otpSuccessModalInstance = null;
let pendingRegistrationEmail = '';
let pendingRegistrationData = {};
let otpRedirectTimer = null;

if (typeof window.togglePasswordVisibility !== 'function') {
    window.togglePasswordVisibility = function (inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (!input) return;
        if (input.type === 'password' || input.getAttribute('type') === 'password') {
            input.setAttribute('type', 'text');
            input.type = 'text';
            if (icon) {
                icon.className = 'fa-solid fa-eye-slash fs-7';
                icon.style.color = '#5B3FA8';
            }
        } else {
            input.setAttribute('type', 'password');
            input.type = 'password';
            if (icon) {
                icon.className = 'fa-solid fa-eye text-muted fs-7';
                icon.style.color = '';
            }
        }
    };
}

window.submitRegistrationSendOtpScreen = async function () {
    const fullName = (document.getElementById('regFullName')?.value || '').trim();
    const email = (document.getElementById('regEmail')?.value || '').trim();
    const password = (document.getElementById('regPassword')?.value || '').trim();
    const confirmPassword = (document.getElementById('regConfirmPassword')?.value || '').trim();
    const agreeTerms = document.getElementById('regAgreeTerms')?.checked;
    const btnSignUp = document.getElementById('btnSignUp');
    const alertBox = document.getElementById('regErrorAlert');
    const alertMsg = document.getElementById('regErrorMsg');

    const showError = (msg) => {
        if (alertBox && alertMsg) {
            alertMsg.innerText = msg;
            alertBox.style.display = 'block';
        } else {
            alert(msg);
        }
    };

    if (alertBox) alertBox.style.display = 'none';

    if (!fullName) {
        showError('Please enter your Full Name.');
        return;
    }
    if (!email) {
        showError('Please enter your School Email.');
        return;
    }
    if (!password || password.length < 6) {
        showError('Password must be at least 6 characters.');
        return;
    }
    if (password !== confirmPassword) {
        showError('Password and Confirm Password do not match.');
        return;
    }
    if (!agreeTerms) {
        showError('Please agree to the Terms and Conditions to proceed.');
        return;
    }

    const nameParts = fullName.split(' ');
    const firstName = nameParts[0] || 'Student';
    const lastName = nameParts.slice(1).join(' ') || '';

    pendingRegistrationEmail = email;
    pendingRegistrationData = {
        firstName: firstName,
        lastName: lastName,
        email: email,
        studentNumber: '2026-' + Math.floor(1000 + Math.random() * 9000),
        course: 'BSIT',
        yearLevel: '1st Yr',
        password: password
    };

    try {
        if (btnSignUp) {
            btnSignUp.disabled = true;
            btnSignUp.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Sending OTP...';
        }

        const res = await fetch('/pasabuy_otp.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'send_otp',
                email: email,
                name: fullName,
                password: password,
                firstName: firstName,
                lastName: lastName
            })
        });

        const data = await res.json();
        if (btnSignUp) {
            btnSignUp.disabled = false;
            btnSignUp.innerText = 'Sign Up';
        }

        if (res.ok && data.success) {
            const emailTargetEl = document.getElementById('otpTargetEmail');
            if (emailTargetEl) emailTargetEl.innerText = email;

            const inputEl = document.getElementById('otpInputCode');
            if (inputEl) inputEl.value = '';

            const errEl = document.getElementById('otpVerifyErrorAlert');
            if (errEl) errEl.style.display = 'none';

            const otpModalEl = document.getElementById('otpVerifyModal');
            if (otpModalEl && otpModalEl.parentElement !== document.body) {
                document.body.appendChild(otpModalEl);
            }
            if (!otpVerifyModalInstance) {
                otpVerifyModalInstance = new bootstrap.Modal(otpModalEl);
            }
            otpVerifyModalInstance.show();
        } else {
            showError(data.message || '❌ Could not send OTP code to this email address.');
        }
    } catch (e) {
        if (btnSignUp) {
            btnSignUp.disabled = false;
            btnSignUp.innerText = 'Sign Up';
        }
        showError('Connection error sending OTP code. Please try again.');
    }
};

window.verifyOtpAndCompleteRegistration = async function () {
    const code = (document.getElementById('otpInputCode')?.value || '').trim();
    const btnVerify = document.getElementById('btnVerifyOtpSubmit');
    const errEl = document.getElementById('otpVerifyErrorAlert');

    if (!code || code.length !== 6) {
        if (errEl) {
            errEl.innerText = 'Please enter the 6-digit OTP code sent to your email.';
            errEl.style.display = 'block';
        } else {
            alert('Please enter the 6-digit OTP code sent to your email.');
        }
        return;
    }

    if (errEl) errEl.style.display = 'none';

    try {
        if (btnVerify) {
            btnVerify.disabled = true;
            btnVerify.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Verifying...';
        }

        const res = await fetch('/pasabuy_otp.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'verify_otp',
                email: pendingRegistrationEmail,
                otpCode: code
            })
        });

        const data = await res.json();
        if (btnVerify) {
            btnVerify.disabled = false;
            btnVerify.innerHTML = '<i class="fa-solid fa-shield-check me-1"></i> Verify OTP & Complete Registration';
        }

        if (res.ok && data.success) {
            // Hide the OTP input modal
            if (otpVerifyModalInstance) {
                otpVerifyModalInstance.hide();
            }

            // Save registered email to localStorage so login screen can read it
            if (pendingRegistrationEmail) {
                localStorage.setItem('rentease_registered_email', pendingRegistrationEmail);
            }

            // Show the OTP Success Modal
            const successModalEl = document.getElementById('otpSuccessModal');
            if (successModalEl && successModalEl.parentElement !== document.body) {
                document.body.appendChild(successModalEl);
            }
            if (!otpSuccessModalInstance) {
                otpSuccessModalInstance = new bootstrap.Modal(successModalEl);
            }
            otpSuccessModalInstance.show();

            // Auto-direct to the login field after countdown
            let secondsLeft = 2;
            const countdownEl = document.getElementById('otpSuccessCountdown');
            if (countdownEl) countdownEl.innerText = secondsLeft;

            if (otpRedirectTimer) clearInterval(otpRedirectTimer);
            otpRedirectTimer = setInterval(() => {
                secondsLeft--;
                if (countdownEl) countdownEl.innerText = secondsLeft;
                if (secondsLeft <= 0) {
                    clearInterval(otpRedirectTimer);
                    proceedToLoginAfterOtpSuccess();
                }
            }, 1000);

        } else {
            if (errEl) {
                errEl.innerText = data.message || '❌ Invalid or expired OTP verification code.';
                errEl.style.display = 'block';
            } else {
                alert(data.message || '❌ Invalid or expired OTP verification code.');
            }
        }
    } catch (e) {
        if (btnVerify) {
            btnVerify.disabled = false;
            btnVerify.innerHTML = '<i class="fa-solid fa-shield-check me-1"></i> Verify OTP & Complete Registration';
        }
        if (errEl) {
            errEl.innerText = 'Connection error verifying OTP. Please try again.';
            errEl.style.display = 'block';
        } else {
            alert('Connection error verifying OTP.');
        }
    }
};

window.proceedToLoginAfterOtpSuccess = function () {
    if (otpRedirectTimer) clearInterval(otpRedirectTimer);
    if (otpSuccessModalInstance) otpSuccessModalInstance.hide();

    const email = pendingRegistrationEmail || localStorage.getItem('rentease_registered_email') || '';

    // If on a standalone page, redirect directly to login.php with the registered email query param
    if (window.location.pathname.includes('create_account.php') || !document.getElementById('authScreen')) {
        window.location.href = 'login.php' + (email ? '?email=' + encodeURIComponent(email) : '');
    } else {
        // If embedded inside index.php
        const regScreen = document.getElementById('registerScreen');
        const authScreen = document.getElementById('authScreen');
        if (regScreen) regScreen.style.display = 'none';
        if (authScreen) authScreen.style.display = 'block';

        const emailField = document.getElementById('loginEmailInput') || document.getElementById('loginEmail');
        if (emailField && email) {
            emailField.value = email;
            emailField.style.borderColor = '#10B981';
            emailField.style.backgroundColor = '#F0FDF4';
            setTimeout(() => {
                emailField.style.borderColor = '#E2E8F0';
                emailField.style.backgroundColor = '#F8FAFC';
            }, 3000);
        }

        const successBanner = document.getElementById('regSuccessBanner');
        if (successBanner) successBanner.style.display = 'block';

        const passField = document.getElementById('loginPasswordInput') || document.getElementById('loginPassword');
        if (passField) passField.focus();
    }
};
</script>

<?php
if ($is_standalone) {
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>';
    echo '</div></body></html>';
}
?>
