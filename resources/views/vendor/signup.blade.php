<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor Signup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    ::-webkit-scrollbar {
      display: none;
    }

    html {
      scrollbar-width: none;
    }

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
<body class="bg-black min-h-screen py-4 flex items-center justify-center">

  <div class="w-full max-w-4xl grid md:grid-cols-2 rounded-3xl overflow-hidden shadow-[0_0_60px_rgba(0,0,0,0.6)]">

    <div class="hidden md:flex flex-col justify-center px-10 py-8 bg-gradient-to-br from-black via-gray-900 to-gray-800 text-white relative">
      <img src="https://aerthh.com/storage/app/public/company/2025-03-26-67e3da8f9b411.webp" alt="logo" class="w-12 h-12 mb-4 rounded-lg shadow-xl shadow-black/50">
      <div class="absolute top-10 left-10 w-32 h-32 bg-orange-500/10 blur-3xl rounded-full"></div>

      <h1 class="text-3xl font-bold mb-3 leading-tight">Join Vendor Dashboard</h1>
      <p class="text-gray-400 mb-6">Create your vendor account and start managing products, orders, and sales.</p>
      <p class="text-gray-500 text-sm mb-8 max-w-sm">
        Get started with a streamlined onboarding flow built for fast setup, secure verification, and smooth store management.
      </p>

      <div class="space-y-4">
        <div class="flex items-center gap-4">
          <i class="fa-solid fa-user-plus text-orange-400 text-xl"></i>
          <p class="text-gray-300 text-sm">Quick vendor registration</p>
        </div>

        <div class="flex items-center gap-4">
          <i class="fa-solid fa-box text-orange-400 text-xl"></i>
          <p class="text-gray-300 text-sm">Add and manage products</p>
        </div>

        <div class="flex items-center gap-4">
          <i class="fa-solid fa-chart-line text-orange-400 text-xl"></i>
          <p class="text-gray-300 text-sm">Track performance in real time</p>
        </div>

        <div class="flex items-center gap-4">
          <i class="fa-solid fa-shield-halved text-orange-400 text-xl"></i>
          <p class="text-gray-300 text-sm">Secure document verification</p>
        </div>

        <div class="flex items-center gap-4">
          <i class="fa-solid fa-rocket text-orange-400 text-xl"></i>
          <p class="text-gray-300 text-sm">Launch your store faster</p>
        </div>
      </div>

      <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
        <p class="text-sm text-gray-300 leading-relaxed">
          Need help during signup? Keep your documents ready and complete each tab step by step for a smooth setup.
        </p>
      </div>
    </div>

    <div class="bg-white/5 backdrop-blur-2xl p-7 md:p-8 text-white border-l border-white/10">
      <h2 class="text-2xl font-semibold mb-2">Vendor Signup</h2>
      <p class="text-gray-400 mb-6">Fill in your details to create a new account</p>

      <form id="signupForm" class="space-y-4" action="{{ route('vendor.signup.submit') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="grid grid-cols-3 gap-2 rounded-2xl bg-black/30 p-1 border border-white/10">
          <button type="button" data-tab-target="profileTab" class="signup-tab-btn rounded-xl px-3 py-2 text-sm font-semibold transition bg-orange-500 text-black">
            Profile Details
          </button>
          <button type="button" data-tab-target="addressTab" class="signup-tab-btn rounded-xl px-3 py-2 text-sm font-semibold transition text-gray-300 hover:text-white">
            Address
          </button>
          <button type="button" data-tab-target="documentsTab" class="signup-tab-btn rounded-xl px-3 py-2 text-sm font-semibold transition text-gray-300 hover:text-white">
            Documents
          </button>
        </div>

        <div id="formErrorMsg" class="hidden p-3 bg-red-500/20 border border-red-500/50 rounded-xl text-red-400 text-sm"></div>

        <div id="profileTab" class="signup-tab-panel space-y-4">
          <div>
            <label class="text-sm text-gray-400">Name</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-user text-gray-500 mr-2"></i>
              <input id="name" type="text" name="name" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter name" required>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">Email</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-envelope text-gray-500 mr-2"></i>
              <input id="email" type="email" name="email" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter email" required>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">Phone</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-phone text-gray-500 mr-2"></i>
              <input id="phone" type="text" name="phone" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter phone number" required>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">Profile Image</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-image text-gray-500 mr-2"></i>
              <input id="image" type="file" name="image" class="w-full py-2 bg-black outline-none text-white file:mr-3 file:rounded-lg file:border-0 file:bg-orange-500 file:px-3 file:py-1.5 file:text-black file:font-semibold" accept="image/*">
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">Password</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-lock text-gray-500 mr-2"></i>
              <input id="password" type="password" name="password" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter password" required>
              <span id="togglePassword" class="text-xs text-orange-400 cursor-pointer ml-2">SHOW</span>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">Confirm Password</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-lock text-gray-500 mr-2"></i>
              <input id="password_confirmation" type="password" name="password_confirmation" class="w-full py-2 bg-black outline-none text-white" placeholder="Confirm password" required>
            </div>
          </div>

          <div class="flex justify-end pt-2">
            <button type="button" data-nav="next" class="px-5 py-2 rounded-xl bg-orange-500 text-black font-semibold hover:bg-orange-400 transition">
              Next
            </button>
          </div>
        </div>

        <div id="addressTab" class="signup-tab-panel hidden space-y-4">
          <div>
            <label class="text-sm text-gray-400">Address</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-location-dot text-gray-500 mr-2"></i>
              <input id="address" type="text" name="address" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter address" required>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-gray-400">City</label>
              <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
                <i class="fa fa-city text-gray-500 mr-2"></i>
                <input id="city" type="text" name="city" class="w-full py-2 bg-black outline-none text-white" placeholder="City">
              </div>
            </div>

            <div>
              <label class="text-sm text-gray-400">State</label>
              <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
                <i class="fa fa-map text-gray-500 mr-2"></i>
                <input id="state" type="text" name="state" class="w-full py-2 bg-black outline-none text-white" placeholder="State">
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-gray-400">Zip</label>
              <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
                <i class="fa fa-hashtag text-gray-500 mr-2"></i>
                <input id="zip" type="text" name="zip" class="w-full py-2 bg-black outline-none text-white" placeholder="Zip code">
              </div>
            </div>

            <div>
              <label class="text-sm text-gray-400">Country</label>
              <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
                <i class="fa fa-globe text-gray-500 mr-2"></i>
                <input id="country" type="text" name="country" class="w-full py-2 bg-black outline-none text-white" placeholder="Country">
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between gap-3 pt-2">
            <button type="button" data-nav="back" class="px-4 py-2 rounded-xl bg-gray-800 text-white font-semibold hover:bg-gray-700 transition">
              Back
            </button>
            <button type="button" data-nav="next" class="px-5 py-2 rounded-xl bg-orange-500 text-black font-semibold hover:bg-orange-400 transition">
              Next
            </button>
          </div>
        </div>

        <div id="documentsTab" class="signup-tab-panel hidden space-y-4">
          <div>
            <label class="text-sm text-gray-400">Aadhar Number</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-id-card text-gray-500 mr-2"></i>
              <input id="aadhar_no" type="text" name="aadhar_no" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter Aadhar number" required>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">Aadhar Image</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-image text-gray-500 mr-2"></i>
              <input id="aadhar_image" type="file" name="aadhar_image" class="w-full py-2 bg-black outline-none text-white file:mr-3 file:rounded-lg file:border-0 file:bg-orange-500 file:px-3 file:py-1.5 file:text-black file:font-semibold" accept="image/*" required>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">PAN Number</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-id-card text-gray-500 mr-2"></i>
              <input id="pan_no" type="text" name="pan_no" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter PAN number" required>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">PAN Image</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-image text-gray-500 mr-2"></i>
              <input id="pan_image" type="file" name="pan_image" class="w-full py-2 bg-black outline-none text-white file:mr-3 file:rounded-lg file:border-0 file:bg-orange-500 file:px-3 file:py-1.5 file:text-black file:font-semibold" accept="image/*" required>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">GST Number</label>
            <div class="flex items-center border-b border-gray-700 px-1 mt-1 focus-within:border-orange-400 transition">
              <i class="fa fa-receipt text-gray-500 mr-2"></i>
              <input id="gst_no" type="text" name="gst_no" class="w-full py-2 bg-black outline-none text-white" placeholder="Enter GST number" required>
            </div>
          </div>

          <div>
            <label class="text-sm text-gray-400">Captcha</label>
            <div id="captchaErrorMsg" class="text-red-400 text-xs mt-1 hidden mb-1"></div>
            <div class="flex items-center gap-3 mt-1 border-b border-gray-700 px-1 focus-within:border-orange-400 transition">
              <div id="captchaBox" class="text-orange-400 font-semibold tracking-widest"></div>
              <input id="captchaInput" type="text" name="captcha" placeholder="Enter" class="flex-1 py-2 bg-black outline-none text-white" required>
              <button type="button" onclick="generateCaptcha()" class="text-orange-400 text-lg">
                <i class="fa-solid fa-rotate"></i>
              </button>
            </div>
          </div>

          <div class="flex justify-between items-center text-sm text-gray-400">
            <label class="flex items-center gap-2">
              <input type="checkbox" class="accent-orange-500" required>
              Accept terms
            </label>
            <a href="{{ route('vendor.login') }}" class="hover:text-orange-400 transition">Already have account?</a>
          </div>

          <div class="flex items-center justify-between gap-3 pt-2">
            <button type="button" data-nav="back" class="px-4 py-2 rounded-xl bg-gray-800 text-white font-semibold hover:bg-gray-700 transition">
              Back
            </button>
            <button type="submit" id="signupBtn" class="flex-1 bg-gradient-to-r from-orange-500 to-amber-400 hover:from-orange-600 hover:to-amber-500 text-black font-semibold py-2 rounded-xl transition shadow-lg shadow-orange-500/20">
              Signup
            </button>
          </div>
        </div>
      </form>
    </div>

  </div>

  <script>
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const navButtons = document.querySelectorAll('[data-nav]');
    const tabPanels = document.querySelectorAll('.signup-tab-panel');
    const signupForm = document.getElementById('signupForm');
    const formErrorMsg = document.getElementById('formErrorMsg');
    const captchaErrorMsg = document.getElementById('captchaErrorMsg');
    const tabOrder = ['profileTab', 'addressTab', 'documentsTab'];
    let activeTabId = 'profileTab';

    function setActiveTab(tabId) {
      activeTabId = tabId;
      tabPanels.forEach((panel) => {
        panel.classList.toggle('hidden', panel.id !== tabId);
      });

      tabButtons.forEach((button) => {
        const isActive = button.dataset.tabTarget === tabId;
        button.classList.toggle('bg-orange-500', isActive);
        button.classList.toggle('text-black', isActive);
        button.classList.toggle('text-gray-300', !isActive);
      });
    }

    function getTabFieldState(field) {
      if (field.type === 'checkbox') {
        return field.checked;
      }

      if (field.type === 'file') {
        return field.files && field.files.length > 0;
      }

      return !!field.value.trim();
    }

    function validateTab(tabId) {
      const panel = document.getElementById(tabId);
      if (!panel) {
        return true;
      }

      const requiredFields = Array.from(panel.querySelectorAll('[required]'));
      const missingField = requiredFields.find((field) => !getTabFieldState(field));

      if (missingField) {
        showFormError('Please fill all required fields before continuing.');
        missingField.focus();
        return false;
      }

      hideFormError();
      return true;
    }

    function showFormError(message) {
      if (!formErrorMsg) {
        return;
      }

      formErrorMsg.textContent = message;
      formErrorMsg.classList.remove('hidden');
    }

    function hideFormError() {
      if (!formErrorMsg) {
        return;
      }

      formErrorMsg.textContent = '';
      formErrorMsg.classList.add('hidden');
    }

    tabButtons.forEach((button) => {
      button.addEventListener('click', () => setActiveTab(button.dataset.tabTarget));
    });

    setActiveTab('profileTab');

    navButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const direction = button.dataset.nav;
        const currentIndex = tabOrder.indexOf(activeTabId);

        if (direction === 'next') {
          if (!validateTab(activeTabId)) {
            return;
          }

          const nextTabId = tabOrder[currentIndex + 1];
          if (nextTabId) {
            setActiveTab(nextTabId);
          }
          return;
        }

        if (direction === 'back') {
          const previousTabId = tabOrder[currentIndex - 1];
          if (previousTabId) {
            hideFormError();
            setActiveTab(previousTabId);
          }
        }
      });
    });

    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    toggle.addEventListener('click', () => {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      passwordConfirmation.setAttribute('type', type);
      toggle.textContent = type === 'password' ? 'SHOW' : 'HIDE';
    });

    function generateCaptcha() {
      const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
      let captcha = '';
      for (let i = 0; i < 5; i++) {
        captcha += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      document.getElementById('captchaBox').innerText = captcha;
      window.generatedCaptcha = captcha;
    }

    signupForm.addEventListener('submit', function(e) {
      e.preventDefault();
      hideFormError();

      if (activeTabId !== 'documentsTab') {
        setActiveTab('documentsTab');
      }

      const captchaBox = document.getElementById('captchaBox').innerText;
      const captchaInputEl = document.getElementById('captchaInput');
      const captchaInput = captchaInputEl.value.toUpperCase();
      const captchaContainer = document.querySelector('div:has(#captchaBox)');

      if (captchaInput !== captchaBox) {
        if (captchaErrorMsg) {
          captchaErrorMsg.textContent = 'Captcha mismatch! Try again.';
          captchaErrorMsg.classList.remove('hidden');
        }
        captchaContainer.classList.add('captcha-shake');

        setTimeout(() => {
          captchaContainer.classList.remove('captcha-shake');
          if (captchaErrorMsg) {
            captchaErrorMsg.classList.add('hidden');
          }
          generateCaptcha();
          captchaInputEl.value = '';
          captchaInputEl.focus();
        }, 1500);

        return false;
      }

      const missingField = Array.from(signupForm.querySelectorAll('[required]')).find((field) => !getTabFieldState(field));

      if (missingField) {
        const targetTab = missingField.closest('.signup-tab-panel');
        if (targetTab) {
          setActiveTab(targetTab.id);
        }

        showFormError('Please fill all required fields before submitting.');
        missingField.focus();
        return false;
      }

      signupForm.submit();
    });

    generateCaptcha();
  </script>

</body>
</html>
