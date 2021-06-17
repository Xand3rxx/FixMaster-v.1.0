<div class="d-flex ml-4"><h4 class="text-success">{{ !empty($message)? $message: '' }}</h4></div>
<form action="{{route('admin.payments.get_checkbox', app()->getLocale())}}" method="post">
    {{ csrf_field() }}
<table class="table table-hover mg-b-0" id="basicExample">

    <div class="col-md-4" id="bulkOptionsContainer">
       <select class="form-control" name="bulk" required style="padding:0px;">
         <option value="">Select Action</option>
         <option value="Paid">Mark as Paid</option>
       </select>
       <input type="submit" name="submit" class="btn btn-success" value="Apply">
    </div>

    <thead class="thead-primary">
      <tr>
        <th><input class="selectAllBoxes" type="checkbox"></th>
        <th class="text-center">#</th>
        <th>Job ID</th>
        <th>Service Category</th>
        <th>Service Type</th>
        <th>CSE Name</th>
        <th>CSE Nuban</th>
        <th>CSE Bank</th>
        <th>CSE Amount</th>
        <th>QA Name</th>
        <th>QA Nuban</th>
        <th>QA Bank</th>
        <th>QA Amount</th>
        <th>Technician Name</th>
        <th>Technician Nuban</th>
        <th>Technician Bank</th>
        <th>Technician Amount</th>
        <th>Supplier Name</th>
        <th>Supplier Nuban</th>
        <th>Supplier Bank</th>
        <th>Supplier Amount</th>
        <th>Retention Fee</th>
        <th>Amount After Retention</th>
        <th>Amount to be Paid</th>
        <th>Status</th>
        <th class="text-center">Date of Completion</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>

        @foreach($pendingPayments as $payment)
      <tr>
        <td><input class="checkBoxes" name="checkBoxArray[]" type="checkbox" value="{{$payment->id}}"></td>
        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
        <td class="tx-medium">{{$payment['service_request']['unique_id']}}</td>
          <td class="tx-medium">{{$payment['service_request']['service']['name']}}</td>
          <td class="tx-medium">{{$payment['service_type']}}</td>
          @foreach($payment['users']['roles'] as $role)
            @if($role['name'] == 'Customer Service Executive')
            {{-- for CSEs --}}
                <td class="tx-medium">{{$payment['users']['account']['first_name'].' '.$payment['users']['account']['middle_name'].' '.$payment['users']['account']['last_name'] ?? 'Unavailable'}}</td>
                <td class="tx-medium">{{!empty($payment['users']['account']['account_number']) ? $payment['users']['account']['account_number'] : 'Unavailable'}}</td>
                <td class="tx-medium">{{!empty($payment['users']['account']['bank']['name']) ? $payment['users']['account']['bank']['name'] : 'Unavailable'}}</td>
                <td class="tx-medium">&#8358;{{!empty($payment['flat_rate']) ? number_format($payment['flat_rate'],2) : 'Unavailable'}}</td>
            @else
            <td class="tx-medium">Unavailable</td>
            <td class="tx-medium">Unavailable</td>
            <td class="tx-medium">Unavailable</td>
            <td class="tx-medium">Unavailable</td>
            @endif

            {{-- for QAs --}}
             @if($role['name'] == 'Quality Assurance Manager')
             <td class="tx-medium">{{$payment['users']['account']['first_name'].' '.$payment['users']['account']['middle_name'].' '.$payment['users']['account']['last_name'] ?? 'Unavailable'}}</td>
             <td class="tx-medium">{{!empty($payment['users']['account']['account_number']) ? $payment['users']['account']['account_number'] : 'Unavailable'}}</td>
             <td class="tx-medium">{{$payment['users']['account']['bank']['name']}}</td>
             <td class="tx-medium">&#8358;{{number_format($payment['flat_rate'],2)}}</td>
             @else
             <td class="tx-medium">Unavailable</td>
             <td class="tx-medium">Unavailable</td>
             <td class="tx-medium">Unavailable</td>
             <td class="tx-medium">Unavailable</td>
             @endif

              @if($role['name'] == 'Technicians & Artisans')
          {{-- for Technicians --}}
                <td class="tx-medium">{{$payment['users']['account']['first_name'].' '.$payment['users']['account']['middle_name'].' '.$payment['users']['account']['last_name']}}</td>
                <td class="tx-medium">{{$payment['users']['account']['account_number']}}</td>
                <td class="tx-medium">{{$payment['users']['account']['bank']['name']}}</td>
                <td class="tx-medium">&#8358;{{number_format($payment['actual_labour_cost'],2)}}</td>
              @else
              <td class="tx-medium">Unavailable</td>
              <td class="tx-medium">Unavailable</td>
              <td class="tx-medium">Unavailable</td>
              <td class="tx-medium">Unavailable</td>
            @endif

              @if($role['name'] == 'Suppliers')
              <td class="tx-medium">{{$payment['users']['account']['first_name'].' '.$payment['users']['account']['middle_name'].' '.$payment['users']['account']['last_name']}}</td>
              <td class="tx-medium">{{$payment['users']['account']['account_number']}}</td>
              <td class="tx-medium">{{$payment['users']['account']['bank']['name']}}</td>
              <td class="tx-medium">&#8358;{{number_format($payment['actual_material_cost'],2)}}</td>
              @else
               <td class="tx-medium">Unavailable</td>
               <td class="tx-medium">Unavailable</td>
               <td class="tx-medium">Unavailable</td>
               <td class="tx-medium">Unavailable</td>
              @endif

              @if($role['name'] == 'Technicians & Artisans' || $role['name'] == 'Suppliers')

                <td class="tx-medium">&#8358;{{number_format($payment['retention_fee'],2)}}</td>
                <td class="tx-medium">&#8358;{{number_format($payment['amount_after_retention'],2)}}</td>

              @else

              <td class="tx-medium">Unavailable</td>
              <td class="tx-medium">Unavailable</td>

              @endif

              <td class="tx-medium">&#8358;{{number_format($payment['amount_to_be_paid'],2)}}</td>
              <td class="tx-medium">{{$payment['status']}}</td>
          @endforeach
          <td class="text-medium tx-center">{{ Carbon\Carbon::parse($payment->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          {{-- <td><a href="#" data-toggle="modal" data-target="#transactionDetails" data-payment-ref="{{ $result->unique_id }}" data-url="{{ route('quality-assurance.payment_details', ['payment' => $result->id, 'locale' => app()->getLocale()]) }}" id="payment-details" class="btn btn-primary btn-sm ">Details</a></td> --}}
           <td><a href="#" id="" class="btn btn-primary btn-sm ">Details</a></td>
        </tr>
        @endforeach
    </tbody>
  </table>
</form>
