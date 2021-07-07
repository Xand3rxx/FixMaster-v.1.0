<div class="d-flex justify-content-center">
    @if(empty($rfqDetails->image))
        <img src="{{ asset('assets/images/no-image-available.png') }}" class="img-fluid wd-sm-200 rounded" alt="No image found">
    @elseif(!file_exists(public_path('assets/rfq-images/'.$rfqDetails->image)))
        <img src="{{ asset('assets/images/no-image-available.png') }}" class="img-fluid wd-sm-200 rounded" alt="No image found">
    @else
        <img src="{{ asset('assets/rfq-images/'.$rfqDetails->image) }}" class="img-fluid wd-sm-200 rounded" alt="{{ $rfqDetails->name }}">
    @endif
</div>