{{-- template/crud/index.blade.php --}}
@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="/dist/assets/extensions/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="/dist/assets/extensions/filepond/filepond.css">
    <link rel="stylesheet" href="/dist/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
    <link rel="stylesheet" href="/dist/assets/extensions/choices.js/public/assets/styles/choices.css">
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-6 col-md-12">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-start">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('jurnal.index')}}">Journal Entries</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 order-md-1 order-last">
                <div class="d-flex align-items-center gap-3 justify-content-between">
                    <div>
                        <h3>Add Journal Entries</h3>
                        <p class="text-subtitle text-muted">Add New Journal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
      <div class="card">
        <div class="card-body">
          <form action="{{route('jurnal.store')}}" method="POST">
            @csrf
            <div class="row">
              <div class="col-12">
                <label for="date" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                <input type="date" name="date" id="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
              </div>
              <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
              </div>
              <div class="col-12">
                <table class="table my-3 w-100 rounded-4">
                  <thead>
                    <tr class="p-2 bg-light-primary">
                      <th style="width: 15em">Account</th>
                      <th style="width: 20em">Description</th>
                      <th>Debit</th>
                      <th>Credit</th>
                      <th style="width: 4em">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 20 20">
                          <g fill="currentColor">
                            <circle cx="5" cy="10" r="2" />
                            <circle cx="10" cy="10" r="2" />
                            <circle cx="15" cy="10" r="2" />
                          </g>
                        </svg>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select name="account_id[]" id="account" class="form-select new-account" required>
                          <option value="">-- Pilih Account --</option>
                          @foreach ($accounts as $account)
                            <option value="{{$account->id}}">{{$account->no_code}} - {{$account->account_name}}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <input type="text" name="name[]" class="form-control" placeholder="Transaksi Apa Ini ?" required>
                      </td>
                      <td>
                        <input type="text" name="debit[]" class="form-control rupiah-input" placeholder="Rp. ">
                      </td>
                      <td>
                        <input type="text" name="credit[]" class="form-control rupiah-input" placeholder="Rp. ">
                      </td>
                      <td>
                        <button type="button" class="d-flex align-items-center btn btn-danger justify-content-center btn-sm remove-row" style="aspect-ratio:1/1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 16h6m1-6V9a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6" />
                          </svg>
                        </button>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="5">
                        <div class="d-flex align-items-center justify-content-center">
                          <button type="button" class="add-row btn btn-sm btn-primary d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 14v1a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-6m-3-3H7m0 0H4m3 0V5m0 3v3" />
                            </svg>
                            Add New Entry
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <button type="submit" class="btn btn-primary w-100">Buat Jurnal</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/dist/assets/extensions/flatpickr/flatpickr.min.js"></script>
<script src="/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function () {
    // Inisialisasi Choices.js untuk elemen pertama
    const accChoices = new Choices('#account', {
      searchEnabled: true,
      placeholder: true,
      placeholderValue: 'Select a Account',
      removeItemButton: true,
    });

    flatpickr('.flatpickr-no-config', {
      enableTime: false,
      dateFormat: "d M Y", 
      defaultDate: "today",
    })

    function formatRupiah(angka) {
      let number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
      return 'Rp ' + rupiah;
    }

    // Format input Rupiah
    $(document).on('keyup', '.rupiah-input', function () {
      let value = $(this).val().replace(/[^,\d]/g, '').toString();
      let rp = formatRupiah(value);
      $(this).val(rp);
    });

    // Tambahkan baris baru
    $(document).on('click', '.add-row', function () {
      let newRow = `
        <tr>
          <td>
            <select name="account_id[]" class="form-select new-account">
              <option value="">-- Pilih Account --</option>
              @foreach ($accounts as $account)
                <option value="{{$account->id}}">{{$account->no_code}} - {{$account->account_name}}</option>
              @endforeach
            </select>
          </td>
          <td>
            <input type="text" name="name[]" class="form-control" placeholder="Transaksi Apa Ini ?" required>
          </td>
          <td>
            <input type="text" name="debit[]" class="form-control rupiah-input" placeholder="Rp. ">
          </td>
          <td>
            <input type="text" name="credit[]" class="form-control rupiah-input" placeholder="Rp. ">
          </td>
          <td>
            <button type="button" class="d-flex align-items-center btn btn-danger justify-content-center btn-sm remove-row" style="aspect-ratio:1/1">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 16h6m1-6V9a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6" />
              </svg>
            </button>
          </td>
        </tr>`;
      
      // Tambahkan baris baru sebelum baris terakhir
      $(this).closest('table').find('tbody tr:last').before(newRow);

      // Inisialisasi Choices.js pada elemen baru
      $('.new-account').each(function () {
        new Choices(this, {
          searchEnabled: true,
          placeholder: true,
          placeholderValue: 'Select a Account',
          removeItemButton: true,
        });
        // Hapus kelas setelah inisialisasi untuk menghindari duplikasi
        $(this).removeClass('new-account');
      });
    });

    // Hapus baris
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
    });
  });
</script>

@endsection
