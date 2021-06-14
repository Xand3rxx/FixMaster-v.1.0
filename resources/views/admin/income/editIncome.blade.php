@extends('layouts.dashboard')
@section('title', 'Edit Income')
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.income', app()->getLocale()) }}">Incomes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Income</li>
                        </ol>
                    </nav>
{{--                    <h4 class="mg-b-0 tx-spacing--1">Create New Income</h4>--}}
                </div>
            </div>

            <form action="{{ route('admin.update_income', ['locale' => app()->getLocale(), 'income' => $income['uuid']]) }}" method="POST">
                @csrf
                @method('PATCH')
                <fieldset class="form-group border p-4">
                    <legend class="w-auto px-2">Edit Income</legend>
                    <div class="row row-xs">
                        <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label>Income Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('income_name') is-invalid @enderror" id="income_name" name="income_name" placeholder="Income Name" value="{{ $income['income_name'] }}" readonly>
                                    @error('income_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            <div class="mt-6">
                                <div class="form-group col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="amount" name="type" value="amount" @if($income['income_type'] == 'amount') checked @endif >
                                        <label class="custom-control-label" for="amount">Amount Based</label><br>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 d-flex align-items-end">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="percentage" name="type" value="percentage" @if($income['income_type'] == 'percentage') checked @endif>
                                        <label class="custom-control-label" for="percentage">Percentage Based</label><br>
                                    </div>
                                </div>
                            </div>
                                <div class="form-group col-md-12 @if($income['income_type'] != 'amount') d-none @endif d-amount">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Amount" value="{{ $income['amount'] }}">
                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 @if($income['income_type'] != 'percentage') d-none @endif d-percentage">
                                    <label for="percentage">Percentage <strong>(%)</strong> </label>
                                    <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage" name="percentage" placeholder="Percentage" value="{{ $income['percentage']*100 }}">
                                    @error('percentage')
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
        $('#amount').change(function () {
            if ($(this).prop('checked')) {
                $('.d-amount').removeClass('d-none');
                $('.d-percentage').addClass('d-none');
            }
        });

        $('#percentage').change(function () {
            if ($(this).prop('checked')) {
                $('.d-percentage').removeClass('d-none');
                $('.d-amount').addClass('d-none');
            }
        });

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
