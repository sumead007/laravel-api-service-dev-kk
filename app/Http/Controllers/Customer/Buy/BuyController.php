<?php

namespace App\Http\Controllers\Customer\Buy;

use App\Http\Controllers\Controller;
use App\Models\Buy;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class BuyController extends Controller
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
        $datas = Product::find($request->id);
        $banks = [
            [
                "to_account" => "ธนาคารไทยพาณิชย์",
                "to_no_account" => "1457-8795-1547",
                "to_name_account" => "นายสราวุท สวาสวัสดื์",
            ],
            [
                "to_account" => "พร้อมเพล",
                "to_no_account" => "0943820902",
                "to_name_account" => "นายสราวุท สวาสวัสดื์",
            ]
        ];
        // $this->banks = $banks;
        Session::put('banks', $banks);
        // dd(Session::get('banks'));
        return view('customer.buy.home', compact('datas', 'banks'));
    }

    public function store(Request $request)
    {
        // return dd($this->banks);

        $request->validate(
            [
                "name_api" => "required",
                "type_name_api" => "required",
                "days_api" => "required",
                "price_api" => "required",
                "from_account" => "required",
                "from_no_account" => "required",
                "from_name_account" => "required",
                "from_index" => "required",
                "datetime_transection" => "required",
                "price" => "required",
            ],
            []
        );
        $banks = Session::get('banks');
        $bank = $banks[$request->from_index];
        // return dd($bank);
        $data = Product::find($request->id);
        $user = Buy::updateOrCreate(['id' => ""], [
            "cus_id" => auth()->guard('customer')->user()->id,
            "name_api" => $data->name,
            "type_name_api" => $data->type_name,
            "days_api" => $data->days,
            "price_api" => $data->price,
            "status" => 0,
            "comment" => "-",
            "expire" => now()->addDay($data->days),
            "from_account" => $request->from_account,
            "from_no_account" => $request->from_no_account,
            "from_name_account" => $request->from_name_account,
            "to_account" => $bank['to_account'],
            "to_no_account" => $bank['to_no_account'],
            "to_name_account" => $bank['to_name_account'],
            "datetime_transection" =>   Carbon::parse($request->datetime_transection),
            "price" => $request->price,

        ]);

        return redirect()->back()->with('success', "บักทึกข้อมูลสำเร็จ");
    }
}
