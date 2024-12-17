@extends('layouts.app')

@section('content')
<div class="page-heading">
  <div class="page-title">
    <div class="row align-items-center">
        <div class="col-6 col-md-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Laba Rugi (Income Statement)</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 order-md-1">
            <div class="d-flex align-items-center gap-3 justify-content-between">
                <div>
                    <h3>Laporan Laba Rugi (Income Statement)</h3>
                    <p class="text-subtitle text-muted">Manage Laporan Laba Rugi (Income Statement)</p>
                </div>
                <div>
                    <a href="{{route('report.incomeStatement.print', ['start_date' => request()->get('start_date'), 'end_date' => request()->get('end_date') ])}}" class="btn btn-sm mb-1 d-flex align-items-center gap-2 btn-danger block" 
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
        <!-- revenue -->
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5>Pendapatan (Revenue)</h5>
                <table class="table rounded-4 overflow-hidden">
                  <tr class="bg-light-primary">
                    <th style="font-size: 13px; padding:10px 5px">Tanggal</th>
                    <th style="font-size: 13px; padding:10px 5px">Account</th>
                    <th style="font-size: 13px; padding:10px 5px">Description</th>
                    <th style="font-size: 13px; width: 11em">Amount</th>
                  </tr>
                  @foreach ($revenue['entries'] as $entry)
                      <tr class="">
                          <td style="font-size: 13px; padding:10px 5px; width:10em">{{$entry->date}}</td>
                          <td style="font-size: 13px; padding:10px 5px; "><div class="me-2 d-inline-block p-1 px-2 bg-light-primary rounded-3" style="font-size: 10px;">{{$entry->account->no_code}}</div>{{ ($entry->account->is_parent == 1 ? '' : $entry->account->parent()->account_name.' / ').$entry->account->account_name }}</td>
                          <td style="font-size: 13px">{{ $entry->name }}</td>
                          <td style="font-size: 13px; background-color:{{($entry->credit - $entry->debit) > 0 ? '#ddffe5' : '#ffdede'}}">{{ formatRupiah($entry->credit - $entry->debit) }}</td>
                      </tr>
                  @endforeach
                  <tr class="mt-3" style="background-color: #f7f7f7">
                    <td style="font-size: 13px" colspan="3">Total Revenue</td> 
                    <td style="font-size: 13px; background-color: {{$revenue['total_credit'] <= 0 ? '#ffdede' : '#ddffe5'}}">{{ formatRupiah($revenue['total_credit']) }}</td>
                  </tr>
                </table>
              </div>
            </div>
        </div>

        <!-- expense -->
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5>Expense</h5>
                <table class="table rounded-4 overflow-hidden">
                  <tr class="bg-light-primary">
                    <th style="font-size: 13px">Tanggal</th>
                    <th style="font-size: 13px">Account</th>
                    <th style="font-size: 13px">Description</th>
                    <th style="font-size: 13px; width: 11em">Amount</th>
                  </tr>
                  @foreach ($expense['entries'] as $entry)
                      <tr class="">
                          <td style="font-size: 13px; padding:10px 5px; width:10em">{{$entry->date}}</td>
                          <td style="font-size: 13px; padding:10px 5px; "><div class="me-2 d-inline-block p-1 px-2 bg-light-primary rounded-3" style="font-size: 10px;">{{$entry->account->no_code}}</div>{{ ($entry->account->is_parent == 1 ? '' : $entry->account->parent()->account_name.' / ').$entry->account->account_name }}</td>
                          <td style="font-size: 13px">{{ $entry->name }}</td>
                          <td style="font-size: 13px; background-color:{{($entry->debit - $entry->credit) > 0 ? '#ddffe5' : '#ffdede'}}">{{ formatRupiah($entry->debit - $entry->credit) }}</td>
                      </tr>
                  @endforeach
                  <tr class="mt-3" style="background-color: #f7f7f7">
                    <td style="font-size: 13px" colspan="3">Total Expense</td> 
                    <td style="font-size: 13px; background-color: {{$expense['total_debit'] <= 0 ? '#ffdede' : '#ddffe5'}}">{{ formatRupiah($expense['total_debit']) }}</td>
                  </tr>
                </table>
              </div>
            </div>
        </div>

        <div class="col-12">
          <h6 class="bg-primary text-white rounded-2 p-1 px-2 d-inline-block">Net Income</h6>
          <h5>{{ formatRupiah($netIncome) }}</h5>
        </div>
    </div>
  </section>
</div>
@endsection
