<h3>New RFQ</h3>
                        <section>
                        <p class="mg-b-0">A request for quotation is a business process in which a company or public entity requests a quote from a supplier for the purchase of specific products or services.</p>
                           
                         
                        @if(!empty($causalAgent))
                            
                            @if($causalTechnician != '0')
                            <h4 id="section1" class="mt-4 mb-2">Initiate RFQ if only SUPPLIER is a causal agent!</h4>
                            @else 
                            <h4 id="section1" class="mt-4 mb-2">Initiate RFQ?</h4>
                            @endif
                            @else 
                             <h4 id="section1" class="mt-4 mb-2">Initiate RFQ?</h4>
                             @endif 
                        


                            <div class="form-row mt-4">
                                <div class="form-group col-md-4">
                                    <div class="custom-control custom-radio">
                                    @if(!empty($causalAgent))
                                        <input type="radio" class="custom-control-input" id="rfqYes" name="intiate_rfq" value="yes"
                                    {{$causalTechnician != 0? 'disabled': '' }}
                                     >
                                     @else 
                                     <input type="radio" class="custom-control-input" id="rfqYes" name="intiate_rfq" value="yes">
                                     @endif 
                                   
                                        <label class="custom-control-label" for="rfqYes">Yes</label><br>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 d-flex align-items-end">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="rfqNo" name="intiate_rfq" value="no" checked>
                                        <label class="custom-control-label" for="rfqNo">No</label><br>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none d-rfq">
                            <small class="text-danger">This portion will display only if the CSE initially executed a RFQ, the Client paid for the components and the Supplier has made the delivery.</small>
                           
                   
                    @if(!empty($suppliers->rfqSuppliesInvoices))
                    <div class="divider-text initial-supplier">Initial Supplier </div>
                    <h4 id="section1" class="mt-4 mb-2 initial-supplier">Initiate RFQ To Initial Supplier?</h4>
                    <ul class="list-group wd-md-100p initial-supplier">
                              
                                @foreach($suppliers->rfqSuppliesInvoices as $item)
                                @if($item->accepted == 'Yes')
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
                                                                        <a href="tel:08124483438" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                                    </div>
                                                <div class="form-group col-1 col-md-1 col-sm-1">
                                                        <div class="custom-control custom-radio mt-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="checkbox" class="custom-control-input old-supplier" id="initial_supplier" name="supplier_id[]" value="{{$item->warranty_claim_supplier->user_id}}">
                                                                <input type="hidden" class="custom-control-input" id="add_inital_supplier" name="initial_supplier[]" value="{{$item->warranty_claim_supplier->user_id}}">
                                                                <input type="hidden" class="custom-control-input" id="" name="supplier_email" value="{{$item->warranty_claim_supplier->user->email}}">
                                                                <input type="hidden" class="custom-control-input" id="" name="supplier_fname" value="{{$item->warranty_claim_supplier->user->account->first_name}}">
                                                                <input type="hidden" class="custom-control-input" id="" name="supplier_lname" value="{{$item->warranty_claim_supplier->user->account->last_name}}">


                                                                <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                </div>
                                            </div>
                                            </li>
                                            @endif    
                                            @endforeach
                                            @endif
                                        </ul>
                                 
     
                            
                            <h4 id="section1" class="mt-4 mb-2 other-supplier">Initiate RFQ To Other Supplier?</h4>
                             <div class="form-row mt-4 other-supplier">
                                <div class="form-group col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input type="checkbox" class="custom-control-input new-supplier"  name="new_supplier_id" value="all" 
                                     
                                         >
                                        <label class="custom-control-label" for="">Yes</label><br>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="initial-suppliers d-none">
                            @if(!empty($suppliers))
                            @include('cse.warranties.includes.make_request')
                            @endif  
                            </div>

                            <div class="other-suppliers d-none">
                            @include('cse.warranties.includes.make_new_request')
                            </div>
                            
                              @if(!empty($suppliers->rfqSuppliesInvoices))
                             
                              @foreach($suppliers->rfqSuppliesInvoices as $item)
                              @if($item->accepted == 'Pending')
                            
                              @include('cse.warranties.includes.suppliers_contact')
                          
                            @endif    
                            @endforeach
                           <input type="hidden" value="{{$suppliers->id}}" name="rfq_id">
                        @endif
                            </div><!-- end the d-none -->
                        
                        </section>