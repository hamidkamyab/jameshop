<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قالب دیجی استایل</title>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/jquery.custom-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fonticon/css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fonticon/css/fontello-ie7.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fonticon/css/fontello.css') }}">
    @yield('head')
</head>
<body class="BYekan vh-100">
    <div class="bodyBox mCustomScrollbar HoverSC mCS_noMargin mCS_rightPos overflow-hidden vh-100 p-0" data-mcs-theme="light">
        @include('client.layouts.header')
            @yield('content')
        @include('client.layouts.footer')

    </div>

</body>
<footer>
    <script src="{{ asset('js/jquery.custom-scrollbar.js') }}"></script>
    <script src="{{ asset('js/client.js') }}"></script>
    @yield('footer')

</footer>

</html>
