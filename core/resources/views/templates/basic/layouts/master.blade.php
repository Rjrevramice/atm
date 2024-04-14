<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $general->sitename($pageTitle ?? '') }}</title>
    @include('partials.seo')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/odometer.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue. 'frontend/css/main.css')}}">
     <!-- referrer tree -->
     <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/js/jorg-charts/tree.css')}}">
    @stack('style-lib')
    @stack('style')
    <link href="{{ asset($activeTemplateTrue . 'frontend/css/color.php') }}?color={{$general->base_color}}&secondColor={{$general->secondary_color}}" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


    <style>
        *{
            font-family: 'Poppins', sans-serif !important;
        }
        .la, .las ,.lar,.fas,.far,.fa {
            font-family: 'Line Awesome Free' !important;
            font-weight: 900 !important;
        }
    </style>

</head>

<body>
    @stack('fbComment')
    <div class="overlay"></div>
    <a href="{{route('home')}}" class="scrollToTop"><i class="fas fa-angle-up"></i></a>
    <div class="preloader">
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
    </div>
    @include($activeTemplate.'partials.user_header')
    @yield('content')
    @include($activeTemplate.'partials.footer')
    <script src="{{asset($activeTemplateTrue. 'frontend/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/modernizr-3.6.0.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/plugins.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/magnific-popup.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/wow.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/owl.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/odometer.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/viewport.jquery.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/nice-select.js')}}"></script>
    <script src="{{asset($activeTemplateTrue. 'frontend/js/main.js')}}"></script>
    <!-- referrer tree -->
    <script src="{{asset('assets/admin/js/jorg-charts/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jorg-charts/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/admin/js/jorg-charts/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jorg-charts/tree.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery-kinetic/jquery.kinetic.js')}}"></script>
    <script src="{{asset('assets/admin/js/jorg-charts/jquery.jOrgChart.js')}}"></script>
    @stack('script-lib')
    @stack('script')
    @include('partials.plugins')
    @include('partials.notify')
    <script>
        (function ($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{route('home')}}/change/"+$(this).val() ;
            });
        })(jQuery);
    </script>
</body>
</html>
