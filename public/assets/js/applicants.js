// $("#cse_applicant_form").validate();
$(function () {
    $("#cse_applicant_form").validate({
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
            date_of_birth: {
                required: true,
                dateISO: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                digits: true,
                minlength: 8,
                maxlength: 15
            },
            address: {
                required: true,
            },
            cv: {
                required: true,
            },
            terms_cse: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "First name field is mandatory",
                minlength: "First name should be atleast 5 characters long",
                maxlength: "First name should be atmost 180 characters long",
            },
            last_name: {
                required: "Last name field is mandatory",
                minlength: "Last name should be atleast 5 characters long",
                maxlength: "Last name should be atmost 180 characters long",
            },
            date_of_birth: {
                required: "Date of birth is mandatory",
            },
            email: {
                required: "Email address is mandatory",
                email: "Valid email address is mandatory"
            },
            phone: {
                required: 'Phone number is mandatory',
            },
            address: {
                required: "Residential address is mandatory",
            },
            cv: {
                required: "CV(Curriculum Vitae) is mandatory",
            },
            terms: {
                required: "Required",
            },
        },
        errorClass: "invalid-response",
        errorElement: "div",
        submitHandler: function (form) {
            $('.submitBnt').prop('disabled', true)
            form.submit();
        }
    });

    $("#technician_application_form").validate({
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

            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                digits: true,
                minlength: 8,
                maxlength: 15
            },
            residential_address: {
                required: true,
            },
            years_of_experience: {
                required: true,
            },
            terms: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "First name field is mandatory",
                minlength: "First name should be atleast 5 characters long",
                maxlength: "First name should be atmost 180 characters long",
            },
            last_name: {
                required: "Last name field is mandatory",
                minlength: "Last name should be atleast 5 characters long",
                maxlength: "Last name should be atmost 180 characters long",
            },

            email: {
                required: "Email address is mandatory",
                email: "Valid email address is mandatory"
            },
            phone: {
                required: 'Phone number is mandatory',
            },
            residential_address: {
                required: "Residential address is mandatory",
            },
            years_of_experience: {
                required: "Years of experience is mandatory",
            },
            terms: {
                required: "Required",
            },
        },
        errorClass: "invalid-response",
        errorElement: "div",
        submitHandler: function (form) {
            $('.submitBnt').prop('disabled', true)
            form.submit();
        }
    });
});
