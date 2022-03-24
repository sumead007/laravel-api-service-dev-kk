@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Product For {{ $datas[0]->name }}</div>

                    <div class="card-body">
                        {{-- <h1>Product For {{ $datas[0]->name }} </h1> --}}
                        <br>
                        <div class="row">
                            @foreach ($datas as $key => $value)
                                <div class="col-md-4">
                                    <div class="card" style="width: 18rem;">
                                        {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                                        <div class="card-body">
                                            <h6 class="card-title text-center">
                                                @if ($value->type_name == 0)
                                                    ถอน
                                                @elseif ($value->type_name == 1)
                                                    ฝาก
                                                @elseif ($value->type_name == 2)
                                                    ถอน/ฝาก
                                                @endif
                                            </h6>
                                            <h5 class="card-title text-center">{{ $value->price }}บาท/
                                                {{ $value->days }}วัน
                                            </h5>
                                            {{-- <p class="card-text">Some quick example text to build on the card title and
                                                make up
                                                the
                                                bulk of the card's content.</p> --}}
                                        </div>

                                        <ul class="list-group list-group-flush">
                                            @foreach ($value->product_details as $product_detail)
                                                <li class="list-group-item">
                                                    @if ($product_detail->status == 0)
                                                        <i class="fa-solid fa-xmark" style="font-size: 16pt;color:red"></i>
                                                    @else
                                                        <i class="fa-solid fa-check"
                                                            style="font-size: 16pt;color:green"></i>
                                                    @endif
                                                    {{ $product_detail->detail }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="card-body" align="center">
                                            <a href="#" class="card-link">เช่าเลย</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
