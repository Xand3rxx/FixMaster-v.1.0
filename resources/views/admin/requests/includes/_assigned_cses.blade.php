<div id="assignedCSEs" class="tab-pane pd-20 pd-xl-25">
    <h5 class="mt-4">Notified Client Service Executives</h5>
    <div class="table-responsive mb-4">
        <table class="table table-hover mg-b-0">
            <thead class="thead-primary">
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Date Assigned</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviceRequest['adminAssignedCses'] as $assignedCse)
                <tr>
                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                    <td class="tx-medium">{{ Str::title($assignedCse['user']['account']['first_name'] ." ". $assignedCse['user']['account']['last_name']) }}</td>
                    <td class="tx-medium">{{ \Carbon\Carbon::parse($assignedCse['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- table-responsive -->
</div>