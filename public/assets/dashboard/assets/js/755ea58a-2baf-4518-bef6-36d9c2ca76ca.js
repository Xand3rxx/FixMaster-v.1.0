$(document).ready(function() {
    $(document).on('click', '#edit-inventory', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let toolName = $(this).attr('data-tool-name');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-edit-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-edit-body').modal("show");
              $('#modal-edit-body').html('');
              $('#modal-edit-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ toolName +' Tool details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

});