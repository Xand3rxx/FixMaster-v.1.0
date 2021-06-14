@extends('layouts.dashboard')
@section('title', 'Create New Estate')
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.list_estate', app()->getLocale()) }}">Estates</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Estate</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Create New Estate</h4>
                </div>
            </div>

            <form action="{{ route('admin.store_estate', app()->getLocale()) }}" method="POST">
            @csrf
            <fieldset class="form-group border p-4">
            <legend class="w-auto px-2">Personal Details</legend>
            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="first_name">First name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="First name">
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="middle_name">Middle name</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" placeholder="Middle name">
                            @error('middle_name')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="last_name">Last name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last name">
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="email">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="E-mail" >
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" placeholder="Phone Number" >
                            @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth" >
                            @error('date_of_birth')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Identification <strong>(ID)</strong> Type <span class="text-danger">*</span></label>
                            <select class="custom-select @error('identification_type') is-invalid @enderror" name="identification_type">
                                <option>Select...</option>
                                <option value="National ID">National ID</option>
                                <option value="International Passport">Internation Passport</option>
                                <option value="Voters Card">Voters Card</option>
                                <option value="Drivers License">Drivers License</option>
                            </select>
                            @error('identification_type')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>Identification <strong>(ID)</strong> Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('identification_number') is-invalid @enderror" id="identification_number" name="identification_number" placeholder="Identification Number">
                            @error('identification_number')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="expiry_date">Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" name="expiry_date" placeholder="Expiry Date" >
                            @error('expiry_date')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="full_address">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('full_address') is-invalid @enderror" id="full_address" name="full_address" placeholder="Address"></textarea>
                            @error('full_address')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
                </fieldset>
                <fieldset class="form-group border p-4">
                    <legend class="w-auto px-2">Estate Details</legend>
                    <div class="row row-xs">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="estate_name">Estate name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('estate_name') is-invalid @enderror" id="estate_name" name="estate_name" placeholder="Estate name">
                                    @error('estate_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="state_id">State <span class="text-danger">*</span></label>
                                    <select class="custom-select @error('state_id') is-invalid @enderror" id="state_id" name="state_id">
                                        <option>Select...</option>
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
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="lga_id">L.G.A <span class="text-danger">*</span></label>
                                    <select class="custom-select @error('lga_id') is-invalid @enderror" id="lga_id" name="lga_id">
                                        <option>Select...</option>
                                        @error('lga_id')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="town">Town <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('town') is-invalid @enderror" id="town" name="town" placeholder="Town">
                                    @error('town')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="landmark">Nearest Landmark <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('landmark') is-invalid @enderror" id="landmark" name="landmark" placeholder="Nearest Landmark">
                                    @error('landmark')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>

        </div>
    </div>

@section('scripts')
    <script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>

    <script>
        $('.selectpicker').selectpicker();
    </script>

@endsection

@push('scripts')
    <script>
        $(document).ready(function (){
            //Get list of L.G.A's in a particular state.
            $('#state_id').on('change',function () {
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
                    data: {"_token": "{{ csrf_token() }}", "state_id":stateId},
                    success: function(data){
                        if(data){

                            $('#lga_id').html(data.lgaList);
                        }else{
                            var message = 'Error occured while trying to get L.G.A`s in '+ stateName +' state';
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
