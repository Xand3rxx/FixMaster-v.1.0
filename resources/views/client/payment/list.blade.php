@extends('layouts.client')
@section('title', 'Payments')
@section('content')
    @include('layouts.partials._messages')


    <div class="col-lg-8 col-12">
        <div class="border-bottom pb-4 row">

            <div class="col-md-4 mt-4">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Transactions</h4>
                        <p class="text-muted mb-0">3</p>
                    <!-- {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}} -->
                    </div>
                </div>

            </div>

            <div class="col-md-4 mt-4">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Amount Spent</h4>
                        <p class="text-muted mb-0">₦30,000.00</p>
                    <!-- {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}} -->
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Amount Recieved</h4>
                        <p class="text-muted mb-0">₦84,560.00</p>
                    <!-- {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}} -->
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content mt-3" id="pills-tabContent">
            <!-- payment options ends here -->
            <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                <h5 class="mb-0">All Payments Transactions</h5>
                <div class="table-responsive mt-4 bg-white rounded shadow">
                    <div class="row mt-1 mb-1 ml-1 mr-1">
                        <div class="col-md-4">
                            <div class="form-group position-relative">
                                <label>Sort Table</label>
                                <select class="form-control custom-select" id="request-sorting">
                                    <option value="None">Select...</option>
                                    <option value="Date">Date</option>
                                    <option value="Month">Month</option>
                                    <option value="Date Range">Date Range</option>
                                </select>
                            </div>
                        </div><!--end col-->

                        <div class="col-md-4 specific-date d-none">
                            <div class="form-group position-relative">
                                <label>Specify Date <span class="text-danger">*</span></label>
                                <i data-feather="calendar" class="fea icon-sm icons"></i>
                                <input name="name" id="name" type="date" class="form-control pl-5">
                            </div>
                        </div>

                        <div class="col-md-4 sort-by-year d-none">
                            <div class="form-group position-relative">
                                <label>Specify Year <span class="text-danger">*</span></label>
                                <select class="form-control custom-select" id="Sortbylist-Shop">
                                    <option>Select...</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 sort-by-year d-none">
                            <div class="form-group position-relative">
                                <label>Specify Month <span class="text-danger">*</span></label>
                                <select class="form-control custom-select" id="Sortbylist-Shop">
                                    <option>Select...</option>
                                    <option>January</option>
                                    <option>February</option>
                                    <option>March</option>
                                    <option>April</option>
                                    <option>May</option>
                                    <option>June</option>
                                    <option>July</option>
                                    <option>August</option>
                                    <option>September</option>
                                    <option>October</option>
                                    <option>November</option>
                                    <option>December</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 date-range d-none">
                            <div class="form-group position-relative">
                                <label>From <span class="text-danger">*</span></label>
                                <i data-feather="calendar" class="fea icon-sm icons"></i>
                                <input name="name" id="name" type="date" class="form-control pl-5">
                            </div>
                        </div>

                        <div class="col-md-4 date-range d-none">
                            <div class="form-group position-relative">
                                <label>To <span class="text-danger">*</span></label>
                                <i data-feather="calendar" class="fea icon-sm icons"></i>
                                <input name="name" id="name" type="date" class="form-control pl-5">
                            </div>
                        </div>
                    </div>

                    <table class="table table-center table-padding mb-0" id="basicExample">
                        <thead>
                        <tr>
                            <th class="py-3">#</th>
                            <th class="py-3">Job/Wallet Ref</th>
                            <th class="py-3">Reference No</th>
                            <th class="py-3">Transaction ID</th>
                            <th class="py-3">Payment For</th>
                            <th class="py-3">Amount(₦)</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Transacation Date</th>
                            <th class="py-3">Action</th>

                            {{-- <th class="py-3">Balance</th> --}}
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                                <td>{{$payment->unique_id}}</td>
                                <td>{{$payment->reference_id}}</td>
                                <td>{{$payment->transaction_id == null ? 'UNAVAILABLE' : $payment->transaction_id  }}</td>
                                <td class="font-weight-bold">{{$payment->payment_for}}</td>
                                <td>{{$payment->amount}}</td>

                                @if($payment->status=='success')
                                    <td class="text-center text-success">Success</td>
                                @elseif($payment->status=='pending')
                                    <td class="text-center text-danger">Pending</td>
                                @elseif($payment->status=='failed')
                                    <td class="text-center text-warning">Failed</td>
                                @elseif($payment->status=='timeout')
                                    <td class="text-center text-info">Timeout</td>
                                @endif

                                <td>{{ Carbon\Carbon::parse($payment->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                <td><a href="#" data-toggle="modal" data-target="#transactionDetails" data-payment-ref="{{ $payment->unique_id }}" data-url="{{ route('client.payment.details', ['payment' => $payment->id, 'locale' => app()->getLocale()]) }}" id="payment-details" class="btn btn-primary btn-sm ">Details</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>

        </div>


        <div class="modal fade" id="transactionDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content tx-14">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel2">E-Wallet Transaction Details</h6>
                    <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                    <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20" id="modal-body">

                        <div id="spinner-icon"></div>
                  </div><!-- modal-body -->
                <div class="modal-footer"></div>
              </div>
            </div>
        </div>



    </div><!--end col-->

@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#payment-details', function(event) {
                event.preventDefault();
                let route = $(this).attr('data-url');
                let paymentRef = $(this).attr('data-payment-ref');

                $.ajax({
                    url: route,
                    beforeSend: function() {
                        $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
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
                        var message = error+ ' An error occured while trying to retireve '+ paymentRef +' record.';
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
    </script>

@endsection

@endsection
