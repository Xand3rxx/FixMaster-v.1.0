                                
  @if(Auth::user()->type->url != 'admin') 
  <div id="contactCollaborators" class="tab-pane pd-20 pd-xl-25">
                    @else
<div id="contactCollaborators" class="tab-pane show active pd-20 pd-xl-25">
@endif
            
This show's a list of all FixMaster Collaborators that worked on the clients service request initially.
        
    <div class="row row-xs mt-4">
        <div class="col-lg-12 col-xl-12">


        <div class="divider-text">CSE </div>
            @if(!empty($service_request['service_request_assignees']))
            <ul class="list-group wd-md-100p">
            @foreach ($service_request['service_request_assignees'] as $item)
            @if($item['user']['roles'][0]['slug'] == 'cse-user')
                <li class="list-group-item d-flex align-items-center">
                    
                    <div class="form-row">
                    <img src="{{ asset('assets/user-avatars/'.$item->user->account->avatar??'default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

                    <div class="col-md-6 col-sm-6">
                   
                    <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ ucfirst($item->user->account->first_name)}} {{  ucfirst($item->user->account->last_name)}}</h6>

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
                            <a href="tel: {{$item->user->account->contact->phone_number}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
                </li>
                @endif
                @endforeach
            </ul>
            @endif


        <div class="divider-text">Technicians  </div>
        @if(!empty($service_request['service_request_assignees']))
        <ul class="list-group wd-md-100p">
            @foreach ($service_request['service_request_assignees'] as $item)
            @if($item['user']['roles'][0]['slug'] == 'technician-artisans')
           
                      
                <li class="list-group-item d-flex align-items-center">
                    
                    <div class="form-row">
                    <img src="{{ asset('assets/user-avatars/'.$item->user->account->avatar??'default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                    
                    <div class="col-md-6 col-sm-6">
                    <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ ucfirst($item->user->account->first_name)}} {{  ucfirst($item->user->account->last_name)}}</h6>
                    
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
                            <a href="tel:{{$item->user->account->contact->phone_number}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
                </li>
             @endif
                @endforeach
            </ul>
            @endif


         
            @if(!empty($service_request->service_request_warranty->service_request_warranty_issued))
       @if(!is_null($service_request->service_request_warranty->service_request_warranty_issued->technician_id))
            <div class="divider-text">Warrant Technician Assigned  </div>
     
        <ul class="list-group wd-md-100p">
                      
                <li class="list-group-item d-flex align-items-center">
                    
                    <div class="form-row">
                    <img src="{{ asset('assets/user-avatars/'.CustomHelpers::getUserDetail($service_request->service_request_warranty->service_request_warranty_issued->technician_id)->account->avatar??'default-male-avatar.png') }}" 
                    class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                    
                    <div class="col-md-6 col-sm-6">
                    <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">
                    <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ ucfirst(CustomHelpers::getUserDetail($service_request->service_request_warranty->service_request_warranty_issued->technician_id)->account->first_name)}} 
                    {{ ucfirst(CustomHelpers::getUserDetail($service_request->service_request_warranty->service_request_warranty_issued->technician_id)->account->last_name)}} 
                    </h6>

                    
                    </h6>
                    
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
                            <a href="tel:{CustomHelpers::getUserDetail($service_request->service_request_warranty->service_request_warranty_issued->technician_id)->account->contact->phone_number}}" 
                            
                            class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
                </li>
            </ul>
            @endif
            @endif

            <div class="divider-text">Quality Assurance Managers </div>
            @if(!empty($service_request['service_request_assignees']))
            <ul class="list-group wd-md-100p">
            @foreach ($service_request['service_request_assignees'] as $item)
            @if($item['user']['roles'][0]['slug'] == 'quality-assurance-user')
                <li class="list-group-item d-flex align-items-center">
                    
                    <div class="form-row">
                    <img src="{{ asset('assets/user-avatars/'.$item->user->account->avatar??'default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

                    <div class="col-md-6 col-sm-6">
                   
                    <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ ucfirst($item->user->account->first_name)}} {{  ucfirst($item->user->account->last_name)}}</h6>

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
                            <a href="tel: {{$item->user->account->contact->phone_number}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
                </li>
                @endif
                @endforeach
            </ul>
            @endif
          

         
            <div class="divider-text">Suppliers </div>

            <ul class="list-group wd-md-100p">
            @if(!empty($suppliers->rfqSuppliesInvoices))
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

                    </div>
                    </div>
                </div>
                </li>
                @endif    
                @endforeach
                @endif
            </ul>
        </div><!-- df-example -->
    </div>
</div>



