@extends('layout.app')
@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">
                    {{ trim($customer->first_name . ' ' . $customer->last_name) ?: 'Customer' }}
                </h1>
                <p class="text-sm text-gray-500">Customer #{{ $customer->id }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 text-[11px] font-semibold rounded-full {{ $customer->status ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                {{ $customer->status ? 'Active' : 'Inactive' }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Email</p>
                <p class="text-sm font-medium text-gray-800">{{ $customer->email ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Phone</p>
                <p class="text-sm text-gray-800">{{ $customer->phone ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Gender</p>
                <p class="text-sm text-gray-800 capitalize">{{ $customer->gender ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Date of Birth</p>
                <p class="text-sm text-gray-800">
                    {{ $customer->dob?->format('d M Y') ?? '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Referral Code</p>
                <p class="text-sm text-gray-800">{{ $customer->referral_code ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Role</p>
                <p class="text-sm text-gray-800">{{ $customer->role ?? 'customer' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Created</p>
                <p class="text-sm text-gray-700">{{ $customer->created_at?->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Terms &amp; Conditions</p>
                <p class="text-sm text-gray-800">{{ $customer->terms_and_conditions ? 'Accepted' : 'Not accepted' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-2">Profile Image</p>
                @if($customer->profile_image)
                    <img src="{{ $customer->profile_image }}" alt="customer image" class="w-full max-h-48 object-cover rounded-lg border border-gray-100">
                @else
                    <span class="text-sm text-gray-400">No profile image.</span>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-2">Email Status</p>
                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold {{ $customer->email ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                    {{ $customer->email ? 'Provided' : 'Missing' }}
                </span>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-2">Phone Status</p>
                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold {{ $customer->phone ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                    {{ $customer->phone ? 'Provided' : 'Missing' }}
                </span>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('customers.index') }}" class="px-4 py-2 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">Back</a>
        </div>
    </div>
@endsection
