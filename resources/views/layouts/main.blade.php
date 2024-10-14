<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/tempus.css') }}">
    <script src="{{ asset('assets/js/tempus.js') }}"></script>
    
    @yield('head')

</head>

<body>

    @yield('body')

    @yield('script')


    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>

</body>

</html>
