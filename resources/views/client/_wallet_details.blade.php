<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Unique ID</td>
            <td class="tx-color-03" width="75%">{{ $transaction->unique_id }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Reference No.</td>
            <td class="tx-color-03" width="75%">{{ $transaction->reference_id }}</td>
        </tr>
        @if(!empty($transaction->transaction_id))
        <tr>
            <td class="tx-medium" width="25%">Transaction ID.</td> 
            <td class="tx-color-03" width="75%">{{ $transaction->transaction_id }}</td>
        </tr>
        @endif
        <tr>
            <td class="tx-medium" width="25%">Transaction Type</td>
            <td class="tx-color-03" width="75%">{{ ucfirst($transaction['wallettransactions']['transaction_type']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Payment Type</td> 
            <td class="tx-color-03" width="75%">{{ ucfirst($transaction['wallettransactions']['payment_type']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Payment Channel</td> 
            <td class="tx-color-03" width="75%">{{ ucfirst($transaction->payment_channel) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Payment For</td>
            <td class="tx-color-03" width="75%">{{ ucfirst($transaction->payment_for) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Amount</td>
            <td class="tx-color-03" width="75%">₦{{ number_format($transaction->amount) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Status</td>
            <td class="{{ (($transaction->status == 'pending') ? 'text-warning' : (($transaction->status == 'success') ? 'text-success' : (($transaction->status == 'failed') ? 'text-danger' : 'text-danger'))) }}" width="75%">{{ ucfirst($transaction->status) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Opening Balance</td>
            <td class="tx-color-03" width="75%">₦{{ number_format($transaction['wallettransactions']['opening_balance']) }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Closing Balance</td>
            <td class="tx-color-03" width="75%">₦{{ number_format($transaction['wallettransactions']['closing_balance']) }}</td>
        </tr>
    </tbody>
    </table>
</div>