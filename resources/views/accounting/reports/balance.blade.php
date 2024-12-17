@extends('layouts.app')

@section('content')
<div class="page-heading">
  <div class="page-title">
    <div class="row align-items-center">
        <div class="col-6 col-md-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Neraca (Balance Sheet)</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 order-md-1">
            <div class="d-flex align-items-center gap-3 justify-content-between">
                <div>
                    <h3>Laporan Neraca (Balance Sheet)</h3>
                    <p class="text-subtitle text-muted">Manage Laporan Neraca (Balance Sheet)</p>
                </div>
                <div>
                    <a href="{{route('report.balance.print', ['start_date' => request()->get('start_date'), 'end_date' => request()->get('end_date') ])}}" class="btn btn-sm mb-1 d-flex align-items-center gap-2 btn-danger block" 
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 32 32">
                          <path fill="currentColor" d="M9 16a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5zm1.5 3H10v-1h.5a.5.5 0 0 1 0 1m3.5-2a1 1 0 0 1 1-1h.5a3.5 3.5 0 1 1 0 7H15a1 1 0 0 1-1-1zm2 3.915a1.5 1.5 0 0 0 0-2.83zM20 22v-5a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2h-2v1h2a1 1 0 1 1 0 2h-2v1a1 1 0 1 1-2 0M17 9V2H8a3 3 0 0 0-3 3v8a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2v1a3 3 0 0 0 3 3h16a3 3 0 0 0 3-3v-1a2 2 0 0 0 2-2v-9a2 2 0 0 0-2-2v-1h-7a3 3 0 0 1-3-3m10 6v9H5v-9zm-8-6V2.117a3 3 0 0 1 1.293.762l5.828 5.828A3 3 0 0 1 26.883 10H20a1 1 0 0 1-1-1" />
                        </svg>
                        Cetak
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 order-last">
          @include('partials.accounting.date-range')
        </div>
    </div>
  </div>

  <section class="section">
      <div class="row">
        <!-- Assets -->
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5>Assets</h5>
                <table class="table rounded-4 overflow-hidden">
                    <tr class="bg-light-primary">
                      <th style="font-size: 13px">Tanggal</th>
                      <th style="font-size: 13px">Account</th>
                      <th style="font-size: 13px">Description</th>
                      <th style="font-size: 13px; width: 11em">Amount</th>
                    </tr>
                    @foreach ($assets['entries'] as $entry)
                        <tr class="">
                            <td style="font-size: 13px; width:10em">{{$entry->date}}</td>
                            <td style="font-size: 13px; "><div class="me-2 d-inline-block mb-1 p-1 px-2 bg-light-primary rounded-3" style="font-size: 10px;">{{$entry->account->no_code}}</div>{{ ($entry->account->is_parent == 1 ? '' : $entry->account->parent()->account_name.' / ').$entry->account->account_name }}</td>
                            <td style="font-size: 13px">{{ $entry->name }}</td>
                            <td style="font-size: 13px; background-color:{{($entry->debit - $entry->credit) > 0 ? '#ddffe5' : '#ffdede'}}">{{ formatRupiah($entry->debit - $entry->credit) }}</td>
                        </tr>
                    @endforeach
                    <tr class="mt-3" style="background-color: #f7f7f7">
                      <td style="font-size: 13px" colspan="3">Total Assets</td> 
                      <td style="font-size: 13px; background-color: {{$assets['balance'] < 0 ? '#ffdede' : '#ddffe5'}}">{{ formatRupiah($assets['balance']) }}</td>
                    </tr>
                </table>
              </div>
            </div>
        </div>

        <!-- Liabilities -->
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5>Liabilities</h5>
                <table class="table rounded-4 overflow-hidden">
                    <tr class="bg-light-primary">
                      <th style="font-size: 13px">Tanggal</th>
                      <th style="font-size: 13px">Account</th>
                      <th style="font-size: 13px">Description</th>
                      <th style="font-size: 13px; width: 11em">Amount</th>
                    </tr>
                    @foreach ($liabilities['entries'] as $entry)
                        <tr class="">
                            <td style="font-size: 13px; width:10em">{{$entry->date}}</td>
                            <td style="font-size: 13px; "><div class="me-2 d-inline-block mb-1 p-1 px-2 bg-light-primary rounded-3" style="font-size: 10px;">{{$entry->account->no_code}}</div>{{ ($entry->account->is_parent == 1 ? '' : $entry->account->parent()->account_name.' / ').$entry->account->account_name }}</td>
                            <td style="font-size: 13px">{{ $entry->name ?? $entry->account->account_name }}</td>
                            <td style="font-size: 13px; background-color:{{($entry->debit - $entry->credit) > 0 ? '#ddffe5' : '#ffdede'}}">{{ formatRupiah($entry->debit - $entry->credit) }}</td>
                        </tr>
                    @endforeach
                    <tr class="mt-3" style="background-color: #f7f7f7">
                      <td style="font-size: 13px" colspan="3">Total Liabilities</td> 
                      <td style="font-size: 13px; background-color: {{$liabilities['balance'] < 0 ? '#ffdede' : '#ddffe5'}}">{{ formatRupiah($liabilities['balance']) }}</td>
                    </tr>
                </table>
              </div>
            </div>
        </div>

        <!-- Equity -->
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5>Equity</h5>
                <table class="table rounded-4 overflow-hidden">
                    <tr class="bg-light-primary">
                      <th style="font-size: 13px">Tanggal</th>
                      <th style="font-size: 13px">Account</th>
                      <th style="font-size: 13px">Description</th>
                      <th style="font-size: 13px; width: 11em">Amount</th>
                    </tr>
                    @foreach ($equity['entries'] as $entry)
                        <tr class="">
                            <td style="font-size: 13px; width:10em">{{$entry->date}}</td>
                            <td style="font-size: 13px; "><div class="me-2 d-inline-block mb-1 p-1 px-2 bg-light-primary rounded-3" style="font-size: 10px;">{{$entry->account->no_code}}</div>{{ ($entry->account->is_parent == 1 ? '' : $entry->account->parent()->account_name.' / ').$entry->account->account_name }}</td>
                            <td style="font-size: 13px">{{ $entry->name}}</td>
                            <td style="font-size: 13px; background-color:{{($entry->debit - $entry->credit) > 0 ? '#ddffe5' : '#ffdede'}}">{{ formatRupiah($entry->debit - $entry->credit) }}</td>
                        </tr>
                    @endforeach
                    <tr class="mt-3" style="background-color: #f7f7f7">
                      <td style="font-size: 13px" colspan="3">Total Equity</td> 
                      <td style="font-size: 13px; background-color: {{$equity['balance'] < 0 ? '#ffdede' : '#ddffe5'}}">{{ formatRupiah($equity['balance']) }}</td>
                    </tr>
                </table>
              </div>
            </div>
        </div>
      </div>
  </section>
</div>
@endsection
