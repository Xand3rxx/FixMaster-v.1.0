<h5>
  Issuer: {{ Str::title($rfqDetails['issuer']['account']['first_name'] ." ". $rfqDetails['issuer']['account']['last_name']) }}<br>
  Service: {{ $rfqDetails->serviceRequest->service->name }}
</h5>
            <div class="table-responsive mt-4">
              <form method="POST" action="{{ route('supplier.rfq_store_supplier_invoice', app()->getLocale()) }}">
                @csrf
                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th width="30%">Component Name</th>
                      <th width="15%">Model Number</th>
                      <th width="5%" class="text-center">Quantity</th>
                      <th width="25%" class="text-center">Unit Price</th>
                      <th width="25%" class="text-center">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <input value="{{ $rfqDetails->id }}" type="hidden" name="rfq_id" class="d-none">
                    <input value="{{ old('total_amount') }}" type="hidden" name="total_amount"  id="total_amount" class="d-none"> 

                      @foreach ($rfqDetails->rfqBatches as $item)

                      <input value="{{ $item->id }}" type="hidden" name="rfq_batch_id[]" class="d-none">
                      <input value="{{ $item->quantity }}" type="hidden" name="quantity[]"> 
                        <tr>
                            <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                            <td class="tx-medium">{{ $item->component_name }}</td>
                            <td>{{ $item->model_number }}</td>
                            <td class="tx-medium text-center quantity-{{$item->id}}">{{ $item->quantity }}</td>
                            <td class="tx-medium text-center">
                            <input type="number" maxlength="7" min="1" name="unit_price[]" class="form-control @error('unit_price') is-invalid @enderror" id="unit-price-{{$item->id}}" value="{{ old('unit_price[]') }}" onkeyup="individualAmount({{ $item->id }})" autocomplete="off">
                            @error('unit_price')
                              <x-alert :message="$message" />
                            @enderror
                            <input type="hidden" class="each-amount" id="unit-amount-{{$item->id}}">
                            </td>
                            <td class="tx-medium text-center amount-{{$item->id}}">0</td>
                        </tr>
                      @endforeach
                      <thead class="thead-primary">
                        <tr>
                          <th colspan="2">#</th>
                          <th width="20%">Delivery Fee</th>
                          <th width="20%">Delivery Time</th>
                          <th colspan="2"></th>
                        </tr>
                      </thead>
                      <tr>
                        <td colspan="2">1</td>
                        <td>
                          <input class="form-control @error('delivery_fee') is-invalid @enderror each-amount" name="delivery_fee" id="delivery_fee" type="number" maxlength="7" min="1" value="{{ old('delivery_fee')}}" autocomplete="off" onkeyup="deliveryFee()">
                          @error('delivery_fee')
                            <x-alert :message="$message" />
                          @enderror
                        </td>
                        <td>
                          <input class="form-control @error('delivery_time') is-invalid @enderror" name="delivery_time" id="service-date-time" type="text" value="{{ old('delivery_time') }}" placeholder="Click to Enter Delivery Date & Time" readonly>
                          @error('delivery_time')
                            <x-alert :message="$message" />
                          @enderror
                        </td>
                        <td colspan="1"></td>
                        <td class="tx-medium delivery-fee">0</td>
                      </tr>
                      <tr>
                        <td colspan="4">
                            <button type="submit" class="btn btn-primary">Send Invoice</button>
                        </td>
                        <td class="tx-medium text-center">Total</td>
                        <td class="tx-medium text-center total-amount">₦0</td>
                      </tr>
                  </tbody>
                </table>
              </form>
            </div><!-- table-responsive -->