$(document).ready(function() {
    //Get sent invoice quote
    $(document).on('click', '#rfq-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-body').modal("show");
              $('#modal-body').html('');
              $('#modal-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    //Get image associated with invoice quote
    $(document).on('click', '#rfq-image-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-image-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-image-body').modal("show");
              $('#modal-image-body').html('');
              $('#modal-image-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });


    $(document).on('click', '#dispatch', function(event) {
      event.preventDefault();

      //Get row attributes for id's
      let rfq = $(this).attr('data-rfq');
      let rfqId = $(this).attr('data-rfq-id');
      let supplierRfqId = $(this).attr('data-supplier-invoice');

      //Set row attbutes to hidden field in the modal
      $('#dispatchModal').modal("show");
      $('#rfq, #rfq-label').val(rfq);
      $('#rfq-label').text(rfq);
      $('#rfq_id').val(rfqId);
      $('#supplier_rfq_id').val(supplierRfqId);

    });

    //Generate Code for Dispatch
    $(document).on('click', '.generate-new-code', function(event) {
      event.preventDefault();
      let route = $('#generate-dispatch-code').attr('data-url');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#unique_id").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#unique_id').val(result);
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve a new dispatch code';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    

  });


  function individualAmount(count)
  {
    var unitPrice = parseFloat(($('#unit-price-'+count).val().replace(/,/g , '')));
    var quantity  = parseInt($('.quantity-'+count).text());
    var totalAmount = (unitPrice * quantity);
    $('#unit-amount-'+count).val(totalAmount);
    $('.amount-'+count).text(numberWithCommas(totalAmount.toFixed(2)));
    getTotalAmount();
  }

  function deliveryFee(){
    // $('#delivery_fee').keyup(function(){
    //     return $(this).val();
    // });
    $('.delivery-fee').text(numberWithCommas($('#delivery_fee').val()));
    getTotalAmount();
  }

  function getTotalAmount()
  {
    var totalEachAmount = 0;
    var totalAmount = 0;

    $('.each-amount').each(function (){
        var total  = parseInt($(this).val());
        if(isNaN(total) == false){
          totalEachAmount += total;
          $('.total-amount').text('₦'+numberWithCommas(totalEachAmount.toFixed(2)));
          $('#total_amount').val(totalEachAmount);
          // return totalEachAmount;
        }
    });
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }


  if($('#delivery_fee').val()){
    getTotalAmount();
  }
 

