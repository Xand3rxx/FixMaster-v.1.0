@extends('layouts.dashboard')
@section('title', 'Edit Earnings')
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.earnings', app()->getLocale()) }}">Earnings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Earning</li>
                        </ol>
                    </nav>
{{--                    <h4 class="mg-b-0 tx-spacing--1">Create Earning</h4>--}}
                </div>
            </div>

            <form action="{{ route('admin.update_earnings', ['locale' => app()->getLocale(), 'earning' => $earnings['uuid']]) }}" method="POST">
                @csrf
                @method('PATCH')
                <fieldset class="form-group border p-4">
                    <legend class="w-auto px-2">Edit Earnings</legend>
                    <div class="row row-xs">
                        <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label for="role_name">Roles <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name" placeholder="Roles" readonly value="{{ $earnings['role_name'] }}">
                                    @error('role_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="earnings">Earnings <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('earnings') is-invalid @enderror" id="earnings" name="earnings" placeholder="Earnings" value="{{ $earnings['earnings'] * 100 }}">
                                    @error('earnings')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                        </div>
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
    </div>

@section('scripts')
    <script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>

    <script>
        $('.selectpicker').selectpicker();
    </script>

@endsection

@push('scripts')
    <script>
        $(document).ready(function (){
            //Get list of L.G.A's in a particular state.
            $('#state_id').on('change',function () {
                let stateId = $('#state_id').find('option:selected').val();
                let stateName = $('#state_id').find('option:selected').text();

                // $.ajaxSetup({
                //         headers: {
                //             'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
                //         }
                //     });
                $.ajax({
                    url: "{{ route('lga_list', app()->getLocale()) }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {"_token": "{{ csrf_token() }}", "state_id":stateId},
                    success: function(data){
                        if(data){

                            $('#lga_id').html(data.lgaList);
                        }else{
                            var message = 'Error occured while trying to get L.G.A`s in '+ stateName +' state';
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
