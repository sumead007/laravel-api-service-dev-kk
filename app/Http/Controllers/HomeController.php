<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer,admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->guard('customer')->check()) {
            // return dd('ลูกค้า');
            return view('home');
        } else if (auth()->guard('admin')->check()) {
            // return dd('แอตมิน');
            return view('admin.home');;
        } else {
            return view('welcome');
        };
    }

}
