@extends('layout.app')
@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">Delivery Man Profile</h3>
            <p class="text-[10px] text-gray-400">Detailed information about {{ $delivery_man->full_name }}</p>
        </div>
        <a href="{{ route('admin.delivery-man.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to List
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Profile Card --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
                <div class="h-24 bg-gradient-to-r from-cyan-500 to-emerald-500"></div>
                <div class="px-6 pb-6">
                    <div class="relative -mt-12 mb-4">
                        @if($delivery_man->profile_photo)
                            <img src="{{ asset('storage/'.$delivery_man->profile_photo) }}" 
                                 class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-md mx-auto"
                                 alt="{{ $delivery_man->full_name }}">
                        @else
                            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center border-4 border-white shadow-md mx-auto">
                                <i class="fas fa-user text-3xl text-gray-400"></i>
                            </div>
                        @endif
                        <div class="absolute bottom-0 right-1/2 translate-x-12">
                            <span class="flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 {{ $delivery_man->status == 'active' ? 'bg-green-400' : 'bg-yellow-400' }}"></span>
                                <span class="relative inline-flex rounded-full h-5 w-5 {{ $delivery_man->status == 'active' ? 'bg-green-500' : 'bg-yellow-500' }} border-2 border-white"></span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <h4 class="text-base font-bold text-gray-800">{{ $delivery_man->full_name }}</h4>
                        <p class="text-xs text-gray-400 mb-4">ID: #DM-{{ str_pad($delivery_man->id, 5, '0', STR_PAD_LEFT) }}</p>
                        
                        <div class="flex justify-center gap-2 mb-6">
                            <span class="px-3 py-1 bg-cyan-50 text-cyan-600 rounded-full text-[10px] font-semibold uppercase tracking-wider">
                                {{ $delivery_man->vehicle_type }}
                            </span>
                            <span class="px-3 py-1 {{ $delivery_man->status == 'active' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600' }} rounded-full text-[10px] font-semibold uppercase tracking-wider">
                                {{ $delivery_man->status }}
                            </span>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-gray-50">
                            <div class="flex items-center text-xs text-gray-600">
                                <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-phone text-cyan-500"></i>
                                </div>
                                <span class="font-medium">{{ $delivery_man->mobile }}</span>
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-envelope text-emerald-500"></i>
                                </div>
                                <span class="font-medium truncate">{{ $delivery_man->email }}</span>
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-rose-500"></i>
                                </div>
                                <span class="font-medium">{{ $delivery_man->city }}, {{ $delivery_man->state }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Details Area --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Information Cards --}}
            <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">General Information</h3>
                    <i class="fas fa-info-circle text-gray-300"></i>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Full Name</p>
                        <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Gender</p>
                        <p class="text-xs text-gray-700 font-medium capitalize">{{ $delivery_man->gender ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Date of Birth</p>
                        <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->date_of_birth ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Pincode</p>
                        <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->pincode }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Full Address</p>
                        <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->address_line }}, {{ $delivery_man->city }}, {{ $delivery_man->state }} - {{ $delivery_man->pincode }}</p>
                    </div>
                </div>
            </div>

            {{-- Vehicle & Identity --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Vehicle Info --}}
                <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                        <h3 class="text-sm font-semibold text-gray-700">Vehicle Details</h3>
                        <i class="fas fa-truck text-cyan-400"></i>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Vehicle Type</p>
                            <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->vehicle_type }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Vehicle Number</p>
                            <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->vehicle_number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">License Number</p>
                            <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->driving_license_number }}</p>
                        </div>
                    </div>
                </div>

                {{-- Identity Info --}}
                <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                        <h3 class="text-sm font-semibold text-gray-700">Identity Details</h3>
                        <i class="fas fa-id-card text-emerald-400"></i>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Aadhaar Number</p>
                            <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->aadhaar_number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Joined Date</p>
                            <p class="text-xs text-gray-700 font-medium">{{ $delivery_man->created_at->format('d M, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">Verification Documents</h3>
                    <i class="fas fa-file-alt text-gray-300"></i>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        {{-- Aadhaar --}}
                        <div class="space-y-2">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider text-center">Aadhaar Card</p>
                            <div class="aspect-video bg-gray-50 rounded-lg border-2 border-dashed border-gray-100 overflow-hidden relative group">
                                @if($delivery_man->aadhaar_image)
                                    <img src="{{ asset('storage/'.$delivery_man->aadhaar_image) }}" class="w-full h-full object-cover">
                                    <a href="{{ asset('storage/'.$delivery_man->aadhaar_image) }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-medium">
                                        <i class="fas fa-external-link-alt mr-2"></i> View Full
                                    </a>
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-image text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- RC --}}
                        <div class="space-y-2">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider text-center">Vehicle RC</p>
                            <div class="aspect-video bg-gray-50 rounded-lg border-2 border-dashed border-gray-100 overflow-hidden relative group">
                                @if($delivery_man->rc_upload)
                                    <img src="{{ asset('storage/'.$delivery_man->rc_upload) }}" class="w-full h-full object-cover">
                                    <a href="{{ asset('storage/'.$delivery_man->rc_upload) }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-medium">
                                        <i class="fas fa-external-link-alt mr-2"></i> View Full
                                    </a>
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-image text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- DL --}}
                        <div class="space-y-2">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider text-center">Driving License</p>
                            <div class="aspect-video bg-gray-50 rounded-lg border-2 border-dashed border-gray-100 overflow-hidden relative group">
                                @if($delivery_man->dl_upload)
                                    <img src="{{ asset('storage/'.$delivery_man->dl_upload) }}" class="w-full h-full object-cover">
                                    <a href="{{ asset('storage/'.$delivery_man->dl_upload) }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-medium">
                                        <i class="fas fa-external-link-alt mr-2"></i> View Full
                                    </a>
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-image text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Rejection Reason if any --}}
            @if($delivery_man->rejection_reason)
            <div class="bg-rose-50 rounded-xl border border-rose-100 p-6">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                        <i class="fas fa-exclamation-triangle text-rose-500"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-rose-800 mb-1">Rejection Reason</h4>
                        <p class="text-xs text-rose-600">{{ $delivery_man->rejection_reason }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
