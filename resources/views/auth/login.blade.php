@extends('layouts.auth')

@section('content')
<div id="auth">
        
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class=" mb-5">
                    <a href="{{url('/')}}"><img src="/images/devtektiflogo.jpeg" alt="Devtektif Logo" class="d-block" style="height: 2.5em; object-fit:cover; border-radius:99px"></a>
                </div>
                <h1 class="fs-2">Log in.</h1>
                <p class="fs-6 text-muted mb-3">Log in with your data that you entered during registration.</p>
    
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group position-relative has-icon-left mb-2">
                        <input type="email" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group position-relative has-icon-left mb-2">
                        <input type="password" name="password" class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Password" value="{{old('password')}}">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-check d-flex align-items-center">
                        <input name="remember" class="form-check-input me-2" type="checkbox" {{ old('remember') ? 'checked' : '' }} id="flexCheckDefault">
                        <label class="form-check-label text-gray-600 mt-1" for="flexCheckDefault">
                            Keep me logged in
                        </label>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block shadow-lg mt-4">Log in</button>
                </form>
                <div class="text-center mt-3 text-lg fs-6">
                    <p class="text-gray-600">Don't have an account? <a href="" class="font-bold">Contact us</a>.</p>
                    {{-- @if (Route::has('password.request'))
                    <p><a class="font-bold" href="{{route('password.request')}}">Forgot password?</a>.</p>
                    @endif --}}
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right" style="background: #77217a !important">
    
            </div>
        </div>
    </div>
    
</div>
@endsection
