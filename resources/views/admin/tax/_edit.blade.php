<form method="POST" action="{{ route('admin.taxes.update', ['tax'=>$tax->uuid, 'locale'=>app()->getLocale()]) }}">
        @csrf @method('PUT')
    <h5 class="mg-b-2"><strong>Editing "{{ $tax->name }}" Tax</strong></h5>
    <hr>
    <div class="form-row mt-4">
      <div class="form-group col-md-12">
        <div class="form-row mt-4">
          <div class="form-group col-md-4">
              <label for="name">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') ?? $tax->name }}"  autocomplete="off">
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>

          <div class="form-group col-md-4">
              <label for="percentage">Percentage(%)</label>
              <input type="text" class="form-control @error('percentage') is-invalid @enderror" name="percentage" min="1" max="100" maxlength="5" id="percentage" placeholder="Percentage" value="{{ old('percentage') ?? $tax->percentage }}" autocomplete="off">
              @error('percentage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>

          <div class="form-group col-md-4">
            <label>Apply</label>
            <select class="custom-select @error('applicable') is-invalid @enderror" name="applicable">
              <option selected value="">Select...</option>
              <option value="1" {{ old('applicable') == '1' ? 'selected' : ''}} @if($tax->applicable == 1)@ selected else @endif>Yes</option>
              <option value="0" {{ old('applicable') == '0' ? 'selected' : ''}} @if($tax->applicable == 0)@ selected else @endif>No</option>
            </select>
            <small class="text-danger">If "Apply" is set to yes, other taxes will be set to no</small>
            @error('applicable')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
      </div>
      
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputEmail4">Description(Optional)</label>
          <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') ?? $tax->description }}</textarea>
          @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>