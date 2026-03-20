@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header with Create Button --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">All SubSubCategories</h3>
            <p class="text-[10px] text-gray-400">Manage your product sub-subcategories</p>
        </div>
        <a href="{{ route('subsubcategory.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow">
            <i class="fas fa-plus mr-2"></i>
            Add New SubSubCategory
        </a>
    </div>

    {{-- SubSubCategories List Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700">SubSubCategories List</h3>
                
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" 
                           id="search-input"
                           placeholder="Search subsubcategories..."
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
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Name</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Category</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">SubCategory</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Priority</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($data as $index => $item)
                    <tr class="hover:bg-cyan-50/30 transition-colors duration-200">
                        {{-- Serial Number --}}
                        <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                        
                        {{-- Name --}}
                        <td class="px-4 py-3 font-medium text-gray-700">{{ $item->name }}</td>
                        
                        {{-- Category --}}
                        <td class="px-4 py-3">
                            @if($item->category)
                                <span class="px-2 py-1 bg-purple-50 text-purple-600 rounded-full text-[10px] font-medium">
                                    {{ $item->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        
                        {{-- SubCategory --}}
                        <td class="px-4 py-3">
                            @if($item->subCategory)
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-medium">
                                    {{ $item->subCategory->name }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        
                        {{-- Priority --}}
                        <td class="px-4 py-3">
                            @if($item->priority)
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-medium">
                                    {{ $item->priority }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        
                        {{-- Actions --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                {{-- Edit Button --}}
                                <a href="{{ route('subsubcategory.edit', $item->id) }}" 
                                   class="p-1 hover:bg-cyan-50 rounded text-gray-400 hover:text-cyan-500 transition-colors duration-200"
                                   title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                
                                {{-- Delete Button with Modal Trigger --}}
                                <button type="button"
                                   onclick="openDeleteModal({{ $item->id }}, '{{ $item->name }}')"
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
                            No subsubcategories found
                            <a href="{{ route('subsubcategory.create') }}" class="block mt-2 text-cyan-500 hover:text-cyan-600">
                                Add your first subsubcategory
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[10px] text-gray-400">
                Showing {{ $data->count() }} {{ Str::plural('entry', $data->count()) }}
            </p>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        {{-- Background overlay --}}
        <div id="deleteModalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        {{-- Modal panel --}}
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    {{-- Warning Icon --}}
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i>
                    </div>
                    
                    {{-- Modal Content --}}
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-sm font-semibold text-gray-700" id="deleteModalTitle">
                            Delete SubSubCategory
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500" id="deleteModalMessage">
                                Are you sure you want to delete this subsubcategory? This action cannot be undone.
                            </p>
                            <p class="text-xs font-medium text-gray-700 mt-2" id="deleteItemName"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Modal Actions --}}
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                {{-- Delete button (GET method as per your route) --}}
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

{{-- JavaScript for Modal and Search --}}
<script>
// Search functionality
document.getElementById('search-input')?.addEventListener('keyup', function() {
    let search = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let name = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase();
        let category = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase();
        let subcategory = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase();
        
        if (name) {
            let matches = name.includes(search) || 
                         (category && category.includes(search)) || 
                         (subcategory && subcategory.includes(search));
            row.style.display = matches ? '' : 'none';
        }
    });
});

// Delete Modal functionality
let currentDeleteId = null;

function openDeleteModal(itemId, itemName) {
    // Store the current item ID
    currentDeleteId = itemId;
    
    // Set the item name in modal
    document.getElementById('deleteItemName').textContent = `"${itemName}"`;
    
    // Update the delete button href with the correct route (GET method)
    const deleteButton = document.getElementById('deleteConfirmButton');
    deleteButton.href = `{{ url('admin/subsubcategory/delete') }}/${itemId}`;
    
    // Show modal
    document.getElementById('deleteModal').classList.remove('hidden');
    
    // Prevent body scrolling
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    // Hide modal
    document.getElementById('deleteModal').classList.add('hidden');
    
    // Restore body scrolling
    document.body.style.overflow = 'auto';
    
    // Clear current ID
    currentDeleteId = null;
}

// Close modal when clicking on overlay
document.getElementById('deleteModalOverlay')?.addEventListener('click', closeDeleteModal);

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

// Prevent modal from closing when clicking inside
document.querySelector('#deleteModal .bg-white')?.addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>

<style>
#deleteModal {
    transition: opacity 0.3s ease;
}

#deleteModal.hidden {
    display: none;
}

#deleteModal:not(.hidden) {
    display: block;
}

.fixed.inset-0.bg-gray-500 {
    transition: opacity 0.3s ease;
}

.align-bottom {
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection