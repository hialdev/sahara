@extends('layouts.blank2')
@section('css')
<style>
.book {
    margin: 0;
    padding: 0;
    background-color: #fff;
    font-family: 'Times New Roman', serif;
    transform-origin: 0 0;
}

* {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}

.page {
    display: block;
    width: 21cm;
    height: 29.7cm;
    margin: 1cm auto;
    border: 1px #D3D3D3 solid;
    border-radius: 5px;
    background: white;
    background: url('/dist/assets/compiled/png/saharakop.png') no-repeat;
    background-size: 100%;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    color: #212121 !important;

}

.subpage {
    margin: 3.5cm 2cm;
    outline: 0cm #FAFAFA solid;
}

@page {
    size: A4;
    margin: 0;
}

@media print {
    .page {
        margin: 0;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }
}

tr>td, tr>th{
    vertical-align: top;
}

table.main-table{

}
table.main-table>thead>tr>th, table.main-table>tbody>tr>td{
    border: 1px solid black; /* Border untuk sel */
    padding: 8px; /* Ruang dalam sel */
    text-align: left; /* Rata kiri untuk teks */
}
</style>
@endsection
@section('content')
<!-- Print content -->
<div class="d-flex align-items-center justify-content-center position-fixed bottom-0 end-0 start-0 mb-2" style="z-index: 99">
    <div class="d-flex align-items-center gap-1 bg-white shadow-sm p-1 rounded-pill">
        <a href="{{url()->previous()}}" class="btn p-2 px-3 btn-light-secondary rounded-pill">Back</a>
        <a href="{{route('debt.download', $debt->id)}}" class="btn p-2 px-3 btn-primary rounded-pill">Download Document</a>
    </div>
