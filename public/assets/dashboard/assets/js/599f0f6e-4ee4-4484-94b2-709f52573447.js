$(document).ready(function() {

    //Sort Activity Log view
    $(document).on('click', '#activity-log-details', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        $.ajax({
            url: route,
            beforeSend: function() {
              $("#sort_table_details").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
            },
            // return the result
            success: function(result) {
                $('#modal-body').modal("show");
                $('#modal-body').html(result).show();
            },
            complete: function() {
                $("#sort_table_details").hide();
            },
            error: function(jqXHR, testStatus, error) {
                // console.log(error);
                // alert("Page " + route + " cannot open. Error:" + error);
                // var message = "Page " + route + " cannot open. Error:" + error;
                var message = error+ ' An error occured while trying to retireve Activity Log details.';
                var type = 'error';
                displayMessage(message, type);
                $("#sort_table_details").hide();
            },
            timeout: 8000
        })
    });

    $('#sort_by_range').on('change', function (){        
            let option = $("#sort_by_range").find("option:selected").val();

            if(option === 'None'){
                $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                //Set other related sorting fields so default
                $('#specific_date, #date_from, #date_to').val("YYYY-MM-DD");
                $("#sort_by_month, #sort_by_year").prop('selectedIndex', 0);
            }

            if(option === 'Date'){
                $('.specific-date').removeClass('d-none');
                $('.sort-by-year, .date-range').addClass('d-none');

                //Set other related sorting fields so default
                $('#specific_date, #date_from, #date_to').val("YYYY-MM-DD");
                $("#sort_by_month, #sort_by_year").prop('selectedIndex', 0);

            }

            if(option === 'Month'){
                $('.sort-by-year').removeClass('d-none');
                $('.specific-date, .date-range').addClass('d-none');
                //Set other related sorting fields so default
                $('#specific_date, #date_from, #date_to').val("YYYY-MM-DD");
            }

            if(option === 'Year'){
                $('.sort-by-year').removeClass('d-none');
                $('#sort-by-month, .specific-date, .date-range').addClass('d-none');

                //Set other related sorting fields so default
                $('#specific_date, #date_from, #date_to').val("YYYY-MM-DD");
                $("#sort_by_month").prop('selectedIndex', 0);

            }

            if(option === 'Date Range'){
                $('.date-range').removeClass('d-none');
                $('.specific-date, .sort-by-year').addClass('d-none');

                //Set other related sorting fields so default
                $('#specific_date').val("YYYY-MM-DD");
            }
    });
    
    //SORT ACTIVITY LOG BY TYPE
    $('#activity_log_type').on('change', function (){
      //Get the User ID
      $userId = $('#user_id').val();

      //Get the Activity Log Type
      $type = $("#activity_log_type").find("option:selected").val();

      //Set other related sorting fields so default
      $("#sort_by_range, #sort_by_year, #sort_by_month").prop('selectedIndex', 0);
      $('#specific_date, #date_from, #date_to').val('');

      //Hide other related sorting fields
      $('.specific-date, .sort-by-year, .date-range').addClass('d-none');

      //Assign sorting level
      $sortLevel = 'Level One';

      sortTableData($userId, $sortLevel, $type);

    });        

    //SORT ACTIVITY LOG BY SPECIFIC DATE
    $('#specific_date').change(function (){
      //Get the User ID
      $userId = $('#user_id').val();

      //Assign sorting level
      $sortLevel = 'Level Two';

      //Get the Activity Log Type
      $type = $("#activity_log_type").find("option:selected").val();

      //Get specific Activity Log date
      $date = $('#specific_date').val();

      sortTableData($userId, $sortLevel, $type, $date);

    });

    //SORT ACTIVITY LOG BY SPECIFIC YEAR 
    $('#sort_by_year').change(function (){
      //Get the User ID
      $userId = $('#user_id').val();
      //Assign sorting level
      $sortLevel = 'Level Three';
      //Get the Activity Log Type
      $type = $("#activity_log_type").find("option:selected").val();
      //Get year to sort activity log
      $year = $('#sort_by_year').find("option:selected").val();
      //Set month to default
      $("#sort_by_month").prop('selectedIndex', 0);
    
      sortTableData($userId, $sortLevel, $type, $date='', $year);

    });

    //SORT ACTIVITY LOG BY SPECIFIC MONTH IN A YEAR 
    $('#sort_by_month').change(function (){
      //Get the User ID
      $userId = $('#user_id').val();
      //Assign sorting level
      $sortLevel = 'Level Four';
      //Get the Activity Log Type
      $type = $("#activity_log_type").find("option:selected").val();
      //Get year to sort activity log
      $year = $('#sort_by_year').find("option:selected").val();
      //Get year to sort activity log
      $month = $('#sort_by_month').find("option:selected").val();
      //Set month to default
      // $("#sort_by_month").prop('selectedIndex', 0);
    
      if($.trim($year).length == 0){
        var message = 'Kindly select a year to sort by Month.';
        var type = 'error';
        displayMessage(message, type);

      }else{
        sortTableData($userId, $sortLevel, $type, $date='', $year, $month);
      }
    });

    $('#date_from').change(function (){
      $('#date_to').attr('min', $('#date_from').val());
    });

    //SORT ACTIVITY LOG BY DATE RANGE
    $('#date_to').change(function (){
      //Get the User ID
      $userId = $('#user_id').val();
      //Assign sorting level
      $sortLevel = 'Level Five';
      //Get the Activity Log Type
      $type = $("#activity_log_type").find("option:selected").val();
      //Get year to sort activity log
      $year = $('#sort_by_year').find("option:selected").val();
      //Get date from to sort activity log
      $dateFrom = $('#date_from').val();
      //Get date to, to sort activity log
      $dateTo = $('#date_to').val();
    
      if($.trim($dateFrom).length == 0){
        var message = 'Kindly select a date to sort From.';
        var type = 'error';
        displayMessage(message, type);

      }else{
        sortTableData($userId, $sortLevel, $type, $date='', $year='', $month='', $dateFrom, $dateTo);
      }
    });

  });

  function sortTableData($userId, $sortLevel, $type, $date, $year='', $month='', $dateFrom, $dateTo){
    //Get sorting route
    $route = $('#route').val();

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: $route,
        method: 'POST',
        data: {"user": $userId, "sort_level": $sortLevel, "type": $type, "date": $date, "year":$year, "month": $month, "date_from": $dateFrom, "date_to": $dateTo},
        beforeSend : function(){
            $("#sort_table").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'); 
        },
        success: function (data){
            if(data){
              //Replace table with new sorted records
              $('#sort_table').html('');                
              $('#sort_table').html(data);

              //Add sorting class for jQuery datatable
              $('#basicExample').addClass('basicExample');

              //Attach JQuery datatable to current sorting
              if($('#basicExample').hasClass('basicExample')){
                jQuerySort();
              }
            }else {
              var message = 'Error occured while trying to sort Activity Log table.';
              var type = 'error';
              displayMessage(message, type);
            }            
        }
    });
  }

  function jQuerySort(){
    $('.basicExample').DataTable({
          'iDisplayLength': 10,
          language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
              }
        });
  }