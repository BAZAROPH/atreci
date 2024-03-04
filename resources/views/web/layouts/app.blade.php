@php($categorieEcommerce = categorieEcommerce(2))
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta content="{{ strip_tags($parametre->description) }}" name="description">
    <meta content="{{ $parametre->keywords }}" name="keywords">
    <meta property="og:title" content="{{ $parametre->libelle }} @isset($title)- {{ $title }}@endisset" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="{{ asset('assets/img/logo.png') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $parametre->libelle }} @isset($title) - {{ $title }} @endisset
    </title>

    {{--  {!! htmlScriptTagJsApiV3([
        'action' => 'homepage'
    ]) !!}  --}}

    {!! htmlScriptTagJsApi(/* $formId - INVISIBLE version only */) !!}
    {{-- {!! htmlScriptTagJsApi($configuration) !!} --}}

    <!-- Favicons -->
    {{-- @if(!empty($parametre->getMedia('icon')->first()))
        <link href="{{ url($parametre->getMedia('icon')->first()->getUrl('thumb')) }}" rel="icon">
        <link href="{{ url($parametre->getMedia('icon')->first()->getUrl('thumb')) }}" rel="apple-touch-icon">
    @endif --}}
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <!-- Styles -->

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/bower/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/assets/plugins/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/bower/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="apple-touch-icon" href="{{ asset('web/img/icon/icon.jpg') }}">
    <link rel="icon" type="image/jpg" href="{{ asset('web/img/icon/icon.jpg') }}">
    <link rel="icon" type="image/jpg" href="{{ asset('web/img/icon/icon.jpg') }}">
    {{-- <link rel="manifest" href="{{ asset('web/site.webmanifest') }}"> --}}
    {{-- <link rel="mask-icon" color="#fe6a6a" href="{{ asset('web/img/icon/safari-pinned-tab.svg') }}"> --}}
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Dosis|Montserrat|Nunito|Open+Sans|Oxygen|PT+Sans|Poppins|Raleway|Ubuntu&display=swap" rel="stylesheet">
    <!-- iconfont -->
    <link rel="stylesheet" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css">
    <!-- Font Awesone -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-F8FPPK9L2G"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-F8FPPK9L2G');
    </script>

    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{ asset('web/vendor/simplebar/dist/simplebar.min.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('web/vendor/tiny-slider/dist/tiny-slider.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('web/vendor/drift-zoom/dist/drift-basic.min.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('web/vendor/nouislider/distribute/nouislider.min.css') }}"/>
    <link rel="stylesheet" media="screen" href="{{ asset('web/vendor/lightgallery.js/dist/css/lightgallery.min.css') }}" />
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{ asset('web/css/theme.css') }}">
    <link rel="stylesheet" media="screen" href="{{ asset('web/css/persanaliser.css') }}">
    @livewireStyles
</head>
<body class="toolbar-enabled">
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.3&appId=1309978652408851&autoLogAppEvents=1"></script>

    @include('web.layouts.header')
    @yield('content')
    @include('web.layouts.footer')
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="{{ asset('web/vendor/jquery/dist/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('web/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('web/vendor/bs-custom-file-input/dist/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('web/vendor/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('web/vendor/tiny-slider/dist/min/tiny-slider.js') }}"></script>
    <script src="{{ asset('web/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
    <script src="{{ asset('web/vendor/drift-zoom/dist/Drift.min.js') }}"></script>
    <script src="{{ asset('web/vendor/lightgallery.js/dist/js/lightgallery.min.js') }}"></script>
    <script src="{{ asset('web/vendor/lg-video.js/dist/lg-video.min.js') }}"></script>
    <script src="{{ asset('web/vendor/nouislider/distribute/nouislider.min.js') }}"></script>

    <!-- Main theme script-->
    <script src="{{ asset('web/js/theme.min.js') }}"></script>
    <script>
        $('#flash-overlay-modal').modal();
    </script>
    @include('sweetalert::alert')

    @stack('dataTable')

    {{-- <script type="text/javascript">
        $('.toggle1').change(function() {
            var mode = $(this).val();
            var nbr_commande = $("#nbr_commande").val();
            var totalCommande = $("#totalCommande").val();

            if(mode == 351){
                    $('.Myfrais').show();
                    $('.totalAmount').show();
                    $('.totalCommande').hide();
                    $('.Myacompte').show();
                    $('.resteAPayer').show();
                    $('#suivant').hide();

            }
            else{
                $('.Myfrais').hide();
                $('.totalAmount').hide();
                $('.totalCommande').show();
                $('.Myacompte').hide();
                $('.resteAPayer').hide();
                $('#suivant').show();
                $('#monAcompte').hide();
            }
        });
    </script> --}}

    {{--  <script type="text/javascript">
        $('#add-address').modal('show');
    </script>  --}}
    <!-- lazyload -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
    <script type="text/javascript">
        $("img").lazyload({
            effect : "fadeIn"
        });
    </script> --}}

    @if($errors->any())
        <script type="text/javascript">
            $(window).on('load', function() {
                $('#signin-modal').modal('show');
            });
        </script>
    @endif

    @livewireScripts
</body>
</html>
