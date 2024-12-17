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
        <a href="{{route('quotation.download', $quotation->id)}}" class="btn p-2 px-3 btn-primary rounded-pill">Download Document</a>
    </div>
</div>
<div class="container-fluid">
    <div class="book">
        <div class="page">
            <div class="subpage" id='editor-container'>
                <div class="text-center mb-3">
                    <h4 class="mb-0 text-uppercase">Surat Penawaran</h4>
                    <div class="fw-bold">{{$quotation->no}}</div>
                    <div class="ft-italic">Jakarta, {{ \Carbon\Carbon::parse($quotation->date)->translatedFormat('d F Y') }}</div>
                    <hr>
                </div>
                <div>
                    <table class="mb-2 w-100">
                        <tr>
                            <td width="60">Nomor</td><td width="10" class="pl-1 pr-1">:</td><td>{{$quotation->no}}</td>
                        </tr>
                        <tr>
                            <td width="60">Lampiran</td><td width="10" class="pl-1 pr-1">:</td><td>-</td>
                        </tr>
                        <tr>
                            <td width="60">Perihal</td><td width="10" class="pl-1 pr-1">:</td><td><span class="previewPerihal">{{$quotation->perihal}}</span></td>
                        </tr>
                        <tr>
                            <td width="60" class="align-top">Kepada</td>
                            <td width="10" class="pl-1 pr-1 align-top">:</td>
                            <td>
                                <span class="previewClientName fw-bold">{{$quotation->client->name}}</span><br>
                                <span class="previewClientAddress">{{$quotation->client->addresses->keyBy('address_tag')->get('office')->address}}</span><br>
                                <span class="previewClientPostal">{{$quotation->client->addresses->keyBy('address_tag')->get('office')->postal_code}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="60">U.P.</td><td width="10" class="pl-1 pr-1">:</td><td><span class="previewFor">{{$quotation->for}}</span></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <p>Dengah hormat,</p>
                    <div id="previewMessage">
                        {!! $quotation->message !!}
                    </div>
                </div>
                <div class="my-4 mt-2">
                    <table class="w-100 main-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Products</th>
                                <th>Price</th>
                                <th>Packaging</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (json_decode($quotation->products) as $product)
                            <tr>
                                <td class="text-bold-500">{{$loop->index+1}}</td>
                                <td>
                                <div class="fw-semibold">{{$product->title}}</div>
                                <p class="m-0" style="font-size:13px">{{$product->description}}</p>
                                </td>
                                <td>{{ formatRupiah($product->price_sale) }} / {{$product->satuan}}</td>
                                <td class="text-bold-500">{{$product->packaging}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="keterangan mb-4">
                    <div>Keterangan :</div>
                    <div id="previewKeterangan">
                        {!! $quotation->keterangan !!}
                    </div>
                </div>
                <div>
                    Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
                </div>
                <div class="print-body my-4 ml-5 mr-5">
                    <div>Hormat Kami,</div>
                    <div class="">{{$getSet->get('company_name')->the_value}}</div>
                    <div class="mt-4 mb-4">&nbsp;</div>
                    <div class=""><u>{{$getSet->get('company_director')->the_value}}</u></div>
                    <div>Direktur</div>
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