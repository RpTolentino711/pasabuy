<!-- APPLICATION MODALS (PHP COMPONENT) -->

<!-- REPORT MODAL -->
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3">
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold text-danger"><i
                        class="fa-solid fa-triangle-exclamation me-2"></i>Submit Report to Admin</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="fs-8 text-muted mb-3">Reports are reviewed directly by PasaBuy Admin. If policy violations
                    are found, the account will be suspended.</p>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Report Reason</label>
                    <select class="form-select rounded-3 fs-7" id="reportReason">
                        <option>Scam / Fake Item</option>
                        <option>Prohibited Item</option>
                        <option>Misleading Description</option>
                        <option>Inappropriate Content / Harassment</option>
                        <option>Stolen Item</option>
                        <option>Other Violation</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Details for Admin Review</label>
                    <textarea class="form-control rounded-3 fs-7" id="reportDetails" rows="3"
                        placeholder="Describe what happened..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4 fs-8"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger rounded-pill px-4 fs-8"
                    onclick="submitReportToAdmin()">Submit Report</button>
            </div>
        </div>
    </div>
</div>

<!-- POST WANTED MODAL -->
<div class="modal fade" id="wantedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3">
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold text-primary"><i class="fa-solid fa-bullhorn me-2"></i>Post Wanted
                    Item / Campus Request</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="fs-8 text-muted mb-3">Looking for something urgent or need a food pasabuy? Post your
                    request and let fellow campus students offer!</p>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Item / Request Title</label>
                    <input type="text" class="form-control rounded-3 fs-7" id="wantedTitle"
                        placeholder="e.g. Need Casio FX-991ES Calculator for 2PM Exam!">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Category</label>
                        <select class="form-select rounded-3 fs-7" id="wantedCategory">
                            <option>School Supplies</option>
                            <option>Food / Pasabuy</option>
                            <option>Textbooks / Books</option>
                            <option>Electronics</option>
                            <option>Lab Equipment</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Max Budget (₱)</label>
                        <input type="number" class="form-control rounded-3 fs-7" id="wantedBudget"
                            placeholder="e.g. 400">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Urgency</label>
                    <select class="form-select rounded-3 fs-7" id="wantedUrgency">
                        <option value="URGENT">🔴 URGENT (Needed Today / Exam)</option>
                        <option value="CLASS">🟡 Needed for Class This Week</option>
                        <option value="GENERAL">🟢 General Request</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Preferred Meetup / Delivery Location <span
                            class="text-muted fw-normal fs-8">(Optional)</span></label>
                    <input type="text" class="form-control rounded-3 fs-7" id="wantedMeetup"
                        placeholder="e.g. Library Lobby, Gate 1, Cafeteria, or Any (Optional)">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Description / Specific Instructions</label>
                    <textarea class="form-control rounded-3 fs-7" id="wantedDescription" rows="2"
                        placeholder="e.g. Willing to meet before 2 PM at Library. Will pay cash or GCash."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4 fs-8"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold"
                    onclick="submitWantedPost()"><i class="fa-solid fa-paper-plane me-1"></i> Publish
                    Request</button>
            </div>
        </div>
    </div>
</div>

