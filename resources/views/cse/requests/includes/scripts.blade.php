<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>

<script defer>
    $(function() {
        'use strict'
        $('.notify-client-schedule-date').on('click', function(e) {
            // Trigger Ajax call to send notification
            $.ajax({
                url: "{{ route('cse.notify.client', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "service_request": $(this).data('service')
                },
                success: function(data) {
                    console.log(data);
                    displayMessage(data, 'success');
                },
                catch: function(error) {
                    displayMessage(error.data, 'error');
                }
            });
            // User service requuest client_id
            // return respose of either success or failed
        });

        //Initiate light gallery plugin
        $('.lightgallery').lightGallery();

        $(document).on('click', '#contact-me', function(){
            var contactMe = parseInt($(this).attr('data-contact-me'));

            if(contactMe == 0){
                displayMessage('Sorry! The client does not want to be contacted.', 'error');
                return;
            }
        });

        $(document).on('click', '#tool-request-details', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let batchNumber = $(this).attr('data-batch-number');

            $.ajax({
                url: route,
                beforeSend: function() {
                    $("#tool-request-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                // return the result
                success: function(result) {
                    $('#tool-request-body').modal("show");
                    $('#tool-request-body').html('');
                    $('#tool-request-body').html(result).show();
                },
                complete: function() {
                    $("#spinner-icon").hide();
                },
                error: function(jqXHR, testStatus, error) {
                    var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000
            })
            });

            $('.close').click(function (){
                $(".modal-backdrop").remove();
            });
    });
</script>
