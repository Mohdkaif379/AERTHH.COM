@extends('layout.app')

@section('title', 'Edit Banner')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-700">Edit Banner: {{ $banner->banner_type }}</h3>
        </div>

        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            
            {{-- Banner Title --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Banner Title <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       name="banner_type"
                       value="{{ old('banner_type', $banner->banner_type) }}"
                       placeholder="Home Hero, Sidebar Offer, Campaign name"
                       class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400 @error('banner_type') border-rose-300 @enderror"
                       required>
                @error('banner_type')
                    <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Status
                </label>
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_published" value="0">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $banner->is_published) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-cyan-200 rounded-full peer peer-checked:bg-emerald-500 transition-colors duration-300 ease-in-out after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-5 after:w-5 after:transition-transform after:duration-300 after:ease-in-out peer-checked:after:translate-x-5"></div>
                    </label>
                    <span class="text-xs text-gray-500">Enable to show banner on site/app.</span>
                </div>
            </div>

            {{-- Banner Image --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Banner Image
                    <span class="text-gray-400 text-[10px] ml-1">(Leave empty to keep current)</span>
                </label>
                <div class="flex items-center space-x-4">
                    @if($banner->image)
                        <img src="{{ asset('storage/' . $banner->image) }}" 
                             class="w-28 h-20 rounded-lg object-cover border border-gray-200"
                             alt="{{ $banner->banner_type }}">
                    @else
                        <div class="w-28 h-20 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" 
                               name="image"
                               id="banner-image"
                               class="hidden"
                               accept="image/*">
                        <label for="banner-image" 
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 hover:bg-cyan-50 hover:border-cyan-200 hover:text-cyan-600 cursor-pointer transition-all duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            {{ $banner->image ? 'Change Image' : 'Choose File' }}
                        </label>
                        <p class="text-[10px] text-gray-400 mt-1">PNG, JPG, JPEG (Max 4MB)</p>
                        @error('image')
                            <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.banners.index') }}" class="px-6 py-2 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow">
                    Update Banner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
