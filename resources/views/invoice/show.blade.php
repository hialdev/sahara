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
        <li class="breadcrumb-item"><a href="{{route('invoice.index')}}">Invoice</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$invoice->no}}</li>
    </ol>
</nav>
<div class=" pb-3 px-0 d-flex flex-wrap align-items-center gap-4">
    <div class="mb-2">
        <h5 class="fs-5 flex-1">Invoice Number</h5>
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex gap-2 text-white bg-primary p-1 px-2 rounded-3 align-items-center" style="font-size: 0.8rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.245 2h9.51c1.159 0 1.738 0 2.206.163a3.05 3.05 0 0 1 1.881 1.936C21 4.581 21 5.177 21 6.37v14.004c0 .858-.985 1.314-1.608.744a.946.946 0 0 0-1.284 0l-.483.442a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0l-.483-.442a.946.946 0 0 0-1.284 0c-.623.57-1.608.114-1.608-.744V6.37c0-1.193 0-1.79.158-2.27c.3-.913.995-1.629 1.881-1.937C5.507 2 6.086 2 7.245 2M7 6.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 10.25a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 13.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5z" clip-rule="evenodd"/></svg>
                {{$invoice->no}}
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2 ms-auto">
        <a href="{{route('invoice.print', $invoice->id)}}" title="PO / Request Order FIle Refrence" class="btn btn-sm btn-danger ms-auto d-flex align-items-center justify-content-center" style="aspect-ratio:1/1">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1m4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2z" clip-rule="evenodd" />
            </svg>
        </a>
        <button type="button" class="ms-auto btn btn-sm btn-light-danger d-flex align-items-center gap-2 p-2 px-2.5" data-bs-toggle="modal"
            data-bs-target="#danger-{{$invoice->id}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
            </svg>
            Hapus
        </button>
        {{-- Modal Delete --}}
        <div class="modal fade text-left" id="danger-{{$invoice->id}}" tabindex="-1" role="dialog"
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
                        Apakah anda yakin menghapus data Invoice dengan nomor <span class="fw-bold">{{$invoice->no}}</span> untuk client <span class="fw-bold">{{$invoice->client->name}}</span> ? data Pembayaran Invoice dan Jurnal yang terkait mungkin akan terdampak
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="{{route('invoice.destroy', $invoice->id)}}" method="POST">
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
                <div class="mb-2">
                    @if ($invoice->status == 0)
                    <span class="p-1 px-2 rounded-2 bg-light-secondary text-secondary" style="font-size:12px;white-space:nowrap">Waiting</span>
                    @elseif ($invoice->status == 1)
                    <span class="p-1 px-2 rounded-2 bg-warning text-dark" style="font-size:12px;white-space:nowrap">On Process</span>
                    @elseif ($invoice->status == 2)
                    <span class="p-1 px-2 rounded-2 bg-success text-white" style="font-size:12px;white-space:nowrap">Finish</span>
                    @endif
                </div>
                <div class="fw-semibold">{{$invoice->client?->name}}</div>
                <div style="font-size:12px" class="text-muted">NPWP : {{$invoice->client?->npwp}}</div>
                <div style="font-size:12px" class="text-muted">{{$invoice->client?->email}}</div>
                <div class="d-flex align-items-center gap-3 my-3">
                    <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M6 17c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1H6m9-9a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3a3 3 0 0 1 3 3M3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2" />
                        </svg>
                    </div>
                    <h6 class="m-0" style="font-size: 13px">PIC Contact</h6>
                </div>
                <div class="fw-semibold">
                    {{$invoice->client?->contact_name}}
                </div>
                <div style="font-size:12px" class="text-muted">{{$invoice->client?->contact_email}}, {{$invoice->client?->contact_phone}}</div>
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
                <div class="fw-semibold">{{$invoice->purchaseOrder->address->address_tag}}</div>
                <div style="font-size:12px" class="text-muted">Address : {{$invoice->purchaseOrder->address->address}}, {{$invoice->purchaseOrder->address->city}} - {{$invoice->purchaseOrder->address->postal_code}}</div>
                <div style="font-size:12px" class="text-muted">TELP / FAX : {{$invoice->purchaseOrder->address->telp}} / {{$invoice->purchaseOrder->address->fax}}</div>
                <button type="button" class="border-0 my-2 outline-0 bg-transparent text-primary gap-2 d-flex align-items-center justify-content-center" data-bs-toggle="modal"
                    data-bs-target="#productModal-{{$invoice->purchaseOrder->id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                        <path fill="currentColor" fill-rule="evenodd" d="M13.5 10.421V5.475l-2 .714V8.25a.75.75 0 0 1-1.5 0V6.725l-2.25.804v6.088l4.777-1.792a1.5 1.5 0 0 0 .973-1.404m-2.254-5.734l1.6-.571a2 2 0 0 0-.175-.104L9.499 2.427a1.5 1.5 0 0 0-1.197-.063l-.941.353l3.724 1.862q.09.045.16.108M5.444 3.435l3.878 1.94l-2.273.811l-3.805-1.903q.108-.063.23-.109zm.806 4.029L2.5 5.589v5.057a1.5 1.5 0 0 0 .83 1.342l2.92 1.46zM1 5.579c0-.436.094-.856.266-1.236a.75.75 0 0 1 .2-.37c.342-.54.855-.968 1.48-1.203L7.777.96a3 3 0 0 1 2.394.125l3.172 1.586A3 3 0 0 1 15 5.354v5.067a3 3 0 0 1-1.947 2.809l-4.828 1.81a3 3 0 0 1-2.395-.125l-3.172-1.586A3 3 0 0 1 1 10.646z" clip-rule="evenodd" />
                    </svg>
                    <span style="white-space:nowrap">{{count($invoice->purchaseOrder->getProducts)}} Products</span>
                </button>
                {{-- Modal Address --}}
                <div class="modal fade" id="productModal-{{$invoice->purchaseOrder->id}}" tabindex="-1" role="dialog"
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
                                @forelse ($invoice->purchaseOrder->getProducts as $product)
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

                <div class="row p-3 rounded-3 bg-light-primary">
                  <div class="col-md-6">
                    <div style="font-size: 12px">Total yang harus dibayarkan</div>
                    <div class="fs-6 fw-bold text-primary">{{formatRupiah($invoice->total_invoice)}}</div>
                  </div>
                  <div class="col-md-6 text-end">
                    <div style="font-size: 12px">Sisa yang belum dibayarkan</div>
                    <div class="fs-6 fw-bold text-danger">{{formatRupiah($invoice->sisaPiutang())}}</div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex mb-2 align-items-center gap-3">
    <h5 class="m-0">Riwayat Pembayaran</h5>
    <div class="d-flex align-items-center bg-primary text-white rounded-5 p-1 px-2 justify-content-center" style="aspect-ratio:1/1; font-size:12px; object-fit:contain;">
        <strong>{{count($invoice->processes)}}</strong>
    </div>
    <button type="button" class="ms-auto border-0 outline-0 btn btn-primary p-2 px-3" data-bs-toggle="modal"
        data-bs-target="#addProcessModal" {{$invoice->status == 2 ? 'disabled' : ''}}>
        <span style="white-space:nowrap">Add <span class="d-none d-sm-inline-block">Paid Invoice</span></span>
    </button>
    {{-- Add Process Modal --}}
    <div class="modal fade" id="addProcessModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100" style="min-width:80vw"
            role="document">
            <div class="modal-content">
                <div class="modal-header border-0 ">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Process Invoice </h5>
                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body border-0 py-0  pb-2" style="height:fit-content; max-height:100vh">
                    <form action="{{route('invoice.process.store', $invoice->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="no" class="form-label">No. Payment Receipt (Automatic)</label>
                                            <input type="text" id="no" name="no" class="form-control" placeholder="No. Purchase Order Principle" value="RECEIPT/xxx/RSM/xx/xxxx" disabled id="no" value="{{ old('no') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date Letter <span class="text-danger">*</span></label>
                                            <input type="date" name="date" id="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="amount_paid" class="form-label">Jumlah yang dibayar <span class="text-danger">*</span></label>
                                            <input type="text" id="amount_paid" name="amount_paid" placeholder="Sisa {{formatRupiah($invoice->sisaPiutang())}}" class="form-control mb-3 rupiah-input">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="edit-file-spk" class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                                            <input type="file" name="proof" id="proof">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="position-sticky bottom-0 w-100 pb-1">
                            <button type="button" class="send btn btn-primary w-100">Proses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Process Modal --}}
