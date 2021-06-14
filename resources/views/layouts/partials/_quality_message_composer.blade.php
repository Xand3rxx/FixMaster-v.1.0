
<?php
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Technician;

//     $technician = Technician::where('user_id', Auth::id())->first();
//     $serviceRequests = $technician->requests;
//         $ongoingJobs = $technician->requests()
//                         ->where('service_request_status_id', '>', '3')
//                         ->get();

?>
<style type="text/css">
  .hideDiv{
    display: none;
  }
</style>

<div class="modal fade" id="technicianMessageComposer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg wd-sm-650" role="document">
      <div class="modal-content">
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
          <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <h5 class="mg-b-2"><strong>Send Message</strong></h5>
          <form method="POST" action="javascript:void(0)" accept-charset="UTF-8" class="form-horizontal" >
            {{ csrf_field() }}
          <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Select User </label>
                    <input type="hidden" id="currentuser" value="{{ Auth::id() }}" />

                    <select class="custom-select"  id="recipient_id" name="recipient_id" onchange="ongoingJobsEvent(this.value)">
                      <option value="" selected>Select...</option>
                      <option value="4">Fix Master</option>
                      <option value="jobs" >Ongoing Jobs</option>
                    </select>
                </div>
            </div><!--end col-->

              <div class="col-md-12" id = "ongoingJobs" hidden>
                  <div class="form-group">
                      <label>Ongoing Jobs</label>
                      <select id = "jobsId" class="custom-select" name="" onchange="getInvolvedUsers(this.value, $('#currentuser').val())">


                      </select>
                  </div>
              </div><!--end col-->


              <div class="col-md-12" id = "assoc_users" hidden>
                <div class="form-group">
                    <label>Recipients</label>
                    <select id = "users" class="custom-select" name="" multiple>


                    </select>
                </div>
            </div><!--end col-->
  

            <div class="form-group col-md-12">
                <label for="inputEmail4">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject">
            </div>

            <div class="form-group col-md-12">
              <label for="message_body">Message</label>
              <textarea rows="4" class="form-control" id="messageBody" name="message"></textarea>
            </div>

           <div class="form-group col-md-12">
            <button type="submit" class="btn btn-primary " id="Send-Message">Send Message</button>
           </div>
        </div>
          </form>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<script>
  $(document).ready(function(){
    $('#messageBody').val(data);
  })
  
</script>


