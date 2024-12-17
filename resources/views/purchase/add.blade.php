@extends('templates.crud.add', ['routeName'=>'purchase'])

@section('title', 'Add Purchase / Request Order')
@section('description', 'Add Purchase Data from client / Request Order')

@section('form')
    <style>
        .btn-content.active {
            background-color: #4f15d6 !important;
            color: white !important;
        }
        .btn-content.active *{
            color: white !important;
        }
    </style>

    <form id="ro-form" action="{{route('purchase.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="position-sticky top-0 pt-2" style="z-index: 999">
                            <div class="row">
                                <div class="col-6">
                                    <div class="btn-content btn-content-purchase-data d-flex align-items-center bg-white p-3 shadow-sm rounded-4 gap-3 mb-3" style="cursor: pointer;">
                                        <div class="d-flex align-items-center justify-content-center p-2" style="aspect-ratio:1/1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58s1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41s-.23-1.06-.59-1.42M5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4S7 4.67 7 5.5S6.33 7 5.5 7" />
                                            </svg>
                                        </div>
                                        <div class="">
                                            <h6 class="m-0"><span class="d-none d-sm-inline-block">Purchase</span> Data</h6>
                                            <p class="text-secondary m-0 d-none d-md-block ">Isi Data Penawaran</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="btn-content btn-content-purchase-product d-flex align-items-center bg-white justify-content-end p-3 shadow-sm rounded-4 gap-3 mb-3" style="cursor: pointer;">
                                        <div class="text-end">
                                            <h6 class="m-0"><span class="d-none d-sm-inline-block">Purchase</span> Product</h6>
                                            <p class="text-secondary m-0 d-none d-md-block ">Pilih atau Isi Purchase Product</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center p-2" style="aspect-ratio:1/1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M11 21.725v-9.15L3 7.95v8.025q0 .55.263 1T4 17.7zm2 0l7-4.025q.475-.275.738-.725t.262-1V7.95l-8 4.625zm3.975-13.75l2.95-1.725L13 2.275Q12.525 2 12 2t-1 .275L9.025 3.4zM12 10.85l2.975-1.7l-7.925-4.6l-3 1.725z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Quotation Data --}}
                        <div class="content-purchase-data active" style="display: none">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="no" class="form-label">No. Request Order (Automatic)</label>
                                        <input type="text" id="no" name="no" class="form-control" placeholder="No. Purchase" value="RO/xxx/RSM/x/xxxx" disabled value="{{ old('no') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Date Purchase <span class="text-danger">*</span></label>
                                        <input type="date" name="date" id="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                                        <select id="client" name="client" class="form-select">
                                            <option value="">Pilih Client</option>
                                            @forelse ($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                            @empty
                                            <option value="">Tidak ada client tersedia</option>
                                            @endforelse
                                        </select>
                                        <div id="client-detail">
                                        </div>
                                        <div class="text-secondary">Client belum terdaftar? <a href="{{route('client.add')}}" target="_blank" class="ms-2">Tambah Client</a></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quotation" class="form-label">Refrensi Quotation (Jika Ada)</label>
                                        <select id="quotation" name="quotation" class="form-select">
                                            <option value="">Pilih Quotation (Pilih Client terlebih dahulu)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Kirim Ke Alamat <span class="text-danger">*</span> <span id="load-data" class="p-1 px-2 rounded-3 bg-light-primary" style="cursor: pointer">update</span></label>
                                        <select id="address" name="address" class="form-select">
                                            <option value="">Pilih Address</option>
                                        </select>
                                        <div id="address-detail">
                                        </div>
                                        <div class="text-secondary">Tidak ada alamat yang sesuai untuk dikirim? <a href="" id="address-link" target="_blank" class="ms-2">Tambah Alamat Client</a></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="nosurat" class="form-label">Nomor Refrensi Surat Req. Order <span class="text-danger">*</span></label>
                                        <input type="text" name="nosurat" id="nosurat" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="file-purchase" class="form-label">File Request Order <span class="text-danger">*</span></label>
                                        <input type="file" name="file-purchase" id="file-purchase">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea id="description" cols="30" rows="5" name="description"></textarea>
                                    </div>
                                </div>
                                {{-- Submit Button --}}
                                <div class="com-md-12">
                                    <button type="button" class="btn-to-product d-block btn btn-light-secondary w-100">Next to Add Product</button>
                                </div>
                            </div>
                        </div>

                        {{-- Quotation Product Add --}}
                        <div class="content-purchase-product" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="m-0">Pruchase Products</h6>
                                        <button type="button" class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addProduct"
                                            >Add Product
                                        </button>
                                    </div>
                                </div>
                                <div id="productList" class="col-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 p-3 border rounded-3">
                                        <div>
                                            <h6 class="m-0">Product Name</h6>
                                            <p class="m-0 text-muted" style="font-size: 13px">Lorem ipsum dolor sit amet jamet mantap met</p>
                                        </div>
                                        <div class="ms-md-auto">
                                            <div class="fw-bold">Rp 17.000,00 / Liter</div>
                                            <div class="d-flex align-items-center gap-3 justify-content-md-end" style="font-size: 13px">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                            <path d="m7.5 4.27l9 5.15M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                                            <path d="m3.3 7l8.7 5l8.7-5M12 22V12" />
                                                        </g>
                                                    </svg>
                                                </div>
                                                205 Liter per Drum
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="d-flex align-items-center justify-content-center btn btn-sm btn-outline-primary block" style="aspect-ratio:1/1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                    </g>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger block" style="aspect-ratio:1/1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <button type="button" id="saveRequestOrder" class="btn btn-primary w-100">Save Request Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

{{-- Modal confirmProduct --}}
<div class="modal fade" id="confirmProduct" tabindex="-1" role="dialog"
aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header border-0 ">
                <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation use Product from Quotation?</h5>
                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                    </svg>
                </button>
            </div>
            <div class="modal-body border-0 py-0">
                <p>Anda memilih refrensi quotation pada Purchase Data, Gunakan data products dari quotation tersebut ?</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <span>No</span>
                </button>
                <button type="button" id="btnConfirmProduct" class="btn btn-primary">Yes</button>
            </div>
        </div>
    </div>
</div>

    {{-- Modal AddProduct --}}
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header border-0 ">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Product </h5>
                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                    </svg>
                </button>
            </div>
            <div class="modal-body border-0 py-0">
                <div class="content-tab">
                    {{-- Tab Add By Select Product --}}
                    <div class="form-purchase">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="product" class="form-label">Product <span class="text-danger">*</span></label>
                                    <select id="product" name="product" required class="form-select">
                                        <option value="">Pilih Product</option>
                                        @foreach ($products as $product)
                                        <option value="{{$product->id}}" {{ $product->title === old('product') ? 'selected' : '' }}>{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="id-satuan" value="{{old('id-satuan')}}">
                                <input type="hidden" name="product-satuan" value="{{old('product-satuan')}}">
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price Sale / item <span class="text-danger">*</span></label>
                                    <input type="text" id="price" name="price" placeholder="Rp 0,00" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="qty" class="form-label">Qty of Packaging<span class="text-danger">*</span></label>
                                <input type="number" name="qty" id="qty" class="form-control" placeholder="0" required>
                                <div id="qty-product" class=" mt-2 text-secondary" style="font-size: 12px">
                                    Total qty products : <span class="count">NaN</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="packaging" class="form-label">Packaging <span class="text-danger">*</span><a href="#" class="ms-2" data-bs-toggle="tooltip" title="Pilih product terlebih dahulu">?</a></label>
                                <select id="packaging" name="packaging" required class="form-select">
                                    <option value="">Pilih Packaging</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="qdescription" class="form-label">Description</label>
                                    <textarea name="qdescription" id="qdescription" cols="20" rows="5" class="form-control">{{old('description')}}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="rounded-4 p-3 bg-light-secondary">
                                    <div class="mb-2">Product belum ada atau tidak ditemukan ? </div>
                                    <button type="button" class="btn-form-add-product btn btn-outline-primary rounded-pill px-3 d-inline-flex align-items-center gap-2">
                                        Add New Product
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" fill-rule="evenodd" d="M10.159 10.72a.75.75 0 1 0 1.06 1.06l3.25-3.25L15 8l-.53-.53l-3.25-3.25a.75.75 0 0 0-1.061 1.06l1.97 1.97H1.75a.75.75 0 1 0 0 1.5h10.379z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab Add New Product --}}
                    <div class="form-product">
                        <form action="" class="w-100">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn-form-back btn btn-light-secondary mb-3 rounded-pill px-3 d-inline-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" fill-rule="evenodd" d="M5.841 5.28a.75.75 0 0 0-1.06-1.06L1.53 7.47L1 8l.53.53l3.25 3.25a.75.75 0 0 0 1.061-1.06l-1.97-1.97H14.25a.75.75 0 0 0 0-1.5H3.871z" clip-rule="evenodd" />
                                        </svg>
                                        Back to Add Purchase Product
                                    </button>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Product Name</label>
                                                        <input type="text" name="title" class="form-control" placeholder="Product Name" id="name" value="{{ old('name') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea name="description" id="description" cols="20" rows="5" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="satuan" class="form-label">Satuan</label>
                                                        <select id="satuan" name="satuan" class="form-select">
                                                            <option value="">Pilih satuan</option>
                                                            @forelse ($satuans as $satuan)
                                                            <option value="{{$satuan->id}}">{{$satuan->name}}</option>
                                                            @empty
                                                            <option value="">Tidak ada satuan tersedia</option>
                                                            @endforelse
                                                        </select>
                                                        <div class="text-secondary">Tidak menemukan satuan yang pas? <a href="{{route('satuan.index')}}" class="ms-2 btn btn-sm btn-secondary">Tambah Satuan</a></div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary w-100">Add New Product</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <span>Close</span>
                </button>
                <button type="button" id="addPurchaseProduct" class="btn btn-primary">Add Purchase Product</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog"
    aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    {{-- Tab Add By Select Product --}}
                    <div class="form-purchase">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editProduct" class="form-label">Product <span class="text-danger">*</span></label>
                                    <select id="editProduct" name="editProduct" required class="form-select">
                                        <option value="">Pilih Product</option>
                                        @foreach ($products as $product)
                                        <option value="{{$product->id}}" {{ $product->title === old('editProduct') ? 'selected' : '' }}>{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="edit-id-satuan" value="{{old('edit-id-satuan')}}">
                                <input type="hidden" name="edit-product-satuan" value="{{old('edit-product-satuan')}}">
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editPrice" class="form-label">Harga Penawaran per Satuan</label>
                                    <input type="text" id="editPrice" name="editPrice" placeholder="Rp 0,00" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editQty" class="form-label">Qty of Packaging<span class="text-danger">*</span></label>
                                <input type="number" name="editQty" id="editQty" class="form-control" placeholder="0" required>
                                <div id="edit-qty-product" class=" mt-2 text-secondary" style="font-size: 12px">
                                    Total qty products : <span class="count">NaN</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editPackaging" class="form-label">Packaging <span class="text-danger">*</span><a href="#" class="ms-2" data-bs-toggle="tooltip" title="Pilih product terlebih dahulu">?</a></label>
                                <select id="editPackaging" name="editPackaging" required class="form-select">
                                    <option value="">Pilih Packaging</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="editQdescription" class="form-label">Description</label>
                                    <textarea name="editDescription" id="editQdescription" cols="20" rows="5" class="form-control">{{old('description')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <span>Close</span>
                </button>
                <button type="button" id="editQuotationProduct" class="btn btn-primary">Update Quotation Product</button>
            </div>
        </div>
    </div>
</div>

@php
 $userId = Auth::user()->id;  
@endphp
@endsection


@section('scripts')
<script>
    // If you want to use tooltips in your project, we suggest initializing them globally
    // instead of a "per-page" level.
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }, false);
</script>
<script>
    // function previewImage(event) {
    //     var reader = new FileReader();
    //     reader.onload = function(){
    //         var output = document.getElementById('image-preview');
    //         output.src = reader.result;
    //         output.style.display = 'block';
    //     };
    //     reader.readAsDataURL(event.target.files[0]);
    // }

    // Filepond: Image Crop
    FilePond.create(document.querySelector(".image-input"), {
        credits: null,
        allowImagePreview: true,
        allowImageFilter: false,
        allowImageExifOrientation: false,
        allowImageCrop: true,
        acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg", "image/webp"],
        fileValidateTypeDetectType: (source, type) =>
            new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise
            resolve(type)
            }),
        storeAsFile: true,
    })


