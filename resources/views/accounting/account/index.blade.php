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
                        <li class="breadcrumb-item active" aria-current="page">Chart of Accounts</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 order-md-1 order-last">
                <div class="d-flex align-items-center gap-3 justify-content-between">
                    <div>
                        <h3>Chart of Accounts</h3>
                        <p class="text-subtitle text-muted">Manage Chart of Account</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm mb-1 btn-primary block" 
                            data-bs-toggle="modal"
                            data-bs-target="#addCOAModal"
                            >
                            Add Account
                        </button>

                        {{-- Add COA Modal --}}
                        <div class="modal fade" id="addCOAModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered w-100"
                                role="document">
                                <div class="modal-content pb-2">
                                    <div class="modal-header border-0 ">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Add New Account</h5>
                                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body border-0 py-0">
                                        <form action="{{route('account.store')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <label for="account_type" class="form-label">Account Type</label>
                                                    <select name="account_type" id="account_type" class="form-select" required>
                                                        <option value="">Pilih account type</option>
                                                        @foreach ($actypes as $atype)
                                                            <option value="{{$atype->code}}">{{$atype->code.' - '.$atype->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="is_parent" value="1" type="checkbox" id="is_parent">
                                                        <label class="form-check-label" for="is_parent">Jadikan parent</label>
                                                    </div>
                                                </div>
                                                <div id="parent_box" class="col-12 mb-2">
                                                    <label for="parent_account" class="form-label">Parent Account</label>
                                                    <select name="parent_account" id="parent_account" class="form-select">
                                                        <option value="">Pilih Parent Category</option>
                                                        <option value="">Tidak ada</option>
                                                        @foreach ($parents as $parent)
                                                            <option value="{{$parent->account_code}}">{{$parent->accountType->code.'.'.$parent->account_code.' - '.$parent->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label for="account_code" class="form-label">Account Code</label>
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">xx.xxx.</span>
                                                            </div>
                                                            <input type="text" id="account_code" name="account_code" minlength="3" maxlength="3" aria-label="Account code" class="form-control account_code_input"
                                                                placeholder="Account Code (3 digit)" required>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label for="account_name" class="form-label">Account Name</label>
                                                    <input type="text" class="form-control" name="account_name" placeholder="Account Name" required>
                                                </div>
                                            </div>
                                            <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                                <button type="submit" class="btn btn-primary w-100">Tambah Account</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10em; font-size:12px">No. COA Code</th>
                                <th style="font-size:12px">Account</th>
                                <th style="font-size:12px">Type</th>
                                <th style="font-size:12px">Created At</th>
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
                            @foreach ($actypes as $actype)
                                <tr class="">
                                   
                                    <td colspan="5">
                                        <div class="d-flex align-items-center gap-3 p-2 bg-light-primary rounded-4">
                                            <div style="font-size:13px" class="bg-primary text-white rounded-5 d-inline-block p-2 px-3">
                                                <span class="fw-bold" >{{$actype->code}}</span><br/>
                                            </div>
                                            {{$actype->name}}
                                            <div style="font-size:13px" class="ms-auto p-1 px-2 rounded-3 d-inline-block bg-light-primary shadow-sm">
                                                {{$actype->type}} 
                                            </div>
                                            <a href="{{route('account_type.index')}}"
                                                class="btn btn-sm btn-warning rounded-5 block"
                                                style="aspect-ratio:1/1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2m0 2a8 8 0 1 0 0 16a8 8 0 0 0 0-16m0 3a5 5 0 1 1-4.78 3.527A2.499 2.499 0 0 0 12 9.5a2.5 2.5 0 0 0-1.473-2.28A5 5 0 0 1 12 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @forelse ($actype->parents() as $coa)
                                    <tr class="fw-bold">
                                        <td class="ps-4">
                                            <div style="font-size:13px" class="{{$coa->is_parent == 1 ? 'bg-secondary text-white' : 'bg-light-primary'}} rounded-5 d-inline-block p-2 px-3">
                                                <span class="fw-bold" >{{$coa->no_code}}</span><br/>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-size:13px">{{$coa->account_name}}</div>
                                            <div style="font-size:12px" class="text-muted">{{$coa->description}}</div>
                                        </td>
                                        <td>
                                            <div style="font-size:13px" class="p-1 px-2 rounded-3 d-inline-block bg-light-primary">
                                                {{$coa->accountType->type}}
                                            </div>
                                        </td>
                                        
                                        <td style="font-size: 12px">
                                            {{$coa->created_at}}
                                        </td>

                                        <td style="width: 5em">
                                            @if($coa->is_urgent !== 1)
                                            <div class="d-flex align-items-center gap-1">
                                                <button type="button" class="btn-edit-coa btn btn-sm btn-primary block" 
                                                    style="aspect-ratio:1/1"
                                                    data-id={{$coa->id}}
                                                    >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                            <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                                        </g>
                                                    </svg>
                                                </button>
                                                <a href="{{route('account.setting', $coa->id)}}"
                                                    class="btn btn-sm btn-light-secondary block"
                                                    style="aspect-ratio:1/1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12.428 2c-1.114 0-2.129.6-4.157 1.802l-.686.406C5.555 5.41 4.542 6.011 3.985 7c-.557.99-.557 2.19-.557 4.594v.812c0 2.403 0 3.605.557 4.594s1.57 1.59 3.6 2.791l.686.407C10.299 21.399 11.314 22 12.428 22s2.128-.6 4.157-1.802l.686-.407c2.028-1.2 3.043-1.802 3.6-2.791c.557-.99.557-2.19.557-4.594v-.812c0-2.403 0-3.605-.557-4.594s-1.572-1.59-3.6-2.792l-.686-.406C14.555 2.601 13.542 2 12.428 2m-3.75 10a3.75 3.75 0 1 1 7.5 0a3.75 3.75 0 0 1-7.5 0" clip-rule="evenodd"/></svg>
                                                </a>
                                            </div>
                                            @else
                                            <span class="rounded-3 bg-light-warning p-1 px-2" style="font-size: 13px">Logical</span>
                                            @endif
                                        </td>
                                    </tr>

                                    @if(count($coa?->childs()) > 0)
                                        @foreach ($coa->childs() as $child)
                                            <tr class="fw-bold">
                                                <td class="ps-5">
                                                    <div style="font-size:13px" class="{{$child->is_parent == 1 ? 'bg-primary text-white' : 'bg-light-primary'}} rounded-5 d-inline-block p-2 px-3">
                                                        <span class="fw-bold" >{{$child->no_code}}</span><br/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="font-size:13px">{{$child->account_name}}</div>
                                                    <div style="font-size:12px" class="text-muted">{{$child->description}}</div>
                                                </td>
                                                <td>
                                                    <div style="font-size:13px" class="p-1 px-2 rounded-3 d-inline-block bg-light-primary">
                                                        {{$child->accountType->type}} 
                                                    </div>
                                                </td>
                                                
                                                <td style="font-size: 12px">
                                                    {{$child->created_at}}
                                                </td>

                                                <td style="width: 5em">
                                                    @if($child->is_urgent !== 1)
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button type="button" class="btn-edit-coa btn btn-sm btn-primary block" 
                                                            style="aspect-ratio:1/1"
                                                            data-id={{$child->id}}
                                                            >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                                    <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                                                </g>
                                                            </svg>
                                                        </button>
                                                        <a href="{{route('account.setting', $child->id)}}"
                                                            class="btn btn-sm btn-light-secondary block"
                                                            style="aspect-ratio:1/1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12.428 2c-1.114 0-2.129.6-4.157 1.802l-.686.406C5.555 5.41 4.542 6.011 3.985 7c-.557.99-.557 2.19-.557 4.594v.812c0 2.403 0 3.605.557 4.594s1.57 1.59 3.6 2.791l.686.407C10.299 21.399 11.314 22 12.428 22s2.128-.6 4.157-1.802l.686-.407c2.028-1.2 3.043-1.802 3.6-2.791c.557-.99.557-2.19.557-4.594v-.812c0-2.403 0-3.605-.557-4.594s-1.572-1.59-3.6-2.792l-.686-.406C14.555 2.601 13.542 2 12.428 2m-3.75 10a3.75 3.75 0 1 1 7.5 0a3.75 3.75 0 0 1-7.5 0" clip-rule="evenodd"/></svg>
                                                        </a>
                                                    </div>
                                                    @else
                                                    <span class="rounded-3 bg-light-warning p-1 px-2" style="font-size: 13px">Logical</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center"> Tidak ada Account terkait</td>
                                    </tr>
                                @endforelse
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        {{-- Edit COA Modal --}}
        <div class="modal fade" id="editCOAModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable w-100"
                role="document">
                <div class="modal-content pb-2">
                    <div class="modal-header border-0 ">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit <span class="account_name"></span></h5>
                        <button type="button" class="btn text-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m2.207 6.837L10.01 9.03L7.815 6.837a.68.68 0 0 0-.88-.072l-.084.072a.68.68 0 0 0 0 .964l2.195 2.193l-2.195 2.193a.682.682 0 1 0 .964.965l2.195-2.195l2.197 2.195c.24.24.613.263.88.071l.084-.072a.68.68 0 0 0 0-.964l-2.196-2.193l2.195-2.193a.682.682 0 0 0-.963-.964" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body border-0 py-0">
                        <form id="editCOAForm" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label for="edit_account_type" class="form-label">Account Type</label>
                                    <select name="account_type" id="edit_account_type" class="form-select" required>
                                        <option value="">Pilih account type</option>
                                        @foreach ($actypes as $atype)
                                            <option value="{{$atype->code}}">{{$atype->code.' - '.$atype->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="is_parent" value="1" type="checkbox" id="is_parent">
                                        <label class="form-check-label" for="is_parent">Jadikan parent</label>
                                    </div>
                                </div>
                                <div id="edit_parent_box" class="col-12 mb-2">
                                    <label for="edit_parent_account" class="form-label">Parent Account</label>
                                    <select name="parent_account" id="edit_parent_account" class="form-select">
                                        <option value="">Pilih Parent Category</option>
                                        <option value="">Tidak ada</option>
                                        @foreach ($parents as $parent)
                                            <option value="{{$parent->account_code}}">{{$parent->accountType->code.'.'.$parent->account_code.' - '.$parent->account_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="account_code" class="form-label">Account Code</label>
                                    <fieldset>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">xx.xxx.</span>
                                            </div>
                                            <input type="text" id="account_code" name="account_code" minlength="3" maxlength="3" aria-label="Account code" class="form-control account_code_input"
                                                placeholder="Account Code (3 digit)" required>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="account_name" class="form-label">Account Name</label>
                                    <input type="text" class="form-control" name="account_name" placeholder="Account Name" required>
                                </div>
                            </div>
                            <div class="position-sticky bottom-0 w-100 pb-2 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Perbarui Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->

</div>
@endsection

@section('scripts')
<script src="/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        const actypeChoices = new Choices('#account_type', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a Account Type',
            removeItemButton: true
        });
        const editActypeChoices = new Choices('#edit_account_type', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a Account Type',
            removeItemButton: true
        });
        const parentChoices = new Choices('#parent_account', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a Account Parent',
            removeItemButton: true
        });
        const editParentChoices = new Choices('#edit_parent_account', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a Account Parent',
            removeItemButton: true
        });

        $(document).on('change', '#account_type', function () {
            triggeredChangeCode();
        })

        $(document).on('change', '#parent_account', function () {
            triggeredChangeCode();
        })

        $(document).on('change', '#is_parent', function () {
            triggeredChangeCode();
            let value = $(this).is(':checked');

            !value ? $('#parent_box').removeClass('d-none') : $('#parent_box').addClass('d-none');
            !value ? $('#edit_parent_box').removeClass('d-none') : $('#edit_parent_box').addClass('d-none');
        })

        const triggeredChangeCode = () => {
            let accountType = $('#account_type').val() || 'xx';
            let parentAccount = $('#parent_account').val() || 'xxx';
            let inputText = $('span.input-group-text');
            let isParent = $('#is_parent').is(':checked');

            // Validasi jika parentAccount dan accountType bukan default
            if (!isParent && parentAccount !== 'xxx' && accountType !== 'xx') {
                const parentCodeType = $('#parent_account option:selected').text().split('.')[0];
                if (parentCodeType !== accountType) {
                    actypeChoices.setChoiceByValue(parentCodeType);
                    $('#account_type').val(parentCodeType).trigger('change');

                    Toast.fire({
                        icon: 'warning',
                        title: 'Type parent dan account type disinkronkan otomatis! Pilih parent "Tidak Ada" untuk membuat parent baru'
                    });

                    // Perbarui inputText
                    inputText.text(`${parentCodeType}.${parentAccount}.`);
                    return;
                }
            }

            // Perbarui inputText berdasarkan isParent
            if (isParent) {
                inputText.text(`${accountType}.`);
            } else {
                inputText.text(`${accountType}.${parentAccount}.`);
            }
        };


        $(document).on('input', '.account_code_input', function () {
            let value = $(this).val();

            value = value.replace(/[^0-9.]/g, '');

            if (value.startsWith('.')) {
                value = value.substring(1);
            }

            $(this).val(value);
        });

        $('.btn-edit-coa').click(function(){
            let COAid = $(this).data('id');
            setEditCoa(COAid);
        });

        const setEditCoa = (COAid) => {
            $.ajax({
                url: `/account/${COAid}`,
                method: 'GET',
                success: (response) => {
                    if(response.success){
                        const modal = $('#editCOAModal');
                        modal.find('span.account_name').text(response.data.account_name);
                        modal.find('input[name=account_code]').val(response.data.account_code);
                        modal.find('input[name=is_parent]').prop('checked', response.data.is_parent == 1).trigger('change');
                        modal.find('input[name=account_name]').val(response.data.account_name);
                        editActypeChoices.setChoiceByValue(`${response.data.account_type.code}`);
                        editParentChoices.setChoiceByValue(response.data.no_code.split('.')[1]);
                        modal.find('form').attr('action', '/account/' + COAid + '/edit');
                        
                        let accountType = modal.find('#edit_account_type').val() || 'xx';
                        let parentAccount = modal.find('#edit_parent_account').val() || 'xxx';
                        let inputText = modal.find('span.input-group-text');
                        let isParent = modal.find('input[name=is_parent]').is(':checked');

                        if (isParent) {
                            inputText.text(`${accountType}.`);
                        } else {
                            inputText.text(`${accountType}.${parentAccount}.`);
                        }

                        $('#editCOAModal').modal('show');
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan, Error : '+response.data.error
                        })
                    }
                }
            })
        }

    });
</script>
@endsection
