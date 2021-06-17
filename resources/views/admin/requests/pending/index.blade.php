@extends('layouts.dashboard')
@section('title', 'All Pending Service Requests')
@include('layouts.partials._messages')
@section('content')
<style>
    table.t {
    border-collapse: collapse;
    border:1px;
    table-layout:fixed;
}

tr.t {
    /* border: 1px solid black; */
    width: 50px;
}

tr.top {
    border-bottom: 1px dashed black;
}
tr.left {
    border-right: 1px dashed black;
}
tr.right {
    border-left: 1px dashed black;
}
tr.bottom {
    border-top: 1px dashed black;
}
tr.middle {
    border: 1px dashed black;
}

tr.bd-danger {
    -webkit-animation: pulse-border 1s infinite;
}

@-webkit-keyframes pulse-border {
    from, to { box-shadow: 0 0 0 0 #dc3545;}
    50% { box-shadow: 0 0 0 2px #dc3545; }
}

tr.bd-warning {
    -webkit-animation: pulse-border-2 1s infinite;
}

@-webkit-keyframes pulse-border-2 {
    from, to { box-shadow: 0 0 0 0 #dc3545;}
    50% { box-shadow: 0 0 0 2px #dc3545; }
}

</style>

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('quality-assurance.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Service Requests</li>
                        <li class="breadcrumb-item active" aria-current="page">Pending Requests</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Pending Service Requests</h4>
            </div>
        </div>

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Your Most Recent Requests</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all <strong>Pending Service Requests</strong> with assumed initial payments made by the clients.</p>
                        </div>

                    </div><!-- card-header -->
                    <div class="card-body pd-y-30">
                        <div class="d-sm-flex">
                            <div class="media">
                                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                                    <i data-feather="bar-chart-2"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Total Requests</h6>
                                    <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">{{ $requests->count() }}</h4>
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
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Payment Status</th>
                                    <th>Scheduled Date</th>
                                    <th>Date Created</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                <tr
                                @if((\Carbon\Carbon::now() > Carbon\Carbon::parse($request['preferred_time'], 'UTC')) || (\Carbon\Carbon::now() == Carbon\Carbon::parse($request['preferred_time'], 'UTC')))
                                class="bd bd-2 bd-danger"
                                @elseif(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($request['preferred_time'], 'UTC')) < 2)
                                class="bd bd-2 bd-warning"
                                @endif
                                >
                                    <td class="tx-color-03 tx-center"> {{ $loop->iteration }} </td>
                                    <td class="tx-medium"> {{ $request['unique_id'] }} </td>
                                    <td class="tx-medium"> {{ !empty($request['client']['account']['first_name']) ? Str::title($request['client']['account']['first_name'] .' '. $request['client']['account']['last_name']) : 'UNAVAILABLE' }} </td>

                                    <td class="tx-medium text-center">₦{{ number_format($request['total_amount']) }}<br><span class="text-success">({{ $request['price']['name'] }})</span></td>
                                    <td class="{{ (($request['payment_statuses']['status'] == 'pending') ? 'text-warning' : (($request['payment_statuses']['status'] == 'success') ? 'text-success' : (($request['payment_statuses']['status'] == 'failed') ? 'text-danger' : 'text-danger'))) }}">{{ ucfirst($request['payment_statuses']['status']) }}({{ ucfirst($request['payment_statuses']['payment_channel']) }})
                                    </td>
                                    <td class="text-medium">{{ !empty($request['preferred_time']) ? Carbon\Carbon::parse($request['preferred_time'])->isoFormat('MMMM Do YYYY, hh:mm:ssa') : 'Not Scheduled'}}</td>
                                    <td class="text-medium">{{ Carbon\Carbon::parse($request['created_at'])->isoFormat('MMMM Do YYYY, hh:mm:ssa') }}</td>
                                    <td class=" text-center">
                                        <div class="dropdown-file">
                                            <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('admin.requests-pending.show', ['requests_pending'=>$request['uuid'], 'locale'=>app()->getLocale()]) }}" class="dropdown-item text-primary"><i class="far fa-clipboard"></i> Details</a>
                                                <a href="#" class="dropdown-item text-danger"><i class="fas fa-times"></i> Cancel Request</a>
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




@push('scripts')

<script src="{{ asset('assets/client/js/requests/4c676ab8-78c9-4a00-8466-a10220785892.js') }}"></script>
@endpush
@endsection
