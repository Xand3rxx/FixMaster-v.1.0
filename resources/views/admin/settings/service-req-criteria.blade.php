@extends('layouts.dashboard')
@section('title', 'Service Request Criteria')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Rating</li>
              <li class="breadcrumb-item active" aria-current="page">Service Request Setting</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Service Request Setting</h4>
        </div>
      </div>

      <input type="hidden" id="path_admin" value="{{url('/')}}">

      <div class="row row-xs">
       
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <!-- <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
               
              </div> -->
              <!-- card-header -->
             
              <div class="table-responsive">
                
              <div id="sort_table">
                  @include('admin.settings._service-req-criteria')
                </div>

              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

<div class="modal fade" id="serviceCategoryDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel2">Service Category Details</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>Mobile Phone Service</h5>
            <div class="table-responsive mt-4">
              <table class="table table-striped table-sm mg-b-0">
                <tbody>
                  <tr>
                    <td class="tx-medium">Name</td>
                    <td class="tx-color-03">Mobile Phone</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Service</td>
                    <td class="tx-color-03">Communication</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Status</td>
                    <td class="tx-color-03">Active</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Standard Fee</td>
                    <td class="tx-color-03">₦3,000</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Urgent Fee</td>
                    <td class="tx-color-03">₦5,000</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">OOH(Out of Hours) Fee</td>
                    <td class="tx-color-03">₦7,500</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Requests</td>
                    <td class="tx-color-03">8</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">CSE's</td>
                    <td class="tx-color-03">2</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Technicians</td>
                    <td class="tx-color-03">3</td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
</div>



   <!-- Modal with form -->
   <div class="modal fade" id="editmenuitem" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Edit Criteria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
               <form name="menu_form_category" action="{{url('update_menu_item')}}" method="post" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <input type="hidden" name="id" id="id">
                  <input type="hidden" name="real_image" id="real_image">
                  <div class="form-group">
                     <label>Select Status</label>
                     <select class="form-control" name="category" id="category" required>                        
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>                        
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Radius</label>
                     <input type="number" class="form-control" placeholder="Enter Radius" id="radius" name="Radius" required>
                  </div>
                  <div class="form-group">
                     <label>Max Job a CSE can accept</label>
                     <input type="number" class="form-control" placeholder="Max ongoing jobs" id="max_ongoing_jobs" name="max_ongoing_jobs"  required>
                  </div>
                  <div class="col-md-12">
                       <button id="payment-button" type="submit" class="btn btn-primary btn-md form-control">
                         Update
                       </button>
                  </div>
               </form>
            </div>
      </div>
    </div>
  </div>

  
  @section('scripts')
<script>
   
   // Edit item
function editCriteria(id){
  // console.log('hello denk');

   $.ajax( {
         url: "{{ route('getServiceDetails', app()->getLocale()) }}" + '/' + id,
         responseData: { },
         success: function( responseData ) {
             console.log(responseData);
            //  {{ route('getServiceDetails', app()->getLocale()) }}
            // {{ route('getServiceDetails',"+id+") }}
            //    $("#id").val(responseData.id);
            //    $('#name').val(responseData.menu_name);
            //    $('#category').val(responseData.category);
            //    $('#price').val(responseData.price);           
         }
    }); 
}


</script>
@endsection

@endsection