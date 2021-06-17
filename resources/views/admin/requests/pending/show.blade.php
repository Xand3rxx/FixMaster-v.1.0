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
            <div class="media align-items-center">
                <span class="tx-color-03 d-none d-sm-block">

                    @php
                        if ($serviceRequest['client']['account']['gender'] == 'male' || $serviceRequest['client']['account']['gender'] == 'others') {
                            $genderAvatar = 'default-male-avatar.png' ?? 'default-female-avatar.png';
                        }
                    @endphp

                    @if (empty($serviceRequest['client']['account']['avatar']))
                        <img src="{{ asset('assets/images/' . $genderAvatar) }}" class="avatar rounded-circle"
                            alt="Default avatar">
                    @elseif(!file_exists(public_path('assets/user-avatars/'.$serviceRequest['client']['account']['avatar'])))
                        <img src="{{ asset('assets/images/' . $genderAvatar) }}" class="avatar rounded-circle"
                            alt="Profile avatar">
                    @else
                        <img src="{{ asset('assets/user-avatars/' . $serviceRequest['client']['account']['avatar']) }}"
                            class="avatar rounded-circle" alt="Profile avatar">
                    @endif

                </span>
                <div class="media-body mg-sm-l-20">
                    <h4 class="tx-18 tx-sm-20 mg-b-2">
                        {{ ucfirst($serviceRequest['client']['account']['first_name']) }}
                        {{ ucfirst($serviceRequest['client']['account']['last_name']) }}
                        <a class="btn btn-sm btn-primary btn-icon" title="Call Client"
                    @if($serviceRequest['contactme_status'] == 1) href="tel:{{ $serviceRequest['client']['account']['contact']['phone_number'] }}" @else href="#" @endif id="contact-me" data-contact-me="{{ $serviceRequest['contactme_status'] }}"><i class="fas fa-phone"></i> </a>

                    </h4>

                    <p class="tx-13 tx-color-03 mg-b-0">Scheduled Date:
                        {{ !empty($serviceRequest['preferred_time']) ? Carbon\Carbon::parse($serviceRequest['preferred_time'], 'UTC')->isoFormat('MMMM Do YYYY') : 'UNSCHEDULED' }}
                    </p>
                    <p class="tx-13 tx-color-03 mg-b-0">Job Ref.: {{ $serviceRequest['unique_id'] }} </p>
                </div>
            </div><!-- media -->

            <div class="contact-content-header mt-4">
                <nav class="nav">
                    <a href="#description" class="nav-link active" data-toggle="tab"><span>Job Description</a>
                    <a href="#notifyCSE" class="nav-link" data-toggle="tab"><span>Assign CSE</a>
                     @if(collect($serviceRequest['adminAssignedCses'])->isNotEmpty())   
                        <a href="#assignedCSEs" class="nav-link" data-toggle="tab"><span>Notified CSE's</a>
                    @endif
                </nav>
            </div><!-- contact-content-header -->

            <div class="contact-content-body">
                <div class="tab-content">

                    @include('admin.requests.includes.job_description')


                    <div id="notifyCSE" class="tab-pane pd-20 pd-xl-25">
                        <div class="divider-text">Assign CSE</div>

                        <ul class="list-group wd-md-100p">
                            @foreach ($cses as $cse)
                            <li class="list-group-item d-flex align-items-center">

                                <div class="form-row">
                                    @php
                                        if ($cse['user']['account']['gender'] == 'male' || $cse['user']['account']['gender'] == 'others') {
                                            $cseGenderAvatar = 'default-male-avatar.png' ?? 'default-female-avatar.png';
                                        }
                                    @endphp

                                    @if (empty($cse['user']['account']['avatar']))
                                        <img src="{{ asset('assets/images/' . $cseGenderAvatar) }}" class="wd-30 rounded-circle mg-r-15" alt="Default avatar">
                                    @elseif(!file_exists(public_path('assets/user-avatars/'.$cse['user']['account']['avatar'])))
                                        <img src="{{ asset('assets/images/' . $cseGenderAvatar) }}" class="wd-30 rounded-circle mg-r-15" alt="Profile avatar">
                                    @else
                                        <img src="{{ asset('assets/user-avatars/' . $cse['user']['account']['avatar']) }}"
                                            class="wd-30 rounded-circle mg-r-15" alt="Profile avatar">
                                    @endif
                                </div>

                                <div class="col-md-6 col-sm-6">
                                <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ !empty($cse['user']['account']['first_name']) ? $cse['user']['account']['first_name'] .' '. $cse['user']['account']['last_name'] : 'UNAVAILABLE'}}</h6>

                                <span class="d-block tx-11 text-muted">
                                    @for ($i = 0; $i < round($cse['user']['ratings']->avg('star')); $i++)
                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                    @endfor
                                    @for ($x = 0; $x < (5 - round($cse['user']['ratings']->avg('star'))); $x++)
                                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                    @endfor

                                    <span class="font-weight-bold ml-2">{{ \App\Traits\CalculateDistance::getDistanceBetweenPoints($serviceRequest['client']['contact']['address_latitude'], $serviceRequest['client']['contact']['address_longitude'], $cse['user']['contact']['address_latitude'], $cse['user']['contact']['address_longitude']) }}km</span> from client's residence.
                                </span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="form-row">
                                    <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                        <a class="btn btn-sm btn-primary btn-icon" title="Call CSE" href="tel:{{ $cse['user']['contact']['phone_number'] }}"><i class="fas fa-phone"></i> </a>
                                    </div>
                                    <div class="form-group col-1 col-md-1 col-sm-1">
                                            <div class="custom-control">
                                                <form action="{{ route('admin.requests-pending.store', app()->getLocale()) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="custom-control-input" id="{{ $loop->iteration }}" name="cse_user_uuid" value="{{ $cse['user']['uuid'] }}">
                                                    <input type="hidden" class="custom-control-input" id="{{ $loop->iteration }}" name="service_request_uuid" value="{{ $serviceRequest['uuid'] }}">
                                                    <button class="btn btn-sm btn-success btn-icon" title="Assign CSE"><i class="fas fa-user-check"></i> </button>
                                                </form>
                                            </div>
                                    </div>

                                </div>
                                {{-- </div> --}}
                            </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @if(collect($serviceRequest['adminAssignedCses'])->isNotEmpty())   
                    <div id="assignedCSEs" class="tab-pane pd-20 pd-xl-25">
                        <h5 class="mt-4">Notified Client Service Executives</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-hover mg-b-0">
                                <thead class="">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Date Assigned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($serviceRequest['adminAssignedCses'] as $assignedCse)
                                    <tr>
                                        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                        <td class="tx-medium">{{ Str::title($assignedCse['user']['account']['first_name'] ." ". $assignedCse['user']['account']['last_name']) }}</td>
                                        <td class="tx-medium">{{ \Carbon\Carbon::parse($assignedCse['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div>
                    @endif
                </div>
            </div>

        </div>
        </div>

    </div>
</div>

@endsection
