<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function login(Request $request)
    {
        $credential = array("username" => $request->input('username'), 'password' => $request->input('password'),);
        if (Auth::guard('customer')->attempt($credential)) {
            // $hashed_get_random_uinq_str = hexdec(uniqid());
            // // dd($hashed_get_random_uinq_str);
            // Customer::find(Auth::guard('customer')->user()->id)->update([
            //     "token_login" => $hashed_get_random_uinq_str
            // ]);
            // Auth::guard('customer')->user()->token_login = $hashed_get_random_uinq_str;
            Auth::guard('customer')->logoutOtherDevices(request('password'));
            return redirect('/home');
        } else {
            return redirect()->route('login')->with('error', 'ชื่อผู้ใช้งานหรือรหัสผ่านผิด');
        }
    }

    /**
     * The user has been authenticated.
     *
     * @return mixed
     */
    protected function authenticated()
    {
        Auth::guard('customer')->logoutOtherDevices(request('password'));
    }
}
