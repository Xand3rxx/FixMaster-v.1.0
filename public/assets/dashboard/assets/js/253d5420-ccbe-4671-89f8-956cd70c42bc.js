// $(document).ready(function() {

    var locale = $('#locale').val();

    $(document).on('click', '#service-details', function(event) {
    // $('body').delegate( '#service-details', 'click', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let serviceName = $(this).attr('data-service-name');
      
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
              var message = error+ ' An error occured while trying to retireve '+ serviceName +' category details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $(document).on('click', '#service-reassign', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let serviceName = $(this).attr('data-service-name');

      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-reassign-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-reassign-body').html('');
              $('#modal-reassign-body').modal("show");
              $('#modal-reassign-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon-2").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to reassign services assigned to '+ serviceName;
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon-2").hide();
          },
          timeout: 8000
      })
    });

    $(document).on('click', '#service-edit', function(event) {
        event.preventDefault();

        let route = $(this).attr('data-url');
        let id = $(this).attr('data-id');
        let serviceName = $(this).attr('data-service-name');
        let labourMarkup = $(this).attr('data-labour-markup');
        let materialMarkup = $(this).attr('data-material-markup');

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
        url: route,
        method: 'GET',
        data: {"id": id, "serviceName": serviceName, "labourMarkup": labourMarkup, "materialMarkup": materialMarkup},
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
            var message = error+ ' An error occured while trying to edit '+ serviceName+' category';
            var type = 'error';
            displayMessage(message, type);
            $("#spinner-icon-3").hide();
        },
        timeout: 8000
        });

    });


    $(document).on('change', '#reassign-category-service', function(event) {
      event.preventDefault();

       let serviceId = $(this).children("option:selected").data('service-id');
       let serviceName = $(this).children("option:selected").data('service-name');
       let categoryId = $(this).children("option:selected").data('category-id');
       let categoryName = $(this).children("option:selected").data('category-name');
       let route = $(this).children("option:selected").data('url');

       $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url: route,
        method: "POST",
        data: {'serviceId':serviceId, 'serviceName':serviceName, 'categoryId':categoryId, 'categoryName':categoryName},
        beforeSend : function(){
            $("#sort_table").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'); 
        },
        success: function (data){
            if(data){
                
                var message = serviceName+' Service was successfully reassgined to '+ categoryName +' category';
                var type = 'success';

                $(this).closest("tr").remove();
                displayMessage(message, type);

                $('#serviceReassign').modal('hide');
                $(".modal-backdrop").remove();

                //Replace table with new sorted records
                $('#sort_table').html('');                
                $('#sort_table').html(data);

                //Add sorting class for jQuery datatable
                $('#basicExample').addClass('basicExample');

                //Attach JQuery datatable to current sorting
                if($('#basicExample').hasClass('basicExample')){
                    jQuerySort();
                }
                
                setTimeout(function() {
                    window.location.reload();

                }, 3000);

            }else{
              var message = 'Error occured while trying to reassign '+ serviceName +' service to '+ categoryName + ' category';
              var type = 'error';
              displayMessage(message, type);

            }
        }
      });

    });

//   });

    

  function jQuerySort(){
    $('.basicExample').DataTable({
        "iDisplayLength": 10,
          "language": {
                searchPlaceholder: 'Search...',
                sSearch: '',
                // lengthMenu: '_MENU_ items/page',
                "lengthMenu": "Display _MENU_ records per page",
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
    });
  }