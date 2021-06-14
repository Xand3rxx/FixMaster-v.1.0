{{-- @if (is_null($service_request['preferred_time'])) --}}
<h3>Scheduled Date</h3>
<section>
    <div class="mt-4 form-row">
        <div class="form-group col-md-12">
            <label for="preferred_time">Scheduled Date</label>
            <input required id="service-date-time" type="text" readonly
                min="{{ \Carbon\Carbon::today()->isoFormat('2021-04-13') }}"
                class="form-control @error('preferred_time') is-invalid @enderror" name="preferred_time"
                placeholder="Click to Enter Scheduled Date" value="{{ !empty($service_request['preferred_time']) ? $service_request['preferred_time']->isoFormat('Y/MM/DD') : old('preferred_time') }}">

            @error('preferred_time')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</section>
