@extends('layouts.admin.app')

@section('content')
    @include('layouts.script.data_table.stylesheet')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">ประวัติการโอนเงินของลูกค้า</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">ประวัติการโอนเงินของลูกค้า</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{-- <div align="right">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="addPost()">
                        เพิ่มข้อมูล
                    </a>
                </div> --}}
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                {{-- <th>No</th> --}}
                                <th>Username</th>
                                <th>ชื่อ Product</th>
                                <th>ประเภทการใช้งาน</th>
                                <th>จำนวนการเช่า(วัน)</th>
                                <th>ราคา(บาท)</th>
                                <th>สถานะ</th>
                                <th>หมายเหตุ</th>
                                <th>วันหมดอายุ</th>
                                <th>โอนจากบัญชี</th>
                                <th>เลขที่บัญชี</th>
                                <th>ชื่อคนโอน</th>
                                <th>โอนไปยังบัญชี</th>
                                <th>โอนไปยังเลขที่บัญชี</th>
                                <th>ชื่อคนรับ</th>
                                <th>จำนวนเงินที่โอน</th>
                                <th>วันเวลาทำรายการ</th>
                                <th>วันที่ทำรายการ</th>
                                <th>อื่นๆ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    {{-- modal store --}}
    <div class="modal fade" id="post-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="text_addcus">เพิ่มข้อมูล Product</h4>
                </div>
                <div class="modal-body">
                    <form name="form_second" id="form_second" class="form-horizontal">
                        <input type="hidden" name="post_id" id="post_id">
                        <div class="form-group">
                            <label for="name">ชื่อ</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="กรุณากรอกชื่อ"
                                    required>
                                <span id="nameError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">ประเภท</label>
                            <div class="col-sm-12">
                                <select name="type" id="type" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกประเภท</option>
                                    <option value="0">ถอน</option>
                                    <option value="1">ฝาก</option>
                                    <option value="2">ถอน/ฝาก</option>
                                </select>
                                <span id="typeError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="days">ให้เช่ากี่วัน (วัน)</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="days" name="days"
                                    placeholder="กรุณากรอกจำนวนวัน" required>
                                <span id="daysError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">ราคา (บาท)</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="กรุณากรอกราคา" required>
                                <span id="priceError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">สถานะ</label>
                            <div class="col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือก</option>
                                    <option value="0">ปิดให้ใช้งาน</option>
                                    <option value="1">เปิดให้ใช้งาน</option>
                                </select>
                                <span id="statusError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-outline-danger mr-auto" id="btn_user_status"
                        onclick="user_status(event.target)">ปิดบัญชีนี้</button> --}}
                    <button type="button" class="btn btn-primary" onclick="createPost()">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal table --}}
    <div class="modal fade" id="table-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="text_addcus">รายละเอียด</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tb_id" id="tb_id">
                    <table class="table" id="records_table">
                        <thead>
                            <tr>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-outline-danger mr-auto" id="btn_user_status"
                        onclick="user_status(event.target)">ปิดบัญชีนี้</button> --}}
                    <button type="button" class="btn btn-warning" onclick="see_all_detail()">แก้ไข</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function accepte(pass_id, status) {
            Swal.fire({
                title: 'คุณต้องการทำรายการนี้ใช่หรือไม่?',
                text: "คุณต้องการลบข้อมูลใช่หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = pass_id;
                    let _url = "/admin/manage/history/accepte/" + id + "/" + status;
                    let _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: _url,
                        type: "get",
                        data: {
                            _token: _token,
                        },
                        success: function(res) {
                            Swal.fire(
                                'สำเร็จ!',
                                res.message,
                                'success'
                            )
                            var t = $('.yajra-datatable').DataTable();
                            t.draw();
                        },
                        error: function(err) {
                            Swal.fire(
                                'มีข้อผิดพลาด!',
                                err.responseJSON.message,
                                'error'
                            )

                        }

                    });
                }
            })

        }
    </script>

    <script type="text/javascript">
        window.onload = (event) => {

            $(function() {
                var table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.history.list') }}",
                    columns: [
                        // {
                        //     data: 'DT_RowIndex',
                        //     name: 'DT_RowIndex'
                        // },
                        {
                            data: 'cus_username',
                            name: 'cus_username'
                        },
                        {
                            data: 'name_api',
                            name: 'name_api'
                        },
                        {
                            data: 'type_name_api_new',
                            name: 'type_name_api_new'
                        },
                        {
                            data: 'days_api',
                            name: 'days_api'
                        },
                        {
                            data: 'price_api',
                            name: 'price_api'
                        },
                        {
                            data: 'status_new',
                            name: 'status_new'
                        },
                        {
                            data: 'comment',
                            name: 'comment'
                        },
                        {
                            data: 'expire',
                            name: 'expire'
                        },
                        {
                            data: 'from_account',
                            name: 'from_account'
                        },
                        {
                            data: 'from_no_account',
                            name: 'from_no_account'
                        },
                        {
                            data: 'from_name_account',
                            name: 'from_name_account'
                        },
                        {
                            data: 'to_account',
                            name: 'to_account'
                        },
                        {
                            data: 'to_no_account',
                            name: 'to_no_account'
                        },
                        {
                            data: 'to_name_account',
                            name: 'to_name_account'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'datetime_transection',
                            name: 'datetime_transection'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            orderable: true,
                        },
                        {
                            data: 'action',
                            name: 'action',
                            // orderable: true,
                            searchable: true
                        },
                    ]
                });
            });
        };
    </script>
@endsection
