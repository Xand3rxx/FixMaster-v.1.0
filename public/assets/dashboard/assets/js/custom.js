$(document).ready(function(){

    //Prevent characters or string asides number in ohone number input field 
    $("#phone_number, .quantity, .quantity-2, .amount").on("keypress keyup blur", function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });  

    $(document).on('click', '.register-cse', function(){
        $('.cse-registration').removeClass('d-none');    
        $('.technician-registration, .supplier-registration').addClass('d-none');
    });

    $(document).on('click', '.register-technician', function(){
        $('.technician-registration').removeClass('d-none');    
        $('.cse-registration, .supplier-registration').addClass('d-none');
    });

    $(document).on('click', '.register-supplier', function(){
        $('.supplier-registration').removeClass('d-none');    
        $('.cse-registration, .technician-registration').addClass('d-none');
    });

    let count = 1;

    //Add and Remove Request for 
    $(document).on('click', '.add-rfq', function(){
        count++;
        addRFQ(count);
    });

    $(document).on('click', '.remove-rfq', function(){
        count--;
        $(this).closest(".remove-rfq-row").remove();
        // $(this).closest('tr').remove();
    });

    //Add and Remove Tools request form
    $(document).on('click', '.add-trf', function(){
        count++;
        addTRF(count);
    });

    $(document).on('click', '.remove-trf', function(){
        count--;
        $(this).closest(".remove-trf-row").remove();
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

    //Hide and Unhide RFQ
    $('#rfqYes').change(function () {
        if ($(this).prop('checked')) {
            $('.d-rfq').removeClass('d-none');    
        }
    });

    $('#rfqNo').change(function () {
        if ($(this).prop('checked')) {
            $('.d-rfq').addClass('d-none');    
        }
    });

    //Hide and Unhide TRF
    $('#trfYes').change(function () {
        if ($(this).prop('checked')) {
            $('.d-trf').removeClass('d-none');    
        }
    });

    $('#trfNo').change(function () {
        if ($(this).prop('checked')) {
            $('.d-trf').addClass('d-none');    
        }
    });
});

function addRFQ(count){

    let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="inputEmail4">Component Name</label> <input type="text" class="form-control" id="inputEmail4"></div><div class="form-group col-md-4"> <label for="inputPassword4">Model Number</label> <input type="text" class="form-control" id="inputPassword4" placeholder=""></div><div class="form-group col-md-2 mt-2"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5" ></i></button></div></div>';

    $('.add-rfq-row').append(html);

}

function addTRF(count){

    let html = '<div class="form-row remove-trf-row"><div class="form-group col-md-4"> <label for="inputEmail4">Equipment/Tools Name</label> <input type="text" class="form-control" id="inputEmail4"></div><div class="form-group col-md-2"> <label for="inputPassword4">Quantity</label> <input type="tel" class="form-control quantity-2" maxlength="2" id="inputPassword4" placeholder=""></div><div class="form-group col-md-2 mt-2"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-trf" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i> </button></div></div>';

    $('.add-trf-row').append(html);

}