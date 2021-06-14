@extends('layouts.dashboard')
@section('title', 'Send Supplier Invoice')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('supplier.rfq', app()->getLocale()) }}">RFQ's List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Send Quote</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Send Quote for: {{ !empty($rfqDetails->unique_id) ? $rfqDetails->unique_id : 'UNAVAILABLE' }} RFQ</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <h5>
            Issuer: {{ Str::title($rfqDetails['issuer']['account']['first_name'] ." ". $rfqDetails['issuer']['account']['last_name']) }}<br>
            Service: {{ $rfqDetails->serviceRequest->service->name }}
          </h5>
        <div class="table-responsive mt-4">
        <form method="POST" action="{{ route('supplier.rfq_store_ supplier_warranty_claim', app()->getLocale()) }}">
            @csrf
            <table class="table table-hover mg-b-0">
            <thead class="thead-primary">
                <tr>
                <th class="text-center">#</th>
                <th width="30%">Component Name</th>
                <th width="15%">Model Number</th>
                <th width="5%" class="text-center">Quantity</th>
                <th width="25%" class="text-center">Unit Price</th>
                <th width="25%" class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                <input value="{{ $rfqDetails->id }}" type="hidden" name="rfq_id" class="d-none">
                <input value="{{ old('total_amount') }}" type="hidden" name="total_amount"  id="total_amount" class="d-none"> 

                @foreach ($rfqDetails->rfqBatches as $item)

                <input value="{{ $item->id }}" type="hidden" name="rfq_batch_id[]" class="d-none">
                <input value="{{ $item->quantity }}" type="hidden" name="quantity[]"> 
                    <tr>
                        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                        <td class="tx-medium">{{ $item->component_name }}</td>
                        <td>{{ $item->model_number }}</td>
                        <td class="tx-medium text-center quantity-{{$item->id}}">{{ $item->quantity }}</td>
                        <td class="tx-medium text-center">
                        <input type="number" maxlength="7" min="1" name="unit_price[]"
                         class="form-control @error('unit_price') is-invalid @enderror"
                          id="unit-price-{{$item->id}}" value="{{ old('unit_price[]') }}" onkeyup="individualAmount({{ $item->id }})" autocomplete="off">
                        @error('unit_price')
                        <x-alert :message="$message" />
                        @enderror
                        <input type="hidden" class="each-amount" id="unit-amount-{{$item->id}}">
                        </td>
                        <td class="tx-medium text-center amount-{{$item->id}}">0</td>
                    </tr>
                @endforeach
                <thead class="thead-primary">
                    <tr>
                    <th colspan="2">#</th>
                    <th width="20%">Delivery Fee</th>
                    <th width="20%">Delivery Time</th>
                    <th colspan="2"></th>
                    </tr>
                </thead>
                <tr>
                    <td colspan="2">1</td>
                    <td>
                    <input class="form-control @error('delivery_fee') is-invalid @enderror each-amount" name="delivery_fee" id="delivery_fee" type="number" maxlength="7" min="1" value="{{ old('delivery_fee')}}" autocomplete="off" onkeyup="deliveryFee()">
                    @error('delivery_fee')
                        <x-alert :message="$message" />
                    @enderror
                    </td>
                    <td>
                    <input class="form-control @error('delivery_time') is-invalid @enderror" name="delivery_time" id="service-date-time" type="text" value="{{ old('delivery_time') }}" placeholder="Click to Enter Delivery Date & Time" readonly>
                    @error('delivery_time')
                        <x-alert :message="$message" />
                    @enderror
                    </td>
                    <td colspan="1"></td>
                    <td class="tx-medium delivery-fee">0</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <button type="submit" class="btn btn-primary">Send Invoice</button>
                    </td>
                    <td class="tx-medium text-center">Total</td>
                    <td class="tx-medium text-center total-amount">₦0</td>
                </tr>
            </tbody>
            </table>
        </form>
        </div><!-- table-responsive -->
      </div><!-- col -->
      <small class="text-danger">Please note, this is a one time process for this RFQ. Ensure to fill in the right details.</small>
    </div><!-- row -->

  </div><!-- container -->


@push('scripts')
    <script src="{{ asset('assets/dashboard/assets/js/a784c9e7-4015-44df-994d-50ffe4921458.js') }}"></script>
@endpush

@endsection