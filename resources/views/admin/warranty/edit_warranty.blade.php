@extends('layouts.dashboard')
@section('title', 'Edit Warranty')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.warranty_list', app()->getLocale()) }}">Warranty</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Warranty</li>
                        </ol>
                    </nav>
                   
                </div>
            </div>
    <form method="POST" action="{{ route('admin.update_warranty', ['details'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}">
        @csrf @method('PUT')
    <h5 class="mg-b-2"><strong>Editing "{{ $warranty->name }}" Warranty</strong></h5>
    <hr>
   
        <div class="form-row mt-4">

          <div class="form-group col-md-6">
              <label for="name">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') ?? $warranty->name }}"  autocomplete="off" required>
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>
          
          <div class="form-group col-md-6">
            <label>Type</label>
            <select class="custom-select @error('warranty_type') is-invalid @enderror" name="warranty_type" required>
              <option selected value="">Select...</option>
              <option value="Free" @if($warranty->warranty_type == 'Free') selected @endif>Free (0%)</option>
              <option value="Extended" @if($warranty->warranty_type == 'Extended') selected @endif>Extended</option>
            </select>
            @error('warranty_type')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
              <label for="percentage">Percentage(%)</label>
              <input type="text" class="form-control @error('percentage') is-invalid @enderror" name="percentage" min="1" max="100" maxlength="3" id="percentage" placeholder="Percentage" value="{{ old('percentage') ?? $warranty->percentage }}" autocomplete="off" required>
              @error('percentage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>

          <div class="form-group col-md-6">
            <label for="percentage">Maximum Duration (Days)</label>
            <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" min="1" max="366" maxlength="5" id="duration" placeholder="Maximum Duration in Days" value="{{ old('duration') ?? $warranty->duration }}" autocomplete="off" required>
            @error('percentage')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
      
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="inputEmail4">Description</label>
            <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ old('description') ?? $warranty->description }}</textarea>
            @error('description')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>

  @endsection