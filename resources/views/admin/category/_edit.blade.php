
<form method="POST" action="{{ route('admin.categories.update', ['category'=>$category->uuid, 'locale'=>app()->getLocale()]) }}">
    @csrf @method('PUT')
    <h5 class="mg-b-2"><strong>Editing {{ !empty($category->name) ? $category->name : 'UNAVAILABLE' }} Category</strong></h5>
    <hr>
    <div class="form-row mt-4">
    <div class="form-group col-md-12">
        <label for="name">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? !empty($category->name) ? $category->name : 'UNAVAILABLE' }}" placeholder="Name" autocomplete="off">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group col-md-12">
        <label for="labour_markup">Labour Markup</label>
        <input type="number" class="form-control @error('labour_markup') is-invalid @enderror" id="labour_markup" name="labour_markup" value="{{ old('labour_markup') ?? !empty($category->labour_markup) ? $category->labour_markup*100 : 'UNAVAILABLE' }}" placeholder="Labour Markup" autocomplete="off">
        @error('labour_markup')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group col-md-12">
        <label for="material_markup">Material Markup</label>
        <input type="number" class="form-control @error('material_markup') is-invalid @enderror" id="material_markup" name="material_markup" value="{{ old('material_markup') ?? !empty($category->material_markup) ? $category->material_markup*100 : 'UNAVAILABLE' }}" placeholder="Material Markup" autocomplete="off">
        @error('material_markup')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
<form>
