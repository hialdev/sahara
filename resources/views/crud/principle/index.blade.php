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
                        <li class="breadcrumb-item active" aria-current="page">Principle</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Principle</h3>
                <p class="text-subtitle text-muted">Manage Supplier or Principle</p>
            </div>
            <div class="col-6 order-md-2 order-1">
                <a href="{{route('principle.add')}}" class="btn btn-primary float-end">Add New</a>
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
                                <th>principle</th>
                                <th>description</th>
                                <th>PIC</th>
                                <th>created_at</th>
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
                            @foreach ($principles as $principle)
                            <tr>
                                
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" style="aspect-ratio:1/1;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addressModal-{{$principle->id}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203.21l-4.243 4.242a3 3 0 0 1-4.097.135l-.144-.135l-4.244-4.243A9 9 0 0 1 18.364 4.636M12 8a3 3 0 1 0 0 6a3 3 0 0 0 0-6" />
                                            </svg>
                                        </button>
                                        {{-- Modal Address --}}
                                        <div class="modal fade" id="addressModal-{{$principle->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0 ">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Address </h5>
                                                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body border-0 py-0">
                                                        @forelse ($principle->addresses as $address)
                                                            <div class="p-3 border rounded-3 border-2 mb-2">
                                                                <div class="rounded-2 mb-2 p-1 px-2 text-uppercase bg-primary text-white d-inline-block" style="font-size: 10px">{{$address->address_tag}}</div>
                                                                <p class="m-0 fw-semibold" style="font-size: 12px">{{$address->city.', '.$address->postal_code}}</p>
                                                                <p class="m-0" style="font-size:12px">{{$address->address}}</p>
                                                            </div>
                                                        @empty
                                                        Address not found for this Principle
                                                        @endforelse
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">OK, Close</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{$principle->name}}</div>
                                            <div style="font-size:12px" class="text-secondary">{{$principle->email}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="max-width: 10em; font-size:12px">{{$principle->description}}</td>
                                <td>
                                    <div class="fw-semibold">
                                        {{$principle->contact_name}}
                                    </div>
                                    <div style="font-size:12px" class="text-secondary">{{$principle->contact_email}}, {{$principle->contact_phone}}</div>
                                </td>
                                <td style="font-size: 12px">
                                    {{$principle->created_at}}
                                </td>

                                <td style="width: 5em">
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{route('principle.edit', $principle->id)}}" class="d-flex align-items-center justify-content-center btn btn-sm btn-outline-primary block" style="aspect-ratio:1/1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                    <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                    <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                </g>
                                            </svg>
                                        </a>
                                        
                                        <button type="button" class="btn btn-sm btn-outline-danger block" style="aspect-ratio:1/1" data-bs-toggle="modal"
                                            data-bs-target="#danger-{{$principle->id}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    {{-- Modal Delete --}}
                                    <div class="modal fade text-left" id="danger-{{$principle->id}}" tabindex="-1" role="dialog"
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
                                                    Apakah anda yakin menghapus data principle dengan id {{$principle->id}} ? data yang dihapus bersifat permanen tidak dapat dikembalikan
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Batal</span>
                                                    </button>
                                                    <form action="{{route('principle.destroy', $principle->id)}}" method="POST">
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        let ind = 3; // Indeks kolom untuk sorting, pastikan sesuai

        $('#table2').DataTable({
            responsive: true,
            order: [[ind, 'desc']], // Mengatur urutan berdasarkan kolom yang ditentukan
            fixedHeader: {
                header: true,
            },
            pagingType: 'simple',
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
    });
</script>
@endsection
