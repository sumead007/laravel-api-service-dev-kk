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
                            <th>วันที่ทำรายการ</th>
                            {{-- <th>อื่นๆ</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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

    {{-- <script>
        function detail(pass_id) {
            var id = pass_id;
            let _url = "/admin/manage/admin/delete_post/" + id;
            $.ajax({
                url: _url,
                type: "get",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    console.log(res);
                    if (res) {
                        $("#records_table tbody").empty();
                        $.each(res, function(i, item) {
                            var $tr = $('<tr>').append(
                                $('<td>').text(item.detail),
                                $('<td>').html(item.status == 0 ?
                                    "<b class='text-danger'>ไม่รองรับ</b>" :
                                    "<b class='text-success'>รองรับ</b>"),
                                $('<td>').text(item.created_at2)
                            ).appendTo('#records_table');
                            // console.log($tr.wrap('<p>').html());
                        });
                        $("#tb_id").val(id)
                        $('#table-modal').modal('show');
                    }
                }
            });
        }

        function see_all_detail() {
            let id = $("#tb_id").val();
            window.location = "/admin/manage/product/detail/home/" + id
        }

        function editPost(pass_id) {
            clear_ms_error()
            var id = pass_id;
            let _url = "/admin/manage/product/get_post/" + id;
            $("#text_addcus").html("แก้ไข Product");
            $("#form_second")[0].reset();
            $.ajax({
                url: _url,
                type: "get",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    console.log(res);
                    if (res) {
                        $("#post_id").val(res.id);
                        $("#name").val(res.name);
                        $("#type").val(res.type_name);
                        $("#days").val(res.days);
                        $("#price").val(res.price);
                        $("#status").val(res.status);
                        $('#post-modal').modal('show');
                    }
                }
            });
        }

        function deletePost(pass_id) {
            Swal.fire({
                title: 'คูณแน่ใจใช่หรือไม่?',
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
                    let _url = "/admin/manage/product/delete_post/" + id;
                    let _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: _url,
                        type: "DELETE",
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

        function addPost() {
            $('#post-modal').modal('show');
            $("#form_second")[0].reset();
            $("#post_id").val("")
        }

        function createPost() {
            Swal.fire({
                title: 'คุณแน่ใจใช่หรือไม่?',
                text: "คุณต้องการบันทีกใช่หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: "ยกเลิก"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#form_second')[0];
                    var data = new FormData(form);
                    var id = $("#post_id").val();
                    let _url = "{{ route('admin.manage.product.store') }}";
                    $.ajax({
                        url: _url,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        enctype: 'multipart/form-data',
                        processData: false, // Important!
                        contentType: false,
                        cache: false,
                        timeout: 600000,
                        data: data,
                        success: function(res) {
                            Swal.fire(
                                'สำเร็จ!',
                                res.message,
                                'success'
                            )
                            var t = $('.yajra-datatable').DataTable();
                            t.draw();
                            $('#post-modal').modal('hide');

                            // console.log(res);
                        },
                        error: function(err) {
                            let msg = JSON.parse(err.responseText)
                            // console.log(msg);

                            Swal.fire(
                                'มีข้อผิดพลาด!',
                                'กรุณาตรวจสอบข้อมูลก่อนส่ง!',
                                'error'
                            )
                            clear_ms_error();
                            $('#nameError').text(err.responseJSON.errors.name);
                            $('#typeError').text(err.responseJSON.errors.type);
                            $('#daysError').text(err.responseJSON.errors.days);
                            $('#priceError').text(err.responseJSON.errors.price);
                            $('#statusError').text(err.responseJSON.errors.status);

                        }
                    });
                }
            })
        }

        function clear_ms_error() {
            $('#nameError').text("");
            $('#typeError').text("");
            $('#daysError').text("");
            $('#priceError').text("");
            $('#statusError').text("");
        }
    </script> --}}

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
                            data: 'created_at',
                            name: 'created_at',
                            orderable: true,
                        },
                        // {
                        //     data: 'action',
                        //     name: 'action',
                        //     // orderable: true,
                        //     searchable: true
                        // },
                    ]
                });
            });
        };
    </script>
@endsection
