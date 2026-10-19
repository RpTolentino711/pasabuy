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

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Student Number</label>
                        <input type="number" inputmode="numeric" pattern="[0-9]*" class="form-control rounded-3 fs-7" id="settingsStudentNumber"
                            placeholder="Numbers only" style="-moz-appearance: textfield;"
                            onkeydown="if(!['Backspace','Delete','ArrowLeft','ArrowRight','Tab'].includes(event.key) && (event.key &lt; '0' || event.key &gt; '9')) event.preventDefault();"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold fs-7">Phone Number</label>
                        <input type="tel" inputmode="numeric" class="form-control rounded-3 fs-7" id="settingsPhone"
                            placeholder="09171234567" oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-7">Registered Email</label>
                    <input type="email" class="form-control rounded-3 fs-7" id="settingsEmail"
                        placeholder="you@school.edu.ph">
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
            <h5 class="fw-bold text-dark mb-2">Log Out of RentEase?</h5>
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
                    <label class="form-label fw-bold fs-7"><i class="fa-solid fa-boxes-stacked text-primary me-1"></i> Available Stock Quantity <span class="text-muted fw-normal fs-9">(Set to 0 to hide from Home/Explore feeds)</span></label>
                    <input type="number" class="form-control rounded-3 fs-7" id="editQuantityInput" min="0" value="1" placeholder="e.g. 1">
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
                    <div class="mb-3 pt-2">
                        <label class="form-label fw-bold fs-7 text-dark mb-2"><i class="fa-solid fa-truck-ramp-box text-primary me-1"></i> Fulfillment Option</label>
                        <div class="d-flex gap-2">
                            <div class="form-check card p-2.5 rounded-3 border w-50 flex-row align-items-center gap-2 m-0 bg-white" style="cursor:pointer;" onclick="document.getElementById('fulMotor').click();">
                                <input class="form-check-input ms-1" type="radio" name="fulfillmentTypeRadio" id="fulMotor" value="MOTOR_DELIVERY" checked>
                                <label class="form-check-label fs-8 fw-bold text-dark cursor-pointer" for="fulMotor">
                                    🚚 Express Motor
                                    <span class="d-block text-muted fw-normal fs-9">Direct to your address</span>
                                </label>
                            </div>
                            <div class="form-check card p-2.5 rounded-3 border w-50 flex-row align-items-center gap-2 m-0 bg-white" style="cursor:pointer;" onclick="document.getElementById('fulMeetup').click();">
                                <input class="form-check-input ms-1" type="radio" name="fulfillmentTypeRadio" id="fulMeetup" value="MEETUP">
                                <label class="form-check-label fs-8 fw-bold text-dark cursor-pointer" for="fulMeetup">
                                    🤝 Campus Meetup
                                    <span class="d-block text-muted fw-normal fs-9">Library / Spot</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 border">
                        <span class="fw-bold text-dark fs-7">Total Amount:</span>
                        <span class="fw-extrabold text-primary fs-5" id="cartTotalDisplay">₱0.00</span>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none;" onclick="executeCheckoutOrder()">
                        <i class="fa-solid fa-bag-shopping me-1"></i> Confirm & Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- BUYER ADDRESS PROMPT MODAL (SHOWN IF PROFILE ADDRESS IS MISSING) -->
    <div class="modal fade" id="buyerAddressPromptModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
                <div class="modal-header border-0 pb-1">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-location-dot text-danger fs-5"></i> Delivery Address Required
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="fs-8 text-muted mb-3">To order items for delivery or meetup, please complete your residential address and contact phone number first.</p>
                    <form id="quickAddressForm" onsubmit="event.preventDefault(); saveQuickBuyerAddress();">
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label fw-bold fs-8">Hometown / City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3 fs-8" id="qaHometown" required placeholder="e.g. Quezon City">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold fs-8">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3 fs-8" id="qaPostalCode" required placeholder="e.g. 1108">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold fs-8">Full Residential / Dorm Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 fs-8" id="qaAddress" required placeholder="e.g. 123 Katipunan Ave, Dorm Bldg 4">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold fs-8">Contact Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control rounded-3 fs-8" id="qaPhone" required placeholder="09171234567">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light rounded-pill w-50 fw-bold fs-8" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill w-50 fw-bold fs-8 shadow-sm" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none;">
                                Save &amp; Continue Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MY ORDERS & LIVE DELIVERY TRACKING MODAL -->
    <div class="modal fade" id="ordersModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
                <div class="modal-header border-0 pb-2">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-primary fs-5"></i> My Orders &amp; Delivery Tracking
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-1">
                    <ul class="nav nav-pills nav-justified mb-3 bg-light p-1 rounded-pill fs-8 fw-bold" id="ordersTabs">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill py-1.5" onclick="renderBuyerOrdersTab('active', this)">Active Deliveries</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill py-1.5" onclick="renderBuyerOrdersTab('completed', this)">Order History</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill py-1.5" onclick="renderSellerOrdersTab(this)">Seller Orders</button>
                        </li>
                    </ul>

                    <div id="ordersListContent" class="d-flex flex-column gap-3" style="max-height: 480px; overflow-y: auto;">
                        <!-- Rendered dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MOTOR RIDER REGISTRATION MODAL -->
    <div class="modal fade" id="riderRegisterModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
                <div class="modal-header border-0 pb-1">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-motorcycle text-warning fs-4"></i> Apply as PasaBuy Motor Driver
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-1">
                    <p class="fs-8 text-muted mb-3">Earn money delivering packages to students on campus! Submit your driver details for Admin approval.</p>
                    <form id="riderRegisterForm" onsubmit="event.preventDefault(); submitRiderRegistration();">
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label fw-bold fs-8">Plate Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3 fs-8" id="rPlateNumber" required placeholder="e.g. 123-ABC">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold fs-8">Vehicle Brand / Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3 fs-8" id="rVehicleModel" required placeholder="e.g. Honda Click 125i">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold fs-8">Driver License Serial Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 fs-8" id="rLicenseNo" required placeholder="e.g. N01-18-123456">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold fs-8"><i class="fa-solid fa-camera text-primary me-1"></i> Upload Photo of Driver's License <span class="text-danger">*</span></label>
                            <input type="file" class="form-control rounded-3 fs-8" id="rLicenseInput" accept="image/*" onchange="previewRiderLicense(event)">
                            <div id="rLicensePreviewBox" class="mt-2 text-center" style="display:none;">
                                <img id="rLicensePreview" class="img-fluid rounded-3 border shadow-sm" style="max-height: 150px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light rounded-pill w-50 fw-bold fs-8" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning rounded-pill w-50 fw-bold fs-8 text-dark shadow-sm" id="submitRiderRegBtn">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DRIVER INCOMING JOB ALERT POPUP MODAL -->
    <div class="modal fade" id="riderJobAlertModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 shadow-lg border-start border-5 border-warning">
                <div class="modal-header border-0 pb-1">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-bell text-warning fs-4 animate-bounce"></i> New Express Delivery Job Available!
                    </h6>
                </div>
                <div class="modal-body pt-2" id="riderJobAlertBody">
                    <!-- Populated dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- DRIVER ACTIVE DELIVERY DASHBOARD MODAL (2-STAGE PICKUP & DROPOFF) -->
    <div class="modal fade" id="driverActiveDeliveryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
                <div class="modal-header border-0 pb-2">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-motorcycle text-warning fs-4"></i> Driver Active Delivery Task
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-1" id="driverActiveDeliveryBody">
                    <!-- Populated dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- SELLER DISPATCH RADAR MODAL -->
    <div class="modal fade" id="sellerDispatchModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
                <div class="modal-header border-0 pb-1">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-radar text-primary fs-4"></i> Nearby Motor Drivers Radar
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="fs-8 text-muted mb-3">Broadcast package pickup alert to all active verified motor drivers nearby on campus.</p>
                    <input type="hidden" id="dispatchOrderId">
                    <div id="nearbyRidersRadarList" class="d-flex flex-column gap-2 mb-3">
                        <div class="text-center text-muted py-3 fs-8"><i class="fa-solid fa-spinner fa-spin me-1"></i> Scanning nearby motor drivers...</div>
                    </div>
                    <button class="btn btn-warning w-100 rounded-pill fw-bold py-2 fs-7 text-dark shadow-sm" onclick="executeBroadcastToRiders()">
                        <i class="fa-solid fa-bullhorn me-1"></i> Broadcast Delivery Request to All Nearby Drivers
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

