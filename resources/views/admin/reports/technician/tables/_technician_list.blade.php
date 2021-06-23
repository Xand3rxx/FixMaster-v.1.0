
<table class="table table-hover mg-b-0" id="basicExample2">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Territory</th>
        <th>Franchisee</th>
        <th>Onboarding Date</th>
        <th>Technician Status</th>
        <th>Technician Rating</th>
        <th>Last Activity Date</th>
        <th>No of Jobs in last X Months</th>

      </tr>
    </thead>
    <tbody>

      <tr>
        <td class="tx-color-03 tx-center">1</td>
        <td class="tx-medium">Kenneth Ifeanyi</td>
        <td class="tx-medium">Victorial Island</td>
        <td class="text-medium">Company</td>
        <td class="text-medium">{{ Carbon\Carbon::now('UTC') }}</td>
        <td class="text-medium text-center">Active</td>
        <td class="text-medium">6 stars</td>
        <td class="text-center">{{ Carbon\Carbon::now('UTC') }}</td>
        <td class="text-center">8</td>
      </tr>

    </tbody>
  </table>
