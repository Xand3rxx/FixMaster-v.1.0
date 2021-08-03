@extends('layouts.client')
@section('title', 'E-Wallet')
@section('content')
@include('layouts.partials._messages')

<style>
    [type=radio] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* IMAGE STYLES */
    [type=radio] + img {
        cursor: pointer;
    }

    /* CHECKED STYLES */
    [type=radio]:checked + img {
        outline: 2px solid #E97D1F;
        outline-style: dashed;
    }

    .vodiapicker{
        display: none;
    }

    #a{
        padding-left: 0px;
    }

    #a img, .btn-select img{
        width: 45px;
    }

    #a li{
        list-style: none;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    #a li:hover{
    background-color: #F4F3F3;
    }

    #a li img{
        margin-left: 15px;
    }

    #a li span, .btn-select li span{
        margin-left: 30px;
    }

    .b{
        display: none;
        width: 100%;
        /* max-width: 350px; */
        max-width: 335px;
        box-shadow: 0 6px 12px rgba(0,0,0,.175);
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 5px;
        position: absolute;
        z-index: 1000;
    }

    .open{
        display: show !important;
    }

    .btn-select{
        margin-top: 10px;
        width: 100%;
        max-width: 350px;
        height: 42px;
        border-radius: 5px;
        background-color: #fff;
        border: 1px solid #ccc;
    }
    .btn-select li{
        list-style: none;
        float: left;
        padding-bottom: 0px;
    }

    .btn-select:hover li{
        margin-left: 0px;
    }

    .btn-select:hover{
        background-color: #F4F3F3;
        border: 1px solid transparent;
        box-shadow: inset 0 0px 0px 1px #ccc;
    }

    .btn-select:focus{
        outline:none;
    }

    .lang-select{
        margin-top: -10px;
    }
    .avatar.avatar-ex-smm {
        max-height: 75px;
    }
</style>


