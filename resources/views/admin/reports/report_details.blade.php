@extends('layouts.dashboard')
@section('title', '\'s Summary')
@include('layouts.partials._messages')
@section('content')
  <div class="content-body">
      <div class="container pd-x-0">
          <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
              <div>
                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                          <li class="breadcrumb-item"><a href="{{ route('admin.cse_reports', app()->getLocale()) }}">CSE Report</a></li>
                          <li class="breadcrumb-item active" aria-current="page">{{-- $serviceRequests->estate_name --}}</li>
                      </ol>
                  </nav>
                  {{-- <h4 class="mg-b-0 tx-spacing--1">CSE List</h4> --}}
              </div>

              <div class="d-md-block">
                 
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
                              <a href="#summary" class="nav-link active" data-toggle="tab">Job Assigned</a>
                              <a href="#amount_earned" class="nav-link" data-toggle="tab"><span>Amount Earned</a>
                              <a href="#client" class="nav-link" data-toggle="tab"><span>All CSE's</a>
                              <a href="#client" class="nav-link" data-toggle="tab"><span>CSE Rating History</a>
                              <a href="#activityLog" class="nav-link" data-toggle="tab"><span>Statement Balance</a> 
                              <a href="#client" class="nav-link" data-toggle="tab"><span>Prospect Conversion</a>
                              <a href="#client" class="nav-link" data-toggle="tab"><span>Customer Complaints</a>
                              <a href="#client" class="nav-link" data-toggle="tab"><span>Warranty Log</a>
                            </nav>
                            <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a>
                          </div>
                          <nav class="nav nav-with-icon tx-13">
                              <!-- <a href="" class="nav-link"><i data-feather="plus"></i> Add New</a> -->
                          </nav>
                      </div><!-- card-header -->
                      <div class="contact-content-body">
                        <div class="tab-content">
                    
                                  <div class="table-responsive">
                                      <table class="table table-striped table-sm mg-b-0">
                                          <tbody>
                                          <tr>
                                              <td class="tx-medium">CSE ID</td>
                                              <td>@foreach($serviceRequests->users as $data)
                  @foreach($data->roles as $res)
                  @if($res->url == "cse")
                     {{$data->cse->unique_id ?? ''}}
                  @endif
                  @endforeach
                  @endforeach </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">JOB ID</td>
                                              <td class="tx-color-03"> {{$serviceRequests->unique_id}} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">JOB LOCATION</td>
                                              <td class="tx-color-03"> {{$serviceRequests->address->address}} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">JOB BOOKING DATE</td>
                                              <td class="tx-color-03"> {{ Carbon\Carbon::parse($serviceRequests->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">JOB ACCEPTANCE DATE</td>
                                              <td class="tx-color-03"> {{ $serviceRequests->unique_id ?? '' }}</td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">JOB DIAGNOSTIC DATE</td>
                                              <td class="tx-color-03"> {{-- Carbon\Carbon::parse($estate->date_of_birth, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') --}} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">JOB COMPLETION DATE</td>
                                              <td class="tx-color-03"> {{ $serviceRequests->unique_id ?? '' }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">JOB STATUS</td>
                                              @if($serviceRequests->status_id == 1)
                    <td class="text-medium text-warning">Pending</td>
                  @elseif($serviceRequests->status_id == 2)
                  <td class="text-medium text-info">Ongoing</td>
                  @elseif($serviceRequests->status_id == 3)
                    <td class="text-medium text-danger">Cancelled</td>
                  @elseif($serviceRequests->status_id == 4)
                    <td class="text-medium text-success">Completed</td>
                  @else
                 <td class="text-medium text-warning">{{$serviceRequests->status}}</td>
                  @endif
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Days between Booking / Acceptance</td>
                                              <td class="tx-color-03"> {{ $serviceRequests->unique_id ?? '' }} </td>
                                          </tr>
                                          <tr>
                                              <td class="tx-medium">Days between Acceptance / Between</td>
                                              <td class="tx-color-03"> {{ $serviceRequests->unique_id ?? '' }} </td>
                                          </tr>
                                        
                                          
                                          
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <div class="tab-pane pd-20 pd-xl-25" id="amount_earned">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5"> CSE Earning as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Fixmaster CSE Earning .</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>CSE ID</th>
                                                <th>Job ID</th>
                                                <th>Job Acceptance Date</th>
                                                <th>Diagnostic Date</th>
                                                <th>Day Betwn Accept & Diagnostic</th>
                                                <th>Job Completion Date</th>
                                                <th>Diagnostic Earning</th>
                                                <th>Completion Earning</th>
                                                <th>Total Earned</th>
                                                <th>Diagnostic Paid (Y/N)</th>
                                                <th>Completion Paid (Y/N)</th>
                                                <th>Total Paid</th>
                                                
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td class="tx-color-03 tx-center">1</td>
                                              <td class="tx-medium">Family and Friends</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Service discount</td>
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
                                    <h6 class="mg-b-5"> clients as of {{ date('M, d Y') }}</h6>
                                    <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Clients in .</p>
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
                                        <tr>
                                          <td class="tx-color-03 tx-center">1</td>
                                          <td class="tx-medium">Colin Hayward</td>
                                          <td class="tx-medium">09072345421</td>
                                          <td class="tx-medium">colinh20@gmail.com</td>
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
                                        <tr>
                                            <td class="tx-color-03 tx-center">2</td>
                                            <td class="tx-medium">Martin Philips</td>
                                            <td class="tx-medium">08041234586</td>
                                            <td class="tx-medium">m.philips@gmail.com</td>
                                            <td class="tx-medium">11/01/2020</td>
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
                                          <tr>
                                            <td class="tx-color-03 tx-center">3</td>
                                            <td class="tx-medium">Kolade Michaels</td>
                                            <td class="tx-medium">07056685943</td>
                                            <td class="tx-medium">kolade_mic@gmail.com</td>
                                            <td class="tx-medium">25/12/2020</td>
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
