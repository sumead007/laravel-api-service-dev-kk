<?php

use App\Http\Controllers\Admin\Manage\ManageAdminController;
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
});

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/manage/admin/home', [ManageAdminController::class, 'index'])->name('admin.manage.home');
    Route::get('/manage/admin/list', [ManageAdminController::class, 'getAdmin'])->name('admin.manage.admin.list');
    Route::post('/manage/admin/store', [ManageAdminController::class, 'store'])->name('admin.manage.admin.store');

});
