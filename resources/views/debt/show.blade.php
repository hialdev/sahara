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
        <li class="breadcrumb-item"><a href="{{route('debt.index')}}">Debt</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$debt->no}}</li>
    </ol>
</nav>
<div class=" pb-3 px-0 d-flex flex-wrap align-items-center gap-4">
    <div class="mb-2">
        <h5 class="fs-5 flex-1">Debt Number</h5>
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex gap-2 text-white bg-primary p-1 px-2 rounded-3 align-items-center" style="font-size: 0.8rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.245 2h9.51c1.159 0 1.738 0 2.206.163a3.05 3.05 0 0 1 1.881 1.936C21 4.581 21 5.177 21 6.37v14.004c0 .858-.985 1.314-1.608.744a.946.946 0 0 0-1.284 0l-.483.442a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0l-.483-.442a.946.946 0 0 0-1.284 0c-.623.57-1.608.114-1.608-.744V6.37c0-1.193 0-1.79.158-2.27c.3-.913.995-1.629 1.881-1.937C5.507 2 6.086 2 7.245 2M7 6.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 10.25a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 13.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5z" clip-rule="evenodd"/></svg>
                {{$debt->no}}
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2 ms-auto">
        <a href="{{route('debt.print', $debt->id)}}" title="PO / Request Order FIle Refrence" class="btn btn-sm btn-danger ms-auto d-flex align-items-center justify-content-center" style="aspect-ratio:1/1">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1m4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2z" clip-rule="evenodd" />
            </svg>
        </a>
        <button type="button" class="ms-auto btn btn-sm btn-light-danger d-flex align-items-center gap-2 p-2 px-2.5" data-bs-toggle="modal"
            data-bs-target="#danger-{{$debt->id}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
            </svg>
            Hapus
        </button>
        {{-- Modal Delete --}}
        <div class="modal fade text-left" id="danger-{{$debt->id}}" tabindex="-1" role="dialog"
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
                        Apakah anda yakin menghapus data Debt dengan nomor <span class="fw-bold">{{$debt->no}}</span> untuk client <span class="fw-bold">{{$debt->principle->name}}</span> ? data Pembayaran Debt dan Jurnal yang terkait mungkin akan terdampak
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="{{route('debt.destroy', $debt->id)}}" method="POST">
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
<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex align-items-center mb-2 justify-content-between">
            <div class="w-100">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        @switch($debt->processOrder->is_finished)
                            @case(1)
                                <div class="p-1 px-2 rounded-3 bg-light-warning text-dark d-inline-block mb-2" style="font-size: 13px">On Process</div>
                                @break
                            @case(2)
                                <div class="p-1 px-2 rounded-3 bg-light-success text-success d-inline-block mb-2" style="font-size: 13px">Finish</div>
                                @break
                            @default
                                <div class="p-1 px-2 rounded-3 bg-light-primary text-dark d-inline-block mb-2" style="font-size: 13px">Waiting</div>
                        @endswitch
                        <h6>{{$debt->processOrder->no}}</h6>
                        <p class="mb-1" style="font-size: 13px">{{ \Carbon\Carbon::parse($debt->processOrder->date)->translatedFormat('d F Y') }}</p>
                        <p class="text-muted mb-0" style="font-size: 13px">{{$debt->processOrder->description}}</p>
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
                            @if ($debt->processOrder->is_logistic_in_sahara == 1)
                            <span class="text-muted font-semibold">{{$debt->processOrder->logistic->name}}<br/></span>
                            <span class="text-muted" style="font-size:13px">
                                <strong>Pick Up Address : </strong> 
                                ({{ optional($debt->processOrder->pickup)->address_tag }}) 
                                {{ optional($debt->processOrder->pickup)->address }}, 
                                {{ optional($debt->processOrder->pickup)->city }}. 
                                {{ optional($debt->processOrder->pickup)->postal_code }}
                            </span>
                            @else
                            <span class="text-muted">Logistic diurus oleh Principle<br/></span>
                            @endif

                            <div class="d-flex mt-1 align-items-center gap-1">
                                <a href="{{asset('storage/'.$debt->processOrder->spk_file)}}" target="_blank" class="d-flex align-items-center gap-2 p-1 px-2 rounded-3 bg-light-secondary text-dark" style="font-size: 13px">
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
                                <a href="{{asset('storage/'.$debt->processOrder->surjal_file)}}" target="_blank" class="d-flex align-items-center gap-2 p-1 px-2 rounded-3 bg-light-secondary text-dark" style="font-size: 13px">
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
                    <div class="col-12 mt-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.13em" height="1em" viewBox="0 0 576 512"><path fill="currentColor" d="M256 0h64c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32h-64c-17.7 0-32-14.3-32-32V32c0-17.7 14.3-32 32-32M64 64h128v48c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V64h128c35.3 0 64 28.7 64 64v320c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128c0-35.3 28.7-64 64-64m112 373.3c0 5.9 4.8 10.7 10.7 10.7h202.7c5.9 0 10.7-4.8 10.7-10.7c0-29.5-23.9-53.3-53.3-53.3H229.5c-29.5 0-53.3 23.9-53.3 53.3zM288 352a64 64 0 1 0 0-128a64 64 0 1 0 0 128"/></svg>
                                    </div>
                                    <h6 class="m-0" style="font-size: 13px">Principle</h6>
                                </div>
                                <div class="fw-semibold">{{$debt->processOrder->principle?->name}}</div>
                                <div style="font-size:12px" class="text-muted">{{$debt->processOrder->principle?->email}}</div>
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
                                    {{$debt->processOrder->principle?->contact_name}}
                                </div>
                                <div style="font-size:12px" class="text-muted">{{$debt->processOrder->principle?->contact_email}}, {{$debt->processOrder->principle?->contact_phone}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-3 m-1 mb-2 rounded-3 bg-light-primary">
            <div class="col-md-6">
                <div style="font-size: 12px">Total yang harus dibayarkan</div>
                <div class="fs-6 fw-bold text-primary">{{formatRupiah($debt->total_debt)}}</div>
            </div>
            <div class="col-md-6 text-end">
                <div style="font-size: 12px">Sisa yang belum dibayarkan</div>
                <div class="fs-6 fw-bold text-danger">{{formatRupiah($debt->sisaHutang())}}</div>
            </div>
        </div>
        <div class="accordion accordion-flush" id="accordionProcessed-{{$debt->processOrder->id}}">
            <div class="accordion-item">
                <div class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed rounded-3 border" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{$debt->processOrder->id}}" aria-expanded="false" aria-controls="flush-{{$debt->processOrder->id}}">
                        {{count($debt->processOrder->getProducts)}} product yang diproses
                    </button>
                </div>
                <div id="flush-{{$debt->processOrder->id}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionProcessed-{{$debt->processOrder->id}}">
                    <div class="p-3">
                        @forelse($debt->processOrder->getProducts as $prod)
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <h6>{{$prod->product->title}}</h6>
                                <p style="font-size:13px">{{$prod->product->description}}</p>
                            </div>
                            <div class="col-md-4">
                                <h6>{{formatRupiah($prod?->price_buy)}} x {{$prod->qty ?? 0}}</h6>
                                <span style="font-size:13px">pax diproses</span>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light-secondary rounded-4 overflow-hidden p-2">
                                    <div class="p-1 px-2 rounded-5 bg-primary text-white mb-2" style="font-size: 12px">Total Pemesanan</div>
                                    <h6>{{formatRupiah($prod?->price_buy * $prod->qty)}}</h6>
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
    <h5 class="m-0">Riwayat Pembayaran</h5>
    <div class="d-flex align-items-center bg-primary text-white rounded-5 p-1 px-2 justify-content-center" style="aspect-ratio:1/1; font-size:12px; object-fit:contain;">
        <strong>{{count($debt->processes)}}</strong>
    </div>
    <button type="button" class="ms-auto border-0 outline-0 btn btn-primary p-2 px-3" data-bs-toggle="modal"
        data-bs-target="#addProcessModal" {{$debt->status == 2 ? 'disabled' : ''}}>
        <span style="white-space:nowrap">Add <span class="d-none d-sm-inline-block">Paid Debt</span></span>
    </button>
    {{-- Add Process Modal --}}
    <div class="modal fade" id="addProcessModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100" style="min-width:80vw"
            role="document">
            <div class="modal-content">
                <div class="modal-header border-0 ">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Process Debt </h5>
                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body border-0 py-0  pb-2" style="height:fit-content; max-height:100vh">
                    <form action="{{route('debt.process.store', $debt->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="no" class="form-label">No. Debt Paid (Automatic)</label>
                                            <input type="text" id="no" name="no" class="form-control" value="PAID/xxx/RSM/xx/xxxx" disabled id="no" value="{{ old('no') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date Letter <span class="text-danger">*</span></label>
                                            <input type="date" name="date" id="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="debt_id" value="{{$debt->id}}">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="amount_paid" class="form-label">Jumlah yang dibayar <span class="text-danger">*</span></label>
                                            <input type="text" id="amount_paid" name="amount_paid" placeholder="Sisa {{formatRupiah($debt->sisaHutang())}}" class="form-control mb-3 rupiah-input">
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
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Process Debt</h5>
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
                                        <label for="no" class="form-label">No. Debt Paid (Automatic)</label>
                                        <input type="text" id="no" name="no" class="form-control" value="PAID/xxx/RSM/xx/xxxx" disabled id="no" value="{{ old('no') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date Letter <span class="text-danger">*</span></label>
                                        <input type="date" name="date" id="edit-date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                                    </div>
                                </div>
                                <input type="hidden" name="debt_id" value="{{$debt->id}}">
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

@forelse ($debt->processes as $processed)
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
                                <form action="{{route('debt.process.jurnal', ['id' => $debt->id, 'process_id' => $processed->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Buat jurnal entri dengan menentukan dengan apa Pembayaran ini dibayarkan, silahkan pilih akun mewakili alat pembayaran tersebut. <strong>Setelah Jurnal dibuat mengedit tidak diizinkan lagi</strong>
                                        </div>
                                    </div>
                                    <div class="w-100 position-relative mb-3 mt-2">
                                        <label for="payment-account-id-{{$loop->index}}" class="form-label">Payment Account</label>
                                        <select name="payment_account_id" id="payment-account-id-{{$loop->index}}" class="form-select">
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
                                        <button type="submit" class="btn btn-primary w-100">Generate Pembayaran Hutang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Edit Button --}}
                @if(!$processed->hasJurnal())
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
                                <h5 class="modal-title text-danger" id="exampleModalCenterTitle">Hapus Process Debt ?</h5>
                                <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body border-0 py-0">
                                <form action="{{route('debt.process.destroy', ['id' => $debt->id, 'process_id' => $processed->id])}}" method="POST" enctype="multipart/form-data">
                                    @method('DELETE')
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Yakin untuk menghapus pembayaran debt ({{$processed->no}}) ?. <strong>Pembayaran Debt yang dihapus tidak bisa dikembalikan (permanen)</strong>
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
    let debt_id = "{{$debt->id}}";

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

    let countProcesseds = @JSON(count($debt->processes));
    for (let index = 0; index < countProcesseds; index++) {
        new Choices('#payment-account-id-'+index, {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a Payment Account',
            removeItemButton: true
        });
    }

    const dateEdit = flatpickr('#edit-date', {
        enableTime: false,
        dateFormat: "d M Y", 
        defaultDate: "today",
    })

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
        var url = `/debt/${debt_id}/process/add`;
        // Define FormData and add other fields
        let formData = new FormData();

        const selectedDate = dateAdd.selectedDates[0]; // Date object
        const year = selectedDate.getFullYear();
        const month = String(selectedDate.getMonth() + 1).padStart(2, "0"); // Bulan dimulai dari 0
        const day = String(selectedDate.getDate()).padStart(2, "0");

        const formattedDate = `${year}-${month}-${day}`;

        formData.append('date_paid', formattedDate);
        formData.append('debt_id', $('input[name=debt_id]').val());
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
                          title: 'Pembayaran Debt berhasil ditambahkan!'
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
        var url = '/ajax/debt/' +debt_id+'/process/'+processId;

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

        var updateUrl = `/debt/${debt_id}/process/${processId}/edit`;
        let formData = new FormData();

        const selectedDate = dateEdit.selectedDates[0]; // Date object
        const year = selectedDate.getFullYear();
        const month = String(selectedDate.getMonth() + 1).padStart(2, "0"); // Bulan dimulai dari 0
        const day = String(selectedDate.getDate()).padStart(2, "0");

        const formattedDate = `${year}-${month}-${day}`;
        const editModal = $('#editProcessModal');
        formData.append('date_paid', formattedDate);
        formData.append('debt_id', editModal.find('input[name=debt_id]').val());
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