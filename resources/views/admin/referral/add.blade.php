@extends('layouts.dashboard')
@section('title', 'Create New Discount /Promotion')
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
                        <li class="breadcrumb-item active" aria-current="page">Add Referral Code</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create New Referral Code</h4>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.referral_list',app()->getLocale()) }}" class="btn btn-primary"><i
                        class="fas fa-arrow-left"></i> Referral List</a>
            </div>
        </div>


        <form id="discountForm" method="POST" action="{{ route('admin.referral_store', app()->getLocale()) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="entity">Select UserType</label>
                            <select id="entity_id" name="entity" class="custom-select cs-select" id>
                                <option selected value="">Select...</option>
                                @foreach($entities as $value)
                                <option value="{{ strtolower($value) }}"
                                    {{ old('entity') ==  strtolower($value) ? 'selected' : ''}}>
                                    {{ $value }}</option>
                                @endforeach
                            </select>
                            @error('entity')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span class="invalid-feedback-err"></span>
                        </div>

                        <div class="form-group col-md-6 d-none cses">
                            <label class='add-page'>Select Cses</label>
                            <select class="selectpicker show-tick select-user" id="users" name="cses"
                                title="select..." 
                                data-live-search="true">
                                @foreach($cses as $value)
                                <option value="{{ $value->account_id }}"
                                    {{ old('users') ==  $value ? 'selected' : ''}}>
                                    {{ $value->first_name  }}</option>
                                @endforeach
                            </select>
                            @error('cses')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 d-none clients">
                        <label class='add-page'>Select Client</label>
                            <select class="selectpicker show-tick select-user" id="users" name="users"
                                title="select..."
                                data-live-search="true">
                                @foreach($clients as $value)
                                <option value="{{ $value->account_id }}"
                                    {{ old('users') ==  $value ? 'selected' : ''}}>
                                    {{ $value->first_name  }}</option>
                                @endforeach
                            </select>
                            @error('users')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">Add Referral Code</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@push('scripts')

<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/admin/referral/b09fced7-c17b-4b2e-b716-96323e4ab730.js') }}"></script>

@endpush
@endsection