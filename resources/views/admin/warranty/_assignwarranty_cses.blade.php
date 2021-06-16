<form method="POST" action="{{ route('admin.save_assigned_waranty_cse', app()->getLocale()) }}">
        @csrf @method('POST')
          <h5 class="mg-b-2"><strong>Assign Cse </strong></h5>
         
          <div class="form-row mt-4">
            <div class="form-group col-md-12">
              
                <div class="divider-text">Select Cses  </div>
              <div class="form-row">
         
              @if(!empty($users))
              @foreach($users as $cse)
            
          
              <div class="form-group col-md-6">
            <ul class="list-group wd-md-100p">
           <li class="list-group-item d-flex align-items-center">
        
        <div class="form-row">
        <img src="{{ asset('assets/user-avatars/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

        <div class="col-md-6 col-sm-6">
        <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ Str::title($cse['user']['account']['last_name'] ." ". $cse['user']['account']['first_name']) }}</h6>

    
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
          <a href="tel:{{ $cse['user']['contact']['phone_number']}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
      </div>
        <div class="form-group col-1 col-md-1 col-sm-1">
              <div class="custom-control custom-radio mt-2">
                  <div class="custom-control custom-radio">
                  
                  <input type="hidden" class="custom-control-input" id="" name="cse_old" value="{{ $requestDetail->id}}">
                  <input type="hidden" class="custom-control-input" id="" name="service_request_id" value="{{$serviceRequest->service_request_id}}">
                  <input type="hidden" class="custom-control-input" id="" name="warranty_claim_id" value="{{$serviceRequest->id}}">

                      <input type="radio" class="custom-control-input" id="" name="cse" value="{{$cse->user_id}}">
                      <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
                  </div>
              </div>
          </div>
        </div>
        </div>
    </div>
    </li>
 
</ul>
</div><!-- df-example -->

@endforeach
@endif

</div>

              
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Assign</button>
          </div>
        </form>