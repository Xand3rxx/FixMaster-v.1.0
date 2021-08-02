<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" /> --}}
    <meta name="description"
          content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@homefix.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">

    <!-- vendor css -->
    <link href="{{ asset('assets/dashboard/lib/fontawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.dashboard.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4-custom.css') }}" />
    <link href="{{ asset('assets/dashboard/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/client/css/jquery.datetimepicker.min.css') }}">
    <link href="{{ asset('assets/client/css/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/client/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    @yield('css')

    <style>
        div.dt-buttons {
            margin-top: 1em;
            margin-left: 1.5em;
        }

        button.dt-button,
        div.dt-button,
        a.dt-button,
        input.dt-button {
            font-size: inherit !important;
            color: #fff !important;
            background-color: #E97D1F !important;
            background: linear-gradient(to bottom, rgb(233 125 31) 0%, rgb(233 125 31) 100%);
            border-color: #E97D1F !important;
            display: inline-block !important;
            font-weight: 400 !important;
            text-align: center !important;
            vertical-align: middle !important;
            user-select: none !important;
            background-color: transparent !important;
            border: 1px solid transparent !important;
            padding: 0.46875rem 0.9375rem !important;
            font-size: 0.875rem !important;
            line-height: 1.5 !important;
            border-radius: 0.25rem !important;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
            line-height: 1.5 i !important;
            text-decoration: none;
            outline: none;
            text-overflow: ellipsis;
        }

        button.dt-button:hover,
        div.dt-button:hover,
        a.dt-button:hover,
        input.dt-button:hover {
            color: #fff !important;
            background-color: #E97D1F !important;
            background: linear-gradient(to bottom, rgb(233 125 31) 0%, rgb(233 125 31) 100%);
            border-color: #E97D1F !important;
        }

    </style>


</head>

<body>

