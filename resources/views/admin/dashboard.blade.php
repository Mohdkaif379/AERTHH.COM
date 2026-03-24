
@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, Admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Vendors --}}
        <div class="bg-gradient-to-r from-cyan-500/10 to-emerald-500/10 border border-cyan-100 rounded-xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] uppercase tracking-wide text-cyan-600 font-semibold">Vendors</p>
                    <p class="text-3xl font-bold text-gray-800 leading-tight">{{ $stats['vendors'] ?? 0 }}</p>
                    <p class="text-[11px] text-gray-500 mt-1">Active sellers on platform</p>
                </div>
                <span class="h-10 w-10 flex items-center justify-center rounded-lg bg-cyan-500 text-white shadow">
                    <i class="fas fa-store text-sm"></i>
                </span>
            </div>
        </div>

        {{-- Customers --}}
        <div class="bg-gradient-to-r from-emerald-500/10 to-cyan-500/10 border border-emerald-100 rounded-xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] uppercase tracking-wide text-emerald-600 font-semibold">Customers</p>
                    <p class="text-3xl font-bold text-gray-800 leading-tight">{{ $stats['customers'] ?? 0 }}</p>
                    <p class="text-[11px] text-gray-500 mt-1">Registered shoppers</p>
                </div>
                <span class="h-10 w-10 flex items-center justify-center rounded-lg bg-emerald-500 text-white shadow">
                    <i class="fas fa-users text-sm"></i>
                </span>
            </div>
        </div>

        {{-- Products --}}
        <div class="bg-gradient-to-r from-cyan-500/10 to-blue-500/10 border border-cyan-100 rounded-xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] uppercase tracking-wide text-blue-600 font-semibold">Products</p>
                    <p class="text-3xl font-bold text-gray-800 leading-tight">{{ $stats['products'] ?? 0 }}</p>
                    <p class="text-[11px] text-gray-500 mt-1">Items in catalog</p>
                </div>
                    <span class="h-10 w-10 flex items-center justify-center rounded-lg bg-blue-500 text-white shadow">
                    <i class="fas fa-box-open text-sm"></i>
                </span>
            </div>
        </div>
    </div>
@endsection
