@extends('layouts.client')
@section('title', 'Service Quote')
@section('content')
@include('layouts.partials._messages')


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" type="text/css" />
<style>
    .blog .author { opacity: 1 !important; }
    .blog .overlay { opacity: 0.6 !important; }
    .avatar.avatar-ex-smm { max-height: 75px; }
</style>

<style>

.cc-selector input{
    margin:0;padding:0;
    -webkit-appearance:none;
       -moz-appearance:none;
            appearance:none;
}
.paystack{background-image:url({{ asset('assets/images') }}/paystack.png);}
.flutter{background-image:url({{ asset('assets/images') }}/flutter.png);}

.cc-selector input:active +.drinkcard-cc{opacity: .5;}
.cc-selector input:checked +.drinkcard-cc{
    -webkit-filter: none;
       -moz-filter: none;
            filter: none;
}
.drinkcard-cc{
    cursor:pointer;
    background-size:contain;
    background-repeat:no-repeat;
    display:inline-block;
    width:100px;height:10em;
    -webkit-transition: all 100ms ease-in;
       -moz-transition: all 100ms ease-in;
            transition: all 100ms ease-in;
    -webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
       -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
            filter: brightness(1.8) grayscale(1) opacity(.7);
}
.drinkcard-cc:hover{
    -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
       -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
            filter: brightness(1.2) grayscale(.5) opacity(.9);
}

