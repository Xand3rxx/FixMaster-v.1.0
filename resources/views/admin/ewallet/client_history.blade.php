@extends('layouts.dashboard')
@section('title', 'E-Wallet Client Transaction History')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.ewallet.clients', app()->getLocale()) }}">Clients</a></li>
              <li class="breadcrumb-item active" aria-current="page">E-Wallet Transactions History</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">{{ !empty($transaction['account']['first_name']) ? Str::title($transaction['account']['first_name'] .' '. $transaction['account']['last_name']) : 'UNAVAILABLE' }}'s E-Wallet Transactions History</h4>
        </div>
      </div>

      <div class="row row-xs">

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">{{ !empty($transaction['account']['first_name']) ? Str::title($transaction['account']['first_name'] .' '. $transaction['account']['last_name']) : 'UNAVAILABLE' }}'s E-Wallet Transactions as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster E-Wallet Tranactions.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                {{-- <div class="row mt-1 mb-1 ml-1 mr-1">
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
                </div> --}}

                <table class="table table-hover mg-b-0" id="basicExample">
                    <thead class="thead-primary">
                      <tr>
                        <th class="text-center">#</th>
                        <th>Reference No.</th>
                        <th>Transaction ID</th>
                        <th class="text-center">Transaction Type</th>
                        <th class="text-center">Payment Type</th>
                        <th class="text-center">Amount(₦)</th>
                        <th class="text-center">Status</th>
                        <th>Date Created</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction['client']['walletTransactions'] as $item)
                        <tr>
                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                            <td class="tx-medium">{{ !empty($item['payment']['reference_id']) ? $item['payment']['reference_id'] : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($item['payment']['transaction_id']) ? $item['payment']['transaction_id'] : 'UNAVAILABLE' }}</td>
                            <td class="text-center">{{ ucfirst($item['transaction_type']) }}</td>
                            <td class="text-center">{{ ucfirst($item['payment_type']) }}</td>
                            <td class="tx-medium text-center">{{ number_format($item['amount']) }}</td>
                            <td class="text-center {{ (($item['payment']['status'] == 'pending') ? 'text-warning' : (($item['payment']['status'] == 'success') ? 'text-success' : (($item['payment']['status'] == 'timeout') ? 'text-danger' : 'text-danger'))) }} ">{{ ucfirst($item['payment']['status']) }}</td>
                            <td>{{ Carbon\Carbon::parse($item['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                            <td class=" text-center">
                            <div class="dropdown-file">
                                <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                
                                <a href="#transactionDetails" id="wallet-transaction-detail" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $transaction['client']['unique_id'] }} transaction details" data-url="{{ route('admin.ewallet.history.details', ['history'=>$item->id, 'locale'=>app()->getLocale()]) }}"><i class="far fa-clipboard"></i> Details</a>
                
                                </div>
                            </div>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                  </table>
              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

<div class="modal fade" id="transactionDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel2">E-Wallet Transaction Details</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20" id="modal-body">
            
          </div><!-- modal-body -->
        <div class="modal-footer"></div>
      </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/dashboard/assets/js/e7475718-5047-4404-a117-ef35a0dfc1c9.js') }}"></script>
@endpush

@endsection