<style>
    #productDetailModal.is-owner-listing .detail-buyer-only,
    #productDetailModal.is-owner-listing #detailHeaderBuyerActions,
    #productDetailModal.is-owner-listing #detailBuyerSafetyRow,
    #productDetailModal.is-owner-listing #detailHeaderReportBtn,
    #productDetailModal.is-owner-listing #detailReportItemLink {
        display: none !important;
    }
    #productDetailModal:not(.is-owner-listing) #detailHeaderOwnerBadge {
        display: none !important;
    }
    #productDetailModal .modal-content { border-radius: 24px !important; box-shadow: 0 24px 70px rgba(15, 23, 42, .24) !important; }
    #productDetailModal #productDetailModalBody { background: #F8FAFC !important; }
    #productDetailModal #detailOwnerControlSection > div { border-radius: 18px !important; border-color: #E2E8F0 !important; background: #FFFFFF !important; box-shadow: 0 8px 24px rgba(15, 23, 42, .06); }
</style>
<!-- PRODUCT DETAIL VIEW MODAL (MATCHING RENTEASE SCREEN 3 IN UIDESIFNAPP.png 1:1) -->
<div class="modal fade" id="productDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 p-0 shadow-lg overflow-hidden" style="border: 1px solid rgba(0,0,0,0.08);">
            
            <!-- Top Header Action Bar -->
            <div class="modal-header border-bottom border-light-subtle bg-white px-3 py-2.5 d-flex align-items-center justify-content-between position-relative z-3">
                <button type="button" class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" style="width:36px; height:36px; background:#f1f5f9; transition: transform 0.15s ease;" data-bs-dismiss="modal" title="Back">
                    <i class="fa-solid fa-arrow-left text-dark fs-7"></i>
                </button>
                <div class="fw-extrabold text-dark fs-7 text-truncate px-2" id="detailHeaderTitle" style="letter-spacing: -0.2px;">Equipment Details</div>
                <div id="detailHeaderOwnerBadge" class="d-flex align-items-center" style="display:none;">
                    <span class="badge rounded-pill fw-bold px-2.5 py-2" style="background:#EEF2FF; color:#5B3FA8; font-size:0.72rem;">
                        <i class="fa-solid fa-crown text-warning me-1"></i> Mine
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2" id="detailHeaderBuyerActions">
                    <button type="button" id="detailHeaderReportBtn" class="btn btn-light rounded-circle p-0 align-items-center justify-content-center shadow-2xs detail-buyer-only" style="display:none; width:36px; height:36px; background:#fef2f2; border:1.5px solid #fee2e2; color:#ef4444; transition: transform 0.15s ease;" onclick="openReportItemModal()" title="Report Listing to Admin">
                        <i class="fa-solid fa-flag fs-7 text-danger"></i>
                    </button>
                    <button type="button" id="detailHeaderWishlistBtn" class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs detail-buyer-only" style="width:36px; height:36px; background:#f1f5f9; transition: transform 0.15s ease;" onclick="toggleWishlist(this, currentDetailProductId)" title="Wishlist">
                        <i class="fa-regular fa-heart text-dark fs-7" id="detailWishlistIcon"></i>
                    </button>
                    <button type="button" class="btn btn-light rounded-circle position-relative p-0 d-flex align-items-center justify-content-center shadow-2xs detail-buyer-only" style="width:36px; height:36px; background:#f1f5f9; transition: transform 0.15s ease;" onclick="openCartFromDetailModal()" title="View Cart" id="modalHeaderCartBtn">
                        <i class="fa-solid fa-cart-shopping text-dark fs-7"></i>
                        <span class="badge-cart-counter position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="modalCartCountBadge" style="display:none;">0</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body Scrollable Area (Screen 3) -->
            <div class="modal-body p-3 bg-white" id="productDetailModalBody">
                
                <!-- Dynamic Media Carousel with Auto-slide & Touch Swiping -->
                <div id="detailMediaCarousel" class="carousel slide rounded-4 overflow-hidden border bg-dark mb-3 position-relative shadow-sm" 
                     data-bs-ride="carousel" data-bs-interval="3500" data-bs-touch="true" style="min-height:230px; user-select:none; -webkit-user-select:none; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
                    
                    <!-- Carousel Inner Slides (Images & Videos) -->
                    <div class="carousel-inner" id="detailCarouselInner" style="max-height:260px; min-height:230px; background:#0f172a;">
                        <div class="carousel-item active" style="height:260px;">
                            <img id="detailMainImg" src="https://via.placeholder.com/500x500/5B3FA8/FFFFFF?text=No+Image"
                                 class="d-block w-100 h-100" style="object-fit:cover;"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/500x500/5B3FA8/FFFFFF?text=No+Image';">
                        </div>
                    </div>

                    <!-- Slide Indicator Dots -->
                    <div class="carousel-indicators mb-2.5 gap-1.5" id="detailCarouselIndicators" style="margin-bottom:8px;">
                        <button type="button" data-bs-target="#detailMediaCarousel" data-bs-slide-to="0" class="active rounded-pill" aria-current="true" style="width:18px; height:6px; background-color:#fff; border:none; transition:all 0.3s ease;"></button>
                    </div>

                    <!-- Navigation Chevrons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#detailMediaCarousel" data-bs-slide="prev" id="detailCarouselPrevBtn" style="width:44px; opacity:0.9; display:none;">
                        <span class="d-flex align-items-center justify-content-center rounded-circle bg-dark bg-opacity-50 text-white shadow-sm" style="width:32px; height:32px; backdrop-filter:blur(4px);">
                            <i class="fa-solid fa-chevron-left fs-8"></i>
                        </span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#detailMediaCarousel" data-bs-slide="next" id="detailCarouselNextBtn" style="width:44px; opacity:0.9; display:none;">
                        <span class="d-flex align-items-center justify-content-center rounded-circle bg-dark bg-opacity-50 text-white shadow-sm" style="width:32px; height:32px; backdrop-filter:blur(4px);">
                            <i class="fa-solid fa-chevron-right fs-8"></i>
                        </span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                    <!-- Media Badge Counter in Top Right (e.g. 1/3) -->
                    <div class="position-absolute top-0 end-0 m-2.5 z-2" id="detailMediaBadge" style="pointer-events:none; display:none;">
                        <span class="badge rounded-pill bg-black bg-opacity-60 text-white px-2 py-1 fs-9 fw-semibold shadow-xs" style="backdrop-filter:blur(4px);">
                            <i class="fa-regular fa-images me-1"></i> <span id="detailMediaCount">1/1</span>
                        </span>
                    </div>
                </div>

                <!-- Hidden fallback video player container for backwards compatibility -->
                <div id="detailVideoContainer" style="display:none;"><video id="detailVideoPlayer"></video></div>

                <!-- Category Tag & Verification Row -->
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="badge rounded-pill px-2.5 py-1 text-primary fw-bold" style="background: #F3E8FF; font-size: 0.7rem;" id="detailCategoryBadge">
                        <i class="fa-solid fa-layer-group me-1"></i> Rental Equipment
                    </span>
                    <span class="badge rounded-pill px-2 py-0.5 text-success fw-bold" style="background: #ECFDF5; font-size: 0.68rem;">
                        <i class="fa-solid fa-shield-halved me-1"></i> Campus Verified
                    </span>
                </div>

                <!-- Title, Rating & Reviews -->
                <h4 class="fw-extrabold text-dark fs-5 mb-1" id="detailTitle" style="letter-spacing:-0.2px;">Equipment Details</h4>
                
                <div class="d-flex align-items-center gap-1.5 mb-3">
                    <div class="d-flex align-items-center gap-1 bg-warning bg-opacity-10 px-2 py-0.5 rounded-pill">
                        <i class="fa-solid fa-star text-warning fs-9"></i>
                        <span class="fw-extrabold text-dark fs-8" id="detailRatingVal">5.0</span>
                    </div>
                    <span class="text-muted fs-8">(<span id="detailReviewCount">1</span> reviews)</span>
                    <span class="text-secondary opacity-50">•</span>
                    <span class="text-muted fs-8"><i class="fa-solid fa-location-dot text-danger fs-9 me-0.5"></i> Campus Meetup</span>
                </div>

                <!-- Price Highlight Card -->
                <div class="p-3 rounded-4 mb-3 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border: 1.5px solid #E2E8F0;">
                    <div>
                        <div class="text-muted fw-bold text-uppercase" style="font-size:0.65rem; letter-spacing:0.6px;">Rental Price</div>
                        <div class="d-flex align-items-baseline gap-1">
                            <span class="fw-extrabold fs-3" id="detailPrice" style="color: #5B3FA8;">₱0</span>
                            <span class="text-muted fs-7 fw-semibold">/ day</span>
                        </div>
                    </div>
                    <span class="badge rounded-pill px-3 py-1.5 fw-bold" style="background: #EDE9FE; color: #5B3FA8; font-size: 0.72rem;">
                        <i class="fa-regular fa-clock me-1"></i> 1 Day Min Rental
                    </span>
                </div>

                <!-- Description Card -->
                <div class="p-3 rounded-4 mb-3" style="background: #FFFFFF; border: 1.5px solid #F1F5F9; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <div class="d-flex align-items-center gap-1.5 fw-bold text-dark fs-8 mb-1.5">
                        <i class="fa-solid fa-circle-info text-primary" style="color:#5B3FA8 !important;"></i>
                        <span>Equipment Description</span>
                    </div>
                    <p class="fs-8 text-secondary lh-sm mb-0" id="detailDescription">No description provided for this listing.</p>
                </div>

                <!-- Feature Badges Row -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="p-2.5 rounded-3 text-center border h-100 d-flex flex-column align-items-center justify-content-center" style="background: #ECFDF5; border-color: #A7F3D0 !important;">
                            <i class="fa-solid fa-boxes-stacked text-success fs-6 mb-1"></i>
                            <span class="fs-9 fw-extrabold text-success-emphasis" id="detailStockBadge">10 Available</span>
                            <span class="text-muted" style="font-size:0.65rem;">Ready to Rent</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2.5 rounded-3 text-center border h-100 d-flex flex-column align-items-center justify-content-center" style="background: #F5F3FF; border-color: #DDD6FE !important;">
                            <i class="fa-regular fa-calendar-check fs-6 mb-1" style="color: #6D28D9;"></i>
                            <span class="fs-9 fw-extrabold" style="color: #6D28D9;">1 Day Min</span>
                            <span class="text-muted" style="font-size:0.65rem;">Daily Booking</span>
                        </div>
                    </div>
                </div>

                <!-- Quantity Stepper (Screen 3 - Non-Owner View) -->
                <div class="d-flex align-items-center justify-content-between p-3 rounded-4 mb-3" id="detailQtyContainer" style="background: #F8FAFC; border: 1.5px solid #E2E8F0;">
                    <div>
                        <div class="fw-extrabold text-dark fs-8">Rental Quantity</div>
                        <div class="text-muted fs-9" id="detailMaxStockLabel">Available: 10 units</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-white rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                                style="width:34px; height:34px; background:#fff; border: 1.5px solid #CBD5E1; transition:all 0.2s ease;" onclick="adjustDetailQty(-1)">
                            <i class="fa-solid fa-minus text-dark fs-9"></i>
                        </button>
                        <span class="fw-extrabold text-dark fs-6 px-2" id="detailQtyVal" style="min-width: 28px; text-align: center;">1</span>
                        <button type="button" class="btn btn-sm btn-white rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" 
                                style="width:34px; height:34px; background:#fff; border: 1.5px solid #CBD5E1; transition:all 0.2s ease;" onclick="adjustDetailQty(1)">
                            <i class="fa-solid fa-plus text-dark fs-9"></i>
                        </button>
                    </div>
                </div>

                <!-- Rental Dates & Duration (Screen 3 - Non-Owner View) -->
                <div class="card border-0 rounded-4 p-3 mb-3" id="detailDatesContainer" style="background: #F8FAFC; border: 1.5px solid #E2E8F0 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-extrabold text-dark fs-8"><i class="fa-regular fa-calendar-days text-primary me-1" style="color:#5B3FA8;"></i> Rental Schedule</span>
                        <span class="badge bg-primary-subtle text-primary fw-bold fs-9" id="detailDurationBadge">1 Day Rent</span>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label fs-9 text-muted mb-1 fw-bold">Start Date</label>
                            <input type="date" class="form-control form-control-sm rounded-3 fs-8 fw-semibold" id="detailStartDateInput" onchange="onDetailDatesChanged()">
                        </div>
                        <div class="col-6">
                            <label class="form-label fs-9 text-muted mb-1 fw-bold">End Date</label>
                            <input type="date" class="form-control form-control-sm rounded-3 fs-8 fw-semibold" id="detailEndDateInput" onchange="onDetailDatesChanged()">
                        </div>
                    </div>
                    <div class="p-2 rounded-3 bg-white border text-muted fs-9 d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-coins text-warning me-1"></i> Total Rental Cost:</span>
                        <strong class="text-primary fs-7" id="detailComputedTotalText" style="color:#5B3FA8 !important;">₱0.00</strong>
                    </div>
                </div>

                <!-- Owner Controls & Management Section (Visible ONLY when logged-in user is Owner) -->
                <div id="detailOwnerControlSection" style="display:none;" class="mb-2">
                    <!-- Owner Alert Banner with Take Down & Refund Warning -->
                    <div class="p-3 rounded-4 bg-warning bg-opacity-15 border border-warning-subtle mb-3">
                        <div class="d-flex align-items-start gap-2.5 mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning text-dark shadow-2xs mt-0.5" style="width:32px; height:32px; flex-shrink:0;">
                                <i class="fa-solid fa-triangle-exclamation fs-6"></i>
                            </div>
                            <div>
                                <h6 class="fw-extrabold text-dark fs-7 mb-1">⚠️ You Own This Equipment Listing</h6>
                                <p class="fs-9 text-secondary mb-0">
                                    This equipment is active on campus. Fellow students can rent it based on your stock and pricing below.
                                </p>
                            </div>
                        </div>
                        <div class="p-2.5 rounded-3 bg-white border border-warning-subtle text-dark fs-9">
                            <div class="fw-bold text-danger mb-0.5"><i class="fa-solid fa-shield-halved me-1 text-danger"></i> Take Down & Refund Notice:</div>
                            <span>Taking this item down removes it immediately from catalog search. You are eligible for a <strong>refund of your posting fee</strong> provided no active bookings remain.</span>
                        </div>
                    </div>

                    <!-- Inline Price & Stock Management Card -->
                    <div class="card border-0 rounded-4 shadow-sm p-3 bg-light mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-1.5">
                            <h6 class="fw-extrabold text-dark fs-8 mb-0">
                                <i class="fa-solid fa-pen-to-square me-1" style="color: #5B3FA8;"></i> Edit Rental Rate & Stock
                            </h6>
                            <span class="badge bg-primary-subtle text-primary fw-bold fs-9">Live Update</span>
                        </div>
                        <p class="fs-9 text-muted mb-2.5">Update daily rate and available units directly in database.</p>
                        
                        <div class="row g-2 mb-2.5">
                            <div class="col-6">
                                <label class="form-label fs-9 fw-bold text-dark mb-1">Rental Rate (₱ / day)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white fw-extrabold text-dark fs-8">₱</span>
                                    <input type="number" class="form-control rounded-end-3 fs-8 fw-bold" id="detailOwnerPriceInput" min="1" step="1" placeholder="Price">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fs-9 fw-bold text-dark mb-1">Available Units</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control rounded-start-3 fs-8 fw-bold" id="detailOwnerStockInput" min="0" step="1" placeholder="Stock">
                                    <span class="input-group-text bg-white fs-9 text-muted">units</span>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-primary w-100 rounded-pill py-2 fw-extrabold fs-8 shadow-xs d-flex align-items-center justify-content-center gap-1.5" 
                                style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" id="btnSaveOwnerDetailChanges" onclick="saveOwnerStockPriceFromDetail()">
                            <i class="fa-solid fa-floppy-disk"></i> Save Stock & Price Changes
                        </button>
                    </div>
                </div>

                <!-- Report Listing & Community Safety Link -->
                <div class="d-flex align-items-center justify-content-between pt-2.5 pb-1 border-top mt-2">
                    <span class="text-muted fs-9 d-flex align-items-center gap-1">
                        <i class="fa-solid fa-shield-halved text-success"></i> Campus Safety (3-Strike Policy)
                    </span>
                    <button type="button" id="detailReportItemLink" class="btn btn-link text-danger p-0 fs-9 text-decoration-none fw-bold d-none align-items-center gap-1" onclick="openReportItemModal()">
                        <i class="fa-regular fa-flag"></i> Report this Item
                    </button>
                </div>

            </div>

            <!-- Bottom Sticky Action Bar: [Chat Owner] + [Add to Cart] + [Rent Now] -->
            <div class="modal-footer border-top bg-white p-3 d-flex align-items-center gap-2 sticky-bottom" id="detailFooterActions" style="box-shadow: 0 -4px 16px rgba(0,0,0,0.04);">
                <button type="button" class="btn btn-light rounded-4 py-2.5 px-3 fw-bold fs-7 d-flex align-items-center justify-content-center gap-1.5 text-nowrap" 
                        style="background:#F8FAFC; border: 1.5px solid #E2E8F0; color:#5B3FA8; height:46px;" onclick="chatWithOwnerFromDetail()" title="Chat with Owner">
                    <i class="fa-regular fa-comment-dots fs-6"></i>
                    <span>Chat</span>
                </button>
                <button type="button" class="btn rounded-4 py-2.5 px-3 fw-extrabold fs-7 flex-grow-1 d-flex align-items-center justify-content-center gap-2 shadow-2xs text-nowrap" 
                        style="border: 2px solid #5B3FA8; color: #5B3FA8; background: #FAF5FF; height:46px; transition: all 0.2s ease;" id="detailAddToCartBtn" onclick="confirmAddDetailToCart(this)">
                    <i class="fa-solid fa-cart-plus fs-6"></i>
                    <span>Add to Cart</span>
                </button>
                <button type="button" class="btn btn-primary rounded-4 py-2.5 px-3 fw-extrabold fs-7 flex-grow-1 d-flex align-items-center justify-content-center gap-2 shadow-sm text-nowrap" 
                        style="background: linear-gradient(135deg, #6C5CE7, #5B3FA8); border: none; color: #fff; height:46px; box-shadow: 0 4px 14px rgba(91, 63, 168, 0.35);" id="detailRentNowBtn" onclick="confirmRentNowDetail()">
                    <i class="fa-solid fa-bolt fs-6 text-warning"></i>
                    <span>Rent Now</span>
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ==========================================================
     REPORT EQUIPMENT LISTING MODAL (3-STRIKE SYSTEM)
     ========================================================== -->