</div>
<div class="container-fluid">
    <div class="book">
        <div class="page">
            <div class="subpage" id='editor-container'>
                <div class="text-center mb-3">
                    <h4 class="mb-0 text-uppercase">Detail Hutang</h4>
                    <div class="fw-bold">{{$debt->no}}</div>
                    <div class="ft-italic">{{ \Carbon\Carbon::parse($debt->date)->translatedFormat('d F Y') }}</div>
                    <hr>
                </div>
                <div>
                    <table class="w-100">
                        <tr class="">
                            <td class="pb-2">
                                <div class="p-1 px-2 rounded-3 bg-light-primary text-dark d-inline-block mb-2" style="font-size: 13px">Process Order</div>
                                <h6>{{$debt->processOrder->no}}</h6>
                                <p class="mb-1" style="font-size: 13px">{{ \Carbon\Carbon::parse($debt->processOrder->date)->translatedFormat('d F Y') }}</p>
                                <p class="text-muted mb-0" style="font-size: 13px">{{$debt->processOrder->description}}</p>
                            </td>
                            <td class="pb-2 w-50">
                                <table class="table">
                                    <tr>
                                        <td class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="#435ebe" d="M3 4a2 2 0 0 0-2 2v11h2a3 3 0 0 0 3 3a3 3 0 0 0 3-3h6a3 3 0 0 0 3 3a3 3 0 0 0 3-3h2v-5l-3-4h-3V4m-7 2l4 4l-4 4v-3H4V9h6m7 .5h2.5l1.97 2.5H17M6 15.5A1.5 1.5 0 0 1 7.5 17A1.5 1.5 0 0 1 6 18.5A1.5 1.5 0 0 1 4.5 17A1.5 1.5 0 0 1 6 15.5m12 0a1.5 1.5 0 0 1 1.5 1.5a1.5 1.5 0 0 1-1.5 1.5a1.5 1.5 0 0 1-1.5-1.5a1.5 1.5 0 0 1 1.5-1.5" />
                                            </svg>
                                        </td>
                                        <td>
                                            <h6 class="m-0" style="font-size: 13px">Detail Pengiriman</h6>
                                        </td>
                                    </tr>
                                </table>
                                <div>
                                    @if ($debt->processOrder->is_logistic_in_sahara == 1)
                                    <span class="text-muted font-semibold">{{$debt->processOrder->logistic->name}}<br/></span>
                                    <span class="text-muted" style="font-size:13px">
                                        <strong>Pick Up Address : </strong> 
                                        ({{ optional($debt->processOrder->pickup)->address_tag }}) 
                                        {{ optional($debt->processOrder->pickup)->address }}, 
                                        {{ optional($debt->processOrder->pickup)->city }}. 
                                        {{ optional($debt->processOrder->pickup)->postal_code }}
                                    </span>
                                    @else
                                    <span class="text-muted">Logistic diurus oleh Principle<br/></span>
                                    @endif

                                    <table class="">
                                        <tr>
                                            <td>
                                                <a href="{{$debt->processOrder->spk_file ? asset('storage/'.$debt->processOrder->spk_file) : '#'}}" target="_blank" class="p-1 px-2 rounded-3 bg-light-secondary text-dark" style="font-size: 13px">
                                                    File SPK
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{$debt->processOrder->surjal_file ? asset('storage/'.$debt->processOrder->surjal_file) : '#'}}" target="_blank" class="p-1 px-2 rounded-3 bg-light-secondary text-dark" style="font-size: 13px">
                                                    File Surjal
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="">
                                <table class="table" style="vertical-align: middle">
                                    <tr>
                                        <td class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.13em" height="1em" viewBox="0 0 576 512"><path fill="#435ebe" d="M256 0h64c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32h-64c-17.7 0-32-14.3-32-32V32c0-17.7 14.3-32 32-32M64 64h128v48c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V64h128c35.3 0 64 28.7 64 64v320c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128c0-35.3 28.7-64 64-64m112 373.3c0 5.9 4.8 10.7 10.7 10.7h202.7c5.9 0 10.7-4.8 10.7-10.7c0-29.5-23.9-53.3-53.3-53.3H229.5c-29.5 0-53.3 23.9-53.3 53.3zM288 352a64 64 0 1 0 0-128a64 64 0 1 0 0 128"/></svg>
                                        </td>
                                        <td>
                                            <h6 class="m-0" style="font-size: 13px">Principle</h6>
                                        </td>
                                    </tr>
                                </table>
                                <div class="fw-semibold">{{$debt->processOrder->principle?->name}}</div>
                                <div style="font-size:12px" class="text-muted">{{$debt->processOrder->principle?->email}}</div>
                            </td>
                            <td class="">
                                <table class="table">
                                    <tr>
                                        <td class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                                <path fill="#435ebe" d="M6 17c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1H6m9-9a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3a3 3 0 0 1 3 3M3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2" />
                                            </svg>
                                        </td>
                                        <td>
                                            <h6 class="m-0" style="font-size: 13px">PIC Contact</h6>
                                        </td>
                                    </tr>
                                </table>
                                <div class="fw-semibold">
                                    {{$debt->processOrder->principle?->contact_name}}
                                </div>
                                <div style="font-size:12px" class="text-muted">{{$debt->processOrder->principle?->contact_email}}, {{$debt->processOrder->principle?->contact_phone}}</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="my-4">
                    <table class="w-100 main-table mb-3">
                        <thead>
                            <tr>
                                <th style="width: 2.7em">No</th>
                                <th>Product Dipesan</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Price Buy</th>
                                <th class="bg-danger text-white">Total Hutang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($debt->processOrder->getProducts as $product)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>
                                    <div class="fw-bold">{{$product->product->title}}</div>
                                    <div style="font-size: 10px" class="text-secondary">{{$product->product->description}}</div>
                                </td>
                                <td>
                                    {{$product->product->satuan->name}}
                                </td>
                                <td>{{$product->qty}}</td>
                                <td>
                                    {{formatRupiah($product->price_buy)}}
                                </td>
                                <td class="bg-light-danger fw-bold">
                                    {{formatRupiah($product->price_buy*$product->qty)}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="w-100 main-table mb-2">
                        <thead>
                            <tr>
                                <th style="width: 2.7em">No</th>
                                <th>Hutang Dibayar</th>
                                <th class="bg-primary text-white">Jumlah Dibayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($debt->processes as $process)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>
                                    <div class="fw-bold">{{$process->no}}</div>
                                    <div style="font-size: 10px" class="text-secondary">{{\Carbon\Carbon::parse($process->date_paid)->translatedFormat('d F Y')}}</div>
                                </td>
                                <td class="bg-light-primary fw-bold">
                                    {{formatRupiah($process->amount_paid)}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="w-100 main-table bg-light-primary rounded-3 overflow-hidden" style="border: 0px solid transparent !important">
                        <tr class="" style="border: 0px solid transparent !important">
                            <td class="p-3" style="border: 0px solid transparent !important">
                                <div style="font-size: 12px">Total yang harus dibayarkan</div>
                                <div class="fs-6 fw-bold text-primary">{{formatRupiah($debt->total_debt)}}</div>
                            </td>
                            <td class="text-end p-3" style="border: 0px solid transparent !important">
                                <div style="font-size: 12px">Sisa yang belum dibayarkan</div>
                                <div class="fs-6 fw-bold text-danger">{{formatRupiah($debt->sisaHutang())}}</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function adjustZoomLevel() {
  var documentWidth = window.innerWidth
    || document.documentElement.clientWidth
    || document.body.clientWidth;
    
  // 1 cm = 37.795276px;
  var zoomLevel = documentWidth / (23 * 37.795276);
  
  // stop zooming when book fits page
  if (zoomLevel >= 1) return;
  
  document.querySelector(".book").style.transform = "scale(" + zoomLevel + ")";
}

adjustZoomLevel();

window.addEventListener("resize", adjustZoomLevel);
</script>
@endsection