<!-- PAYMONGO LIVE GATEWAY MODAL -->
<div class="modal fade" id="payMongoGatewayModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-credit-card text-primary fs-5"></i>
                    <h6 class="modal-title fw-bold text-dark mb-0">PayMongo Live Checkout</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Step 1: Channel Selector -->
            <div class="modal-body py-3" id="pmStep1">
                <div class="text-center p-3 bg-light rounded-4 border mb-3">
                    <span class="text-muted fs-8">TOTAL POSTING FEE</span>
                    <div class="fw-extrabold fs-2 text-primary" id="gatewayAmount">₱5.00</div>
                    <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill fs-9 mt-1"><i
                            class="fa-solid fa-shield-halved me-1"></i> PayMongo Live API Active</span>
                </div>

                <label class="form-label fw-bold fs-7 mb-2">Select Payment Channel to Pay</label>
                <div class="d-grid gap-2 mb-2">
                    <button
                        class="btn btn-outline-primary rounded-3 text-start p-3 fw-bold d-flex align-items-center justify-content-between"
                        onclick="showGcashStep()">
                        <div>
                            <i class="fa-solid fa-mobile-screen-button fs-5 text-info me-2"></i>
                            <span>GCash E-Wallet / QRPh</span>
                        </div>
                        <span class="badge bg-primary rounded-pill">Pay ₱5.00</span>
                    </button>
                    <button
                        class="btn btn-outline-dark rounded-3 text-start p-3 fw-bold d-flex align-items-center justify-content-between"
                        onclick="completePayMongoPayment()">
                        <div>
                            <i class="fa-solid fa-wallet fs-5 text-primary me-2"></i>
                            <span>Maya Wallet</span>
                        </div>
                        <span class="badge bg-dark rounded-pill">Pay ₱5.00</span>
                    </button>
                    <button
                        class="btn btn-outline-secondary rounded-3 text-start p-3 fw-bold d-flex align-items-center justify-content-between"
                        onclick="completePayMongoPayment()">
                        <div>
                            <i class="fa-solid fa-credit-card fs-5 text-success me-2"></i>
                            <span>Credit / Debit Card</span>
                        </div>
                        <span class="badge bg-secondary rounded-pill">Pay ₱5.00</span>
                    </button>
                </div>
            </div>

            <!-- Step 2: PayMongo GCash Live QR Code View -->
            <div class="modal-body py-3 text-center" id="pmStep2" style="display:none;">
                <div class="p-3 bg-primary bg-opacity-10 rounded-4 border border-primary-subtle mb-3">
                    <span class="badge bg-primary text-white fw-bold px-3 py-1 rounded-pill fs-9 mb-2"><i
                            class="fa-solid fa-qrcode me-1"></i> PayMongo Live QRPh / GCash Code</span>
                    <div class="fw-extrabold fs-2 text-primary mb-1" id="gcashAmountDisplay">₱5.00</div>
                    <div class="fs-9 text-muted mb-2">Merchant: <strong>PasaBuy Campus Marketplace</strong></div>

                    <!-- Generated Live PayMongo GCash QR Code Image -->
                    <div class="bg-white p-3 rounded-4 border d-inline-block shadow-sm mb-2"
                        style="max-width: 240px;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://pasabuy.site/pasabuy_api.php?action=paymongo_gcash_qr"
                            id="paymongoQrImage" alt="PayMongo GCash QR Code" class="img-fluid rounded-3 mb-2"
                            style="width: 180px; height: 180px;">
                        <div class="fw-bold fs-9 text-dark"><i class="fa-solid fa-camera me-1 text-primary"></i>
                            Scan with GCash App</div>
                    </div>

                    <!-- Real-Time Auto Detection Status Badge -->
                    <div id="paymongoStatusBadge"
                        class="p-2 bg-white rounded-3 border fs-8 text-primary fw-bold mb-2">
                        <span class="spinner-border spinner-border-sm me-1 text-primary" role="status"></span>
                        Waiting for GCash QR payment...
                    </div>

                    <p class="fs-9 text-muted mb-0">Scan QR with GCash app. Payment auto-detects and closes
                        automatically!</p>
                </div>

                <button type="button" class="btn btn-success w-100 rounded-pill fw-bold py-2 fs-7 mb-2"
                    id="btnAutoVerifyPayMongo" onclick="completePayMongoPayment()">
                    <i class="fa-solid fa-circle-check me-1"></i> Verify & Post Live Now
                </button>
                <button type="button" class="btn btn-link text-muted fs-8" onclick="showPmStep1()"><i
                        class="fa-solid fa-arrow-left me-1"></i> Back to Payment Options</button>
            </div>

        </div>
    </div>
</div>

