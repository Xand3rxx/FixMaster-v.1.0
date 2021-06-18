<div class="modal fade" id="cancelRequest" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Cancel Job Request</h5> 
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20"  id="modal-body-assign">
            <form class="p-4" method="POST" id="cancel-request-form">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group position-relative">
                            <label>Kindly state the reason for cancelling this request.</label>
                            <textarea name="reason" id="reason" rows="3" class="form-control @error('reason') is-invalid @enderror" placeholder="">{{ old('reason')  }}</textarea>
                            @error('reason')
                                <x-alert :message="$message" />
                            @enderror
                        </div>
                    </div><!--end col-->

                    <div class="col-sm-12">
                    <button type="submit" class="submitBnt btn btn-primary">Submit</button>
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->
       
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->