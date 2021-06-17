 <div class="d-flex ml-4"><h4 class="text-success">{{ !empty($message)? $message: '' }}</h4></div>
 <table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
    {{-- {{$payment}} --}}
      <tr>
        <tr>
            <th class="text-center">#</th>
            <th>Service</th>
            <th>Job ID</th>
            <th>Client</th>
            <th>Payment For</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date Paid</th>
            <th>Action</th>
          </tr>
      </tr>
    </thead>
    <tbody>

        @foreach($receivedPayments as $payment)
        <tr>

            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
            <td class="tx-medium">{{$payment['service_request']['service']['name']}}</td>
            <td class="tx-medium">{{$payment['unique_id']}}</td>
            <td class="tx-medium">{{$payment['clients']['account']['first_name'].' '.$payment['clients']['account']['last_name']}}</td>
            <td class="tx-medium">{{$payment['payment_type']}}</td>
            <td class="tx-medium">&#8358;{{number_format($payment['amount'],2)}}</td>
            <td class="tx-medium">{{$payment['status']}}</td>
            <td class="text-medium tx-center">{{ Carbon\Carbon::parse($payment['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>

              {{-- <td><a href="#" data-toggle="modal" data-target="#transactionDetails" data-payment-ref="{{ $result->unique_id }}" data-url="{{ route('quality-assurance.payment_details', ['payment' => $result->id, 'locale' => app()->getLocale()]) }}" id="payment-details" class="btn btn-primary btn-sm ">Details</a></td> --}}
               <td><a href="#" id="" class="btn btn-primary btn-sm ">Details</a></td>
            </tr>
        @endforeach
    </tbody>
  </table>
