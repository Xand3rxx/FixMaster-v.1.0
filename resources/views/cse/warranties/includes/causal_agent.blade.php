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
                                                 @foreach ($technicians as $item)
                                                     <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                 @endforeach
                                                 <span class="font-weight-bold ml-2">0.6km</span>
                                             </span>
                                             </div>
                                             <div class="col-md-6 col-sm-6">
                                             <div class="form-row">
                                                 <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                                 <a href="tel:{{$item->user->account->contact->phone_number}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                 </div>
                                                 <div class="form-group col-1 col-md-1 col-sm-1">
                                                     <div class="custom-control custom-radio mt-2">
                                                         <div class="custom-control custom-radio">
                                                             <input type="checkbox" class="custom-control-input" id="{{ $loop->iteration }}" name="causal_agent_id[]" value="{{$item->user->id}}">
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
                                                    <a href="tel: {{$item->warranty_claim_supplier->user->account->contact->phone_number}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                </div>

                                                <div class="form-group col-1 col-md-1 col-sm-1">
                                                     <div class="custom-control custom-radio mt-2">
                                                         <div class="custom-control custom-radio">
                                                             <input type="checkbox" class="custom-control-input" id="" name="causal_agent_id[]"  value="{{$item->warranty_claim_supplier->user_id}}">
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

            <div class="divider-text">Causal Reason </div>
            <ul class="list-group wd-md-100p">
            <li class="list-group-item d-flex align-items-center">
                                                <img src="{{ asset('assets/user-avatars/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

                                                <div class="form-group col-11 col-md-11 col-sm-11">
                                                    <label for="causal_reason">Other Reasons </label>
                                                    <textarea rows="3" class="form-control @error('causal_reason ') is-invalid @enderror" id="causal_reason " name="causal_reason"></textarea>
                                                </div>
                                         </li>
                                         </ul>