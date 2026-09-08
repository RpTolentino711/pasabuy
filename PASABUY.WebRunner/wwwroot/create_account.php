<!-- 3. CREATE AN ACCOUNT / REGISTER SCREEN (PHP COMPONENT) -->
<div id="registerScreen" style="display:none;">
    <div class="text-center p-4 bg-white rounded-4 border shadow-sm my-2 position-relative">
        <button type="button" class="btn btn-light rounded-circle position-absolute top-0 start-0 m-3 border-0 shadow-2xs d-flex align-items-center justify-content-center" style="width:36px; height:36px;" onclick="showLoginScreen()">
            <i class="fa-solid fa-arrow-left text-dark fs-7"></i>
        </button>

        <div class="mb-3 text-center pt-2">
            <div class="bg-primary bg-opacity-10 text-primary rounded-4 p-2.5 d-inline-flex align-items-center justify-content-center shadow-sm mb-2" style="width:58px; height:58px;">
                <img src="LOGO.png" alt="PasaBuy Logo" style="width:38px; height:38px; object-fit:contain;" onerror="this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-bag-shopping fs-3\' style=\'color:#5F27CD;\'></i>';">
            </div>
            <h4 class="fw-extrabold text-dark mb-0">PasaBuy</h4>
            <p class="text-muted fs-8">Your Campus, Your Marketplace</p>
        </div>

        <h5 class="fw-extrabold text-dark mb-1">Create an Account</h5>
        <p class="text-muted fs-8 mb-4">Join our campus marketplace</p>

        <div class="text-start mb-3">
            <label class="form-label fw-bold fs-8 text-secondary">Full Name</label>
            <input type="text" class="form-control rounded-3 py-2.5 px-3 fs-7" id="regFullName" placeholder="Juan Dela Cruz">
        </div>

        <div class="text-start mb-3">
            <label class="form-label fw-bold fs-8 text-secondary">School Email</label>
            <input type="email" class="form-control rounded-3 py-2.5 px-3 fs-7" id="regEmail" placeholder="you@school.edu.ph">
        </div>

        <div class="text-start mb-3">
            <label class="form-label fw-bold fs-8 text-secondary">Password</label>
            <div class="input-group">
                <input type="password" class="form-control border-end-0 rounded-start-3 py-2.5 px-3 fs-7" id="regPassword" placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white" onclick="togglePasswordVisibility('regPassword', 'regEyeIcon2')">
                    <i class="fa-solid fa-eye text-muted" id="regEyeIcon2"></i>
                </button>
            </div>
        </div>

        <div class="text-start mb-3">
            <label class="form-label fw-bold fs-8 text-secondary">Confirm Password</label>
            <div class="input-group">
                <input type="password" class="form-control border-end-0 rounded-start-3 py-2.5 px-3 fs-7" id="regConfirmPassword" placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white" onclick="togglePasswordVisibility('regConfirmPassword', 'regConfirmEyeIcon2')">
                    <i class="fa-solid fa-eye text-muted" id="regConfirmEyeIcon2"></i>
                </button>
            </div>
        </div>

        <div class="form-check text-start mb-3">
            <input class="form-check-input" type="checkbox" id="regAgreeTerms" checked>
            <label class="form-check-label fs-8 text-muted" for="regAgreeTerms">
                I agree to the <a href="javascript:void(0)" class="text-primary fw-bold text-decoration-none" onclick="alert('📋 PasaBuy Terms: Campus marketplace registration requires valid student credentials.')">Terms and Conditions</a>
            </label>
        </div>

        <button class="btn btn-primary w-100 rounded-3 py-3 fw-bold fs-7 shadow-sm mb-3 text-white" 
            style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none;" 
            onclick="submitRegistrationSendOtpScreen()">
            Sign Up
        </button>

        <div class="pt-2 text-center fs-8 text-muted">
            Already have an account? 
            <a href="javascript:void(0)" class="text-primary fw-bold text-decoration-none ms-1" onclick="showLoginScreen()">Sign In</a>
        </div>
    </div>
</div>
