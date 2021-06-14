<style>
    #topnav .navigation-menu.nav-light > li > a{
        color: #ffffff !important;
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

    .alert-dismissible .close-alert{
  font-size: 30px;
 position: relative;
  top:-10px;
  cursor:pointer !important;
}
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
        <a class="logo" href="">
            <img src="{{ asset('assets/images/home-fix-logo-new.png') }}" style="margin-top: -90px !important; margin-bottom: -38px !important;" class="l-light" height="250" alt="FixMaster Logo">

            <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" style="margin-top: -40px !important; margin-bottom: -38px !important; margin-left: 50px !important"  class="l-dark" height="70" alt="FixMaster Logo">
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
            <li ><a href="{{ route('frontend.index', app()->getLocale()) }}">FixMaster Home</a></li>

                <li><a class="" href="{{ route('frontend.about', app()->getLocale()) }}">About us</a></li>
                
                <li class="has-submenu">
                    <a href="javascript:void(0)">How it works</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="{{ route('frontend.how_it_works', app()->getLocale()) }}">How It Works</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </li>
                
                {{-- <li><a class="" href="#">Contact</a></li> --}}

                <li class="has-submenu {{ Route::currentRouteNamed('client.index', 'client.services.list', 'client.services.details', 'client.services.quote', 'client.service.all', 'client.request_details') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="l-dark l-light">Profile</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                    <li class="{{ Route::currentRouteNamed('client.index') ? 'active' : '' }}"><a href="{{ route('client.index', app()->getLocale()) }}">Dashboard</a></li>

                    <li class="{{ Route::currentRouteNamed('client.services.list', 'client.services.details', 'client.services.quote') ? 'active' : '' }}"><a href="{{ route('client.services.list', app()->getLocale()) }}">Book a Service</a></li>

                        <li class="{{ Route::currentRouteNamed('client.wallet') ? 'active' : '' }}"><a href="{{ route('client.wallet', app()->getLocale()) }}">E-Wallet</a></li>

                        <li class="{{ Route::currentRouteNamed('client.service.all', 'client.request_details') ? 'active' : '' }}"><a href="{{route('client.service.all', app()->getLocale()) }}">Requests</a></li>

                    <li class="{{ Route::currentRouteNamed('client.payments') ? 'active' : '' }}"><a href="{{ route('client.payments', app()->getLocale()) }}">Payments</a></li>

                        <li class="{{ Route::currentRouteNamed('') ? 'active' : '' }}"><a href="#">Messages</a></li> 

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



<!-- Hero Start -->
{{-- <section class="bg-profile d-table w-100 bg-primary" style="background: url('{{ asset("assets/images/account/bg.png") }}') center center no-repeat;"> --}}
   

    <section class="bg-profile d-table w-100  bg-primar" style="background-color: #ff9800 !important;" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12"> 
             <div class="card public-profile border-0 rounded shadow" style="z-index: 1;">

             <div class="alert alert-primary alert-dismissible d-none ttf" role="alert">
                <span type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer">
                <span class="close-alert" aria-hidden="true">&times;</span>
                </span>
                <span class="verify-msg"></span>
               
            </div>
                 <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-md-3 text-md-left text-center">
                       
                                {{-- <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar avatar-large rounded-circle shadow d-block mx-auto" alt=""> --}}
                                @if(!empty($profile->avatar) && file_exists(public_path().'/assets/user-avatars/'.$profile->avatar))
                                    <img src="{{ asset('assets/user-avatars/'.$profile->avatar) }}" class="avatar avatar-large rounded-circle shadow d-block mx-auto" alt="Client avatar" />
                                @else
                                    @if($profile->gender == 'male')
                                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="avatar avatar-large rounded-circle shadow d-block mx-auto" />
                                    @else
                                        <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="avatar avatar-large rounded-circle shadow d-block mx-auto" />
                                    @endif
                                @endif
                            </div><!--end col-->
                            <div class="col-lg-10 col-md-9">
                                <div class="row align-items-end">
                                    <div class="col-md-7 text-md-left text-center mt-4 mt-sm-0">
                                    <h3 class="title mb-0">{{ !empty($profile->first_name || $profile->last_name) ? $profile->first_name.' '.$profile->last_name : 'UNAVAILABLE' }}</h3>
                                    <small class="text-muted h6 mr-2">Occupation: {{ $profile->profession->name ?? 'Accountant' }}</small>
                                        {{-- <ul class="list-inline mb-0 mt-3">
                                            <li class="list-inline-item mr-2"><a href="javascript:void(0)" class="text-muted" title="Instagram"><i data-feather="instagram" class="fea icon-sm mr-2"></i>Femi_joseph</a></li>
                                            <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted" title="Linkedin"><i data-feather="linkedin" class="fea icon-sm mr-2"></i>Femi Joseph</a></li>
                                        </ul> --}}
                                    </div><!--end col-->
                                    <div class="col-md-5 text-md-right text-center">
                                        <ul class="list-unstyled social-icon social mb-0 mt-4">
                                            <li class="list-inline-item"><a href="{{ route('client.wallet', app()->getLocale()) }}" class="rounded" data-toggle="tooltip" data-placement="bottom" title="E-Wallet"><i data-feather="credit-card" class="fea icon-sm fea-social"></i></a></li>
                                            <li class="list-inline-item">
                                                <a href="#" class="rounded" data-toggle="tooltip" title="You have 0 unread messages" data-placement="bottom">
                                                    <i data-feather="message-circle" class="fea icon-sm fea-social" ></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item"><a href="#" class="rounded" data-toggle="tooltip" data-placement="bottom" title="Book a Service"><i data-feather="calendar" class="fea icon-sm fea-social"></i></a></li>
                                            <li class="list-inline-item"><a href="#" class="rounded" data-toggle="tooltip" data-placement="bottom" title="Settings"><i data-feather="settings" class="fea icon-sm fea-social"></i></a></li>
                                        </ul><!--end icon-->
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--ed container-->
</section><!--end section-->
<!-- Hero End -->