<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
                    $actionBtn = '<button data-swal-toast-template="#my-template"  class="edit btn btn-warning btn-sm">
                    รายละเอียด
                </button>';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    $data = Carbon::parse($row->created_at)->locale('th')->diffForHumans();;
                    return $data;
                })
                ->rawColumns(['type_name_new', 'detail', 'status_new', 'created_at', 'action'])
                ->make(true);
        }
    }
}
