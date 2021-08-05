@extends('layouts.dashboard')
@section('title', 'Create New Supplier Account')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/bootstrap-multiselect.css') }}">

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Supplier</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create New Supplier</h4>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.users.supplier.index', app()->getLocale()) }}" class="btn btn-primary"><i data-feather="wind"></i> Supplier List</a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.supplier.store', app()->getLocale()) }}" enctype="multipart/form-data">
            @csrf
            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="first_name">First Name</label>
                            <input required type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ $applicant['form_data']['first_name'] ?? old('first_name') }}" placeholder="First Name" autocomplete="off">
                            @error('first_name')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $applicant['form_data']['middle_name'] ?? old('middle_name') }}" autocomplete="off" placeholder="Middle Name">
                            @error('middle_name')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ $applicant['form_data']['last_name'] ?? old('last_name') }}" autocomplete="off" placeholder="Last Name">
                            @error('last_name')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-Mail" name="email" id="email" value="{{ $applicant['form_data']['email'] ?? old('email') }}" required autocomplete="off">
                            @error('email')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone_number">Phone Number</label>
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone Number" name="phone_number" id="phone_number" value="{{ $applicant['form_data']['phone'] ?? old('phone_number') }}" maxlength="11" required autocomplete="off">
                            @error('phone_number')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cac_number">CAC Number</label>
                            <input type="text" class="form-control @error('cac_number') is-invalid @enderror" placeholder="CAC Number" name="cac_number" id="cac_number" value="{{ $applicant['form_data']['cac_number'] ?? old('cac_number') }}" required autocomplete="off">
                            @error('cac_number')
                            <x-alert :message="$message" />
                            @enderror
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="established_on">Established On</label>
                            <input type="date" class="form-control @error('established_on') is-invalid @enderror" placeholder="Established On" name="established_on" id="established_on" value="{{ $applicant['form_data']['establishment_date'] ?? old('established_on') }}" required autocomplete="off">
                            @error('established_on')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="supplier_name">Business Name</label>
                            <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" placeholder="Supplier Name" name="supplier_name" id="supplier_name" value="{{ $applicant['form_data']['company_name'] ?? old('supplier_name') }}" required autocomplete="off">

                            @error('supplier_name')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Service Category</label>
                            <select class="form-control selectpicker @error('supplier_category') is-invalid @enderror" id="supplier_category" name="supplier_category[]" multiple="multiple" data-live-search="true">
                                @foreach ($services as $service)
                                <optgroup label="{{ $service->name }}">
                                    @foreach($service->services as $item)
                                    @if(!empty($applicant))
                                    <option @if (in_array($item->id, $applicant['form_data']['supplier_category'])) {{'selected'}} @endif  value="{{ $item->id }}"> {{ $item->name }} </option>
                                   @endif
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            @error('supplier_category')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="supplier_description">Business Description</label>
                            <textarea required id="supplier_description" class="form-control @error('supplier_description') is-invalid @enderror" rows="1" name="supplier_description" placeholder="Brief description of the Supplier business">{{ old('supplier_description') }}</textarea>
                            @error('supplier_description')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Education Level</label>
                            <select required class="form-control @error('education_level') is-invalid @enderror" name="education_level" id="education_level">
                                <option selected disabled value="0">Select...</option>
                                @foreach($education_levels as $education_level)
                                <option value="{{ $education_level}}">{{ Str::title(Str::of($education_level)->replace('-', ' ',)) }}</option>
                                @endforeach
                            </select>
                            @error('education_level')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Bank Name</label>
                            <select required id="bank_id" name="bank_id" class="custom-select bank_id @error('bank_id') is-invalid @enderror">
                                <option selected value="">Select...</option>
                                @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : ''}}>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="account_number">Account Number</label>
                            <input type="tel" required class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number') }}" placeholder="Account Number" maxlength="10" autocomplete="off">
                            @error('account_number')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Profile Avatar</label>
                            <div class="custom-file">
                                <input type="file" accept="image/*" class="custom-file-input @error('avatar') is-invalid @enderror" name="avatar" id="avatar">
                                <label class="custom-file-label" id="image-name" for="image">Upload Profile Avatar</label>
                                @error('avatar')
                                <x-alert :message="$message" />
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required minlength="8" autocomplete="off">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Password must be 8 characters at least.
                                <a href="{{ route('admin.users.supplier.index', app()->getLocale()) }}" class="random-password"> Generate random </a>
                            </small>
                            @error('password')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" required class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" minlength="8 placeholder=" Confirm Password" autocomplete="off">
                            @error('confirm_password')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>State</label>
                            <select required class="form-control @error('state_id') is-invalid @enderror" name="state_id" id="state_id">
                                <option selected disabled value="0">Select...</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id')
                            <x-alert :message="$message" />
                            @enderror
                        </div>

                        <div id="lga-content" class="form-group col-md-4">
                            <label>L.G.A</label>
                            <select required class="form-control @error('lga_id') is-invalid @enderror" name="lga_id" id="lga_id">
                                <option disabled selected value="0">Select a State first</option>
                            </select>
                            @error('lga_id')
                            <x-alert :message="$message" />
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>Town/City</label>
                            <input type="text" class="form-control @error('town') is-invalid @enderror" placeholder="e.g. CMS, Ikoyi, Egbeda" name="town" id="town" value="{{ old('town') }}" required>
                            @error('town')
                            <x-alert :message="$message" />
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputAddress2">Full Address</label>
                            <textarea required id="user_address" class="user_address form-control @error('full_address') is-invalid @enderror" rows="3" name="full_address" id="full_address" placeholder="e.g. 284B, Ajose Adeogun Street, Victoria Island, Lagos, Nigeria.">{{ $applicant['form_data']['office_address'] ?? old('full_address') }}</textarea>
                            @error('full_address')
                            <x-alert :message="$message" />
                            @enderror

                            <input type="hidden" value="{{ old('address_latitude') }}" name="address_latitude" id="user_latitude">
                            <input type="hidden" value="{{ old('address_longitude') }}" name="address_longitude" id="user_longitude">

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create New Supplier </button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/js/password-generator.js') }}"></script>
<script src="{{ asset('assets/js/geolocation.js') }}"></script>

<script>
    $(document).ready(function() {
        "use strict";
        $('.selectpicker').selectpicker();
        //Append the image name from file options to post cover field
        $('input[type="file"]').change(function(e) {
            let fileName = e.target.files[0].name;
            $('#image-name').text(fileName);
        });

        //Get list of L.G.A's in a particular state.
        $('#state_id').on('change', function() {
            let stateId = $('#state_id').find('option:selected').val();
            let stateName = $('#state_id').find('option:selected').text();
            $.ajax({
                url: "{{ route('lga_list', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    state_id: stateId
                },
                success: function(data) {
                    if (data) {
                        $('#lga-content').removeClass('d-none')
                        $('#lga_id').html(data.lgaList);
                    } else {
                        $('#lga-content').addClass('d-none')
                        let message = 'Error occured while trying to get L.G.A`s in ' + stateName + ' state';
                        let type = 'error';
                        displayMessage(message, type);
                    }
                },
            })
        });

        // Random Password Generator
        $('.random-password').on('click', function(e) {
            e.preventDefault()
            const random_password = generatePassword();
            $('#password').val(random_password)
            $('#confirm_password').val(random_password)
        });
    });
</script>

@endpush
@endsection