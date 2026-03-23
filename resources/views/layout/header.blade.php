{{-- resources/views/layouts/header.blade.php --}}
<header class="sticky top-0 z-40 bg-white/70 backdrop-blur-md border-b border-cyan-100/50 px-4 sm:px-6 py-3 shadow-md">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        
        {{-- Page Title --}}
        <div class="flex items-start sm:items-center gap-2 sm:gap-3">
            <button id="headerMobileSidebar" class="inline-flex lg:hidden p-2 rounded-lg border border-cyan-100 text-cyan-500 bg-white shadow-sm hover:bg-cyan-50 transition">
                <i class="fas fa-bars text-sm"></i>
            </button>
            <div class="flex flex-col leading-tight">
                <h2 class="text-sm font-semibold text-gray-700">@yield('page-title', 'Dashboard')</h2>
                <p class="text-[10px] text-gray-400">@yield('page-subtitle', 'Welcome Back ' . session('admin_name', 'Admin'))</p>
            </div>
        </div>
        
        {{-- Right Icons --}}
        <div class="flex items-center flex-wrap justify-end gap-3 sm:gap-4">
            
            {{-- Search Input --}}
            <div class="relative w-full sm:w-64 md:w-80">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       placeholder="Search..." 
                       class="w-full pl-8 pr-3 py-3 bg-white/90 border border-gray-200 rounded-2xl focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400">
            </div>
            
            {{-- Shopping Cart Icon --}}
            <button class="relative text-gray-500 hover:text-cyan-500">
                <i class="fas fa-shopping-cart text-sm"></i>
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-cyan-500 text-white text-[8px] flex items-center justify-center rounded-full">5</span>
            </button>
            
            {{-- Notifications --}}
            <button class="relative text-gray-500 hover:text-cyan-500">
                <i class="fas fa-bell text-sm"></i>
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 text-white text-[8px] flex items-center justify-center rounded-full">3</span>
            </button>
            
            {{-- Messages --}}
            <button class="relative text-gray-500 hover:text-emerald-500">
                <i class="fas fa-envelope text-sm"></i>
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-cyan-500 text-white text-[8px] flex items-center justify-center rounded-full">5</span>
            </button>
            
            {{-- Language Dropdown with Flags --}}
            <div class="relative shadow-xl rounded-full p-1" x-data="{ langOpen: false }">
                <button @click="langOpen = !langOpen" class="flex items-center space-x-1.5 px-2 py-1 rounded-lg transition-all duration-200">
                    {{-- Selected Language Flag --}}
                    <img src="https://flagcdn.com/w20/us.png" 
                         srcset="https://flagcdn.com/w40/us.png 2x" 
                         class="w-4 h-3 rounded-sm object-cover"
                         alt="US Flag">
                    <span class="text-xs font-medium text-gray-700">English</span>
                    <i class="fas fa-chevron-down text-[8px] text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': langOpen }"></i>
                </button>
                
                {{-- Language Menu with Flags --}}
                <div x-show="langOpen" 
                     @click.away="langOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-4 w-40 bg-white rounded-lg shadow-lg border border-cyan-100/50 py-1 z-50">
                    
                    {{-- English --}}
                    <a href="#" class="flex items-center space-x-2 px-3 py-1.5 text-xs text-gray-700 hover:bg-cyan-50 transition-all duration-200">
                        <img src="https://flagcdn.com/w20/us.png" 
                             srcset="https://flagcdn.com/w40/us.png 2x" 
                             class="w-4 h-3 rounded-sm object-cover"
                             alt="US Flag">
                        <span>English</span>
                    </a>
                </div>
            </div>
            
            {{-- Profile Dropdown --}}
            <div class="relative shadow-xl p-2 rounded-full border border-gray-300" x-data="{ open: false }">
                {{-- Profile Button --}}
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-400 p-0.5">
                        <img src="https://ui-avatars.com/api/?name={{ session('admin_name', 'Admin') }}&background=06b6d4&color=fff&size=100" 
                             class="w-full h-full rounded-full border-2 border-white">
                    </div>
                    <div class="text-left hidden md:block">
                        <p class="text-xs font-medium text-gray-700">{{ session('admin_name', 'Admin') }}</p>
                        <p class="text-[8px] text-gray-400">Administrator</p>
                    </div>
                    <i class="fas fa-chevron-down text-[8px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>
                
                {{-- Dropdown Menu --}}
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-4 w-48 bg-white rounded-lg shadow-lg border border-cyan-100/50 py-1 z-50">
                    
                    {{-- Profile Info --}}
                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-xs font-medium text-gray-700">{{ session('admin_name', 'Admin User') }}</p>
                        <p class="text-[9px] text-gray-400">{{ session('admin_email', 'admin@aerthh.com') }}</p>
                    </div>
                    
                    {{-- Profile Link --}}
                    <a href="#" class="block px-4 py-2 text-xs text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                        <i class="fas fa-user mr-2 text-cyan-500 w-4"></i>
                        My Profile
                    </a>
                    
                    {{-- Settings Link --}}
                    <a href="#" class="block px-4 py-2 text-xs text-gray-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-emerald-50 transition-all duration-200">
                        <i class="fas fa-cog mr-2 text-emerald-500 w-4"></i>
                        Settings
                    </a>
                    
                    {{-- Divider --}}
                    <div class="border-t border-gray-100 my-1"></div>
                    
                    {{-- Logout Button (Opens Modal) --}}
                    <button @click="$dispatch('open-logout-modal')" class="w-full text-left px-4 py-2 text-xs text-gray-600 hover:bg-rose-50 transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-2 text-rose-400 w-4"></i>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Logout Confirmation Modal --}}
<div x-data="{ showModal: false }" 
     @open-logout-modal.window="showModal = true"
     x-show="showModal" 
     class="fixed inset-0 z-50 overflow-y-auto"
     x-cloak>
    
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" 
         @click="showModal = false"
         x-show="showModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>
    
    {{-- Modal --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all sm:max-w-lg w-full"
             x-show="showModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            {{-- Modal Content --}}
            <div class="p-6">
                {{-- Icon --}}
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-rose-100 mb-4">
                    <i class="fas fa-sign-out-alt text-2xl text-rose-500"></i>
                </div>
                
                {{-- Title --}}
                <h3 class="text-center text-xl font-bold text-gray-800 mb-2">
                    Confirm Logout
                </h3>
                
                {{-- Message --}}
                <p class="text-center text-sm text-gray-500 mb-6">
                    Are you sure you want to logout from your account?
                </p>
                
                {{-- Buttons --}}
                <div class="flex space-x-3">
                    {{-- Cancel Button --}}
                    <button @click="showModal = false" 
                            class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                        Cancel
                    </button>
                    
                    {{-- Confirm Logout Button --}}
                    <form method="POST" action="{{ route('admin.logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full px-4 py-2.5 bg-gradient-to-r from-rose-500 to-rose-600 text-white text-sm font-medium rounded-lg hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                            Yes, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js for dropdown and modal --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    [x-cloak] { display: none !important; }
    
    /* Optional: Add shadow when scrolled */
    .sticky.scrolled {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
</style>

{{-- Optional: Add shadow on scroll --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('header');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Open sidebar from header hamburger on mobile
        const headerMobileSidebar = document.getElementById('headerMobileSidebar');
        const sidebarTrigger = document.getElementById('mobileSidebarTrigger');
        if (headerMobileSidebar && sidebarTrigger) {
            headerMobileSidebar.addEventListener('click', () => sidebarTrigger.click());
        }
    });
</script>
