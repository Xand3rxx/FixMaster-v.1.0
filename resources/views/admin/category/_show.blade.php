
<h5>Services assigned to <strong>"{{ $categoryName }}"</strong> Category</h5>
<div class="table-responsive mt-4">
    <table class="table table-hover mg-b-0" id="basicExample">
        <thead class="thead-primary">
        <tr>
            <th class="text-center">#</th>
            <th>Name</th>
            <th class="text-center">Requests</th>
            <th class="text-center">Rating</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($categoryServices as $categoryService)
            <tr>
                <td width="5%" class="tx-color-03 tx-center">{{ ++$i }}</td>
                <td width="25%" class="tx-medium">{{ !empty($categoryService->name) ? $categoryService->name : 'UNAVAILABLE' }}</td>
            <td width="5%" class="tx-medium text-center">{{ $categoryService->serviceRequests->count() ?? '0' }}</td>
                <td width="5%" class="tx-medium text-center">0</td>
                <td width="65%" class="tx-medium">{{ !empty($categoryService->description) ?$categoryService->description : 'No description found' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div><!-- table-responsive -->