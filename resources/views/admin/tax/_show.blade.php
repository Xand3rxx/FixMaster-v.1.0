<h5><strong>Tax Percentage History for {{ $taxName }}</strong></h5>

<div class="table-responsive">
    <table class="table table-hover mg-b-0" id="basicExample">
      <thead class="thead-primary">
        <tr>
          <th class="text-center">#</th>
          <th>Created By</th>
          <th class="text-center">Percentage</th>
          <th>Date Created</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($taxHistories as $taxHistory)
            <tr>
                <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                <td>{{ $taxHistory->user->email }}</td>
                <td class="tx-medium text-center">{{ $taxHistory->percentage }}</td>
                <td>{{ Carbon\Carbon::parse($taxHistory->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>