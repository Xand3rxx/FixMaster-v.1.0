@extends('layouts.dashboard')
@section('title', $estate->estate_name.'\'s Summary')
@include('layouts.partials._messages')
@section('content')
  <div class="content-body">
      <div class="container pd-x-0">
          <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
              <div>
                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                          <li class="breadcrumb-item"><a href="{{ route('admin.list_estate', app()->getLocale()) }}">Estates</a></li>
                          <li class="breadcrumb-item active" aria-current="page">{{ $estate->estate_name }}</li>
                      </ol>
                  </nav>
                  {{-- <h4 class="mg-b-0 tx-spacing--1">Administrators List</h4> --}}
              </div>

              <div class="d-md-block">
                  <a href="{{ route('admin.list_estate', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                  @if($estate->is_active == 'deactivated' || $estate->is_active == 'reinstated')
                  <a href="{{ route('admin.edit_estate', [ 'estate'=>$estate->uuid, 'locale'=>app()->getLocale() ]) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                  @endif
                  @if($estate->is_active == 'deactivated')
                      <a href="{{ route('admin.reinstate_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-success"><i class="fas fa-undo"></i>Reinstate</a>
                  @elseif($estate->is_active == 'reinstated')
                  <a href="{{ route('admin.deactivate_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-warning"><i class="fas fa-ban"></i> Deactivate</a>
                  @endif
                  @if($estate['approved_by'] == null || $estate['is_active'] == 'declined' || $estate['is_active'] == 'pending')
                      <a href="{{ route('admin.approve_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-success"><i class="fas fa-check"></i> Approve</a>
                      <a href="{{ route('admin.decline_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-warning"><i class="fas fa-ban"></i> Decline</a>
                  @endif
                  <a href="{{ route('admin.delete_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
              </div>
          </div>

          <div class="row row-xs">
              <div class="col-sm-12 col-lg-12">
                  <div class="card mg-b-20 mg-lg-b-25">
                      <div class="card-header">
                          {{-- <div class="row float-center text-center justify-content-center align-items-center mt-100">
                              <h6 class="tx-uppercase tx-semibold mg-b-0 col-md-4 col-12 btn btn-outline-primary btn-sm estate-summary">{{ $estate->estate_name }} Summary</h6>
                              <h6 class="tx-uppercase tx-semibold mg-b-0 col-md-4 col-12 btn btn-outline-primary btn-sm estate-discount">{{ $estate->estate_name }} Discount History</h6>
                              <h6 class="tx-uppercase tx-semibold mg-b-0 col-md-4 col-12 btn btn-outline-primary btn-sm estate-client">{{ $estate->estate_name }} Registered Clients</h6>
                          </div> --}}

                          <div class="contact-content-header mt-4">
                            <nav class="nav">
                              <a href="#summary" class="nav-link active" data-toggle="tab">Summary</a>
                              @if($estate['is_active'] == 'reinstated' || $estate['is_active'] == 'deactivated')
                              <a href="#discount" class="nav-link" data-toggle="tab"><span>Discount History</span></a>
                              <a href="#client" class="nav-link" data-toggle="tab"><span>Registered Clients</span></a>
                              @endif
                              {{-- <a href="#activityLog" class="nav-link" data-toggle="tab"><span>Activity Log</a> --}}
                            </nav>
                            <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a>
                          </div>
                          <nav class="nav nav-with-icon tx-13">
                              <!-- <a href="" class="nav-link"><i data-feather="plus"></i> Add New</a> -->
                          </nav>
                      </div><!-- card-header -->
                      <div class="contact-content-body">
                        <div class="tab-content">
                      {{-- <div class="card-body pd-25"> --}}
                          <div class="tab-pane show active pd-20 pd-xl-25" id="summary">
{{--                                <div class="pos-relative d-inline-block mg-b-20">--}}
{{--                                    <div class="avatar avatar-xxl"><span class="avatar-initial rounded-circle bg-gray-700 tx-normal"><i class="icon ion-md-person"></i></span></div>--}}
{{--                                    --}}{{-- <a href="" class="contact-edit-photo"><i data-feather="edit-2"></i></a> --}}
{{--                                </div>--}}
                              <div class="media-body pd-l-25">
                                  {{-- <h5 class="mg-b-5 mb-2">Business Type: Marine Cargo</h5> --}}
                                  <div class="table-responsive">
                                      <table class="table table-striped table-sm mg-b-0">
                                          <tbody>
                                          <tr>
                                              <td class="tx-medium">Estate Name</td>
                                              <td class="tx-color-03">{{ $estate->estate_name }}</td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Author</td>
                                              <td class="tx-color-03"> {{ $estate->first_name .' '. $estate->last_name }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Phone Number</td>
                                              <td class="tx-color-03"> {{ $estate->phone_number }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Email</td>
                                              <td class="tx-color-03"> {{ $estate->email }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Status</td>
                                              <td class="tx-color-03"> {{ $estate['is_active'] == 'reinstated' ? 'Active' : 'Inactive' }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Date of Birth</td>
                                              <td class="tx-color-03"> {{ Carbon\Carbon::parse($estate->date_of_birth, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Identification Type</td>
                                              <td class="tx-color-03"> {{ $estate->identification_type }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Identification Number</td>
                                              <td class="tx-color-03"> {{ $estate->identification_number }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Expiry Date</td>
                                              <td class="tx-color-03"> {{ $estate->expiry_date }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Full Address</td>
                                              <td class="tx-color-03"> {{ $estate->full_address }} </td>
                                          </tr>
                                            <tr>
                                            <td class="tx-medium">State</td>
                                            <td class="tx-color-03"> {{ $estate->state->name }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">L.G.A</td>
                                              <td class="tx-color-03"> {{ $estate->lga->name }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Town</td>
                                              <td class="tx-color-03"> {{ $estate->town }} </td>
                                          </tr>
                                          <tr>
                                            <td class="tx-medium">Landmark</td>
                                            <td class="tx-color-03"> {{ $estate->landmark }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Date Created</td>
                                              <td class="tx-color-03"> {{ Carbon\Carbon::parse($estate->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} ({{ $estate->created_at->diffForHumans() }}) </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Last Edited</td>
                                              <td class="tx-color-03"> @if(!empty($estate->updated_at)) {{ Carbon\Carbon::parse($estate->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} @else Never @endif </td>
                                          </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <div class="tab-pane pd-20 pd-xl-25" id="discount">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5">{{$estate->estate_name}} discounts as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all discounts in {{$estate->estate_name}}.</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Discount ID</th>
                                                <th>Name</th>
                                                <th>Duration</th>
                                                <th>Applied To</th>
                                                <th>Rate (%)</th>
                                                <th>Date Created</th>
                                                <th>Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($estateDiscounts as $estateDiscount)
                                            <tr>
                                              <td class="tx-color-03 tx-center">1</td>
                                              <td class="tx-medium">{{ $estateDiscount['discount_id'] }}</td>
                                              <td class="tx-medium">Family and Friends</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">6 Months</td>
                                              <td class="tx-medium">5</td>
                                              <td class="tx-medium">20/05/2020</td>
                                              <td class=" text-center">
                                                <div class="dropdown-file">
                                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="" class="dropdown-item details text-primary"><i class="far fa-user"></i> Summary</a>
                                                        <a href="" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                          </div>
                          <div class="tab-pane pd-20 pd-xl-25" id="client">
                            <div class="col-lg-12 col-xl-12">
                            <div class="card">
                            <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                <div>
                                    <h6 class="mg-b-5">{{$estate->estate_name}} clients as of {{ date('M, d Y') }}</h6>
                                    <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Clients in {{$estate->estate_name}}.</p>
                                </div>

                            </div>
                              <div class="table-responsive">

                                  <table class="table table-hover mg-b-0" id="basicExample">
                                      <thead class="thead-primary">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Client Name</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>Date Registered</th>
                                            <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($registeredClients as $clients)
                                        <tr>
                                          <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                          <td class="tx-medium">{{ $clients['user']['account']['first_name']. " " .$clients['user']['account']['last_name'] }}</td>
                                          <td class="tx-medium">09072345421</td>
                                          <td class="tx-medium">{{ $clients['user']['email'] }}</td>
                                          <td class="tx-medium">{{ Carbon\Carbon::parse($clients['user']['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                          <td class=" text-center">
                                            <div class="dropdown-file">
                                                <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="" class="dropdown-item details text-primary"><i class="far fa-user"></i> Summary</a>
                                                    <a href="" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        </tr>
                                      @endforeach
                                      </tbody>
                                  </table>
                              </div>
                          </div>

                      </div>
                  </div>
          {{-- </div><!-- row --> --}}
          </div><!-- row -->
          </div><!-- row -->

      </div>
  </div>

@endsection
