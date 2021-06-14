
<aside class="aside aside-fixed">
    <div class="aside-header">
      <a href="#" class="aside-logo"></a>
      <a href="" class="aside-menu-link">
        <i data-feather="menu"></i>
        <i data-feather="x"></i>
      </a>
    </div>
    <div class="aside-body">
      <div class="aside-loggedin">
        <div class="d-flex align-items-center justify-content-start">
          <a href="" class="avatar">
            @include('layouts.partials._profile_avatar')
          </a>
          <div class="aside-alert-link">
          <a href="#" class="new" data-toggle="tooltip" title="You have 0 unread messages"><i data-feather="message-square"></i></a>
            <a onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" href="{{ route('logout', app()->getLocale()) }}" data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>
            <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
              @csrf
          </form>
      </div>
        </div>
        <div id="user-controller" class="aside-loggedin-user d-none">
            <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
                <h6 class="tx-semibold mg-b-0">{{ Auth::user()->account->first_name.' '.Auth::user()->account->last_name }}</h6>
                <i data-feather="chevron-down"></i>
            </a>
            <p class="tx-color-03 tx-12 mg-b-0">Customer Service Executive(CSE)</p>
            <p class="tx-15 mg-b-0 mt-4 font-weight-bold text-center">Job availability</p><br>
            <div class="custom-control custom-switch" style="margin-left: 4rem !important; margin-top: -12px !important;">
                <input type="checkbox" {{$cse_availability[1]}} class="custom-control-input" id="cse-availability">
                <label class="custom-control-label font-weight-bold" for="cse-availability"></label>
            </div>
            <p class="cse_availability text-center tx-14 text-success tx-12 mt-1 mg-b-0">{{$cse_availability[0]}}</p>
            <form id="cse-avalability-form" action="{{ route('cse.availablity', app()->getLocale()) }}" method="POST" style="display: none;">
                @csrf
                <input id="accepted_service_request" type="hidden" name="cse_availablity" value="{{$cse_availability[0]}}">
            </form>
            @push('scripts')
            <script>
                $('label[for="cse-availability"]').on('click', function(e) {
                    const currentCheckbox = $('#cse-availability').is(":checked");
                    if (confirm('Are you sure you want to update your avalability?')) {
                        document.getElementById('cse-avalability-form').submit()
                    }
                    return e.preventDefault();
                });
                $('#user-controller').removeClass('d-none')

            </script>
            @endpush
        </div>
        <div class="collapse {{ Route::currentRouteNamed('cse.profile.index', 'cse.profile.edit') ? 'show' : '' }}" id="loggedinMenu">
            <ul class="nav nav-aside mg-b-0">
                <li class="nav-item {{ Route::currentRouteNamed('cse.profile.index') ? 'active' : '' }}"><a href="{{ route('cse.profile.index', app()->getLocale()) }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>
            <li class="nav-item {{ Route::currentRouteNamed('cse.profile.edit') ? 'active' : '' }}"><a href="{{ route('cse.profile.edit',[app()->getLocale(), auth()->user()->uuid]) }}" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
            </ul>
        </div>
      </div><!-- aside-loggedin -->
      <ul class="nav nav-aside">
        <li class="nav-label">MENU</li>
        <li class="nav-item {{ Route::currentRouteNamed('cse.index') ? 'active' : '' }}"><a href="{{ route('cse.index', app()->getLocale()) }}" class="nav-link"><i data-feather="airplay"></i> <span>Dashboard</span></a></li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('cse.requests.index', 'cse.requests.active', 'cse.request_details', 'cse.warranty_details','cse.requests.show', 'cse.warranty_claims_list','cse.warranty_claims', 'cse.warranty_claim_details') ? 'active show' : '' }}">
            <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a>
            <ul>
                <li class="{{ Route::currentRouteNamed('cse.requests.active') ? 'active' : '' }}"><a href="{{ route('cse.requests.status', ['locale' => app()->getLocale(), 'status' => 'Ongoing']) }}"> Active </a></li>
                <li class="{{ Route::currentRouteNamed('cse.messages.sent') ? 'active' : '' }}"><a href="{{ route('cse.requests.status', ['locale' => app()->getLocale(), 'status' => 'Canceled']) }}"> Cancelled </a></li>
                <li class="{{ Route::currentRouteNamed('cse.messages.sent') ? 'active' : '' }}"><a href="{{ route('cse.requests.status', ['locale' => app()->getLocale(), 'status' => 'Completed']) }}"> Completed </a></li>
                <li class="{{ Route::currentRouteNamed('cse.requests.index') ? 'active' : '' }}"><a href="{{ route('cse.requests.status', ['locale' => app()->getLocale(), 'status' => 'Pending']) }}"> Pending </a></li>
                <li class="{{ Route::currentRouteNamed('cse.warranty_claims', 'cse.warranty_claim_details') ? 'active' : '' }}"><a href="{{ route('cse.warranty_claims_list', app()->getLocale()) }}"> Warranty Claims <sup class="font-weight-bold text-primary">{{$unresolvedWarranties }}</sup></a></li>
            </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('inbox_messages', 'outbox_messages') ? 'active show' : '' }}">
            <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
            <ul>
                <li class="{{ Route::currentRouteNamed('cse.messages.inbox') ? 'active' : '' }}"><a href="{{ route('cse.messages.inbox', app()->getLocale()) }}">Inbox</a></li>
                <li class="{{ Route::currentRouteNamed('cse.messages.sent') ? 'active' : '' }}"><a href="{{ route('cse.messages.sent', app()->getLocale()) }}">Sent</a></li>
            </ul>
        </li>

        <li class="nav-item {{ Route::currentRouteNamed('cse.payments') ? 'active show' : '' }}"><a href="{{ route('cse.payments', app()->getLocale()) }}" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>

      </ul>
    </div>
  </aside>

