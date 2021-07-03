           
<table class="table table-hover mg-b-0" id="basicExample1">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>CUSTOMER ID</th>
        <th>CUSTOMER NAME</th>
        <th>JOB ID</th>
        <th>JOB CATEGORY</th>
        <th>TERRITORY</th>
        <th>FRANCHISEE</th>
        <th>JOB COMPLETION DATE</th>
        <th> EXTENDED WARRANTY VALUE</th>
        <th>EXTENDED WARRANTY ACTIVATION DATE</th>
        <th>EXTENDED WARRANTY STATUS</th>
        <th>CSE ASSIGNED</th>
     
     
      </tr>
    </thead>
    <tbody>
      @foreach ($extendedWarranties as $warranty)
        <tr>
          <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
          <td class="tx-medium">{{ $warranty['user']['id'] }}</td>
          <td class="tx-medium">{{ $warranty['user']['account']['first_name'].' '.$warranty['user']['account']['last_name'] }}</td>
          <td class="tx-medium">{{ $warranty['service_request']['unique_id'] }}</td>
          <td class="tx-medium">{{ $warranty['service_request_report']['service']['category']['name'] }}</td>
          <td class="tx-medium">{{ $warranty['service_request']['client']['account']['lga']['name']??'UNAVAILABLE' }}</td>
          <td class="tx-medium">{{ 'None' }}</td>
          <td class="tx-medium">{{ Carbon\Carbon::parse($warranty['start_date'] ?? '2020-12-28', 'UTC')->isoFormat('MMMM Do YYYY') }}</td>
          <td class="tx-medium">{{ floor($warranty['warranty']['percentage']).'%' }}</td>
          <td class="tx-medium">{{ Carbon\Carbon::parse($warranty['start_date'] ?? '2020-12-28', 'UTC')->isoFormat('MMMM Do YYYY') }}</td>

          @if($warranty->status == 'used')
            <td class="text-success">Used</td>
          @else
            <td class="text-danger">Unused</td>
          @endif
          @foreach ($warranty['service_request_report']['service_request_assignees'] as $item)
            @if($item['user']['roles'][0]['slug'] == 'cse-user')
          <td class="tx-medium">{{ ucfirst($item->user->account->first_name)}} {{  ucfirst($item->user->account->last_name)}}</td>
          @endif
          @endforeach
        </tr>
      @endforeach
   
   
    </tbody>
  </table>


