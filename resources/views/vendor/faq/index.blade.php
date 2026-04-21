@extends('vendor.layout.navbar')

@section('title', 'FAQ - Help Center')

@section('content')
<div class="space-y-8">
  <!-- Enhanced Header with gradient and icon animation -->
  <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-orange-50 to-amber-50 dark:from-slate-800/50 dark:to-slate-900/50 p-8 mb-6 border border-orange-100 dark:border-orange-900/30">
    <div class="absolute top-0 right-0 -mr-16 -mt-16">
      <div class="w-48 h-48 rounded-full bg-orange-200/30 dark:bg-orange-500/10 blur-3xl"></div>
    </div>
    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-lg">
          <i class="fa fa-question-circle text-3xl text-orange-500"></i>
        </div>
        <div>
          <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-amber-600 dark:from-orange-400 dark:to-amber-400 bg-clip-text text-transparent">Frequently Asked Questions</h1>
          <p class="text-gray-600 dark:text-gray-300 mt-1">Find quick answers to common questions about selling on Aerthh</p>
        </div>
      </div>
      <!-- Support contact chip -->
      <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-full px-4 py-2 shadow-sm">
        <i class="fa fa-headset text-orange-500 mr-2"></i>
        <span class="text-sm text-gray-700 dark:text-gray-300">Need more help? </span>
        <a href="#" class="text-sm font-semibold text-orange-600 hover:text-orange-700">Contact Support →</a>
      </div>
    </div>
  </div>

  <!-- Main FAQ Card -->
  <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl border border-gray-200 dark:border-gray-700 shadow-2xl max-w-5xl mx-auto overflow-hidden">
    <!-- Search Bar -->
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-900/30">
      <div class="relative max-w-md">
        <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
        <input type="text" id="faqSearch" placeholder="Search questions or keywords..." 
               class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all text-gray-800 dark:text-white placeholder-gray-400">
      </div>
      <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
        <i class="fa fa-lightbulb-o text-amber-500"></i>
        
      </p>
    </div>

    <!-- FAQ Accordion Container -->
    <div class="divide-y divide-gray-200 dark:divide-gray-700" id="faqContainer">
      <!-- FAQ Item 1 -->
      <div class="faq-item transition-all duration-200 hover:bg-gray-50/50 dark:hover:bg-slate-700/30" data-question="How do I add a new product? product add create listing" data-answer="Go to Products → Add Product from sidebar. Fill product details, upload images, set price and save. Product will be reviewed by admin before going live.">
        <button class="w-full text-left flex items-center justify-between px-6 py-5 focus:outline-none group">
          <div class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
              <i class="fa fa-plus text-sm faq-icon-indicator"></i>
            </div>
            <span class="font-semibold text-gray-800 dark:text-white text-lg">How do I add a new product?</span>
          </div>
          <i class="fa fa-chevron-down text-gray-400 dark:text-gray-500 transition-all duration-300 faq-chevron"></i>
        </button>
        <div class="faq-answer hidden px-6 pb-5 pl-[4.5rem] text-gray-600 dark:text-gray-300 leading-relaxed border-l-2 border-orange-200 dark:border-orange-800 ml-10">
          <p>Go to <strong class="text-orange-600 dark:text-orange-400">Products → Add Product</strong> from sidebar. Fill product details, upload high-quality images, set price and save. The product will be reviewed by admin within 24 hours before going live. You'll receive a notification once approved.</p>
          <div class="mt-3 flex gap-2 text-xs text-gray-500">
            <span class="bg-gray-100 dark:bg-slate-700 px-2 py-1 rounded-full"><i class="fa fa-image mr-1"></i> Max 10 images</span>
            <span class="bg-gray-100 dark:bg-slate-700 px-2 py-1 rounded-full"><i class="fa fa-tag mr-1"></i> Use clear pricing</span>
          </div>
        </div>
      </div>

      <!-- FAQ Item 2 -->
      <div class="faq-item transition-all duration-200 hover:bg-gray-50/50 dark:hover:bg-slate-700/30" data-question="How do I track my orders? order tracking status delivery" data-answer="Use Orders menu in sidebar to see all your orders in different statuses: Pending, Confirmed, Packaging, Out for Delivery, Delivered, etc.">
        <button class="w-full text-left flex items-center justify-between px-6 py-5 focus:outline-none group">
          <div class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
              <i class="fa fa-plus text-sm faq-icon-indicator"></i>
            </div>
            <span class="font-semibold text-gray-800 dark:text-white text-lg">How do I track my orders?</span>
          </div>
          <i class="fa fa-chevron-down text-gray-400 dark:text-gray-500 transition-all duration-300 faq-chevron"></i>
        </button>
        <div class="faq-answer hidden px-6 pb-5 pl-[4.5rem] text-gray-600 dark:text-gray-300 leading-relaxed border-l-2 border-orange-200 dark:border-orange-800 ml-10">
          <p>Navigate to the <strong class="text-orange-600 dark:text-orange-400">Orders</strong> section in the sidebar. Here you can filter orders by status: <span class="inline-flex flex-wrap gap-1 mt-1"> <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full text-xs">Pending</span> <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs">Confirmed</span> <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full text-xs">Packaging</span> <span class="bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded-full text-xs">Out for Delivery</span> <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs">Delivered</span></span>. Click on any order to see detailed tracking information and customer details.</p>
        </div>
      </div>

      <!-- FAQ Item 3 -->
      <div class="faq-item transition-all duration-200 hover:bg-gray-50/50 dark:hover:bg-slate-700/30" data-question="When will I receive payments? payment payout revenue profit" data-answer="Payments are processed weekly for all Delivered orders. Check Revenue & Profit in Analytics for payment history and details.">
        <button class="w-full text-left flex items-center justify-between px-6 py-5 focus:outline-none group">
          <div class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
              <i class="fa fa-plus text-sm faq-icon-indicator"></i>
            </div>
            <span class="font-semibold text-gray-800 dark:text-white text-lg">When will I receive payments?</span>
          </div>
          <i class="fa fa-chevron-down text-gray-400 dark:text-gray-500 transition-all duration-300 faq-chevron"></i>
        </button>
        <div class="faq-answer hidden px-6 pb-5 pl-[4.5rem] text-gray-600 dark:text-gray-300 leading-relaxed border-l-2 border-orange-200 dark:border-orange-800 ml-10">
          <p>Payments are processed <strong class="text-orange-600">every Monday</strong> for all <strong>Delivered</strong> orders completed in the previous week (Monday to Sunday). You can view your payment history, upcoming payouts, and detailed revenue breakdown in <strong class="text-orange-600">Analytics → Revenue & Profit</strong>. The first payout may take up to 14 days for verification.</p>
          <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-xl text-sm">
            <i class="fa fa-info-circle text-green-600 mr-1"></i> Minimum payout threshold: ₹500
          </div>
        </div>
      </div>

      <!-- FAQ Item 4 -->
      <div class="faq-item transition-all duration-200 hover:bg-gray-50/50 dark:hover:bg-slate-700/30" data-question="My product is rejected. What now? product rejected reason resubmit" data-answer="Check Rejected Products section for rejection reason. Edit the product and resubmit. Admin will review again within 24 hours.">
        <button class="w-full text-left flex items-center justify-between px-6 py-5 focus:outline-none group">
          <div class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
              <i class="fa fa-plus text-sm faq-icon-indicator"></i>
            </div>
            <span class="font-semibold text-gray-800 dark:text-white text-lg">My product is rejected. What now?</span>
          </div>
          <i class="fa fa-chevron-down text-gray-400 dark:text-gray-500 transition-all duration-300 faq-chevron"></i>
        </button>
        <div class="faq-answer hidden px-6 pb-5 pl-[4.5rem] text-gray-600 dark:text-gray-300 leading-relaxed border-l-2 border-orange-200 dark:border-orange-800 ml-10">
          <p>Don't worry! Go to <strong class="text-orange-600">Products → Rejected Products</strong> to see the specific reason provided by the admin (e.g., low-quality images, incomplete description, pricing issue). Make the necessary changes and click <strong>"Resubmit for Review"</strong>. The admin team will re-evaluate within 24 hours. Most products are approved on the second attempt.</p>
        </div>
      </div>

      <!-- FAQ Item 5 -->
      <div class="faq-item transition-all duration-200 hover:bg-gray-50/50 dark:hover:bg-slate-700/30" data-question="How can I contact support? support help live chat email" data-answer="Use live chat from dashboard header or email support@aerthh.com. Response within 4 hours during business days.">
        <button class="w-full text-left flex items-center justify-between px-6 py-5 focus:outline-none group">
          <div class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
              <i class="fa fa-plus text-sm faq-icon-indicator"></i>
            </div>
            <span class="font-semibold text-gray-800 dark:text-white text-lg">How can I contact support?</span>
          </div>
          <i class="fa fa-chevron-down text-gray-400 dark:text-gray-500 transition-all duration-300 faq-chevron"></i>
        </button>
        <div class="faq-answer hidden px-6 pb-5 pl-[4.5rem] text-gray-600 dark:text-gray-300 leading-relaxed border-l-2 border-orange-200 dark:border-orange-800 ml-10">
          <p>We offer multiple support channels:</p>
          <ul class="list-disc list-inside mt-2 space-y-1">
            <li><i class="fa fa-comment text-orange-500 w-5"></i> <strong>Live Chat</strong> - Click the chat icon at the bottom right corner of your dashboard (available 9 AM - 9 PM IST)</li>
            <li><i class="fa fa-envelope text-orange-500 w-5"></i> <strong>Email</strong> - <a href="mailto:support@aerthh.com" class="text-orange-600 underline">support@aerthh.com</a> (Response within 4 business hours)</li>
            <li><i class="fa fa-whatsapp text-green-500 w-5"></i> <strong>WhatsApp</strong> - +91 98765 43210 (for urgent queries)</li>
          </ul>
        </div>
      </div>

      <!-- FAQ Item 6 - New: Shipping & Returns -->
      <div class="faq-item transition-all duration-200 hover:bg-gray-50/50 dark:hover:bg-slate-700/30" data-question="What are the shipping and return policies? shipping return policy courier" data-answer="Vendors are responsible for shipping within 2-3 days. Returns are processed through customer support.">
        <button class="w-full text-left flex items-center justify-between px-6 py-5 focus:outline-none group">
          <div class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
              <i class="fa fa-plus text-sm faq-icon-indicator"></i>
            </div>
            <span class="font-semibold text-gray-800 dark:text-white text-lg">What are the shipping and return policies?</span>
          </div>
          <i class="fa fa-chevron-down text-gray-400 dark:text-gray-500 transition-all duration-300 faq-chevron"></i>
        </button>
        <div class="faq-answer hidden px-6 pb-5 pl-[4.5rem] text-gray-600 dark:text-gray-300 leading-relaxed border-l-2 border-orange-200 dark:border-orange-800 ml-10">
          <p><strong>Shipping:</strong> Vendors must dispatch orders within 2-3 business days. You can use our integrated courier partners or your own. <strong>Returns:</strong> Customers can request returns within 7 days of delivery. Return shipping is handled by Aerthh in case of damaged/wrong items. For other cases, vendor and customer can mutually decide.</p>
        </div>
      </div>
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="hidden text-center py-12 px-6">
      <i class="fa fa-search text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
      <p class="text-gray-500 dark:text-gray-400 text-lg">No matching questions found.</p>
      <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Try different keywords or <a href="#" class="text-orange-500 underline">contact support</a></p>
    </div>

    <!-- Footer Helpful Section -->
    <div class="bg-gray-50 dark:bg-slate-900/50 px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
        <i class="fa fa-thumbs-up text-gray-500"></i>
        <span>Was this helpful?</span>
        <button class="ml-2 text-xs bg-white dark:bg-slate-800 px-3 py-1 rounded-full border shadow-sm hover:bg-orange-50 transition">Yes</button>
        <button class="text-xs bg-white dark:bg-slate-800 px-3 py-1 rounded-full border shadow-sm hover:bg-orange-50 transition">No</button>
      </div>
      <div class="text-sm">
        <a href="#" class="text-orange-600 hover:underline flex items-center gap-1"><i class="fa fa-arrow-right"></i> View all guides</a>
      </div>
    </div>
  </div>
