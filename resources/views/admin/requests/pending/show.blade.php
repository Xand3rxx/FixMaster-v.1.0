@extends('layouts.dashboard')
@section('title', 'Pending Request Details')
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
            <li class="breadcrumb-item"><a href="{{ route('admin.requests-pending.index', app()->getLocale()) }}">Pending Requests</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pending Request Details</li>
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
                    @if($serviceRequest['payment_statuses']['status'] == 'success')   
                        <a href="#notifyCSE" class="nav-link" data-toggle="tab"><span>Assign CSE</a>
                    @endif
                    @if(collect($serviceRequest['adminAssignedCses'])->isNotEmpty())   
                        <a href="#assignedCSEs" class="nav-link" data-toggle="tab"><span>Notified CSE's</a>
                    @endif
                </nav>
            </div><!-- contact-content-header -->

            <div class="contact-content-body">
                <div class="tab-content">
                    @include('admin.requests.includes.job_description')

                    @if($serviceRequest['payment_statuses']['status'] == 'success')   
                        @include('admin.requests.includes._notify_cse')
                    @endif

                    @if(collect($serviceRequest['adminAssignedCses'])->isNotEmpty())   
                        @include('admin.requests.includes._assigned_cses')
                    @endif
                </div>
            </div>

        </div>
        </div>

    </div>
</div>

@endsection
