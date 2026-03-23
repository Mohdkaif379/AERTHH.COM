@extends('layout.app')

@section('title', 'Banner Details')
@section('page-title', 'Banner Details')
@section('page-subtitle', 'View banner info')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Banner #{{ $banner->id }}</h1>
                <p class="text-sm text-gray-500">{{ $banner->banner_type }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 text-[11px] font-semibold rounded-full {{ $banner->is_published ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                {{ $banner->is_published ? 'Published' : 'Draft' }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Banner Type</p>
                <p class="text-sm font-medium text-gray-800">{{ $banner->banner_type }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Created</p>
                <p class="text-sm text-gray-700">{{ $banner->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div>
            <p class="text-xs text-gray-500 mb-2">Image</p>
            @if($banner->image)
                <img src="{{ asset('storage/' . $banner->image) }}" alt="banner" class="w-full max-h-72 object-cover rounded-lg border border-gray-100">
            @else
                <span class="text-sm text-gray-400">No image uploaded.</span>
            @endif
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">Back</a>
            <a href="{{ route('admin.banners.edit', $banner) }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-cyan-500 hover:bg-cyan-600 shadow">Edit</a>
        </div>
    </div>
@endsection
