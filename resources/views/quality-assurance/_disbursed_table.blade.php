<div class="d-flex ml-4"><h4 class="text-success">{{ !empty($message)? $message: '' }}</h4></div>
<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Job Reference</th>
        <th>Reference No</th>
        <th>Paid By</th>
        <th>Amount</th>
        <th>Payment Mode</th>
        <th>Comment</th>
        <th class="text-center">Payment Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @php $sn = 1; @endphp
      @foreach ($payments as $result)
        <tr>
        <td class="tx-color-03 tx-center">{{ $sn++ }}</td>
        <td class="tx-medium">{{$result->service_request->unique_id}}</td>
          <td class="tx-medium">{{$result->payment_reference}}</td>
          <td class="tx-medium">{{$result->user->account->first_name}} {{$result->user->account->last_name}}</td>
          <td class="tx-medium">₦{{ number_format($result->amount)}}</td>
          <td class="tx-medium">{{$result->mode->name}}</td>
          <td class="tx-medium">{{$result->comment}}</td>
          <td class="text-medium tx-center">{{ Carbon\Carbon::parse($result->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td><a href="#" data-toggle="modal" data-target="#transactionDetails" data-payment-ref="{{ $result->unique_id }}" data-url="{{ route('quality-assurance.payment_details', ['payment' => $result->id, 'locale' => app()->getLocale()]) }}" id="payment-details" class="btn btn-primary btn-sm ">Details</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
