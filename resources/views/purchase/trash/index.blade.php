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
                        <li class="breadcrumb-item active" aria-current="page">Deleted Purchase From Client</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Deleted Purchase from Client</h3>
                <p class="text-subtitle text-muted">Restore a Purchase Order from Client</p>
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
                                <th>No</th>
                                <th>Client</th>
                                <th>Purchased Products</th>
                                <th>Status</th>
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
                            @foreach ($purchases as $purchase)
                            <tr>
                                <td>
                                    <div style="font-size:13px">
                                        <span class="fw-bold" >{{$purchase->no}}</span><br/>
                                        {{$purchase->date}}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" style="aspect-ratio:1/1;" data-bs-toggle="modal"
                                            data-bs-target="#addressModal-{{$purchase->id}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" fill-rule="evenodd" d="M1 3a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v5h4a5 5 0 0 1 5 5v4a3 3 0 0 1-2.129 2.872a3 3 0 0 1-5.7.128H8.83a3 3 0 0 1-5.7-.128A3 3 0 0 1 1 17v-4h6a1 1 0 1 0 0-2H1V9h4a1 1 0 0 0 0-2H1zm13 15h1.171a3 3 0 0 1 5.536-.293A1 1 0 0 0 21 17v-4a3 3 0 0 0-3-3h-4zm-7 1a1 1 0 1 0-2 0a1 1 0 0 0 2 0m10.293-.707A1 1 0 0 0 17 19a1 1 0 1 0 .293-.707" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        {{-- Modal Products --}}
                                        <div class="modal fade" id="addressModal-{{$purchase->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0 ">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Purchase / Request Order Details</h5>
                                                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body border-0 py-0">
                                                        <a href="{{asset('storage/'.$purchase->po_file)}}" target="_blank" class="mb-4 bg-primary text-white p-1 px-2 rounded-3 d-flex gap-2 align-items-center justify-content-between">
                                                            <div>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 2H6a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-8h-6a3 3 0 0 1-3-3zm9 7v-.172a3 3 0 0 0-.879-2.12l-3.828-3.83A3 3 0 0 0 14.172 2H14v6a1 1 0 0 0 1 1z" clip-rule="evenodd"/></svg>
                                                            </div>
                                                            <div class="w-100" style="display: -webkit-box;
                                                                                -webkit-box-orient: vertical;
                                                                                overflow: hidden;
                                                                                white-space:nowrap;
                                                                                text-overflow: ellipsis;
                                                                                /* Tentukan jumlah baris yang diinginkan */
                                                                                -webkit-line-clamp: 1;">
                                                                Refrence : {{$purchase->po_number}}
                                                            </div>
                                                        </a>
                                                        <div>
                                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                                <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                        <path fill="currentColor" fill-rule="evenodd" d="M1 3a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v5h4a5 5 0 0 1 5 5v4a3 3 0 0 1-2.129 2.872a3 3 0 0 1-5.7.128H8.83a3 3 0 0 1-5.7-.128A3 3 0 0 1 1 17v-4h6a1 1 0 1 0 0-2H1V9h4a1 1 0 0 0 0-2H1zm13 15h1.171a3 3 0 0 1 5.536-.293A1 1 0 0 0 21 17v-4a3 3 0 0 0-3-3h-4zm-7 1a1 1 0 1 0-2 0a1 1 0 0 0 2 0m10.293-.707A1 1 0 0 0 17 19a1 1 0 1 0 .293-.707" clip-rule="evenodd" />
                                                                    </svg>
                                                                </div>
                                                                <h6 class="m-0" style="font-size: 13px">Pesanan dikirimkan ke Alamat</h6>
                                                            </div>
                                                            <div class="fw-semibold">{{$purchase->address->address_tag}}</div>
                                                            <div style="font-size:12px" class="text-muted">Address : {{$purchase->address->address}}, {{$purchase->address->city}} - {{$purchase->address->postal_code}}</div>
                                                            <div style="font-size:12px" class="text-muted">TELP / FAX : {{$purchase->address->telp}} / {{$purchase->address->fax}}</div>
                                                        </div>
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
                                            <div class="fw-semibold">
                                                @if($purchase->client)
                                                    {{ $purchase->client->trashed() ? '[Deleted] ' : '' }}{{ $purchase->client->name }}
                                                @else
                                                    <span class="text-danger">Client Not Found</span>
                                                @endif
                                            </div>
                                            <div style="font-size:12px" class="text-secondary">
                                                @if($purchase->client)
                                                    {{ $purchase->client->email }}
                                                @else
                                                    <span class="text-danger">Email Not Available</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="border-0 outline-0 bg-transparent text-primary gap-2 d-flex align-items-center justify-content-center" data-bs-toggle="modal"
                                        data-bs-target="#productModal-{{$purchase->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" fill-rule="evenodd" d="M13.5 10.421V5.475l-2 .714V8.25a.75.75 0 0 1-1.5 0V6.725l-2.25.804v6.088l4.777-1.792a1.5 1.5 0 0 0 .973-1.404m-2.254-5.734l1.6-.571a2 2 0 0 0-.175-.104L9.499 2.427a1.5 1.5 0 0 0-1.197-.063l-.941.353l3.724 1.862q.09.045.16.108M5.444 3.435l3.878 1.94l-2.273.811l-3.805-1.903q.108-.063.23-.109zm.806 4.029L2.5 5.589v5.057a1.5 1.5 0 0 0 .83 1.342l2.92 1.46zM1 5.579c0-.436.094-.856.266-1.236a.75.75 0 0 1 .2-.37c.342-.54.855-.968 1.48-1.203L7.777.96a3 3 0 0 1 2.394.125l3.172 1.586A3 3 0 0 1 15 5.354v5.067a3 3 0 0 1-1.947 2.809l-4.828 1.81a3 3 0 0 1-2.395-.125l-3.172-1.586A3 3 0 0 1 1 10.646z" clip-rule="evenodd" />
                                        </svg>
                                        <span style="white-space:nowrap">{{count($purchase->getProducts)}} Products</span>
                                    </button>
                                    {{-- Modal Address --}}
                                    <div class="modal fade" id="productModal-{{$purchase->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 ">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Purchased Products </h5>
                                                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                            <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body border-0 py-0">
                                                    @forelse ($purchase->getProducts as $product)
                                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 p-3 border rounded-3">
                                                        <div>
                                                            <h6 class="m-0">{{$product->product->title}}</h6>
                                                            <p class="m-0 text-muted" style="font-size: 13px">{{$product->product->description}}</p>
                                                        </div>
                                                        <div class="ms-md-auto text-end">
                                                            <div class="fw-bold">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }} / {{$product->product->satuan->name}}</div>
                                                            <div class="d-flex align-items-center gap-3 justify-content-md-end" style="font-size: 13px">
                                                                <div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                            <path d="m7.5 4.27l9 5.15M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                                                            <path d="m3.3 7l8.7 5l8.7-5M12 22V12" />
                                                                        </g>
                                                                    </svg>
                                                                </div>
                                                                x {{$product->qty .' '.$product->packaging->name.' @ '.$product->packaging->capacity.' Cap.'}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    Products not found for this purchase
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
                                </td>
                                <td>
                                    <span class="p-1 px-2 rounded-2 bg-light-secondary text-secondary" style="font-size:12px;white-space:nowrap">Invalid - Restore first</span>
                                </td>
                                <td style="font-size: 12px">
                                    {{$purchase->created_at}}
                                </td>

                                <td style="width: 5em">
                                    <div class="d-flex align-items-center gap-1">
                                        <button type="button" class="btn btn-sm btn-primary block" style="aspect-ratio:1/1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmRestoreModal-{{$purchase->id}}"
                                            >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9.7 10.75q.425-.45 1.025-.725T12 9.75q1.35 0 2.3.95t.95 2.3t-.95 2.3t-2.3.95q-.9 0-1.637-.45T9.2 14.625q-.15-.275-.437-.363T8.2 14.3q-.3.125-.412.438t.062.587q.6 1.1 1.7 1.763t2.45.662q1.95 0 3.35-1.4t1.4-3.35t-1.4-3.35T12 8.25q-.95 0-1.775.35t-1.475.95v-.8q0-.325-.213-.537T8 8t-.537.213t-.213.537v2.75q0 .325.213.538T8 12.25h2.75q.325 0 .538-.213t.212-.537t-.213-.537t-.537-.213zM6 22q-.825 0-1.412-.587T4 20V4q0-.825.588-1.412T6 2h7.175q.4 0 .763.15t.637.425l4.85 4.85q.275.275.425.638t.15.762V20q0 .825-.587 1.413T18 22z"/></svg>
                                        </button>

                                        {{-- Restoreing Restore Modal --}}
                                        <div class="modal fade" id="confirmRestoreModal-{{$purchase->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0 ">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Confirm Restore Purchase</h5>
                                                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body border-0 py-0">
                                                        <form action="{{route('purchase.restore', $purchase->id )}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    Apakah anda yakin ingin merestore data Purchase : {{$purchase->no}} ?
                                                                </div>
                                                            </div>
                                                            <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                                                <button type="submit" class="btn btn-primary w-100">Restore</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <a href="{{route('purchase.show.deleted', $purchase->id)}}" class="btn btn-sm btn-success block" style="aspect-ratio:1/1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                                <path fill="currentColor" d="M32 376a56 56 0 0 0 56 56h336a56 56 0 0 0 56-56V222H32Zm66-76a30 30 0 0 1 30-30h48a30 30 0 0 1 30 30v20a30 30 0 0 1-30 30h-48a30 30 0 0 1-30-30ZM424 80H88a56 56 0 0 0-56 56v26h448v-26a56 56 0 0 0-56-56" />
                                            </svg>
                                        </a>
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
        let ind = 4; // Indeks kolom untuk sorting, pastikan sesuai

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
