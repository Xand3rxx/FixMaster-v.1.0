@extends('layouts.dashboard')
@section('title', 'Quality Assurance Payments')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('quality-assurance.index',app()->getLocale()) }}">Dashboard</a></li>
          <li class="breadcrumb-item " aria-current="page">Consultation</li>
            <li class="breadcrumb-item active" aria-current="page">Pending</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Pending Consultations</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
          </div>
          <div class="card-body pd-y-30">
            <div class="d-sm-flex">
              <div class="media">
                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                  <i data-feather="bar-chart-2"></i>
                </div>
                <div class="media-body">
                  <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Total Request</h6>
                  <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">{{$pendingConsults->count()}}</h4>
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
                    @php $sn = 1; @endphp
                    @foreach($pendingConsults as $data)
                    <tr>
                        <td class="tx-color-03 tx-center">{{$sn++}}</td>
                        <td class="tx-medium">{{$data->service_request->unique_id}}</td>
                        <td class="tx-medium">{{$data->service_request->service->category->name}}</td>
                         @foreach($data->service_request->users as $res)
                            @if ($res->type->role->name === 'Customer Service Executive')
                            <td class="tx-medium">{{ $res->account->first_name.' '.$res->account->last_name }}</td>
                            @endif
                         @endforeach

                        <td>
                            <a href="{{ route('quality-assurance.consultations.pending_details', [$data->service_request->uuid, 'locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm">Details</a>
                        </td>
                    </tr>
                    @endforeach
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

