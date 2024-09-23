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
                        <li class="breadcrumb-item active" aria-current="page">Product</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Product</h3>
                <p class="text-subtitle text-muted">Manage Products / Catalog for make a whole money</p>
            </div>
            <div class="col-6 order-md-2 order-1">
                <a href="{{route('product.add')}}" class="btn btn-primary float-end">Add New</a>
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
                                @foreach ($columns as $column)
                                <th>{{$column['name']}}</th>
                                @endforeach
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
                            @forelse ($datas as $item)
                            <tr>
                                
                                @foreach ($columns as $column)
                                @php
                                    $value = $column['name'];
                                @endphp
                                <td style="font-size: 13px">
                                    @if ($column['type'] == 'toggle')
                                        @if ($item->$value == 1)
                                            <div class="rounded-2 d-inline-block p-1 px-2 bg-primary text-white">Ya</div>
                                        @else
                                            <div class="rounded-2 d-inline-block p-1 px-2 bg-light text-secondary">No</div>
                                        @endif
                                    @elseif ($column['type'] == 'image')
                                        <div>
                                            <img src="{{$item->$value ? Storage::url($item->$value) : 'https://placehold.co/600x400?text=No+Image'}}" alt="{{$item->$value}}" class="d-block w-100" style="max-height: 5em; max-width:8em; object-fit:contain">
                                        </div>
                                    @elseif ($column['type'] == 'icon')
                                        <div class="d-flex align-items-center gap-1">
                                            @php
                                                $icon = str_contains($item->$value, 'bi-');
                                                if($icon){
                                                    $icon = str_replace('bi-', '', $item->$value);
                                                }else{
                                                    $icon = $item->$value;
                                                }
                                            @endphp
                                            <i class="bi-{{$icon}}" title="{{$item->$value}}"></i>
                                        </div>
                                    @elseif ($column['type'] == 'relation')
                                        @php
                                            $rlt_type = $column['rlt_type'];
                                            $rlt_name = $column['rlt_name'];
                                            $rlt_index = $column['rlt_index'];
                                            $rlt_key = $column['rlt_key'];
                                        @endphp
                                        @if ($rlt_type == 'collection')
                                    
                                            @if (count($item->$rlt_name) > 0 && $item->$rlt_name)
                                                <ul class="m-0">
                                                    @foreach ($item->$rlt_name as $rlt)
                                                    <li><a href="{{$rlt->url}}" target="_blank">{{$rlt->$rlt_key}}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @elseif($rlt_type == 'single')
                                            @if ($rlt_index !== null)
                                            <div>
                                                {{$item->$rlt_name[$rlt_index]->$rlt_key}}
                                            </div>
                                            @else
                                            <div>
                                                {{$item->$rlt_name->$rlt_key}}
                                            </div>
                                            @endif
                                        @endif
                                    @else
                                    {{$item->$value}}
                                    @endif  
                                </td>
                                @endforeach
                                
                                <td style="width: 5em">
                                    <div class="d-flex align-items-center gap-1">
                                        <button
                                            type="button" 
                                            class="btn btn-sm btn-outline-primary block" 
                                            style="aspect-ratio:1/1"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal"
                                            data-id="{{ $item->id }}"
                                            data-title="{{ $item->title }}"
                                            data-satuan="{{ $item->satuan->id }}"
                                            data-description="{{ $item->description }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                    <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                    <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                </g>
                                            </svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger block"
                                            style="aspect-ratio:1/1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-id="{{$item->id}}"
                                            data-title="{{$item->title}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                </td>
                            </tr>
                            @empty
                                
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <form action="{{route('product.update', $item->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Product</h5>
                            <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                    <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body border-0">
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
                                        <textarea name="description" id="description" cols="20" rows="5" class="form-control" value="{{ old('description') }}">{{ old('description')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <select id="satuan" name="satuan" class="form-select">
                                            @forelse (\App\Models\Satuan::all() as $satuan)
                                            <option value="{{$satuan->id}}">{{$satuan->name}}</option>
                                            @empty
                                            <option value="">Tidak ada satuan tersedia</option>
                                            @endforelse
                                        </select>
                                        <div class="text-secondary">Tidak menemukan satuan yang pas? <a href="{{route('satuan.index')}}" target="_blank" class="ms-2 btn btn-sm btn-secondary">Tambah Satuan</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- Modal Delete --}}
        <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog"
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
                        Apakah anda yakin menghapus data Product : <span class="product-title fw-semibold"></span> ? data yang dihapus bersifat permanen tidak dapat dikembalikan
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="{{route('product.destroy', $item->id)}}" method="POST">
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

    </section>
    <!-- Basic Tables end -->

</div>
@endsection

@php
    // Tentukan index kolom untuk sorting, jika kolom 'created_at' berada di posisi terakhir
    $index_created_at = count($columns)-1; // Update dengan benar jika 'created_at' bukan kolom terakhir
@endphp

@section('scripts')
<script src="/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        let ind = {{ $index_created_at }}; // Indeks kolom untuk sorting, pastikan sesuai

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

        const satuanChoices = new Choices('#satuan', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Pilih satuan',
            removeItemButton: true
        });

        // Saat modal edit ditampilkan
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var id = button.data('id'); // Ambil data-id dari tombol
            var title = button.data('title'); // Ambil data-title dari tombol
            var satuan = button.data('satuan'); // Ambil data-satuan dari tombol
            var description = button.data('description'); // Ambil data-description

            // Masukkan data ke dalam form modal
            var modal = $(this);
            modal.find('input[name="title"]').val(title); // input untuk nama produk
            satuanChoices.setChoiceByValue(satuan);
            modal.find('textarea[name="description"]').val(description); // textarea untuk deskripsi produk

            // Ubah action form sesuai ID produk
            modal.find('form').attr('action', '/product/' + id + '/edit');
        });

        // Saat modal delete ditampilkan
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var id = button.data('id'); // Ambil data-id dari tombol
            var title = button.data('title'); // Ambil data-title dari tombol

            // Masukkan data ke dalam form modal
            var modal = $(this);
            modal.find('span.product-title').text(title); // Update nama produk

            // Ubah action form sesuai ID produk
            modal.find('form').attr('action', '/product/' + id + '/destroy');
        });
    });
</script>
@endsection
