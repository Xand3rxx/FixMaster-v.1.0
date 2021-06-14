@extends('layouts.dashboard')
@section('title', 'Ongoing Consultations -  Technicians')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('technician.index',app()->getLocale()) }}">Dashboard</a></li>
          <li class="breadcrumb-item " aria-current="page">Consultation</li>
            <li class="breadcrumb-item active" aria-current="page">Ongoing</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Ongoing Consultations</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            {{-- <div>
              <h6 class="mg-b-5">Your Most Recent Requests</h6>
            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all <strong>Service Requests</strong> assigned to you by Fixmaster Administrator or Customer Service Executive after careful understudy of each request and with assumed initial payments made by the clients</p>
            </div> --}}

          </div><!-- card-header -->
          <div class="card-body pd-y-30">
            <div class="d-sm-flex">
              <div class="media">
                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                  <i data-feather="bar-chart-2"></i>
                </div>
                <div class="media-body">
                  <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Total Request</h6>
                  <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">2</h4>
                </div>
              </div>

            </div>
          </div><!-- card-body -->
          <div class="table-responsive">

              <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Job ID</th>
                      <th>Service Category</th>
                      <th>CSE</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td class="tx-color-03 tx-center">1</td>
                        <td class="tx-medium">REF-79A722D6</td>
                        <td class="tx-medium">Unavailable</td>
                        <td class="tx-medium">kenneth</td>
                        <td class="tx-medium"><button class="btn btn-sm" style="background-color: #E97D1F; color:#fff">Details</button></td>
                    </tr>

                    <tr>
                        <td class="tx-color-03 tx-center">2</td>
                        <td class="tx-medium">REF-79A722S5</td>
                        <td class="tx-medium">Unavailable</td>
                        <td class="tx-medium">Samuel</td>
                        <td class="tx-medium"><button class="btn btn-sm" style="background-color: #E97D1F; color:#fff">Details</button></td>
                    </tr>
                  </tbody>
                </table>




          </div><!-- table-responsive -->
        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->


  </div><!-- container -->
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/dashboard/assets/js/qa-payments-sortings.js') }}"></script>
 <script>
    $(document).ready(function() {


    });

</script>
@endsection

