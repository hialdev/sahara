@extends('layouts.pdf')
@section('title', $title)

@section('css')
<style>
    /** 
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 0cm 0cm;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 2cm;
        margin-left: 3cm;
        margin-right: 2cm;
        margin-bottom: 2cm;
    }
</style>
@endsection

@section('header')
<div class="mb-4">
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
            <td class="py-1 text-end">
                <div class="h4 mb-0 text-muted d-inline-block text-uppercase">
                    {{$getSet->get('company_name')->the_value}}
                </div>
            </td>
        </tr>
    </table>
</div>
@endsection

@section('content')
<div class="" style="font-family: 'Times New Roman', serif !important">
    <!-- Content area -->

    <div class="mb-4 ml-5 mr-5">
        <div class="row">
            <div class="col-5">
                <div class="p-1 text-end">
                    Jakarta, <span class="previewDate">{{formatTanggal($quotation->date)}}</span>
                </div>
            </div>
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
                    <tr style="border-top: 1px solid #212121 !important; border-bottom: 1px solid #212121 !important;">
                        <th class="py-1">No</th>
                        <th class="py-1">Products</th>
                        <th class="py-1">Price</th>
                        <th class="py-1">Packaging</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Product Looping --}}
                    @foreach (json_decode($quotation->products) as $product)
                    <tr style="border-top: 1px solid #212121 !important; border-bottom: 1px solid #212121 !important;">
                        <td class="py-1 text-bold-500">{{$loop->index+1}}</td>
                        <td class="py-1">
                           <div class="fw-semibold">{{$product->title}}</div>
                           <p class="m-0" style="font-size:13px">{{$product->description}}</p>
                        </td>
                        <td class="py-1">{{ 'Rp ' . number_format($product->price_sale, 0, ',', '.') }} / {{$product->satuan}}</td>
                        <td class="py-1 text-bold-500">{{$product->packaging}}</td>
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




        <!-- /content area -->
<!-- /Print content -->
</div>
@endsection

@section('footer')
<div class="print-footer page-footer table-responsive">
    <table class="table table-lg">
        <tr class="row">
            <td class="py-1 col-6 pr-0">
                <div class="p-2 pl-4">
                    <h6>{{$getSet->get('company_name')->the_value}}</h6>
                    <p style="max-width: 15em">{{$getSet->get('company_ofcaddress')->the_value}}</p>
                    <div class="text-muted"><span class="fw-semibold">Phone</span> : {{$getSet->get('company_phone')->the_value}}</div>
                    <div class="text-muted"><span class="fw-semibold">Email</span> : {{$getSet->get('company_mail')->the_value}}</div>
                </div>
            </td>
            <td class="py-1 col-6 pl-0">
                <div class="p-2 pl-4">
                    <h6>Representative Office</h6>
                    <p style="max-width: 15em">{{$getSet->get('company_repaddress')->the_value}}</p>
                </div>
            </td>
        </tr>
        <tr class="row">
            <td class="py-1 col-6 pr-0 small" style="background-color: #f89e42;">&nbsp;</td>
            <td class="py-1 col-6 pl-0 small" style="background-color: #4374c4;">&nbsp;</td>
        </tr>
    </table>
</div>
@endsection