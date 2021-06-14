<div class="table-responsive">
                
    <table class="table table-hover mg-b-0" id="basicExample">
      <thead class="thead-primary">
        <tr>
          <th class="text-center">#</th>
          <th>Name</th>
          <th>Category</th>
          <th class="text-center">Service Charge(₦)</th>
          <th class="text-center">Sub Services</th>
          <th class="text-center">Requests</th>
          <th>Status</th>
          <th>Date Created</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($services as $service)
        <tr>
          <td class="tx-color-03 tx-center">{{ ++$i }}</td>
          <td class="tx-medium">{{ !empty($service->name) ? $service->name : 'UNAVAILABLE' }}</td>
          <td class="tx-medium">{{ !empty($service->category->name) ? $service->category->name : 'UNAVAILABLE' }}</td>
          <td class="tx-medium text-center">{{ !empty($service->service_charge) ? $service->service_charge : 'UNAVAILABLE' }}</td>
          <td class="tx-medium text-center">{{ $service->subServices->count() ?? '0' }}</td>
          <td class="tx-medium text-center">{{ $service->serviceRequests->count() ?? '0' }}</td>
        
          @if(!empty($service->status) == 1) 
            <td class="text-success">Active</td>
          @else 
            <td class="text-danger">Inactive</td>
          @endif
          <td>{{ Carbon\Carbon::parse($service->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') ??  Carbon\Carbon::nouw('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class=" text-center">
            @if(!empty($service->name))
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a href="#serviceCategoryDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $service->name}} details" data-url="{{ route('admin.services.show', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" data-category-name="{{ $service->name}}" id="category-details"><i class="far fa-clipboard"></i> Details</a>

              <a href="{{ route('admin.services.edit', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" id="service-edit" title="Edit {{ $service->name }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

              @if($service->status == 1) 
                <a data-url="{{ route('admin.services.deactivate', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-warning deactivate-entity" title="Deactivate {{ $service->name}}" style="cursor: pointer;"><i class="fas fa-ban"></i> Deactivate</a>
              @else
                <a href="{{ route('admin.services.reinstate', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Reinstate {{ $service->name}}"><i class="fas fa-undo"></i> Reinstate</a>
              @endif
              <a data-url="{{ route('admin.services.delete', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger delete-entity" title="Delete {{ $service->name}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Delete</a>
              </div>
            </div>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div><!-- table-responsive -->