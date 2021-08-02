<table class="table table-hover mg-b-0" id="basicExample">
  <thead class="thead-primary">
    <tr>
      <th class="text-center">#</th>
      <th class="text-center">Radius(km)</th>
      <th class="text-center">Max. Ongoing Jobs</th>
      <th>Date Created</th>
      <th>Date Updated</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="tx-color-03 tx-center">1</td>
      <td class="text-center">{{ $setting->radius }}</td>
      <td class="text-center">{{ $setting->max_ongoing_jobs }}</td> 
      <td class="text-medium">{{ Carbon\Carbon::parse($setting->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
      <td class="text-medium">{{ Carbon\Carbon::parse($setting->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
      <td class=" text-center">
        <div class="dropdown-file">
          <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
          <div class="dropdown-menu dropdown-menu-right">
          
            <a href="#editCriteria" data-toggle="modal" id="criteria-edit" data-url="{{ route('admin.service-request-settings.edit', ['service_request_setting'=>$setting->uuid, 'locale'=>app()->getLocale()]) }}" data-id="{{ $setting->uuid }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

            {{-- <a data-url="{{ route('admin.service-request-settings.delete', ['tax'=>$setting->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger delete-entity" title="Delete {{ $setting->uuid}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Delete</a> --}}

          </div>
        </div>
      </td>
    </tr>
  </tbody>
</table>