$(document).ready(function() {
    $('#request-sorting').on('change', function (){
        let option = $("#request-sorting").find("option:selected").val();

        if(option === 'None'){
            $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
        }

        if(option === 'Date'){
            $('.specific-date').removeClass('d-none');
            $('.sort-by-year, .date-range').addClass('d-none');
        }

        if(option === 'Month'){
            $('.sort-by-year').removeClass('d-none');
            $('.specific-date, .date-range').addClass('d-none');
        }

        if(option === 'Date Range'){
            $('.date-range').removeClass('d-none');
            $('.specific-date, .sort-by-year').addClass('d-none');
        }
    });

    //test for iterating over child elements
    var langArray = [];
    $('.vodiapicker option').each(function(){
        var img = $(this).attr("data-thumbnail");
        var text = this.innerText;
        var value = $(this).val();
        var item = '<li><img src="'+ img +'" alt="" value="'+value+'"/><span>'+ text +'</span></li>';
        langArray.push(item);
    })

    $('#a').html(langArray);

    //Set the button value to the first el of the array
    $('.btn-select').html(langArray[0]);
    $('.btn-select').attr('value', 'en');

    //change button stuff on click
    $('#a li').click(function(){
        var img = $(this).find('img').attr("src");
        var value = $(this).find('img').attr('value');
        var text = this.innerText;
        var item = '<li><img src="'+ img +'" alt="" /><span>'+ text +'</span></li>';
        $('.btn-select').html(item);
        $('.btn-select').attr('value', value);
        $(".b").toggle();
        //console.log(value);
    });

    $(".btn-select").click(function(){
            $(".b").toggle();
    });

    //check local storage for the lang
    var sessionLang = localStorage.getItem('lang');
    if (sessionLang){
        //find an item with value of sessionLang
        var langIndex = langArray.indexOf(sessionLang);
        $('.btn-select').html(langArray[langIndex]);
        $('.btn-select').attr('value', sessionLang);
        } else {
        var langIndex = langArray.indexOf('ch');
        // console.log(langIndex);
        $('.btn-select').html(langArray[langIndex]);
        //$('.btn-select').attr('value', 'en');
    }

    $(document).on('click', '#transaction-details', function(event) {
        event.preventDefault();
        let route = $('#route').val();
        let transaction = $(this).attr('data-transaction-id');
        
        $.ajax({
            url: route,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                reference_id: transaction,
            },
            success: function (data) {
                if (data) {
                    $("#modal-transaction-body").modal("show");
                    $("#modal-transaction-body").html("");
                    $("#modal-transaction-body").html(data).show();
                } else {
                    displayMessage('An error occured while trying to retireve '+ transaction +' transaction details', 'error');
                }
            },
        });
    });

    $('.close').click(function (){
        $(".modal-backdrop").remove();
    });
});