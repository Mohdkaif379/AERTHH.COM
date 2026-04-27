@extends('vendor.layout.navbar')

@section('title', 'Edit Profile')

@section('content')
@php
    $rawImage = $vendor ? $vendor->getRawOriginal('image') : null;
    $currentImage = null;

    if ($rawImage) {
        if (str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')) {
            $currentImage = $rawImage;
        } elseif (str_starts_with($rawImage, 'storage/app/public/')) {
            $currentImage = asset(str_replace('storage/app/public/', 'storage/', $rawImage));
        } elseif (str_starts_with($rawImage, 'storage/')) {
            $currentImage = asset($rawImage);
        } else {
            $currentImage = asset('storage/' . ltrim($rawImage, '/'));
        }
    }
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
    {{-- Header --}}
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-amber-500 bg-clip-text text-transparent mb-2">
                Edit Profile
            </h1>
            <p class="text-base text-gray-500 dark:text-gray-400">
                Update your business details, contact information, and profile photo.
            </p>
        </div>
        <a href="{{ route('vendor.account-setting.index') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Settings
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 dark:bg-rose-950/20 dark:border-rose-900/40 p-4">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-rose-100 dark:bg-rose-900/40 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 dark:text-rose-300"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-rose-700 dark:text-rose-200">Please fix the following</h3>
                    <ul class="mt-2 space-y-1 text-sm text-rose-600 dark:text-rose-300 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/20 dark:border-emerald-900/40 p-4 text-sm text-emerald-700 dark:text-emerald-300">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Form --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                        <i class="fa-solid fa-user-pen text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Information</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Only the details below can be updated here</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('vendor.account-setting.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $vendor->name) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                               placeholder="Enter your name">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $vendor->email) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                               placeholder="Enter email">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $vendor->phone) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                               placeholder="Enter phone number">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">GST Number</label>
                        <input type="text" name="gst_no" value="{{ old('gst_no', $vendor->gst_no) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                               placeholder="Enter GST number">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Address</label>
                        <textarea name="address" rows="3"
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                                  placeholder="Enter your business address">{{ old('address', $vendor->address) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">City</label>
                        <input type="text" name="city" value="{{ old('city', $vendor->city) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                               placeholder="Enter city">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">State</label>
                        <input type="text" name="state" value="{{ old('state', $vendor->state) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                               placeholder="Enter state">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">ZIP Code</label>
                        <input type="text" name="zip" value="{{ old('zip', $vendor->zip) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                               placeholder="Enter ZIP code">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Country</label>
                        <input type="text" name="country" value="{{ old('country', $vendor->country) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400"
                               placeholder="Enter country">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Profile Image</label>
                        <input type="file" name="image" id="profileImageInput" accept="image/*"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400">
                        <p class="mt-2 text-xs text-gray-400">Accepted: JPG, PNG, WEBP. Max size 2MB.</p>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-amber-400 text-black font-semibold shadow-lg shadow-orange-500/20 hover:from-orange-600 hover:to-amber-500 transition">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Preview / Summary --}}
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <i class="fa-regular fa-image text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Profile Preview</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Current image and account details</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <div class="w-28 h-28 mx-auto rounded-2xl overflow-hidden bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center shadow-lg shadow-orange-500/20">
                        <img id="profileImagePreview"
                             src="{{ $currentImage ?: 'https://ui-avatars.com/api/?name=' . urlencode($vendor->name ?? 'Vendor') . '&size=128' }}"
                             alt="{{ $vendor->name ?? 'Vendor' }}"
                             class="w-full h-full object-cover">
                    </div>
                    <h4 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">{{ $vendor->name ?? 'Vendor' }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $vendor->email ?? '-' }}</p>
                    <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ ($vendor->status ?? false) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-200' }}">
                        <i class="fa-solid fa-circle text-[8px]"></i>
                        <span class="text-xs font-semibold">{{ ($vendor->status ?? false) ? 'Verified' : 'Pending Verification' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Quick Notes</h3>
                </div>
                <div class="p-6 space-y-3 text-sm text-gray-600 dark:text-gray-300">
                    <p class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-info text-orange-500 mt-1"></i>
                        Email and phone must stay unique across vendors.
                    </p>
                    <p class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-info text-orange-500 mt-1"></i>
                        Uploading a new profile image will replace the current one.
                    </p>
                    <p class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-info text-orange-500 mt-1"></i>
                        Documents like Aadhar and PAN stay in the account settings view.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const profileImageInput = document.getElementById('profileImageInput');
    const profileImagePreview = document.getElementById('profileImagePreview');

    profileImageInput?.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            profileImagePreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection
