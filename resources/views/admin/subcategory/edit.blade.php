@extends('layout.app')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <h3 class="text-sm font-semibold text-gray-700">Edit SubCategory</h3>
        </div>

        <form action="{{ route('subcategory.update', $subcategory->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            {{-- Note: Using POST with update route as per your route definition --}}
            
            {{-- SubCategory Name* --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    SubCategory Name* <span class="text-gray-400">(EN)</span>
                </label>
                <input type="text" 
                       name="name"
                       value="{{ old('name', $subcategory->name) }}"
                       placeholder="Enter subcategory name"
                       class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400 @error('name') border-rose-300 @enderror"
                       required>
                @error('name')
                    <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Select Category --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Select Category* <span class="text-gray-400">(Parent Category)</span>
                </label>
                <select name="category_id" 
                        class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 @error('category_id') border-rose-300 @enderror"
                        required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Priority --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Priority <span class="text-gray-400 ml-1">(Optional)</span>
                </label>
                <select name="priority" 
                        class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600">
                    <option value="">Set Priority</option>
                    @for($i = 0; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('priority', $subcategory->priority) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('subcategory.index') }}" 
                   class="px-6 py-2 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow">
                    Update SubCategory
                </button>
            </div>
        </form>
    </div>
</div>
@endsection