<form class="form-data" method="POST" action="{{route('cse.project.progress.update', [app()->getLocale()])}}">
    @csrf
    <div class="mt-4">
        <div class="tx-13 mg-b-25">
            <div id="wizard3">
                @if($latest_service_request_progress->sub_status_id > 12)
                @if($latest_service_request_progress->sub_status_id < 14) 
                <h3>Re-Categorization </h3>
                    <section>
                        
                        <div class="mt-4 form-row">
                            <div class="form-group col-md-6">
                                <label for="category_id">Category</label>
                                <select class="form-control custom-select @error('category_id') is-invalid @enderror" name="category_id">
                                    <option selected disabled value="0" selected>Select Category</option>
                                    @foreach($service_request['service']['subServices'] as $key => $sub_service)
                                    <option value="{{$sub_service['uuid']}}">{{$sub_service['name']}} </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="service_id">Service</label>
                                <select class="form-control custom-select @error('service_id') is-invalid @enderror" name="service_id">
                                    <option selected disabled value="0" selected>Select Service</option>
                                    @foreach($service_request['service']['subServices'] as $key => $sub_service)
                                    <option value="{{$sub_service['uuid']}}">{{$sub_service['name']}} </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12 position-relative">
                                <label for="sub_service_uuid">Sub Service</label>
                                <select class="form-control selectpicker @error('sub_service_uuid') is-invalid @enderror" name="sub_service_uuid" id="sub_service_uuid" multiple>
                                    <option disabled value="">Select Sub service</option>
                                    @foreach($service_request['service']['subServices'] as $key => $sub_service)
                                <option value="{{$sub_service['uuid']}}" data-count="{{ $key }}" data-sub-service-name="{{$sub_service['name']}}">{{$sub_service['name']}} </option>
                                    @endforeach
                                </select>
                                @error('sub_service_uuid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="root_cause">Root Cause <span class="text-danger">*</span></label>
                                <textarea rows="3" class="form-control @error("root_cause") is-invalid @enderror" id="root_cause" name="root_cause"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="other_comments">Other Comments(Optional)</label>
                                <textarea rows="3" class="form-control @error("other_comments") is-invalid @enderror" id="other_comments" name="other_comments"></textarea>
                            </div>
                        </div>

                    </section>

                    <h3>Invoice building</h3>
                    <section>
                        <small class="text-danger">This portion will be displayed only if the CSE selects "Completed Diganosis" and the Client chooses to continue with the Service Request</small>
                        <div class="mt-4 form-row">
                            <div class="form-group col-md-6">
                                <label for="estimated_hours">Estimated Work Hours</label>
                                <select class="form-control custom-select @error('estimated_work_hours') is-invalid @enderror" name="estimated_work_hours">
                                    <option value="" selected>Select...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                @error('estimated_hours')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="category_id">Category</label>
                                <select class="form-control custom-select @error('category_id') is-invalid @enderror" name="category_id">
                                    <option selected disabled value="0" selected>Select Category</option>
                                    @foreach($service_request['service']['subServices'] as $key => $sub_service)
                                    <option value="{{$sub_service['uuid']}}">{{$sub_service['name']}} </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="service_id">Service</label>
                                <select class="form-control custom-select @error('service_id') is-invalid @enderror" name="service_id">
                                    <option selected disabled value="0" selected>Select Service</option>
                                    @foreach($service_request['service']['subServices'] as $key => $sub_service)
                                    <option value="{{$sub_service['uuid']}}">{{$sub_service['name']}} </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 position-relative">
                                <label for="sub_service_uuid">Sub Service</label>
                                <select class="form-control selectpicker @error('sub_service_uuid') is-invalid @enderror" name="sub_service_uuid" id="sub_service_uuid" multiple>
                                    <option disabled value="">Select Sub service</option>
                                    @foreach($service_request['service']['subServices'] as $key => $sub_service)
                                <option value="{{$sub_service['uuid']}}" data-count="{{ $key }}" data-sub-service-name="{{$sub_service['name']}}">{{$sub_service['name']}} </option>
                                    @endforeach
                                </select>
                                @error('sub_service_uuid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <span class="mt-2 sub-service-report"></span>
                        
                    </section>
                    @endif
                    @if($service_request['rfqs']->isNotEmpty())
                    <h3>Material Acceptance</h3>
                    <section>
                        This portion will display only if the CSE initially executed a RFQ, the Client paid for the components and the Supplier has made the delivery.
                        <div class="mt-4 form-row">
                            <div class="form-group col-md-4">
                                <label for="supplier_name">Supplier's Name</label>
                                <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" id="supplier_name" value="{{ $service_request['rfqs'][0]['rfqSupplier']['supplier']['account']['last_name'] .' '.$service_request['rfqs'][0]['rfqSupplier']['supplier']['account']['first_name'] }}" name="supplier_name" readonly>
                                @error('supplier_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="devlivery_fee">Delivery Fee</label>
                                <input type="tel" class="form-control amount @error('devlivery_fee') is-invalid @enderror" id="devlivery_fee" name="devlivery_fee" value="{{ $service_request['rfqs'][0]['rfqSupplier']['devlivery_fee']}}" readonly>
                                @error('devlivery_fee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="delivery_time">Delivery Time</label>
                                <input type="text" min="{{ \Carbon\Carbon::now()->isoFormat('2021-04-07 08:53:12') }}" class="form-control @error('delivery_time') is-invalid @enderror" name="delivery_time" value="{{ $service_request['rfqs'][0]['rfqSupplier']['delivery_time'] }}" readonly>
                                @error('delivery_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @foreach ($service_request['rfqs'][0]['rfqBatches'] as $batch)

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="manufacturer_name">Manufacturer Name</label>
                                <input type="text" class="form-control" id="manufacturer_name" name="manufacturer_name[]" value="{{ $batch['manufacturer_name'] }}" readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="model_number">Model Number</label>
                                <input type="text" class="form-control" id="model_number" name="model_number[]" value="{{ $batch['model_number']}}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="component_name">Component Name</label>
                                <input type="text" class="form-control" id="component_name" name="component_name[]" value="{{ $batch['component_name'] }}" readonly>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity[]" value="{{ $batch['quantity'] }}" min="" max="" readonly>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="size">Size</label>
                                <input type="number" class="form-control" id="size" name="size[]" value="{{ $batch['size'] }}" min="" max="" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="unit_of_measurement">Unit of Measurement</label>
                                <input type="text" class="form-control" id="unit_of_measurement" name="unit_of_measurement[]" value="{{ $batch['unit_of_measurement'] }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="amount">Amount</label>
                                <input type="tel" class="form-control amount" id="amount" placeholder="" value="{{ $batch['amount'] }}" name="amount[]" autocomplete="off" readonly>
                            </div>
                        </div>

                        @endforeach

                        <h5>Accept Materials Delivery</h5>
                        <div class="form-row">
                            {{-- <div class="form-group col-md-6">
                                <label for="accept_materials">Verify Supplier Code</label>
                                <input type="text" class="form-control" id="verify_code" placeholder="e.g DEV-02397432" value="">
                            </div> --}}

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
                        </div>
                    </section>
                    @endif

                    <h3>Material Acceptance</h3>
                    <section>
                        <small class="text-danger">This portion will display only if the CSE initially executed a RFQ, the Client paid for the components and the Supplier has made the delivery.</small>

                        <h5>Update RFQ Status</h5>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="status">Status</label>
                                <select class="form-control custom-select" id="status" name="status">
                                    <option selected disabled value="" selected>Select...</option>
                                    <option value="Awaiting" value="{{ old('Awaiting') }}" {{ old('status') == 'Awaiting' ? 'selected' : ''}}>Awaiting</option>
                                    <option value="Shipped" value="{{ old('Shipped') }}" {{ old('status') == 'Shipped' ? 'selected' : ''}}>Shipped</option>
                                    <option value="Delivered" value="{{ old('Shipped') }}" {{ old('status') == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-striped table-sm mg-b-0">
                              <tbody>
                                
                                <tr>
                                  <td class="tx-medium">Supplier Name</td>
                                  <td class="tx-color-03">Henry Efe <small class="text-muted">(Business Name: IMPACT)</small></td>
                                </tr>
                                <tr>
                                    <td class="tx-medium">Dispatch Status</td>
                                    <td class="text-info">In-Transit</td>
                                </tr>
                                <tr>
                                    <td class="tx-medium">Delivery Status</td>
                                    <td class="text-warning">Pending</td>
                                </tr>
                                <tr>
                                  <td class="tx-medium">Delivery Fee</td>
                                  <td class="tx-color-03">₦{{ number_format(1500) }}</td>
                                </tr>
                                <tr>
                                  <td class="tx-medium">Delivery Time</td>
                                  <td class="tx-color-03">{{ Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                </tr>
                                <tr>
                                  <td class="tx-medium">Grand Total</td>
                                  <td class="tx-color-03">₦{{ number_format(3150) }}</td>
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
                                <tr>
                                    <td class="tx-color-03 tx-center">1</td>
                                    <td class="tx-medium">S-Tek</td>
                                    <td class="tx-medium">PC-234234</td>
                                    <td class="tx-medium">Power cable</td>
                                    <td class="tx-medium text-center">1</td>
                                    <td class="tx-medium text-center">0</td>
                                    <td class="tx-medium">Meters</td>
                                    <td class="text-center">View</td>
                                    <td class="tx-medium text-center">₦{{ number_format(450) }}</td>
                                    <td class="tx-medium text-center">₦{{ number_format(450) }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-color-03 tx-center">2</td>
                                    <td class="tx-medium">Crucial</td>
                                    <td class="tx-medium">RM-3242</td>
                                    <td class="tx-medium">8GB RAM</td>
                                    <td class="tx-medium text-center">2</td>
                                    <td class="tx-medium text-center">0</td>
                                    <td class="tx-medium">Bytes</td>
                                    <td class="text-center">View</td>
                                    <td class="tx-medium text-center">₦{{ number_format(600) }}</td>
                                    <td class="tx-medium text-center">₦{{ number_format(1200) }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div><!-- table-responsive -->

                        
                        
                        <h5>Accept Materials Delivery</h5>
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
                                <textarea rows="3" class="form-control @error("reason") is-invalid @enderror" id="reason" name="reason"></textarea>
                            </div>
                        </div>

                    </section>

                    <h3>New RFQ</h3>
                    <section>
                        <p class="mg-b-0">A request for quotation is a business process in which a company or public entity requests a quote from a supplier for the purchase of specific products or services.</p>
                        <h4 id="section1" class="mt-4 mb-2">Initiate RFQ?</h4>

                        <div class="form-row mt-4">
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="rfqYes" name="intiate_rfq" value="yes">
                                    <label class="custom-control-label" for="rfqYes">Yes</label><br>
                                </div>
                            </div>
                            <div class="form-group col-md-4 d-flex align-items-end">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="rfqNo" name="intiate_rfq" value="no">
                                    <label class="custom-control-label" for="rfqNo">No</label><br>
                                </div>
                            </div>
                        </div>

                        <div class="d-none d-rfq">
                            <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="manufacturer_name">Manufacturer Name</label>
                                    <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror" id="manufacturer_name" name="manufacturer_name[]" value="{{ old('manufacturer_name[0]') }}">
                                    @error('manufacturer_name[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="model_number">Model Number</label>
                                    <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number[0]') }}">
                                    @error('model_number[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="component_name">Component Name</label>
                                    <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name[0]') }}">
                                    @error('component_name[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="\d*" maxlength="2" value="{{ old('quantity[0]') }}">
                                    @error('quantity[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="size">Size</label>
                                    <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size[]" min="1" pattern="\d*" maxlength="2" value="{{ old('size[0]') }}">
                                    @error('size[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="unit_of_measurement">Unit of Measurement</label>
                                    <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror" id="unit_of_measurement" name="unit_of_measurement[]" value="{{ old('unit_of_measurement[0]') }}">
                                    @error('unit_of_measurement[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Image</label>
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image">
                                        <label class="custom-file-label" for="image">Component Image</label>
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-1 mt-1">
                                    <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                                </div>
                            </div>

                            <span class="add-rfq-row"></span>

                        </div>
                    </section>

                    <h3>New Tools Request</h3>
                    <section>
                        <p class="mg-b-0">A request form to procure tools and equipments from <span>FixMaster</span> to properly carry out a Service Request.</p>

                        <h4 id="section1" class="mt-4 mb-2">Initiate Tools Request?</h4>
                        <div class="form-row mt-4 ">
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="trfYes" name="intiate_trf" value="yes">
                                    <label class="custom-control-label" for="trfYes">Yes</label><br>
                                </div>
                            </div>
                            <div class="form-group col-md-4 d-flex align-items-end">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="trfNo" name="intiate_trf" value="no">
                                    <label class="custom-control-label" for="trfNo">No</label><br>
                                </div>
                            </div>
                        </div>

                        <div class="d-none d-trf">
                            <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
                            <div class="form-row tool-request">
                                <div class="form-group col-md-4">
                                    <label for="tool_id">Equipment/Tools Name</label>
                                    <select class="form-control custom-select @error('tool_id') is-invalid @enderror tool_id" id="tool_id" name="tool_id[]">
                                        <option value="" selected>Select...</option>
                                        @foreach($tools as $tool)
                                        <option value="{{ $tool->id }}" {{ old('tool_id[0]') == $tool->id ? 'selected' : ''}} data-id="tool_quantity">{{ $tool->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tool_id[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group quantity-section col-md-2">
                                    <label for="tool_quantity">Quantity</label>
                                    <input type="number" class="form-control @error('tool_quantity[0]') is-invalid @enderror tool_quantity" name="tool_quantity[]" id="tool_quantity" min="1" pattern="\d*" maxlength="2" value="{{ old('tool_quantity[0]') }}">
                                    @error('tool_quantity[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 mt-1">
                                    <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-trf" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                                </div>
                            </div>
                            <span class="add-trf-row"></span>
                        </div>
                    </section>
                    @endif

                    <h3>Request QA</h3>
                    <section>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="qa_user_uuid">Assign QA</label>
                                <select required class="form-control custom-select @error('qa_user_uuid') is-invalid @enderror" name="qa_user_uuid">
                                    <option selected disabled value="0" selected>Select...</option>
                                    @foreach ($qaulity_assurances['users'] as $qaulity_assurance)
                                        <option value="{{ $qaulity_assurance['account']['user_id'] }}">{{ !empty($qaulity_assurance['account']['first_name']) ? Str::title($qaulity_assurance['account']['first_name'] ." ". $qaulity_assurance['account']['last_name']) : 'UNAVAILABLE' }}</option>
                                    @endforeach
                                </select>
                                @error('qa_user_uuid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="assistive_role">Assitive Role</label>
                                <select required class="form-control custom-select @error('assistive_role') is-invalid @enderror" name="assistive_role">
                                    <option selected disabled value="0" selected>Select...</option>
                                    <option value="Consultant">Consultant</option>
                                    <option value="Technician">Technician</option>
                                </select>
                                @error('assistive_role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <h3>Assign New Technician</h3>
                    <section>
                        <div class="form-group col-md-12">
                           
                            <ul class="list-group wd-md-100p">
                                @foreach ($technicains as $technicain)
                                <li class="list-group-item d-flex align-items-center">
                                  
                                 <div class="form-row">
                                    <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                                  
                                  <div class="col-md-6 col-sm-6">
                                    <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{$technicain['user']['account']['first_name'] .' '. $technicain['user']['account']['last_name']}}</h6>
                                    
                                    <span class="d-block tx-11 text-muted">
                                        @foreach ($technicains as $technicain)
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                        @endforeach
                                        <span class="font-weight-bold ml-2">{{ \App\Traits\CalculateDistance::getDistanceBetweenPoints($service_request['client']['contact']['address_latitude'], $service_request['client']['contact']['address_longitude'], $technicain['user']['contact']['address_latitude'], $technicain['user']['contact']['address_longitude']) }}
                                    km</span>
                                    </span>
                                  </div>
                                  <div class="col-md-6 col-sm-6">
                                    <div class="form-row">
                                        <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                            <a href="tel:08124483438" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                        </div>
                                        <div class="form-group col-1 col-md-1 col-sm-1">
                                            <div class="custom-control custom-radio mt-2">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="{{ $loop->iteration }}" name="technician_user_uuid" value="{{ $technicain['user']['uuid'] }}">
                                                    <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>

                    <h3>Project Progress</h3>
                    <section>
                        <p class="mg-b-0">Specify the current progress of the job.</p>
                        <div class="form-row mt-4">
                            <div class="form-group col-md-12">
                                <select required class="form-control custom-select @error('sub_status_uuid') is-invalid @enderror" name="sub_status_uuid">
                                    <option selected disabled value="0">Select...</option>
                                    @foreach($ongoingSubStatuses as $status)
                                    <option value="{{ $status->uuid }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_status_uuid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </section>
            </div>
        </div>
    </div><!-- df-example -->

    <input type="hidden" value="{{$service_request->uuid}}" name="service_request_uuid">

    <button type="submit" class="btn btn-primary d-none" id="update-progress">Update Progress</button>

</form>
