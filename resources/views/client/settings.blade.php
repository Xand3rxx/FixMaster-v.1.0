@extends('layouts.client')
@section('title', 'Profile Setting')
@section('content')
@include('layouts.partials._messages')

      <div class="col-lg-8 col-12">
          <div class="card border-0 rounded shadow">
              <div class="card-body mt-">
                  <h5 class="text-md-left text-center">Personal Detail :</h5>
  
                  <div class="mt-3 text-md-left text-center d-sm-flex">
                
                  @if(!empty($client->user->account->avatar)) 
                    <img src="{{ asset('assets/user-avatars/'.$client->user->account->avatar) }}" id="avatar" class="d-none profile_image_preview avatar float-md-left avatar-medium rounded-circle shadow mr-md-4" alt="{{ $client->user->account->first_name }}" />
                  @endif

                  <img src="{{ asset('assets/user-avatars/'.$client->user->account->avatar) }}" id="avatar" class="d-none profile_image_preview avatar float-md-left avatar-medium rounded-circle shadow mr-md-4" alt="{{ $client->user->account->first_name }}" />
                  </div>

                  <form method="POST" action="{{ route('client.updateProfile', app()->getLocale()) }}" enctype="multipart/form-data">
                   {{ csrf_field() }}
                      <div class="row mt-4">
                      <!-- first name -->
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>First Name</label>
                                  <i data-feather="user" class="fea icon-sm icons"></i>
                                  <input name="first_name" id="first_name" type="text" class="form-control pl-5" value="{{$client->user->account->first_name}}" placeholder="First Name :" />
                              </div>
                          </div>
                          <!--end col-->
                        <!-- middle name -->
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Middle Name</label>
                                  <i data-feather="user" class="fea icon-sm icons"></i>
                                  <input name="middle_name" id="middle_name" type="text" class="form-control pl-5" value="{{$client->user->account->middle_name}}" placeholder="Middle Name :" />
                              </div>
                          </div>
                          <!--end col-->
                          <!-- Last Name -->
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Last Name</label>
                                  <i data-feather="user" class="fea icon-sm icons"></i>
                                  <input name="last_name" id="last_name" type="text" class="form-control pl-5" value="{{$client->user->account->last_name}}" placeholder="Last Name :" />
                              </div>
                          </div>
                          <!--end col-->
                          <!-- Email -->
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Your Email</label>
                                  <i data-feather="mail" class="fea icon-sm icons"></i>
                                  <input name="email" id="email" type="email" class="form-control pl-5" value="{{$client->user->email}}" readonly placeholder="Your E-Mail :" />
                              </div>
                          </div>
                          <!--end col-->
                          <!-- Phone No -->
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Phone No. :</label>
                                  <i data-feather="phone" class="fea icon-sm icons"></i>
                                  <input name="phone_number" id="phone_number" type="tel" maxlength="11" class="form-control pl-5" value="{{ $client->user->contact->phone_number }}" placeholder="Phone :" />
                              </div>
                          </div>
                          <!--end col-->
                          <!-- Profile Avatar -->
                          <div class="form-group col-md-4">
                              <label>Profile Avatar</label>
                              <div class="custom-file change-picture">

                                <input type="hidden" id="old_avatar" name="old_avatar" value="{{ $client->avatar }}">
                                <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="profile_avater" id="profile_image" value="{{$client->user->account->avatar}}">
                                <label class="custom-file-label" id="imagelabel" for="profile_image">Upload Profile Avatar</label>
                               
                              </div>
                            </div>
                        <!--end col-->
                        <!-- gender -->
                        <div class="col-md-3">
                            <label>Gender</label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                            <option value="">Choose....</option>
                            <option value="Male" {{ $client->user->account->gender == 'male' ? 'selected' : ''}}>Male</option>
                            <option value="Female" {{ $client->user->account->gender == 'female' ? 'selected' : ''}}>Female</option>                                                         
                            </select> 
                        </div>
                          <!-- State -->
                          <div class="col-md-3">
                              <div class="form-group position-relative">
                                  <label>State <span class="text-danger">*</span></label>
                                  <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                  <select class="form-control pl-5  @error('state_id') is-invalid @enderror" name="state_id" id="state_id">
                                    <option selected value="">Select...</option>
                                    @foreach($states as $state)
                                      <option value="{{$state->id}}" {{old('state_id') == $state->id ? 'selected' : ''}} @if($client->user->account->state_id == $state->id) selected @endif>{{ $state->name }}</option>
                                    @endforeach
                                  </select>
                                  @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                              </div>
                          </div>
                          <!--End row-->
                          <!-- LGA -->
                          <div class="col-md-3">
                             <div class="form-group position-relative">
                                <label>L.G.A <span class="text-danger">*</span></label>
                                <i data-feather="map" class="fea icon-sm icons"></i>
                                <select class="form-control pl-5 @error('lga_id') is-invalid @enderror" name="lga_id" id="lga_id">
                                    <!-- <option selected value="">Select...</option> -->
                                    @foreach($lgas as $lga)
                                    <option value="{{ $client->user->account->lga_id }}" {{old('lga_id') == $lga->id ? 'selected' : ''}} @if($client->user->account->lga_id == $lga->id) selected @endif>{{ $lga->name }}</option>
                                    @endforeach
                               </select>
                                @error('lga_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                          <!--End row-->
                          <!-- Town -->
                          <div class="col-md-3">
                          <div class="form-group position-relative">
                                <label>Town/City <span class="text-danger">*</span></label>
                                
                                <select class="form-control pl-5 @error('town_id') is-invalid @enderror" name="town_id" id="town_id">
                                    @foreach($towns as $town)
                                        <option value="{{ $client->user->account->town_id }}" {{old('town_id') == $town->id ? 'selected' : ''}} @if($client->user->account->town_id == $town->id) selected @endif>{{ $town->name }}</option>
                                    @endforeach
                                </select>
                                @error('town_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                             </div>
                        </div>
                          <!--End row-->
                          <!-- Residential Address -->
                          <div class="col-lg-12">
                              <div class="form-group position-relative">
                                  <label>Residential Address</label>
                                  <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                  
                                  <input type="text" class="form-control pl-5 user_address @error('full_address') is-invalid @enderror" name="full_address" id="full_address" value="{{ old('full_address') ?? $client->user->address->address}}" required>

                              </div>
                          </div>
                      </div>

                      <!-- hidden fields -->
                      <input type="hidden" value="{{ old('user_latitude') ?? $client->user->contact->address_latitude}}" id="user_latitude" name="user_latitude"/>
                      <input type="hidden" value="{{ old('user_longitude') ?? $client->user->contact->address_longitude}}" id="user_longitude" name="user_longitude"/>
                      <!--end col-->
                     
                      <!--end row-->
                      <div class="row">
                          <div class="col-sm-12">
                              <input type="submit" id="submit" class="btn btn-primary btn-sm user_address" value="Update Profile" />
                          </div>
                          <!--end col-->
                      </div>
                      <!--end row-->
                  </form>
                  <!--end form-->

                  <div class="row">
                      <div class="col-md-12 mt-4 pt-2">
                          <h5>Change password :</h5>
                          <small class="text-danger">In order to change your password, you need to provide the current password.</small>

                          <form method="post" action="{{route('client.updatePassword', app()->getLocale()) }}" >
                              {{ csrf_field() }}
                              <div class="row mt-4">
                                  <div class="col-lg-4">
                                      <div class="form-group position-relative">
                                          <label>Current Password :</label>
                                          <i data-feather="key" class="fea icon-sm icons"></i>
                                          <input type="password" class="form-control pl-5" placeholder="Current Password" id="current_password" name="current_password" />
                                      </div>
                                  </div>
                                  <!--end col-->

                                  <div class="col-lg-4">
                                      <div class="form-group position-relative">
                                          <label>New password :</label>
                                          <i data-feather="key" class="fea icon-sm icons"></i>
                                          <input type="password" class="form-control pl-5" placeholder="New password" id="new_password" name="new_password" />
                                          <small style="font-size: 10px;" class="text-muted">Password must be at least 8 characters</small>
                                      </div>
                                  </div>
                                  <!--end col-->

                                  <div class="col-lg-4">
                                      <div class="form-group position-relative">
                                          <label>Re-type New password :</label>
                                          <i data-feather="key" class="fea icon-sm icons"></i>
                                          <input type="password" class="form-control pl-5" placeholder="Re-type New password" id="new_confirm_password" name="new_confirm_password" />
                                      </div>
                                  </div>
                                  <!--end col-->

                                  <div class="col-lg-12 mt-2 mb-0">
                                      <button type="submit" class="btn btn-primary btn-sm">Change password</button>
                                  </div>
                                  <!--end col-->
                              </div>
                              <!--end row-->
                          </form>
                      </div>
                      <!--end col-->
                  </div>
                  <!--end row-->
              </div>
          </div>
      </div>
      <!--end col-->

      @push('scripts')
 
  <script>
//function to pick profile pix starts
(function($){
    "use scrict";
    $(document).ready(function(){
    
      $(document).on('change','#profile_image', function(){
        readURL(this);
      })

      reader.readAsDataURL(input.files[0]);

      function readURL(input){
        if(input.files && input.files[0]){
          var reader = new FileReader();
          var res = isImage(input.files[0].name);

          if(res==false){
            var msg = 'Image should be png/PNG, jpg/JPG & jpeg/JPG';
            Snackbar.show({text: msg, pos: 'bottom-right',backgroundColor:'#d32f2f', actionTextColor:'#fff' });
            return false;
          }

          reader.onload = function(e){
            $('.profile_image_preview').attr('src', e.target.result);
            $("imagelabel").text((input.files[0].name));
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

      function getExtension(filename) {
          var parts = filename.split('.');
          return parts[parts.length - 1];
      }  

      function isImage(filename) {
          var ext = getExtension(filename);
          switch (ext.toLowerCase()) {
          case 'jpg':
          case 'jpeg':
          case 'png':
          case 'gif':
              return true;
          }
          return false;
      }

    })

 })(jQuery);
//function to pick profile pix ends
</script>

<script>
$(document).ready(function() {
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

        // AJAX to get the towns of a particular LGA
        $("#lga_id").on("change", function () {
            // let stateId = $("#state_id").find("option:selected").val();
            // let stateName = $("#state_id").find("option:selected").text();

            let lgaId = $("#lga_id").find("option:selected").val();
            let lgaName = $("#lga_id").find("option:selected").text();

            $.ajax({
                url: "{{ route('ward_list', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    lga_id: lgaId,
                },
                success: function (data) {
                    if (data) {
                        $("#town_id").html(data.townList);
                    } else {
                        var message = "Error occured while trying to get wards in " + lgaName + " local government";
                        var type = "error";
                        displayMessage(message, type);
                    }
                },
            });
        });


    });

    $(document).on('click', '.change-picture', function (){
            $('#avatar').removeClass('d-none');
        });
</script>

@endpush

@endsection