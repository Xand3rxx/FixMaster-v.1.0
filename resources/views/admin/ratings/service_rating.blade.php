@extends('layouts.dashboard')
@section('title', 'Service Rating')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Rating</li>
              <li class="breadcrumb-item active" aria-current="page">Service Rating</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Service Rating</h4>
        </div>
      </div>

      <div class="row row-xs">

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Service Category Ratings as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Service Ratings made by Clients.</p>
                </div>

              </div><!-- card-header -->

              <div class="table-responsive">

                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Service</th>
                      <th class="text-center">Total Rating</th>
                      <th class="text-center">Overall Rating(5)</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $sn = 1; @endphp
                @foreach($cards as $rating)
                    <tr>

                    <td class="tx-color-03 tx-center">{{$sn++}}</td>
                    <td class="tx-medium">{{$rating->service_request->service->name}}</td>
                      <td class="tx-medium text-center">{{$rating->id}}</td>
                      <td class="text-medium text-center">{{round($rating->starAvg)}}</td>
                      <td class=" text-center">
                        <div class="dropdown-file">
                            <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                            <a href="javascript:void(0)" data-toggle="modal" data-number="{{$rating->service_request_id}}" class="dropdown-item details text-primary" title="View Computer & Laptops ratings"><i class="far fa-star"></i> Ratings</a>
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

<div class="modal fade" id="serviceDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Total Ratings for {{$rating->service_request->service->name}}</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
        <table class="table table-hover mg-b-0" id="basicExample">
          <thead class="thead-primary">
            <tr>
              <th class="text-center">#</th>
              <th>Job Reference</th>
              <th>Client</th>
              <th class="text-center">Rating(5)</th>
              <th class="text-center">Date</th>
            </tr>
          </thead>
          <tbody id="tbody">


          </tbody>
        </table>
        </div><!-- modal-body -->
      <div class="modal-footer"></div>
    </div>
  </div>
</div>
@endsection
@yield('scripts')
@stack('scripts')
@section('scripts')
<script>
$(document).ready(function(){
   $(document).on('click', ".dropdown-item", function() {
       let service_request_id = $(this).data('number');
       //alert(id);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.get_ratings_by_service', app()->getLocale()) }}",
                        method: 'GET',
                        data: {
                            "id": service_request_id
                        },
                        // return the result
                        success: function(data) {
                            if (data) {
                            //console.log(data);
                            var sn = 1;
                                $.each(data, function(key, rating) { //+rating.service_request.unique_id+
                                var date = new Date(rating.created_at);
                                var rate_table = `
                                <tr>
                                    <td class="tx-color-03 tx-center">`+ sn++ +`</td>
                                    <td class="tx-medium">`+rating.service_request.unique_id+`</td>
                                    <td>`+ rating.client_account.first_name+" "+rating.client_account.last_name +`</td>
                                    <td class="text-medium text-center">`+ rating.star +`</td>
                                    <td>`+ date.toDateString() +`</td>
                                </tr>
                                `;
                                $("#exampleModalLabel2").append(rating.service_request.service);
                                $("#tbody").append(rate_table);
                                $("#serviceDetails").modal({show: true});
                                });

                            }
                        }

                    });
   });

   $('.close').click(function(){
       location.reload();
   })

})
</script>
@endsection
