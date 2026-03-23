<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;

Route::get('customers', [CustomerController::class, 'index']);
Route::post('customer/create', [CustomerController::class, 'store']);
Route::get('customers/{customer}', [CustomerController::class, 'show']);
Route::put('customers/{customer}', [CustomerController::class, 'update']);
Route::patch('customers/{customer}', [CustomerController::class, 'update']);
Route::delete('customers/{customer}', [CustomerController::class, 'destroy']);
Route::patch('customers/{customer}/status', [CustomerController::class, 'updateStatus']);
