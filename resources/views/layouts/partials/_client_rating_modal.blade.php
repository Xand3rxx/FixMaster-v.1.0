{{-- ##########################  Client Diagnosis Rating ##################### --}}
@if (\Request::filled('group') &&  \Request::filled('total_Amount') && \Request::filled('serviceRequestId') && \Request::filled('serviceId') && \Request::filled('uniqueId'))

@yield('scripts')
@stack('scripts')
<script>
  const group = @json(\Request::get('group'));
  const serviceId = @json(\Request::get('serviceId'));
  const totalAmount = @json(\Request::get('total_Amount'));
  const serviceRequestId = @json(\Request::get('serviceRequestId'));
  const unique_id = @json(\Request::get('uniqueId'));
  
  $(".show_msg").append("Kindly Rate the Service Diagnosis Performance and give a Review");
  
  
  let ratings_row1 = `<div class="row">
                                    <div class="col-md-4 col-lg-4 col-4">
                                        <p id="user0" style="margin-top:20px;"> Rate Service Diagnosis </p>
                                    </div>
                                    <div class="col-md-8 col-lg-8 col-8">
                                        <div class="tx-40 text-center rate">
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="1"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="2"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="3"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="4"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="5"></i>
                                            <input type="hidden" name="diagnosis_star" class="star" readonly>
                                            <input class="stage" type="hidden" name="stage" value="diagnosis" readonly>
                                        </div>
                                    </div>
                                </div>`;
            $('#ratin').append(ratings_row1);
            $('.unique').append('SERVICE REQUEST UNIQUEID - ' +unique_id);

  $.each(group, function(key, user1) {
    if(user1.roles[0].name == "Customer Service Executive"){
       //console.log(user.roles[0].name);
       let ratings_row1 = `<div class="row">
                                    <div class="col-md-4 col-lg-4 col-4">
                                        <p id="user0" style="margin-top:20px;">Rate ` + user1.account.first_name + " " + user1.account.last_name + " " + "(" + user1.roles[0].name + ")" + `</p>
                                    </div>
                                    <div class="col-md-8 col-lg-8 col-8">
                                        <div class="tx-40 text-center rate">
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="1"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="2"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="3"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="4"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="5"></i>
                                            <input type="hidden" name="users_star[]" class="star" readonly>
                                            <input type="hidden" name="users_id[]" value=` + user1.account.user_id + ` readonly>
                                        </div>
                                    </div>
                                </div>`;
            $('#ratin').append(ratings_row1);
    }
  });

    $("#modalDetails").modal({show: true});
    let stage = $(".stage").val();

    // Users Star Rating Count Integration
    $('.rates').on('click', function() {
        let ratedNumber = $(this).data('number');
        $(this).parent().children('.star').val(ratedNumber);
        $(this).parent().children().removeClass('tx-orange').addClass('tx-gray-300');
        $(this).prevUntil(".rate").removeClass('tx-gray-300').addClass('tx-orange');
        $(this).removeClass('tx-gray-300').addClass('tx-orange');
    });

    $(".btn-danger").on('click', function() {
        Swal.fire({
            title: 'Are you sure you want to skip this rating?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
           //console.log(result)
            if (result.isConfirmed) {
                Swal.fire(
                    'Rating Skipped'
                )

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('client.update_service_request', app()->getLocale()) }}",
                    method: 'POST',
                    data: {
                        "id": serviceRequestId, "stage": stage
                    },
                    // return the result
                    success: function(data) {
                      console.log(data);
                    }

                });
                $("#modalDetails").modal('hide');
            }
        });
    });

</script>
@endif

@if (\Request::filled('users') && \Request::filled('serviceRequestId') && \Request::filled('totalAmount') && \Request::filled('serviceId') && \Request::filled('unique_id'))

@yield('scripts')
@stack('scripts')
<script>
  //console.log('{{ \Request::get('results') }}');
  const users = @json(\Request::get('users'));
  const serviceId = @json(\Request::get('serviceId'));
  const totalAmount = @json(\Request::get('totalAmount'));
  const serviceRequestId = @json(\Request::get('serviceRequestId'));
  const unique_id = @json(\Request::get('unique_id'));
  $(".show_msg").append("Kindly rate the service performance and give a review to qualify for loyalty reward");

  let ratings_row = `<div class="row">
                                    <div class="col-md-4 col-lg-4 col-4">
                                        <p id="user0" style="margin-top:20px;"> Rate Job Performance </p>
                                    </div>
                                    <div class="col-md-8 col-lg-8 col-8">
                                        <div class="tx-40 text-center rate">
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="1"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="2"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="3"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="4"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="5"></i>
                                            <input type="hidden" name="diagnosis_star" class="star" readonly>
                                            <input class="stage" type="hidden" name="stage" value="final_rating" readonly>
                                        </div>
                                    </div>
                                </div>`;
            $('#ratings_cse').append(ratings_row);
            $('.unique').append('SERVICE REQUEST UNIQUEID - ' +unique_id);


  $.each(users, function(key, user) {
    if(user.roles[0].name == "Customer Service Executive"){
       //console.log(user.roles[0].name);
       let ratings_row = `<div class="row">
                                    <div class="col-md-4 col-lg-4 col-4">
                                        <p id="user0" style="margin-top:20px;">Rate ` + user.account.first_name + " " + user.account.last_name + " " + "(" + user.roles[0].name + ")" + `</p>
                                    </div>
                                    <div class="col-md-8 col-lg-8 col-8">
                                        <div class="tx-40 text-center rate">
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="1"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="2"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="3"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="4"></i>
                                            <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="5"></i>
                                            <input type="hidden" name="users_star[]" class="star" readonly>
                                            <input type="hidden" name="users_id[]" value=` + user.account.user_id + ` readonly>
                                        </div>
                                    </div>
                                </div>`;
            $('#ratings_cse').append(ratings_row);
    }
  });
    $("#modalDetails").modal({show: true});
    let stage = $(".stage").val();

    // Users Star Rating Count Integration
    $('.rates').on('click', function() {
        let ratedNumber = $(this).data('number');
        $(this).parent().children('.star').val(ratedNumber);
        $(this).parent().children().removeClass('tx-orange').addClass('tx-gray-300');
        $(this).prevUntil(".rate").removeClass('tx-gray-300').addClass('tx-orange');
        $(this).removeClass('tx-gray-300').addClass('tx-orange');
    });

    $(".btn-danger").on('click', function() {
        Swal.fire({
            title: 'Are you sure you want to skip this rating?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Rating Skipped'
                )

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('client.update_service_request', app()->getLocale()) }}",
                    method: 'POST',
                    data: {
                        "id": serviceRequestId,"stage":stage
                    },
                    // return the result
                    success: function(data) {
                      console.log(data);
                    }

                });
                $("#modalDetails").modal('hide');
            }
        });
    });

</script>
@endif