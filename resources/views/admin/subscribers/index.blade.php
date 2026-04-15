@extends('layout.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-envelope text-cyan-500 text-sm"></i>
                <span>All Subscribers</span>
            </h3>
            <p class="text-[10px] text-gray-400">Manage your email subscribers</p>
        </div>
    </div>

    {{-- Search Box --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm p-4">
        <div class="relative max-w-sm">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   id="searchInput"
                   placeholder="Search email..."
                   class="w-full pl-8 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 text-xs">
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50 flex justify-between">
            <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-2">
                <i class="fas fa-list text-cyan-500 text-sm"></i>
                <span>Subscribers List</span>
            </h3>

            <span class="text-[10px] text-gray-500">
                Total: {{ $subscribe->count() }} subscribers
            </span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-gray-50 border-y border-gray-100">
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Sr.No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Email</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Subscribed Date</th>
                    </tr>
                </thead>

                <tbody id="subscriberTableBody" class="divide-y divide-gray-100">

                    @forelse($subscribe as $index => $subscriber)
                    <tr class="subscriberRow hover:bg-cyan-50/30 transition">
                        <td class="px-4 py-3">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $subscriber->email }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $subscriber->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr id="noDataRow">
                        <td colspan="3" class="px-4 py-8 text-center text-gray-400">
                            <i class="fas fa-envelope-open text-3xl mb-2 block text-gray-300"></i>
                            No subscribers found
                        </td>
                    </tr>
                    @endforelse

                    {{-- Hidden No Result Row --}}
                    <tr id="noResultRow" style="display:none;">
                        <td colspan="3" class="px-4 py-8 text-center text-gray-400">
                            No matching results found
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- JS Live Search --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {

    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('.subscriberRow');
    let visible = 0;

    rows.forEach(row => {
        let email = row.children[1].textContent.toLowerCase();

        if (email.includes(value)) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    // Show / hide no result row
    let noResultRow = document.getElementById('noResultRow');

    if (visible === 0) {
        noResultRow.style.display = '';
    } else {
        noResultRow.style.display = 'none';
    }
});
</script>

@endsection