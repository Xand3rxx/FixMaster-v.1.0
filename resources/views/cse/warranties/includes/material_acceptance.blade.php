

                      
                        <h3>Material Acceptance</h3>
                        <section>
                        <small class="text-danger">This portion will display only if the CSE initially executed a RFQ, the Client paid for the components and the Supplier has made the delivery.</small>

                        @if($rfqWarranty->status != 'Delivered')
                            <h5>Update RFQ Status</h5>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="status">Status</label>
                                    <select class="form-control custom-select" id="status" name="delivery_status">
                                        <option selected disabled value="" selected>Select...</option>
                                        <option value="Awaiting" value="{{ old('Awaiting') }}" {{ old('status') == 'Awaiting' ? 'selected' : ''}}>Awaiting</option>
                                        <option value="Shipped" value="{{ old('Shipped') }}" {{ old('status') == 'Shipped' ? 'selected' : ''}}>Shipped</option>
                                        <option value="Delivered" value="{{ old('Shipped') }}" {{ old('status') == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                        <option value="Rejected" value="{{ old('Rejected') }}" {{ old('status') == 'Rejected' ? 'selected' : ''}}>Rejected</option>

                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                            @endif
                            <input type="hidden" value="{{$rfqWarranty?$rfqWarranty->id: 0}}" name="rfqWarranty_id">


 @foreach($rfqDetails as $rfqDetail)

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

            @if(!is_null($rfqDetail->supplierDispatch ))
                  <tr>
                    <td class="tx-medium">Dispatch Status</td>
                @if($rfqDetail->supplierDispatch->supplier_status === 'Delivered')
                <td class="text-success">{{$rfqDetail->supplierDispatch->supplier_status}}</td>
                @else
                <td class="text-info">{{$rfqDetail->supplierDispatch->supplier_status}}</td>
                @endif

                 
                </tr>
                <tr>
                <td class="tx-medium">Delivery Status</td>
                @if($rfqDetail->rfq->status === 'Delivered')
                <td class="text-success">{{$rfqDetail->rfq->status}}</td>
                @else
                <td class="text-warning">{{$rfqDetail->rfq->status}}</td>
                @endif
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
                              @if($item->image == '')
                              {{$item->image  }} kkkkkkkkkkkkkkkkkkkk
                              @else
                              <a href="#rfqImageDetails" data-toggle="modal" class="text-info" title="View {{ $item['component_name'] }} image" data-batch-number="{{ $item->id }}" data-url="{{ route('cse.rfq_waranty_details_image', ['image'=>$item->id, 'locale'=>app()->getLocale()]) }}" id="rfq-image-details"> View</a>
                              @endif
                            </td>
                            <td class="tx-medium text-center">{{ !empty($item->amount) ? number_format($item->amount) : $rfqDetail->total_amount  }}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                            </div><!-- table-responsive -->
         @endforeach



            <div class="divider-text">Accept Materials Delivery  </div>
                            <h5></h5>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="accept_materials">Accept Delivery</label>
                                    <select class="form-control custom-select" id="accept_materials" name="accept_materials">
                                        <option selected disabled value="" selected>Select...</option>
                                        <option value="Yes" value="{{ old('Yes') }}" {{ old('accept_materials') == 'Yes' ? 'selected' : ''}}>Yes, all ordered components were delivered</option>
                                        <option value="No" value="{{ old('No') }}" {{ old('accept_materials') == 'No' ? 'selected' : ''}}>No, all ordered components were not delivered</option>
                                    </select>
                                    @error('accept_materials')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group decline-rfq-reason col-md-12">
                                    <label for="reason">Reason</label>
                                    <textarea rows="3" class="form-control @error("reason") is-invalid @enderror" id="reason" name="accept_reason"></textarea>
                                </div>
                            </div>


                            
                            </section>





                       