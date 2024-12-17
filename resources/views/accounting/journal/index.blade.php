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
                        <li class="breadcrumb-item active" aria-current="page">Journal Entries</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 order-md-1 order-last">
                <div class="d-flex align-items-center gap-3 justify-content-between">
                    <div>
                        <h3>Journal Entries</h3>
                        <p class="text-subtitle text-muted">Manage Journal Entries</p>
                    </div>
                    <div>
                        <a href="{{route('jurnal.add')}}" class="btn btn-sm mb-1 btn-primary block" 
                            >
                            Add Journal Entries
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                  <table class="table" id="table2">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Description</th>
                              <th style="width: 8em">Account</th>
                              <th>Name</th>
                              <th style="width: 8em">Debit</th>
                              <th style="width: 8em">Credit</th>
                              <th>
                                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
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
                          @foreach ($jurnals as $jurnal)
                          <tr>
                              <td>{{$loop->index+1}}</td>
                              <td style="font-size: 13px">{{ \Carbon\Carbon::parse($jurnal->date)->translatedFormat('d F Y') }}</td>
                              <td style="font-size: 13px">
                                <div style="font-size:10px" class="mb-1 p-1 px-2 rounded-3 bg-light-primary d-inline-block">{{$jurnal->account->no_code}}</div><br />
                                <div>{{$jurnal->account->accountType->name .' / '.$jurnal->account->account_name}}</div>
                              </td>
                              <td style="font-size: 13px">
                                <div class="d-inline-block p-1 px-2 bg-primary text-white rounded-3" style="font-size: 10px">{{$jurnal->account->no_code}}</div>
                                <div class="d-inline-block p-1 px-2 bg-light-primary rounded-3" style="font-size: 10px">{{$jurnal->account->accountType->type}}</div>
                                <div class="mt-1">{{$jurnal->account->account_name}}</div>
                              </td>
                              <td style="font-size: 13px">{{$jurnal->name}}</td>
                              <td style="font-size: 13px">{{formatRupiah($jurnal->debit)}}</td>
                              <td style="font-size: 13px">{{formatRupiah($jurnal->credit)}}</td>
                              <td style="width: 5em">
                                @if ($jurnal->is_generated !== 1)
                                    <div class="d-flex align-items-center gap-1">
                                      <button type="button" class="btn-edit-jurnal btn btn-sm btn-primary block" 
                                          style="aspect-ratio:1/1"
                                          data-id={{$jurnal->id}}
                                          >
                                          <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                              <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                  <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                  <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                              </g>
                                          </svg>
                                      </button>
                                      <button type="button" class="btn-destroy-jurnal btn btn-sm btn-outline-danger block d-flex align-items-center" data-bs-toggle="modal"
                                        style="aspect-ratio:1/1"
                                        data-id={{$jurnal->id}}
                                        data-name={{$jurnal->name}}
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                                        </svg>
                                    </button>
                                  </div>
                                @else
                                    <span class="d-flex p-1 px-2 bg-light-primary rounded-3" style="font-size: 13px">Generated</span>
                                @endif
                              </td>
                          </tr>
                          @endforeach
                          
                      </tbody>
                  </table>
              </div>
            </div>
        </div>
        
        {{-- Edit Jurnal Modal --}}
        <div class="modal fade" id="editJurnalModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100"
                role="document">
                <div class="modal-content pb-2">
                    <div class="modal-header border-0 ">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit <span class="name"></span></h5>
                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body border-0 py-0">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                              <div class="col-12">
                                <label for="date" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                                <input type="date" name="date" id="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                              </div>
                              <div class="col-12 mb-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                              </div>
                              <div class="col-12 mb-2">
                                  <label for="account_id" class="form-label">Account</label>
                                  <select name="account_id" id="account_id" class="form-select">
                                    <option value="">-- Pilih Account --</option>
                                    @foreach ($accounts as $account)
                                      <option value="{{$account->id}}">{{$account->no_code}} - {{$account->account_name}}</option>
                                    @endforeach
                                  </select>
                              </div>
                              <div class="col-12 mb-2">
                                <label for="name" class="form-label">Description</label>
                                <input type="text" name="name" class="form-control" placeholder="Transaksi Apa Ini ?" required>
                              </div>
                              <div class="col-12 mb-2">
                                <label for="debit" class="form-label">Debit</label>
                                <input type="text" name="debit" class="form-control rupiah-input" placeholder="Rp. ">
                              </div>
                              <div class="col-12 mb-2">
                                <label for="credit" class="form-label">Credit</label>
                                <input type="text" name="credit" class="form-control rupiah-input" placeholder="Rp. ">
                              </div>
                            </div>
                            <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Perbarui Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Delete --}}
        <div class="modal fade text-left" id="destroyJurnalModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <div class="modal-content rounded-4">
                    <div class="modal-header bg-danger border-0">
                        <h5 class="modal-title white" id="myModalLabel120">Confirmation Delete</h5>
                        <button type="button" class="btn btn-danger bg-danger" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="mb-1 bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body border-0">
                        Apakah anda yakin menghapus data Jurnal Entry ini <strong>( <span class="name"></span> )</strong> ?
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger ms-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ya, Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Tables end -->

