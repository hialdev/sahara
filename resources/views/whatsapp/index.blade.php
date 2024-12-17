@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-6 col-md-12">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-start">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Whatsapp</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Whatsapp Connection</h3>
                <p class="text-subtitle text-muted">Manage Whatsapp Connection for this applications, scan QR Code below with your whatsapp</p>
            </div>
        </div>
    </div>
    <div class="card rounded-5" id="main-view">
        <div class="card-body">
            <div>
                <form method="post" id="form_security" autocomplete="off">
                    <div class="form-group row mb-3">
                        <div class="col-12">
                            <div class="form-control-plaintext">
                                In order to use Whatsapp for notification purposes, connect a Whatsapp Account.
                            </div>
                            <img id="qr-placeholder" src="/images/qrcodeplaceholder.webp" alt="Placeholder QR Code" class="block rounded-5 bg-light mb-2" style="aspect-ratio:1/1; max-width:200px">
                            <div class="wa-section wa-logs fs-italic">
                            </div>
                            <div class="wa-section wa-qrcode" style="display: none;">
                                <img id="qrcode" src="">
                                <div class="mt-1">Please scan QR Code above to link your Whatsapp</div>
                            </div>
                            <div class="wa-section wa-info mt-3 p-5 rounded-5 bg-light-primary" style="display: none;">
                                <div>
                                    <i class="ti ti-circle-check text-success"></i> Whatsapp connected as <span class="wa-number fw-bold"></span>.
                                </div>
                                <div class="mt-3">
                                    <a href="javascript:;" class="btn btn-danger fw-bold">disconnect</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
<script src="{{ asset('/src/js/whatsapp.js') }}"></script>
<script>
    var HOST = "{{ env('WHATSAPP_SERVER') }}";
    jQuery(document).ready(function() {
        SystemSetting.init();
    });
</script>
@endsection
