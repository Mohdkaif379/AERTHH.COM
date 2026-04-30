<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    }
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<style>
  ::-webkit-scrollbar {
    display: none;
  }

  .sidebar-transition {
    transition: all 0.3s ease-in-out;
  }

  .content-expanded {
    margin-left: 0;
    transition: margin-left 0.3s ease-in-out;
  }

  @media (min-width: 768px) {
    .content-collapsed {
      margin-left: 70px;
    }

    .content-expanded {
      margin-left: 256px;
    }
  }

  .sidebar-text {
    transition: opacity 0.2s ease, visibility 0.2s ease;
  }

  .collapse-btn {
    transition: all 0.3s ease;
  }

  .collapse-btn:hover {
    transform: scale(1.05);
    background: rgba(249, 115, 22, 0.1);
  }
</style>
@php
$navVendorRawImage = session('vendor.image');
$navVendorImage = null;

if (!empty($navVendorRawImage)) {
if (str_starts_with($navVendorRawImage, 'http://') || str_starts_with($navVendorRawImage, 'https://')) {
$navVendorImage = $navVendorRawImage;
} elseif (str_starts_with($navVendorRawImage, 'storage/app/public/')) {
$navVendorImage = asset(str_replace('storage/app/public/', 'storage/', $navVendorRawImage));
} elseif (str_starts_with($navVendorRawImage, 'storage/')) {
$navVendorImage = asset($navVendorRawImage);
} else {
$navVendorImage = asset('storage/' . ltrim($navVendorRawImage, '/'));
}
}
@endphp

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen transition-colors duration-300">

  <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

  <aside id="sidebar" class="fixed top-0 left-0 h-full z-50 sidebar-transition shadow-2xl
    bg-white/95 dark:bg-black/95 backdrop-blur-2xl border-r border-gray-200/50 dark:border-gray-800/50 overflow-hidden"
    style="width: 256px;">

    <div class="flex flex-col h-full relative">
      <div class="px-4 py-4 border-b border-gray-200/50 dark:border-gray-800/50">
        <div class="flex items-center justify-between gap-2">
          <div class="flex items-center gap-2.5" id="logoContainer">
            <img src="{{ asset('logo.webp') }}"
              class="w-10 h-10 rounded-md shadow-sm transition-transform hover:scale-105 object-cover flex-shrink-0" alt="Logo">
            <div class="sidebar-text transition-all duration-200 overflow-hidden">
              <h1 class="text-base font-bold bg-gradient-to-r from-orange-500 to-amber-500 bg-clip-text text-transparent tracking-tight whitespace-nowrap">
                Aerthh.com
              </h1>
              <p class="text-[10px] text-gray-500 dark:text-gray-400 whitespace-nowrap">Vendor Dashboard</p>
            </div>
          </div>

          <button id="collapseSidebarBtn" class="collapse-btn hidden md:flex p-0 text-orange-600 dark:text-gray-400  rounded-lg transition-all duration-200">
            <i id="collapseIcon" class="fa fa-chevron-left text-sm"></i>
          </button>

          <button id="closeSidebarBtn" class="md:hidden text-orange-500">
            <i class="fa fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
        <a href="{{ route('vendor.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 bg-orange-500/10 text-orange-500 group">
          <i class="fa fa-tachometer-alt w-5 text-base flex-shrink-0"></i>
          <span class="sidebar-text whitespace-nowrap transition-all duration-200">Dashboard</span>
        </a>
        <div>
          <button id="productsMenuBtn" type="button" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 group">
            <span class="flex items-center gap-3">
              <i class="fa fa-box w-5 text-orange-500 flex-shrink-0"></i>
              <span class="sidebar-text whitespace-nowrap text-orange-500 transition-all duration-200">Products</span>
            </span>
            <i id="productsMenuIcon" class="fa fa-chevron-down text-xs sidebar-text text-orange-500 transition-transform duration-200"></i>
          </button>

          <div id="productsSubMenu" class="hidden mt-1 ml-2 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-3">
            <a href="{{ route('vendor.products.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-list w-3.5 text-blue-500"></i>
              <span class="text-gray-900 dark:text-white">All Products</span>
            </a>
            <a href="{{ route('vendor.products.create') }}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-plus-circle w-3.5 text-orange-500"></i>
              <span class="text-gray-900 dark:text-white">Add Product</span>
            </a>
            <a href="{{ route('vendor.pending-products.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-hourglass-half w-3.5 text-amber-500"></i>
              <span class="text-gray-900 dark:text-white">Pending Products</span>
            </a>
            <a href="{{ route('vendor.approved-products.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-circle-check w-3.5 text-green-500"></i>
              <span class="text-gray-900 dark:text-white">Approved Products</span>
            </a>
            <a href="{{route('vendor.rejected-products.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-circle-xmark w-3.5 text-red-500"></i>
              <span class="text-gray-900 dark:text-white">Rejected Products</span>
            </a>
          </div>
        </div>
        <div>
          <button id="ordersMenuBtn" type="button" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 group">
            <span class="flex items-center gap-3">
              <i class="fa fa-shopping-cart w-5 text-orange-500 flex-shrink-0"></i>
              <span class="sidebar-text whitespace-nowrap text-orange-500 transition-all duration-200">Orders</span>
            </span>
            <i id="ordersMenuIcon" class="fa fa-chevron-down text-xs sidebar-text text-orange-500 transition-transform duration-200"></i>
          </button>

          <div id="ordersSubMenu" class="hidden mt-1 ml-2 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-3">
            <a href="{{route('vendor.pending-orders.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-hourglass-half w-3.5 text-amber-500"></i>
              <span class="text-gray-900 dark:text-white">Pending</span>
            </a>
            <a href="{{route('vendor.confirmed-orders.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-circle-check w-3.5 text-green-500"></i>
              <span class="text-gray-900 dark:text-white">Confirmed</span>
            </a>
            <a href="{{route('vendor.packaging-orders.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-box w-3.5 text-blue-500"></i>
              <span class="text-gray-900 dark:text-white">Packaging</span>
            </a>
            <a href="{{route('vendor.out-for-delivery-orders.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-truck w-3.5 text-purple-500"></i>
              <span class="text-gray-900 dark:text-white">Out for Delivery</span>
            </a>
            <a href="{{route('vendor.delivered-orders.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-check-circle w-3.5 text-emerald-500"></i>
              <span class="text-gray-900 dark:text-white">Delivered</span>
            </a>
            <a href="{{route('vendor.failed.delivery.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-spinner w-3.5 text-yellow-500"></i>
              <span class="text-gray-900 dark:text-white">Failed to Deliver</span>
            </a>
            <a href="{{route('vendor.cancel-orders.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-times-circle w-3.5 text-red-500"></i>
              <span class="text-gray-900 dark:text-white">Cancelled</span>
            </a>
            <a href="{{route('vendor.returned-orders.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-undo w-3.5 text-indigo-500"></i>
              <span class="text-gray-900 dark:text-white">Returned</span>
            </a>
          </div>
        </div>
        <div>
          <button id="analyticsMenuBtn" type="button" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 group">
            <span class="flex items-center gap-3">
              <i class="fa fa-chart-line w-5 text-orange-500 flex-shrink-0"></i>
              <span class="sidebar-text whitespace-nowrap text-orange-500 transition-all duration-200">Analytics</span>
            </span>
            <i id="analyticsMenuIcon" class="fa fa-chevron-down text-xs sidebar-text text-orange-500 transition-transform duration-200"></i>
          </button>

          <div id="analyticsSubMenu" class="hidden mt-1 ml-2 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-3">
            <a href="{{route('vendor.order-insight.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-shopping-bag w-3.5 text-blue-500"></i>
              <span class="text-gray-900 dark:text-white">Order Insights</span>
            </a>
            <a href="{{ route('vendor.revenue-profit.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-coins w-3.5 text-green-500"></i>
              <span class="text-gray-900 dark:text-white">Revenue & Profit</span>
            </a>

            <a href="{{route('vendor.report.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-file-export w-3.5 text-purple-500"></i>
              <span class="text-gray-900 dark:text-white">Reports / Exports</span>
            </a>
          </div>
        </div>
        <div>
          <button id="settingsMenuBtn" type="button" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 group">
            <span class="flex items-center gap-3">
              <i class="fa fa-cog w-5 text-orange-500 flex-shrink-0"></i>
              <span class="sidebar-text whitespace-nowrap text-orange-500 transition-all duration-200">Settings</span>
            </span>
            <i id="settingsMenuIcon" class="fa fa-chevron-down text-xs sidebar-text text-orange-500 transition-transform duration-200"></i>
          </button>

          <div id="settingsSubMenu" class="hidden mt-1 ml-2 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-3">
            <a href="{{route('vendor.account-setting.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-user-gear w-3.5 text-blue-500"></i>
              <span class="text-gray-900 dark:text-white">Account Settings</span>
            </a>
            <a href="{{route('vendor.wallet.index')}}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-wallet w-3.5 text-green-500"></i>
              <span class="text-gray-900 dark:text-white">Wallet</span>
            </a>
            <a href="{{ route('vendor.faq.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-question-circle w-3.5 text-purple-500"></i>
              <span class="text-gray-900 dark:text-white">FAQ</span>
            </a>
            <a href="{{ route('vendor.privacy-policy.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-shield-alt w-3.5 text-indigo-500"></i>
              <span class="text-gray-900 dark:text-white">Privacy Policy</span>
            </a>
            <a href="{{ route('vendor.password-manager.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-key w-3.5 text-red-500"></i>
              <span class="text-gray-900 dark:text-white">Password Manager</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-2 text-xs rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">
              <i class="fa fa-money-bill-wave w-3.5 text-red-500"></i>
              <span class="text-gray-900 dark:text-white">Withdrawal</span>
            </a>
          </div>


          <a href="{{ route('vendor.support-ticket.index') }}"
            class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl 
             text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">

            <i class="fa fa-ticket-alt w-5 text-orange-500"></i>
            <span class="text-orange-500">Support Tickets</span>

          </a>

          <a href="{{ route('vendor.my-product-reviews.index') }}"
            class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl 
            text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">

            <i class="fa fa-star w-5 text-orange-500"></i>
            <span class="text-orange-500">Reviews</span>

          </a>

          <a href="{{ route('vendor.history.index') }}"
            class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl 
   text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5">

            <i class="fa fa-history w-5 text-orange-500"></i>
            <span class="text-orange-500">History</span>

          </a>
        </div>
      </nav>

      <div class="p-4 border-t border-gray-200/50 dark:border-gray-800/50">
        <div class="sidebar-text text-center">
          <div class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
            <i class="fa fa-shield-alt mr-1"></i> Aerthh.com &copy; {{ date('Y') }}
          </div>
        </div>
      </div>
    </div>
  </aside>

  <div id="mainContent" class="flex flex-col min-h-screen content-expanded transition-all duration-300">
    @php
    $navVendor = session('vendor');
    $navAvailableBalance = 0;

    if ($navVendor) {
    $navDeliveredOrdersQuery = \App\Models\Order::where('vendor_id', $navVendor['id'])
    ->where('status', 'delivered');

    $navTotalEarnings = (clone $navDeliveredOrdersQuery)
    ->get()
    ->sum(function (\App\Models\Order $order) {
    return (float) $order->total_price + (float) ($order->shipping_cost ?? 0);
    });

    $navPendingPayout = 0;
    $navAvailableBalance = $navTotalEarnings - $navPendingPayout;
    }
    @endphp

    <header class="sticky top-0 z-30 bg-white/80 dark:bg-black backdrop-blur-2xl border-b border-gray-200/50 dark:border-gray-800/50">
      <div class="px-4 sm:px-6 py-2.5 flex items-center justify-between">

        <div class="flex items-center gap-3">
          <button id="openSidebarBtn" class="md:hidden p-2 text-gray-600 dark:text-gray-400 hover:text-orange-500 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all">
            <i class="fa fa-bars text-xl"></i>
          </button>

          <div class="hidden sm:block">
            <p class="text-sm text-gray-500 dark:text-gray-400">Welcome back, <span class="text-black dark:text-orange-500 font-semibold" id="headerVendorName"></span></p>
          </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
          <div class="hidden sm:flex items-center gap-2 rounded-2xl bg-white/90 dark:bg-gray-900/90 px-3 py-2 shadow-lg border border-gray-200/70 dark:border-gray-800/70">
            <div class="w-2.5 h-2.5 rounded-full bg-orange-500 shadow-[0_0_12px_rgba(249,115,22,0.65)]"></div>
            <div class="leading-tight">
              <div class="text-sm font-bold text-gray-900 dark:text-white">&#8377;{{ number_format($navAvailableBalance, 2) }}</div>
            </div>
          </div>

          <div class="flex items-center gap-2 rounded-2xl bg-white/90 dark:bg-gray-900/90 px-3 py-2 shadow-lg border border-gray-200/70 dark:border-gray-800/70">
            <div class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-[0_0_12px_rgba(34,197,94,0.65)]"></div>
            <div class="leading-tight text-center">
              <div id="indiaTime" class="text-sm font-bold text-gray-900 dark:text-white whitespace-nowrap"> --:--:--</div>
            </div>
          </div>

          <button class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-orange-500  rounded-lg transition-all">
            <i class="fa fa-bell text-lg"></i>
            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-orange-500 rounded-full border-2 border-white dark:border-gray-900"></span>
          </button>

          <button id="themeToggle" class="p-2 text-gray-600 dark:text-gray-400 hover:text-orange-500  rounded-lg transition-all">
            <i id="themeIcon" class="fa fa-moon text-lg"></i>
          </button>

          <button id="escActionBtn" type="button" class="p-2 text-gray-600 dark:text-gray-400 hover:text-orange-500 rounded-lg transition-all" title="Fullscreen">
            <i id="escActionIcon" class="fa fa-expand text-lg"></i>
          </button>

          <div class="relative">
            <button id="userMenuBtn" class="flex items-center gap-2  rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all shadow-2xl">
              <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-white/50 dark:border-gray-700 shadow-md" id="vendorAvatar">
                <img id="vendorAvatarImg" src="{{ $navVendorImage ?: '' }}" alt="Vendor Avatar" class="w-full h-full object-cover rounded-full" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" loading="lazy">
                <i class="fa fa-user text-white text-xs font-medium absolute inset-0 flex items-center justify-center bg-gradient-to-r from-orange-500 to-amber-500 rounded-full" style="display:none;"></i>
              </div>
            </button>

            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-black border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg shadow-black/10 dark:shadow-black/40 py-1.5 z-50">
              <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800 bg-gradient-to-r from-gray-50 dark:from-gray-900/50 rounded-t-xl">

                <p class="font-semibold text-sm" id="dropdownVendorName">{{ session('vendor.name', 'Vendor') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                  {{ session('vendor.email', 'vendor@aerthh.com') }}
                </p>

              </div>
              <a href="{{route('vendor.account-setting.index')}}" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                <i class="fa fa-user mr-2"></i> Profile
              </a>
              <a href="{{ route('vendor.password-manager.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                <i class="fa fa-cog mr-2"></i> Password Manager
              </a>
              <hr class="my-1 border-gray-200 dark:border-gray-800">

              <button onclick="openLogoutModal()" class="w-full text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                <i class="fa fa-sign-out-alt mr-2 text-xs"></i> Logout
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>

    <main class="flex-1 p-2 sm:p-4 lg:p-6 overflow-y-auto ">
      @yield('content')
    </main>
  </div>

  <!-- Logout Modal -->
  <div id="logoutModal" class="fixed inset-0 bg-black/50 z-[9999] hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-sm w-full mx-4 p-6 border border-gray-200 dark:border-gray-800">
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-2xl mx-auto mb-4 flex items-center justify-center">
          <i class="fa fa-exclamation-triangle text-2xl text-red-500"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Confirm Logout</h3>
        <p class="text-gray-600 dark:text-gray-300">Are you sure you want to logout? You will need to login again to access your dashboard.</p>
      </div>
      <form id="logoutModalForm" method="POST" action="{{ route('vendor.logout') }}">
        @csrf
        <div class="flex gap-3">
          <button type="button" onclick="closeLogoutModal()" class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded-xl transition-all font-medium">
            Cancel
          </button>
          <button type="submit" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-all font-medium shadow-lg hover:shadow-xl">
            Yes, Logout
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Logout Modal Functions
    window.openLogoutModal = function() {
      document.getElementById('logoutModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    };

    window.closeLogoutModal = function() {
      document.getElementById('logoutModal').classList.add('hidden');
      document.body.style.overflow = '';
    };

    function closeTransientHeaderUI() {
      const userDropdown = document.getElementById('userDropdown');
      if (userDropdown) {
        userDropdown.classList.add('hidden');
      }

      const logoutModal = document.getElementById('logoutModal');
      if (logoutModal && !logoutModal.classList.contains('hidden')) {
        closeLogoutModal();
      }
    }

    const escActionBtn = document.getElementById('escActionBtn');
    const escActionIcon = document.getElementById('escActionIcon');

    function updateFullscreenIcon() {
      if (!escActionIcon) {
        return;
      }

      if (document.fullscreenElement) {
        escActionIcon.classList.remove('fa-expand');
        escActionIcon.classList.add('fa-compress');
        if (escActionBtn) {
          escActionBtn.title = 'Exit Fullscreen';
        }
      } else {
        escActionIcon.classList.remove('fa-compress');
        escActionIcon.classList.add('fa-expand');
        if (escActionBtn) {
          escActionBtn.title = 'Fullscreen';
        }
      }
    }

    if (escActionBtn) {
      escActionBtn.addEventListener('click', async () => {
        closeTransientHeaderUI();

        try {
          if (!document.fullscreenElement) {
            await document.documentElement.requestFullscreen();
          } else {
            await document.exitFullscreen();
          }
          updateFullscreenIcon();
        } catch (error) {
          console.error('Fullscreen toggle failed:', error);
        }
      });
    }

    document.addEventListener('fullscreenchange', updateFullscreenIcon);
    updateFullscreenIcon();

    window.performLogout = function() {
      document.getElementById('logoutForm').submit();
    };



    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeTransientHeaderUI();
      }
    });

    const indiaTimeEl = document.getElementById('indiaTime');

    function updateIndiaTime() {
      if (!indiaTimeEl) {
        return;
      }

      const parts = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true,
      }).formatToParts(new Date());

      const timeString = parts.map((part) => {
        if (part.type === 'dayPeriod') {
          return part.value.toUpperCase();
        }

        return part.value;
      }).join('');

      indiaTimeEl.textContent = timeString;
    }

    updateIndiaTime();
    setInterval(updateIndiaTime, 1000);

    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');

    const themeIcon = document.getElementById('themeIcon');
    const html = document.documentElement;

    function updateTheme() {
      if (localStorage.theme === 'light' || (!localStorage.theme && window.matchMedia('(prefers-color-scheme: light)').matches)) {
        html.classList.remove('dark');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
      } else {
        html.classList.add('dark');
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
      }
    }

    updateTheme();
    themeToggle.addEventListener('click', () => {
      html.classList.toggle('dark');
      localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
      updateTheme();
    });

    // Sidebar Collapse
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const collapseBtn = document.getElementById('collapseSidebarBtn');
    const collapseIcon = document.getElementById('collapseIcon');
    const logoContainer = document.getElementById('logoContainer');
    const logoImg = document.querySelector('#logoContainer img');
    const productsMenuBtn = document.getElementById('productsMenuBtn');
    const productsSubMenu = document.getElementById('productsSubMenu');
    const productsMenuIcon = document.getElementById('productsMenuIcon');

    let isSidebarCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';

    function applySidebarState() {
      if (window.innerWidth >= 768) {
        if (isSidebarCollapsed) {
          sidebar.style.width = '70px';
          mainContent.classList.remove('content-expanded');
          mainContent.classList.add('content-collapsed');

          if (collapseIcon) {
            collapseIcon.className = 'fa fa-chevron-right text-sm';
          }

          document.querySelectorAll('.sidebar-text').forEach(el => {
            el.style.opacity = '0';
            el.style.visibility = 'hidden';
            el.style.width = '0';
            el.style.display = 'none';
          });

          document.querySelectorAll('#sidebar nav a').forEach(el => {
            el.style.justifyContent = 'center';
            el.style.padding = '0.625rem 0';
          });

          // Fix logo cut: reduce size and center without margin
          if (logoContainer) {
            logoContainer.style.marginLeft = '0';
            logoContainer.style.justifyContent = 'center';
            logoContainer.style.gap = '0';
          }
          if (logoImg) {
            logoImg.style.width = '32px';
            logoImg.style.height = '32px';
          }

          if (productsSubMenu) {
            productsSubMenu.classList.add('hidden');
          }
          if (productsMenuIcon) {
            productsMenuIcon.classList.remove('rotate-180');
          }

        } else {
          sidebar.style.width = '256px';
          mainContent.classList.remove('content-collapsed');
          mainContent.classList.add('content-expanded');

          if (collapseIcon) {
            collapseIcon.className = 'fa fa-chevron-left text-sm';
          }

          document.querySelectorAll('.sidebar-text').forEach(el => {
            el.style.opacity = '1';
            el.style.visibility = 'visible';
            el.style.width = 'auto';
            el.style.display = 'block';
          });

          document.querySelectorAll('#sidebar nav a').forEach(el => {
            el.style.justifyContent = 'flex-start';
            el.style.padding = '0.625rem 0.75rem';
          });

          if (logoContainer) {
            logoContainer.style.marginLeft = '0';
            logoContainer.style.justifyContent = 'flex-start';
            logoContainer.style.gap = '0.625rem';
          }
          if (logoImg) {
            logoImg.style.width = '40px';
            logoImg.style.height = '40px';
          }
        }
      } else {
        sidebar.style.width = '256px';
        mainContent.classList.remove('content-collapsed');
        mainContent.classList.add('content-expanded');
        document.querySelectorAll('.sidebar-text').forEach(el => {
          el.style.opacity = '1';
          el.style.visibility = 'visible';
          el.style.width = 'auto';
          el.style.display = 'block';
        });
        if (logoContainer) {
          logoContainer.style.marginLeft = '0';
          logoContainer.style.justifyContent = 'flex-start';
          logoContainer.style.gap = '0.625rem';
        }
        if (logoImg) {
          logoImg.style.width = '40px';
          logoImg.style.height = '40px';
        }
        if (collapseIcon) {
          collapseIcon.className = 'fa fa-chevron-left text-sm';
        }
      }
    }

    function toggleSidebarCollapse() {
      isSidebarCollapsed = !isSidebarCollapsed;
      localStorage.setItem('sidebar_collapsed', isSidebarCollapsed);
      applySidebarState();
    }

    if (collapseBtn) {
      collapseBtn.addEventListener('click', toggleSidebarCollapse);
    }

    if (productsMenuBtn) {
      productsMenuBtn.addEventListener('click', () => {
        if (window.innerWidth >= 768 && isSidebarCollapsed) {
          return;
        }
        productsSubMenu.classList.toggle('hidden');
        productsMenuIcon.classList.toggle('rotate-180');
      });
    }

    // Orders menu toggle
    const ordersMenuBtn = document.getElementById('ordersMenuBtn');
    const ordersSubMenu = document.getElementById('ordersSubMenu');
    const ordersMenuIcon = document.getElementById('ordersMenuIcon');

    if (ordersMenuBtn) {
      ordersMenuBtn.addEventListener('click', () => {
        if (window.innerWidth >= 768 && isSidebarCollapsed) {
          return;
        }
        ordersSubMenu.classList.toggle('hidden');
        ordersMenuIcon.classList.toggle('rotate-180');
      });
    }

    // Settings menu toggle
    const settingsMenuBtn = document.getElementById('settingsMenuBtn');
    const settingsSubMenu = document.getElementById('settingsSubMenu');
    const settingsMenuIcon = document.getElementById('settingsMenuIcon');

    if (settingsMenuBtn) {
      settingsMenuBtn.addEventListener('click', () => {
        if (window.innerWidth >= 768 && isSidebarCollapsed) {
          return;
        }
        settingsSubMenu.classList.toggle('hidden');
        settingsMenuIcon.classList.toggle('rotate-180');
      });
    }

    // Analytics menu toggle
    const analyticsMenuBtn = document.getElementById('analyticsMenuBtn');
    const analyticsSubMenu = document.getElementById('analyticsSubMenu');
    const analyticsMenuIcon = document.getElementById('analyticsMenuIcon');

    if (analyticsMenuBtn) {
      analyticsMenuBtn.addEventListener('click', () => {
        if (window.innerWidth >= 768 && isSidebarCollapsed) {
          return;
        }
        analyticsSubMenu.classList.toggle('hidden');
        analyticsMenuIcon.classList.toggle('rotate-180');
      });
    }

    applySidebarState();

    window.addEventListener('resize', () => {
      applySidebarState();
      if (window.innerWidth >= 768) {
        if (overlay) overlay.classList.add('hidden');
        document.body.style.overflow = '';
      } else {
        if (!sidebar.classList.contains('-translate-x-full')) {
          sidebar.classList.add('-translate-x-full');
        }
        sidebar.style.width = '256px';
        mainContent.classList.remove('content-collapsed');
        mainContent.classList.add('content-expanded');
      }
    });

    // Mobile sidebar
    const overlay = document.getElementById('sidebarOverlay');
    const openBtn = document.getElementById('openSidebarBtn');
    const closeBtn = document.getElementById('closeSidebarBtn');

    function openMobileSidebar() {
      sidebar.classList.remove('-translate-x-full');
      sidebar.classList.add('translate-x-0');
      if (overlay) overlay.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeMobileSidebar() {
      sidebar.classList.add('-translate-x-full');
      sidebar.classList.remove('translate-x-0');
      if (overlay) overlay.classList.add('hidden');
      document.body.style.overflow = '';
    }

    if (openBtn) openBtn.addEventListener('click', openMobileSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeMobileSidebar);
    if (overlay) overlay.addEventListener('click', closeMobileSidebar);

    // User Dropdown
    const userBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');

    if (userBtn) {
      userBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        userDropdown.classList.toggle('hidden');
      });
    }

    document.addEventListener('click', () => {
      if (userDropdown) userDropdown.classList.add('hidden');
    });

    // Vendor Data
    window.getVendorDetails = function() {
      try {
        return JSON.parse(localStorage.getItem('vendor_data') || '{}');
      } catch (e) {
        console.error('Vendor data parse error:', e);
        return {};
      }
    };

    window.resolveVendorImageUrl = function(path) {
      const baseUrl = "{{ url('/') }}";
      if (!path) return '';
      if (path.startsWith('http://') || path.startsWith('https://')) return path;
      if (path.startsWith('storage/app/public/')) {
        return baseUrl + '/' + path.replace('storage/app/public/', 'storage/');
      }
      if (path.startsWith('storage/')) {
        return baseUrl + '/' + path;
      }
      return baseUrl + '/storage/' + path.replace(/^\/+/, '');
    };

    window.updateAllVendorUI = function() {
      const vendor = window.getVendorDetails();
      const vendorName = vendor.name || 'Vendor';
      const vendorEmail = vendor.email || 'vendor@example.com';
      const vendorImage = window.resolveVendorImageUrl(vendor.image || '');

      const headerName = document.getElementById('headerVendorName');
      if (headerName) headerName.textContent = vendorName;

      const dropdownName = document.getElementById('dropdownVendorName');
      if (dropdownName) dropdownName.textContent = vendorName;

      const dropdownEmail = document.getElementById('dropdownVendorEmail');
      if (dropdownEmail) dropdownEmail.textContent = vendorEmail;

      // Update vendor avatar
      const avatarEl = document.getElementById('vendorAvatarImg');
      if (avatarEl && vendorImage) {
        avatarEl.src = vendorImage;
        avatarEl.style.display = 'block';
        avatarEl.nextElementSibling.style.display = 'none';
      }

      window.dispatchEvent(new CustomEvent('vendorDataUpdated', {
        detail: vendor
      }));
      return vendor;
    };

    // Vendor data loaded via session (server-side auth)
    window.updateAllVendorUI();
  </script>
</body>

</html>