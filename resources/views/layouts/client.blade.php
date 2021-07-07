<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-alt-name" content="{{ config('app.geolocation_api_key') }}">

    <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@fixmaster.com.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Slider -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.carousel.min.css') }}" />

    {{-- <link rel="stylesheet" href="{{ asset('assets/client/css/owl.theme.default.min.css') }}" /> --}}

    {{-- <link href="{{ asset('assets/dashboard/lib/fontawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/dashboard/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/client/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link rel="stylesheet" href="{{ asset('assets/client/css/jquery.datetimepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/client/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/client/datatables/dataTables.bs4-custom.css') }}" />
    <link href="{{ asset('assets/client/css/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/client/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">

    <style>
      .card {
        /* border: 1px solid rgba(233,125,31,0.2) !important; */
        box-shadow: 0 2px 5px rgba(233, 125, 31, 0.2) !important;
      }

      .shadow {
        box-shadow: 0 2px 5px rgba(233, 125, 31, 0.2) !important;
      }

      .swal2-styled.swal2-confirm a.confirm-link {
        color: #fff  !important;
        font-size: 1.0625em;
      }

      .tx-gray-300 {
        color: #cdd4e0;
      }

      .lh-0 {
        line-height: 0;
      }

      .tx-40 {
        font-size: 40px;
      }

      .tx-orange {
        color: #fd7e14;
      }
      .pplogo-container {
        border: 2px solid #e97d1f !important;
        box-shadow: 0px 3px 10px -2px rgb(233 125 31) !important;
      }

      input[type="radio"]:checked + .pplogo-container {
          /* background: #fd7e14; */
          box-shadow: 0px 0px 20px rgb(233 125 31);
          box-shadow: 0px 0px 20px rgb(233 125 31);
      }

      input[type="radio"]:checked + .pplogo-container::after {
        color: #fd7e14 !important;
        border: 1px solid #fd7e14 !important;
      }
    </style>
  </head>

  <body>



    {{-- <div id="preloader">
      <div id="status">
          <div class="spinner">
              <div class="double-bounce1"></div>
              <div class="double-bounce2"></div>
          </div>
      </div>
  </div> --}}

    {{-- @include('layouts.partials._messages') --}}
    @include('layouts.partials._client_header')
    @include('layouts.partials._client_sidebar')
    @include('layouts.partials._client_footer')

    <script src="{{asset('assets/frontend/js/jquery-3.5.1.min.js')}}"></script>
    {{-- <script src="{{asset('assets/client/js/jquery.min.js')}}"></script> --}}
    <script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/scrollspy.min.js')}}"></script>

          <!-- geolocation asset starts here -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.geolocation_api_key') }}&v=3.exp&libraries=places"></script>
     <script src="{{asset('assets/js/geolocation.js')}}"></script>
     <!-- geolocation asset starts here -->

    <!-- SLIDER -->
    <script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/owl.init.js')}}"></script>
    <!-- Icons -->
    <script src="{{asset('assets/frontend/js/feather.min.js')}}"></script>
    <!-- Switcher -->
    <script src="{{asset('assets/frontend/js/switcher.js')}}"></script>
    <!-- Main Js -->
    <script src="{{asset('assets/frontend/js/app.js')}}"></script>
    <!-- scroll -->
    {{-- <script src="{{ asset('assets/frontend/js/scroll.js')}}"></script> --}}
    <script src="{{ asset('assets/frontend/js/typed/lib/typed.js')}}"></script>
    <script src="{{ asset('assets/client/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/client/datatables/dataTables.bootstrap.min.js') }}"></script>
    <!-- Datepicker -->
    <script src="{{ asset('assets/client/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/moment.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/polyfill.js') }}"></script>
    <script src="https://unicons.iconscout.com/release/v2.1.9/script/monochrome/bundle.js"></script>
    <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/jquery.tinymce.min.js') }}"></script>


    <div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg wd-sm-650" role="document">
            <div class="modal-content">
                <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
                    <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
       <h4 class="text-center unique"></h4><hr>
    <h6 class="text-center show_msg"></h6>
    <form action="{{ route('client.handle.ratings', app()->getLocale()) }}" method="POST">
        @csrf
            <div class="row">
        <div class="col-md-12 col-lg-12 col-12">
            <div id="ratings_cse"></div>
            <div id="ratin"></div>
                </div>

                    <div id="reviewText" class="form-group col-md-12 col-lg-12">
                        <label>Leave a review</label>
                        <textarea name="review" class="form-control" rows="4"
                            placeholder=""></textarea>
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
{{---############# Rating modals triggers #############---}}
    @include('layouts.partials._client_rating_modal')
    <script>
        function displayMessage(message, type){

          const Toast = swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 8000,
              timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
          });
          Toast.fire({
                  icon: type,
                //   type: 'success',
                  title: message
          });

        }
    </script>



 @yield('scripts')
 @stack('scripts')

    <script>
      $(document).ready(function () {

        // Basic DataTable
        $('#basicExample').DataTable({
          'iDisplayLength': 10,
          language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ Items/page',
              }
        });


        //Prevent characters or string asides number in ohone number input field
        $("#number, #phone_number, #alternate_phone_number").on("keypress keyup blur", function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $(document).on('click', '#service-date-time', function() {
          $('#service-date-time').datetimepicker({
              // format: 'L', //LT for time only
              // inline: true,
              // sideBySide: true,
              timepicker:false,
              format: 'Y/m/d',
              formatDate: 'Y/m/d',
              minDate: '-1970/01/02', // yesterday is minimum date
              mask: true,
          });
      });

      $(function () {
        $('.popup-modal').magnificPopup({
          type: 'inline',
          preloader: false,
          focus: '#username',
          modal: true
        });
        $(document).on('click', '.popup-modal-dismiss', function (e) {
          e.preventDefault();
          $.magnificPopup.close();
        });
      });

      // $('.urgent').click(function(){
      //   alert('Urgent Service Required');

      // })



      });

    </script>




  </body>
</html>
