
$('.selectpicker').selectpicker();


$(document).ready(function() {
    var entity ='';
    $('#entity_id').on("change", function() {
         entity = $(this).children("option:selected").val();
        if (entity === 'client') {
            $('.clients').removeClass('d-none');
            $('.cses').addClass('d-none');
        }
        if (entity === 'cse') {
            $('.clients').addClass('d-none');
            $('.cses').removeClass('d-none');
        }
    });

    entity = $('#entity_id').children("option:selected").val();
        if (entity === 'client') {
            $('.clients').removeClass('d-none');
            $('.cses').addClass('d-none');
        }
        if (entity === 'cse') {
            $('.clients').addClass('d-none');
            $('.cses').removeClass('d-none')
        }

    });