@extends('layouts.dashboard')
@section('title', 'Edit Profile')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('franchisee.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Account Settings</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-lg-12 col-xl-12">
          <div class="card">
            <ul class="nav nav-tabs nav-justified" id="myTab3" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="description-tab3" data-toggle="tab" href="#description3" role="tab" aria-controls="description" aria-selected="true">Update Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="rfq-tab3" data-toggle="tab" href="#rfq3" role="tab" aria-controls="rfq" aria-selected="false">Change Password</a>
                </li>
              </ul>
              <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent3">
                <div class="tab-pane fade show active" id="description3" role="tabpanel" aria-labelledby="description-tab3">
                  <h6>UPDATE PROFILE</h6>
                  <div class="card-body pd-20 pd-lg-25">
                  <form action="{{ route('supplier.profile-updates.update', ['profile_update'=>$profile->uuid, 'locale'=>app()->getLocale()]) }}" method="POST" role="form" enctype="multipart/form-data">
                      {{ csrf_field() }} @method('PATCH')
                      <div class="d-sm-flex float-left">
                            <div class="mg-sm-r-30">
                                <div class="pos-relative d-inline-block mg-b-20">
                                  <a href="#">
                                    <div class="avatar avatar-xxl">
                                      <div class="user-img">
                                        @php 
                                          if($profile['account']['gender'] == 'male' || $profile['account']['gender'] == 'others'){
                                              $genderAvatar = 'default-male-avatar.png';
                                          }else{
                                              $genderAvatar = 'default-female-avatar.png';
                                          }
                                        @endphp

                                        @if(empty($profile['account']['avatar']))
                                            <img src="{{ asset('assets/images/'.$genderAvatar) }}" class="rounded-circle wh-150p img-fluid image profile_image_preview" alt="Default avatar">
                                        @elseif(!file_exists(public_path('assets/user-avatars/'.$profile['account']['avatar'])))
                                            <img src="{{ asset('assets/images/'.$genderAvatar) }}" class="rounded-circle wh-150p img-fluid image profile_image_preview" alt="Profile avatar">
                                        @else
                                            <img src="{{ asset('assets/user-avatars/'.$profile['account']['avatar']) }}" class="rounded-circle wh-150p img-fluid image profile_image_preview" alt="Profile avatar">
                                        @endif

                                      </div>
                                    </div>
                                  </a>
                                </div>
                            </div><!-- col -->
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-3">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" value="{{ old('first_name') ?? !empty($profile['account']['first_name']) ? $profile['account']['first_name'] : '' }}">
                            @error('first_name')
                              <x-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                          <label for="middle_name">Middle Name</label>
                          <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name') ?? !empty($profile['account']['middle_name']) ? $profile['account']['middle_name'] : '' }}">
                          @error('middle_name')
                            <x-alert :message="$message" />
                          @enderror
                      </div>
                            <!-- Last Name -->
                            <div class="form-group col-md-3">
                              <label for="last_name">Last Name</label>
                              <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') ?? !empty($profile['account']['last_name']) ? $profile['account']['last_name'] : '' }}">
                              @error('last_name')
                                <x-alert :message="$message" />
                              @enderror
                          </div>
                          {{-- gender --}}
                          <div class="form-group col-md-3">
                            <label>Gender</label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                              <option value="</option>
                              <option value="">Choose....</option>
                              <option value="male" {{ old('gender') == $profile['account']['gender'] ? 'selected' : ''}}  @if($profile['account']['gender'] == 'male') selected @endif>Male</option>
                              <option value="female" {{ old('gender') == $profile['account']['gender'] ? 'selected' : ''}}  @if($profile['account']['gender'] == 'female') selected @endif>Female</option>
                              <option value="others" {{ old('gender') == $profile['account']['gender'] ? 'selected' : ''}}  @if($profile['account']['gender'] == 'others') selected @endif>Others</option>
                           </select>
                           @error('gender')
                              <x-alert :message="$message" />
                           @enderror
                          </div>
                            <!-- Email -->
                            <div class="form-group col-md-4">
                              <label for="email">Email</label>
                              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="{{ !empty($profile->email) ? $profile->email : '' }}" disabled>
                              @error('email')
                                <x-alert :message="$message" />
                              @enderror
                          </div>
                          <!-- Phone Number -->
                          <div class="form-group col-md-4">
                            <label for="phone_number">Phone Number</label>
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" maxlength="11" value="{{ old('phone_number') ?? !empty($profile['contact']['phone_number']) ? $profile['contact']['phone_number'] : '' }}" autocomplete="off">
                            @error('phone_number')
                              <x-alert :message="$message" />
                            @enderror
                          </div>

                          <!-- Profile Avatar -->
                          <div class="form-group col-md-4">
                            <label>Profile Avatar</label>
                            <div class="custom-file">
                              <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="profile_image">
                              <label class="custom-file-label" id="imagelabel" for="profile_image">Upload Profile Avatar</label>
                              @error('image')
                                <x-alert :message="$message" />
                              @enderror
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label>Bank</label>
                            <select name="bank_id" id="bank_id" class="form-control @error('bank_id') is-invalid @enderror" required>
                              <option value="">Select...</option>
                              @foreach($banks as $bank)
                              <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : ''}}  @if($profile['account']['bank_id'] == $bank->id) selected @endif>{{$bank->name ?? ''}}</option>
                              @endforeach
                          </select>
                          @error('bank_id')
                            <x-alert :message="$message" />
                          @enderror
                          </div>

                          <div class="form-group col-md-6">
                            <label for="account_number">Account Number</label>
                            <input type="tel" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" maxlength="10" value="{{ old('account_number') ?? !empty($profile['account']['account_number']) ? $profile['account']['account_number'] : '' }}" required autocomplete="off">
                            @error('account_number')
                              <x-alert :message="$message" />
                            @enderror
                          </div>

                            <!-- Full Address -->
                            <div class="form-group col-md-12">
                              <label for="address">Full Address</label>
                              <textarea rows="3" class="user_address form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address') ?? !empty($profile['contact']['address']) ? $profile['contact']['address'] : '' }}</textarea>
                              @error('address')
                                <x-alert :message="$message" />
                              @enderror
                            </div>

                            <input type="hidden" value="{{ old('address_latitude') ?? !empty($profile['contact']['address_latitude']) ? $profile['contact']['address_latitude'] : '' }}" name="address_latitude" id="user_latitude">
                            <input type="hidden" value="{{ old('address_longitude') ?? !empty($profile['contact']['address_longitude']) ? $profile['contact']['address_longitude'] : '' }}" name="address_longitude" id="user_longitude">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                  </div>
                </div>

                <div class="tab-pane fade" id="rfq3" role="tabpanel" aria-labelledby="rfq-tab3">
                  <h6>CHANGE PASSWORD</h6>
                  <p class="mg-b-0 text-danger">In order to change your password, you need to provide the current password.</p>
                  <div class="card-body pd-20 pd-lg-25">
                    <form action="{{ route('supplier.update_profile_password', app()->getLocale()) }}" method="POST">
                      @csrf @method('PUT')
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="current_password">Current Password</label>
                          <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" autocomplete="off">
                          @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                          </div>
                        <div class="form-group col-md-4">
                          <label for="new_password">New Password</label>
                          <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" autocomplete="off">
                          <small class="text-muted">Password must be minimum of 6 characters</small>
                          @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="form-group col-md-4">
                          <label for="new_confirm_password">Confirm Password</label>
                          <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="new_confirm_password" name="new_confirm_password" autocomplete="off">
                          @error('new_confirm_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                    </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                  </div>
                </div>

          </div>
        </div>
      </div>
    </div>
</div>
{{-- {{ dd(config('app.geolocation_api_key')) }} --}}
@push('scripts')
<script src="{{ asset('assets/js/geolocation.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/184a93a1-ca37-44a3-839f-c75344933ed1.js') }}"></script>
@endpush

@endsection
