$(document).ready(function () {
   $(document).on('click', '#cancel-request', function(event) {
    event.preventDefault();
    let route = $(this).attr('data-url');
    let jobReference = $(this).attr('data-job-reference');

    $('#cancel-request-form').attr('action', route);
});

$(document).on('click', '#warranty-initiate', function(event) {
    event.preventDefault();
    let route = $(this).attr('data-url');
    let jobReference = $(this).attr('data-job-reference');

    $('#warranty-initiate-form').attr('action', route);
});



});

$(document).ready(function() {

    $(document).on('click', '#activate', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Reinstate</a>"
        displayAlert(url, 'Would you like to reinstate this request?')
    });



    $(document).on('click', '#completed', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Mark As Completed</a>"
        displayAlert(url, 'Would you like to mark this request as completed?')
    });



    function displayAlert(url, message) {
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            showCancelButton: true,
            confirmButtonColor: '#E97D1F',
            cancelButtonColor: '#8392a5',
            confirmButtonText: url
        })

    }

});


$(document).ready(function () {
    $(document).on("click", "#edit-request", function (event) {
        event.preventDefault();
        let route = $(this).attr("data-url");
        let jobReference = $(this).attr("data-job-reference");

        $.ajax({
            url: route,
            beforeSend: function () {
                $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
            },
            // return the result
            success: function (result) {
                $("#modal-edit-request").modal("show");
                $("#modal-edit-request").html("");
                $("#modal-edit-request").html(result).show();
            },
            complete: function () {
                $("#spinner-icon").hide();
            },
            error: function (jqXHR, testStatus, error) {
                var message = error + "An error occured while trying to retireve " + jobReference + " service request details.";
                var type = "error";
                displayMessage(message, type);
                $("#spinner-icon").hide();
            },
            timeout: 8000,
        });
    });

    $(".close").click(function () {
        $(".modal-backdrop").remove();
    });

    $(document).on("click", ".verify-security-code", function () {
        if ($("#security_code").val() == $("#security-code").val()) {
            $("#security_code").val("");
            $("#validateSecurityCode").modal("hide");

            $("#cseTechnicianModal").modal("show");
        } else {
            var message = "Invalid Security code";
            var type = "error";
            displayMessage(message, type);
        }
    });
});


