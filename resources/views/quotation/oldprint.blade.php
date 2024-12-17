@extends('layouts.blank')

@section('content')
<!-- Print content -->
<div class="d-flex align-items-center justify-content-center position-fixed bottom-0 end-0 start-0 mb-2">
    <div class="d-flex align-items-center gap-1 bg-white shadow-sm p-1 rounded-pill">
        <a href="{{route('quotation.index')}}" class="btn p-2 px-3 btn-light-secondary rounded-pill">Back</a>
        <a href="{{route('quotation.download', $quotation->id)}}" class="btn p-2 px-3 btn-primary rounded-pill">Download Document</a>
    </div>
</div>
<div class="print-content PAGE-A4" style="font-family: 'Poppins', sans-serif !important">

    <!-- Content area -->
    

    <div class="print-header mb-4">
        <!-- <div class="row">
        <div class="col-3">
            <img class="img-fluid" src="assets/images/logo.jpeg">
        </div>
        <div class="col-9 d-flex align-items-center justify-content-end">
            <div class="h4 mb-0 text-muted d-inline-block">
                CONTRACTOR AND SERVICES
            </div>
        </div>
        </div> -->
        <table class="w-100">
            <tr>
                <td>
                    <img height="60" src="{{env('SSO_URL').'/storage/'.$getSet->get('company_logo')->the_value}}">
                </td>
                <td class="text-end">
                    <div class="h4 mb-0 text-muted d-inline-block">
                        {{$getSet->get('company_name')->the_value}}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="print-body mb-4 ml-5 mr-5">
        <div class="row">
            <div class="col-7">
                <div class="p-1">
                    <table class="mb-2 w-100">
                        <tr>
                            <td width="60">Nomor</td><td width="10" class="pl-1 pr-1">:</td><td>{{$quotation->no}}</td>
                        </tr>
                        <tr>
                            <td width="60">Lampiran</td><td width="10" class="pl-1 pr-1">:</td><td>-</td>
                        </tr>
                        <tr>
                            <td width="60">Perihal</td><td width="10" class="pl-1 pr-1">:</td><td><span class="previewPerihal">{{$quotation->perihal}}</span></td>
                        </tr>
                        <tr>
                            <td width="60" class="align-top">Kepada</td>
                            <td width="10" class="pl-1 pr-1 align-top">:</td>
                            <td>
                                <span class="previewClientName fw-bold">{{$quotation->client->name}}</span><br>
                                <span class="previewClientAddress">{{$quotation->client->addresses->keyBy('address_tag')->get('office')->address}}</span><br>
                                <span class="previewClientPostal">{{$quotation->client->addresses->keyBy('address_tag')->get('office')->postal_code}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="60">U.P.</td><td width="10" class="pl-1 pr-1">:</td><td><span class="previewFor">{{$quotation->for}}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-5">
                <div class="p-1 text-end">
                    Jakarta, <span class="previewDate">{{formatTanggal($quotation->date)}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="print-body mb-4 ml-5 mr-5">

        <p>Dengah hormat,</p>
        <div id="previewMessage">
            {!! $quotation->message !!}
        </div>

        <!-- Table with no outer spacing -->
        <div class="table-responsive mb-4">
            <table class="table mb-0 table-lg" id="previewTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Packaging</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Product Looping --}}
                    @foreach (json_decode($quotation->products) as $product)
                    <tr>
                        <td class="text-bold-500">{{$loop->index+1}}</td>
                        <td>
                           <div class="fw-semibold">{{$product->title}}</div>
                           <p class="m-0" style="font-size:13px">{{$product->description}}</p>
                        </td>
                        <td>{{ 'Rp ' . number_format($product->price_sale, 0, ',', '.') }} / {{$product->satuan}}</td>
                        <td class="text-bold-500">{{$product->packaging}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="keterangan mb-4">
            <div>Keterangan :</div>
            <div id="previewKeterangan">
                {!! $quotation->keterangan !!}
            </div>
        </div>

        <div>
            Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
        </div>
    </div>

    <div class="print-body mb-4 ml-5 mr-5">
        <div>Hormat Kami,</div>
        <div class="">{{$getSet->get('company_name')->the_value}}</div>
        <div class="mt-4 mb-4">&nbsp;</div>
        <div class=""><u>{{$getSet->get('company_director')->the_value}}</u></div>
        <div>Direktur</div>
    </div>

    <div class="mt-5 mb-4">&nbsp;</div>


    <div class="print-footer page-footer">
        <div class="row">
            <div class="col-6 pr-0">
                <div class="p-2 pl-4">
                    <h6>{{$getSet->get('company_name')->the_value}}</h6>
                    <p style="max-width: 15em">{{$getSet->get('company_ofcaddress')->the_value}}</p>
                    <h6 class="text-muted">Phone : {{$getSet->get('company_phone')->the_value}}</h6>
                    <h6 class="text-muted">Email : {{$getSet->get('company_mail')->the_value}}</h6>
                </div>
            </div>
            <div class="col-6 pl-0">
                <div class="p-2 pl-4">
                    <h6>Representative Office</h6>
                    <p style="max-width: 15em">{{$getSet->get('company_repaddress')->the_value}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 pr-0 small" style="background-color: #f89e42;">&nbsp;</div>
            <div class="col-6 pl-0 small" style="background-color: #4374c4;">&nbsp;</div>
        </div>
    </div>

        <!-- /content area -->

    </div>
<!-- /Print content -->
</div>
@endsection