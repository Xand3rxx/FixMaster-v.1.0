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

    /* item list */

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

</style>


<div class="col-lg-8 col-12">
    <div class="border-bottom pb-4 row">
        {{-- <h5>Femi Joseph</h5>
        <p class="text-muted mb-0">I have started my career as a trainee and prove my self and achieve all the milestone with good guidance and reach up to the project manager. In this journey, I understand all the procedure which make me a good developer, team leader, and a project manager.</p>--}}
        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">paystack</h4>
                <p class="text-muted mb-0">3</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>

        </div>

        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Amount Spent</h4>
                    <p class="text-muted mb-0">₦30,000.00</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Amount Recieved</h4>
                    <p class="text-muted mb-0">₦84,560.00</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>
        </div>
    </div> 

 

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12 mt-4 pt-2 text-center">
                <div class="media">                                        
                    <div class="media-body content">
                    <p class="text-muted location-time"><span class="text-dark h6">You are about to pay the sum of</span></p>
                        <h4><a href="javascript:void(0)" class="text-dark title">₦ {{$pay->amount}} </a></h4> 
                        
                        <p class="text-muted location-time"><span class="text-dark h6">Via Paystack</span></p>
                                              
                        <form class="mb-5" method="post" action="{{ route('client.ipn.paystack', app()->getLocale()) }}">
                          @csrf     
                          <button type="submit" class="btn btn-lg btn-outline-primary mouse-down btn-block">
                            Click to complete the transaction
                          </button>    
                        <!-- <a href="#" class="btn btn-lg btn-outline-primary mouse-down">Click to complete the transaction</a> -->
                        </form>
                    </div>
                </div>
        </div>
    </div>

    
</div><!--end col-->

@section('scripts')

@endsection

@endsection