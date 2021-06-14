@extends('layouts.dashboard')
@section('title', 'Services List')
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
              <li class="breadcrumb-item active" aria-current="page">Services List</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Services List</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
        <a href="{{ route('admin.services.create', app()->getLocale()) }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add New</a>
        </div>

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Services as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster core Services.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                <div id="sort_table">
                  @include('admin.service._table')
                </div>
              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

<div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
        <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <form method="POST" action="{{ route('admin.services.store', app()->getLocale()) }}" enctype="multipart/form-data">
          @csrf
        <h5 class="mg-b-2"><strong>Create New Service</strong></h5>
        <div class="row row-xs">
          <div class="col-md-12">
            <div class="form-row mt-4">
                <div class="form-group col-md-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') }}" autocomplete="off">
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                  <label>Service</label>
                  <select class="custom-select @error('category_id') is-invalid @enderror" name="category_id">
                    <option selected value="">Select...</option>
                    @foreach($categories as $category)
                      @if($category->id != 1)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                      @endif
                    @endforeach
                  </select>
                  @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="service_charge">Service Charge</label>
                    <input type="number" min="1" maxlength="5" class="form-control @error('service_charge') is-invalid @enderror" name="service_charge" id="service_charge" placeholder="Service Charge" value="{{ old('service_charge') }}" autocomplete="off">
                    @error('service_charge')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                  <label>Category Cover Image</label>
                  <div class="custom-file">
                    <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image">
                    <label class="custom-file-label" id="image-name" for="image">Upload Category Image</label>
                    
                  </div>
                  {{-- <small class="text-danger"> Preferred category cover image size is 350x259.</small> --}}
                  @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputEmail4">Description</label>
                <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') }}</textarea>
                @error('description')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </div>
      </form>
      </div><!-- modal-body -->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->




<div class="modal fade" id="serviceCategoryDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Service Details</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20" id="modal-body">
          <!-- Modal displays here -->
          <div id="spinner-icon" style="display: block !important"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editService" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2"><span class="edit-title"></span> Service</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20" id="modal-edit-body">
        <!-- Modal displays here -->
        <div id="spinner-icon-3"></div>
      </div><!-- modal-body -->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/1e65edf0-c8e5-432c-8bbf-a7ed7847990f.js') }}"></script>
@endpush

@endsection