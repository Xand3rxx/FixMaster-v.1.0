$(document).ready(function() {

    $('#assigned-sorting-parameters').on('change', function() {
    let option = $("#assigned-sorting-parameters").find("option:selected").val();
    switch (option) {
        case 'SortType1':
                $('.assigned-cse-list').removeClass('d-none');
                $('.assigned-date-range, .assigned-job-status, .paid').addClass('d-none');
                $("#assigned-job-status, #paid").prop('selectedIndex', 0);
                $('#assigned-date-from, #assigned-date-to').val('');
            break
        case 'SortType2':
                $('.assigned-date-range').removeClass('d-none');
                $('.assigned-cse-list, .assigned-job-status, .paid').addClass('d-none');
                $("#assigned-cse-list, #assigned-job-status, #paid").prop('selectedIndex', 0);
                $('#assigned-date-from, #assigned-date-to').val('');
            break
        case 'SortType3':
                $('.assigned-date-range').removeClass('d-none');
                $('.assigned-cse-list, .assigned-job-status, .paid').addClass('d-none');
                $("#assigned-cse-list, #assigned-job-status, #paid").prop('selectedIndex', 0);
                $('#assigned-date-from, #assigned-date-to').val('');
            break
        case 'SortType4':
                $('.assigned-job-status').removeClass('d-none');
                $('.assigned-cse-list, .assigned-date-range, .paid').addClass('d-none');
                $("#assigned-cse-list, #paid").prop('selectedIndex', 0);
                $('#assigned-date-from, #assigned-date-to').val('');
            break
        case 'SortType5':
                $('.paid').removeClass('d-none');
                $('.assigned-cse-list, .assigned-date-range, .assigned-job-status').addClass('d-none');
                $("#assigned-cse-list, #assigned-job-status, #paid").prop('selectedIndex', 0);
                $('#assigned-date-from, #assigned-date-to').val('');
            break

        default:
                $('.assigned-cse-list, .assigned-date-range, .assigned-job-status, .paid').addClass('d-none');
                $("#assigned-cse-list, #paid, #assigned-job-status").prop('selectedIndex', 0);
                $('#assigned-date-from, #assigned-date-to').val('');
            break;
    }
    });

    //SORT CSE REPORT BY CSE ID
    $('#assigned-cse-list').on('change', function() {
        //Get the User ID
        $cseIdList = [];
        $cseId = $(this).val();
        $cseIdList.push($cseId);
        // console.log($cseIdList);

        //Assign sorting level
        $sortLevel = 'SortType1';

        sortAmountEarnedTable($sortLevel, $cseIdList);

    });

    //SORT CSE REPORT BY DATE RANGE
    $('#assigned-date-to').change(function() {

        //Assign sorting level
        $sortLevel = $('#assigned-sorting-parameters').val();
        //Get date from to sort activity log
        $dateFrom = $('#assigned-date-from').val();
        //Get date to, to sort activity log
        $dateTo = $('#assigned-date-to').val();

        if ($.trim($dateFrom).length == 0) {
            var message = 'Kindly select a date to start From.';
            var type = 'error';
            displayMessage(message, type);

        } else {
            sortAmountEarnedTable($sortLevel, $cseId = null, $jobStatus = null, $dateFrom, $dateTo);
        }
    });

    //SORT CSE REPORT BY JOB STATUS
    $('#assigned-job-status').change(function() {

    //Assign sorting level
    $sortLevel = $('#assigned-sorting-parameters').val();
    //Get date from to sort activity log
    $jobStatus = $('#assigned-job-status').val();

    sortAmountEarnedTable($sortLevel, $cseId = null, $jobStatus, $dateFrom = null, $dateTo = null);
    });

});

function sortAmountEarnedTable($sortLevel, $cseId = null, $jobStatus = null, $dateFrom = null, $dateTo = null) {
    //Get sorting route
    $route = $('#assigned-route').val();
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
        $("#amount-earned-sorting").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
      },
      success: function(data) {
        // console.log(data);
        // return false;
        if (data) {
          //Replace table with new sorted records
          $('#amount-earned-sorting').html('');
          $('#amount-earned-sorting').html(data);

          //Add sorting class for jQuery datatable
          $('#basicExample2').addClass('basicExample2');

          //Attach JQuery datatable to current sorting
          if ($('#basicExample2').hasClass('basicExample2')) {
            jQuerySort();
          }
        } else {
          var message = 'Error occured while trying to sort Amount Earned table.';
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
    $('.basicExample2').DataTable({
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