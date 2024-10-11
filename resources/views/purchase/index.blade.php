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
                        <li class="breadcrumb-item active" aria-current="page">Purchase</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Purchase</h3>
                <p class="text-subtitle text-muted">Create a Purchase Order from Client, assign quotation too (if already)</p>
            </div>
            <div class="col-6 order-md-2 order-1">
                <a href="{{route('purchase.add')}}" class="btn btn-primary float-end">Add New</a>
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
                                <th>Offering products</th>
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
                                                <path fill="currentColor" d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203.21l-4.243 4.242a3 3 0 0 1-4.097.135l-.144-.135l-4.244-4.243A9 9 0 0 1 18.364 4.636M12 8a3 3 0 1 0 0 6a3 3 0 0 0 0-6" />
                                            </svg>
                                        </button>
                                        {{-- Modal Address --}}
                                        <div class="modal fade" id="addressModal-{{$purchase->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0 ">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Client Address </h5>
                                                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body border-0 py-0">
                                                        @forelse ($purchase->client->addresses as $address)
                                                            <div class="p-3 border rounded-3 border-2 mb-2">
                                                                <div class="rounded-2 mb-2 p-1 px-2 text-uppercase bg-primary text-white d-inline-block" style="font-size: 10px">{{$address->address_tag}}</div>
                                                                <p class="m-0 fw-semibold" style="font-size: 12px">{{$address->city.', '.$address->postal_code}}</p>
                                                                <p class="m-0" style="font-size:12px">{{$address->address}}</p>
                                                            </div>
                                                        @empty
                                                        Address not found for this purchase
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
                                            <div class="fw-semibold">{{$purchase->client->name}}</div>
                                            <div style="font-size:12px" class="text-secondary">{{$purchase->client->email}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="border-0 outline-0 bg-transparent text-primary gap-2 d-flex align-items-center justify-content-center" data-bs-toggle="modal"
                                        data-bs-target="#productModal-{{$purchase->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" fill-rule="evenodd" d="M13.5 10.421V5.475l-2 .714V8.25a.75.75 0 0 1-1.5 0V6.725l-2.25.804v6.088l4.777-1.792a1.5 1.5 0 0 0 .973-1.404m-2.254-5.734l1.6-.571a2 2 0 0 0-.175-.104L9.499 2.427a1.5 1.5 0 0 0-1.197-.063l-.941.353l3.724 1.862q.09.045.16.108M5.444 3.435l3.878 1.94l-2.273.811l-3.805-1.903q.108-.063.23-.109zm.806 4.029L2.5 5.589v5.057a1.5 1.5 0 0 0 .83 1.342l2.92 1.46zM1 5.579c0-.436.094-.856.266-1.236a.75.75 0 0 1 .2-.37c.342-.54.855-.968 1.48-1.203L7.777.96a3 3 0 0 1 2.394.125l3.172 1.586A3 3 0 0 1 15 5.354v5.067a3 3 0 0 1-1.947 2.809l-4.828 1.81a3 3 0 0 1-2.395-.125l-3.172-1.586A3 3 0 0 1 1 10.646z" clip-rule="evenodd" />
                                        </svg>
                                        <span style="white-space:nowrap">{{count(json_decode($purchase->products))}} Products</span>
                                    </button>
                                    {{-- Modal Address --}}
                                    <div class="modal fade" id="productModal-{{$purchase->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 ">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Offering Prducts </h5>
                                                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                            <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body border-0 py-0">
                                                    @forelse (json_decode($purchase->products) as $product)
                                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 p-3 border rounded-3">
                                                        <div>
                                                            <h6 class="m-0">{{$product->title}}</h6>
                                                            <p class="m-0 text-muted" style="font-size: 13px">{{$product->description}}</p>
                                                        </div>
                                                        <div class="ms-md-auto text-end">
                                                            <div class="fw-bold">{{ 'Rp ' . number_format($product->price_sale, 0, ',', '.') }} / {{$product->satuan}}</div>
                                                            <div class="d-flex align-items-center gap-3 justify-content-md-end" style="font-size: 13px">
                                                                <div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                            <path d="m7.5 4.27l9 5.15M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                                                            <path d="m3.3 7l8.7 5l8.7-5M12 22V12" />
                                                                        </g>
                                                                    </svg>
                                                                </div>
                                                                {{$product->packaging}}
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
                                    @if ($purchase->status == 0)
                                    <span class="p-1 px-2 rounded-2 bg-primary text-white" style="font-size:12px">Offering</span>
                                    @elseif ($purchase->status == 1)
                                    <span class="p-1 px-2 rounded-2 bg-success text-white" style="font-size:12px">Purchased</span>
                                    @elseif ($purchase->status == 2)
                                        <span class="p-1 px-2 rounded-2 bg-lihgt-secondary text-white" style="font-size:12px">Offering</span>
                                    @endif
                                </td>
                                <td style="font-size: 12px">
                                    {{$purchase->created_at}}
                                </td>

                                <td style="width: 5em">
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{route('purchase.edit', $purchase->id)}}" class="d-flex align-items-center justify-content-center btn btn-sm btn-outline-primary block" style="aspect-ratio:1/1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                    <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                    <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                </g>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{route('purchase.add', ['purchase' => $purchase->id])}}" class="btn btn-sm btn-success block" style="aspect-ratio:1/1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                                <path fill="currentColor" d="M32 376a56 56 0 0 0 56 56h336a56 56 0 0 0 56-56V222H32Zm66-76a30 30 0 0 1 30-30h48a30 30 0 0 1 30 30v20a30 30 0 0 1-30 30h-48a30 30 0 0 1-30-30ZM424 80H88a56 56 0 0 0-56 56v26h448v-26a56 56 0 0 0-56-56" />
                                            </svg>
                                        </a>
                                        <a href="{{route('purchase.print', $purchase->id)}}" class="btn btn-sm btn-danger block" style="aspect-ratio:1/1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1m4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2z" clip-rule="evenodd" />
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