</script>

<script src="/dist/assets/extensions/flatpickr/flatpickr.min.js"></script>
<script src="/dist/assets/extensions/tinymce/tinymce.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const themeOptions = document.body.classList.contains("dark")
    ? {
            skin: "oxide-dark",
            content_css: "dark",
        }
    : {
            skin: "oxide",
            content_css: "default",
        }

    tinymce.init({
        selector: "#altiny",
        menubar:false,
        statusbar:false,
        toolbar:
            "undo redo styleselect | bold italic underline | bullist numlist code",
        plugins: "code",
        ...themeOptions,
    })

    tinymce.init({
        selector: "#description",
        menubar:false,
        statusbar:false,
        toolbar:
            "undo redo styleselect | bold italic underline | bullist numlist code",
        plugins: "code",
        ...themeOptions,
    })
})

flatpickr('.flatpickr-no-config', {
    enableTime: false,
    dateFormat: "d M Y", 
    defaultDate: "today",
})
</script>
<script src="/dist/assets/static/js/pages/filepond-pdf-preview.js"></script>
<script>
$(document).ready(function() {
    let userId = "{{$userId}}";
    localStorage.removeItem('data_quotation_selected_'+userId);
    localStorage.removeItem('product_purchase_'+userId);

    // Pastikan content-purchase-data aktif di awal
    $('.content-purchase-data').show();
    $('.content-purchase-product').hide();
    $('.btn-content-purchase-data').addClass('active');
    
    // Saat tombol "Data" diklik
    $('.btn-content-purchase-data').click(function() {
        // Sembunyikan konten produk dan tampilkan konten data
        $('.content-purchase-product').hide();
        $('.content-purchase-data').show();
        
        // Menambahkan class active pada tombol yang diklik
        $('.btn-content-purchase-data').addClass('active');
        $('.btn-content-purchase-product').removeClass('active');
    });
    
    $('.btn-to-product').click(function() {
        // Sembunyikan konten data dan tampilkan konten produk
        $('.content-purchase-data').hide();
        $('.content-purchase-product').show();
        
        // Menambahkan class active pada tombol yang diklik
        $('.btn-content-purchase-product').addClass('active');
        $('.btn-content-purchase-data').removeClass('active');
        
        showConfirmModal();
    });

    // Saat tombol "Product" diklik
    $('.btn-content-purchase-product').click(function() {
        // Sembunyikan konten data dan tampilkan konten produk
        $('.content-purchase-data').hide();
        $('.content-purchase-product').show();
        
        // Menambahkan class active pada tombol yang diklik
        $('.btn-content-purchase-product').addClass('active');
        $('.btn-content-purchase-data').removeClass('active');

        showConfirmModal();
    });

    function showConfirmModal(){
        let quotation = JSON.parse(localStorage.getItem('data_quotation_selected_'+userId)) || {};
        let purchase = JSON.parse(localStorage.getItem('product_purchase_'+userId)) || [];
        if(quotation?.products && JSON.parse(quotation.products).length > 0 && purchase.length == 0){
            $('#confirmProduct').modal('show');
        }
    }
    // Form Modal Toggle Content --------------------------    
    $('.form-product').hide();

    // Saat tombol "Data" diklik
    $('.btn-form-add-product').click(function() {
        // Sembunyikan konten produk dan tampilkan konten data
        $('.form-purchase').hide();
        $('.form-product').show();

        $('.btn-submit-purchase').removeAttr("type").attr("type", "button");
        $('.btn-submit-purchase').attr('disabled', true);
    });

    $('.btn-form-back').click(function() {
        // Sembunyikan konten data dan tampilkan konten produk
        $('.form-product').hide();
        $('.form-purchase').show();

        $('.btn-submit-purchase').text('Add Purchase Product');
        $('.btn-submit-purchase').attr('disabled', false);
    });

    const clientChoices = new Choices('#client', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a client',
        removeItemButton: true
    });

    const addressChoices = new Choices('#address', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a Address',
        removeItemButton: true
    });

    const quotationChoices = new Choices('#quotation', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a quotation',
        removeItemButton: true
    });

    const satuanChoices = new Choices('#satuan', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a satuan',
        removeItemButton: true
    });

    const productChoices = new Choices('#product', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a product',
        removeItemButton: true
    });

    const packagingChoices = new Choices('#packaging', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a product',
        removeItemButton: true
    });

    // Inisialisasi Choices.js
    const editProductChoices = new Choices('#editProduct', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Pilih Product',
        removeItemButton: true
    });

    const editPackagingChoices = new Choices('#editPackaging', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Pilih Packaging',
        removeItemButton: true
    });
    FilePond.registerPlugin(FilePondPluginPdfPreview);
    const fileInput = document.querySelector('#file-purchase');
    const filePO = FilePond.create(fileInput, {
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
    });

    // Fungsi untuk format Rupiah
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
    $('#price').on('keyup', function() {
        let value = $(this).val().replace(/[^,\d]/g, '').toString();
        
        let split = value.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

        $(this).val('Rp ' + rupiah);
    });

    $('#address').on('change', function(){
        let addressId = $(this).val();
        let clientId = $('#client').val();

        $.ajax({
            url: `/ajax/address/${addressId}`,
            type: 'GET',
            success: function(data) {
                let addressShow = `
                    <div class="card bg-light-secondary mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="fw-semibold">${data.address_tag}</div>
                                    <div style="font-size:12px" class="text-secondary">Address : ${data.address}, ${data.city} - ${data.postal_code}</div>
                                    <div style="font-size:12px" class="text-secondary">TELP / FAX : ${data.telp} / ${data.fax}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
        
                $('#address-detail').html(addressShow);
            }
        });
    });

    $('#load-data').on('click', function(){
        let clientId = $('#client').val();
        let addressId = $('#address').val();
        if(clientId && clientId != '' && clientId.length > 2){
            $.ajax({
                url: `/ajax/client/${clientId}`,
                type: 'GET',
                success: function(data) {
                    const formattedData = data.addresses.map(item => ({
                        value: `${item.id}`,
                        label: `${item.address_tag} @ ${item.address}, ${item.city}, ${item.postal_code}`,
                    }));
                    addressChoices.clearChoices();
                    addressChoices.setChoices(formattedData);
                    addressChoices.setChoiceByValue(addressId);
                    Toast.fire({
                        icon: 'success',
                        title: 'Mengambil nilai address terbaru',
                    })
                }
            })
        }
    });
    $('#client').on('change', function () {
        let clientId = $(this).val();

        $.ajax({
            url: `/ajax/client/${clientId}`,
            type: 'GET',
            success: function(data) {
                $('#address-link').attr('href', '/client/'+clientId+'/edit');
                addressChoices.clearChoices();
                const formattedData = data.addresses.map(item => ({
                    value: `${item.id}`, // Ambil 'id' sebagai 'value'
                    label: `${item.address_tag} @ ${item.address}, ${item.city}, ${item.postal_code}`, // Gabungkan 'name' dan 'capacity' untuk 'label'
                }));
                addressChoices.setChoices(formattedData);
                $.ajax({
                    url: `/ajax/quotation/client/${clientId}`,
                    type: 'GET',
                    success: function(qt) {
                        quotationChoices.clearChoices();
                        const formattedData = qt.map(item => ({
                            value: `${item.id}`, // Ambil 'id' sebagai 'value'
                            label: `${item.no} (${item.for} | ${item.perihal} - ${formatDate(item.date)})`, // Gabungkan 'name' dan 'capacity' untuk 'label'
                        }));
                        quotationChoices.setChoices(formattedData);
                        Toast.fire({
                            icon: 'success',
                            title: `Menerapkan pilihan Quotation untuk client ${data.name}`,
                        })
                    }
                })
                
                let clientShow = `
                    <div class="card bg-light-secondary mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="fw-semibold">${data.name}</div>
                                    <div style="font-size:12px" class="text-secondary">NPWP : ${data.npwp}</div>
                                    <div style="font-size:12px" class="text-secondary">${data.email}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M6 17c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1H6m9-9a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3a3 3 0 0 1 3 3M3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2" />
                                            </svg>
                                        </div>
                                        <h6 class="m-0" style="font-size: 13px">PIC Contact</h6>
                                    </div>
                                    <div class="fw-semibold">
                                        ${data.contact_name}
                                    </div>
                                    <div style="font-size:12px" class="text-secondary">${data.contact_email}, ${data.contact_phone}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#client-detail').html(clientShow);
            }
        });
    });

    // Quotation
    $('#quotation').on('change', function (){
        let qtId = $(this).val();

        if(qtId != 'undefined' || qtId != null || qtId != ''){
            $.ajax({
                url: `/ajax/quotation/${qtId}`,
                type: 'GET',
                success: function(data){
                    localStorage.setItem('data_quotation_selected_'+userId, JSON.stringify(data));
                    Toast.fire({
                        icon: 'success', 
                        title: `Berhasil memilih dan menyimpan nilai quotation : ${data.no} ke localstorage`
                    })
                }
            })
        }else{
            localStorage.removeItem('data_quotation_selected_'+userId);
        }
    });

    function checkQuotationProduct(){
        let quotation = JSON.parse(localStorage.getItem('data_quotation_selected_'+userId)) || {};
        if(quotation?.products && JSON.parse(quotation.products).length > 0){
            let products = JSON.parse(quotation?.products);
            localStorage.setItem('product_purchase_'+userId, JSON.stringify(products));
            renderProductList();
            Toast.fire({
                icon: 'success',
                title: 'Berhasil menerapkan data product berdasarkan refrensi Quotations'
            })
        }else{
            Toast.fire({
                icon: 'success',
                title: 'Tidak ada products pada data quotations'
            })
        }
    }

    $('#btnConfirmProduct').on('click', function(){
        checkQuotationProduct();
        $('#confirmProduct').modal('hide');
    });
    // Ajax
    $('#product').on('change', function() {
        let productId = $(this).val();

        // Mengambil detail product berdasarkan ID
        $.ajax({
            url: `/ajax/product/${productId}`,
            type: 'GET',
            success: function(data) {
                // Ambil packaging berdasarkan satuan_id dari product
                $.ajax({
                    url: `/ajax/packaging/satuan/${data.id_satuan_barang}`,
                    type: 'GET',
                    success: function(packagings) {
                        packagingChoices.clearChoices();
                        const formattedData = packagings.map(item => ({
                            value: `${item.id}`, // Ambil 'id' sebagai 'value'
                            label: `${item.name} @ ${item.capacity} ${data?.satuan}`, // Gabungkan 'name' dan 'capacity' untuk 'label'
                        }));
                        packagingChoices.setChoices(formattedData);
                        $('textarea#qdescription').val(data.description);
                        $('input[name=id-satuan]').val(data.id_satuan_barang);
                        $('input[name=product-satuan]').val(data.satuan);
                    }
                });
            }
        });
    });

    $('.form-product form').off('submit').on('submit', function(e) {
        e.preventDefault(); // Mencegah form di-submit secara standar

        let formData = $(this).serialize(); // Mengambil semua data form

        $.ajax({
            url: '/ajax/product/add', // Route untuk menyimpan product
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    // Sembunyikan konten data dan tampilkan konten produk
                    $.ajax({
                        url: '/ajax/satuan', // Route untuk mengambil satuan
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            satuanChoices.clearChoices(); // Hapus pilihan sebelumnya
                            const formattedData = data.map(item => (
                                { value: item.id, label: item.name }
                            ));
                            satuanChoices.setChoices(formattedData); // Isi pilihan baru
                        }
                    });
                    
                    // Menampilkan toast sukses
                    Toast.fire({
                        icon: 'success',
                        title: response.message // Pesan sukses dari response JSON
                    });

                    // Update Product
                    $.ajax({
                        url: '/ajax/product', // Route untuk mengambil product
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            productChoices.clearChoices(); // Hapus pilihan sebelumnya
                            const formattedData = data.map(item => (
                                { value: item.id, label: item.title }
                            ));
                            productChoices.setChoices(formattedData); // Isi pilihan baru
                        }
                    });
                    
                    
                    $('.form-product').hide();
                    $('.form-purchase').show();

                    $('.btn-submit-purchase').text('Add Purchase Product');
                    $('.btn-submit-purchase').attr('disabled', false);
                    
                    // Reset form setelah sukses
                    $('.form-product form')[0].reset();

                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Menampilkan pesan error validasi
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';

                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '\n'; // Menggabungkan pesan error
                    });

                    Toast.fire({
                        icon: 'error',
                        title: errorMessage // Pesan error dari validasi
                    });
                } else {
                    // Menampilkan pesan error umum
                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal menambahkan product?. ' + xhr.responseJSON.message
                    });
                }
            }
        });
    });

    $('#qty').on('keyup', function(){
        const count = countQtyProduct();
        $('#qty-product span.count').text(count);
    });
    $('#packaging').on('change', function(){
        const count = countQtyProduct();
        $('#qty-product span.count').text(count);
    });
    $('#editQty').on('keyup', function(){
        const count = countQtyProduct(true);
        $('#edit-qty-product span.count').text(count);
    });
    $('#editPackaging').on('change', function(){
        const count = countQtyProduct(true);
        $('#edit-qty-product span.count').text(count);
    });

    function countQtyProduct(edited = false) {
        // Cek apakah mode 'edited' diaktifkan untuk mengambil nilai yang sesuai
        if (edited) {
            qty = $('#editQty').val();
            packaging = $('#editPackaging').val();
        } else {
            qty = $('#qty').val();
            packaging = $('#packaging').val();
        }

        // Ubah 'qty' menjadi integer untuk memastikan tidak ada nilai string
        qty = parseInt(qty) || 0;

        // Cek apakah 'packaging' mengandung angka, dan ambil angka tersebut
        var number = packaging.match(/\d+/)[0]; // Mengambil angka pertama yang ditemukan
        var value = parseInt(number); // Mengonversi angka menjadi integer
        return value * qty;
    }

    function getCapacity(packaging){
        var number = packaging.match(/\d+/)[0]; // Mengambil angka pertama yang ditemukan
        return parseInt(number); // Mengonversi angka menjadi integer
    }


    $('#saveRequestOrder').on('click', function(){
        saveRequestOrder();
    });

    function saveRequestOrder(){
        let client = $('#client').val();
        let address = $('#address').val();
        let date = $('#date').val();
        let price = $('#price').val().replace(/[^\d]/g, '');
        let quotation = $('#quotation').val();
        let nosurat = $('#nosurat').val();
        let fileRO = filePO.getFiles();
        let description = tinymce.get('description').getContent();
        let products = JSON.parse(localStorage.getItem('product_purchase_' + userId));
        const file = fileRO.length > 0 ? fileRO[0].file : null; // Mengirim file jika ada

        if (products && Array.isArray(products)) {
            let isValid = products.every(product => product.hasOwnProperty('qty') && product.qty > 0);

            if (isValid) {
                let formData = new FormData(); // Membuat form data untuk mengirim file

                // Menambahkan field ke dalam formData
                formData.append('client', client);
                formData.append('address', address);
                formData.append('date', date);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('price', price);
                formData.append('quotation', quotation);
                formData.append('po_number', nosurat);
                formData.append('po_file', file); // File PO
                formData.append('description', description);
                formData.append('products', JSON.stringify(products)); // Produk dalam bentuk JSON string

                $.ajax({
                    url: '/purchase/add',
                    type: 'POST',
                    data: formData,
                    processData: false, // Agar jQuery tidak memproses data
                    contentType: false, // Agar jQuery tidak mengatur Content-Type
                    success: function(response) {
                        if (response.success) {
                            // Menampilkan alert sukses menggunakan SweetAlert Toast.fire
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            window.location.href = response.redirect_url;
                        } else {
                            // Menampilkan alert error jika terjadi kesalahan
                            Toast.fire({
                                icon: 'error',
                                title: response.error
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Gagal menyimpan Request Order. ' + xhr.responseText
                        });
                    }
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Ada product RO / Purchase dengan data Qty yang belum benar'
                });
            }
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Products Kosong atau tidak ditemukan'
            });
        }
    }


    // Fungsi untuk menyimpan atau memperbarui produk ke localStorage
    function saveQuotationToLocalStorage(index = null) {
        
        let productId = $('#product').val();
        let productTitle = $('#product option:selected').text();
        let description = $('#qdescription').val();
        let priceSale = $('#price').val().replace(/[^\d]/g, ''); // Hilangkan format Rp
        let idSatuan = $('input[name=id-satuan]').val();
        let satuan = $('input[name=product-satuan]').val();
        let qty = $('#qty').val();
        let packagingId = $('#packaging').val();
        let packaging = $('#packaging option:selected').text();

        // Buat objek produk
        let productPurchase = {
            id: productId,
            title: productTitle,
            description: description,
            id_satuan: idSatuan,
            satuan: satuan,
            qty: qty,
            price_sale: priceSale,
            packaging: packaging,
            packaging_id: packagingId,
        };

        // Ambil array dari localStorage atau buat array baru jika belum ada
        let quotations = JSON.parse(localStorage.getItem('product_purchase_'+userId)) || [];

        if (index !== null) {
            // Edit produk di array berdasarkan index
            quotations[index] = productPurchase;
        } else {
            // Tambahkan produk baru ke array
            quotations.push(productPurchase);
        }

        // Simpan array ke localStorage
        localStorage.setItem('product_purchase_'+userId, JSON.stringify(quotations));
        
        // Update tampilan HTML setelah menyimpan
        renderProductList();
    }

    // Event listener untuk tombol Add Purchase Product
    $('#addPurchaseProduct').off('click').on('click', function() {
        saveQuotationToLocalStorage(); // Panggil fungsi untuk menyimpan produk
        $('#addProduct').modal('hide');
    });

    $('#editProduct').on('change', function() {
        let productId = $(this).val();

        // Mengambil detail product berdasarkan ID
        $.ajax({
            url: `/ajax/product/${productId}`,
            type: 'GET',
            success: function(data) {
                // Ambil packaging berdasarkan satuan_id dari product
                $.ajax({
                    url: `/ajax/packaging/satuan/${data.id_satuan_barang}`,
                    type: 'GET',
                    success: function(packagings) {
                        editPackagingChoices.clearChoices();
                        const formattedData = packagings.map(item => ({
                            value: `${item.id}`, // Ambil 'id' sebagai 'value'
                            label: `${item.name} @ ${item.capacity} ${data.satuan}`, // Gabungkan 'name' dan 'capacity' untuk 'label'
                        }));
                        editPackagingChoices.setChoices(formattedData);
                        $('textarea#editQdescription').val(data.description);
                        $('input[name=edit-id-satuan]').val(data.id_satuan_barang);
                        $('input[name=edit-product-satuan]').val(data.satuan);
                    }
                });
            }
        });
    });

    // Event untuk mengisi modal edit saat tombol edit diklik
    $(document).on('click', '.edit-product', function() {
        let index = $(this).data('index');
        let quotations = JSON.parse(localStorage.getItem('product_purchase_'+userId)) || [];
        let product = quotations[index];

        // Isi form edit dengan data produk yang akan diedit
        editProductChoices.setChoiceByValue(product.id);
        // Check if id_satuan is defined before making the AJAX call
        if (product.id_satuan) {
            $.ajax({
                url: `/ajax/packaging/satuan/${product.id_satuan}`,
                type: 'GET',
                success: function(packagings) {
                    editPackagingChoices.clearChoices();
                    const formattedData = packagings.map(item => ({
                        value: `${item.id}`, // Use 'id' as 'value'
                        label: `${item.name} @ ${item.capacity} ${product.satuan}`, // Combine 'name' and 'capacity' for 'label'
                    }));
                    editPackagingChoices.setChoices(formattedData);
                    editPackagingChoices.setChoiceByValue(product.packaging_id);
                },
                error: function(xhr) {
                    console.error('Error fetching packagings:', xhr);
                }
            });
        }else{
            $.ajax({
                url: `/ajax/packaging`,
                type: 'GET',
                success: function(packagings) {
                    editPackagingChoices.clearChoices();
                    const formattedData = packagings.map(item => ({
                        value: `${item.id}`, // Use 'id' as 'value'
                        label: `${item.name} @ ${item.capacity} ${product.satuan}`, // Combine 'name' and 'capacity' for 'label'
                    }));
                    editPackagingChoices.setChoices(formattedData);
                    editPackagingChoices.setChoiceByValue(product.packaging_id);
                },
                error: function(xhr) {
                    console.error('Error fetching packagings:', xhr);
                }
            });
        }
        $('#editQdescription').val(product.description);
        $('#editPrice').val(formatRupiah(product.price_sale));
        $('#editQty').val(product?.qty ?? 0);
        $('textarea#editQdescription').val(product.description);
        $('input[name=edit-id-satuan]').val(product.id_satuan);
        $('input[name=edit-product-satuan]').val(product.satuan);


        // Ubah event tombol simpan di modal edit
        $('#editQuotationProduct').off('click').on('click', function() {
            saveEditedQuotationToLocalStorage(index);
            $('#editProductModal').modal('hide'); // Tutup modal setelah menyimpan perubahan
        });
    });


    // Fungsi untuk me-render daftar produk
    function renderProductList(edited = false) {
        let quotations = JSON.parse(localStorage.getItem('product_purchase_'+userId)) || [];
        
        // Pastikan ada data sebelum merender
        if (quotations.length === 0) {
            $('#productList').html('<p>No products added.</p>');
            return; // Keluar dari fungsi jika tidak ada produk
        }

        let productListHtml = '';

        quotations.forEach((product, index) => {
            productListHtml += `
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 p-3 border rounded-3">
                    <div style="min-width:15em">
                        <h6 class="m-0">${product?.title} <span class="fw-base text-light-secondary" style="font-size:10px">x ${product?.qty ? product.qty * getCapacity(product?.packaging) : 'qty belum ditentukan (silahkan edit)'}</span></h6>
                        <p class="m-0 text-muted" style="font-size: 13px">${product?.description}</p>
                    </div>
                    <div class="ms-md-auto text-end">
                        <div class="fw-bold" style="font-size:14px">${formatRupiah(product?.price_sale)} / ${product?.satuan}</div>
                        <div class="d-flex align-items-center gap-3 justify-content-md-end" style="font-size: 13px">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="m7.5 4.27l9 5.15M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                        <path d="m3.3 7l8.7 5l8.7-5M12 22V12" />
                                    </g>
                                </svg>
                            </div>
                            <span class="fw-bold">${product?.qty ?? 'qty belum ditentukan (silahkan edit)'}</span> * ${product?.packaging}
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="d-flex align-items-center justify-content-center btn btn-sm btn-outline-primary block edit-product" style="aspect-ratio:1/1" data-index="${index}" data-bs-toggle="modal" data-bs-target="#editProductModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                    <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                </g>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger block delete-product" style="aspect-ratio:1/1" data-index="${index}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
        });

        // Update HTML ke elemen dengan ID tertentu, misalnya #productList
        $('#productList').html(productListHtml);
    }
    
    // Fungsi untuk menyimpan atau memperbarui produk ke localStorage
    function saveEditedQuotationToLocalStorage(index) {
        // Ambil nilai dari form edit
        let productId = $('#editProduct').val();
        let productTitle = $('#editProduct option:selected').text();
        let description = $('#editQdescription').val();
        let qty = $('#editQty').val();
        let priceSale = $('#editPrice').val().replace(/[^\d]/g, ''); // Hilangkan format Rp
        let satuan = $('input[name=edit-product-satuan]').val();
        let idSatuan = $('input[name=edit-id-satuan]').val();
        let packaging = $('#editPackaging option:selected').text();
        let packagingId = $('#editPackaging').val();

        // Buat objek produk yang akan diedit
        let productPurchase = {
            id: productId,
            title: productTitle,
            description: description,
            id_satuan: idSatuan,
            satuan: satuan,
            price_sale: priceSale,
            qty: qty,
            packaging: packaging,
            packaging_id: packagingId
        };

        // Ambil array dari localStorage atau buat array baru jika belum ada
        let quotations = JSON.parse(localStorage.getItem('product_purchase_'+userId)) || [];

        // Edit produk di array berdasarkan index
        quotations[index] = productPurchase;

        // Simpan array ke localStorage
        localStorage.setItem('product_purchase_'+userId, JSON.stringify(quotations));

        // Update tampilan HTML setelah menyimpan
        renderProductList(true);
    }

    // Delegasikan event listener untuk tombol hapus
    $(document).on('click', '.delete-product', function() {
        let index = $(this).data('index');
        deleteProduct(index);
    });

    // Fungsi untuk mengedit produk
    function editProduct(index) {
        let quotations = JSON.parse(localStorage.getItem('product_purchase_'+userId)) || [];
        let product = quotations[index];
        
        // Ambil packaging berdasarkan satuan_id dari product
        $.ajax({
            url: `/ajax/packaging/satuan/${product.id_satuan}`,
            type: 'GET',
            success: function(packagings) {
                editPackagingChoices.clearChoices();
                const formattedData = packagings.map(item => ({
                    value: `${item.id}`, // Ambil 'id' sebagai 'value'
                    label: `${item.name} @ ${item.capacity} ${product.satuan}`, // Gabungkan 'name' dan 'capacity' untuk 'label'
                }));
                editPackagingChoices.setChoices(formattedData);
                editPackagingChoices.setChoiceByValue(product.packaging_id);
            }
        });

        // Isi form dengan data produk
        productChoices.setChoiceByValue(product.id);
        $('#editQdescription').val(product.description);
        $('#editPrice').val(formatRupiah(product.price_sale));
        $('input[name=edit-id-satuan]').val(product.id_satuan);
        $('input[name=edit-product-satuan]').val(product.satuan);

    }

    // Fungsi untuk menghapus produk
    function deleteProduct(index) {
        let quotations = JSON.parse(localStorage.getItem('product_purchase_'+userId)) || [];
        console.log('clicked');
        // Hapus produk dari array
        quotations.splice(index, 1);

        // Simpan array baru ke localStorage
        localStorage.setItem('product_purchase_'+userId, JSON.stringify(quotations));

        // Render ulang produk
        renderProductList();
    }

    // Fungsi untuk mereset form setelah perubahan disimpan
    function resetForm() {
        $('#product').val('').trigger('change');
        $('#qdescription').val('');
        $('#price').val('');
        $('input[name=product-satuan]').val('');
        $('#packaging').val('');

        // Ubah kembali tombol Add
        $('#addPurchaseProduct').text('Add Purchase Product');
        $('#addPurchaseProduct').off('click').on('click', function() {
            saveQuotationToLocalStorage();
        });
    }

    function setDataProduct(){
        let dataPurchase = JSON.parse(localStorage.getItem('data_purchase_'+userId)) || [];
        $('#date').val(dataPurchase.date);
        clientChoices.setChoiceByValue(dataPurchase.client);
        $('#perihal').val(dataPurchase.perihal);
        $('#for').val(dataPurchase.for);
        $('textarea[name=message]').val(dataPurchase.message);
        $('textarea[name=keterangan]').val(dataPurchase.keterangan);
    }

    // SaveQuotation
    // Event ketika tombol saveQuotation diklik
    $('#saveQuotation').on('click', function() {
        // Ambil data dari localStorage (atau sumber lain)
        let dataPurchase = JSON.parse(localStorage.getItem('data_purchase_'+userId));
        let productPurchases = JSON.parse(localStorage.getItem('product_purchase_'+userId));

        // Tambahkan CSRF token agar Laravel dapat memverifikasi request
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Ubah format tanggal dari '24 Sep 2024' ke '2024-09-24' menggunakan JavaScript
        let date = new Date(dataPurchase.date);
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0'); // getMonth() menghasilkan 0-11, jadi tambahkan 1
        let day = String(date.getDate()).padStart(2, '0');

        // Format manual menjadi YYYY-MM-DD
        let formattedDate = `${year}-${month}-${day}`; // Menghasilkan format YYYY-MM-DD

        // Format data yang akan dikirimkan ke controller
        let dataToSend = {
            client: dataPurchase.client,
            date: formattedDate,
            for: dataPurchase.for,
            message: dataPurchase.message,
            keterangan: dataPurchase.keterangan,
            products: JSON.stringify(productPurchases), // Ubah array ke format JSON
            _token: csrfToken // CSRF token untuk keamanan
        };
        console.log(dataToSend);
        // Lakukan request AJAX POST
        $.ajax({
            url: "{{ route('purchase.store') }}", // Route untuk menambah quotation
            type: "POST",
            data: dataToSend,
            success: function(response) {
                if (response.success) {
                    localStorage.removeItem('data_purchase_'+userId);
                    localStorage.removeItem('product_purchase_'+userId);
                    // Menampilkan toast sukses
                    Toast.fire({
                        icon: 'success',
                        title: response.message // Pesan sukses dari response JSON
                    });
                    window.location.href = "{{ route('purchase.index') }}";
                } else {
                    // Menampilkan toast sukses
                    Toast.fire({
                        icon: 'error',
                        title: response.error // Pesan sukses dari response JSON
                    });
                }
            },
            error: function(xhr, status, error) {
                // Jika request gagal
                Toast.fire({
                    icon: 'error',
                    title: 'Error : '+error+', Status : '+status // Pesan sukses dari response JSON
                });
            }
        });
    });

    function formatDate(dateString) {
        // Konversi string menjadi objek Date
        let date = new Date(dateString);
        
        // Array bulan dalam bahasa Indonesia
        let monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        
        // Dapatkan hari, bulan, dan tahun
        let day = date.getDate();
        let month = monthNames[date.getMonth()];
        let year = date.getFullYear();
        
        // Return format yang diinginkan
        return `${day} ${month} ${year}`;
    }
    setDataProduct();
    // Render product list saat halaman dimuat
    renderProductList();
});
</script>

@endsection