
<form method="POST" action="{{ route('admin.tools.update', ['tool'=>$tool->uuid, 'locale'=>app()->getLocale()]) }}">
    @csrf @method('PUT')
    <h5 class="mg-b-2"><strong>Editing {{ $tool->name }} Tool</strong></h5>
    <div class="form-row mt-4">
        <div class="form-group col-md-9">
            <label for="Name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name') ?? $tool->name }}" autocomplete="off" required>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-3">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" min="1" value="{{ old('quantity') ?? $tool->quantity }}" placeholder="Quantity" required>
            @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    
<form>