<!-- EDIT PROFILE & ACCOUNT SETTINGS MODAL -->
<div class="modal fade" id="profileSettingsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3">
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold text-primary"><i class="fa-solid fa-gear me-2"></i>Account Profile &
                    Settings</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="fs-8 text-muted mb-3">Update your profile info and avatar picture visible to fellow campus
                    students.</p>

                <!-- Avatar Change Box -->
                <div class="text-center mb-3">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80"
                        class="rounded-circle border shadow-sm mb-2" width="80" height="80"
                        style="object-fit:cover;" id="settingsAvatarPreview">
                    <div>
                        <label class="btn btn-sm btn-outline-secondary rounded-pill fs-8">
                            <i class="fa-solid fa-camera me-1"></i> Upload New Profile Picture
                            <input type="file" id="settingsAvatarInput" accept="image/*" style="display:none;"
                                onchange="previewSettingsAvatar(event)">
                        </label>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">First Name</label>
                        <input type="text" class="form-control rounded-3 fs-7" id="settingsFirstName"
                            placeholder="First Name">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Last Name</label>
                        <input type="text" class="form-control rounded-3 fs-7" id="settingsLastName"
                            placeholder="Last Name">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Student Number</label>
                    <input type="text" class="form-control rounded-3 fs-7" id="settingsStudentNumber"
                        placeholder="Student Number">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-7">
                        <label class="form-label fw-bold fs-7">Course / Program</label>
                        <input type="text" class="form-control rounded-3 fs-7" id="settingsCourse"
                            placeholder="Course / Program">
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold fs-7">Year Level</label>
                        <select class="form-select rounded-3 fs-7" id="settingsYearLevel">
                            <option value="1st Yr">1st Yr</option>
                            <option value="2nd Yr">2nd Yr</option>
                            <option value="3rd Yr">3rd Yr</option>
                            <option value="4th Yr">4th Yr</option>
                            <option value="5th Yr">5th Yr</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4 fs-8"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold"
                    onclick="saveProfileSettings()"><i class="fa-solid fa-floppy-disk me-1"></i> Save & Update
                    Profile</button>
            </div>
        </div>
    </div>
</div>

