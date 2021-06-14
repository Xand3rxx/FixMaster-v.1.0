@extends('layouts.client')
@section('title', 'Settings')
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12">
    <div class="card border-0 rounded shadow">
        <div class="card-body mt-">
            <h5 class="text-md-left text-center">Personal Detail :</h5>

            <div class="mt-3 text-md-left text-center d-sm-flex">
                {{-- <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar float-md-left avatar-medium rounded-circle shadow mr-md-4" alt=""> --}}

                @if(!empty($client->avatar))
                    <img src="{{ asset('assets/client-avatars/'.$client->avatar) }}" class="avatar float-md-left avatar-medium rounded-circle shadow mr-md-4" alt="{{ $user->fullName->name }}" />
                @else
                    @if($client->gender == 'Male')
                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="avatar float-md-left avatar-medium rounded-circle shadow mr-md-4" />
                    @else
                        <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="avatar float-md-left avatar-medium rounded-circle shadow mr-md-4" />
                    @endif
                @endif

                <div class="mt-md-4 mt-3 mt-sm-0">
                    <button type="button" class="btn btn-primary btn-sm mt-2 change-picture">Change Picture</button>

                    <form method="POST" action="{{ route('client.update_profile_avatar') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                        <input type="hidden" id="old_avatar" name="old_avatar" value="{{ $client->avatar }}">
                        <input type="file" accept="image/*" class="d-none" name="avatar" id="avatar">
                        <button type="submit" class="btn btn-outline-primary  btn-sm d-none mt-2" id="submit-avatar">Save Picture</button>
                    </form>
                </div>
            </div>

        <form method="POST" action="{{ route('client.update_profile') }}">
                @csrf @method('PUT')
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>First Name</label>
                            <i data-feather="user" class="fea icon-sm icons"></i>
                            <input name="first_name" id="first_name" type="text" class="form-control pl-5 @error('first_name') is-invalid @enderror" value="{{ old('first_name') ?? $client->first_name }}" placeholder="First Name :">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col-->

                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>Middle Name</label>
                            <i data-feather="user" class="fea icon-sm icons"></i>
                            <input name="middle_name" id="middle_name" type="text" class="form-control pl-5 @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') ?? $client->middle_name }}" placeholder="Middle Name :">
                            @error('middle_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col-->
                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>Last Name</label>
                            <i data-feather="user" class="fea icon-sm icons"></i>
                            <input name="last_name" id="last_name" type="text" class="form-control pl-5 @error('middle_name') is-invalid @enderror" value="{{ old('last_name') ?? $client->last_name }}" placeholder="Last Name :">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col-->
                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>Your Email</label>
                            <i data-feather="mail" class="fea icon-sm icons"></i>
                            <input name="email" id="email" type="email" class="form-control pl-5 @error('email') is-invalid @enderror" value="{{ old('email') ?? $user->email }}" placeholder="Your E-Mail :">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col-->
                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>Phone No. :</label>
                            <i data-feather="phone" class="fea icon-sm icons"></i>
                            <input name="phone_number" id="phone_number" type="tel" maxlength="11" class="form-control pl-5 @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') ?? $client->phone_number }}" placeholder="Phone :">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col-->
                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>Occupation</label>
                            <i data-feather="bookmark" class="fea icon-sm icons"></i>
                            <select class="form-control pl-5 @error('profession_id') is-invalid @enderror" name="profession_id" id="profession_id">
                                <option selected value="">Select...</option>
                                @foreach($professions as $profession)
                                    <option value="{{ $profession->id }}" {{ old('profession_id') == $profession->id ? 'selected' : ''}} @if($client->profession_id == $profession->id) selected @endif>{{ $profession->name }}</option>
                                @endforeach
                            </select>
                            @error('profession_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>State <span class="text-danger">*</span></label>
                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                            <select class="form-control pl-5 @error('state_id') is-invalid @enderror" name="state_id" id="state_id">
                                <option selected value="">Select...</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : ''}} @if($client->state_id == $state->id) selected @endif>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>L.G.A <span class="text-danger">*</span></label>
                            <i data-feather="map" class="fea icon-sm icons"></i>
                            <select class="form-control pl-5 @error('lga_id') is-invalid @enderror" name="lga_id" id="lga_id">
                            <option selected value="{{ $client->lga_id }}">{{ $client->lga->name }}</option>
                            </select>
                            @error('lga_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label>Town/City <span class="text-danger">*</span></label>
                            <i data-feather="navigation" class="fea icon-sm icons"></i>
                            <input type="text" class="form-control pl-5 @error('town') is-invalid @enderror" placeholder="e.g. Ajah, Ikoyi" name="town" id="town" value="{{ old('town') ?? $client->town }}">
                            @error('town')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group position-relative">
                            <label>Residential Address</label>
                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                            <textarea name="full_address" id="full_address" rows="4" class="form-control pl-5 @error('full_address') is-invalid @enderror" placeholder="Residential address :">{{ old('full_address') ?? $client->full_address }}</textarea>
                            @error('full_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div><!--end row-->
                <div class="row">
                    <div class="col-sm-12">
                        <input type="submit" id="submit" class="btn btn-primary btn-sm" value="Update Profile">
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->


            <div class="row">
                {{-- <div class="col-md-6 mt-4 pt-2">
                    <h5>Card Details :</h5>

                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name of card holder : </label>
                                    <input name="name" id="name" type="text" class="form-control font-weight-bold" required placeholder="Name">
                                </div>
                            </div><!--end col-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Card Number :</label>
                                    <input type="tel" min="0" autocomplete="off" id="cardnumber" maxlength="16" class="form-control font-weight-bold" required placeholder="0000 0000 0000 0000">
                                </div>
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expires End :</label>
                                    <input type="tel" min="0" autocomplete="off" id="exdate" class="form-control font-weight-bold" required placeholder="MM/YY" maxlength="2">
                                </div>
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CVV :</label>
                                    <input type="tel" min="0" autocomplete="off" id="cvv" class="form-control font-weight-bold" required placeholder="CVV" maxlength="3">
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary btn-sm" value="Add Card">
                            </div><!--end col-->
                        </div><!--end row-->
                    </form><!--end form-->
                </div><!--end col--> --}}

                <div class="col-md-12 mt-4 pt-2">
                    <h5>Change password :</h5>
                    <small class="text-danger">In order to change your password, you need to provide the current password.</small>

                    <form  method="POST" action="{{ route('client.update_profile_password') }}">
                        @csrf @method('PUT')
                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <div class="form-group position-relative">
                                    <label>Current Password :</label>
                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                    <input type="password" class="form-control pl-5 @error('current_password') is-invalid @enderror" placeholder="Current Password" id="current_password" name="current_password">
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-4">
                                <div class="form-group position-relative">
                                    <label>New password :</label>
                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                    <input type="password" class="form-control pl-5 @error('new_password') is-invalid @enderror" placeholder="New password" id="new_password" name="new_password">
                                    <small style="font-size: 10px;" class="text-muted">Password must be at least 8 characters</small>
                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-4">
                                <div class="form-group position-relative">
                                    <label>Re-type New password :</label>
                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                    <input type="password" class="form-control pl-5 @error('new_confirm_password') is-invalid @enderror" placeholder="Re-type New password" id="new_confirm_password" name="new_confirm_password">
                                    @error('new_confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-12 mt-2 mb-0">
                                <button type="submit" class="btn btn-primary btn-sm">Change password</button>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>
</div><!--end col-->

@push('scripts')
  <!-- geolocation asset starts here -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeoGwJDBE4ic-btiuWCfLk37ehqk2LxPs&v=3.exp&libraries=places"></script>
  <script src="{{asset('assets/js/geolocation.js')}}"></script>
  <!-- geolocation asset starts here -->
  
<script>
    $(document).ready(function (){
        $('#state_id').on('change',function () {
            let stateId = $('#state_id').find('option:selected').val();
            let stateName = $('#state_id').find('option:selected').text();

            // console.log(stateId, stateName); return;
            $.ajaxSetup({
                headers: {
                    'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('lga_list') }}",
                method: "POST",
                dataType: "JSON",
                data: {state_id:stateId},
                success: function(data){
                    if(data){

                        $('#lga_id').html(data.lgaList);
                    }else{
                        var message = 'Error occured while trying to get L.G.A`s in '+ categoryName +' category to '+ serviceName + ' service';
                        var type = 'error';
                        displayMessage(message, type);

                    }
                },
            })
        });

        $(document).on('click', '.change-picture', function (){
            // alert();
            $('#avatar').trigger('click');
            $('#submit-avatar').removeClass('d-none');
        });
    });
</script>
@endpush

@endsection
