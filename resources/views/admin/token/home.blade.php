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
                        <h1 class="m-0">จัดการ Token</h1>
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
                <div align="right">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="addPost()">
                        เพิ่ม Token
                    </a>
                </div>
                <br>
                <table class="table table-bordered yajra-datatable">
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>Username</th>
                            <th>Product</th>
                            <th>ใช้ล่าสุด</th>
                            <th>หมดอายุ</th>
                            <th>วันที่สร้าง</th>
                            <th>อื่นๆ</th>
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
                    <h4 class="modal-title" id="text_addcus">เพิ่มข้อมูล Token</h4>
                </div>
                <div class="modal-body">
                    <h4>เพิ่ม Token โดยเลือกลูกค้า</h4>
                    <form name="form_second" id="form_second" class="form-horizontal">
                        <input type="hidden" name="post_id" id="post_id">
                        <div class="form-group row">
                            {{-- <label for="name">ค้นหาจาก username</label> --}}
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="ค้นหาจาก username" required>
                                <span id="usernameError" class="alert-message text-danger"></span>
                            </div>
                            <div class="col-sm-3">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="searcdh()">
                                    ค้นหา
                                </a>
                            </div>

                        </div>


                        <table class="table table-bordered" id="records_table">
                            <thead>
                                <tr>
                                    {{-- <th>No</th> --}}
                                    <th>เลือก</th>
                                    <th>ชื่อ</th>
                                    <th>ชื่อผู้ใช้งาน</th>
                                    {{-- <th>อื่นๆ</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <span id="idError" class="alert-message text-danger"></span>

                        <div class="form-group">
                            <label for="product">Product</label>
                            <div class="col-sm-12">
                                <select name="product" id="product" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือก Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->name }}:{{ $product->id }}">
                                            {{ $product->name }}:
                                            @if ($product->type_name == 0)
                                                ถอน
                                            @elseif($product->type_name == 1)
                                                ฝาก
                                            @elseif($product->type_name == 2)
                                                ถอน/ฝาก
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <span id="productError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">วันหมดอายุ</label>
                            <div class="col-sm-12">
                                <input type="date" name="expire" id="expire" class="form-control" min='1899-01-01'
                                    max='2000-13-13'>
                                <span id="expireError" class="alert-message text-danger"></span>
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



    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("expire").setAttribute("min", today);

        function searcdh() {
            // console.log("test");
            // return false;
            let username = $("#username").val();
            let _url = "/admin/manage/token/search/" + username;
            $.ajax({
                url: _url,
                type: "get",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    // console.log(res);
                    if (res) {
                        $("#records_table tbody").empty();
                        $.each(res, function(i, item) {
                            var $tr = $('<tr>').append(
                                $('<td>').html("<input type='radio' name='id' value='" + item.id +
                                    "'>"),
                                $('<td>').text(item.name),
                                $('<td>').text(item.username)
                            ).appendTo('#records_table');
                            // console.log($tr.wrap('<p>').html());
                        });
                    }
                }
            });
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
                    let _url = "/admin/manage/token/delete_post/" + id;
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
                    let _url = "{{ route('admin.manage.token.store') }}";
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
                            let message = res.message + '<br>' + '<b>' + 'Token: ' + (res.token).split(
                                    "|")[1] + '</b>' + '<br>' +
                                '<b class="text-danger">คำเตือน!! สามารถดูโทเค็นได้แค่ครั้งเดียว กรุณาเก็บไว้ให้ดี</b>'

                            Swal.fire(
                                'สำเร็จ!',
                                message,
                                'success',
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
                            $('#idError').text(err.responseJSON.errors.id);
                            $('#expireError').text(err.responseJSON.errors.expire);
                            $('#productError').text(err.responseJSON.errors.product);
                        }
                    });
                }
            })
        }

        function clear_ms_error() {
            $('#idError').text("");
            $('#expireError').text("");
            $('#productError').text("");
        }
    </script>

    <script type="text/javascript">
        window.onload = (event) => {

            $(function() {
                var table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.manage.token.list') }}",
                    columns: [
                        // {
                        //     data: 'DT_RowIndex',
                        //     name: 'DT_RowIndex'
                        // },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'abilities',
                            name: 'abilities'
                        },
                        {
                            data: 'last_used_at',
                            name: 'last_used_at'
                        },
                        {
                            data: 'expired_at',
                            name: 'expired_at'
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
