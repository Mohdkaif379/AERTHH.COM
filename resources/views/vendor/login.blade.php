<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor Login</title>
<script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
      20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .captcha-shake {
      animation: shake 0.4s ease-in-out;
    }
  </style>
</head>
<body class="bg-black min-h-screen flex items-center justify-center">

  <div class="w-full max-w-4xl grid md:grid-cols-2 rounded-3xl overflow-hidden shadow-[0_0_60px_rgba(0,0,0,0.6)]">

    <!-- LEFT PREMIUM DARK -->
    <div class="hidden md:flex flex-col justify-center px-14 bg-gradient-to-br from-black via-gray-900 to-gray-800 text-white relative">
      <!-- Logo -->
      <img src="https://aerthh.com/storage/app/public/company/2025-03-26-67e3da8f9b411.webp" alt="logo" class="w-12 h-12 mb-6 rounded-lg shadow-xl shadow-black/50">
      <div class="absolute top-10 left-10 w-32 h-32 bg-orange-500/10 blur-3xl rounded-full"></div>

      <h1 class="text-4xl font-bold mb-4 leading-tight">Vendor Dashboard</h1>
      <p class="text-gray-400 mb-10">Control your business with powerful tools, insights and real-time sales tracking.</p>

      <div class="space-y-6">
        <div class="flex items-center gap-4">
          <i class="fa-solid fa-user text-orange-400 text-xl"></i>
          <p class="text-gray-300 text-sm">Secure vendor access</p>
        </div>

        <div class="flex items-center gap-4">
          <i class="fa-solid fa-store text-orange-400 text-xl"></i>
          <p class="text-gray-300 text-sm">Manage products & orders</p>
        </div>

        <div class="flex items-center gap-4">
          <i class="fa-solid fa-chart-line text-orange-400 text-xl"></i>
          <p class="text-gray-300 text-sm">Track sales performance</p>
        </div>
      </div>
    </div>

    <!-- RIGHT GLASS LOGIN -->
    <div class="bg-white/5 backdrop-blur-2xl p-8 md:p-10 text-white border-l border-white/10">
      <h2 class="text-3xl font-semibold mb-2">Vendor Access</h2>
      <p class="text-gray-400 mb-8">Enter your credentials to access your account</p>

      <form id="loginForm" class="space-y-6 " action="{{route('vendor.login.submit')}}" method="POST">
@csrf
        <!-- Hidden field for captcha verification -->
        <input type="hidden" name="captcha_verified" id="captchaVerified" value="0">

        <!-- Email -->

        <div>
          <label class="text-sm text-gray-400">Email</label>
          <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
            <i class="fa fa-envelope text-gray-500 mr-2"></i>
            <input id="email" type="email" name="email" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter email" required>
          </div>
        </div>

        <!-- Password with toggle -->
        <div>
          <label class="text-sm text-gray-400">Password</label>
          <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
            <i class="fa fa-lock text-gray-500 mr-2"></i>
            <input id="password" type="password" name="password" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter password" required>
            <span id="togglePassword" class="text-xs text-orange-400 cursor-pointer ml-2">SHOW</span>
          </div>
        </div>

        <!-- CAPTCHA -->
        <div>
          <label class="text-sm text-gray-400">Captcha</label>
          <div id="captchaErrorMsg" class="text-red-400 text-xs mt-1 hidden mb-2"></div>
          <div class="flex items-center gap-3 mt-1 border-b border-gray-700 px-1 focus-within:border-orange-400 transition">
            <div id="captchaBox" class="text-orange-400 font-semibold tracking-widest"></div>
            <input id="captchaInput" type="text" name="captcha" placeholder="Enter" class="flex-1 py-2 bg-black outline-none text-white" required>
            <button type="button" onclick="generateCaptcha()" class="text-orange-400 text-lg">
              <i class="fa-solid fa-rotate"></i>
            </button>
          </div>
        </div>

        <!-- Loading & Error Messages -->
        <div id="loading" class="hidden flex items-center justify-center gap-2 text-orange-400">
          <i class="fa fa-spinner fa-spin"></i>
          Logging in...
        </div>
        <div id="errorMsg" class="hidden p-3 bg-red-500/20 border border-red-500/50 rounded-xl text-red-400 text-sm"></div>

        <!-- Options -->
        <div class="flex justify-between text-sm text-gray-400">
          <label class="flex items-center gap-2">
            <input type="checkbox" class="accent-orange-500">
            Remember
          </label>
          <a href="#" class="hover:text-orange-400 transition">Forgot Password</a>
        </div>

        <!-- Button -->
        <button type="submit" id="loginBtn" class="w-full bg-gradient-to-r from-orange-500 to-amber-400 hover:from-orange-600 hover:to-amber-500 text-black font-semibold py-2 rounded-xl transition shadow-lg shadow-orange-500/20">
          Login
        </button>
      </form>
    </div>

  </div>

  <!-- JS -->
  <script>
    // Password toggle
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', () => {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      toggle.textContent = type === 'password' ? 'SHOW' : 'HIDE';
    });

    // Captcha
    function generateCaptcha() {
      const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
      let captcha = '';
      for (let i = 0; i < 5; i++) {
        captcha += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      document.getElementById('captchaBox').innerText = captcha;
      window.generatedCaptcha = captcha;
    }

    // Login API integration
    // Form already has action="{{route('vendor.login.submit')}}", normal submit


    // Client-side captcha validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const captchaBox = document.getElementById('captchaBox').innerText;
      const captchaInput = document.getElementById('captchaInput').value.toUpperCase();
      const captchaContainer = document.querySelector('div:has(#captchaBox)'); // Parent div for shake
      const captchaVerified = document.getElementById('captchaVerified');

      if (captchaInput !== captchaBox) {
        e.preventDefault(); // Stop form submission
        
        // Show response message (no alert), shake, regenerate
        const errorMsg = document.getElementById('captchaErrorMsg');
        errorMsg.textContent = 'Captcha mismatch! Try again.';
        errorMsg.classList.remove('hidden');
        captchaContainer.classList.add('captcha-shake');
        captchaVerified.value = '0';
        
        setTimeout(() => {
          captchaContainer.classList.remove('captcha-shake');
          errorMsg.classList.add('hidden');
          generateCaptcha();
          document.getElementById('captchaInput').value = ''; // Clear input
          document.getElementById('captchaInput').focus();
        }, 1500);
        
        return false;
      } else {
        captchaVerified.value = '1'; // Verified
      }
    });

    // Init captcha
    generateCaptcha();
  </script>

</body>
</html>
