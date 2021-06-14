<form method="POST" action="{{ route('admin.services.update', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
  {{-- <h5 class="mg-b-2"><strong>Editing {{ $category->name }} Service</strong></h5> --}}
  <div class="form-row mt-4"></div>

  <div class="row row-xs">
    <div class="col-md-12">
      <div class="form-row">
          <div class="form-group col-md-3">
              <label for="name">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') ?? $category->name }}" autocomplete="off">
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>
          <div class="form-group col-md-3">
            <label>Service</label>
            <select class="custom-select @error('category_id') is-invalid @enderror" name="category_id">
              <option selected value="">Select...</option>
              @foreach($categories as $item)
                @if($item->id != 1)
                    <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : ''}} @if($category->category_id == $item->id) selected @endif>{{ $item->name }}</option>
                @endif
              @endforeach
            </select>
            @error('category_id')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="service_charge">Service Charge</label>
            <input type="number" min="1" maxlength="7" class="form-control @error('service_charge') is-invalid @enderror" name="service_charge" id="service_charge" placeholder="Service Charge" value="{{ old('service_charge') ?? $category->service_charge }}" autocomplete="off">
            @error('service_charge')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>
          <div class="form-group col-md-3">
            <label>Category Cover Image</label>
            <div class="custom-file">
              <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image">
            <label class="custom-file-label" id="new-image-name" for="image">Upload Cover Image</label>
              <input type="hidden" id="old-post-image" name="old_post_image" value="{{ $category->image }}">
            </div>
            <small class="text-muted">Current Image: {{ $category->image }}</small>
            @error('image')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          
      </div>
      
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputEmail4">Description</label>
          <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') ?? $category->description }}</textarea>
          @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </div>
</form>