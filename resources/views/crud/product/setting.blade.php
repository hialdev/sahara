@extends('templates.crud.add', ['routeName'=>'product'])

@section('title', 'Setting Product')
@section('description', 'Setting Product : '.$product->title)

@section('form')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center justify-content-center rounded-2 bg-primary text-white p-2" style="aspect-ratio:1/1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 56 56"><path fill="currentColor" d="M14.559 51.953h27.586c4.218 0 6.656-2.437 6.656-7.266V20.43c0-4.828-2.461-7.266-7.36-7.266h-3.726c-.14-4.922-4.406-9.117-9.703-9.117c-5.32 0-9.586 4.195-9.727 9.117H14.56c-4.875 0-7.36 2.414-7.36 7.266v24.258c0 4.851 2.485 7.265 7.36 7.265M28.012 7.61c3.304 0 5.812 2.485 5.93 5.555h-11.86c.094-3.07 2.602-5.555 5.93-5.555"/></svg>
                        </div>
                        <h5 class="mb-0">Product</h5>
                    </div>
                    <h6 class="mb-0">{{$product->title}}</h6>
                    <p class="mb-0" style="font-size: 12px">{{$product->description}}</p>
                </div>
                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger block d-flex align-items-center gap-2 mb-1 ms-auto" data-bs-toggle="modal"
                        data-bs-target="#danger-{{$product->id}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                        </svg>
                        Hapus
                    </button>
                    <p class="mb-0" style="font-size: 12px"><span class="text-danger">*</span> Mohon perhatikan effek yang ditimbulkan dari menghapus product, seperti transaksi Purchase Order yang terkait dengan product ini.</p>
                </div>
                {{-- Modal Delete --}}
                <div class="modal fade text-left" id="danger-{{$product->id}}" tabindex="-1" role="dialog"
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
                                Apakah anda yakin menghapus data satuan <strong> {{$product->title}}</strong> ?
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Batal</span>
                                </button>
                                <form action="{{route('product.destroy', $product->id)}}" method="POST">
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
        <h4 class="mb-0">Data Purchase Order yang terkait</h4>
        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-5 p-2" style="aspect-ratio:1/1 !impportant; width:2em">{{count($product->purchaseOrders)}}</div>
    </div>

    @forelse ($product->purchaseOrders as $processed)
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
                                <p class="text-muted mb-0" style="font-size: 13px">{!! $processed->description !!}</p>
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
