{{-- {{ dd($results) }} --}}
<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
    <tr>
        <th class="text-center">#</th>
        <th>Supplier Name</th>
        <th>Supplier ID</th>
        <th>Job ID</th>
        <th>Job Status</th>
        <th>Item Ordered</th>
        <th>Quantity</th>
        <th>No. Of Items</th>
        <th>Value</th>
        <th>Order Date</th>
        <th>Delivery Date</th>
        <th>Order and Deliver</th>
        <th>Was Item Returned</th>
        <th>CSE on Job</th>
        <th>Customer Name</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="tx-color-03 tx-center">1</td>
        <td class="tx-medium">Henry Efe</td>
        <td class="tx-medium">SUP-9C401136</td>
        <td class="tx-medium">REF-79A722D6</td>
        <td class="text-medium">Completed</td>
        <td class="text-medium">PVC Pipe</td>
        <td class="text-medium">3</td>
        <td class="text-medium">3</td>
        <td class="text-medium">{{number_format(4000)}}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-23 17:09:23', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-24 11:15:30', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium"></td>
        <td class="text-medium text-info">NO</td>
        <td class="text-medium text-center">Benedict Olaoye</td>
        <td class="text-medium text-center">Kelvin Israel</td>
    </tr>

    <tr>
        <td class="tx-color-03 tx-center">2</td>
        <td class="tx-medium">James Godfrey</td>
        <td class="tx-medium">SUP-CBB42A2F</td>
        <td class="tx-medium">REF-66EB5A26</td>
        <td class="text-medium">Completed</td>
        <td class="text-medium">Condenser</td>
        <td class="text-medium">1</td>
        <td class="text-medium">1</td>
        <td class="text-medium">{{number_format(25000)}}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-02-15 10:00:00', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-16 15:35:12', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">Yes</td>
        <td class="text-medium text-success">No</td>
        <td class="text-medium text-center">Jackson Okoye</td>
        <td class="text-medium text-center">Wisdom Amana</td>
    </tr>

    </tbody>
</table>
