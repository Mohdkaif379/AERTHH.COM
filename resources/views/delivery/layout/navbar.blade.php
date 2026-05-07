<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Aerthh.com | Delivery Partner Panel</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
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

    <style>
        ::-webkit-scrollbar {
            width: 2px;
            height: 2px;
        }

        html.dark ::-webkit-scrollbar-track {
            background: #1a0f14;
        }

        html.dark ::-webkit-scrollbar-thumb {
            background: #F43F5E;
            border-radius: 10px;
        }

        html.light ::-webkit-scrollbar-track {
            background: #e5e7eb;
        }

        html.light ::-webkit-scrollbar-thumb {
            background: #F43F5E;
            border-radius: 10px;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(244, 63, 94, 0.2), transparent);
            border-left: 3px solid #F43F5E;
        }

        html.light .nav-item.active {
            background: linear-gradient(90deg, rgba(244, 63, 94, 0.12), transparent);
        }

        .sidebar-scroll {
            scrollbar-width: thin;
        }

        .content-area {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        * {
            transition: background-color 0.25s ease-in-out,
                border-color 0.25s ease-in-out,
                color 0.2s ease-in-out,
                box-shadow 0.2s ease-in-out,
                width 0.3s ease-in-out,
                padding 0.3s ease-in-out;
        }

        html.dark body {
            background: linear-gradient(135deg, #0a0508 0%, #1a0f14 100%);
        }

        html.light body {
            background: linear-gradient(135deg, #e8e8e8 0%, #d4d4d4 100%);
        }

        html.dark main {
            background: linear-gradient(135deg, #0a0508 0%, #1a0f14 100%);
        }

        html.light main {
            background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
        }

        .sidebar {
            transition: width 0.3s ease-in-out;
        }

        html.dark .sidebar {
            background-color: #0A0610;
            border-right-color: #22152a;
        }

        html.light .sidebar {
            background-color: #ffffff;
            border-right-color: #e5e7eb;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        }

        html.dark header {
            background-color: rgba(15, 7, 18, 0.95);
            border-bottom-color: #22152a;
        }

        html.light header {
            background-color: rgba(255, 255, 255, 0.95);
            border-bottom-color: #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .search-input:focus {
            border-color: #F43F5E !important;
            box-shadow: 0 0 0 1px #F43F5E !important;
        }

        html.dark .search-input {
            border-color: #F43F5E;
        }

        html.light .search-input {
            border-color: #F43F5E;
        }

        /* Sidebar collapsed styles */
        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .nav-item span:not(.absolute),
        .sidebar.collapsed .user-name,
        .sidebar.collapsed .user-id,
        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        .sidebar.collapsed .nav-item i {
            margin-right: 0 !important;
        }

        .sidebar.collapsed .flex.items-center.gap-2 {
            justify-content: center;
        }

        .sidebar.collapsed .user-info {
            display: none;
        }

        .sidebar.collapsed .relative {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body class="font-sans h-screen overflow-hidden">

    <div class="flex h-screen">

        <!-- ========== SIDEBAR ========== -->
        <aside id="sidebar" class="sidebar w-64 flex flex-col h-full overflow-visible">

            <!-- Logo Area with Collapse Button -->
            <div class="p-4 border-b dark:border-[#22152a] light:border-gray-200 relative">
                <div class="flex items-center gap-2">
                    <div class="bg-gradient-to-br from-[#F43F5E] to-[#BE123C] rounded-lg p-1.5 flex-shrink-0">
                        <i class="fas fa-motorcycle text-white text-md"></i>
                    </div>
                    <div class="logo-text overflow-hidden whitespace-nowrap">
                        <h1 class="text-md font-bold dark:text-white light:text-gray-800">Mk<span class="text-[#FB7185]">Industry</span></h1>
                        <p class="text-gray-500 text-[8px]">Delivery Panel</p>
                    </div>
                </div>
                <!-- Collapse Button - Inside Sidebar -->
                <button id="collapseBtn" class="absolute -right-3 mr-2 top-5 w-6 h-6 rounded-full  text-[#FB7185] flex items-center justify-center  hover:scale-110 transition-all z-10">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-2 space-y-0.5 overflow-y-auto sidebar-scroll">
                <a href="{{ route('delivery.dashboard') }}" class="nav-item active flex items-center gap-2 px-3 py-2 rounded-lg dark:text-white light:text-gray-700 dark:bg-[#F43F5E]/10 light:bg-[#F43F5E]/8 transition-all whitespace-nowrap">
                    <i class="fas fa-tachometer-alt w-4 text-[#FB7185] text-sm"></i>
                    <span class="sidebar-text text-xs font-medium">Dashboard</span>
                </a>

                <a href="{{ route('delivery.my-assigned-orders.index') }}" class="nav-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 dark:text-gray-400 light:text-gray-500 hover:dark:text-white hover:light:text-gray-800 hover:bg-[#F43F5E]/10 transition-all group whitespace-nowrap">
                    <i class="fas fa-shopping-cart w-4 text-gray-500 group-hover:text-[#FB7185] text-sm"></i>
                    <span class="sidebar-text text-xs">Orders</span>
                </a>

                <a href="#" class="nav-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 dark:text-gray-400 light:text-gray-500 hover:dark:text-white hover:light:text-gray-800 hover:bg-[#F43F5E]/10 transition-all group whitespace-nowrap">
                    <i class="fas fa-rupee-sign w-4 text-gray-500 group-hover:text-[#FB7185] text-sm"></i>
                    <span class="sidebar-text text-xs">Earnings</span>
                </a>

                <a href="{{ route('delivery.history.index') }}" class="nav-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 dark:text-gray-400 light:text-gray-500 hover:dark:text-white hover:light:text-gray-800 hover:bg-[#F43F5E]/10 transition-all group whitespace-nowrap">
                    <i class="fas fa-history w-4 text-gray-500 group-hover:text-[#FB7185] text-sm"></i>
                    <span class="sidebar-text text-xs">Delivery History</span>
                </a>

                <a href="#" class="nav-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 dark:text-gray-400 light:text-gray-500 hover:dark:text-white hover:light:text-gray-800 hover:bg-[#F43F5E]/10 transition-all group whitespace-nowrap">
                    <i class="fas fa-wallet w-4 text-gray-500 group-hover:text-[#FB7185] text-sm"></i>
                    <span class="sidebar-text text-xs">Wallet</span>
                </a>

                <a href="#" class="nav-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 dark:text-gray-400 light:text-gray-500 hover:dark:text-white hover:light:text-gray-800 hover:bg-[#F43F5E]/10 transition-all group whitespace-nowrap">
                    <i class="fas fa-file-alt w-4 text-gray-500 group-hover:text-[#FB7185] text-sm"></i>
                    <span class="sidebar-text text-xs">Documents</span>
                </a>

                <a href="#" class="nav-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 dark:text-gray-400 light:text-gray-500 hover:dark:text-white hover:light:text-gray-800 hover:bg-[#F43F5E]/10 transition-all group whitespace-nowrap">
                    <i class="fas fa-user-cog w-4 text-gray-500 group-hover:text-[#FB7185] text-sm"></i>
                    <span class="sidebar-text text-xs">Profile Settings</span>
                </a>

                <a href="#" class="nav-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 dark:text-gray-400 light:text-gray-500 hover:dark:text-white hover:light:text-gray-800 hover:bg-[#F43F5E]/10 transition-all group whitespace-nowrap">
                    <i class="fas fa-headset w-4 text-gray-500 group-hover:text-[#FB7185] text-sm"></i>
                    <span class="sidebar-text text-xs">Support</span>
                </a>
            </nav>

            <!-- User Info + Logout -->
            <div class="border-t dark:border-[#22152a] light:border-gray-200 p-3">
                <!-- Logout Button -->
                <a href="javascript:void(0)" onclick="openLogoutModal()" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 hover:text-[#F43F5E] hover:bg-[#F43F5E]/10 transition-all group">
                    <i class="fas fa-sign-out-alt w-4 text-gray-500 group-hover:text-[#F43F5E] text-sm"></i>
                    <span class="sidebar-text text-xs font-medium">Logout</span>
                </a>
            </div>
        </aside>

        <!-- ========== MAIN CONTENT ========== -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- ========== HEADER ========== -->
            <header class="backdrop-blur-sm px-5 py-2.5 flex items-center justify-between shadow-sm relative z-40">
                <div>
                    <h2 class="dark:text-white light:text-gray-800 text-md font-semibold">Dashboard</h2>
                    <p class="text-gray-500 text-[9px]">Welcome back, partner!</p>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Search -->
                    <div class="relative hidden md:block">
                        <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-500 text-[10px]"></i>
                        <input type="text" id="searchInput" placeholder="Search orders..." class="search-input dark:bg-black/30 light:bg-gray-100 border rounded-lg pl-8 pr-3 py-1.5 dark:text-white light:text-gray-700 text-[11px] placeholder:text-gray-500 focus:outline-none transition-all w-48" style="border-color: #F43F5E;">
                    </div>

                    <!-- Full Screen Button -->
                    <button id="fullscreenBtn" class="relative p-1.5 rounded-lg hover:bg-[#F43F5E]/10 transition-all">
                        <i class="fas fa-expand text-gray-400 text-sm"></i>
                    </button>

                    <!-- Theme Toggle -->
                    <button id="themeToggle" class="relative p-1.5 rounded-lg hover:bg-[#F43F5E]/10 transition-all">
                        <i id="themeIconSun" class="fas fa-sun text-gray-400 text-sm hidden"></i>
                        <i id="themeIconMoon" class="fas fa-moon text-gray-400 text-sm"></i>
                    </button>

                    @php
                        $deliveryManId = session('delivery_man')->id ?? session('delivery_man')['id'] ?? null;
                        $notifications = collect();
                        $unreadCount = 0;
                        if ($deliveryManId) {
                            $dmModel = \App\Models\DeliveryMan::find($deliveryManId);
                            if ($dmModel) {
                                $notifications = $dmModel->notifications()->latest()->take(5)->get();
                                $unreadCount = $dmModel->unreadNotifications->count();
                            }
                        }
                    @endphp

                    <!-- Notifications -->
                    <div class="relative group">
                        <button class="relative p-1.5 rounded-lg hover:bg-[#F43F5E]/10 transition-all">
                            <i class="fas fa-bell text-gray-400 text-sm"></i>
                            <div id="notificationBadgeContainer">
                                @if($unreadCount > 0)
                                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 dark:border-[#0F0712] light:border-white"></span>
                                @endif
                            </div>
                        </button>

                        {{-- Notifications Dropdown --}}
                        <div class="absolute right-0 mt-2 w-72 bg-white dark:bg-[#1a1121] rounded-xl shadow-2xl border dark:border-[#22152a] overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[9999]">
                            <div class="px-4 py-3 border-b dark:border-[#22152a] bg-gray-50 dark:bg-black/20 flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-200">Notifications</span>
                                <div id="notificationCountBadge">
                                    @if($unreadCount > 0)
                                        <span class="text-[10px] bg-[#F43F5E] text-white px-2 py-0.5 rounded-full">{{ $unreadCount }} New</span>
                                    @endif
                                </div>
                            </div>
                            <div id="notificationList" class="max-h-64 overflow-y-auto sidebar-scroll">
                                @forelse($notifications as $notification)
                                    <a href="{{ $notification->data['action_url'] ?? '#' }}" class="block px-4 py-3 hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition-all border-b dark:border-[#22152a] last:border-0 {{ $notification->read_at ? '' : 'bg-blue-50/30 dark:bg-[#F43F5E]/5' }}">
                                        <div class="flex gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-[#F43F5E]/10 flex items-center justify-center text-[#FB7185]">
                                                <i class="fas fa-shopping-bag text-xs"></i>
                                            </div>
                                            <div>
                                                <p class="text-[11px] text-gray-700 dark:text-gray-300 leading-tight">
                                                    {{ $notification->data['message'] ?? 'New notification' }}
                                                </p>
                                                <p class="text-[9px] text-gray-400 mt-1">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-8 text-center text-gray-400">
                                        <i class="fas fa-bell-slash text-xl mb-2 block opacity-30"></i>
                                        <span class="text-[10px]">No notifications yet</span>
                                    </div>
                                @endforelse
                            </div>
                            <div id="notificationFooter" class="{{ $notifications->isEmpty() ? 'hidden' : '' }} px-4 py-2 border-t dark:border-[#22152a] text-center">
                                <a href="{{ route('delivery.my-assigned-orders.index') }}" class="text-[10px] font-bold text-[#FB7185] hover:underline">View All Orders</a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="flex items-center gap-3 pl-3 border-l dark:border-gray-700 light:border-gray-200">
                        <div class="relative">
                            <div class="w-9 h-9 rounded-full overflow-hidden border border-[#F43F5E]/30 flex items-center justify-center bg-gradient-to-br from-[#F43F5E]/20 to-[#BE123C]/20">

                                @if(session('delivery_man') && !empty(session('delivery_man')['profile_photo']))
                                <img src="{{ asset('storage/' . session('delivery_man')['profile_photo']) }}"
                                    class="w-full h-full object-contain"
                                    alt="profile">
                                @else
                                <i class="fas fa-user-alt text-[#FB7185] text-sm"></i>
                                @endif

                            </div>

                            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 dark:border-[#0F0712] light:border-white"></span>
                        </div>
                        <div class="hidden md:block">
                            <h3 class="dark:text-white light:text-gray-800 text-sm font-semibold">
                                {{ session('delivery_man')['full_name'] ?? 'Guest' }}
                            </h3>
                            <!-- <p class="text-gray-400 text-[9px]">
                                ID: {{ session('delivery_man')['id'] ?? 'N/A' }}
                            </p> -->
                        </div>
                    </div>
                </div>
            </header>

            <!-- ========== DYNAMIC CONTENT AREA ========== -->
            <main class="flex-1 overflow-y-auto p-5 content-area">
                @yield('content')

            </main>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div id="logoutModalOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

            <!-- Modal Panel -->
            <div class="inline-block align-bottom dark:bg-[#1A1021] bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border dark:border-[#F43F5E]/20 border-gray-100">
                <div class="p-6">
                    <div class="flex flex-col items-center text-center">
                        <!-- Icon -->
                        <div class="w-16 h-16 rounded-full bg-[#F43F5E]/10 flex items-center justify-center mb-4">
                            <i class="fas fa-sign-out-alt text-2xl text-[#F43F5E]"></i>
                        </div>
                        
                        <!-- Text -->
                        <h3 class="text-lg font-bold dark:text-white text-gray-800 mb-2">Ready to Leave?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to log out? You'll need to log back in to manage your deliveries.</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 dark:bg-black/20 bg-gray-50 flex gap-3">
                    <button type="button" onclick="closeLogoutModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 dark:text-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        Stay
                    </button>
                    <a href="{{ route('delivery.logout') }}" class="flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#F43F5E] to-[#BE123C] text-white text-sm font-semibold text-center hover:shadow-lg hover:shadow-[#F43F5E]/20 transition-all">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('logoutModalOverlay')?.addEventListener('click', closeLogoutModal);

        (function() {
            const html = document.documentElement;
            const sunIcon = document.getElementById('themeIconSun');
            const moonIcon = document.getElementById('themeIconMoon');
            const themeToggle = document.getElementById('themeToggle');
            const searchInput = document.getElementById('searchInput');
            const sidebar = document.getElementById('sidebar');
            const collapseBtn = document.getElementById('collapseBtn');
            const fullscreenBtn = document.getElementById('fullscreenBtn');

            let isCollapsed = false;

            // Collapse/Expand Sidebar
            collapseBtn.addEventListener('click', function() {
                isCollapsed = !isCollapsed;
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    collapseBtn.innerHTML = '<i class="fas fa-chevron-right text-xs"></i>';
                } else {
                    sidebar.classList.remove('collapsed');
                    collapseBtn.innerHTML = '<i class="fas fa-chevron-left text-xs"></i>';
                }
            });

            // Full Screen Functionality
            function toggleFullscreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(err => {
                        console.log(`Error: ${err.message}`);
                    });
                    fullscreenBtn.innerHTML = '<i class="fas fa-compress text-gray-400 text-sm"></i>';
                } else {
                    document.exitFullscreen();
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand text-gray-400 text-sm"></i>';
                }
            }

            fullscreenBtn.addEventListener('click', toggleFullscreen);

            // ESC key to exit fullscreen
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && document.fullscreenElement) {
                    document.exitFullscreen();
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand text-gray-400 text-sm"></i>';
                }
            });

            // Update fullscreen button icon when fullscreen changes
            document.addEventListener('fullscreenchange', function() {
                if (document.fullscreenElement) {
                    fullscreenBtn.innerHTML = '<i class="fas fa-compress text-gray-400 text-sm"></i>';
                } else {
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand text-gray-400 text-sm"></i>';
                }
            });

            function updateIcons() {
                if (html.classList.contains('dark')) {
                    if (sunIcon) sunIcon.classList.add('hidden');
                    if (moonIcon) moonIcon.classList.remove('hidden');
                } else {
                    if (sunIcon) sunIcon.classList.remove('hidden');
                    if (moonIcon) moonIcon.classList.add('hidden');
                }
            }

            function updateSearchBorder() {
                if (searchInput) {
                    searchInput.style.borderColor = '#F43F5E';
                }
            }

            function initTheme() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'light') {
                    html.classList.remove('dark');
                    html.classList.add('light');
                } else if (savedTheme === 'dark') {
                    html.classList.remove('light');
                    html.classList.add('dark');
                } else {
                    html.classList.remove('light');
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
                updateIcons();
                updateSearchBorder();
            }

            function toggleTheme() {
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    html.classList.add('light');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.remove('light');
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
                updateIcons();
                updateSearchBorder();
            }

            initTheme();
            if (themeToggle) themeToggle.addEventListener('click', toggleTheme);

            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    this.style.borderColor = '#F43F5E';
                    this.style.boxShadow = '0 0 0 1px #F43F5E';
                });
                searchInput.addEventListener('blur', function() {
                    this.style.borderColor = '#F43F5E';
                    this.style.boxShadow = 'none';
                });
            }
        })();

        // Real-time Notification Polling
        (function() {
            const fetchUrl = "{{ route('delivery.notifications.fetch') }}";
            const badgeContainer = document.getElementById('notificationBadgeContainer');
            const countBadge = document.getElementById('notificationCountBadge');
            const listContainer = document.getElementById('notificationList');
            const footer = document.getElementById('notificationFooter');

            function fetchNotifications() {
                fetch(fetchUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Update Badge on Bell
                        if (data.unreadCount > 0) {
                            badgeContainer.innerHTML = '<span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 dark:border-[#0F0712] light:border-white"></span>';
                            countBadge.innerHTML = `<span class="text-[10px] bg-[#F43F5E] text-white px-2 py-0.5 rounded-full">${data.unreadCount} New</span>`;
                        } else {
                            badgeContainer.innerHTML = '';
                            countBadge.innerHTML = '';
                        }

                        // Update List
                        if (data.notifications.length > 0) {
                            footer.classList.remove('hidden');
                            let html = '';
                            data.notifications.forEach(n => {
                                const bgClass = n.is_read ? '' : 'bg-blue-50/30 dark:bg-[#F43F5E]/5';
                                html += `
                                    <a href="${n.url}" class="block px-4 py-3 hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition-all border-b dark:border-[#22152a] last:border-0 ${bgClass}">
                                        <div class="flex gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-[#F43F5E]/10 flex items-center justify-center text-[#FB7185]">
                                                <i class="fas fa-shopping-bag text-xs"></i>
                                            </div>
                                            <div>
                                                <p class="text-[11px] text-gray-700 dark:text-gray-300 leading-tight">${n.message}</p>
                                                <p class="text-[9px] text-gray-400 mt-1">${n.time}</p>
                                            </div>
                                        </div>
                                    </a>
                                `;
                            });
                            listContainer.innerHTML = html;
                        } else {
                            footer.classList.add('hidden');
                            listContainer.innerHTML = `
                                <div class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-bell-slash text-xl mb-2 block opacity-30"></i>
                                    <span class="text-[10px]">No notifications yet</span>
                                </div>
                            `;
                        }
                    })
                    .catch(err => console.error('Notification Error:', err));
            }

            // Poll every 15 seconds
            setInterval(fetchNotifications, 15000);
        })();
    </script>
    @stack('scripts')
</body>

</html>