@extends('vendor.layout.navbar')
@section('content')

<div class="max-w-4xl mx-auto">
  <!-- Page Header -->
  <div class="mb-8">
    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Withdrawal Request</h2>
    <p class="text-gray-500 dark:text-gray-400 mt-2">Choose your preferred payout method and enter details.</p>
  </div>

  @if(session('success'))
  <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-2xl flex items-center gap-3 animate-bounce">
    <i class="fa fa-check-circle text-xl"></i>
    <span class="font-bold">{{ session('success') }}</span>
  </div>
  @endif

  @if($errors->any())
  <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-2xl">
    <div class="flex items-center gap-3 mb-2">
      <i class="fa fa-exclamation-triangle text-xl"></i>
      <span class="font-bold">Please fix the following errors:</span>
    </div>
    <ul class="list-disc list-inside text-sm opacity-90">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Balance Summary Card -->
    <div class="md:col-span-1">
      <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-3xl p-6 shadow-2xl shadow-orange-500/20 text-white relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-4 -bottom-4 w-32 h-32 bg-black/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
          <p class="text-orange-100 text-sm font-medium opacity-80">Available Balance</p>
          <h3 class="text-4xl font-bold mt-1">₹{{ number_format($availableBalance ?? 0, 2) }}</h3>
          <div class="mt-8 flex items-center gap-2 text-xs text-orange-100 bg-white/10 w-fit px-3 py-1.5 rounded-full backdrop-blur-md">
            <i class="fa fa-info-circle"></i>
            <span>Settled earnings only</span>
          </div>
        </div>
      </div>

      <div class="mt-6 bg-white dark:bg-gray-800/50 backdrop-blur-xl border border-gray-200 dark:border-gray-700/50 rounded-3xl p-6">
        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Payout Info</h4>
        <ul class="space-y-4">
          <li class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
              <i class="fa fa-clock text-blue-600 dark:text-blue-400 text-xs"></i>
            </div>
            <div>
              <p class="text-xs font-bold text-gray-900 dark:text-white">Processing Time</p>
              <p class="text-[10px] text-gray-500">Usually 24-48 business hours</p>
            </div>
          </li>
          <li class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
              <i class="fa fa-shield-check text-green-600 dark:text-green-400 text-xs"></i>
            </div>
            <div>
              <p class="text-xs font-bold text-gray-900 dark:text-white">Secure Payout</p>
              <p class="text-[10px] text-gray-500">Verified payment gateways only</p>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- Main Form Container -->
    <div class="md:col-span-2">
      <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl overflow-hidden shadow-sm">
        <!-- Tab Headers -->
        <div class="flex p-2 bg-gray-50 dark:bg-black/40 border-b border-gray-200 dark:border-gray-800">
          <button onclick="switchTab('bank')" id="tab-bank" class="flex-1 flex items-center justify-center gap-2 py-3 text-sm font-bold rounded-2xl transition-all duration-300 tab-active">
            <i class="fa fa-university text-lg"></i>
            <span>Bank Transfer</span>
          </button>
          <button onclick="switchTab('upi')" id="tab-upi" class="flex-1 flex items-center justify-center gap-2 py-3 text-sm font-bold rounded-2xl transition-all duration-300 text-gray-500 dark:text-gray-400 hover:text-orange-500 dark:hover:text-orange-400">
            <i class="fa fa-mobile-screen text-lg"></i>
            <span>UPI ID</span>
          </button>
        </div>

        <!-- Form Body -->
        <div class="p-6 sm:p-8">
          <!-- Bank Transfer Form -->
          <form id="form-bank" action="{{ route('vendor.withdrawal.store') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="payment_type" value="bank_transfer">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1">Account Holder Name</label>
                <div class="relative group">
                  <i class="fa fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                  <input type="text" name="account_holder_name" placeholder="John Doe" required
                    class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all dark:text-white placeholder:text-gray-400">
                </div>
              </div>
              <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1">Account Number</label>
                <div class="relative group">
                  <i class="fa fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                  <input type="text" name="account_number" placeholder="0000 0000 0000" required
                    class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all dark:text-white placeholder:text-gray-400">
                </div>
              </div>
              <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1">Bank Name</label>
                <div class="relative group">
                  <i class="fa fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                  <input type="text" name="bank_name" placeholder="HDFC Bank" required
                    class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all dark:text-white placeholder:text-gray-400">
                </div>
              </div>
              <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1">IFSC Code</label>
                <div class="relative group">
                  <i class="fa fa-code absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                  <input type="text" name="ifsc_code" placeholder="HDFC0001234" required
                    class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all dark:text-white placeholder:text-gray-400">
                </div>
              </div>
            </div>
            <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-gray-800">
              <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1">Amount (₹)</label>
              <div class="relative group">
                <i class="fa fa-indian-rupee-sign absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                <input type="number" name="amount" min="1" placeholder="Enter amount to withdraw" required
                  class="w-full pl-11 pr-4 py-4 bg-orange-50/30 dark:bg-orange-500/5 border border-orange-200 dark:border-orange-900/30 rounded-2xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all dark:text-white font-bold text-lg">
              </div>
            </div>
            <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-2xl shadow-lg shadow-orange-500/30 transition-all hover:scale-[1.01] active:scale-[0.98] mt-4">
              Submit Bank Transfer Request
            </button>
          </form>

          <!-- UPI ID Form -->
          <form id="form-upi" action="{{ route('vendor.withdrawal.store') }}" method="POST" class="space-y-6 hidden">
            @csrf
            <input type="hidden" name="payment_type" value="upi">
            <div class="space-y-2">
              <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1">UPI ID</label>
              <div class="relative group">
                <i class="fa fa-at absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                <input type="text" name="upi_id" placeholder="username@bank" required
                  class="w-full pl-11 pr-4 py-4 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all dark:text-white placeholder:text-gray-400">
              </div>
              <p class="text-[10px] text-gray-500 ml-1">Example: yourname@upi, 9876543210@paytm</p>
            </div>
            <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-gray-800">
              <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1">Amount (₹)</label>
              <div class="relative group">
                <i class="fa fa-indian-rupee-sign absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                <input type="number" name="amount" min="1" placeholder="Enter amount to withdraw" required
                  class="w-full pl-11 pr-4 py-4 bg-orange-50/30 dark:bg-orange-500/5 border border-orange-200 dark:border-orange-900/30 rounded-2xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all dark:text-white font-bold text-lg">
              </div>
            </div>
            <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-2xl shadow-lg shadow-orange-500/30 transition-all hover:scale-[1.01] active:scale-[0.98] mt-4">
              Submit UPI Request
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .tab-active {
    background-color: white;
    color: #f97316;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
  }
  
  .dark .tab-active {
    background-color: #111;
    color: #fb923c;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.5);
  }

  /* Fade animation */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  form:not(.hidden) {
    animation: fadeIn 0.4s ease-out forwards;
  }
</style>

<script>
  function switchTab(type) {
    const bankForm = document.getElementById('form-bank');
    const upiForm = document.getElementById('form-upi');
    const bankTab = document.getElementById('tab-bank');
    const upiTab = document.getElementById('tab-upi');

    if (type === 'bank') {
      bankForm.classList.remove('hidden');
      upiForm.classList.add('hidden');
      
      bankTab.classList.add('tab-active');
      bankTab.classList.remove('text-gray-500', 'dark:text-gray-400');
      
      upiTab.classList.remove('tab-active');
      upiTab.classList.add('text-gray-500', 'dark:text-gray-400');
    } else {
      upiForm.classList.remove('hidden');
      bankForm.classList.add('hidden');
      
      upiTab.classList.add('tab-active');
      upiTab.classList.remove('text-gray-500', 'dark:text-gray-400');
      
      bankTab.classList.remove('tab-active');
      bankTab.classList.add('text-gray-500', 'dark:text-gray-400');
    }
  }
</script>

@endsection