/* Extras */
a:visited{color:#888}
a{color:#999;text-decoration:none;}
p{margin-bottom:.3em;}

.address-hide{
    display:none;
}

table.scroll {
    /* width: 100%; */ /* Optional */
    /* border-collapse: collapse; */
    border-spacing: 0;
    /* border: 2px solid black; */
}

table.scroll tbody,
table.scroll thead { display: block; }

thead tr th { 
    height: 30px;
    line-height: 30px;
    /* text-align: left; */
}

table.scroll tbody {
    height: 10em;
    overflow-y: auto;
    overflow-x: hidden;
}

tbody { border-top: 2px solid black; }

tbody td, thead th {
    /* width: 20%; */ /* Optional */
    border-right: 1px solid black;
    /* white-space: nowrap; */
}

tbody td:last-child, thead th:last-child {
    border-right: none;
}




.payment-container {
  display: flex;
  flex-flow: row wrap;
}
.payment-container > .payment-radio-container {
  flex: 1;
  padding: 0.5rem;
}
input[type="radio"] {
  display: none;
}
input[type="radio"]:not(:disabled) ~ .pplogo-container {
  cursor: pointer;
  
}
input[type="radio"]:disabled ~ .pplogo-container {
  color: #2251fc;
  border-color: #2251fc;
  box-shadow: none;
  cursor: not-allowed;
}
.pplogo-container {
  height: 150px;
  display: flex;
  justify-content:canter;
  align-items:center;
  width:200px;
  background: white;
  border: 2px solid #2251fc;
  border-radius: 20px;
  padding: 1rem;
  //margin-bottom: 1rem;
  box-shadow: 0px 3px 10px -2px rgba(34, 81, 252, 0.5);
  position: relative;
}
input[type="radio"]:checked + .pplogo-container {
  //background: #2251fc;
  color: white;
  box-shadow: 0px 0px 20px rgba(34, 81, 252, 0.75);
}
input[type="radio"]:checked + .pplogo-container::after {
  content: "\f058";
 font-family: "Font Awesome 5 Free";
  color: #2251fc;  
  border: 1px solid #2251fc;
  font-size: 2.5rem;
  font-weight:100;
  position: absolute;
  top: -25px;
  left: 50%;
  transform: translateX(-50%);
  height: 50px;
  width: 50px;
  line-height: 49px;
  text-align: center;
  border-radius: 50%;
  background: white;
  box-shadow: 0px 2px 5px -2px rgba(0, 0, 0, 0.25);
}
p {
  font-weight: 900;
}
@media only screen and (max-width: 700px) {
  section {
    flex-direction: column;
  }
}


</style>

<style> 
.pac-container {
    z-index: 100000;
}

tbody td, thead th {
    width: 20% !important;
}
</style>


<div class="col-lg-8 col-12">
    <div class="card custom-form border-0">
        <div class="card-body mt-4">
            {{--
            <h5><span class="font-weight-bold">{{ $service->name }}</span> Service Request</h5> 
            --}}
            <div class="card bg-primary">
                <h4 class="text-white ml-2 user d-block"><i class="mdi mdi-bookmark"></i> Service: {{ !empty($service->name) ? $service->name : 'UNAVAILABLE' }}</h4>
                <small class="text-white ml-2 date"><i class="mdi mdi-star_rate"></i> Total Requests: {{ $service->serviceRequests()->count() ?? '0' }}</small>
            </div>

            <!-- <form class="rounded p-4" method="POST" action="{{ route('client.services.serviceRequest', app()->getLocale()) }}" enctype="multipart/form-data"> -->
            <!-- <form class="rounded p-4" method="POST" action="{{ route('client.services.serviceRequest', app()->getLocale()) }}" enctype="multipart/form-data"> -->
            <form class="rounded p-4" action="" method="POST" id="payment" enctype="multipart/form-data">
                @csrf
                <small class="text-danger">A Booking Fee deposit is required to validate this order and enable our AI assign a Customer Service Executice(CSE) to your Job.</small>

                <input type="hidden" class="d-none" value="{{ $service->id }}" name="service_id" />

                <div class="row" id="pills-tab" role="tablist">
                    <ul class="nav nav-pills bg-white nav-justified flex-column mb-0" id="pills-tab" role="tablist">
                        @foreach($bookingFees as $bookingFee)
                        <li class="nav-item bg-light rounded-md mt-4">
                            <a
                                class="nav-link rounded-md @if(old('price_id') == $bookingFee->id) active @endif"
                                id="dashboard-{{$bookingFee->id}}"
                                data-toggle="pill"
                                href="#dash-board-{{$bookingFee->id}}"
                                role="tab"
                                aria-controls="dash-board-{{$bookingFee->id}}"
                                aria-selected="false"
                            >
                                <div class="p-3 text-left">
                                    <h5 class="title">{{ !empty($bookingFee->name) ? $bookingFee->name : 'UNAVAILABLE' }}: ₦{{ number_format(!empty($bookingFee->amount) ? $bookingFee->amount : '0') }}</h5>
                                    <p class="text-muted tab-para mb-0">{{ !empty($bookingFee->description) ? $bookingFee->description : 'No description found' }}</p>
                                    <input type="radio" name="price_id" value="{{ old('price_id') ?? $bookingFee->id }}" class="custom-control-input booking-fee" />
                                    <input type="radio" name="booking_fee" value="{{ old('booking_fee') ?? $bookingFee->amount }}" class="custom-control-input booking-fee" />
                                </div>
                            </a>
                            <!--end nav link-->
                        </li>
                        <!--end nav item-->
                        @endforeach
                    </ul>
                    <!--end nav pills-->
                </div>
                <!-- new end -->
                <div class="row">
                    <!-- first div -->
                    <div class="col-lg-12 col-md-12 mt-4" id="address">
                        <div class="contact-list">
                        @include('client.services._contactList')
            </div>                        
                    </div>
                    <!--end col-->
                </div>


                <div class="d-flex align-items-center justify-content-between mt-4 col-lg-12">  
                    <button type="button" name="add" id="add_new_contact" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-primary btn-sm"><i data-feather="plus" class="fea icon-sm"></i> Add New Contact</button>  
                </div> 


<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group position-relative">
            <label>Tell us more about the service you need :</label>
            <i data-feather="message-circle" class="fea icon-sm icons"></i>
            <textarea name="description" id="description" rows="4" class="form-control pl-5 @error('description') is-invalid @enderror" placeholder="If there is an equipment involved, do tell us about the equipment e.g. the make, model, age of the equipment etc.">{{ old('description') }}</textarea>
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
            <label>Scheduled Date & Time :</label>
            <i data-feather="calendar" class="fea icon-sm icons"></i>
            <input name="timestamp" type="text" class="form-control pl-5 @error('timestamp') is-invalid @enderror" placeholder="Click to select :" id="service-date-time" readonly value="{{ old('timestamp') }}" />
            @error('timestamp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <!--end col-->


    <!-- <div class="col-md-6">
        <div class="form-group position-relative">
            <label>Upload file for evaluation <span class="text-danger">(Optional)</span> :</label>
            <input type="file" class="form-control-file btn btn-primary btn-sm" id="fileupload" name="media_file" accept="image/*,.txt,.doc,.docx,.pdf" />
            <small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>
        </div>
    </div> -->


    <div class="col-md-3 card-body">
            <div class="form-group position-relative">
                <a class="btn btn-outline btn-dark btn-pill btn-outline-1x btn-sm" id="add-more-file">Add more attachments</a>
            </div> 
        </div><!--end col-->

          <div class="col-md-9 form-group card-body pl-0">
          <div class="attachments">
            <div class="form-group position-relative custom-file">
                <input type="file" name="media_file[]" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_1" accept="image/*,.txt,.doc,.docx,.pdf" />
                <small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>
            </div> 
            </div> 
          </div>

    <!--end col-->


    <div class="col-md-6">
        <div class="form-group position-relative">
            <input name="payment_for" type="hidden" readonly value="service-request" />
        </div>
    </div>


    @if($discounts->count() > 0)
    <div class="col-md-12 form-group">
        <h5><span class="font-weight-bold">Available Discounts</span></h5>
        <small class="text-danger">The selected discount will be applied on final invoice.</small>
    </div>

        @foreach($discounts as $discount)
            <div class="col-md-4 form-group">
                <div class="custom-control custom-radio form-group position-relative">
                <input type="radio" id="discount-{{ $discount->id }}" name="client_discount_id" class="custom-control-input" value="{{ $discount->id }}" @if(empty($discount->discount->name)) disabled @endif>
                <label class="custom-control-label" for="discount-{{ $discount->id }}">{{ $discount->discount->name ?? 'UNAVAILABLE' }}(<small class="text-danger">{{ $discount->discount->rate ?? '0.00' }}%</small>)</label>
                </div>
            </div>
        @endforeach

        
    @endif



    <div class="col-md-12 form-group">
        <h5><span class="font-weight-bold">Do you want to be contacted?</span></h5>
    </div>

    <div class="col-md-6 form-group">
        <div class="custom-control custom-radio form-group position-relative">
            <input type="radio" id="yes_contact" name="contacted" class="custom-control-input input-check" value="1" />
            <label class="custom-control-label" for="yes_contact">Your Dedicated Project Manager will call you within the hour</label>
        </div>
    </div>

    <div class="col-md-6 form-group">
        <div class="custom-control custom-radio form-group position-relative">
            <input type="radio" id="no_contact" name="contacted" class="custom-control-input input-check" value="0" />
            <label class="custom-control-label" for="no_contact">I prefer to call my Dedicated Project Manager at my convenience</label>
        </div>
    </div>


    <div class="col-md-12 form-group">
        <h5><span class="font-weight-bold">Payment Options</span></h5>
    </div>




    <div class="col-md-6 form-group">
        <div class="custom-control custom-radio form-group position-relative">
            <input type="radio" id="wallet_payment_option" name="payment_channel" class="custom-control-input input-check" onclick="displayPaymentGateways('1')" value="Wallet" data-tabid="wallet" data-action="{{route('wallet-submit', app()->getLocale()) }}"/>
            <label class="custom-control-label" for="wallet_payment_option">E-Wallet</label>
        </div>
    </div>

    <div class="col-md-6 form-group">
        <div class="custom-control custom-radio form-group position-relative">
            <input type="radio" id="payment_gateway_option" name="payment_channel" class="custom-control-input" onclick="displayPaymentGateways('2')" value="Online" />
            <label class="custom-control-label" for="payment_gateway_option">Pay Online</label>
        </div>
    </div>

 
    <input type="hidden" value="{{!empty($balance->closing_balance) ? $balance->closing_balance : '0'}}" name="balance" />


<!-- payment starts here -->
    <!-- <div class="col-md-6 mx-auto p-4 payment-container d-none payment-options"> -->
    <div class="row mx-auto p-4 cc-selector d-none payment-options">   
        <div class="col-md-6 payment-radio-container">
        <!-- <div class="col-md-6 payment-radio-container media key-feature align-items-center p-3 rounded shadow mt-4"> -->
            
            <!-- <input type="radio" id="flutter" name="payment_channel" value="flutterwave" checked> -->
            <input type="radio" id="flutter" name="payment_channel" class="input-check" value="flutterwave" data-tabid="flutterwave" data-action="{{route('flutterwave-submit', app()->getLocale()) }}" > 
            <label for="flutter" class="pplogo-container">
            <img class="img-fluid" alt="flutter"src="{{ asset('assets/images') }}/flutter.png">              
            </label>
        </div>
        
        <div class="col-md-6 payment-radio-container">
            <!-- <input type="radio" id="paystack" name="payment_channel" value="paystack"> -->
            <input type="radio" id="paystack" name="payment_channel" class="input-check" value="paystack" data-tabid="paystack" data-action="{{route('paystack-submit', app()->getLocale()) }}" > 
            <label for="paystack" class="pplogo-container">
            <img class="img-fluid" alt="paystack"src="{{ asset('assets/images') }}/paystack.png">             
            </label>
        </div>
    </div>
<!-- payment ends -->

    <!-- @foreach($gateways as $val)
    <div class="col-md-6 cc-selector d-none payment-options">
        <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
            <a href="#" data-toggle="modal" data-target="#modal-form{{$val->id}}">
                <img src="{{ asset('assets/images') }}/{{$val->name}}.png" class="avatar avatar-ex-smm" alt="" />
            </a>
            <a href="javascript:void(0)" class="text-primary">
                <div class="media-body content ml-3">
                    <a href="#" data-toggle="modal" data-target="#modal-form{{$val->id}}">
                        <h4 class="title mb-0">{{$val->name}}</h4>
                    </a>
                </div>
            </a>
        </div>
    </div>
    @endforeach -->
</div>



<div class="row ml-4 mb-4">
    <div class="col-sm-12">
    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
    <!-- <button type="submit" class="submitBnt btn btn-primary">Submit</button> -->
    </div><!--end col-->
</div><!--end row-->

</div>








<div class="modal fade" id="payOffline" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">How to make offline payment?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--
                <h3>How to make offline payment?</h3>
                --}}
                <p class="text-muted">You can make offline payment using the following options</p>
                <h5 class="text-primary">Pay To The Bank</h5>
                <p>
                    Pay to into the account details below:<br />
                    Account name: <strong>FCMB</strong><br />
                    Account Number: <strong>1234567890</strong><br />
                    <span class="text-danger">Note: </span> On the teller, please write as depositor's name and add your job reference at the end of the name. E.g.:
                    <span class="text-muted">"{{ Auth::user()->account->first_name.' '.Auth::user()->account->last_name }} (REF-2E3487AAF23) payment."</span>
                </p>

                <h5 class="text-primary">Internet Banking</h5>
                <p>
                    Make an online transfer to the account details below:<br />
                    Account name: <strong>FCMB</strong><br />
                    Account Number: <strong>1234567890</strong><br />
                    <span class="text-danger">Note: </span> Use the following as transfer note. E.g.: <span class="text-muted">"{{ Auth::user()->account->first_name.' '.Auth::user()->account->last_name }} (REF-2E3487AAF23) payment."</span>
                </p>

                <div class="col-md-12 col-12 mt-4 mb-4 pt-2">
                    <div class="media">
                        <i data-feather="help-circle" class="fea icon-ex-md text-primary mr-2 mt-1"></i>
                        <div class="media-body">
                            <h5 class="mt-0">Once your payment is successfully made, kindly notify us by:</h5>
                            <p class="answer text-muted mb-0">
                                1. Call Us on <strong>08132863878</strong><br />
                                2. Send an SMS of your service Reference Code <strong>(REF-2E3487AAF23)</strong> and amount paid to <strong>08132863878</strong><br />
                                3. E-Mail Us on <a href="mailto:info@fixmaster.com.ng">info@fixmaster.com.ng</a> with your service Reference Code and amount paid.<br />
                                4. <a class="btn btn-primary btn-sm"> Notify Us Online</a>
                            </p>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
        </div>
        <!-- modal-body -->
    </div>
    <!-- modal-content -->
</div>
<!-- modal-dialog -->




            </form>
        </div>
    </div>


   

@push('scripts')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.geolocation_api_key') }}&v=3.exp&libraries=places"></script>
<script src="{{ asset('assets/js/geolocation.js') }}"></script>

<script>

    $(document).ready(function () {
        //Get list of L.G.A's in a particular state.
        $("#state_id").on("change", function () {
            let stateId = $("#state_id").find("option:selected").val();
            let stateName = $("#state_id").find("option:selected").text();
            let wardId = $("#ward_id").find("option:selected").val();

            // $.ajaxSetup({
            //         headers: {
            //             'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            $.ajax({
                url: "{{ route('lga_list', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    state_id: stateId,
                },
                success: function (data) {
                    if (data) {
                        $("#lga_id").html(data.lgaList);
                    } else {
                        var message = "Error occured while trying to get L.G.A`s in " + stateName + " state";
                        var type = "error";
                        displayMessage(message, type);
                    }
                },
            });
        });

        $('#lga_id').on('change', function() {
            let stateId = $('#state_id').find('option:selected').val();
            let lgaId = $('#lga_id').find('option:selected').val();
            $.ajax({
                url: "{{ route('towns.show', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "state_id": stateId, "lga_id": lgaId
                },
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $('#town_id').html(data.towns_list);
                    } else {
                        var message = 'Error occured while trying to get Town`s';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })
        });


        $('#insert_form').on("submit", function(event){  
           event.preventDefault();  
                $.ajax({  
                     url:"{{ route('client.ajax_contactForm', app()->getLocale()) }}",  
                     method:"POST",  
                     data: {
                    _token: "{{ csrf_token() }}",
                    firstName: $("#first-name").val(),
                    lastName: $("#last-name").val(),
                    phoneNumber: $("#phone_number").val(),
                    state: $("#state_id").val(),
                    lga: $("#lga_id").val(),
                    town: $("#town_id").val(),
                    streetAddress: $("#street-address").val(), 
                    addressLat: $("#user_latitude").val(),
                    addressLng: $("#user_longitude").val(),
                    },  
                     beforeSend:function(){  
                        //   $('.contact-list').val("Creating New Contact...");
                        $("#contacts_table").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');  
                     },  
                     success:function(data){ 
                        
                        $('#insert_form')[0].reset(); 
                        $('#add_data_Modal').modal('hide');
                        $('#contacts_table').html(data);
                        var message = ' New contact saved.';
                        var type = 'success';
                        displayMessage(message, type);
                     }
                    //  complete: function(data) {
                    //     // $(".contact-list").hide();
                    //     var message = ' New contact saved.';
                    //     var type = 'success';
                    //     // $('#add_data_Modal').modal('hide');
                    //     displayMessage(message, type);
                    //     // $('#contacts_table').html(data);
                    //     // $(".contact-list").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');  
                       
                    // }
                    // error: function(jqXHR, testStatus, error) {
                    //     var message = error+ ' An error occured while trying to save the new contact information.';
                    //     var type = 'error';
                    //     displayMessage(message, type);
                    //     // $(".contact-list").html('Failed to save new contact.');
                    // },

                    // timeout: 3000  
                }); 
        }); 


    });

    $(document).ready(function () {
        $(document).on("click", ".nav-item", function () {
            $(this).find(".booking-fee").prop("checked", true);
        });

        $("#pay_offline").on("change", function () {
            $("#pay_offline").attr("checked", "checked");
            $(".payment-options").addClass("d-none");
        });

        $(".close").click(function () {
            $(".modal-backdrop").remove();
        });
    });

    function displayPaymentGateways(val) {
        console.log(val);
        if(val == 2){
            $(".payment-options").removeClass("d-none");
        }else{
            $(".payment-options").addClass("d-none");
        }
        
    }

    $("#editAddress").addClass("address-hide");

    function address() {
        $("#address").addClass("address-hide");
        $("#editAddress").removeClass("address-hide");
    }

    $(document).ready(function() {
       // always check the first payment gateway
       $(".input-check").first().attr('checked', true);
        // change form action, show form for checked 'gateway'
        let tabid = $(".input-check:checked").data('tabid');
       $('#payment').attr('action', $(".input-check:checked").data('action'));
    });

     // on gateway change...
     $(document).on('change', '.input-check', function() {
        // change form action
        let tabid = $(this).data('tabid');
        $('#payment').attr('action', $(this).data('action'));
        $('#paymentGatewaysForm').attr('action', $(".input-check:checked").data('action'));

    });

</script>


<script>
function ValidateSize(file) {
        if (typeof(file.files[0]) === "undefined") {
            $(file).val('');
            $(file).parent('.custom-file').find('label').text('Choose File');
            return false;
        }
        var FileSize = file.files[0].size / 1024 / 1024;
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
            $(file).val(''); //for clearing with Jquery
        } else {
            $(file).parent('.custom-file').find('label').text(file.files[0].name);
        }
    }
    
 $('body').on('click', '#add-more-file', function () {
        var count = parseInt($('.attachments').find('.custom-file:nth-last-child(1) input').prop('id').split("_")[2]) + 1; 
        // $('.attachments').append('<div class="custom-file">'+
        //     '<label class="custom-file-label" for="custom_file_'+count+'">file here</label>'+
        //     '<input type="file" name="filename[]" accept="application/pdf, image/gif, image/jpeg, image/png" class="custom-file-input" size="20" onchange="ValidateSize(this);" id="custom_file_'+count+'">'+
        //     '</div>')

            $('.attachments').append('<div class="form-group position-relative custom-file">'+
                '<input type="file" name="media_file[]" accept="image/*,.txt,.doc,.docx,.pdf" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_'+count+'"  />'+
                '<small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>'+
            '</div>')
    });
</script>


@endpush 
@include('client.services._newAddress')
@endsection




