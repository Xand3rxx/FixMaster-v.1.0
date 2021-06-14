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
                        <li class="breadcrumb-item active" aria-current="page">Add Discout/Promotion</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create New Discount</h4>
            </div>
          
        </div>


        <form id="discountForm" method="POST" action="{{ route('admin.store_discount', app()->getLocale()) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <label for="entity">Select Entity</label>
                            <select id="entity_id" name="entity" class="custom-select cs-select" id>
                                <option selected value="">Select...</option>
                                @foreach($entities as $key => $value)
                                <option value="{{ strtolower($value->name) }}"
                                    {{ old('entity') ==  strtolower($value->name) ? 'selected' : ''}}>
                                    {{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('entity')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span class="invalid-feedback-err"></span>
                        </div>
                        <div class="form-group col-md-12 show-estate d-none">
                            <label>Select Estate</label>
                            <select class="custom-select cs-select" name="estate_name" id="estate_id">
                                <option selected value="">Select...</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <hr />
                        </div>
                        <fieldset class="form-fieldset col-md-12 parameter d-none" style="margin-bottom:30px">
                            <legend>Filter By Additional Fields</legend>

                            <div class="form-row">
                                <br>
                                <div class="form-group col-md-3">
                                    <label for="specified_request_count_morethan">Count of Services Requests Range(From)</label>
                                    <input type="number" min="1" class="form-control custom-input-1 get_users"
                                        id="specified_request_count_morethan" name="specified_request_count_morethan"
                                        value="{{ old('specified_request_count_morethan') }}" autocomplete="off">
                                        @error('specified_request_count_morethan')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="specified_request_count_equalto">Count of Services Requests Range(To)</label>
                                    <input type="number" min="1" class="form-control custom-input-1 get_users"
                                        id="specified_request_count_equalto" name="specified_request_count_equalto"
                                        value="{{ old('specified_request_count_equalto') }}" autocomplete="off">
                                        @error('specified_request_count_equalto')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="specified_request_amount_from">Sum of Services Requests
                                        Amount(from)</label>
                                    <input type="text" class="form-control custom-input-1 get_users" 
                                        id="specified_request_amount_from" name="specified_request_amount_from"
                                        value="{{ old('specified_request_amount_from') }}" autocomplete="off">
                                        @error('specified_request_amount_from')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="specified_request_amount_to">Sum of Services Requests
                                        Amount(To)</label>
                                    <input type="number" min="1" class="form-control custom-input-1 get_users"
                                        id="specified_request_amount_to" name="specified_request_amount_to"
                                        value="{{ old('specified_request_amount_to') }}" autocomplete="off">
                                        @error('specified_request_amount_to')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="specified_request_start_date">Date Range(from)</label>
                                    <input type="date" class="form-control custom-input-1 get_users" 
                                        id="specified_request_start_date" name="specified_request_start_date"
                                        value="{{ old('specified_request_start_date') }}" autocomplete="off">
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="specified_request_end_date">Date Range(to)</label>
                                    <input type="date" class="form-control custom-input-1 get_users"
                                        id="specified_request_end_date" name="specified_request_end_date"
                                        value="{{ old('specified_request_end_date') }}" autocomplete="off">
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="entity">States</label>
                                    <select id="state_id" name="specified_request_state" class="custom-select cs-select get_users">
                                        <option selected value="">Select...</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state') == $state->id ? 'selected' : ''}}>
                                            {{ $state->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group col-md-3">
                                    <label>LGAs</label>
                                    <select class="custom-select cs-select get_users" name="specified_request_lga" id="lga_id">
                                        <option selected value="">Select...</option>
                                    </select>
                                </div>
                            </div>
                            
                        </fieldset>
                   
                     
                        



                        <div class="form-group col-md-10 parameter d-none add-users" >
                        <div class="spinner1 d-none">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">...</div>
                        </div>
                          
                            <label class='add-page'>Add Users</label>
                        
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

                        <div class="form-group col-md-2 parameter d-none add-users">
                            <label class='add-page'>Users' Count</label>
                            <input type="text" disabled class="form-control user-count"/>
                        
                        </div>



                     

                        <div class="form-group col-md-10 d-none show-estate" id="estate-users">
                        <div class="spinner1 d-none">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">...</div>
                        </div>
                            <label class='add-page not-users'>Add Estate Users</label>
                            <select class="selectpicker show-tick select-user" id="estate-user" name="users[]"
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

                        <div class="form-group col-md-2 show-estate d-none" >
                            <label class='add-page not-users'>Users' Count</label>
                            <input type="text" disabled class="form-control user-count-estate" />
                        
                        </div>


                        <div class="form-group col-md-6 show-service d-none">
                            <label class='add-page'>Select Service Category</label>
                            <select class="selectpicker show-tick select-all-service" id="category_id" name="category[]"
                                title="select..." multiple="multiple" data-selected-text-format="count>3"
                                data-live-search="true">
                                <option value="">Select...</option>
                            </select>
                            @error('category')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group col-md-6 show-service d-none">
                        <div class="spinner1 d-none">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">...</div>
                        </div>
                            <label class='add-page'>Select Services</label>
                            <select class="selectpicker show-tick select-services" id="service_id" name="services[]"
                                title="select..." multiple="multiple" data-selected-text-format="count>3"
                                data-live-search="true">
                                <option value="">Select...</option>
                            </select>
                        </div>

                        <div class="form-group col-md-10 show-service d-none" id="add-users">
                            <label class='add-page service'>Add Users</label>
                            <select class="selectpicker show-tick select-user" id="service-users" name="users[]"
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
                        <div class="form-group col-md-2 show-service d-none">
                            <label class='add-page'>Users' Count</label>
                            <input type="text" disabled class="form-control user-count"/>
                        
                        </div>
             
                        <div class="form-group col-md-12">
                            <hr />
                        </div>
                 

                     
                        <div class="form-group col-md-12"> </div>
                    

                        <div class="form-group col-md-4">
                            <label for="discount_name">Name of discount</label>
                            <input type="text" class="form-control custom-input-1" id="discount_name"
                                name="discount_name" value="{{ old('discount_name') }}" autocomplete="off">
                            @error('discount_name')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group col-md-4">
                            <label for="rate">Rate</label>
                            <div class="input-group">
                                <input type="number" min="0.1" step="any" id="rate" class="form-control" name="rate" value="{{ old('rate') }}"
                                    aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                    <span id="percentage" class="input-group-text">0.00</span>
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('rate')
                                <span class="invalid-feedback-err">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                                    <label for="entity">Apply Discount To</label>
                                    <select id="apply_id" name="apply_discount" class="custom-select cs-select">
                                        <option selected value="">Select...</option>
                                        @foreach($apply_discount as $apply)
                                        <option value="{{ $apply }}"
                                            {{ old('apply') == $apply ? 'selected' : ''}}>
                                            {{ $apply }}</option>
                                        @endforeach
                                    </select>
                                    @error('apply_discount')
                                <span class="invalid-feedback-err">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>

                        <div class="form-group col-md-6">
                            <label for="start_date">Duaration(Start)</label>
                            <input type="date" class="form-control custom-input-1" id="start_date"
                                min=<?= date('Y-m-d'); ?> name="start_date" value="{{ old('start_date') }}"
                                autocomplete="off">
                            @error('start_date')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">Duration(End)</label>
                            <input type="date" class="form-control custom-input-1" id="end_date"
                                min=<?= date('Y-m-d');?> name="end_date" value="{{ old('end_date') }}"
                                autocomplete="off">
                            @error('end_date')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea rows="3" class="form-control" id="description-1" rows="5" maxlength="250"
                                name="description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label> Notify Users</label>
                        <div class="flex-this">
                            <span class="f" style="display:flex">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="notify" class="custom-control-input"
                                        {{ old('notify') == 1 ? 'checked' : ''}} value="1">
                                    <label class="custom-control-label" for="customRadio1">Yes</label>
                                </div>

                                <div class="custom-control custom-radio" style="padding-left: 50px">
                                    <input type="radio" id="customRadio2" name="notify" class="custom-control-input"
                                        {{ old('notify') == 0 ? 'checked' : ''}} value="0">
                                    <label class="custom-control-label" for="customRadio2">No</label>
                                </div>
                            </span>

                            <button type="submit" class="btn btn-primary pull-right-1">Create</button>
                        </div>
                    

                    </div>
                
                </div>
              
            </div>
        </form>
<input type="hidden"  data-estate="{{ route('admin.all_estates',app()->getLocale()) }}" id="get_estate_url" />
<input type="hidden"  data-client="{{ route('admin.discount_users',app()->getLocale()) }}" id="get_client_users_url" />
<input type="hidden"  data-state="{{ route('admin.all_estates',app()->getLocale()) }}" id="get_state_url" />
<input type="hidden"  data-lga="{{ route('admin.getLGA',app()->getLocale()) }}" id="get_lga_url" />
<input type="hidden"  data-category="{{ route('admin.categories',app()->getLocale()) }}" id="get_category_url" />
<input type="hidden"  data-services="{{ route('admin.category_services',app()->getLocale()) }}" id="get_services_url" />

    </div>
</div>
@push('scripts')

<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/admin/discount/4c676ab8-78c9-4a00-8466-a10220785894.js') }}"></script>

@endpush
@endsection