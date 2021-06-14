@extends('layouts.dashboard')
@section('title', 'Location Request')
@include('layouts.partials._messages')
@section('content')
<style>
  .select2-container .select2-selection--single { 
    height: 38px;
  }
  .select2-container {
    width: 100% !important;
  }
</style>

  <input type="hidden" id="path_web" value="{{ route('admin.index', app()->getLocale()) }}">
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.location_request', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Location Request</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Location Request</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-12 justify-content-center text-center align-items-center">
        <a href="#locationRequest" class="btn btn-primary float-right" data-toggle="modal"><i class="fas fa-plus"></i> Request</a>
      </div>

      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Your Most Recent Requests</h6>
            {{-- <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of Location Requests made by <span>You</span> to a Technician paired with on a job as of <strong>{{ date('l jS F Y') }}</strong>.</p> --}}
            </div>
            
          </div><!-- card-header -->
          
          <div class="table-responsive">
           
            <table class="table table-hover mg-b-0" id="basicExample">
              <thead class="thead-primary">
                <tr>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Job Ref.</th>
                    <th>Requested By</th>
                    <th>Request Timestamp</th>
                    <th>Recipient</th>
                    <th>Response Timestamp</th>
                    <th>Location</th>
                    <th class=" text-center">Action</th>
                  </tr>
                </tr>
              </thead>
              <tbody>

              @foreach($serviceRequests as $k=>$data)
                <tr>
                  <td class="tx-color-03 tx-center">{{++$k}}</td> 
                  <td class="tx-medium">{{$data->unique_id}}</td>
                  <td class="tx-medium">David Akinsola</td>
                  <td class="text-medium">{{date("Y/m/d h:i:A",strtotime($data->created_at))}}</td>
                  <td class="tx-medium">Godfrey Diwa</td>
                  <td class="text-medium"></td>
                  <td class="text-medium"></td>
                  <td class=" text-center"><a href="#" title="Show location" class="btn btn-success btn-sm"><i class="
                    fas fa-map-marker-alt"></i></a></td>
                </tr>           
               @endforeach

              </tbody>
            </table>
          </div><!-- table-responsive -->
        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->


  </div><!-- container -->
</div>

<div class="modal fade" id="locationRequest" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered wd-sm-650" role="document">
    <div class="modal-content">
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
        <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <h5 class="mg-b-2"><strong>Location Request</strong></h5>
        
        <div class="col-12 col-md-12 col-lg-12 col-xs-12 mt-4">
            <div class="form-row">
                <div class="col-md-12">
                    <label for="password">Job Reference</label>
                    <select class="custom-select select2 form-control" required onchange="getWorkersAssignedToThisService(this.value)">
                        <option label="Select..."></option>
                        @foreach($serviceRequests as $data)
                        <option value="{{$data->id}}">{{$data->unique_id}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row mt-4">
              <div class="col-md-12">
                  <label for="password">CSE/Technician</label>
                  <select class="custom-select">
                      <option label="Select..."></option>
                      <option value="CSE">CSE</option>
                      <option value="Technician">Technician</option>
                  </select>
              </div>
          </div>
            <div class="form-row mt-4">
              <div class="col-md-12">
                  <label for="inputEmail4">Full Name</label>
                  <input class="form-control" id="" value="Godfrey Diwa" disabled readonly>
              </div>
            </div>
            
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </div>
      </div><!-- modal-body -->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

@section('scripts')
<script src="{{ asset('assets/dashboard/lib/select2/js/select2.min.js') }}"></script>

<script>
$(function(){
    'use strict'

    // Basic with search
    $('.select2').select2({
      placeholder: 'Choose one',
      searchInputPlaceholder: 'Search Job Reference'
    });

  });
</script>

<script>
    $(document).ready(function() {

        $('#request-sorting').on('change', function (){        
                let option = $("#request-sorting").find("option:selected").val();

                if(option === 'None'){
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Date'){
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Month'){
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                }

                if(option === 'Date Range'){
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                }
        });
    });
   


       // to change the menu item list on change of category in dropdown select
       function getWorkersAssignedToThisService(val){
        console.log(val);

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
        //     }
        // });

            // $.ajax({
            //     url: "{{ route('getServiceDetails', app()->getLocale()) }}"+"/"+val,
            //     responseData: { },
            //     success: function( responseData ) {
            //         // var itemname = "";
            //         console.log(responseData);
            //         // for (var i = 0; i < responseData.length; i++) {
            //         //     itemname += '<option value="'+responseData[i]["id"]+'">'+responseData[i]["menu_name"]+ '</option>'
            //         // }
            //         // document.getElementById("itemlist").innerHTML = itemname;
            //     }
            // });

            $.ajax({
                url: "{{ route('getServiceDetails', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON", 
                data: {
                    "_token": "{{ csrf_token() }}",
                    "job_Ref": val
                },
                success: function(data) {
                  // itemname = '';
                  // for (var i = 0; i < data.length; i++) {
                  //       itemname += '<option value="'+data[i]["id"]+'">'+data[i]["menu_name"]+ '</option>'
                  //   }

                  // document.getElementById("itemlist").innerHTML = itemname;

                  console.log(data)

                    // if (data) {
                    //     $('#lga_id').html(data.lgaList);
                    // } else {
                    //     var message = 'Error occured while trying to get L.G.A`s in ' + stateName + ' state';
                    //     var type = 'error';
                    //     displayMessage(message, type);
                    // }
                },
            })



        }

</script>
@endsection

@endsection