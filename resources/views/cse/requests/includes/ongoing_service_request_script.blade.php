<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>

<script>

    $(document).ready(function (){
        $('.selectpicker').selectpicker(); //Initiate multiple dropdown select

        $(document).on('change', '#sub_service_uuid', function(){
          
            $subServiceUuidList = [];
            $subServiceUuid = $(this).val();
            $subServiceUuidList.push($subServiceUuid);
            var route = $('#route').val();

            $.ajax({
                url: route,
                beforeSend: function() {
                    $(".sub-service-report").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                data: {"sub_service_list":$subServiceUuidList},
                // return the result
                success: function(result) {
                    $('.sub-service-report').html('');
                    $('.sub-service-report').html(result);
                },
                error: function(jqXHR, testStatus, error) {
                    var message = error+ ' An error occured while trying to retireve sub service details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000
            })
            
        });
    });
</script>