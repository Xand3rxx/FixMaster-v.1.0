<div id="serviceRequestProgress" class="tab-pane pd-20 pd-xl-25">
    <div class="divider-text">Service Request Progress</div>
    <h5 class="mt-4">Service Request Progress</h5>
    <div class="table-responsive mb-4">
        <table class="table table-hover mg-b-0" id="basicExample">
            <thead class="">
                <tr>
                    <th class="text-center">#</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th class="text-center">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($serviceRequest['serviceRequestProgresses'] as $progress)
                    <tr>
                        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                         {{-- <td class="tx-medium">
                           {{ Str::title($progress['user']['account']['last_name'] . ' ' . $progress['user']['account']['first_name']) }} 
                            ({{ $progress['user']['roles'][0]['name'] }})</td> --}}
                            <td class="tx-medium">
                                {{ Str::title($progress['user']['account']['first_name'] . ' ' . $progress['user']['account']['last_name']) }}</td>
                        <td class="tx-medium text-success">
                            {{ $progress['substatus']['name'] }} </td>
                        <td class="text-center">
                            {{ Carbon\Carbon::parse($progress['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- table-responsive -->
</div>