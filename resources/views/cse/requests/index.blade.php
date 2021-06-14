@extends('layouts.dashboard')
@section('title', 'All CSE Service Requests')
    @include('layouts.partials._messages')
@section('content')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('quality-assurance.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Service Requests</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">{{\Request::get('status')}} Service Requests</h4>
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">Your Most Recent Requests</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all <strong>Service
                                        Requests</strong> assigned to you by FixMaster AI or your CSE Coodinator after
                                    careful understudy of each request and with assumed initial payments made by the
                                    clients.</p>
                            </div>

                        </div><!-- card-header -->
                        <div class="card-body pd-y-30">
                            <div class="d-sm-flex">
                                <div class="media">
                                    <div
                                        class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                                        <i data-feather="bar-chart-2"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6
                                            class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">
                                            Total Requests</h6>
                                        <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0"></h4>
                                    </div>
                                </div>

                            </div>
                        </div><!-- card-body -->
                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Job Ref.</th>
                                        <th>Client</th>
                                        <th class="text-left">Amount</th>
                                        <th>Schedule Date</th>
                                        <th class="text-left">Date Created </th>
                                        <th class=" text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($requests as $request)
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                            <td class="tx-medium">{{ $request['service_request']['unique_id'] }}</td>
                                            <td class="tx-medium">
                                                {{ Str::title($request['service_request']['client']['account']['first_name'] . ' ' . $request['service_request']['client']['account']['last_name']) ?? 'UNAVAILABLE' }}
                                            </td>
                                            <td class="text-left">
                                                ₦{{ number_format($request['service_request']['price']['amount']) }}</td>
                                            </td>
                                            <td class="text-left">
                                                {{ !empty($request['service_request']['preferred_time']) ? Carbon\Carbon::parse($request['service_request']['preferred_time'], 'UTC')->isoFormat('MMMM Do YYYY') : 'UNSCHEDULED' }}
                                            </td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($request['service_request']['created_at'] ?? '2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                                            </td>
                                            <td class=" text-center">
                                                <div class="dropdown-file"> <a href="" class="dropdown-link"
                                                        data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{route('cse.requests.show', ['locale' => app()->getLocale(), 'request' => $request['service_request']['uuid'] ])}}" class="dropdown-item details"><i
                                                                class="far fa-clipboard"></i> Details </a>
                                                    </div>
                                                </div>
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
