<div class="d-flex justify-content-center">
    @if(empty($rfqDetails->image))
        <img src="{{ asset('assets/images/no-image-available.png') }}" class="img-fluid wd-sm-200 rounded" alt="No image found">
    {{-- @elseif(!file_exists(asset('storage/'.$rfqDetails->image)))
        <img src="{{ asset('assets/images/no-image-available.png') }}" class="img-fluid wd-sm-200 rounded" alt="No image found"> --}}
    @else
        <img src="{{ asset('storage/'.$rfqDetails->image) }}" class="img-fluid rounded" alt="{{ $rfqDetails->name }}">
    @endif
</div>