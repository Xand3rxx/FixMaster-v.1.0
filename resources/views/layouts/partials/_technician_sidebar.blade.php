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
        <p class="tx-color-03 tx-12 mg-b-0">{{ Auth::user()->type->role->name ?? 'Technicians & Artisans' }}</p>
      </div>
      <div class="collapse {{ Route::currentRouteNamed('technician.view_profile', 'technician.edit_profile') ? 'show' : '' }}" id="loggedinMenu">
        <ul class="nav nav-aside mg-b-0">
          <li class="nav-item {{ Route::currentRouteNamed('technician.view_profile') ? 'active' : '' }}"><a href="{{ route('technician.view_profile', app()->getLocale()) }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>

          <li class="nav-item {{ Route::currentRouteNamed('technician.edit_profile') ? 'active' : '' }}"><a href="{{ route('technician.edit_profile',app()->getLocale()) }}" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
        </ul>
      </div>
    </div><!-- aside-loggedin -->
    <ul class="nav nav-aside">
      <li class="nav-label">Components</li>
      <li class="nav-item {{ Route::currentRouteNamed('technician.index') ? 'active' : '' }}"><a href="{{ route('technician.index', app()->getLocale()) }}" class="nav-link"><i data-feather="airplay"></i> <span>Dashboard</span></a></li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('technician.requests.active', 'technician.requests.completed', 'technician.requests.warranty_claim', 'technician.requests.cancelled') ? 'active show' : '' }}">
            <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a>
            <ul>
                <li class="{{ Route::currentRouteNamed('technician.requests.active') ? 'active' : '' }}"><a href="{{ route('technician.requests.active', app()->getLocale()) }}">Active</a></li>
                <li class="{{ Route::currentRouteNamed('technician.requests.completed') ? 'active' : '' }}"><a href="{{ route('technician.requests.completed', app()->getLocale()) }}">Completed</a></li>
                <li class="{{ Route::currentRouteNamed('technician.requests.warranty_claim') ? 'active' : '' }}"><a href="{{ route('technician.requests.warranty_claim', app()->getLocale()) }}">Warranty Claims</a></li>
                <li class="{{ Route::currentRouteNamed('technician.requests.cancelled') ? 'active' : '' }}"><a href="{{ route('technician.requests.cancelled', app()->getLocale()) }}">Cancelled</a></li>
            </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('technician.consultations.pending', 'quality-assurance.consultations.ongoing', 'quality-assurance.consultations.completed') ? 'active show' : '' }}">
            <a href="" class="nav-link"><i data-feather="layout"></i> <span>Consultations</span></a>
            <ul>
                <li class="{{ Route::currentRouteNamed('technician.consultations.pending') ? 'active' : '' }}"><a href="{{ route('technician.consultations.pending', app()->getLocale()) }}">Pending</a></li>
                <li class="{{ Route::currentRouteNamed('technician.consultations.ongoing') ? 'active' : '' }}"><a href="{{ route('technician.consultations.ongoing', app()->getLocale()) }}">Ongoing</a></li>
                <li class="{{ Route::currentRouteNamed('technician.consultations.completed') ? 'active' : '' }}"><a href="{{ route('technician.consultations.completed', app()->getLocale()) }}">Completed</a></li>
            </ul>
        </li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('technician.messages.inbox', 'technician.messages.outbox') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('technician.messages.inbox') ? 'active' : '' }}"><a href="{{ route('technician.messages.inbox', app()->getLocale()) }}">Inbox</a></li>
          <li class="{{ Route::currentRouteNamed('technician.messages.outbox') ? 'active' : '' }}"><a href="{{ route('technician.messages.outbox', app()->getLocale()) }}">Sent</a></li>
          {{-- <li><a href="#cseMessageComposer" data-toggle="modal">Compose</a></li> --}}
        </ul>
      </li>

      <li class="nav-item {{ Route::currentRouteNamed('technician.payments') ? 'active' : '' }}"><a href="{{ route('technician.payments', app()->getLocale()) }}" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>
    </ul>
  </div>
</aside>

