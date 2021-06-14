$(document).ready(function (){

    $(document).on('click', '#booking-fee-history', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let bookingFeeName = $(this).attr('data-booking-fee-name');
      
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
              var message = error+ ' An error occured while trying to retireve '+ bookingFeeName +' booking fee history.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $(document).on('click', '#booking-fee-edit', function(event) {
        event.preventDefault();

        let route = $(this).attr('data-url');
        let id = $(this).attr('data-id');
        let bookingFeeName = $(this).attr('data-booking-fee-name');

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
        url: route,
        method: 'GET',
        data: {"id": id, "bookingFeeName": bookingFeeName },
        beforeSend : function(){
            $("#modal-edit-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'); 
        },
        success: function (result){
            $('#modal-edit-body').modal("show");
            $('#modal-edit-body').html('');
            $('#modal-edit-body').html(result).show();
        },
        complete: function() {
                $("#spinner-icon-3").hide();
        },
        error: function(jqXHR, testStatus, error) {
            var message = error+ ' An error occured while trying to edit '+ bookingFeeName+' booking fee.';
            var type = 'error';
            displayMessage(message, type);
            $("#spinner-icon-3").hide();
        },
        timeout: 8000
        });

    });

});