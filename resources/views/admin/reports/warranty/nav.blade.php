<nav class="nav">
        <a href="{{route('admin.warranty_reports', app()->getLocale())}}" class="nav-link {{ Route::currentRouteNamed('admin.warranty_reports') ? 'active' : '' }}" >Warranty Claims List</a>
        <a href="{{route('admin.extended_warranty_reports', app()->getLocale())}}" class="nav-link {{ Route::currentRouteNamed('admin.extended_warranty_reports') ? 'active' : '' }}" >Extended Warranty Claims List</a>
      
      </nav>