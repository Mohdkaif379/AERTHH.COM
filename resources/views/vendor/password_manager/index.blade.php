{{-- resources/views/vendor/password_manager/index.blade.php --}}

@extends('vendor.layout.navbar')

@section('content')
<div class="min-h-screen py-8 px-4 transition-colors duration-300 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                <i class="fas fa-key text-orange-500 mr-3"></i>
                Password Manager
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage and secure your passwords with our smart password manager</p>
        </div>

        {{-- Two Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- LEFT COLUMN: Change Password Form --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300">
                {{-- Card Header - Dark mode me light orange --}}
                <div class="bg-orange-500 dark:bg-orange-400 px-6 py-4 transition-colors duration-300">
                    <h2 class="text-white dark:text-gray-900 font-bold text-lg flex items-center gap-2">
                        <i class="fas fa-exchange-alt"></i>
                        Change Password
                    </h2>
                </div>
                
                <div class="p-6">
                    {{-- Session Success Message --}}
                    @if(session('success'))
                    <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 border-l-4 border-green-500">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    {{-- Session Error Message --}}
                    @if($errors->any())
                    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 border-l-4 border-red-500">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <div class="inline-block">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- JS Success Message --}}
                    <div id="successMessage" class="hidden mb-4 p-3 rounded-lg bg-green-100 text-green-700 border-l-4 border-green-500">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span id="successText"></span>
                    </div>

                    {{-- JS Error Message --}}
                    <div id="errorMessage" class="hidden mb-4 p-3 rounded-lg bg-red-100 text-red-700 border-l-4 border-red-500">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span id="errorText"></span>
                    </div>

                    {{-- AI Suggestion Toast --}}
                    <div id="aiToast" class="hidden mb-4 p-3 rounded-lg bg-orange-100 text-orange-700 border-l-4 border-orange-500 animate-pulse">
                        <i class="fas fa-robot mr-2"></i>
                        <span id="aiToastText">AI suggested a strong password for you!</span>
                    </div>

                    <form id="changePasswordForm" action="{{ route('vendor.password.manager.update') }}" method="Post">
                        @csrf
                      
                        {{-- Current Password --}}
                        <div class="mb-5">
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                <i class="fas fa-shield-alt text-orange-500 dark:text-orange-400 mr-2"></i>
                                Current Password
                            </label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 dark:text-white focus:border-orange-500 dark:focus:border-orange-400 focus:outline-none transition"
                                       placeholder="Enter current password" required>
                                <button type="button" onclick="togglePassword('current_password')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-orange-500 dark:hover:text-orange-400">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        {{-- New Password --}}
                        <div class="mb-5">
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-gray-700 dark:text-gray-300 font-medium">
                                    <i class="fas fa-plus-circle text-orange-500 dark:text-orange-400 mr-2"></i>
                                    New Password
                                </label>
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="suggestStrongPassword()" class="text-xs bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300 px-2 py-1 rounded-full flex items-center gap-1 hover:bg-orange-200 dark:hover:bg-orange-800 transition">
                                        <i class="fas fa-robot text-xs"></i>
                                        Suggest Password
                                    </button>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="password" name="new_password" id="new_password" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 dark:text-white focus:border-orange-500 dark:focus:border-orange-400 focus:outline-none transition"
                                       placeholder="Enter new password" required>
                                <button type="button" onclick="togglePassword('new_password')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-orange-500 dark:hover:text-orange-400">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                <i class="fas fa-keyboard text-orange-500"></i>
                                Type your own password or use the Suggest Password button.
                            </p>
                            
                            {{-- Strength Meter --}}
                            <div class="mt-3">
                                <div class="flex gap-2 mb-2">
                                    <div id="strength1" class="h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-gray-700 transition-all"></div>
                                    <div id="strength2" class="h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-gray-700 transition-all"></div>
                                    <div id="strength3" class="h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-gray-700 transition-all"></div>
                                    <div id="strength4" class="h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-gray-700 transition-all"></div>
                                </div>
                                <p id="strengthText" class="text-xs text-gray-500 dark:text-gray-400">Enter new password</p>
                            </div>

                            {{-- Requirements Checklist --}}
                            <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                                <div id="req-length" class="flex items-center gap-1 text-gray-500 dark:text-gray-400">❌ 8+ characters</div>
                                <div id="req-upper" class="flex items-center gap-1 text-gray-500 dark:text-gray-400">❌ Uppercase letter</div>
                                <div id="req-lower" class="flex items-center gap-1 text-gray-500 dark:text-gray-400">❌ Lowercase letter</div>
                                <div id="req-number" class="flex items-center gap-1 text-gray-500 dark:text-gray-400">❌ Number</div>
                                <div id="req-special" class="flex items-center gap-1 text-gray-500 dark:text-gray-400 col-span-2">❌ Special character (@$!%*?&)</div>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-6">
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                <i class="fas fa-check-circle text-orange-500 dark:text-orange-400 mr-2"></i>
                                Confirm Password
                            </label>
                            <div class="relative">
                                <input type="password" name="new_password_confirmation" id="confirm_password" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 dark:text-white focus:border-orange-500 dark:focus:border-orange-400 focus:outline-none transition"
                                       placeholder="Confirm new password" required>
                                <button type="button" onclick="togglePassword('confirm_password')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-orange-500 dark:hover:text-orange-400">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <p id="matchText" class="text-xs mt-1"></p>
                        </div>

                        {{-- Update Button --}}
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 dark:from-orange-400 dark:to-orange-500 text-white font-semibold py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 dark:hover:from-orange-500 dark:hover:to-orange-600 transform hover:scale-[1.02] transition-all duration-300 shadow-lg">
                            <i class="fas fa-save mr-2"></i>
                            Update Password
                        </button>
                    </form>

                    {{-- Forget Password Link --}}
                    <div class="text-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="#" class="text-orange-500 dark:text-orange-400 hover:text-orange-600 dark:hover:text-orange-300 text-sm">
                            <i class="fas fa-question-circle mr-1"></i>
                            Forget Password?
                        </a>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Tips & Content --}}
            <div class="space-y-6">
                {{-- Security Tips Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 dark:from-orange-400 dark:to-orange-500 px-6 py-4 transition-colors duration-300">
                        <h2 class="text-white dark:text-gray-900 font-bold text-lg flex items-center gap-2">
                            <i class="fas fa-lightbulb"></i>
                            Security Tips
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start gap-3 p-3 bg-orange-50 dark:bg-gray-700 rounded-xl">
                                <i class="fas fa-check-circle text-green-500 mt-1 text-lg"></i>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">Use Unique Passwords</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Never reuse passwords across different websites or apps</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-orange-50 dark:bg-gray-700 rounded-xl">
                                <i class="fas fa-check-circle text-green-500 mt-1 text-lg"></i>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">Enable 2FA</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Two-factor authentication adds an extra layer of security</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-orange-50 dark:bg-gray-700 rounded-xl">
                                <i class="fas fa-check-circle text-green-500 mt-1 text-lg"></i>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">Regular Updates</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Change your passwords every 3-6 months</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-orange-50 dark:bg-gray-700 rounded-xl">
                                <i class="fas fa-check-circle text-green-500 mt-1 text-lg"></i>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">Password Manager</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Use a trusted password manager to store credentials</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Strong Password Guide Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300">
                    <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 transition-colors duration-300">
                        <h2 class="text-gray-800 dark:text-white font-bold text-lg flex items-center gap-2">
                            <i class="fas fa-star text-orange-500 dark:text-orange-400"></i>
                            What Makes a Strong Password?
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                <span>Minimum <strong class="text-orange-500 dark:text-orange-400">8 characters</strong> long</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                <span>Includes <strong class="text-orange-500 dark:text-orange-400">uppercase & lowercase</strong> letters</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                <span>Contains at least <strong class="text-orange-500 dark:text-orange-400">one number</strong></span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                <span>Has <strong class="text-orange-500 dark:text-orange-400">special characters</strong> (@$!%*?&)</span>
                            </div>
                        </div>
                        <div class="mt-5 p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-gray-700 dark:to-gray-700 rounded-xl">
                            <p class="text-sm text-gray-700 dark:text-gray-300 text-center">
                                <i class="fas fa-key text-orange-500 dark:text-orange-400 mr-2"></i>
                                <strong class="text-orange-500 dark:text-orange-400">Example:</strong> MyP@ssw0rd2024!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Remove Auto AI Suggest on Focus to allow manual typing
    const newPasswordInput = document.getElementById('new_password');
    let aiSuggested = false;
    
    // AI Password Suggestion Function
    function suggestStrongPassword() {
        const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowercase = 'abcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';
        const special = '@$!%*?&';
        
        let generatedPassword = '';
        generatedPassword += uppercase.charAt(Math.floor(Math.random() * uppercase.length));
        generatedPassword += lowercase.charAt(Math.floor(Math.random() * lowercase.length));
        generatedPassword += numbers.charAt(Math.floor(Math.random() * numbers.length));
        generatedPassword += special.charAt(Math.floor(Math.random() * special.length));
        
        const allChars = uppercase + lowercase + numbers + special;
        for (let i = generatedPassword.length; i < 12; i++) {
            generatedPassword += allChars.charAt(Math.floor(Math.random() * allChars.length));
        }
        
        generatedPassword = generatedPassword.split('').sort(() => Math.random() - 0.5).join('');
        
        document.getElementById('new_password').value = generatedPassword;
        document.getElementById('confirm_password').value = '';
        
        aiSuggested = true;
        checkStrength();
        showAIToast('🤖 AI suggested a strong password for you!');
    }
    
    function showAIToast(message) {
        const toast = document.getElementById('aiToast');
        const toastText = document.getElementById('aiToastText');
        toastText.innerHTML = message;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }
    
    // Password Strength Checker
    const password = document.getElementById('new_password');
    const confirm = document.getElementById('confirm_password');
    
    const strength1 = document.getElementById('strength1');
    const strength2 = document.getElementById('strength2');
    const strength3 = document.getElementById('strength3');
    const strength4 = document.getElementById('strength4');
    const strengthText = document.getElementById('strengthText');
    const matchText = document.getElementById('matchText');
    
    const reqLength = document.getElementById('req-length');
    const reqUpper = document.getElementById('req-upper');
    const reqLower = document.getElementById('req-lower');
    const reqNumber = document.getElementById('req-number');
    const reqSpecial = document.getElementById('req-special');

    function checkStrength() {
        let pwd = password.value;
        
        let hasLength = pwd.length >= 8;
        let hasUpper = /[A-Z]/.test(pwd);
        let hasLower = /[a-z]/.test(pwd);
        let hasNumber = /[0-9]/.test(pwd);
        let hasSpecial = /[@$!%*?&]/.test(pwd);
        
        updateRequirement(reqLength, hasLength);
        updateRequirement(reqUpper, hasUpper);
        updateRequirement(reqLower, hasLower);
        updateRequirement(reqNumber, hasNumber);
        updateRequirement(reqSpecial, hasSpecial);
        
        let score = 0;
        if (hasLength) score++;
        if (hasUpper && hasLower) score++;
        if (hasNumber) score++;
        if (hasSpecial) score++;
        
        let colors = ['bg-gray-200', 'bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
        let texts = ['', '❌ Weak', '⚠️ Fair', '👍 Good', '✅ Strong'];
        let textColors = ['', 'text-red-500', 'text-orange-500', 'text-yellow-600', 'text-green-500'];
        
        [strength1, strength2, strength3, strength4].forEach((bar, i) => {
            bar.className = `h-1.5 flex-1 rounded-full transition-all ${i < score ? colors[score] : 'bg-gray-200 dark:bg-gray-700'}`;
        });
        
        if (pwd.length === 0) {
            strengthText.innerHTML = 'Enter new password';
            strengthText.className = 'text-xs text-gray-500 dark:text-gray-400';
            aiSuggested = false;
        } else {
            strengthText.innerHTML = texts[score];
            strengthText.className = `text-xs ${textColors[score]} mt-1`;
        }
        
        checkMatch();
    }
    
    function updateRequirement(element, isMet) {
        if (isMet) {
            element.innerHTML = element.innerHTML.replace('❌', '✅');
            element.className = 'flex items-center gap-1 text-green-600 dark:text-green-400';
        } else {
            element.innerHTML = element.innerHTML.replace('✅', '❌');
            element.className = 'flex items-center gap-1 text-gray-500 dark:text-gray-400';
        }
    }
    
    function checkMatch() {
        if (confirm.value.length === 0) {
            matchText.innerHTML = '';
        } else if (password.value === confirm.value) {
            matchText.innerHTML = '✅ Passwords match!';
            matchText.className = 'text-xs text-green-600 dark:text-green-400 mt-1';
        } else {
            matchText.innerHTML = '❌ Passwords do not match';
            matchText.className = 'text-xs text-red-500 mt-1';
        }
    }
    
    function togglePassword(fieldId) {
        let field = document.getElementById(fieldId);
        let icon = field.nextElementSibling.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
    
    password.addEventListener('input', checkStrength);
    confirm.addEventListener('input', checkMatch);
    
    // Form Submit
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        let pwd = password.value;
        let hasLength = pwd.length >= 8;
        let hasUpper = /[A-Z]/.test(pwd);
        let hasLower = /[a-z]/.test(pwd);
        let hasNumber = /[0-9]/.test(pwd);
        let hasSpecial = /[@$!%*?&]/.test(pwd);

        if (!hasLength || !hasUpper || !hasLower || !hasNumber || !hasSpecial) {
            e.preventDefault();
            showMessage('New password must contain at least one uppercase, one lowercase, one number, and one special character (@$!%*?&)', 'error');
            return;
        }

        if (password.value !== confirm.value) {
            e.preventDefault();
            showMessage('New password and confirm password do not match!', 'error');
            return;
        }
        // Let the form submit normally to the backend
    });
    
    function showMessage(message, type) {
        const msgDiv = document.getElementById(type + 'Message');
        const msgText = document.getElementById(type + 'Text');
        msgText.innerHTML = message;
        msgDiv.classList.remove('hidden');
        setTimeout(() => {
            msgDiv.classList.add('hidden');
        }, 3000);
    }
</script>

<style>
    input:focus {
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }
</style>
@endsection