<div class="modal fade" id="reportItemModal" tabindex="-1" style="z-index: 1065;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger" style="width:38px; height:38px;">
                        <i class="fa-solid fa-flag fs-6"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-extrabold text-dark fs-7 mb-0">Report Equipment Listing</h6>
                        <span class="fs-9 text-muted">Admin Moderation &amp; Policy Enforcement</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-1">
                <!-- Reported Item Summary Card -->
                <div class="p-2.5 rounded-3 bg-light border mb-3 d-flex align-items-center gap-2.5">
                    <img id="reportItemThumb" src="https://via.placeholder.com/100x100/5B3FA8/FFFFFF?text=No+Image" class="rounded-2 border" style="width:44px; height:44px; object-fit:cover;">
                    <div class="min-w-0 flex-grow-1">
                        <div class="fw-bold text-dark fs-8 text-truncate" id="reportItemName">POSPT</div>
                        <div class="fs-9 text-muted">Owner: <span class="fw-semibold text-secondary" id="reportItemOwner">Romeo Paolo Tolentino</span></div>
                    </div>
                    <span class="badge bg-danger-subtle text-danger fs-9 fw-bold">Item #<span id="reportItemId">0</span></span>
                </div>

                <!-- 3-Strike Rule Alert Notice -->
                <div class="p-2.5 rounded-3 bg-warning bg-opacity-15 border border-warning-subtle mb-3">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-gavel text-warning fs-7 mt-0.5"></i>
                        <div class="fs-9 text-dark">
                            <strong>RentEase 3-Strike Policy:</strong> If this listing accumulates <strong>3 approved violation reports</strong>, the post will be terminated and the poster will be suspended. The owner can submit an appeal.
                        </div>
                    </div>
                </div>

                <!-- Violation Reason Dropdown -->
                <div class="mb-3">
                    <label class="form-label fw-bold fs-8 mb-1 text-dark">Reason for Report <span class="text-danger">*</span></label>
                    <select class="form-select rounded-3 fs-8" id="reportReasonSelect">
                        <option value="" disabled selected>-- Select violation reason --</option>
                        <option value="Prohibited or Hazardous Equipment">🚫 Prohibited or Hazardous Equipment (Weapons, illegal, dangerous)</option>
                        <option value="Scam or Fraudulent Listing">⚠️ Scam or Fraudulent Listing (Demanding off-platform deposits, fake)</option>
                        <option value="Damaged or Broken Equipment">🛠️ Damaged / Broken Item Misrepresented as Working</option>
                        <option value="Misleading Pricing or Hidden Fees">💸 Misleading Pricing or Extortionate Hidden Fees</option>
                        <option value="Impersonation or Stolen Property">👤 Impersonation or Stolen Equipment</option>
                        <option value="Inappropriate Content or Harassment">🔞 Inappropriate Content, Offensive Photos, or Harassment</option>
                        <option value="Other Policy Violation">⚖️ Other Campus Policy Violation</option>
                    </select>
                </div>

                <!-- Details / Explanation Textarea -->
                <div class="mb-3">
                    <label class="form-label fw-bold fs-8 mb-1 text-dark">Why are you reporting this item? <span class="text-danger">*</span></label>
                    <textarea class="form-control rounded-3 fs-8" id="reportDetailsText" rows="3" placeholder="Please provide specific details explaining what is wrong with this listing so the admin can review it..."></textarea>
                </div>

                <!-- Optional Evidence Photo Upload -->
                <div class="mb-3">
                    <label class="form-label fw-bold fs-8 mb-1 text-dark">Evidence Photo / Screenshot (Optional)</label>
                    <input type="file" class="form-control form-control-sm rounded-3 fs-9" id="reportEvidenceFile" accept="image/*" onchange="previewReportEvidence(this)">
                    <div id="reportEvidencePreviewContainer" class="mt-2 text-center" style="display:none;">
                        <img id="reportEvidencePreviewImg" class="rounded-3 border shadow-2xs" style="max-height:120px; max-width:100%; object-fit:contain;">
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 d-flex gap-2">
                <button type="button" class="btn btn-light rounded-pill px-3 fs-8 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger rounded-pill px-4 fs-8 fw-bold flex-grow-1 shadow-xs" id="btnSubmitItemReport" onclick="submitItemReport()">
                    <i class="fa-solid fa-flag me-1"></i> Submit Report to Admin
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================
     OWNER APPEAL MODAL (APPEAL VIOLATION / TERMINATION)
     ========================================================== -->
