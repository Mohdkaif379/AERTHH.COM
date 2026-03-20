
@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, Admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-cyan-100/50">
            <h3 class="text-xs text-gray-400">Total Sales</h3>
            <p class="text-2xl font-bold text-gray-800">$45,678</p>
        </div>
        <div class="bg-white rounded-xl p-5 border border-emerald-100/50">
            <h3 class="text-xs text-gray-400">Total Orders</h3>
            <p class="text-2xl font-bold text-gray-800">1,234</p>
        </div>
        <div class="bg-white rounded-xl p-5 border border-cyan-100/50">
            <h3 class="text-xs text-gray-400">Customers</h3>
            <p class="text-2xl font-bold text-gray-800">5,678</p>
        </div>
        <div class="bg-white rounded-xl p-5 border border-emerald-100/50">
            <h3 class="text-xs text-gray-400">Products</h3>
            <p class="text-2xl font-bold text-gray-800">892</p>
        </div>
    </div>
@endsection