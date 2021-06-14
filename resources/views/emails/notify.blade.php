<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>FixMaster.ng - We Fix, You Relax!</title>
    <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" />
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@fixmaster.com.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />

    <!-- <link rel="shortcut icon" href="images/favicon.ico"> -->
    <link rel="icon" href="{{ asset('assets/images/home-fix-logo.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Slider -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.theme.default.min.css') }}" />
    <!-- Main Css -->
    <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/client/css/colors/default.css') }}" rel="stylesheet" id="color-opt">



  </head>

  <body>
    <div class="container">
            <!-- Logo container-->
            <div>
                {{-- <a class="logo" href="{{ route('frontend.index') }}">
                <img src="{{ asset('assets/images/home-fix-logo.png') }}" class="l-dark" height="70" alt="">
                <img src="{{ asset('assets/images/home-fix-logo-new.png') }}" class="l-light" height="70" alt="">
                </a> --}}
                <a class="logo" href="{{ route('frontend.index', app()->getLocale()) }}">
                    {{-- <img src="{{ asset('assets/images/home-fix-logo.png') }}" class="l-dark" height="160" style="margin-top: -38px !important; margin-bottom: -38px !important;" alt="FixMaster Logo"> --}}

                    <img src="{{ asset('assets/images/home-fix-logo-new.png') }}" style="margin-top: -90px !important; margin-bottom: -38px !important;" class="l-light" height="250" alt="FixMaster Logo">

                    <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" style="margin-top: -40px !important; margin-bottom: -38px !important; margin-left: 50px !important" class="l-dark" height="70" alt="FixMaster Logo">

                </a>
            </div>
        <div style="margin-top: 2em; padding:1em;">
       

        <h1> Dear {{ ucfirst($user->firstname) }}</h1>
      @if($user->type=='cse')
      <p>Below is your referral code  </p>
      <p>Referral Code :  <?=  $user->code ?></p>
            @else
            <p>Below is your referral link, please copy and paste in browser  </p>
          <p>Referral Link :  <?= url('/en/registration/client?ref=' .$user->code) ?></p>
        @endif

        </div>
    </div>
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
    <script src="{{asset('assets/frontend/js/scroll.js')}}"></script>
    <script src="{{asset('assets/frontend/js/typed/lib/typed.js')}}"></script>
</body>
</html>
