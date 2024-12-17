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
        <li class="breadcrumb-item"><a href="{{route('purchase.index')}}">Purchase</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$po->no}}</li>
    </ol>
</nav>
<div class=" pb-3 px-0 d-flex flex-wrap align-items-center gap-4">
    <div class="mb-2">
        <h5 class="fs-5 flex-1">Purchase Number</h5>
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
    <div class="d-flex align-items-center gap-2 ms-auto">
        <a href="{{asset('storage/'.$po->po_file)}}" target="_blank" title="PO / Request Order FIle Refrence" class="btn btn-sm btn-danger ms-auto d-flex align-items-center justify-content-center" style="aspect-ratio:1/1">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1m4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2z" clip-rule="evenodd" />
            </svg>
        </a>
        <button type="button" class="ms-auto btn btn-sm btn-light-danger d-flex align-items-center gap-2 p-2 px-2.5" data-bs-toggle="modal"
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
                <div class="modal-content pb-2 rounded-4">
                    <div class="modal-header bg-danger border-0">
                        <h5 class="modal-title white" id="myModalLabel120">Confirmation Delete</h5>
                        <button type="button" class="btn btn-danger bg-danger" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="mb-1 bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body border-0">
                        Apakah anda yakin menghapus data Quotation dengan nomor <span class="fw-bold">{{$po->no}}</span> untuk client <span class="fw-bold">{{$po->client->name}}</span> ? data Purchase Order yang terkait mungkin akan terdampak
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="{{route('purchase.destroy', $po->id)}}" method="POST">
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

        {{-- @if(!$po->invoice) --}}
            <button type="button" class="{{$po->invoice ? 'd-none' : ''}} ms-auto btn btn-sm btn-light-primary d-flex align-items-center gap-2 p-2 px-2.5" data-bs-toggle="modal"
                data-bs-target="#makeInvoice-{{$po->id}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.245 2h9.51c1.159 0 1.738 0 2.206.163a3.05 3.05 0 0 1 1.881 1.936C21 4.581 21 5.177 21 6.37v14.004c0 .858-.985 1.314-1.608.744a.946.946 0 0 0-1.284 0l-.483.442a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0l-.483-.442a.946.946 0 0 0-1.284 0c-.623.57-1.608.114-1.608-.744V6.37c0-1.193 0-1.79.158-2.27c.3-.913.995-1.629 1.881-1.937C5.507 2 6.086 2 7.245 2M7 6.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 10.25a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 13.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5z" clip-rule="evenodd"/></svg>
                Generate Invoice
            </button>
            {{-- Modal Delete --}}
            <div class="{{$po->invoice ? 'd-none' : ''}} modal fade text-left" id="makeInvoice-{{$po->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"
                    role="document">
                    <div class="modal-content pb-2 rounded-4">
                        <div class="modal-header bg-primary border-0 rounded-top-4">
                            <h5 class="modal-title white" id="myModalLabel120">Generate Invoice</h5>
                            <button type="button" class="btn btn-primary bg-primary" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="mb-1 bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="modal-body border-0">
                            Apakah anda yakin membuat invoice terhadap Purchase Order <span class="fw-bold">{{$po->no}}</span> untuk client <span class="fw-bold">{{$po->client->name}}</span> ?
                        </div>
                        <div class="px-3 border-0">
                            <form action="{{route('purchase.invoice.generate', $po->id)}}" method="POST">
                                @csrf
                                <div class="w-100 position-relative mb-2 mt-2" style="">
                                    <label for="receivable-account-id" class="form-label">Receivable Account</label>
                                    <select name="receivable_account_id" id="receivable-account-id" class="form-select">
                                        <option value="">-- Pilih Receivable Account --</option>
                                        @foreach ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->no_code}} - {{$account->account_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-100 position-relative mb-2" style="">
                                    <label for="revenue-account-id" class="form-label">Revenue Account</label>
                                    <select name="revenue_account_id" id="revenue-account-id" class="form-select">
                                        <option value="">-- Pilih Revenue Account --</option>
                                        @foreach ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->no_code}} - {{$account->account_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-center gap-1 mb-2">
                                    Tidak ada akun yang tepat? <a href="{{route('account.index')}}">buat akun</a> 
                                </div>
                                <div class="d-flex align-items-center gap-1 justify-content-end">
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Batal</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ms-1"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Ya, Generate Invoice</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- @else --}}
            @if (isset($po->invoice))
            <a href="{{route('invoice.print', $po->invoice->id)}}" class="ms-auto btn btn-sm btn-light-primary d-flex align-items-center gap-2 p-2 px-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.245 2h9.51c1.159 0 1.738 0 2.206.163a3.05 3.05 0 0 1 1.881 1.936C21 4.581 21 5.177 21 6.37v14.004c0 .858-.985 1.314-1.608.744a.946.946 0 0 0-1.284 0l-.483.442a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0l-.483-.442a.946.946 0 0 0-1.284 0c-.623.57-1.608.114-1.608-.744V6.37c0-1.193 0-1.79.158-2.27c.3-.913.995-1.629 1.881-1.937C5.507 2 6.086 2 7.245 2M7 6.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 10.25a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 13.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5z" clip-rule="evenodd"/></svg>
                Lihat Invoice
            </a>
            @endif
        {{-- @endif --}}
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="mb-2">
                    @if ($po->getStatus() == 0)
                    <span class="p-1 px-2 rounded-2 bg-light-secondary text-secondary" style="font-size:12px;white-space:nowrap">Waiting</span>
                    @elseif ($po->getStatus() == 1)
                    <span class="p-1 px-2 rounded-2 bg-warning text-dark" style="font-size:12px;white-space:nowrap">On Process - Partial</span>
                    @elseif ($po->getStatus() == 2)
                    <span class="p-1 px-2 rounded-2 bg-warning text-dark" style="font-size:12px;white-space:nowrap">On Process - Full</span>
                    @elseif ($po->getStatus() == 3)
                    <span class="p-1 px-2 rounded-2 bg-success text-white" style="font-size:12px;white-space:nowrap">Finished</span>
                    @endif
                </div>
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
                        <div class="modal-content pb-2">
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
                        Lihat Status Pemrosesan {{count($statusProducts)}} Products
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
    <button type="button" class="ms-auto border-0 outline-0 btn btn-primary p-2 px-3" data-bs-toggle="modal"
        data-bs-target="#addProcessModal" {{$po->getStatus() == 3 ? 'disabled' : ''}}>
        <span style="white-space:nowrap">Add <span class="d-none d-sm-inline-block">Process</span></span>
    </button>
    {{-- Modal Address --}}
    <div class="modal fade" id="addProcessModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100" style="min-width:80vw"
            role="document">
            <div class="modal-content pb-2">
                <div class="modal-header border-0 ">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Process Purchase </h5>
                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body border-0 py-0" style="height: 100vh">
                    <form action="{{route('purchase.process.store', $po->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="no" class="form-label">No. Process Purchase Order (Automatic)</label>
                                            <input type="text" id="no" name="no" class="form-control" placeholder="No. Purchase Order Principle" value="PO/xxx/RSM/xx/xxxx" disabled id="name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Date Letter <span class="text-danger">*</span></label>
                                            <input type="date" name="date" id="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="principle" class="form-label">Proses ke Principle / Supplier <span class="text-danger">*</span></label>
                                        <select id="principle" name="principle" class="form-select">
                                            <option value="">Pilih Principle</option>
                                            @forelse ($principles as $principle)
                                            <option value="{{$principle->id}}" {{old('principle') == $principle->id ? 'selected' : ''}}>{{$principle->name}}</option>
                                            @empty
                                            <option value="">Tidak ada principle tersedia</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        {{-- Toggle : Pengiriman dengan sahara ? --}}
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is-logistic-sahara" value="0"> <!-- Default value if not checked -->
                                            <input class="form-check-input" type="checkbox" role="switch" value="1" 
                                                {{old('is-logistic-sahara') == '1' ? 'checked' : ''}} 
                                                name="is-logistic-sahara" id="is-logistic-sahara">
                                            <label class="form-check-label" for="is-logistic-sahara">Pengiriman diatur Sahara ?</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        {{-- Jika iya maka tampilkan inputan select pilih logistic --}}
                                        <label for="logistic" class="form-label">Pilih Logistic <span class="text-danger">*</span></label>
                                        <select id="logistic" name="logistic" class="form-select">
                                            <option value="">Pilih Logistic</option>
                                            @forelse ($logistics as $logistic)
                                            <option value="{{$logistic->id}}" {{old('logistic') == $logistic->id ? 'selected' : ''}}>{{$logistic->name.' - '.$logistic->email}}</option>
                                            @empty
                                            <option value="">Tidak ada logistic tersedia</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        {{-- Jika iya maka tampilkan inputan select pilih logistic --}}
                                        <label for="address-jemput" class="form-label">Jemput Barang di <span class="text-danger">*</span> <a href="" class="text-primary">Tambah baru</a></label>
                                        <select id="address-jemput" name="address-jemput" class="form-select">
                                            <option value="">Pilih Alamat Penjemputan (Pilih Principle terlebih dahulu)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="file-spk" class="form-label">File SPK</label>
                                        <input type="file" name="file-spk" value="{{old('file-spk')}}" id="file-spk">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="file-surjal" class="form-label">File Surat Jalan</label>
                                        <input type="file" name="file-surjal" value="{{old('file-surjal')}}" id="file-surjal">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Description"></textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="product" class="form-label">Product yang diproses <span class="text-danger">*</span></label>
                                        <select id="product" name="products[]" class="form-select" multiple>
                                            <option value="">Pilih Product</option>
                                            @forelse ($po->getProducts as $product)
                                            <option value="{{$product->id}}" {{ in_array($product->id, old('products', [])) ? 'selected' : '' }}>
                                                {{$product->product->title}}
                                            </option>
                                            @empty
                                            <option value="">Tidak ada product tersedia</option>
                                            @endforelse
                                        </select>                                        
                                    </div>
                                </div>
                            </div>
                            <div id="qty-container"></div>
    
                        </div>
                        <div class="position-sticky bottom-0 w-100 pb-1">
                            <button class="btn btn-primary w-100">Proses</button>
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
        <div class="modal-content pb-2">
            <div class="modal-header border-0 ">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Process Purchase : <span class="no-process">xxx/xxx/xxx</span> </h5>
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
                                        <input type="hidden" name="edit-id-process" id="edit-id-process">
                                        <label for="edit-no" class="form-label">No. Process Purchase Order (Automatic)</label>
                                        <input type="text" id="edit-no" name="no" class="form-control" placeholder="No. Purchase Order Principle" value="PO/xxx/RSM/xx/xxxx" disabled id="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date Letter <span class="text-danger">*</span></label>
                                        <input type="date" name="date" id="edit-date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="edit-principle" class="form-label">Proses ke Principle / Supplier <span class="text-danger">*</span></label>
                                    <select id="edit-principle" name="principle" class="form-select">
                                        <option value="">Pilih Principle</option>
                                        @forelse ($principles as $principle)
                                        <option value="{{$principle->id}}" {{old('edit-principle') == $principle->id ? 'selected' : ''}}>{{$principle->name}}</option>
                                        @empty
                                        <option value="">Tidak ada principle tersedia</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    {{-- Toggle : Pengiriman dengan sahara ? --}}
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is-logistic-sahara" value="0"> <!-- Default value if not checked -->
                                        <input class="form-check-input" type="checkbox" role="switch" value="1" 
                                            {{old('is-logistic-sahara') == '1' ? 'checked' : ''}} 
                                            name="is-logistic-sahara" id="edit-is-logistic-sahara">
                                        <label class="form-check-label" for="edit-is-logistic-sahara">Pengiriman diatur Sahara ?</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{-- Jika iya maka tampilkan inputan select pilih logistic --}}
                                    <label for="edit-logistic" class="form-label">Pilih Logistic <span class="text-danger">*</span></label>
                                    <select id="edit-logistic" name="logistic" class="form-select">
                                        <option value="">Pilih Logistic</option>
                                        @forelse ($logistics as $logistic)
                                        <option value="{{$logistic->id}}" {{old('logistic') == $logistic->id ? 'selected' : ''}}>{{$logistic->name.' - '.$logistic->email}}</option>
                                        @empty
                                        <option value="">Tidak ada logistic tersedia</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{-- Jika iya maka tampilkan inputan select pilih logistic --}}
                                    <label for="edit-address-jemput" class="form-label">Jemput Barang di <span class="text-danger">*</span> <a href="" class="text-primary">Tambah baru</a></label>
                                    <select id="edit-address-jemput" name="address-jemput" class="form-select">
                                        <option value="">Pilih Alamat Penjemputan</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit-file-spk" class="form-label">File SPK</label>
                                    <input type="file" name="file-spk" id="edit-file-spk">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="edit-file-surjal" class="form-label">File Surat Jalan</label>
                                    <input type="file" name="file-surjal" id="edit-file-surjal">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="hidden" id="edit-product-ids" name="products">
                                    <label for="edit-description" class="form-label">Description</label>
                                    <textarea name="description" id="edit-description" class="form-control" cols="30" rows="5" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="edit-qty-container"></div>

                    </div>
                    <div class="position-sticky bottom-0 w-100 pb-1">
                        <button type="button" id="submit-edit" class="btn btn-primary w-100">Proses</button>
                    </div>
                </form>
            </div>
        </div>
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
                    <div class="col-12 mt-4">
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
            <div class="ms-auto" style="width:3em">

                @if($processed->is_finished == 0)
                <button type="button" id="editButton" data-process-id="{{$processed->id}}" class="d-flex mb-1 align-items-center justify-content-center btn btn-sm btn-light-secondary block" style="aspect-ratio:1/1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                            <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                        </g>
                    </svg>
                </button>

                <button type="button" class="btn btn-sm mb-1 btn-warning block" style="aspect-ratio:1/1"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmProcessModal-{{$processed->id}}"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M1 3a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v5h4a5 5 0 0 1 5 5v4a3 3 0 0 1-2.129 2.872a3 3 0 0 1-5.7.128H8.83a3 3 0 0 1-5.7-.128A3 3 0 0 1 1 17v-4h6a1 1 0 1 0 0-2H1V9h4a1 1 0 0 0 0-2H1zm13 15h1.171a3 3 0 0 1 5.536-.293A1 1 0 0 0 21 17v-4a3 3 0 0 0-3-3h-4zm-7 1a1 1 0 1 0-2 0a1 1 0 0 0 2 0m10.293-.707A1 1 0 0 0 17 19a1 1 0 1 0 .293-.707" clip-rule="evenodd"/></svg>
                </button>

                {{-- Processing Process Modal --}}
                <div class="modal fade" id="confirmProcessModal-{{$processed->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100"
                        role="document">
                        <div class="modal-content pb-2">
                            <div class="modal-header border-0 ">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Confirm Process Purchase</h5>
                                <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body border-0 py-0">
                                <form action="{{route('purchase.process.processing', ['id' => $po->id, 'process_id' => $processed->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Pastikan semua data telah benar sebelum memproses PO ke Principle, <strong>Setelah status berubah data tidak bisa diedit atau dihapus</strong>
                                        </div>
                                    </div>
                                    <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                        <button type="submit" class="btn btn-primary w-100">Proses ke Principle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($processed->is_finished != 0 && $processed->is_finished != 2)
                <button type="button" class="btn btn-sm mb-1 btn-success block" 
                    style="aspect-ratio:1/1" {{$processed->is_finished == 2 ? 'disabled' : ''}}
                    data-bs-toggle="modal"
                    data-bs-target="#finishProcessModal-{{$processed->id}}"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor" d="M21.546 5.111a1.5 1.5 0 0 1 0 2.121L10.303 18.475a1.6 1.6 0 0 1-2.263 0L2.454 12.89a1.5 1.5 0 1 1 2.121-2.121l4.596 4.596L19.424 5.111a1.5 1.5 0 0 1 2.122 0" />
                        </g>
                    </svg>
                </button>

                {{-- Finish Process Modal --}}
                <div class="modal fade" id="finishProcessModal-{{$processed->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100"
                        role="document">
                        <div class="modal-content pb-2">
                            <div class="modal-header border-0 ">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Tetapkan Selesai</h5>
                                <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body border-0 py-0">
                                <form action="{{route('purchase.process.finish', ['id' => $po->id, 'process_id' => $processed->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Pastikan semua Dokumen penting, Keadaan lapangan, dan Keperluan Bisnis telah berjalan dengan baik dan sesuai sebelum menyelesaikan Proses ini. <strong>Menyelesaikan Proses akan membuat atau menambah Piutang ke Principle / Suplier.</strong>
                                        </div>
                                    </div>
                                    <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                        <button type="submit" class="btn btn-primary w-100">Selesaikan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($processed->is_finished == 2)
                <button type="button" class="btn btn-sm mb-1 btn-primary block" 
                    style="aspect-ratio:1/1"
                    data-bs-toggle="modal"
                    data-bs-target="#debtProcessModal-{{$processed->id}}"
                    {{isset($processed->debt) ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M18 2a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3zM8 17a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 9 18.01l-.007-.127A1 1 0 0 0 8 17m4 0a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 13 18.01l-.007-.127A1 1 0 0 0 12 17m4 0a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 17 18.01l-.007-.127A1 1 0 0 0 16 17m-8-4a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 9 14.01l-.007-.127A1 1 0 0 0 8 13m4 0a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 13 14.01l-.007-.127A1 1 0 0 0 12 13m4 0a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 17 14.01l-.007-.127A1 1 0 0 0 16 13m-1-7H9a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2" />
                    </svg>
                </button>

                {{-- Debt Process Modal --}}
                <div class="modal fade {{isset($processed->debt) ? 'd-none' : '' }}" id="debtProcessModal-{{$processed->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-centered w-100"
                        role="document">
                        <div class="modal-content pb-2">
                            <div class="modal-header border-0 ">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Buat Hutang / Debt</h5>
                                <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body border-0 py-0">
                                <form action="{{route('purchase.process.debt', ['id' => $po->id, 'process_id' => $processed->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Pastikan semua Dokumen penting, Keadaan lapangan, dan Keperluan Bisnis telah berjalan dengan baik dan sesuai sebelum membuat hutang untuk Proses ini. <strong>Dengan menyetujui maka Hutang ke Principle / Suplier akan dibuat.</strong>
                                        </div>
                                    </div>
                                    <div class="w-100 position-relative mb-3 mt-2">
                                        <label for="payable-account-id-{{$loop->index}}" class="form-label">Payable Account</label>
                                        <select name="payable_account_id" id="payable-account-id-{{$loop->index}}" class="form-select">
                                            <option value="">-- Pilih Payable Account --</option>
                                            @foreach ($accounts as $account)
                                            <option value="{{$account->id}}">{{$account->no_code}} - {{$account->account_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-100 position-relative mb-2 mt-2">
                                        <label for="cogs-account-id-{{$loop->index}}" class="form-label">Beban Pokok Penjualan (COGS) Account</label>
                                        <select name="cogs_account_id" id="cogs-account-id-{{$loop->index}}" class="form-select">
                                            <option value="">-- Pilih Beban Pokok Penjualan (COGS) Account --</option>
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
                @endif

                @if ($processed->is_finished == 0 || Auth::user()->hasRole('executive'))
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
                        <div class="modal-content pb-2">
                            <div class="modal-header border-0 bg-light-danger mb-3">
                                <h5 class="modal-title text-danger" id="exampleModalCenterTitle">Hapus Process / PO Ke Principle ?</h5>
                                <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body border-0 py-0">
                                <form action="{{route('purchase.process.destroy', ['id' => $po->id, 'process_id' => $processed->id])}}" method="POST" enctype="multipart/form-data">
                                    @method('DELETE')
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            Yakin untuk menghapus proses / PO ke Principle ?. <strong>Process / PO ke Principle yang dihapus tidak bisa dikembalikan (permanen)</strong>
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
    let purchaseId = "{{$po->id}}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    flatpickr('.flatpickr-no-config', {
        enableTime: false,
        dateFormat: "d M Y", 
        defaultDate: "today",
    })

    const principleChoices = new Choices('#principle', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a principle',
        removeItemButton: true
    });
    const editPrincipleChoices = new Choices('#edit-principle', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a Principle',
        removeItemButton: true
    });

    const productChoices = new Choices('#product', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a product',
        removeItemButton: true
    });

    const receivableAccountChoices = new Choices('#receivable-account-id', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a receivable Account',
        removeItemButton: true
    });
    const revenueAccountChoices = new Choices('#revenue-account-id', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a Revenue Account',
        removeItemButton: true
    });

    let countProcesseds = @JSON(count($processeds));
    console.log(countProcesseds);
    for (let index = 0; index < countProcesseds; index++) {
        console.log(index);
        const payableAccountChoices = new Choices('#payable-account-id-'+index, {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a payable Account',
            removeItemButton: true
        });
        const cogsAccountChoices = new Choices('#cogs-account-id-'+index, {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a COGS Account',
            removeItemButton: true
        });
    }

    const logisticChoices = new Choices('#logistic', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a logistic',
        removeItemButton: true
    });
    const editLogisticChoices = new Choices('#edit-logistic', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a logistic',
        removeItemButton: true
    });

    const jemputChoices = new Choices('#address-jemput', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Pilih alamat penjemputan',
        removeItemButton: true
    });
    const editJemputChoices = new Choices('#edit-address-jemput', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Pilih alamat penjemputan',
        removeItemButton: true
    });

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
    const fileInput = document.querySelector('#file-spk');
    const fileSPK = FilePond.create(fileInput, filePondOptionPdf);

    const fileInputSurjal = document.querySelector('#file-surjal');
    const fileSurjal = FilePond.create(fileInputSurjal, filePondOptionPdf);

    const fileInputEdit = document.querySelector('#edit-file-spk');
    const editFileSPK = FilePond.create(fileInputEdit, filePondOptionPdf);

    const fileInputSurjalEdit = document.querySelector('#edit-file-surjal');
    const editFileSurjal = FilePond.create(fileInputSurjalEdit, filePondOptionPdf);

    // Check the initial state of the switch on page load
    toggleLogisticFields($('#is-logistic-sahara').is(':checked'));
    toggleEditLogisticFields($('#edit-is-logistic-sahara').is(':checked'));

    // Add change event listener to the checkbox
    $('#is-logistic-sahara').on('change', function() {
        toggleLogisticFields($(this).is(':checked'));
    });
    $('#edit-is-logistic-sahara').on('change', function() {
        toggleEditLogisticFields($(this).is(':checked'));
    });

    // Function to show/hide the logistic fields
    function toggleLogisticFields(isChecked) {
        if (isChecked) {
            // Hide the selects if the switch is ON
            $('#logistic').closest('.col-md-6').show();
            $('#address-jemput').closest('.col-md-6').show();
            $('#file-spk').closest('.col-md-12').show();
        } else {
            // Show the selects if the switch is OFF
            $('#logistic').closest('.col-md-6').hide();
            $('#address-jemput').closest('.col-md-6').hide();
            $('#file-spk').closest('.col-md-12').hide();
        }
    }

    function toggleEditLogisticFields(isChecked) {
        if (isChecked) {
            // Hide the selects if the switch is ON
            $('#edit-logistic').closest('.col-md-6').show();
            $('#edit-address-jemput').closest('.col-md-6').show();
            $('#edit-file-spk').closest('.col-md-12').show();
        } else {
            // Show the selects if the switch is OFF
            $('#edit-logistic').closest('.col-md-6').hide();
            $('#edit-address-jemput').closest('.col-md-6').hide();
            $('#edit-file-spk').closest('.col-md-12').hide();
        }
    }
    // 
    $('#principle').on('change', function(){
        var principleId = $(this).val();
        $.ajax({
            url: `/ajax/principle/${principleId}`,
            type: 'GET',
            success: function(data){
                const formattedData = data.addresses.map(item => ({
                    value: `${item.id}`,
                    label: `${item.address_tag} @ ${item.address}, ${item.city}, ${item.postal_code}`,
                }));
                jemputChoices.clearChoices();
                jemputChoices.setChoices(formattedData);
                Toast.fire({
                    icon: 'success',
                    title: 'Menerapkan principle / supplier',
                })
            }
        })
    })

    $('#edit-principle').on('change', function(){
        var principleId = $(this).val();
        $.ajax({
            url: `/ajax/principle/${principleId}`,
            type: 'GET',
            success: function(data){
                const formattedData = data.addresses.map(item => ({
                    value: `${item.id}`,
                    label: `${item.address_tag} @ ${item.address}, ${item.city}, ${item.postal_code}`,
                }));
                editJemputChoices.clearChoices();
                editJemputChoices.setChoices(formattedData);
                Toast.fire({
                    icon: 'success',
                    title: 'Menerapkan principle / supplier',
                })
            }
        })
    })


    $('#product').on('change', function() {
        // Hapus semua input qty sebelumnya
        $('#qty-container').empty();
        console.log('Produc changed :',productChoices.getValue(true));
        // Ambil semua produk yang dipilih
        const selectedProducts = productChoices.getValue(true);

        // Iterasi setiap produk yang dipilih
        if (Array.isArray(selectedProducts) && selectedProducts.length > 0) {
            $.ajax({
                url: `/ajax/purchase/products?purchaseId=${purchaseId}&ids=${selectedProducts.join(',')}`,
                type: 'GET',
                success: function(data){
                    console.log(data);
                    let qtyInput = ``;
                    data.forEach(function(product) {
                        // Buat elemen input qty baru untuk setiap produk yang dipilih
                        qtyInput += `
                            <div class="col-md-12">
                                <div class="card mb-3 bg-light-secondary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center flex-column flex-sm-row gap-2 justify-content-between">
                                            <div class="d-flex flex-column flex-wrap align-items-start gap-1">
                                                <div>
                                                    <h6 class="m-0">${product.product.title}</h6>
                                                </div>
                                                <div class="">
                                                    <div class="mb-3 d-flex align-items-center gap-3 justify-content-md-start" style="font-size: 13px">
                                                        <div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                    <path d="m7.5 4.27l9 5.15M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                                                    <path d="m3.3 7l8.7 5l8.7-5M12 22V12" />
                                                                </g>
                                                            </svg>
                                                        </div>
                                                        x${product.qty}
                                                    </div>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-success text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M6 3q-.75 0-1.2.6L3.5 5.2c-.3.4-.5.8-.5 1.3V19c0 1.1.9 2 2 2h8.3c-.2-.6-.3-1.3-.3-2c0-3.3 2.7-6 6-6c.7 0 1.4.1 2 .3V6.5c0-.5-.2-.9-.5-1.3l-1.4-1.7c-.2-.3-.6-.5-1.1-.5zm-.1 1h12l.9 1H5.1zM6 15h6v3H6zm15.3.8l-3.6 3.6l-1.6-1.6L15 19l2.8 3l4.8-4.8z" />
                                                                </svg>
                                                            </div>
                                                            ${product.done_qty}
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-primary text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M12 6a1 1 0 0 0-.993.883L11 7v5l.009.131a1 1 0 0 0 .197.477l.087.1l3 3l.094.082a1 1 0 0 0 1.226 0l.094-.083l.083-.094a1 1 0 0 0 0-1.226l-.083-.094L13 11.585V7l-.007-.117A1 1 0 0 0 12 6"/></svg>
                                                            </div>
                                                            ${product.waiting_qty}
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-warning text-dark">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M3 4a2 2 0 0 0-2 2v11h2a3 3 0 0 0 3 3a3 3 0 0 0 3-3h6a3 3 0 0 0 3 3a3 3 0 0 0 3-3h2v-5l-3-4h-3V4m-7 2l4 4l-4 4v-3H4V9h6m7 .5h2.5l1.97 2.5H17M6 15.5A1.5 1.5 0 0 1 7.5 17A1.5 1.5 0 0 1 6 18.5A1.5 1.5 0 0 1 4.5 17A1.5 1.5 0 0 1 6 15.5m12 0a1.5 1.5 0 0 1 1.5 1.5a1.5 1.5 0 0 1-1.5 1.5a1.5 1.5 0 0 1-1.5-1.5a1.5 1.5 0 0 1 1.5-1.5" />
                                                                </svg>
                                                            </div>
                                                            ${product.on_process_qty}
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-danger text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                                                    <path fill="currentColor" d="m4.036 2.488l6.611 2.833L8 6.455L1.427 3.638c.148-.151.329-.273.535-.352zm1.338-.514l1.55-.596a3 3 0 0 1 2.153 0l4.962 1.908c.205.08.386.2.534.352l-2.656 1.138zm9.62 2.572L8.5 7.329v7.45q.295-.05.577-.158l4.962-1.909a1.5 1.5 0 0 0 .961-1.4V4.686q0-.07-.007-.14M7.5 14.779v-7.45L1.007 4.546a2 2 0 0 0-.007.14v6.626a1.5 1.5 0 0 0 .962 1.4l4.961 1.909q.282.108.577.158" />
                                                                </svg>
                                                            </div>
                                                            ${product.left_qty}
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>  
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <label for="price-buy-${product.id}" class="form-label" style="font-size: 12px">Harga Beli ke Principle (Rp)</label>
                                                    <input type="number" name="price-buy-${product.id}" class="form-control" placeholder="Rp. ">
                                                </div>
                                                <div>
                                                    <label for="process-qty-${product.id}" class="form-label" style="font-size: 12px">Proses sebanyak (Pkg)</label>
                                                    <input type="number" name="process-qty-${product.id}" max="${product.left_qty}" class="form-control" placeholder="${product.left_qty} Pkg Belum diproses" ${product.left_qty == 0 ? 'disabled' : ''}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        // Tambahkan input qty ke container
                    });
                    $('#qty-container').html(qtyInput);
                }
            })
        }
    });


    // ---------- Edit -----------
    function setEditProcess(processId) {
        // URL untuk mendapatkan data process berdasarkan process_id
        var url = '/ajax/purchase/' + purchaseId + '/process/' + processId;

        // Lakukan Ajax request
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                // Berhasil mendapatkan data, isi form di modal
                if (response.success) {
                    console.log(response);
                    // Isi nomor Process Purchase Order
                    $('#edit-id-process').val(processId);
                    $('#edit-no').val(response.data.process.no || 'N/A');

                    // Isi file inputan (biasanya untuk file tidak bisa langsung diisi, tapi kita bisa menampilkan nama file sebelumnya)
                    if(response.data.process.spk_file != "" && response.data.process.spk_file != null){
                        let fileSPK = '/storage/'+response.data.process.spk_file ;
                        editFileSPK.addFile(fileSPK);
                    }

                    if(response.data.process.surjal_file != "" && response.data.process.surjal_file != null){
                        let fileSurjal = '/storage/'+response.data.process.surjal_file;
                        editFileSurjal.addFile(fileSurjal);
                    }

                    // Isi tanggal surat
                    const editDatePicker = $('#edit-date')._flatpickr;
                    if (editDatePicker) {
                        editDatePicker.setDate(response.data.process.date, true); // The second parameter 'true' triggers the change event
                    }

                    // Pilih principle yang sesuai
                    editPrincipleChoices.setChoiceByValue(response.data.process.principle_id);
                    $.ajax({
                        url: `/ajax/principle/${response.data.process.principle_id}`,
                        type: 'GET',
                        success: function(data){
                            const formattedData = data.addresses.map(item => ({
                                value: `${item.id}`,
                                label: `${item.address_tag} @ ${item.address}, ${item.city}, ${item.postal_code}`,
                            }));
                            editJemputChoices.clearChoices();
                            editJemputChoices.setChoices(formattedData);
                            editJemputChoices.setChoiceByValue(response.data.process.address_id || '');
                            Toast.fire({
                                icon: 'success',
                                title: 'Menerapkan principle / supplier',
                            })
                        }
                    })
                    // Cek apakah pengiriman diatur oleh Sahara
                    $('#edit-is-logistic-sahara').prop('checked', response.data.process.is_logistic_in_sahara == 1).trigger('change');

                    // Pilih logistic yang sesuai
                    editLogisticChoices.setChoiceByValue(response.data.process.logistic_id || '');

                    $('#edit-product-ids').val(JSON.parse(response.data.process.products).join(','));

                    $('span.no-process').text(response.data.process.no);
                    // Pilih alamat penjemputan

                    // Isi deskripsi
                    $('#edit-description').val(response.data.process.description || '');

                    let qtyInput = ``;
                    response.data?.products?.forEach(function(product){
                        qtyInput += `
                            <div class="col-md-12">
                                <div class="card mb-3 bg-light-secondary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center flex-column flex-sm-row gap-2 justify-content-between">
                                            <div class="d-flex flex-column flex-wrap align-items-start gap-1">
                                                <div>
                                                    <h6 class="m-0">${product.product.title}</h6>
                                                </div>
                                                <div class="">
                                                    <div class="mb-3 d-flex align-items-center gap-3 justify-content-md-start" style="font-size: 13px">
                                                        <div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                    <path d="m7.5 4.27l9 5.15M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                                                    <path d="m3.3 7l8.7 5l8.7-5M12 22V12" />
                                                                </g>
                                                            </svg>
                                                        </div>
                                                        x${product.qty}
                                                    </div>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-success text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M6 3q-.75 0-1.2.6L3.5 5.2c-.3.4-.5.8-.5 1.3V19c0 1.1.9 2 2 2h8.3c-.2-.6-.3-1.3-.3-2c0-3.3 2.7-6 6-6c.7 0 1.4.1 2 .3V6.5c0-.5-.2-.9-.5-1.3l-1.4-1.7c-.2-.3-.6-.5-1.1-.5zm-.1 1h12l.9 1H5.1zM6 15h6v3H6zm15.3.8l-3.6 3.6l-1.6-1.6L15 19l2.8 3l4.8-4.8z" />
                                                                </svg>
                                                            </div>
                                                            ${product.done_qty}
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-primary text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34M12 6a1 1 0 0 0-.993.883L11 7v5l.009.131a1 1 0 0 0 .197.477l.087.1l3 3l.094.082a1 1 0 0 0 1.226 0l.094-.083l.083-.094a1 1 0 0 0 0-1.226l-.083-.094L13 11.585V7l-.007-.117A1 1 0 0 0 12 6"/></svg>
                                                            </div>
                                                            ${product.waiting_qty} ${product.edited_qty ? '<span class="text-danger">-'+product.edited_qty+'</span>' : ''}
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-warning text-dark">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M3 4a2 2 0 0 0-2 2v11h2a3 3 0 0 0 3 3a3 3 0 0 0 3-3h6a3 3 0 0 0 3 3a3 3 0 0 0 3-3h2v-5l-3-4h-3V4m-7 2l4 4l-4 4v-3H4V9h6m7 .5h2.5l1.97 2.5H17M6 15.5A1.5 1.5 0 0 1 7.5 17A1.5 1.5 0 0 1 6 18.5A1.5 1.5 0 0 1 4.5 17A1.5 1.5 0 0 1 6 15.5m12 0a1.5 1.5 0 0 1 1.5 1.5a1.5 1.5 0 0 1-1.5 1.5a1.5 1.5 0 0 1-1.5-1.5a1.5 1.5 0 0 1 1.5-1.5" />
                                                                </svg>
                                                            </div>
                                                            ${product.on_process_qty}
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 justify-content-md-start" style="font-size: 13px">
                                                            <div class="d-flex align-items-center justify-content-center p-1 rounded-2 bg-danger text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                                                    <path fill="currentColor" d="m4.036 2.488l6.611 2.833L8 6.455L1.427 3.638c.148-.151.329-.273.535-.352zm1.338-.514l1.55-.596a3 3 0 0 1 2.153 0l4.962 1.908c.205.08.386.2.534.352l-2.656 1.138zm9.62 2.572L8.5 7.329v7.45q.295-.05.577-.158l4.962-1.909a1.5 1.5 0 0 0 .961-1.4V4.686q0-.07-.007-.14M7.5 14.779v-7.45L1.007 4.546a2 2 0 0 0-.007.14v6.626a1.5 1.5 0 0 0 .962 1.4l4.961 1.909q.282.108.577.158" />
                                                                </svg>
                                                            </div>
                                                            ${product.left_qty}  ${product.edited_qty ? '<span class="text-success">+'+product.edited_qty+'</span>' : ''}
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>  
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <label for="price-buy-${product.id}" class="form-label" style="font-size: 12px">Harga Beli ke Principle (Rp)</label>
                                                    <input type="number" name="price-buy-${product.id}" value="${product.price_buy}" class="form-control" placeholder="Rp. ">
                                                </div>
                                                <div>
                                                    <label for="process-qty-${product.id}" class="form-label" style="font-size: 12px">Proses sebanyak (Pkg)</label>
                                                    <input type="number" name="process-qty-${product.id}" value="${product.edited_qty}" max="${product.left_qty}" class="form-control" placeholder="${product.left_qty} Pkg Belum diproses" ${product.left_qty == 0 ? 'disabled' : ''}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    })
                    // Tambahkan input qty ke container
                    $('#edit-qty-container').html(qtyInput);

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
        console.log('Clicked Edit Process Button',processId);
        setEditProcess(processId);
    });

    $('#submit-edit').on('click',function (e) {
        e.preventDefault();
        let processId = $('#edit-id-process').val();
        console.log('Edit Clicked', processId);
        
        // Define FormData and add other fields
        let formData = new FormData();
        formData.append('no', $('#edit-no').val());
        formData.append('date', $('#edit-date').val());
        formData.append('principle', $('#edit-principle').val());
        formData.append('is_logistic_sahara', $('#edit-is-logistic-sahara').is(':checked') ? 1 : 0);
        formData.append('logistic', $('#edit-logistic').val());
        formData.append('address_jemput', $('#edit-address-jemput').val());
        formData.append('description', $('#edit-description').val());

        // Append files if present
        const fileSPKFiles = editFileSPK.getFiles();
        if (fileSPKFiles.length > 0) {
            formData.append('file_spk', fileSPKFiles[0].file);
        }

        const fileSurjalFiles = editFileSurjal.getFiles();
        if (fileSurjalFiles.length > 0) {
            formData.append('file_surjal', fileSurjalFiles[0].file);
        }

        // Retrieve and process product IDs
        let productIds = $('#edit-product-ids').val().split(',');
        console.log(productIds);
        // Append each product ID as 'products[]' to ensure it is recognized as an array in Laravel
        productIds.forEach(productId => {
            formData.append('products[]', productId);

            let inputQty = $(`#editProcessModal input[name="process-qty-${productId}"]`).val();
            formData.append(`process-qty-${productId}`, inputQty);

            let inputPb = $(`#editProcessModal input[name="price-buy-${productId}"]`).val();
            formData.append(`price-buy-${productId}`, inputPb);
        });

        // Log the contents of formData
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        // URL untuk mengupdate, pastikan sesuai dengan route di server
        let updateUrl = `/purchase/${purchaseId}/process/${processId}/edit`;

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
                    title: 'Data tidak valid, pastikan qty tidak melebihi permintaan , Error: '+ response.error
                });
            }
        });
    });
});
</script>
@endsection