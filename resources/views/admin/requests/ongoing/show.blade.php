@extends('layouts.dashboard')
@section('title', 'Ongoing Request Details')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.requests-ongoing.index', app()->getLocale()) }}">Ongoing Requests</a></li>
              <li class="breadcrumb-item active" aria-current="page">Ongoing Request Details</li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-lg-12 col-xl-12">
            @include('admin.requests.includes._client_brief_details')

            <div class="contact-content-header mt-4">
                <nav class="nav">
                    <a href="#description" class="nav-link active" data-toggle="tab"><span>Job Description</a>
                    <a href="#serviceRequestSummary" class="nav-link" data-toggle="tab"><span>Job Summary</a>
                    <a href="#serviceRequestProgress" class="nav-link" data-toggle="tab"><span>Job Progress</a>
                    <a href="#materialAccepted" class="nav-link" data-toggle="tab"><span>Request For Qoute </a>
                </nav>
            </div><!-- contact-content-header -->

            <div class="contact-content-body">
                <div class="tab-content">
                    @include('admin.requests.includes.job_description')
                    @include('admin.requests.includes._service_request_summary')
                    @include('admin.requests.includes._service_request_progress')
                    @include('admin.requests.includes._material_acceptance')
                    
                </div>
            </div>

        </div>
        </div>

    </div>
</div>

@endsection
