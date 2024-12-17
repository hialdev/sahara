@extends('templates.crud.add', ['routeName'=>'satuan'])

@section('title', 'Setting Satuan')
@section('description', 'Setting Satuan : '.$satuan->name)

@section('form')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center justify-content-center rounded-2 bg-primary text-white p-2" style="aspect-ratio:1/1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 56 56"><path fill="currentColor" d="M14.559 51.953h27.586c4.218 0 6.656-2.437 6.656-7.266V20.43c0-4.828-2.461-7.266-7.36-7.266h-3.726c-.14-4.922-4.406-9.117-9.703-9.117c-5.32 0-9.586 4.195-9.727 9.117H14.56c-4.875 0-7.36 2.414-7.36 7.266v24.258c0 4.851 2.485 7.265 7.36 7.265M28.012 7.61c3.304 0 5.812 2.485 5.93 5.555h-11.86c.094-3.07 2.602-5.555 5.93-5.555"/></svg>
                        </div>
                        <h5 class="mb-0">Satuan</h5>
                    </div>
                    <h6 class="mb-0">{{$satuan->name}}</h6>
                </div>
                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger block d-flex align-items-center gap-2 mb-1 ms-auto" data-bs-toggle="modal"
                        data-bs-target="#danger-{{$satuan->id}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                        </svg>
                        Hapus
                    </button>
                    <p class="mb-0" style="font-size: 12px"><span class="text-danger">*</span> Mohon perhatikan effek yang ditimbulkan dari menghapus satuan, seperti data Products dan transaksi Purchase Order yang terkait dengan satuan ini.</p>
                </div>
                {{-- Modal Delete --}}
                <div class="modal fade text-left" id="danger-{{$satuan->id}}" tabindex="-1" role="dialog"
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
                                Apakah anda yakin menghapus data Satuan <strong> {{$satuan->name}}</strong> ?
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Batal</span>
                                </button>
                                <form action="{{route('satuan.destroy', $satuan->id)}}" method="POST">
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
        <h4 class="mb-0">Data Products yang terkait</h4>
        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-5 p-2" style="aspect-ratio:1/1 !impportant; width:2em">{{count($satuan->products)}}</div>
    </div>

    @forelse ($satuan->products as $product)
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="w-100">
                        <h6>{{$product->title}}</h6>
                        <p class="m-0">{{$product->description}}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="d-flex align-items-center jutify-content-center p-5">
            <div>
                Belum ada Product yang menggunakan satuan ini, <a href="{{route('satuan.index')}}">Lihat Products</a>
            </div>
        </div>
    @endforelse
@endsection
