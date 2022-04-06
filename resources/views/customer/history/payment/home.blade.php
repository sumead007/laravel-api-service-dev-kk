@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <h1>History Payment</h1>
                        <div class="table-responsive">
                            <table class="table table-bordered yajra-datatable">
                                <thead>
                                    <tr>
                                        {{-- <th>No</th> --}}
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
                                        <th>วันเวลาโอนเงิน</th>
                                        <th>วันที่ทำรายการ</th>
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

    <script type="text/javascript">
        window.addEventListener('load', function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer.history.home.list') }}",
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
                        data: 'type_name_api',
                        name: 'type_name_api'
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
                        data: 'status',
                        name: 'status'
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
                        name: 'created_at'
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
