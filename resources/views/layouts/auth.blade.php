
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
        {{-- <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
        <meta name="Telephone" content="Tel: +234 903 554 7107" /> --}}
        <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
        <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
        <meta name="email" content="info@fixmaster.com.ng" />
        <meta name="website" content="https://www.fixmaster.com.ng" />
        <meta name="Version" content="v0.0.1" />
        <!-- favicon -->
        <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" />

        <!-- Bootstrap -->
        {{-- <link href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="{{ asset('assets/dashboard/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Main Css -->
        <link href="{{ asset('assets/dashboard/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
        <link href="{{ asset('assets/dashboard/css/colors/default.css') }}" rel="stylesheet" id="color-opt"> --}}
        <link href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="{{ asset('assets/frontend/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Slider -->
        <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.carousel.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.theme.default.min.css') }}" />
        <!-- Main Css -->
        <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
        <link href="{{ asset('assets/frontend/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
        <link rel="stylesheet" href="{{asset('assets/frontend/css/unicons.css') }}" type="text/css" >

    </head>

    <body>
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div>
        <!-- Loader -->

       
        
        <div class="back-to-home rounded d-none d-sm-block">
        <a href="{{ route('frontend.index',app()->getLocale()) }}" class="btn btn-icon btn-soft-primary"><i data-feather="home" class="icons"></i></a>
        </div>
        
        <!-- Hero Start -->
        
        @yield('content')
        <!--end section-->
        <!-- Hero End -->

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
        <script src="{{ asset('assets/frontend/js/unicons.js') }}"></script>
        <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>

        <!-- geolocation asset starts here -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4Cgk4_memXity0NLrIGyjS3ORuMykkkQ&v=3.exp&libraries=places"></script>
        <script src="{{asset('assets/frontend/js/geolocation.js')}}"></script>
        <!-- geolocation asset starts here -->
        
        <script>
            //Prevent characters or string asides number in ohone number input field 
            $("#number, #phone_number").on("keypress keyup blur", function(event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

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