<!-- CREATE ACCOUNT REGISTRATION MODAL -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-primary"><i class="fa-solid fa-user-plus me-2"></i>Create
                    PasaBuy Student Account</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <p class="fs-8 text-muted mb-3">Register your campus student info. We will send a 6-digit OTP to
                    your email to verify before saving your account to the database.</p>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">First Name</label>
                        <input type="text" class="form-control rounded-3 fs-7" id="regFirstName"
                            placeholder="e.g. Juan">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Last Name</label>
                        <input type="text" class="form-control rounded-3 fs-7" id="regLastName"
                            placeholder="e.g. Dela Cruz">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold fs-7">School Email Address</label>
                    <input type="email" class="form-control rounded-3 fs-7" id="regEmail"
                        placeholder="e.g. juan.delacruz@student.edu.ph">
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold fs-7">Student Number</label>
                    <input type="text" class="form-control rounded-3 fs-7" id="regStudentNumber"
                        placeholder="e.g. 2024-00982">
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-7">
                        <label class="form-label fw-bold fs-7">Course / Program</label>
                        <input type="text" class="form-control rounded-3 fs-7" id="regCourse"
                            placeholder="e.g. BS Computer Science">
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold fs-7">Year Level</label>
                        <select class="form-select rounded-3 fs-7" id="regYearLevel">
                            <option value="1st Yr">1st Yr</option>
                            <option value="2nd Yr">2nd Yr</option>
                            <option value="3rd Yr">3rd Yr</option>
                            <option value="4th Yr">4th Yr</option>
                        </select>
                    </div>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-end-0 rounded-start-3 fs-7"
                                id="regPassword" placeholder="Min 8 chars"
                                oninput="validateRegistrationPasswordLive()">
                            <button type="button"
                                class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white"
                                onclick="togglePasswordVisibility('regPassword', 'regEyeIcon')">
                                <i class="fa-solid fa-eye text-muted fs-8" id="regEyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-end-0 rounded-start-3 fs-7"
                                id="regConfirmPassword" placeholder="Re-type password"
                                oninput="validateRegistrationPasswordLive()">
                            <button type="button"
                                class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white"
                                onclick="togglePasswordVisibility('regConfirmPassword', 'regConfirmEyeIcon')">
                                <i class="fa-solid fa-eye text-muted fs-8" id="regConfirmEyeIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Live Password Checker & Match Feedback -->
                <div class="p-3 bg-light rounded-3 border mb-3 text-start fs-8">
                    <div class="fw-bold mb-1 text-dark fs-8">Password Security Checklist:</div>
                    <div id="regReqLen" class="text-muted"><i class="fa-solid fa-circle-dot me-1"></i> At least 8
                        characters long</div>
                    <div id="regReqCapital" class="text-muted"><i class="fa-solid fa-circle-dot me-1"></i> At least
                        1 Capital Letter (A-Z)</div>
                    <div id="regReqNumber" class="text-muted"><i class="fa-solid fa-circle-dot me-1"></i> At least 1
                        Number (0-9)</div>
                    <div id="regReqSymbol" class="text-muted"><i class="fa-solid fa-circle-dot me-1"></i> At least 1
                        Special Symbol (!@#$%^&*...)</div>
                    <hr class="my-2">
                    <div id="regMatchStatus" class="fw-bold text-muted"><i class="fa-solid fa-lock me-1"></i> Enter
                        matching passwords</div>
                </div>

                <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold py-2 fs-7"
                    onclick="submitRegistrationSendOtp()"><i class="fa-solid fa-paper-plane me-1"></i> Send OTP
                    Verification Code</button>
            </div>
        </div>
    </div>
</div>

<!-- OTP VERIFICATION MODAL (PREMIUM UI DESIGN) -->
<div class="modal fade" id="otpVerifyModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4 shadow-lg text-center position-relative overflow-hidden">
            <!-- Glowing Top Accent Header Gradient -->
            <div
                style="height:6px; background: linear-gradient(90deg, #5F27CD, #00d2d3, #ff9f43); position:absolute; top:0; left:0; right:0;">
            </div>

            <div class="modal-body py-2">
                <!-- Success Sent Icon Badge -->
                <div class="mb-3 position-relative d-inline-block">
                    <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm"
                        style="width:72px; height:72px;">
                        <i class="fa-solid fa-paper-plane fs-2"></i>
                    </div>
                    <span
                        class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center border border-2 border-white shadow-sm"
                        style="width:26px; height:26px; font-size:11px;">
                        <i class="fa-solid fa-check"></i>
                    </span>
                </div>

                <h5 class="fw-extrabold text-dark mb-1">OTP Verification Code Sent!</h5>
                <p class="fs-8 text-muted mb-3">We sent a 6-digit security code to <br><strong
                        class="text-primary fs-7" id="otpTargetEmail">user@gmail.com</strong> from
                    <code>PASABUY@pasabuy.site</code>
                </p>

                <!-- OTP Code Input Box -->
                <div class="p-3 bg-light rounded-4 border mb-3">
                    <label class="form-label fw-bold fs-8 text-uppercase text-muted tracking-wider mb-2">Enter
                        6-Digit Verification Code</label>
                    <input type="text"
                        class="form-control text-center fw-extrabold fs-2 rounded-3 border-2 border-primary bg-white shadow-sm"
                        id="otpInputCode" maxlength="6" placeholder="0 0 0 0 0 0"
                        style="letter-spacing: 10px; font-family: monospace;">
                    <span class="fs-9 text-muted mt-2 d-block"><i
                            class="fa-solid fa-clock-rotate-left me-1 text-warning"></i> Code expires in <strong
                            class="text-dark">10 minutes</strong></span>
                </div>

                <div id="otpVerifyErrorAlert" class="alert alert-danger rounded-3 fs-8 p-2 mb-3"
                    style="display:none;"></div>

                <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold py-2.5 fs-7 shadow-sm mb-2"
                    onclick="verifyOtpAndCompleteRegistration()"><i class="fa-solid fa-shield-check me-1"></i>
                    Verify OTP & Complete Registration</button>
                <button type="button" class="btn btn-light w-100 rounded-pill text-muted fs-8 fw-semibold"
                    data-bs-dismiss="modal">Cancel Registration</button>
            </div>
        </div>
    </div>
</div>

<!-- FORGOT PASSWORD MODAL -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-primary"><i class="fa-solid fa-key me-2"></i>Forgot Account
                    Password</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <p class="fs-8 text-muted mb-3">Enter your registered school email. We will send an OTP code to
                    verify your identity before allowing password reset.</p>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Registered School Email</label>
                    <input type="email" class="form-control rounded-3 fs-7" id="forgotEmailInput"
                        placeholder="e.g. john.doe@student.edu.ph">
                </div>

                <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold py-2 fs-7"
                    onclick="submitForgotPasswordSendOtp()"><i class="fa-solid fa-paper-plane me-1"></i> Send
                    Password Reset OTP</button>
            </div>
        </div>
    </div>
</div>

<!-- RESET PASSWORD MODAL -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-success"><i class="fa-solid fa-lock-open me-2"></i>Reset Account
                    Password</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <p class="fs-8 text-muted mb-2">Account: <strong class="text-dark"
                        id="resetDisplayUsername">user@pasabuy.edu.ph</strong></p>
                <p class="fs-8 text-muted mb-3">Enter the 6-digit OTP code sent from
                    <code>PASABUY@pasabuy.site</code> and your new password.
                </p>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">6-Digit OTP Code</label>
                    <input type="text" class="form-control text-center fw-bold fs-4 rounded-3" id="resetOtpInput"
                        maxlength="6" placeholder="000000" style="letter-spacing: 4px;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control border-end-0 rounded-start-3 fs-7"
                            id="resetNewPasswordInput" placeholder="Enter new password">
                        <button type="button"
                            class="btn btn-outline-secondary border-start-0 rounded-end-3 bg-white"
                            onclick="togglePasswordVisibility('resetNewPasswordInput', 'resetEyeIcon')">
                            <i class="fa-solid fa-eye text-muted" id="resetEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="button" class="btn btn-success w-100 rounded-pill fw-bold py-2 fs-7"
                    onclick="executePasswordReset()"><i class="fa-solid fa-floppy-disk me-1"></i> Save New Password
                    & Log In</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE LISTING CONFIRMATION MODAL -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4 text-center">
            <div class="modal-body py-2">
                <div class="text-danger mb-3">
                    <i class="fa-solid fa-trash-can display-4"></i>
                </div>
                <h6 class="fw-bold text-dark mb-2">Delete Selling Post?</h6>
                <p class="fs-8 text-muted mb-3">Are you sure you want to delete <strong class="text-dark"
                        id="deleteItemTitle">this listing</strong>?</p>

                <div
                    class="p-3 bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-3 text-start mb-3 fs-8">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> <strong>Note on Paid Posting
                        Fee:</strong><br>
                    You already paid <strong id="deleteItemFee" class="text-danger">₱5.00</strong> posting fee via
                    PayMongo for this item post. Deleting this post is permanent and the posting fee is
                    non-refundable.
                </div>
            </div>
            <div class="d-flex gap-2 p-3 pt-0">
                <button type="button" class="btn btn-light rounded-pill w-100 fw-bold py-2 fs-8 text-secondary"
                    data-bs-dismiss="modal">Keep Post</button>
                <button type="button" class="btn btn-danger rounded-pill w-100 fw-bold py-2 fs-8 shadow-sm"
                    onclick="executeDeleteListing()"><i class="fa-solid fa-trash me-1"></i> Yes, Delete Post</button>
            </div>
        </div>
    </div>
</div>

<!-- LOGOUT CONFIRMATION MODAL -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4 shadow-lg text-center">
            <div class="mb-3">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center p-3"
                    style="width:64px; height:64px;">
                    <i class="fa-solid fa-right-from-bracket fs-2"></i>
                </div>
            </div>
            <h5 class="fw-bold text-dark mb-2">Log Out of PasaBuy?</h5>
            <p class="fs-8 text-muted mb-4">Are you sure you want to log out of your account?</p>

            <div class="d-flex gap-2">
                <button type="button"
                    class="btn btn-light rounded-pill w-100 fw-bold py-2 fs-7 text-secondary"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button"
                    class="btn btn-danger rounded-pill w-100 fw-bold py-2 fs-7 shadow-sm"
                    onclick="executeLogout()"><i class="fa-solid fa-right-from-bracket me-1"></i>
                    Yes, Log Out</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT PRODUCT LISTING MODAL -->
<div class="modal fade" id="editListingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Edit Product Listing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editListingId">
                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Item Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control rounded-3 fs-7" id="editTitleInput">
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Price (₱) <span class="badge bg-secondary-subtle text-secondary ms-1"><i class="fa-solid fa-lock me-1"></i> Locked</span></label>
                        <input type="number" step="0.01" class="form-control rounded-3 fs-7 bg-light" id="editPriceInput" readonly title="Price is locked to prevent fee evasion. Delete & re-post if price changes.">
                        <span class="fs-9 text-muted d-block mt-1" style="font-size:0.7rem;"><i class="fa-solid fa-shield-halved text-success me-1"></i> Price locked after posting (PasaBuy fee protection).</span>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Category</label>
                        <select class="form-select rounded-3 fs-7" id="editCategorySelect">
                            <option value="1">School Supplies</option>
                            <option value="2">Electronics</option>
                            <option value="3">Books</option>
                            <option value="4">Gadgets</option>
                            <option value="5">Food / Pasabuy</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Condition</label>
                        <select class="form-select rounded-3 fs-7" id="editConditionSelect">
                            <option>Like New</option>
                            <option>Good</option>
                            <option>Fair</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Meetup Location</label>
                        <input type="text" class="form-control rounded-3 fs-7" id="editMeetupInput">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Description</label>
                    <textarea class="form-control rounded-3 fs-7" id="editDescriptionInput" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold fs-7"><i class="fa-solid fa-image text-primary me-1"></i> Product Image URL</label>
                    <input type="text" class="form-control rounded-3 fs-7" id="editImageUrlInput" placeholder="https://.../image.jpg">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold fs-7"><i class="fa-solid fa-video text-danger me-1"></i> Product Video (File or URL)</label>
                    <input type="file" class="form-control rounded-3 fs-7 mb-2" id="editVideoFileInput" accept="video/*" onchange="handleEditVideoUpload(event)">
                    <input type="text" class="form-control rounded-3 fs-7" id="editVideoUrlInput" placeholder="or enter MP4 video URL">
                    <div id="editVideoPreviewContainer" class="mt-2" style="display:none;">
                        <video id="editVideoPreview" controls style="width:100%; max-height:180px; border-radius:8px; background:#000;"></video>
                    </div>
                </div>
                <div class="d-flex gap-2 pt-2">
                    <button type="button" class="btn btn-light rounded-pill w-100 fw-bold py-2 fs-7 text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-pill w-100 fw-bold py-2 fs-7 shadow-sm" onclick="executeSaveEditedListing()"><i class="fa-solid fa-check me-1"></i> Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SHOPPING CART & CHECKOUT MODAL -->
<div class="modal fade" id="cartCheckoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-primary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-cart-shopping fs-5"></i> My Shopping Cart
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <div id="cartItemsContainer" style="max-height: 320px; overflow-y: auto;">
                    <!-- Cart items rendered dynamically -->
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 border mt-3">
                    <span class="fw-bold text-dark fs-7">Estimated Total (Items + ₱20 Delivery):</span>
                    <span class="fw-extrabold text-primary fs-5" id="cartTotalDisplay">₱0.00</span>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4 fs-8" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" onclick="alert('🛍️ Checkout Order Sent! Arrange cash/meetup delivery with sellers via Messages.')">
                    <i class="fa-solid fa-bag-shopping me-1"></i> Proceed to Checkout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- NOTIFICATIONS & ALERTS MODAL -->
<div class="modal fade" id="notificationsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <h6 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bell text-primary fs-5"></i> Notifications & Alerts
                    <span class="badge bg-danger rounded-pill fs-9" id="notifBadgeCount">2 New</span>
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-2">
                <div id="notificationsListContainer" class="d-flex flex-column gap-2" style="max-height: 380px; overflow-y: auto;">
                    
                    <!-- Notification 1: New Message from Buyer/Seller -->
                    <div class="p-3 bg-primary bg-opacity-10 border border-primary-subtle rounded-3 shadow-2xs text-start position-relative"
                        onclick="handleNotificationClick('messages')" style="cursor:pointer;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="badge bg-primary text-white fw-bold fs-9"><i class="fa-solid fa-comment-dots me-1"></i> New Message</span>
                            <span class="text-muted fs-9">2m ago</span>
                        </div>
                        <h6 class="fw-bold text-dark fs-8 mb-1">Beatriz Solis sent you a message</h6>
                        <p class="text-secondary fs-8 mb-0 text-truncate">"Is the Calculus Textbook (8th Edition) still available for meetup at Main Library?"</p>
                        <div class="text-primary fw-bold fs-9 mt-1"><i class="fa-solid fa-arrow-right me-1"></i> Tap to open Chat & Reply</div>
                    </div>

                    <!-- Notification 2: New Item Posted -->
                    <div class="p-3 bg-light border rounded-3 shadow-2xs text-start"
                        onclick="handleNotificationClick('item')" style="cursor:pointer;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="badge bg-success text-white fw-bold fs-9"><i class="fa-solid fa-bag-shopping me-1"></i> New Item Arrived</span>
                            <span class="text-muted fs-9">15m ago</span>
                        </div>
                        <h6 class="fw-bold text-dark fs-8 mb-1">Laptop Backpack (15.6") just posted!</h6>
                        <p class="text-secondary fs-8 mb-0">Campus Gear posted a new item in Electronics for ₱899.</p>
                        <div class="text-success fw-bold fs-9 mt-1"><i class="fa-solid fa-eye me-1"></i> Tap to view campus listing</div>
                    </div>

                    <!-- Notification 3: Order Update -->
                    <div class="p-3 bg-light border rounded-3 shadow-2xs text-start"
                        onclick="handleNotificationClick('order')" style="cursor:pointer;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="badge bg-warning text-dark fw-bold fs-9"><i class="fa-solid fa-box-open me-1"></i> Order Update</span>
                            <span class="text-muted fs-9">1h ago</span>
                        </div>
                        <h6 class="fw-bold text-dark fs-8 mb-1">Order Confirmed by Seller</h6>
                        <p class="text-secondary fs-8 mb-0">TechHub PH accepted your order for Wireless Earbuds (2nd Gen).</p>
                    </div>

                </div>
            </div>
            <div class="modal-footer border-0 pt-2 justify-content-between">
                <button type="button" class="btn btn-link text-muted fs-8 p-0 text-decoration-none" onclick="clearAllNotifications()"><i class="fa-solid fa-check-double me-1"></i> Mark all as read</button>
                <button type="button" class="btn btn-secondary rounded-pill px-4 fs-8" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- PRODUCT DETAIL VIEW MODAL (MATCHING REFERENCE DESIGN 1:1) -->
<div class="modal fade" id="productDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 p-0 shadow-lg overflow-hidden">
            
            <!-- Top Header Action Bar -->
            <div class="modal-header border-0 bg-white px-3 py-2.5 d-flex align-items-center justify-content-between position-relative z-3">
                <button type="button" class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" style="width:36px; height:36px; background:#f1f5f9;" data-bs-dismiss="modal">
                    <i class="fa-solid fa-arrow-left text-dark fs-7"></i>
                </button>
                <div class="fw-bold text-dark fs-7">Item Details</div>
                <button type="button" class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" style="width:36px; height:36px; background:#f1f5f9;" onclick="toggleWishlist(this, currentDetailProductId)">
                    <i class="fa-regular fa-heart text-dark fs-7" id="detailWishlistIcon"></i>
                </button>
            </div>

            <!-- Modal Body Scrollable Area -->
            <div class="modal-body p-3 bg-white" id="productDetailModalBody">
                
                <!-- Main Product Image / Video -->
                <div class="position-relative mb-2 rounded-4 overflow-hidden border bg-light text-center" style="min-height:240px;">
                    <img id="detailMainImg" src="" class="img-fluid rounded-4" style="max-height:280px; width:100%; object-fit:cover;">
                    <video id="detailMainVideo" controls style="width:100%; max-height:280px; object-fit:cover; display:none; background:#000;"></video>
                </div>

                <!-- Gallery Thumbnails Row -->
                <div class="d-flex gap-2 mb-3 overflow-x-auto pb-1" id="detailThumbnailsRow">
                    <!-- Thumbnails appended dynamically -->
                </div>

                <!-- Title & Price Section -->
                <h4 class="fw-extrabold text-dark fs-5 mb-1" id="detailTitle">Product Title</h4>
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="fw-extrabold text-dark fs-3" id="detailPrice">₱0.00</span>
                    <span class="text-muted text-decoration-line-through fs-7" id="detailOrigPrice">₱0.00</span>
                    <span class="badge bg-danger bg-opacity-10 text-danger fw-bold rounded-pill px-2.5 py-1 fs-8" id="detailDiscountTag">25% OFF</span>
                </div>

                <!-- Rating & Stock Status -->
                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-1.5">
                        <i class="fa-solid fa-star text-warning fs-7"></i>
                        <span class="fw-bold text-dark fs-7" id="detailRatingVal">4.8</span>
                        <span class="text-muted fs-8">(<span id="detailReviewCount">120</span> reviews)</span>
                    </div>
                    <div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fw-bold fs-8" id="detailStockBadge">
                            <i class="fa-solid fa-circle-check me-1"></i> In Stock
                        </span>
                    </div>
                </div>

                <!-- Seller Info Card -->
                <div class="p-3 bg-light rounded-4 border mb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2.5">
                        <img id="detailSellerAvatar" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" class="rounded-circle border" width="44" height="44" style="object-fit:cover;">
                        <div>
                            <div class="fs-9 text-muted mb-0.5">Sold by</div>
                            <div class="fw-bold text-dark fs-7 d-flex align-items-center gap-1">
                                <span id="detailSellerName">Verified Seller</span>
                                <span class="badge bg-primary-subtle text-primary rounded-pill fs-9 px-2 py-0.5 fw-semibold"><i class="fa-solid fa-check me-0.5"></i> Verified</span>
                            </div>
                            <div class="fs-9 text-muted mt-0.5" id="detailSellerLocation"><i class="fa-solid fa-location-dot text-danger me-1"></i> Campus Library</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold fs-8" id="detailChatBtn">
                        <i class="fa-solid fa-comments me-1"></i> Chat
                    </button>
                </div>

                <!-- Product Specifications & Details Table -->
                <div class="mb-3">
                    <h6 class="fw-bold text-dark mb-2 fs-7">Product Details</h6>
                    <div class="p-3 bg-light rounded-4 border fs-8">
                        <div class="row py-1 border-bottom border-secondary-subtle">
                            <div class="col-4 text-muted">Brand:</div>
                            <div class="col-8 fw-semibold text-dark" id="detailBrand">Generic</div>
                        </div>
                        <div class="row py-1 border-bottom border-secondary-subtle">
                            <div class="col-4 text-muted">Condition:</div>
                            <div class="col-8 fw-semibold text-dark" id="detailCondition">Brand New</div>
                        </div>
                        <div class="row py-1 border-bottom border-secondary-subtle">
                            <div class="col-4 text-muted">Category:</div>
                            <div class="col-8 fw-semibold text-dark" id="detailCategory">Electronics</div>
                        </div>
                        <div class="row py-1 border-bottom border-secondary-subtle">
                            <div class="col-4 text-muted">Meetup Point:</div>
                            <div class="col-8 fw-semibold text-dark" id="detailMeetup">Campus Library</div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-12 text-muted mb-1">Description:</div>
                            <div class="col-12 text-dark fs-8 lh-sm" id="detailDescription">Authentic item available for quick campus pickup or pasabuy delivery.</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Sticky Action Bar (Add to Cart / Buy Now) -->
            <div class="modal-footer border-top bg-white p-3 d-flex gap-2 align-items-center justify-content-between sticky-bottom">
                <button type="button" class="btn btn-outline-primary rounded-pill w-50 py-2.5 fw-bold fs-7 d-flex align-items-center justify-content-center gap-1.5 shadow-2xs" id="detailAddToCartBtn">
                    <i class="fa-solid fa-cart-plus fs-6"></i> Add to Cart
                </button>
                <button type="button" class="btn btn-primary rounded-pill w-50 py-2.5 fw-bold fs-7 d-flex align-items-center justify-content-center gap-1.5 shadow-sm" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none;" id="detailBuyNowBtn">
                    <i class="fa-solid fa-bolt fs-6"></i> Buy Now
                </button>
            </div>

        </div>
    </div>
</div>
