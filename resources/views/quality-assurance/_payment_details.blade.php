<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Unique ID</td>
            <td class="tx-color-03" width="75%">{{$payment->service_request->unique_id}}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Service Category</td>
            <td class="tx-color-03" width="75%">{{$payment['service_request']['service']['name']}}</td></td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Service Type</td>
            <td class="tx-color-03" width="75%">{{$payment['service_type']?? 'Unavailable'}}</td>
        </tr>
    
        <tr>
            <td class="tx-medium" width="25%">Amount</td>
            <td class="tx-color-03" width="75%">₦{{ number_format($payment['amount_to_be_paid']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Status</td>
            @if($payment->status=='Paid')
                <td class="text-success" width="75%">Paid</td>
            @else
                <td class="text-warning" width="75%">Pending</td>
            @endif
        </tr>

    </tbody>
    </table>
</div>
