
var token = $('.get_token').attr('data-token');
var get_users_edit = $('#get_users_edit_url').attr('data-users-edit');


$(document).ready(function() {
    $('.selectpicker').selectpicker();

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


 var amount;
    $('#sum').change(function() {
        amount = $(this).val();
        $.ajax({
            url: get_users_edit,
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": token,
                "amount": amount
            },
            success: function(data) {
                if (data) {
                    $("#users").html(data.options).selectpicker('refresh');
                    $('.user-count').val(data.count).selectpicker('refresh');

                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })
    });

    $.ajax({
            url: get_users_edit,
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": token,
                data: $('#loyaltyForm').serialize()
               
            },
            success: function(data) {
                if (data) {
                    $("#users").html(data.options).selectpicker('refresh');
                    $('.user-count').val(data.count).selectpicker('refresh');

                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })


//get points percentage
let sum, point;
   if(!sum){
        $('#points').attr('disabled', 'true')  
    }

        $('#sum').keyup(function() {
        sum = $(this).val();
        if(!sum)
         $('#points').attr('disabled', 'true');

        if(sum)
        $('#points').removeAttr('disabled')   
        
        if (point && sum) {
        let newpoint = parseFloat(point) / 100 * parseInt(sum);
        $('#percentage').text(Math.round(newpoint));
        }else{
        $('#percentage').text('0.00'); 
        }
    });

 
    $('#points').keyup(function() {
         point = $(this).val();
    

        if (point && sum) {
        let newpoint = parseFloat(point) / 100 * parseInt(sum);
        $('#percentage').text(Math.round(newpoint));
        }else{
            $('#percentage').text('0.00'); 
        }
    });


        point = $('#points').val();
        sum = $('#sum').val();
        if(sum){
            $('#points').removeAttr('disabled')  
        }
            
    
        if (point != '' && sum != '') {
        let newpoint = parseFloat(point) / 100 * parseInt(sum);
        $('#percentage').text(Math.round(newpoint));
        }else{
        $('#percentage').text('0.00'); 
        }

    });