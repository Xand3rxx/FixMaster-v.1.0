<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Created By</th>
        <th class="text-center">Percentage</th>
        <th class="text-center">Applicable</th>
        <th class="text-center">Description</th>
        <th>Date Created</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($taxes as $tax)
        <tr>
          <td class="tx-color-03 tx-center">{{ ++$i }}</td>
          <td class="tx-medium">{{ $tax->name }}</td>
          <td>{{ $tax->user->email }}</td>
          <td class="tx-medium text-center">{{ $tax->percentage }}</td>
          @if($tax->applicable == 1) 
          <td class="text-center text-success">Yes</td> 
          @else 
            <td class="text-center text-danger">No</td>
          @endif
          <td>{{ $tax->description }}</td>
          <td>{{ Carbon\Carbon::parse($tax->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class=" text-center">
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
             
                <a href="#taxDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $tax->name}} details" data-url="{{ route('admin.taxes.show', ['tax'=>$tax->uuid, 'locale'=>app()->getLocale()] ) }}" data-tax-name="{{ $tax->name}}" id="tax-details"><i class="far fa-clipboard"></i> History</a>

                <a href="#editTax" data-toggle="modal" id="tax-edit" title="Edit {{ $tax->name }}" data-url="{{ route('admin.taxes.edit', ['tax'=>$tax->uuid, 'locale'=>app()->getLocale()]) }}" data-tax-name="{{ $tax->name }}" data-id="{{ $tax->uuid }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

                <a data-url="{{ route('admin.taxes.delete', ['tax'=>$tax->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger delete-entity" title="Delete {{ $tax->name}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Delete</a>

              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>