@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Verifikasi</h3>
                <p class="text-subtitle text-muted">Kode OTP Telah kami kirimkan ke <strong>{{$email ?? $phone}}</strong> masukkan kode tersebut untuk memverifikasi </p>
            
                @if(session('success'))
                  <div class="alert alert-success">
                    {{ session('success') }}
                  </div>
                @endif
                <form action="{{ route('verifikasi.send') }}" method="POST">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-2">
                        <input type="number" name="otp" class="form-control form-control-xl @error('otp') is-invalid @enderror" placeholder="OTP Code" value="{{old('otp')}}">
                        <div class="form-control-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                    </div>
                    <input type="hidden" name="{{$email ? 'email' : 'phone'}}" value="{{$email ?? $phone}}">
                    @error('otp')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <button class="btn btn-primary btn-lg btn-block shadow-lg mt-4">Verifikasi</button>
                </form>
                <form action="{{ $email ? route('verifikasi.email') : route('verifikasi.phone')}}" method="post">
                  @csrf
                  <input type="hidden" name="{{$email ? 'email' : 'phone'}}" value="{{$email ?? $phone}}">
                  <div class="text-center mt-3 text-lg fs-6">
                    <div class="text-gray-600">
                      Code expired? 
                      <button type="submit" id="resendButton" class="font-bold btn btn-outline-primary border-0">Re-send</button>
                      <span id="countdown" class="text-muted"></span>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection