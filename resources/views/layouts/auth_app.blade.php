<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="{{asset('/vendors/base/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('/images/favicon.png')}}" />
    <style>
        .login-full-bg {
            background: url("{{ asset('images/auth/login-bg.png') }}") no-repeat center center;
            background-size: cover;
            min-height: 100vh;
            position: relative;
        }
        .login-full-bg::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 450px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        .login-copyright {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            color: #fff;
            z-index: 1;
        }
    </style>
</head>

<body>
<div class="login-full-bg d-flex align-items-center justify-content-center">
    <div class="login-card">
        @yield('content')
    </div>
    <p class="login-copyright">Copyright &copy; <strong>Petercodes</strong> 2026</p>
</div>
<!-- plugins:js -->
<script src="{{asset('/vendors/base/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="{{asset('/js/off-canvas.js')}}"></script>
<script src="{{asset('/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('/js/template.js')}}"></script>
<!-- endinject -->
</body>

</html>
