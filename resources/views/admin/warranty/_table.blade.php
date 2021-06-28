<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Warranty ID</th>
        <th>Warranty Name</th>
        <th>Warranty Type</th>
        <th class="text-center">Percentage(%)</th>  
        <th class="text-center">Duration(Days)</th>  
        <th>Date Created</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($warranties as $warranty)
        <tr>
          <td class="tx-color-03 tx-center">{{ ++$loop->iteration }}</td>
          <td class="tx-medium">{{ !empty($warranty->unique_id) ? $warranty->unique_id : 'UNAVAILABLE' }}</td>
          <td>{{ !empty($warranty->name) ? $warranty->name : 'UNAVAILABLE' }}</td>
          <td>{{ $warranty->warranty_type }}</td>
          <td class="tx-medium text-center">{{ !empty($warranty->percentage) ? $warranty->percentage : '0' }}</td>
          <td class="tx-medium text-center">{{ !empty($warranty->duration) ? $warranty->duration : '0' }}</td>
          <td>{{ Carbon\Carbon::parse($warranty->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class=" text-center">
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('admin.warranty_summary', ['details'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>
              <a href="{{ route('admin.edit_warranty', ['details'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>
              <a href="#" id="delete" 
                                                    data-url="{{route('admin.delete_warranty', ['details'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}"
                                                    class="dropdown-item details text-danger" title="Delete Discount"><i
                                                        class="fas fa-trash"></i> Delete</a>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  
@push('scripts')
<script>
  $(document).ready(function() {

$(document).on('click', '#delete', function(event) {
    event.preventDefault();
    let route = $(this).attr('data-url');
    let url = "<a href='" + route + "'  class='confirm-link'>Yes Delete</a>";
    displayAlert(url, 'Would you like to detele this Warranty?')
});


function displayAlert(url, message) {
    Swal.fire({
        title: 'Are you sure?',
        text: message,
        showCancelButton: true,
        confirmButtonColor: '#E97D1F',
        cancelButtonColor: '#8392a5',
        confirmButtonText: url
    })

}

});



</script>

@endpush