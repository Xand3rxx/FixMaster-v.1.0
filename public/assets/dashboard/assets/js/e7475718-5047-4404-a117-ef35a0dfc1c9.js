$(document).ready(function() {

    $(document).on('click', '#wallet-transaction-detail', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        
        $.ajax({
            url: route,
            beforeSend: function() {
                $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
            },
            // return the result
            success: function(result) {
                $('#modal-body').modal("show");
                $('#modal-body').html('');
                $('#modal-body').html(result).show();
            },
            complete: function() {
                $("#spinner-icon").hide();
            },
            error: function(jqXHR, testStatus, error) {
                var message = error+ ' An error occured while trying to retireve this E-Wallet transaction history.';
                var type = 'error';
                displayMessage(message, type);
                $("#spinner-icon").hide();
            },
            timeout: 8000
        })
    });

    $('#request-sorting').on('change', function (){        
            let option = $("#request-sorting").find("option:selected").val();

            if(option === 'None'){
                $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
            }

            if(option === 'Date'){
                $('.specific-date').removeClass('d-none');
                $('.sort-by-year, .date-range').addClass('d-none');
            }

            if(option === 'Month'){
                $('.sort-by-year').removeClass('d-none');
                $('.specific-date, .date-range').addClass('d-none');
            }

            if(option === 'Date Range'){
                $('.date-range').removeClass('d-none');
                $('.specific-date, .sort-by-year').addClass('d-none');
            }
    });
});