</div>

<script>
  (function() {
    // Get all FAQ items
    const faqItems = document.querySelectorAll('.faq-item');
    const searchInput = document.getElementById('faqSearch');
    const noResultsDiv = document.getElementById('noResults');
    const faqContainer = document.getElementById('faqContainer');

    // Function to close all answers
    function closeAllAnswers() {
      document.querySelectorAll('.faq-answer').forEach(answer => {
        answer.classList.add('hidden');
        // Reset chevron rotation
        const chevron = answer.closest('.faq-item')?.querySelector('.faq-chevron');
        if (chevron) chevron.classList.remove('rotate-180');
        // Reset plus/minus icon
        const indicator = answer.closest('.faq-item')?.querySelector('.faq-icon-indicator');
        if (indicator) {
          indicator.classList.remove('fa-minus');
          indicator.classList.add('fa-plus');
        }
      });
    }

    // Toggle single answer
    function toggleAnswer(button) {
      const faqItem = button.closest('.faq-item');
      const answer = faqItem.querySelector('.faq-answer');
      const chevron = faqItem.querySelector('.faq-chevron');
      const indicator = faqItem.querySelector('.faq-icon-indicator');
      const isHidden = answer.classList.contains('hidden');
      
      // Close all others
      closeAllAnswers();
      
      if (isHidden) {
        // Open this one
        answer.classList.remove('hidden');
        chevron.classList.add('rotate-180');
        indicator.classList.remove('fa-plus');
        indicator.classList.add('fa-minus');
        // Smooth scroll into view if needed (optional)
        setTimeout(() => {
          answer.style.opacity = '1';
        }, 10);
      } else {
        // Already closed by closeAllAnswers, but just to be safe
        answer.classList.add('hidden');
        chevron.classList.remove('rotate-180');
        indicator.classList.remove('fa-minus');
        indicator.classList.add('fa-plus');
      }
    }

    // Attach event listeners to all FAQ buttons
    document.querySelectorAll('.faq-item button').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        toggleAnswer(button);
      });
    });

    // Search functionality
    if (searchInput) {
      searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        let visibleCount = 0;

        faqItems.forEach(item => {
          const questionElement = item.querySelector('button .font-semibold');
          const answerDiv = item.querySelector('.faq-answer');
          const questionText = questionElement ? questionElement.innerText.toLowerCase() : '';
          const answerText = answerDiv ? answerDiv.innerText.toLowerCase() : '';
          const customData = item.getAttribute('data-question') || '';
          const searchableText = questionText + ' ' + answerText + ' ' + customData;
          
          if (searchTerm === '' || searchableText.includes(searchTerm)) {
            item.style.display = '';
            visibleCount++;
          } else {
            item.style.display = 'none';
            // If this item was open, close it
            if (!answerDiv.classList.contains('hidden')) {
              const btn = item.querySelector('button');
              if (btn) toggleAnswer(btn);
            }
          }
        });

        // Show/hide no results message
        if (visibleCount === 0 && searchTerm !== '') {
          noResultsDiv.classList.remove('hidden');
          faqContainer.classList.add('border-b-0');
        } else {
          noResultsDiv.classList.add('hidden');
          faqContainer.classList.remove('border-b-0');
        }
      });
    }

    // Initially close all answers
    closeAllAnswers();
    
    // Optional: Add smooth transition on answer open/close
    const style = document.createElement('style');
    style.textContent = `
      .faq-answer {
        transition: all 0.3s ease-in-out;
        overflow: hidden;
      }
      .faq-answer:not(.hidden) {
        display: block;
        animation: fadeSlideDown 0.3s ease-out;
      }
      @keyframes fadeSlideDown {
        from {
          opacity: 0;
          transform: translateY(-10px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      .fa-chevron-down.rotate-180 {
        transform: rotate(180deg);
      }
      .faq-icon-indicator {
        transition: all 0.2s ease;
      }
    `;
    document.head.appendChild(style);
  })();
</script>
@endsection