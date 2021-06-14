@extends('layouts.dashboard')
@section('title', 'Prospective Customer Service Executive List')
    @include('layouts.partials._messages')

@section('content')
    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Prospective Customer Service Executive
                                List</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Prospective Customer Service Executive List</h4>
                </div>
                {{-- <div class="d-md-block">
                <a href="{{ route('admin.prospective.cse.create', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
            </div> --}}
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">Prospective Customer Service Executive as of {{ date('M, d Y') }}</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Prospective
                                    Customer Service Executive.</p>
                            </div>

                        </div><!-- card-header -->

                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Full Name</th>
                                        <th>E-Mail</th>
                                        <th>Phone Number</th>
                                        <th>Gender</th>
                                        <th>Date of Birth</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $cse)
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                            <td class="tx-medium">
                                                {{ Str::title($cse['form_data']['first_name'] . ' ' . $cse['form_data']['last_name']) }}
                                            </td>
                                            <td class="tx-medium">{{ $cse['form_data']['email'] }}</td>
                                            <td class="tx-medium">{{ $cse['form_data']['phone'] }}</td>
                                            <td class="tx-medium">{{ Str::title($cse['form_data']['gender']) }}</td>

                                            <td class="tx-medium">
                                                {{ Carbon\Carbon::parse($cse['form_data']['date_of_birth'], 'UTC')->isoFormat('MMMM Do YYYY') }}
                                            </td>

                                            <td> {{ Str::title($cse['status']) }}</td>

                                            <td class=" text-center">
                                                <div class="dropdown-file">
                                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i
                                                            data-feather="more-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('admin.prospective.cse.show', [app()->getLocale(), $cse['uuid']]) }}"
                                                            class="dropdown-item details text-primary"><i
                                                                class="far fa-user"></i> Summary</a>
                                                        @if ($cse['status'] == \App\Models\Applicant::STATUSES[0])
                                                            <a href="#" data-user="{{ $cse['uuid'] }}"
                                                                data-action="approve"
                                                                class="cse-decision-making dropdown-item details"><i
                                                                    class="fas fa-check"></i> Approve </a>
                                                            <a href="#" data-user="{{ $cse['uuid'] }}"
                                                                data-action="decline"
                                                                class="cse-decision-making dropdown-item details text-danger">
                                                                <i class="fas fa-ban"></i> Decline</a>
                                                        @endif
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
    <x-cse.decision />

@endsection
