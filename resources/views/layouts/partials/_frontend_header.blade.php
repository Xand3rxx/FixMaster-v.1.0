<style>
.buy-btn-two{
    box-shadow: 0 3px 5px 0 rgba(233, 125, 31, 0.3) !important;
    border-color: #E97D1F !important;
    background-color: #E97D1F !important;
    color: #fff !important;
}
.buy-btn-two:hover{
    box-shadow: 0 3px 5px 0 rgba(233, 125, 31, 0.3) !important;
    border-color: #E97D1F !important;
    background-color: #E97D1F !important;
    color: #fff !important;
}
.btn.btn-light {
    color: #fff !important;
    border: 1px solid #e97d1f !important;
}



</style>

<header id="topnav" class="defaultscroll sticky navbar-dark">
    <div class="container">
        <!-- Logo container-->
        <div>
        <a class="logo" href="{{ route('frontend.index', app()->getLocale()) }}">
            {{-- <img src="{{ asset('assets/images/home-fix-logo.png') }}" height="70" alt=""> --}}
            {{-- <img src="{{ asset('assets/images/home-fix-logo.png') }}" style="margin-top: -38px !important; margin-bottom: -38px !important;" height="160" alt="FixMaster Logo"> --}}

            {{-- <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" style="margin-top: -38px !important; margin-bottom: -38px !important;" height="140" alt="FixMaster Logo"> --}}

            <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" style="margin-top: -40px !important; margin-bottom: -38px !important; margin-left: 50px !important" height="70" alt="FixMaster Logo">

            </a>
        </div>
        @if(Route::currentRouteNamed('frontend.index', 'frontend.about', 'frontend.contact', 'frontend.how_it_works', 'frontend.why_home_fix', 'frontend.careers', 'frontend.faq', 'frontend.services'))
            <div class="buy-button">
                <a href="{{ route('frontend.index', app()->getLocale()) }}">
                    <div class="btn btn-primary login-btn-primary">Book a Service</div>
                    <div class="btn btn-light login-btn-light buy-btn-two">Book a Service</div>
                </a>
            </div><!--end login button-->
        @endif
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
            <ul class="navigation-menu">
                <li><a class="{{ Route::currentRouteNamed('frontend.index') ? 'selected' : '' }}" href="{{ route('frontend.index', app()->getLocale()) }}">Home</a></li>
                <li><a class="{{ Route::currentRouteNamed('frontend.about') ? 'selected' : '' }}" href="{{ route('frontend.about', app()->getLocale()) }}">About Us</a></li>



                <li class="has-submenu {{ Route::currentRouteNamed('frontend.how_it_works', 'frontend.faq') ? 'selected' : '' }}">
                    <a href="javascript:void(0)">How it works</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a class="{{ Route::currentRouteNamed('frontend.how_it_works') ? 'selected' : '' }}" href="{{ route('frontend.how_it_works', app()->getLocale()) }}">How It Works</a></li>
                        <li><a class="{{ Route::currentRouteNamed('frontend.faq') ? 'selected' : '' }}" href="{{ route('frontend.faq', app()->getLocale()) }}">FAQ</a></li>
                    </ul>
                </li>

                <li><a class="{{ Route::currentRouteNamed('frontend.contact') ? 'selected' : '' }}" href="{{ route('frontend.contact', app()->getLocale()) }}">Contact</a></li>


                <li class="has-submenu {{ Route::currentRouteNamed('frontend.careers', 'login', 'register') ? 'selected' : '' }}">
                    <a href="javascript:void(0)">Get started</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="{{ route('frontend.registration.client.index', app()->getLocale()) }}">Register</a></li>
                        <li><a href="{{ route('login', app()->getLocale()) }}">Login</a></li>
                        <li class="has-submenu"><a href="javascript:void(0)"> Apply <span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="{{ route('frontend.careers', app()->getLocale()) }}">CSE</a></li>
                                {{-- <li><a href="{{ route('frontend.careers') }}">Franchisee</a></li>
                                <li><a href="{{ route('frontend.careers') }}">Intern</a></li>
                                <li><a href="{{ route('frontend.careers') }}">Service Partner</a></li> --}}
                                <li><a href="{{ route('frontend.careers', app()->getLocale()) }}">Supplier</a></li>
                                {{-- <li><a href="{{ route('frontend.careers') }}">Trainee</a></li> --}}
                                {{-- <li><a href="{{ route('frontend.careers', app()->getLocale()) }}">Add Estate</a></li> --}}
                                <li><a href="{{ route('frontend.careers', app()->getLocale()) }}">Technician</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul><!--end navigation menu-->

        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
