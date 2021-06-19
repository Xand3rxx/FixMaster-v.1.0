<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.geolocation_api_key') }}&v=3.exp&libraries=places"></script>
<script src="{{ asset('assets/js/geolocation.js') }}"></script>

<script>

    $(document).ready(function () {
        //Get list of L.G.A's in a particular state.
        $("#state_id").on("change", function () {
            let stateId = $("#state_id").find("option:selected").val();
            let stateName = $("#state_id").find("option:selected").text();
            let wardId = $("#ward_id").find("option:selected").val();

            // $.ajaxSetup({
            //         headers: {
            //             'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            $.ajax({
                url: "{{ route('lga_list', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    state_id: stateId,
                },
                success: function (data) {
                    if (data) {
                        $("#lga_id").html(data.lgaList);
                    } else {
                        var message = "Error occured while trying to get L.G.A`s in " + stateName + " state";
                        var type = "error";
                        displayMessage(message, type);
                    }
                },
            });
        });

        $('#lga_id').on('change', function() {
            let stateId = $('#state_id').find('option:selected').val();
            let lgaId = $('#lga_id').find('option:selected').val();
            $.ajax({
                url: "{{ route('towns.show', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "state_id": stateId, "lga_id": lgaId
                },
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $('#town_id').html(data.towns_list);
                    } else {
                        var message = 'Error occured while trying to get Town`s';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })
        });


        $('#insert_form').on("submit", function(event){  
           event.preventDefault();  
                $.ajax({  
                     url:"{{ route('client.ajax_contactForm', app()->getLocale()) }}",  
                     method:"POST",  
                     data: {
                    _token: "{{ csrf_token() }}",
                    firstName: $("#first-name").val(),
                    lastName: $("#last-name").val(),
                    phoneNumber: $("#phone_number").val(),
                    state: $("#state_id").val(),
                    lga: $("#lga_id").val(),
                    town: $("#town_id").val(),
                    streetAddress: $("#street-address").val(), 
                    addressLat: $("#user_latitude").val(),
                    addressLng: $("#user_longitude").val(),
                    },  
                     beforeSend:function(){  
                        //   $('.contact-list').val("Creating New Contact...");
                        $("#contacts_table").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');  
                     },  
                     success:function(data){ 
                        
                        $('#insert_form')[0].reset(); 
                        $('#add_data_Modal').modal('hide');
                        $('#contacts_table').html(data);
                        var message = ' New contact saved.';
                        var type = 'success';
                        displayMessage(message, type);
                     }
                    //  complete: function(data) {
                    //     // $(".contact-list").hide();
                    //     var message = ' New contact saved.';
                    //     var type = 'success';
                    //     // $('#add_data_Modal').modal('hide');
                    //     displayMessage(message, type);
                    //     // $('#contacts_table').html(data);
                    //     // $(".contact-list").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');  
                       
                    // }
                    // error: function(jqXHR, testStatus, error) {
                    //     var message = error+ ' An error occured while trying to save the new contact information.';
                    //     var type = 'error';
                    //     displayMessage(message, type);
                    //     // $(".contact-list").html('Failed to save new contact.');
                    // },

                    // timeout: 3000  
                }); 
        }); 


        //Check if clien't service request location is part of areas currently serviced by FixMaster
        $(document).on('change', '.contact-id', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let conctactName = $(this).attr('data-contact-name');
            let townID = $(this).attr('data-town-id')
            let bookingFee = 0;
            // let bookingFee = $("input:radio[name=booking_fee]").val();
            if($('input:radio[name=booking_fee]').is(':checked') || bookingFee != 0) { 
                bookingFee = $('.alt-booking').val();
            }else{
                displayMessage("Kindly select a booking fee.", "error");
                return;
            }

            $.ajax({
                url: route,
                method: 'POST',
                data: {_token: "{{ csrf_token() }}", town_id: townID, booking_fee: bookingFee },
                beforeSend: function() {
                    $(".display-request-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                // return the result
                success: function(result) {
                    $('.display-request-body').html('');
                    $('.display-request-body').html(result);
                },
                complete: function() {
                    $("#spinner-icon").hide();
                },
                error: function(jqXHR, testStatus, error) {
                    var message = 'An error occured while trying to retireve '+ conctactName +' town details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $(".display-request-body").html(message);
                },
                timeout: 8000
            })
        });

    });

    $(document).ready(function () {
        $(document).on("click", ".nav-item", function () {
            $(this).find(".booking-fee, .booking-fee-2").prop("checked", true);
            $('.alt-booking').val(parseFloat($(this).find(".booking-fee-2").val()));
        });

        $("#pay_offline").on("change", function () {
            $("#pay_offline").attr("checked", "checked");
            $(".payment-options").addClass("d-none");
        });

        $(".close").click(function () {
            $(".modal-backdrop").remove();
        });
    });

    function displayPaymentGateways(val) {
        console.log(val);
        if(val == 2){
            $(".payment-options").removeClass("d-none");
        }else{
            $(".payment-options").addClass("d-none");
        }
        
    }

    $("#editAddress").addClass("address-hide");

    function address() {
        $("#address").addClass("address-hide");
        $("#editAddress").removeClass("address-hide");
    }

    $(document).ready(function() {
       // always check the first payment gateway
       $(".input-check").first().attr('checked', true);
        // change form action, show form for checked 'gateway'
        let tabid = $(".input-check:checked").data('tabid');
       $('#payment').attr('action', $(".input-check:checked").data('action'));
    });

     // on gateway change...
     $(document).on('change', '.input-check', function() {
        // change form action
        let tabid = $(this).data('tabid');
        $('#payment').attr('action', $(this).data('action'));
        $('#paymentGatewaysForm').attr('action', $(".input-check:checked").data('action'));

    });

</script>


<script>
function ValidateSize(file) {
        if (typeof(file.files[0]) === "undefined") {
            $(file).val('');
            $(file).parent('.custom-file').find('label').text('Choose File');
            return false;
        }
        var FileSize = file.files[0].size / 1024 / 1024;
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
            $(file).val(''); //for clearing with Jquery
        } else {
            $(file).parent('.custom-file').find('label').text(file.files[0].name);
        }
    }
    
 $('body').on('click', '#add-more-file', function () {
        var count = parseInt($('.attachments').find('.custom-file:nth-last-child(1) input').prop('id').split("_")[2]) + 1; 
        // $('.attachments').append('<div class="custom-file">'+
        //     '<label class="custom-file-label" for="custom_file_'+count+'">file here</label>'+
        //     '<input type="file" name="filename[]" accept="application/pdf, image/gif, image/jpeg, image/png" class="custom-file-input" size="20" onchange="ValidateSize(this);" id="custom_file_'+count+'">'+
        //     '</div>')

            $('.attachments').append('<div class="form-group position-relative custom-file">'+
                '<input type="file" name="media_file[]" accept="image/*,.txt,.doc,.docx,.pdf" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_'+count+'"  />'+
                '<small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>'+
            '</div>')
    });
</script>