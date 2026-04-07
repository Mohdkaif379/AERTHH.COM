<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerLoginController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;

Route::get('customers', [CustomerController::class, 'index']);
Route::post('customer/create', [CustomerController::class, 'store']);
Route::post('customer/login', [CustomerLoginController::class, 'login']);
Route::get('customers/{customer}', [CustomerController::class, 'show']);
Route::put('customers/{customer}', [CustomerController::class, 'update']);
Route::patch('customers/{customer}', [CustomerController::class, 'update']);
Route::delete('customers/{customer}', [CustomerController::class, 'destroy']);
Route::patch('customers/{customer}/status', [CustomerController::class, 'updateStatus']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('addresses', [AddressController::class, 'index']);
    Route::post('address/create', [AddressController::class, 'store']);
    Route::put('address/{id}', [AddressController::class, 'update']);
    Route::delete('address/{id}', [AddressController::class, 'destroy']);

    Route::post('order/create', [OrderController::class, 'store']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/add', [CartController::class, 'addToCart']);
    Route::delete('cart/remove/{productId}', [CartController::class, 'removeFromCart']);
});

Route::get('vendors', [VendorController::class, 'index']);
Route::post('vendor/create', [VendorController::class, 'store']);
Route::post('vendor/login', [VendorController::class, 'login']);
Route::get('vendors/{vendor}', [VendorController::class, 'show']);
Route::put('vendors/{vendor}', [VendorController::class, 'update']);
Route::patch('vendors/{vendor}', [VendorController::class, 'update']);
Route::delete('vendors/{vendor}', [VendorController::class, 'destroy']);
Route::patch('vendors/{vendor}/status', [VendorController::class, 'updateStatus']);

Route::get('banners', [BannerController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('product/create', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});

Route::get('brands', [BrandController::class, 'index']);
