<!-- Sidebar options are displayed based on the Authenticated User Role -->

<!-- START ADMIN SIDEBAR MENU -->
@if((Auth::user()->type->role->name === 'Super Admin') || (Auth::user()->type->role->name === 'Administrator'))
  @include('layouts.partials._admin_sidebar')
@endif
<!-- END ADMIN SIDEBAR MENU -->

<!-- START Customer Service Executive SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Customer Service Executive')
  @include('layouts.partials._cse_sidebar')
@endif
<!-- END Customer Service Executive SIDEBAR MENU -->

<!-- START QUALITY ASSURANCE SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Quality Assurance Manager')
  @include('layouts.partials._qa_sidebar')
@endif
<!-- END QUALITY ASSURANCE SIDEBAR MENU -->

<!-- START TECHNICIAN & ARTISAN SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Technicians & Artisans')
  @include('layouts.partials._technician_sidebar')
@endif
<!-- END TECHNICIAN & ARTISAN SIDEBAR MENU -->

<!-- START FRANCHISEE SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Franchisee(CSE Coordinator)')
  @include('layouts.partials._franchisee_sidebar')
@endif
<!-- END FRANCHISEE SIDEBAR MENU -->

<!-- START FRANCHISEE SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Suppliers')
  @include('layouts.partials._supplier_sidebar')
@endif
<!-- END FRANCHISEE SIDEBAR MENU -->

