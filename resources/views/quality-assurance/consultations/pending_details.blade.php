@extends('layouts.dashboard')
@section('title', 'Quality Assurance Payments')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('quality-assurance.index',app()->getLocale()) }}">Dashboard</a></li>
          <li class="breadcrumb-item" aria-current="page">Consultation</li>
            <li class="breadcrumb-item" aria-current="page">Pending</li>
            <li class="breadcrumb-item active" aria-current="page">details</li>
          </ol>

        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Pending Consultation</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">

        <div class="row">
            <div class="col-md-9">

            </div>

            <div class="col-md-3">
                @if($sRequest->qa_job_accepted == null)
                <a href="{{ route('quality-assurance.accept_job', [$result->uuid, 'locale' => app()->getLocale()]) }}" class="btn btn-primary btn-icon">Accept</a>
                @else
                <a href="javascript:void(0)" class="btn btn-primary btn-icon">Accepted</a>
                @endif
                <a href="#" class="btn btn-primary btn-icon">Go Back</a>
            </div>
        </div>
        <div class="divider-text">Service Request Description</div>
<br>
        <table class="table table-striped table-sm mg-b-0">
            <tbody>
              <tr>
                <td class="">Job Reference</td>
                <td class="">{{$result->id}}</td>
              </tr>
              <tr>
                <td class="">Service Required</td>
                <td class="">{{$result->service->category->name}} ({{$result->service->name}})</td>
              </tr>
              <tr>
                <td class="">Service Description</td>
                <td class="">{{$result->service->description}}</td>
                {{-- @foreach($result->service_request_medias as $media)

                 {{ $media->media_files->original_name}}

        @endforeach --}}
              </tr>
            </tbody>
          </table>

          <br>
          <div class="divider-text">Service Request Media Files</div>
          <div class="row row-xs">
      @foreach($result->service_request_medias as $media)
            <div class="col-6 col-sm-4 col-md-3">
              <div class="card card-file">
                 <img data-magnify="gallery" data-src="{{ asset('service-request-media-files/'.$media->media_files->original_name) }}" src="{{ asset('service-request-media-files/'.$media->media_files->original_name) }}" height="250" class="img-fluid h-100" alt="Profile avatar">
              </div>
            </div>
       @endforeach
            </div>
@endsection
@section('scripts')
<script src="{{ asset('assets/dashboard/assets/js/qa-payments-sortings.js') }}"></script>
 <script>
    $(document).ready(function() {


    });

</script>
@endsection

