{{-- <div class="d-flex mb-2"><small class="text-danger">In other to delete this Service, you need to reassing every Category assigned to it.</small></div> --}}
<div id="spinner-icon-4"></div>

<h5>Services assigned to <strong>"{{ $categoryName }}"</strong> Category</h5>
<div class="table-responsive mt-4">
    <table class="table table-hover mg-b-0" id="basicExample">
        <thead class="thead-primary">
        <tr>
            <th width="5%" class="text-center">#</th>
            <th width="20%">Name</th>
            <th wwidth="5%" class="text-center">Requests</th>
            <th width="40%">Description</th>
            <th width="30%">Reassign</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($categoryServices as $serviceDetail)
            <tr>
                <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                <td class="tx-medium">{{ $serviceDetail->name }}</td>
                <td class="tx-medium text-center">0</td>
                <td class="tx-medium">{{ $serviceDetail->description }}</td>
                <td>
                    <select class="custom-select" id="reassign-category-service">
                        <option selected value="None">Select...</option>
                        @foreach ($categories as $category)
                            @if($category->uuid != $categoryId AND $category->uuid != 1)
                                <option value="{{ $category->uuid }}" data-category-name="{{ $category->name }}" data-category-id="{{ $category->id }}" data-service-id="{{ $serviceDetail->id }}" data-service-name="{{ $serviceDetail->name }}" data-url="{{ route('admin.categories.reassign_service', app()->getLocale()) }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                        
                    </select>
                </td>
            </tr>
            @endforeach
        

        </tbody>
    </table>
</div><!-- table-responsive -->
