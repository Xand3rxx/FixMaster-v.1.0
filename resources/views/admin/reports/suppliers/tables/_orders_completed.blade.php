<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
    <tr>
        <th class="text-center">#</th>
        <th>Supplier Name</th>
        <th>Supplier ID</th>
        <th>Job ID</th>
        <th>Item Ordered</th>
        <th>Delivery Date</th>
        <th>Delivery Status</th>
        <th>Returns</th>
        <th>Invoice Value</th>
        <th>Retention Value</th>
        <th>Payment Due</th>
        <th>Payment Date</th>
        <th>Payment Status</th>
        <th>CSE on Job</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="tx-color-03 tx-center">1</td>
        <td class="tx-medium">Henry Efe</td>
        <td class="tx-medium">SUP-9C401136</td>
        <td class="tx-medium">REF-79A722D6</td>
        <td class="text-medium">PVC Pipe</td>
        <td class="text-medium">Delivered</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-23 17:09:23', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{number_format(2000)}}</td>
        <td class="text-medium">{{number_format(8000)}}</td>
        <td class="text-medium">{{number_format(3000)}}</td>
        <td class="text-medium">{{number_format(8000)}}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-24 11:15:30', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium text-center">Paid</td>
        <td class="text-medium text-center">Benedict Olaoye</td>
    </tr>

    <tr>
        <td class="tx-color-03 tx-center">2</td>
        <td class="tx-medium">James Godfrey</td>
        <td class="tx-medium">SUP-CBB42A2F</td>
        <td class="tx-medium">REF-66EB5A26</td>
        <td class="text-medium">Condenser</td>
        <td class="text-medium">Delivered</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-02-15 10:00:00', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{number_format(5000)}}</td>
        <td class="text-medium">{{number_format(25000)}}</td>
        <td class="text-medium">{{number_format(6000)}}</td>
        <td class="text-medium">{{number_format(25000)}}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-16 15:35:12', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium text-center">Wisdom Amana</td>
        <td class="text-medium text-center">Jackson Okoye</td>
    </tr>

    </tbody>
</table>
