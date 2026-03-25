<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerLoginController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;

Route::get('customers', [CustomerController::class, 'index']);
Route::post('customer/create', [CustomerController::class, 'store']);
Route::post('customer/login', [CustomerLoginController::class, 'login']);
Route::get('customers/{customer}', [CustomerController::class, 'show']);
Route::put('customers/{customer}', [CustomerController::class, 'update']);
Route::patch('customers/{customer}', [CustomerController::class, 'update']);
Route::delete('customers/{customer}', [CustomerController::class, 'destroy']);
Route::patch('customers/{customer}/status', [CustomerController::class, 'updateStatus']);

Route::get('vendors', [VendorController::class, 'index']);
Route::post('vendor/create', [VendorController::class, 'store']);
Route::get('vendors/{vendor}', [VendorController::class, 'show']);
Route::put('vendors/{vendor}', [VendorController::class, 'update']);
Route::patch('vendors/{vendor}', [VendorController::class, 'update']);
Route::delete('vendors/{vendor}', [VendorController::class, 'destroy']);
Route::patch('vendors/{vendor}/status', [VendorController::class, 'updateStatus']);

Route::get('banners', [BannerController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