<div class="modal fade" id="appealItemModal" tabindex="-1" style="z-index: 1065;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary" style="width:38px; height:38px;">
                        <i class="fa-solid fa-scale-balanced fs-6"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-extrabold text-dark fs-7 mb-0">Appeal Listing Violation / Termination</h6>
                        <span class="fs-9 text-muted">Owner Reinstatement Request</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-1">
                <!-- Item Summary -->
                <div class="p-2.5 rounded-3 bg-light border mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="fw-extrabold text-dark fs-8" id="appealItemTitle">POSPT</span>
                        <span class="badge bg-danger text-white fs-9" id="appealItemStatusBadge">Strike Status</span>
                    </div>
                    <div class="fs-9 text-secondary" id="appealViolationReason">Reason: Violation report approved by moderation.</div>
                </div>

                <div class="p-2.5 rounded-3 bg-primary bg-opacity-10 border border-primary-subtle mb-3">
                    <div class="fs-9 text-primary-emphasis">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        <strong>How Appeals Work:</strong> Explain why the violation was mistaken or unjustified. Provide proof of authenticity or equipment compliance. If approved by Admin, strikes will be cleared, your listing restored, and your account unsuspended.
                    </div>
                </div>

                <input type="hidden" id="appealItemId" value="0">

                <!-- Appeal Explanation -->
                <div class="mb-3">
                    <label class="form-label fw-bold fs-8 mb-1 text-dark">Your Defense / Explanation <span class="text-danger">*</span></label>
                    <textarea class="form-control rounded-3 fs-8" id="appealReasonText" rows="3" placeholder="Explain why your equipment complies with campus rental rules, address the violation claims, or explain corrective actions taken..."></textarea>
                </div>

                <!-- Proof / Counter-Evidence -->
                <div class="mb-3">
                    <label class="form-label fw-bold fs-8 mb-1 text-dark">Proof of Authenticity / Working Condition (Optional)</label>
                    <input type="file" class="form-control form-control-sm rounded-3 fs-9" id="appealEvidenceFile" accept="image/*" onchange="previewAppealEvidence(this)">
                    <div id="appealEvidencePreviewContainer" class="mt-2 text-center" style="display:none;">
                        <img id="appealEvidencePreviewImg" class="rounded-3 border shadow-2xs" style="max-height:120px; max-width:100%; object-fit:contain;">
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 d-flex gap-2">
                <button type="button" class="btn btn-light rounded-pill px-3 fs-8 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 fs-8 fw-bold flex-grow-1 shadow-xs" style="background:linear-gradient(135deg, #6C5CE7, #5B3FA8); border:none;" id="btnSubmitItemAppeal" onclick="submitItemAppeal()">
                    <i class="fa-solid fa-paper-plane me-1"></i> Submit Appeal to Admin
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ISSUE REPORTING / CUSTOMER SUPPORT MODAL (CUSTOMER SUPPORT - 10%) -->
<div class="modal fade" id="issueReportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-1">
                <h6 class="modal-title fw-extrabold text-dark fs-7 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-headset text-primary" style="color:#5B3FA8;"></i> Report Issue to Support Center
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-1">
                <p class="fs-9 text-muted mb-3">
                    Encountered an issue with your rental? Submit a ticket below for immediate resolution by RentEase Admin.
                </p>

                <div class="mb-2.5">
                    <label class="form-label fw-bold fs-8 mb-1">Related Order</label>
                    <input type="text" class="form-control rounded-3 fs-8" id="issueOrderCodeInput" value="#RE-10245" placeholder="#RE-10245">
                </div>

                <div class="mb-2.5">
                    <label class="form-label fw-bold fs-8 mb-1">Issue Category</label>
                    <select class="form-select rounded-3 fs-8" id="issueCategorySelect">
                        <option value="Damaged Chair">Damaged Equipment (e.g. Cracked Chair)</option>
                        <option value="Late Delivery">Late Delivery / Delay</option>
                        <option value="Missing Equipment">Missing Equipment / Parts</option>
                        <option value="Billing & Charges">Computation / Billing Inquiry</option>
                        <option value="Other">Other Issue</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-8 mb-1">Description & Details</label>
                    <textarea class="form-control rounded-3 fs-8" id="issueDescriptionText" rows="3" placeholder="Explain the problem and affected items..."></textarea>
                </div>

                <button type="button" class="btn btn-primary w-100 py-2.5 rounded-pill fw-bold fs-8 shadow-sm" 
                        style="background: #5B3FA8; border:none;" onclick="submitRentEaseIssue()">
                    Submit Ticket
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================
     RENTEASE PROFILE MODALS (SCREEN 8 & USER HUB)
     ========================================================== -->

