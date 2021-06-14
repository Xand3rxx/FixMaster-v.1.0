$(document).ready(function() {
    //Initiate multiple dropdown select
    $('.selectpicker').selectpicker();


    $('#sorting-parameters').on('change', function() {
        let option = $("#sorting-parameters").find("option:selected").val();
        switch (option) {
            case 'SortType1':
                $('.supplier-list').removeClass('d-none');
                $('.date-range, .job-status, .cse-list').addClass('d-none');
                $("#job-status").prop('selectedIndex', 0);
                $('#date-from, #date-to').val('');
                break
            case 'SortType2':
                $('.date-range').removeClass('d-none');
                $('.supplier-list, .cse-list, .job-status').addClass('d-none');
                $("#supplier-list, #job-status").prop('selectedIndex', 0);
                $('#date-from, #date-to').val('');
                break
            case 'SortType3':
                $('.date-range').removeClass('d-none');
                $('.supplier-list, .job-status, .cse-list').addClass('d-none');
                $("#supplier-list, #job-status").prop('selectedIndex', 0);
                $('#date-from, #date-to').val('');
                break
            case 'SortType4':
                $('.job-status').removeClass('d-none');
                $('.supplier-list, .date-range, .cse-list').addClass('d-none');
                $("#supplier-list").prop('selectedIndex', 0);
                $('#date-from, #date-to').val('');
                break
            case 'SortType5':
                $('.cse-list').removeClass('d-none');
                $('.supplier-list, .date-range, .job-status').addClass('d-none');
                $("#supplier-list").prop('selectedIndex', 0);
                $('#date-from, #date-to').val('');
                break
            default:
                $('.supplier-list, .date-range, .job-status, .cse-list').addClass('d-none');
                break;
        }
    });

});

//SORT SUPPLIER REPORT BY SUPPLIER ID
$('#supplier-list').on('change', function (){
    //Get the User ID
    $supplierId = $('#user_id').val();

    //Assign sorting level
    $sortLevel = 'SortType1';

    sortItemDeliveredTable($sortLevel, $supplierId);

});

function sortItemDeliveredTable($sortLevel, $supplierId = null, $jobStatus, $dateFrom = null, $dateTo = null, $cseId = null){
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
        data: {"sort_level": $sortLevel, "supplier_id": $supplierId, "job_status": $jobStatus, "date_from": $dateFrom, "date_to": $dateTo, "cse_id" : $cseId},
        beforeSend : function(){
            $("#items-delivered-sorting").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
        },
        success: function (data){
            if(data){
                //Replace table with new sorted records
                $('#items-delivered-sorting').html('');
                $('#items-delivered-sorting').html(data);

                //Add sorting class for jQuery datatable
                $('#basicExample').addClass('basicExample');

                //Attach JQuery datatable to current sorting
                if($('#basicExample').hasClass('basicExample')){
                    jQuerySort();
                }
            }else {
                var message = 'Error occurred while trying to sort this table.';
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
    })
}
