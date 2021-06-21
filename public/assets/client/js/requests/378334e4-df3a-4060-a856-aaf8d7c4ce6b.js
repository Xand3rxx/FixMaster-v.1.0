$(document).ready(function () {
    "use strict";

    //Get list of L.G.A's in a particular state.
    $("#state_id").on("change", function () {
        let stateId = $("#state_id").find("option:selected").val();
        let stateName = $("#state_id").find("option:selected").text();
        let wardId = $("#ward_id").find("option:selected").val();
        let route = $(".lga-list").val();
       
        $.ajax({
            url: route,
            method: "POST",
            dataType: "JSON",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
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
        let route = $(".town-list").val();

        $.ajax({
            url: route,
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "state_id": stateId, "lga_id": lgaId
            },
            success: function(data) {
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


    

    //Check if clien't service request location is part of areas currently serviced by FixMaster
    $(document).on('change', '.contact-id', function(event) {
        event.preventDefault();
        //Get required values from client choice 
        let townID = $(this).attr('data-town-id')
        let bookingFee = 0;

        //Assigning town id to hidden field
        $(".town-id").val(townID);

        //Check if client selected a booking fee
        if($('input:radio[name=booking_fee]').is(':checked') || bookingFee != 0) { 
            bookingFee = $('.alt-booking').val();

            //Check if the selected contact has a town ID
            if($.trim(townID).length == 0){
                displayMessage("Sorry! This contact has no default Town ID.", "error");
            }else{
                return services_areas(townID, bookingFee);
            }
        }else{
            displayMessage("Kindly select a booking fee.", "error");
            return;
        }

    });

    $(document).on("click", ".nav-item", function () {
        $(this).find(".booking-fee, .booking-fee-2").prop("checked", true);
        $('.alt-booking').val(parseFloat($(this).find(".booking-fee-2").val()));
        let townID = $('.town-id').val();
        let bookingFee = parseFloat($(this).find(".booking-fee-2").val());

        //Check if the selected contact has a town ID
        if($.trim(townID).length > 0) { 
            return services_areas(townID, bookingFee);
        }else{
            if($('input:radio[name=contact_id]').is(':checked')){
                displayMessage("Sorry! The selected contact does not have a default Town ID.", "error");
                return;
            }
        }
    });

    $("#pay_offline").on("change", function () {
        $("#pay_offline").attr("checked", "checked");
        $(".payment-options").addClass("d-none");
    });

    $(".close").click(function () {
        $(".modal-backdrop").remove();
    });

    $("#editAddress").addClass("address-hide");

    // always check the first payment gateway
    $(".input-check").first().attr('checked', true);
    // change form action, show form for checked 'gateway'
    let tabid = $(".input-check:checked").data('tabid');
    $('#payment').attr('action', $(".input-check:checked").data('action'));

    // on gateway change...
    $(document).on('change', '.input-check', function() {
    // change form action
        let tabid = $(this).data('tabid');
        $('#payment').attr('action', $(this).data('action'));
        $('#paymentGatewaysForm').attr('action', $(".input-check:checked").data('action'));

    });

    let count = 1;

    $('body').on('click', '#add-more-file', function () {
        count++;
        $('.attachments').append('<div class="form-group position-relative custom-file remove-file">'+
            '<input type="file" name="media_file[]" accept="image/*,.txt,.doc,.docx,.pdf" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_'+count+'"  />'+
            '<small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>'+
        '<div class="form-group position-relative"><a class="btn btn-danger btn-sm remove-media-file"><i data-feather="minus" class="fea icon-sm"></i></a></div></div>')
    });

    //Remove sub service row
    $(document).on('click', '.remove-media-file', function() {
        count--;
        $(this).closest(".remove-file").remove();
    });

    $("#insert_form").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 3,
                maxlength: 180
            },
            last_name: {
                required: true,
                minlength: 3,
                maxlength: 180
            },
            gender: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            phone_number: {
                required: true,
                digits: true,
                minlength: 8,
                maxlength: 15
            },
            address: {
                required: true,
            },
            state_id: {
                required: true
            },
            lga_id: {
                required: true
            }
        },
        messages: {
            first_name: {
                required: "First name field is mandatory",
                minlength: "First name should be atleast 3 characters long",
                maxlength: "First name should be atmost 180 characters long",
            },
            last_name: {
                required: "Last name field is mandatory",
                minlength: "Last name should be atleast 3 characters long",
                maxlength: "Last name should be atmost 180 characters long",
            },
            email: {
                required: "Email address is mandatory",
                email: "Valid email address is mandatory"
            },
            phone_number: {
                required: 'Phone number is mandatory',
            },
            address: {
                required: "Use the Google address autocomplete to select your Residential address is mandatory",
            },
            user_latitude: {
                required: 'Kindly use the Google address autocomplete',
            },
            user_longitude: {
                required: 'Kindly use the Google address autocomplete',
            },
            state_id: {
                required: 'You must select a State',
            },
            lga_id: {
                required: 'You must select a Local Government Area',
            }
        },
        errorClass: "invalid-response",
        errorElement: "div",
        submitHandler: function () {

            $('#insert').prop('disabled', true);
            // form.submit();
            return createNewClientContact();
        }
    });
});


function createNewClientContact(){

    $('#insert_form').on("submit", function(event){  
        event.preventDefault();  
        let route = $(".ajax-contact-form").val();
		// formData = $(this).serialize();

        formData = {
            first_name        : $('#first_name').val(),
            last_name         : $('#last_name').val(),
            phone_number      : $('#phone_number').val(),
            state_id          : $('#state_id').val(),
            lga_id            : $('#lga_id').val(),
            town_id           : $('#town_id').val(),
            address           : $('#address').val(),
            user_latitude     : $('#user_latitude').val(),
            user_longitude    : $('#user_longitude').val()
        };
        // Appending CSRF token to formData
		// formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({  
            url: route,  
			type: "POST",
            dataType: "json",
            data: formData,  
            beforeSend:function(){  
                $("#contacts_table").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');  
            },  
            success:function(data){ 
                $('#insert_form')[0].reset(); 
                $('#add_data_Modal').modal('hide');
                $('#contacts_table').html(data);
                var message = $("#first-name").val()+' '+$("#last-name").val()+' contact has been saved.';
                displayMessage(message, success);
            },
            error: function(jqXHR, testStatus, error) {
                
                displayMessage('An error occured while trying to save the new contact information.', 'error');
            },
            timeout: 3000  
        }); 
    }); 
}

function displayPaymentGateways(val) {
    if(val == 2){
        $(".payment-options").removeClass("d-none");
    }else{
        $(".payment-options").addClass("d-none");
    }
}

function address() {
    $("#address").addClass("address-hide");
    $("#editAddress").removeClass("address-hide");
}

function services_areas(townID,bookingFee) {
    let conctactName = $(this).attr('data-contact-name');
    let route = $(".validate-service-area").val();

    $.ajax({
        url: route,
        method: 'POST',
        data: {_token: $('meta[name="csrf-token"]').attr('content'), town_id: townID, booking_fee: bookingFee },
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
}

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