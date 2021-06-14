$(document).ready(function (){

    $(document).on('click', '#tax-details', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let serviceName = $(this).attr('data-tax-name');
        
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
                var message = error+ ' An error occured while trying to retireve '+ serviceName +' tax history.';
                var type = 'error';
                displayMessage(message, type);
                $("#spinner-icon").hide();
            },
            timeout: 8000
        });
    });

    $(document).on('click', '#tax-edit', function(event) {
        event.preventDefault();
  
        let route = $(this).attr('data-url');
        let id = $(this).attr('data-id');
        let taxName = $(this).attr('data-tax-name');
  
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
          url: route,
          method: 'GET',
          data: {"id": id, "taxName": taxName },
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
              var message = error+ ' An error occured while trying to edit '+ taxName+' tax';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon-3").hide();
          },
          timeout: 8000
        });
  
    });


    $(document).on('click', '#markas-resolved', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
    
        $('#markas-resolved-form').attr('action', route);
    });


    let count = 1;

    $(document).on('click', '#assign-Cse', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let job_reference = $(this).attr('data-job');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-body-assign").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#job').text(job_reference);
              $('#modal-body-assign').html('');
              $('#modal-body-assign').modal("show");
              $('#modal-body-assign').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ ' ' +' service details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });
    

  });



 $(document).on('click', '#resolved-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let job_reference = $(this).attr('data-job');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#job').text(job_reference);
              $('#modal-body').html('');
              $('#modal-body').modal("show");
              $('#modal-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ ' ' +' service details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    
    

  });
