@include('layouts.partials._client_navbar')
@section('title', 'Invoice')
    
    <!-- Invoice Start -->
    <section class="bg-invoice bg-light">
        <div class="container">
            <div class="row mt-5 pt-4 pt-sm-0 justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <div class="invoice-top pb-4 border-bottom">
                                <div class="row">
                                    <div class="col-md-8">
                                        <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" class="l-dark" style="margin-top: -38px !important;" height="140" alt="FixMaster Logo">

                                        <div class="logo-invoice mb-2">
                                            @if($invoiceExists->status == 1)
                                                <span class="text-primary"> Pending Payment</span><br>
                                                <button type="button" onclick="payWithPaystack()" id="paystack_option"  class="btn btn-success">PAY </button>
                                            @elseif($invoiceExists->status == 2)
                                                <span class="text-success">Paid</span><br>
                                            @endif
                                        </div>

                                        <a href="{{ route('page.home') }}" class="text-primary h6"><i data-feather="link" class="fea icon-sm text-muted mr-2"></i>www.fixmaster.com.ng</a>

                                        
                                    </div><!--end col-->

                                    <div class="col-md-4 mt-4 mt-sm-0">
                                        <h5>Address :</h5>
                                        <dl class="row mb-0">
                                            <dt class="col-2 text-muted"><i data-feather="map-pin" class="fea icon-sm"></i></dt>
                                            <dd class="col-10 text-muted">
                                                <a href="#" class="video-play-icon text-muted">
                                                    <p class="mb-0">284 Ajose Adeogun Street, Victoria Island,</p>
                                                    <p class="mb-0">Lagos, Nigeria</p>
                                                </a>
                                            </dd>

                                            <dt class="col-2 text-muted"><i data-feather="mail" class="fea icon-sm"></i></dt>
                                            <dd class="col-10 text-muted">
                                                <a href="mailto:info@fixmaster.com.ng" class="text-muted">info@fixmaster.com.ng</a>
                                            </dd>

                                            <dt class="col-2 text-muted"><i data-feather="phone" class="fea icon-sm"></i></dt>
                                            <dd class="col-10 text-muted">
                                                <a href="tel:+152534-468-854" class="text-muted">(+234) 0813-286-3878</a>
                                            </dd>
                                        </dl>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div>

                            <div class="invoice-middle py-4">
                                <h5>Invoice Details :</h5>
                                <div class="row mb-0">
                                    <div class="col-md-8 order-2 order-md-1">
                                        <dl class="row">
                                            <dt class="col-md-3 col-5 font-weight-normal">Invoice No. :</dt>
                                        <dd class="col-md-9 col-7 text-muted">{{ $invoiceExists->invoice_number}}</dd>
                                            
                                            <dt class="col-md-3 col-5 font-weight-normal">Name :</dt>
                                            <dd class="col-md-9 col-7 text-muted">{{ $invoiceExists->client->fullName->name }}</dd>
                                            
                                            <dt class="col-md-3 col-5 font-weight-normal">Address :</dt>
                                            <dd class="col-md-9 col-7 text-muted">
                                                <p class="mb-0">{{ $invoiceExists->serviceRequest->serviceRequestDetail->address }}</p>
                                            </dd>
                                            
                                            <dt class="col-md-3 col-5 font-weight-normal">Phone :</dt>
                                            <dd class="col-md-9 col-7 text-muted">{{ $invoiceExists->serviceRequest->serviceRequestDetail->phone_number }}</dd>
                                        </dl>
                                    </div>

                                    <div class="col-md-4 order-md-2 order-1 mt-2 mt-sm-0">
                                        <dl class="row mb-0">
                                            <dt class="col-md-4 col-5 font-weight-normal">Date :</dt>
                                            <dd class="col-md-8 col-7 text-muted">{{ Carbon\Carbon::parse($invoiceExists->created_at, 'UTC')->isoFormat('MMMM Do YYYY') }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="invoice-table pb-4">
                                <div class="table-responsive bg-white shadow rounded">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col" class="text-left">No.</th>
                                                <th scope="col" class="text-left">Component Name</th>
                                                <th scope="col" class="text-left">Model Number</th>
                                                <th scope="col" class="text-center">Quantity</th>
                                                <th scope="col" class="text-center">Amount</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($invoiceDetails as $item)
                                            <tr>
                                                <th scope="row" class="text-left">{{ ++$i }}</th>
                                                <td class="text-left">{{ $item->component_name }}</td>
                                                <td class="text-left">{{ $item->model_number }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-center">₦{{ number_format($item->amount) }}</td>
                                                <td class="text-right">₦{{ number_format($item->amount * $item->quantity) }}</td>
                                            </tr>
                                            @endforeach
                                           
                                            <tr>
                                                <th scope="row" class="text-left">3</th>
                                                <td class="text-left">Delivery Fee</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">₦{{ number_format($invoiceExists->rfqSupplier->devlivery_fee ?? '0') }}</td>
                                                <td class="text-right">₦{{ number_format($invoiceExists->rfqSupplier->devlivery_fee ?? '0') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-5 ml-auto">
                                        <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                            <li class="text-muted d-flex justify-content-between">Subtotal :<span>₦{{ number_format($invoiceExists->total_amount + $invoiceExists->rfqSupplier->devlivery_fee) ?? '0' }}</span></li>
                                        <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦{{ number_format($tax) }}</span></li>
                                            <li class="d-flex justify-content-between">Total :<span>₦{{ number_format($invoiceExists->total_amount + $tax + $invoiceExists->rfqSupplier->devlivery_fee) ?? '0' }}</span></li>
                                        </ul>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div>

                            <form method="POST" action="{{ route('client.pay_request_invoice') }}">
                                @csrf
                                {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                                <input type="hidden" class="d-none" value="{{ old('email') ?? $email }}" id="email" name="email">
                                <input type="hidden" class="d-none" value="{{ old('client_discount') ?? $clientDiscount }}" id="client_discount" name="client_discount">
                                <input type="hidden" class="d-none" value="{{ old('client_phone_number') ?? $clientPhoneNumber }}" id="client_phone_number" name="client_phone_number">

                                {{-- Values are to be provided by the payment gateway using jQuery or Vanilla JS --}}
                                <input type="hidden" class="d-none" value="{{ old('payment_response_message') }}" id="payment_response_message" name="payment_response_message">
                                <input type="hidden" class="d-none" value="{{ old('payment_reference') }}" id="payment_reference" name="payment_reference">

                                <input type="hidden" class="d-none" value="{{ old('service_fee') ?? $invoiceExists->total_amount + $tax + ($invoiceExists->rfqSupplier->devlivery_fee) ?? '0' }}" id="serviceFee" name="service_fee">

                                
                                <input type="hidden" class="d-none" value="{{ old('service_request_id') ?? $invoiceExists->service_request_id }}" id="service_request_id" name="service_request_id">

                                <input type="hidden" class="d-none" value="{{ old('rfq_id') ?? $invoiceExists->id }}" id="rfq_id" name="rfq_id">

                                <input type="hidden" class="d-none" value="{{ old('invoice') ?? $invoiceExists->invoice_number }}" id="invoice" name="invoice">

                                <button type="submit" class="submitBnt btn btn-primary d-none">Submit</button>


                            </form>

                            <div class="invoice-footer border-top pt-4">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="text-sm-left text-muted text-center">
                                            <h6 class="mb-0">Customer Service : <a href="tel:08132863878" class="text-warning">(+234) 0813-286-3878</a></h6>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="text-sm-right text-muted text-center">
                                        <h6 class="mb-0">&copy {{ date('Y') }} FixMaster. All Rights Reserved. </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- Invoice End -->

    <!-- Footer Start -->
    <footer class="footer footer-bar">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="text-sm-left">
                        <p class="mb-0">© {{ date('Y') }} FixMaster. All Rights Reserved.</p>
                    </div>
                </div><!--end col-->
    
                <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    {{-- <ul class="list-unstyled text-sm-right mb-0">
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/american-ex.png" class="avatar avatar-ex-sm" title="American Express" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/discover.png" class="avatar avatar-ex-sm" title="Discover" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/master-card.png" class="avatar avatar-ex-sm" title="Master Card" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/paypal.png" class="avatar avatar-ex-sm" title="Paypal" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/visa.png" class="avatar avatar-ex-sm" title="Visa" alt=""></a></li>
                    </ul> --}}
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </footer><!--end footer-->
    <!-- Footer End -->
    
    <!-- Back to top -->
    <a href="#" class="btn btn-icon btn-soft-primary back-to-top"><i data-feather="arrow-up" class="icons"></i></a>
    <!-- Back to top -->

    <!-- javascript -->
    <script src="{{asset('assets/frontend/js/jquery-3.5.1.min.js')}}"></script>
    {{-- <script src="{{asset('assets/client/js/jquery.min.js')}}"></script> --}}
    <script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/scrollspy.min.js')}}"></script>
    <!-- SLIDER -->
    <script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/owl.init.js')}}"></script>
    <!-- Icons -->
    <script src="{{asset('assets/frontend/js/feather.min.js')}}"></script>
    <!-- Switcher -->
    <script src="{{asset('assets/frontend/js/switcher.js')}}"></script>
    <!-- Main Js -->
    <script src="{{asset('assets/frontend/js/app.js')}}"></script>
    <!-- scroll -->
    <script src="{{ asset('assets/frontend/js/scroll.js')}}"></script>
    <script src="{{ asset('assets/frontend/js/typed/lib/typed.js')}}"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>

    @php
        $paystackInfo = json_decode($paystack->information, true);
    @endphp

<script>
    function payWithPaystack(){

        var clientEmail = $('#email').val();
        var clientDiscount = $('#client_discount').val();
        var clientPhoneNumber = $('#client_phone_number').val();
        var amount = $("#serviceFee").val();

        var handler = PaystackPop.setup({
            key:"{{ $paystackInfo['public_key'] }}",
            // key: 'pk_test_41ada297a2a2953f9d42e125713644baccd0658c',
            email: clientEmail,
            amount: amount * 100,
            currency: "NGN",
            ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
            custom_fields: [
                {
                    display_name: "Mobile Number",
                    variable_name: "mobile_number",
                    value: clientPhoneNumber,
                }
            ]
            },
            callback: function(response){
                // sendResponseToController(response);
                // alert('success. transaction ref is ' + response.reference);
                $('#payment_reference').val(response.reference);
                $('#payment_response_message').val('success');

                // console.log($('#payment_reference').val());
                $('.submitBnt').trigger('click');

            },
            onClose: function(){
                // alert('window closed');

                var message = 'Closing payment gateway window.';
                var type = 'success';
                displayMessage(message, type);
            }
        });
        handler.openIframe();
    }
</script>

</body>
</html>