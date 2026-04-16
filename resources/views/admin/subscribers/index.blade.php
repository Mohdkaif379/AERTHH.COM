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
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Actions</th>
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
                        <td class="px-4 py-3">
                            <button type="button"
                                    onclick="openDeleteModal({{ $subscriber->id }}, '{{ addslashes($subscriber->email) }}')"
                                    class="p-1 hover:bg-rose-50 rounded text-gray-400 hover:text-rose-500 transition-colors duration-200"
                                    title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="noDataRow">
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                            <i class="fas fa-envelope-open text-3xl mb-2 block text-gray-300"></i>
                            No subscribers found
                        </td>
                    </tr>
                    @endforelse

                    {{-- Hidden No Result Row --}}
                    <tr id="noResultRow" style="display:none;">
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                            No matching results found
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="deleteModalOverlay"></div>
        <div class="relative bg-white rounded-lg max-w-md w-full overflow-hidden">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700">Delete Subscriber</h3>
                        <p class="text-xs text-gray-500 mt-1">
                            Are you sure you want to delete <span id="deleteItemName" class="font-medium"></span>?
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg">
                <button onclick="closeDeleteModal()" class="px-4 py-2 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <form id="deleteForm" method="GET">
                    <button type="submit" class="px-4 py-2 text-xs text-white bg-rose-600 hover:bg-rose-700 rounded-lg">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal --}}
@if(session('success'))
<div id="successModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="successModalOverlay"></div>
        <div class="relative bg-white rounded-lg max-w-md w-full overflow-hidden">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <h3 class="text-sm font-semibold text-gray-700">Success</h3>
                <p class="text-xs text-gray-500 mt-2">{{ session('success') }}</p>
            </div>
            <div class="bg-gray-50 px-6 py-3 flex justify-end rounded-b-lg">
                <button type="button" onclick="closeSuccessModal()" class="px-4 py-2 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">Okay</button>
            </div>
        </div>
    </div>
</div>
@endif

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

let currentDeleteId = null;

function openDeleteModal(id, name) {
    currentDeleteId = id;
    document.getElementById('deleteItemName').textContent = `"${name}"`;
    document.getElementById('deleteForm').action = `{{ url('admin/subscribers/delete') }}/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('deleteModalOverlay')?.addEventListener('click', closeDeleteModal);

function closeSuccessModal() {
    document.getElementById('successModal')?.classList.add('hidden');
}

document.getElementById('successModalOverlay')?.addEventListener('click', closeSuccessModal);

@if(session('success'))
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
});
@endif
</script>

@endsection
