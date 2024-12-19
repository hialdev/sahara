{{-- template/crud/index.blade.php --}}
@extends('layouts.app')
@section('css')
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
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Settings</h3>
                <p class="text-subtitle text-muted">Manage Settings for this applications</p>
            </div>
            <div class="col-6 order-md-2 order-1">
                <button type="button" class="btn btn-primary float-end"
                    data-bs-toggle="modal"
                    data-bs-target="#addSetting"   
                >
                    Add New
                </button>
            </div>
        </div>
    </div>

    {{-- Add Setting --}}
    <div class="modal fade" id="addSetting" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <form action="{{route('setting.store')}}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header border-0 ">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Setting </h5>
                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body border-0 py-0">
                    <div class="content-tab">
                        {{-- Add Setting Form --}}
                        <div class="form-setting">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="editPrice" class="form-label">Name Setting</label>
                                        <input type="text" id="nameSetting" name="name" placeholder="Nama Setting" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" cols="20" rows="3" class="form-control">{{old('description')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editPrice" class="form-label">Key (Unique)</label>
                                        <input type="text" name="key" placeholder="Kata Kuci Unik" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="type_form" class="form-label">Form Type <span class="text-danger">*</span><a href="#" class="ms-2" data-bs-toggle="tooltip" title="Pilih Group / Tab terlebih dahulu">?</a></label>
                                    <select id="type_form" name="type_form" required class="form-select">
                                        <option value="">Pilih Tipe Form</option>
                                        @php
                                            $type_forms = ['text', 'textarea', 'rich_text','image', 'file', 'checkbox', 'number', 'currency', 'dropdown', 'multiple_dropdown'];
                                            @endphp
                                        @foreach ($type_forms as $ft)
                                        <option value="{{$ft}}">{{$ft}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tempat untuk menampilkan dynamic options -->
                                {{-- Dropdown Option --}}
                                <div id="option-container" class="mb-2" style="display: none;">
                                    <div class="card m-0">
                                        <div class="card-body bg-light-secondary rounded-4">
                                            <label for="form-options" class="form-label">Options</label>
                                            <div id="form-options">
                                                <div class="option-row d-flex align-items-center gap-2">
                                                    <input type="text" name="options[]" class="form-control mb-2" placeholder="Enter option">
                                                    <button type="button" class="remove-option btn btn-danger mb-2">-</button>
                                                </div>
                                            </div>
                                            <button type="button" id="add-option" class="btn btn-primary mt-2">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="group" class="form-label">Group / Tab <span class="text-danger">*</span><a href="#" class="ms-2" data-bs-toggle="tooltip" title="Pilih Group / Tab terlebih dahulu">?</a></label>
                                    <select id="group" name="group" required class="choices form-select">
                                        <option value="">Pilih Group / Tab</option>
                                        @php
                                            $tabs = \App\Models\GroupSetting::all();
                                        @endphp
                                        @foreach ($tabs as $tab)
                                            <option value="{{$tab->id}}">{{$tab->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="rounded-4 p-3 bg-light-secondary">
                                        <div class="mb-2">Group / Tab Setting belum ada atau tidak ditemukan ? </div>
                                        <button class="btn-form-add-setting btn btn-outline-primary rounded-pill px-3 d-inline-flex align-items-center gap-2">
                                            Add New Group Setting
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                                <path fill="currentColor" fill-rule="evenodd" d="M10.159 10.72a.75.75 0 1 0 1.06 1.06l3.25-3.25L15 8l-.53-.53l-3.25-3.25a.75.75 0 0 0-1.061 1.06l1.97 1.97H1.75a.75.75 0 1 0 0 1.5h10.379z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Form Group Setting --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn-form-back btn btn-light-secondary mb-3 rounded-pill px-3 d-inline-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" fill-rule="evenodd" d="M5.841 5.28a.75.75 0 0 0-1.06-1.06L1.53 7.47L1 8l.53.53l3.25 3.25a.75.75 0 0 0 1.061-1.06l-1.97-1.97H14.25a.75.75 0 0 0 0-1.5H3.871z" clip-rule="evenodd" />
                                        </svg>
                                        Back to Add Setting
                                    </button>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Group / Tab Name</label>
                                                        <input type="text" id="nameGroup" name="name" class="form-control" placeholder="Group / Tab Name" id="name" value="{{ old('name') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100" id="btnAddNewGroup">Add New Group / Tab Setting</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <span>Close</span>
                    </button>
                    <button type="submit" id="saveSetting" class="btn btn-primary">Add New Setting</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab start -->
    <div>
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            @foreach ($group_settings as $tab)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{$loop->index == 0 ? 'active' : ''}}" id="{{$tab->id}}-tab" data-bs-toggle="tab" href="#{{$tab->id}}" role="tab"
                    aria-controls="{{$tab->id}}" aria-selected="true">{{$tab->name}}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- Tab end -->

    {{-- Tab Content Start --}}
    <div class="tab-content" id="myTabContent">
        @foreach ($group_settings as $setting)
        <div class="tab-pane fade {{$loop->index == 0 ? 'show active' : ''}}" id="{{$setting->id}}" role="tabpanel" aria-labelledby="{{$setting->id}}-tab">
            <div class="d-flex align-items-center justify-content-end mb-3">
                @if($setting->is_urgent != 1)
                <button type="button" class="btn btn-sm btn-outline-danger block"
                    style="aspect-ratio:1/1"
                    data-bs-toggle="modal"
                    data-bs-target="#tabDelete-{{$setting->id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                    </svg>
                </button>

                {{-- Modal Delete --}}
                <div class="modal fade text-left" id="tabDelete-{{$setting->id}}" tabindex="-1" role="dialog"
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
                                Apakah anda yakin menghapus Group / Tab Setting : <span class="fw-bold">{{$setting->name}}</span> ? semua setting yang ada di tab tersebut akan dihapus permanen tidak dapat dikembalikan
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                    <span class="">Batal</span>
                                </button>
                                <form action="{{route('setting.group.destroy', $setting->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger ms-1"
                                        data-bs-dismiss="modal">
                                        <span class="">Ya, Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @foreach ($setting->settings as $item)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-2">
                            <div class="flex-1 w-100">
                                <h6>{{$item->name}}
                                    <div class="d-inline-flex gap-1 align-items-center ms-2 text-muted" style="font-size: 13px"">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="0.8em" height="0.8em" viewBox="0 0 20 20">
                                            <path fill="currentColor" d="M7 7.5C7 4.424 9.424 2 12.5 2S18 4.424 18 7.5S15.576 13 12.5 13a5.8 5.8 0 0 1-1.5-.18V13a1 1 0 0 1-1 1H9v1a1 1 0 0 1-1 1H7v.5A1.5 1.5 0 0 1 5.5 18h-2A1.5 1.5 0 0 1 2 16.5v-1.586c0-.398.158-.78.44-1.06l4.54-4.541c.134-.134.2-.368.142-.638A5.6 5.6 0 0 1 7 7.5M15 6a1 1 0 1 0-2 0a1 1 0 0 0 2 0" />
                                        </svg>
                                        <span>{{$item->the_key}}</span>
                                    </div>
                                </h6>
                                <p class="text-muted mb-2" style="font-size: 13px">{{$item->description}}</p>
                                <div class="w-100">
                                    @switch($item->type_form)
                                        @case('text')
                                            <input type="text" id="{{$item->the_key}}" name="{{$item->the_key}}" value="{{$item->the_value}}" class="form-control w-100">
                                            @break
                                        @case('textarea')
                                            <textarea name="{{$item->the_key}}" id="{{$item->the_key}}" cols="30" rows="5" class="form-control w-100">{{$item->the_value}}</textarea>
                                            @break
                                        @case('rich_text')
                                            <textarea name="{{$item->the_key}}" id="richtext-{{$item->the_key}}" cols="30" rows="5" class="form-control w-100">{{$item->the_value}}</textarea>
                                            @break
                                        @case('image')
                                            @if (strlen($item->the_value) > 5)
                                                <img src="{{ asset('storage/' . $item->the_value) }}" alt="Image {{$item->name}}" class="rounded-3 mb-2" style="max-height: 4em">
                                            @else
                                            @endif
                                                <input type="file" id="{{$item->the_key}}" name="{{$item->the_key}}" class="image-input">
                                            @break
                                        @case('file')
                                            @if (strlen($item->the_value) > 5)
                                            <a href="{{ asset('storage/' . $item->the_value) }}" class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2 bg-light-secondary">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                        <g fill="currentColor">
                                                            <path d="m12 2l.117.007a1 1 0 0 1 .876.876L13 3v4l.005.15a2 2 0 0 0 1.838 1.844L15 9h4l.117.007a1 1 0 0 1 .876.876L20 10v9a3 3 0 0 1-2.824 2.995L17 22H7a3 3 0 0 1-2.995-2.824L4 19V5a3 3 0 0 1 2.824-2.995L7 2z" />
                                                            <path d="M19 7h-4l-.001-4.001z" />
                                                        </g>
                                                    </svg>
                                                </div>
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">{{$item->the_value}}</span>
                                                <div class="ms-auto d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="M16.59 9H15V4c0-.55-.45-1-1-1h-4c-.55 0-1 .45-1 1v5H7.41c-.89 0-1.34 1.08-.71 1.71l4.59 4.59c.39.39 1.02.39 1.41 0l4.59-4.59c.63-.63.19-1.71-.7-1.71M5 19c0 .55.45 1 1 1h12c.55 0 1-.45 1-1s-.45-1-1-1H6c-.55 0-1 .45-1 1" />
                                                    </svg>
                                                </div>
                                            </a>
                                            @endif
                                            <input type="file" id="{{$item->the_key}}" name="{{$item->the_key}}" class="file-input">
                                            @break
                                        @case('checkbox')
                                            <label class="switch">
                                                <input type="checkbox" id="{{$item->the_key}}" name="{{$item->the_key}}" {{$item->the_value != 'false' && $item->the_value ? 'checked' : ''}}>
                                                <span class="slider round"></span>
                                            </label>
                                            @break
                                        @case('number')
                                            <input type="number" id="{{$item->the_key}}" class="form-control" name="{{$item->the_key}}" value="{{$item->the_value}}">
                                            @break
                                        @case('currency')
                                            <input type="text" id="{{$item->the_key}}" class="currency-input form-control" name="{{$item->the_key}}" value="{{$item->the_value}}">
                                            @break
                                        @case('dropdown')
                                            @php
                                                $options = json_decode($item->options);
                                            @endphp
                                            <select id="{{$item->the_key}}" name="{{$item->the_key}}" class="dropdown-input form-select" required>
                                                <option value="">Pilih {{$item->name}}</option>
                                                @forelse ($options as $option)
                                                <option value="{{$option}}" {{$option == $item->the_value ? 'selected' : ''}}>{{$option}}</option>
                                                @empty
                                                <option value="">Tidak ada pilihan tersedia</option>
                                                @endforelse
                                            </select>
                                            @break
                                        @case('multiple_dropdown')
                                            @php
                                                $options = json_decode($item->options);
                                                $values = explode(',',$item->the_value);
                                            @endphp
                                            <select id="{{$item->the_key}}" name="{{$item->the_key}}" class="multiple-input form-select" multiple="multiple" required>
                                                <option value="">Pilih {{$item->name}}</option>
                                                @forelse ($options as $option)
                                                <option value="{{$option}}" {{in_array($option, $values) ? 'selected' : ''}}>{{$option}}</option>
                                                @empty
                                                <option value="">Tidak ada pilihan tersedia</option>
                                                @endforelse
                                            </select>
                                            @break
                                        @default
                                            
                                    @endswitch
                                </div>
                            </div>
                            <div>
                                <button type="button"
                                    id="updateSetting"
                                    class="mb-2 d-flex align-items-center justify-content-center btn btn-sm btn-primary block"
                                    style="aspect-ratio:1/1"
                                    data-bs-toggle="tooltip"
                                    data-bs-original-title="Update {{$item->name}}"
                                    data-index="{{$item->id}}"
                                    data-form-type="{{$item->type_form}}"
                                    data-key="{{$item->the_key}}"
                                    
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M10.277 16.515c.005-.11.186-.154.24-.058c.254.45.686 1.111 1.176 1.412s1.276.386 1.792.408c.11.005.153.186.057.24c-.45.254-1.11.686-1.411 1.176s-.386 1.276-.408 1.792c-.005.11-.187.153-.24.057c-.254-.45-.686-1.11-1.177-1.411c-.49-.301-1.276-.386-1.791-.408c-.11-.005-.154-.187-.058-.24c.45-.254 1.111-.686 1.412-1.177c.3-.49.386-1.276.408-1.791" />
                                        <path fill="currentColor" d="M18.492 15.515c-.009-.11-.2-.156-.258-.062c-.172.283-.42.623-.697.793s-.692.236-1.022.262c-.11.008-.156.2-.062.257c.282.172.623.42.793.697s.236.693.262 1.023c.008.11.2.155.257.061c.172-.282.42-.623.697-.792s.693-.237 1.023-.262c.11-.009.155-.2.061-.258c-.282-.172-.623-.42-.792-.697s-.237-.692-.262-1.022" opacity="0.5" />
                                        <path fill="currentColor" d="m14.703 4.002l-.242-.306c-.937-1.183-1.405-1.775-1.95-1.688c-.544.088-.805.796-1.326 2.213l-.135.366c-.148.403-.222.604-.364.752s-.336.225-.724.38l-.353.141l-.247.1c-1.2.48-1.804.753-1.882 1.283c-.082.565.49 1.049 1.634 2.016l.296.25c.326.275.488.413.581.6c.094.187.107.403.133.835l.024.393c.094 1.52.14 2.28.635 2.542c.494.262 1.108-.147 2.336-.966l.318-.212c.349-.233.523-.35.723-.381s.401.024.806.136l.367.102c1.423.394 2.134.591 2.521.188c.388-.403.195-1.14-.19-2.613l-.1-.381c-.109-.419-.164-.628-.134-.835s.142-.389.366-.752l.203-.33c.785-1.276 1.178-1.914.924-2.426c-.255-.51-.988-.557-2.454-.648l-.38-.024c-.416-.026-.624-.039-.805-.135s-.314-.264-.58-.6" />
                                        <path fill="currentColor" d="M8.835 13.326C6.698 14.37 4.919 16.024 4.248 18c-.752-4.707.292-7.747 1.965-9.637c.144.295.332.539.5.73c.35.396.852.82 1.362 1.251l.367.31l.17.145c.005.064.01.14.015.237l.03.485c.04.655.08 1.294.178 1.805" opacity="0.5" />
                                    </svg>
                                </button>
                                @if ($item->type_form == 'file' || $item->type_form == 'image')                                    
                                <button type="button" 
                                    id="clearSetting"
                                    class="mb-2 d-flex align-items-center justify-content-center btn btn-sm btn-outline-secondary block"
                                    data-bs-original-title="Kosongkan {{$item->name}}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#clear-{{$item->id}}"
                                    style="aspect-ratio:1/1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M18.3 5.71a.996.996 0 0 0-1.41 0L12 10.59L7.11 5.7A.996.996 0 1 0 5.7 7.11L10.59 12L5.7 16.89a.996.996 0 1 0 1.41 1.41L12 13.41l4.89 4.89a.996.996 0 1 0 1.41-1.41L13.41 12l4.89-4.89c.38-.38.38-1.02 0-1.4" />
                                    </svg>
                                </button>

                                {{-- Clear Delete --}}
                                <div class="modal fade text-left" id="clear-{{$item->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel120" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content rounded-4">
                                            <div class="modal-header bg-light-secondary border-0">
                                                <h5 class="modal-title" id="myModalLabel120">Confirmation Clear File</h5>
                                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="mb-1 bi-x-lg"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body border-0">
                                                Apakah anda yakin mengosongkan file / gambar pada Setting : <span class="fw-bold">{{$item->name}}</span> dengan key <span class="fw-bold">{{$item->the_key}}</span> ? data yang dihapus bersifat permanen tidak dapat dikembalikan
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <span class="">Batal</span>
                                                </button>
                                                <form action="{{route('setting.clear', $item->id)}}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" class="btn btn-dark ms-1"
                                                        data-bs-dismiss="modal">
                                                        <span class="">Ya, Kosongkan</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($item->is_urgent != 1)
                                <button type="button" class="btn btn-sm btn-outline-danger block"
                                    style="aspect-ratio:1/1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#danger-{{$item->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                                    </svg>
                                </button>

                                {{-- Modal Delete --}}
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
                                                Apakah anda yakin menghapus Setting : <span class="fw-bold">{{$item->name}}</span> dengan key <span class="fw-bold">{{$item->the_key}}</span> ? data yang dihapus bersifat permanen tidak dapat dikembalikan
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <span class="">Batal</span>
                                                </button>
                                                <form action="{{route('setting.destroy', $item->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger ms-1"
                                                        data-bs-dismiss="modal">
                                                        <span class="">Ya, Hapus</span>
                                                    </button>
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
            @endforeach
        </div>
        @endforeach
    </div>
    {{-- Tab Content End --}}
</div>
@endsection

@section('scripts')
<script src="/dist/assets/extensions/tinymce/tinymce.min.js"></script>

<script>
$(document).ready(function () {
    // -------- Modal Add Setting JS
    // Form Modal Toggle Content --------------------------    
    $('.form-group').hide();

    // Saat tombol "Data" diklik
    $('.btn-form-add-setting').click(function() {
        // Sembunyikan konten produk dan tampilkan konten data
        $('.form-setting').hide();
        $('.form-group').show();

        $('#saveSetting').attr('disabled', true);
    });

    $('.btn-form-back').click(function() {
        // Sembunyikan konten data dan tampilkan konten produk
        $('.form-group').hide();
        $('.form-setting').show();

        $('#saveSetting').attr('disabled', false);
    });

    const dropdownInputs = document.querySelectorAll('.dropdown-input');
    dropdownInputs.forEach(dropdownInput => {
        new Choices(dropdownInput, {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select..',
            removeItemButton: true
        });
    });

    const multipleInputs = document.querySelectorAll('.multiple-input');
    multipleInputs.forEach(multipleInput => {
        new Choices(multipleInput, {
            delimiter: ",",
            editItems: true,
            maxItemCount: -1,
            removeItemButton: true,
        });
    });

    // ----------------------------------------------------
    //-------- Type Form Dropdown Select
    const tfChoices = new Choices('select#type_form', {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select..',
        removeItemButton: true
    });

    // Handle change event for type_form select
    $(document).on('change', 'select#type_form', function() {
        var selectedValue = tfChoices.getValue()?.value;
        console.log(selectedValue);
        if (selectedValue === 'dropdown' || selectedValue === 'multiple_dropdown') {
            $('#option-container').show(); // Show option inputs if the value is 'dropdown' or 'multiple_dropdown'
        } else {
            $('#option-container').hide(); // Hide option inputs for other form types
        }
    });

    // Add new option input
    $('#add-option').on('click', function() {
        var newOption = `
            <div class="option-row d-flex align-items-center gap-2">
                <input type="text" name="options[]" class="form-control mb-2" placeholder="Enter option">
                <button type="button" class="remove-option btn btn-danger mb-2">-</button>
            </div>`;
        $('#form-options').append(newOption);
    });

    // Remove option input
    $(document).on('click', '.remove-option', function() {
        $(this).closest('.option-row').remove();
    });

    // ---------------------------------------------------
    // FilePond: Image Crop
    const imageInputs = document.querySelectorAll('.image-input');

    // Store FilePond instances for images in a separate Map
    const imagePondInstances = new Map();

    imageInputs.forEach(imageInput => {
        const instance = FilePond.create(imageInput, {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            acceptedFileTypes: ["image/png", "image/jpeg", "image/jpg", "image/webp"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    resolve(type);
                }),
            storeAsFile: true,
        });
        // Store the instance with the input ID as the key
        imagePondInstances.set(imageInput.id, instance);
    });

    // FilePond: Document Files
    const fileInputs = document.querySelectorAll('.file-input');

    // Store FilePond instances for files in a separate Map
    const filePondInstances = new Map();

    fileInputs.forEach(fileInput => {
        const instance = FilePond.create(fileInput, {
            credits: null,
            allowImagePreview: false, // No image preview for files
            allowImageFilter: false,
            allowImageExifOrientation: false,
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
        // Store the instance with the input ID as the key
        filePondInstances.set(fileInput.id, instance);
    });

    // Konfigurasi TinyMCE berdasarkan tema
    const themeOptions = document.body.classList.contains("dark")
        ? {
            skin: "oxide-dark",
            content_css: "dark",
        }
        : {
            skin: "oxide",
            content_css: "default",
        };

    // Map untuk menyimpan instance TinyMCE
    const tinymceInstances = new Map();

    // Inisialisasi TinyMCE untuk setiap textarea dengan id yang dimulai dengan 'richtext-'
    $('textarea[id^="richtext-"]').each(function() {
        const editorId = $(this).attr('id');  // Ambil ID dari elemen textarea

        tinymce.init({
            selector: `#${editorId}`,  // Inisialisasi TinyMCE berdasarkan ID
            menubar: false,
            statusbar: false,
            toolbar: "undo redo styleselect | bold italic underline | bullist numlist code",
            plugins: "code",
            ...themeOptions,
            setup: function(editor) {
                // Simpan instance TinyMCE ke dalam Map
                tinymceInstances.set(editorId, editor);
            }
        });
    });


    $('.currency-input').on('keyup', function() {
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

    function IDRFormat(number) {
        // Pastikan number adalah string
        let value = number.toString().replace(/[^,\d]/g, '');

        let split = value.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

        return 'Rp ' + rupiah;
    }

    // Iterasi semua elemen input dengan class .currency-input
    const currencyInputs = document.querySelectorAll(".currency-input");

    currencyInputs.forEach(function(input) {
        let formattedValue = IDRFormat(input.value); // Dapatkan nilai terformat
        input.value = formattedValue; // Set nilai yang terformat kembali ke input
    });

    // ---------------------------------------------
    // --------- Data Setting Action
    // ---------------------------------------------
    $(document).on('click', '#updateSetting', function (e) {
        e.preventDefault();
        console.log('Clicked');

        // Ambil ID setting dari data attribute tombol
        let settingId = $(this).data('index');
        let settingKey = $(this).data('key'); // Pastikan tombol memiliki data-key yang benar
        let formType = $(this).data('form-type'); // Tambahkan data-form-type untuk mengetahui jenis form

        // Buat FormData untuk pengiriman data
        let formData = new FormData();

        if (formType === 'image') {
            // Ambil instance FilePond untuk gambar dari Map
            const filePondInstance = imagePondInstances.get(settingKey);

            if (filePondInstance) {
                // Ambil file dari FilePond
                const files = filePondInstance.getFiles();

                // Cek apakah ada file yang diunggah
                if (files.length > 0) {
                    const file = files[0].file; // Mendapatkan file dari FilePond
                    formData.append('the_value', file);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Tidak ada file untuk di update, klik button x untuk mengosongkan'
                    });
                    return; // Keluar dari fungsi jika file tidak dipilih
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Image Pond Instance Tidak ditemukan'
                });;
                return; // Keluar dari fungsi jika instance tidak ditemukan
            }
        } else if (formType === 'file') {
            // Ambil instance FilePond untuk file dari Map
            const filePondInstance = filePondInstances.get(settingKey);

            if (filePondInstance) {
                // Ambil file dari FilePond
                const files = filePondInstance.getFiles();

                // Cek apakah ada file yang diunggah
                if (files.length > 0) {
                    const file = files[0].file; // Mendapatkan file dari FilePond
                    formData.append('the_value', file);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Tidak ada file untuk di update, klik button x untuk mengosongkan'
                    });
                    return; // Keluar dari fungsi jika file tidak dipilih
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Filepond Instance tidak ditemukan'
                });
                return; // Keluar dari fungsi jika instance tidak ditemukan
            }
        } else if (formType == 'checkbox') {
            let inputValue = $('#' + settingKey).is(':checked');
            formData.append('the_value', inputValue);
        } else if (formType == 'rich_text') {
            const editor = tinymceInstances.get(`richtext-${settingKey}`);
            formData.append('the_value', editor.getContent());
        } else {
            // Jika bukan file atau image, ambil nilai input biasa
            let inputValue = $('#' + settingKey).val();
            formData.append('the_value', inputValue);
        }

        // Tambahkan CSRF token dan method PUT
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT'); // Metode PUT untuk update

        // Ajax request
        $.ajax({
            url: '/setting/' + settingId + '/edit', // URL update
            method: 'POST', // Menggunakan POST dengan _method PUT
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    // Menampilkan alert sukses menggunakan SweetAlert Toast.fire
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                } else {
                    // Menampilkan alert error jika terjadi kesalahan
                    Toast.fire({
                        icon: 'error',
                        title: response.error
                    });
                }
            },
            error: function (xhr, status, error) {
                // Menangani kesalahan dari server
                Toast.fire({
                    icon: 'error',
                    title: 'An error occurred: ' + xhr.responseText
                });
            }
        });
    });

    $(document).on('click', '#btnAddNewGroup', function (e) {
        e.preventDefault();
        let nameGroup = $('input#nameGroup').val();

        let formData = new FormData();
        // Tambahkan CSRF token dan method PUT
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('name', nameGroup);

        // Ajax request
        $.ajax({
            url: '/setting/group/add', // URL update
            method: 'POST', // Menggunakan POST dengan _method PUT
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    // Menampilkan alert sukses menggunakan SweetAlert Toast.fire
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    location.reload();
                } else {
                    // Menampilkan alert error jika terjadi kesalahan
                    Toast.fire({
                        icon: 'error',
                        title: response.error
                    });
                }
            },
            error: function (xhr, status, error) {
                // Menangani kesalahan dari server
                Toast.fire({
                    icon: 'error',
                    title: 'An error occurred: ' + xhr.responseText
                });
            }
        });
    });

    $(document).on('click', '#saveSetting', function (e) {
        e.preventDefault();
        let nameSetting = $('input#nameSetting').val();
        let description = $('textarea[name=description]').val();
        let theKey = $('input[name=key]').val();
        let typeForm = $('select#type_form').val();
        let options = $("input[name='options[]']").map(function() {
            return $(this).val();  // Ambil nilai setiap input text
        }).get();
        let group = $('select#group').val();

        let formData = new FormData();
        // Tambahkan CSRF token dan method PUT
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('name', nameSetting);
        formData.append('description', description);
        formData.append('the_key', theKey);
        formData.append('type_form', typeForm);
        formData.append('options', options);
        formData.append('group', group);

        // Ajax request
        $.ajax({
            url: '/setting/add', // URL update
            method: 'POST', // Menggunakan POST dengan _method PUT
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    // Menampilkan alert sukses menggunakan SweetAlert Toast.fire
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    location.reload();
                } else {
                    // Menampilkan alert error jika terjadi kesalahan
                    Toast.fire({
                        icon: 'error',
                        title: response.error
                    });
                }
            },
            error: function (xhr, status, error) {
                // Menangani kesalahan dari server
                Toast.fire({
                    icon: 'error',
                    title: 'An error occurred: ' + xhr.responseText
                });
            }
        });
    });
});
</script>
@endsection
