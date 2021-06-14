
<form method="POST" action="{{ route('admin.statuses.update', ['status'=>$subStatus->uuid, 'locale'=>app()->getLocale()]) }}">
    @csrf @method('PUT')
    <h5 class="mg-b-2"><strong>Editing "{{ !empty($subStatus->name) ? $subStatus->name : 'UNAVAILABLE' }}" Sub-Status</strong></h5>

    <div class="form-row mt-4">
        <div class="form-group col-md-12">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? !empty($subStatus->name) ? $subStatus->name : 'UNAVAILABLE' }}" placeholder="Name" autocomplete="off">
            @error('name')
                <x-alert :message="$message" />
            @enderror
        </div>
        <div class="form-group col-md-12">
        <label>Recurrence</label>
        <select class="custom-select @error('recurrence') is-invalid @enderror" name="recurrence">
            <option selected value="">Select...</option>
            <option value="Yes" @if($subStatus->recurrence == 'Yes') selected @endif {{ old('recurrence') == $subStatus->recurrence ? 'selected' : ''}}>Yes</option>
            <option value="No" @if($subStatus->recurrence == 'No') selected @endif {{ old('recurrence') == $subStatus->recurrence ? 'selected' : ''}}>No</option>
        </select>
        <small class="text-muted">Will the status reoccur?</small>
        @error('recurrence')
            <x-alert :message="$message" />
        @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Sub-Status</button>
    </div>
</form>
