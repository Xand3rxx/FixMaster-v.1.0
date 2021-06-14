<h5><strong>Booking Fee History for {{ $priceName }}</strong></h5>

<div class="table-responsive">
    <table class="table table-hover mg-b-0" id="basicExample">
      <thead class="thead-primary">
        <tr>
          <th class="text-center">#</th>
          <th>Updated By</th>
          <th class="text-center">Amount(₦)</th>
          <th>Date Created</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($priceHistories as $priceHistory)
            <tr>
                <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                <td>{{ !empty($priceHistory->user->email) ? $priceHistory->user->email : 'UNAVAILABLE' }}</td>
                <td class="tx-medium text-center">{{ !empty($priceHistory->amount) ? number_format($priceHistory->amount) : '0' }}</td>
                <td>{{ Carbon\Carbon::parse($priceHistory->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') ?? Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>