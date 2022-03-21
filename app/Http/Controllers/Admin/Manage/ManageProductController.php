<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class ManageProductController extends Controller
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
        return view('admin.manage_product.home');
    }

    public function get_product(Request $request)
    {
        if ($request->ajax()) {
            // $data = Product::latest()->get(); ช้า
            $data = Product::query(); //เร็ว
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm" onclick="editPost(' . $row->id . ')">แก้ไข</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deletePost(' . $row->id . ')">ลบ</a>';
                    return $actionBtn;
                })
                ->addColumn('type_name_new', function ($row) {
                    if ($row->type_name == 0) {
                        return "ถอน";
                    }
                    if ($row->type_name == 1) {
                        return "ฝาก";
                    }
                    if ($row->type_name == 2) {
                        return "ถอน/ฝาก";
                    }
                })
                ->addColumn('status_new', function ($row) {
                    if ($row->status == 0) {
                        return "<b class='text-danger'>ไม่เปิดให้ใช้</b>";
                    }
                    if ($row->status == 1) {
                        return "<b class='text-success'>เปิดให้ใช้</b>";
                    }
                })
                ->addColumn('detail', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm" onclick="detail(' . $row->id . ')">รายละเอียด</a> ';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $data = Carbon::parse($row->created_at)->locale('th')->diffForHumans();
                    return $data;
                })
                ->rawColumns(['type_name_new', 'detail', 'status_new', 'created_at', 'action'])
                ->make(true);
        }
    }

    public function get_post($id)
    {
        $data = ProductDetail::where('pro_id', $id)->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->created_at2 = Carbon::parse($data[$i]->created_at)->locale('th')->diffForHumans();
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {

        if ($request->post_id != "") {
            $data = Product::find($request->post_id);
            $request->validate(
                [
                    "name" => $data->username != $request->username ? "required|max:12|unique:products" : "required|max:12",
                    "type" => "required",
                    "status" => "required",
                    "days" => "required|numeric",
                    "price" => "required|numeric",
                ],
                // [
                //     "phone.required" => "กรุณากรอกช่องนี้",
                //     "phone.numeric" => "กรุณากรอกช่องนี้เป็นตัวเลข",
                //     "phone.digits" => "กรุณากรอกช่องนี้ 10 หลัก",
                //     "phone.unique" => "มีผู้ใช้แล้ว",

                // ]
            );
            $user = Product::updateOrCreate(['id' => $request->post_id], [
                "name" => $request->name,
                "type_name" => $request->type,
                "status" => $request->status,
                "days" => $request->days,
                "price" => $request->price,
            ]);
        } else {
            //เพิ่มข้อมูลใหม่
            $request->validate(
                [
                    "name" => "required|max:12|unique:products",
                    "type" => "required",
                    "status" => "required",
                    "days" => "required|numeric",
                    "price" => "required|numeric",
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
            $user = Product::updateOrCreate(['id' => $request->post_id], [
                "name" => $request->name,
                "type_name" => $request->type,
                "status" => $request->status,
                "days" => $request->days,
                "price" => $request->price,
            ]);
        }
        return response()->json(['code' => '200', 'message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function get_post_product($id)
    {
        $data = Product::find($id);
        return response()->json($data);
    }

    public function delete_post($id)
    {
        $data = Product::find($id)->delete();
        return response()->json(['message' => "ลบข้อมูลเรียบร้อย", "code" => "200"]);
    }
}
