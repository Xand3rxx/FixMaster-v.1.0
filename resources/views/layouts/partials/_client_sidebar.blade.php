<!-- Profile Start -->
<section class="section mt-60">
    <div class="container mt-lg-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 d-lg-block d-none">
                <div class="sidebar sticky-bar p-4 rounded shadow">
                    <h5 class="widget-title">E-Wallet: <strong>{{ $profile['client']['unique_id'] ?? 'UNAVAILABLE' }}</strong></h5>
                    <div class="widget">
                        <div class="row mt-4  text-center">
                            <div class="card event-schedule rounded border">
                                <div class="card-body event-width">
                                    <div class="media">
                                        <div class="media-body content">
                                            <h4><a href="javascript:void(0)" class="text-dark title">Balance</a></h4>
                                        <p class="text-muted location-time"><span class="text-dark h6">₦{{ !empty($profile['clientWalletBalance']['closing_balance']) ? number_format($profile['clientWalletBalance']['closing_balance']) : '0' }}</span></p>
                                            <a href="{{ route('client.wallet', app()->getLocale()) }}" class="btn btn-sm btn-outline-primary mouse-down">Fund Account</a>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <small>Last Login: <br>
                                            <strong>{{ !empty($profile['lastActivityLog']['created_at']) ? \Carbon\Carbon::parse($profile['lastActivityLog']['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</strong>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget mt-4 pt-2">
                        <h5 class="widget-title">Profile :</h5>
                    </div>

                    <div class="widget">
                        <div class="row">
                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.index', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.index') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-home-alt"></i></span>
                                    <h6 class="title text-dark h6 my-0">Dashboard</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.services.list', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.services.list', 'client.services.details', 'client.services.quote', 'client.services.custom') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-calendar-alt"></i></span>
                                    <h6 class="title text-dark h6 my-0">Book a Service</h6>
                                </a>
                            </div><!--end col-->
                            <div class="col-6 mt-4 pt-2">
                                <a href="{{ route('client.service.all', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.service.all', 'client.request_details', 'client.edit_request') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-sitemap"></i></span>
                                    <h6 class="title text-dark h6 my-0">Requests</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.wallet', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.wallet') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-wallet"></i></span>
                                    <h6 class="title text-dark h6 my-0">E-Wallet</h6>
                                </a>
                            </div><!--end col-->

                            @if(CustomHelpers::ifLoyaltyExist(auth()->user()->id) == 1)
                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.loyalty', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.loyalty') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-award"></i></span>
                                    <h6 class="title text-dark h6 my-0">Loyalty Wallet </h6>
                                </a>
                            </div><!--end col-->
                            @endif
                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.messages.index', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.messages.index') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-envelope-download text-danger" data-toggle="tooltip" title="You have 0 unread messages"></i></span>
                                    <h6 class="title text-dark h6 my-0">Messages</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.payments', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.payments') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-transaction"></i></span>
                                    <h6 class="title text-dark h6 my-0">Payments</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.settings', app()->getLocale()) }}"" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.settings') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-setting"></i></span>
                                    <h6 class="title text-dark h6 my-0">Settings</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" href="{{ route('logout', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-sign-out-alt"></i></span>
                                    <h6 class="title text-dark h6 my-0">Logout</h6>
                                </a>

                                {{-- <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                                    @csrf
                                </form> --}}
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>

                </div>
            </div><!--end col-->

            @yield('content')

        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->
<!-- Profile End -->






