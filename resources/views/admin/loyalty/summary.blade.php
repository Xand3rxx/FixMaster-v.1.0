@extends('layouts.dashboard')
@section('title', $loyalty->first_name.'\'s Summary')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a  href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.loyalty_list',app()->getLocale()) }}"> List</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{'Summary' }}</li>
          </ol>
        </nav>
      </div>

      <div class="d-md-block">
      <a href="{{ route('admin.loyalty_list',app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
      <a href="{{ route('admin.edit_loyalty', [ 'loyalty'=>$loyalty->uuid, 'locale'=>app()->getLocale() ]) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                       
        <a href="#"  data-url="{{ route('admin.delete_loyalty', [ 'loyalty'=>$loyalty->uuid, 'client'=>$loyalty->client_id, 'locale'=>app()->getLocale() ]) }}" id="delete" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
      </div>
    </div>


          
    <h5 class="mg-t-40 mg-b-20 capitalize"> {{ucfirst($loyalty->first_name) }} {{ucfirst($loyalty->last_name) }} Details</h5>
          <div class="table-responsive">
            <table class="table table-striped table-sm mg-b-0">
              <tbody>
                <tr>
                  <td class="tx-medium">Name</td>
                  <td class="tx-color-03 capitalize">{{ucfirst($loyalty->first_name) }} {{ucfirst($loyalty->last_name) }}</td>
                </tr>
                <tr>
                  <td class="tx-medium">Points</td>
                  <td class="tx-color-03 capitalize">{{$loyalty->points}} %</td>
                </tr>
                <tr>
                  <td class="tx-medium">Amount</td>
                  <td class="tx-color-03 capitalize">{{$loyalty->amount}}</td>
                </tr>

                <tr>
                  <td class="tx-medium">Loyalty in Naira</td>
                  <td class="tx-color-03 capitalize">{{ $loyalty->points/100 * $loyalty->amount}}  &#8358;</td>
                </tr>

                <tr>
                  <td class="tx-medium">Loyalty Wallet</td>
                  <td class="tx-color-03 capitalize">{{ $loyalty->wallets}}  &#8358;</td>
                </tr>

                <tr>
                  <td class="tx-medium">Created Date</td>
                  <td class="tx-color-03">{{ Carbon\Carbon::parse($loyalty->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                </tr>

                
              </tbody>
            </table>
          </div>
        </div>




        <div class="row row-xs">

            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Loyalty Withdrawal List as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster
                            Loyalty Withdrawal List.</p>
                        </div>

                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Amount</th>
                                    <th>Withdrawal Date</th>
                                    <th>Balance</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                            @if (!empty($withdraws)) 
                            @foreach($withdraws as $k=>$withdraw)
                        <tr>
                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                            <td class="tx-medium">&#8358; {{ $withdraw }}</td>
                            <td class="tx-medium">{{ Carbon\Carbon::parse($withdraw_date[$k], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ss') }}</td>
                           <td  class="tx-medium">&#8358; {{$loyalty->wallets}}</td>
                           </tr>
                      
                      @endforeach
                      @endif
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- card -->

            </div><!-- col -->

        </div>

    </div>
</div>



</div><!-- tab-content -->
    </div><!-- contact-content-body -->
</div>


@section('scripts')
@push('scripts')
<script src="{{ asset('assets/dashboard/assets/js/admin/loyalty/4d5e497c-d12d-43ec-ac7a-a14f825ffaed.js') }}"></script>

@endpush

@endsection

@endsection