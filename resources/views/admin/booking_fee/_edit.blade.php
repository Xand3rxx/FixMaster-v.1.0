<form method="POST" action="{{ route('admin.booking-fees.update', ['booking_fee'=>$bookingFee->uuid, 'locale'=>app()->getLocale()]) }}">
        @csrf @method('PUT')
    <h5 class="mg-b-2"><strong>Editing "{{ $bookingFee->name }}" Booking Fee</strong></h5>
    <hr>
    <div class="form-row mt-4">
      <div class="form-group col-md-12">
        <div class="form-row mt-4">
          <div class="form-group col-md-6">
              <label for="name">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') ?? $bookingFee->name }}"  autocomplete="off">
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>

          <div class="form-group col-md-6">
              <label for="amount">Amount</label>
              <input type="number" class="form-control amount @error('amount') is-invalid @enderror" name="amount"  id="amount" placeholder="amount" value="{{ old('amount') ?? $bookingFee->amount }}" autocomplete="off">
              @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>

      </div>
      
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputEmail4">Description(Optional)</label>
          <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') ?? $bookingFee->description }}</textarea>
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