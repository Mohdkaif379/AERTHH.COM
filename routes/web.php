<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\SubCategory\SubCategoryController;
use App\Http\Controllers\Admin\SubSubCategory\SubSubCategoryController;
use App\Http\Controllers\Admin\Attribute\AttributeController;
use App\Http\Controllers\Admin\Brand\BrandController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Banner\BannerController;
use App\Http\Controllers\Website\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginSubmit'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

Route::prefix('admin/category')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::get('/status/{id}', [CategoryController::class, 'status'])->name('category.status');
});

Route::prefix('admin/subcategory')->group(function () {
    Route::get('/', [SubCategoryController::class, 'index'])->name('subcategory.index');
    Route::get('/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
    Route::post('/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
    Route::get('/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
    Route::post('/update/{id}', [SubCategoryController::class, 'update'])->name('subcategory.update');
    Route::get('/delete/{id}', [SubCategoryController::class, 'destroy'])->name('subcategory.delete');
});

Route::prefix('admin/subsubcategory')->group(function () {
    Route::get('/', [SubSubCategoryController::class, 'index'])->name('subsubcategory.index');
    Route::get('/create', [SubSubCategoryController::class, 'create'])->name('subsubcategory.create');
    Route::post('/store', [SubSubCategoryController::class, 'store'])->name('subsubcategory.store');
    Route::get('/edit/{id}', [SubSubCategoryController::class, 'edit'])->name('subsubcategory.edit');
    Route::post('/update/{id}', [SubSubCategoryController::class, 'update'])->name('subsubcategory.update');
    Route::get('/delete/{id}', [SubSubCategoryController::class, 'destroy'])->name('subsubcategory.delete');
});


Route::prefix('admin/brand')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::get('/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete');
    Route::get('/status/{id}', [BrandController::class, 'status'])->name('brand.status');
});


Route::prefix('admin/attribute')->group(function () {
    Route::get('/', [AttributeController::class, 'index'])->name('attribute.index');
    Route::get('/create', [AttributeController::class, 'create'])->name('attribute.create');
    Route::post('/store', [AttributeController::class, 'store'])->name('attribute.store');
    Route::get('/edit/{id}', [AttributeController::class, 'edit'])->name('attribute.edit');
    Route::post('/update/{id}', [AttributeController::class, 'update'])->name('attribute.update');
    Route::get('/delete/{id}', [AttributeController::class, 'destroy'])->name('attribute.delete');
});     


Route::prefix('admin/products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/import', [ProductController::class, 'importForm'])->name('products.import.form');
    Route::get('/import/template', [ProductController::class, 'importTemplate'])->name('products.import.template');
    Route::post('/import', [ProductController::class, 'bulkImport'])->name('products.import');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');
    Route::get('/status/{id}', [ProductController::class, 'toggleStatus'])->name('products.status');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
});

Route::prefix('admin/banners')->group(function () {
    Route::get('/', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/store', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/edit/{banner}', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Route::post('/update/{banner}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::post('/delete/{banner}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    Route::get('/status/{id}', [BannerController::class, 'toggleStatus'])->name('admin.banners.status');
    Route::get('/{id}', [BannerController::class, 'show'])->name('admin.banners.show');
});



