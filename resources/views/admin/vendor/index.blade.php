@extends('layout.app')
@section('content')
<div class="space-y-6">
    {{-- Header with Create Button --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">All Vendors</h3>
            <p class="text-[10px] text-gray-400">Manage your vendors</p>
        </div>
       
    </div>

    {{-- Vendors List Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700">Vendors List</h3>
                
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" 
                           id="search-input"
                           placeholder="Search vendors..."
                           class="w-56 pl-8 pr-3 py-1.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400">
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="m-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-xs text-green-600 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </p>
        </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
        <div class="m-4 p-3 bg-rose-50 border border-rose-200 rounded-lg">
            <p class="text-xs text-rose-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </p>
        </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-gray-50 border-y border-gray-100">
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Sr.No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Image</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Name</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Email</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Phone</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($vendors as $index => $vendor)
                    <tr class="hover:bg-cyan-50/30 transition-colors duration-200">
                        {{-- Serial Number --}}
                        <td class="px-4 py-3 text-gray-600">{{ $vendors->firstItem() + $index }}</td>
                        
                        {{-- Image --}}
                        <td class="px-4 py-3">
                            @if($vendor->image)
                                <img src="{{ asset($vendor->image) }}" 
                                     class="w-10 h-10 rounded-lg object-cover border border-gray-200"
                                     alt="{{ $vendor->name }}">
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        
                        {{-- Name --}}
                        <td class="px-4 py-3 font-medium text-gray-700">{{ $vendor->name }}</td>
                        
                        {{-- Email --}}
                        <td class="px-4 py-3 text-gray-600">{{ $vendor->email }}</td>

                        {{-- Phone --}}
                        <td class="px-4 py-3 text-gray-600">{{ $vendor->phone }}</td>
                        
                        {{-- Status Button --}}
                        <td class="px-4 py-3">
                            <button type="button"
                                    onclick="openStatusModal({{ $vendor->id }}, '{{ $vendor->name }}', {{ $vendor->status ? 'true' : 'false' }})"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium cursor-pointer hover:opacity-80 transition-opacity {{ $vendor->status ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-500' }}">
                                <i class="fas fa-circle mr-1 text-[6px] {{ $vendor->status ? 'text-green-500' : 'text-gray-400' }}"></i>
                                {{ $vendor->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        
                        {{-- Actions --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                {{-- View Button --}}
                                <a href="{{ route('vendors.show', $vendor->id) }}" 
                                   class="p-1 hover:bg-cyan-50 rounded text-gray-400 hover:text-cyan-500 transition-colors duration-200"
                                   title="View">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                {{-- Delete Button with Modal Trigger --}}
                                <button type="button"
                                        onclick="openDeleteModal({{ $vendor->id }}, '{{ $vendor->name }}')"
                                        class="p-1 hover:bg-rose-50 rounded text-gray-400 hover:text-rose-500 transition-colors duration-200"
                                        title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-folder-open text-3xl mb-2 block text-gray-300"></i>
                            No vendors found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[10px] text-gray-400">
                Showing {{ $vendors->count() }} {{ Str::plural('entry', $vendors->count()) }}
            </p>
            <div class="text-xs">
                {{ $vendors->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Status Confirmation Modal --}}
<div id="statusModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div id="statusModalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-sm font-semibold text-gray-700" id="statusModalTitle">
                            Want to Turn ON/OFF <span id="statusVendorName" class="text-cyan-600"></span> Status
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500" id="statusModalMessage">
                                Toggling this will show/hide the vendor in relevant listings.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <a href="#" id="statusConfirmButton" 
                   class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-xs font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-xs">
                    OK
                </a>
                <button type="button" 
                        onclick="closeStatusModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-xs">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div id="deleteModalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-sm font-semibold text-gray-700" id="deleteModalTitle">
                            Delete Vendor
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500" id="deleteModalMessage">
                                Are you sure you want to delete this vendor? This action cannot be undone.
                            </p>
                            <p class="text-xs font-medium text-gray-700 mt-2" id="deleteVendorName"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <a href="#" id="deleteConfirmButton" 
                   class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-xs font-medium text-white hover:bg-rose-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-xs">
                    Delete
                </a>
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-xs">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('search-input')?.addEventListener('keyup', function() {
    let search = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let name = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase();
        if (name) {
            row.style.display = name.includes(search) ? '' : 'none';
        }
    });
});

// Status Modal functionality
function openStatusModal(vendorId, vendorName, status) {
    document.getElementById('statusVendorName').textContent = vendorName;
    const action = status ? 'OFF' : 'ON';
    document.getElementById('statusModalTitle').innerHTML = `Want to Turn ${action} <span id="statusVendorName" class="text-cyan-600">${vendorName}</span> Status`;
    const confirmButton = document.getElementById('statusConfirmButton');
    confirmButton.href = `{{ url('admin/vendors/status') }}/${vendorId}`;
    document.getElementById('statusModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('statusModalOverlay')?.addEventListener('click', closeStatusModal);
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeStatusModal();
});
document.querySelector('#statusModal .bg-white')?.addEventListener('click', function(e) {
    e.stopPropagation();
});

// Delete Modal functionality
function openDeleteModal(vendorId, vendorName) {
    document.getElementById('deleteVendorName').textContent = `"${vendorName}"`;
    const deleteButton = document.getElementById('deleteConfirmButton');
    deleteButton.href = `{{ url('admin/vendors/delete') }}/${vendorId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('deleteModalOverlay')?.addEventListener('click', closeDeleteModal);
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});
document.querySelector('#deleteModal .bg-white')?.addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>
@endsection
