@extends('layouts.dashboard')
@section('title', 'Tools Inventory')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tools Inventory</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Tools Inventory</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
          <a href="#addInventory" class="btn btn-primary float-right" data-toggle="modal"><i class="fas fa-plus"></i> Add New</a>
        </div>

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Tools Records as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster In-House Tools.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                
                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Name</th>
                      <th class="text-center">Quantity</th>
                      <th class="text-center">Available</th>
                      <th class="text-center">Requests</th>
                      <th class="text-center">Created By</th>
                      <th class="text-center">Date Created</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($toolsInventories as $toolsInventory)
                    <tr>
                      <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                      <td class="tx-medium">{{ $toolsInventory->name }}</td>
                      <td class="tx-medium text-center">{{ $toolsInventory->quantity }}</td>
                      <td class="tx-medium text-center text-@if($toolsInventory->available > 0)success @elseif($toolsInventory->available < 1)danger @endif">{{ $toolsInventory->available }}</td>
                      <td class="tx-medium text-center">0</td>
                      <td class="text-center">{{ $toolsInventory->user->email }}</td>
                      <td class="text-center">{{ Carbon\Carbon::parse($toolsInventory->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                      <td class=" text-center">
                        <div class="dropdown-file">
                          <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                          <div class="dropdown-menu dropdown-menu-right">
                              
                          <a href="#editInventory" id="edit-inventory" data-toggle="modal" class="dropdown-item details text-info" data-url="{{ route('admin.tools.edit', ['tool'=>$toolsInventory->uuid, 'locale'=>app()->getLocale()]) }}" data-tool-name="{{ $toolsInventory->name }}" data-id="{{ $toolsInventory->uuid }}"><i class="far fa-edit"></i> Edit</a>

                          <a data-url="{{ route('admin.tools.delete', ['tool'=>$toolsInventory->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger delete-entity" title="Delete {{ $toolsInventory->name}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Delete</a>

                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach

                  </tbody>
                </table>
              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>


<div class="modal fade" id="addInventory" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered wd-sm-650" role="document">
      <div class="modal-content">
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
          <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <form method="POST" action="{{ route('admin.tools.store', app()->getLocale()) }}">
            @csrf
            <h5 class="mg-b-2"><strong>Add New Tool</strong></h5>
            <div class="form-row mt-4">
              <div class="form-group col-md-9">
                  <label for="Name">Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name') }}" autocomplete="off" required>
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="form-group col-md-3">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" placeholder="Quantity" required>
                  @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->



<div class="modal fade" id="editInventory" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered wd-sm-650" role="document">
      <div class="modal-content">
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
          <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <div class="modal-body" id="modal-edit-body">
              <!-- Modal displays here -->
              <div id="spinner-icon"></div>
          </div>
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/755ea58a-2baf-4518-bef6-36d9c2ca76ca.js') }}"></script>
@endpush

@endsection