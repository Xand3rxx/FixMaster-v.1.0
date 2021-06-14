<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Job Reference</td>
            <td class="tx-color-03" width="75%">{{ $dispatch['rfq']['serviceRequest']['unique_id'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">RFQ Batch Number</td>
            <td class="tx-color-03" width="75%">{{ $dispatch['rfq']['unique_id'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Dispatch Code</td>
            <td class="tx-color-03" width="75%">{{ $dispatch->unique_id }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Client Service Executive Status</td>
            @if($dispatch->cse_status == 'Pending')
                <td width="75%" class="text-medium text-warning">Pending</td>
            @elseif($dispatch->cse_status == 'Yes')
                <td width="75%" class="text-medium text-success">Accepted</td>
            @else
                <td width="75%" class="text-medium text-danger">Declined</td>
            @endif
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Client Service Executive Acceptance</td>
            <td class="tx-color-03" width="75%">{{ (!empty($dispatch->cse_material_acceptance)) ? ($dispatch->cse_material_acceptance == 'Yes' ? 'Yes, all ordered materials were delivered' : 'No, all ordered materials were not delivered as specified') : 'UNAVAILABLE' }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Client Service Executive Comment</td>
            <td class="tx-color-03" width="75%">{{ $dispatch->cse_comment ?? 'UNAVAILABLE' }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Supplier Status</td>
            @if($dispatch->supplier_status == 'Processing')
                <td width="75%" class="text-medium text-warning">Processing</td>
            @elseif($dispatch->supplier_status == 'Delivered')
                <td width="75%" class="text-medium text-success">Delivered</td>
            @else
                <td width="75%" class="text-medium text-info">In-Transit</td>
            @endif
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Dispatched Date</td>
            <td class="tx-color-03" width="75%"3">{{ Carbon\Carbon::parse($dispatch->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Courier Name</td>
            <td class="tx-color-03" width="75%"3">{{ $dispatch->courier_name }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="35%">Courier Phone Number</td>
            <td class="tx-color-03" width="65%"3">{{ $dispatch->courier_phone_number }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Delivery Medium</td>
            <td class="tx-color-03" width="75%">{{ $dispatch->delivery_medium }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%"> Comment</td>
            <td class="tx-color-03" width="75%">{{ $dispatch->comment }}</td>
        </tr>
        
    </tbody>
    </table>
</div>

@if($dispatch->cse_status == 'Delivered')
<div class="divider-text">Delivered Materials</div>

<h5>Delivered Materials</h5>
<div class="table-responsive mt-4">
    <table class="table table-hover mg-b-0" id="basicExample">
      <thead class="thead-primary">
        <tr>
          <th class="text-center">#</th>
          <th>Component Name</th>
          <th>Model Number</th>
          <th class="text-center">Quantity</th>
          <th class="text-center">Unit Price(₦)</th>
          <th class="text-center">Amount(₦)</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($dispatch['supplierInvoice']['supplierInvoiceBatches'] as $item)
            <tr>
                <td class="tx-color-03 tx-center">{{ ++$loop->iteration }}</td>
                <td class="tx-medium">{{ $item->rfqBatch->component_name }}</td>
                <td class="tx-medium">{{ $item->rfqBatch->model_number }}</td>
                <td class="tx-medium text-center">{{ $item->quantity }}</td>
                <td class="tx-medium text-center">₦{{ number_format($item->unit_price) }}</td>
                <td class="tx-medium text-center">₦{{ number_format($item->total_amount) }}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="5" class="tx-medium">Delivery Fee</td>
            <td class="tx-medium text-center">₦{{ number_format($dispatch['supplierInvoice']['delivery_fee']) ?? '0' }}</td>
          </tr>
          <tr>
            <td colspan="5" class="tx-medium table-dark">Grand Total</td>
            <td class="tx-medium text-center table-dark">₦{{ number_format($dispatch['supplierInvoice']['total_amount']) ?? 0 }}</td>
          </tr>
      </tbody>
    </table>
  </div><!-- table-responsive -->
  @endif