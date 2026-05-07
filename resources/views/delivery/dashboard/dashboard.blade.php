@extends('delivery.layout.navbar')

@section('content')
<script>
    const successMsg = @json(session('success') ?? '');
    const errorMsg = @json(session('error') ?? '');
    
    if (successMsg) {
        // Bottom right toast with progress bar
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 z-50 bg-green-500/95 text-white px-6 py-4 rounded-2xl shadow-2xl backdrop-blur-md border border-green-400/30 max-w-sm text-sm animate-slide-in-right';
        toast.innerHTML = `
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-check-circle text-lg"></i>
                <span class="font-medium">${successMsg}</span>
            </div>
            <div class="h-1 bg-green-400/50 rounded-full overflow-hidden">
                <div class="h-full bg-green-400 rounded-full transition-all duration-4000" style="width: 100%; animation: progress 4s linear forwards;"></div>
            </div>
        `;
        document.body.appendChild(toast);
        
        // Auto remove with animation
        setTimeout(() => {
            toast.style.animation = 'slide-out-right 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 3800);
    }
    if (errorMsg) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-2xl backdrop-blur-md max-w-sm text-sm';
        toast.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>${errorMsg}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }
</script>
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold dark:text-white light:text-gray-800">Dashboard</h2>
<p class="text-gray-500 text-sm mt-1">Welcome back, {{ $deliveryMan?->full_name ?? 'Delivery Partner' }}! Here's your delivery performance overview</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Today's Earnings -->
        <div class="dark:bg-black/30 light:bg-white rounded-xl p-4 border dark:border-[#22152a] light:border-gray-200 hover:shadow-lg transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs">Today's Earnings</p>
                    <p class="text-2xl font-bold dark:text-white light:text-gray-800 mt-1">₹1,280</p>
                    <span class="text-green-500 text-xs flex items-center gap-1 mt-1"><i class="fas fa-arrow-up text-[10px]"></i> +12% from yesterday</span>
                </div>
                <div class="w-10 h-10 bg-[#F43F5E]/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-[#FB7185] text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="dark:bg-black/30 light:bg-white rounded-xl p-4 border dark:border-[#22152a] light:border-gray-200 hover:shadow-lg transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs">Total Orders</p>
                    <p class="text-2xl font-bold dark:text-white light:text-gray-800 mt-1">156</p>
                    <span class="text-green-500 text-xs flex items-center gap-1 mt-1"><i class="fas fa-arrow-up text-[10px]"></i> +24 this month</span>
                </div>
                <div class="w-10 h-10 bg-[#F43F5E]/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-[#FB7185] text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Rating -->
        <div class="dark:bg-black/30 light:bg-white rounded-xl p-4 border dark:border-[#22152a] light:border-gray-200 hover:shadow-lg transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs">Customer Rating</p>
                    <p class="text-2xl font-bold dark:text-white light:text-gray-800 mt-1">4.98</p>
                    <span class="text-yellow-500 text-xs flex items-center gap-1 mt-1"><i class="fas fa-star text-[10px]"></i> ⭐ 4.98 (245 reviews)</span>
                </div>
                <div class="w-10 h-10 bg-[#F43F5E]/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-[#FB7185] text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="dark:bg-black/30 light:bg-white rounded-xl p-4 border dark:border-[#22152a] light:border-gray-200 hover:shadow-lg transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs">Completion Rate</p>
                    <p class="text-2xl font-bold dark:text-white light:text-gray-800 mt-1">98.5%</p>
                    <span class="text-green-500 text-xs flex items-center gap-1 mt-1"><i class="fas fa-check-circle text-[10px]"></i> Excellent</span>
                </div>
                <div class="w-10 h-10 bg-[#F43F5E]/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-[#FB7185] text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="dark:bg-black/30 light:bg-white rounded-xl border dark:border-[#22152a] light:border-gray-200 overflow-hidden">
        <div class="px-5 py-3 border-b dark:border-[#22152a] light:border-gray-200 flex items-center justify-between">
            <h3 class="font-semibold dark:text-white light:text-gray-800 text-sm">
                <i class="fas fa-truck-fast text-[#FB7185] mr-2"></i>Recent Orders
            </h3>
            <a href="#" class="text-[#FB7185] text-xs hover:underline">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="dark:bg-black/50 light:bg-gray-50">
                    <tr>
                        <th class="text-left px-5 py-3 text-gray-500 text-xs font-medium">Order ID</th>
                        <th class="text-left px-5 py-3 text-gray-500 text-xs font-medium">Customer</th>
                        <th class="text-left px-5 py-3 text-gray-500 text-xs font-medium">Amount</th>
                        <th class="text-left px-5 py-3 text-gray-500 text-xs font-medium">Status</th>
                        <th class="text-left px-5 py-3 text-gray-500 text-xs font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b dark:border-[#22152a] light:border-gray-100 hover:dark:bg-[#F43F5E]/5 hover:light:bg-gray-50 transition-all">
                        <td class="px-5 py-3 text-[#FB7185] text-xs font-mono">#ORD-1001</td>
                        <td class="px-5 py-3 dark:text-gray-300 light:text-gray-600 text-xs">Rahul Mehta</td>
                        <td class="px-5 py-3 dark:text-white light:text-gray-800 text-xs font-semibold">₹249</td>
                        <td class="px-5 py-3">
                            <span class="bg-yellow-500/20 text-yellow-500 text-[10px] px-2 py-1 rounded-full">Pending</span>
                        </td>
                        <td class="px-5 py-3">
                            <button class="text-[#FB7185] text-xs hover:underline">View</button>
                        </td>
                    </tr>
                    <tr class="border-b dark:border-[#22152a] light:border-gray-100 hover:dark:bg-[#F43F5E]/5 hover:light:bg-gray-50 transition-all">
                        <td class="px-5 py-3 text-[#FB7185] text-xs font-mono">#ORD-1002</td>
                        <td class="px-5 py-3 dark:text-gray-300 light:text-gray-600 text-xs">Priya Singh</td>
                        <td class="px-5 py-3 dark:text-white light:text-gray-800 text-xs font-semibold">₹599</td>
                        <td class="px-5 py-3">
                            <span class="bg-green-500/20 text-green-500 text-[10px] px-2 py-1 rounded-full">Delivered</span>
                        </td>
                        <td class="px-5 py-3">
                            <button class="text-[#FB7185] text-xs hover:underline">View</button>
                        </td>
                    </tr>
                    <tr class="border-b dark:border-[#22152a] light:border-gray-100 hover:dark:bg-[#F43F5E]/5 hover:light:bg-gray-50 transition-all">
                        <td class="px-5 py-3 text-[#FB7185] text-xs font-mono">#ORD-1003</td>
                        <td class="px-5 py-3 dark:text-gray-300 light:text-gray-600 text-xs">Amit Kumar</td>
                        <td class="px-5 py-3 dark:text-white light:text-gray-800 text-xs font-semibold">₹899</td>
                        <td class="px-5 py-3">
                            <span class="bg-blue-500/20 text-blue-500 text-[10px] px-2 py-1 rounded-full">Out for Delivery</span>
                        </td>
                        <td class="px-5 py-3">
                            <button class="text-[#FB7185] text-xs hover:underline">View</button>
                        </td>
                    </tr>
                    <tr class="hover:dark:bg-[#F43F5E]/5 hover:light:bg-gray-50 transition-all">
                        <td class="px-5 py-3 text-[#FB7185] text-xs font-mono">#ORD-1004</td>
                        <td class="px-5 py-3 dark:text-gray-300 light:text-gray-600 text-xs">Neha Gupta</td>
                        <td class="px-5 py-3 dark:text-white light:text-gray-800 text-xs font-semibold">₹349</td>
                        <td class="px-5 py-3">
                            <span class="bg-yellow-500/20 text-yellow-500 text-[10px] px-2 py-1 rounded-full">Pending</span>
                        </td>
                        <td class="px-5 py-3">
                            <button class="text-[#FB7185] text-xs hover:underline">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Performance Chart Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Weekly Earnings Chart -->
        <div class="dark:bg-black/30 light:bg-white rounded-xl p-4 border dark:border-[#22152a] light:border-gray-200">
            <h3 class="font-semibold dark:text-white light:text-gray-800 text-sm mb-3">
                <i class="fas fa-chart-line text-[#FB7185] mr-2"></i>Weekly Earnings
            </h3>
            <div class="flex items-end justify-between h-32 gap-2">
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-[#F43F5E]/20 rounded-lg h-16" style="height: 60px;"></div>
                    <p class="text-gray-500 text-[10px] mt-2">Mon</p>
                </div>
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-[#F43F5E]/40 rounded-lg h-24" style="height: 80px;"></div>
                    <p class="text-gray-500 text-[10px] mt-2">Tue</p>
                </div>
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-[#F43F5E]/60 rounded-lg h-28" style="height: 100px;"></div>
                    <p class="text-gray-500 text-[10px] mt-2">Wed</p>
                </div>
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-[#F43F5E] rounded-lg h-32" style="height: 120px;"></div>
                    <p class="text-gray-500 text-[10px] mt-2">Thu</p>
                </div>
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-[#F43F5E]/50 rounded-lg h-20" style="height: 70px;"></div>
                    <p class="text-gray-500 text-[10px] mt-2">Fri</p>
                </div>
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-[#F43F5E]/30 rounded-lg h-18" style="height: 65px;"></div>
                    <p class="text-gray-500 text-[10px] mt-2">Sat</p>
                </div>
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-[#F43F5E]/20 rounded-lg h-12" style="height: 45px;"></div>
                    <p class="text-gray-500 text-[10px] mt-2">Sun</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dark:bg-black/30 light:bg-white rounded-xl p-4 border dark:border-[#22152a] light:border-gray-200">
            <h3 class="font-semibold dark:text-white light:text-gray-800 text-sm mb-3">
                <i class="fas fa-bolt text-[#FB7185] mr-2"></i>Quick Actions
            </h3>
            <div class="space-y-2">
                <a href="#" class="flex items-center justify-between p-3 rounded-lg dark:hover:bg-[#F43F5E]/5 light:hover:bg-gray-50 transition-all">
                    <span class="dark:text-gray-300 light:text-gray-600 text-sm">View Today's Orders</span>
                    <i class="fas fa-arrow-right text-[#FB7185] text-xs"></i>
                </a>
                <a href="#" class="flex items-center justify-between p-3 rounded-lg dark:hover:bg-[#F43F5E]/5 light:hover:bg-gray-50 transition-all">
                    <span class="dark:text-gray-300 light:text-gray-600 text-sm">Check Earnings Summary</span>
                    <i class="fas fa-arrow-right text-[#FB7185] text-xs"></i>
                </a>
                <a href="#" class="flex items-center justify-between p-3 rounded-lg dark:hover:bg-[#F43F5E]/5 light:hover:bg-gray-50 transition-all">
                    <span class="dark:text-gray-300 light:text-gray-600 text-sm">Update Availability Status</span>
                    <i class="fas fa-arrow-right text-[#FB7185] text-xs"></i>
                </a>
                <a href="#" class="flex items-center justify-between p-3 rounded-lg dark:hover:bg-[#F43F5E]/5 light:hover:bg-gray-50 transition-all">
                    <span class="dark:text-gray-300 light:text-gray-600 text-sm">Contact Support</span>
                    <i class="fas fa-arrow-right text-[#FB7185] text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection