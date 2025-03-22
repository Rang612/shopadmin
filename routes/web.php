<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::get('/',[\App\Http\Controllers\FrontController::class, 'index'])->name('front.home');
Auth::routes();

Route::get('/home', [\App\Http\Controllers\admin\HomeController::class, 'index'])->name('home');

//Category Routes
Route::get('/categories', [\App\Http\Controllers\admin\CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [\App\Http\Controllers\admin\CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [\App\Http\Controllers\admin\CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [\App\Http\Controllers\admin\CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [\App\Http\Controllers\admin\CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [\App\Http\Controllers\admin\CategoryController::class, 'destroy'])->name('categories.delete');

//Sub Category Routes
Route::get('/sub-categories', [\App\Http\Controllers\admin\SubCategoryController::class, 'index'])->name('sub-categories.index');
Route::get('/sub-categories/create', [\App\Http\Controllers\admin\SubCategoryController::class, 'create'])->name('sub-categories.create');
Route::post('/sub-categories', [\App\Http\Controllers\admin\SubCategoryController::class, 'store'])->name('sub-categories.store');
Route::get('/sub-categories/{subCategory}/edit', [\App\Http\Controllers\admin\SubCategoryController::class, 'edit'])->name('sub-categories.edit');
Route::put('/sub-categories/{subCategory}', [\App\Http\Controllers\admin\SubCategoryController::class, 'update'])->name('sub-categories.update');
Route::delete('/sub-categories/{subCategory}', [\App\Http\Controllers\admin\SubCategoryController::class, 'destroy'])->name('sub-categories.delete');

// Brand Routes
Route::get('/brands', [\App\Http\Controllers\admin\BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/create', [\App\Http\Controllers\admin\BrandController::class, 'create'])->name('brands.create');
Route::post('/brands', [\App\Http\Controllers\admin\BrandController::class, 'store'])->name('brands.store');
Route::get('/brands/{brand}/edit', [\App\Http\Controllers\admin\BrandController::class, 'edit'])->name('brands.edit');
Route::put('/brands/{brand}', [\App\Http\Controllers\admin\BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/{brand}', [\App\Http\Controllers\admin\BrandController::class, 'destroy'])->name('brands.delete');

//Product Routes
Route::get('/products', [\App\Http\Controllers\admin\ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [\App\Http\Controllers\admin\ProductController::class, 'create'])->name('products.create');
Route::post('/products', [\App\Http\Controllers\admin\ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [\App\Http\Controllers\admin\ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [\App\Http\Controllers\admin\ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [\App\Http\Controllers\admin\ProductController::class, 'destroy'])->name('products.delete');

Route::get('/product-subcategories', [\App\Http\Controllers\admin\ProductSubController::class, 'index'])->name('product-subcategories.index');

Route::post('/product-images/update', [\App\Http\Controllers\admin\ProductImageController::class, 'update'])->name('product-images.update');
Route::delete('/product-images', [\App\Http\Controllers\admin\ProductImageController::class, 'destroy'])->name('product-images.destroy');

//Shipping Routes
Route::get('/shipping/create', [\App\Http\Controllers\admin\ShippingController::class, 'create'])->name('shipping.create');
Route::post('/shipping', [\App\Http\Controllers\admin\ShippingController::class, 'store'])->name('shipping.store');
Route::get('/shipping/{id}', [\App\Http\Controllers\admin\ShippingController::class, 'edit'])->name('shipping.edit');
Route::put('/shipping/{id}', [\App\Http\Controllers\admin\ShippingController::class, 'update'])->name('shipping.update');
Route::delete('/shipping/{id}', [\App\Http\Controllers\admin\ShippingController::class, 'destroy'])->name('shipping.delete');

//Discount Code Routes
Route::get('/coupons', [\App\Http\Controllers\admin\DiscountCodeController::class, 'index'])->name('coupons.index');
Route::get('/coupons/create', [\App\Http\Controllers\admin\DiscountCodeController::class, 'create'])->name('coupons.create');
Route::post('/coupons', [\App\Http\Controllers\admin\DiscountCodeController::class, 'store'])->name('coupons.store');
Route::get('/coupons/{coupon}/edit', [\App\Http\Controllers\admin\DiscountCodeController::class, 'edit'])->name('coupons.edit');
Route::put('/coupons/{coupon}', [\App\Http\Controllers\admin\DiscountCodeController::class, 'update'])->name('coupons.update');
Route::delete('/coupons/{coupon}', [\App\Http\Controllers\admin\DiscountCodeController::class, 'destroy'])->name('coupons.delete');

//Order Routes
Route::get('/orders', [\App\Http\Controllers\admin\OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [\App\Http\Controllers\admin\OrderController::class, 'detail'])->name('orders.detail');
Route::post('/orders/change-status/{id}', [\App\Http\Controllers\admin\OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');
//Route::post('/orders/send-email/{id}', [App\Http\Controllers\OrderController::class, 'sendInvoiceEmail'])->name('orders.sendInvoiceEmail');


//temp-images.create
Route::post('/upload-temp-image', [\App\Http\Controllers\admin\TempImagesController::class, 'create'])->name('temp-images.create');

Route::get('/getSlug', function(Request $request){
    $slug = '';
    if(!empty($request->title)){
        $slug = Str::slug($request->title);
    }

    return response()->json([
        'status' => true,
        'slug' => $slug
    ]);
})->name('getSlug');
