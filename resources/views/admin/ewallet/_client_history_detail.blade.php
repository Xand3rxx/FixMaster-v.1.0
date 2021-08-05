<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Unique ID</td>
            <td class="tx-color-03" width="75%">{{ $transaction['unique_id'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Reference No.</td>
            <td class="tx-color-03" width="75%">{{ !empty($transaction['payment']['reference_id']) ? $transaction['payment']['reference_id'] : 'UNAVAILABLE' }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Transaction ID.</td>
            <td class="tx-color-03" width="75%">{{ !empty($transaction['payment']['transaction_id']) ? $transaction['payment']['transaction_id'] : 'UNAVAILABLE' }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Transaction Type</td>
            <td class="tx-color-03" width="75%">{{ ucfirst($transaction['transaction_type']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Payment Type</td>
            <td class="tx-color-03" width="75%"3">{{ ucfirst($transaction['payment_type']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Payment Channel</td>
            <td class="tx-color-03" width="75%"3">{{ ucfirst($transaction['payment']['payment_channel']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Payment For</td>
            <td class="tx-color-03" width="75%"3">{{ ucfirst($transaction['payment']['payment_for']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Amount</td>
            <td class="tx-color-03" width="75%">₦{{ number_format($transaction['payment']['amount']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Status</td>
            <td class="text-success" width="75%">{{ $transaction['payment']['status'] }}</td>
        </tr>
        {{-- <tr>
            <td class="tx-medium" width="25%">Refund Reason</td>
            <td class="tx-color-03" width="75%">This section should only be visible in a case of refund, the reason should be displayed here or UNAVAILABLE</td>
        </tr> --}}
    </tbody>
    </table>
</div>