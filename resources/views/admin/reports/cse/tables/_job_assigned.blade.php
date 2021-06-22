<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Job Ref.</th>
        <th>Job Location</th>
        <th>Booking Date</th>
        <th>Acceptance Date</th>
        <th>Diagnostic Date</th>
        <th>Completion Date</th>
        <th>Status</th>
        <th>Days Btw. Booking & Acceptance</th>
        <th>Days Btw. Acceptance & Completion</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($results as $result)
      <tr>
        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
        <td class="tx-medium">{{ !empty($result['user']['account']['first_name']) ? Str::title($result['user']['account']['first_name'] ." ". $result['user']['account']['last_name']) : 'UNAVAILABLE' }}</td>
        <td class="tx-medium">{{ $result['service_request']['unique_id'] }}</td>
        <td class="tx-medium">Victoria Island</td>
        <td class="text-medium">{{ Carbon\Carbon::parse($result['service_request']['created_at'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse($result['job_acceptance_time'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse($result['job_diagnostic_date'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ !empty($result['job_completed_date']) ? Carbon\Carbon::parse($result['job_completed_date'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') : 'UNAVAILABLE' }}</td>
        @if($result['service_request']['status']['name'] == 'Pending')
        <td class="text-medium text-warning">{{ $result['service_request']['status']['name'] }}</td>
        @elseif($result['service_request']['status']['name'] == 'Ongoing')
        <td class="text-medium text-info">{{ $result['service_request']['status']['name'] }}</td>
        @elseif($result['service_request']['status']['name'] == 'Cancelled')
        <td class="text-medium text-danger">{{ $result['service_request']['status']['name'] }}</td>
        @else
        <td class="text-medium text-success">{{ $result['service_request']['status']['name'] }}</td>
        @endif
        <td class="text-medium text-center">{{ Carbon\Carbon::parse($result['service_request']['created_at'], 'UTC')->diffInDays(Carbon\Carbon::parse($result['job_acceptance_time'], 'UTC')) }}day(s) </td>
        <td class="text-medium text-center">{{ !empty($result['job_completed_date']) ? Carbon\Carbon::parse($result['job_acceptance_time'], 'UTC')->diffInDays(Carbon\Carbon::parse($result['job_completed_date'], 'UTC')) : '0'}}day(s)</td>
      </tr>
      @endforeach


      {{-- <tr>
        <td class="tx-color-03 tx-center">2</td>
        <td class="tx-medium">Susan Ngozi </td>
        <td class="tx-medium">REF-66EB5A26</td>
        <td class="tx-medium">Ogba</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-23 17:09:23', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-15 09:12:06', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-15 14:39:43', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium text-success">Completed</td>
        <td class="text-medium text-center">{{ Carbon\Carbon::parse('2021-01-23 17:09:23', 'UTC')->diffInDays(Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')) }}days</td>
        <td class="text-medium text-center">{{ Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')->diffInDays(Carbon\Carbon::parse('2021-01-15 14:39:43', 'UTC')) }}days</td>
      </tr> --}}

    </tbody>
  </table>
