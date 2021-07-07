
<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Name</td>
            <td class="tx-color-03" width="75%">{{ $serviceRequest->user->account->first_name}} {{ $serviceRequest->user->account->last_name}}</td>
        </tr>

        <tr>
            <td class="tx-medium" width="25%">Warranty Name</td>
            <td class="tx-color-03" width="75%">{{ $warrantyExist->name}} </td>
        </tr>

        <tr>
            <td class="tx-medium" width="25%">Warranty Duration</td>
            <td class="tx-color-03" width="75%">{{ $warrantyExist->duration}} </td>
        </tr>


        <tr>
            <td class="tx-medium" width="25%">Cse</td>
            <td class="tx-color-03" width="75%">{{ $serviceRequest->service_request_warranty_issued->account->first_name }} 
            {{ $serviceRequest->service_request_warranty_issued->account->last_name }}
            </td>
        </tr>

        <tr>
            <td class="tx-medium" width="25%">Completed By</td>
            <td class="tx-color-03" width="75%">{{ $serviceRequest->service_request_warranty_issued->completedBy->first_name?? '' }} 
            {{ $serviceRequest->service_request_warranty_issued->completedBy->last_name??'' }}
            </td>
        </tr>

        <tr>
            <td class="tx-medium" width="25%">Comment</td>
            @if(!empty($serviceRequest->service_request_warranty_issued->admin_comment))
            <td class="tx-color-03" width="75%">{{ $serviceRequest->service_request_warranty_issued->admin_comment}} </td>
            @else
            <td class="tx-color-03" width="75%">{{ $serviceRequest->service_request_warranty_issued->cse_comment}} </td>
             @endif
        </tr>

        <tr>
            <td class="tx-medium" width="25%">Warranty Initated</td>
            <td class="tx-color-03" width="75%">{{ Carbon\Carbon::parse($serviceRequest->date_initiated ?? '2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
         
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Warranty Start Date</td>
            <td class="tx-color-03" width="75%">{{ Carbon\Carbon::parse($warrantyExist->start_date ?? '2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
           
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Warranty Expiration Date</td>
            <td class="tx-color-03" width="75%">{{ Carbon\Carbon::parse($warrantyExist->expiration_date ?? '2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
        

        </tr>
       
       
       
    </tbody>
    </table>
</div>