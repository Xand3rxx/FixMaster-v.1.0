           
<table class="table table-hover mg-b-0" id="basicExample1">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>CUSTOMER ID</th>
        <th>CUSTOMER NAME</th>
        <th>TERRITORY</th>
        <th>WARRANTY STATUS</th>
        <th>WARRANTY TYPE</th>
        <th>CSE ASSIGNED</th>
        <th>NO OF DAYS SPENT ON RESOLUTION</th>
        <th>WARRANTY RESOLUTION DATE</th>
        <th>JOB RATING</th>
      
      </tr>
    </thead>
    <tbody>
      @foreach ($warranties as $warranty)

 
        <tr>
          <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
          <td class="tx-medium">{{ $warranty['user']['id'] }}</td>
          <td class="tx-medium">{{ $warranty['user']['account']['first_name'].' '.$warranty['user']['account']['last_name'] }}</td>
          <td class="tx-medium">{{ $warranty['service_request']['client']['account']['lga']['name']??'UNAVAILABLE' }}</td>
          @if($warranty->status == 'used')
            <td class="text-success">Used</td>
          @else
            <td class="text-danger">Unused</td>
          @endif
          <td class="tx-medium">{{ $warranty['warranty']['name'] }}</td>

          @foreach ($warranty['service_request_report']['service_request_assignees'] as $item)
            @if($item['user']['roles'][0]['slug'] == 'cse-user')
          <td class="tx-medium">{{ ucfirst($item->user->account->first_name)}} {{  ucfirst($item->user->account->last_name)}}</td>
          @endif
          @endforeach
          @if($warranty['service_request_warranty_issued']['date_resolved'])
          <td class="tx-medium text-center">{{CustomHelpers::displayTime($warranty->date_initiated , $warranty['service_request_warranty_issued']['date_resolved']) }}</td>
          <td class="tx-medium">{{ Carbon\Carbon::parse($warranty['service_request_warranty_issued']['date_resolved']?? '2020-12-28', 'UTC')->isoFormat('MMMM Do YYYY') }}</td>

          @else
          <td class="text-danger">UNAVAILABLE</td>
          <td class="text-danger">UNAVAILABLE</td>
          @endif
          <td class="tx-medium">{{$warranty['service_request']['serviceRating']['star']??'UNAVAILABLE'}}</td>
       
        </tr>
      @endforeach
   
   
    </tbody>
  </table>