<section class="bg-invoice mb-5">
    <div class="container">
        <div class="row mt-5 pt-4 pt-sm-0 justify-content-center">
            <div class="col-lg-10">

                @if(auth()->user()->type->url === 'admin')
                    <div class="py-4">
                        <a href="{{route('admin.invoices', app()->getLocale())}}" class="btn btn-outline-primary"><i class="fa fa-arrow-left"></i> Return to invoices
                        </a>
                    </div>
                @else
                    @if($invoice->status == '1' && $invoice['phase'] == '2')
                        <div class="py-4">
                            <input id="invoice_uuid" type="hidden" name="invoiceUUID" value="{{ $invoice['uuid'] }}">
                            <input id="client-return" type="hidden" name="route" value="{{ route('client.return', app()->getLocale()) }}">
                            <button id="return-btn" href="{{route('client.service.all', app()->getLocale())}}" class="btn btn-outline-primary mr-2">
                                <i class="fa fa-arrow-left"></i> Go Back to Pay for {{$invoice['invoice_type'] === 'Diagnosis Invoice' ? 'Final' : 'Diagnosis'}} Invoice
                            </button>
                        </div>
                    @else
                        <div class="py-4">
                            <a href="{{route('client.service.all', app()->getLocale())}}" class="btn btn-outline-primary"><i class="fa fa-arrow-left"></i> Return to service request
                            </a>
                        </div>
                    @endif
                @endif
                <div class="card shadow rounded border-0">
                    <div class="card-body">
                        <div class="invoice-top pb-4 border-bottom">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" class="l-dark" style="margin-top: 10px !important;" height="80" alt="FixMaster Logo">
                                    <div class="logo-invoice mb-2">
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
                            @if($invoice['status'] === '2' && $invoice['phase'] == '2')
                            <div class="d-flex justify-content-start">
                                <img src="{{asset('assets/images/paystampss.png')}}" style="width: 200px; height: 100px">
                            </div>
                            @endif
                            <div class="d-flex justify-content-center">
                                <h2 style="border: 2px solid grey; padding: 5px">{{$invoice['invoice_type']}}</h2>
                            </div>
                        </div>

                        <div class="invoice-middle py-4">
                            <div class="row mb-0">
                                <div class="col-md-6 order-md-1">
                                    <dl class="row mb-0">
                                        <dt class="col-md-4 col-5 font-weight-normal">Report To. :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice['client']->account->first_name }} {{ $invoice['client']->account->last_name }}</dd>

                                        <dt class="col-md-4 col-5 font-weight-normal">Customer No. :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice['client']['contact']['phone_number'] }}</dd>

                                        <dt class="col-md-4 col-5 font-weight-normal">Customer Email :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice['client']['email'] }}</dd>

                                        <dt class="col-md-4 col-5 font-weight-normal">Service Location :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice['client']['contact']['address'] }}</dd>
                                    </dl>
                                </div>

                                <div class="col-md-6 order-md-2 mt-2">
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Order No. :</dt>
                                        <dd class="col-md-6 col-7 text-muted">{{ $invoice['unique_id'] }}</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Order Date. :</dt>
                                        <dd class="col-md-6 col-7 text-muted">{{ Carbon\Carbon::parse($invoice['serviceRequest']['created_at'], 'UTC')->isoFormat('MMMM Do, YYYY') }}</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Assigned CSE. :</dt>
                                        <dd class="col-md-6 col-7 text-muted">{{ $service_request_assigned['user']['account']['first_name'].' '. $service_request_assigned['user']['account']['last_name'] }}</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Visit Date. :</dt>
                                        <dd class="col-md-6 col-7 text-muted">Friday 10th May, 2021</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Report Issuance Date :</dt>
                                        <dd class="col-md-6 col-7 text-muted">Monday 10th May, 2021</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="py-3">
                            <span class="font-weight-bold text-uppercase">Invoice Details :</span>

                            <div class="mt-5">
                            <h5 class="font-weight-bold text-uppercase">{{$invoice['serviceRequest']['service']['category']['name']}}: </h5>
                            <div class="card shadow rounded my-2">
                                <div class="card-body">
                                    <h5 class="card-title">Root Cause:</h5>
                                    <p class="card-text">{{ $root_cause }}</p>
                                </div>
                            </div>
                            <div class="card shadow rounded">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-center">Other Comments</h5>
                                    <p class="card-text">{{ $other_comments }}</p>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="py-3">
                            <span class="font-weight-bold text-uppercase">Quotation  Schedule:</span>
                        </div>
                        @if($invoice['invoice_type'] === 'Final Invoice')
                            @if($invoice['rfq_id'] !== null)
                            <div class="table-responsive bg-white shadow rounded">
                                <table class="table mb-0 table-center invoice-tb">
                                    <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="text-left" style="width: 80px">S/N</th>
                                        <th scope="col" class="text-left" style="width: 200px">Materials</th>
                                        <th scope="col" class="text-left" style="width: 200px">Quantity</th>
                                        <th scope="col" class="text-left">Unit of Measurement</th>
                                        <th scope="col" class="text-left">Unit Price</th>
                                        <th scope="col" class="text-left">Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice['rfqs']['rfqBatches'] as $item)
                                        <tr>
                                            <td class="text-left">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $item->component_name }}</td>
                                            <td class="text-left">{{ $item->quantity }}</td>
                                            <td class="text-left">{{ $item->unit_of_measurement }}</td>
                                            <td class="text-left">₦ {{ number_format($item->amount/$item->quantity + $item->amount/$item->quantity*$materialsMarkup, 2) }}</td>
                                            <td class="text-left">₦ {{ number_format($item['amount'] + $item['amount']*$materialsMarkup, 2)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th class="text-left" colspan="5">Total Material Cost</th>
                                        <th class="text-left">₦ {{ number_format($materialsMarkupPrice, 2) }}</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                                <div class="table-responsive bg-white shadow rounded mt-3">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <tbody>
                                        <tr>
                                            <th scope="col" class="text-left" colspan="5" style="width: 580px">Supplier Delivery Fee:</th>
                                            <th scope="col" class="text-left">₦ {{ number_format($supplierDeliveryFee, 2) }}</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif


                                <div class="table-responsive bg-white shadow rounded mt-4">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left" style="width: 80px">S/N</th>
                                            <th scope="col" class="text-left" style="width: 200px">Labour</th>
                                            <th scope="col" class="text-left" style="width: 200px">Quantity</th>
                                            <th scope="col" class="text-left" colspan="2" style="width: 210px">Cost</th>
                                            <th scope="col" class="text-left">Sub Totals</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($labourCosts as $labourCost)
                                            <tr>
                                                <td class="text-left">{{$loop->iteration }}</td>
                                                <td class="text-left">{{$labourCost['subService']['name']}}</td>
                                                <td class="text-left">{{$labourCost['quantity']['quantity']}}</td>
                                                <td class="text-left" colspan="2">₦ {{number_format($labourCost['subService']['labour_cost'] + $labourCost['subService']['labour_cost'] * $labourMarkup, 2)}}</td>
                                                <td class="text-left">₦ {{number_format($labourCost['amount'], 2)}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th class="text-left" colspan="5">Total Labour Cost</th>
                                            <th class="text-left">₦ {{number_format($totalLabourCost, 2)}}</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive bg-white shadow rounded mt-3">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <tbody>
                                        <tr>
                                            <th scope="col" class="text-left" colspan="5" style="width: 580px">FixMaster Royalty:</th>
                                            <th scope="col" class="text-left">₦ {{number_format($fixMasterRoyalty, 2)}}</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="text-left" colspan="5" style="width: 580px">Logistics Cost</th>
                                            <th scope="col" class="text-left">₦ {{number_format($logistics, 2)}}</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                        @elseif($invoice['invoice_type'] === 'Diagnosis Invoice')
                            <div class="table-responsive bg-white shadow rounded mt-4">
                                <table class="table mb-0 table-center invoice-tb">
                                    <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="text-left">S/N</th>
                                        <th scope="col" class="text-left">Name</th>
                                        <th scope="col" class="text-left">Est. Hours Worked</th>
                                        <th scope="col" class="text-left">Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-left">1</td>
                                        <td class="text-left">Diagnostic Charge</td>
                                        <td class="text-left">{{ $invoice['hours_spent'] }}</td>
                                        <td class="text-left">₦ {{ number_format($subTotal) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                            <div class="row my-4">
                                <div class="col-lg-6 col-md-6 ml-auto">
                                    <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">

    @if($invoice['invoice_type'] == 'Final Invoice')

{{--    <li class='text-muted d-flex justify-content-between'>Subtotal :<span>₦ {{number_format($subTotal, 2)}} </span></li>--}}
    <li class='text-muted d-flex justify-content-between my-2'>Total Job Quotation :<span>₦ {{ number_format($totalQuotation, 2) }}</span></li>
    <li class='d-flex justify-content-between text-danger my-2'>Less Booking Fee :<span>- ₦ {{ number_format($bookingFee, 2) }}</span></li>
{{--    <li class='d-flex justify-content-between mt-2'>Amount Due :<span>₦ {{ number_format($amountDue, 2) }}</span></li>--}}
{{--    <hr>--}}
    @if($invoice['serviceRequest']['client_discount_id'] != null)
    <li class='text-muted d-flex justify-content-between mt-2'>Discounts : </li>
    <li class='d-flex justify-content-between text-danger mb-2'>First Booking Discount (50%) :<span>- ₦ {{ number_format($discount, 2) }}</span></li>
    @endif

    <li class='text-muted d-flex justify-content-between my-2'>Warranty </li>
    <li class='text-muted d-flex justify-content-between my-2'>
        <span>{{ $warranty['name'] }} <strong>({{ $warranty['duration'] }} Days)</strong> :</span><span>₦ {{ number_format($warrantyCost, 2) }}</span>
    </li>
    <li class='text-muted d-flex justify-content-between my-2'>VAT :<span>₦ {{ number_format($vat, 2) }}</span></li>
    <li class='d-flex justify-content-between my-2'>Total Amount Due :<span>₦ {{ number_format($totalAmount, 2) }}</span></li>
    @else
    <li class='text-muted d-flex justify-content-between'>Subtotal :<span>₦  {{number_format($subTotal, 2)}}</span></li>
    <li class='text-muted d-flex justify-content-between'>FixMaster Royalty :<span>₦ {{number_format($fixMasterRoyalty, 2)}}</span></li>
    <li class='d-flex justify-content-between text-danger'>Less Booking Fee :<span>- ₦ {{ number_format($bookingFee, 2) }}</span></li>
    <li class='d-flex justify-content-between my-2'>Amount Due :<span>₦ {{ number_format($amountDue, 2) }}</span></li>
    <li class='text-muted d-flex justify-content-between mb-2'>VAT :<span>₦ {{ number_format($vat, 2) }}</span></li>
    <li class='d-flex justify-content-between'>Total Amount Due :<span>₦ {{ number_format($totalAmount, 2) }}</span></li>
    @endif


                                    </ul>
                                </div><!--end col-->
                            </div>
                    </div>


                    <div class="d-flex justify-content-center py-3">

                        @if(auth()->user()->type->url === 'admin')
                            <a href="{{route('admin.invoices', app()->getLocale())}}" class="btn btn-outline-primary">Return to invoices</a>
                        @else
                            @if($invoice->status == '1' && $invoice['phase'] == '1')
                                <div id="client-decision">
                                    <input id="decision-route" type="hidden" name="route" value="{{ route('client.decline', app()->getLocale()) }}">
                                    <input id="client-accept" type="hidden" name="route" value="{{ route('client.accept', app()->getLocale()) }}">
                                    <input id="invoice_uuid" type="hidden" name="invoiceUUID" value="{{ $invoice['uuid'] }}">
                                    {{--                            <button class="btn btn-outline-primary" id="client_accept" name="client_choice">Client Accept</button>--}}
                                    <a href="#" data-toggle="modal" data-target="#clientAccept" data-payment-ref="" data-url="" id="payment-details" class="btn btn-outline-primary ">Click to Pay for final invoice</a>
                                    <button class="btn btn-outline-primary" id="client_decline" name="client_choice">Click here to reject final invoice</button>
                                    <div id="msg"></div>
                                </div>
                            @elseif($invoice->status == '1' && $invoice['phase'] == '2')
                                {{--                            @if($invoice['invoice_type'] === 'Diagnosis Invoice')--}}
                                {{--                            @endif--}}
                                <form method="POST" action="{{ route('client.invoice_payment', app()->getLocale()) }}">
                                    @csrf
                                    {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                                    {{--                                <input type="hidden" class="d-none" value="paystack" id="payment_channel" name="payment_channel">--}}
                                    <input type="hidden" class="d-none" value="{{$totalAmount}}" name="booking_fee">
                                    <input type="hidden" class="d-none" value="{{$service_request_assigned['user_id']}}" name="cse_assigned">
                                    <input type="hidden" class="d-none" value="{{$technician_assigned['user_id']}}" name="technician_assigned">
                                    <input type="hidden" class="d-none" value="{{$invoice['rfqs']['rfqSupplier']['supplier_id'] ?? null}}" name="supplier_assigned">
                                    <input type="hidden" class="d-none" value="{{$qa_assigned['user_id'] ?? null}}" name="qa_assigned">

                                    <input type="hidden" class="d-none" value="{{$logistics}}" id="logistics_cost" name="logistics_cost">
                                    <input type="hidden" class="d-none" value="{{$retention_fee}}" id="retention_fee" name="retention_fee">
                                    <input type="hidden" class="d-none" value="{{$vat}}" id="tax" name="tax">
                                    <input type="hidden" class="d-none" value="{{$actual_labour_cost}}" id="actual_labour_cost" name="actual_labour_cost">
                                    <input type="hidden" class="d-none" value="{{$actual_material_cost}}" id="actual_material_cost" name="actual_material_cost">
                                    <input type="hidden" class="d-none" value="{{$labour_markup}}" id="labour_markup" name="labour_markup">
                                    <input type="hidden" class="d-none" value="{{$material_markup}}" id="material_markup" name="material_markup">
                                    <input type="hidden" class="d-none" value="{{$fixMasterRoyalty}}" id="fixMasterRoyalty" name="fixMasterRoyalty">
                                    <input type="hidden" class="d-none" value="{{ $warrantyCost }}" id="warrantyCost" name="warrantyCost">

                                    <input type="hidden" class="d-none" value="invoice" id="payment_for" name="payment_for">
                                    <input type="hidden" class="d-none" value="{{ $invoice['unique_id'] }}" id="unique_id" name="unique_id">
                                    <input type="hidden" class="d-none" value="{{ $invoice['invoice_type'] }}" id="invoice_type" name="invoice_type">
                                    <input type="hidden" class="d-none" value="{{ $invoice['uuid'] }}" id="uuid" name="uuid">
                                    <button type="submit" id="payment_channel"  class="btn btn-outline-primary" name="payment_channel" value="paystack">
                                        <div>
                                            Click here to pay with
                                        </div>
                                        <div>
                                            <label for="paystack" class="pplogo-container" style="cursor:pointer;">
                                                <img class="img-fluid" alt="paystack" src="{{ asset('assets/images') }}/paystack.png" width="100" height="20">
                                            </label>
                                        </div>
                                    </button>
                                    <button type="submit" id="payment_channel"  class="btn btn-outline-primary" name="payment_channel" value="flutterwave">
                                        <div>
                                            Click Here to pay with
                                        </div>
                                        <div>
                                            <label for="paystack" class="pplogo-container" style="cursor:pointer;">
                                                <img class="img-fluid" alt="flutterwave" src="{{ asset('assets/images') }}/flutter.png" width="100" style="height:px">
                                            </label>
                                        </div>
                                    </button>
                                </form>

                            @elseif($invoice['status'] === '2' && $invoice['phase'] == '2')
                                <a href="{{route('client.service.all', app()->getLocale())}}" class="btn btn-outline-primary">Return to Service Requests</a>
                            @endif
                        @endif

                    </div>

                    <div class="invoice-footer border-top py-3 px-3">
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
                    <div class="modal fade" id="clientAccept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="true" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content tx-14">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel2">Select Warranty Type</h6>
                                    <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                                <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20" id="modal-body">
                                    <div class="container">
                                        <div class="mb-4">
                                            <span>Selected warranty will be applied on the final invoice</span>
                                        </div>
                                        <form method="POST" action="{{ route('client.warranty_decision', ['locale' => app()->getLocale(), 'invoice' => $invoice['uuid']]) }}">
                                            @csrf
                                            @method('PUT')
{{--                                            <div class="form-group">--}}
{{--                                                <div class="custom-control custom-radio">--}}
{{--                                                    <input class="custom-control-input" type="radio" name="warranty_id" id="inlineRadio{{ $warranty->id }}" value="{{ $warranty->id }}" data-warranty-id="{{$warranty->id}}"  @if($invoice['warranty_id'] === $warranty['id']) checked @endif >--}}
{{--                                                    <label class="custom-control-label" for="inlineRadio{{ $warranty->id }}">{{ $warranty->name }} - (₦ {{ number_format($warranty->percentage/100 * ($invoice['materials_cost'] + $invoice['labour_cost']), 2) }})</label><br>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            @foreach($ActiveWarranties as $ActiveWarranty)
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" name="warranty_id" id="inlineRadio{{ $ActiveWarranty->id }}" value="{{ $ActiveWarranty->id }}" data-warranty-id="{{$ActiveWarranty->id}}" @if($invoice['warranty_id'] === $ActiveWarranty['id']) checked @endif >
                                                        <label class="custom-control-label" for="inlineRadio{{ $ActiveWarranty->id }}">{{ $ActiveWarranty->name }} - (₦ {{ number_format($ActiveWarranty->percentage/100 * ($subTotal), 2) }}) <strong>Valid for {{$ActiveWarranty['duration']}} days</strong> </label><br>
                                                    </div>
                                                </div>
                                        @endforeach


                                    </div>
                                </div><!-- modal-body -->
                                <div class="modal-footer">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
    </div><!--end container-->
</section>

<script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/scrollspy.min.js')}}"></script>
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
<script src="{{ asset('assets/client/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/client/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Datepicker -->
<script src="{{ asset('assets/client/js/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('assets/client/js/moment.js') }}"></script>
<script src="{{ asset('assets/client/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/client/js/polyfill.js') }}"></script>
<script src="https://unicons.iconscout.com/release/v2.1.9/script/monochrome/bundle.js"></script>
<script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/jquery.tinymce.min.js') }}"></script>
</body>

    <script src="{{asset('assets/frontend/js/invoice/client_decision.js')}}"></script>

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
            $('.close').click(function (){
                $(".modal-backdrop").remove();
            });
        });

    </script>
