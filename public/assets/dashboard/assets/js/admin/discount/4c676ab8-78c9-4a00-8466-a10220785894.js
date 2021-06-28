

//routes
var entity_estates =  $('#get_estate_url').attr('data-estate');
var enity_client = $('#get_client_users_url').attr('data-client');
var get_state = $('#get_state_url').attr('data-state');
var get_lga = $('#get_lga_url').attr('data-lga');
var get_category = $('#get_category_url').attr('data-category');
var get_services = $('#get_services_url').attr('data-services');


$(document).ready(function() {
    $('.selectpicker').selectpicker();

    $('.custom-select.cs-select').change(function() {
        $('.custom-select.cs-select').each(function(index, item) {
            if ($(this).children("option:selected").val()) {
                $(this).next('.invalid-feedback-err').hide();
            }

        });
    });

    $('.custom-input-1').on('blur', function() {
        $('.custom-input-1').each(function(index, item) {
            if ($(this).val() !== '') {
                $(this).next('.invalid-feedback-err').hide();
            }

        });
    });


    $('#rate').keyup(function() {
        let rate = $(this).val();
        let newrate = parseFloat(rate) / 100;
        if (rate) {
        let newrate = parseFloat(rate) / 100;
        $('#percentage').text(newrate);
    }else{
        $('#percentage').text('0'); 
    }
    });


    let rate = $('#rate').val();
    if (rate) {
        let newrate = parseFloat(rate) / 100;
        $('#percentage').text(newrate);
    }else{
        $('#percentage').text('0'); 
    }

});


$(document).ready(function() {

    $('.selectpicker.select-user').on('change', function() {
        var selectPicker = $(this);
        var selectAllOption = selectPicker.find('option.select-all');
        var checkedAll = selectAllOption.prop('selected');
        var optionValues = selectPicker.find('option[value!="[all]"][data-divider!="true"]');

        if (checkedAll) {
            // Process 'all/none' checking
            var allChecked = selectAllOption.data("all") || false;

            if (!allChecked) {
                optionValues.prop('selected', true).parent().selectpicker('refresh');
                selectAllOption.data("all", true);
            } else {
                optionValues.prop('selected', false).parent().selectpicker('refresh');
                selectAllOption.data("all", false);
            }

            selectAllOption.prop('selected', false).parent().selectpicker('refresh');
        } else {
            // Clicked another item, determine if all selected
            var allSelected = optionValues.filter(":selected").length == optionValues.length;
            selectAllOption.data("all", allSelected);
        }
    }).trigger('change');


    $('.selectpicker.select-all-service').on('change', function() {
        var selectPicker = $(this);
        var selectAllOption = selectPicker.find('option.select-all');
        var checkedAll = selectAllOption.prop('selected');
        var optionValues = selectPicker.find('option[value!="all"][data-divider!="true"]');

        if (checkedAll) {
            // Process 'all/none' checking
            var allChecked = selectAllOption.data("all") || false;

            if (!allChecked) {
                optionValues.prop('selected', true).parent().selectpicker('refresh');
                selectAllOption.data("all", true);
            } else {
                optionValues.prop('selected', false).parent().selectpicker('refresh');
                selectAllOption.data("all", false);
            }

            selectAllOption.prop('selected', false).parent().selectpicker('refresh');
        } else {
            // Clicked another item, determine if all selected
            var allSelected = optionValues.filter(":selected").length == optionValues.length;
            selectAllOption.data("all", allSelected);
        }
    }).trigger('change');



    $('.selectpicker.select-services').on('change', function() {
        var selectPicker = $(this);
        var selectAllOption = selectPicker.find('option.select-all');
        var checkedAll = selectAllOption.prop('selected');
        var optionValues = selectPicker.find('option[value!="all-services"][data-divider!="true"]');


        if (checkedAll) {
            // Process 'all/none' checking
            var allChecked = selectAllOption.data("all") || false;

            if (!allChecked) {
                optionValues.prop('selected', true).parent().selectpicker('refresh');
                selectAllOption.data("all", true);
            } else {
                optionValues.prop('selected', false).parent().selectpicker('refresh');
                selectAllOption.data("all", false);
            }

            selectAllOption.prop('selected', false).parent().selectpicker('refresh');
        } else {
            // Clicked another item, determine if all selected
            var allSelected = optionValues.filter(":selected").length == optionValues.length;
            selectAllOption.data("all", allSelected);
        }
    }).trigger('change');
});

