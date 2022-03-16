<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

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
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {

        if ($request->post_id != "") {
            $admin = Phone::find($request->post_id);
            $request->validate(
                [
                    "phone" => $request->phone != $admin->phone ? "required|digits:10|unique:phones,phone" : "",
                ],
                [
                    "phone.required" => "กรุณากรอกช่องนี้",
                    "phone.numeric" => "กรุณากรอกช่องนี้เป็นตัวเลข",
                    "phone.digits" => "กรุณากรอกช่องนี้ 10 หลัก",
                    "phone.unique" => "มีผู้ใช้แล้ว",

                ]
            );
            $user = Phone::updateOrCreate(['id' => $request->post_id], [
                "phone" =>  $request->phone,
            ]);
        } else {
            //เพิ่มข้อมูลใหม่
            $request->validate(
                [
                    "username" => "required|min:6|max:12|unique:customers|unique:users",
                    "name" => "required|min:3|max:6",
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
                    "name.max" => "ต้องมีไม่เกิน6ตัวอักษร",
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
}
