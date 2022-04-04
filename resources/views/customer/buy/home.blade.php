@extends('layouts.app')

@section('content')
    @php
    $type_name = '';
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        แบบฟอมร์ชำระเงิน
                    </div>

                    <div class="card-body">
                        <h1>
                            {{ $datas->name }}
                            @if ($datas->type_name == 0)
                                @php
                                    $type_name = 'ถอน';
                                    echo $type_name;
                                @endphp
                            @elseif ($datas->type_name == 1)
                                @php
                                    $type_name = 'ฝาก';
                                    echo $type_name;

                                @endphp
                            @elseif ($datas->type_name == 2)
                                @php
                                    $type_name = 'ถอน/ฝาก';
                                    echo $type_name;
                                @endphp
                            @endif
                        </h1>
                        <br>
                        <div class="row">
                            <form name="form_second" id="form_second"
                                action="{{ route('customer.buy.store', ['id' => $datas->id]) }}" method="post"
                                class="form-horizontal">
                                @csrf
                                <input type="hidden" name="post_id" id="post_id">
                                <div class="form-group">
                                    <label for="name_api">ชื่อ API ที่ต้องการเช่า</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name_api" name="name_api"
                                            placeholder="กรุณากรอกชื่อ" required readonly value="{{ $datas->name }}">
                                    </div>
                                    @error('name_api')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="type_name_api">ประเภท</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="type_name_api" name="type_name_api"
                                            placeholder="กรุณากรอกชื่อ" required readonly value="{{ $type_name }}">
                                    </div>
                                    @error('type_name_api')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="days_api">จำนวนวันที่เช่า (วัน)</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="days_api" name="days_api"
                                            placeholder="กรุณากรอกชื่อ" required readonly value="{{ $datas->days }}">
                                    </div>
                                    @error('days_api')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price_api">ราคา (บาท)</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="price_api" name="price_api"
                                            placeholder="กรุณากรอกชื่อ" required readonly value="{{ $datas->price }}">
                                    </div>
                                    @error('price_api')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="from_account">บัญชีของคุณ</label>
                                    <div class="col-sm-12">
                                        <select name="from_account" id="from_account" class="form-control">
                                            <option value="">กรุณาเลือกบัญชี</option>
                                            <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                                            <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                                            <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                                            <option value="ธนาคารทหารไทย">ธนาคารทหารไทย</option>
                                            <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                                            <option value="ธนาคารออมสิน">ธนาคารออมสิน</option>
                                        </select>
                                    </div>
                                    @error('from_account')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="from_no_account">เลขที่บัญชีของคุณ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="from_no_account"
                                            name="from_no_account" placeholder="กรุณากรอกเลขที่บัญชี" required>
                                    </div>
                                    @error('from_no_account')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="from_name_account">ชื่อบัญชีของคุณ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="from_name_account"
                                            name="from_name_account" placeholder="กรุณากรอกชื่อบัญชี" required>
                                    </div>
                                    @error('from_name_account')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                โอนไปยัง
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            {{-- <th>No</th> --}}
                                            <th>เลือก</th>
                                            <th>ธนาคาร</th>
                                            <th>เลขที่บัญชี</th>
                                            <th>ชื่อบัญชี</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banks as $key => $bank)
                                            <tr>
                                                <td>
                                                    <input type="radio" name="from_index" value="{{ $key }}"
                                                        required>
                                                </td>
                                                <td>{{ $bank['to_account'] }}</td>
                                                <td>{{ $bank['to_no_account'] }}</td>
                                                <td>{{ $bank['to_name_account'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @error('from_index')
                                    <div class="my-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label for="date_transection">วันที่ทำการโอนเงิน</label>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control" id="date_transection"
                                            name="date_transection" placeholder="กรุณากรอกชื่อบัญชี" required>
                                    </div>
                                    @error('date_transection')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="time_transection">วันที่ทำการโอนเงิน</label>
                                    <div class="col-sm-12">
                                        <input type="time" class="form-control" id="time_transection"
                                            name="time_transection" placeholder="กรุณากรอกชื่อบัญชี" required>
                                    </div>
                                    @error('time_transection')
                                        <div class="my-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div align="right">
                                    <button type="button" class="btn btn-primary" onclick="createPost()">บันทึก</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function createPost() {
            Swal.fire({
                title: 'คุณต้องการบันทีกใช่หรือไม่?',
                html: "<b class='text-danger'>คำเตือน! กรุณาตรวจสอบข้อมูลให้ดี จะไม่สามารถแก้ไขภายหลังได้</b>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: "ยกเลิก"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form_second').submit();
                }
            })
        }
    </script>
@endsection
