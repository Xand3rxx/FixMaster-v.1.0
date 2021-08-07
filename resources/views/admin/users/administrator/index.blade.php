@extends('layouts.dashboard')
@section('title', 'Administrators List')
@section('content')
@include('layouts.partials._messages')

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Administrators List</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Administrators List</h4>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.users.administrator.create', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
            </div>
        </div>

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Administrators as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Administrators.</p>
                        </div>

                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Full Name</th>
                                    <th>E-Mail</th>
                                    <th>Created By</th>
                                    <th>Phone Number</th>
                                    <th>Access Level</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $administrator)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium">{{ Str::title($administrator['user']['account']['last_name'] ." ". $administrator['user']['account']['first_name']) }}</td>
                                    <td class="tx-medium">{{ $administrator['user']['email'] }}</td>
                                    <td class="tx-medium">{{ $administrator['created_by'] }}</td>
                                    <td class="tx-medium">{{ $administrator['user']['contact']['phone_number'] ?? 'UNAVAILABLE' }}</td>
                                    <td class="tx-medium text-info">{{ $administrator['user']['roles'][0]['name']}}</td>
                                    <td class="text-medium text-success">{{is_null($administrator['user']['deleted_at']) ? 'Active' : InActive}}</td>
                                    <td class="text-medium">{{ Carbon\Carbon::parse($administrator->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                    <td class=" text-center">
                                        <div class="dropdown-file">
                                            <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('admin.users.administrator.summary.show', [app()->getLocale(),$administrator['user']['uuid'] ]) }}" class="dropdown-item details text-primary"><i class="far fa-user"></i> Summary</a>
                                                <a href="{{ route('admin.users.administrator.edit', [app()->getLocale(),$administrator['user']['uuid'] ]) }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>
                                                <a href="#" class="dropdown-item details"><i class="fas fa-address-card"></i> Activitiy Log</a>
                                                <a href="#" data-url="{{ route('admin.users.administrator.index', app()->getLocale()) }}" title="{{ Str::title($administrator['user']['account']['last_name'] ." ". $administrator['user']['account']['first_name']) }}" class="dropdown-item details text-warning"><i class="fas fa-ban"></i> Deactivate</a>
                                                {{-- <a href="#" class="dropdown-item details text-success"><i class="fas fa-undo"></i> Reinstate</a>
                                                <a href="#" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a> --}}
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


@section('scripts')
<script>
    $(document).ready(function() {

        $('#request-sorting').on('change', function() {
            let option = $("#request-sorting").find("option:selected").val();
            switch (option) {
                case 'Date':
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                    break;

                case 'Month':
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                    break;

                case 'Date Range':
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                    break;

                default:
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                    break;
            }

            // if (option === 'None') {
            //     $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
            // }

            // if (option === 'Date') {
            //     $('.specific-date').removeClass('d-none');
            //     $('.sort-by-year, .date-range').addClass('d-none');
            // }

            // if (option === 'Month') {
            //     $('.sort-by-year').removeClass('d-none');
            //     $('.specific-date, .date-range').addClass('d-none');
            // }

            // if (option === 'Date Range') {
            //     $('.date-range').removeClass('d-none');
            //     $('.specific-date, .sort-by-year').addClass('d-none');
            // }

        });
    });
</script>
@endsection

@endsection