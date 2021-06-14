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
          <li class="breadcrumb-item" aria-current="page">Request</li>
            <li class="breadcrumb-item" aria-current="page">Active</li>
            <li class="breadcrumb-item active" aria-current="page">details</li>
          </ol>

        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Active Requests</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">

        <div class="row">
            <div class="col-md-9">

            </div>

            <div class="col-md-3">
              <a href="tel:{{$phone}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i> Call CSE</a> <button class="btn btn-sm" style="background-color: #E97D1F; color:#fff;">Go Back</button>
            </div>
        </div>
        <div class="divider-text">Service Request Description</div>
        <br>
        <table class="table table-striped table-sm mg-b-0">
            <tbody>
              <tr>
                <td class="">Job Reference</td>
                <td class="">{{$activeDetails->service_request->unique_id}}</td>
              </tr>
              <tr>
                <td class="">Service Required</td>
                <td class="">{{$activeDetails->service_request->service->category->name}} ({{$activeDetails->service_request->service->name}})</td>
              </tr>
              <tr>
                <td class="tx-medium">Scheduled Date & Time</td>
                <td class="tx-color-03">{{ Carbon\Carbon::parse($activeDetails->service_request->preferred_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:a') }}</td>
            </tr>
            <tr>
                <td class="tx-medium">Request Address</td>
                <td class="tx-color-03">{{$activeDetails->service_request->address->address}}</td>
            </tr>
            <tr>
                <td class="tx-medium">Town/City</td>
                {{-- <td class="tx-color-03">{{$activeDetails['service_request']['address']['town']['name']}}</td> --}}
                <td class="tx-color-03">{{$activeDetails->service_request->address}}</td>
            </tr>
            <tr>
                <td class="tx-medium">L.G.A</td>
                {{-- <td class="tx-color-03">{{$activeDetails['service_request']['address']['lga']['name']}}</td> --}}
            </tr>
              <tr>
                <td class="">Service Description</td>
                <td class="">{{$activeDetails->service_request->service->description}}</td>
              </tr>
            </tbody>
          </table>

          <br>
          <div class="divider-text">Service Request Media Files</div>

          <div class="row row-xs">
      @foreach($activeDetails->service_request->service_request_medias as $media)
            <div class="col-6 col-sm-4 col-md-3">
              <div class="card card-file">
                 <img data-magnify="gallery" data-src="{{ asset('assets/service-request-images/'.$media->media_files->original_name) }}" src="{{ asset('assets/service-request-images/'.$media->media_files->original_name) }}" height="250" class="img-fluid h-100" alt="Profile avatar">
              </div>
            </div>
      @endforeach
          </div><!-- row -->

      </div>
    </div>

  </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/dashboard/assets/js/qa-payments-sortings.js') }}"></script>
 <script>
    $(document).ready(function() {


    });

</script>
@endsection

