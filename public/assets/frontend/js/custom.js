$(document).ready(function(){

    $(document).on('click', '.estate-summary', function(){
        $('.summary').removeClass('d-none');
        $('.discount, .client').addClass('d-none');
        // scrollDown();
        // $('html, body').animate({
        //     scrollTop: $(".down").offset().top
        // }, 1500);
    });

    $(document).on('click', '.estate-discount', function(){
        $('.discount').removeClass('d-none');
        $('.summary, .client').addClass('d-none');
        // scrollDown();
        // $('html, body').animate({
        //     scrollTop: $(".down").offset().top
        // }, 1500);
    });

    $(document).on('click', '.estate-client', function(){
        $('.client').removeClass('d-none');
        $('.discount, .summary').addClass('d-none');
        // scrollDown();
        // $('html, body').animate({
        //     scrollTop: $(".down").offset().top
        // }, 1500);
    });


    $(document).on('click', '.register-cse', function(){
        $('.cse-registration').removeClass('d-none');
        $('.technician-registration, .supplier-registration, .estate-registration').addClass('d-none');
        // scrollDown();
        $('html, body').animate({
            scrollTop: $(".down").offset().top
        }, 1500);
    });

    $(document).on('click', '.register-technician', function(){
        $('.technician-registration').removeClass('d-none');
        $('.cse-registration, .supplier-registration, .estate-registration').addClass('d-none');
        $('html, body').animate({
            scrollTop: $(".down-1").offset().top
        }, 1500);
    });

    $(document).on('click', '.register-supplier', function(){
        $('.supplier-registration').removeClass('d-none');
        $('.cse-registration, .technician-registration, .estate-registration').addClass('d-none');
        $('html, body').animate({
            scrollTop: $(".down-2").offset().top
        }, 1500);
    });

    $(document).on('click', '.register-estate', function(){
        $('.estate-registration').removeClass('d-none');
        $('.cse-registration, .technician-registration, .supplier-registration').addClass('d-none');
        $('html, body').animate({
            scrollTop: $(".down-3").offset().top
        }, 1500);
    });

    let count = 1;

    $(document).on('click', '.add-company', function(){
        count++;
        let buttonAction = $(this);
        addCompanies(count);
    });

    $(document).on('click', '.remove-company', function(){
        count--;
        $(this).closest(".remove-previous-employment").remove();
        // $(this).closest('tr').remove();
    });

    //Hide and Unhide Work Experience form
    $('#work_experience_yes').change(function () {
        if ($(this).prop('checked')) {
            $('.previous-employment').removeClass('d-none');
        }
    });

    $('#work_experience_no').change(function () {
        if ($(this).prop('checked')) {
            $('.previous-employment').addClass('d-none');
        }
    });

    //Hide and Unhide Work Experience form
    $('#convicted_yes').change(function () {
        if ($(this).prop('checked')) {
            $('.convicted').removeClass('d-none');
        }
    });

    $('#convicted_no').change(function () {
        if ($(this).prop('checked')) {
            $('.convicted').addClass('d-none');
        }
    });
});

function addCompanies(count){

    let html = '<div class="row remove-previous-employment"><div class="col-md-4"><div class="form-group position-relative"> <label>Company Name <span class="text-danger">*</span></label> <i data-feather="home" class="fas fa-home"></i> <input name="name" id="name" type="text" class="form-control pl-5"></div></div><div class="col-md-3"><div class="form-group position-relative"> <label>Start Date <span class="text-danger">*</span></label> <i data-feather="calendar" class="fea icon-sm icons"></i> <input name="name" id="name" type="date" class="form-control pl-5"></div></div><div class="col-md-3"><div class="form-group position-relative"> <label>End Date <span class="text-danger">*</span></label> <i data-feather="calendar" class="fea icon-sm icons"></i> <input name="name" id="name" type="date" class="form-control pl-5"></div></div><div class="col-md-2"><div class="form-group position-relative"> <label></label> <button type="button" class="form-control pl-5 mt-1 btn btn-icon btn-danger btn-block remove-company"><i data-feather="minus" class="icons"></i></button></div></div></div>';

    $('#add-companies').append(html);

}

function scrollDown(){
    $('html, body').animate({
        scrollTop: $(".down").offset().top
    }, 1500);
}
    // $(".down").click(function() {

    //  });

    // $(".up").click(function() {
    //      $('html, body').animate({
    //          scrollTop: $(".down").offset().top
    //      }, 1000);
    //  });

    $(document).ready(function () {

    });
