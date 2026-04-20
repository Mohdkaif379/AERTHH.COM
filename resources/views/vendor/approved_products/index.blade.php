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

  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Approved Products</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Products approved by admin</p>
    </div>
    <a href="{{ route('vendor.products.create') }}" class="inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
      <i class="fa fa-plus text-sm"></i>
      <span>Add Product</span>
    </a>
  </div>

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
          $categories = collect($approvedProducts)->pluck('category.name')->unique()->filter();
        @endphp
        @foreach($categories as $cat)
          <option value="{{ $cat }}">{{ $cat }}</option>
        @endforeach
      </select>
      <select id="brandFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
        <option value="all">All Brands</option>
        @php
          $brands = collect($approvedProducts)->pluck('brand.name')->unique()->filter();
        @endphp
        @foreach($brands as $brand)
          <option value="{{ $brand }}">{{ $brand }}</option>
        @endforeach
      </select>
      <button id="resetFilters" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
        <i class="fa fa-undo-alt text-sm"></i> Reset
      </button>
    </div>
  </div>

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
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Brand</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Price</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Unit</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Stock</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
          </tr>
        </thead>
        <tbody id="productsTableBody" class="divide-y divide-gray-200 dark:divide-gray-800"></tbody>
      </table>
    </div>

    <div id="loadingState" class="flex flex-col items-center justify-center py-12 text-gray-500 dark:text-gray-400">
      <i class="fa fa-spinner fa-pulse text-3xl mb-3"></i>
      <p>Loading approved products...</p>
    </div>
    <div id="noResults" class="hidden flex flex-col items-center justify-center py-12 text-gray-500 dark:text-gray-400">
      <i class="fa fa-box-open text-3xl mb-3"></i>
      <p>No approved products found matching your filters.</p>
    </div>
  </div>
</div>

