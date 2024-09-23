{{-- template/crud/index.blade.php --}}
@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/table-datatable-jquery.css">
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-6 col-md-12">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-start">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>@yield('title')</h3>
                <p class="text-subtitle text-muted">@yield('description')</p>
            </div>
            <div class="col-6 order-md-2 order-1">
                <a href="{{route($routeName.'.add')}}" class="btn btn-primary float-end">Add New</a>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $item)
                            <tr>
                                
                                @foreach ($columns as $column)
                                @php
                                    $value = $column['name'];
                                @endphp
                                <td>
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
                                        <a href="{{route($routeName.'.edit', $item->id)}}" class="btn text-primary d-flex align-items-center justify-content-center p-1 rounded-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button
                                            data-bs-toggle="modal" data-bs-target="#danger-{{$item->id}}"
                                            class="btn text-danger d-flex align-items-center justify-content-center p-1 rounded-2">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                    <div class="modal fade text-left" id="danger-{{$item->id}}" tabindex="-1" role="dialog"
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
                                                    Apakah anda yakin menghapus data {{$routeName}} dengan id {{$item->id}} ? data yang dihapus bersifat permanen tidak dapat dikembalikan
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Batal</span>
                                                    </button>
                                                    <form action="{{route($routeName.'.destroy', $item->id)}}" method="POST">
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
                                </td>
                            </tr>
                            @empty
                                
                            @endforelse
                            
                        </tbody>
                    </table>
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
    });
</script>
@endsection
