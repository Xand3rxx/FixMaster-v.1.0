<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home | FixMaster.ng - We Fix, You Relax!</title>
    {{-- <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" /> --}}
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@homefix.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v2.0.1" />
    <!-- favicon -->
    <!-- <link rel="shortcut icon" href="images/favicon.ico"> -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Slider -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.theme.default.min.css') }}" />
    <!-- Main Css -->
    <link href="{{ asset('assets/frontend/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/client/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/client/css/swiper.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <style>
        .buy-btn-two {
            box-shadow: 0 3px 5px 0 rgba(233, 125, 31, 0.3) !important;
            border-color: #E97D1F !important;
            background-color: #E97D1F !important;
            color: #fff !important;
        }

        .buy-btn-two:hover {
            box-shadow: 0 3px 5px 0 rgba(233, 125, 31, 0.3) !important;
            border-color: #E97D1F !important;
            background-color: #E97D1F !important;
            color: #fff !important;
        }

        .btn.btn-light {
            color: #fff !important;
            border: 1px solid #e97d1f !important;
        }

        /* #topnav .navigation-menu.nav-light > li > a{
        color: #ffffff !important;
    }
    #topnav .navigation-menu.nav-light > li > a:hover{
        color: #e97d1f !important;
    }
    #topnav.nav-sticky .navigation-menu.nav-light > li > a {
        color: #3c4858 !important;
    } */

        #topnav .navigation-menu.nav-light>li>a {
            color: #ffffff !important;
        }

        #topnav .navigation-menu.nav-light>li>a:hover {
            color: #fff !important;
        }

        #topnav.nav-sticky .navigation-menu.nav-light>li>a {
            color: #3c4858 !important;
        }

        #topnav .navigation-menu.nav-light>li>a:focus {
            color: #ffff !important;
        }

        #topnav .navigation-menu.nav-light>li>a:active {
            color: #ffff !important;
        }

        @media (max-width: 991px) {
            #topnav .navigation-menu.nav-light>li>a {
                color: #3c4858 !important;
                padding: 10px 20px;
            }
        }
    </style>
    <header id="topnav" class="defaultscroll sticky">
        <div class="container">
            <!-- Logo container-->
            <div>
                {{-- <a class="logo" href="{{ route('frontend.index') }}">
                <img src="{{ asset('assets/images/home-fix-logo.png') }}" class="l-dark" height="70" alt="">
                <img src="{{ asset('assets/images/home-fix-logo-new.png') }}" class="l-light" height="70" alt="">
                </a> --}}
                <a class="logo" href="{{ route('frontend.index', app()->getLocale()) }}">
                    {{-- <img src="{{ asset('assets/images/home-fix-app()->getLocale()logo.png') }}" class="l-dark" height="160" style="margin-top: -38px !important; margin-bottom: -38px !important;" alt="FixMaster Logo"> --}}

                    <img src="{{ asset('assets/images/home-fix-logo-new.png') }}" style="margin-top: -90px !important; margin-bottom: -38px !important;" class="l-light" height="250" alt="FixMaster Logo">

                    <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" style="margin-top: -40px !important; margin-bottom: -38px !important; margin-left: 50px !important" class="l-dark" height="70" alt="FixMaster Logo">

                </a>
            </div>
            <div class="buy-button">
                <a href="{{ route('services.list', app()->getLocale()) }}" target="_blank">
                    <div class="btn btn-primary login-btn-primary">Book a Service</div>
                    <div class="btn btn-light login-btn-light buy-btn-two">Book a Service</div>
                </a>
            </div>
            <!--end login button-->
            <!-- End Logo container-->
            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu nav-light">
                    <li><a class="{{ Route::currentRouteNamed('frontend.index') ? 'selected' : '' }}" href="{{ route('frontend.index', app()->getLocale()) }}">Home</a></li>
                    <li><a class="{{ Route::currentRouteNamed('frontend.about') ? 'selected' : '' }}" href="{{ route('frontend.about', app()->getLocale()) }}">About us</a></li>

                    {{-- <li><a class="{{ Route::currentRouteNamed('frontend.how_it_works') ? 'selected' : '' }}" href="{{ route('frontend.how_it_works', app()->getLocale()) }}">How it works</a></li> --}}

                    {{-- <li><a class="{{ Route::currentRouteNamed('frontend.why_home_fix') ? 'selected' : '' }}" href="{{ route('frontend.why_home_fix', app()->getLocale()) }}">Why FixMaster?</a></li> --}}

                    {{-- <li><a class="{{ Route::currentRouteNamed('frontend.careers') ? 'selected' : '' }}" href="{{ route('frontend.careers', app()->getLocale()) }}">Join Us</a></li> --}}


                    <li class="has-submenu {{ Route::currentRouteNamed('frontend.how_it_works', 'frontend.faq') ? 'selected' : '' }}">
                        <a href="javascript:void(0)">How it works</a><span class="menu-arrow"></span>
                        <ul class="submenu">
                            <li><a class="{{ Route::currentRouteNamed('frontend.how_it_works') ? 'selected' : '' }}" href="{{ route('frontend.how_it_works', app()->getLocale()) }}">How It Works</a></li>
                            <li><a class="{{ Route::currentRouteNamed('frontend.faq') ? 'selected' : '' }}" href="{{ route('frontend.faq', app()->getLocale()) }}">FAQ</a></li>
                        </ul>
                    </li>
                    <li><a class="{{ Route::currentRouteNamed('frontend.contact') ? 'selected' : '' }}" href="{{ route('frontend.contact', app()->getLocale()) }}">Contact</a></li>
                    @auth
                    <li class="active"><a onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" href="{{ route('logout', app()->getLocale()) }}">Logout</a></li>

                    <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endauth
                    @guest
                    <li class="has-submenu {{ Route::currentRouteNamed('frontend.careers', 'login', 'register') ? 'selected' : '' }}"">
                    <a href=" javascript:void(0)">Get started</a><span class="menu-arrow"></span>
                        <ul class="submenu">
                            <li><a href="{{ route('frontend.registration.client.index', app()->getLocale()) }}">Register</a></li>
                            <li><a href="{{ route('login', app()->getLocale()) }}">Login</a></li>
                            <li class="has-submenu"><a href="javascript:void(0)"> Apply <span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="{{ route('frontend.careers', app()->getLocale()) }}">CSE</a></li>
                                        <li><a href="{{ route('frontend.careers', app()->getLocale()) }}">Supplier</a></li>
                                        <li><a href="{{ route('frontend.careers', app()->getLocale()) }}">Technician</a></li>
                                        {{-- <li><a href="{{ route('frontend.careers', app()->getLocale()) }}">Add Estate</a></li> --}}
                                    </ul>
                            </li>
                        </ul>
                    </li>
                    @endguest

                </ul>
                <!--end navigation menu-->

            </div>
            <!--end navigation-->
        </div>
        <!--end container-->
    </header>
    <!--end header-->

    <section class="swiper-slider-hero position-relative d-block vh-100" id="home">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide d-flex align-items-center overflow-hidden">
                    <div class="slide-inner slide-bg-image d-flex align-items-center" style="background: center center;" data-background="{{ asset('assets/images/electrician.jpg') }}">
                        <div class="bg-overlay"></div>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="title-heading text-center">
                                        <h1 class="heading mb-3" style="color: #ffffff;">Get A <span class="type"></span> <br> <span class="texty"> Client Service
                                                Executive</span> </h1>
                                        <p class="para-desc mx-auto text-muted1">We assign a dedicated Customer Service Executive to you who ensures your job is completed promptly and professionally</p>
                                        <p class="texty2">WE REPAIR while YOU RELAX!!!</p>
                                        <div class="mt-4">
                                            <a href="{{ route('services.list', app()->getLocale()) }}" class="btn btn-prim mt-2 mr-2 js-scroll-trigger">Book a Service</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end container-->
                    </div><!-- end slide-inner -->
                </div> <!-- end swiper-slide -->

                <div class="swiper-slide d-flex align-items-center overflow-hidden">
                    <div class="slide-inner slide-bg-image d-flex align-items-center" style="background: center center;" data-background="{{ asset('assets/images/newest/mech1.jpg') }}">
                        <div class="bg-overlay"></div>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="title-heading text-center">
                                        <h1 class="heading text-white title-dark mb-4">Allow Professionals Handle your Jobs</h1>

                                        <p class="para-desc mx-auto text-muted1">We offer convenient Quality Services. Book a service conveniently from any place at any time.</p>
                                        <p class="texty2">WE REPAIR while YOU RELAX!!!</p>

                                        <div class="mt-4">
                                            <a href="{{ route('services.list', app()->getLocale()) }}" class="btn btn-prim mt-2 mr-2 js-scroll-trigger">Book a Service</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end container-->
                    </div><!-- end slide-inner -->
                </div> <!-- end swiper-slide -->
            </div>
            <!-- end swiper-wrapper -->

            <!-- swipper controls -->
            <!-- <div class="swiper-pagination"></div> -->
            <div class="swiper-button-next border rounded-circle text-center"></div>
            <div class="swiper-button-prev border rounded-circle text-center"></div>
        </div>
        <!--end container-->
    </section>
    <!--end section-->
    <!-- Hero End -->

    <!-- How It Work Start -->
    @include('layouts.partials._how_it_works')
    <!-- How It Work End -->

    <!-- Why FixMaster Starts -->
    @include('layouts.partials._why_home_fix')
    <!-- Why FixMaster End -->


    <section id="requestService" class="section bg-light">
        <div class="container mt-5 mb-5">
            <p class="serv__1">Request a Service</p>
            <div class="row">
                <div class="col-md-7">
                    <p class="text-muted"> Below is a list of some of the services our <span class="texty font-weight-bold">Users</span> frequently request.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="card blog rounded border-0 shadow">
                        <div class="position-relative">
                            <img class="ult1 card-img-top rounded-top" src="{{ asset('assets/images/generato.jpg') }}" alt="Generator">

                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                            <h5 class="serv__2">Generators</h5>
                            <div class="post-meta d-flex justify-content-between mt-2">
                                <p class="serv__3 text-muted">We offer services for Generator repairs of all kinds.</p>
                            </div>
                            <a href="{{ route('services.list', app()->getLocale()) }}" class="btn btn-outline-fix btn-block">Request Service</a>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-lg-4 mt-4 pt-2">
                    <div class="card blog rounded border-0 shadow">
                        <div class="position-relative">
                            <img class="ult1 card-img-top rounded-top" src="{{ asset('assets/images/airconditioner.jpg') }}" alt="Air Conditioner">

                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                            <h5 class="serv__2">Air Conditioners</h5>
                            <div class="post-meta d-flex justify-content-between mt-2">
                                <p class="serv__3 text-muted">We provide you quality services include AC maintenance, Ac Repairing, Air conditioner Installation and AC service.</p>

                            </div>
                            <a href="{{ route('services.list', app()->getLocale()) }}" class="btn btn-outline-fix btn-block">Request Service</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="card blog rounded border-0 shadow">
                        <div class="position-relative">
                            <img class="ult1 card-img-top rounded-top" src="{{ asset('assets/images/electricals.jpg') }}" alt="null">

                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                            <h5 class="serv__2">Electricals</h5>
                            <div class="post-meta d-flex justify-content-between mt-2">
                                <p class="serv__3 text-muted">We repair all kinds electrical appliances such as Televisons, DvDs, Sound Systems etc.</p>

                            </div>
                            <a href="{{ route('services.list', app()->getLocale()) }}" class="btn btn-outline-fix btn-block">Request Service</a>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <div class="row mt-3">
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="card blog rounded border-0 shadow">
                        <div class="position-relative">
                            <img class="ult1 card-img-top rounded-top" src="{{ asset('assets/images/plumbing.jpg') }}" alt="Plumbing">

                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                            <h5 class="serv__2">Plumbing</h5>
                            <div class="post-meta d-flex justify-content-between mt-2">
                                <p class="serv__3 text-muted">We can fix all plumbing job types. Fix it right with an expert plumber. You Can Count On! All works are carried out promptly.</p>
                            </div>
                            <a href="{{ route('services.list', app()->getLocale()) }}" class="btn btn-outline-fix btn-block">Request Service</a>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-lg-4 mt-4 pt-2">
                    <div class="card blog rounded border-0 shadow">
                        <div class="position-relative">
                            <img class="ult1 card-img-top rounded-top" src="{{ asset('assets/images/households.jpg') }}" alt="Household Aplliances">

                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                            <h5 class="serv__2">Household Equipments</h5>
                            <div class="post-meta d-flex justify-content-between mt-2">
                                <p class="serv__3 text-muted">If you've got a leaky fridge, a rattling dryer, a barely cooling HVAC, a stove that no longer sizzles or a clogged dishwasher, we've got you covered.</p>

                            </div>
                            <a href="{{ route('services.list', app()->getLocale()) }}" class="btn btn-outline-fix btn-block">Request Service</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="card blog rounded border-0 shadow">
                        <div class="position-relative">
                            <img class="ult1 card-img-top rounded-top" src="{{ asset('assets/images/gadgets.jpg') }}" alt="Gadgets">

                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                            <h5 class="serv__2">Gadgets</h5>
                            <div class="post-meta d-flex justify-content-between mt-2">
                                <p class="serv__3 text-muted">We repair and fix all kinds of phones,IPhone,Android and Windows Phone etc.</p>

                            </div>
                            <a href="{{ route('services.list', app()->getLocale()) }}" class="btn btn-outline-fix btn-block">Request Service</a>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <p class="text-center mt-4"><a href="{{ route('services.list', app()->getLocale()) }}" class="browse">Browse more services &rarr;</a></p>
        </div>
    </section>

    <!-- Testi Start -->
    {{-- @include('layouts.partials._client_reviews') --}}
    <!-- Testi End -->

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
    <script src="{{asset('assets/frontend/js/scroll.js')}}"></script>
    <script src="{{asset('assets/frontend/js/typed/lib/typed.js')}}"></script>
    <script src="{{asset('assets/client/js/swiper.min.js')}}"></script>
    <script src="{{asset('assets/client/js/swiper.init.js')}}"></script>

    <script>
        var typed = new Typed('.type', {
            strings: [
                "Trusted and Dedicated",
                "Professional"
            ],
            stringsElement: null,
            typeSpeed: 100,
            startDelay: 1200,
            backSpeed: 50,
            backDelay: 1200,
            loop: true,
            showCursor: true,
            cursorChar: '|'
        });
    </script>
</body>

</html>
