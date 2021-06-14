
<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Job Ref.</th>
        <th>Job Location</th>
        <th>Booking Date</th>
        <th>Acceptance Date</th>
        <th>CSE Matched</th>
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
        <td class="tx-medium">{{ !empty($result['service_request']['address']['town']['name']) ? $result['service_request']['address']['town']['name'] : 'UNAVAILABILE' }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse($result['service_request']['created_at'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse($result['job_acceptance_time'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        @foreach($result['service_request']['service_request_assignee']['user']['roles'] as $data)
         @if($data['slug'] == 'cse-user')
         <td class="text-medium">  {{$result['service_request']['service_request_assignee']['user']['account']['first_name']}}
           {{$result['service_request']['service_request_assignee']['user']['account']['middle_name']}}
           {{$result['service_request']['service_request_assignee']['user']['account']['last_name']}}
        </td>
         @endif
        @endforeach
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
    </tbody>
  </table>
