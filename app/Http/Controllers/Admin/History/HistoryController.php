<?php

namespace App\Http\Controllers\Admin\History;

use App\Http\Controllers\Controller;
use App\Models\Buy;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

class HistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.history.home');
    }

    public function get_list(Request $request)
    {
        if ($request->ajax()) {
            // $data = Customer::latest()->get(); ช้า
            $data = Buy::query(); //เร็ว

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
                ->addColumn('cus_username', function ($row) {
                    $data = $row->customers->username;
                    return $data;
                })
                ->addColumn('type_name_api_new', function ($row) {
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
                ->addColumn('status_new', function ($row) {
                    if ($row->status == 0) {
                        return "<b class='text-danger'>รอการยืนยัน</b>";
                    }
                    if ($row->status == 1) {
                        return "<b class='text-success'>สำเร็จ</b>";
                    }
                    if ($row->status == 2) {
                        return "<b class='text-success'>ยกเลิก</b>";
                    }
                })
                ->editColumn('created_at', function ($row) {
                    $data = Carbon::parse($row->created_at)->locale('th')->diffForHumans();
                    return $data;
                })
                ->rawColumns(['action', 'cus_username', 'type_name_api_new', 'status_new'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
