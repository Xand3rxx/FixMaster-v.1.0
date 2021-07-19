
            <h3>Supplier's Invoice</h3>
         
                        <section>
                        <small class="text-danger">This portion will display only if the CSE initially executed a RFQ, the Client paid for the components and the Supplier has made the delivery.</small>
 
      
          
                @if(collect($rfqDetails)->count() > 0)
                @if($rfqDetails[0]->accepted  !=  'Yes')
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="status">Invoice Status</label>
                                    <select class="form-control custom-select" id="status" name="approve_invoice">
                                        <option selected disabled value="" selected>Select...</option>
                                        <option value="Approved" value="{{ old('Approved') }}" {{ old('status') == 'Approved' ? 'selected' : ''}}>Approved</option>
                                        <option value="Declined" value="{{ old('') }}" {{ old('status') == 'Declined' ? 'selected' : ''}}>Declined</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <input type="hidden" value="{{$rfqWarranty?$rfqWarranty->id: 0}}" name="rfqWarranty_id">

                            </div>
                            @endif
                            @endif
                      

 @foreach($rfqDetails as $rfqDetail)

 @if($rfqDetail->accepted != 'Yes')

 <ul class="list-group wd-md-100p">
             
             <li class="list-group-item d-flex align-items-center">
                 
                 <div class="form-row">
                 <img src="{{ asset('assets/user-avatars/'.$rfqDetail['supplier']['account']['avatar']??'default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

                 <div class="col-md-6 col-sm-6">
                 <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">
                 {{ !empty($rfqDetail['supplier']['account']['first_name']) ? Str::title($rfqDetail['supplier']['account']['first_name'] ." ". $rfqDetail['supplier']['account']['last_name']) : 'UNAVAILABLE' }}</td>
                 
                 </h6>

                 {{-- <span class="d-block tx-11 text-muted">
                         <i class="icon ion-md-star lh-0 tx-orange"></i>
                         <i class="icon ion-md-star lh-0 tx-orange"></i>
                         <i class="icon ion-md-star lh-0 tx-orange"></i>
                     <span class="font-weight-bold ml-2">0.6km</span>
                 </span> --}}
                 </div>
                 <div class="col-md-6 col-sm-6">
                 <div class="form-row">
                     <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                         <a href="tel: {{$rfqDetail['supplier']['account']['contact']['phone_number']}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                     </div>

                     <div class="form-group col-1 col-md-1 col-sm-1">
                          <div class="custom-control custom-radio mt-2">
                              <div class="custom-control custom-radio">
                                  <input type="checkbox" class="custom-control-input" id="" name="assigned_supplier_id[]" value="{{$rfqDetail['supplier']['account']['user_id']}}">
                                  <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
                              </div>
                          </div>
                      </div>

                 </div>
                 </div>
             </div>
             </li>

         </ul>
                            <div class="table-responsive mt-4">
                              

                                <table class="table table-striped table-sm mg-b-0">
                <tbody>
                  <tr>
                    <td class="tx-medium">Supplier's Name</td>
                    <td class="tx-color-03">
                      {{ !empty($rfqDetail['supplier']['account']['first_name']) ? Str::title($rfqDetail['supplier']['account']['first_name'] ." ". $rfqDetail['supplier']['account']['last_name']) : 'UNAVAILABLE' }}</td>
                  </tr>
                  @if(is_null($rfqDetail->supplierDispatch ))
                  <tr>
                    <td class="tx-medium">Dispatch Status</td>
                
                    <td class="text-info">Pending</td>
                 
                </tr>
                <tr>
                <td class="tx-medium">Delivery Status</td>
                <td class="text-warning">Pending</td>
            </tr>
            @endif

       
                  <tr>
                    <td class="tx-medium">Delivery Fee</td>
                    <td class="tx-color-03">₦{{ number_format($rfqDetail->delivery_fee ?? '0') }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Delivery Time</td>
                    <td class="tx-color-03">{{ Carbon\Carbon::parse($rfqDetail->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  </tr>
               
                  
                
                  
                  <tr>
                    <td class="tx-medium">Grand Total</td>
                    <td class="tx-color-03">₦{{ number_format($rfqDetail->total_amount +  $rfqDetail->delivery_fee) ?? 0 }}</td>
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
                      <th class="text-center">Amount(₦)</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($rfqDetail->rfqBatches as $item)
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
                              <a href="#rfqImageDetails" data-toggle="modal" class="text-info" title="View {{ $item->component_name }} image" data-batch-number="{{ $item->id }}" data-url="{{ route('cse.rfq_details_image', ['image'=>$item->id, 'locale'=>app()->getLocale()]) }}" id="rfq-image-details"> View</a>
                              @else
                                    -
                              @endif
                            </td>
                            <td class="tx-medium text-center">{{ !empty($item->amount) ? number_format($item->amount) : $rfqDetail->total_amount  }}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                       </div><!-- table-responsive -->
                       @endif 
         @endforeach
     
                            </section>
                         