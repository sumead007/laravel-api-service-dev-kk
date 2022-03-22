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
                                    <th>Action</th>
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
                        data: 'type_name_api',
                        name: 'type_name_api'
                    },
                    {
                        data: 'days_api',
                        name: 'days_api'
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
                        data: 'token',
                        name: 'token'
                    },
                    {
                        data: 'expire',
                        name: 'expire'
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
