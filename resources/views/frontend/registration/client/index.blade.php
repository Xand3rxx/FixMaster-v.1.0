@extends('layouts.auth')
@section('title', 'Register')
@section('content')
@include('layouts.partials._messages')

<style>
    .form-group textarea {
        height: 80px !important;
    }
</style>
<section class="bg-home bg-circle-gradiant d-flex align-items-center">
    <div class="bg-overlay bg-overlay-white"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="card login_page shadow rounded border-0">
                    <div class="card-body">
                        {{-- <div class="align-items-center text-center justify-content-center">
                            <img src="{{ asset('assets/images/home-fix-logo-colored.png')}}" class="img-fluid d-block mx-auto" alt="FixMaster Logo" style="width: 8em; height: auto; margin-top: -70px !important; margin-bottom: -60px !important;">
                    </div> --}}
                    <h4 class="card-title text-center texty"> <img src="{{ asset('assets/images/home-fix-logo-colored.png')}}" class="img-fluid d-block mx-auto" alt="FixMaster Logo" style="width: 6em; height: auto;">Registration</h4>
                    <form class="login-form mt-4" method="POST" action="{{route('frontend.registration.client.store', app()->getLocale())}}">
                        @csrf
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>First name <span class="text-danger">*</span></label>
                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                    <input type="text" class="form-control pl-5 @error('first_name') is-invalid @enderror" placeholder="First Name" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>Middle name </label>
                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                    <input type="text" class="form-control pl-5 @error('middle_name') is-invalid @enderror" placeholder="Middle Name" name="middle_name" id="middle_name" value="{{ old('middle_name') }}">
                                    @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>Last name <span class="text-danger">*</span></label>
                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                    <input type="text" class="form-control pl-5 @error('last_name') is-invalid @enderror" placeholder="Last Name" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>E-Mail <span class="text-danger">*</span></label>
                                    <i data-feather="mail" class="fea icon-sm icons"></i>
                                    <input type="email" class="form-control pl-5 @error('email') is-invalid @enderror" placeholder="E-Mail" name="email" id="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>Telephone <span class="text-danger">*</span></label>
                                    <img src="{{ asset('assets/flags/nigeria.gif')}}" alt="Country Flag" width="10%">
                                    <i data-feather="phone" class="fea icon-sm icons"></i>
                                    <input type="tel" class="form-control pl-5 @error('phone_number') is-invalid @enderror" placeholder="Telephone" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" maxlength="11" required>
                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <i data-feather="users" class="fea icon-sm icons"></i>
                                    <select class="form-control pl-5 @error('gender') is-invalid @enderror" name="gender" id="gender" required>
                                        <option selected value="">Select...</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : ''}}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : ''}}>Female</option>
                                    </select>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>State <span class="text-danger">*</span></label>
                                    <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                    <select class="form-control pl-5 @error('state_id') is-invalid @enderror" name="state_id" id="state_id">
                                        <option selected value="">Select...</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>L.G.A <span class="text-danger">*</span></label>
                                    <i data-feather="map" class="fea icon-sm icons"></i>
                                    <select class="form-control pl-5 @error('lga_id') is-invalid @enderror" name="lga_id" id="lga_id">
                                        <option selected value="">Select...</option>
                                    </select>
                                    @error('lga_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>Town/City <span class="text-danger">*</span></label>
                                    <i data-feather="navigation" class="fea icon-sm icons"></i>
                                    <select class="form-control pl-5" name="town_id" id="town_id">
                                        <option selected value="">Select...</option>
                                    </select>
                                    @error('town_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>Estates </label>
                                    <i data-feather="navigation" class="fea icon-sm icons"></i>
                                    <select class="form-control pl-5" name="estate_id" id="estate_id">
                                        <option selected disabled value="0">Select...</option>
                                        @foreach($activeEstates as $estate)
                                        <option value="{{ $estate->id }}">{{ $estate->estate_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                    <input type="password" class="form-control pl-5 @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required>
                                    <small style="font-size: 10px;" class="text-muted">Password must be at least 8 characters</small>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group position-relative">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                    <input type="password" class="form-control pl-5 @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password" name=" confirm_password" id="confirm_password" required>
                                    @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group position-relative">
                                    <label>Correspondence Address <span class="text-danger">*</span></label>
                                    <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                    <input type="text" class="form-control pl-5 user_address @error('full_address') is-invalid @enderror" placeholder="e.g. 284B, Ajose Adeogun Street, Victoria Island, Lagos, Nigeria." name="full_address" id="full_address" value="{{ old('full_address') }}" required>

                                    @error('full_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- hidden input field for long, and lat -->
                            <input type="hidden" class="form-control" value="{{ old('user_address') }}" name="user_address" id="user_address" placeholder="Your Location">
                            <input type="hidden" value="{{ old('address_latitude') }}" name="address_latitude" id="user_latitude">
                            <input type="hidden" value="{{ old('address_longitude') }}" name="address_longitude" id="user_longitude">
                            <input type="hidden"  name="ref"  value="{{$referralCode}}">


                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="terms_and_conditions" name="terms_and_conditions" {{ old('terms_and_conditions') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="terms_and_conditions">I Accept <a data-toggle="modal" data-target="#terms" href="javascript:void(0)" class="texty">Terms And Condition</a></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-0">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>

                            <div class="mx-auto">
                                <p class="mb-0 mt-3"><small class="text-dark mr-2">Already have an account?</small>
                                    <a href="{{ url(app()->getLocale(), 'login') }}" class="text-dark font-weight-bold">Login</a>
                                </p>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    </div>
    <!--end container-->

    <!-- Modal Content Start -->
    <div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded shadow border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Terms & Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <h5>Service Terms & Conditions</h5>

                </div>

            </div>
        </div>
    </div>
    <!-- Modal Content End -->

</section>

@push('scripts')
<script>
    $(document).ready(function() {
        "use strict";
        //Get list of L.G.A's in a particular state.
        $('#state_id').on('change', function() {
            let stateId = $('#state_id').find('option:selected').val();
            let stateName = $('#state_id').find('option:selected').text();

            // $.ajaxSetup({
            //         headers: {
            //             'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            $.ajax({
                url: "{{ route('lga_list', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "state_id": stateId
                },
                success: function(data) {
                    if (data) {
                        $('#lga_id').html(data.lgaList);
                    } else {
                        var message = 'Error occured while trying to get L.G.A`s in ' + stateName + ' state';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })
        });
        // Get List of Towns in the selected State and LGA
        $('#lga_id').on('change', function() {
            let stateId = $('#state_id').find('option:selected').val();
            let lgaId = $('#lga_id').find('option:selected').val();
            $.ajax({
                url: "{{ route('towns.show', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "state_id": stateId, "lga_id": lgaId
                },
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $('#town_id').html(data.towns_list);
                    } else {
                        var message = 'Error occured while trying to get Town`s';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })
        });


    });
</script>
@endpush
@endsection