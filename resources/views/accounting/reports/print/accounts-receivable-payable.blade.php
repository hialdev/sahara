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
        <a href="{{route('report.accountsReceivableAndPayable.download', ['start_date' => request()->get('start_date'), 'end_date' => request()->get('end_date')])}}" class="btn p-2 px-3 btn-primary rounded-pill">Download Document</a>
    </div>
</div>
<div class="container-fluid">
    <div class="book">
    
        <div class="page">
            <div class="subpage" id='editor-container'>
                <div class="text-center mb-3">
                    <h4 class="mb-0 text-uppercase">Laporan Hutang Piutang (Receivable & Payable)</h4>
                    <div class="ft-italic">Pada rentang tanggal {{ request()->get('start_date') != null ? \Carbon\Carbon::parse(request()->get('start_date'))->translatedFormat('d F Y') : '' }} hingga {{ \Carbon\Carbon::parse(request()->get('end_date'))->translatedFormat('d F Y') }}</div>
                    <hr>
                </div>
                <div class="" style="max-height: 19cm; overflow:auto !important;">
                    <!-- Receivable -->
                    <div class="mb-2">
                        <h5>Receivable</h5>
                        <table class="table overflow-hidden rounded-4">
                      <thead>
                          <tr class="bg-light-primary">
                              <th style="font-size: 13px; padding: 10px 5px">Tanggal</th>
                              <th style="font-size: 13px; padding: 10px 5px">Account</th>
                              <th style="font-size: 13px; padding: 10px 5px">Keterangan</th>
                              <th style="font-size: 13px; padding: 10px 5px; width:11em">Debit</th>
                              <th style="font-size: 13px; padding: 10px 5px; width:11em">Credit</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($receivables as $entry)
                              <tr>
                                  <td style="font-size: 13px; padding: 10px 5px">{{ $entry->date }}</td>
                                  <td style="font-size: 13px; padding: 10px 5px; "><div class="me-2 d-inline-block mb-1 p-1 px-2 bg-light-primary rounded-3" style="font-size: 10px;">{{$entry->account->no_code}}</div>{{ $entry->account->parent()->account_name .' / '. $entry->account->account_name }}</td>
                                  <td style="font-size: 13px; padding: 10px 5px">{{ $entry->name ?? $entry->description }}</td>
                                  <td style="font-size: 13px; padding: 10px 5px">{{ formatRupiah($entry->debit) }}</td>
                                  <td style="font-size: 13px; padding: 10px 5px">{{ formatRupiah($entry->credit) }}</td>
                              </tr>
                          @endforeach
                          <tr>
                            <td style="font-size: 13px; padding: 10px 5px; background: #f7f7f7" colspan="3">Total</td>
                            <td style="font-size: 13px; padding: 10px 5px; background: #ffdede">{{formatRupiah($receivables->sum('debit'))}}</td>
                            <td style="font-size: 13px; padding: 10px 5px; background: #ddffe5">{{formatRupiah($receivables->sum('credit'))}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payable -->
                    <div class="mb-2">
                        <h5>Payable</h5>
                        <table class="table overflow-hidden rounded-4">
                      <thead>
                          <tr class="bg-light-primary">
                              <th style="font-size: 13px; padding: 10px 5px">Tanggal</th>
                              <th style="font-size: 13px; padding: 10px 5px">Account</th>
                              <th style="font-size: 13px; padding: 10px 5px">Keterangan</th>
                              <th style="font-size: 13px; padding: 10px 5px; width: 11em">Debit</th>
                              <th style="font-size: 13px; padding: 10px 5px; width: 11em">Credit</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($payables as $entry)
                              <tr>
                                  <td style="font-size: 13px; padding: 10px 5px">{{ $entry->date }}</td>
                                  <td style="font-size: 13px; padding: 10px 5px; "><div class="me-2 d-inline-block mb-1 p-1 px-2 bg-light-primary rounded-3" style="font-size: 10px;">{{$entry->account->no_code}}</div>{{ $entry->account->parent()->account_name .' / '. $entry->account->account_name }}</td>
                                  <td style="font-size: 13px; padding: 10px 5px">{{ $entry->name ?? $entry->description }}</td>
                                  <td style="font-size: 13px; padding: 10px 5px">{{ formatRupiah($entry->debit) }}</td>
                                  <td style="font-size: 13px; padding: 10px 5px">{{ formatRupiah($entry->credit) }}</td>
                              </tr>
                          @endforeach
                          <tr>
                            <td style="font-size: 13px; padding: 10px 5px; background: #f7f7f7" colspan="3">Total</td>
                            <td style="font-size: 13px; padding: 10px 5px; background: #ddffe5">{{formatRupiah($payables->sum('debit'))}}</td>
                                <td style="font-size: 13px; padding: 10px 5px; background: #ffdede">{{formatRupiah($payables->sum('credit'))}}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
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