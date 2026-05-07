<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Aerthh.com | Delivery Partner Signup</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'accent-rose': '#F43F5E',
                        'accent-pink': '#FB7185',
                        'accent-crimson': '#BE123C',
                    }
                }
            }
        }
    </script>

</head>

<style>
    /* Chrome, Safari, Edge - Hide scrollbar */

    ::-webkit-scrollbar {
        display: none;
    }

    /* Preview image styling */
    .image-preview {
        max-width: 80px;
        max-height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 8px;
    }

    .preview-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .remove-preview {
        cursor: pointer;
        color: #F43F5E;
        font-size: 12px;
        background: rgba(0, 0, 0, 0.5);
        padding: 2px 8px;
        border-radius: 20px;
        transition: all 0.2s;
    }

    .remove-preview:hover {
        background: #F43F5E;
        color: white;
    }
</style>

<body class="font-sans bg-gradient-to-br from-[#1a0f14] to-[#0a0508] min-h-screen py-6 px-4 flex items-center justify-center">

    <!-- Main Container -->
    <div class="w-full max-w-5xl mx-auto bg-[#0F0712] rounded-3xl shadow-2xl border border-[#22152a] overflow-hidden p-2">

        <!-- Logo at Top Left -->
        <div class="p-5 pb-0">
            <div class="flex items-center gap-3">
                <div class="bg-black/40 backdrop-blur rounded-2xl border border-[#F43F5E]/30">
                    <img src="{{ asset('logo.webp') }}" alt="Aerthh Logo" class="w-[50px] h-[50px] rounded-xl">
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">Delivery Partner <span class="bg-gradient-to-r from-[#F43F5E] to-[#FB7185] bg-clip-text text-transparent">Signup</span></h1>
                    <p class="text-gray-400 text-[10px]">Join India's fastest delivery network</p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="px-5 pt-4 border-b border-[#22152a]">
            <div class="flex gap-6 overflow-x-auto pb-1">
                <button class="tab-btn active text-gray-400 hover:text-[#FB7185] font-medium text-sm pb-3 border-b-2 border-transparent transition-all" data-tab="tab1">
                    <i class="fas fa-user-circle mr-1"></i> Personal Info
                </button>
                <button class="tab-btn text-gray-400 hover:text-[#FB7185] font-medium text-sm pb-3 border-b-2 border-transparent transition-all" data-tab="tab2">
                    <i class="fas fa-location-dot mr-1"></i> Address & ID
                </button>
                <button class="tab-btn text-gray-400 hover:text-[#FB7185] font-medium text-sm pb-3 border-b-2 border-transparent transition-all" data-tab="tab3">
                    <i class="fas fa-motorcycle mr-1"></i> Vehicle Details
                </button>
                <button class="tab-btn text-gray-400 hover:text-[#FB7185] font-medium text-sm pb-3 border-b-2 border-transparent transition-all" data-tab="tab4">
                    <i class="fas fa-file-alt mr-1"></i> Documents
                </button>
            </div>
        </div>

        <!-- Form Container -->
        <form method="POST" action="{{ route('delivery.signup.submit') }}" enctype="multipart/form-data">
            @csrf
            <!-- TAB 1: Personal Information -->
            <div id="tab1" class="tab-pane active">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Full Name -->
                    <div class="relative">
                        <i class="fas fa-user absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="text" id="fullName" name="full_name" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Full Name" required>
                    </div>
                    <!-- Mobile Number -->
                    <div class="relative">
                        <i class="fas fa-phone absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="tel" id="mobile" name="mobile" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Mobile Number" required>
                    </div>
                    <!-- Email -->
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="email" id="email" name="email" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Email Address" required>
                    </div>
                    <!-- Password -->
                    <div class="relative">
                        <i class="fas fa-lock absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="password" id="password" name="password" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Password" required>
                    </div>
                    <!-- Confirm Password -->
                    <div class="relative">
                        <i class="fas fa-check-circle absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="password" id="confirmPassword" name="password_confirmation" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Confirm Password" required>
                    </div>
                    <!-- Date of Birth -->
                    <div class="relative">
                        <i class="fas fa-calendar absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="date" id="dob" name="date_of_birth" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all" required>
                    </div>
                    <!-- Gender -->
                    <div class="relative">
                        <i class="fas fa-venus-mars absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <select id="gender" name="gender" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 appearance-none cursor-pointer focus:border-[#F43F5E] focus:outline-none transition-all">
                            <option value="" disabled selected class="bg-[#1a0f14]">Select Gender</option>
                            <option value="male" class="bg-[#1a0f14]">Male</option>
                            <option value="female" class="bg-[#1a0f14]">Female</option>
                            <option value="other" class="bg-[#1a0f14]">Other</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-2 bottom-3 text-[#FB7185] text-xs opacity-60 pointer-events-none"></i>
                    </div>
                    <!-- Profile Photo Upload with Preview -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="text-gray-400 text-xs mb-1.5 block"><i class="fas fa-camera mr-1 text-[#FB7185]"></i>Profile Photo</label>
                        <div class="file-upload-trigger bg-black/30 border-2 border-dashed border-[#F43F5E]/30 rounded-xl p-3 text-center cursor-pointer hover:border-[#F43F5E] hover:bg-[#F43F5E]/5 transition-all">
                            <i class="fas fa-cloud-upload-alt text-[#FB7185] text-xl"></i>
                            <p class="text-gray-400 text-xs mt-1">Click to upload profile picture</p>
                        </div>
                        <input type="file" id="profilePhoto" name="profile_photo" class="hidden" accept="image/*">
                        <div id="profilePhotoPreview" class="preview-container"></div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Address & ID Proof -->
            <div id="tab2" class="tab-pane hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Address Line -->
                    <div class="relative col-span-1 md:col-span-2">
                        <i class="fas fa-location-dot absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="text" id="address" name="address_line" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Address Line" required>
                    </div>
                    <!-- City -->
                    <div class="relative">
                        <i class="fas fa-city absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="text" id="city" name="city" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="City" required>
                    </div>
                    <!-- State -->
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="text" id="state" name="state" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="State" required>
                    </div>
                    <!-- Pincode -->
                    <div class="relative">
                        <i class="fas fa-mail-bulk absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="text" id="pincode" name="pincode" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Pincode" required>
                    </div>
                    <!-- Aadhaar Number -->
                    <div class="relative">
                        <i class="fas fa-id-card absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="text" id="aadhaarNumber" name="aadhaar_number" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Aadhaar Number (12 digits)" maxlength="12" required>
                    </div>
                    <!-- Aadhaar Image Upload with Preview -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="text-gray-400 text-xs mb-1.5 block"><i class="fas fa-id-card mr-1 text-[#FB7185]"></i>Aadhaar Image Upload</label>
                        <div class="file-upload-aadhaar bg-black/30 border-2 border-dashed border-[#F43F5E]/30 rounded-xl p-3 text-center cursor-pointer hover:border-[#F43F5E] hover:bg-[#F43F5E]/5 transition-all">
                            <i class="fas fa-cloud-upload-alt text-[#FB7185] text-xl"></i>
                            <p class="text-gray-400 text-xs mt-1">Upload Aadhaar Card (Front)</p>
                        </div>
                        <input type="file" id="aadhaarImage" name="aadhaar_image" class="hidden" accept="image/*">
                        <div id="aadhaarImagePreview" class="preview-container"></div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: Vehicle Details -->
            <div id="tab3" class="tab-pane hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Vehicle Type -->
                    <div class="relative">
                        <i class="fas fa-truck absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <select id="vehicleType" name="vehicle_type" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 appearance-none cursor-pointer focus:border-[#F43F5E] focus:outline-none transition-all">
                            <option value="" disabled selected class="bg-[#1a0f14]">Select Vehicle Type</option>
                            <option value="bike" class="bg-[#1a0f14]">Motorcycle / Bike</option>
                            <option value="bicycle" class="bg-[#1a0f14]">Bicycle</option>
                            <option value="scooter" class="bg-[#1a0f14]">Scooter</option>
                            <option value="auto" class="bg-[#1a0f14]">Auto Rickshaw</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-2 bottom-3 text-[#FB7185] text-xs opacity-60 pointer-events-none"></i>
                    </div>
                    <!-- Vehicle Number -->
                    <div class="relative">
                        <i class="fas fa-hashtag absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="text" id="vehicleNumber" name="vehicle_number" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Vehicle Number (e.g., MH01AB1234)" required>
                    </div>
                    <!-- Driving License Number -->
                    <div class="relative">
                        <i class="fas fa-id-card absolute left-0 bottom-3 text-[#FB7185] text-sm opacity-70"></i>
                        <input type="text" id="dlNumber" name="driving_license_number" class="w-full bg-transparent border-0 border-b-2 border-white/15 text-white text-sm py-2.5 pl-7 focus:border-[#F43F5E] focus:outline-none transition-all placeholder:text-gray-500" placeholder="Driving License Number" required>
                    </div>
                    <!-- RC Upload with Preview -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="text-gray-400 text-xs mb-1.5 block"><i class="fas fa-file-pdf mr-1 text-[#FB7185]"></i>RC Upload (Registration Certificate)</label>
                        <div class="file-upload-rc bg-black/30 border-2 border-dashed border-[#F43F5E]/30 rounded-xl p-3 text-center cursor-pointer hover:border-[#F43F5E] hover:bg-[#F43F5E]/5 transition-all">
                            <i class="fas fa-cloud-upload-alt text-[#FB7185] text-xl"></i>
                            <p class="text-gray-400 text-xs mt-1">Upload RC Document (PDF/Image)</p>
                        </div>
                        <input type="file" id="rcUpload" name="rc_upload" class="hidden" accept="image/*,application/pdf">
                        <div id="rcUploadPreview" class="preview-container"></div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: Documents -->
            <div id="tab4" class="tab-pane hidden">
                <div class="grid grid-cols-1 gap-5">
                    <!-- Driving License Upload with Preview -->
                    <div>
                        <label class="text-gray-400 text-xs mb-1.5 block"><i class="fas fa-id-card mr-1 text-[#FB7185]"></i>Driving License Upload</label>
                        <div class="file-upload-dl bg-black/30 border-2 border-dashed border-[#F43F5E]/30 rounded-xl p-3 text-center cursor-pointer hover:border-[#F43F5E] hover:bg-[#F43F5E]/5 transition-all">
                            <i class="fas fa-cloud-upload-alt text-[#FB7185] text-xl"></i>
                            <p class="text-gray-400 text-xs mt-1">Upload Driving License (Front & Back)</p>
                        </div>
                        <input type="file" id="dlUpload" name="dl_upload" class="hidden" accept="image/*,application/pdf">
                        <div id="dlUploadPreview" class="preview-container"></div>
                    </div>
                    <!-- Terms & Conditions -->
                    <div class="flex items-start gap-3 mt-3">
                        <input type="checkbox" id="termsCheckbox" class="mt-0.5 w-4 h-4 rounded border-gray-500 bg-transparent checked:bg-[#F43F5E] focus:ring-[#F43F5E]">
                        <label class="text-gray-400 text-xs">I confirm that all the information provided above is accurate and I agree to the <span class="text-[#FB7185] cursor-pointer hover:underline">Terms & Conditions</span> and <span class="text-[#FB7185] cursor-pointer hover:underline">Privacy Policy</span> of Aerthh Delivery Services.</label>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between gap-4 mt-8 pt-4 border-t border-[#22152a]">
                <button type="button" id="prevBtn" class="px-6 py-2.5 rounded-xl border border-[#F43F5E]/50 text-[#FB7185] font-semibold text-sm hover:bg-[#F43F5E]/10 transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                    <i class="fas fa-arrow-left mr-2"></i> Previous
                </button>
                <button type="button" id="nextBtn" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-[#F43F5E] to-[#BE123C] text-white font-semibold text-sm hover:shadow-lg transition-all">
                    Next <i class="fas fa-arrow-right ml-2"></i>
                </button>
                <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-[#F43F5E] to-[#BE123C] text-white font-semibold text-sm hover:shadow-lg transition-all hidden">
                    <i class="fas fa-check-circle mr-2"></i> Submit Application
                </button>
            </div>
        </form>

        <!-- Footer Note -->
        <div class="px-6 pb-5 text-center text-[10px] text-gray-500 border-t border-[#22152a] pt-4 mt-2">
            <i class="fas fa-shield-alt text-[#FB7185]/50 mr-1"></i> Your data is secure with AES-256 encryption
        </div>
    </div>

    <script>
        (function() {
            // Tab Switching Logic
            const tabs = document.querySelectorAll('.tab-btn');
            const panes = document.querySelectorAll('.tab-pane');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            let currentTab = 0;
            const totalTabs = 4;

            function showTab(index) {
                panes.forEach((pane, i) => {
                    if (i === index) {
                        pane.classList.remove('hidden');
                        pane.classList.add('active');
                    } else {
                        pane.classList.add('hidden');
                        pane.classList.remove('active');
                    }
                });
                tabs.forEach((tab, i) => {
                    if (i === index) {
                        tab.classList.add('active', 'text-[#FB7185]', 'border-b-2', 'border-[#F43F5E]');
                        tab.classList.remove('text-gray-400');
                    } else {
                        tab.classList.remove('active', 'text-[#FB7185]', 'border-b-2', 'border-[#F43F5E]');
                        tab.classList.add('text-gray-400');
                    }
                });
                if (index === totalTabs - 1) {
                    nextBtn.classList.add('hidden');
                    submitBtn.classList.remove('hidden');
                } else {
                    nextBtn.classList.remove('hidden');
                    submitBtn.classList.add('hidden');
                }
                prevBtn.disabled = (index === 0);
            }

            tabs.forEach((tab, idx) => {
                tab.addEventListener('click', () => {
                    currentTab = idx;
                    showTab(currentTab);
                });
            });

            nextBtn.addEventListener('click', () => {
                if (currentTab < totalTabs - 1) {
                    currentTab++;
                    showTab(currentTab);
                }
            });

            prevBtn.addEventListener('click', () => {
                if (currentTab > 0) {
                    currentTab--;
                    showTab(currentTab);
                }
            });

            // File upload with preview function
            function setupFileUploadWithPreview(triggerClass, inputId, previewId, fileType = 'image') {
                const trigger = document.querySelector(triggerClass);
                const input = document.getElementById(inputId);
                const previewContainer = document.getElementById(previewId);

                if (trigger && input && previewContainer) {
                    trigger.addEventListener('click', () => input.click());
                    input.addEventListener('change', (e) => {
                        previewContainer.innerHTML = '';
                        if (e.target.files && e.target.files[0]) {
                            const file = e.target.files[0];
                            const fileName = document.createElement('span');
                            fileName.className = 'text-[10px] text-gray-400';
                            fileName.textContent = file.name;

                            if (fileType === 'image' && file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(evt) {
                                    const img = document.createElement('img');
                                    img.src = evt.target.result;
                                    img.className = 'image-preview';
                                    const removeBtn = document.createElement('span');
                                    removeBtn.className = 'remove-preview';
                                    removeBtn.innerHTML = '<i class="fas fa-times mr-1"></i>Remove';
                                    removeBtn.onclick = () => {
                                        input.value = '';
                                        previewContainer.innerHTML = '';
                                    };
                                    previewContainer.appendChild(img);
                                    previewContainer.appendChild(removeBtn);
                                    previewContainer.appendChild(fileName);
                                };
                                reader.readAsDataURL(file);
                            } else {
                                // For PDF or other files, show file icon
                                const fileIcon = document.createElement('i');
                                fileIcon.className = 'fas fa-file-pdf text-[#FB7185] text-2xl';
                                const removeBtn = document.createElement('span');
                                removeBtn.className = 'remove-preview';
                                removeBtn.innerHTML = '<i class="fas fa-times mr-1"></i>Remove';
                                removeBtn.onclick = () => {
                                    input.value = '';
                                    previewContainer.innerHTML = '';
                                };
                                previewContainer.appendChild(fileIcon);
                                previewContainer.appendChild(removeBtn);
                                previewContainer.appendChild(fileName);
                            }
                        }
                    });
                }
            }

            // Setup all file uploads with preview
            setupFileUploadWithPreview('.file-upload-trigger', 'profilePhoto', 'profilePhotoPreview', 'image');
            setupFileUploadWithPreview('.file-upload-aadhaar', 'aadhaarImage', 'aadhaarImagePreview', 'image');
            setupFileUploadWithPreview('.file-upload-rc', 'rcUpload', 'rcUploadPreview', 'pdf');
            setupFileUploadWithPreview('.file-upload-dl', 'dlUpload', 'dlUploadPreview', 'pdf');

            // Toast notification
            function showToast(message, isError = false) {
                const existing = document.querySelector('.toast-custom');
                if (existing) existing.remove();
                const toast = document.createElement('div');
                toast.className = `toast-custom fixed bottom-5 left-1/2 -translate-x-1/2 z-50 px-5 py-2.5 rounded-full text-sm font-medium backdrop-blur-md shadow-lg ${isError ? 'bg-red-500/90 text-white' : 'bg-green-500/90 text-white'}`;
                toast.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-triangle' : 'fa-check-circle'} mr-2 text-xs"></i>${message}`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2500);
            }

            // Form validation and submission - Disabled for direct form submit
            // JS validation only
            const form = document.querySelector('form');
            form.addEventListener('submit', (e) => {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const terms = document.getElementById('termsCheckbox').checked;

                if (password !== confirmPassword) {
                    e.preventDefault();
                    showToast('❌ Passwords do not match!', true);
                    return;
                }
                if (password.length < 6) {
                    e.preventDefault();
                    showToast('❌ Password must be at least 6 characters!', true);
                    return;
                }
                if (!terms) {
                    e.preventDefault();
                    showToast('❌ Please accept Terms & Conditions!', true);
                    return;
                }
                // Allow native form submit
            });
        })();
    </script>
</body>

</html>