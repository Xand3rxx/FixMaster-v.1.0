           
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
        <th>RATING</th>
        <th>JOB ID</th>
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
          <td class="tx-medium">UNAVAILABLE</td>
          <td class="tx-medium">{{ $warranty['service_request']['unique_id'] }}</td>
          <td class="tx-medium">{{$warranty['service_request']['serviceRating']['star']??'UNAVAILABLE'}}</td>
       
        </tr>
      @endforeach
   
   
    </tbody>
  </table>


