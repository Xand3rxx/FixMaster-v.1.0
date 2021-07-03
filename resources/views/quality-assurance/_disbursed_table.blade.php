<div class="d-flex ml-4"><h4 class="text-success">{{ !empty($message)? $message: '' }}</h4></div>
<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
            <th>Job ID</th>
            <th>Service Category</th>
            <th>Service Type</th>
            <th>QA Name</th>
            <th>QA Nuban</th>
            <th>QA Bank</th>
            <th>QA Amount</th>
            <th>Status</th>
            <th class="text-center">Date of Completion</th>
            <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @php $sn = 1; @endphp
      @foreach ($payments as $result)
        <tr>
        <td class="tx-color-03 tx-center">{{ $sn++ }}</td>
          <td class="tx-medium">{{$result['service_request']['unique_id']}}</td>
              <td class="tx-medium">{{$result['service_request']['service']['name']}}</td>
              <td class="tx-medium">{{$result['service_type']}}</td>
              <td class="tx-medium">{{$result['users']['account']['first_name'].' '.$result['users']['account']['middle_name'].' '.$result['users']['account']['last_name'] ?? 'Unavailable'}}</td>
                 <td class="tx-medium">{{!empty($result['users']['account']['account_number']) ? $result['users']['account']['account_number'] : 'Unavailable'}}</td>
                 <td class="tx-medium">{{$result['users']['account']['bank']['name']}}</td>
                 <td class="tx-medium">&#8358;{{number_format($result['amount_to_be_paid'],2)}}</td>
                 @if($result['status'] == 'Paid')
                  <td class="tx-medium text-success">Paid</td>
                 @else
                  <td class="tx-medium text-warning">Pending</td>
                 @endif

          <td class="text-medium tx-center">{{ Carbon\Carbon::parse($result->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td><a href="#" data-toggle="modal" data-target="#transactionDetails" data-payment-ref="{{ $result['service_request']['unique_id'] }}" data-url="{{ route('quality-assurance.payment_details', ['payment' => $result->id, 'locale' => app()->getLocale()]) }}" id="payment-details" class="btn btn-primary btn-sm ">Details</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
