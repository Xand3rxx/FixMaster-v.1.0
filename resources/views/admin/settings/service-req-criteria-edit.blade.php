<form action="{{ route('admin.service-request-settings.update', ['service_request_setting'=>$setting->uuid, 'locale'=>app()->getLocale()]) }}" method="POST">
    @method('PUT') @csrf
    <div class="form-group">
        <label>Radius</label>
        <input type="number" class="form-control @error('radius') is-invalid @enderror" placeholder="Enter Radius" id="radius" name="radius" value="{{ old('radius') ?? $setting->radius }}" required>
        @error('radius')
            <x-alert :message="$message" />
        @enderror
    </div>
    <div class="form-group">
        <label>Max. Job a CSE can accept</label>
        <input type="number" class="form-control @error('max_ongoing_jobs') is-invalid @enderror" placeholder="Max ongoing jobs" id="max_ongoing_jobs" name="max_ongoing_jobs" maxlength="2" value="{{ old('max_ongoing_jobs') ?? $setting->max_ongoing_jobs }}" required>
        @error('max_ongoing_jobs')
            <x-alert :message="$message" />
        @enderror
    </div>
      <button type="submit" class="btn btn-primary">Update</button>
  </form>