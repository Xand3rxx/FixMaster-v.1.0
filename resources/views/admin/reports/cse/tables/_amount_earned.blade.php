
{{-- {{ dd($results)}} --}}
<table class="table table-hover mg-b-0" id="basicExample2">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Job Ref.</th>
        <th>Job Acceptance Time</th>
        <th>Job Diagnostic Date</th>
        <th>Days Btw. Acceptance & Diagnosis</th>
        <th>Job Completion Date</th>
        <th>Diagnostic Earning</th>
        <th>Completion Earning</th>
        <th>Total Earned</th>
        <th>Diagnostic Paid(Y/N)</th>
        <th>Completion Paid(Y/N)</th>
        <th>Total Paid</th>
      </tr>
    </thead>
    <tbody>

      @foreach ($results as $result)
      <tr>
        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
        <td class="tx-medium">{{ !empty($result['user']['account']['first_name']) ? Str::title($result['user']['account']['first_name'] ." ". $result['user']['account']['last_name']) : 'UNAVAILABLE' }}</td>
        <td class="tx-medium">{{ $result['service_request']['unique_id'] }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse($result['job_acceptance_time'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse($result['job_diagnostic_date'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium text-center">{{ !empty($result['service_request']['created_at']) ? Carbon\Carbon::parse($result['job_acceptance_time'], 'UTC')->diffInDays(Carbon\Carbon::parse($result['service_request']['created_at'], 'UTC')) : '0'}}day(s)</td>
        <td class="text-medium">{{ !empty($result['job_completed_date']) ? Carbon\Carbon::parse($result['job_completed_date'], 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') : 'UNAVAILABLE' }}</td>
        <td class="text-center">-</td>
        <td class="text-center">-</td>
        <td class="text-center">-</td>
        <td class="text-center">-</td>
        <td class="text-center">-</td>
        <td class="text-center">-</td>
      </tr>
      @endforeach

    </tbody>
  </table>