
<div class="d-flex ml-4"><h4 class="text-success">{{ $message }}</h4></div>
<table class="table table-dashboard mg-b-0" id="basicExample">
    <thead>
      <tr>
        <th width="5%">#</th>
        <th width="10%">Type</th>
        <th width="20%">Date Created</th>
        <th width="65%">Message</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($activityLogs as $activityLog)
        @if($activityLog->severity == 'Informational')
          <tr class="alert alert-success" role="alert">
        @elseif($activityLog->severity == 'Warning')
          <tr class="alert alert-warning" role="alert">
        @elseif($activityLog->severity == 'Error')
          <tr class="alert alert-danger" role="alert">
        @else
          <tr>
        @endif
        <td class="tx-color-03">{{ ++$i }}</td>
        <td class="tx-medium">{{ $activityLog->type }}</td>
        <td class="tx-medium">{{ Carbon\Carbon::parse($activityLog->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
        <td class="tx-medium">{{ $activityLog->message }} <a href="#activityLogDetailsModal" data-toggle="modal" data-url="{{ route('admin.activity-log.details', ['activity_log'=>$activityLog->id, 'locale'=>app()->getLocale()]) }}" id="activity-log-details" title="View activity log details"> <i class="fas fa-info-circle"></i></a></td>
        </tr>
      @endforeach
      
    </tbody>
  </table>

  <!-- Activity Log Details Modal -->
	<div class="modal fade" id="activityLogDetailsModal" tabindex="-1" role="dialog" aria-labelledby="activityLogDetailsModal" aria-hidden="true" data-keyboard="false" data-backdrop="static"> 
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Activity Log Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="modal-body">
              <!-- Modal displays here -->
              <div id="sort_table_details"></div>
          </div>
          {{-- <div class="modal-footer text-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div> --}}
        </div>
    </div>
  </div>