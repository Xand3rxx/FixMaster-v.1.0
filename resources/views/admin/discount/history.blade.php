@extends('layouts.dashboard')
@section('title', 'Discount History')
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
                        <li class="breadcrumb-item active" aria-current="page">Discount History List</li>
                    </ol>
                </nav>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.add_discount', app()->getLocale()) }}" class="btn btn-primary"><i
                        class="fas fa-plus"></i> Add New Discount/Promotion</a>
            </div>
        </div>

        <div class="row row-xs">

            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Discount History List as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster
                                Discounts History.</p>
                        </div>

                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Client Name</th>
                                    <th>Discount Name</th>
                                    <th>Entity</th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Applied To</th>
                                    <th class="text-center">Duration</th>
                                    <!-- <th class="text-center">Service Category</th>
                                    <th>Services Name</th> -->
                                    <th>Available</th>
                                    <th>Date Created</th>
                             
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($discounts as $discount)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium">{{  $discount->client_name != '' ?ucfirst($discount->client_name): 'Nil' }}</td>
                                    <td class="tx-medium">{{ ucfirst($discount->name)}}</td>
                                    <td class="tx-medium text-center">{{ucfirst($discount->entity)}}</td>
                                    <td class="tx-medium text-center">{{$discount->rate.'%'}}</td>
                                    <td class="tx-medium text-center">{{$discount->apply_discount}}</td>
                               <td class="tx-medium text-center">{{CustomHelpers::displayTime($discount->duration_start, $discount->duration_end) }}</td>
                                    <!-- <td class="tx-medium">{{$discount->service_category != ''? $discount->service_category: 'Nil'}}</td>
                                    <td class="tx-medium text-center">{{$discount->service_name != ''? $discount->service_name: 'Nil'}} -->
                                    </td>
                                    @if($discount->availability  == 'used')
                                    <td class="text-medium text-success">Used</td>
                                    @else
                                    <td class="text-medium text-danger">Unused</td>
                                    @endif

                                    <td class="text-medium">
                                        {{ Carbon\Carbon::parse($discount->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                                    </td> 
                            
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
<script src="{{ asset('assets/dashboard/assets/js/admin/discount/4c676ab8-78c9-4a00-8466-a10220785897.js') }}"></script>
@endpush
@endsection
@endsection