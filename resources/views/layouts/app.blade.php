<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sahara Information System</title>
        
        <link rel="shortcut icon" href="{{env('SSO_URL').'/storage/'.setting('site_logo')}}" type="image/x-icon">    
        
        @yield('css')
        
        <link rel="stylesheet" href="/dist/assets/extensions/sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/extra-component-sweetalert.css">
        <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/app.css">
        <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/app-dark.css">
        <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/iconly.css">
        <style>
            .tox .tox-editor-header{
                z-index: auto !important;
            }
        </style>
    </head>

    <body>
        <script src="/dist/assets/static/js/initTheme.js"></script>
        <div id="app">
            @include('partials.sidebar')
            <div id="main">
                <div class="d-flex mb-4 align-items-center justify-content-between">
                    <header class="mb-3">
                        <a href="#" class="burger-btn d-block d-xl-none">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                    </header>
                    @php
                        $user = Auth::user();
                    @endphp
                    <div class="dropdown">
                        <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar avatar-lg" style="background: #f0f0f0">
                                <img src="{{env('SSO_URL').'/storage'.'/'.$user->image}}" alt="{{$user->name}} Photo Profile">
                            </div>
                            <div class="text">
                                <h6 class="user-dropdown-name">{{$user->name}}</h6>
                                <p class="user-dropdown-status text-sm text-muted">{{$user->roles[0]->name}}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                            <li>
                                <a href="{{env('ACCOUNT_URL')}}/my" class="dropdown-item">My Account</a>
                            </li>
                            <li>
                                <form action="http://account.sahara.test/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                
                @yield('content')

                @include('partials.footer')
            </div>
        </div>
        <script src="/dist/assets/static/js/components/dark.js"></script>
        <script src="/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        
        <script src="/dist/assets/compiled/js/app.js"></script>
        
        <!-- Need: Apexcharts -->
        <script src="/dist/assets/extensions/apexcharts/apexcharts.min.js"></script>
        <script src="/dist/assets/extensions/jquery/jquery.min.js"></script>
        
        {{-- Sweet Alert --}}
        <script src="/dist/assets/extensions/sweetalert2/sweetalert2.min.js"></script>
        <script src="/dist/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
        <script src="/dist/assets/static/js/pages/form-element-select.js"></script>
        
        {{-- File Pond --}}
        <script src="/dist/assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
        <script src="/dist/assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
        <script src="/dist/assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
        <script src="/dist/assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
        <script src="/dist/assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js"></script>
        <script src="/dist/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
        <script src="/dist/assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
        <script src="/dist/assets/extensions/filepond/filepond.js"></script>
        <script src="/dist/assets/extensions/toastify-js/src/toastify.js"></script>
        <script src="/dist/assets/static/js/pages/filepond.js"></script>
        
        <script>
            // If you want to use tooltips in your project, we suggest initializing them globally
            // instead of a "per-page" level.
            document.addEventListener('DOMContentLoaded', function () {

                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            }, false);
        </script>

        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
        </script>
        
        @if(session('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{session('success')}}"
            })
        </script>
        @endif

        @if(session('warning'))
        <script>
            Toast.fire({
                icon: 'warning',
                title: "{{session('warning')}}"
            })
        </script>
        @endif

        @if(session('error'))
            <script>
            Toast.fire({
                icon: 'error',
                title: "{{session('error')}}"
            })
            </script>
        @endif
        @yield('scripts')

    </body>

</html>