<div class="modal fade" id="editProcessModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100" style="min-width:80vw"
        role="document">
        <div class="modal-content">
            <div class="modal-header border-0 ">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Process Invoice</h5>
                <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                    </svg>
                </button>
            </div>
            <div class="modal-body border-0 py-0" style="height: 100vh">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="no" class="form-label">No. Payment Receipt (Automatic)</label>
                                        <input type="text" id="no" name="no" class="form-control" placeholder="No. Purchase Order Principle" value="RECEIPT/xxx/RSM/xx/xxxx" disabled id="no" value="{{ old('no') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date Letter <span class="text-danger">*</span></label>
                                        <input type="date" name="date" id="edit-date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                                    </div>
                                </div>
                                <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="amount_paid" class="form-label">Jumlah yang dibayar <span class="text-danger">*</span></label>
                                        <input type="text" id="amount_paid" name="amount_paid" placeholder="" class="form-control mb-3 rupiah-input">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="edit-file-spk" class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                                        <input type="file" name="proof" id="edit-proof">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="edit-process-id" id="edit-process-id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="position-sticky bottom-0 w-100 pb-1">
                        <button type="button" id="submit-edit" class="btn btn-primary w-100">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@forelse ($invoice->processes as $processed)
<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex align-items-center mb-2 justify-content-between">
            <div class="w-100">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6>{{$processed->no}}</h6>
                        <p class="mb-1" style="font-size: 13px">{{ \Carbon\Carbon::parse($processed->date_paid)->translatedFormat('d F Y') }}</p>
                        <p class="text-muted mb-0" style="font-size: 13px">{{$processed->description}}</p>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <div style="font-size: 12px">Telah dibayar sejumlah</div>
                            <div class="fs-6 fw-bold text-primary">{{formatRupiah($processed->amount_paid)}}</div>
                            <div class="d-flex mt-1 align-items-center gap-1">
                                <a href="{{asset('storage/'.$processed->proof_paid)}}" target="_blank" class="d-flex align-items-center gap-2 p-1 px-2 rounded-3 bg-light-secondary text-dark" style="font-size: 13px">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="currentColor">
                                                <path d="m12 2l.117.007a1 1 0 0 1 .876.876L13 3v4l.005.15a2 2 0 0 0 1.838 1.844L15 9h4l.117.007a1 1 0 0 1 .876.876L20 10v9a3 3 0 0 1-2.824 2.995L17 22H7a3 3 0 0 1-2.995-2.824L4 19V5a3 3 0 0 1 2.824-2.995L7 2z" />
                                                <path d="M19 7h-4l-.001-4.001z" />
                                            </g>
                                        </svg>
                                    </div>
                                    Bukti Pembayaran
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="ms-auto" style="width:3em">
                <button type="button" class="btn btn-sm mb-1 btn-primary block" 
                    style="aspect-ratio:1/1"
                    data-bs-toggle="modal"
                    data-bs-target="#generateJurnalModal-{{$processed->id}}"
                    {{$processed->hasJurnal() ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M2 18.5A1.5 1.5 0 0 0 3.5 20H5V0H3.5A1.5 1.5 0 0 0 2 1.5zM6 0v20h10a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm7 8H8V7h5zm3-2H8V5h8z" />
                    </svg>
                </button>

                {{-- Debt Process Modal --}}
                <div class="modal fade {{$processed->hasJurnal() ? 'd-none' : '' }}" id="generateJurnalModal-{{$processed->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-centered w-100"
                        role="document">
                        <div class="modal-content pb-2">
                            <div class="modal-header border-0 ">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Generate Jurnal Entry</h5>
                                <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body border-0 py-0">
                                <form action="{{route('invoice.process.jurnal', ['id' => $invoice->id, 'process_id' => $processed->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Buat jurnal entri dengan menentukan ke mana Pembayaran ini dibayarkan, silahkan pilih akun yang memiliki tipe aset (berawalan 1x). <strong>Setelah Jurnal dibuat mengedit tidak diizinkan lagi</strong>
                                        </div>
                                    </div>
                                    <div class="w-100 position-relative mb-3 mt-2">
                                        <label for="receive-account-id-{{$loop->index}}" class="form-label">Receiver Account</label>
                                        <select name="receive_account_id" id="receive-account-id-{{$loop->index}}" class="form-select">
                                            <option value="">-- Pilih Account --</option>
                                            @foreach ($accounts as $account)
                                            <option value="{{$account->id}}">{{$account->no_code}} - {{$account->account_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 mb-2">
                                        Tidak ada akun yang tepat? <a href="{{route('account.index')}}">buat akun</a> 
                                    </div>
                                    <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                        <button type="submit" class="btn btn-primary w-100">Buat Hutang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!$processed->hasJurnal())
                {{-- Edit Button --}}
                <button type="button" id="editButton" data-process-id="{{$processed->id}}" class="d-flex mb-1 align-items-center justify-content-center btn btn-sm btn-light-secondary block" style="aspect-ratio:1/1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                            <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                        </g>
                    </svg>
                </button>
                @endif

                @if (Auth::user()->hasRole('executive'))
                <button type="button" title="Delete Process" class="btn btn-sm mb-1 btn-danger block"
                    style="aspect-ratio:1/1"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteProcessModal-{{$processed->id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024">
                        <path fill="currentColor" d="M195.2 195.2a64 64 0 0 1 90.496 0L512 421.504L738.304 195.2a64 64 0 0 1 90.496 90.496L602.496 512L828.8 738.304a64 64 0 0 1-90.496 90.496L512 602.496L285.696 828.8a64 64 0 0 1-90.496-90.496L421.504 512L195.2 285.696a64 64 0 0 1 0-90.496" />
                    </svg>
                </button>

                {{-- Delete Process Modal --}}
                <div class="modal fade" id="deleteProcessModal-{{$processed->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100"
                        role="document">
                        <div class="modal-content">
                            <div class="modal-header border-0 bg-light-danger mb-3">
                                <h5 class="modal-title text-danger" id="exampleModalCenterTitle">Hapus Process Invoice ?</h5>
                                <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body border-0 py-0">
                                <form action="{{route('invoice.process.destroy', ['id' => $invoice->id, 'process_id' => $processed->id])}}" method="POST" enctype="multipart/form-data">
                                    @method('DELETE')
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Yakin untuk menghapus pembayaran invoice ({{$processed->no}}) ?. <strong>Pembayaran Invoice yang dihapus tidak bisa dikembalikan (permanen)</strong>
                                        </div>
                                    </div>
                                    <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                        <button type="submit" class="btn btn-danger w-100">Mengerti, Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
$(document).ready(function() {
    let invoice_id = "{{$invoice->id}}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    const dateAdd = flatpickr('#date', {
        enableTime: false,
        dateFormat: "d M Y", 
        defaultDate: "today",
    })

    const dateEdit = flatpickr('#edit-date', {
        enableTime: false,
        dateFormat: "d M Y", 
        defaultDate: "today",
    })

    let countProcesseds = @JSON(count($invoice->processes));
    for (let index = 0; index < countProcesseds; index++) {
        new Choices('#receive-account-id-'+index, {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a Received Account',
            removeItemButton: true
        });
    }

    FilePond.registerPlugin(FilePondPluginPdfPreview);
    let filePondOptionPdf = {
        allowPdfPreview: true,
        pdfPreviewHeight: 220,
        pdfComponentExtraParams: 'toolbar=0&navpanes=0&scrollbar=0&view=fitH',
        acceptedFileTypes: [
            "application/msword", // DOC
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document", // DOCX
            "application/pdf", // PDF
            "application/vnd.ms-powerpoint", // PPT
            "application/vnd.openxmlformats-officedocument.presentationml.presentation", // PPTX
            "application/vnd.ms-excel", // XLS
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" // XLSX
        ],
        fileValidateTypeDetectType: (source, type) =>
            new Promise((resolve, reject) => {
                resolve(type);
            }),
        storeAsFile: true,
    };
    const proofFileInput = document.querySelector('#proof');
    const proofFile = FilePond.create(proofFileInput, filePondOptionPdf);
    
    const editProofFileInput = document.querySelector('#edit-proof');
    const editProofFile = FilePond.create(editProofFileInput, filePondOptionPdf);

    // --------- Add -------------
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

    // Event untuk menghitung total ketika price diubah
    $('.rupiah-input').on('keyup', function() {
        let value = $(this).val().replace(/[^,\d]/g, '').toString();
        let rp = formatRupiah(value);
        $(this).val(rp);
    });

    // -----------------------------
    // ---------- Form Add ---------
    //------------------------------
    $('#addProcessModal button.send').on('click', function() {
        var url = `/invoice/${invoice_id}/process/add`;
        // Define FormData and add other fields
        let formData = new FormData();

        const selectedDate = dateAdd.selectedDates[0]; // Date object
        const year = selectedDate.getFullYear();
        const month = String(selectedDate.getMonth() + 1).padStart(2, "0"); // Bulan dimulai dari 0
        const day = String(selectedDate.getDate()).padStart(2, "0");

        const formattedDate = `${year}-${month}-${day}`;

        formData.append('date_paid', formattedDate);
        formData.append('invoice_id', $('input[name=invoice_id]').val());
        formData.append('amount_paid', $('#amount_paid').val().replace(/[^\d]/g, ''));
        formData.append('description', $('textarea[name=description]').val());

        const proofPaid = proofFile.getFiles();
        if (proofPaid.length > 0) {
            formData.append('proof_paid', proofPaid[0].file);
        }

        if($('#amount_paid').val() && proofPaid.length > 0){
          // AJAX request untuk mengirimkan data
          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                  if (response.success) {
                      // Jika berhasil, tampilkan notifikasi dan close modal
                      Toast.fire({
                          icon: 'success',
                          title: 'Pembayaran Invoice berhasil ditambahkan!'
                      });
                      $('#addProcessModal').modal('hide');
                      setTimeout(function() {
                          location.reload();
                      }, 1300);
                  } else {
                      // Jika gagal, tampilkan pesan error
                      Toast.fire({
                          icon: 'error',
                          title: 'Gagal membuat proses, '+response.error
                      });
                  }
              },
              error: function (response, xhr, status, error) {
                  // Tangani error AJAX
                  console.error("Error:", error);
                  Toast.fire({
                      icon: 'error',
                      title: 'Kesalahan dalam menyimpan data , Error: '+ response.error
                  });
              }
          });
        }else{
          Toast.fire({
              icon: 'error',
              title: 'Isi dulu dong datanya yang ada tanda bintang merah, gimana sih',
          });
        }
    });

    // ---------- Edit -----------
    function setEditProcess(processId) {
        var url = '/ajax/invoice/' +invoice_id+'/process/'+processId;

        // Lakukan Ajax request
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                // Berhasil mendapatkan data, isi form di modal
                if (response.success) {
                    console.log(response);
                    // Isi nomor Process Purchase Order
                    const editModal = $('#editProcessModal');
                    editModal.find('.no-process').val(response.data.no);
                    editModal.find('#no').val(response.data.no);
                    editModal.find('input[name=amount_paid]').val(formatRupiah(response.data.amount_paid));
                    editModal.find('textarea[name=description]').val(response.data.description);
                    editModal.find('#edit-process-id').val(processId);
                    
                    if(response.data.proof_paid != "" && response.data.proof_paid != null){
                        let editProofFileData = '/storage/'+response.data.proof_paid;
                        editProofFile.addFile(editProofFileData);
                    }
                    const formattedDate = flatpickr.formatDate(
                        new Date(response.data.date_paid.split(" ")[0]),
                        "d M Y"
                    );
                    console.log(formattedDate);
                    // Isi tanggal surat
                    dateEdit.setDate(formattedDate); // The second parameter 'true' triggers the change event
                    
                    // Tampilkan modal
                    $('#editProcessModal').modal('show');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: `Gagal Fetch data, ${response.message}`,
                    });
                }
            },
            error: function (xhr) {
                // Error saat request
                console.error(xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: `Gagal Fetch data nih, ${xhr.error}`,
                });
            }
        });
    }

    // Event listener untuk button edit
    $(document).on('click', '#editButton', function () {
        var processId = $(this).data('process-id'); // Ambil ID process dari atribut data-process-id
        setEditProcess(processId);
    });

    $('#submit-edit').on('click',function (e) {
        e.preventDefault();
        let processId = $('#edit-process-id').val();
        console.log('Edit Clicked', processId);

        var updateUrl = `/invoice/${invoice_id}/process/${processId}/edit`;
        let formData = new FormData();

        const selectedDate = dateEdit.selectedDates[0]; // Date object
        const year = selectedDate.getFullYear();
        const month = String(selectedDate.getMonth() + 1).padStart(2, "0"); // Bulan dimulai dari 0
        const day = String(selectedDate.getDate()).padStart(2, "0");

        const formattedDate = `${year}-${month}-${day}`;
        const editModal = $('#editProcessModal');
        formData.append('date_paid', formattedDate);
        formData.append('invoice_id', editModal.find('input[name=invoice_id]').val());
        formData.append('amount_paid', editModal.find('#amount_paid').val().replace(/[^\d]/g, ''));
        formData.append('description', editModal.find('textarea[name=description]').val());

        const editProofPaid = editProofFile.getFiles();
        if (editProofPaid.length > 0) {
            formData.append('proof_paid', editProofPaid[0].file);
        }

        if(editModal.find('#amount_paid').val() && editProofPaid.length > 0){
        // AJAX request untuk mengirimkan data
          $.ajax({
              url: updateUrl,
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                  if (response.success) {
                      // Jika berhasil, tampilkan notifikasi dan close modal
                      Toast.fire({
                          icon: 'success',
                          title: 'Proses berhasil diperbarui!'
                      });
                      $('#editProcessModal').modal('hide');
                      setTimeout(function() {
                          location.reload();
                      }, 1300);
                  } else {
                      // Jika gagal, tampilkan pesan error
                      Toast.fire({
                          icon: 'error',
                          title: 'Gagal memperbarui proses, '+response.message
                      });
                  }
              },
              error: function (response, xhr, status, error) {
                  // Tangani error AJAX
                  console.error("Error:", error);
                  Toast.fire({
                      icon: 'error',
                      title: 'Data tidak valid, pastikan data yang di proses sesuai, Error: '+ response.error
                  });
              }
          });
        }else{
          Toast.fire({
              icon: 'error',
              title: 'Yang bener dong isi datanya, kalau ada bintang merah artinya wajib!',
          });
        }
    });
});
</script>
@endsection