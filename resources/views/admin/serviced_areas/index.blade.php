@extends('layouts.dashboard')
@section('title', 'Serviced Areas')
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
              <li class="breadcrumb-item active" aria-current="page">Serviced Areas</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Serviced Areas</h4>
        </div>
      </div>

      <div class="row row-xs">

        <div class="col-lg-3 col-xl-3 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-10"><b>ADD NEW SERVICED AREA</b></h6>
                </div>                
              </div>
                    <form method="POST" action="{{ route('admin.serviced-areas.store', app()->getLocale()) }}">
                    @csrf

                            <div class="form-group col-md-12">
                                <label>State</label>
                                <select class="form-control @error('state_id') is-invalid @enderror" name="state_id" id="state_id">
                                    <option selected value="">Select...</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                               
                            </div>

                            <div class="form-group col-md-12">
                                <label>L.G.A</label>
                                <select class="form-control @error('lga_id') is-invalid @enderror" name="lga_id" id="lga_id">
                                    <option selected value="">Select...</option>
                                </select>
                                @error('lga_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                               
                            </div>

                            <div class="form-group col-md-12">
                                <label>Town</label>
                                <select class="form-control @error('town_id') is-invalid @enderror" name="town_id"  id="town_id">
                                    <option selected value="">Select...</option>
                                </select>
                                @error('town_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                               
                            </div>

                            <input type="hidden" name="url" id="url" value="{{url('/')}}" />

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                <!-- </form> -->
            </div><!-- card -->    
        </div><!-- col -->

        <div class="col-lg-9 col-xl-9 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Serviced Areas as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all areas that can be serviced.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                <div id="sort_table">
                  @include('admin.serviced_areas._table')
                </div>
              </div><!-- table-responsive -->
            </div><!-- card -->    
        </div><!-- col -->
        
      </div>

    </div>
</div>

@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/1e65edf0-c8e5-432c-8bbf-a7ed7847990f.js') }}"></script>

  <script>

    $(document).ready(function () {
        //Get list of L.G.A's in a particular state.
        $("#state_id").on("change", function () {
            let stateId = $("#state_id").find("option:selected").val();
            let stateName = $("#state_id").find("option:selected").text();
            let wardId = $("#ward_id").find("option:selected").val();

            $.ajax({
                url: "{{ route('lga_list', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    state_id: stateId,
                },
                success: function (data) {
                    if (data) {
                        $("#lga_id").html(data.lgaList);
                    } else {
                        var message = "Error occured while trying to get L.G.A`s in " + stateName + " state";
                        var type = "error";
                        displayMessage(message, type);
                    }
                },
            });
        });

        $('#lga_id').on('change', function() {
            let stateId = $('#state_id').find('option:selected').val();
            let lgaId = $('#lga_id').find('option:selected').val();
            $.ajax({
                url: "{{ route('towns.show', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "state_id": stateId, "lga_id": lgaId
                },
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $('#town_id').html(data.towns_list);
                    } else {
                        var message = 'Error occured while trying to get Town`s';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })
        });
    });
</script>

@endpush

@endsection