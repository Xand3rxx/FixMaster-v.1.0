
<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
    {{-- <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" /> --}}
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@fixmaster.com.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />
    
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link href="{{ asset('assets/client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Main Css -->
    <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/client/css/colors/default.css') }}" rel="stylesheet" id="color-opt">

</head>

<body>
    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div> -->
    <!-- Loader -->
    
    <!-- Navbar STart -->
<!-- Navbar STart -->
<style>
    #topnav .navigation-menu.nav-light > li > a{
        /* color: #ffffff !important; */
        color: #3c4858 !important;
    }
    #topnav .navigation-menu.nav-light > li > a:hover{
        color: #fff !important;
    }
    #topnav.nav-sticky .navigation-menu.nav-light > li > a {
        color: #3c4858 !important;
    }
    #topnav .navigation-menu.nav-light > li > a:focus{
        color: #ffff !important;
    }

    #topnav .navigation-menu.nav-light > li > a:active{
        color: #ffff !important;
    }
    /* #topnav.nav-sticky .navigation-menu > li > a {
        color: #3c4858 !important;
    } */
    /* #topnav .navigation-menu .has-submenu .menu-arrow {
        border: solid #ffffff;
    } */
    @media (max-width: 991px){
        #topnav .navigation-menu.nav-light > li > a {
            color: #3c4858 !important;
            padding: 10px 20px;
        }
    }

    .event-width{
        width: 320px !important;
    }

    @media (max-width: 992px){
        .event-width{
            margin-left: -20px !important;
        }
    }

    .avatar.avatar-large {
        border: 1px solid;
        border-color: #e97d1f;
    }
</style>
<!-- Navbar STart -->
<header id="topnav" class="defaultscroll sticky navbar-dark">
    <div class="container">
        <!-- Logo container-->
        <div>
        <a class="logo" href="#">
            <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" style="margin-top: -40px !important; margin-bottom: -38px !important; margin-left: 50px !important" height="70" alt="FixMaster Logo">
        </a>
        </div>                 
        
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
                <li ><a href="{{ route('frontend.home', app()->getLocale()) }}">FixMaster Home</a></li>

                <li><a class="" href="{{ route('frontend.about', app()->getLocale()) }}">About us</a></li>
                
                <li class="has-submenu">
                    <a href="javascript:void(0)">How it works</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a class="" href="{{ route('frontend.how_it_works', app()->getLocale()) }}">How It Works</a></li>
                        <li><a class="" href="{{ route('frontend.faq', app()->getLocale()) }}">FAQ</a></li>
                    </ul>
                </li>
                
                <li><a class="{{ Route::currentRouteNamed('frontend.contact') ? 'selected' : '' }}" href="{{ route('frontend.contact', app()->getLocale()) }}">Contact</a></li>

                <li class="has-submenu {{ Route::currentRouteNamed('client.index', 'client.services.list', 'client.services.details', 'client.services.quote', 'client.service.all', 'client.request_details') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="l-dark l-light">Profile</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li class="{{ Route::currentRouteNamed('client.index', app()->getLocale()) ? 'active' : '' }}"><a href="{{ route('client.index') }}">Dashboard</a></li>

                        <li class="{{ Route::currentRouteNamed('client.services.list', 'client.services.list', 'client.services.details', 'client.services.quote') ? 'active' : '' }}"><a href="{{ route('client.services.list') }}">Book a Service</a></li>

                        <li class="{{ Route::currentRouteNamed('') ? 'active' : '' }}"><a href="#">E-Wallet</a></li>

                        <li class="{{ Route::currentRouteNamed('client.service.all', 'client.request_details') ? 'active' : '' }}"><a href="{{ route('client.requests') }}">Requests</a></li>

                        <li class="{{ Route::currentRouteNamed('client.payments') ? 'active' : '' }}"><a href="{{ route('client.payments'), app()->getLocale() }}">Payments</a></li>

                        <li class="{{ Route::currentRouteNamed('client.messages') ? 'active' : '' }}"><a href="#">Messages</a></li>

                        <li class="{{ Route::currentRouteNamed('client.settings') ? 'active' : '' }}"><a href="{{ route('client.settings', app()->getLocale()) }}">Settings</a></li>


                        {{-- <li><a href="{{ route('login') }}">Logout</a></li> --}}
                    </ul>
                </li>

                <li title="Logout"><a href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" href="{{ route('logout', app()->getLocale()) }}"><i class="uil uil-sign-out-alt" style="font-size: 20px" ></i></a></li>

                <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
<!-- Navbar End -->
<!-- Navbar End -->
