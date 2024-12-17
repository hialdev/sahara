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
        <a href="{{route('invoice.download', $invoice->id)}}" class="btn p-2 px-3 btn-primary rounded-pill">Download Document</a>
    </div>
</div>
<div class="container-fluid">
    <div class="book">
        <div class="page">
            <div class="subpage" id='editor-container'>
                <div class="text-center mb-3">
                    <h4 class="mb-0 text-uppercase">Invoice</h4>
                    <div class="fw-bold">{{$invoice->no}}</div>
                    <div class="ft-italic">{{ \Carbon\Carbon::parse($invoice->date)->translatedFormat('d F Y') }}</div>
                    <hr>
                </div>
                <div>
                    <table>
                        <tr>
                            <th>PO / BPP Number</th>
                            <td class="px-3">:</td>
                            <td>{{$invoice->purchaseOrder->po_number}}</td>
                        </tr>
                        <tr>
                            <th>Project Location</th>
                            <td class="px-3">:</td>
                            <td style="max-width: 24em">{{$invoice->purchaseOrder->address->address_tag}} - {{$invoice->purchaseOrder->address->address}}, {{$invoice->purchaseOrder->address->city}}, {{$invoice->purchaseOrder->address->postal_code}}</td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td class="px-3">:</td>
                            <td>{{$invoice->client->name}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td class="px-3">:</td>
                            <td style="max-width: 24em">{{$invoice->client->addresses->keyBy('address_tag')->get('office')->address}}, {{$invoice->client->addresses->keyBy('address_tag')->get('office')->city}}, {{$invoice->client->addresses->keyBy('address_tag')->get('office')->postal_code}}</td>
                        </tr>
                    </table>
                </div>
                <div class="my-4">
                    <table class="w-100 main-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->purchaseOrder->getProducts as $product)
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
                                    {{formatRupiah($product->price)}}
                                </td>
                                <td>
                                    {{formatRupiah($product->price*$product->qty)}}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="fw-bold" colspan="5">Sub Total</td>
                                @php
                                    $totalPrice = 0;
                                    foreach ($invoice->purchaseOrder->getProducts as $prd) {
                                        $totalPrice += $prd->price*$prd->qty;
                                    }
                                    $tax = 11/100;
                                    $totalPriceTaxed = $totalPrice * $tax;
                                @endphp

                                <td>{{formatRupiah($totalPrice)}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light-warning text-dark" colspan="5">VAT 11%</td>
                                <td>{{formatRupiah($totalPriceTaxed)}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-primary text-white" colspan="5">Grand Total</td>
                                <td class="bg-light-primary text-primary font-bold">{{formatRupiah($totalPriceTaxed+$totalPrice)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="w-100">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="fw-bold">Payment Transfer</div>
                                            <div>PT Rizq Sahara Multindo</div>
                                            <div>Mandiri Cabang Jakarta Aneka Tambang</div>
                                            <div>A/C: 127-000-7938-085</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="text-end">
                                <div class="text-start">
                                    <div>Sincerely,</div>
                                    <div>PT. Rizq Sahara Multindo</div>
                                    <div style="height: 2cm"></div>
                                    <div><u>Teuku Ria Fahriza</u></div>
                                    <div>Director</div>
                                </div>
                            </td>
                        </tr>
                    </table>
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