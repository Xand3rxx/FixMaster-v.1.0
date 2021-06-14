$(document).ready(function() {

    $('#sorting-parameters').on('change', function() {
      let option = $("#sorting-parameters").find("option:selected").val();
      switch (option) {
        case 'SortType1':
            $('.cse-list').removeClass('d-none');
            $('.date-range, .job-status').addClass('d-none');
            $("#job-status").prop('selectedIndex', 0);
            $('#date-from, #date-to').val('');
          break
        case 'SortType2':
            $('.date-range').removeClass('d-none');
            $('.cse-list, .job-status').addClass('d-none');
            $("#cse-list, #job-status").prop('selectedIndex', 0);
            $('#date-from, #date-to').val('');
          break
        case 'SortType3':
            $('.date-range').removeClass('d-none');
            $('.cse-list, .job-status').addClass('d-none');
            $("#cse-list, #job-status").prop('selectedIndex', 0);
            $('#date-from, #date-to').val('');
          break
        case 'SortType4':
            $('.job-status').removeClass('d-none');
            $('.cse-list, .date-range').addClass('d-none');
            $("#cse-list").prop('selectedIndex', 0);
            $('#date-from, #date-to').val('');
          break
        default:
            $('.cse-list, .date-range, .job-status').addClass('d-none');
            $("#cse-list, #job-status").prop('selectedIndex', 0);
          break;
      }
    });

    //SORT CSE REPORT BY CSE ID
    $('#cse-list').on('change', function() {
      //Get the User ID
      $cseIdList = [];
      $cseId = $(this).val();
      $cseIdList.push($cseId);
      // console.log($cseIdList);

      //Assign sorting level
      $sortLevel = 'SortType1';

      sortJobAssignedTable($sortLevel, $cseIdList);

    });

    //SORT CSE REPORT BY DATE RANGE
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
        sortJobAssignedTable($sortLevel, $cseId = null, $jobStatus = null, $dateFrom, $dateTo);
      }
    });

    //SORT CSE REPORT BY JOB STATUS
    $('#job-status').change(function() {

      //Assign sorting level
      $sortLevel = $('#sorting-parameters').val();
      //Get date from to sort activity log
      $jobStatus = $('#job-status').val();

      sortJobAssignedTable($sortLevel, $cseId = null, $jobStatus, $dateFrom = null, $dateTo = null);
    });

});

  function sortJobAssignedTable($sortLevel, $cseId = null, $jobStatus = null, $dateFrom = null, $dateTo = null) {
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
      data: {"sort_level": $sortLevel, "cse_id": $cseId, "job_status": $jobStatus, "date": $date},
      beforeSend: function() {
        $("#job-assigned-sorting").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
      },
      success: function(data) {
        console.log(data);
        // return false;
        if (data) {
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
      }
    });
  }

  function jQuerySort() {
    $('.basicExample').DataTable({
      "iDisplayLength": 10,
        "language": {
            "searchPlaceholder": 'Search...',
            "sSearch": '',
            "lengthMenu": '_MENU_ items/page',
            // "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "No matching records found",
            // "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
      "dom": 'Bfrtip',
      "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      "processing": true,
    
    })
  }
