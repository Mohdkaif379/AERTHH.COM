@extends('layout.app')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <h3 class="text-sm font-semibold text-gray-700">Edit Attribute</h3>
            <p class="text-[10px] text-gray-500 mt-1">Update attribute information</p>
        </div>

        <form action="{{ route('attribute.update', $attribute->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            
            {{-- Attribute ID (hidden) --}}
            <input type="hidden" name="id" value="{{ $attribute->id }}">

            {{-- Attribute Name* --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Attribute Name* <span class="text-gray-400">(Unique)</span>
                </label>
                <input type="text" 
                       name="attribute_name"
                       value="{{ old('attribute_name', $attribute->attribute_name) }}"
                       placeholder="e.g., Size, Color, Material, Brand, etc."
                       class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400 @error('attribute_name') border-rose-300 @enderror"
                       required
                       autofocus>
                @error('attribute_name')
                    <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-[10px] text-gray-400">Current value: {{ $attribute->attribute_name }}</p>
            </div>

            {{-- Metadata Card --}}
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h4 class="text-xs font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-clock mr-1"></i>
                    Metadata
                </h4>
                <div class="grid grid-cols-2 gap-3 text-[10px]">
                    <div>
                        <span class="text-gray-500">Created:</span>
                        <span class="text-gray-700 ml-1">{{ $attribute->created_at ? $attribute->created_at->format('d M Y, h:i A') : '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Last Updated:</span>
                        <span class="text-gray-700 ml-1">{{ $attribute->updated_at ? $attribute->updated_at->format('d M Y, h:i A') : '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Attribute ID:</span>
                        <span class="text-gray-700 ml-1">{{ $attribute->id }}</span>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('attribute.index') }}" 
                   class="px-6 py-2 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow">
                    Update Attribute
                </button>
            </div>
        </form>
    </div>
</div>
@endsection