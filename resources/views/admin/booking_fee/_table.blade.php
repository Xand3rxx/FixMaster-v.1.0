<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Created By</th>
        <th class="text-center">Amount(₦)</th>
        <th class="text-center">Description</th>
        <th>Date Created</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($bookingFees as $bookingFee)
        <tr>
          <td class="tx-color-03 tx-center">{{ ++$i }}</td>
          <td class="tx-medium">{{ !empty($bookingFee->name) ? $bookingFee->name : 'UNAVAIALABLE' }}</td>
          <td>{{ !empty($bookingFee->user->email) ? $bookingFee->user->email : 'UNAVAIALABLE' }}</td>
          <td class="tx-medium text-center">{{ !empty($bookingFee->amount) ? number_format($bookingFee->amount) : '0' }}</td>
          <td>{{ !empty($bookingFee->description) ? $bookingFee->description : 'UNAVAILABLE' }}</td>
          <td>{{ Carbon\Carbon::parse($bookingFee->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') ?? Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class=" text-center">
            @if(!empty($bookingFee->name))
              <div class="dropdown-file">
                <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
              
                  <a href="#boookingFeeHistory" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $bookingFee->name}} details" data-url="{{ route('admin.booking-fees.show', ['booking_fee'=>$bookingFee->uuid, 'locale'=>app()->getLocale()] ) }}" data-booking-fee-name="{{ $bookingFee->name}}" id="booking-fee-history"><i class="far fa-clipboard"></i> History</a>

                  <a href="#editBookingFee" data-toggle="modal" id="booking-fee-edit" title="Edit {{ $bookingFee->name }}" data-url="{{ route('admin.booking-fees.edit', ['booking_fee'=>$bookingFee->uuid, 'locale'=>app()->getLocale()]) }}" data-booking-fee-name="{{ $bookingFee->name }}" data-id="{{ $bookingFee->uuid }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

                </div>
              </div>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>