<?php

use App\Models\Customer;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', function () {
    $credentials = request()->only(['username', 'password']);
    $item_id = request()->only(['item_id']);
    if (!auth()->guard('customer')->validate($credentials)) {
        abort(401);
    } else {
        $user = Customer::where('username', $credentials['username'])->first();
        // @$user->tokens()->delete();
        $token = $user->createToken($credentials['username'], ['scb'], now()->addMinutes(1));
        // $token = $user->createToken($credentials['username'], ['scb'], now()->addMonths(1));
        return response()->json(['token' => $token->plainTextToken]);
    }
});



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('numbers', function () {
        return response()->json([1, 2, 3, 4, 5]);
    });
});
