@extends('vendor.layout.navbar')

@section('content')
<div class="space-y-6">
    @php
        $totalReviews = $reviews->total();
        $averageRating = $reviews->getCollection()->count() ? round($reviews->getCollection()->avg('rating'), 1) : 0;
        $fiveStar = $reviews->getCollection()->where('rating', 5)->count();
        $recentReview = $reviews->getCollection()->sortByDesc('created_at')->first();
    @endphp

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Product Reviews</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Only reviews for products published by your vendor account</p>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-orange-100/60 dark:border-gray-800 shadow-sm p-5">
            <p class="text-[11px] uppercase tracking-wide text-gray-400 font-semibold">Total Reviews</p>
            <div class="mt-2 flex items-end justify-between gap-4">
                <div>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalReviews }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Reviews received</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                    <i class="fas fa-star text-orange-500"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-orange-100/60 dark:border-gray-800 shadow-sm p-5">
            <p class="text-[11px] uppercase tracking-wide text-gray-400 font-semibold">Average Rating</p>
            <div class="mt-2 flex items-end justify-between gap-4">
                <div>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $averageRating }}</p>
                    <div class="flex items-center gap-1 mt-1 text-orange-500">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-[11px] {{ $i <= round($averageRating) ? 'text-orange-500' : 'text-gray-300 dark:text-gray-600' }}"></i>
                        @endfor
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <i class="fas fa-chart-simple text-amber-500"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-orange-100/60 dark:border-gray-800 shadow-sm p-5">
            <p class="text-[11px] uppercase tracking-wide text-gray-400 font-semibold">5 Star Reviews</p>
            <div class="mt-2 flex items-end justify-between gap-4">
                <div>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $fiveStar }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Best customer feedback</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <i class="fas fa-face-smile text-emerald-500"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Reviews List --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-gray-900 dark:to-gray-800 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Reviews List</h3>

                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text"
                           id="searchInput"
                           placeholder="Search reviews..."
                           class="w-full sm:w-72 pl-8 pr-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400 text-sm">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80 border-y border-gray-100 dark:border-gray-700">
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Sr.No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Product</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Customer</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Rating</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Comment</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="reviewsTableBody">
                    @forelse($reviews as $index => $review)
                    <tr class="hover:bg-orange-50/40 dark:hover:bg-gray-800/60 transition-colors duration-200 review-row">
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                            {{ $reviews->firstItem() + $index }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shrink-0">
                                    @if(optional($review->product)->image)
                                        <img src="{{ str_starts_with($review->product->image, 'http') ? $review->product->image : asset('storage/'.$review->product->image) }}"
                                             alt="{{ $review->product->product_name ?? 'Product' }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="fas fa-box"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-800 dark:text-white truncate">
                                        {{ $review->product->product_name ?? 'Unknown Product' }}
                                    </p>
                                    <p class="text-[11px] text-gray-400 truncate">
                                        Product ID: #{{ str_pad($review->product_id, 4, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center font-semibold text-orange-600 dark:text-orange-300">
                                    {{ strtoupper(substr(optional($review->customer)->first_name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-white">
                                        {{ trim((optional($review->customer)->first_name ?? '') . ' ' . (optional($review->customer)->last_name ?? '')) ?: 'Unknown Customer' }}
                                    </p>
                                    <p class="text-[11px] text-gray-400">
                                        {{ $review->customer->email ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-300 text-xs font-semibold">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-[10px] {{ $i <= $review->rating ? 'text-orange-500' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                @endfor
                                <span class="ml-1">{{ $review->rating }}/5</span>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 max-w-[340px]">
                            <p class="line-clamp-2 review-comment">{{ $review->comment ?: 'No comment provided' }}</p>
                        </td>

                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ optional($review->created_at)->format('d M Y, h:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-400 text-sm">
                            <i class="fas fa-comment-slash text-3xl mb-2 block text-gray-300 dark:text-gray-600"></i>
                            No reviews found for your products
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800/60 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <p class="text-[10px] text-gray-400">
                Showing {{ $reviews->count() }} {{ \Illuminate\Support\Str::plural('entry', $reviews->count()) }}
            </p>
            <div class="text-xs">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput')?.addEventListener('input', function () {
    const search = this.value.toLowerCase();
    document.querySelectorAll('.review-row').forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
});
</script>
@endsection
