<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Unique ID</td>
            <td class="tx-color-03" width="75%">{{ $payment['unique_id'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Reference No.</td>
            <td class="tx-color-03" width="75%">{{ $payment['reference_id'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Transaction ID.</td>
            <td class="tx-color-03" width="75%">{{$payment->transaction_id == null ? 'UNAVAILABLE' : $payment->transaction_id  }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Payment Channel</td>
            <td class="tx-color-03" width="75%">{{ $payment['payment_channel'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Payment For</td>
            <td class="tx-color-03" width="75%">{{ $payment['payment_for'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Amount</td>
            <td class="tx-color-03" width="75%">₦{{ number_format($payment['amount']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Status</td>
            @if($payment->status=='success')
                <td class="text-success" width="75%">Success</td>
            @elseif($payment->status=='pending')
                <td class="text-danger" width="75%">Pending</td>
            @elseif($payment->status=='failed')
                <td class="text-warning" width="75%">Failed</td>
            @elseif($payment->status=='timeout')
                <td class="text-info" width="75%">Timeout</td>
            @endif
        </tr>

    </tbody>
    </table>
</div>
