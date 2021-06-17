
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
        <p class="tx-color-03 tx-12 mg-b-0">Supplier({{ Auth::user()->account->supplier->unique_id }})</p>
      </div>
      <div class="collapse {{ Route::currentRouteNamed('supplier.view_profile', 'supplier.edit_profile') ? 'show' : '' }}" id="loggedinMenu">
        <ul class="nav nav-aside mg-b-0">
          <li class="nav-item {{ Route::currentRouteNamed('supplier.view_profile') ? 'active' : '' }}"><a href="{{ route('supplier.view_profile', app()->getLocale()) }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>

          <li class="nav-item {{ Route::currentRouteNamed('supplier.edit_profile') ? 'active' : '' }}"><a href="{{ route('supplier.edit_profile',app()->getLocale()) }}" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
        </ul>
      </div>
    </div><!-- aside-loggedin -->
    <ul class="nav nav-aside">
      <li class="nav-label">Components</li>
      <li class="nav-item {{ Route::currentRouteNamed('supplier.index') ? 'active' : '' }}"><a href="{{ route('supplier.index', app()->getLocale()) }}" class="nav-link"><i data-feather="airplay"></i> <span>Home</span></a></li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('supplier.rfq', 'supplier.rfq_send_supplier_invoice', 'supplier.rfq_sent_invoices', 'supplier.rfq_approved_invoices', 'supplier.rfq_declined_invoices', 'supplier.rfq_link_details') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests For Quote @if($newQuotes > 0)<span class="badge badge-primary">{{ $newQuotes }}</span>@endif</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('supplier.rfq', 'supplier.rfq_send_supplier_invoice', 'supplier.rfq_link_details') ? 'active' : '' }}"><a href="{{ route('supplier.rfq', app()->getLocale()) }}">New Quotes @if($newQuotes > 0)<sup class="font-weight-bold text-primary">{{ $newQuotes }}</sup>@endif</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.rfq_sent_invoices') ? 'active' : '' }}"><a href="{{ route('supplier.rfq_sent_invoices', app()->getLocale()) }}">Sent Quotes</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.rfq_declined_invoices') ? 'active' : '' }}"><a href="{{ route('supplier.rfq_declined_invoices', app()->getLocale()) }}">Declined Quotes</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.rfq_approved_invoices') ? 'active' : '' }}"><a href="{{ route('supplier.rfq_approved_invoices', app()->getLocale()) }}">Won Quotes</a></li>
        </ul>
      </li>


      <li class="nav-item with-sub {{ Route::currentRouteNamed('supplier.rfq.warranty', 'supplier.rfq_send_supplier_invoice', 'supplier.rfq_sent_invoices', 'supplier.rfq_approved_invoices', 'supplier.rfq_declined_invoices', 'supplier.rfq_link_details') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Warranty Claim Quote @if(count($RfqDispatchNotification) > 0)<span class="badge badge-primary">{{count($RfqDispatchNotification) }}</span>@endif</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('supplier.rfq.warranty', 'supplier.rfq_send_supplier_invoice', 'supplier.rfq_link_details') ? 'active' : '' }}"><a href="{{ route('supplier.rfq.warranty', app()->getLocale()) }}">New Quotes @if($warrantyQuotes > 0)<sup class="font-weight-bold text-primary">{{ $warrantyQuotes }}</sup>@endif</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.warranty_sent_invoices') ? 'active' : '' }}"><a href="{{ route('supplier.warranty_sent_invoices', app()->getLocale()) }}">Sent Quotes</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.rfq_declined_invoices') ? 'active' : '' }}"><a href="{{ route('supplier.rfq_declined_invoices', app()->getLocale()) }}">Declined Quotes</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.rfq_approved_invoices') ? 'active' : '' }}"><a href="{{ route('supplier.rfq_approved_invoices', app()->getLocale()) }}">Won Quotes</a></li>
          
        </ul>
      </li>

      {{-- <li class="nav-item {{ Route::currentRouteNamed('supplier.dispatches') ? 'active' : '' }}"><a href="{{ route('supplier.dispatches', app()->getLocale()) }}" class="nav-link"><i data-feather="file-text"></i> <span>Materials Dispatched</span></a></li> --}}

      <li class="nav-item with-sub {{ Route::currentRouteNamed('supplier.dispatches', 'supplier.dispatches_returned', 'supplier.dispatches_delivered') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="file-text"></i> <span>Materials</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('supplier.dispatches') ? 'active' : '' }}"><a href="{{ route('supplier.dispatches', app()->getLocale()) }}">Dispatched</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.dispatches_delivered') ? 'active' : '' }}"><a href="{{ route('supplier.dispatches_delivered', app()->getLocale()) }}">Delivered</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.dispatches_returned') ? 'active' : '' }}"><a href="{{ route('supplier.dispatches_returned', app()->getLocale()) }}">Returned</a></li>
        </ul>
      </li>


      <li class="nav-item with-sub {{ Route::currentRouteNamed('inbox_messages', 'outbox_messages') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('supplier.messages.inbox') ? 'active' : '' }}"><a href="{{ route('supplier.messages.inbox', app()->getLocale()) }}">Inbox</a></li>
          <li class="{{ Route::currentRouteNamed('supplier.messages.sent') ? 'active' : '' }}"><a href="{{ route('supplier.messages.sent', app()->getLocale()) }}">Sent</a></li>
        </ul>
      </li>

      <li class="nav-item {{ Route::currentRouteNamed('supplier.payments') ? 'active' : '' }}"><a href="{{ route('supplier.payments', app()->getLocale()) }}" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>

    </ul>
  </div>
</aside>