<!-- 0. SETTINGS & ACCOUNT HUB MODAL -->
<div class="modal fade" id="settingsHubModal" tabindex="-1" aria-labelledby="settingsHubModalLabel" aria-hidden="true" style="z-index: 1060 !important; pointer-events: auto !important;">
    <div class="modal-dialog modal-dialog-centered" style="position: relative; z-index: 1061 !important; pointer-events: auto !important;">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white" style="pointer-events: auto !important;">
            <div class="modal-header border-0 pb-2 d-flex align-items-center justify-content-between">
                <h6 class="modal-title fw-bold text-dark fs-7 d-flex align-items-center gap-2 mb-0" id="settingsHubModalLabel">
                    <i class="fa-solid fa-gear" style="color:#5B3FA8;"></i> Account & Settings
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-1 px-1">
                <!-- User mini profile header with Edit button -->
                <div class="p-2.5 rounded-3 bg-light bg-opacity-75 mb-2.5 d-flex align-items-center justify-content-between border">
                    <div class="d-flex align-items-center gap-2">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&q=80" 
                             class="rounded-circle border border-2 border-white shadow-2xs" width="38" height="38" style="object-fit:cover;" id="settingsHubAvatar" alt="Profile">
                        <div>
                            <h6 class="fw-bold text-dark fs-8 mb-0" id="settingsHubName">Campus Student</h6>
                            <div class="text-muted" style="font-size:0.68rem;" id="settingsHubSub">College Student</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-circle p-0 d-flex align-items-center justify-content-center shadow-2xs" style="width:32px; height:32px; border-color:#5B3FA8; color:#5B3FA8;" 
                            onclick="switchFromSettingsHub('openProfileSettingsModal')" title="Edit Profile">
                        <i class="fa-solid fa-pen-to-square fs-8"></i>
                    </button>
                </div>

                <!-- Account Navigation Menu -->
                <div class="card border-0 rounded-3 shadow-2xs overflow-hidden bg-white border mb-1">
                    
                    <!-- My Orders -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom position-relative" 
                       id="settingsHubMyOrdersRow"
                       onclick="switchFromSettingsHub('openMyOrdersModal')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center position-relative" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-receipt fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">My Orders</span>
                        </div>
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="badge rounded-pill bg-danger text-white fw-bold badge-pulse-glow" id="settingsMyOrdersBadge" style="display:none; font-size:0.65rem; padding:2px 6px;">
                                <i class="fa-solid fa-bell me-1"></i> Update
                            </span>
                            <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                        </div>
                    </a>

                    <!-- Purchase History -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub('openPurchaseHistoryModal')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-regular fa-calendar-check fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Purchase History</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- Saved Addresses -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub('openSavedAddressesModal')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-location-dot fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Saved Addresses</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- ID Verification Status -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub('openVerificationModal')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-id-card fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Student ID Verification</span>
                        </div>
                        <div class="d-flex align-items-center gap-1.5">
                            <span id="settingsHubVerificationBadge" class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-2 py-0.5 fs-9 fw-bold">Verified</span>
                            <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                        </div>
                    </a>

                    <!-- Payment Methods -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub('openPaymentMethodsModal')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-regular fa-credit-card fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Payment Methods</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- Customer Support (Issue Center) -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub('openIssueReportingModal')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-headset fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">Customer Support</span>
                        </div>
                        <span class="badge rounded-pill bg-danger-subtle text-danger fw-bold" style="font-size:0.68rem;">Issue Center</span>
                    </a>

                    <!-- About RentEase -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none border-bottom" 
                       onclick="switchFromSettingsHub('openAboutRentEaseModal')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-light d-flex align-items-center justify-content-center" style="width:30px; height:30px; color:#5B3FA8;">
                                <i class="fa-solid fa-circle-info fs-8"></i>
                            </div>
                            <span class="fw-bold text-dark fs-8">About RentEase</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted fs-9"></i>
                    </a>

                    <!-- Log Out -->
                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-between py-2.5 px-3 text-decoration-none" 
                       onclick="switchFromSettingsHub('logoutRentEaseUser')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-3 p-1.5 bg-danger bg-opacity-10 d-flex align-items-center justify-content-center text-danger" style="width:30px; height:30px;">
                                <i class="fa-solid fa-arrow-right-from-bracket fs-8"></i>
                            </div>
                            <span class="fw-bold text-danger fs-8">Log Out</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-danger opacity-50 fs-9"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- 1. EDIT PROFILE & SETTINGS MODAL -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <h6 class="modal-title fw-extrabold text-dark fs-7 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-user-pen" style="color:#5B3FA8;"></i> Edit Profile & Account
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-1">
                <div class="text-center mb-3">
                    <div class="position-relative d-inline-block">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&q=80" 
                             id="editProfileAvatarPreview" class="rounded-circle border border-3 border-white shadow-sm" 
                             width="72" height="72" style="object-fit:cover;">
                    </div>
                    <div class="mt-2">
                        <label class="form-label fs-9 text-muted mb-1">Avatar Image URL</label>
                        <input type="text" class="form-control form-control-sm rounded-pill text-center fs-9" 
                               id="editProfileAvatarInput" placeholder="https://..." oninput="document.getElementById('editProfileAvatarPreview').src = this.value || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&q=80'">
                    </div>
                </div>

                <div class="mb-2.5">
                    <label class="form-label fw-bold fs-8 mb-1">Full Name</label>
                    <input type="text" class="form-control rounded-3 fs-8" id="editProfileNameInput" placeholder="Enter your name">
                </div>

                <div class="mb-2.5">
                    <label class="form-label fw-bold fs-8 mb-1">Email Address</label>
                    <input type="email" class="form-control rounded-3 fs-8" id="editProfileEmailInput" placeholder="user@campus.edu.ph">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold fs-8 mb-1">Phone Number</label>
                    <input type="tel" class="form-control rounded-3 fs-8" id="editProfilePhoneInput" placeholder="0917-123-4567">
                </div>

                <button type="button" class="btn btn-primary w-100 py-2.5 rounded-pill fw-bold fs-8 shadow-sm" 
                        style="background: #5B3FA8; border:none;" onclick="saveRentEaseProfile()">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. MY ORDERS MODAL -->
