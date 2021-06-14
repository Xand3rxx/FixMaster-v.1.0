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
      </tr>
    </thead>
    <tbody>
      @php $sn = 1; @endphp
      @foreach ($payments as $result)

        <tr>
        <td class="tx-color-03 tx-center">{{ $sn++ }}</td>
        <td class="tx-medium">{{$result->service_request->uuid}}</td>
          <td class="tx-medium">{{$result->payment_reference}}</td>
          <td class="tx-medium">Admin</td>
          <td class="tx-medium">₦{{ number_format($result->amount)}}</td>
          <td class="tx-medium">{{$result->mode->name}}</td>
          <td class="tx-medium">{{$result->comment}}</td>
          <td class="text-medium tx-center">{{ Carbon\Carbon::parse($result->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>

        </tr>
      @endforeach
    </tbody>
  </table>