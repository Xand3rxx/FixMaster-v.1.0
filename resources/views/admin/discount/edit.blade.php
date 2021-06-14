@extends('layouts.dashboard')
@section('title', 'Edit Discount /Promotion')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.discount_list', app()->getLocale()) }}">Discount List</a></li>

                        <li class="breadcrumb-item active" aria-current="page">Edit Discount/ Edit Promotion</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Edit Discount</h4>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.discount_list',app()->getLocale()) }}" class="btn btn-primary"><i
                        class="fas fa-arrow-left"></i> Discount List</a>
                <a href="{{ route('admin.add_discount',app()->getLocale()) }}" class="btn btn-warning"><i
                        class="fas fa-plus"></i> Add Discount</a>

            </div>
        </div>


        <form id="discountForm" method="POST" action="{{ route('admin.store_discount_edit', app()->getLocale()) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <label for="entity">Select Entity</label>
                            <select id="entity_id" name="entity" class="custom-select cs-select">
                               <?php $statuses = !empty($status->entity) ? $status->entity : 'select'?>
                                @foreach($entities as $key => $value)
                                <option value="{{ strtolower($value->name) }}"
                                    {{ $statuses ==  strtolower($value->name) ? 'selected' : ''}}>
                                    {{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('entity')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span class="invalid-feedback-err"></span>
                            <?php $uuid = !empty($status->uuid) ? $status->uuid : 'select'?>
                            <input type="hidden" name="discount_id" value="{{$uuid}}" />
                        </div>
                        <div class="form-group col-md-12 show-estate">
                            <label>Select Estate</label>
                            <select class="custom-select cs-select" name="estate_name" id="estate_id">
                                <option selected value="">Select...</option>
                            </select>
                            <input type="hidden" id="estate_value" name="estate_value" value="{{$estate}}" />
                        </div>

                        <div class="form-group col-md-12">
                            <hr />
                        </div>

                        <fieldset class="form-fieldset col-md-12 parameter" style="margin-bottom:30px">
                            <legend>Filter By Additional Fields</legend>

                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    @php $specified_request_count_morethan =
                                    isset($field->specified_request_count_morethan)?
                                    $field->specified_request_count_morethan : ''; @endphp
                                    <label for="specified_request_count_morethan">Count of Services Requests Range(From)</label>
                                    <input type="number" min="1" class="form-control custom-input-1 get_users"
                                        id="specified_request_count_morethan" name="specified_request_count_morethan"
                                        value="{{$specified_request_count_morethan}}" autocomplete="off">

                                        @error('specified_request_count_morethan')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    @php $specified_request_count_equalto =
                                    isset($field->specified_request_count_equalto)?
                                    $field->specified_request_count_equalto : ''; @endphp
                                    <label for="specified_request_count_equalto">Count of Services Requests Range(To)</label>
                                    <input type="number" min="1" class="form-control custom-input-1 get_users"
                                        id="specified_request_count_equalto" name="specified_request_count_equalto"
                                        value="{{$specified_request_count_equalto}}" autocomplete="off">
                                        @error('specified_request_count_equalto')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    @php $specified_request_amount_from = isset($field->specified_request_amount_from)?
                                    $field->specified_request_amount_from : ''; @endphp
                                    <label for="specified_request_amount_from">Sum of Services Requests
                                        Amount(from)</label>
                                    <input type="number" min="1" class="form-control custom-input-1 get_users"
                                        id="specified_request_amount_from" name="specified_request_amount_from"
                                        value="{{ $specified_request_amount_from }}" autocomplete="off">
                                        @error('specified_request_amount_from')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    @php $specified_request_amount_to = isset($field->specified_request_amount_to)?
                                    $field->specified_request_amount_to : ''; @endphp
                                    <label for="specified_request_amount_to">Sum of Services Requests
                                        Amount(To)</label>
                                    <input type="number" min="1" class="form-control custom-input-1 get_users"
                                        id="specified_request_amount_to" name="specified_request_amount_to"
                                        value="{{ $specified_request_amount_to }}" autocomplete="off">
                                        @error('specified_request_amount_to')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    @php $specified_request_start_date = isset($field->specified_request_start_date)?
                                    Carbon\Carbon::parse( $field->specified_request_start_date,
                                    'UTC')->isoFormat("Y-MM-DD") : ''; @endphp
                                    <label for="sspecified_request_start_date">Date Range(from)</label>
                                    <input type="date" class="form-control custom-input-1 get_users"
                                        id="specified_request_start_date" name="specified_request_start_date"
                                        value="{{$specified_request_start_date}}" autocomplete="off">
                                </div>


                                <div class="form-group col-md-3">
                                    @php $specified_request_end_date = isset($field->specified_request_end_date)?
                                    Carbon\Carbon::parse($specified_request_end_date, 'UTC')->isoFormat("Y-MM-DD") : '';
                                    @endphp
                                    <label for="sspecified_request_end_date">Date Range(to)</label>
                                    <input type="date" class="form-control custom-input-1 get_users"
                                        id="specified_request_end_date" name="specified_request_end_date"
                                        value="{{$specified_request_end_date}}" autocomplete="off">
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="entity">States</label>
                                    @php $name = isset($request_state->name)? $request_state->name : ''; @endphp
                                    @php $id = isset($request_state->id)? $request_state->id : ''; @endphp
                                    <select id="state_id" name="specified_request_state" class="custom-select cs-select get_users">
                                        <option value="{{$id }}"> {{$name}} </option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state') == $state->id ? 'selected' : ''}}>
                                            {{ $state->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group col-md-3">
                                    @php $specified_request_lga = isset($field->specified_request_lga)?
                                    $field->specified_request_lga : ''; @endphp
                                    @php $name = isset($request_lga->name)?$request_lga->name : ''; @endphp

                                    <label>L.G.A</label>
                                    <select class="custom-select cs-select get_users" name="specified_request_lga" id="lga_id">
                                        <option value="{{ $specified_request_lga }}"> {{$name}} </option>
                                    </select>
                                </div>

                              

                            </div>
                        </fieldset>

                        <div class="form-group col-md-10 parameter add-users">
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
                            <input type="hidden" name="edit_users[]" value="{{$users}}" id="edit_users" />
                        </div>


                        <div class="form-group col-md-2 parameter add-users">
                            <label class='add-page'>Users' Count</label>
                            <input type="text" disabled class="form-control user-count"/>
                        
                        </div>

                     

                        <div class="form-group col-md-10 parameter show-estate" id="estate-users">
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

                        <div class="form-group col-md-2 parameter show-estate" >
                            <label class='add-page not-users'>Users' Count</label>
                            <input type="text" disabled class="form-control user-count-estate" />
                        
                        </div>

                     


                        <div class="form-group col-md-6 show-service">
                            <label class='add-page'>Select Service Category</label>
                            <select class="selectpicker show-tick select-all-service" id="category_id" name="category[]"
                                title="select..." multiple="multiple" data-selected-text-format="count>3"
                                data-live-search="true">
                                <option value="">Select...</option>
                            </select>

                            <input type="hidden" name="edit_category[]" value="{{$category}}" id="edit_category" />
                            <input type="hidden" name="edit_services[]" value="{{$services}}" id="edit_services" />
                        </div>


                        <div class="form-group col-md-6 show-service">
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

                        <div class="form-group col-md-10 show-service" >
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
                        <div class="form-group col-md-2 show-service">
                            <label class='add-page'>Users' Count</label>
                            <input type="text" disabled class="form-control user-count"/>
                        
                        </div>


                        <div class="form-group col-md-12">
                            <hr />
                        </div>


                


                        <div class="form-group col-md-12 parameter">
                            <hr />
                        </div>


                        <div class="form-group col-md-4">
                            <label for="discount_name">Name of discount</label>
                            <?php $name = !empty($status->name) ? $status->name : 'select'?>
                            <input type="text" class="form-control custom-input-1" id="discount_name"
                                name="discount_name" value="{{ $name }}" autocomplete="off">
                            @error('discount_name')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>




                        <div class="form-group col-md-4">
                            <label for="rate">Rate</label>
                            <div class="input-group">
                            <?php $rate = !empty($status->rate) ? $status->rate : 'select'?>
                                <input type="number" min="0.1" step="any" id="rate" class="form-control" name="rate"
                                    aria-label="Dollar amount" value="{{ $rate }}">
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
                                    <?php $apply_discount = !empty($status->apply_discount) ? $status->apply_discount : 'select'?>
                                    <select id="apply_id" name="apply_discount" class="custom-select cs-select">
                                        <option selected value="">Select...</option>
                                        @foreach($apply_discounts as $apply)
                                            <option value="{{ $apply}}"
                                        {{ $apply_discount ==  $apply ? 'selected' : ''}}>
                                        {{ $apply }}
                                    </option>
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
                            <?php $duration_start = !empty($status->duration_start) ? $status->duration_start : date('y-m-d')?>
                            <input type="date" class="form-control custom-input-1" id="start_date"
                                min=<?= date('Y-m-d'); ?> name="start_date"
                                value="{{ Carbon\Carbon::parse($duration_start, 'UTC')->isoFormat("Y-MM-DD") }}"
                                autocomplete="off">
                            @error('from_date')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">Duration(End)</label>
                            <?php $duration_end = !empty($status->duration_end) ? $status->duration_end : date('y-m-d')?>
                            <input type="date" class="form-control custom-input-1" id="end_date"
                                min=<?= date('Y-m-d');?> name="end_date"
                                value="{{ Carbon\Carbon::parse($duration_end, 'UTC')->isoFormat("Y-MM-DD") }}"
                                autocomplete="off">
                            @error('discount_name')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                        <?php $description = !empty($status->description) ? $status->description : 'select'?>
                            <label for="description">Description</label>
                            <textarea rows="3" class="form-control" id="description-1" rows="5" maxlength="250"
                                name="description">{{ $description }}</textarea>
                        </div>
                    </div>



                    <div class="col-md-12">
                    <?php $notify = !empty($status->notify) ? $status->notify : 'select'?>
                        <label> Notify Users</label>
                        <div class="flex-this">
                            <span class="f" style="display:flex">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="notify" class="custom-control-input"
                                        {{ $notify == '1' ? 'checked' : ""}} value="1" name="notify">
                                    <label class="custom-control-label" for="customRadio1">Yes</label>
                                </div>

                                <div class="custom-control custom-radio" style="padding-left: 50px">
                                    <input type="radio" id="customRadio2" name="notify" class="custom-control-input"
                                        {{ $notify == 0 ? 'checked' : ''}} value="0">
                                    <label class="custom-control-label" for="customRadio2">No</label>
                                </div>
                            </span>

                            <button type="submit" class="btn btn-primary pull-right-1">Update</button>
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
<input type="hidden"  data-categoryServicesEdit=" {{ route('admin.category_services_edit',app()->getLocale()) }}" id="get_category_services_edit_url" />
<input type="hidden"  data-services="{{ route('admin.category_services',app()->getLocale()) }}" id="get_services_url" /> 
<input type="hidden"  data-token="{{ csrf_token() }}" class="get_token" /> 
<input type="hidden"  data-category-edit="{{ route('admin.categories_edit',app()->getLocale()) }}" id="get_category_edit_url" />
<input type="hidden"  data-client-edit="{{ route('admin.discount_users_edit',app()->getLocale()) }}" id="get_client_users_edit_url" />


    </div>
</div>
@push('scripts')

<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/admin/discount/4c676ab8-78c9-4a00-8466-a1022078589-e.js') }}"></script> 
@endpush
@endsection