<div class="modal fade" id="myOrdersModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <h6 class="modal-title fw-extrabold text-dark fs-7 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-receipt" style="color:#5B3FA8;"></i> Active Rental Orders
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-1" id="myOrdersModalBody">
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-spinner fa-spin me-2"></i>Loading orders...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. PURCHASE HISTORY MODAL -->
<div class="modal fade" id="purchaseHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <h6 class="modal-title fw-extrabold text-dark fs-7 d-flex align-items-center gap-2">
                    <i class="fa-regular fa-calendar-check" style="color:#5B3FA8;"></i> Rental & Purchase History
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-1" id="purchaseHistoryModalBody">
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-spinner fa-spin me-2"></i>Loading history...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. SAVED ADDRESSES MODAL -->
<div class="modal fade" id="savedAddressesModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <h6 class="modal-title fw-extrabold text-dark fs-7 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-location-dot" style="color:#5B3FA8;"></i> Saved Delivery Addresses
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-1">
                <div id="savedAddressesList" class="mb-3">
                    <!-- Dynamic addresses rendered here -->
                </div>

                <div class="border-top pt-3">
                    <h6 class="fw-bold text-dark fs-8 mb-2"><i class="fa-solid fa-plus-circle text-primary me-1"></i> Add New Address</h6>
                    <div class="mb-2.5">
                        <input type="text" class="form-control rounded-3 fs-8" id="newAddressDetails" autocomplete="off" name="rentease_delivery_address" placeholder="Full street, building, or drop-off directions...">
                    </div>
                    <button class="btn btn-sm btn-outline-primary rounded-pill w-100 fw-bold fs-8" onclick="saveNewSavedAddress()">
                        <i class="fa-solid fa-plus me-1"></i> Save Address
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 5. PAYMENT METHODS MODAL -->
<div class="modal fade" id="paymentMethodsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <h6 class="modal-title fw-extrabold text-dark fs-7 d-flex align-items-center gap-2">
                    <i class="fa-regular fa-credit-card" style="color:#5B3FA8;"></i> Payment Methods
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-1">
                <p class="fs-9 text-muted mb-3">Select your preferred payment method for event rental checkouts.</p>

                <div class="list-group gap-2 mb-3" id="paymentMethodsList">
                    <label class="list-group-item rounded-3 border d-flex align-items-center justify-content-between p-2.5 cursor-pointer">
                        <div class="d-flex align-items-center gap-2.5">
                            <input class="form-check-input mt-0" type="radio" name="preferredPaymentRadio" value="GCASH" checked onchange="savePreferredPaymentMethod('GCASH')">
                            <div>
                                <strong class="fs-8 text-dark d-block"><i class="fa-solid fa-mobile-screen text-primary me-1"></i> GCash</strong>
                                <span class="text-muted fs-9" id="gcashAccountDisplay">Connected (0917-***-4567)</span>
                            </div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fw-bold fs-9">Instant</span>
                    </label>

                    <label class="list-group-item rounded-3 border d-flex align-items-center justify-content-between p-2.5 cursor-pointer">
                        <div class="d-flex align-items-center gap-2.5">
                            <input class="form-check-input mt-0" type="radio" name="preferredPaymentRadio" value="MAYA" onchange="savePreferredPaymentMethod('MAYA')">
                            <div>
                                <strong class="fs-8 text-dark d-block"><i class="fa-solid fa-wallet text-success me-1"></i> Maya Wallet</strong>
                                <span class="text-muted fs-9" id="mayaAccountDisplay">Connected (0918-***-1234)</span>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success fw-bold fs-9">Instant</span>
                    </label>

                    <label class="list-group-item rounded-3 border d-flex align-items-center justify-content-between p-2.5 cursor-pointer">
                        <div class="d-flex align-items-center gap-2.5">
                            <input class="form-check-input mt-0" type="radio" name="preferredPaymentRadio" value="CARD" onchange="savePreferredPaymentMethod('CARD')">
                            <div>
                                <strong class="fs-8 text-dark d-block"><i class="fa-brands fa-cc-visa text-primary me-1"></i> Debit / Credit Card</strong>
                                <span class="text-muted fs-9">Visa / Mastercard ending in •••• 8842</span>
                            </div>
                        </div>
                        <span class="badge bg-light text-dark border fs-9">Card</span>
                    </label>

                    <label class="list-group-item rounded-3 border d-flex align-items-center justify-content-between p-2.5 cursor-pointer">
                        <div class="d-flex align-items-center gap-2.5">
                            <input class="form-check-input mt-0" type="radio" name="preferredPaymentRadio" value="COD" onchange="savePreferredPaymentMethod('COD')">
                            <div>
                                <strong class="fs-8 text-dark d-block"><i class="fa-solid fa-hand-holding-dollar text-warning me-1"></i> Cash on Delivery (COD)</strong>
                                <span class="text-muted fs-9">Pay rider upon delivery</span>
                            </div>
                        </div>
                        <span class="badge bg-warning-subtle text-warning fw-bold fs-9">Cash</span>
                    </label>
                </div>

                <div class="border-top pt-2.5">
                    <label class="form-label fw-bold fs-8 mb-1">Update GCash / Maya Mobile Number</label>
                    <div class="input-group input-group-sm">
                        <input type="tel" class="form-control rounded-start-3 fs-8" id="paymentPhoneInput" placeholder="0917-xxx-xxxx">
                        <button class="btn btn-primary rounded-end-3 px-3 fw-bold fs-8" style="background:#5B3FA8; border:none;" onclick="updatePaymentPhoneNumber()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 6. ABOUT RENTEASE MODAL -->
