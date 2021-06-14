@extends('layouts.dashboard')
@section('title', Auth::user()->type->role->name.' Dashboard' ?? 'Technicians & Artisans Dashboard')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item active">Dashboard</li>
            {{-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> --}}
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Welcome to Fix<span style="color: #E97D1F;">Master</span> {{ Auth::user()->type->role->name ?? 'Quality Assurance' }} Dashboard</h4>
        {{-- <h4 class="mg-b-0 tx-spacing--1">Welcome  Dashboard</h4> --}}
      </div>
      {{-- <div class="d-none d-md-block">
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button>
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="upload" class="wd-10 mg-r-5"></i> Export</button>
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button>
        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="sliders" class="wd-10 mg-r-5"></i> Settings</button>
      </div> --}}
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12">
        <div class="card">
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


          <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
            <div>
              <h6 class="mg-b-5">Service Request Metrics</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Requests made since inception.</p>
            </div>


            <div class="btn-group mg-t-20 mg-sm-t-0">
              {{-- <button class="btn btn-xs btn-white btn-uppercase">Day</button>
              <button class="btn btn-xs btn-white btn-uppercase">Month</button>
              <button class="btn btn-xs btn-white btn-uppercase active">Year</button> --}}

            </div><!-- btn-group -->
          </div><!-- card-header -->
          <div class="card-body pd-lg-25">
            <div class="row align-items-sm-end">
              <div class="col-lg-7 col-xl-8">
                <div class="chart-six"><canvas id="chartBar1"></canvas></div>
              </div>
              <div class="col-lg-5 col-xl-4 mg-t-30 mg-lg-t-0">
                <div class="row">
                  <div class="col-sm-6 col-lg-12">
                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                      <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Total Requests</h6>
                      {{-- <span class="tx-10 tx-color-04">65</span> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mg-b-5">
                      <h5 class="tx-normal tx-rubik lh-2 mg-b-0">25</h5>
                      {{-- <h6 class="tx-normal tx-rubik tx-color-03 lh-2 mg-b-0">20,000</h6> --}}
                    </div>
                    <div class="progress ht-4 mg-b-0 op-5">
                      <div class="progress-bar bg-teal wd-25p" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-12 mg-t-30 mg-sm-t-0 mg-lg-t-30">
                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                      <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Completed Requests</h6>
                    </div>
                    <div class="d-flex justify-content-between mg-b-5">
                      <h5 class="tx-normal tx-rubik mg-b-0">20</h5>
                    </div>
                    <div class="progress ht-4 mg-b-0 op-5">
                      <div class="progress-bar bg-orange wd-20p" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-12 mg-t-30">
                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                      <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Canceled Requests</h6>
                      {{-- <span class="tx-10 tx-color-04">20% goal reached</span> --}}
                    </div>
                    <div class="d-flex justify-content-between mg-b-5">
                      <h5 class="tx-normal tx-rubik mg-b-0">5</h5>
                      {{-- <h5 class="tx-normal tx-rubik tx-color-03 mg-b-0"><small>85,000</small></h5> --}}
                    </div>
                    <div class="progress ht-4 mg-b-0 op-5">
                      <div class="progress-bar bg-pink wd-5p" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-12 mg-t-30">
                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                      <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Payments Received</h6>
                      {{-- <span class="tx-10 tx-color-04">85% goal reached</span> --}}
                    </div>
                    <div class="d-flex justify-content-between mg-b-5">
                      <h5 class="tx-normal tx-rubik mg-b-0">{{Auth::user()->payments->count()}}</h5>
                      {{-- <h5 class="tx-normal tx-rubik tx-color-03 mg-b-0"><small>30.50%</small></h5> --}}
                    </div>
                    <div class="progress ht-4 mg-b-0 op-5">
                      <div class="progress-bar bg-primary wd-{{Auth::user()->payments->count()}}p" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div><!-- row -->

              </div>
            </div>
          </div><!-- card-body -->
        </div><!-- card -->
      </div>

      <div class="col-md-12 col-xl-12 mg-t-10">
        <div class="card ht-100p">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">Recent Payments</h6>
            {{-- <div class="d-flex tx-18">
              <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
              <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
            </div> --}}
          </div>
          @if(Auth::user()->payments->count() > 0)
          <ul class="list-group list-group-flush tx-13">
       @foreach(Auth::user()->payments as $payment)
            <li class="list-group-item d-flex pd-sm-x-20">
              <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
              <div class="pd-sm-l-10">
                <p class="tx-medium mg-b-0">Payment from FixMaster for {{$payment->service_request->job_reference}} job</p>
                <small class="tx-12 tx-color-03 mg-b-0">{{$payment->payment_date}}</small>
              </div>
              <div class="mg-l-auto text-right">
                <p class="tx-medium mg-b-0"> ₦{{number_format($payment->amount)}}</p>
                <small class="tx-12 tx-success mg-b-0">Completed</small>
              </div>
            </li>
        @endforeach
          </ul>
          <div class="card-footer text-center tx-13">
          <a href="{{ route('quality-assurance.payments',app()->getLocale()) }}" class="link-03">View All Transactions <i class="icon ion-md-arrow-down mg-l-5"></i></a>
          </div><!-- card-footer -->
          @else
          <div class="card-footer text-center tx-13">
            <h6 class="text-center">No Recent Payments</h6>
          </div>
          @endif
        </div><!-- card -->
      </div>


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
