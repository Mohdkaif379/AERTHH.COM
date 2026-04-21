 <?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Vendor\Login\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\SubCategory\SubCategoryController;
use App\Http\Controllers\Admin\SubSubCategory\SubSubCategoryController;
use App\Http\Controllers\Admin\Attribute\AttributeController;
use App\Http\Controllers\Admin\Brand\BrandController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Banner\BannerController;
use App\Http\Controllers\Admin\Vendor\VendorController;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\ConfirmedOrder\ConfirmedOrderController;
use App\Http\Controllers\Admin\PackagingOrder\PackagingOrderController;
use App\Http\Controllers\Admin\PendingOrder\PendingOrderController;
use App\Http\Controllers\Admin\Vendor\VendorPendingProductController;
use App\Http\Controllers\Admin\Vendor\VendorApprovedProductController;
use App\Http\Controllers\Admin\Vendor\VendorRejectedProductController;
use App\Http\Controllers\Admin\ChatSupportController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Vendor\Approved\ApprovedProductController as VendorOwnApprovedProductController;
use App\Http\Controllers\Vendor\Pending\PendingProductController as VendorOwnPendingProductController;
use App\Http\Controllers\Vendor\Product\ProductController as ProductProductController;
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

Route::prefix('admin/vendors')->group(function () {
    Route::get('/', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('/{vendor}', [VendorController::class, 'show'])->name('vendors.show');
    Route::get('/status/{vendor}', [VendorController::class, 'status'])->name('vendors.status');
    Route::get('/delete/{vendor}', [VendorController::class, 'destroy'])->name('vendors.delete');
});



Route::prefix('admin/chats')->group(function () {
    Route::get('/', [ChatSupportController::class, 'index'])->name('admin.chats.index');
    Route::get('/history', [ChatSupportController::class, 'get_all_chat'])->name('admin.chats.history');
});

Route::prefix('admin/customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/status/{customer}', [CustomerController::class, 'status'])->name('customers.status');
    Route::get('/delete/{customer}', [CustomerController::class, 'destroy'])->name('customers.delete');
});

Route::prefix('admin/pending-orders')->group(function () {
    Route::get('/', [PendingOrderController::class, 'index'])->name('admin.pending-orders.index');
});

Route::prefix('admin/confirmed-orders')->group(function () {
    Route::get('/', [ConfirmedOrderController::class, 'index'])->name('admin.confirmed-orders.index');
    Route::get('/confirm/{id}', [ConfirmedOrderController::class, 'confirm'])->name('admin.confirmed-orders.confirm');
});

Route::prefix('admin/packaging-orders')->group(function () {
    Route::get('/', [PackagingOrderController::class, 'index'])->name('admin.packaging-orders.index');
    Route::get('/move/{id}', [PackagingOrderController::class, 'markAsPackaging'])->name('admin.packaging-orders.move');
});


Route::prefix('admin/vendor/products/pending')->group(function () {
    Route::get('/', [VendorPendingProductController::class, 'index'])->name('vendor.products.pending');
    Route::get('/status/{id}/{status}', [VendorPendingProductController::class, 'updateStatus'])->name('vendor.products.pending.status');
});

Route::prefix('admin/vendor/products/approved')->group(function () {
    Route::get('/', [VendorApprovedProductController::class, 'index'])->name('vendor.products.approved');
});

Route::prefix('admin/vendor/products/rejected')->group(function () {
    Route::get('/', [VendorRejectedProductController::class, 'index'])->name('vendor.products.rejected');
});


Route::prefix('admin/subscribers')->group(function () {
    Route::get('/', [SubscriberController::class, 'index'])->name('admin.subscribers.index');
    Route::get('/delete/{id}', [SubscriberController::class, 'destroy'])->name('admin.subscribers.delete');
});




Route::prefix('vendor/login')->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('vendor.login');
});

Route::post('vendor/login/submit', [LoginController::class, 'loginSubmit'])->name('vendor.login.submit');
Route::post('vendor/logout', [LoginController::class, 'logout'])->name('vendor.logout');

Route::prefix('vendor/dashboard')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\Dashboard\DashboardController::class, 'vendor_dashboard'])->name('vendor.dashboard');
});

Route::prefix('vendor/pending-products')->group(function () {
    Route::get('/', [VendorOwnPendingProductController::class, 'index'])->name('vendor.pending-products.index');
});

Route::prefix('vendor/approved-products')->group(function () {
    Route::get('/', [VendorOwnApprovedProductController::class, 'index'])->name('vendor.approved-products.index');
});

Route::prefix('vendor/confirmed-orders')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\ConfirmedOrder\ConfirmedOrderController::class, 'index'])->name('vendor.confirmed-orders.index');
    Route::post('/{id}/update-status', [\App\Http\Controllers\Vendor\ConfirmedOrder\ConfirmedOrderController::class, 'updateStatus'])->name('vendor.confirmed-orders.update-status');
});

Route::prefix('vendor/packaging-orders')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\PackagingOrder\PackagingOrderController::class, 'index'])->name('vendor.packaging-orders.index');
    Route::post('/{id}/update-status', [\App\Http\Controllers\Vendor\PackagingOrder\PackagingOrderController::class, 'updateStatus'])->name('vendor.packaging-orders.update-status');
});

Route::prefix('vendor/out-for-delivery-orders')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\OutForDeliveryOrder\OutForDeliveryOrderController::class, 'index'])->name('vendor.out-for-delivery-orders.index');
    Route::post('/{id}/update-status', [\App\Http\Controllers\Vendor\OutForDeliveryOrder\OutForDeliveryOrderController::class, 'updateStatus'])->name('vendor.out-for-delivery-orders.update-status');
});

Route::prefix('vendor/delivered-orders')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\DeliveredOrder\DeliveredOrderController::class, 'index'])->name('vendor.delivered-orders.index');
});

Route::prefix('vendor/rejected-products')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\Rejected\RejectedProductController::class, 'index'])->name('vendor.rejected-products.index');
});

Route::prefix('vendor/pending-orders')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\PendingOrder\PendingOrderController::class, 'index'])->name('vendor.pending-orders.index');
    Route::post('/{id}/update-status', [\App\Http\Controllers\Vendor\PendingOrder\PendingOrderController::class, 'updateStatus'])->name('vendor.pending-orders.update-status');
});

Route::prefix('vendor/failed/delivery')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\FailedDeliveryOrder\FailedDeliveryOrderController::class, 'index'])->name('vendor.failed.delivery.index');
});

Route::prefix('vendor/products')->group(function () {
    Route::get('/', [ProductProductController::class, 'index'])->name('vendor.products.index');
    Route::get('/create', [ProductProductController::class, 'create'])->name('vendor.products.create');
    Route::post('/', [ProductProductController::class, 'store'])->name('vendor.products.store');
    Route::get('/{id}/edit', [ProductProductController::class, 'edit'])->name('vendor.products.edit');
    Route::put('/{id}', [ProductProductController::class, 'update'])->name('vendor.products.update');
    Route::delete('/{id}', [ProductProductController::class, 'destroy'])->name('vendor.products.delete');
});

Route::prefix('vendor/cancel-orders')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\CancelOrder\CancelOrderController::class, 'index'])->name('vendor.cancel-orders.index');
});

Route::prefix('vendor/returned-orders')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\ReurnedOrder\ReturnedOrderController::class, 'index'])->name('vendor.returned-orders.index');
});

Route::prefix('vendor/order-insight')->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\OrderInsight\OrderInsightController::class, 'index'])->name('vendor.order-insight.index');
});