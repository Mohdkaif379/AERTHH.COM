<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Aerthh.com | Delivery Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 20% 30%, #1a0f14, #0a0508);
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* FIXED SIZE CONTAINER - INCREASED HEIGHT FOR BETTER SPACING */
        .login-container {
            width: 940px;
            height: 510px;
            background: #0F0712;
            border-radius: 28px;
            box-shadow: 0 30px 50px -15px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(244, 63, 94, 0.12);
            overflow: hidden;
        }

        /* Bottom border only inputs with proper padding */
        .input-bottom {
            background: transparent;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.12);
            border-radius: 0;
            padding: 10px 0 10px 34px;
            width: 100%;
            color: white;
            font-size: 13px;
            transition: all 0.2s;
        }

        .input-bottom:focus {
            outline: none;
            border-bottom-color: #F43F5E;
        }

        .input-bottom::placeholder {
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
        }

        /* Icon wrapper for inputs */
        .input-icon-wrap {
            position: relative;
            margin-bottom: 18px;
        }

        .input-icon-wrap i {
            position: absolute;
            left: 0;
            bottom: 10px;
            color: #F43F5E;
            font-size: 14px;
            opacity: 0.7;
        }

        /* Password toggle with text button */
        .password-toggle-btn {
            position: absolute;
            right: 0;
            bottom: 6px;
            background: transparent;
            border: none;
            color: #FB7185;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .password-toggle-btn:hover {
            background: rgba(251, 113, 133, 0.15);
            color: #F43F5E;
        }

        /* Premium login button */
        .login-btn {
            background: linear-gradient(135deg, #F43F5E, #BE123C);
            border-radius: 12px;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 0;
        }

        .login-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: linear-gradient(115deg, rgba(255, 255, 255, 0) 10%, rgba(255, 255, 255, 0.2) 40%, rgba(255, 255, 255, 0) 60%);
            transform: rotate(25deg);
            transition: all 0.5s;
            opacity: 0;
        }

        .login-btn:hover::after {
            left: 120%;
            opacity: 1;
        }

        .login-btn:active {
            transform: scale(0.98);
        }

        /* Custom checkbox */
        .checkbox-custom {
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]:checked+.checkbox-custom {
            background: #F43F5E;
            border-color: #F43F5E;
        }

        input[type="checkbox"]:checked+.checkbox-custom i {
            display: block;
        }

        .checkbox-custom i {
            font-size: 8px;
            color: white;
            display: none;
        }

        /* CAPTCHA single row styles */
        .captcha-display {
            background: linear-gradient(135deg, #1a0f14, #2d1520);
            border: 1px solid rgba(244, 63, 94, 0.3);
            width: 95px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .captcha-display span {
            font-family: 'Courier New', monospace;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 4px;
            color: #FB7185;
        }

        .captcha-refresh-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(244, 63, 94, 0.3);
            color: #FB7185;
            cursor: pointer;
            transition: all 0.2s;
        }

        .captcha-refresh-btn:hover {
            background: rgba(244, 63, 94, 0.2);
            transform: rotate(15deg);
        }

        .captcha-input-area {
            position: relative;
            flex: 1;
        }

        .captcha-input-area input {
            background: transparent;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.12);
            padding: 10px 0 10px 32px;
            width: 100%;
            color: white;
            font-size: 13px;
        }

        .captcha-input-area input:focus {
            outline: none;
            border-bottom-color: #F43F5E;
        }

        .captcha-input-area input::placeholder {
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
        }

        .captcha-input-area i {
            position: absolute;
            left: 0;
            bottom: 10px;
            color: #F43F5E;
            font-size: 13px;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #F43F5E, #FB7185);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Toast message */
        .toast-notify {
            position: fixed;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2000;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 500;
            backdrop-filter: blur(12px);
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Shake animation */
        @keyframes shakeAnim {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .shake-effect {
            animation: shakeAnim 0.3s ease-in-out;
        }

        /* Left section proper padding */
        .left-section {
            padding: 18px 16px;
        }

        .right-section {
            padding: 18px 20px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="flex h-full">

            <!-- LEFT SECTION - Premium Partner Content -->
            <div class="w-1/2 bg-[#0F0712] border-r border-[#22152a] left-section flex flex-col">
                <!-- Top badges -->
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-black/40 backdrop-blur rounded-2xl border border-[#F43F5E]/30 flex items-center">
                        <img src="{{asset('logo.webp')}}" alt="logo" class="w-[50px] h-[50px] rounded-2xl shadow-lg">
                    </div>
                    <div class="bg-[#F43F5E]/10 p-1.5 rounded-full border border-[#F43F5E]/30">
                        <i class="fas fa-motorcycle text-[#FB7185] text-sm"></i>
                    </div>
                </div>

                <!-- Main content -->
                <div class="flex-1">
                    <div class="inline-block bg-[#F43F5E]/10 rounded-full px-2.5 py-0.5 mb-3">
                        <span class="text-[#FB7185] text-[8px] font-bold">
                            <i class="fas fa-chart-line mr-1 text-[7px]"></i> EARNING BOOST
                        </span>
                    </div>

                    <h2 class="text-xl font-extrabold text-white leading-tight mb-2">
                        Deliver More,<br>
                        <span class="gradient-text">Earn Premium</span>
                    </h2>

                    <p class="text-gray-400 text-[11px] leading-relaxed mb-4">
                        Join the elite delivery force. Get higher incentives, priority support & daily bonus missions.
                    </p>

                    <!-- Stats cards -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-black/30 rounded-xl p-2.5">
                            <i class="fas fa-truck-fast text-[#FB7185] text-sm mb-1 block"></i>
                            <p class="text-gray-400 text-[8px]">Active Today</p>
                            <p class="text-white text-base font-bold">2,450+</p>
                        </div>
                        <div class="bg-black/30 rounded-xl p-2.5">
                            <i class="fas fa-rupee-sign text-[#FB7185] text-sm mb-1 block"></i>
                            <p class="text-gray-400 text-[8px]">Daily Avg.</p>
                            <p class="text-white text-base font-bold">₹1,850</p>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="bg-gradient-to-r from-[#F43F5E]/10 to-transparent p-2.5 rounded-xl border-l-3 border-[#FB7185]">
                        <div class="flex gap-2 items-center">
                            <div class="w-7 h-7 rounded-full bg-[#F43F5E]/20 flex items-center justify-center">
                                <i class="fas fa-user-check text-[#FB7185] text-[9px]"></i>
                            </div>
                            <div>
                                <p class="text-gray-300 text-[9px] italic">"Best decision ever! Premium pay doubled my income."</p>
                                <p class="text-[#FB7185] text-[8px] font-semibold mt-0.5">— Rohan S., Platinum Rider</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer stats -->
                <div class="flex justify-between gap-2 mt-4 pt-3 border-t border-[#22152a] text-[8px] text-gray-500">
                    <span><i class="fas fa-check-circle text-[#10B981] text-[7px] mr-1"></i> 99.8% on-time</span>
                    <span><i class="fas fa-headset text-[#FB7185] text-[7px] mr-1"></i> 24/7 priority</span>
                    <span><i class="fas fa-gem text-[#FB7185] text-[7px] mr-1"></i> Weekly bonus</span>
                </div>
            </div>

            <!-- RIGHT SECTION - Login Form -->
            <div class="w-1/2 bg-[#0F0712] flex flex-col">
                <div class="h-0.5 w-full bg-gradient-to-r from-[#F43F5E] via-[#FB7185] to-[#F43F5E]"></div>

                <div class="right-section flex-1 flex flex-col">
                    <!-- Logo area -->
                    <div class="text-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#1a0f14] to-black rounded-xl flex items-center justify-center border border-[#F43F5E]/30 mx-auto">
                            <i class="fas fa-motorcycle text-[#FB7185] text-2xl"></i>
                        </div>
                        <h1 class="text-base font-bold text-white mt-2">Delivery Partner</h1>
                        <div class="flex items-center justify-center gap-2 mt-1">
                            <span class="h-px w-6 bg-[#F43F5E]/50"></span>
                            <p class="text-gray-400 text-[9px]">Premium Dashboard Access</p>
                            <span class="h-px w-6 bg-[#F43F5E]/50"></span>
                        </div>
                    </div>

                    <form action="{{ route('delivery.login.submit') }}" method="POST" class="flex-1 flex flex-col">
                        @csrf
                        <!-- Employee ID -->
                        <div class="input-icon-wrap">
                            <i class="fas fa-id-card"></i>
                            <input type="text" id="employeeId" name="mobile" class="input-bottom" placeholder="Enter Mobile Number" autocomplete="off" required>
                        </div>

                        <!-- Password with HIDE/SHOW text button -->
                        <div class="input-icon-wrap">
                            <i class="fas fa-key"></i>
                            <input type="password" id="password" name="password" class="input-bottom" placeholder="Secure Password" autocomplete="off" required>
                            <button type="button" class="password-toggle-btn" id="togglePasswordBtn">SHOW</button>
                        </div>

                        <!-- CAPTCHA - SINGLE ROW -->
                        <div class="mb-4">
                            <label class="text-gray-400 text-[9px] mb-1.5 block">
                                <i class="fas fa-shield-alt text-[#FB7185] text-[9px] mr-1"></i> Security Verification
                            </label>
                            <div class="flex items-center gap-2">
                                <div class="captcha-display">
                                    <span id="captchaCodeText">58472</span>
                                </div>
                                <div class="captcha-input-area">
                                    <i class="fas fa-pencil-alt"></i>
                                    <input type="text" id="captchaInputField" placeholder="Enter 5-digit code" maxlength="5" autocomplete="off">
                                </div>
                                <button type="button" id="refreshCaptchaBtn" class="captcha-refresh-btn">
                                    <i class="fas fa-arrows-rotate text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between mb-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" id="rememberCheck">
                                <span class="checkbox-custom"><i class="fas fa-check"></i></span>
                                <span class="text-gray-400 text-[9px]">Keep me logged in</span>
                            </label>
                            <a href="#" id="forgotPasswordLink" class="text-[#FB7185]/70 hover:text-[#FB7185] text-[9px] font-medium transition">Forgot Password?</a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="login-btn w-full text-white rounded-xl flex items-center justify-center gap-2 text-sm">
                            <i class="fas fa-arrow-right-to-bracket text-xs"></i>
                            <span>Partner Login</span>
                            <i class="fas fa-motorcycle text-xs"></i>
                        </button>

                        <div class="relative my-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-[#22152a]"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-3 bg-[#0F0712] text-gray-500 text-[8px] tracking-wide">SECURE DELIVERY ECOSYSTEM</span>
                            </div>
                        </div>

                        <!-- Signup Links Container -->
                        <div class="space-y-2 text-center">
                            <!-- <p class="text-gray-500 text-[9px]">
                                New to fleet? 
                                <a href="#" id="signupRedirectLink" class="text-[#FB7185] hover:text-[#F43F5E] font-semibold transition">Register Here →</a>
                            </p> -->
                            <p class="text-gray-500 text-[9px]">
                                Want to become a delivery partner?
                                <a href="{{ route('delivery.signup') }}" id="applyOnboardingLink" class="text-[#FB7185] hover:text-[#F43F5E] font-semibold transition">Apply for Onboarding →</a>
                            </p>
                        </div>
                    </form>

                    <!-- Security badges -->
                    <div class="flex justify-center gap-4 mt-3 text-[8px] text-gray-500">
                        <span><i class="fas fa-shield-alt text-[#FB7185]/60 mr-1"></i> SSL Secured</span>
                        <span><i class="fas fa-clock text-[#FB7185]/60 mr-1"></i> 24/7 Dispatch</span>
                        <span><i class="fas fa-headset text-[#FB7185]/60 mr-1"></i> Priority Help</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const loginForm = document.getElementById('loginForm');
            const successMsg = @json(session('success') ?? '');
            const errorMsg = @json(session('error') ?? '');
            
            if (successMsg) {
                showToastNotification(successMsg, false);
            }
            if (errorMsg) {
                showToastNotification(errorMsg, true);
            }
            const empIdInput = document.getElementById('employeeId');
            const passwordInput = document.getElementById('password');
            const rememberCheck = document.getElementById('rememberCheck');
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const forgotLink = document.getElementById('forgotPasswordLink');
            const signupLink = document.getElementById('signupRedirectLink');
            const applyOnboardingLink = document.getElementById('applyOnboardingLink');

            const captchaDisplaySpan = document.getElementById('captchaCodeText');
            const captchaInput = document.getElementById('captchaInputField');
            const refreshCaptchaButton = document.getElementById('refreshCaptchaBtn');

            // Password visibility toggle with text (SHOW/HIDE)
            let isPasswordVisible = false;
            togglePasswordBtn.addEventListener('click', () => {
                if (isPasswordVisible) {
                    passwordInput.type = 'password';
                    togglePasswordBtn.textContent = 'SHOW';
                    isPasswordVisible = false;
                } else {
                    passwordInput.type = 'text';
                    togglePasswordBtn.textContent = 'HIDE';
                    isPasswordVisible = true;
                }
            });

            function generateRandomCaptcha() {
                let code = '';
                for (let i = 0; i < 5; i++) code += Math.floor(Math.random() * 10);
                return code;
            }

            let currentCaptchaValue = generateRandomCaptcha();
            captchaDisplaySpan.textContent = currentCaptchaValue;

            function refreshCaptchaCode() {
                currentCaptchaValue = generateRandomCaptcha();
                captchaDisplaySpan.textContent = currentCaptchaValue;
                captchaInput.value = '';
                showToastNotification('CAPTCHA refreshed! Enter the new code.', false);
            }

            refreshCaptchaButton.addEventListener('click', refreshCaptchaCode);

            const validPartnerCredentials = [{
                    id: "DEL1001",
                    pass: "goldpass"
                },
                {
                    id: "9876543210",
                    pass: "rider123"
                },
                {
                    id: "demo@delivery",
                    pass: "demo123"
                },
                {
                    id: "partner@swift",
                    pass: "swift2024"
                },
                {
                    id: "rajesh123",
                    pass: "deliver"
                }
            ];

            function showToastNotification(message, isError = false) {
                const existingToast = document.querySelector('.toast-notify');
                if (existingToast) existingToast.remove();
                const toast = document.createElement('div');
                toast.className = 'toast-notify';
                toast.style.background = isError ? 'rgba(220,38,38,0.95)' : 'rgba(16,185,129,0.95)';
                toast.style.color = 'white';
                toast.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-triangle' : 'fa-check-circle'} text-xs mr-1"></i>${message}`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2600);
            }

            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const empId = empIdInput.value.trim();
                const pwd = passwordInput.value;
                const captchaVal = captchaInput.value.trim();

                if (!empId) {
                    showToastNotification('Please enter Employee ID or mobile number', true);
                    empIdInput.focus();
                    return;
                }
                if (!pwd) {
                    showToastNotification('Please enter your password', true);
                    passwordInput.focus();
                    return;
                }
                if (!captchaVal) {
                    showToastNotification('Please enter the CAPTCHA code', true);
                    captchaInput.focus();
                    return;
                }
                if (captchaVal !== currentCaptchaValue) {
                    showToastNotification('❌ Invalid CAPTCHA! Please try again.', true);
                    refreshCaptchaCode();
                    captchaInput.focus();
                    return;
                }

                const isValid = validPartnerCredentials.some(c => c.id === empId && c.pass === pwd);

                if (isValid) {
                    showToastNotification('✅ Login successful! Redirecting to dashboard...', false);
                    if (rememberCheck.checked) localStorage.setItem('partnerSession', 'active');
                    else sessionStorage.setItem('partnerSession', 'active');

                    const btn = loginForm.querySelector('button[type="submit"]');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i><span class="ml-1"> Verifying gateway...</span>';

                    setTimeout(() => {
                        const rightPanel = document.querySelector('.w-1/2:last-child .right-section');
                        if (rightPanel) {
                            rightPanel.innerHTML = `
                                <div class="text-center py-3">
                                    <div class="w-14 h-14 mx-auto bg-[#F43F5E]/20 rounded-xl flex items-center justify-center mb-3">
                                        <i class="fas fa-check-circle text-2xl text-[#10B981]"></i>
                                    </div>
                                    <h2 class="text-base font-bold text-white mb-1">Welcome, ${empId.length > 12 ? empId.substring(0,10)+'..' : empId}!</h2>
                                    <p class="text-gray-300 text-[9px] mb-4">Premium Partner Dashboard</p>
                                    <div class="bg-black/30 rounded-xl p-3 text-left border border-[#F43F5E]/20">
                                        <div class="flex justify-between text-[9px] border-b border-[#22152a] pb-2 mb-2">
                                            <span class="text-gray-400">Rider Status</span>
                                            <span class="text-[#FB7185] font-medium"><i class="fas fa-circle text-[5px] text-green-400 mr-1 align-middle"></i> Active</span>
                                        </div>
                                        <div class="flex justify-between text-[9px] mt-1.5">
                                            <span class="text-gray-400">Today's Earnings</span>
                                            <span class="text-white font-semibold">₹1,280</span>
                                        </div>
                                        <div class="flex justify-between text-[9px] mt-1">
                                            <span class="text-gray-400">Completed Orders</span>
                                            <span class="text-white font-semibold">8</span>
                                        </div>
                                        <div class="flex justify-between text-[9px] mt-1">
                                            <span class="text-gray-400">Rating</span>
                                            <span class="text-white font-semibold">4.98 ★</span>
                                        </div>
                                    </div>
                                    <button id="logoutDemoButton" class="mt-5 text-[9px] text-gray-400 hover:text-[#FB7185] transition-all bg-black/20 px-3 py-1.5 rounded-full">
                                        <i class="fas fa-sign-out-alt mr-1"></i> Logout (Demo Reset)
                                    </button>
                                </div>
                            `;
                            const logoutButton = document.getElementById('logoutDemoButton');
                            if (logoutButton) {
                                logoutButton.addEventListener('click', () => {
                                    localStorage.clear();
                                    sessionStorage.clear();
                                    window.location.reload();
                                });
                            }
                        }
                    }, 1600);
                } else {
                    showToastNotification('❌ Invalid Employee ID or Password', true);
                    passwordInput.value = '';
                    passwordInput.focus();
                    document.querySelector('.login-container')?.classList.add('shake-effect');
                    setTimeout(() => document.querySelector('.login-container')?.classList.remove('shake-effect'), 400);
                }
            });

            forgotLink.addEventListener('click', (e) => {
                e.preventDefault();
                showToastNotification('📱 OTP sent to your registered mobile number', false);
            });

            signupLink.addEventListener('click', (e) => {
                e.preventDefault();
                showToastNotification('📝 Registration portal will open soon!', false);
            });

            applyOnboardingLink.addEventListener('click', (e) => {
                e.preventDefault();
                showToastNotification('🚀 Onboarding application submitted! Our team will contact you within 24 hours.', false);
            });
        })();
    </script>
</body>

</html>