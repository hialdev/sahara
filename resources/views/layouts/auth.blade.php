<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management & Purchase System</title>
    
    <link rel="shortcut icon" href="{{env('SSO_URL').'/storage/'.setting('site_logo')}}" type="image/x-icon">    

    @yield('css')

    <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" crossorigin href="/dist/assets/compiled/css/auth.css">
</head>

<body>
    <script src="/dist/assets/static/js/initTheme.js"></script>
    <div id="app">
        @yield('content')
    </div>
    <script src="/dist/assets/static/js/components/dark.js"></script>
    <script src="/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    
    <script src="/dist/assets/compiled/js/app.js"></script>
    
    <!-- Need: Apexcharts -->
    <script src="/dist/assets/extensions/apexcharts/apexcharts.min.js"></script>
    
    
    @yield('scripts')

    </body>

</html>