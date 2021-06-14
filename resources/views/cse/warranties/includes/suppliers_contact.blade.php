
                                
  {{--<div class="divider-text">Supplier {{ $loop->iteration }}</div>
                                    <ul class="list-group wd-md-100p">
             
                                        <li class="list-group-item d-flex align-items-center">
                                            
                                            <div class="form-row">
                                            <img src="{{ asset('assets/user-avatars/'.$item->warranty_claim_supplier->user->account->avatar??'default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

                                            <div class="col-md-6 col-sm-6">
                                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ ucfirst($item->warranty_claim_supplier->user->account->first_name)}} {{  ucfirst($item->warranty_claim_supplier->user->account->last_name)}}</h6>

                                            <span class="d-block tx-11 text-muted">
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                <span class="font-weight-bold ml-2">0.6km</span>
                                            </span>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                                    <a href="tel: {{$item->warranty_claim_supplier->user->account->contact->phone_number}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                </div>

                                                <div class="form-group col-1 col-md-1 col-sm-1">
                                                     <div class="custom-control custom-radio mt-2">
                                                         <div class="custom-control custom-radio">
                                                             <input type="radio" class="custom-control-input" id="" name="supplier_id" value="{{$item->warranty_claim_supplier->user_id}}">
                                                             <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
                                                         </div>
                                                     </div>
                                                 </div>

                                            </div>
                                            </div>
                                        </div>
                                        </li>
              
                                    </ul>--}}

                                    {{-- <div class="table-responsive mt-4">
                                <table class="table table-striped table-sm mg-b-0">
                                    <tbody>
                                    
                                    <tr>
                                        <td class="tx-medium">Supplier Name</td>
                                        <td class="tx-color-03">{{ ucfirst($item->warranty_claim_supplier->user->account->first_name)}} {{  ucfirst($item->warranty_claim_supplier->user->account->last_name)}}</h6>

                                         <small class="text-muted">(Business Name: {{$item->warranty_claim_supplier->business_name}} )</small></td>
                                    </tr>
                                    <!-- <tr>
                                        <td class="tx-medium">Dispatch Status</td>
                                        <td class="text-info">In-Transit</td>
                                    </tr> -->
                                    <!-- <tr>
                                        <td class="tx-medium">Delivery Status</td>
                                        <td class="text-warning">Pending</td>
                                    </tr> -->
                                    <tr>
                                        <td class="tx-medium">Delivery Fee</td>
                                        <td class="tx-color-03">₦{{ number_format($item->delivery_fee) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-medium">Delivery Time</td>
                                        <td class="tx-color-03">{{ Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-medium">Grand Total</td>
                                        <td class="tx-color-03">₦{{ number_format($item->total_amount) }}</td>
                                    </tr>
                                
                                    </tbody>
                                </table>
                                </div>
                              
                            <div class="table-responsive mt-4">
                                <table class="table table-hover mg-b-0" id="basicExampl">
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
                                   
                                    @foreach($item->supplierInvoiceBatches as $items)
                                    <tr>
                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                            <td class="tx-medium">{{ !empty($items->rfqBatch->manufacturer_name) ? $items->rfqBatch->manufacturer_name : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($items->rfqBatch->model_number) ? $items->rfqBatch->model_number : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($items->rfqBatch->component_name) ? $items->rfqBatch->component_name : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium text-center">{{ !empty($items->rfqBatch->quantity) ? number_format($items->rfqBatch->quantity) : '0' }}</td>
                            <td class="tx-medium text-center">{{ !empty($items->rfqBatch->size) ? number_format($items->rfqBatch->size) : '0' }}</td>
                            <td class="tx-medium">{{ !empty($items->rfqBatch->unit_of_measurement) ? $items->rfqBatch->unit_of_measurement : 'UNAVAILABLE' }}</td>
                            <td class="text-center">
                              @if(!empty($items->rfqBatch->image))
                              <a href="#rfqImageDetails" data-toggle="modal" class="text-info" title="View {{ $items->rfqBatch->component_name }} image" data-batch-number="{{ $items->rfqBatch->id }}" data-url="{{ route('cse.rfq_details_image', ['image'=>$items->rfqBatch->id, 'locale'=>app()->getLocale()]) }}" id="rfq-image-details"> View</a>
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
                            </div>--}}<!-- table-responsive -->