<script>
  const approvedProducts = @json($approvedProducts ?? []);

  const searchInput = document.getElementById('searchInput');
  const categoryFilter = document.getElementById('categoryFilter');
  const brandFilter = document.getElementById('brandFilter');
  const resetBtn = document.getElementById('resetFilters');
  const tableBody = document.getElementById('productsTableBody');
  const loadingState = document.getElementById('loadingState');
  const noResultsDiv = document.getElementById('noResults');

  function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, (m) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m]));
  }

  function getImageUrl(path) {
    if (!path || typeof path !== 'string' || path.trim() === '') return '';
    if (path.startsWith('http')) return path;
    return '/storage/' + path.trim();
  }

  function getTagsBadges(tags) {
    let tagsArray = [];
    if (typeof tags === 'string') {
      try { tagsArray = JSON.parse(tags); } catch (e) { tagsArray = []; }
    } else if (Array.isArray(tags)) {
      tagsArray = tags;
    }
    if (!tagsArray.length) return '';
    return `<div class="flex flex-wrap gap-1 mt-1">${tagsArray.map(tag => `<span class="inline-block px-1.5 py-0.5 text-[10px] font-medium rounded bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">${escapeHtml(tag)}</span>`).join('')}</div>`;
  }

  function getPriceWithDiscountHtml(unitPrice, discount, discountType) {
    const original = parseFloat(unitPrice || 0);
    let discounted = original;
    let discountText = '';

    if (discount && discount != 0) {
      const discountValue = parseFloat(discount);
      if (discountType === 'percent') {
        discounted = original - (original * discountValue / 100);
        discountText = `${discountValue}% off`;
      } else {
        discounted = original - discountValue;
        discountText = `Rs ${discountValue} off`;
      }
      discounted = Math.max(0, discounted);
    }

    const finalPriceHtml = `<div class="text-sm font-bold text-gray-900 dark:text-white">Rs ${discounted.toLocaleString('en-IN')}</div>`;
    const originalHtml = (discount && discount != 0 && original !== discounted)
      ? `<div class="text-xs text-gray-400 line-through">Rs ${original.toLocaleString('en-IN')}</div>`
      : '';
    const discountHtml = (discount && discount != 0)
      ? `<div class="mt-1"><span class="inline-flex items-center gap-1 px-1.5 py-0.5 text-[10px] font-medium rounded bg-orange-50 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400"><i class="fas fa-tag text-[8px]"></i> ${discountText}</span></div>`
      : '';

    return `<div>${finalPriceHtml}${originalHtml}${discountHtml}</div>`;
  }

  function renderProducts() {
    const searchTerm = searchInput.value.toLowerCase();
    const category = categoryFilter.value;
    const brand = brandFilter.value;

    const filtered = approvedProducts.filter((p) => {
      const tagsText = typeof p.tags === 'string' ? p.tags : JSON.stringify(p.tags || []);
      const matchSearch =
        (p.product_name && p.product_name.toLowerCase().includes(searchTerm)) ||
        (p.sku && p.sku.toLowerCase().includes(searchTerm)) ||
        (tagsText && tagsText.toLowerCase().includes(searchTerm));
      const matchCategory = category === 'all' || (p.category && p.category.name === category);
      const matchBrand = brand === 'all' || (p.brand && p.brand.name === brand);
      return matchSearch && matchCategory && matchBrand;
    });

    if (filtered.length === 0) {
      tableBody.innerHTML = '';
      noResultsDiv.classList.remove('hidden');
      return;
    }
    noResultsDiv.classList.add('hidden');

    tableBody.innerHTML = filtered.map((product, idx) => {
      const imgUrl = getImageUrl(product.image);
      const categoryName = product.category?.name || 'Uncategorized';
      const subCategoryName = product.sub_category?.name || '';
      const brandName = product.brand?.name || 'N/A';
      const tagsHtml = getTagsBadges(product.tags);
      const priceHtml = getPriceWithDiscountHtml(product.unit_price, product.discount, product.discount_type);

      return `<tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition duration-150">
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${idx + 1}</td>
          <td class="px-4 py-3 whitespace-nowrap">
            <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 shadow-sm">
              <img src="${imgUrl}" alt="${escapeHtml(product.product_name)}" class="w-full h-full object-cover"
                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center text-gray-400\\'><i class=\\'fa fa-image text-xs\\'></i></div>';"/>
            </div>
          </td>
          <td class="px-4 py-3">
            <div class="text-sm font-medium text-gray-900 dark:text-white">${escapeHtml(product.product_name || 'N/A')}</div>
            ${tagsHtml}
          </td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">${escapeHtml(product.sku || '—')}</td>
          <td class="px-4 py-3">
            <div class="text-sm text-gray-600 dark:text-gray-300">${escapeHtml(categoryName)}</div>
            ${subCategoryName ? `<div class="mt-1"><span class="inline-flex items-center gap-1 px-1.5 py-0.5 text-[10px] font-medium rounded bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400"><i class="fas fa-folder-open text-[8px]"></i> ${escapeHtml(subCategoryName)}</span></div>` : ''}
          </td>
          <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">${escapeHtml(brandName)}</td>
          <td class="px-4 py-3">${priceHtml}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">${escapeHtml((product.product_unit || 'N/A').toUpperCase())}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">${product.stock_quantity ?? 0}</td>
          <td class="px-4 py-3 whitespace-nowrap">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">
              <i class="fas fa-circle text-[5px] text-green-500"></i> Approved
            </span>
          </td>
        </tr>`;
    }).join('');
  }

  searchInput.addEventListener('input', renderProducts);
  categoryFilter.addEventListener('change', renderProducts);
  brandFilter.addEventListener('change', renderProducts);
  resetBtn.addEventListener('click', () => {
    searchInput.value = '';
    categoryFilter.value = 'all';
    brandFilter.value = 'all';
    renderProducts();
  });

  if (approvedProducts && approvedProducts.length) {
    loadingState.classList.add('hidden');
    renderProducts();
  } else {
    loadingState.classList.add('hidden');
    noResultsDiv.classList.remove('hidden');
  }
</script>
@endsection
