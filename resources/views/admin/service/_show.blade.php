<div class="d-md-block float-right">
    <a href="{{ route('admin.services.edit', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    @if($category->status == 0)
        <a href="#" data-url="{{ route('admin.services.reinstate', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-success"><i class="fas fa-undo"></i> Reinstate</a>
    @else
        <a href="#" data-url="{{ route('admin.services.deactivate', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" title="Deactivate {{ $category->name}}" class="btn btn-primary deactivate-entity"><i class="fas fa-ban"></i> Deactivate</a>
    @endif
    <a href="#" data-url="{{ route('admin.services.delete', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" title="Delete {{ $category->name}}" class="btn btn-danger delete-entity"><i class="fas fa-trash"></i> Delete</a>
</div>

<h5>{{ $category->name }} Category</h5>

@if(empty($category->image))
    <img src="{{ asset('assets/images/no-image-available.png') }}" class="wd-sm-200 rounded" alt="No image found">

@elseif(!file_exists(public_path('assets/service-images/'.$category->image)))
    <img src="{{ asset('assets/images/no-image-available.png') }}" class="wd-sm-200 rounded" alt="No image found">
@else
    <img src="{{ asset('assets/service-images/'.$category->image) }}" class="wd-sm-200 rounded" alt="{{ $category->name }}">
@endif
<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Name</td>
            <td class="tx-color-03" width="75%">{{ $category->name }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Category</td>
            <td class="tx-color-03" width="75%">{{ $category->category->name }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Service Charge</td>
            <td class="tx-color-03" width="75%">₦{{ $category->service_charge }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Created By</td>
            <td class="tx-color-03" width="75%">{{ $category->user->email }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Status</td>
            @if(empty($category->deleted_at)) 
                <td class="text-success" width="75%">Active</td>
            @else
                <td class="text-danger" width="75%">Inactive</td>
            @endif
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Requests</td>
            <td class="tx-color-03" width="75%">{{ $category->serviceRequests->count() }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Description</td>
            <td class="tx-color-03" width="75%">{{ $category->description }}</td>
        </tr>

        <tr>
            <td class="tx-medium" width="25%">Sub Services</td>
            <td class="tx-color-03" width="75%">
                @foreach ($category->subServices as $subService)
                    ({{$loop->iteration}}) {{ $subService->name }}<br>
                @endforeach
            </td>
        </tr>
    </tbody>
    </table>
</div>
