$(document).ready(function (){
    $(document).on('keyup', '.search-category', function(){
        let query = $(this).val();
        let type = 'Name';

        if($.trim(query).length <= 0){
            $('.search-result').html('');
            $('.search-result').addClass('d-none');
            $('.services-list').removeClass('d-none');
        }

        if($.trim(query).length > 5){
            $('.services-list').addClass('d-none');
            $('.search-result').removeClass('d-none');
            searchCategory(type, query);
        }

    });

    $(document).on('change','#sort-category', function(){

        let query = $(this).find("option:selected").val();
        let type = 'ID';

        if($.trim(query).length <= 0){
            $('.search-result').html('');
            $('.search-result').addClass('d-none');
            $('.services-list').removeClass('d-none');
        }

        if($.trim(query).length > 0){
            $('.services-list').addClass('d-none');
            $('.search-result').removeClass('d-none');
            searchCategory(type, query);
        }

    });

});

function searchCategory(type, query){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var route = $('#route').val();

    $.ajax({
            url: route,
            beforeSend: function() {
                $(".search-result").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
            },
            method: 'POST',
            data: {'type': type, 'query': query},
            // return the result
            success: function(result) {
                $('.search-result').html('');
                $('.search-result').html(result);
            },
            complete: function() {
                $("#spinner-icon").hide();
            },
            timeout: 8000
    });
}