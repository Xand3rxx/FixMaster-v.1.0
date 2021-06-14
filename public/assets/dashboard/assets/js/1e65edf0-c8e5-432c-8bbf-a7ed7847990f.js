$(document).ready(function() {

    let count = 1;

    $(document).on('click', '#category-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let categoryeName = $(this).attr('data-category-name');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-body').html('');
              $('#modal-body').modal("show");
              $('#modal-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ categoryeName +' service details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $(document).on('click', '#service-edit2', function(event) {
        event.preventDefault();

        let route = $(this).attr('data-url');
        let id = $(this).attr('data-id');
        let serviceName = $(this).attr('data-service-name');
        $('.edit-title').text($(this).attr('title'));

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
        url: route,
        method: 'GET',
        data: {"id": id, "serviceName": serviceName },
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
            var message = error+ ' An error occured while trying to edit '+ serviceName+' service';
            var type = 'error';
            displayMessage(message, type);
            $("#spinner-icon-3").hide();
        },
        timeout: 8000
        });

    });

    //Append the image name from file options to post cover field
    $(document).ready(function(){
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('#image-name, #new-image-name').text(fileName);
        });

        let previousCoverPhoto = $('#old-post-image').val();
        $('#image-name').text(previousCoverPhoto);

    });

    //Add new row for a new sub service form
    $(document).on('click', '.add-sub-service', function() {
        count++;
        addSubService(count);
    });
    //Remove sub service row
    $(document).on('click', '.remove-sub-service', function() {
        count--;
        $(this).closest(".remove-sub-service-row").remove();
    });

});


