@extends('templates.crud.add', ['routeName'=>'principle'])

@section('title', 'Setting Principle : '.$principle->name)
@section('description', 'Setting Principle or Supplier with PIC Contact')

@section('form')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center justify-content-center rounded-2 bg-primary text-white p-2" style="aspect-ratio:1/1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M5 6C3.355 6 2 7.355 2 9v14c0 1.645 1.355 3 3 3h22c1.645 0 3-1.355 3-3V9c0-1.645-1.355-3-3-3zm0 2h22c.566 0 1 .434 1 1v14c0 .566-.434 1-1 1H5c-.566 0-1-.434-1-1V9c0-.566.434-1 1-1m6 2c-2.2 0-4 1.8-4 4c0 1.113.477 2.117 1.219 2.844A5.04 5.04 0 0 0 6 21h2c0-1.668 1.332-3 3-3s3 1.332 3 3h2a5.04 5.04 0 0 0-2.219-4.156C14.523 16.117 15 15.114 15 14c0-2.2-1.8-4-4-4m7 1v2h8v-2zm-7 1c1.117 0 2 .883 2 2s-.883 2-2 2s-2-.883-2-2s.883-2 2-2m7 3v2h8v-2zm0 4v2h5v-2z"></path></svg>
                        </div>
                        <h5 class="mb-0">Principle / Supplier</h5>
                    </div>
                    <h6 class="mb-0">{{$principle->name}} - {{$principle->email}}</h6>
                    <p class="mb-0" style="font-size: 12px">{{$principle->description}}</p>
                </div>
                <div class="col-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center justify-content-center rounded-2 bg-primary text-white p-2" style="aspect-ratio:1/1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.13em" height="1em" viewBox="0 0 576 512"><path fill="currentColor" d="M256 0h64c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32h-64c-17.7 0-32-14.3-32-32V32c0-17.7 14.3-32 32-32M64 64h128v48c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V64h128c35.3 0 64 28.7 64 64v320c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128c0-35.3 28.7-64 64-64m112 373.3c0 5.9 4.8 10.7 10.7 10.7h202.7c5.9 0 10.7-4.8 10.7-10.7c0-29.5-23.9-53.3-53.3-53.3H229.5c-29.5 0-53.3 23.9-53.3 53.3zM288 352a64 64 0 1 0 0-128a64 64 0 1 0 0 128"></path></svg>
                        </div>
                        <h5 class="mb-0">PIC</h5>
                    </div>
                    <h6 class="mb-0">{{$principle->contact_name}}</h6>
                    <p class="mb-0" style="font-size: 12px">Email : {{$principle->contact_email}}</p>
                    <p class="mb-0" style="font-size: 12px">Phone : {{$principle->contact_phone}}</p>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger block d-flex align-items-center gap-2 mb-1 ms-auto" data-bs-toggle="modal"
                        data-bs-target="#danger-{{$principle->id}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                        </svg>
                        Hapus
                    </button>
                    <p class="mb-0" style="font-size: 12px"><span class="text-danger">*</span> Mohon perhatikan effek yang ditimbulkan dari menghapus principle, seperti transaksi Purchase Order yang terkait dengan principle ini.</p>
                </div>
                {{-- Modal Delete --}}
                <div class="modal fade text-left" id="danger-{{$principle->id}}" tabindex="-1" role="dialog"
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
                                Apakah anda yakin menghapus data principle <strong> {{$principle->name}}</strong> ?
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Batal</span>
                                </button>
                                <form action="{{route('principle.destroy', $principle->id)}}" method="POST">
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
        <h4 class="mb-0">Purchase Order yang terkait</h4>
        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-5 p-2" style="aspect-ratio:1/1 !impportant; width:2em">{{count($principle->process_purchase_orders)}}</div>
    </div>

    @forelse ($principle->process_purchase_orders as $processed)
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
                                    <a href="" class="d-flex align-items-center gap-2 p-1 px-2 rounded-3 bg-light-secondary text-dark" style="font-size: 13px">
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
                        <div class="col-12">

                        </div>
                    </div>
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
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6>{{$prod->product->title}}</h6>
                                    <p style="font-size:13px">{{$prod->product->description}}</p>
                                </div>
                                <div>
                                    <h6>{{$prod->qty ?? 0}}</h6>
                                    <span style="font-size:13px">pkg diproses</span>
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
            Belum ada Proses yang dibuat, Silahkan menuju menu <a href="{{route('purchase.index')}}">Purchase</a>
        </div>
    </div>
    @endforelse
@endsection
