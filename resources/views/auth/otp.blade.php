@extends('layouts.auth')

@section('content')
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="mb-5">
                    <a href="{{url('/')}}"><img src="{{env('SSO_URL').'/storage/'.setting('site_logo')}}" alt="Devtektif Logo" class="d-block" style="height: 2.5em; object-fit:cover; border-radius:99px"></a>
                </div>
                <h1 class="fs-2">Submit OTP</h1>
                <p class="fs-6 text-muted mb-3">Check your <strong>{{$email}}</strong>, and input your OTP code in below.</p>
                @if(session('warning'))
                  <div class="alert alert-warning">
                    {{ session('warning') }}
                  </div>
                @endif
                @if(session('success'))
                  <div class="alert alert-success">
                    {{ session('success') }}
                  </div>
                @endif
                <form action="{{ route('login.otp') }}" method="POST">
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
                    <button class="btn btn-primary btn-lg btn-block shadow-lg mt-4">Log in</button>
                </form>
                <form action="{{ $email ? route('login.email') : route('login.phone')}}" method="post">
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
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right" style="background: linear-gradient(45deg, #f4942c, #ef7831, #e4443b); !important">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const resendButton = document.getElementById('resendButton');
    const countdownSpan = document.getElementById('countdown');
    let countdownTime = 300; // 5 minutes in seconds
    let countdownInterval;

    function startCountdown() {
        resendButton.disabled = true;
        countdownInterval = setInterval(updateCountdown, 1000);
    }

    function updateCountdown() {
        const minutes = Math.floor(countdownTime / 60);
        const seconds = countdownTime % 60;
        countdownSpan.textContent = `(${minutes}:${seconds.toString().padStart(2, '0')})`;
        
        if (countdownTime <= 0) {
            clearInterval(countdownInterval);
            resendButton.disabled = false;
            countdownSpan.textContent = '';
        } else {
            countdownTime--;
        }
    }

    resendButton.addEventListener('click', function(e) {
        e.preventDefault();
        this.form.submit();
        startCountdown();
    });

    // Check if there's a stored countdown time in localStorage
    const storedCountdownTime = localStorage.getItem('otpCountdownTime');
    const storedTimestamp = localStorage.getItem('otpCountdownTimestamp');
    
    if (storedCountdownTime && storedTimestamp) {
        const elapsedTime = Math.floor((Date.now() - parseInt(storedTimestamp)) / 1000);
        countdownTime = Math.max(0, parseInt(storedCountdownTime) - elapsedTime);
        
        if (countdownTime > 0) {
            startCountdown();
        }
    }

    // Store countdown time and timestamp when leaving the page
    window.addEventListener('beforeunload', function() {
        if (countdownTime > 0) {
            localStorage.setItem('otpCountdownTime', countdownTime.toString());
            localStorage.setItem('otpCountdownTimestamp', Date.now().toString());
        } else {
            localStorage.removeItem('otpCountdownTime');
            localStorage.removeItem('otpCountdownTimestamp');
        }
    });
});
</script>
@endsection