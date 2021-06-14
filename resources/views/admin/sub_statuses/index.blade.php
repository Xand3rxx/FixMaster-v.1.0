@extends('layouts.dashboard')
@section('title', 'Sub-Statuses List')
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
              <li class="breadcrumb-item active" aria-current="page">Sub-Statuses List</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Sub-Statuses List</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
          <a href="#addService" class="btn btn-primary float-right" data-toggle="modal"><i class="fas fa-plus"></i> Add New</a>
        </div>

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Categories as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Sub Statuses for the complete life cycle interaction of a CSE on a Service Request.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                <div id="sort_table">
                  @include('admin.sub_statuses._table')
                </div>
              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

<div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
        <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <form method="POST" action="{{ route('admin.statuses.store', app()->getLocale()) }}">
          @csrf
          <h5 class="mg-b-2"><strong>Create New Sub-Status</strong></h5>
          <div class="form-row mt-4">
            <div class="form-group col-md-12">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name') }}" autocomplete="off" required>
                @error('name')
                  <x-alert :message="$message" />
                @enderror
            </div>
            <div class="form-group col-md-12">
              <label>Recurrence</label>
              <select class="custom-select @error('recurrence') is-invalid @enderror" name="recurrence">
                <option selected value="">Select...</option>
                <option value="Yes" {{ old('recurrence') == 'Yes' ? 'selected' : ''}}>Yes</option>
                <option value="No" {{ old('recurrence') == 'No' ? 'selected' : ''}}>No</option>
                
              </select>
              <small class="text-muted">Will the status reoccur?</small>
              @error('recurrence')
                <x-alert :message="$message" />
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create Sub-Status</button>
          </div>
        </form>
      </div><!-- modal-body -->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="editService" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
          <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <div class="modal-body" id="modal-edit-body">
            <!-- Modal displays here -->
            <div id="spinner-icon-3"></div>
          </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/253d5420-ccbe-4671-89f8-956cd70c42bc.js') }}"></script>
@endpush

@endsection