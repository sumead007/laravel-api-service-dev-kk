<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class ManageProductDetailController extends Controller
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

    public function index($id)
    {
        $data = Product::find($id);
        return view('admin.manage_product.detail', compact('data'));
    }

    public function get_detail(Request $request)
    {
        // return response($request->id);

        if ($request->ajax()) {
            // $data = Product::latest()->get(); ช้า
            // sleep(10);
            $data = ProductDetail::where('pro_id', $request->id);
            // $bottle= tbl_bottle::select(
            //     'name',
            //     'type',
            //     'location'
            //   )->where(function($query) {
            //     $query->where('location','=','USA')->OrWhere('location','=',' ')
            //   });
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm" onclick="editPost(' . $row->id . ')">แก้ไข</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deletePost(' . $row->id . ')">ลบ</a>';
                    return $actionBtn;
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 0) {
                        return "<b class='text-danger'>ไม่รองรับ</b>";
                    }
                    if ($row->status == 1) {
                        return "<b class='text-success'>รองรับ</b>";
                    }
                })
                ->editColumn('created_at', function ($row) {
                    $data = Carbon::parse($row->created_at)->locale('th')->diffForHumans();;
                    return $data;
                })
                ->rawColumns(['created_at', 'action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function store(Request $request)
    {

        if ($request->post_id != "") {
            // $data = ProductDetail::find($request->post_id);
            $request->validate(
                [
                    "detail" => "required|max:255",
                    "pro_id" => "required",
                    "status" => "required",
                ],
                // [
                //     "phone.required" => "กรุณากรอกช่องนี้",
                //     "phone.numeric" => "กรุณากรอกช่องนี้เป็นตัวเลข",
                //     "phone.digits" => "กรุณากรอกช่องนี้ 10 หลัก",
                //     "phone.unique" => "มีผู้ใช้แล้ว",

                // ]
            );
            $user = ProductDetail::updateOrCreate(['id' => $request->post_id], [
                "detail" => $request->detail,
                "pro_id" => $request->pro_id,
                "status" => $request->status,
            ]);
        } else {
            //เพิ่มข้อมูลใหม่
            $request->validate(
                [
                    "detail" => "required|max:255",
                    "pro_id" => "required",
                    "status" => "required",
                ],
                // [
                //     //username
                //     "username.required" => "กรุณากรอกช่องนี้",
                //     "username.min" => "ต้องมีอย่างน้อย6ตัวอักษร",
                //     "username.max" => "ต้องมีไม่เกิน12ตัวอักษร",
                //     "username.unique" => "ชื่อผู้ใช้นี้ถูกใช้แล้ว",
                //     //name
                //     "name.required" => "กรุณากรอกช่องนี้",
                //     "name.min" => "ต้องมีอย่างน้อย3ตัวอักษร",
                //     "name.max" => "ต้องมีไม่เกิน20ตัวอักษร",
                //     //password
                //     "password.required" => "กรุณากรอกช่องนี้",
                //     "password.min" => "ต้องมีอย่างน้อย8ตัวอักษร",
                //     "password.max" => "ต้องมีไม่เกิน20ตัวอักษร",
                //     "password.same" => "กรุณายืนยันรหัสผ่านใหม่อีกครั้ง",

                // ]
            );
            $user = ProductDetail::updateOrCreate(['id' => $request->post_id], [
                "detail" => $request->detail,
                "pro_id" => $request->pro_id,
                "status" => $request->status,
            ]);
        }
        return response()->json(['code' => '200', 'message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function get_post($id)
    {
        $data = ProductDetail::find($id);
        return response()->json($data);
    }

    public function delete_post($id)
    {
        $data = ProductDetail::find($id)->delete();
        return response()->json(['message' => "ลบข้อมูลเรียบร้อย", "code" => "200"]);
    }
}
