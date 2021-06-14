@extends('layouts.dashboard')
@section('title', 'Invoices')
@section('content')
    @include('layouts.partials._messages')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Invoices</h4>
                </div>
                <div class="d-md-block">
                    <a href="{{ route('admin.invoices', app()->getLocale()) }}" class="btn btn-primary">Invoices</a>
                    <a href="{{ route('admin.rfq_simulation', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Simulation</a>
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">Invoices as of {{ date('M, d Y') }}</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Invoices.</p>
                            </div>

                        </div><!-- card-header -->
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
                                                                @if($invoice->status == 1 && $invoice['invoice_type'] == 'Completion Invoice')
                                                                    <span class="text-primary"> Pending Payment</span><br>
                                                                    <button type="button" onclick="payWithPaystack()" id="paystack_option"  class="btn btn-success">PAY </button>
                                                                @elseif($invoice->status == 2 && $invoice['invoice_type'] == 'Completion Invoice')
                                                                    <span class="text-success">Paid</span><br>
                                                                @endif
                                                            </div>

                                                            <a href="" class="text-primary h6"><i data-feather="link" class="fea icon-sm text-muted mr-2"></i>www.fixmaster.com.ng</a>


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
                                                                <dd class="col-md-9 col-7 text-muted">{{ $invoice['invoice_number'] }}</dd>

                                                                <dt class="col-md-3 col-5 font-weight-normal">Name :</dt>
                                                                <dd class="col-md-9 col-7 text-muted">{{ $invoice['client']->account->first_name }} {{ $invoice['client']->account->last_name }}</dd>

                                                                <dt class="col-md-3 col-5 font-weight-normal">Address :</dt>
                                                                <dd class="col-md-9 col-7 text-muted">
                                                                    <p class="mb-0">{{ $invoice['client']['contact']['address'] }}</p>
                                                                </dd>

                                                                <dt class="col-md-3 col-5 font-weight-normal">Phone :</dt>
                                                                <dd class="col-md-9 col-7 text-muted">{{ $invoice['client']['contact']['phone_number'] }}</dd>
                                                            </dl>
                                                        </div>

                                                        <div class="col-md-4 order-md-2 order-1 mt-2 mt-sm-0">
                                                            <dl class="row mb-0">
                                                                <dt class="col-md-4 col-5 font-weight-normal">Date :</dt>
                                                                <dd class="col-md-8 col-7 text-muted">{{ Carbon\Carbon::parse($invoice['created_at'], 'UTC')->isoFormat('MMMM Do, YYYY') }}</dd>
                                                            </dl>
                                                            <dl class="row mb-0">
                                                                <dt class="col-md-4 col-5 font-weight-normal">Type :</dt>
                                                                <dd class="col-md-8 col-7 text-muted">{{ $invoice->invoice_type }}</dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="invoice-table pb-4">
                                                    @if($invoice->invoice_type === 'Diagnostic Invoice')
                                                    <div class="table-responsive bg-white shadow rounded">
                                                        <table class="table mb-0 table-center invoice-tb">
                                                            <thead class="bg-light">
                                                            <tr>
                                                                <th scope="col" class="text-left">Service Type</th>
                                                                <th scope="col" class="text-left">Amount</th>
                                                                <th scope="col">Total</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-left">Diagnostics Completion</td>
                                                                    <td class="text-left">₦ {{ number_format($invoice['total_amount']) }}</td>
                                                                    <td class="text-left">₦ {{ number_format($invoice['total_amount']) }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-5 ml-auto">
                                                            <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                                                <li class="text-muted d-flex justify-content-between">Subtotal :<span>₦ {{ number_format($invoice['total_amount']) }}</span></li>
                                                                   <li class="text-muted d-flex justify-content-between">FixMaster Royalty :<span> ₦ {{ number_format( $fixmaster_royalty ) }}</span></li>
                                                                   <li class="text-muted d-flex justify-content-between">Logistics :<span> ₦ {{ number_format( $logistics ) }}</span></li>
                                                                   <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦ {{ number_format($taxes) }}</span></li>
                                                                <li class="d-flex justify-content-between text-danger">Discount :<span> - ₦ {{ number_format( 0.5 * $logistics ) }}</span></li>
                                                                   <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format($total_cost) }}</span></li>
                                                            </ul>
                                                        </div><!--end col-->
                                                    </div>
                                                    @elseif($invoice->invoice_type === 'RFQ Invoice')
                                                        <div class="table-responsive bg-white shadow rounded">
                                                            <table class="table mb-0 table-center invoice-tb">
                                                                <thead class="bg-light">
                                                                <tr>
                                                                    <th scope="col" class="text-left">#</th>
                                                                    <th scope="col" class="text-left">Component Name</th>
                                                                    <th scope="col" class="text-left">Model Number</th>
                                                                    <th scope="col" class="text-left">Quantity</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($invoice->rfqs->rfqBatches as $item)
                                                                <tr>
                                                                    <td class="text-left">{{ $loop->iteration }}</td>
                                                                    <td class="text-left">{{ $item->component_name }}</td>
                                                                    <td class="text-left">{{ $item->model_number }}</td>
                                                                    <td class="text-left">{{ $item->quantity }}</td>
                                                                </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @elseif ($invoice->invoice_type === 'Supplier Invoice')
                                                        <div class="table-responsive bg-white shadow rounded">
                                                            <table class="table mb-0 table-center invoice-tb">
                                                                <thead class="bg-light">
                                                                <tr>
                                                                    <th scope="col" class="text-left">Supplier Name</th>
                                                                    <th scope="col" class="text-left">Delivery Fee</th>
                                                                    <th scope="col" class="text-left">Delivery Time</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-left">{{ $invoice->rfqs->rfqSupplier->name }}</td>
                                                                        <td class="text-left">₦ {{ number_format($invoice->rfqs->rfqSupplier->devlivery_fee) }}</td>
                                                                        <td class="text-left">{{ Carbon\Carbon::parse($invoice->rfqs->rfqSupplier->delivery_time, 'UTC')->isoFormat('MMMM Do YYYY') }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="table-responsive bg-white shadow rounded mt-3">
                                                            <table class="table mb-0 table-center invoice-tb">
                                                                <thead class="bg-light">
                                                                <tr>
                                                                    <th scope="col" class="text-left">#</th>
                                                                    <th scope="col" class="text-left">Component Name</th>
                                                                    <th scope="col" class="text-left">Model Number</th>
                                                                    <th scope="col" class="text-left">Quantity</th>
                                                                    <th scope="col" class="text-left">Amount</th>
                                                                    <th scope="col" class="text-left">Total</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($invoice->rfqs->rfqBatches as $item)
                                                                    <tr>
                                                                        <td class="text-left">{{ $loop->iteration }}</td>
                                                                        <td class="text-left">{{ $item->component_name }}</td>
                                                                        <td class="text-left">{{ $item->model_number }}</td>
                                                                        <td class="text-left">{{ $item->quantity }}</td>
                                                                        <td class="text-left">₦ {{ number_format($item->amount) }}</td>
                                                                        <td class="text-left">₦ {{ number_format($item->quantity * $item->amount) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-5 ml-auto">
                                                                <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                                                    <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format($invoice->rfqs->total_amount + $invoice->rfqs->rfqSupplier->devlivery_fee) }}</span></li>
{{--                                                                    <li class="text-muted d-flex justify-content-between">Labour Cost :<span> ₦ {{ number_format(3500) }}</span></li>--}}
{{--                                                                    <li class="text-muted d-flex justify-content-between">FixMaster Royalty :<span> ₦ {{ number_format(5000) }}</span></li>--}}
{{--                                                                    <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦ {{ number_format(253) }}</span></li>--}}
{{--                                                                    <li class="text-muted d-flex justify-content-between">Warranty Cost :<span> ₦ {{ number_format(1500) }}</span></li>--}}
{{--                                                                    <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format($invoice->rfqs->total_amount + 3500 + 5000 + 253 + 1500) }}</span></li>--}}
                                                                </ul>
                                                            </div><!--end col-->
                                                        </div>
                                                        @elseif ($invoice->invoice_type === 'Completion Invoice')
                                                        @if($invoice->rfq_id != null)
                                                        <div class="table-responsive bg-white shadow rounded">
                                                            <table class="table mb-0 table-center invoice-tb">
                                                                <thead class="bg-light">
                                                                <tr>
                                                                    <th scope="col" class="text-left">#</th>
                                                                    <th scope="col" class="text-left">Component Name</th>
                                                                    <th scope="col" class="text-left">Model Number</th>
                                                                    <th scope="col" class="text-left">Quantity</th>
                                                                    <th scope="col" class="text-left">Amount</th>
                                                                    <th scope="col" class="text-left">Total</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($invoice->rfqs->rfqBatches as $item)
                                                                    <tr>
                                                                        <td class="text-left">{{ $loop->iteration }}</td>
                                                                        <td class="text-left">{{ $item->component_name }}</td>
                                                                        <td class="text-left">{{ $item->model_number }}</td>
                                                                        <td class="text-left">{{ $item->quantity }}</td>
                                                                        <td class="text-left">₦ {{ number_format($item->amount) }}</td>
                                                                        <td class="text-left">₦ {{ number_format($item->quantity * $item->amount) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @endif

                                                        <div class="table-responsive bg-white shadow rounded mt-3">
                                                            <table class="table mb-0 table-center invoice-tb">
                                                                <thead class="bg-light">
                                                                <tr>
                                                                    <th scope="col" class="text-left" colspan="2">Labour Cost</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-left">Hours worked</td>
                                                                        <td class="text-left">{{$invoice['hours_spent']}} {{ $invoice['hours_spent']>1 ? 'hrs' : 'hr' }} </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Labor</td>
                                                                        <td class="text-left">
                                                                            ₦ {{ number_format($invoice['labour_cost']) }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-5 ml-auto">
                                                                <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                                                    <li class="test-muted d-flex justify-content-between">Subtotal :<span>₦ {{ number_format($invoice['materials_cost'] + $invoice['labour_cost']) }}</span></li>
                                                                   <li class="text-muted d-flex justify-content-between">
                                                                       FixMaster Royalty :
                                                                       @if($get_fixMaster_royalty['amount'] == null)
                                                                       <span> ₦ {{ number_format( $fixmaster_royalty ) }}</span>
                                                                       @endif
                                                                    </li>
                                                                    <li class="text-muted d-flex justify-content-between">Warranty Cost :<span> ₦ {{ number_format($warranty) }}</span></li>
                                                                    <li class="text-muted d-flex justify-content-between">Logistics :<span> ₦ {{ number_format($logistics) }}</span></li>
                                                                    <li class="d-flex justify-content-between text-danger">Booking :<span> - ₦ {{ number_format($invoice->serviceRequest->price->amount) }}</span></li>
                                                                    <li class="d-flex justify-content-between text-danger">Discount :<span> - ₦ {{ number_format( 0.5 * $logistics ) }}</span></li>
                                                                    <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦ {{ number_format($taxes) }}</span></li>
                                                                   <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format( $total_cost ) }}</span></li>
                                                                </ul>
                                                            </div><!--end col-->
                                                        </div>
                                                    @endif

                                                </div>

                                                <form method="POST" action="">
                                                    @csrf
                                                    {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                                                    <input type="hidden" class="d-none" value="" id="email" name="email">
                                                    <input type="hidden" class="d-none" value="" id="client_discount" name="client_discount">
                                                    <input type="hidden" class="d-none" value="" id="client_phone_number" name="client_phone_number">

                                                    {{-- Values are to be provided by the payment gateway using jQuery or Vanilla JS --}}
                                                    <input type="hidden" class="d-none" value="" id="payment_response_message" name="payment_response_message">
                                                    <input type="hidden" class="d-none" value="" id="payment_reference" name="payment_reference">

                                                    <input type="hidden" class="d-none" value="" id="serviceFee" name="service_fee">


                                                    <input type="hidden" class="d-none" value="" id="service_request_id" name="service_request_id">

                                                    <input type="hidden" class="d-none" value="" id="rfq_id" name="rfq_id">

                                                    <input type="hidden" class="d-none" value="" id="invoice" name="invoice">

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
                        </section>
                    </div><!-- card -->

                </div><!-- col -->
            </div><!-- row -->

        </div><!-- container -->
    </div>


@section('scripts')
    <script>
        $(document).ready(function() {

            $('#request-sorting').on('change', function (){
                let option = $("#request-sorting").find("option:selected").val();

                if(option === 'None'){
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Date'){
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Month'){
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                }

                if(option === 'Date Range'){
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                }
            });
        });

    </script>
@endsection

@endsection
