@extends('vendor.layout.navbar')

@section('title', 'Account Settings')

@section('content')
@php
    $isVerified = (bool) ($vendor->status ?? false);
    $statusLabel = $isVerified ? 'Verified' : 'Pending';
    $statusClass = $isVerified
        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200'
        : 'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-200';
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-amber-500 bg-clip-text text-transparent mb-2">
            Account Settings
        </h1>
        <p class="text-base text-gray-500 dark:text-gray-400">
            View and manage your vendor profile information, documents, security, and appearance preferences.
        </p>
    </div>

    {{-- Tabs in Row --}}
    <div class="mb-8 border-b border-gray-200 dark:border-gray-700">
        <nav class="flex flex-wrap gap-1 -mb-px">
            <button type="button" data-tab="profile" class="tab-btn active px-5 py-3 text-sm font-medium rounded-t-lg border-b-2 border-orange-500 text-orange-600 dark:text-orange-400 bg-white dark:bg-gray-800">
                <i class="fa-regular fa-user mr-2"></i> Profile Information
            </button>
            <button type="button" data-tab="documents" class="tab-btn px-5 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                <i class="fa-regular fa-id-card mr-2"></i> Documents
            </button>
            <button type="button" data-tab="security" class="tab-btn px-5 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                <i class="fa-solid fa-lock mr-2"></i> Security
            </button>
            <button type="button" data-tab="appearance" class="tab-btn px-5 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                <i class="fa-regular fa-sun mr-2"></i> Appearance
            </button>
        </nav>
    </div>

    {{-- Tab Content --}}
    <div class="grid grid-cols-1">
        {{-- Profile Tab --}}
        <div id="tab-profile" class="tab-content active">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                {{-- Heading with vendor image in same row --}}
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4">
                    <div class="flex items-center gap-4">
                        {{-- Vendor Image --}}
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white text-lg font-bold shadow-md shrink-0">
                            @if(!empty($vendor->image))
                                <img src="{{ $vendor->image }}" alt="{{ $vendor->name ?? 'Vendor' }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($vendor->name ?? 'V', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Profile Information</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Basic business identity and contact details</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Full Name</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $vendor->name ?? 'Vendor Name' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Email Address</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white break-all">{{ $vendor->email ?? 'vendor@email.com' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Phone Number</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $vendor->phone ?? 'Not added' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">GST Number</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $vendor->gst_no ?? 'Not added' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Address</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $vendor->address ?? 'Not added' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">City</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $vendor->city ?? 'Not added' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">State</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $vendor->state ?? 'Not added' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">ZIP Code</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $vendor->zip ?? 'Not added' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Country</label>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $vendor->country ?? 'Not added' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Account Status Card --}}
            <div class="mt-6 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-950/20 dark:to-amber-950/20 rounded-2xl border border-orange-100 dark:border-orange-900/30 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/40 flex items-center justify-center">
                        <i class="fa-regular fa-circle-check text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Account Status: {{ $statusLabel }}</h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                            @if($isVerified)
                                Your account is verified. You have full access to all vendor features.
                            @else
                                Your account is pending verification. Please complete your KYC documents.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Documents Tab --}}
        <div id="tab-documents" class="tab-content hidden">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <i class="fa-regular fa-id-card text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Identity Documents</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Aadhar and PAN card information with documents</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Aadhar Card --}}
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-id-card text-orange-500"></i>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Aadhar Card</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                    <span class="font-medium">Number:</span> {{ $vendor->aadhar_no ?? 'Not added' }}
                                </p>
                                @if(!empty($vendor->aadhar_image))
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Document Preview:</p>
                                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50 dark:bg-gray-900/30">
                                            <img src="{{ $vendor->aadhar_image }}" alt="Aadhar Card" class="w-full max-h-48 object-contain">
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-3 flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500">
                                        <i class="fa-regular fa-file-lines"></i>
                                        <span>No document uploaded</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- PAN Card --}}
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-credit-card text-orange-500"></i>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">PAN Card</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                    <span class="font-medium">Number:</span> {{ $vendor->pan_no ?? 'Not added' }}
                                </p>
                                @if(!empty($vendor->pan_image))
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Document Preview:</p>
                                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50 dark:bg-gray-900/30">
                                            <img src="{{ $vendor->pan_image }}" alt="PAN Card" class="w-full max-h-48 object-contain">
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-3 flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500">
                                        <i class="fa-regular fa-file-lines"></i>
                                        <span>No document uploaded</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Security Tab --}}
        <div id="tab-security" class="tab-content hidden">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <i class="fa-solid fa-lock text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Security Settings</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Account password and security information</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="rounded-xl bg-gray-50 dark:bg-gray-900/50 p-5">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Password</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Last updated: {{ isset($vendor->updated_at) ? \Carbon\Carbon::parse($vendor->updated_at)->format('d M, Y') : 'Never' }}
                                </p>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Secured with strong encryption
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Appearance Tab --}}
        <div id="tab-appearance" class="tab-content hidden">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <i class="fa-regular fa-sun text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Appearance Settings</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Choose your preferred theme for the dashboard</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Light Mode Card --}}
                        <button type="button" id="lightModeCard" class="appearance-card text-left p-5 rounded-xl border-2 transition-all duration-200 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 hover:border-orange-300 dark:hover:border-orange-700">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    <i class="fa-regular fa-sun text-xl text-amber-500"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Light Mode</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Bright and clean interface</p>
                                </div>
                            </div>
                            <div class="w-full h-20 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden">
                                <div class="w-full h-full bg-white p-2">
                                    <div class="w-full h-2 bg-gray-200 rounded mb-1"></div>
                                    <div class="w-2/3 h-2 bg-gray-100 rounded"></div>
                                </div>
                            </div>
                        </button>

                        {{-- Dark Mode Card --}}
                        <button type="button" id="darkModeCard" class="appearance-card text-left p-5 rounded-xl border-2 transition-all duration-200 bg-gray-900 border-gray-700 hover:border-orange-500">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-800 flex items-center justify-center">
                                    <i class="fa-regular fa-moon text-xl text-orange-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white">Dark Mode</h4>
                                    <p class="text-xs text-gray-400">Easy on the eyes, low light</p>
                                </div>
                            </div>
                            <div class="w-full h-20 rounded-lg bg-gray-800 border border-gray-700 overflow-hidden">
                                <div class="w-full h-full bg-gray-900 p-2">
                                    <div class="w-full h-2 bg-gray-700 rounded mb-1"></div>
                                    <div class="w-2/3 h-2 bg-gray-800 rounded"></div>
                                </div>
                            </div>
                        </button>
                    </div>

                    {{-- Active Theme Indicator --}}
                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-circle-check text-emerald-500"></i>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Current active theme:</span>
                                <span id="activeThemeLabel" class="text-sm font-semibold text-gray-900 dark:text-white">Light Mode</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        // Theme handling
        const html = document.documentElement;
        const lightModeCard = document.getElementById('lightModeCard');
        const darkModeCard = document.getElementById('darkModeCard');
        const activeThemeLabel = document.getElementById('activeThemeLabel');

        function updateActiveThemeLabel() {
            if (activeThemeLabel) {
                const isDark = html.classList.contains('dark');
                activeThemeLabel.textContent = isDark ? 'Dark Mode' : 'Light Mode';
            }
        }

        function setTheme(theme) {
            if (theme === 'light') {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
            updateActiveThemeLabel();
        }

        if (lightModeCard) {
            lightModeCard.addEventListener('click', function () { setTheme('light'); });
        }
        if (darkModeCard) {
            darkModeCard.addEventListener('click', function () { setTheme('dark'); });
        }

        // Initialize theme
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
        updateActiveThemeLabel();

        // Tab switching
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        function switchTab(tabId) {
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });
            
            // Show selected tab content
            const selectedContent = document.getElementById(`tab-${tabId}`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
                selectedContent.classList.add('active');
            }
            
            // Update button styles
            tabBtns.forEach(btn => {
                btn.classList.remove('active', 'border-orange-500', 'text-orange-600', 'dark:text-orange-400');
                btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                
                if (btn.getAttribute('data-tab') === tabId) {
                    btn.classList.add('border-orange-500', 'text-orange-600', 'dark:text-orange-400');
                    btn.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                }
            });
        }

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const tabId = this.getAttribute('data-tab');
                switchTab(tabId);
            });
        });
    })();
</script>

<style>
    .tab-content {
        transition: all 0.2s ease;
    }
    .appearance-card {
        cursor: pointer;
    }
    .appearance-card:hover {
        transform: translateY(-2px);
    }
</style>
@endsection