@extends('layouts.dashboard')
@section('title', 'Income History')
@include('layouts.partials._messages')
@section('content')
    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Histories</li>
                        </ol>
                    </nav>
                    {{-- <h4 class="mg-b-0 tx-spacing--1">Administrators List</h4> --}}
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                    <div class="card mg-b-20 mg-lg-b-25">
                        <div class="card-header">
                            <div class="contact-content-header mt-4">
                                <nav class="nav">
                                    <a href="#earnings" class="nav-link active" data-toggle="tab"><span>Earnings History</span></a>
                                    <a href="#income" class="nav-link" data-toggle="tab"><span>Income History</span></a>
                                </nav>
                                <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a>
                            </div>
                            <nav class="nav nav-with-icon tx-13">
                                <!-- <a href="" class="nav-link"><i data-feather="plus"></i> Add New</a> -->
                            </nav>
                        </div><!-- card-header -->
                        <div class="contact-content-body">
                            <div class="tab-content">
                                {{-- <div class="card-body pd-25"> --}}
                                <div class="tab-pane show active pd-20 pd-xl-25" id="earnings">
                                    <div class="col-lg-12 col-xl-12">
                                        <div class="card">
                                            <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                                <div>
                                                    <h6 class="mg-b-5">Earnings history as of {{ date('M, d Y') }}</h6>
                                                    <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all earnings.</p>
                                                </div>

                                            </div>
                                            <div class="table-responsive">

                                                <table class="table table-hover mg-b-0" id="basicExample">
                                                    <thead class="thead-primary">
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Role</th>
                                                        <th>Earnings (%)</th>
                                                        <th>Updated At</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($earnings as $earning)
                                                    <tr>
                                                        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                                        <td class="tx-medium">{{ $earning['role_name'] }}</td>
                                                        <td class="tx-medium">{{ $earning['earnings'] }}</td>
                                                        <td class="tx-medium">{{ $earning['updated_at'] }}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane pd-20 pd-xl-25" id="income">
                                    <div class="col-lg-12 col-xl-12">
                                        <div class="card">
                                            <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                                <div>
                                                    <h6 class="mg-b-5">Income history as of {{ date('M, d Y') }}</h6>
                                                    <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all incomes.</p>
                                                </div>

                                            </div>
                                            <div class="table-responsive">

                                                <table class="table table-hover mg-b-0" id="basicExample">
                                                    <thead class="thead-primary">
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Income Name</th>
                                                        <th>Income Type</th>
                                                        <th>Amount</th>
                                                        <th>Percentage (%)</th>
                                                        <th>Updated At</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($incomes as $income)
                                                        <tr>
                                                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                                            <td class="tx-medium">{{ $income['income_name'] }}</td>
                                                            <td class="tx-medium">{{ $income['income_type'] }}</td>
                                                            <td class="tx-medium">{{ $income['amount'] == null ? '-' : $income['amount'] }}</td>
                                                            <td class="tx-medium">{{ $income['percentage'] == null ? '-' : $income['percentage']*100 }}</td>
                                                            <td class="tx-medium">{{ $income['updated_at'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- </div><!-- row --> --}}
                            </div><!-- row -->
                        </div><!-- row -->

                    </div>
                </div>

@endsection
