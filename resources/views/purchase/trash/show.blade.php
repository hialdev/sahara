@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="/dist/assets/extensions/filepond/filepond.css">
<link rel="stylesheet" href="/dist/assets/compiled/css/filepond-pdf-preview.css">
<link rel="stylesheet" href="/dist/assets/extensions/flatpickr/flatpickr.min.css">
<link rel="stylesheet" href="/dist/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
<link rel="stylesheet" href="/dist/assets/extensions/choices.js/public/assets/styles/choices.css">
@endsection
@section('content')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-start mb-2">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('purchase.index.deleted')}}">Deleted Purchase</a></li>
        <li class="breadcrumb-item active" aria-current="page">[Deleted] {{$po->no}}</li>
    </ol>
</nav>
<div class=" pb-3 px-0 d-flex flex-wrap align-items-center gap-4">
    <div class="mb-2">
        <h5 class="fs-5 flex-1">[Deleted] Purchase Number</h5>
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex gap-2 text-white bg-primary p-1 px-2 rounded-3 align-items-center" style="font-size: 0.8rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 12 12">
                    <path fill="currentColor" d="M6 1a2 2 0 1 0 0 4a2 2 0 0 0 0-4m2.5 5h-5A1.5 1.5 0 0 0 2 7.5c0 1.116.459 2.01 1.212 2.615C3.953 10.71 4.947 11 6 11s2.047-.29 2.788-.885C9.54 9.51 10 8.616 10 7.5A1.5 1.5 0 0 0 8.5 6" />
                </svg>
                {{$po->no}}
            </div>
            <div class="d-flex gap-2 text-white bg-success p-1 px-2 rounded-3 align-items-center" style="font-size: 0.8rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20.68 7.014a3.85 3.85 0 0 0-.92-1.22l-3-2.72a4.15 4.15 0 0 0-2.39-1.07H8.21A5 5 0 0 0 3 6.864v10.3a5 5 0 0 0 3.31 4.53a4.7 4.7 0 0 0 1.92.3h7.56a5 5 0 0 0 5.21-4.86v-8.57a3.75 3.75 0 0 0-.32-1.55m-13-.4h3.26a1 1 0 0 1 0 2H7.68a1 1 0 1 1 0-2m8.7 10.71h-8.7a1 1 0 1 1 0-2h8.7a1 1 0 0 1 0 1.98zm0-4.35h-8.7a1 1 0 1 1 0-2h8.7a1 1 0 1 1 0 2m-.32-5.57a1.08 1.08 0 0 1-1.09-1.08v-2.65c.66.16 3.23 2.8 3.79 3.24a2 2 0 0 1 .42.49z" />
                </svg>
                {{$po->po_number}}
            </div>
        </div>
    </div>

    <div class="ms-auto d-flex align-items-center gap-2">
        <a href="{{asset('storage/'.$po->po_file)}}" target="_blank" title="PO / Request Order FIle Refrence" class="btn btn-sm btn-danger ms-auto d-flex align-items-center justify-content-center" style="aspect-ratio:1/1">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1m4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2z" clip-rule="evenodd" />
            </svg>
        </a>

        <button type="button" class="btn btn-sm btn-primary block d-flex align-items-center gap-2 p-2 px-2.5"
            data-bs-toggle="modal"
            data-bs-target="#confirmRestoreModal-{{$po->id}}"
            >
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9.7 10.75q.425-.45 1.025-.725T12 9.75q1.35 0 2.3.95t.95 2.3t-.95 2.3t-2.3.95q-.9 0-1.637-.45T9.2 14.625q-.15-.275-.437-.363T8.2 14.3q-.3.125-.412.438t.062.587q.6 1.1 1.7 1.763t2.45.662q1.95 0 3.35-1.4t1.4-3.35t-1.4-3.35T12 8.25q-.95 0-1.775.35t-1.475.95v-.8q0-.325-.213-.537T8 8t-.537.213t-.213.537v2.75q0 .325.213.538T8 12.25h2.75q.325 0 .538-.213t.212-.537t-.213-.537t-.537-.213zM6 22q-.825 0-1.412-.587T4 20V4q0-.825.588-1.412T6 2h7.175q.4 0 .763.15t.637.425l4.85 4.85q.275.275.425.638t.15.762V20q0 .825-.587 1.413T18 22z"/></svg>
            Re-store
        </button>

        {{-- Restoreing Restore Modal --}}
        <div class="modal fade" id="confirmRestoreModal-{{$po->id}}" tabindex="-1" role="dialog"
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
                        <form action="{{route('purchase.restore', $po->id )}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    Apakah anda yakin ingin merestore data Purchase : <strong>{{$po->no}}</strong> ? Seluruh data terkait akan di re-store juga
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

        <button type="button" class="ms-auto btn btn-sm btn-light-danger p-2 px-2.5 d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#danger-{{$po->id}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
            </svg>
            Hapus
        </button>
        {{-- Modal Delete --}}
        <div class="modal fade text-left" id="danger-{{$po->id}}" tabindex="-1" role="dialog"
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
                        Apakah anda yakin menghapus data Quotation dengan nomor <span class="fw-bold">{{$po->no}}</span> untuk client <span class="fw-bold">{{$po->client->name}}</span> ? Data akan di hapus secara permanen beserta data Process PO terkait
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="{{route('purchase.destroy.deleted', $po->id)}}" method="POST">
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
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="fw-semibold">{{$po->client?->name}}</div>
                <div style="font-size:12px" class="text-muted">NPWP : {{$po->client?->npwp}}</div>
                <div style="font-size:12px" class="text-muted">{{$po->client?->email}}</div>
                <div class="d-flex align-items-center gap-3 my-3">
                    <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M6 17c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1H6m9-9a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3a3 3 0 0 1 3 3M3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2" />
                        </svg>
                    </div>
                    <h6 class="m-0" style="font-size: 13px">PIC Contact</h6>
                </div>
                <div class="fw-semibold">
                    {{$po->client?->contact_name}}
                </div>
                <div style="font-size:12px" class="text-muted">{{$po->client?->contact_email}}, {{$po->client?->contact_phone}}</div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd" d="M1 3a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v5h4a5 5 0 0 1 5 5v4a3 3 0 0 1-2.129 2.872a3 3 0 0 1-5.7.128H8.83a3 3 0 0 1-5.7-.128A3 3 0 0 1 1 17v-4h6a1 1 0 1 0 0-2H1V9h4a1 1 0 0 0 0-2H1zm13 15h1.171a3 3 0 0 1 5.536-.293A1 1 0 0 0 21 17v-4a3 3 0 0 0-3-3h-4zm-7 1a1 1 0 1 0-2 0a1 1 0 0 0 2 0m10.293-.707A1 1 0 0 0 17 19a1 1 0 1 0 .293-.707" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h6 class="m-0" style="font-size: 13px">Kirim Ke</h6>
                </div>
                <div class="fw-semibold">{{$po->address->address_tag}}</div>
                <div style="font-size:12px" class="text-muted">Address : {{$po->address->address}}, {{$po->address->city}} - {{$po->address->postal_code}}</div>
                <div style="font-size:12px" class="text-muted">TELP / FAX : {{$po->address->telp}} / {{$po->address->fax}}</div>
                <button type="button" class="border-0 mt-4 outline-0 bg-transparent text-primary gap-2 d-flex align-items-center justify-content-center" data-bs-toggle="modal"
                    data-bs-target="#productModal-{{$po->id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                        <path fill="currentColor" fill-rule="evenodd" d="M13.5 10.421V5.475l-2 .714V8.25a.75.75 0 0 1-1.5 0V6.725l-2.25.804v6.088l4.777-1.792a1.5 1.5 0 0 0 .973-1.404m-2.254-5.734l1.6-.571a2 2 0 0 0-.175-.104L9.499 2.427a1.5 1.5 0 0 0-1.197-.063l-.941.353l3.724 1.862q.09.045.16.108M5.444 3.435l3.878 1.94l-2.273.811l-3.805-1.903q.108-.063.23-.109zm.806 4.029L2.5 5.589v5.057a1.5 1.5 0 0 0 .83 1.342l2.92 1.46zM1 5.579c0-.436.094-.856.266-1.236a.75.75 0 0 1 .2-.37c.342-.54.855-.968 1.48-1.203L7.777.96a3 3 0 0 1 2.394.125l3.172 1.586A3 3 0 0 1 15 5.354v5.067a3 3 0 0 1-1.947 2.809l-4.828 1.81a3 3 0 0 1-2.395-.125l-3.172-1.586A3 3 0 0 1 1 10.646z" clip-rule="evenodd" />
                    </svg>
                    <span style="white-space:nowrap">{{count($po->getProducts)}} Products</span>
                </button>
                {{-- Modal Address --}}
                <div class="modal fade" id="productModal-{{$po->id}}" tabindex="-1" role="dialog"
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
                                @forelse ($po->getProducts as $product)
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
            </div>
        </div>
        <div class="accordion accordion-flush" id="accordionStatus">
            <div class="accordion-item">
                <div class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed rounded-3 border" type="button" data-bs-toggle="collapse" data-bs-target="#flush-status" aria-expanded="false" aria-controls="flush-status">
                        Lihat Status Pemrosesan {{count($statusProducts)}} Products (Invalid - Restore First)
                    </button>
                </div>
                <div id="flush-status" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionStatus">
                    <div class="p-3">
                        @forelse($statusProducts as $stprod)
                        <div class="row border-bottom mb-3">
                            <div class="col-md-4">
                                <h6 class="m-0">{{$stprod->product->title}}</h6>
                                <p style="font-size:13px">{{$stprod->product->description}}</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="m-0">{{$stprod->qty ?? 0}} {{$stprod->packaging->name}}</h6>
                                <span style="font-size:13px">pkg dipesan</span>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                        <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-success text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M6 3q-.75 0-1.2.6L3.5 5.2c-.3.4-.5.8-.5 1.3V19c0 1.1.9 2 2 2h8.3c-.2-.6-.3-1.3-.3-2c0-3.3 2.7-6 6-6c.7 0 1.4.1 2 .3V6.5c0-.5-.2-.9-.5-1.3l-1.4-1.7c-.2-.3-.6-.5-1.1-.5zm-.1 1h12l.9 1H5.1zM6 15h6v3H6zm15.3.8l-3.6 3.6l-1.6-1.6L15 19l2.8 3l4.8-4.8z" />
                                            </svg>
                                        </div>
                                        {{$stprod->done_qty}}
                                    </div>
                                    <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                        <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-primary text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M12 6a1 1 0 0 0-.993.883L11 7v5l.009.131a1 1 0 0 0 .197.477l.087.1l3 3l.094.082a1 1 0 0 0 1.226 0l.094-.083l.083-.094a1 1 0 0 0 0-1.226l-.083-.094L13 11.585V7l-.007-.117A1 1 0 0 0 12 6"/></svg>
                                        </div>
                                        {{$stprod->waiting_qty}}
                                    </div>
                                    <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                        <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-warning text-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M3 4a2 2 0 0 0-2 2v11h2a3 3 0 0 0 3 3a3 3 0 0 0 3-3h6a3 3 0 0 0 3 3a3 3 0 0 0 3-3h2v-5l-3-4h-3V4m-7 2l4 4l-4 4v-3H4V9h6m7 .5h2.5l1.97 2.5H17M6 15.5A1.5 1.5 0 0 1 7.5 17A1.5 1.5 0 0 1 6 18.5A1.5 1.5 0 0 1 4.5 17A1.5 1.5 0 0 1 6 15.5m12 0a1.5 1.5 0 0 1 1.5 1.5a1.5 1.5 0 0 1-1.5 1.5a1.5 1.5 0 0 1-1.5-1.5a1.5 1.5 0 0 1 1.5-1.5" />
                                            </svg>
                                        </div>
                                        {{$stprod->on_process_qty}}
                                    </div>
                                    <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                        <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-danger text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                                <path fill="currentColor" d="m4.036 2.488l6.611 2.833L8 6.455L1.427 3.638c.148-.151.329-.273.535-.352zm1.338-.514l1.55-.596a3 3 0 0 1 2.153 0l4.962 1.908c.205.08.386.2.534.352l-2.656 1.138zm9.62 2.572L8.5 7.329v7.45q.295-.05.577-.158l4.962-1.909a1.5 1.5 0 0 0 .961-1.4V4.686q0-.07-.007-.14M7.5 14.779v-7.45L1.007 4.546a2 2 0 0 0-.007.14v6.626a1.5 1.5 0 0 0 .962 1.4l4.961 1.909q.282.108.577.158" />
                                            </svg>
                                        </div>
                                        {{$stprod->left_qty}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex mb-2 align-items-center gap-3">
    <h5 class="m-0">Processed Purchase</h5>
    <div class="d-flex align-items-center bg-primary text-white rounded-5 p-1 px-2 justify-content-center" style="aspect-ratio:1/1; font-size:12px; object-fit:contain;">
        <strong>{{count($processeds)}}</strong>
    </div>
</div>
<div class="my-4">
    <div class="alert alert-warning">
        Akibat penghapusan data, data sampah ini mungkin tidak akurat. Silahkan re-store data untuk melihat data yang akurat.
    </div>
</div>

@forelse ($processeds as $processed)
<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex align-items-center mb-2 justify-content-between">
            <div class="w-100">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        @switch($processed->is_finished)
                            @case(1)
                                <div class="p-1 px-2 rounded-3 bg-light-warning text-dark d-inline-block mb-2" style="font-size: 13px">On Process</div>
                                @break
                            @case(2)
                                <div class="p-1 px-2 rounded-3 bg-light-success text-success d-inline-block mb-2" style="font-size: 13px">Finish</div>
                                @break
                            @default
                                <div class="p-1 px-2 rounded-3 bg-light-primary text-dark d-inline-block mb-2" style="font-size: 13px">Waiting</div>
                        @endswitch
                        <h6>{{$processed->no}}</h6>
                        <p class="mb-1" style="font-size: 13px">{{ \Carbon\Carbon::parse($processed->date)->translatedFormat('d F Y') }}</p>
                        <p class="text-muted mb-0" style="font-size: 13px">{{$processed->description}}</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-2 align-items-center gap-2 justify-content-md-start">
                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M3 4a2 2 0 0 0-2 2v11h2a3 3 0 0 0 3 3a3 3 0 0 0 3-3h6a3 3 0 0 0 3 3a3 3 0 0 0 3-3h2v-5l-3-4h-3V4m-7 2l4 4l-4 4v-3H4V9h6m7 .5h2.5l1.97 2.5H17M6 15.5A1.5 1.5 0 0 1 7.5 17A1.5 1.5 0 0 1 6 18.5A1.5 1.5 0 0 1 4.5 17A1.5 1.5 0 0 1 6 15.5m12 0a1.5 1.5 0 0 1 1.5 1.5a1.5 1.5 0 0 1-1.5 1.5a1.5 1.5 0 0 1-1.5-1.5a1.5 1.5 0 0 1 1.5-1.5" />
                                </svg>
                            </div>
                            <strong>Detail Pengiriman</strong>
                        </div>
                        <div>
                            @if ($processed->is_logistic_in_sahara == 1)
                            <span class="text-muted font-semibold">{{$processed->logistic->name}}<br/></span>
                            <span class="text-muted" style="font-size:13px">
                                <strong>Pick Up Address : </strong> 
                                ({{ optional($processed->pickup)->address_tag }}) 
                                {{ optional($processed->pickup)->address }}, 
                                {{ optional($processed->pickup)->city }}. 
                                {{ optional($processed->pickup)->postal_code }}
                            </span>
                            @else
                            <span class="text-muted">Logistic diurus oleh Principle<br/></span>
                            @endif

                            <div class="d-flex mt-1 align-items-center gap-1">
                                <a href="{{asset('storage/'.$processed->spk_file)}}" target="_blank" class="d-flex align-items-center gap-2 p-1 px-2 rounded-3 bg-light-secondary text-dark" style="font-size: 13px">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="currentColor">
                                                <path d="m12 2l.117.007a1 1 0 0 1 .876.876L13 3v4l.005.15a2 2 0 0 0 1.838 1.844L15 9h4l.117.007a1 1 0 0 1 .876.876L20 10v9a3 3 0 0 1-2.824 2.995L17 22H7a3 3 0 0 1-2.995-2.824L4 19V5a3 3 0 0 1 2.824-2.995L7 2z" />
                                                <path d="M19 7h-4l-.001-4.001z" />
                                            </g>
                                        </svg>
                                    </div>
                                    SPK
                                </a>
                                <a href="{{asset('storage/'.$processed->surjal_file)}}" target="_blank" class="d-flex align-items-center gap-2 p-1 px-2 rounded-3 bg-light-secondary text-dark" style="font-size: 13px">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="currentColor">
                                                <path d="m12 2l.117.007a1 1 0 0 1 .876.876L13 3v4l.005.15a2 2 0 0 0 1.838 1.844L15 9h4l.117.007a1 1 0 0 1 .876.876L20 10v9a3 3 0 0 1-2.824 2.995L17 22H7a3 3 0 0 1-2.995-2.824L4 19V5a3 3 0 0 1 2.824-2.995L7 2z" />
                                                <path d="M19 7h-4l-.001-4.001z" />
                                            </g>
                                        </svg>
                                    </div>
                                    Surjal
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.13em" height="1em" viewBox="0 0 576 512"><path fill="currentColor" d="M256 0h64c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32h-64c-17.7 0-32-14.3-32-32V32c0-17.7 14.3-32 32-32M64 64h128v48c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V64h128c35.3 0 64 28.7 64 64v320c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128c0-35.3 28.7-64 64-64m112 373.3c0 5.9 4.8 10.7 10.7 10.7h202.7c5.9 0 10.7-4.8 10.7-10.7c0-29.5-23.9-53.3-53.3-53.3H229.5c-29.5 0-53.3 23.9-53.3 53.3zM288 352a64 64 0 1 0 0-128a64 64 0 1 0 0 128"/></svg>
                                    </div>
                                    <h6 class="m-0" style="font-size: 13px">Principle</h6>
                                </div>
                                <div class="fw-semibold">{{$processed->principle?->name}}</div>
                                <div style="font-size:12px" class="text-muted">{{$processed->principle?->email}}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M6 17c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1H6m9-9a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3a3 3 0 0 1 3 3M3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2" />
                                        </svg>
                                    </div>
                                    <h6 class="m-0" style="font-size: 13px">PIC Contact</h6>
                                </div>
                                <div class="fw-semibold">
                                    {{$processed->principle?->contact_name}}
                                </div>
                                <div style="font-size:12px" class="text-muted">{{$processed->principle?->contact_email}}, {{$processed->principle?->contact_phone}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion accordion-flush" id="accordionProcessed-{{$processed->id}}">
            <div class="accordion-item">
                <div class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed rounded-3 border" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{$processed->id}}" aria-expanded="false" aria-controls="flush-{{$processed->id}}">
                        {{count($processed->getProducts)}} product yang diproses
                    </button>
                </div>
                <div id="flush-{{$processed->id}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionProcessed-{{$processed->id}}">
                    <div class="p-3">
                        @forelse($processed->getProducts as $prod)
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6>{{$prod->product->title}}</h6>
                                <p style="font-size:13px">{{$prod->product->description}}</p>
                            </div>
                            <div>
                                <h6>{{$prod->qty ?? 0}}</h6>
                                <span style="font-size:13px">pkg diproses</span>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="d-flex align-items-center jutify-content-center p-5">
    <div>
        Belum ada Proses yang dibuat, Silahkan klik "Add Process" untuk memproses PO Ke Principle
    </div>
</div>
@endforelse
  
@endsection

@section('scripts')
<script src="/dist/assets/static/js/pages/filepond-pdf-preview.js"></script>
<script src="/dist/assets/extensions/flatpickr/flatpickr.min.js"></script>

<script>

</script>
@endsection