@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <h1>Your Product</h1>

                        <table class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    {{-- <th>No</th> --}}
                                    <th>Product</th>
                                    <th>สถานะ</th>
                                    <th>จำนวนวันที่เช่า</th>
                                    <th>ฟังก์ชั่น</th>
                                    <th>วันหมดอายุ</th>
                                    <th>หมายเหตุ</th>
                                    <th>Token</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
                            <label for="token">Token</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="token" name="token" readonly
                                    placeholder="กรุณากรอกรายละเอียด" required>
                                <span id="tokenError" class="alert-message text-danger"></span>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger mr-auto" id="btn_user_status"
                    onclick="user_status(event.target)">ปิดบัญชีนี้</button>
                    <button type="button" class="btn btn-primary" onclick="createPost()">บันทึก</button>
                </div> --}}
            </div>
        </div>
    </div>

    <script>
        function detail(id) {
            var x = document.getElementById("div_"+id);
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <script type="text/javascript">
        window.addEventListener('load', function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer.item.list', ['id' => Auth::user()->id]) }}",
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex'
                    // },
                    {
                        data: 'name_api',
                        name: 'name_api'
                    },
                    {
                        data: 'status_new',
                        name: 'status_new'
                    },
                    {
                        data: 'days_api',
                        name: 'days_api'
                    },
                    {
                        data: 'type_new',
                        name: 'type_new'
                    },
                    {
                        data: 'expire',
                        name: 'expire'
                    },
                    {
                        data: 'comment',
                        name: 'comment'
                    },
                    {
                        data: 'token_new',
                        name: 'token_new'
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     // orderable: true,
                    //     searchable: true
                    // },
                ]
            });
        })
    </script>
@endsection
