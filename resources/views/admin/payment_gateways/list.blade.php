@extends('layouts.dashboard')
@section('title', 'List of payment gateways')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Payment Gateway List</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Payment Gateway List</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="text-danger mg-b-5">Only authorised personnels should be allowed to use the action options on this page</h6>
            </div>
            
          </div><!-- card-header -->
         


          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <form action="{{ route('admin.paystack_update', app()->getLocale()) }}" method="post">
                   {{ csrf_field() }}
                  <div class="card-header">
                      <div class="row">
                          <div class="col-lg-12">
                              <div class="card-title">Paystack</div>
                          </div>
                      </div>
                  </div>
                  <div class="card-body pt-5 pb-5">
                    <div class="row">
                      <div class="col-lg-12">
                         {{ csrf_field() }}
          
                        <div class="form-group">
                          <label>Paystack</label>
                          <div class="selectgroup">
                            <label class="selectgroup-item">
                              <input type="radio" name="status" value="1" class="selectgroup-input" {{$paystack->status == 1 ? 'checked' : ''}}>
                              <span class="selectgroup-button">Activate</span>
                            </label>
                            <label class="selectgroup-item">
                              <input type="radio" name="status" value="0" class="selectgroup-input" {{$paystack->status == 0 ? 'checked' : ''}}>
                              <span class="selectgroup-button">Deactivate</span>
                            </label>
                          </div>
                        </div>
                        @php
                            $paystackInfo = json_decode($paystack->information, true);
                            // dd($paystackInfo);
                        @endphp
                        <div class="form-group">
                          <label>Paystack Public Key</label>
                          <input class="form-control" name="public_key" value="{{$paystackInfo['public_key']}}">
                          @if ($errors->has('public_key'))
                            <p class="mb-0 text-danger">{{$errors->first('public_key')}}</p>
                          @endif
                        </div>
                        <div class="form-group">
                          <label>Paystack Private Key</label>
                          <input class="form-control" name="private_key" value="{{$paystackInfo['private_key']}}">
                          @if ($errors->has('private_key'))
                            <p class="mb-0 text-danger">{{$errors->first('private_key')}}</p>
                          @endif
                        </div>
          
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="form">
                      <div class="form-group from-show-notify row">
                        <div class="col-12 text-center">
                          <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          
          
            <div class="col-lg-6">
              <div class="card">
                <form action="{{ route('admin.flutter_update', app()->getLocale()) }}" method="post">
                   {{ csrf_field() }}
                  <div class="card-header">
                      <div class="row">
                          <div class="col-lg-12">
                              <div class="card-title">Flutter</div>
                          </div>
                      </div>
                  </div>
                  <div class="card-body pt-5 pb-5">
                    <div class="row">
                      <div class="col-lg-12">
                         {{ csrf_field() }}
                        @php
                            $flutterInfo = json_decode($flutter->information, true);
                            // dd($flutterInfo);
                        @endphp
                        <div class="form-group">
                            <label>Flutter</label>
                            <div class="selectgroup">
                              <label class="selectgroup-item">
                                <input type="radio" name="status" value="1" class="selectgroup-input" {{$flutter->status == 1 ? 'checked' : ''}}>
                                <span class="selectgroup-button">Activate</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="status" value="0" class="selectgroup-input" {{$flutter->status == 0 ? 'checked' : ''}}>
                                <span class="selectgroup-button">Deactivate</span>
                              </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Flutter public Key</label>
                            <input class="form-control" name="public_key" value="{{$flutterInfo['public_key']}}">
                            @if ($errors->has('key'))
                                <p class="mb-0 text-danger">{{$errors->first('public_key')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Flutter private Key</label>
                            <input class="form-control" name="private_key" value="{{$flutterInfo['private_key']}}">
                            @if ($errors->has('secret'))
                                <p class="mb-0 text-danger">{{$errors->first('private_key')}}</p>
                            @endif
                        </div>
          
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="form">
                      <div class="form-group from-show-notify row">
                        <div class="col-12 text-center">
                          <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          
          </div>

          
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