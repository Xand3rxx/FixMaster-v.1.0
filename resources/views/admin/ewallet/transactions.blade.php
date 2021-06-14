@extends('layouts.dashboard')
@section('title', 'E-Wallet Transactions List')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">E-Wallet Transactions List</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">E-Wallet Transactions List</h4>
        </div>
      </div>

      <div class="row row-xs">

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">E-Wallet Transactions as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster E-Wallet Tranactions.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                <div class="row mt-1 mb-1 ml-1 mr-1">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sort</label>
                            <select class="custom-select" id="request-sorting">
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
                            <input name="name" id="name" type="date" class="form-control pl-5">
                        </div>
                    </div>
        
                    <div class="col-md-4 date-range d-none">
                        <div class="form-group position-relative">
                            <label>To <span class="text-danger">*</span></label>
                            <input name="name" id="name" type="date" class="form-control pl-5">
                        </div>
                    </div>
                </div>

                <table class="table table-hover mg-b-0" id="basicExample">
                    <thead class="thead-primary">
                      <tr>
                        <th class="text-center">#</th>
                        <th>Client</th>
                        <th>Wallet ID</th>
                        <th class="text-center">Transaction Type</th>
                        <th class="text-center">Payment Type</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Status</th>
                        <th>Date Created</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    @foreach($walletTransactions as $k=>$val)
                        <tr>
                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                            <td class="tx-medium">{{ $val['user']['account']['last_name'] ." ". $val['user']['account']['first_name'] }}</td>
                            <td class="tx-medium">{{$val['unique_id']}}</td>
                            <td class="tx-medium">{{ $val['transaction_type'] }}</td>
                            <td class="tx-medium">{{ $val['payment_type'] }}</td>
                            <td class="tx-medium">{{ $val['amount'] ?? 0 }}</td>
                            <td class="text-medium text-success">{{is_null($val['user']['deleted_at']) ? 'Active' : InActive}}</td>
                            <td class="text-medium">{{ Carbon\Carbon::parse($val->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                            <td class=" text-center">
                                <div class="dropdown-file">
                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                    
                                    <a href="#view{{$val['id'] }}" data-toggle="modal" class="dropdown-item details text-primary" title="View WAL-23782382 details"><i class="far fa-clipboard"></i> Details</a>
                    
                                    </div>
                                </div>
                            </td>
                        </tr>




        <div class="modal fade" id="view{{$val['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static"> 
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content tx-14">
                <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2">E-Wallet Transaction Details</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                   
                <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
                <div class="form-group col-md-12">
                        <label for="Client">Client : </label>  
                        <input type="text" readonly class="form-control" value="{{ $val['user']['account']['last_name'] ." ". $val['user']['account']['first_name'] }}" autocomplete="off">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="Unique">Unique ID</label>
                        <input type="text" readonly class="form-control" value="{{$val['unique_id']}}" autocomplete="off">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="percentage">Reference No</label>
                        <input type="text" readonly class="form-control" value="{{$val['reference_id  ']}}" autocomplete="off">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="percentage">Transaction ID.</label>
                        <input type="text" readonly class="form-control" value="{{$val['transaction_id ']}}" autocomplete="off">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="percentage">Payment Channel</label>
                        <input type="text" readonly class="form-control" value="{{$val['payment_channel ']}}" autocomplete="off">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="percentage">Payment For</label>
                        <input type="text" readonly class="form-control" value="{{$val['payment_for ']}}" autocomplete="off">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="percentage">Amount</label>
                        <input type="text" readonly class="form-control" value="{{$val['amount ']}}" autocomplete="off">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="percentage">Status</label>
                        <input type="text" readonly class="form-control" value="{{$val['status ']}}" autocomplete="off">
                    </div>

                    <!-- <div class="form-group col-md-12">
                        <label for="percentage">Refund Reason</label>
                        <input type="text" class="form-control" value="{{$val['reference_id '] }}" autocomplete="off">
                    </div> -->


                </div>




                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div><!-- modal-footer -->

            </div><!-- modal-content --> --}}
        </div><!-- modal-dialog -->
        </div><!-- modal -->






                        
                    @endforeach

                    </tbody>
                  </table>
              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

                        <!-- modal -->
    <!-- <div class="modal fade" id="transactionDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static"> -->
    <div class="modal fade" id="view{{$val['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static"> 
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel2">E-Wallet Transaction Details</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-sm mg-b-0">
                    <tbody>
                        <tr>
                            <td class="tx-medium" width="25%">Client</td>
                            <td class="tx-color-03" width="75%">Kelvin Adesanya</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Unique ID</td>
                            <td class="tx-color-03" width="75%">WAL-23782382</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Reference No.</td>
                            <td class="tx-color-03" width="75%">32e3lh2e23083h432b</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Transaction ID.</td>
                            <td class="tx-color-03" width="75%">Transaction ID returned on success should be displayed here only if payment gateway was used or UNAVAILABLE</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Transaction Type</td>
                            <td class="tx-color-03" width="75%">Credit</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Payment Type</td>
                            <td class="tx-color-03" width="75%"3">Funding</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Payment Channel</td>
                            <td class="tx-color-03" width="75%"3">Paystack or Flutterwave or Offline or Wallet</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Payment For</td>
                            <td class="tx-color-03" width="75%"3">Wallet</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Amount</td>
                            <td class="tx-color-03" width="75%">₦{{ number_format(10000) }}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Status</td>
                            <td class="text-success" width="75%">Success</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Refund Reason</td>
                            <td class="tx-color-03" width="75%">This section should only be visible in a case of refund, the reason should be displayed here or UNAVAILABLE</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div><!-- modal-body -->
            <div class="modal-footer"></div>
        </div>
        </div>
    </div>
<!-- modal -->



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