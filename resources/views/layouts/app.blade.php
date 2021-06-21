
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="app-alt-name" content="{{ config('app.geolocation_api_key') }}">

    <title>@yield('title') | FixMaster - We Fix, You Relax!</title>
    {{-- <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" /> --}}
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@homefix.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />
    <!-- favicon -->
    <!-- <link rel="shortcut icon" href="images/favicon.ico"> -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Slider -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.carousel.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/client/css/owl.theme.default.min.css') }}" /> --}}
    <!-- Main Css -->
    <link href="{{ asset('assets/frontend/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <!-- <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" /> -->
    <link href="{{ asset('assets/client/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link href="{{ asset('assets/frontend/css/unicons.css') }}" rel="stylesheet" id="color-opt">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link href="{{ asset('assets/client/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    @stack('css')
    {{-- <link href="{{ asset('css/googlemap.css') }}" rel="stylesheet"> --}}
</head>

<body>

    @include('layouts.partials._frontend_header')

        @yield('contents')

    @include('layouts.partials._frontend_footer')

    <!-- Back to top -->
    <a href="#" class="btn btn-icon btn-soft-primary back-to-top"><i data-feather="arrow-up" class="icons"></i></a>
    <!-- Back to top -->

    <!-- javascript -->
    <script src="{{asset('assets/frontend/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/scrollspy.min.js')}}"></script>
    <!-- SLIDER -->
    <script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/owl.init.js')}}"></script>
    <!-- Icons -->
    <script src="{{asset('assets/frontend/js/feather.min.js')}}"></script>
    <!-- Switcher -->
    <script src="{{asset('assets/frontend/js/switcher.js')}}"></script>
    <!-- Main Js -->
    <script src="{{asset('assets/frontend/js/app.js')}}"></script>
    <!-- scroll -->
    {{-- <script src="{{asset('assets/frontend/js/scroll.js')}}"></script> --}}
    <script src="{{asset('assets/frontend/js/unicons.js')}}"></script>
    <script src="https://unicons.iconscout.com/release/v2.1.9/script/monochrome/bundle.js"></script>
    <script src="{{asset('assets/client/js/swiper.min.js')}}"></script>
    <script src="{{asset('assets/client/js/swiper.init.js')}}"></script>
    <script src="{{asset('assets/frontend/js/custom.js')}}"></script>
    {{-- <script src="{{ asset('js/googlemap.js') }}" defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('googlemap')['google_api_key']}}&callback=initMap" async defer></script> --}}
    <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>

    
    <script>
        function displayMessage(message, type){
      
          const Toast = swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 8000,
              timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
          });
          Toast.fire({
                  icon: type,
                //   type: 'success',
                  title: message
          });
      
        }
    </script>
      
    @yield('scripts')
    @stack('scripts')

</body>
</html>