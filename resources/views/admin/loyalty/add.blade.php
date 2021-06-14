@extends('layouts.dashboard')
@section('title', 'Create New Loyalty')
@include('layouts.partials._messages')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/bootstrap-multiselect.css') }}">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> --}}
<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Loyalty </li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create New Loyalty</h4>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.loyalty_list',app()->getLocale()) }}" class="btn btn-primary"><i
                        class="fas fa-arrow-left"></i> Loyalty List</a>
            </div>
        </div>


        <form  method="POST" action="{{ route('admin.loyalty_store', app()->getLocale()) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="form-row">

                    <div class="form-group col-md-6 parameter">
                    <label for="specified_request_amount_from">Select a Sum of Services Requests
                        Amount</label>
                    <input type="number" class="form-control custom-input-1" id="sum"
                        id="specified_request_amount" name="specified_request_amount"
                        value="{{ old('specified_request_amount') }}" autocomplete="off">
                        @error('specified_request_amount')
                        <span class="invalid-feedback-err">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>

                    

                        <div class="form-group col-md-6">
                            <label for="rate">Points</label>
                            <div class="input-group">
                                <input type="number" min="0.1" step="any" id="points" class="form-control" name="points" value="{{ old('points') }}"
                                    aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                <span class="input-group-text">%</span>
                                    <span id="percentage" class="input-group-text">0.00</span>
                                    <span class="input-group-text">&#8358;</span>
                                </div>
                                @error('points')
                                <span class="invalid-feedback-err">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                             
                        </div>
                      
                        <div class="form-group col-md-6" >
                        <div class="spinner1 d-none">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">...</div>
                        </div>
                            <label class='add-page service'>Select Client Who have Rated</label>
                            <select class="selectpicker show-tick select-user" id="users" name="users[]"
                                title="select..." multiple="multiple" data-selected-text-format="count>3"
                                data-live-search="true">
                                <option value="">Select...</option>
                            </select>
                            @error('users')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6" >
                            <label class='add-page not-users'>Users' Count</label>
                            <input type="number" disabled class="form-control user-count" />
                        
                        </div>
                        </div>

                        <div class="form-row">
                        <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Add Loyalty Points</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
<input type="hidden"  data-users="{{ route('admin.loyalty_users',app()->getLocale()) }}" id="get_users_url" />
<input type="hidden"  data-token="{{ csrf_token() }}" class="get_token" /> 
    </div>
</div>
@push('scripts')

<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/admin/loyalty/2d5e497c-d12d-43ec-ac7a-a14f825ffaed.js') }}"></script>
@endpush
@endsection