@extends('layouts.dashboard')
@section('title', 'Editing '. Str::title($service->name))
@include('layouts.partials._messages')
@section('content')
<input class="d-none" id="locale" type="hidden" value="{{ app()->getLocale() }}">

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.services.index', app()->getLocale()) }}">Services List</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ !empty($service->name) ? $service->name : 'UNAVAILABLE' }}</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Editing "{{ !empty($service->name) ? $service->name : 'UNAVAILABLE' }}" </h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
          <a href="{{ route('admin.services.index', app()->getLocale()) }}" class="btn btn-primary float-right"><i class="fas fa-arrow-left"></i> Services List</a>
        </div>

        <div class="col-lg-12 col-xl-12">
            <form method="POST" action="{{ route('admin.services.update', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="col-md-12">
              <div class="divider-text">Edit Diagnosis Cost</div>

              <div class="form-row mt-4">
                <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') ?? !empty($service->name) ? $service->name : 'UNAVAILABLE' }}" autocomplete="off">
                    @error('name')
                      <x-alert :message="$message" />
                    @enderror
                </div>
                <div class="form-group col-md-6">
                  <label>Service</label>
                  <select class="custom-select @error('category_id') is-invalid @enderror" name="category_id">
                    <option selected value="">Select...</option>
                    @foreach($categories as $item)
                      @if($item->id != 1)
                          <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : ''}} @if($service->category_id == $item->id) selected @endif>{{ $item->name }}</option>
                      @endif
                    @endforeach
                  </select>
                  @error('category_id')
                    <x-alert :message="$message" />
                  @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="service_charge">Service Charge(₦)</label>
                    <input type="number" min="1" maxlength="5" class="form-control @error('service_charge') is-invalid @enderror" name="service_charge" id="service_charge" placeholder="Service Charge" value="{{ old('service_charge') ?? !empty($service->service_charge) ? $service->service_charge : '0' }}" autocomplete="off">
                    @error('service_charge')
                      <x-alert :message="$message" />
                    @enderror
                </div>

                <div class="form-group col-md-4">
                  <label for="diagnosis_subsequent_hour_charge">Subsequent Hour Charge(₦)</label>
                  <input type="number" min="1" maxlength="5" class="form-control @error('diagnosis_subsequent_hour_charge') is-invalid @enderror" name="diagnosis_subsequent_hour_charge" id="diagnosis_subsequent_hour_charge" placeholder="Subsequent Hour Charge" value="{{ old('diagnosis_subsequent_hour_charge') ?? !empty($service->diagnosis_subsequent_hour_charge) ? $service->diagnosis_subsequent_hour_charge : '0' }}" autocomplete="off">
                  @error('diagnosis_subsequent_hour_charge')
                    <x-alert :message="$message" />
                  @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Category Cover Image</label>
                    <div class="custom-file">
                      <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image">
                    <label class="custom-file-label" id="new-image-name" for="image">Upload Cover Image</label>
                      <input type="hidden" id="old-post-image" name="old_post_image" value="{{ $service->image }}">
                    </div>
                    <small class="text-muted">Current Image: {{ $service->image }}</small>
                    @error('image')
                        <x-alert :message="$message" />
                    @enderror
                  </div>
                
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Description</label>
                  <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') ?? !empty($service->description) ? $service->description : 'No description found.' }}</textarea>
                  @error('description')
                    <x-alert :message="$message" />
                  @enderror
                </div>
              </div>

              <div class="divider-text">Edit Labour Cost</div>
              <div class="form-group col-md-3">
                <button type="button" class="btn btn-primary add-sub-service" style="margin-top: 1.8rem !important;"><i class="fas fa-plus"></i> Add</button>
              </div>

              @include('admin.service._sub_service')

            </div>

            <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-primary">Update Service</button>
            </div>

          </form>
    
        </div><!-- col -->

      </div>

    </div>
</div>


@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/1e65edf0-c8e5-432c-8bbf-a7ed7847990f.js') }}"></script>

  <script>

  function addSubService(){

      let html = '<div class="form-row remove-sub-service-row"><div class="form-group col-md-3"> <label for="sub_service_name">Sub Service Name</label> <input type="text" class="form-control @error("sub_service_name") is-invalid @enderror" name="sub_service_name[]" id="sub_service_name" placeholder="Name" value="{{ old(" sub_service_name ") }}" autocomplete="off">@error("sub_service_name") <x-alert :message="$message" />@enderror</div><div class="form-group col-md-3"> <label for="labour_cost">Labour Cost(₦)</label> <input type="number" min="1" maxlength="5" class="form-control @error(" labour_cost ") is-invalid @enderror" name="labour_cost[]" id="labour_cost" placeholder="Labour Cost" value="{{ old("labour_cost[1]") }}" autocomplete="off">@error("labour_cost") <x-alert :message="$message" />@enderror</div><div class="form-group col-md-3"> <label for="cost_type">Cost Type</label> <select class="custom-select @error("cost_type") is-invalid @enderror" name="cost_type[]"><option selected value="">Select...</option><option value="Fixed" {{ old("cost_type[1]") == "Fixed" ? "selected" : ""}}>Fixed</option><option value="Variable" {{ old("cost_type") == "Variable" ? "selected" : ""}}>Variable</option> </select> @error("cost_type[1]") <x-alert :message="$message" />@enderror</div><div class="form-group col-md-3"> <button class="btn btn-danger remove-sub-service" type="button" style="margin-top: 1.8rem !important;"><i class="fas fa-minus"></i> Remove</button></div></div>';

      $('.add-new-sub-service').append(html);
  }
</script>
@endpush

@endsection