<?php

use App\Http\Controllers\Admin\Manage\ManageAdminController;
use App\Http\Controllers\Admin\Manage\ManageCustomerController;
use App\Http\Controllers\Admin\Manage\ManageProductController;
use App\Http\Controllers\Admin\Manage\ManageProductDetailController;
use App\Http\Controllers\Customer\Product\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/login', function () {
    if (auth()->guard('customer')->check()) {
        // return dd('ลูกค้า');
        return redirect('/');
    } else if (auth()->guard('admin')->check()) {
        // return dd('แอตมิน');
        return redirect('/home');
    } else {
        return view('auth.login');
    }
})->name('login');

Route::get('/admin/login', function () {
    if (auth()->guard('customer')->check()) {
        // return dd('ลูกค้า');
        return redirect('/home');
    } else if (auth()->guard('admin')->check()) {
        // return dd('แอตมิน');
        return redirect('/home');
    } else {
        return view('auth.admin_login');
    }
})->name('admin.login');

Route::get('/register', function () {
    if (auth()->guard('customer')->check()) {
        // return dd('ลูกค้า');
        return abort(403, 'กรุณาออกจากระบบก่อนถึงมีสิทธิ์ใช้งานหน้านี้');
    } else if (auth()->guard('admin')->check()) {
        return abort(403, 'กรุณาออกจากระบบก่อนถึงมีสิทธิ์ใช้งานหน้านี้');
    } else {
        return view('auth.register');
    }
})->name('register');

Route::middleware(['auth:customer,admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/item/list/{id}', [App\Http\Controllers\HomeController::class, 'get_item'])->name('customer.item.list');

    ///product
    Route::get('/customer/product/home/{id}', [ProductController::class, 'index']);
    // Route::post('/customer/get_token/', [ProductController::class, 'get_token'])->name('customer.get_token');

    // Route::middleware(['check_status_product'])->group(function () {
    // });
});

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/manage/admin/home', [ManageAdminController::class, 'index'])->name('admin.manage.home');
    Route::get('/manage/admin/list', [ManageAdminController::class, 'getAdmin'])->name('admin.manage.admin.list');
    Route::post('/manage/admin/store', [ManageAdminController::class, 'store'])->name('admin.manage.admin.store');
    Route::get('/manage/admin/get_post/{id}', [ManageAdminController::class, 'get_post']);
    Route::delete('/manage/admin/delete_post/{id}', [ManageAdminController::class, 'delete_post']);
    //manage_products
    Route::get('/manage/product/home', [ManageProductController::class, 'index'])->name('admin.manage.product.home');
    Route::get('/manage/product/list', [ManageProductController::class, 'get_product'])->name('admin.manage.product.list');
    Route::get('/manage/admin/delete_post/{id}', [ManageProductController::class, 'get_post']);
    Route::post('/manage/product/store', [ManageProductController::class, 'store'])->name('admin.manage.product.store');
    Route::get('/manage/product/get_post/{id}', [ManageProductController::class, 'get_post_product']);
    Route::delete('/manage/product/delete_post/{id}', [ManageProductController::class, 'delete_post']);

    //product_detail
    Route::get('/manage/product/detail/home/{id}', [ManageProductDetailController::class, 'index']);
    Route::get('/manage/product/detail/list/{id}', [ManageProductDetailController::class, 'get_detail'])->name('admin.manage.product.detail.list');
    Route::post('/manage/product/detail/store', [ManageProductDetailController::class, 'store'])->name('admin.manage.product.detail.store');
    Route::get('/manage/product/detail/get_post/{id}', [ManageProductDetailController::class, 'get_post']);
    Route::delete('/manage/product/detail/delete_post/{id}', [ManageProductDetailController::class, 'delete_post']);

    //manage_customers
    Route::get('/manage/customer/home', [ManageCustomerController::class, 'index'])->name('admin.manage.customer.home');
    Route::get('/manage/customer/list', [ManageCustomerController::class, 'get_customer'])->name('admin.manage.customer.list');
    Route::post('/manage/customer/store', [ManageCustomerController::class, 'store'])->name('admin.manage.customer.store');
    Route::post('/manage/customer/save_code', [ManageCustomerController::class, 'save_code'])->name('admin.manage.customer.save_code');
    Route::get('/manage/customer/get_post/{id}', [ManageCustomerController::class, 'get_post']);
    Route::get('/manage/customer/get_code/{id}', [ManageCustomerController::class, 'get_code']);
    Route::delete('/manage/admin/delete_post/{id}', [ManageCustomerController::class, 'delete_post']);
});
