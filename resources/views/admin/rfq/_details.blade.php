<h5>JOB: {{ $rfqDetails->serviceRequest->unique_id }} <br>RFQ: {{ $rfqDetails->unique_id }}</h5>
            <div class="table-responsive mt-4">
              <h5>Basic Details</h5>

              <table class="table table-striped table-sm mg-b-0">
                <tbody>
                  <tr>
                    <td class="tx-medium">Issued By</td>
                    <td class="tx-color-03">{{ !empty($rfqDetails['issuer']['account']['first_name']) ? Str::title($rfqDetails['issuer']['account']['first_name'] ." ". $rfqDetails['issuer']['account']['last_name']) : 'UNAVAILABLE' }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Client Name</td>
                    <td class="tx-color-03">{{ !empty($rfqDetails['serviceRequest']['client']['account']['first_name']) ? Str::title($rfqDetails['serviceRequest']['client']['account']['first_name'] ." ". $rfqDetails['serviceRequest']['client']['account']['last_name']) : 'UNAVAILABLE' }}</td>
                  </tr>
                  
                  <tr>
                    <td class="tx-medium">Client Address</td>
                    <td class="tx-color-03">{{ !empty($rfqDetails['serviceRequest']['client']['contact']['address']) ? $rfqDetails['serviceRequest']['client']['contact']['address'] : 'UNAVAILABLE' }}</td>
                  </tr>
                </tbody>
              </table>

              @if(collect($rfqDetails['rfqSupplier'])->isNotEmpty())
              <h5 class="mt-4">Supplier Details</h5>
              <table class="table table-striped table-sm mg-b-0">
                  <tbody>
                      <tr>
                          <td class="tx-medium">Supplier Name</td>
                          <td class="tx-color-03">{{ !empty($rfqDetails['rfqSupplier']['supplier']['account']['first_name']) ? Str::title($rfqDetails['rfqSupplier']['supplier']['account']['first_name'] ." ". $rfqDetails['rfqSupplier']['supplier']['account']['last_name']) : 'UNAVAILABLE' }} <small class="text-muted">(Business Name: {{ $rfqDetails['rfqSupplier']['supplier']['supplier']['business_name'] }})</small></td>
                      </tr>
                      <tr>
                          <td class="tx-medium">Delivery Fee</td>
                          <td class="tx-color-03">₦{{ !empty($rfqDetails['rfqSupplier']['devlivery_fee']) ? number_format($rfqDetails['rfqSupplier']['devlivery_fee']) : 0 }}</td>
                      </tr>
                      <tr>
                          <td class="tx-medium">Delivery Time</td>
                          <td class="tx-color-03">{{ !empty($rfqDetails['rfqSupplier']['delivery_time']) ? Carbon\Carbon::parse($rfqDetails['rfqSupplier']['delivery_time'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : 'UNAVAILABLE' }}</td>
                      </tr>
                      <tr>
                          <td class="tx-medium">Grand Total</td>
                          <td class="tx-color-03">₦{{ number_format($rfqDetails['total_amount'] ? $rfqDetails['total_amount'] : 0) }}</td>
                      </tr>
                  </tbody>
              </table>


              @if($rfqDetails['rfqSupplierInvoice']['supplierDispatch'])
              <h5 class="mt-4">Supplier Dispatch Details</h5>
              <table class="table table-striped table-sm mg-b-0">
                  <tbody>

                      <tr>
                          <td class="tx-medium">Courier Name</td>
                          <td class="tx-color-03">{{ !empty($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['courier_name']) ? Str::title($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['courier_name']) : 'UNAVAILABLE' }}</td>
                      </tr>
                      <tr>
                          <td class="tx-medium">Courier Phone Number</td>
                          <td class="tx-color-03">{{ !empty($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['courier_phone_number']) ? $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['courier_phone_number'] : 'UNAVAILABLE' }}</td>
                      </tr>
                      <tr>
                          <td class="tx-medium">Supplier Dispatch Status</td>
                          @if($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] == 'Processing')
                              <td class="text-warning">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] }}</td>
                          @elseif($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] == 'In-Transit')
                              <td class="text-info">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] }}</td>
                          @elseif($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] == 'Delivered')
                              <td class="text-success">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] }}</td>
                          @endif
                      </tr>
                      <tr>
                        <td class="tx-medium">CSE Dispatch Status</td>
                        @if($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_status'] == 'Pending')
                            <td class="text-warning">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_status'] }}</td>
                        @elseif($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_status'] == 'Awaiting')
                            <td class="text-info">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_status'] }}</td>
                        @elseif($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_status'] == 'Shipped')
                            <td class="text-info">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_status'] }}</td>
                        @elseif($rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_status'] == 'Delivered')
                            <td class="text-success">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_status'] }}</td>
                        @endif
                    </tr>
                      <tr>
                          <td class="tx-medium">Delivery Medium</td>
                          <td class="tx-color-03">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['delivery_medium'] }}</td>
                      </tr>
                      <tr>
                          <td class="tx-medium">Supplier Comment</td>
                          <td class="tx-color-03">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['comment'] }}</td>
                      </tr>
                      <tr>
                          <td class="tx-medium">CSE Acceptance Comment</td>
                          <td class="tx-color-03">{{ $rfqDetails['rfqSupplierInvoice']['supplierDispatch']['cse_comment'] }}</td>
                      </tr>

                  </tbody>
              </table>
              @endif

              @endif
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
                      <th class="text-center">Amount(₦)</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($rfqDetails->rfqBatches as $item)
                        <tr>
                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                            <td class="tx-medium">{{ !empty($item->manufacturer_name) ? $item->manufacturer_name : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($item->model_number) ? $item->model_number : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($item->component_name) ? $item->component_name : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium text-center">{{ !empty($item->quantity) ? number_format($item->quantity) : '0' }}</td>
                            <td class="tx-medium text-center">{{ !empty($item->size) ? number_format($item->size) : '0' }}</td>
                            <td class="tx-medium">{{ !empty($item->unit_of_measurement) ? $item->unit_of_measurement : 'UNAVAILABLE' }}</td>
                            <td class="text-center">
                              @if(!empty($item->image))
                              <a href="#rfqImageDetails" data-toggle="modal" class="text-info" title="View {{ $item->component_name }} image" data-batch-number="{{ $item->id }}" data-url="{{ route('admin.rfq_details_image', ['image'=>$item->id, 'locale'=>app()->getLocale()]) }}" id="rfq-image-details"> View</a>
                              @else
                                    -
                              @endif
                            </td>
                            <td class="tx-medium text-center">{{ !empty($item->amount) ? number_format($item->amount) : '0' }}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
            </div><!-- table-responsive -->