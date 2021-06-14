
$(document).ready(function() {

    $(document).on('click', '#delete', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Delete</a>";
        displayAlert(url, 'Would you like to detele this Referral?')
    });
    $(document).on('click', '#deactivate', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Deactivate</a>";
        displayAlert(url, 'Would you like to deactivate this  Referral?')
    })

    $(document).on('click', '#activate', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Reinstate</a>"
        displayAlert(url, 'Would you like to reinstate this  Referral?')
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