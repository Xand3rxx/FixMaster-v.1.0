<div class="table-responsive">
                
    <table class="table table-hover mg-b-0" id="basicExample">
      <thead class="thead-primary">
        <tr>
          <th class="text-center">#</th>
          <th>State</th>
          <th class="text-center">Local Govt</th>
          <th class="text-center">Towns</th>
          <th>Date Created</th>
          <th>Date Updated</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>


      @foreach($serviceAreas as $serviceArea)
        <tr>
          <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
          <td class="tx-medium">{{ !empty($serviceArea->state->name) ? $serviceArea->state->name : 'UNAVAILABLE' }}</td>
          <td class="tx-medium">{{ !empty($serviceArea->lga->name) ? $serviceArea->lga->name : 'UNAVAILABLE' }}</td>
          <td class="tx-medium text-center">{{ !empty($serviceArea->town->name) ? $serviceArea->town->name : 'UNAVAILABLE' }}</td>
          <td class="tx-medium text-center">{{ Carbon\Carbon::parse($serviceArea->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class="tx-medium text-center">{{ Carbon\Carbon::parse($serviceArea->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>

          <td class=" text-center">
            @if(!empty($serviceArea->town->name))
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('admin.services.edit', ['service'=>$serviceArea->uuid, 'locale'=>app()->getLocale()]) }}" id="service-edit" title="Edit {{ $serviceArea->name }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

              <a data-url="{{ route('admin.services.delete', ['service'=>$serviceArea->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger delete-entity" title="Delete {{ $serviceArea->name}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Delete</a>
              </div>
            </div>
            @endif
          </td>

          @endforeach


      </tbody>
    </table>
  </div><!-- table-responsive -->