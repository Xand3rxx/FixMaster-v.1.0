@extends('layouts.dashboard')
@section('title', 'Customer Service Executive Dashboard')

@include('layouts.partials._messages')
@section('content')
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
                <p class="tx-12 tx-color-03 mg-b-0">Ratings is based on 152 total votes by Customer reviews on the quality of service provided by you.</p>

              </div><!-- card-header -->

              <div class="card-body pd-0">
                <div class="pd-t-10 pd-b-15 pd-x-20 d-flex align-items-baseline">
                  <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5">{{ !empty(round($profile['ratings']->avg('star'))) ? round($profile['ratings']->avg('star')) : '0' }}</h1>
                    <div class="tx-18">
                      @for ($i = 0; $i < round($profile['ratings']->avg('star')); $i++)
                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                      @endfor
                      @for ($x = 0; $x < (5 - round($profile['ratings']->avg('star'))); $x++)
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                      @endfor
                    </div>
                </div>

              </div><!-- card-body -->
            </div>
            <div class="col-md-6">
              <div class="card-body pd-t-10 pd-b-15 pd-x-20 mt-2">
                <h6 class="lh-5 mg-b-5">Your current Earnings is:<h1 class="tx-normal tx-rubik mg-b-0 mg-r-5"> ₦0.00 </h1>
                </h6>
              </div>
            </div>
          </div>

        </div><!-- card -->
      </div>

      <div class="col-lg-12 col-xl-12">
        <div class="card">
          <div class="card-body pd-lg-25">
            <div class="row">
              <x-card cardtitle="Completed Jobs" :cardnumber="$completed" />
              <x-card cardtitle="Ongoing Jobs" :cardnumber="$ongoing" />
              <x-card cardtitle="Canceled Jobs" :cardnumber="$canceled" />
            </div>
          </div>
        </div><!-- card -->
      </div>

      <div class="col-md-12 col-xl-12 mg-t-10">
        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
          <div>
            <h6 class="mg-b-5">Pending Requests</h6>
            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all <strong>Available Pending Request </strong> </p>
          </div>
        </div><!-- card-header -->
        <div class="table-responsive">
          <table class="table table-hover mg-b-0" id="dashboardTable">
            <thead class="thead-primary">
              <tr>
                <th class="text-center">#</th>
                <th>Job ID</th>
                <th class="text-left">Service Category</th>
                <th>Job Address </th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($available_requests as $service_request)
              <tr>
                <td class="tx-color-03 tx-center">{{$loop->iteration}}</td>
                <td class="tx-medium">{{$service_request['unique_id']}}</td>
                <td class="text-left tx-medium">{{$service_request['service']['category']['name'] ?? "UNAVAILABLE"}}</td>
                <td class="tx-medium"> {{$service_request['address']['address']}} </td>
                <td class="tx-medium tx-center">
                  <a href="javascript:void(0);" data-service="{{$service_request["uuid"]}}" class="btn btn-primary btn-sm btn-accept-service-request">Accept <i class="fas fa-check"></i></a>
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
<form id="accept-service-request-form" action="{{ route('cse.accept-job', app()->getLocale()) }}" method="POST" style="display: none;">
  @csrf
  <input id="accept_service_request" type="hidden" name="service_request_uuid" value="0">
</form>


@push('scripts')
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

    $('.btn-accept-service-request').on('click', function(e) {
      e.preventDefault()
      if (confirm('Are you sure?')) {
        $('#accept_service_request').val($(this).data('service'))
        $('#accept-service-request-form').submit();
      }
      return false;
    });
  });
</script>
@endpush

@endsection