<div class="col-lg-8 col-12">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12 mt-4 pt-2 text-center">
            <ul class="nav nav-pills nav-justified flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link rounded active" id="fund-account-tab" data-toggle="pill" href="#fund-account" role="tab" aria-controls="fund-account" aria-selected="false">
                        <div class="text-center pt-1 pb-1">
                            <h4 class="title font-weight-normal mb-0">Fund Account</h4>
                        </div>
                    </a><!--end nav link-->
                </li><!--end nav item-->

                <li class="nav-item">
                    <a class="nav-link rounded" id="transactions-tab" data-toggle="pill" href="#transactions" role="tab" aria-controls="transactions" aria-selected="false">
                        <div class="text-center pt-1 pb-1">
                            <h4 class="title font-weight-normal mb-0">Transactions</h4>
                        </div>
                    </a><!--end nav link-->
                </li><!--end nav item-->
            </ul><!--end nav pills-->
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="fund-account" role="tabpanel" aria-labelledby="fund-account-tab">
          <!-- payment options starts here -->
        <div class="border-bottom pb-4 row">
        <span class="ml-4">Click on either Flutterwave or Paystack to fund your wallet account.</span>
        @foreach($gateways as $val)
            <div class="col-md-6 mt-4">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <a href="#" data-toggle="modal" data-target="#modal-form{{$val->id}}" >
                    <img src="{{ asset('assets/images') }}/{{$val->name}}.png" class="avatar avatar-ex-smm" alt="">
                </a>
                    <a href="javascript:void(0)" class="text-primary">
                    <div class="media-body content ml-3">
                    <a href="#" style="color: #333 !important" data-toggle="modal" data-target="#modal-form{{$val->id}}">
                        {{-- <h4 class="title mb-0">{{ ucfirst($val->name) }}</h4> --}}
                    </a>
                    </div>
                    </a>
                </div>
            </div>

            <div class="modal fade" id="modal-form{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content tx-14">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formModal">E-Wallet Account Funding</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <div class="card-header bg-transparent pb-5">
                        <div class="text-muted text-center"><small>Deposit Via</small></div>
                            <div class="btn-wrapper text-center">
                                <span class="btn-inner--icon"><img class="avatar avatar-ex-smm" src="{{ asset('assets/images') }}/{{$val->name}}.png"></span>
                            </div>
                        </div>
                    <div class="modal-body">
                            <form role="form" action="{{ route('client.wallet.submit', app()->getLocale()) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">NGN</span>
                                    </div>
                                    <input type="number" step="any" class="form-control @error('amount') is-invalid @enderror" placeholder="" name="amount" required>
                                    @error('amount')
                                        <x-alert :message="$message" />
                                    @enderror
                                    <input type="hidden" name="gateway" value="{{ $val->id }}">
                                    <input type="hidden" name="payment_channel" value="{{ strtolower($val->keyword) }}">
                                    <input type="hidden" name="payment_for" value="e-wallet">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">Pay</button>
                            </div>
                            </form>
                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- payment options ends here -->




        <div class="tab-pane fade show" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
            <h5 class="mb-0">Transactions</h5>
            <div class="table-responsive mt-4 bg-white rounded shadow">
                {{-- <div class="row mt-1 mb-1 ml-1 mr-1">
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
                </div> --}}

                <table class="table table-center table-padding mb-0" id="basicExample">
                    <thead>
                        <tr>
                            <th class="py-3">#</th>
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
                    @foreach($mytransactions as $k=>$val)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ !empty($val->reference_id )? $val->reference_id : 'UNAVAILABLE' }}</td>
                            <td>{{ !empty($val->transaction_id) ? $val->transaction_id : 'UNAVAILABLE' }}</td>
                            <td class="font-weight-bold">{{ ucfirst($val->payment_for) }}</td>
                            <td>{{ number_format($val->amount) }}</td>

                            @if($val->status=='success')
                            <td class="text-center text-success">Success</td>
                            @elseif($val->status=='pending')
                            <td class="text-center text-danger">Pending</td>
                            @elseif($val->status=='failed')
                            <td class="text-center text-warning">Failed</td>
                            @elseif($val->status=='timeout')
                            <td class="text-center text-info">Timeout</td>
                            @endif

                             <td>{{ Carbon\Carbon::parse($val->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td> 
                            <td><a href="#transactionDetails" data-toggle="modal" class="btn btn-primary btn-sm ">Details</a></td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>


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
            <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-sm mg-b-0">
                    <tbody>
                        <tr>
                            <td class="tx-medium" width="25%">Unique ID</td>
                            <td class="tx-color-03" width="75%">{{$val->unique_id}}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Reference No.</td>
                            <td class="tx-color-03" width="75%">{{$val->reference_id}}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Transaction ID.</td> 
                            <td class="tx-color-03" width="75%">{{$val->transaction_id}}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Transaction Type</td>
                            <td class="tx-color-03" width="75%">{{$val->wallettransactions[0]->transaction_type ?? 'Not Available'}}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Payment Type</td> 
                            <td class="tx-color-03" width="75%">{{$val->wallettransactions[0]->transaction_type ?? 'Not Available'}}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Payment Channel</td> 
                            <td class="tx-color-03" width="75%">{{$val->payment_channel}}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Payment For</td>
                            <td class="tx-color-03" width="75%">{{$val->payment_for}}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Amount</td>
                            <td class="tx-color-03" width="75%">₦{{ number_format($val->amount) }}</td>
                        </tr>
                        <tr>
                            <td class="tx-medium" width="25%">Status</td>
                            <td class="text-warning" width="75%">{{$val->status}}</td>
                        </tr>
                        <!-- <tr>
                            <td class="tx-medium" width="25%">Refund Reason</td>
                            <td class="tx-color-03" width="75%">This section should only be visible in a case of refund, the reason should be displayed here or UNAVAILABLE</td>
                        </tr> -->
                    </tbody>
                    </table>
                </div>
              </div><!-- modal-body -->
            <div class="modal-footer"></div>
          </div>
        </div>
    </div>



</div><!--end col-->

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

        //test for getting url value from attr
    // var img1 = $('.test').attr("data-thumbnail");
    // console.log(img1);

    //test for iterating over child elements
    var langArray = [];
    $('.vodiapicker option').each(function(){
        var img = $(this).attr("data-thumbnail");
        var text = this.innerText;
        var value = $(this).val();
        var item = '<li><img src="'+ img +'" alt="" value="'+value+'"/><span>'+ text +'</span></li>';
        langArray.push(item);
    })

    $('#a').html(langArray);

    //Set the button value to the first el of the array
    $('.btn-select').html(langArray[0]);
    $('.btn-select').attr('value', 'en');

    //change button stuff on click
    $('#a li').click(function(){
        var img = $(this).find('img').attr("src");
        var value = $(this).find('img').attr('value');
        var text = this.innerText;
        var item = '<li><img src="'+ img +'" alt="" /><span>'+ text +'</span></li>';
        $('.btn-select').html(item);
        $('.btn-select').attr('value', value);
        $(".b").toggle();
        //console.log(value);
    });

    $(".btn-select").click(function(){
            $(".b").toggle();
    });

    //check local storage for the lang
    var sessionLang = localStorage.getItem('lang');
    if (sessionLang){
        //find an item with value of sessionLang
        var langIndex = langArray.indexOf(sessionLang);
        $('.btn-select').html(langArray[langIndex]);
        $('.btn-select').attr('value', sessionLang);
        } else {
        var langIndex = langArray.indexOf('ch');
        // console.log(langIndex);
        $('.btn-select').html(langArray[langIndex]);
        //$('.btn-select').attr('value', 'en');
    }



    });
</script>

@endsection

@endsection
