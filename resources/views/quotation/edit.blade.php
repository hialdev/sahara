@extends('templates.crud.add', ['routeName'=>'quotation'])

@section('title', 'Edit Quotation : '.$quotation->no)
@section('description', 'Edit Quotation for '.$quotation->client->name)

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

    <div class="d-flex align-items-center justify-content-end gap-2 mb-3">
        <button type="button" id="resetEdit" class="btn btn-sm btn-light-secondary d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-width="2" d="M20 8c-1.403-2.96-4.463-5-8-5a9 9 0 1 0 0 18a9 9 0 0 0 9-9m0-9v6h-6" />
            </svg>
            Reset Edit
        </button>
        <button type="button" class="btn btn-sm btn-danger d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#danger-{{$quotation->id}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
            </svg>
            Hapus
        </button>
    </div>

    <form action="{{route('quotation.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="position-sticky top-0 pt-2" style="z-index: 999">
                            <div class="row">
                                <div class="col-6">
                                    <div class="btn-content btn-content-quotation-data d-flex align-items-center bg-white p-3 shadow-sm rounded-4 gap-3 mb-3" style="cursor: pointer;">
                                        <div class="d-flex align-items-center justify-content-center p-2" style="aspect-ratio:1/1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58s1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41s-.23-1.06-.59-1.42M5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4S7 4.67 7 5.5S6.33 7 5.5 7" />
                                            </svg>
                                        </div>
                                        <div class="">
                                            <h6 class="m-0"><span class="d-none d-sm-inline-block">Offering</span> Data</h6>
                                            <p class="text-secondary m-0 d-none d-md-block ">Isi Data Penawaran</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="btn-content btn-content-quotation-product d-flex align-items-center bg-white justify-content-end p-3 shadow-sm rounded-4 gap-3 mb-3" style="cursor: pointer;">
                                        <div class="text-end">
                                            <h6 class="m-0"><span class="d-none d-sm-inline-block">Offering</span> Product</h6>
                                            <p class="text-secondary m-0 d-none d-md-block ">Pilih atau Isi Product yang akan ditawarkan</p>
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
                        <div class="content-quotation-data active" style="display: none">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="no" class="form-label">No. Quotation (Automatic)</label>
                                        <input type="text" id="no" name="no" class="form-control" placeholder="No. Quotation" value="{{$quotation->no}}" disabled id="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Date Letter <span class="text-danger">*</span></label>
                                        <input type="date" name="date" id="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." value="{{$quotation->date}}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                                        <select id="client" name="client" class="form-select" required>
                                            <option value="">Pilih Client</option>
                                            @forelse ($clients as $client)
                                            <option value="{{$client->id}}" {{$client->id == $quotation->client->id ? 'selected' : ''}}>{{$client->name}}</option>
                                            @empty
                                            <option value="">Tidak ada client tersedia</option>
                                            @endforelse
                                        </select>
                                        <div id="client-detail">
                                            {{-- <div class="card bg-light-secondary mb-3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="fw-semibold">{{$client->name}}</div>
                                                            <div style="font-size:12px" class="text-secondary">NPWP : {{$client->npwp}}</div>
                                                            <div style="font-size:12px" class="text-secondary">{{$client->email}}</div>
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
                                                                {{$client->contact_name}}
                                                            </div>
                                                            <div style="font-size:12px" class="text-secondary">{{$client->contact_email}}, {{$client->contact_phone}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="text-secondary">Client belum terdaftar? <a href="{{route('client.add')}}" class="ms-2">Tambah Client</a></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Untuk Perhatian" class="mb-2">Untuk Perhatian <span class="text-danger">*</span></label>
                                        <input type="text" id="for" name="for" class="form-control" placeholder="Bpk / Ibu / Pimpinan" value="{{old('for', $quotation->for)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="perihal" class="mb-2">Perihal <span class="text-danger">*</span></label>
                                        <input type="text" id="perihal" name="perihal" class="form-control" required placeholder="Default : Penawaran Harga" value="{{ old('perihal', $quotation->perihal)}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Pesan <span class="text-danger">*</span></label>
                                        <textarea id="altiny" cols="30" rows="5" name="message" required>{{old('message', $quotation->message)}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">keterangan</label>
                                        <textarea id="keterangan" cols="30" rows="5" name="keterangan">{{old('keterangan', $quotation->keterangan)}}</textarea>
                                    </div>
                                </div>
                                {{-- Submit Button --}}
                                <div class="com-md-12">
                                    <button type="button" class="btn-to-product d-block btn btn-light-secondary w-100">Next to Add Product</button>
                                </div>
                            </div>
                        </div>

                        {{-- Quotation Product Add --}}
                        <div class="content-quotation-product" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="m-0">Offering Products</h6>
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
                                            <button class="d-flex align-items-center justify-content-center btn btn-sm btn-outline-primary block" style="aspect-ratio:1/1">
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
                                        <button type="button" id="savePreview" class="btn btn-primary w-100">Preview and Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

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
                    <div class="form-quotation">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga Penawaran per Satuan</label>
                                    <input type="text" id="price" name="price" placeholder="Rp 0,00" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="packaging" class="form-label">Packaging <span class="text-danger">*</span><a href="#" class="ms-2" data-bs-toggle="tooltip" title="Pilih product terlebih dahulu">?</a></label>
                                <select id="packaging" name="packaging" required class="form-select">
                                    <option value="">Pilih Packaging</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="qdescription" class="form-label">Description</label>
                                    <textarea name="description" id="qdescription" cols="20" rows="5" class="form-control">{{old('description')}}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="rounded-4 p-3 bg-light-secondary">
                                    <div class="mb-2">Product belum ada atau tidak ditemukan ? </div>
                                    <button class="btn-form-add-product btn btn-outline-primary rounded-pill px-3 d-inline-flex align-items-center gap-2">
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
                                    <button class="btn-form-back btn btn-light-secondary mb-3 rounded-pill px-3 d-inline-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" fill-rule="evenodd" d="M5.841 5.28a.75.75 0 0 0-1.06-1.06L1.53 7.47L1 8l.53.53l3.25 3.25a.75.75 0 0 0 1.061-1.06l-1.97-1.97H14.25a.75.75 0 0 0 0-1.5H3.871z" clip-rule="evenodd" />
                                        </svg>
                                        Back to Add Quotation Product
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
                <button type="button" id="addQuotationProduct" class="btn btn-primary">Add Quotation Product</button>
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
                    <div class="form-quotation">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPrice" class="form-label">Harga Penawaran per Satuan</label>
                                    <input type="text" id="editPrice" name="editPrice" placeholder="Rp 0,00" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
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

{{-- Fullscreen Modal --}}
<!-- full size modal-->
<div class="modal fade text-left w-100" id="previewModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel20" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full"
        role="document">
        <div class="modal-content p-5">
            <div class="h-screen position-relative" style="height: 100vh; overflow-y:auto;overflow-x:hidden">
            <!-- Print content -->
            <div class="print-content PAGE-A4">

                <!-- Content area -->
                

                <div class="print-header mb-4">
                    <!-- <div class="row">
                    <div class="col-3">
                        <img class="img-fluid" src="assets/images/logo.jpeg">
                    </div>
                    <div class="col-9 d-flex align-items-center justify-content-end">
                        <div class="h4 mb-0 text-muted d-inline-block">
                            CONTRACTOR AND SERVICES
                        </div>
                    </div>
                    </div> -->
                    <table class="w-100">
                        <tr>
                            <td>
                                <img height="60" src="{{env('SSO_URL').'/storage/'.$getSet->get('company_logo')->the_value}}">
                            </td>
                            <td class="text-end">
                                <div class="h4 mb-0 text-muted d-inline-block">
                                    {{$getSet->get('company_name')->the_value}}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="print-body mb-4 ml-5 mr-5">
                    <div class="row">
                        <div class="col-7">
                            <div class="p-1">
                                <table class="mb-2 w-100">
                                    <tr>
                                        <td width="60">Nomor</td><td width="10" class="pl-1 pr-1">:</td><td>{{$quotation->no}}</td>
                                    </tr>
                                    <tr>
                                        <td width="60">Lampiran</td><td width="10" class="pl-1 pr-1">:</td><td>-</td>
                                    </tr>
                                    <tr>
                                        <td width="60">Perihal</td><td width="10" class="pl-1 pr-1">:</td><td><span class="previewPerihal">{{$quotation->perihal}}</span></td>
                                    </tr>
                                    <tr>
                                        <td width="60" class="align-top">Kepada</td>
                                        <td width="10" class="pl-1 pr-1 align-top">:</td>
                                        <td>
                                            <span class="previewClientName fw-bold">PT MITRA BETON MANDIRI</span><br>
                                            <span class="previewClientAddress">Jl. Melur Komp. Vila Panam Blok A No. 15 - 16</span><br>
                                            <span class="previewClientPostal">123456</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="60">U.P.</td><td width="10" class="pl-1 pr-1">:</td><td><span class="previewFor">PT MBM</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="p-1 text-end">
                                Jakarta, <span class="previewDate">13 Oktober 2021</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="print-body mb-4 ml-5 mr-5">

                    <p>Dengah hormat,</p>
                    <div id="previewMessage">
                        <p class="mb-3">
                            Bersama ini kami aiukan Penawaran Harga dengan harga dan detil penawaran dijelaskan di bawah ini :
                        </p>
                    </div>

                    <!-- Table with no outer spacing -->
                    <div class="table-responsive mb-4">
                        <table class="table mb-0 table-lg" id="previewTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Packaging</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Product Looping --}}
                                <tr>
                                    <td class="text-bold-500">1</td>
                                    <td>
                                       <div class="fw-semibold">Product Name</div>
                                       <p class="m-0" style="font-size:13px">Description of product in here</p>
                                    </td>
                                    <td>Rp 17.234 / Liter</td>
                                    <td class="text-bold-500">Drum (250 Liter)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="keterangan mb-4">
                        <div>Keterangan :</div>
                        <div id="previewKeterangan">
                            <p class="pl-3">
                                - Pembayaran 30 hari<br />
                            - Minimum pengiriman 40 drum<br />
                            - Harga belum termasuk PPN 10%<br />
                            - Harga FOT Pekanbaru<br />
                            </p>
                        </div>
                    </div>

                    <div>
                        Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
                    </div>
                </div>

                <div class="print-body mb-4 ml-5 mr-5">
                    <div>Hormat Kami,</div>
                    <div class="">{{$getSet->get('company_name')->the_value}}</div>
                    <div class="mt-4 mb-4">&nbsp;</div>
                    <div class=""><u>{{$getSet->get('company_director')->the_value}}</u></div>
                    <div>Direktur</div>
                </div>

                <div class="mt-5 mb-4">&nbsp;</div>


                <div class="print-footer page-footer">
                    <div class="row">
                        <div class="col-6 pr-0">
                            <div class="p-2 pl-4">
                                <h6>{{$getSet->get('company_name')->the_value}}</h6>
                                <p style="max-width: 15em">{{$getSet->get('company_ofcaddress')->the_value}}</p>
                                <h6 class="text-muted">Phone : {{$getSet->get('company_phone')->the_value}}</h6>
                                <h6 class="text-muted">Email : {{$getSet->get('company_mail')->the_value}}</h6>
                            </div>
                        </div>
                        <div class="col-6 pl-0">
                            <div class="p-2 pl-4">
                                <h6>Representative Office</h6>
                                <p style="max-width: 15em">{{$getSet->get('company_repaddress')->the_value}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 pr-0 small" style="background-color: #f89e42;">&nbsp;</div>
                        <div class="col-6 pl-0 small" style="background-color: #4374c4;">&nbsp;</div>
                    </div>
                </div>

                    <!-- /content area -->

                </div>
            <!-- /Print content -->
            </div>
            <div class="position-fixed bottom-0 start-0 end-0 d-flex justify-content-center">
                <div class="d-inline-flex align-items-center bg-white p-2 rounded-pill gap-1 justify-content-center">
                    <button type="button" class="btn btn-light-secondary rounded-pill"
                        data-bs-dismiss="modal">
                        <span class="">Close</span>
                    </button>
                    <button id="saveQuotation" type="button" class="btn btn-primary ms-1 rounded-pill"
                        data-bs-dismiss="modal">
                        <span class="">Save Quotation</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Delete --}}
<div class="modal fade text-left" id="danger-{{$quotation->id}}" tabindex="-1" role="dialog"
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
                Apakah anda yakin menghapus data Quotation dengan nomor <span class="fw-bold">{{$quotation->no}}</span> untuk client <span class="fw-bold">{{$quotation->client->name}}</span> ? data Purchase Order yang terkait mungkin akan terdampak
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>
                <form action="{{route('quotation.destroy', $quotation->id)}}" method="POST">
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
        selector: "textarea[name=keterangan]",
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
    defaultDate: new Date("{{$quotation->date}}"),
})
</script>

<script>
$(document).ready(function() {
    let userId = "{{$userId}}";
    let quotationId = "{{$quotation->id}}";
    // Pastikan content-quotation-data aktif di awal
    $('.content-quotation-data').show();
    $('.content-quotation-product').hide();
    $('.btn-content-quotation-data').addClass('active');
    
    // Saat tombol "Data" diklik
    $('.btn-content-quotation-data').click(function() {
        // Sembunyikan konten produk dan tampilkan konten data
        $('.content-quotation-product').hide();
        $('.content-quotation-data').show();
        
        // Menambahkan class active pada tombol yang diklik
        $('.btn-content-quotation-data').addClass('active');
        $('.btn-content-quotation-product').removeClass('active');
    });

    $('.btn-to-product').click(function() {
        // Sembunyikan konten data dan tampilkan konten produk
        $('.content-quotation-data').hide();
        $('.content-quotation-product').show();
        
        // Menambahkan class active pada tombol yang diklik
        $('.btn-content-quotation-product').addClass('active');
        $('.btn-content-quotation-data').removeClass('active');
    });

    // Saat tombol "Product" diklik
    $('.btn-content-quotation-product').click(function() {
        // Sembunyikan konten data dan tampilkan konten produk
        $('.content-quotation-data').hide();
        $('.content-quotation-product').show();
        
        // Menambahkan class active pada tombol yang diklik
        $('.btn-content-quotation-product').addClass('active');
        $('.btn-content-quotation-data').removeClass('active');
    });


    // Form Modal Toggle Content --------------------------    
    $('.form-product').hide();

    // Saat tombol "Data" diklik
    $('.btn-form-add-product').click(function() {
        // Sembunyikan konten produk dan tampilkan konten data
        $('.form-quotation').hide();
        $('.form-product').show();

        $('.btn-submit-quotation').removeAttr("type").attr("type", "button");
        $('.btn-submit-quotation').attr('disabled', true);
    });

    $('.btn-form-back').click(function() {
        // Sembunyikan konten data dan tampilkan konten produk
        $('.form-product').hide();
        $('.form-quotation').show();

        $('.btn-submit-quotation').text('Add Quotation Product');
        $('.btn-submit-quotation').attr('disabled', false);
    });

    const clientChoices = new Choices('#client', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select a client',
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

    // Event untuk menghitung total ketika price diubah
    $('#editPrice').on('keyup', function() {
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

    $('#client').on('change', function () {
        let clientId = $(this).val();

        $.ajax({
            url: `/ajax/client/${clientId}`,
            type: 'GET',
            success: function(data) {
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
                            value: `${item.name} (${item.capacity} ${data.satuan})`, // Ambil 'id' sebagai 'value'
                            label: `${item.name} (${item.capacity} ${data.satuan})`, // Gabungkan 'name' dan 'capacity' untuk 'label'
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
                    $('.form-quotation').show();

                    $('.btn-submit-quotation').text('Add Quotation Product');
                    $('.btn-submit-quotation').attr('disabled', false);
                    
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

    function saveDataQuotationToLocal(){
        // Ambil nilai dari form
        let date = $('#date').val();
        let client = $('#client').val();
        let perihal = $('#perihal').val();
        let dataFor = $('#for').val();
        let message = tinymce.get('altiny').getContent();
        let keterangan = tinymce.get('keterangan').getContent();

        // Object data
        let dataQuotation = {
            client: client,
            date: date,
            for: dataFor,
            perihal: perihal,
            message: message,
            keterangan: keterangan,
        };

        localStorage.setItem('data_quotation_'+quotationId+userId, JSON.stringify(dataQuotation));
    }

    $('#savePreview').click(function(){
        saveDataQuotationToLocal();
        saveQuotationToLocalStorage();
        populatePreviewModal();
        $('#previewModal').modal('show');
    });

    // Fungsi untuk menyimpan atau memperbarui produk ke localStorage
    function saveQuotationToLocalStorage(index = null) {
        
        let productId = $('#product').val();
        let productTitle = $('#product option:selected').text();
        let description = $('#qdescription').val();
        let priceSale = $('#price').val().replace(/[^\d]/g, ''); // Hilangkan format Rp
        let idSatuan = $('input[name=id-satuan]').val();
        let satuan = $('input[name=product-satuan]').val();
        let packaging = $('#packaging').val();


        // Buat objek produk
        let productQuotation = {
            id: productId,
            title: productTitle,
            description: description,
            id_satuan: idSatuan,
            satuan: satuan,
            price_sale: priceSale,
            packaging: packaging,
        };
        console.log(productQuotation);

        // Ambil array dari localStorage atau buat array baru jika belum ada
        let products = @json($quotation->products);
        products = JSON.parse(products);
        
        let quotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || [];
        console.log('Quotations',quotations);
        console.log('Products',products);
        console.log(quotations.length < 1);
        if(quotations.length < 1){
            localStorage.setItem('product_quotation_'+quotationId+userId, JSON.stringify(products));
            console.log('Setted');
        }

        quotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || [];

        if (index !== null) {
            // Edit produk di array berdasarkan index
            quotations[index] = productQuotation;
        } else {
            const isIdExist = quotations.some(function(quotation) {
                return quotation.id === productQuotation.id;
            });
            // Tambahkan produk baru ke array
            if(productQuotation.id.length > 1 && !isIdExist){
                quotations.push(productQuotation);
            }else{
                console.log('product already exists');
            }
        }

        // Simpan array ke localStorage
        localStorage.setItem('product_quotation_'+quotationId+userId, JSON.stringify(quotations));
        
        // Update tampilan HTML setelah menyimpan
        renderProductList();
    }

    // Event listener untuk tombol Add Quotation Product
    $('#addQuotationProduct').off('click').on('click', function() {
        saveQuotationToLocalStorage(); // Panggil fungsi untuk menyimpan produk
        $('#addProduct').modal('hide'); // Tutup modal setelah menyimpan perubahan
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
                            value: `${item.name} (${item.capacity} ${data.satuan})`, // Ambil 'id' sebagai 'value'
                            label: `${item.name} (${item.capacity} ${data.satuan})`, // Gabungkan 'name' dan 'capacity' untuk 'label'
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
        let quotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || [];
        let product = quotations[index];

        // Isi form edit dengan data produk yang akan diedit
        editProductChoices.setChoiceByValue(product?.id);
        // Check if id_satuan is defined before making the AJAX call
        if (product.id_satuan) {
            $.ajax({
                url: `/ajax/packaging/satuan/${product.id_satuan}`,
                type: 'GET',
                success: function(packagings) {
                    editPackagingChoices.clearChoices();
                    const formattedData = packagings.map(item => ({
                        value: `${item.name} (${item.capacity} ${product.satuan})`, // Use 'id' as 'value'
                        label: `${item.name} (${item.capacity} ${product.satuan})`, // Combine 'name' and 'capacity' for 'label'
                    }));
                    editPackagingChoices.setChoices(formattedData);
                    editPackagingChoices.setChoiceByValue(product.packaging);
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
                        value: `${item.name} (${item.capacity} ${product.satuan})`, // Use 'id' as 'value'
                        label: `${item.name} (${item.capacity} ${product.satuan})`, // Combine 'name' and 'capacity' for 'label'
                    }));
                    editPackagingChoices.setChoices(formattedData);
                    editPackagingChoices.setChoiceByValue(product.packaging);
                },
                error: function(xhr) {
                    console.error('Error fetching packagings:', xhr);
                }
            });
        }
        $('#editQdescription').val(product.description);
        $('#editPrice').val(formatRupiah(product.price_sale));
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
    function renderProductList() {
        let localProductQuotation = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || [];
        // Pastikan ada data sebelum merender
        let dataProductQuotation = @json($quotation->products);
        dataProductQuotation = JSON.parse(dataProductQuotation);
        let quotations = [];
        quotations = localProductQuotation.length === 0 ? dataProductQuotation : localProductQuotation;
        if (quotations.length === 0) {
            $('#productList').html('<p>No products added.</p>');
        }

        let productListHtml = '';
        console.log(quotations);
        quotations.forEach((product, index) => {
            productListHtml += `
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 p-3 border rounded-3">
                    <div style="min-width:15em">
                        <h6 class="m-0">${product?.title}</h6>
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
                            ${product?.packaging}
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
        let priceSale = $('#editPrice').val().replace(/[^\d]/g, ''); // Hilangkan format Rp
        let satuan = $('input[name=edit-product-satuan]').val();
        let idSatuan = $('input[name=edit-id-satuan]').val();
        let packaging = $('#editPackaging').val();

        // Buat objek produk yang akan diedit
        let productQuotation = {
            id: productId,
            title: productTitle,
            description: description,
            id_satuan: idSatuan,
            satuan: satuan,
            price_sale: priceSale,
            packaging: packaging
        };

        // Ambil array dari localStorage atau buat array baru jika belum ada
        let quotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || [];

        // Edit produk di array berdasarkan index
        quotations[index] = productQuotation;

        // Simpan array ke localStorage
        localStorage.setItem('product_quotation_'+quotationId+userId, JSON.stringify(quotations));

        // Update tampilan HTML setelah menyimpan
        renderProductList();
    }

    // Delegasikan event listener untuk tombol hapus
    $(document).on('click', '.delete-product', function() {
        let index = $(this).data('index');
        deleteProduct(index);
    });

    // Fungsi untuk mengedit produk
    function editProduct(index) {
        let quotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || [];
        let product = quotations[index];
        
        // Ambil packaging berdasarkan satuan_id dari product
        $.ajax({
            url: `/ajax/packaging/satuan/${product.id_satuan}`,
            type: 'GET',
            success: function(packagings) {
                editPackagingChoices.clearChoices();
                const formattedData = packagings.map(item => ({
                    value: `${item.name} (${item.capacity} ${product.satuan})`, // Ambil 'id' sebagai 'value'
                    label: `${item.name} (${item.capacity} ${product.satuan})`, // Gabungkan 'name' dan 'capacity' untuk 'label'
                }));
                editPackagingChoices.setChoices(formattedData);
                editPackagingChoices.setChoiceByValue(product.packaging);
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
        let quotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || [];
        console.log(quotations);
        console.log('clicked');
        // Hapus produk dari array
        quotations.splice(index, 1);

        // Simpan array baru ke localStorage
        localStorage.setItem('product_quotation_'+quotationId+userId, JSON.stringify(quotations));

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
    }

    function setDataQuotation(){
        let localQuotation = JSON.parse(localStorage.getItem('data_quotation_'+quotationId+userId)) || {};
        
        let dataQuotation = {
            date : "{{$quotation->date}}",
            client : "{{$quotation->client_id}}",
            perihal : "{{$quotation->perihal}}",
            for : "{{$quotation->for}}",
            message : @json($quotation->message),
            keterangan : @json($quotation->keterangan),
        }
        clientChoices.setChoiceByValue(localQuotation.client ?? dataQuotation.client);
        $('#perihal').val(localQuotation.perihal ?? dataQuotation.perihal);
        $('#for').val(localQuotation.for ?? dataQuotation.for);
        tinymce.get('altiny').setContent(localQuotation.message ?? dataQuotation.message);
        tinymce.get('keterangan').setContent(localQuotation.keterangan ?? dataQuotation.keterangan);
    }

    function setProductQuotation(){
        let productQuotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || {};
        let quotations = @json($quotation->products);
        localStorage.setItem('product_quotation_'+quotationId+userId, JSON.stringify(JSON.parse(quotations)));
    }

    function resetLocal(){
        localStorage.removeItem('product_quotation_'+quotationId+userId);
        localStorage.removeItem('data_quotation_'+quotationId+userId);
        Toast.fire({
            icon: 'success',
            title: 'Berhasil mereset ulang pengeditan' // Pesan sukses dari response JSON
        });
        setDataQuotation();
        renderProductList();
    }

    $('#resetEdit').on('click', function(){
        resetLocal();
    });
    // ----------- Preview
    // Function to open and populate the modal with data from localStorage
    function populatePreviewModal() {
        // Fetch the data from localStorage
        let dataQuotation = JSON.parse(localStorage.getItem('data_quotation_'+quotationId+userId)) || {};
        let productQuotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId)) || [];
        $.ajax({
            url: `/ajax/client/${dataQuotation.client}`,
            type: 'GET',
            success: function(data) {
                $('.previewClientName').text(data.name || 'PT MITRA BETON MANDIRI');
                $('.previewClientAddress').text(data.address.address+', '+data.address.city || 'Jl. Melur Komp. Vila Panam Blok A No. 15 - 16');
                $('.previewClientPostal').text(data.address.postal_code || '123456');
            }
        });
        $('.previewFor').text(dataQuotation.for || 'PT MBM');
        $('.previewPerihal').text(dataQuotation?.perihal || 'Penawaran Harga');
        // Populate basic information fields
        $('.previewDate').text(dataQuotation.date || '13 Oktober 2021');

        // Populate product quotations table
        let productRows = '';
        productQuotations.forEach((product, index) => {
            productRows += `
                <tr>
                    <td class="text-bold-500">${index + 1}</td>
                    <td>
                        <div class="fw-semibold">${product.title}</div>
                        <p class="m-0" style="font-size:13px">${product.description}</p>
                    </td>
                    <td>${formatRupiah(product.price_sale)} / ${product.satuan}</td>
                    <td class="text-bold-500">${product.packaging}</td>
                </tr>
            `;
        });
        // Insert product rows into the table
        $('table#previewTable tbody').html(productRows);

        $('#previewMessage').html(dataQuotation.message || `
            <p class="mb-3">
                Bersama ini kami aiukan Penawaran Harga dengan harga dan detil penawaran dijelaskan di bawah ini :
            </p>
        `);

        // Populate additional details (like keterangan)
        $('#previewKeterangan').html(dataQuotation.keterangan || `
            <p class="pl-3">
                - Pembayaran 30 hari<br />
                - Minimum pengiriman 40 drum<br />
                - Harga belum termasuk PPN 10%<br />
                - Harga FOT Pekanbaru<br />
            </p>
        `);
    }

    // SaveQuotation
    // Event ketika tombol saveQuotation diklik
    $('#saveQuotation').on('click', function() {
        // Ambil data dari localStorage (atau sumber lain)
        let dataQuotation = JSON.parse(localStorage.getItem('data_quotation_'+quotationId+userId));
        let productQuotations = JSON.parse(localStorage.getItem('product_quotation_'+quotationId+userId));

        // Tambahkan CSRF token agar Laravel dapat memverifikasi request
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Ubah format tanggal dari '24 Sep 2024' ke '2024-09-24' menggunakan JavaScript
        let date = new Date(dataQuotation.date);
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0'); // getMonth() menghasilkan 0-11, jadi tambahkan 1
        let day = String(date.getDate()).padStart(2, '0');

        // Format manual menjadi YYYY-MM-DD
        let formattedDate = `${year}-${month}-${day}`; // Menghasilkan format YYYY-MM-DD

        // Format data yang akan dikirimkan ke controller
        let dataToSend = {
            client: dataQuotation.client,
            date: formattedDate,
            for: dataQuotation.for,
            message: dataQuotation.message,
            keterangan: dataQuotation.keterangan,
            products: JSON.stringify(productQuotations), // Ubah array ke format JSON
            _token: csrfToken // CSRF token untuk keamanan
        };
        console.log(dataToSend);
        // Lakukan request AJAX POST
        $.ajax({
            url: "{{ route('quotation.update', $quotation->id) }}", // Route untuk menambah quotation
            type: "PUT",
            data: dataToSend,
            success: function(response) {
                if (response.success) {
                    // Menampilkan toast sukses
                    Toast.fire({
                        icon: 'success',
                        title: response.message // Pesan sukses dari response JSON
                    });
                    resetLocal();
                    window.location.href = "{{ route('quotation.index') }}";
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

    setProductQuotation();
    setDataQuotation();
    // Render product list saat halaman dimuat
    renderProductList();
});
</script>

@endsection