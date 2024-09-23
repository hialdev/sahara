@extends('templates.crud.add', ['routeName'=>'quotation'])

@section('title', 'Add Quotation')
@section('description', 'Add Client before Add quotation')

@section('form')
    <style>
        .btn-content.active {
            background-color: #762aa8 !important;
            color: white !important;
        }
        .btn-content.active *{
            color: white !important;
        }
    </style>

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
                                            <h6 class="m-0">Offering Data</h6>
                                            <p class="text-secondary m-0 d-none d-md-block ">Isi Data Penawaran</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="btn-content btn-content-quotation-product d-flex align-items-center bg-white justify-content-end p-3 shadow-sm rounded-4 gap-3 mb-3" style="cursor: pointer;">
                                        <div class="text-end">
                                            <h6 class="m-0">Offering Product</h6>
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
                                        <label for="name" class="form-label">No. Quotation (Automatic)</label>
                                        <input type="text" name="no" class="form-control" placeholder="No. Quotation" value="xxx/QTRSM/V/2024" disabled id="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Date Letter <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.." required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                                        <select id="client" name="client" class="choices form-select" required>
                                            <option value="">Pilih Client</option>
                                            @forelse ($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                            @empty
                                            <option value="">Tidak ada client tersedia</option>
                                            @endforelse
                                        </select>
                                        <div class="text-secondary">Client belum terdaftar? <a href="{{route('client.add')}}" class="ms-2">Tambah Client</a></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Untuk Perhatian" class="mb-2">Untuk Perhatian <span class="text-danger">*</span></label>
                                        <input type="text" name="for" class="form-control" placeholder="Bpk / Ibu / Pimpinan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="perihal" class="mb-2">Perihal <span class="text-danger">*</span></label>
                                        <input type="text" name="perihal" class="form-control" required placeholder="Default : Penawaran Harga">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Pesan <span class="text-danger">*</span></label>
                                        <textarea id="altiny" cols="30" rows="5" name="message" required>Bersama ini kami ajukan Penawaran Harga dengan harga dan detail penawaran sebagai berikut :</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea id="altiny" cols="30" rows="5" name="keterangan"></textarea>
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
                                        <button class="btn btn-primary"
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
                                        <button type="button" class="btn btn-primary w-100">Save</button>
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qty" class="form-label">Qty <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="qty" name="qty">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="text" name="total" class="form-control" placeholder="Rp" disabled>
                                </div>
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
})

flatpickr('.flatpickr-no-config', {
    enableTime: false,
    dateFormat: "d M Y", 
    defaultDate: "today",
})
</script>

<script>
$(document).ready(function() {
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

    // Fungsi untuk menghitung total dan memformat hasilnya ke dalam input total
    function calculateTotal() {
        let priceSale = $('#price').val().replace(/[^\d]/g, ''); // Hilangkan format non-angka dari price
        let qty = $('#qty').val();

        if (priceSale && qty) {
            let total = qty * priceSale;
            $('input[name=total]').val(formatRupiah(total));
        } else {
            $('input[name=total]').val('Rp 0');
        }
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

        // Hitung total saat price diubah
        calculateTotal();
    });

    // Event untuk menghitung total ketika qty diubah
    $('input[name=qty]').on('keyup', function() {
        calculateTotal();
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
                        title: 'Gagal menambahkan product. ' + xhr.responseJSON.message
                    });
                }
            }
        });
    });

     // Fungsi untuk menyimpan produk ke localStorage
     function saveQuotationToLocalStorage() {
        // Ambil nilai dari form
        let productId = $('#product').val();
        let productTitle = $('#product option:selected').text();
        let description = $('#qdescription').val();
        let priceSale = $('#price').val().replace(/[^\d]/g, ''); // Hilangkan format Rp
        let qty = $('#qty').val();
        let satuan = $('input[name=product-satuan]').val();
        let packaging = $('#packaging').val();
        // Potong teks di antara tanda kurung
        let capacity = packaging.split('(')[1].split(')')[0]; // Mengambil teks antara kurung
        capacity = capacity.split(' ')[0]; // Mengambil angka di awal (250)
        let packagingTotal = qty / capacity; 
        let priceTotal = calculateTotalPrice(priceSale, qty);

        // Buat objek produk
        let productQuotation = {
            id: productId,
            title: productTitle,
            description: description,
            price_sale: priceSale,
            qty: qty,
            satuan: satuan,
            packaging: packaging,
            packaging_total: packagingTotal,
            price_total: priceTotal
        };

        // Ambil array dari localStorage atau buat array baru jika belum ada
        let quotations = JSON.parse(localStorage.getItem('product_quotation')) || [];

        // Tambahkan produk baru ke array
        quotations.push(productQuotation);

        // Simpan array ke localStorage
        localStorage.setItem('product_quotation', JSON.stringify(quotations));
        
        // Update tampilan HTML setelah menyimpan
        renderProductList();
    }

    // Fungsi untuk menghitung total harga
    function calculateTotalPrice(price, qty) {
        return price * qty;
    }

    // Fungsi untuk me-render produk ke dalam HTML
    function renderProductList() {
        let quotations = JSON.parse(localStorage.getItem('product_quotation')) || [];
        let productListHtml = '';

        quotations.forEach(product => {
            productListHtml += `
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 p-3 border rounded-3">
                <div>
                    <h6 class="m-0">${product.title}</h6>
                    <p class="m-0 text-muted" style="font-size: 13px">${product.description}</p>
                </div>
                <div class="ms-md-auto">
                    <div class="fw-bold" style="font-size:14px">Rp ${formatRupiah(product.price_sale)} / ${product.satuan} <span class="text-muted" style="font-size:13px">* ${product.qty} Qty</span></div>
                    <div class="d-flex align-items-center gap-3 justify-content-md-end" style="font-size: 13px">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="m7.5 4.27l9 5.15M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                    <path d="m3.3 7l8.7 5l8.7-5M12 22V12" />
                                </g>
                            </svg>
                        </div>
                        Packaging ${product.packaging_total} * ${product.packaging}
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
            `;
        });

        // Update HTML ke elemen dengan ID tertentu, misalnya #productList
        $('#productList').html(productListHtml);
    }

    // Format harga ke rupiah
    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Event listener ketika tombol Add Quotation Product diklik
    $('#addQuotationProduct').click(function() {
        saveQuotationToLocalStorage();
    });

    // Render product list saat halaman dimuat
    renderProductList();
});
</script>

@endsection