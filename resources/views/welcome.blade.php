<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png')}}">


    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    @if ($seo['noindex'])
    <meta name="robots" content="noindex, follow">
    @else
    <link rel="canonical" href="{{ $seo['url'] }}">
    @endif

    <!-- Aperçu de partage (WhatsApp, Facebook, LinkedIn, X) -->
    <meta property="og:site_name" content="Fungi For Nature">
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $seo['url'] }}">
    <meta property="og:image" content="{{ $seo['image'] }}">
    <meta property="og:locale" content="en_GB">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $seo['image'] }}">

    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css" rel="stylesheet" integrity="sha256-V6lu+OdYNKTKTsVFBuQsyIlDiRWiOmtC8VQ8Lzdm2i4=" crossorigin="anonymous"> --}}
    <link href="{{asset('assets/css/revolution-slider.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <div id="app"></div>

    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> --}}
    <script src="{{asset('assets/js/revolution.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.fancybox.pack.js')}}"></script>
    <script src="{{asset('assets/js/jquery.fancybox-media.js')}}"></script>
    <script src="{{asset('assets/js/mixitup.js')}}"></script>
    <script src="{{asset('assets/js/owl.js')}}"></script>
    <script src="{{asset('assets/js/wow.js')}}"></script>
    {{-- <script src="{{asset('assets/js/script.js')}}"></script> --}}

</body>

</html>
