@extends('layouts.dashboard')
@section('title', 'Warranty Claim Details')
@include('layouts.partials._messages')
@section('content')
<style>
.card-groups > .card {
    margin-bottom: 15px !important;
}
.card-file-thumb{
    background-repeat: no-repeat;
    background-size: 100% 220px;
}

.custom-control-input {
    position: absolute;
     z-index: 200 !important;;
     opacity: 0; 
    left:10px
}
</style>
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('cse.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cse.warranty_claims', app()->getLocale()) }}">Warranty Claims</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Warranty Claim Details</li>
                    </ol>
                </nav>
       
               

                
                
            </div>
        </div>

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12">

                <div class="divider-text">Warranty Claim Modality</div>

                <div class="media align-items-center">
                    <span class="tx-color-03 d-none d-sm-block">
                        {{-- <i data-feather="credit-card" class="wd-60 ht-60"></i> --}}
                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar rounded-circle" alt="Male Avatar">
                    </span>
                    <div class="media-body mg-sm-l-20">
                        <h4 class="tx-18 tx-sm-20 mg-b-2">{{ucfirst($service_request->client->account->first_name)}}
                            {{ucfirst($service_request->client->account->last_name)}} 
                            <a href="tel:{{$service_request->client->account->contact->phone_number}}" class="btn btn-sm btn-primary btn-icon" title="Call Client "><i class="fas fa-phone"></i> </a>

                            {{-- <a href="#" class="btn btn-sm btn-success btn-icon" title="Notify Client to schedule date"><i class="fas fa-bell"></i> </a> --}}
                        </h4>
                                        
                        <p class="tx-13 tx-color-03 mg-b-0">Scheduled Fix Date: {{$shcedule_datetime != ''? 
                            Carbon\Carbon::parse($shcedule_datetime, 'UTC')->isoFormat('MMMM Do YYYY'):'UNAVAILABLE'}} </p>
                        <p class="tx-13 tx-color-03 mg-b-0">Job Ref.: {{$service_request->unique_id}} </p>
                    </div>
                </div><!-- media -->

                <div class="contact-content-header mt-4">
                    <nav class="nav">
                 
                    @if(Auth::user()->type->url != 'admin')                    
                        <a href="#serviceRequestActions" class="nav-link active" data-toggle="tab">Actions</a>
                        @endif
                    

                    
                    @if(Auth::user()->type->url == 'admin') 
                         <a href="#contactCollaborators" class="nav-link active" data-toggle="tab"><span>Contact Collaborators</a>
                        @else
                    <a href="#contactCollaborators" class="nav-link" data-toggle="tab"><span>Contact Collaborators</a>

                        @endif

                       
                      
                        <a href="#description" class="nav-link" data-toggle="tab"><span> Description</a>
                        <a href="#serviceRequestSummary" class="nav-link" data-toggle="tab"><span>Summary</a>
                    </nav>
                    {{-- <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a> --}}
                </div><!-- contact-content-header -->

                <div class="contact-content-body">
                    <div class="tab-content">

                    
                    @if(Auth::user()->type->url != 'admin') 
                    <div id="serviceRequestActions" class="tab-pane show active pd-20 pd-xl-25">
                                                        
                

                            <small class="text-danger">This tab is only visible once if a Warranty claim has not been marked as resolved or is still ongoing.</small>
                           {{-- {{  dd($technicians) }} --}}
  
     @if($service_request->service_request_warranty->has_been_attended_to != 'Yes')
        <form class="form-data" method="POST" action="{{route('cse.assign.warranty_technician', [app()->getLocale()])}}"  enctype="multipart/form-data">
            @csrf
            <div class="mt-4">
                <div class="tx-13 mg-b-25">
                    <div id="wizard3">

                

                        <h3>Report</h3>
                        <section>
                            <div class="mt-4 form-row">
                                <div class="form-group col-md-12">
                                    <label for="cse_comment">Diagnostic Report</label>
                                    <textarea rows="3" class="form-control @error('cse_comment ') is-invalid @enderror" id="cse_comment " name="cse_comment"></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <label>Faulty Image</label>
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input @error('image[0]') is-invalid @enderror" name="upload_image[]" id="image">
                                        <label class="custom-file-label" for="image">Upload faulty parts image</label>
                                        @error('image[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-1 mt-1">
                                    <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-image" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                                </div>
                            </div>

                            <span class="add-image-row"></span>

                        </section>
                    
                        @if($shcedule_datetime=='' || is_null($shcedule_datetime))
                        <h3>Scheduled Fix Date </h3>
                        <section>
                        
                            <div class="mt-4 form-row">
                                <div class="form-group col-md-12">
                                    <label for="preferred_time">Scheduled Fix Date</label> <span style="color:red">(required)</span>
                                    <input id="service-date-time" type="text" readonly min="{{ \Carbon\Carbon::now()->isoFormat('2021-04-13') }}" class="form-control @error('preferred_time') is-invalid @enderror"
                                     name="preferred_time"
                                      placeholder="Click to Enter Scheduled Date & Time" value="{{ old('preferred_time') }}">
                                    
                                    @error('preferred_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </section>
                         @endif 
                       
                       @if(empty($causalAgent) || $causalAgent->isEmpty())
                         <h3>Indicate Causal Agent</h3>
                         <section>
                             <div class="form-row mt-4">
                                 <div class="form-group col-md-12">
                                 @include('cse.warranties.includes.causal_agent')
                                   
                                 </div>
                             </div>
                         </section>
                         @endif 

                         @if(count($RfqDispatchNotification) < 1)
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
                    <div class="divider-text">Initial Supplier </div>
                    <h4 id="section1" class="mt-4 mb-2">Initiate RFQ To Initial Supplier?</h4>
                    <ul class="list-group wd-md-100p">
                              
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
                                 
     
                            
                            <h4 id="section1" class="mt-4 mb-2">Initiate RFQ To Other Supplier?</h4>
                             <div class="form-row mt-4">
                                <div class="form-group col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input type="checkbox" class="custom-control-input new-supplier"  name="new_supplier_id" value="all" 
                                     
                                         >
                                        <label class="custom-control-label" for="">Yes</label><br>
                                    </div>
                                </div>
                                
                            </div>

                            @if(!empty($suppliers))
                            @include('cse.warranties.includes.make_request')
                            @endif  
                            
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
                        @endif
                        



                    
                        @if(!is_null($rfqDetails))
                        @if(count($rfqDetails) > 0 )
            
                        @include('cse.warranties.includes.select_supplier_quote')
                       
                        @endif
                        @endif
                     
                         
                      
                        @if(!is_null($rfqDetails))
                        @if(count($rfqSupplierDispatch)> 0)
                       
                        <h3>Material Acceptance</h3>
                        <section>
                        <small class="text-danger">This portion will display only if the CSE initially executed a RFQ, the Client paid for the components and the Supplier has made the delivery.</small>

                        @include('cse.warranties.includes.material_acceptance')
                        </section>
                      
                        @endif
                        @endif
                     
                     
                         
                         @if(is_null($technicianExist))
                        <h3>Assign Job To Technician</h3>
                        <section>
                            <div class="form-row mt-4">
                                <div class="form-group col-md-12">
                                    <ul class="list-group wd-md-100p">
                                    @include('cse.warranties.includes.assign_new_technician')  
                                    </ul>
                                </div>
                            </div>
                        </section>
                        @endif
        
        
                    </div>
                </div>
            </div><!-- df-example -->
        
            <input type="hidden" value="{{$shcedule_datetime}}" 
            name="service_request_warrant_issued_schedule_date">   
         
          

            <input type="hidden" value="{{$service_request->id}}" name="service_request_id">
            <input type="hidden" value="{{$service_request->unique_id}}" name="service_request_unique_id">
            <input type="hidden" value="{{$service_request->service_request_warranty->uuid}}" name="service_request_warranty_uuid">
            <input type="hidden" value="{{$service_request->service_request_warranty->id}}" name="service_request_warranty_id">
            <input type="hidden" value="{{$service_request->service_request_warranty->id}}" name="service_request_warranty_id">


            <button type="submit" class="btn btn-primary d-none" id="update-progress">Update Progress</button>
        
        </form>
        @else
        <small class="text-danger">This tab is only visible once a Warranty claim has been marked as resolved.</small>
        <h4> This Warranty Claim has been resolved. </h4>
        @endif
                        
        </div>
        @endif

                       
                        @include('cse.warranties.includes.collaborators')

                                                   
                        <div id="description" class="tab-pane pd-20 pd-xl-25">

                            <div class="divider-text">Warranty Claim  Description</div>

                            <h6>Warranty Claim Description</h6>
                            <div class="row row-xs mt-4">
                                <div class="col-lg-12 col-xl-12">
                                @include('cse.warranties.includes.description')
                                    
                            </div>
                        </div>


                        @include('cse.warranties.includes.summary')                       

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{{--@include('cse.warranties.includes.rfq_details_modal')--}}

@include('cse.requests.includes.scripts')
  
@push('scripts')
<script src="{{ asset('assets/dashboard/assets/js/cse/1e65edf0-c8e5-432c-8bbf-a7ed7847990f.js') }}"></script>
<script>

function addRFQ(count){
    let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="manufacturer_name">Manufacturer Name</label> <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror" id="manufacturer_name" name="manufacturer_name[]" value="{{ old('manufacturer_name[]') }}"> @error('manufacturer_name[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label for="model_number">Model Number</label> <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number[]') }}"> @error('model_number[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-4"> <label for="component_name">Component Name</label> <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name[]') }}"> @error('component_name[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="quantity">Quantity</label> <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="d*" maxlength="2" value="{{ old('quantity[]') }}"> @error('quantity[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="size">Size</label> <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size[]" min="1" pattern="d*" maxlength="2" value="{{ old('size[]') }}"> @error('size[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-4"> <label for="unit_of_measurement">Unit of Measurement</label> <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror" id="unit_of_measurement" name="unit_of_measurement[]" value="{{ old('unit_of_measurement[0]') }}"> @error('unit_of_measurement[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label>Image</label><div class="custom-file"> <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image[]" id="image"> <label class="custom-file-label" for="image">Component Image</label> @error('image[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="form-group col-md-1 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';

    $('.add-rfq-row').append(html);
}

function newImageRow(count){
    let html = '<div class="form-row remove-image-row"><div class="form-group col-md-11"> <label>Faulty Image</label><div class="custom-file"> <input type="file" accept="image/*" class="custom-file-input @error('image[]') is-invalid @enderror" name="upload_image[]" id="image"> <label class="custom-file-label imgx" for="image">Upload faulty parts image</label> @error('image[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="form-group col-md-1 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-image" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';

    $('.add-image-row').append(html);

}


</script>
@endpush

@endsection