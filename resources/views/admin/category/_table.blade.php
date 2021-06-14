<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Created By</th>        
        <th class="text-center">Labour Markup (%)</th>
        <th class="text-center">Materials Markup (%)</th>
        <th class="text-center">Services</th>
        <th>Status</th>
        <th>Date Created</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $category )
        <tr>
          <td class="tx-color-03 tx-center">{{ ++$i }}</td>
          <td class="tx-medium">{{ !empty($category->name) ? $category->name : 'UNAVAILABLE' }}</td>
          <td>{{ !empty($category->user->email) ? $category->user->email : 'UNAVAILABLE' }}</td>
          <td class="tx-medium text-center">{{ !empty($category->labour_markup) ? $category->labour_markup*100 : 'UNAVAILABLE' }}</td>
          <td class="tx-medium text-center">{{ !empty($category->material_markup) ? $category->material_markup*100 : 'UNAVAILABLE' }}</td>
          <td class="tx-medium text-center">{{ $category->services()->count() ?? '0' }}</td>
          @if(empty($category->deleted_at)) 
          <td class="text-success">Active</td>
          @else 
            <td class="text-danger">Inactive</td>
          @endif
          <td>{{ Carbon\Carbon::parse($category->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') ?? Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class=" text-center">
            @if(!empty($category->name))
              <div class="dropdown-file">
                <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
              
                @if($category->id > '1')
                  <a href="#serviceDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $category->name}} details" data-url="{{ route('admin.categories.show', ['category'=>$category->uuid, 'locale'=>app()->getLocale()] ) }}" data-service-name="{{ $category->name}}" id="service-details"><i class="far fa-clipboard"></i> Details</a>

                  <a href="#editService" data-toggle="modal" id="service-edit" title="Edit {{ $category->name }}" data-url="{{ route('admin.categories.edit', ['category'=>$category ->uuid, 'locale'=>app()->getLocale()]) }}" data-service-name="{{ $category->name }}" data-labour-markup="{{ $category->labour_markup }}" data-material-markup="{{ $category->material_markup }}" data-id="{{ $category->uuid }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

                  @if(empty($category->deleted_at)) 
                    <a data-url="{{ route('admin.categories.deactivate', ['category'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-warning deactivate-entity" title="Deactivate {{ $category->name}}" style="cursor: pointer;"><i class="fas fa-ban"></i> Deactivate</a>
                  @else
                    <a href="{{ route('admin.categories.reinstate', ['category'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Reinstate {{ $category->name}}"><i class="fas fa-undo"></i> Reinstate</a>
                  @endif

                  @if(Auth::id() == 1)
                  <a href="#serviceReassign" data-toggle="modal" class="dropdown-item details text-secondary" id="service-reassign" data-url="{{ route('admin.categories.reassign', ['category'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" data-service-name="{{ $category->name}}" title="Reassign {{ $category->name}} categories"><i class="fas fa-arrows-alt"></i> Reassign</a>
                  @endif
                  <a data-url="{{ route('admin.categories.delete', ['category'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item delete-entity text-danger" title="Delete {{ $category->name}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Delete</a>

                @else

                  <a href="#serviceReassign" data-toggle="modal" class="dropdown-item details text-primary" id="service-reassign" data-url="{{ route('admin.categories.reassign', ['category'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" data-service-name="{{ $category->name}}" title="View {{ $category->name}} categories"><i class="fas fa-clipboard"></i> Details</a>
                
                @endif
                </div>
              </div>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>