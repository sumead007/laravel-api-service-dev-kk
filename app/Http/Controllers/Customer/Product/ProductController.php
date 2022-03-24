<?php

namespace App\Http\Controllers\Customer\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Item;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $datas = Product::where('name', $request->id)->get();
        // dd($datas);
        return view('customer.product.home', compact('datas'));
    }

    public function get_token(Request $request)
    {
        $data = Item::find($request->id);
        return response()->json($data->token);
    }
}
