@extends('layouts.dashboard')
@section('title', 'Warranty List')
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
              <li class="breadcrumb-item active" aria-current="page">Warranty List</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Warranty List</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
          <a href="#addWarranty" class="btn btn-primary float-right" data-toggle="modal"><i class="fas fa-plus"></i> Create Warranty</a>
        </div>

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Warranty as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Warranty.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                <div id="sort_table">
                  @include('admin.warranty._table')
                </div>
              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

<div class="modal fade" id="addWarranty" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
        <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <form method="POST" action="{{ route('admin.save_warranty', app()->getLocale()) }}">
        @csrf @method('POST')
          <h5 class="mg-b-2"><strong>Create New Warranty</strong></h5>
          <div class="form-row mt-4">
            <div class="form-group col-md-12">
              <div class="form-row mt-4">
                <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Warranty Name. E.g Platinum" value="{{ old('name') }}" autocomplete="off" required>
                  
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
                    <option value="Free">Free (0%)</option>
                    <option value="Extended">Extended</option>
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
                    <input type="number" class="form-control @error('percentage') is-invalid @enderror" name="percentage" id="percentage" placeholder="Warranty Percentage (%)" value="{{ old('percentage') }}" min="0" max="100" maxlength="3" autocomplete="off" required>
                    @error('percentage')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
            
                <div class="form-group col-md-6">
                    <label for="duration">Maximum Duration (Days)</label>
                    <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" min="1" max="366" maxlength="3" id="duration" placeholder="Maximum Duration in Days" value="{{ old('duration') }}" autocomplete="off">
                    @error('duration')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>
              <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputEmail4">Description</label>
                <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ old('description') }}</textarea>
                @error('description')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Warranty</button>
          </div>
        </form>
      </div><!-- modal-body -->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->






@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/4823bfe5-4a86-49ee-8905-bb9a0d89e2e0.js') }}"></script>
@endpush

@endsection