<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use App\Models\PersonalAccessToken;

class ManageTokenController extends Controller
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
        return view('admin.token.home');
    }

    public function get_list(Request $request)
    {
        if ($request->ajax()) {
            // $data = Customer::latest()->get(); ช้า
            $data = PersonalAccessToken::query(); //เร็ว

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
                    $actionBtn = '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deletePost(' . $row->id . ')">revoke</a>';
                    return $actionBtn;
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
                ->editColumn('last_used_at', function ($row) {
                    $data = $row->last_used_at != null ? Carbon::parse($row->last_used_at) : "ยังไม่ถูกใช้";
                    return $data;
                })
                ->editColumn('expired_at', function ($row) {
                    $data = Carbon::parse($row->expired_at);
                    return $data;
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

    public function delete_post($id)
    {
        $data = PersonalAccessToken::find($id)->delete();
        return response()->json(['message' => "ลบข้อมูลเรียบร้อย", "code" => "200"]);
    }


    public function search($username)
    {
        $data = Customer::where('username', "like", $username . "%")->get();
        return response()->json($data);
    }
}
