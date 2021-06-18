$(document).ready(function () {
    $(document).on('click', '#cancel-request', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let title = $(this).attr('title');

        Swal.fire({
            title: title + '?',
            text: "Are you sure you want to execute this action!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E97D1F',
            cancelButtonColor: '#7987a1',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.value == true) {
                // window.location.href = route;
                $('#cancel-request-form').attr('action', route);
                $('#cancelRequest').modal('show')
            }
        });

    });
});
