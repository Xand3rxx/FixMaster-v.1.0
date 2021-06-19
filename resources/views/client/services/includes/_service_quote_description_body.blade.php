<div class="row mt-4">
    @if($displayDescription == 'serviced')
    <div class="col-md-12">
        <div class="form-group position-relative">
            <label>Tell us more about the service you need :</label>
            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="If there is an equipment involved, do tell us about the equipment e.g. the make, model, age of the equipment etc.">{{ old('description') }}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <!--end col-->
    <div class="col-md-12">
        <div class="form-group position-relative">
            <label>Scheduled Date :</label>
            <i data-feather="calendar" class="fea icon-sm icons"></i>
            <input name="preferred_time" type="text" class="form-control pl-5 @error('preferred_time') is-invalid @enderror" placeholder="Click to select :" id="service-date-time" readonly value="{{ old('preferred_time') }}" />
            @error('preferred_time')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <!--end col-->

    <div class="row col-md-12 mb-4">
        <div class="col-md-9">
            <div class="attachments">
                <div class="form-group position-relative custom-file">
                    <label>Upload Media Files (Optional) :</label>
                    <input type="file" name="media_file[]" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_1" accept="image/*,.txt,.doc,.docx,.pdf" />
                    <small class="text-muted text-small">File must not be more than 2MB</small>
                </div> 
            </div> 
        </div><!--end col-->

        <div class="form-group position-relative" style="margin-top: 1.91rem !important;">
            <a class="btn btn-primary btn-sm" id="add-more-file"><i data-feather="plus" class="fea icon-sm"></i></a>
        </div> 
    </div><!--end col-->

    @if(collect($discounts)->isNotEmpty())
        <div class="col-md-12 form-group">
            <h5><span class="font-weight-bold">Available Discounts</span></h5>
            <small class="text-danger text-small">The selected discount will be applied on final invoice.</small>
        </div>

        <div class="row col-12 col-md-12">
            @foreach($discounts as $discount)
                <div class="col-6 col-md-6 form-group">
                    <div class="custom-control custom-radio form-group position-relative">
                    <input type="radio" id="discount-{{ $discount->id }}" name="client_discount_id" class="custom-control-input" value="{{ $discount->id }}" @if(empty($discount->discount->name)) disabled @endif>
                    <label class="custom-control-label" for="discount-{{ $discount->id }}">{{ $discount->discount->name ?? 'UNAVAILABLE' }}<small class="text-danger">({{ $discount->discount->rate ?? '0.00' }}%)</small></label>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="col-md-12 form-group">
        <h5><span class="font-weight-bold">Do you want to be contacted?</span></h5>
    </div>

    <div class="col-md-6 form-group">
        <div class="custom-control custom-radio form-group position-relative">
            <input type="radio" id="yes_contact" name="contactme_status" class="custom-control-input input-check" value="1" />
            <label class="custom-control-label" for="yes_contact">Your dedicated project manager will call you within the hour.</label>
        </div>
    </div>

    <div class="col-md-6 form-group">
        <div class="custom-control custom-radio form-group position-relative">
            <input type="radio" id="no_contact" name="contactme_status" class="custom-control-input input-check" value="0" />
            <label class="custom-control-label" for="no_contact">I prefer to call my dedicated project manager at my convenience.</label>
        </div>
    </div>

    <div class="col-md-12 form-group">
        <h5><span class="font-weight-bold">Payment Options</span></h5>
    </div>

    <div class="col-md-6 form-group">
        <div class="custom-control custom-radio form-group position-relative">
            <input type="radio" id="wallet_payment_option" name="payment_channel" class="custom-control-input input-check" onclick="displayPaymentGateways('1')" value="wallet" data-tabid="wallet" data-action="{{route('wallet-submit', app()->getLocale()) }}" @if($canPayWithWallet == 'cannot-pay') disabled readonly @endif />
            <label class="custom-control-label" for="wallet_payment_option">E-Wallet</label>
            @if($canPayWithWallet == 'cannot-pay')
                <small class="text-small text-danger">Insufficient funds!.</small>
            @endif
        </div>
    </div>

    <div class="col-md-6 form-group">
        <div class="custom-control custom-radio form-group position-relative">
            <input type="radio" id="payment_gateway_option" class="custom-control-input" onclick="displayPaymentGateways('2')"/>
            <label class="custom-control-label" for="payment_gateway_option">Pay Online</label>
        </div>
    </div>

    <!-- Payment options starts here -->
    <div class="row mx-auto p-4 cc-selector d-none payment-options">   
        <div class="col-md-6 payment-radio-container">
        
            <input type="radio" id="flutter" name="payment_channel" class="input-check" value="flutterwave" data-tabid="flutterwave" > 
            <label for="flutter" class="pplogo-container">
            <img class="img-fluid" alt="flutter" src="{{ asset('assets/images') }}/flutter.png">              
            </label>
        </div>
        
        <div class="col-md-6 payment-radio-container">
            <input type="radio" id="paystack" name="payment_channel" class="input-check" value="paystack" data-tabid="paystack" > 
            <label for="paystack" class="pplogo-container">
            <img class="img-fluid" alt="paystack" src="{{ asset('assets/images') }}/paystack.png">             
            </label>
        </div>
    </div><!-- payment ends -->


    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
    </div><!--end col-->

    @elseif($displayDescription == 'not-serviced')
        <div class="col-md-12">
            <h5>Sorry! The selected contact area is not serviced at the moment, please try another area. Thank you.</h5>
        </div>
    @elseif($displayDescription == 'blank')
        <div class="col-md-12">
            <h6>Select a booking fee and a contact to proceed.</h6>
        </div>
    @endif
</div><!--end row-->