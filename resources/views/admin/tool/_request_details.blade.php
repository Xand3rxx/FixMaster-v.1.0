<h5><strong>BATCH NO.: {{ $toolRequestDetails->batch_number }}</strong></h5>

<div class="table-responsive">
    <table class="table table-hover mg-b-0" id="basicExample">
      <thead class="thead-primary">
        <tr>
          <th class="text-center">#</th>
          <th>Equipment/Tools Name</th>
          <th class="text-center">Quantity</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($toolRequestDetails->toolRequestBatches as $toolRequestDetail)
            <tr>
                <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                <td class="tx-medium">{{ $toolRequestDetail->tool->name }}</td>
                <td class="tx-medium text-center">{{ $toolRequestDetail->quantity }}</td>
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>

  @if($toolRequestDetails->is_returned == '1')
  <small class="text-success font-weight-bold">Tools were returned on {{ Carbon\Carbon::parse($toolRequestDetails->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</small>
  @endif