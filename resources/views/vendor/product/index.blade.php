@extends('vendor.layout.navbar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  @if(session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
      {{ session('error') }}
    </div>
  @endif
  
  <!-- Header (unchanged) -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Products</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Manage your product inventory</p>
    </div>
    <a href="{{route('vendor.products.create')}}" class="inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
      <i class="fa fa-plus text-sm"></i>
      <span>Add Product</span>
    </a>
  </div>

  <!-- Filters Bar (unchanged) -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 mb-6 shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
      <div class="relative">
        <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" id="searchInput" placeholder="Search by name, SKU or tags..." 
               class="w-full pl-9 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/50">
      </div>
      <select id="categoryFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
        <option value="all">All Categories</option>
        @php
          $categories = collect($products)->pluck('category.name')->unique()->filter();
        @endphp
        @foreach($categories as $cat)
          <option value="{{ $cat }}">{{ $cat }}</option>
        @endforeach
      </select>
      <select id="statusFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
      <button id="resetFilters" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
        <i class="fa fa-undo-alt text-sm"></i> Reset
      </button>
    </div>
  </div>

  <!-- Products Table -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
        <thead class="bg-gray-50 dark:bg-gray-800/60">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">#</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Image</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Product Name</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">SKU</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Category</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Price</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Unit</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Stock</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody id="productsTableBody" class="divide-y divide-gray-200 dark:divide-gray-800"></tbody>
      </table>
    </div>

    <!-- States -->
    <div id="loadingState" class="flex flex-col items-center justify-center py-12 text-gray-500 dark:text-gray-400">
      <i class="fa fa-spinner fa-pulse text-3xl mb-3"></i>
      <p>Loading products...</p>
    </div>
    <div id="errorState" class="hidden flex flex-col items-center justify-center py-12 text-red-500">
      <i class="fa fa-exclamation-triangle text-3xl mb-3"></i>
      <p>Failed to load products. Please try again.</p>
    </div>
    <div id="noResults" class="hidden flex flex-col items-center justify-center py-12 text-gray-500 dark:text-gray-400">
      <i class="fa fa-box-open text-3xl mb-3"></i>
      <p>No products found matching your filters.</p>
    </div>
  </div>
</div>

<!-- ========== DELETE CONFIRMATION MODAL ========== -->
<div id="deleteConfirmModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden p-4" onclick="closeDeleteModal()">
  <div class="flex items-center justify-center min-h-full" onclick="event.stopPropagation()">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
      <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800">
        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Delete Product</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">This action cannot be undone.</p>
      </div>
      <div class="px-5 py-4">
        <p class="text-sm text-gray-700 dark:text-gray-300">
          Are you sure you want to delete
          <span id="deleteProductName" class="font-semibold"></span>
          ?
        </p>
      </div>
      <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-800 flex items-center justify-end gap-2">
        <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          Cancel
        </button>
        <form id="deleteProductForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
            Confirm Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ========== PRODUCT VIEW MODAL (same as before) ========== -->
<div id="productModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden overflow-y-auto p-4" onclick="closeProductModal()">
  <div class="flex items-center justify-center min-h-full" onclick="event.stopPropagation()">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-5xl w-full my-8 overflow-hidden">
      <!-- Modal Header – Buttons at top -->
      <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-800 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900">
        <div>
          <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-2">
            <i class="fas fa-info-circle text-cyan-500"></i> Product Details
          </h3>
          <p class="text-[10px] text-gray-400 dark:text-gray-500">View complete product information</p>
        </div>
        <div class="flex items-center gap-2">
          <button id="modalEditBtnTop" class="px-4 py-2 rounded-lg text-black text-sm font-medium hover:bg-gray-100 transition">
            <i class="fas fa-edit"></i> Edit
          </button>
          <button onclick="closeProductModal()" class="p-2 rounded-full hover:bg-gray-100 transition">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>

      <!-- Modal Body (image size reduced) -->
      <div class="p-6 space-y-6">
        <div class="flex flex-wrap gap-3" id="modalBadges"></div>
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-cyan-100/50 dark:border-gray-800 shadow-sm overflow-hidden">
          <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <!-- Left column: Images (smaller) -->
              <div class="lg:col-span-1 space-y-4">
                <div>
                  <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                    <i class="fas fa-image text-gray-500 text-sm"></i> <span>Main Image</span>
                  </h3>
                  <div class="w-40 h-40 bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 flex items-center justify-center">
                    <img id="modalMainImage" src="" alt="Product image" class="w-full h-full object-cover">
                  </div>
                </div>
                <div id="modalAdditionalImagesContainer">
                  <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                    <i class="fas fa-images text-gray-500 text-sm"></i> <span>Additional Images</span>
                  </h3>
                  <div id="modalAdditionalImages" class="grid grid-cols-2 gap-3"></div>
                </div>
              </div>

              <!-- Right column: Details (unchanged) -->
              <div class="lg:col-span-2 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                      <i class="fas fa-info-circle text-gray-500 text-sm"></i> <span>Basic Information</span>
                    </h4>
                    <dl class="space-y-2 text-sm text-gray-800 dark:text-gray-200">
                      <div><span class="font-semibold">Product:</span> <span id="modalProductName"></span></div>
                      <div><span class="font-semibold">SKU:</span> <span id="modalSku"></span></div>
                      <div><span class="font-semibold">Category:</span> <span id="modalCategory"></span></div>
                    </dl>
                  </div>
                  <div>
                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                      <i class="fas fa-rupee-sign text-gray-500 text-sm"></i> <span>Pricing & Stock</span>
                    </h4>
                    <dl class="space-y-2 text-sm text-gray-800 dark:text-gray-200">
                      <div><span class="font-semibold">Unit Price:</span> <span id="modalUnitPrice"></span></div>
                      <div><span class="font-semibold">Product Unit:</span> <span id="modalProductUnit"></span></div>
                      <div><span class="font-semibold">Discount:</span> <span id="modalDiscount"></span></div>
                      <div><span class="font-semibold">Stock:</span> <span id="modalStock"></span></div>
                    </dl>
                  </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                      <i class="fas fa-sliders-h text-gray-500 text-sm"></i> <span>Brand & Attribute</span>
                    </h4>
                    <dl class="space-y-2 text-sm text-gray-800 dark:text-gray-200">
                      <div><span class="font-semibold">Brand:</span> <span id="modalBrand"></span></div>
                      <div><span class="font-semibold">Attribute:</span> <span id="modalAttribute"></span></div>
                    </dl>
                  </div>
                  <div>
                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                      <i class="fas fa-shipping-fast text-gray-500 text-sm"></i> <span>Shipping & Tax</span>
                    </h4>
                    <dl class="space-y-2 text-sm text-gray-800 dark:text-gray-200">
                      <div><span class="font-semibold">Shipping:</span> <span id="modalShipping"></span></div>
                      <div><span class="font-semibold">Tax:</span> <span id="modalTax"></span></div>
                    </dl>
                  </div>
                </div>
                <div id="modalTagsContainer">
                  <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                    <i class="fas fa-tags text-gray-500 text-sm"></i> <span>Tags</span>
                  </h4>
                  <div id="modalTags" class="flex flex-wrap gap-2"></div>
                </div>
                <div>
                  <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                    <i class="fas fa-align-left text-gray-500 text-sm"></i> <span>Description</span>
                  </h4>
                  <div id="modalDescription" class="text-sm text-gray-700 dark:text-gray-300 prose prose-sm max-w-none bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-gray-100 dark:border-gray-800">
                  <div>
                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-1">
                      <i class="fas fa-calendar-plus text-gray-500 text-sm"></i> <span>Created At</span>
                    </h4>
                    <p id="modalCreatedAt" class="text-sm text-gray-800 dark:text-gray-200"></p>
                  </div>
                  <div>
                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-1">
                      <i class="fas fa-sync-alt text-gray-500 text-sm"></i> <span>Last Updated</span>
                    </h4>
                    <p id="modalUpdatedAt" class="text-sm text-gray-800 dark:text-gray-200"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Data passed from controller
  const allProducts = @json($products ?? []);

  // DOM elements
  const searchInput = document.getElementById('searchInput');
  const categoryFilter = document.getElementById('categoryFilter');
  const statusFilter = document.getElementById('statusFilter');
  const resetBtn = document.getElementById('resetFilters');
  const tableBody = document.getElementById('productsTableBody');
  const loadingState = document.getElementById('loadingState');
  const errorState = document.getElementById('errorState');
  const noResultsDiv = document.getElementById('noResults');
  const deleteModal = document.getElementById('deleteConfirmModal');
  const deleteForm = document.getElementById('deleteProductForm');
  const deleteProductName = document.getElementById('deleteProductName');
  const vendorProductsBaseUrl = "{{ url('vendor/products') }}";

  let currentProduct = null;

  // Helper functions
  function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, (m) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m]));
  }

  function getStatusBadge(status) {
    if (status == 1 || status === true) {
      return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">
                <i class="fas fa-circle text-[5px] text-green-500"></i> Active
              </span>`;
    }
    return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
              <i class="fas fa-circle text-[5px] text-gray-500"></i> Inactive
            </span>`;
  }

  function getTagsBadges(tags) {
    let tagsArray = [];
    if (typeof tags === 'string') {
      try { tagsArray = JSON.parse(tags); } catch(e) { tagsArray = []; }
    } else if (Array.isArray(tags)) {
      tagsArray = tags;
    }
    if (!tagsArray.length) return '';
    return `<div class="flex flex-wrap gap-1 mt-1">${tagsArray.map(tag => `<span class="inline-block px-1.5 py-0.5 text-[10px] font-medium rounded bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">${escapeHtml(tag)}</span>`).join('')}</div>`;
  }

  function getSubcategoryHtml(subcategory) {
    if (!subcategory) return '';
    return `<div class="mt-1"><span class="inline-flex items-center gap-1 px-1.5 py-0.5 text-[10px] font-medium rounded bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400"><i class="fas fa-folder-open text-[8px]"></i> ${escapeHtml(subcategory)}</span></div>`;
  }

  function getPriceWithDiscountHtml(unitPrice, discount, discountType) {
    const original = parseFloat(unitPrice);
    let discounted = original;
    let discountText = '';
    if (discount && discount != 0) {
      const discountValue = parseFloat(discount);
      if (discountType === 'percent') {
        discounted = original - (original * discountValue / 100);
        discountText = `${discountValue}% off`;
      } else {
        discounted = original - discountValue;
        discountText = `₹${discountValue} off`;
      }
      discounted = Math.max(0, discounted);
    }
    const finalPriceHtml = `<div class="text-sm font-bold text-gray-900 dark:text-white">₹${discounted.toLocaleString('en-IN')}</div>`;
    const discountHtml = (discount && discount != 0) ? `<div class="mt-1"><span class="inline-flex items-center gap-1 px-1.5 py-0.5 text-[10px] font-medium rounded bg-orange-50 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400"><i class="fas fa-tag text-[8px]"></i> ${discountText}</span></div>` : '';
    const originalHtml = (discount && discount != 0 && original !== discounted) ? `<div class="text-xs text-gray-400 line-through">₹${original.toLocaleString('en-IN')}</div>` : '';
    return `<div>${finalPriceHtml}${originalHtml}${discountHtml}</div>`;
  }

function getImageUrl(path) {
    if (!path || typeof path !== 'string' || path.trim() === '') return null;
    if (path.startsWith('http')) return path;
    // Adjust base URL if needed – here we assume storage path relative to public
    return '/storage/' + path.trim();
  }

  function getFallbackGradient(category) {
    const map = { 'Fashion': 'from-blue-500 to-indigo-600', 'Electronics': 'from-purple-500 to-pink-500' };
    return map[category] || 'from-gray-500 to-gray-600';
  }
  function getFallbackIcon(category) {
    const map = { 'Fashion': 'fa-tshirt', 'Electronics': 'fa-mobile-alt' };
    return map[category] || 'fa-box';
  }

  // Render products table
  function renderProducts() {
    const searchTerm = searchInput.value.toLowerCase();
    const category = categoryFilter.value;
    const status = statusFilter.value;

    const filtered = allProducts.filter(p => {
      const matchSearch = (p.product_name && p.product_name.toLowerCase().includes(searchTerm)) ||
                          (p.sku && p.sku.toLowerCase().includes(searchTerm)) ||
                          (p.tags && (typeof p.tags === 'string' ? p.tags.toLowerCase().includes(searchTerm) : JSON.stringify(p.tags).toLowerCase().includes(searchTerm)));
      const matchCategory = category === 'all' || (p.category && p.category.name === category);
      const matchStatus = status === 'all' || (status === 'active' && (p.status == 1 || p.status === true)) || (status === 'inactive' && (p.status == 0 || p.status === false));
      return matchSearch && matchCategory && matchStatus;
    });

    if (filtered.length === 0) {
      tableBody.innerHTML = '';
      noResultsDiv.classList.remove('hidden');
      return;
    }
    noResultsDiv.classList.add('hidden');

    tableBody.innerHTML = filtered.map((product, idx) => {
      const imgUrl = getImageUrl(product.image);
      const catName = product.category?.name || 'Uncategorized';
      const subCatName = product.sub_category?.name || '';
      const fallbackGrad = getFallbackGradient(catName);
      const fallbackIcon = getFallbackIcon(catName);
      const tagsHtml = getTagsBadges(product.tags);
      const subcategoryHtml = getSubcategoryHtml(subCatName);
      const priceHtml = getPriceWithDiscountHtml(product.unit_price, product.discount, product.discount_type);
      
      return `<tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition duration-150">
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${idx + 1}</td>
          <td class="px-4 py-3 whitespace-nowrap">
            <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 shadow-sm">
              <img src="${imgUrl || ''}" alt="${escapeHtml(product.product_name)}" class="w-full h-full object-cover"
                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br ${fallbackGrad} flex items-center justify-center\'><i class=\\'fa ${fallbackIcon} text-white text-sm\\'></i></div>';">
            </div>
          </td>
          <td class="px-4 py-3">
            <div class="text-sm font-medium text-gray-900 dark:text-white">${escapeHtml(product.product_name)}</div>
            ${tagsHtml}
          </td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">${escapeHtml(product.sku || '—')}</td>
          <td class="px-4 py-3">
            <div class="text-sm text-gray-600 dark:text-gray-300">${escapeHtml(catName)}</div>
            ${subcategoryHtml}
          </td>
          <td class="px-4 py-3">${priceHtml}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${escapeHtml(product.product_unit || '—')}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">${product.stock_quantity ?? 0}</td>
          <td class="px-4 py-3 whitespace-nowrap">${getStatusBadge(product.status)}</td>
          <td class="px-4 py-3 whitespace-nowrap">
            <div class="flex items-center gap-1.5">
              <button onclick="viewProduct(${product.id})" class="p-1.5 text-green-600 hover:bg-green-50 dark:hover:bg-green-950/30 rounded-md transition" title="View"><i class="fa fa-eye text-sm"></i></button>
              <button onclick="editProduct(${product.id})" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-950/30 rounded-md transition" title="Edit"><i class="fa fa-pen text-sm"></i></button>
              <button onclick="deleteProduct(${product.id})" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30 rounded-md transition" title="Delete"><i class="fa fa-trash-alt text-sm"></i></button>
            </div>
          </td>
        </tr>`;
    }).join('');
  }

  // Modal functions
  function viewProduct(id) {
    const product = allProducts.find(p => p.id == id);
    if (!product) return;
    currentProduct = product;

    function getDiscountInfo(price, disc, type) {
      const orig = parseFloat(price);
      let discounted = orig;
      let text = '';
      if (disc && disc != 0) {
        const val = parseFloat(disc);
        if (type === 'percent') {
          discounted = orig - (orig * val / 100);
          text = `${val}% off`;
        } else {
          discounted = orig - val;
          text = `₹${val} off`;
        }
        discounted = Math.max(0, discounted);
      }
      return { orig, discounted, text };
    }

    // Badges
    const stockBadge = product.stock_quantity > 10 
      ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-green-50 text-green-600"><i class="fas fa-boxes mr-1"></i> ${product.stock_quantity} in stock</span>`
      : (product.stock_quantity > 0 
        ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-yellow-50 text-yellow-600"><i class="fas fa-exclamation-triangle mr-1"></i> Low stock: ${product.stock_quantity}</span>`
        : `<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-rose-50 text-rose-600"><i class="fas fa-times-circle mr-1"></i> Out of stock</span>`);
    
    document.getElementById('modalBadges').innerHTML = `
      <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium ${product.status ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-500'}">
        <i class="fas fa-circle mr-1 text-[6px] ${product.status ? 'text-green-500' : 'text-gray-400'}"></i>
        ${product.status ? 'Active' : 'Inactive'}
      </span>
      <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-blue-50 text-blue-600">
        <i class="fas fa-tag mr-1"></i> ${product.product_type || 'physical'}
      </span>
      ${stockBadge}
    `;

    // Main image
    const mainImg = document.getElementById('modalMainImage');
    mainImg.src = getImageUrl(product.image) || '';
    mainImg.alt = product.product_name;
    mainImg.onerror = () => { mainImg.src = 'https://placehold.co/400x400?text=No+Image'; };

    // Additional images
    let additional = [];
    if (typeof product.additional_image === 'string') {
      try { additional = JSON.parse(product.additional_image); } catch(e) { additional = []; }
    } else if (Array.isArray(product.additional_image)) {
      additional = product.additional_image;
    }
    const addContainer = document.getElementById('modalAdditionalImages');
    if (additional.length) {
      addContainer.innerHTML = additional.map(img => `<img src="${getImageUrl(img)}" class="w-full aspect-square rounded-lg object-cover border border-gray-200 dark:border-gray-700" loading="lazy" onerror="this.src='https://placehold.co/150x150?text=No+Image'">`).join('');
      document.getElementById('modalAdditionalImagesContainer').style.display = 'block';
    } else {
      addContainer.innerHTML = '<p class="text-sm text-gray-500 italic col-span-2">No additional images</p>';
    }

    // Basic info
    document.getElementById('modalProductName').innerText = product.product_name;
    document.getElementById('modalSku').innerText = product.sku || '—';
    let categoryStr = '';
    if (product.category) categoryStr += product.category.name;
    if (product.sub_category) categoryStr += ` - ${product.sub_category.name}`;
    if (product.sub_sub_category) categoryStr += ` - ${product.sub_sub_category.name}`;
    document.getElementById('modalCategory').innerText = categoryStr || '—';

    // Pricing
    const { orig, discounted, text } = getDiscountInfo(product.unit_price, product.discount, product.discount_type);
    document.getElementById('modalUnitPrice').innerHTML = `₹${orig.toLocaleString('en-IN')}`;
    document.getElementById('modalProductUnit').innerText = product.product_unit || '—';
    const discountDisplay = (product.discount && product.discount != 0) ? (product.discount_type == 'percent' ? `${product.discount}% off` : `₹${product.discount} off`) : '—';
    document.getElementById('modalDiscount').innerHTML = discountDisplay;
    document.getElementById('modalStock').innerText = product.stock_quantity ?? 0;

    // Brand & Attribute
    document.getElementById('modalBrand').innerText = product.brand?.name || '—';
    let attr = product.attribute ? product.attribute.attribute_name : '';
    if (product.attribute_value) attr += ` - ${product.attribute_value}`;
    document.getElementById('modalAttribute').innerText = attr || '—';

    // Shipping & Tax
    document.getElementById('modalShipping').innerText = product.shipping_cost ? `₹${product.shipping_cost}` : 'Free';
    document.getElementById('modalTax').innerText = product.tax_amount ? `₹${product.tax_amount}` : '—';

    // Tags
    let tagsArray = [];
    if (typeof product.tags === 'string') {
      try { tagsArray = JSON.parse(product.tags); } catch(e) { tagsArray = []; }
    } else if (Array.isArray(product.tags)) tagsArray = product.tags;
    const tagsContainer = document.getElementById('modalTags');
    if (tagsArray.length) {
      tagsContainer.innerHTML = tagsArray.map(tag => `<span class="px-2 py-1 bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 rounded text-[10px] font-medium">#${escapeHtml(tag)}</span>`).join('');
    } else {
      tagsContainer.innerHTML = '<span class="text-sm text-gray-400">No tags</span>';
    }

    // Description
    const descDiv = document.getElementById('modalDescription');
    descDiv.innerHTML = product.description ? product.description : '<p class="text-gray-400">No description provided</p>';

    // Timestamps
    const formatDate = (dateStr) => {
      if (!dateStr) return '—';
      const d = new Date(dateStr);
      return d.toLocaleString('en-IN', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    };
    document.getElementById('modalCreatedAt').innerText = formatDate(product.created_at);
    document.getElementById('modalUpdatedAt').innerText = formatDate(product.updated_at);

    // Edit button action
    document.getElementById('modalEditBtnTop').onclick = () => editProduct(product.id);

    // Show modal
    const modal = document.getElementById('productModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeProductModal() {
    const modal = document.getElementById('productModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
  }

  function deleteProduct(id) {
    const product = allProducts.find(p => p.id == id);
    if (!product) return;

    deleteProductName.textContent = product.product_name || `#${id}`;
    deleteForm.action = `${vendorProductsBaseUrl}/${id}`;
    deleteModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeDeleteModal() {
    deleteModal.classList.add('hidden');
    deleteForm.action = '';
    deleteProductName.textContent = '';
    document.body.style.overflow = '';
  }

  // Placeholder actions
  window.viewProduct = viewProduct;
  window.editProduct = (id) => {
    window.location.href = `${vendorProductsBaseUrl}/${id}/edit`;
  };
  window.deleteProduct = deleteProduct;
  window.closeProductModal = closeProductModal;
  window.closeDeleteModal = closeDeleteModal;

  // Event listeners
  searchInput.addEventListener('input', renderProducts);
  categoryFilter.addEventListener('change', renderProducts);
  statusFilter.addEventListener('change', renderProducts);
  resetBtn.addEventListener('click', () => {
    searchInput.value = '';
    categoryFilter.value = 'all';
    statusFilter.value = 'all';
    renderProducts();
  });

  // Initial load
  if (allProducts && allProducts.length) {
    loadingState.classList.add('hidden');
    renderProducts();
  } else {
    loadingState.classList.remove('hidden');
    setTimeout(() => {
      loadingState.classList.add('hidden');
      noResultsDiv.classList.remove('hidden');
    }, 500);
  }
</script>
@endsection
