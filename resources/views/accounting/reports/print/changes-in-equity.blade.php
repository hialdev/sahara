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
    margin: 4cm 2cm;
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
        <a href="{{route('report.changesInEquity.download', ['start_date' => request()->get('start_date'), 'end_date' => request()->get('end_date')])}}" class="btn p-2 px-3 btn-primary rounded-pill">Download Document</a>
    </div>
</div>
<div class="container-fluid">
    <div class="book">
        <div class="page">
            <div class="subpage" id='editor-container'>
                <div class="text-center mb-3">
                    <h4 class="mb-0 text-uppercase">Laporan Perubahan Ekuitas (Statement of Changes in Equity)</h4>
                    <div class="ft-italic">Pada rentang tanggal {{ request()->get('start_date') != null ? \Carbon\Carbon::parse(request()->get('start_date'))->translatedFormat('d F Y') : '' }} hingga {{ \Carbon\Carbon::parse(request()->get('end_date'))->translatedFormat('d F Y') }}</div>
                    <hr>
                </div>
                <div class="" style="max-height: 19cm; overflow:auto !important;">
                    <table class="table rounded-4 mb-0 overflow-hidden">
                        <thead class="table-dark">
                            <tr>
                                <th style="font-size: 13px">Kode Akun</th>
                                <th style="font-size: 13px">Nama Akun</th>
                                <th style="font-size: 13px; min-width: 11em" class="text-end">Debit</th>
                                <th style="font-size: 13px; min-width: 11em" class="text-end">Kredit</th>
                                <th style="font-size: 13px; min-width: 11em" class="text-end">Perubahan Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equityChanges as $change)
                                <tr>
                                    <td style="font-size: 13px">{{ $change['account_code'] }}</td>
                                    <td style="font-size: 13px">{{ $change['account_name'] }}</td>
                                    <td style="font-size: 13px" class="text-end">{{ formatRupiah($change['debit']) }}</td>
                                    <td style="font-size: 13px" class="text-end">{{ formatRupiah($change['credit']) }}</td>
                                    <td style="font-size: 13px" class="text-end {{ $change['net_change'] < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ formatRupiah($change['net_change']) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="fw-bold" style="background-color: #f7f7f7;">
                                <td style="font-size: 13px" colspan="4" class="text-end">Total Perubahan Ekuitas</td>
                                <td style="font-size: 13px" class="text-end {{ $totalEquityChange < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ formatRupiah($totalEquityChange) }}
                                </td>
                            </tr>
                        </tbody>
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