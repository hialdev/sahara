{{-- template/crud/index.blade.php --}}
@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="/dist/assets/extensions/filepond/filepond.css">
<link rel="stylesheet" href="/dist/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
<link rel="stylesheet" href="/dist/assets/extensions/choices.js/public/assets/styles/choices.css">
@yield('css')
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>@yield('title')</h3>
                <p class="text-subtitle text-muted">@yield('description')</p>
            </div>
        </div>
    </div>

    <!-- Form start -->
    <section class="section">
        @yield('form')
    </section>
    <!-- Form end -->

</div>
@endsection

@section('scripts')
@yield('scripts')
@endsection