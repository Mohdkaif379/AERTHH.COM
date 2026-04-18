@extends('vendor.layout.navbar')

@section('content')

<!-- Welcome -->
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
        Welcome back, 
        <span class="text-orange-500" id="welcomeVendorName"></span>
    </h2>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
        Here's your business overview
    </p>
</div>

<!-- Stats Cards (Same as before) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- ... your stats cards ... -->
</div>

<!-- Main Content (Same as before) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- ... quick actions and orders table ... -->
</div>

<script>
    (function() {
        function updateDashboardUI(vendor) {
            const welcomeNameEl = document.getElementById('welcomeVendorName');
            if (welcomeNameEl) {
                welcomeNameEl.textContent = vendor.name || 'Vendor';
            }
            console.log('Dashboard UI updated for:', vendor.name);
        }
        
        if (window.getVendorDetails) {
            const vendor = window.getVendorDetails();
            if (vendor && vendor.name) {
                updateDashboardUI(vendor);
            }
        }
        
        window.addEventListener('vendorDataUpdated', function(event) {
            updateDashboardUI(event.detail);
        });
    })();
</script>

@endsection