@extends('layouts.dash', ['routeName' => 'packaging'])

@section('title', 'Packaging')
@section('description', 'Kelola packaging product dan tentukan kapasitas per satuannya')

@section('css')
    <link rel="stylesheet" href="/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="/dist/assets/extensions/choices.js/public/assets/styles/choices.css">
@endsection

@section('content-dash')
<section class="section mb-3">
    <div class="row">
        <div class="col-12">
            <form action="{{route('packaging.store')}}" method="POST">
                @csrf
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-4 mb-2">
                        <input type="text" name="name" value="{{old('name')}}" class="form-control border-none p-2 px-3" placeholder="Nama Packaging">
                    </div>
                    <div class="col-5 col-md-2 col-lg-3 mb-2">
                        <input type="number" name="capacity" value="{{old('capacity')}}" class="form-control border-none p-2 px-3" placeholder="Kapasitas">
                    </div>
                    <div class="col-1 col-md-auto mb-2">@</div>
                    <div class="col-6 col-md-3 col-lg-3 mb-2">
                        <select id="satuan" name="satuan" class="form-select">
                            @forelse (\App\Models\Satuan::all() as $satuan)
                            <option value="{{$satuan->id}}" {{old('satuan') && $satuan->id == old('satuan') ? 'selected' : '' }}>{{$satuan->name}}</option>
                            @empty
                            <option value="">Tidak ada satuan tersedia</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn-form btn btn-primary" style="white-space:nowrap">Add New</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive datatable-minimal">
                <table class="table" id="table2">
                    <thead>
                        <tr>
                            <th>Packaging Name</th>
                            <th>Capacity</th>
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
                        @forelse ($datas as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->capacity.' '.$item->satuan?->name}}</td>
                            <td>{{$item->created_at}}</td>
                            <td style="width: 5em">
                                <div class="d-flex align-items-center gap-1">
                                    <button
                                        type="button" 
                                        class="btn btn-sm btn-primary block" 
                                        style="aspect-ratio:1/1"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-capacity="{{ $item->capacity }}"
                                        data-satuan="{{ $item->satuan?->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                            </g>
                                        </svg>
                                    </button>
                                    <a href="{{route('packaging.setting', $item->id)}}"
                                        class="btn btn-sm btn-light-secondary block"
                                        style="aspect-ratio:1/1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12.428 2c-1.114 0-2.129.6-4.157 1.802l-.686.406C5.555 5.41 4.542 6.011 3.985 7c-.557.99-.557 2.19-.557 4.594v.812c0 2.403 0 3.605.557 4.594s1.57 1.59 3.6 2.791l.686.407C10.299 21.399 11.314 22 12.428 22s2.128-.6 4.157-1.802l.686-.407c2.028-1.2 3.043-1.802 3.6-2.791c.557-.99.557-2.19.557-4.594v-.812c0-2.403 0-3.605-.557-4.594s-1.572-1.59-3.6-2.792l-.686-.406C14.555 2.601 13.542 2 12.428 2m-3.75 10a3.75 3.75 0 1 1 7.5 0a3.75 3.75 0 0 1-7.5 0" clip-rule="evenodd"/></svg>
                                    </a>
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
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <form action="" method="POST" class="w-100">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Packaging</h5>
                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body border-0 w-100">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Packaging Name</label>
                                    <input type="text" name="name" class="form-control p-2 px-3" placeholder="packaging Name" id="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="capacity" class="form-label">Kapasitas</label>
                                <input type="number" id="capacity" name="capacity" value="{{old('capacity')}}" class="form-control border-none p-2 px-3" placeholder="Kapasitas">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="satuanEdit" class="form-label">Satuan</label>
                                <select id="satuanEdit" name="satuan" class="form-select">
                                    @forelse (\App\Models\Satuan::all() as $satuan)
                                    <option value="{{$satuan->id}}" {{old('satuan') && $satuan->id == old('satuan') ? 'selected' : '' }}>{{$satuan->name}}</option>
                                    @empty
                                    <option value="">Tidak ada satuan tersedia</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <span class="">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                            <span class="">Update</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>
<!-- Basic Tables end -->

@endsection

@section('scripts')
<script src="/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        const satuanChoices = new Choices('#satuan', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a satuan',
            removeItemButton: true
        });

        const satuanChoicesEdit = new Choices('#satuanEdit', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a satuan',
            removeItemButton: true
        });

        let ind = 2; // Indeks kolom untuk sorting, pastikan sesuai

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

        // Saat modal edit ditampilkan
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var id = button.data('id'); // Ambil data-id dari tombol
            var name = button.data('name'); // Ambil data-title dari tombol
            var capacity = button.data('capacity'); // Ambil data-title dari tombol
            var satuan = button.data('satuan'); // Ambil data-title dari tombol

            // Masukkan data ke dalam form modal
            var modal = $(this);
            modal.find('input[name="name"]').val(name); // input untuk nama produk
            modal.find('input[name="capacity"]').val(capacity); // input untuk nama produk
            satuanChoicesEdit.setChoiceByValue(satuan);

            //Ubah Button
            // Ubah action form sesuai ID produk
            modal.find('form').attr('action', '/packaging/' + id + '/edit');
        });

    });
</script>
@endsection