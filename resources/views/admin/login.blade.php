{{-- resources/views/admin/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aerthh.com - Admin Login</title>
    
    {{-- Prevent caching --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Cube Animation */
        .cube-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .cube {
            position: absolute;
            width: 12px;
            height: 12px;
            border: solid 1.2px rgba(6, 182, 212, 0.1);
            transform-origin: top left;
            transform: scale(0) rotate(0deg) translate(-50%, -50%);
            animation: cube-float 14s ease-in forwards infinite;
            background: rgba(6, 182, 212, 0.02);
            backdrop-filter: blur(1px);
        }
        
        .cube:nth-child(2n) { border-color: rgba(16, 185, 129, 0.1); background: rgba(16, 185, 129, 0.02); }
        .cube:nth-child(3n) { border-color: rgba(59, 130, 246, 0.1); background: rgba(59, 130, 246, 0.02); }
        
        @keyframes cube-float {
            0% { transform: scale(0) rotate(0deg) translate(-50%, -50%); opacity: 0; }
            10% { opacity: 0.5; }
            90% { opacity: 0.3; }
            100% { transform: scale(15) rotate(960deg) translate(-50%, -50%); opacity: 0; }
        }
        
        .cube1 { top: 15%; left: 10%; animation-delay: 0s; }
        .cube2 { top: 75%; left: 85%; animation-delay: 2s; }
        .cube3 { top: 35%; left: 92%; animation-delay: 3.5s; }
        .cube4 { top: 85%; left: 15%; animation-delay: 5.5s; }
        .cube5 { top: 45%; left: 45%; animation-delay: 1.2s; }
        .cube6 { top: 65%; left: 65%; animation-delay: 3s; }
        .cube7 { top: 92%; left: 35%; animation-delay: 4.2s; }
        .cube8 { top: 8%; left: 72%; animation-delay: 6s; }
        
        /* Captcha Styles */
        .captcha-container {
            background: linear-gradient(135deg, #ecfdf5 0%, #e0f2fe 100%);
            border: 1px solid #a5f3fc;
        }
        
        .captcha-text {
            font-family: 'Courier New', monospace;
            letter-spacing: 5px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
            background: linear-gradient(135deg, #06b6d4 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .refresh-captcha:hover {
            transform: rotate(180deg);
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }
        
        .shake-animation {
            animation: shake 0.4s ease-in-out;
        }
        
        .success-check {
            animation: scaleUp 0.3s ease-in-out;
        }
        
        @keyframes scaleUp {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Modal Animation */
        .modal-enter {
            animation: modalFadeIn 0.3s ease-out;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-3 relative bg-gradient-to-br from-cyan-50 via-white to-emerald-50">
    
    <!-- Animated Cube Background -->
    <div class="cube-background">
        <div class="cube cube1"></div>
        <div class="cube cube2"></div>
        <div class="cube cube3"></div>
        <div class="cube cube4"></div>
        <div class="cube cube5"></div>
        <div class="cube cube6"></div>
        <div class="cube cube7"></div>
        <div class="cube cube8"></div>
    </div>

    <!-- Main Container -->
    <div class="max-w-3xl w-full bg-white/90 backdrop-blur-md rounded-xl shadow-lg flex flex-col md:flex-row overflow-hidden min-h-[440px] z-10 border border-white/40">
        
        <!-- LEFT SIDE - LOGIN FORM -->
        <div class="w-full md:w-1/2 p-5 lg:p-6 flex flex-col justify-center bg-white/70 backdrop-blur-sm">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="text-xl lg:text-2xl font-bold text-gray-700 mb-0.5">Welcome Back! Admin</h2>
                <p class="text-gray-400 text-xs">Sign in to your account</p>
            </div>

            <!-- Error Message Display -->
            @if(session('error'))
                <div class="mb-3 p-2 bg-rose-50 border border-rose-200 rounded-lg">
                    <p class="text-rose-500 text-xs"><i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}</p>
                </div>
            @endif

            <!-- Success Message Display (Logout success etc) -->
            @if(session('success'))
                <div class="mb-3 p-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                    <p class="text-emerald-500 text-xs"><i class="fas fa-check-circle mr-1"></i> {{ session('success') }}</p>
                </div>
            @endif

            <!-- Login Form -->
            <form id="loginForm" action="{{ route('admin.login.submit') }}" method="POST" class="space-y-3">
                @csrf
                <!-- Hidden field for captcha verification -->
                <input type="hidden" name="captcha_verified" id="captchaVerified" value="0">
                
                <!-- Email Input -->
                <div class="space-y-0.5">
                    <label class="text-[11px] font-medium text-gray-500 block">
                        <i class="far fa-envelope mr-1 text-cyan-400"></i> Email
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-2.5 top-1/2 -translate-y-1/2 text-cyan-400 text-xs"></i>
                        <input type="email" name="email" id="email" placeholder="john@example.com" value="{{ old('email') }}" required
                               class="w-full pl-8 pr-2.5 py-2 bg-white/90 border border-gray-100 rounded-lg focus:border-cyan-300 focus:outline-none focus:bg-white focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 @error('email') border-rose-300 @enderror">
                    </div>
                    @error('email')
                        <p class="text-rose-500 text-[10px] mt-0.5"><i class="fas fa-exclamation-circle mr-0.5"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-0.5">
                    <label class="text-[11px] font-medium text-gray-500 block">
                        <i class="far fa-lock mr-1 text-emerald-400"></i> Password
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-2.5 top-1/2 -translate-y-1/2 text-emerald-400 text-xs"></i>
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                               class="w-full pl-8 pr-2.5 py-2 bg-white/90 border border-gray-100 rounded-lg focus:border-emerald-300 focus:outline-none focus:bg-white focus:ring-1 focus:ring-emerald-100 transition-all duration-300 text-xs text-gray-600 @error('password') border-rose-300 @enderror">
                    </div>
                    @error('password')
                        <p class="text-rose-500 text-[10px] mt-0.5"><i class="fas fa-exclamation-circle mr-0.5"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- CAPTCHA Section - Single Row -->
                <div class="space-y-0.5 captcha-container p-2.5 rounded-lg">
                    <label class="text-[11px] font-medium text-gray-500 block">
                        <i class="fas fa-shield-alt mr-1 text-cyan-500"></i> Verify
                    </label>
                    
                    <div class="flex items-center space-x-1.5">
                        <!-- Captcha Display -->
                        <div class="flex items-center bg-white/80 rounded-lg border border-cyan-100 overflow-hidden flex-shrink-0">
                            <div class="px-2 py-1.5 bg-gradient-to-r from-cyan-50 to-emerald-50">
                                <span id="captchaDisplay" class="text-base font-bold captcha-text">8A2F</span>
                            </div>
                            <button type="button" onclick="generateCaptcha()" class="px-1.5 py-1.5 bg-white hover:bg-cyan-50 text-cyan-500 transition-all duration-300 refresh-captcha border-l border-cyan-100">
                                <i class="fas fa-sync-alt text-[10px]"></i>
                            </button>
                        </div>
                        
                        <!-- Captcha Input -->
                        <div class="relative flex-1">
                            <i class="fas fa-pencil-alt absolute left-2 top-1/2 -translate-y-1/2 text-emerald-400 text-[10px]"></i>
                            <input type="text" id="captchaInput" placeholder="Code" required
                                   class="w-full pl-7 pr-2 py-1.5 bg-white/90 border border-gray-100 rounded-lg focus:border-emerald-300 focus:outline-none focus:bg-white focus:ring-1 focus:ring-emerald-100 transition-all duration-300 text-xs text-gray-600 uppercase">
                        </div>
                    </div>
                    
                    <div id="captchaMessage" class="text-[10px] mt-0.5 hidden"></div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-1">
                    <label class="flex items-center space-x-1.5 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-3 h-3 rounded border-gray-200 text-cyan-500 focus:ring-cyan-100">
                        <span class="text-[10px] text-gray-500">
                            <i class="far fa-check-square mr-0.5 text-cyan-400 text-[10px]"></i> Remember me
                        </span>
                    </label>
                    <a href="#" class="text-[10px] font-medium text-emerald-500 hover:text-emerald-600">
                        <i class="far fa-question-circle mr-0.5"></i> Forgot Password?
                    </a>
                </div>

                <!-- Login Button -->
                <button type="submit" id="loginBtn" class="w-full bg-gradient-to-r from-cyan-500 to-emerald-500 text-white font-semibold py-2 rounded-lg hover:from-cyan-600 hover:to-emerald-600 transform hover:scale-[1.01] transition-all duration-300 shadow-sm text-xs">
                    <i class="fas fa-sign-in-alt mr-1.5 text-xs"></i> Sign In
                </button>
            </form>
        </div>

        <!-- RIGHT SIDE - LOGO IN CIRCLE -->
        <div class="w-full md:w-1/2 bg-gradient-to-br from-cyan-50/80 via-white to-emerald-50/80 backdrop-blur-sm flex items-center justify-center p-4 relative overflow-hidden">
            <!-- Floating mini cubes -->
            <div class="absolute w-12 h-12 border border-cyan-100/50 rotate-12 top-3 right-3 animate-pulse"></div>
            <div class="absolute w-8 h-8 border border-emerald-100/50 -rotate-12 bottom-6 left-3 animate-bounce" style="animation-duration: 3s;"></div>
            
            <!-- CIRCLE WITH IMAGE -->
            <div class="relative z-10 text-center">
                <!-- Image Circle -->
                <div class="mb-3 flex justify-center">
                    <div class="w-28 h-28 rounded-full  p-1 shadow-lg">
                        <div class="w-full h-full rounded-full bg-white overflow-hidden">
                            <img src="https://aerthh.com/storage/app/public/company/2025-03-26-67e3da8f9b411.webp" 
                                 alt="Aerthh Logo" 
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://via.placeholder.com/150/06b6d4/ffffff?text=AERTH'">
                        </div>
                    </div>
                </div>
                
                <h1 class="text-xl font-bold text-gray-600 mb-0.5 tracking-tight">
                    <i class="fas fa-crown text-yellow-200 mr-1 text-sm"></i>
                    <span class="text-transparent bg-gradient-to-r from-cyan-500 to-emerald-500 bg-clip-text">AERTH</span>
                </h1>
                <p class="text-gray-400 text-[9px] max-w-xs mx-auto">
                    <i class="far fa-gem mr-0.5 text-cyan-400 text-[9px]"></i>
                    Averythink Technology
                </p>
                
                <div class="mt-2 flex justify-center space-x-1.5">
                    <i class="fas fa-circle text-cyan-200 text-[4px] animate-pulse"></i>
                    <i class="fas fa-circle text-emerald-200 text-[4px] animate-pulse delay-150"></i>
                    <i class="fas fa-circle text-teal-200 text-[4px] animate-pulse delay-300"></i>
                </div>

                <div class="mt-2 grid grid-cols-3 gap-1 text-gray-400 text-[9px]">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-truck text-cyan-400 text-xs mb-0.5"></i>
                        <span class="text-gray-300">Free</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="fas fa-shield-alt text-emerald-400 text-xs mb-0.5"></i>
                        <span class="text-gray-300">Secure</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="fas fa-undo-alt text-teal-400 text-xs mb-0.5"></i>
                        <span class="text-gray-300">Returns</span>
                    </div>
                </div>
                
                <div class="mt-2 flex justify-center space-x-3 text-gray-300 text-[9px]">
                    <i class="fab fa-cc-visa hover:text-cyan-500 transition-colors"></i>
                    <i class="fab fa-cc-mastercard hover:text-emerald-500 transition-colors"></i>
                    <i class="fab fa-cc-paypal hover:text-cyan-500 transition-colors"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- SUCCESS MODAL - Sirf Login ke baad dikhega -->
    <div id="successModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-8 max-w-xs mx-4 transform scale-0 transition-all duration-300 success-check shadow-2xl">
            <div class="text-center">
                <!-- Success Animation -->
                <div class="w-20 h-20 bg-gradient-to-r from-cyan-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                    <i class="fas fa-check text-white text-4xl"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Login Successful!</h3>
                <p class="text-gray-500 text-sm mb-6">Welcome back, Admin</p>
                
                <!-- Loading Spinner -->
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <div class="w-2 h-2 bg-cyan-500 rounded-full animate-pulse"></div>
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse delay-150"></div>
                    <div class="w-2 h-2 bg-cyan-500 rounded-full animate-pulse delay-300"></div>
                </div>
                
                <p class="text-gray-400 text-xs">Redirecting to dashboard...</p>
            </div>
        </div>
    </div>

    <script>
        // Generate random captcha (4 characters)
        function generateCaptcha() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ0123456789';
            let captcha = '';
            for (let i = 0; i < 4; i++) {
                captcha += chars[Math.floor(Math.random() * chars.length)];
            }
            document.getElementById('captchaDisplay').textContent = captcha;
            document.getElementById('captchaInput').value = '';
            document.getElementById('captchaMessage').classList.add('hidden');
            document.getElementById('captchaVerified').value = '0';
        }
        
        // Client-side captcha validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const captchaDisplay = document.getElementById('captchaDisplay').textContent;
            const captchaInput = document.getElementById('captchaInput').value.toUpperCase();
            const captchaMessage = document.getElementById('captchaMessage');
            const captchaContainer = document.querySelector('.captcha-container');
            const captchaVerified = document.getElementById('captchaVerified');
            
            captchaContainer.classList.remove('shake-animation');
            
            if (captchaInput === captchaDisplay) {
                captchaMessage.className = 'text-[10px] mt-0.5 text-emerald-500 font-medium';
                captchaMessage.innerHTML = '<i class="fas fa-check-circle mr-0.5"></i> Verified!';
                captchaMessage.classList.remove('hidden');
                captchaVerified.value = '1'; // Set hidden field to verified
                
                // Let the form submit normally to Laravel
                return true;
            } else {
                e.preventDefault(); // Stop form submission
                captchaContainer.classList.add('shake-animation');
                captchaMessage.className = 'text-[10px] mt-0.5 text-rose-500 font-medium';
                captchaMessage.innerHTML = '<i class="fas fa-times-circle mr-0.5"></i> Invalid captcha!';
                captchaMessage.classList.remove('hidden');
                captchaVerified.value = '0';
                
                setTimeout(() => {
                    captchaContainer.classList.remove('shake-animation');
                }, 400);
                
                generateCaptcha();
                return false;
            }
        });
        
        // Show success modal and redirect to dashboard - SIRF TAB CALL HOGA JAB SUCCESS HO
        function showSuccessModalAndRedirect() {
            const modal = document.getElementById('successModal');
            const modalContent = document.querySelector('#successModal > div');
            
            modal.classList.remove('hidden');
            modalContent.classList.add('scale-100');
            
            setTimeout(function() {
                window.location.href = '/dashboard';
            }, 2000);
        }
        
        window.onload = function() {
            generateCaptcha();
        };
        
        document.getElementById('captchaInput').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>

</body>
</html>