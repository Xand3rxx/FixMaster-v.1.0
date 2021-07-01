@extends('layouts.dashboard')
@section('title', 'CSE Diagnosis Rating')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Rating</li>
              <li class="breadcrumb-item active" aria-current="page">Job Performance Rating</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Job Performance Rating</h4>
        </div>
      </div>

      <div class="row row-xs">

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Job Diagnosis Ratings as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Job Diagnosis Ratings authored by Clients.</p>
                </div>

              </div><!-- card-header -->

              <div class="table-responsive">

                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Client</th>
                      <th>CSE</th>
                      <th>Service</th>
                      <th class="text-center">Job Reference</th>
                      <th class="text-center">Job Diagnosis Rating(5)</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $sn = 1; @endphp
                @foreach($diagnosisRatings as $rating)
                    <tr>
                      <td class="tx-color-03 tx-center">{{$sn++}}</td>
                      <td class="tx-medium">{{$rating->clientAccount->first_name.' '.$rating->clientAccount->last_name ?? 'Unavailable'}}</td>
                      <td class="tx-medium">{{$rating->cseAccount->first_name.' '.$rating->cseAccount->last_name ?? 'Unavailable'}}</td>
                      <td class="tx-medium">{{$rating->service_request->service->name ?? 'Unavailable'}}</td>
                      <td class="tx-medium text-center">{{$rating->service_request->unique_id ?? 'Unavailable'}}</td>
                      <td class="text-medium text-center">{{round($rating->star) ?? 'Unavailable'}}</td>
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
@endsection
