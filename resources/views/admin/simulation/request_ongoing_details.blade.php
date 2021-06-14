@extends('layouts.dashboard')
@section('title', 'Ongoing Request Details')
@include('layouts.partials._messages')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Ongoing Requests</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ongoing Request Details</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Job: {{$serviceRequests['id']}}</h4><hr>
                    <div class="media align-items-center">
            <span class="tx-color-03 d-none d-sm-block">
              {{-- <i data-feather="credit-card" class="wd-60 ht-60"></i> --}}
              <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar rounded-circle" alt="Male Avatar">
            </span>
                        <div class="media-body mg-sm-l-20">
                            <h4 class="tx-18 tx-sm-20 mg-b-2"></h4>
                            <p class="tx-13 tx-color-03 mg-b-0"></p>
                        </div>
                    </div><!-- media -->
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12">
                    <form method="POST" action="{{ route('admin.rfq_update', app()->getLocale()) }}">
                        @csrf
                        <input type="hidden" value="{{ $serviceRequests['client_id'] }}" name="client_id" required>
                        <input type="hidden" value="{{ $serviceRequests['id'] }}" name="service_request_id" required>

                        <div class="form-row mt-4">
                            <div class="tx-13 mg-b-25">

                                @if($requestDetail->rfq()->where('status', 'Pending')->count() > 0)

                                    <h3>Price Tagging</h3>
                                    <section>
                                        <p class="mg-b-0">Allocate prices received from the Supplier to generate a Pro forma invoice</p>
                                        <small class="text-danger">This portion will display only if the CSE initially executed a RFQ</small>

                                        <div class="mt-4 form-row">
                                            <div class="form-group col-md-4">
                                                <label for="name">Supplier's Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" name="name">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="devlivery_fee">Delivery Fee</label>
                                                <input type="tel" class="form-control amount @error('devlivery_fee') is-invalid @enderror" id="devlivery_fee" name="devlivery_fee" value="{{ old('devlivery_fee') }}">
                                                @error('devlivery_fee')
                                                <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="delivery_time">Delivery Time</label>
                                                <input type="text" min="{{ \Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm') }}" class="form-control @error('delivery_time') is-invalid @enderror" name="delivery_time" id="service-date-time" value="{{ old('delivery_time') }}" readonly>
                                                @error('delivery_time')
                                                <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if(!empty($requestDetail->rfq->rfqBatches))
                                            @foreach($requestDetail->rfq->rfqBatches as $batch)
                                                <input type="hidden" value="{{ $batch->rfq_id }}" name="rfq_id" required>

                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="component_name">Component Name</label>
                                                        <input type="text" class="form-control" id="component_name" name="component_name" value="{{ old('component_name') ?? $batch->component_name }}" readonly>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="model_number">Model Number</label>
                                                        <input type="text" class="form-control" id="model_number" name="model_number" value="{{ old('model_number') ?? $batch->model_number }}" readonly>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="quantity">Quantity</label>
                                                        <input type="number" class="form-control" id="quantity" name="quantity[]" value="{{ old('quantity') ?? $batch->quantity }}" min="{{ $batch->quantity }}" max="{{ $batch->quantity }}" readonly>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="amount">Total Amount</label>
                                                        <input type="tel" class="form-control amount" id="amount" placeholder="" value="{{ old('amount') }}" name="amount[]" autocomplete="off">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </section>
                                @else

                                    <h3>New RFQ</h3>
                                    <section>
                                        <p class="mg-b-0">A request for quotation is a business process in which a company or public entity requests a quote from a supplier for the purchase of specific products or services.</p>
                                        <h4 id="section1" class="mt-4 mb-2">Initiate RFQ?</h4>

                                        <div class="form-row mt-4">
                                            <div class="form-group col-md-4">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="rfqYes" name="intiate_rfq" value="yes">
                                                    <label class="custom-control-label" for="rfqYes">Yes</label><br>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 d-flex align-items-end">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="rfqNo" name="intiate_rfq" value="no">
                                                    <label class="custom-control-label" for="rfqNo">No</label><br>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-none d-rfq">
                                            <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="component_name">Component Name</label>
                                                    <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name') }}">
                                                    @error('component_name')
                                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="model_number">Model Number</label>
                                                    <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number') }}">
                                                    @error('model_number')
                                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="\d*" maxlength="2" value="{{ old('quantity') }}">
                                                    @error('quantity')
                                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-1 mt-1">
                                                    <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5" ></i></button>
                                                </div>
                                            </div>

                                            <span class="add-rfq-row"></span>

                                        </div>
                                    </section>
                                @endif
                                </div>
                            </div>
                        <button type="submit" class="btn btn-primary" id="update-progress">Update Progress</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="toolsRequestDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel2">Tools Request</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <!-- Modal displays here -->
                    <div id="spinner-icon"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rfqDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content tx-14">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel2">RFQ Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-rfq-details">
                    <!-- Modal displays here -->
                    <div id="spinner-icon"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function(){
                'use strict'

                $('#wizard3').steps({
                    headerTag: 'h3',
                    bodyTag: 'section',
                    autoFocus: true,
                    titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
                    loadingTemplate: '<span class="spinner"></span> #text#',
                    labels: {
                        // current: "current step:",
                        // pagination: "Pagination",
                        finish: "Update Job Progress",
                        // next: "Next",
                        // previous: "Previous",
                        loading: "Loading ..."
                    },
                    stepsOrientation: 1,
                    // transitionEffect: "fade",
                    // transitionEffectSpeed: 200,
                    showFinishButtonAlways: false,
                    onFinished: function (event, currentIndex) {
                        $('#update-progress').trigger('click');
                    },
                });

                let count = 1;

                //Add and Remove Request for
                $(document).on('click', '.add-rfq', function(){
                    count++;
                    addRFQ(count);
                });

                $(document).on('click', '.remove-rfq', function(){
                    count--;
                    $(this).closest(".remove-rfq-row").remove();
                    // $(this).closest('tr').remove();
                });

                //Add and Remove Tools request form
                $(document).on('click', '.add-trf', function(){
                    count++;
                    addTRF(count);
                });

                $(document).on('click', '.remove-trf', function(){
                    count--;
                    $(this).closest(".remove-trf-row").remove();
                });

                //Hide and Unhide Work Experience form
                $('#work_experience_yes').change(function () {
                    if ($(this).prop('checked')) {
                        $('.previous-employment').removeClass('d-none');
                    }
                });

                $('#work_experience_no').change(function () {
                    if ($(this).prop('checked')) {
                        $('.previous-employment').addClass('d-none');
                    }
                });

                //Hide and Unhide RFQ
                $('#rfqYes').change(function () {
                    if ($(this).prop('checked')) {
                        $('.d-rfq').removeClass('d-none');
                    }
                });

                $('#rfqNo').change(function () {
                    if ($(this).prop('checked')) {
                        $('.d-rfq').addClass('d-none');
                    }
                });

                //Hide and Unhide TRF
                $('#trfYes').change(function () {
                    if ($(this).prop('checked')) {
                        $('.d-trf').removeClass('d-none');
                    }
                });

                $('#trfNo').change(function () {
                    if ($(this).prop('checked')) {
                        $('.d-trf').addClass('d-none');
                    }
                });

                $(document).on('click', '#tool-request-details', function(event) {
                    event.preventDefault();
                    let route = $(this).attr('data-url');
                    let batchNumber = $(this).attr('data-batch-number');

                    $.ajax({
                        url: route,
                        beforeSend: function() {
                            $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                        },
                        // return the result
                        success: function(result) {
                            $('#modal-body').modal("show");
                            $('#modal-body').html('');
                            $('#modal-body').html(result).show();
                        },
                        complete: function() {
                            $("#spinner-icon").hide();
                        },
                        error: function(jqXHR, testStatus, error) {
                            var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
                            var type = 'error';
                            displayMessage(message, type);
                            $("#spinner-icon").hide();
                        },
                        timeout: 8000
                    })
                });

                $(document).on('click', '#rfq-details', function(event) {
                    event.preventDefault();
                    let route = $(this).attr('data-url');
                    let batchNumber = $(this).attr('data-batch-number');

                    $.ajax({
                        url: route,
                        beforeSend: function() {
                            $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                        },
                        // return the result
                        success: function(result) {
                            $('#modal-body-rfq-details').modal("show");
                            $('#modal-body-rfq-details').html('');
                            $('#modal-body-rfq-details').html(result).show();
                        },
                        complete: function() {
                            $("#spinner-icon").hide();
                        },
                        error: function(jqXHR, testStatus, error) {
                            var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
                            var type = 'error';
                            displayMessage(message, type);
                            $("#spinner-icon").hide();
                        },
                        timeout: 8000
                    })
                });

                $('.close').click(function (){
                    $(".modal-backdrop").remove();
                });

            });

            function addRFQ(count){

                let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="component_name">Component Name</label> <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name') }}"> @error('component_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label for="model_number">Model Number</label> <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number') }}"> @error('model_number') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="quantity">Quantity</label> <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" placeholder="" value="{{ old('quantity') }}"> @error('quantity') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';

                $('.add-rfq-row').append(html);

            }

            //Get available quantity of a particular tool.
            $(document).on('change', '.tool_id', function () {
                let toolId = $(this).find('option:selected').val();
                let toolName = $(this).children('option:selected').text();
                let quantityName = $(this).children('option:selected').data('id');

                $.ajax({
                    url: "",
                    method: "POST",
                    dataType: "JSON",
                    data: {"_token": "{{ csrf_token() }}", "tool_id":toolId},
                    success: function(data){
                        if(data){

                            $('#'+quantityName+'').attr({
                                "value": data,
                                "max": data,
                            });

                        }else{
                            var message = 'Error occured while trying to get '+ toolName +' available quantity';
                            var type = 'error';
                            displayMessage(message, type);
                        }
                    },
                })
            });

        </script>
    @endpush

@endsection
