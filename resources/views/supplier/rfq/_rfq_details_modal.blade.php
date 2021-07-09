<div class="modal fade" id="rfqDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel2">Request For Qoute Details</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body">
            <!-- Modal displays here -->
            <div id="spinner-icon"></div>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="rfqImageDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered wd-sm-650" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel2">Image Viewer</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-image-body">
            <!-- Modal displays here -->
            <div id="spinner-icon"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="dispatchModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered wd-sm-650" role="document">
      <div class="modal-content">
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
          <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <form method="POST" action="{{ route('supplier.store_dispatch', app()->getLocale()) }}">
            @csrf
            <h5 class="mg-b-2"><strong>Label <span id="rfq-label"></span></strong></h5>
            <div class="form-row mt-4">
              <div class="form-group col-md-10">
                  <label for="unique_id">Delivery Code</label>
                  <input type="text" class="form-control @error('unique_id') is-invalid @enderror" id="unique_id" name="unique_id" placeholder="Click the generate button" value="{{ old('unique_id') }}" autocomplete="off" readonly required>
                  @error('unique_id')
                    <x-alert :message="$message" />
                  @enderror
              </div>
              <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary generate-new-code" style="margin-top: 2rem !important;" title="Generate code"><i class="fas fa-sync"></i></button>
                <input type="hidden" class="d-none" data-url="{{ route('supplier.generate_dispatch_code', app()->getLocale()) }}" id="generate-dispatch-code">

                <input type="hidden" class="d-none" name="rfq" id="rfq">
                <input type="hidden" class="d-none" name="rfq_id" id="rfq_id">
                <input type="hidden" class="d-none" name="rfq_supplier_invoice" id="supplier_rfq_id">
                
              </div>

              <div class="form-group col-md-12">
                <label for="courier_name">Courier Name</label>
                  <input type="text" class="form-control @error('courier_name') is-invalid @enderror" id="courier_name" name="courier_name" placeholder="Courier Name" value="{{ old('courier_name') }}" autocomplete="off" required>
                  @error('courier_name')
                    <x-alert :message="$message" />
                  @enderror
              </div>

              <div class="form-group col-md-12">
                <label for="courier_phone_number">Courier Phone Number</label>
                <input type="tel" class="form-control @error('courier_phone_number') is-invalid @enderror" id="phone_number" name="courier_phone_number" maxlength="11" value="{{ old('courier_phone_number') }}" placeholder="Courier Phone Number" autocomplete="off">
                @error('courier_phone_number')
                  <x-alert :message="$message" />
                @enderror
              </div>

              <div class="form-group col-md-12">
                <label for="delivery_medium">Delivery Medium</label>
                <select name="delivery_medium" id="delivery_medium" class="form-control @error('delivery_medium') is-invalid @enderror" required>
                  <option value="">Select...</option>
                  <option value="Airplane">Airplane</option>
                  <option value="Bicycle">Bicycle</option>
                  <option value="Car">Car</option>
                  <option value="Motorcycle">Motorcycle</option>
                  <option value="Pickup Truck/Van">Pickup Truck/Van</option>
                  <option value="Ship/Ferry/Boat">Ship/Ferry/Boat</option>
                  <option value="Train">Train</option>
                  <option value="Third-party Courier Service">Third-party Courier Service</option>
                </select>
              @error('delivery_medium')
                <x-alert :message="$message" />
              @enderror
              </div>
              
              <div class="form-group col-md-12">
                <label for="comment">Comment<span class="text-danger">(Optional)</span></label>
                <textarea rows="3" class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment">{{ old('comment') }}</textarea>
                @error('comment')
                  <x-alert :message="$message" />
                @enderror
              </div>

              <button type="submit" class="btn btn-primary">Dispatch</button>
            </div>
          </form>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  
@push('scripts')
<script src="{{ asset('assets/dashboard/assets/js/a784c9e7-4015-44df-994d-50ffe4921458.js') }}"></script>
@endpush