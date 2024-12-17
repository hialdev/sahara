{{-- template/crud/index.blade.php --}}
@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/table-datatable-jquery.css">
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
                        <li class="breadcrumb-item active" aria-current="page">Account Type</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 order-md-1 order-last">
                <div class="d-flex align-items-center gap-3 justify-content-between">
                    <div>
                        <h3>Account Type</h3>
                        <p class="text-subtitle text-muted">Manage Account Type</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm mb-1 btn-primary block" 
                            data-bs-toggle="modal"
                            data-bs-target="#addCOAModal"
                            >
                            Add Account Type
                        </button>

                        {{-- Add COA Modal --}}
                        <div class="modal fade" id="addCOAModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100"
                                role="document">
                                <div class="modal-content pb-2">
                                    <div class="modal-header border-0 ">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Add New Account Type</h5>
                                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body border-0 py-0">
                                        <form action="{{route('account_type.store')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <label for="type" class="form-label">Type</label>
                                                    <select name="type" id="type" class="form-select">
                                                      <option value="">-- Pilih type --</option>
                                                      @foreach ($accountTypes as $atype)
                                                        <option value="{{$atype}}">{{$atype}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label for="code" class="form-label">Code</label>
                                                    <input type="number" class="form-control" name="code" placeholder="Code (2 digit)" maxlength="2" max="99">
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                                <button type="submit" class="btn btn-primary w-100">Tambah Account</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                              <th>Code</th>
                              <th>Name</th>
                              <th>Created_at</th>
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
                          @foreach ($types as $type)
                          <tr>
                              <td style="font-size: 13px"><div class="d-inline-block rounded-5 px-3 p-2 bg-primary text-white">{{$type->code}}</div></td>
                              <td style="font-size: 13px">{{$type->name}}</td>
                              <td style="font-size: 13px">{{$type->created_at}}</td>
                              <td style="width: 5em">
                                  @if($type->is_urgent !== 1)
                                  <div class="d-flex align-items-center gap-1">
                                      <button type="button" class="btn-edit-actype btn btn-sm btn-primary block" 
                                          style="aspect-ratio:1/1"
                                          data-id={{$type->id}}
                                          >
                                          <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                              <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                  <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                  <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                              </g>
                                          </svg>
                                      </button>
                                      <a href="{{route('account_type.setting', $type->id)}}"
                                          class="btn btn-sm btn-light-secondary block"
                                          style="aspect-ratio:1/1">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12.428 2c-1.114 0-2.129.6-4.157 1.802l-.686.406C5.555 5.41 4.542 6.011 3.985 7c-.557.99-.557 2.19-.557 4.594v.812c0 2.403 0 3.605.557 4.594s1.57 1.59 3.6 2.791l.686.407C10.299 21.399 11.314 22 12.428 22s2.128-.6 4.157-1.802l.686-.407c2.028-1.2 3.043-1.802 3.6-2.791c.557-.99.557-2.19.557-4.594v-.812c0-2.403 0-3.605-.557-4.594s-1.572-1.59-3.6-2.792l-.686-.406C14.555 2.601 13.542 2 12.428 2m-3.75 10a3.75 3.75 0 1 1 7.5 0a3.75 3.75 0 0 1-7.5 0" clip-rule="evenodd"/></svg>
                                      </a>
                                  </div>
                                  @else
                                  <span class="rounded-3 bg-light-warning p-1 px-2" style="font-size: 13px">Logical</span>
                                  @endif
                              </td>
                          </tr>
                          @endforeach
                          
                      </tbody>
                  </table>
              </div>
            </div>
        </div>
        
        {{-- Edit COA Modal --}}
        <div class="modal fade" id="editAccountTypeModal" tabindex="-1" role="dialog"
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
                        <form class="editCOAForm" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" id="type" class="form-select">
                                        <option value="">-- Pilih Account Type --</option>
                                        @foreach ($accountTypes as $atype)
                                            <option value="{{$atype}}">{{$atype}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" class="form-control code_input" name="code">
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name">
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

    </section>
    <!-- Basic Tables end -->

</div>
@endsection

@section('scripts')
<script src="/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
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

        // Saat modal edit ditampilkan
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var id = button.data('id'); // Ambil data-id dari tombol
            var name = button.data('name'); // Ambil data-title dari tombol

            // Masukkan data ke dalam form modal
            var modal = $(this);
            modal.find('input[name="name"]').val(name); // input untuk nama produk

            // Ubah action form sesuai ID produk
        });
        
        $('.btn-edit-actype').click(function(){
            let actypeId = $(this).data('id');
            setEditCoa(actypeId);
        });

        const setEditCoa = (actypeId) => {
          $.ajax({
            url: `/account-type/${actypeId}`,
            method: 'GET',
            dataType: 'json', // Pastikan respons diproses sebagai JSON
            success: (response) => {
                if (response.success) {
                    const modal = $('#editAccountTypeModal');

                    // Update modal fields
                    modal.find('span.name').text(response.data.name || '-');
                    modal.find('input[name=code]').val(response.data.code || '');
                    modal.find('input[name=name]').val(response.data.name || '');
                    modal.find('select[name=type]').val(response.data.type || '').trigger('change');
                    modal.find('form').attr('action', '/account-type/' + actypeId + '/edit');

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
