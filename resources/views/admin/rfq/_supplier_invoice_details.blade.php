<h5>JOB: {{ $supplierInvoice->rfq->serviceRequest->unique_id }} <br>RFQ: {{ $supplierInvoice->rfq->unique_id }}</h5>
            <div class="table-responsive mt-4">
              <table class="table table-striped table-sm mg-b-0">
                <tbody>
                  <tr>
                    <td class="tx-medium">Supplier's Name</td>
                    <td class="tx-color-03">{{ Str::title($supplierInvoice['supplier']['account']['first_name'] ." ". $supplierInvoice['supplier']['account']['last_name'])  }} ({{ $supplierInvoice['supplier']['supplier']['business_name'] }})</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Delivery Fee</td>
                    <td class="tx-color-03">₦{{ number_format($supplierInvoice->delivery_fee) ?? '0' }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Delivery Time</td>
                    <td class="tx-color-03">{{ Carbon\Carbon::parse($supplierInvoice->delivery_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Issued By</td>
                    <td class="tx-color-03">{{ Str::title($supplierInvoice['rfq']['issuer']['account']['first_name'] ." ". $supplierInvoice['rfq']['issuer']['account']['last_name']) }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Client Name</td>
                    <td class="tx-color-03">{{ Str::title($supplierInvoice['rfq']['serviceRequest']['client']['account']['first_name'] ." ". $supplierInvoice['rfq']['serviceRequest']['client']['account']['last_name']) }}</td>
                  </tr>
                  
                  <tr>
                    <td class="tx-medium">Client Address</td>
                    <td class="tx-color-03">{{ !empty($supplierInvoice['rfq']['serviceRequest']['client']['contact']['address']) ? $supplierInvoice['rfq']['serviceRequest']['client']['contact']['address'] : 'UNAVAILABLE' }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Grand Total</td>
                    <td class="tx-color-03">₦{{ number_format($supplierInvoice->total_amount) ?? 0 }}</td>
                  </tr>

                </tbody>
              </table>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Manufacturer Name</th>
                      <th>Model Number</th>
                      <th>Component Name</th>
                      <th class="text-center">Quantity</th>
                      <th class="text-center">Size</th>
                      <th>Unit of Measurement</th>
                      <th class="text-center">Image</th>
                      <th class="text-center">Unit Price(₦)</th>
                      <th class="text-center">Amount(₦)</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($supplierInvoiceBatches as $item)
                        <tr>
                            <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                            <td class="tx-medium">{{ !empty($item->rfqBatch->manufacturer_name) ? $item->rfqBatch->manufacturer_name : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($item->rfqBatch->model_number) ? $item->rfqBatch->model_number : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($item->rfqBatch->component_name) ? $item->rfqBatch->component_name : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium text-center">{{ !empty($item->rfqBatch->quantity) ? number_format($item->rfqBatch->quantity) : '0' }}</td>
                            <td class="tx-medium text-center">{{ !empty($item->rfqBatch->size) ? number_format($item->rfqBatch->size) : '0' }}</td>
                            <td class="tx-medium">{{ !empty($item->rfqBatch->unit_of_measurement) ? $item->rfqBatch->unit_of_measurement : 'UNAVAILABLE' }}</td>
                            <td class="text-center">
                              @if(!empty($item->rfqBatch->image))
                              <a href="#rfqImageDetails" data-toggle="modal" class="text-info" title="View {{ $item->rfqBatch->component_name }} image" data-batch-number="{{ $item->rfqBatch->id }}" data-url="{{ route('admin.rfq_details_image', ['image'=>$item->rfqBatch->id, 'locale'=>app()->getLocale()]) }}" id="rfq-image-details"> View</a>
                              @else
                                    -
                              @endif
                            </td>
                            <td class="tx-medium text-center">₦{{ number_format($item->unit_price) }}</td>
                            <td class="tx-medium text-center">₦{{ number_format($item->total_amount) }}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
            </div><!-- table-responsive -->