//ajax 
$(document).ready(function() {
    var state, entity_user_type = '';

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#state_id').change(function() {
        state = $(this).children("option:selected").val();
        $.ajax({
            url: get_lga,
            method: "POST",
            dataType: "JSON",
            data: {
                "state_id": state
            },
            success: function(data) {
                if (data) {
                    $('#lga_id').html(data.lgas);
                    $("#lga_list").html(data.lgas).selectpicker('refresh');
                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })
    });
    $('.get_users').on("change", function() {
        var entity = $('#entity_id').children("option:selected").val();
        if (entity != '') {
            $.ajax({
                url: enity_client,
                method: "POST",
                dataType: "JSON",
                data: {
                    data: $('#discountForm').serialize()
                },
                beforeSend: function() {
                    $(".spinner1").removeClass('d-none');
                  },
                success: function(data) {
                    if (data) {
                        setTimeout(() => {
                            $(".spinner1").addClass('d-none'); 
                        }, 500);
                        $("#users").html(data.options).selectpicker('refresh');
                        $("#service-users").html(data.options).selectpicker('refresh');
                        $('.user-count').val(data.count).selectpicker('refresh');
                    } else {
                        var message =
                            'Error occured while trying to get Enity Parameter List`s in ';
                        var type = 'error';
                        displayMessage(message, type);
                        ory
                    }
                },
            })
        } else {
            $('#entity_id ~.invalid-feedback-err').html('Please select an Entity');
        }

    });



    $('#estate_id').on("change", function() {
        $.ajax({
            url: enity_client,
            method: "POST",
            dataType: "JSON",
            data: {             
                data: $('#discountForm').serialize()
            },
            beforeSend: function() {
                $(".spinner1").removeClass('d-none');
              },
            success: function(data) {
                if (data) {
                    setTimeout(() => {
                        $(".spinner1").addClass('d-none'); 
                    }, 500);
                    $("#estate-user").html(data.options).selectpicker('refresh');
                    $('.user-count-estate').val(data.count).selectpicker('refresh');
                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                    ory
                }
            },
        });

    });


    $('.selectpicker.select-all-service').on('changed.bs.select', function(e, clickedIndex, isSelected,
        previousValue) {
        var categoryid = $(this).val();
        $.ajax({
            url: get_services,
            method: "POST",
            dataType: "JSON",
            data: {
                data: categoryid.length > 0 ? categoryid : '1'
            },
            beforeSend: function() {
                $(".spinner1").removeClass('d-none');
              },
            success: function(data) {
                if (data) {
                    setTimeout(() => {
                        $(".spinner1").addClass('d-none'); 
                    }, 500);
                    $("#service_id").html(data.service).selectpicker('refresh');
                } else {
                    var message =
                        'Error occured while trying to get Category List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })


    });

});

//when page loads 
$(document).ready(function() {



$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

 var entity = $('#entity_id').children("option:selected").val();
    if (entity === 'client') {
        $('.show-service').addClass('d-none');
        $('.parameter').removeClass('d-none');
        $('.add-users').removeClass('d-none');
    }
    if (entity === 'estate') {
        $('.show-estate').removeClass('d-none');
        $('.show-estate').show();
        $('.show-service').addClass('d-none');
        $('.parameter').removeClass('d-none');
        $('.add-users').addClass('d-none');
       

        $.ajax({
            url: entity_estates,
            method: "POST",
            dataType: "JSON",
           
            success: function(data) {
                if (data) {
                    $('#estate_id').html(data.estates);
                } else {
                    var message =
                        'Error occured while trying to get Enity Estate List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        });

    } else {
        $('.show-estate').addClass('d-none');
    }



    if (entity === 'service') {
        $('.show-service').removeClass('d-none');
        $('.show-estate').addClass('d-none');
        $('.parameter').addClass('d-none');

        $.ajax({
            url: get_category,
            method: "POST",
            dataType: "JSON",
        
            success: function(data) {
                if (data) {
                    $('#category_id').html(data.category).selectpicker('refresh');

                } else {
                    var message =
                        'Error occured while trying to get Enity Estate List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })
    }



    if (entity) {
        $.ajax({
            url: enity_client,
            method: "POST",
            dataType: "JSON",
            data: {
                data: $('#discountForm').serialize()
            },
            success: function(data) {
                if (data) {
                    $("#users").html(data.options).selectpicker('refresh');
                    $("#service-users").html(data.options).selectpicker('refresh');
                    $('.user-count').val(data.count).selectpicker('refresh');
                    $('.user-count-estate').val(data.count).selectpicker('refresh');
                   
                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })
    }

});


//when there is onchange event
$(document).ready(function() {
    $('#entity_id').on("change", function() {


        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var entity = $(this).children("option:selected").val();
        if (entity === 'client') {
            $('.show-service').addClass('d-none');
            $('.parameter').removeClass('d-none');
            $('.add-users').removeClass('d-none');
          
        }
        if (entity === 'estate') {
            $('.show-estate').removeClass('d-none');
            $('.show-estate').show();
            $('.show-service').addClass('d-none');
            $('.parameter').removeClass('d-none');
            $('.add-users').addClass('d-none');
           

            $.ajax({
                url: get_state,
                method: "POST",
                dataType: "JSON",
            
                success: function(data) {
                    if (data) {
                        $('#estate_id').html(data.estates);
                    } else {
                        var message =
                            'Error occured while trying to get Enity Estate List`s in ';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })
        } else {
            $('.show-estate').addClass('d-none');
        }

        if (entity === 'service') {
            $('.show-service').removeClass('d-none');
            $('.show-estate').addClass('d-none');
            $('.parameter').addClass('d-none');

            $.ajax({
                url: get_category,
                method: "POST",
                dataType: "JSON",
                success: function(data) {
                    if (data) {
                        $('#category_id').html(data.category).selectpicker('refresh');

                    } else {
                        var message =
                            'Error occured while trying to get Enity Estate List`s in ';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })

        } else {
        
            $('.show-service').addClass('d-none');
        }


        if (entity) {
            $.ajax({
                url: enity_client,
                method: "POST",
                dataType: "JSON",
                data: {
                    data: $('#discountForm').serialize()
                },
                beforeSend: function() {
                    $(".spinner1").removeClass('d-none');
                  },
                success: function(data) {
                    if (data) {
                        $(".spinner1").addClass('d-none');
                        $("#users").html(data.options).selectpicker('refresh');
                        $("#service-users").html(data.options).selectpicker('refresh');
                        $('.user-count').val(data.count).selectpicker('refresh');
                    } else {
                        var message =
                            'Error occured while trying to get Enity Users List`s in ';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                }
            });
        }

    });

});

