
{{-- {{ dd($results)}} --}}
<table class="table table-hover mg-b-0" id="basicExample2">
    <thead class="thead-primary">
      <tr>
        <th>Name</th>
        <th>Territory</th>
        <th>Current Rating</th>
        <th>Rating Last Month</th>
        <th>Rating Last Quarter</th>
        <th>Notable Feedback</th>
        <th>Job ID</th>
        <th>Job Rating</th>

      </tr>
    </thead>
    <tbody>

      {{-- @foreach ($results as $result) --}}
      <tr>
        <td class="tx-medium">Jamal Diwa</td>
        <td class="tx-medium">Victorial Island</td>
        <td class="text-medium">5 stars</td>
        <td class="text-medium">3 stars</td>
        <td class="text-medium text-center">4 Stars</td>
        <td class="text-medium">-</td>
        <td class="text-center">REF-EEE7FD14	</td>
        <td class="text-center">3stars</td>
      </tr>
      {{-- @endforeach --}}

    </tbody>
  </table>
