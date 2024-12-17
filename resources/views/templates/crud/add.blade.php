{{-- template/crud/index.blade.php --}}
@php
$settingPage = $settingPage ?? null;
@endphp
@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="/dist/assets/extensions/filepond/filepond.css">
<link rel="stylesheet" href="/dist/assets/compiled/css/filepond-pdf-preview.css">
<link rel="stylesheet" href="/dist/assets/extensions/flatpickr/flatpickr.min.css">
<link rel="stylesheet" href="/dist/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
<link rel="stylesheet" href="/dist/assets/extensions/choices.js/public/assets/styles/choices.css">
@yield('css')
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-start">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item text-capitalize"><a href="{{route($routeName.'.index')}}">{{$routeName}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 order-md-1 order-last">
                <div class="d-flex align-items-center justify-content-between gap-2 w-full">
                    <div>
                        <h3>@yield('title')</h3>
                        <p class="text-subtitle text-muted">@yield('description')</p>
                    </div>
                    @if ($settingPage)
                    <a href="{{route($routeName.'.setting', $routeId ?? null)}}" class="btn btn-light-secondary d-flex align-items-center justify-content-center rounded-3" style="aspect-ratio:1/1;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12.428 2c-1.114 0-2.129.6-4.157 1.802l-.686.406C5.555 5.41 4.542 6.011 3.985 7c-.557.99-.557 2.19-.557 4.594v.812c0 2.403 0 3.605.557 4.594s1.57 1.59 3.6 2.791l.686.407C10.299 21.399 11.314 22 12.428 22s2.128-.6 4.157-1.802l.686-.407c2.028-1.2 3.043-1.802 3.6-2.791c.557-.99.557-2.19.557-4.594v-.812c0-2.403 0-3.605-.557-4.594s-1.572-1.59-3.6-2.792l-.686-.406C14.555 2.601 13.542 2 12.428 2m-3.75 10a3.75 3.75 0 1 1 7.5 0a3.75 3.75 0 0 1-7.5 0" clip-rule="evenodd"/></svg>
                    </a>
                    @endif
                </div>
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