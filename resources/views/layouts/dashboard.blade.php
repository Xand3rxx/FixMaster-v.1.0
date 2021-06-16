<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@homefix.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">

    <!-- vendor css -->
    <link href="{{ asset('assets/dashboard/lib/fontawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/jquery.magnify.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4-custom.css') }}" />
    <link href="{{ asset('assets/dashboard/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/client/css/jquery.datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/lightgallery.css') }}" />

    @yield('css')
    @yield('styles')

</head>

<body>


    <style>
        div.dt-buttons {
            margin-top: 1em;
            margin-left: 1.5em;
        }

        button.dt-button,
        div.dt-button,
        a.dt-button,
        input.dt-button {
            font-size: inherit !important;
            color: #fff !important;
            background-color: #E97D1F !important;
            background: linear-gradient(to bottom, rgb(233 125 31) 0%, rgb(233 125 31) 100%);
            border-color: #E97D1F !important;
            display: inline-block !important;
            font-weight: 400 !important;
            text-align: center !important;
            vertical-align: middle !important;
            user-select: none !important;
            background-color: transparent !important;
            border: 1px solid transparent !important;
            padding: 0.46875rem 0.9375rem !important;
            font-size: 0.875rem !important;
            line-height: 1.5 !important;
            border-radius: 0.25rem !important;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
            line-height: 1.5 i !important;
            text-decoration: none;
            outline: none;
            text-overflow: ellipsis;
        }

        button.dt-button:hover,
        div.dt-button:hover,
        a.dt-button:hover,
        input.dt-button:hover {
            color: #fff !important;
            background-color: #E97D1F !important;
            background: linear-gradient(to bottom, rgb(233 125 31) 0%, rgb(233 125 31) 100%);
            border-color: #E97D1F !important;
        }
        
        .position-top{
            position:fixed;
            left:0;
            width:100%;
        z-index: 30000;        
        background: #8392a5;;
        border-color: #8392a5;;
        border-radius: 0;
        color:#fff;
            display: flex;
            justify-content: space-evenly;
            top:40px
        }

    </style>
  

   @if(!empty($RfqDispatchNotification) && Auth::user()->type->url == 'supplier'))
   @if(!empty($RfqDispatchNotification[0]))
   @if(Auth::user()->id == $RfqDispatchNotification[0]->supplier_id ))
   @if($RfqDispatchNotification[0]->notification == 'On')))
    <div class="alert alert-primary alert-dismissible position-top" role="alert">
                <span type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer">
                <!-- <span class="close-alert" aria-hidden="true">&times;</span> -->
                </span>
                <span class="">An urgent dispatch for warrant claim for job reference {{$RfqDispatchNotification[0]->service_request->unique_id}} is required .</span>
               {{-- <input type="checkbox" class="custom-control-inpu"  name="warranty_replacement_notify" value="Yes" 
                onclick="event.preventDefault();
                    document.getElementById('notify-form').submit();" 
                    href="{{ route('supplier.warranty_replacement_notify',  ['dispatch'=>$RfqDispatchNotification[0]->id, 'locale'=>app()->getLocale()]) }}"
                    >
                    <form id="notify-form" class="form-data" method="POST" style="display: none;"
                    action="{{route('supplier.warranty_replacement_notify', ['dispatch'=>$RfqDispatchNotification[0]->id, 'locale'=>app()->getLocale()])}}"  
                    enctype="multipart/form-data">
                    @csrf
                   </form>--}}
            </div>
            @endif
            @endif
            @endif
            @endif
   
    <input type="hidden" id="path_admin" value="{{url('/')}}">
    @include('layouts.partials._dashboard_sidebar')

    <div class="content ht-100v pd-0">
        @include('layouts.partials._dashboard_header')
        @yield('content')
        <div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg wd-sm-650" role="document">
                <div class="modal-content">
                    <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="text-center unique"></h4>
                        <hr>
                        <form action="{{ route('cse.handle.ratings', app()->getLocale()) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12">
                                    <div id="ratings_users"></div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-danger" aria-label="Close"> Skip </button>
                                </div>

                            </div>
                        </form>
                    </div><!-- modal-body -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->
    </div>

    <script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.aside.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.settings.js') }}"></script>

    <script src="{{ asset('assets/dashboard/assets/js/dashforge.sampledata.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery/jquery.magnify.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/chart.js/Chart.bundle.min.js') }}"></script>

    <!-- append theme customizer -->
    {{-- <script src="{{ asset('assets/dashboard/lib/js-cookie/js.cookie.js') }}"></script> --}}

    <script src="{{ asset('assets/dashboard/assets/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery-steps/build/jquery.steps.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/dashboard/assets/js/custom.js') }}"></script> --}}
    <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
    <input type="hidden" class="d-none" id="path_backEnd" value="{{ url('/') }}">

    <script src="{{ asset('assets/client/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/moment.js') }}"></script>

    <script src="{{ asset('assets/dashboard/assets/js/jquery.tinymce.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.geolocation_api_key') }}&v=3.exp&libraries=places">
    </script>
    <script src="{{ asset('assets/dashboard/assets/js/48a9782e-3e2b-4055-a9bb-8a926a937e2c.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/lightgallery-all.min.js') }}"></script>

    @yield('scripts')
    @stack('scripts')

    @if (\Request::filled('results') && \Request::filled('users') && \Request::filled('client') && \Request::filled('serviceRequestId') && \Request::filled('uniqueId'))
    <script>
        const data = @json(\Request::get('users'));
        const uniqueId = @json(\Request::get('uniqueId'));
        const client = @json(\Request::get('client'));
        var serviceRequestId = @json(\Request::get('serviceRequestId'));
        // client div to page
        let ratings_row = `<div class="row">
                                <div class="col-md-4 col-lg-4 col-4">
                                    <p id="user0" style="margin-top:20px;">` + client.first_name + " " + client.last_name + " (Client)" + `</p>
                                </div>
                                <div class="col-md-8 col-lg-8 col-8">
                                    <div class="tx-40 text-center rate">
                                        <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="1"></i>
                                        <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="2"></i>
                                        <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="3"></i>
                                        <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="4"></i>
                                        <i class="icon ion-md-star rates lh-0 tx-gray-300" data-number="5"></i>
                                        <input type="hidden" name="client_star" class="star" readonly>
                                        <input type="hidden" name="client_id" value=` + client.id + ` readonly>
                                    </div>
                                </div>
                            </div>`;
        $('#ratings_users').append(ratings_row);
        $('.unique').append('SERVICE REQUEST UNIQUEID - ' + uniqueId);
        // end of client
        $.each(data, function(key, user) {
            //console.log(key);
            if (user.roles[0].name != "Administrator" && user.uuid != '{{Auth::user()->uuid}}') {
                let ratings_row = `<div class="row">
                                        <div class="col-md-4 col-lg-4 col-4">
                                            <p id="user0" style="margin-top:20px;">` + user.account.first_name + " " + user.account.last_name + " " + "(" + user.roles[0].name + ")" + `</p>
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
                $('#ratings_users').append(ratings_row);
            }
        });

        $("#modalDetails").modal({
            show: true
        });

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
                title: 'Are you sure you want to skip this rating?'
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes'
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
                        url: "{{ route('cse.update_service_request', app()->getLocale()) }}"
                        , method: 'POST'
                        , data: {
                            "id": serviceRequestId
                        },
                        // return the result
                        success: function(data) {
                            // if (data) {
                            //     alert(data)
                            // } else {
                            //     alert('No It is not working');
                            // }
                        }

                    });
                    $("#modalDetails").modal('hide');
                }
            });
        });

    </script>
    @endif

</body>

</html>