<div class="modal fade" id="aboutRentEaseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <div class="d-flex align-items-center gap-2">
                    <img src="LOGO.png" alt="RentEase" style="height:32px; width:auto;">
                    <h6 class="modal-title fw-extrabold text-dark fs-7 mb-0">About RentEase</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-1">
                <div class="text-center mb-3 py-2 bg-light rounded-4">
                    <h6 class="fw-extrabold text-dark fs-7 mb-1" style="color:#5B3FA8 !important;">RentEase v2.0</h6>
                    <div class="badge bg-primary-subtle text-primary fw-bold fs-9 mb-1">Easy Rentals. Seamless Events.</div>
                    <p class="fs-9 text-muted mb-0">"Rent. Book. Celebrate."</p>
                </div>

                <div class="d-flex flex-column gap-2 mb-3">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-circle-check text-success fs-8 mt-1"></i>
                        <span class="fs-8 text-dark"><strong>Hassle-Free Event Rentals:</strong> Book tables, chairs, event tents, lights, and PA audio systems with live delivery tracking.</span>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-circle-check text-success fs-8 mt-1"></i>
                        <span class="fs-8 text-dark"><strong>Student & Campus Friendly:</strong> Transparent daily rates, package discounts, and refundable security deposits upon pickup.</span>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-circle-check text-success fs-8 mt-1"></i>
                        <span class="fs-8 text-dark"><strong>Peer-to-Peer Rent Out:</strong> Students and event organizers can post their own equipment to earn extra income on campus.</span>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-headset text-primary fs-8 mt-1"></i>
                        <span class="fs-8 text-dark"><strong>Support Center:</strong> 24/7 ticket dispute resolution and dedicated equipment inspection team.</span>
                    </div>
                </div>

                <div class="bg-light p-2.5 rounded-3 text-center fs-9 text-muted">
                    © 2026 RentEase Event Solutions. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SELLER VERIFICATION REQUEST MODAL -->
