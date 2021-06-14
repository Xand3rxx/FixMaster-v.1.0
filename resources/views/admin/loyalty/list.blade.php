@extends('layouts.dashboard')
@section('title', 'Loyalty List')
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
                        <li class="breadcrumb-item active" aria-current="page">Loyalty List</li>
                    </ol>
                </nav>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.add_loyalty', app()->getLocale()) }}" class="btn btn-primary"><i
                        class="fas fa-plus"></i> Add New Loyalty</a>
            </div>
        </div>

        <div class="row row-xs">

            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Loyalty List as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster
                            Loyalties.</p>
                        </div>

                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Points</th>
                                    <th>Amount</th>
                                    <th>loyalty(&#8358;)</th>
                                    <th>Date Created</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($loyalty as $row)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium">{{ucfirst($row->first_name) }} {{ucfirst($row->last_name) }}</td>
                                    <td class="tx-medium">{{ $row->points}}</td>
                             
                                    <td class="tx-medium">{{ $row->amount}}</td>
                                    <td class="tx-medium"> &#8358; {{ $row->points/100 * $row->amount }}</td>
                                    <td class="text-medium">
                                        {{ Carbon\Carbon::parse($row->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                                    </td>
                                    <td class=" text-center">

                                        <div class="dropdown-file">
                                            <a href="" class="dropdown-link" data-toggle="dropdown"><i
                                                    data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('admin.loyalty_summary', [ 'loyalty'=>$row->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-primary" title="View  details"
                                                    data-url="" data-category-name="" id="category-details"><i
                                                        class="far fa-clipboard"></i> Summary</a>
                                                <a href="{{ route('admin.edit_loyalty', [ 'loyalty'=>$row->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-info"><i class="far fa-edit"></i>
                                                    Edit</a>
                                             

                                                <a href="#" id="delete" 
                                                    data-url="{{ route('admin.delete_loyalty', [ 'loyalty'=>$row->uuid, 'client'=>$row->client_id,'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-danger" title="Delete Loyalty"><i
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
<script src="{{ asset('assets/dashboard/assets/js/admin/loyalty/4d5e497c-d12d-43ec-ac7a-a14f825ffaed.js') }}"></script>
@endpush
@endsection
@endsection