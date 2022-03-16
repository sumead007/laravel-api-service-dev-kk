<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Carbon\Carbon;

class ManageAdminController extends Controller
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
        return view('admin.manage_admin.home');
    }

    public function getAdmin(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm" onclick="editPost(' . $row->id . ')">แก้ไข</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deletePost(' . $row->id . ')">ลบ</a>';
                    return $actionBtn;
                })
                ->addColumn('name', function ($row) {
                    if ($row->id == auth()->guard('admin')->user()->id) {
                        return "<p class='text-success'>$row->name (คุณ)</p>";
                    }
                    if ($row->id != auth()->guard('admin')->user()->id) {
                        return "<p class='text-block'>$row->name </p>";
                    }
                })
                ->addColumn('created_at', function ($row) {
                    $data = Carbon::parse($row->created_at)->locale('th')->diffForHumans();;
                    return $data;
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {

        if ($request->post_id != "") {
            $data = User::find($request->post_id);
            $request->validate(
                [
                    "username" => $data->username != $request->username ? "required|min:6|max:12|unique:customers|unique:users" : "required|min:6|max:12|unique:customers",
                    "name" => "required|min:3|max:20",
                    "password" => $request->password != null ? "required|min:8|max:20|required_with:password_confirmation|same:password_confirmation" : "",
                ],
                [
                    "phone.required" => "กรุณากรอกช่องนี้",
                    "phone.numeric" => "กรุณากรอกช่องนี้เป็นตัวเลข",
                    "phone.digits" => "กรุณากรอกช่องนี้ 10 หลัก",
                    "phone.unique" => "มีผู้ใช้แล้ว",

                ]
            );
            $user = User::updateOrCreate(['id' => $request->post_id], [
                "username" => $request->username,
                "name" => $request->name,
                "password" => $request->password != null ? bcrypt($request->password) : $data->password,
            ]);
        } else {
            //เพิ่มข้อมูลใหม่
            $request->validate(
                [
                    "username" => "required|min:6|max:12|unique:customers|unique:users",
                    "name" => "required|min:3|max:20",
                    "password" => "required|min:8|max:20|required_with:password_confirmation|same:password_confirmation",
                ],
                [
                    //username
                    "username.required" => "กรุณากรอกช่องนี้",
                    "username.min" => "ต้องมีอย่างน้อย6ตัวอักษร",
                    "username.max" => "ต้องมีไม่เกิน12ตัวอักษร",
                    "username.unique" => "ชื่อผู้ใช้นี้ถูกใช้แล้ว",
                    //name
                    "name.required" => "กรุณากรอกช่องนี้",
                    "name.min" => "ต้องมีอย่างน้อย3ตัวอักษร",
                    "name.max" => "ต้องมีไม่เกิน20ตัวอักษร",
                    //password
                    "password.required" => "กรุณากรอกช่องนี้",
                    "password.min" => "ต้องมีอย่างน้อย8ตัวอักษร",
                    "password.max" => "ต้องมีไม่เกิน20ตัวอักษร",
                    "password.same" => "กรุณายืนยันรหัสผ่านใหม่อีกครั้ง",

                ]
            );
            $user = User::updateOrCreate(['id' => $request->post_id], [
                "username" => $request->username,
                "name" => $request->name,
                "password" => bcrypt($request->password),
            ]);
        }
        return response()->json(['code' => '200', 'message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }
    public function get_post($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    public function delete_post($id)
    {
        $data = User::find($id)->delete();
        return response()->json(['message' => "ลบข้อมูลเรียบร้อย", "code" => "200"]);
    }
}
