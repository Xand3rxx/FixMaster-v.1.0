<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
        <tr>
            <th class="text-center">#</th>
            <th>Name</th>
            <th class="text-center">Parent Status</th>
            <th>Created By</th>
            <th class="text-center">Recurrence</th>
            <th>Status</th>
            <th>Date Created</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subStatuses as $subStatus )
        <tr>
            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
            <td class="tx-medium">{{ !empty($subStatus->name) ? $subStatus->name : 'UNAVAILABLE' }}</td>
            <td class="tx-medium text-center">{{ $subStatus['parentStatus']['name'] }}</td>
            <td>{{ !empty($subStatus->user->email) ? $subStatus->user->email : 'UNAVAILABLE' }}</td>
            <td class="tx-medium text-center">{{ $subStatus->recurrence }}</td>

            @if($subStatus->status == 'active')
            <td class="text-success">Active</td>
            @else
            <td class="text-danger">Inactive</td>
            @endif
            <td>{{ Carbon\Carbon::parse($subStatus->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') ?? Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            <td class=" text-center">
                @if(!empty($subStatus->name))
                <div class="dropdown-file">
                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if($subStatus->recurrence == 'Yes' )
                            <a href="#editService" data-toggle="modal" id="service-edit" title="Edit {{ $subStatus->name }}" data-url="{{ route('admin.statuses.edit',[app()->getLocale(), $subStatus->uuid] ) }}" data-service-name="{{ $subStatus->name }}" data-id="{{ $subStatus->uuid }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>
                        @endif
                        @if($subStatus->status == 'active' )
                            <a data-url="{{ route('admin.statuses.deactivate',[app()->getLocale(), $subStatus->uuid] ) }}" class="dropdown-item details text-warning deactivate-entity" title="Deactivate {{ $subStatus->name}}" style="cursor: pointer;"><i class="fas fa-ban"></i> Deactivate</a>
                        @else
                            <a href="{{ route('admin.statuses.reinstate', ['status'=>$subStatus->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Reinstate {{ $subStatus->name}}"><i class="fas fa-undo"></i> Reinstate</a>
                        @endif
                        <a data-url="{{ route('admin.statuses.delete', [app()->getLocale(), $subStatus->uuid] ) }}" class="dropdown-item delete-entity text-danger" title="Delete {{ $subStatus->name}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Delete</a>
                    </div>
                </div>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
