@foreach($service['subServices'] as $subService)
    <div class="form-row mt-4">
    <div class="form-group col-md-3">
        <label for="sub_service_name">Sub Service Name</label>
        <input type="text" class="form-control @error('sub_service_name') is-invalid @enderror" name="sub_service_name[]" id="sub_service_name" placeholder="Name" value="{{ old('sub_service_name') ?? !empty($subService->name) ? $subService->name : 'UNAVAILABLE' }}" autocomplete="off">
        @error('sub_service_name')
            <x-alert :message="$message" />
        @enderror
    </div>
    
    <div class="form-group col-md-3">
        <label for="labour_cost">Labour Cost(₦)</label>
        <input type="number" min="1" maxlength="5" class="form-control @error('labour_cost') is-invalid @enderror" name="labour_cost[]" id="labour_cost" placeholder="Labour Cost" value="{{ old('labour_cost[0]') ?? !empty($subService->labour_cost) ? $subService->labour_cost : '0' }}" autocomplete="off">
        @error('labour_cost[0]')
            <x-alert :message="$message" />
        @enderror
    </div>

    <div class="form-group col-md-3">
        <label for="cost_type">Cost Type</label>
        <select class="custom-select @error('cost_type') is-invalid @enderror" name="cost_type[]">
            <option selected value="">Select...</option>
            <option value="Fixed" {{ old('cost_type, []') == 'Fixed' ? 'selected' : ''}} @if($subService->cost_type == 'Fixed') selected @endif>Fixed</option>
            <option value="Variable" {{ old('cost_type, []') == 'Variable' ? 'selected' : ''}} @if($subService->cost_type == 'Variable') selected @endif>Variable</option>
        </select>
        @error('cost_type, []')
        <x-alert :message="$message" />
        @enderror
    </div>
    <div class="form-group col-md-3">
        <a data-url="{{ route('admin.services.delete_sub_service', ['subService'=>$subService->uuid, 'locale'=>app()->getLocale()]) }}" class="delete-entity" title="Delete {{ $subService->name}}"><i class="fas fa-times text-danger" style="margin-top: 2.5rem !important;"></i></a>
    </div>

    <input type="hidden" class="d-none" name="sub_service_id[]" id="sub_service_id"  autocomplete="off" value="{{ json_encode($subService->id, TRUE)}}">
    
    </div>
    @endforeach

    <span class="add-new-sub-service"></span>