<?php

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
        return dd('แอตมิน');
    } else {
        return view('auth.login');
    }
})->name('login');

Route::get('/register', function () {
    if (auth()->guard('customer')->check()) {
        // return dd('ลูกค้า');
        return abort(403, 'กรุณาออกจากระบบก่อนถึงมีสิทธิ์ใช้งานหน้านี้');
    } else if (auth()->guard('admin')->check()) {
        return abort(404, 'กรุณาออกจากระบบก่อนถึงมีสิทธิ์ใช้งานหน้านี้');
    } else {
        return view('auth.register');
    }
})->name('register');

Route::middleware(['auth:customer'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
