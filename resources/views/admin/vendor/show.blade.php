@extends('layout.app')
@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">{{ $vendor->name }}</h1>
                <p class="text-sm text-gray-500">Vendor #{{ $vendor->id }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 text-[11px] font-semibold rounded-full {{ $vendor->status ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                {{ $vendor->status ? 'Active' : 'Inactive' }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Email</p>
                <p class="text-sm font-medium text-gray-800">{{ $vendor->email }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Phone</p>
                <p class="text-sm text-gray-800">{{ $vendor->phone }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Address</p>
                <p class="text-sm text-gray-800">{{ $vendor->address }}</p>
                <p class="text-xs text-gray-500">
                    {{ $vendor->city }}, {{ $vendor->state }} {{ $vendor->zip }}<br>
                    {{ $vendor->country }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">GST No.</p>
                <p class="text-sm text-gray-800">{{ $vendor->gst_no }}</p>
                <p class="text-xs text-gray-500 mt-2">PAN No.: <span class="text-gray-800">{{ $vendor->pan_no }}</span></p>
                <p class="text-xs text-gray-500">Aadhar No.: <span class="text-gray-800">{{ $vendor->aadhar_no }}</span></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Role</p>
                <p class="text-sm text-gray-800">{{ $vendor->role ?? 'vendor' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Created</p>
                <p class="text-sm text-gray-700">{{ $vendor->created_at?->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-2">Profile Image</p>
                @if($vendor->image)
                    <img src="{{ asset($vendor->image) }}" alt="vendor image" class="w-full max-h-48 object-cover rounded-lg border border-gray-100">
                @else
                    <span class="text-sm text-gray-400">No image uploaded.</span>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-2">Aadhar Image</p>
                @if($vendor->aadhar_image)
                    <img src="{{ asset($vendor->aadhar_image) }}" alt="aadhar image" class="w-full max-h-48 object-cover rounded-lg border border-gray-100">
                @else
                    <span class="text-sm text-gray-400">No Aadhar image.</span>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-2">PAN Image</p>
                @if($vendor->pan_image)
                    <img src="{{ asset($vendor->pan_image) }}" alt="pan image" class="w-full max-h-48 object-cover rounded-lg border border-gray-100">
                @else
                    <span class="text-sm text-gray-400">No PAN image.</span>
                @endif
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('vendors.index') }}" class="px-4 py-2 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">Back</a>
            {{-- Placeholder edit route if/when implemented --}}
            {{-- <a href="#" class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-cyan-500 hover:bg-cyan-600 shadow">Edit</a> --}}
        </div>
    </div>
@endsection
