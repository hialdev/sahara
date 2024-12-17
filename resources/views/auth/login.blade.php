@extends('layouts.auth')

@section('content')
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="mb-5">
                    <a href="{{url('/')}}"><img src="{{env('SSO_URL').'/storage/'.setting('site_logo')}}" alt="Devtektif Logo" class="d-block" style="height: 2.5em; object-fit:cover; border-radius:99px"></a>
                </div>
                <h1 class="fs-2">Log in.</h1>
                <p class="fs-6 text-muted mb-3">Log in with your data that you entered during registration.</p>

                <ul class="nav nav-tabs mb-1" id="loginTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="true">Password</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab" aria-controls="email" aria-selected="false">Email</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone" type="button" role="tab" aria-controls="phone" aria-selected="false">Phone</button>
                    </li>
                </ul>
                <div class="tab-content" id="loginTabContent">
                    <div class="tab-pane fade show active" id="password" role="tabpanel" aria-labelledby="password-tab">
                        @if(session('error'))
                            <div class="invalid-feedback mb-3" role="alert">
                                <strong>{{session('error')}}</strong>
                            </div>
                        @endif
                        <form action="{{ route('login.password') }}" method="POST">
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
                                <input name="remember" class="form-check-input me-2" type="checkbox" {{ old('remember') ? 'checked' : '' }} checked id="flexCheckDefault">
                                <label class="form-check-label text-gray-600 mt-1" for="flexCheckDefault">
                                    Keep login for 7 days
                                </label>
                            </div>
                            <button class="btn btn-primary btn-lg btn-block shadow-lg mt-4">Log in</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                        <form action="{{ route('login.email') }}" method="POST">
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
                            <button class="btn btn-primary btn-lg btn-block shadow-lg mt-2">Log in</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="phone" role="tabpanel" aria-labelledby="phone-tab">
                        <form action="{{ route('login.phone') }}" method="POST">
                            @csrf
                            <div class="form-group position-relative has-icon-left mb-2">
                                <input type="number" name="phone" class="form-control form-control-xl @error('phone') is-invalid @enderror" placeholder="Phone" value="{{old('phone')}}">
                                <div class="form-control-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                            </div>
                            @error('phone')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <button class="btn btn-primary btn-lg btn-block shadow-lg mt-2">Log in</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3 text-lg fs-6">
                    <p class="text-gray-600">Don't have an account? <a href="" class="font-bold">Contact us</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right" style="background: linear-gradient(45deg, #f4942c, #ef7831, #e4443b); !important">
            </div>
        </div>
    </div>
</div>
@endsection