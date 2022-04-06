<?php

namespace App\Http\Controllers\Customer\History;

use App\Http\Controllers\Controller;
use App\Models\Buy;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class HistoryPaymentController extends Controller
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
        return view('customer.history.payment.home');
    }
    public function get_item(Request $request)
    {
        if ($request->ajax()) {
            // $data = Customer::latest()->get(); ช้า
            $data = Buy::where('cus_id', auth()->guard('customer')->user()->id); //เร็ว

            // DB::statement(DB::raw('set @rownum=0'));
            // $data = Customer::select([
            //     DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            //     'id',
            //     'name',
            //     'username',
            //     'code',
            //     'created_at',
            //     'updated_at'
            // ]);


            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm" onclick="editPost(' . $row->id . ')">แก้ไข</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deletePost(' . $row->id . ')">ลบ</a>';
                    return $actionBtn;
                })
                ->editColumn('created_at', function ($row) {
                    $data = Carbon::parse($row->created_at)->locale('th')->diffForHumans();;
                    return $data;
                })
                ->editColumn('type_name_api', function ($row) {
                    if ($row->type_name_api == 0) {
                        return "ถอน";
                    }
                    if ($row->type_name_api == 1) {
                        return "ฝาก";
                    }
                    if ($row->type_name_api == 2) {
                        return "ถอน/ฝาก";
                    }
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 0) {
                        return "<b class='text-secondary'>กำลังรอดำเนินการ</b>";
                    }
                    if ($row->status == 1) {
                        return "<b class='text-success'>ปกติ</b>";
                    }
                    if ($row->status == 2) {
                        return "<b class='text-danger'>ถูกยกเลิก</b>";
                    }
                })
                ->rawColumns(['action', 'created_at', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
