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
        if (@$request->input('auth') == "admin") {
            if (Auth::guard('admin')->attempt($credential)) {
                Auth::guard('admin')->logoutOtherDevices(request('password'));
                return redirect('/home');
            } else {
                return redirect()->route('admin.login')->with('error', 'ชื่อผู้ใช้งานหรือรหัสผ่านผิด');
            }
        } else {
            if (Auth::guard('customer')->attempt($credential)) {
                Auth::guard('customer')->logoutOtherDevices(request('password'));
                return redirect('/home');
            } else {
                return redirect()->route('login')->with('error', 'ชื่อผู้ใช้งานหรือรหัสผ่านผิด');
            }
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
