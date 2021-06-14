<?php
use App\Models\User;
use App\Models\CSE;

        $cse = CSE::where('user_id', Auth::id())->first();
        $serviceRequests = $cse->requests;
        $ongoingJobs = $cse->requests()
                ->where('service_request_status_id', '>', '3')
                ->get();
?>
<style type="text/css">
  .hideDiv{
    display: none;
  }
</style>

<div class="modal fade" id="cseMessageComposer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg wd-sm-650" role="document">
      <div class="modal-content">
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
          <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <h5 class="mg-b-2"><strong>Send Message</strong></h5>
          <form method="POST" action="{{route('cse.save-message-data')}}" accept-charset="UTF-8" class="form-horizontal" >
            {{ csrf_field() }}
          <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Select User</label>
                    <select class="custom-select" name="recipient_id" onchange="updateReciever(this.value)">
                      <option value="" selected>Select...</option>
                      <option value="4">Fix Master</option>
                      <option value="" >Ongoing Jobs</option>
                    </select>
                </div>
            </div><!--end col-->

            <div class="col-md-12 specific-date hideDiv" id="job-ref" >
                <div class="form-group position-relative ">
                    <label>Ongoing Jobs List</label>
                    <select class="custom-select" id="jobReference" name="jobReference" onchange="updateRecieverList(this.value)">
                      <option value="" selected>Select Job Reference</option>
                      @foreach ($ongoingJobs as $item)
                        <option value="{{$item->id}}">{{$item->job_reference}} </option>
                      @endforeach
                   </select>                  
                </div>
            </div>

            <div class="col-md-12 specific-date hideDiv" id="Recipient">
              <div class="form-group position-relative ">
                  <label>Select Recipient</label>
                  <select class="custom-select" name="selectedReciever" id="assigned">
                      <option value="" selected>Select...</option>
                  </select>
              </div>
            </div>

            <div class="form-group col-md-12">
                <label for="inputEmail4">Subject</label>
                <input type="text" class="form-control" id="inputEmail4" name="subject">
            </div>

            <div class="form-group col-md-12">
              <label for="message_body">Message</label>
              <textarea rows="4" class="form-control" id="messageBody" name="message"></textarea>
            </div>

            <button type="submit" class="btn btn-primary hideDiv" id="Send-Message">Send Message</button>

        </div>
          </form>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