</div>
@endsection

@section('scripts')
<script src="/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/dist/assets/extensions/flatpickr/flatpickr.min.js"></script>
<script src="/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        let ind = 0; 
        
        $('#table2').DataTable({
            responsive: true,
            order: [[ind, 'asc']],
            fixedHeader: {
                header: true,
            },
            pagingType: 'simple',
            pageLength: 100,
            lengthMenu: [100, 300, 500, 1000],
            dom:
                "<'row'<'col-3'l><'col-9'f>>" +
                "<'row dt-row'<'col-sm-12'tr>>" +
                "<'row'<'col-4'i><'col-8'p>>",
            language: {
                info: "Page _PAGE_ of _PAGES_",
                lengthMenu: "_MENU_ ",
                search: "",
                searchPlaceholder: "Search.."
            }
        });

        const accChoices = new Choices('#account_id', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a Account',
            removeItemButton: true
        });

        flatpickr('.flatpickr-no-config', {
          enableTime: false,
          dateFormat: "d M Y", 
          defaultDate: "today",
        })

        function formatDate(dateString) {
          let date = new Date(dateString);
          
          const monthNames = [
              "Jan", "Feb", "Mar", "Apr", "May", "Jun",
              "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
          ];
          
          let day = date.getDate();
          let month = monthNames[date.getMonth()];
          let year = date.getFullYear();

          return `${day} ${month} ${year}`;
        }

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

        $('.btn-destroy-jurnal').click(function(){
            let jurnalId = $(this).data('id');
            let jurnalName = $(this).data('name');
            const modal = $('#destroyJurnalModal')
            modal.find('span.name').text(jurnalName);
            modal.find('form').attr('action', '/jurnal/' + jurnalId + '/destroy');
            modal.modal('show');
        });

        $('.btn-edit-jurnal').click(function(){
            let jurnalId = $(this).data('id');
            setEditCoa(jurnalId);
        });

        const setEditCoa = (jurnalId) => {
          $.ajax({
            url: `/jurnal/${jurnalId}`,
            method: 'GET',
            dataType: 'json', // Pastikan respons diproses sebagai JSON
            success: (response) => {
                if (response.success) {
                    const modal = $('#editJurnalModal');
                    // Update modal fields
                    modal.find('span.name').text(response.data.name || '-');
                    document.querySelector("#date")._flatpickr.setDate(formatDate(response.data.date));
                    modal.find('textarea[name=description]').val(response.data.description || '');
                    modal.find('input[name=name]').val(response.data.name || '');
                    modal.find('input[name=debit]').val(formatRupiah(response.data.debit) || '');
                    modal.find('input[name=credit]').val(formatRupiah(response.data.credit) || '');
                    accChoices.setChoiceByValue(response.data.chart_of_account_id);
                    modal.find('form').attr('action', '/jurnal/' + jurnalId + '/edit');

                    // Show modal
                    modal.modal('show');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: `Terjadi kesalahan: ${response.error || 'Unknown error'}`
                    });
                }
            },
            error: (xhr, status, error) => {
                // Menampilkan pesan error yang lebih informatif
                const errorMessage = xhr.responseJSON?.message || error || 'Terjadi kesalahan tak terduga';
                Toast.fire({
                    icon: 'error',
                    title: `Terjadi kesalahan: ${errorMessage}`
                });
            }
          });
        }
    });
</script>
@endsection
