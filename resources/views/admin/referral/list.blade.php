@extends('layouts.dashboard')
@section('title', ' Referral List')
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
                        <li class="breadcrumb-item active" aria-current="page">Referral Code List</li>
                    </ol>
                </nav>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.add_referral', app()->getLocale()) }}" class="btn btn-primary"><i
                        class="fas fa-plus"></i> Add New Referral Code</a>
            </div>
        </div>

        <div class="row row-xs">

            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Referral List as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster
                            Referrals.</p>
                        </div>

                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>User-Type</th>
                                    <th>Created By</th>
                                     <th>Code</th>
                                     <th>Referral Count</th>
                                     <th>Status</th>
                                    <th>Date Created</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($referrals as $ref)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium">{{ucfirst($ref->first_name) }} {{ucfirst($ref->last_name) }}</td>
                                    <td class="tx-medium">{{ ucfirst($ref->url)}}</td>
                                    <td class="tx-medium">{{ ucfirst($ref->created_by)}}</td>
                                    <td class="tx-medium">{{ ucfirst($ref->referral_code)}}</td>
                                    <td class="tx-medium">{{ ucfirst($ref->referral_count)}}</td>
                                    <td class="tx-medium">{{ ucfirst($ref->status)}}</td>
                                    <td class="text-medium">
                                        {{ Carbon\Carbon::parse($ref->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                                    </td>
                                    <td class=" text-center">

                                    <div class="dropdown-file">
                                        <a href="" class="dropdown-link" data-toggle="dropdown"><i
                                                data-feather="more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        @if($ref->status == 'activate')
                                                <a href="#" id="deactivate"
                                                    data-url="{{ route('admin.deactivate_referral', [ 'referral'=>$ref->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-warning deactivate"
                                                    title="Deactivate "><i class="fas fa-ban"></i> Deactivate</a>
                                                @else

                                                <a href="#" id="activate"
                                                    data-url="{{ route('admin.activate_referral', [ 'referral'=>$ref->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-success" title="Reinstate"><i
                                                        class="fas fa-undo"></i> Reinstate</a>
                                                @endif
                                            <a href="#" id="delete" 
                                                data-url="{{ route('admin.delete_referral', [ 'referral'=>$ref->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                class="dropdown-item details text-danger" title="Delete  Referral"><i
                                                    class="fas fa-trash"></i> Delete</a>

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

        </div>

    </div>
</div>



@section('scripts')
@push('scripts')
<script src="{{ asset('assets/dashboard/assets/js/admin/referral/a09fced7-c17b-4b2e-b716-96323e4ab730.js') }}"></script>
@endpush
@endsection
@endsection