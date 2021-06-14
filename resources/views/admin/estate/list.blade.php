@extends('layouts.dashboard')
@section('title', 'Estates List')
@section('content')
    @include('layouts.partials._messages')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Estates</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Estates List</h4>
                </div>
                <div class="d-md-block">
                    <a href="{{ route('admin.add_estate', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">Estates as of {{ date('M, d Y') }}</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Estates.</p>
                            </div>

                        </div><!-- card-header -->

                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Estate Name</th>
                                    <th>Author</th>
                                    <th>Phone Number</th>
                                    <th>Clients</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Approved / Declined By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($estates as $estate)
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                            <td class="tx-medium">{{ $estate['estate_name'] }}</td>
                                            <td class="tx-medium">{{ $estate['first_name'] .' '.$estate['last_name'] }}</td>
                                            <td class="tx-medium">{{ $estate['phone_number'] }}</td>
                                            <td class="text-medium">
                                                {{ \App\Models\Client::where('estate_id', $estate['id'])->count() }}
                                            </td>
                                            @if($estate['approved_by'] == null)
                                                <td class="text-medium text-danger">Pending</td>
                                            @else
                                                <td class="text-medium text-@if($estate['is_active'] == 'approved' || $estate['is_active'] == 'reinstated')success @elseif($estate['is_active'] == 'declined' || $estate['is_active'] == 'deactivated')danger @endif">
                                                    {{ Str::ucfirst($estate['is_active']) }}
                                                </td>
                                            @endif
                                            <td class="text-medium">{{ $estate['created_by'] }}</td>
                                            @if($estate['approved_by'] == null)
                                            <td class="text-medium text-danger">Pending</td>
                                            @else
                                            @foreach($approvedBy as $item)
                                            <td class="text-medium">{{ $item->email }}</td>
                                            @endforeach
                                            @endif
                                            <td class=" text-center">
                                                <div class="dropdown-file">
                                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('admin.estate_summary', [ 'estate'=>$estate['uuid'], 'locale'=>app()->getLocale() ]) }}" class="dropdown-item details text-primary"><i class="far fa-user"></i> Summary</a>
                                                        @if($estate['is_active'] == 'reinstated' || $estate['is_active'] == 'deactivated')
                                                        <a href="{{ route('admin.edit_estate', [ 'estate'=>$estate['uuid'], 'locale'=>app()->getLocale() ]) }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>
                                                        @endif
                                                        @if($estate['approved_by'] == null || $estate['is_active'] == 'declined' || $estate['is_active'] == 'pending')
                                                        @if($estate['approved_by'] != null || $estate['is_active'] == 'declined' || $estate['is_active'] == 'pending')
                                                            <a href="{{ route('admin.approve_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success"><i class="fas fa-ban"></i> Approve</a>
                                                            <a href="{{ route('admin.decline_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-warning"><i class="fas fa-ban"></i> Decline</a>
                                                        @endif

                                                        @elseif($estate['is_active'] == 'reinstated' || $estate['is_active'] == 'deactivated')
                                                        @if($estate['is_active'] == 'reinstated' )
                                                            <a href="{{ route('admin.deactivate_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-warning"><i class="fas fa-ban"></i> Deactivate</a>
                                                        @elseif($estate['is_active'] == 'deactivated' )
                                                            <a href="{{ route('admin.reinstate_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success"><i class="fas fa-undo"></i> Reinstate</a>
                                                        @endif
                                                        @endif
                                                        <a href="{{ route('admin.delete_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a>
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

            $('#request-sorting').on('change', function (){
                let option = $("#request-sorting").find("option:selected").val();

                if(option === 'None'){
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Date'){
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Month'){
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                }

                if(option === 'Date Range'){
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                }
            });
        });

    </script>
@endsection

@endsection
