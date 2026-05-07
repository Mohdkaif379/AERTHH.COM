@extends('layout.app')
@section('content')
<div class="space-y-6">
    {{-- Header with Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-xl border border-cyan-100/50 shadow-sm flex items-center space-x-4">
            <div class="w-10 h-10 bg-cyan-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-cyan-500"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-medium uppercase">Total Delivery Men</p>
                <h4 class="text-lg font-bold text-gray-700">{{ session('total_delivery_men', 0) }}</h4>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-emerald-100/50 shadow-sm flex items-center space-x-4">
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-emerald-500"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-medium uppercase">Active Partners</p>
                <h4 class="text-lg font-bold text-gray-700">{{ session('active_delivery_men', 0) }}</h4>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-yellow-100/50 shadow-sm flex items-center space-x-4">
            <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-500"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-medium uppercase">Pending Approval</p>
                <h4 class="text-lg font-bold text-gray-700">{{ session('pending_delivery_men', 0) }}</h4>
            </div>
        </div>
    </div>

    {{-- Delivery Men List Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700">Delivery Men List</h3>
                
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" 
                           id="search-input"
                           placeholder="Search delivery men..."
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

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-gray-50 border-y border-gray-100">
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Sr.No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Photo</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Name</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Contact</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Vehicle</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($delivery_men as $index => $dm)
                    <tr class="hover:bg-cyan-50/30 transition-colors duration-200">
                        {{-- Serial Number --}}
                        <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                        
                        {{-- Photo --}}
                        <td class="px-4 py-3">
                            @if($dm->profile_photo)
                                <img src="{{ asset('storage/'.$dm->profile_photo) }}" 
                                     class="w-10 h-10 rounded-lg object-cover border border-gray-200"
                                     alt="{{ $dm->full_name }}">
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        
                        {{-- Name --}}
                        <td class="px-4 py-3 font-medium text-gray-700">{{ $dm->full_name }}</td>
                        
                        {{-- Contact --}}
                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <span class="text-gray-700">{{ $dm->mobile }}</span>
                                <span class="text-[10px] text-gray-400">{{ $dm->email }}</span>
                            </div>
                        </td>
                        
                        {{-- Vehicle --}}
                        <td class="px-4 py-3 text-gray-600">
                            {{ $dm->vehicle_type }} ({{ $dm->vehicle_number }})
                        </td>
                        
                        {{-- Status --}}
                        <td class="px-4 py-3">
                            <button type="button"
                                    onclick="openStatusModal({{ $dm->id }}, '{{ $dm->full_name }}', '{{ $dm->status }}')"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium cursor-pointer hover:opacity-80 transition-opacity 
                                {{ $dm->status == 'active' ? 'bg-green-50 text-green-600' : 
                                   ($dm->status == 'pending' ? 'bg-yellow-50 text-yellow-600' : 'bg-rose-50 text-rose-600') }}">
                                <i class="fas fa-circle mr-1 text-[6px] {{ $dm->status == 'active' ? 'text-green-500' : ($dm->status == 'pending' ? 'text-yellow-500' : 'text-rose-500') }}"></i>
                                {{ ucfirst($dm->status) }}
                            </button>
                        </td>
                        
                        {{-- Actions --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.delivery-man.show', $dm->id) }}" 
                                   class="p-1 hover:bg-cyan-50 rounded text-gray-400 hover:text-cyan-500 transition-colors duration-200"
                                   title="View Details">
                                     <i class="fas fa-eye text-xs"></i>
                                 </a>
                                 
                                 <button type="button"
                                    onclick="openDeleteModal({{ $dm->id }}, '{{ $dm->full_name }}')"
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
                            <i class="fas fa-user-slash text-3xl mb-2 block text-gray-300"></i>
                            No delivery men found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[10px] text-gray-400">
                Showing {{ $delivery_men->count() }} {{ Str::plural('entry', $delivery_men->count()) }}
            </p>
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
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-cyan-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-user-check text-cyan-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-sm font-semibold text-gray-700">
                            Update Status for <span id="dmName" class="text-cyan-600"></span>
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                Current Status: <span id="currentStatus" class="font-medium uppercase"></span>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Choose an action to update the delivery man's account status.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <a href="#" id="approveBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-xs font-medium text-white hover:bg-green-700 focus:outline-none sm:w-auto">
                    Approve / Active
                </a>
                <a href="#" id="rejectBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-xs font-medium text-white hover:bg-rose-700 focus:outline-none sm:w-auto">
                    Reject / Inactive
                </a>
                <button type="button" onclick="closeStatusModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto">
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
                        <h3 class="text-sm font-semibold text-gray-700">
                            Delete Delivery Man
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                Are you sure you want to delete <span id="deleteDmName" class="text-rose-600 font-medium"></span>? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <a href="#" id="deleteConfirmButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-xs font-medium text-white hover:bg-rose-700 focus:outline-none sm:ml-3 sm:w-auto">
                    Delete Now
                </a>
                <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto">
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
        let mobile = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase();
        if (name || mobile) {
            row.style.display = (name.includes(search) || mobile.includes(search)) ? '' : 'none';
        }
    });
});

// Status Modal functionality
function openStatusModal(id, name, status) {
    document.getElementById('dmName').textContent = name;
    document.getElementById('currentStatus').textContent = status;
    
    const approveBtn = document.getElementById('approveBtn');
    const rejectBtn = document.getElementById('rejectBtn');
    
    // Set routes
    approveBtn.href = `{{ url('admin/delivery-man/status') }}/${id}/active`;
    rejectBtn.href = `{{ url('admin/delivery-man/status') }}/${id}/rejected`;
    
    // Show modal
    document.getElementById('statusModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Delete Modal functionality
function openDeleteModal(id, name) {
    document.getElementById('deleteDmName').textContent = name;
    const deleteBtn = document.getElementById('deleteConfirmButton');
    deleteBtn.href = `{{ url('admin/delivery-man/delete') }}/${id}`;
    
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('statusModalOverlay')?.addEventListener('click', closeStatusModal);
document.getElementById('deleteModalOverlay')?.addEventListener('click', closeDeleteModal);
</script>

<style>
#statusModal, #deleteModal { transition: opacity 0.3s ease; }
#statusModal.hidden, #deleteModal.hidden { display: none; }
#statusModal:not(.hidden), #deleteModal:not(.hidden) { display: block; }
.align-bottom { animation: modalSlideIn 0.3s ease-out; }
@keyframes modalSlideIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
