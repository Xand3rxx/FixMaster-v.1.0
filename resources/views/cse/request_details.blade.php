@extends('layouts.dashboard')
@section('title', 'Request Details')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('cse.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cse.requests.index', app()->getLocale()) }}">Requests</a></li>
              <li class="breadcrumb-item active" aria-current="page">Request Details</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Job: REF-234234723</h4><hr>
          <div class="media align-items-center">
            <span class="tx-color-03 d-none d-sm-block">
              {{-- <i data-feather="credit-card" class="wd-60 ht-60"></i> --}}
              <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar rounded-circle" alt="Male Avatar">
            </span>
            <div class="media-body mg-sm-l-20">
              <h4 class="tx-18 tx-sm-20 mg-b-2">Kelvin Adesanya</h4>
              <p class="tx-13 tx-color-03 mg-b-0">08173682832</p>
            </div>
          </div><!-- media -->
        </div>
      </div>
     
      <div class="row row-xs">
        <div class="col-lg-12 col-xl-12">
          <div class="card">
            <ul class="nav nav-tabs nav-justified" id="myTab3" role="tablist">

              <li class="nav-item">
                <a class="nav-link active" id="update-tab3" data-toggle="tab" href="#update3" role="tab" aria-controls="update" aria-selected="true">Service Request Actions</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" id="description-tab3" data-toggle="tab" href="#description3" role="tab" aria-controls="description" aria-selected="true">Description</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" id="media-tab3" data-toggle="tab" href="#media3" role="tab" aria-controls="media" aria-selected="false">Service Request Summary</a>
              </li>
            </ul>
              <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent3">

                <div class="tab-pane fade show active" id="update3" role="tabpanel" aria-labelledby="update-tab3">
                  <small class="text-danger">This tab is only visible once the Service request has an Ongoing status. Which logically is updated by the system or the CSE Coordinator by assigning a CSE to the request</small>

                  <form method="POST" action="">
                    @csrf
                    
                    <div class="form-row mt-4">
                      <div class="tx-13 mg-b-25">
                        <div id="wizard3">

                          <h3>Assign Technician</h3>
                          <section>
                            <div class="form-row mt-4">
                              <div class="form-group col-md-12">
                                <label for="name">Assign Technician</label>
                                <select class="form-control custom-select @error('user_id') is-invalid @enderror" name="user_id">
                                    <option value="" selected>Select...</option>
                                    <option value="">Jamal Diwa</option>
                                    <option value="">Andrew Nwankwo</option>
                                    <option value="">Taofeek Adedokun</option>
                                </select>
                                @error('user_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                            </div>
                          </section>

                          <h3>Project Progress</h3>
                          <section>
                            <p class="mg-b-0">Specify the current progress of the job.</p>
                            <div class="form-row mt-4">
                              <div class="form-group col-md-12">
                                  {{-- This portion will display only Ongoing Status Sub statuses<br> --}}

                                <select class="form-control custom-select @error('sub_status_id') is-invalid @enderror" name="sub_status_id">
                                  <option value="">Select...</option>
                                  @foreach($ongoingSubStatuses as $status)
                                    {{-- @if($status->id > 6) --}}
                                      <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    {{-- @endif --}}
                                  @endforeach
                                </select>
                                @error('sub_status_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                            </div>
                          </section>

                          <h3>Project Cost Estimate</h3>
                          <section>
                            
                            <small class="text-danger">This portion will be displayed only if the CSE selects "Completed Diganosis" and the Client chooses to continue with the Service Request</small>
                            
                            
                            <div class="mt-4 form-row">
                              
        
                              <div class="form-group col-md-4">
                                <label for="estimated_hours">Estimated Work Hours</label>
                                <select class="form-control custom-select @error('proceed') is-invalid @enderror" name="proceed">
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

                              <div class="form-group col-md-4">
                                <label for="estimated_hours">Warranty</label>
                                <select class="form-control custom-select @error('proceed') is-invalid @enderror" name="proceed">
                                    <option value="" selected>Select...</option>
                                    @foreach($warranties as $warranty)
                                <option value="{{ $warranty->id }}">{{ $warranty->name }}({{$warranty->percentage}}%)</option>
                                    @endforeach
                                </select>
                                @error('estimated_hours')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>

                              <div class="form-group col-md-4">
                                <label for="estimated_hours">Computer & Laptop Sub-Services</label>
                                <select class="form-control custom-select @error('sub_service_id') is-invalid @enderror" name="sub_service_id">
                                    <option value="" selected>Select...</option>
                                    <option value="1">Motherboard</option>
                                    <option value="2">Keyboards</option>
                                    <option value="3">Monitors & Screens</option>
                                </select>
                                @error('sub_service_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                            </div>

                          </section>

                          <h3>Material Acceptance</h3>
                          <section>

                            This portion will display only if the CSE initially executed a RFQ, the Client paid for the components and the Supplier has made the delivery.

                              <div class="mt-4 form-row">
                                <div class="form-group col-md-4">
                                  <label for="name">Supplier's Name</label>
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" name="name">
                                  @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
          
                                <div class="form-group col-md-4">
                                  <label for="devlivery_fee">Delivery Fee</label>
                                  <input type="tel" class="form-control amount @error('devlivery_fee') is-invalid @enderror" id="devlivery_fee" name="devlivery_fee" value="{{ old('devlivery_fee') }}">
                                  @error('devlivery_fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                  
                                <div class="form-group col-md-4">
                                  <label for="delivery_time">Delivery Time</label>
                                <input type="text" min="{{ \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm') }}" class="form-control @error('delivery_time') is-invalid @enderror" name="delivery_time" id="service-date-time" value="{{ old('delivery_time') }}" readonly>
                                  @error('delivery_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>
  
                              <div class="form-row">
                                  <div class="form-group col-md-4">
                                    <label for="component_name">Component Name</label>
                                    <input type="text" class="form-control" id="component_name" name="component_name" value="{{ old('component_name') }}" readonly>
                                  </div>
                    
                                  <div class="form-group col-md-3">
                                    <label for="model_number">Model Number</label>
                                    <input type="text" class="form-control" id="model_number" name="model_number" value="{{ old('model_number') }}" readonly>
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity[]" value="{{ old('quantity') }}" min="" max="" readonly>
                                  </div>
                                  <div class="form-group col-md-3">
                                    <label for="amount">Amount</label>
                                    <input type="tel" class="form-control amount" id="amount" placeholder="" value="{{ old('amount') }}" name="amount[]" autocomplete="off">
                                  </div>
                              </div>

                              <h5>Accept Materials Delivery</h5>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="accepted">Accept Delivery</label>
                                  <select class="form-control custom-select" id="accepted" name="accepted">
                                    <option value="" selected>Select...</option>
                                    <option value="Yes" value="{{ old('Yes') }}" {{ old('accepted') == 'Yes' ? 'selected' : ''}}>Yes, all ordered components were delivered</option>
                                    <option value="No" value="{{ old('No') }}" {{ old('accepted') == 'No' ? 'selected' : ''}}>No, all ordered components were not delivered</option>
                                </select>
                                @error('accepted')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                                </div>
                              </div>
                            {{-- </div> --}}

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
                                      <label for="component_name">Component Name</label>
                                      <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name') }}">
                                      @error('component_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    </div>
                      
                                    <div class="form-group col-md-3">
                                      <label for="model_number">Model Number</label>
                                      <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number') }}">
                                      @error('model_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    </div>
            
                                    <div class="form-group col-md-2">
                                      <label for="quantity">Quantity</label>
                                      <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="\d*" maxlength="2" value="{{ old('quantity') }}">
                                      @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    </div>
            
                                    <div class="form-group col-md-1 mt-1">
                                        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5" ></i></button>
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
                                          <select class="form-control custom-select @error('tool_id') is-invalid @enderror tool_id" id="tool_id" name="tool_id[]" >
                                              <option value="" selected>Select...</option>
                                              @foreach($tools as $tool)
                                                <option value="{{ $tool->uuid }}" {{ old('tool_id') == $tool->uuid ? 'selected' : ''}} data-id="tool_quantity">{{ $tool->name }}</option>
                                              @endforeach
                                          </select>
                                          @error('tool_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                          @enderror
                                        </div>
                          
                                        <div class="form-group quantity-section col-md-2">
                                          <label for="tool_quantity">Quantity</label>
                                          <input type="number" class="form-control @error('tool_quantity') is-invalid @enderror tool_quantity" name="tool_quantity[]" id="tool_quantity" min="1" pattern="\d*" maxlength="2" value="{{ old('tool_quantity') }}">
                                          @error('tool_quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                          @enderror
                                        </div>
                                        <div class="form-group col-md-2 mt-1">
                                            <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-trf" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5" ></i></button>
                                        </div>
                                    </div>
            
                                    <span class="add-trf-row"></span>
            
                                </div>
                          </section>

                          <h3>Assign Additional Technician</h3>
                          <section>
                            <div class="form-group col-md-12">
                              <label for="name">Assign Technician</label>
                              <select class="form-control custom-select @error('user_id') is-invalid @enderror" name="user_id">
                                  <option value="" selected>Select...</option>
                                  <option value="">Jamal Diwa</option>
                                  <option value="">Andrew Nwankwo</option>
                                  <option value="">Taofeek Adedokun</option>
                              </select>
                              @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </section>
                        </div>
                      </div>
                    </div><!-- df-example -->

                    <button type="submit" class="btn btn-primary d-none" id="update-progress">Update Progress</button>

                  </form>

                </div>
                
                <div class="tab-pane fade" id="description3" role="tabpanel" aria-labelledby="description-tab3">

                  <div class="divider-text">Service Request Description</div>

                  <h6>SERVICE REQUEST DESCRIPTION</h6>
                  <div class="row row-xs mt-4">
                    <div class="col-lg-12 col-xl-12">
                      <table class="table table-striped table-sm mg-b-0">
                        <tbody>
                          <tr>
                            <td class="tx-medium">Job Reference</td>
                            <td class="tx-color-03">REF-234234723</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Service Required</td>
                            <td class="tx-color-03">Eletronics (Computer & Laptops)</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Scheduled Date & Time</td>
                            <td class="tx-color-03">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:a') }}</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Payment Status</td>
                            <td class="tx-color-03"><span class="text-success">Success</span>(Paystack or Flutterwave or E-Wallet or Offline)</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Initial Service Charge</td>
                            <td class="tx-color-03">₦{{ number_format(10000) }} Standard Price</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Total Service Charge</td>
                            <td class="tx-color-03">₦{{ number_format(15000) }}</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Security Code</td>
                            <td class="tx-color-03">SEC-27AEC73E</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Supervised By</td>
                            <td class="tx-color-03">David Akinsola</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">CSE's Assigned</td>
                            <td class="tx-color-03">List all CSE's assigned</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Technicians Assigned</td>
                            <td class="tx-color-03">List all Technicians's assigned</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Quality Assurance Managers Assigned</td>
                            <td class="tx-color-03">List all QA's assigned</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">State</td>
                            <td class="tx-color-03">Lagos</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">L.G.A</td>
                            <td class="tx-color-03">Eti-Osa</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Town/City</td>
                            <td class="tx-color-03">Ikoyi</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Request Address</td>
                            <td class="tx-color-03">27B, Bourdillon Road off Falomo, Ikoyi-Lagos.</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Request Description</td>
                            <td class="tx-color-03">My pc no longer comes on even when plugged into a power source.</td>
                          </tr>

                          <tr>
                            <td class="tx-medium">Reason for Cancellation </td>
                            <td class="tx-color-03">I'm no longer interested. <span class="text-danger">(Only visible if the request was cancelled)</span></td>
                          </tr>
                        </tbody>
                      </table>

                      {{-- @if(!empty($requestDetail->serviceRequestDetail->media_file)) --}}
                      <div class="divider-text">Media Files</div>
                        <div class="row">
                          <div class="pd-20 pd-lg-25 pd-xl-30">
                
                            <div class="row row-xs">
                              <div class="col-6 col-sm-6 col-md-6 col-xl mg-t-10 mg-sm-t-0">
                                <div class="card card-file">
                              
                                  
                                  {{-- Media file design will come in here afterwrds --}}
                                  <div class="placeholder-media wd-100p wd-sm-55p wd-md-45p">
                                    <div class="line"></div>
                                  </div>
                                </div>
                              </div><!-- col -->
                              
                            </div><!-- row -->
                            
                          </div>
                        </div>
                      {{-- @endif --}}
                    </div><!-- df-example -->
                  </div>
                </div>

                <div class="tab-pane fade" id="media3" role="tabpanel" aria-labelledby="media-tab3">
                  <h5 class="mt-4 text-primary">Service Request Progress</h5>
                  <div class="table-responsive mb-4">
                    <table class="table table-hover mg-b-0">
                      <thead class="">
                        <tr>
                          <th class="text-center">#</th>
                          <th>Author</th>
                          <th>Status</th>
                          <th class="text-center">Timestamp</th>
                        </tr>
                      </thead>
                      <tbody>
                    
                          <tr>
                            <td class="tx-color-03 tx-center">1</td>
                            <td class="tx-medium">David Akinsola (CSE)</td>
                            <td class="tx-medium text-success">Enroute to Client's house</td>
                            <td class="text-center">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                          </tr>
                      </tbody>
                    </table>
                  </div><!-- table-responsive -->

                  <h5 class="mt-4 text-primary">Tool Requests</h5>
                  <div class="table-responsive mb-4">
                    <table class="table table-hover mg-b-0">
                      <thead class="">
                        <tr>
                          <th class="text-center">#</th>
                          <th>Batch Number</th>
                          <th>Client</th>
                          <th>Approved By</th>
                          <th>Requested By</th>
                          <th>Status</th>
                          <th>Date Requested</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        @php  $z = 0; @endphp
                        <tr>
                          <td class="tx-color-03 tx-center">{{ ++$z }}</td>
                          <td class="tx-medium">TRF-C85BEA04</td>
                          <td class="tx-medium">Kelvin Adesanya</td>
                          <td class="tx-medium">Charles Famoriyo</td>
                          <td class="tx-medium">David Akinsola (CSE)</td>
                          <td class="text-medium text-success">Approved</td>
                         
                          <td class="text-medium">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                          <td class=" text-center">
                            <a href="#toolsRequestDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View TRF-C85BEA04 details" data-batch-number="TRF-C85BEA04" data-url="#" id="tool-request-details">Details</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div><!-- table-responsive -->


                  <h5 class="mt-4 text-primary">Request For Quotation</h5>
                  <div class="table-responsive">
                  
                    <table class="table table-hover mg-b-0 mt-4">
                      <thead class="">
                        <tr>
                          <th class="text-center">#</th>
                          <th>Batch Number</th>
                          <th>Client</th>
                          <th>Issued By</th>
                          <th>Status</th>
                          <th class="text-center">Total Amount</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php  $y = 0; @endphp
                        <tr>
                          <td class="tx-color-03 tx-center">{{ ++$y }}</td>
                          <td class="tx-medium">RFQ-C85BEA04 </td>
                          <td class="tx-medium">Kelvin Adesanya</td>
                          <td class="tx-medium">David Akinsola</td>
                          <td class="text-medium text-success">Payment received</td>
                          <td class="tx-medium text-center">₦{{ number_format(5000) ?? 'Null'}}</td>
                          <td class="text-medium">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                          <td class=" text-center">
                            <a href="#rfqDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View RFQ-C85BEA04 details" data-batch-number="RFQ-C85BEA04" data-url="#" id="rfq-details"></i> Details</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div><!-- table-responsive -->
                </div>

                
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="toolsRequestDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Tools Request</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body">
        <!-- Modal displays here -->
        <div id="spinner-icon"></div>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rfqDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">RFQ Details</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body-rfq-details">
          <!-- Modal displays here -->
          <div id="spinner-icon"></div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  $(function(){
    'use strict'

    $('#wizard3').steps({
      headerTag: 'h3',
      bodyTag: 'section',
      autoFocus: true,
      titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
      loadingTemplate: '<span class="spinner"></span> #text#',
      labels: {
          // current: "current step:",
          // pagination: "Pagination",
          finish: "Update Job Progress",
          // next: "Next",
          // previous: "Previous",
          loading: "Loading ..."
      },
      stepsOrientation: 1,
      // transitionEffect: "fade",
      // transitionEffectSpeed: 200,
      showFinishButtonAlways: false,
      onFinished: function (event, currentIndex) {
        $('#update-progress').trigger('click');
      },
    });

    let count = 1;

    //Add and Remove Request for 
    $(document).on('click', '.add-rfq', function(){
        count++;
        addRFQ(count);
    });

    $(document).on('click', '.remove-rfq', function(){
        count--;
        $(this).closest(".remove-rfq-row").remove();
        // $(this).closest('tr').remove();
    });

    //Add and Remove Tools request form
    $(document).on('click', '.add-trf', function(){
        count++;
        addTRF(count);
    });

    $(document).on('click', '.remove-trf', function(){
        count--;
        $(this).closest(".remove-trf-row").remove();
    });

    //Hide and Unhide Work Experience form
    $('#work_experience_yes').change(function () {
        if ($(this).prop('checked')) {
            $('.previous-employment').removeClass('d-none');    
        }
    });

    $('#work_experience_no').change(function () {
        if ($(this).prop('checked')) {
            $('.previous-employment').addClass('d-none');    
        }
    });

    //Hide and Unhide RFQ
    $('#rfqYes').change(function () {
        if ($(this).prop('checked')) {
            $('.d-rfq').removeClass('d-none');    
        }
    });

    $('#rfqNo').change(function () {
        if ($(this).prop('checked')) {
            $('.d-rfq').addClass('d-none');    
        }
    });

    //Hide and Unhide TRF
    $('#trfYes').change(function () {
        if ($(this).prop('checked')) {
            $('.d-trf').removeClass('d-none');    
        }
    });

    $('#trfNo').change(function () {
        if ($(this).prop('checked')) {
            $('.d-trf').addClass('d-none');    
        }
    });

    $(document).on('click', '#tool-request-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-body').modal("show");
              $('#modal-body').html('');
              $('#modal-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $(document).on('click', '#rfq-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-body-rfq-details').modal("show");
              $('#modal-body-rfq-details').html('');
              $('#modal-body-rfq-details').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $('.close').click(function (){
      $(".modal-backdrop").remove();
    });

  });

  function addRFQ(count){

    let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="component_name">Component Name</label> <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name') }}"> @error('component_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label for="model_number">Model Number</label> <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number') }}"> @error('model_number') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="quantity">Quantity</label> <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" placeholder="" value="{{ old('quantity') }}"> @error('quantity') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';

    $('.add-rfq-row').append(html);

  }

  function addTRF(count){

    let html = '<div class="tool-request form-row remove-trf-row"><div class="form-group col-md-4"> <label for="tool_id">Equipment/Tools Name</label> <select class="form-control custom-select @error('tool_id') is-invalid @enderror tool_id" id="tool_id" name="tool_id[]" ><option value="" selected>Select...</option> @foreach($tools as $tool)<option value="{{ $tool->id }}" {{ old('tool_id') == $tool->id ? 'selected' : ''}} data-id="tool_quantity'+count+'">{{ $tool->name }}</option> @endforeach </select> @error('tool_id') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group quantity-section col-md-2"> <label for="tool_quantity">Quantity</label> <input type="number" class="form-control @error('tool_quantity') is-invalid @enderror tool_quantity" name="tool_quantity[]" id="tool_quantity'+count+'" min="1" pattern="\d*" maxlength="2" value="{{ old('tool_quantity') }}"> @error('tool_quantity') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-trf" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i> </button></div></div>';

    $('.add-trf-row').append(html);

  }

  //Get available quantity of a particular tool.
  $(document).on('change', '.tool_id', function () {
      let toolId = $(this).find('option:selected').val();
      let toolName = $(this).children('option:selected').text();
      let quantityName = $(this).children('option:selected').data('id'); 
      
      $.ajax({
          url: "{{ route('available_quantity', app()->getLocale()) }}",
          method: "POST",
          dataType: "JSON",
          data: {"_token": "{{ csrf_token() }}", "tool_id":toolId},
          success: function(data){
              if(data){
                
                  $('#'+quantityName+'').attr({
                    "value": data,
                    "max": data,
                  });
                 
              }else{
                  var message = 'Error occured while trying to get '+ toolName +' available quantity';
                  var type = 'error';
                  displayMessage(message, type);
              }
          },
      })  
  });

</script>
@endpush

@endsection