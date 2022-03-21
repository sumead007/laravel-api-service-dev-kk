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
                        <h1 class="m-0">Products Detail: {{ $data->name }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">จัดการข้อมูล Products</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <a href="{{ URL::previous() }}" class="edit btn btn-success">ย้อนกลับ</a>

                <div align="right">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="addPost()">
                        เพิ่มข้อมูล
                    </a>
                </div>
                <br>
                <table class="table table-bordered yajra-datatable">
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>รายละเอียด</th>
                            <th>สถานะ</th>
                            <th>วันที่ทำรายการ</th>
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
                    <h4 class="modal-title" id="text_addcus">เพิ่มข้อมูลแอตมิน</h4>
                </div>
                <div class="modal-body">
                    <form name="form_second" id="form_second" class="form-horizontal">
                        <input type="hidden" name="post_id" id="post_id">
                        <div class="form-group">
                            <label for="detail">รายละเอียด</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="detail" name="detail"
                                    placeholder="กรุณากรอกรายละเอียด" required>
                                <span id="detailError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">สถานะ</label>
                            <div class="col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือก</option>
                                    <option value="0">ไม่รองรับ</option>
                                    <option value="1">รองรับ</option>
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

    <script>
        function editPost(pass_id) {
            clear_ms_error()
            var id = pass_id;
            let _url = "/admin/manage/admin/get_post/" + id;
            $("#text_addcus").html("แก้ไขรายเบอร์โทร");
            $("#form_second")[0].reset();
            $.ajax({
                url: _url,
                type: "get",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    // console.log(res);
                    if (res) {
                        $("#post_id").val(res.id);
                        $("#name").val(res.name);
                        $("#username").val(res.username);
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
                    let _url = "/admin/manage/admin/delete_post/" + id;
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
                    let _url = "{{ route('admin.manage.admin.store') }}";
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
                            $('#usernameError').text(err.responseJSON.errors.username);
                            $('.passwordError').text(err.responseJSON.errors.password);

                        }
                    });
                }
            })
        }

        function clear_ms_error() {
            $('#nameError').text("");
            $('#usernameError').text("");
            $('#passwordError').text("");
        }
    </script>

    <script type="text/javascript">
        window.addEventListener('load', function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.manage.product.detail.list', ['id' => $data->id]) }}",
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex'
                    // },
                    {
                        data: 'detail',
                        name: 'detail'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
        })
    </script>
@endsection
