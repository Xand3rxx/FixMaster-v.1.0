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
      <div class="aside-loggedin-user">
        <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
          <h6 class="tx-semibold mg-b-0">{{ Auth::user()->account->first_name.' '.Auth::user()->account->last_name }}</h6>
          <i data-feather="chevron-down"></i>
        </a>
        {{-- <p class="tx-color-03 tx-12 mg-b-0">Ludwig Enterprise (TECHNICIAN)</p> --}}
        <p class="tx-color-03 tx-12 mg-b-0">Quality Assurance Manager</p>
      </div>
      <div class="collapse {{ Route::currentRouteNamed('quality-assurance.view_profile', 'quality-assurance.edit_profile') ? 'show' : '' }}" id="loggedinMenu">
        <ul class="nav nav-aside mg-b-0">
          {{-- <li class="nav-item"><a href="" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li> --}}
          <li class="nav-item {{ Route::currentRouteNamed('quality-assurance.view_profile') ? 'active' : '' }}"><a href="{{ route('quality-assurance.view_profile', app()->getLocale()) }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>

          <li class="nav-item {{ Route::currentRouteNamed('quality-assurance.edit_profile') ? 'active' : '' }}"><a href="{{ route('quality-assurance.edit_profile',app()->getLocale()) }}" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
        </ul>
      </div>
    </div><!-- aside-loggedin -->
    <ul class="nav nav-aside">
      <li class="nav-label">menu</li>
      <li class="nav-item {{ Route::currentRouteNamed('quality-assurance.index') ? 'active' : '' }}"><a href="{{ route('quality-assurance.index', app()->getLocale()) }}" class="nav-link"><i data-feather="airplay"></i> <span>Dashboard</span></a></li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('quality-assurance.requests.active', 'quality-assurance.requests.completed', 'quality-assurance.requests.warranty', 'quality-assurance.requests.cancelled','quality-assurance.requests.active_details','quality-assurance.requests.warranty') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('quality-assurance.requests.active','quality-assurance.requests.active_details') ? 'active' : '' }}"><a href="{{ route('quality-assurance.requests.active', app()->getLocale()) }}">Active</a></li>
            <li class="{{ Route::currentRouteNamed('quality-assurance.requests.completed') ? 'active' : '' }}"><a href="{{ route('quality-assurance.requests.completed', app()->getLocale()) }}">Completed</a></li>
            <li class="{{ Route::currentRouteNamed('quality-assurance.requests.warranty_claim','quality-assurance.requests.warranty') ? 'active' : '' }}"><a href="{{ route('quality-assurance.requests.warranty_claim', app()->getLocale()) }}">Warranty Claims</a></li>
            <li class="{{ Route::currentRouteNamed('quality-assurance.requests.cancelled') ? 'active' : '' }}"><a href="{{ route('quality-assurance.requests.cancelled', app()->getLocale()) }}">Cancelled</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('quality-assurance.consultations.pending', 'quality-assurance.consultations.ongoing', 'quality-assurance.consultations.completed','quality-assurance.consultations.pending_details','quality-assurance.consultations.ongoing_details') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="layout"></i> <span>Consultations</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('quality-assurance.consultations.pending','quality-assurance.consultations.pending_details') ? 'active' : '' }}"><a href="{{ route('quality-assurance.consultations.pending', app()->getLocale()) }}">Pending</a></li>
            <li class="{{ Route::currentRouteNamed('quality-assurance.consultations.ongoing','quality-assurance.consultations.ongoing_details') ? 'active' : '' }}"><a href="{{ route('quality-assurance.consultations.ongoing', app()->getLocale()) }}">Ongoing</a></li>
            <li class="{{ Route::currentRouteNamed('quality-assurance.consultations.completed') ? 'active' : '' }}"><a href="{{ route('quality-assurance.consultations.completed', app()->getLocale()) }}">Completed</a></li>
          </ul>
        </li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('inbox_messages', 'outbox_messages') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('quality-assurance.messages.inbox') ? 'active' : '' }}"><a href="{{ route('quality-assurance.messages.inbox', app()->getLocale()) }}">Inbox</a></li>
          <li class="{{ Route::currentRouteNamed('quality-assurance.messages.sent') ? 'active' : '' }}"><a href="{{ route('quality-assurance.messages.sent', app()->getLocale()) }}">Sent</a></li>
          {{-- <li><a href="#cseMessageComposer" data-toggle="modal">Compose</a></li> --}}
        </ul>
      </li>

      <li class="nav-item {{ Route::currentRouteNamed('quality-assurance.payments') ? 'active show' : '' }}"><a href="{{ route('quality-assurance.payments', app()->getLocale()) }}" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>

      {{-- <li class="nav-item {{ Route::currentRouteNamed('quality-assurance.requests', 'quality-assurance.request_details') ? 'active show' : '' }}"><a href="{{ route('quality-assurance.requests', app()->getLocale()) }}" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a></li> --}}


    </ul>
  </div>
</aside>

