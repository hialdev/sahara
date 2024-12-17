@extends('templates.crud.add', ['routeName'=>'account_type'])

@section('title', 'Setting Account Type')
@section('description', 'Setting Account Type : '.$actype->name)

@section('form')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center justify-content-center rounded-2 bg-primary text-white p-2" style="aspect-ratio:1/1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                    <path fill="currentColor" d="M7 13a2 2 0 0 1 1.995 1.85L9 15v3a2 2 0 0 1-1.85 1.995L7 20H4a2 2 0 0 1-1.995-1.85L2 18v-3a2 2 0 0 1 1.85-1.995L4 13zm9 4a1 1 0 0 1 .117 1.993L16 19h-4a1 1 0 0 1-.117-1.993L12 17zm4-4a1 1 0 1 1 0 2h-8a1 1 0 1 1 0-2zM7 3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm9 4a1 1 0 0 1 .117 1.993L16 9h-4a1 1 0 0 1-.117-1.993L12 7zm4-4a1 1 0 0 1 .117 1.993L20 5h-8a1 1 0 0 1-.117-1.993L12 3z" />
                                </g>
                            </svg>
                        </div>
                        <h5 class="mb-0">Account Type</h5>
                    </div>
                    <h6 class="mb-0">{{$actype->name}}</h6>
                </div>
                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger block d-flex align-items-center gap-2 mb-1 ms-auto" data-bs-toggle="modal"
                        data-bs-target="#danger-{{$actype->id}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                        </svg>
                        Hapus
                    </button>
                    <p class="mb-0" style="font-size: 12px"><span class="text-danger">*</span> Mohon perhatikan effek yang ditimbulkan dari menghapus satuan, seperti data Accounts dan Journal Entries yang terkait dengan satuan ini.</p>
                </div>
                {{-- Modal Delete --}}
                <div class="modal fade text-left" id="danger-{{$actype->id}}" tabindex="-1" role="dialog"
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
                                Apakah anda yakin menghapus data Account Type <strong> {{$actype->name}}</strong> ?
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Batal</span>
                                </button>
                                <form action="{{route('account_type.destroy', $actype->id)}}" method="POST">
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
    </div>
    
    <div class="d-flex align-items-center gap-4">
        <h4 class="mb-0">Data Accounts yang terkait</h4>
        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-5 p-2" style="aspect-ratio:1/1 !impportant; width:2em">{{count($actype->accounts)}}</div>
    </div>

    @forelse ($actype->accounts as $account)
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="w-100">
                                <div class="d-inline-block p-1 px-2 rounded-3 bg-light-primary mb-2" style="font-size: 13px">{{$account->no_code}}</div>
                                <h6 class="m-0">{{$account->account_name}}</h6>
                                <p class="m-0">{{$account->description}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-end">
                            <div class="fs-3 m-0">{{count($account->entries)}}</div>
                            <p class="text-muted m-0">Jurnal terkait</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="d-flex align-items-center jutify-content-center p-5">
            <div>
                Belum ada Product yang menggunakan satuan ini, <a href="{{route('account_type.index')}}">Lihat Accounts</a>
            </div>
        </div>
    @endforelse
@endsection