<div class="modal fade" id="verificationRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 p-4 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-id-card text-primary fs-4"></i> Student Seller Verification Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-1">
                <div id="verificationStatusBanner" class="p-3 rounded-3 mb-3 fs-8 fw-semibold" style="display:none;"></div>

                <p class="fs-8 text-muted mb-3">
                    To maintain safety and trust on campus, all student sellers must submit their valid ID and residential details for Admin verification before posting items to sell.
                </p>

                <form id="verificationForm" onsubmit="event.preventDefault(); submitSellerVerificationRequest();">
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">Hometown / City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 fs-7" id="vHometown" required placeholder="e.g. Quezon City, Metro Manila">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">Postal Code / Zip Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 fs-7" id="vPostalCode" required placeholder="e.g. 1108">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7">Full Residential Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 fs-7" id="vHomeAddress" required placeholder="e.g. 123 Katipunan Ave, Brgy. Loyola Heights">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">Student Contact Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control rounded-3 fs-7" id="vPhoneNumber" required placeholder="09171234567">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">Guardian Name & Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 fs-7" id="vGuardianInfo" required placeholder="e.g. Maria Santos (09189876543)">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">Valid Identification Type <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3 fs-7" id="vIdType">
                                <option value="Postal ID">Postal ID</option>
                                <option value="School Student ID" selected>School / University Student ID</option>
                                <option value="National ID (PhilSys)">National ID (PhilSys)</option>
                                <option value="Driver's License">Driver's License</option>
                                <option value="Passport">Passport</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">ID Card / Serial Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 fs-7" id="vIdNumber" required placeholder="e.g. PRN-10293847">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7"><i class="fa-solid fa-camera text-primary me-1"></i> Upload Photo of Valid ID / Postal ID <span class="text-danger">*</span></label>
                        <input type="file" class="form-control rounded-3 fs-7" id="vIdPhotoInput" accept="image/*" onchange="previewVerificationIdPhoto(event)">
                        <div id="vIdPhotoPreviewBox" class="mt-2 text-center" style="display:none;">
                            <img id="vIdPhotoPreview" class="img-fluid rounded-3 border shadow-sm" style="max-height: 180px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="button" class="btn btn-light rounded-pill w-50 fw-bold py-2 fs-7 text-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded-pill w-50 fw-bold py-2 fs-7 shadow-sm" style="background: linear-gradient(135deg, #6C5CE7, #5F27CD); border:none;" id="submitVerificationBtn">
                            <i class="fa-solid fa-paper-plane me-1"></i> Submit to Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================
     REPORT UNRETURNED EQUIPMENT MODAL (Owner -> Admin)
     ========================================================== -->
<div class="modal fade" id="reportUnreturnedModal" tabindex="-1" style="z-index: 1080;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger" style="width:38px; height:38px;">
                        <i class="fa-solid fa-flag fs-6"></i>
                    </div>
                    <div>
                        <h6 class="fw-extrabold text-dark mb-0 fs-7">Report Unreturned Item</h6>
                        <span class="fs-9 text-muted">Submit case with photo proof to Admin</span>
                    </div>
                </div>
                <button type="button" class="btn-close fs-9" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2">
                <div class="p-2.5 rounded-3 bg-light border mb-2.5 fs-8">
                    <div class="d-flex justify-content-between text-muted fs-9 mb-1">
                        <span>Order Code:</span>
                        <strong class="text-dark" id="unretModalOrderCode">#RE-10000</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted fs-9 mb-1">
                        <span>Equipment:</span>
                        <strong class="text-dark" id="unretModalItemName">POSPT</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted fs-9">
                        <span>Renter:</span>
                        <strong class="text-danger" id="unretModalRenterName">Pogilameg Tester</strong>
                    </div>
                </div>

                <div class="alert alert-warning border-0 rounded-3 p-2 fs-9 mb-2.5 text-secondary">
                    <i class="fa-solid fa-circle-exclamation text-warning me-1"></i> If approved by Admin, the renter will be penalized with a <strong>5-day rental suspension</strong>.
                </div>

                <div class="mb-2.5">
                    <label class="form-label fs-9 fw-bold text-dark mb-1">Reason for Report</label>
                    <input type="text" class="form-control rounded-3 fs-8" id="unretReportReason" value="Item not returned after rental period" readonly style="background:#F1F5F9;">
                </div>

                <div class="mb-2.5">
                    <label class="form-label fs-9 fw-bold text-dark mb-1">Incident Details & Communication <span class="text-danger">*</span></label>
                    <textarea class="form-control rounded-3 fs-8" id="unretReportDetails" rows="3" placeholder="Provide details: meetup location attempts, lack of response, or unreturned condition..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fs-9 fw-bold text-dark mb-1"><i class="fa-solid fa-camera text-primary me-1"></i> Photo Proof <span class="text-danger">*</span></label>
                    <input type="file" class="form-control rounded-3 fs-8" id="unretPhotoFileInput" accept="image/*" onchange="previewUnretReportPhoto(event)">
                    <input type="hidden" id="unretPhotoDataUrl">
                    <div id="unretPhotoPreviewBox" class="mt-2 text-center" style="display:none;">
                        <img id="unretPhotoPreview" class="img-fluid rounded-3 border shadow-xs" style="max-height: 140px; object-fit: contain;">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill w-50 fw-bold py-2 fs-8" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger rounded-pill w-50 fw-bold py-2 fs-8 shadow-xs" id="btnSubmitUnretReport" onclick="executeSubmitUnreturnedReport()">
                        <i class="fa-solid fa-paper-plane me-1"></i> Submit Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================
     CONFIRM RETURN OF REPORTED UNRETURNED EQUIPMENT MODAL
     (Shown when owner clicks "Mark Returned & Restock" if ticket exists)
     ========================================================== -->
<div class="modal fade" id="confirmReturnReportedTicketModal" tabindex="-1" style="z-index: 1085;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:42px; height:42px; background:linear-gradient(135deg, #FEF3C7, #FDE68A); color:#D97706;">
                        <i class="fa-solid fa-file-shield fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-extrabold text-dark mb-0 fs-7">Confirm Return of Reported Gear</h6>
                        <span class="fs-9 text-muted">Admin Incident Ticket on Record</span>
                    </div>
                </div>
                <button type="button" class="btn-close fs-9" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2">
                <div class="p-3 rounded-3 mb-2.5" style="background:#FFFBEB; border:1.5px solid #FDE68A;">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-warning fs-6 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="fw-bold text-dark fs-8 mb-1">Notice: You previously reported an incident ticket to Admin!</div>
                            <div class="fs-9 text-secondary" style="line-height:1.4;">
                                You reported that the renter did not return this gear for Order <strong class="text-dark font-monospace" id="confirmReturnTicketOrderCode">#RE-00000</strong> (<span id="confirmReturnTicketItemName" class="fw-semibold">Equipment</span>).
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="earlyReturnRequestModal" tabindex="-1" style="z-index: 1085;">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 410px;">
                        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
                            <div class="modal-header border-0 pb-2"><div class="d-flex align-items-center gap-2"><div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary" style="width:42px;height:42px;"><i class="fa-solid fa-rotate-left fs-5"></i></div><div><h6 class="fw-extrabold text-dark mb-0 fs-7">Request Early Return?</h6><span class="fs-9 text-muted">Order <strong id="earlyReturnRequestOrderCode">#RE-00000</strong></span></div></div><button type="button" class="btn-close fs-9" data-bs-dismiss="modal"></button></div>
                            <div class="modal-body p-2"><div class="p-3 rounded-3 mb-3" style="background:#EFF6FF;border:1.5px solid #BFDBFE;"><div class="d-flex align-items-start gap-2"><i class="fa-solid fa-shield-halved text-primary mt-1"></i><div class="fs-8 text-secondary" style="line-height:1.5;">The renter must verify the return before this item can be marked returned or restocked.</div></div></div><p class="text-dark fw-semibold fs-8 mb-3">Send an early-return request to the renter?</p><div class="d-flex gap-2"><button type="button" class="btn btn-light border rounded-pill w-50 fw-bold py-2 fs-8" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary rounded-pill w-50 fw-bold py-2 fs-8" id="earlyReturnRequestConfirm"><i class="fa-solid fa-paper-plane me-1"></i> Send Request</button></div></div>
                        </div>
                    </div>
                </div>
                <div class="p-2.5 rounded-3 bg-light border mb-2.5 fs-8 text-secondary" style="line-height:1.45;">
                    <div class="fw-bold text-dark mb-1.5"><i class="fa-solid fa-info-circle text-primary me-1"></i>If you confirm receipt:</div>
                    <ul class="mb-0 ps-3 fs-9">
                        <li class="mb-1">The ticket sent to Admin <strong>will remain on file for recordkeeping</strong>, but its status and solution will be updated to:
                            <div class="mt-1">
                                <span class="badge bg-success text-white fw-bold px-2 py-1 fs-10 rounded-pill">
                                    <i class="fa-solid fa-boxes-packing me-1"></i>Solution: Item Has Returned
                                </span>
                            </div>
                        </li>
                        <li class="mb-1">The equipment will be automatically restocked into your market inventory.</li>
                        <li>Any temporary rental suspension applied to the renter for this item will be safely cleared.</li>
                    </ul>
                </div>

                <div class="text-center text-dark fw-bold fs-8 mb-2.5">
                    Are you sure the equipment was returned and you want to restock it?
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill w-50 fw-bold py-2 fs-8" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn rounded-pill w-50 fw-bold py-2 fs-8 shadow-xs text-white" id="btnConfirmReturnReportedYes" style="background:linear-gradient(135deg, #10B981, #059669); border:none;" onclick="executeConfirmReturnReportedOrder()">
                        <i class="fa-solid fa-boxes-packing me-1"></i> Yes, Mark Returned
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================
     RENTAL SUSPENSION NOTICE & APPEAL MODAL (Renter -> Admin)
     ========================================================== -->
<div class="modal fade" id="rentalSuspensionAppealModal" tabindex="-1" style="z-index: 1085;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg bg-white">
            <div class="modal-header border-0 pb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger" style="width:40px; height:40px;">
                        <i class="fa-solid fa-ban fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-extrabold text-danger mb-0 fs-7">Rental Privileges Suspended</h6>
                        <span class="fs-9 text-muted">5-Day Penalty Active</span>
                    </div>
                </div>
                <button type="button" class="btn-close fs-9" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2">
                <div class="alert alert-danger border-0 rounded-4 p-3 mb-2.5" style="background:#FEF2F2; border:1px solid #FEE2E2 !important;">
                    <div class="fw-bold text-dark fs-8 mb-1"><i class="fa-solid fa-triangle-exclamation text-danger me-1"></i> You cannot rent equipment</div>
                    <p class="text-secondary mb-2 fs-9" id="suspensionNoticeReason">An unreturned equipment report against your account was approved by Admin.</p>
                    <div class="p-2 rounded-3 bg-white border text-dark fs-9 d-flex justify-content-between align-items-center">
                        <span class="text-muted">Suspension Active Until:</span>
                        <strong class="text-danger" id="suspensionNoticeEndDate">--</strong>
                    </div>
                </div>

                <div class="card border-0 rounded-4 p-3 bg-light mb-2">
                    <h6 class="fw-extrabold text-dark fs-8 mb-1"><i class="fa-solid fa-gavel text-primary me-1" style="color:#5B3FA8;"></i> File an Appeal</h6>
                    <p class="text-muted fs-9 mb-2.5">If you have returned the item or believe this is an error, submit your appeal with proof for Admin review.</p>

                    <div class="mb-2">
                        <label class="form-label fs-9 fw-bold text-dark mb-1">Your Explanation / Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3 fs-8" id="appealReasonText" rows="3" placeholder="Explain the return handover, communication with owner, or why suspension should be lifted..."></textarea>
                    </div>

                    <div class="mb-2.5">
                        <label class="form-label fs-9 fw-bold text-dark mb-1"><i class="fa-solid fa-camera text-primary me-1"></i> Proof / Photo (Receipt or Chat screenshot)</label>
                        <input type="file" class="form-control rounded-3 fs-8" id="appealPhotoFileInput" accept="image/*" onchange="previewAppealPhoto(event)">
                        <input type="hidden" id="appealPhotoDataUrl">
                        <div id="appealPhotoPreviewBox" class="mt-2 text-center" style="display:none;">
                            <img id="appealPhotoPreview" class="img-fluid rounded-3 border shadow-xs" style="max-height: 120px; object-fit: contain;">
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary rounded-pill w-100 py-2 fw-bold fs-8 shadow-xs" style="background: linear-gradient(135deg, #5B3FA8, #341F97); border:none;" id="btnSubmitSuspensionAppeal" onclick="executeSubmitSuspensionAppeal()">
                        <i class="fa-solid fa-paper-plane me-1"></i> Submit Appeal to Admin
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
