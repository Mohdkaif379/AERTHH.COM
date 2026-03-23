{{-- resources/views/layouts/sidebar.blade.php --}}
<button id="mobileSidebarTrigger" class="lg:hidden fixed top-4 left-4 z-50 p-3 rounded-full bg-white shadow-lg text-cyan-500 border border-cyan-100/60 hover:bg-cyan-50 transition">
    <i class="fas fa-bars text-base"></i>
</button>

<div id="sidebarOverlay" class="hidden lg:hidden fixed inset-0 bg-black/30 backdrop-blur-sm z-40"></div>

<aside id="sidebar" class="w-64 md:w-60 sm:w-64 max-w-xs h-screen lg:h-auto overflow-y-auto bg-white/80 backdrop-blur-md border-r border-cyan-100/50 flex flex-col transition-all duration-300 shadow-md fixed lg:static inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0">

    {{-- Logo Section with Toggle Button --}}
    <div class="p-5 border-b border-cyan-100/50">
        <div class="flex items-center justify-between">
            {{-- Logo Image --}}
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg overflow-hidden shadow-md flex-shrink-0">
                    <img src="https://aerthh.com/storage/app/public/company/2025-03-26-67e3da8f9b411.webp"
                        alt="Aerthh Logo"
                        class="w-full h-full object-cover"
                        onerror="this.src='https://via.placeholder.com/40/06b6d4/ffffff?text=A'">
                </div>
                {{-- Brand Text - Hidden when collapsed --}}
                <div class="sidebar-text">
                    <h1 class="text-lg font-bold text-gray-800">Aerthh</h1>
                    <p class="text-[9px] text-gray-400">Admin Dashboard</p>
                </div>
            </div>

            {{-- Toggle Button --}}
            <button id="toggleSidebar" class="text-gray-400 hover:text-cyan-500 transition-colors">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
        </div>
    </div>

    <!-- {{-- Admin Profile --}}
    <div class="p-4 border-b border-cyan-100/50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-400 p-0.5 flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=06b6d4&color=fff&size=100"
                    class="w-full h-full rounded-full border-2 border-white">
            </div>
            {{-- Profile Info - Hidden when collapsed --}}
            <div class="sidebar-text">
                <h3 class="text-sm font-semibold text-gray-700">{{ session('admin_name', 'Admin') }}</h3>
                <p class="text-[10px] text-gray-400">{{ session('admin_email', 'admin@aerthh.com') }}</p>
            </div>
            <button class="sidebar-text ml-auto text-gray-400 hover:text-cyan-500">
                <i class="fas fa-ellipsis-v text-xs"></i>
            </button>
        </div>
    </div> -->

    {{-- Navigation Menu --}}
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home w-5 text-cyan-500 text-sm flex-shrink-0"></i>
            <span class="sidebar-text text-xs font-medium">Dashboard</span>
        </a>

        {{-- ORDER MANAGEMENT HEADING --}}
        <div class="px-3 pt-4 pb-1">
            <h3 class="sidebar-text text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Order Management</h3>
        </div>

        {{-- ORDERS DROPDOWN --}}
        <div x-data="{ ordersOpen: false }" class="space-y-1">
            {{-- Orders Main Button --}}
            <button @click="ordersOpen = !ordersOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-shopping-cart w-5 text-emerald-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Orders</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="sidebar-text bg-cyan-100 text-cyan-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">22</span>
                    <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': ordersOpen }"></i>
                </div>
            </button>

            {{-- Orders Status List --}}
            <div x-show="ordersOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-list w-4 text-gray-400 text-[10px]"></i>
                        <span class="sidebar-text">All Orders</span>
                    </div>
                    <span class="sidebar-text bg-gray-100 text-gray-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">22</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-clock w-4 text-yellow-400 text-[10px]"></i>
                        <span class="sidebar-text">Pending</span>
                    </div>
                    <span class="sidebar-text bg-yellow-100 text-yellow-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">7</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle w-4 text-blue-400 text-[10px]"></i>
                        <span class="sidebar-text">Confirmed</span>
                    </div>
                    <span class="sidebar-text bg-blue-100 text-blue-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">11</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-box w-4 text-purple-400 text-[10px]"></i>
                        <span class="sidebar-text">Packaging</span>
                    </div>
                    <span class="sidebar-text bg-purple-100 text-purple-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">0</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-truck w-4 text-indigo-400 text-[10px]"></i>
                        <span class="sidebar-text">Out for delivery</span>
                    </div>
                    <span class="sidebar-text bg-indigo-100 text-indigo-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">1</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle w-4 text-emerald-400 text-[10px]"></i>
                        <span class="sidebar-text">Delivered</span>
                    </div>
                    <span class="sidebar-text bg-emerald-100 text-emerald-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">3</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-undo-alt w-4 text-orange-400 text-[10px]"></i>
                        <span class="sidebar-text">Returned</span>
                    </div>
                    <span class="sidebar-text bg-orange-100 text-orange-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">0</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-exclamation-circle w-4 text-rose-400 text-[10px]"></i>
                        <span class="sidebar-text">Failed to Deliver</span>
                    </div>
                    <span class="sidebar-text bg-rose-100 text-rose-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">0</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-times-circle w-4 text-red-400 text-[10px]"></i>
                        <span class="sidebar-text">Canceled</span>
                    </div>
                    <span class="sidebar-text bg-red-100 text-red-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">0</span>
                </a>
            </div>
        </div>


        {{-- REQUESTS DROPDOWN (New) --}}
        <div x-data="{ requestsOpen: false }" class="space-y-1">
            {{-- Requests Main Button --}}
            <button @click="requestsOpen = !requestsOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clipboard-list w-5 text-cyan-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Requests</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="sidebar-text bg-cyan-100 text-cyan-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">8</span>
                    <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': requestsOpen }"></i>
                </div>
            </button>

            {{-- Requests Status List --}}
            <div x-show="requestsOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">



                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-clock w-4 text-yellow-400 text-[10px]"></i>
                        <span class="sidebar-text">Pending</span>
                    </div>
                    <span class="sidebar-text bg-yellow-100 text-yellow-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">4</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle w-4 text-emerald-400 text-[10px]"></i>
                        <span class="sidebar-text">Approved</span>
                    </div>
                    <span class="sidebar-text bg-emerald-100 text-emerald-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">2</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-hourglass-half w-4 text-purple-400 text-[10px]"></i>
                        <span class="sidebar-text">Refunded</span>
                    </div>
                    <span class="sidebar-text bg-red-100 text-red-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">1</span>
                </a>

                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">

                        <i class="fas fa-times-circle w-4 text-red-400 text-[10px]"></i>
                        <span class="sidebar-text">Rejected</span>
                    </div>
                    <span class="sidebar-text bg-purple-100 text-purple-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">1</span>
                </a>
            </div>
        </div>


        {{-- PRODUCT MANAGEMENT DROPDOWNS --}}

        {{-- Product Management Heading --}}
        <div class="px-3 pt-4 pb-1">
            <h3 class="sidebar-text text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Product Management</h3>
        </div>

        {{-- 1. CATEGORY SETUP DROPDOWN --}}
        <div x-data="{ categoryOpen: false }" class="space-y-1">
            <button @click="categoryOpen = !categoryOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-folder-tree w-5 text-cyan-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Category Setup</span>
                </div>
                <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': categoryOpen }"></i>
            </button>

            <div x-show="categoryOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                <a href="{{ route('category.index') }}" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-layer-group w-4 text-cyan-400 text-[10px]"></i>
                    <span class="sidebar-text">Categories</span>
                </a>

                <a href="{{ route('subcategory.index') }}" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-layer-group w-4 text-emerald-400 text-[10px]"></i>
                    <span class="sidebar-text">Sub Categories</span>
                </a>

                <a href="{{ route('subsubcategory.index') }}" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-layer-group w-4 text-purple-400 text-[10px]"></i>
                    <span class="sidebar-text">Sub Sub Categories</span>
                </a>
            </div>
        </div>

        {{-- 2. BRANDS DROPDOWN --}}
        <div x-data="{ brandsOpen: false }" class="space-y-1">
            <button @click="brandsOpen = !brandsOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-trademark w-5 text-emerald-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Brands</span>
                </div>
                <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': brandsOpen }"></i>
            </button>

            <div x-show="brandsOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Add New Button --}}
                <a href="{{ route('brand.create') }}" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-plus-circle w-4 text-emerald-400 text-[10px]"></i>
                    <span class="sidebar-text">Add New</span>
                </a>

                {{-- List Button --}}
                <a href="{{ route('brand.index') }}" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-list w-4 text-cyan-400 text-[10px]"></i>
                    <span class="sidebar-text">List</span>
                </a>
            </div>
        </div>
        {{-- PRODUCT ATTRIBUTE SETUP BUTTON --}}
        <a href="{{ route('attribute.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <i class="fas fa-sliders-h w-5 text-purple-500 text-sm flex-shrink-0"></i>
            <span class="sidebar-text text-xs font-medium">Product Attribute Setup</span>
        </a>

        {{-- IN-HOUSE PRODUCTS DROPDOWN --}}
        <div x-data="{ inhouseOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="inhouseOpen = !inhouseOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-store w-5 text-cyan-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">In-house Products</span>
                </div>
                <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': inhouseOpen }"></i>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="inhouseOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Product List --}}
                <a href="{{ route('products.index') }}" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-list w-4 text-emerald-400 text-[10px]"></i>
                    <span class="sidebar-text">Product List</span>
                </a>

                {{-- Add New Product --}}
                <a href="{{ route('products.create') }}" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-plus-circle w-4 text-cyan-400 text-[10px]"></i>
                    <span class="sidebar-text">Add New Product</span>
                </a>

                {{-- Bulk Import --}}
                <a href="{{ route('products.import.form') }}" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-file-import w-4 text-purple-400 text-[10px]"></i>
                    <span class="sidebar-text">Bulk Import</span>
                </a>
            </div>
        </div>

        {{-- VENDOR PRODUCTS DROPDOWN --}}
        <div x-data="{ vendorOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="vendorOpen = !vendorOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-store-alt w-5 text-emerald-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Vendor Products</span>
                </div>
                <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': vendorOpen }"></i>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="vendorOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- New Products Requests --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-clock w-4 text-yellow-400 text-[10px]"></i>
                        <span class="sidebar-text">New Products Requests</span>
                    </div>
                    <span class="sidebar-text bg-yellow-100 text-yellow-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">12</span>
                </a>

                {{-- Product Update Request --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-edit w-4 text-blue-400 text-[10px]"></i>
                        <span class="sidebar-text">Product Update Request</span>
                    </div>
                    <span class="sidebar-text bg-blue-100 text-blue-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">5</span>
                </a>

                {{-- Approved Products --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle w-4 text-emerald-400 text-[10px]"></i>
                        <span class="sidebar-text">Approved Products</span>
                    </div>
                    <span class="sidebar-text bg-emerald-100 text-emerald-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">45</span>
                </a>

                {{-- Denied Products --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-times-circle w-4 text-rose-400 text-[10px]"></i>
                        <span class="sidebar-text">Denied Products</span>
                    </div>
                    <span class="sidebar-text bg-rose-100 text-rose-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">3</span>
                </a>
            </div>
        </div>

        {{-- Product Gallery Button --}}
        <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <i class="fas fa-images w-5 text-pink-500 text-sm flex-shrink-0"></i>
            <span class="sidebar-text text-xs font-medium">Product Gallery</span>
        </a>


        {{-- PROMOTION MANAGEMENT SECTION --}}
        <div class="px-3 pt-4 pb-1">
            <h3 class="sidebar-text text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Promotion Management</h3>
        </div>

        {{-- Banner Setup Button --}}
        <a href="{{route('admin.banners.index')}}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <i class="fas fa-images w-5 text-pink-500 text-sm flex-shrink-0"></i>
            <span class="sidebar-text text-xs font-medium">Banner Setup</span>
        </a>

        {{-- OFFERS & DEALS DROPDOWN --}}
        <div x-data="{ offersOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="offersOpen = !offersOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-tags w-5 text-orange-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Offers & Deals</span>
                </div>
                <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': offersOpen }"></i>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="offersOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Coupon --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-ticket-alt w-4 text-purple-400 text-[10px]"></i>
                    <span class="sidebar-text">Coupon</span>
                </a>

                {{-- Flash Deals --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-bolt w-4 text-yellow-400 text-[10px]"></i>
                    <span class="sidebar-text">Flash Deals</span>
                </a>

                {{-- Deal of the day --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-calendar-day w-4 text-emerald-400 text-[10px]"></i>
                    <span class="sidebar-text">Deal of the day</span>
                </a>

                {{-- Featured Deal --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-star w-4 text-amber-400 text-[10px]"></i>
                    <span class="sidebar-text">Featured Deal</span>
                </a>
            </div>
        </div>

        {{-- NOTIFICATIONS DROPDOWN --}}
        <div x-data="{ notifOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="notifOpen = !notifOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-bell w-5 text-rose-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Notifications</span>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- <span class="sidebar-text bg-rose-100 text-rose-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">3</span> -->
                    <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': notifOpen }"></i>
                </div>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="notifOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Send Notification --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-paper-plane w-4 text-cyan-400 text-[10px]"></i>
                    <span class="sidebar-text">Send Notification</span>
                </a>

                {{-- Push Notifications Setup --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-cog w-4 text-purple-400 text-[10px]"></i>
                    <span class="sidebar-text">Push Notifications Setup</span>
                </a>
            </div>
        </div>


        {{-- ANNOUNCEMENT BUTTON --}}
        <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <i class="fas fa-bullhorn w-5 text-purple-500 text-sm flex-shrink-0"></i>
            <span class="sidebar-text text-xs font-medium">Announcement</span>
        </a>



        {{-- HELP & SUPPORT SECTION --}}

        {{-- Help & Support Heading --}}
        <div class="px-3 pt-4 pb-1">
            <h3 class="sidebar-text text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Help & Support</h3>
        </div>

        {{-- Inbox Button --}}
        <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <div class="flex items-center space-x-3">
                <i class="fas fa-inbox w-5 text-cyan-500 text-sm flex-shrink-0"></i>
                <span class="sidebar-text text-xs font-medium">Inbox</span>
            </div>
            <span class="sidebar-text bg-cyan-100 text-cyan-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">5</span>
        </a>

        {{-- Messages Button --}}
        <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <div class="flex items-center space-x-3">
                <i class="fas fa-envelope w-5 text-emerald-500 text-sm flex-shrink-0"></i>
                <span class="sidebar-text text-xs font-medium">Messages</span>
            </div>
            <span class="sidebar-text bg-emerald-100 text-emerald-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">7</span>
        </a>

        {{-- Support Ticket Button --}}
        <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <div class="flex items-center space-x-3">
                <i class="fas fa-ticket-alt w-5 text-purple-500 text-sm flex-shrink-0"></i>
                <span class="sidebar-text text-xs font-medium">Support Ticket</span>
            </div>
            <span class="sidebar-text bg-purple-100 text-purple-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">3</span>
        </a>



        {{-- REPORTS & ANALYSIS SECTION --}}

        {{-- Reports & Analysis Heading --}}
        <div class="px-3 pt-4 pb-1">
            <h3 class="sidebar-text text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Reports & Analysis</h3>
        </div>

        {{-- Sales & Transaction Dropdown --}}
        <div x-data="{ salesOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="salesOpen = !salesOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-chart-line w-5 text-emerald-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Sales & Transaction Repo</span>
                </div>
                <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': salesOpen }"></i>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="salesOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Earning Reports --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-dollar-sign w-4 text-yellow-400 text-[10px]"></i>
                    <span class="sidebar-text">Earning Reports</span>
                </a>

                {{-- Inhouse Sales --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-store w-4 text-cyan-400 text-[10px]"></i>
                    <span class="sidebar-text">Inhouse Sales</span>
                </a>

                {{-- Vendor Sales --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-store-alt w-4 text-purple-400 text-[10px]"></i>
                    <span class="sidebar-text">Vendor Sales</span>
                </a>

                {{-- Transaction Report --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-exchange-alt w-4 text-emerald-400 text-[10px]"></i>
                    <span class="sidebar-text">Transaction Report</span>
                </a>
            </div>
        </div>


        {{-- PRODUCT REPORT BUTTON --}}
        <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <i class="fas fa-box w-5 text-cyan-500 text-sm flex-shrink-0"></i>
            <span class="sidebar-text text-xs font-medium">Product Report</span>
        </a>

        {{-- ORDER REPORT BUTTON --}}
        <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <i class="fas fa-shopping-cart w-5 text-emerald-500 text-sm flex-shrink-0"></i>
            <span class="sidebar-text text-xs font-medium">Order Report</span>
        </a>



        {{-- USER MANAGEMENT SECTION --}}

        {{-- User Management Heading --}}
        <div class="px-3 pt-4 pb-1">
            <h3 class="sidebar-text text-[10px] font-semibold text-gray-400 uppercase tracking-wider">User Management</h3>
        </div>

        {{-- Customers Dropdown --}}
        <div x-data="{ customersOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="customersOpen = !customersOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-users w-5 text-blue-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Customers</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="sidebar-text bg-blue-100 text-blue-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">156</span>
                    <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': customersOpen }"></i>
                </div>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="customersOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Customer List --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-list w-4 text-cyan-400 text-[10px]"></i>
                        <span class="sidebar-text">Customer List</span>
                    </div>
                    <span class="sidebar-text bg-cyan-100 text-cyan-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">128</span>
                </a>

                {{-- Customer Reviews --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-star w-4 text-yellow-400 text-[10px]"></i>
                        <span class="sidebar-text">Customer Reviews</span>
                    </div>
                    <span class="sidebar-text bg-yellow-100 text-yellow-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">42</span>
                </a>

                {{-- Wallet --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-wallet w-4 text-emerald-400 text-[10px]"></i>
                        <span class="sidebar-text">Wallet</span>
                    </div>
                    <span class="sidebar-text bg-emerald-100 text-emerald-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">67</span>
                </a>

                {{-- Wallet Bonus Setup --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-gift w-4 text-purple-400 text-[10px]"></i>
                        <span class="sidebar-text">Wallet Bonus Setup</span>
                    </div>
                    <span class="sidebar-text bg-purple-100 text-purple-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">3</span>
                </a>

                {{-- Loyalty Points --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-medal w-4 text-amber-400 text-[10px]"></i>
                        <span class="sidebar-text">Loyalty Points</span>
                    </div>
                    <span class="sidebar-text bg-amber-100 text-amber-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">8</span>
                </a>
            </div>
        </div>



        {{-- VENDORS DROPDOWN --}}
        <div x-data="{ vendorsOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="vendorsOpen = !vendorsOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-store-alt w-5 text-purple-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Vendors</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="sidebar-text bg-purple-100 text-purple-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">24</span>
                    <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': vendorsOpen }"></i>
                </div>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="vendorsOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Add New Vendor --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-plus-circle w-4 text-emerald-400 text-[10px]"></i>
                        <span class="sidebar-text">Add New Vendor</span>
                    </div>
                </a>

                {{-- Vendor List --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-list w-4 text-cyan-400 text-[10px]"></i>
                        <span class="sidebar-text">Vendor List</span>
                    </div>
                    <span class="sidebar-text bg-cyan-100 text-cyan-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">24</span>
                </a>

                {{-- Withdraws --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-money-bill-wave w-4 text-yellow-400 text-[10px]"></i>
                        <span class="sidebar-text">Withdraws</span>
                    </div>
                    <span class="sidebar-text bg-yellow-100 text-yellow-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">12</span>
                </a>

                {{-- Withdrawal Methods --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-credit-card w-4 text-purple-400 text-[10px]"></i>
                        <span class="sidebar-text">Withdrawal Methods</span>
                    </div>
                    <span class="sidebar-text bg-purple-100 text-purple-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">4</span>
                </a>
            </div>
        </div>




        {{-- DELIVERY MEN DROPDOWN --}}
        <div x-data="{ deliveryOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="deliveryOpen = !deliveryOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-truck w-5 text-amber-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Delivery Men</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="sidebar-text bg-amber-100 text-amber-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">18</span>
                    <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': deliveryOpen }"></i>
                </div>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="deliveryOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Add new --}}
                <a href="#" class="sidebar-link flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <i class="fas fa-plus-circle w-4 text-emerald-400 text-[10px]"></i>
                    <span class="sidebar-text">Add new</span>
                </a>

                {{-- List --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-list w-4 text-cyan-400 text-[10px]"></i>
                        <span class="sidebar-text">List</span>
                    </div>
                    <span class="sidebar-text bg-cyan-100 text-cyan-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">18</span>
                </a>

                {{-- Withdraws --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-money-bill-wave w-4 text-yellow-400 text-[10px]"></i>
                        <span class="sidebar-text">Withdraws</span>
                    </div>
                    <span class="sidebar-text bg-yellow-100 text-yellow-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">7</span>
                </a>

                {{-- Emergency Contact --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-phone w-4 text-rose-400 text-[10px]"></i>
                        <span class="sidebar-text">Emergency Contact</span>
                    </div>
                    <span class="sidebar-text bg-rose-100 text-rose-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">3</span>
                </a>
            </div>
        </div>



        {{-- EMPLOYEES DROPDOWN --}}
        <div x-data="{ employeesOpen: false }" class="space-y-1">
            {{-- Main Button --}}
            <button @click="employeesOpen = !employeesOpen" class="w-full sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-user-tie w-5 text-indigo-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Employees</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="sidebar-text bg-indigo-100 text-indigo-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">15</span>
                    <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': employeesOpen }"></i>
                </div>
            </button>

            {{-- Dropdown Items --}}
            <div x-show="employeesOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="pl-9 space-y-1">

                {{-- Employee Role Setup --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-user-cog w-4 text-purple-400 text-[10px]"></i>
                        <span class="sidebar-text">Employee Role Setup</span>
                    </div>
                    <span class="sidebar-text bg-purple-100 text-purple-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">6</span>
                </a>

                {{-- Employees --}}
                <a href="#" class="sidebar-link flex items-center justify-between px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-users w-4 text-emerald-400 text-[10px]"></i>
                        <span class="sidebar-text">Employees</span>
                    </div>
                    <span class="sidebar-text bg-emerald-100 text-emerald-600 text-[8px] font-bold px-1.5 py-0.5 rounded-full">15</span>
                </a>
            </div>
        </div>
        {{-- SUBSCRIBERS BUTTON --}}
        <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
            <span class="w-5 text-cyan-500 text-sm flex-shrink-0">人</span>
            <span class="sidebar-text text-xs font-medium">Subscribers</span>
        </a>


        {{-- SYSTEM SETTINGS WITH BUSINESS SETUP DROPDOWN --}}
        <div class="mb-6">
            <div class="px-3 pt-4 pb-1">
                <h3 class="sidebar-text text-[10px] font-semibold text-gray-400 uppercase tracking-wider">System Settings</h3>
            </div>

            {{-- Business Setup Dropdown --}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-building w-5 text-purple-500 text-sm flex-shrink-0"></i>
                        <span class="sidebar-text text-xs font-medium">Business Setup</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>

                <div x-show="open" x-transition class="ml-8 mt-1 space-y-0.5">
                    <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                        <i class="fas fa-sliders-h w-4 text-blue-500 text-xs flex-shrink-0"></i>
                        <span class="text-xs">Business Settings</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                        <i class="fas fa-store w-4 text-emerald-500 text-xs flex-shrink-0"></i>
                        <span class="text-xs">In-house Shop</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                        <i class="fas fa-cog w-4 text-amber-500 text-xs flex-shrink-0"></i>
                        <span class="text-xs">SEO Settings</span>
                    </a>
                </div>
            </div>
        </div>


        {{-- 3RD PARTY DROPDOWN --}}
        <div class="mb-6" x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-plug w-5 text-pink-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">3rd Party</span>
                </div>
                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open" x-transition class="ml-8 mt-1 space-y-0.5">
                <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                    <i class="fas fa-credit-card w-4 text-indigo-500 text-xs flex-shrink-0"></i>
                    <span class="text-xs">Payment methods</span>
                </a>

                <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                    <i class="fas fa-cogs w-4 text-amber-500 text-xs flex-shrink-0"></i>
                    <span class="text-xs">Other Configurations</span>
                </a>
            </div>
        </div>



        {{-- PAGES & MEDIA DROPDOWN --}}
        <div class="mb-6" x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-file-alt w-5 text-blue-500 text-sm flex-shrink-0"></i>
                    <span class="sidebar-text text-xs font-medium">Pages & Media</span>
                </div>
                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open" x-transition class="ml-8 mt-1 space-y-0.5">
                {{-- Business Pages --}}
                <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                    <i class="fas fa-briefcase w-4 text-emerald-500 text-xs flex-shrink-0"></i>
                    <span class="text-xs">Business Pages</span>
                </a>

                {{-- Social Media Links --}}
                <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                    <i class="fas fa-share-alt w-4 text-sky-500 text-xs flex-shrink-0"></i>
                    <span class="text-xs">Social Media Links</span>
                </a>

                {{-- Gallery --}}
                <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                    <i class="fas fa-images w-4 text-purple-500 text-xs flex-shrink-0"></i>
                    <span class="text-xs">Gallery</span>
                </a>

                {{-- Vendor Registration --}}
                <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                    <i class="fas fa-user-plus w-4 text-rose-500 text-xs flex-shrink-0"></i>
                    <span class="text-xs">Vendor Registration</span>
                </a>
            </div>
        </div>




    </nav>

    {{-- Footer --}}
    <div class="sidebar-text p-4 border-t border-cyan-100/50">
        <p class="text-[8px] text-gray-400 text-center">© {{ date('Y') }} aerthh.com</p>
    </div>
</aside>

{{-- Alpine.js for dropdowns --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

{{-- JavaScript for Sidebar Toggle --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const mobileTrigger = document.getElementById('mobileSidebarTrigger');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        const isMobileView = () => window.innerWidth < 1024;

        const openMobileSidebar = () => {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };

        const closeMobileSidebar = () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        const applyDesktopState = () => {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            toggleBtn.classList.remove('hidden');
            mobileTrigger.classList.add('hidden');

            if (isCollapsed) {
                sidebar.classList.add('w-20');
                sidebar.classList.remove('w-64', 'md:w-60', 'sm:w-64');
                sidebarTexts.forEach(el => el.classList.add('hidden'));
                toggleBtn.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
            } else {
                sidebar.classList.add('w-64', 'md:w-60', 'sm:w-64');
                sidebar.classList.remove('w-20');
                sidebarTexts.forEach(el => el.classList.remove('hidden'));
                toggleBtn.innerHTML = '<i class="fas fa-chevron-left text-sm"></i>';
            }
        };

        const applyMobileState = () => {
            toggleBtn.classList.add('hidden');
            mobileTrigger.classList.remove('hidden');
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            sidebarTexts.forEach(el => el.classList.remove('hidden'));
            closeMobileSidebar();
        };

        const handleViewport = () => {
            if (isMobileView()) {
                applyMobileState();
            } else {
                applyDesktopState();
            }
        };

        handleViewport();
        window.addEventListener('resize', handleViewport);

        toggleBtn.addEventListener('click', function() {
            if (isMobileView()) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                return isHidden ? openMobileSidebar() : closeMobileSidebar();
            }

            isCollapsed = !isCollapsed;

            if (isCollapsed) {
                sidebar.classList.add('w-20');
                sidebar.classList.remove('w-64', 'md:w-60', 'sm:w-64');
                sidebarTexts.forEach(el => el.classList.add('hidden'));
                toggleBtn.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
            } else {
                sidebar.classList.add('w-64', 'md:w-60', 'sm:w-64');
                sidebar.classList.remove('w-20');
                sidebarTexts.forEach(el => el.classList.remove('hidden'));
                toggleBtn.innerHTML = '<i class="fas fa-chevron-left text-sm"></i>';
            }

            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });

        mobileTrigger.addEventListener('click', openMobileSidebar);
        sidebarOverlay.addEventListener('click', closeMobileSidebar);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isMobileView() && !sidebar.classList.contains('-translate-x-full')) {
                closeMobileSidebar();
            }
        });
    });
</script>

<style>
    #sidebar {
        transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .sidebar-text {
        transition: opacity 0.2s ease;
    }

    #sidebar.w-20 .sidebar-link {
        justify-content: center;
    }

    #sidebar.w-20 .sidebar-link i {
        margin-right: 0;
    }

    #sidebar.w-20 .flex.items-center.space-x-3 {
        justify-content: center;
    }

    #sidebar.w-20 .ml-auto {
        display: none;
    }

    [x-cloak] {
        display: none !important;
    }

    @media (max-width: 1023px) {
        #sidebar {
            width: 80vw;
            max-width: 18rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
    }
</style>
