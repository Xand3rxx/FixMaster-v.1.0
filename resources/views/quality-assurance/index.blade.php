@extends('layouts.dashboard')
@section('title', 'Quality Assurance Manager Dashboard')

@include('layouts.partials._messages')
@section('content')

<style>
  .qa-style {
    background-color: #E97D1F;
    border-radius: 15px;
  }
</style>

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Welcome to Fix<span style="color: #E97D1F;">Master</span> {{ Auth::user()->type->role->name ?? 'Customer Service Executive' }} Dashboard</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12">
        <div class="card">
          <div class="form-row">
            <div class="col-md-6">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="lh-5 mg-b-5">Overall Rating</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Ratings is based on {{ Auth::user()->ratings->count() }} total votes by CSE's and Customer reviews on the quality of service provided by you.</p>

          </div><!-- card-header -->

              <div class="card-body pd-0">
                <div class="pd-t-10 pd-b-15 pd-x-20 d-flex align-items-baseline">
                    <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5">{{round(Auth::user()->ratings->avg('star'))}}</h1>
                    <div class="tx-18">
                        @if(round(Auth::user()->ratings->avg('star')) == 1)
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        @elseif(round(Auth::user()->ratings->avg('star')) == 2)
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        @elseif(round(Auth::user()->ratings->avg('star')) == 3)
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        @elseif(round(Auth::user()->ratings->avg('star')) == 4)
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        @elseif(round(Auth::user()->ratings->avg('star')) == 5)
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                        @else
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        @endif
                        </div>
                </div>

              </div><!-- card-body -->
            </div>
            <div class="col-md-6">
              <div class="card-body pd-t-10 pd-b-15 pd-x-20 mt-2">
                <h6 class="lh-5 mg-b-5">Your current Earnings is:<h1 class="tx-normal tx-rubik mg-b-0 mg-r-5"> ₦{{number_format($QApayments, 0)}} </h1> </h6>
              </div>
            </div>
          </div>
        </div><!-- card -->
      </div>

      <div class="col-lg-12 col-xl-12">
        <div class="card">
          <div class="card-body pd-lg-25">
            <div class="row">
              <x-card cardtitle="Completed Jobs" cardnumber="{{$completedJobs}}" />
              <x-card cardtitle="Ongoing Jobs" cardnumber="{{$ongoingJobs}}" />
              <x-card cardtitle="Pending Consultations" cardnumber="{{$pendingConsultations->count()}}" />
              <x-card cardtitle="Completed Consultations" cardnumber="{{$completedConsultations}}" />
              <x-card cardtitle="Ongoing Consultations" cardnumber="{{$ongoingConsultations}}" />
            </div>
          </div>
        </div><!-- card -->
      </div>

      <div class="col-md-12 col-xl-12 mg-t-10">

        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
          <div>
            <h6 class="mg-b-5">Pending Consultations</h6>
            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all <strong>Available Pending Request </strong> </p>
          </div>

        </div><!-- card-header -->

        <div class="table-responsive">
          <table class="table table-hover mg-b-0" id="dashboardTable">
            <thead class="thead-primary">
              <tr>
                <th class="text-center">#</th>
                <th>Job ID</th>
                <th class="text-center">Service Category</th>
                <th>Job Address </th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            @php $sn = 1; @endphp
            <tbody>
                @foreach($pendingConsultations as $request)
              <tr>
                <td class="tx-color-03 tx-center">{{$sn++}}</td>
                <td class="tx-medium">{{$request->service_request->unique_id}}</td>
                <td class="text-center tx-medium">{{$request->service_request->service->category->name}}</td>
                <td class="tx-medium">{{$request->service_request->address->address}}</td>
                <td class="tx-medium tx-center">
                  <a href="{{ route('quality-assurance.consultations.pending_details', [$request->service_request->uuid, 'locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm" >Details</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- table-responsive -->

      </div>


    </div><!-- row -->
  </div><!-- container -->
</div>


@section('scripts')
<script>
  $(document).ready(function() {

    $('#dashboardTable').DataTable({
      responsive: true,
      "iDisplayLength": 10,
      "language": {
        "lengthMenu": '_MENU_ items/page',
        "zeroRecords": "No matching records found",
        "info": "Showing page _PAGE_ of _PAGES_",
        "infoEmpty": "No records available",
        "infoFiltered": "(filtered from _MAX_ total records)"
      },
      "processing": true,
    });

    $('#request-sorting').on('change', function() {
      let option = $("#request-sorting").find("option:selected").val();

      if (option === 'None') {
        $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
      }

      if (option === 'Date') {
        $('.specific-date').removeClass('d-none');
        $('.sort-by-year, .date-range').addClass('d-none');
      }

      if (option === 'Month') {
        $('.sort-by-year').removeClass('d-none');
        $('.specific-date, .date-range').addClass('d-none');
      }

      if (option === 'Date Range') {
        $('.date-range').removeClass('d-none');
        $('.specific-date, .sort-by-year').addClass('d-none');
      }
    });
  });
</script>
@endsection

@endsection
