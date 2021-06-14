$(function() {
    'use strict'
    $('#wizard3').steps({
        headerTag: 'h3'
        , bodyTag: 'section'
        , autoFocus: true
        , titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>'
        , loadingTemplate: '<span class="spinner"></span> #text#'
        , labels: {
            // current: "current step:",
            // pagination: "Pagination",
            finish: "Update Job Progress",
            // next: "Next",
            // previous: "Previous",
            loading: "Loading ..."
        }
        , stepsOrientation: 1,
        // transitionEffect: "fade",
        // transitionEffectSpeed: 200,
        showFinishButtonAlways: false
        , onFinished: function(event, currentIndex) {
            $('#update-progress').trigger('click');
        }
    , });

    var count = 1;
    //Add and Remove Request for qoute form
    $(document).on('click', '.add-rfq', function() {
        count++;
        addRFQ(count);
    });
    $(document).on('click', '.remove-rfq', function() {
        count--;
        $(this).closest(".remove-rfq-row").remove();
        // $(this).closest('tr').remove();
    });

    //Add and Remove image row form
    $(document).on('click', '.add-image', function() {
        count++;
        newImageRow(count);
    });
    $(document).on('click', '.remove-image', function() {
        count--;
        $(this).closest(".remove-image-row").remove();
        // $(this).closest('tr').remove();
    });

    //Hide and Unhide RFQ
    $('#rfqYes').change(function() {
        if ($(this).prop('checked')) {
            $('.d-rfq').removeClass('d-none');
             $('.d-rfq2').removeClass('d-none')
        }
    });
    $('#rfqNo').change(function() {
        if ($(this).prop('checked')) {
            $('.d-rfq').addClass('d-none');
            $('.d-rfq2').addClass('d-none')
        }
    });

  
        if ($('#rfqNo').prop('checked')) {
            $('.d-rfq2').addClass('d-none')
        }



    
    
});

$(document).on('change', '.custom-file-input', function() {
            var photo = $(this)[0].files[0];
           if(photo){
            $(this).parent().find('.custom-file-label').text(photo.name);
           }   
                    
});

$(document).on('change', '.new-supplier', function() {
    if ($(this).prop('checked')) {
         $('.old-supplier').prop('checked', false)
      
    }
         
});

$(document).on('change', '.old-supplier', function() {
    if ($(this).prop('checked')) {
         $('.new-supplier').prop('checked', false)
      
    }
         
});





