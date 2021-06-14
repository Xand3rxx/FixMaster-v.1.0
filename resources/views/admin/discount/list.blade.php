@extends('layouts.dashboard')
@section('title', 'Discount List')
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
                        <li class="breadcrumb-item active" aria-current="page">Discount/Promotion List</li>
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
                            <h6 class="mg-b-5">Discount List as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster
                                Discounts/Promotion.</p>
                        </div>

                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Entity</th>
                                    <th>Created By</th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Applied To</th>
                                    <th class="text-center">Duration</th>
                                    <th class="text-center">Description</th>
                                    <th>Notification Status</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($discounts as $discount)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium">{{ucfirst($discount->name) }}</td>
                                    <td class="tx-medium">{{ ucfirst($discount->entity)}}</td>
                                    <td class="tx-medium text-center">{{$discount->created_by}}</td>
                                    <td class="tx-medium text-center">{{$discount->rate.'%'}}</td>
                                    <td class="tx-medium text-center">{{$discount->apply_discount}}</td>
                               <td class="tx-medium text-center">{{CustomHelpers::displayTime($discount->duration_start, $discount->duration_end) }}</td>
                                    <td class="tx-medium">{{$discount->description}}</td>
                                    <td class="tx-medium text-center">{{$discount->notify == 1 ? ' Sent': 'Not Sent'}}
                                    </td>
                                    @if($discount->status == 'activate')
                                    <td class="text-medium text-success">Active</td>
                                    @else
                                    <td class="text-medium text-danger">Deactivated</td>
                                    @endif

                                    <td class="text-medium">
                                        {{ Carbon\Carbon::parse($discount->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                                    </td>
                                    <td class=" text-center">

                                        <div class="dropdown-file">
                                            <a href="" class="dropdown-link" data-toggle="dropdown"><i
                                                    data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('admin.summary', [ 'discount'=>$discount->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-primary" title="View  details"
                                                    data-url="" data-category-name="" id="category-details"><i
                                                        class="far fa-clipboard"></i> Summary</a>
                                                <a href="{{ route('admin.edit_discount', [ 'discount'=>$discount->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-info"><i class="far fa-edit"></i>
                                                    Edit</a>
                                                @if($discount->status == 'activate')
                                                <a href="#" id="deactivate"
                                                    data-url="{{ route('admin.deactivate_discount', [ 'discount'=>$discount->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-warning deactivate"
                                                    title="Deactivate "><i class="fas fa-ban"></i> Deactivate</a>
                                                @else

                                                <a href="#" id="activate"
                                                    data-url="{{ route('admin.activate_discount', [ 'discount'=>$discount->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-success" title="Reinstate"><i
                                                        class="fas fa-undo"></i> Reinstate</a>
                                                @endif

                                                <a href="#" id="delete" 
                                                    data-url="{{ route('admin.delete_discount', [ 'discount'=>$discount->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-danger" title="Delete Discount"><i
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
<script src="{{ asset('assets/dashboard/assets/js/admin/discount/4c676ab8-78c9-4a00-8466-a10220785897.js') }}"></script>
@endpush
@endsection
@endsection