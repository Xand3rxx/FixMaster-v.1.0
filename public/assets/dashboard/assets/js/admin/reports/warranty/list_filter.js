$(document).ready(function() {

  $('#sorting-parameters').on('change', function() {
    let option = $("#sorting-parameters").find("option:selected").val();
    switch (option) {
      case 'SortType1':
          $('.warranty-id-list').removeClass('d-none');
          $('.date-range, .service-id-list, .job-status, .lga-list').addClass('d-none');
          $("#job-status").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
        break
      case 'SortType2':
          $('.date-range').removeClass('d-none');
          $('.warranty-id-list, .job-status').addClass('d-none');
          $("#warranty-id-list, #job-status").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
        break
      case 'SortType3':
          $('.date-range').removeClass('d-none');
          $('.warranty-id-list, .job-status').addClass('d-none');
          $("#warranty-id-list, #job-status").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
        break
      case 'SortType4':
          $('.job-claims').removeClass('d-none');
          $('.warranty-id-list, .date-range, .service-id-list, .job-status, .lga-list,.category-list').addClass('d-none');
          $("#warranty-id-list").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
        break
      case 'SortType5':
          $('.service-id-list').removeClass('d-none');
          $('.warranty-id-list, .date-range,.lga-list,.job-claims').addClass('d-none');
          $("#warranty-id-list").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
        break

        case 'SortType6':
        $('.lga-list').removeClass('d-none');
        $('.warranty-id-list, .date-range, .service-id-list, .job-status,.job-claims').addClass('d-none');
        $("#lga-list").prop('selectedIndex', 0);
        $('#date-from, #date-to').val('');
      break
      case 'SortType7':
          $('.category-list').removeClass('d-none');
          $('.warranty-id-list, .date-range, .service-id-list, .job-status,.lga-list,.job-claims').addClass('d-none');
          $("#lga-list").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
        break
      case 'SortType8':
      $('.category-list').removeClass('d-none');
      $('.warranty-id-list, .date-range, .service-id-list, .job-status, .lga-list').addClass('d-none');
      $("#lga-list").prop('selectedIndex', 0);
      $('#date-from, #date-to').val('');
      break
      default:
          $('.warranty-id-list, .date-range, .job-status').addClass('d-none');
          $("#warranty-id-list, #job-status").prop('selectedIndex', 0);
        break;
    }
  });

  //SORT USER ID REPORT 
  $('#warranty-id-list').on('change', function() {
    //Get the User ID
    $userIdList = [];
    $userId = $(this).val();
    $userIdList.push($userId);
    // console.log($cseIdList);

    //Assign sorting level
    $sortLevel = 'SortType1';

    sortJobAssignedTable($sortLevel, $userIdList);

  });

  //SORT JOB ID REPORT 
  $('#service-id-list').on('change', function() {
      //Get the User ID
      $jobIdList = [];
      $jobId = $(this).val();
      $jobIdList.push($jobId);
    // console.log( $jobIdList, 'weddd');

      $sortLevel = 'SortType5';

      sortJobAssignedTable($sortLevel, $userId = null, $jobIdList, $lgaIdList =null);

    });


//SORT LGA ID REPORT 
$('.selectpicker.cs-select').on('change', function() {

  $lgaIdList = [];
  $lgaId = $(this).val();
  $lgaIdList.push($lgaId);
// console.log( $jobIdList, 'weddd');

  $sortLevel = 'SortType6';

  sortJobAssignedTable($sortLevel, $userId = null, $jobIdList= null, $lgaIdList);

});


//SORT CATEGORY ID REPORT 
$('#category-list').on('change', function() {

  $catIdList = [];
  $catId = $(this).val();
  $catIdList.push($catId);
// console.log( $jobIdList, 'weddd');

  $sortLevel = 'SortType7';

  sortJobAssignedTable($sortLevel, $userId = null, $jobIdList= null, $lgaIdList=null, $catIdList);

});


  //SORT CUSTOMER REPORT BY DATE RANGE
  $('#date-to').change(function() {

    //Assign sorting level
    $sortLevel = $('#sorting-parameters').val();
    //Get date from to sort activity log
    $dateFrom = $('#date-from').val();
    //Get date to, to sort activity log
    $dateTo = $('#date-to').val();

    if ($.trim($dateFrom).length == 0) {
      var message = 'Kindly select a date to start From.';
      var type = 'error';
      displayMessage(message, type);

    } else {
      sortJobAssignedTable($sortLevel,  $userId = null, $jobId=null, $lgaIdList =null,   $catIdList=null, $jobStatus = null, $dateFrom, $dateTo);
    }
  });

  //SORT CSE REPORT BY JOB STATUS
  $('#job-claims').change(function() {
    //Assign sorting level
    $sortLevel = $('#sorting-parameters').val();
    //Get date from to sort activity log
    $jobClaim = $('#job-claims').val();

    sortJobAssignedTable($sortLevel,  $userId = null, $jobStatus=null, $jobId=null,   $catIdList=null,  $jobClaim=null , $dateFrom = null, $dateTo = null);
  });

});

function sortJobAssignedTable($sortLevel,  $userId = null, $jobId = null, $lgaIdList =null,  $catIdList=null,  $jobClaim=null , $jobStatus = null, $dateFrom = null, $dateTo = null) {
  //Get sorting route
  $route = $('#route').val();
  const $date = {
    "date_from": $dateFrom,
    "date_to": $dateTo
  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: $route,
    method: 'POST',
    data: {"sort_level": $sortLevel, "user_id": $userId,  "jobId": $jobId, "lgaId":$lgaIdList, "catIdList":  $catIdList,"job_status": $jobStatus, "jobClaims": $jobClaim, "date": $date},
    beforeSend: function() {
      $("#job-assigned-sorting").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
    },
    success: function(data) {
      
      // return false;
      if (data) {

         $('#extended_warranty_claim_list').removeClass('show, active');

        //Replace table with new sorted records
        $('#job-assigned-sorting').html('');
        $('#job-assigned-sorting').html(data);

        //Add sorting class for jQuery datatable
        $('#basicExample').addClass('basicExample');

        //Attach JQuery datatable to current sorting
        if ($('#basicExample').hasClass('basicExample')) {
          jQuerySort();
        }
      } else {
        var message = 'Error occured while trying to sort Job Assigned table.';
        var type = 'error';
        displayMessage(message, type);
      }
    },
    error: function() {
      var message = 'Kindly select at least one parameter for filtering.';
      var type = 'error';
      displayMessage(message, type);

    setTimeout(() => {
      location.reload();
    }, 1000);
    
    }
  });
}

function jQuerySort() {
  $('.basicExample').DataTable({
    'iDisplayLength': 10,
    language: {
      searchPlaceholder: 'Search...',
      sSearch: '',
      lengthMenu: '_MENU_ items/page',
    }
  })
}
