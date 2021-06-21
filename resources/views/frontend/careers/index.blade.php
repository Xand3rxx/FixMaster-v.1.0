@extends('layouts.app')
@section('title', 'Join Us')
@section('contents')
    @include('layouts.partials._messages')
    <style>
        .invalid-response{
            font-size: 12px !important;
            color: #e43f52;
        }
    </style>
    <section class="section bg-light">
        <div class="container" style="margin-top: 3rem;">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-4 pb-2">
                        <h4 class="title mb-4">We are Hiring!</h4>
                        <p class="text-muted para-desc mx-auto mb-0"> <span>FixMaster</span> is always looking for service
                            professionals who are experts in their trade and provide great service to their customers
                            ranging from Customer Service Executives(CSE's) to Technicians to Suppliers. The best home
                            service professionals use <span>FixMaster</span> for the great pay and flexible scheduling.</p>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

            <div class="row float-center text-center justify-content-center align-items-center mt-100">
                <div class="col-md-3 col-12">
                    <div class="features">
                        <div class="icons rounded h1 text-center text-primary px-3 position-relative d-inline-block">
                            <i class="uil uil-channel-add"></i>
                        </div>

                        <div class="content mt-4">
                            <h4 class="title-2">Customer Service Executive(CSE)</h4>
                            <p class="text-muted mb-0">Brief description here...</p>
                            <div class="mt-4">
                                <button type="button"
                                    class="btn btn-prim mt-2 mr-2 js-scroll-trigger register-cse">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-md-3 col-12 mt-5 mt-sm-0">
                    <div class="features">
                        <div class="icons rounded h1 text-center text-primary px-3 position-relative d-inline-block">
                            <i class="uil uil-truck-loading"></i>
                        </div>

                        <div class="content mt-4">
                            <h4 class="title-2">Technicians & Artisans</h4>
                            <p class="text-muted mb-0">Brief description here...</p>
                            <div class="mt-4">
                                <button type="button"
                                    class="btn btn-prim mt-2 mr-2 js-scroll-trigger register-technician">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-md-3 col-12 mt-5 mt-sm-0">
                    <div class="features">
                        <div class="icons rounded h1 text-center text-primary px-3 position-relative d-inline-block">
                            <i class="uil uil-shopping-cart"></i>
                        </div>

                        <div class="content mt-4">
                            <h4 class="title-2">Suppliers</h4>
                            <p class="text-muted mb-0">Brief job description here...</p>
                            <div class="mt-4">
                                <button type="button"
                                    class="btn btn-prim mt-2 mr-2 js-scroll-trigger register-supplier">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->


        </div>
        <!--end container-->

        <div class="container mt-100 mt-60">

            {{-- CSE Registration Start --}}
            <div class="row justify-content-center cse-registration d-none down">
                <div class="col-lg-10 col-md-12">
                    <div class="card custom-form border-0">
                        <div class="card-body">
                            <h4 class="title mb-4"> {{ __('CSE Application Form') }} </h4>

                            <form id="cse_applicant_form" class="rounded shadow p-4" method="POST"
                                action="{{ route('frontend.customer-service-executive.store', app()->getLocale()) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label> {{ __('First Name') }} <span class="text-danger">*</span></label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="first_name" value="{{ old('first_name') }}" id="first_name"
                                                type="text" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="last_name" id="last_name" type="text" class="form-control pl-5">
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Phone Number <span class="text-danger">*</span></label>
                                            <i data-feather="phone" class="fea icon-sm icons"></i>
                                            <input name="phone" id="phone" type="tel" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                            <input type="email" name="email" id="email" class="form-control pl-5">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Gender </label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <select required name="gender" class="form-control custom-select pl-5"
                                                id="Sortbylist-Shop">
                                                <option selected disabled value="0">Select...</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Date of Birth <span class="text-danger">*</span></label>
                                            <i data-feather="calendar" class="fea icon-sm icons"></i>
                                            <input type="date" max="{{ now()->subYears(18)->toDateString() }}"
                                                name="date_of_birth" id="date_of_birth" class="form-control pl-5">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group position-relative">
                                            <label>Residential Address <span class="text-danger">* <span
                                                        style="font-size: 10px;">Use auto complete feature after typing to
                                                        select your address</span></span></label>
                                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                            <textarea required name="address" id="user_address" rows="3"
                                                class="user_address form-control pl-5"
                                                placeholder="Your residential address :"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Upload Your Cv(DOC, DOCX or PDF) : <span class="text-danger">* <span
                                                        style="font-size: 10px;">Maximum size of 3mb</span></span> </label>
                                            <input name="cv" type="file"
                                                accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                class="form-control-file" id="fileupload">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Referral Code </label>
                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                            <input type="text" class="form-control pl-5 " placeholder="Enter Referral Code"
                                                name="referral_code" id="referral_code">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group position-relative">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="terms_cse"
                                                    class="form-control custom-control-input" id="customCheck1">

                                                <label class="custom-control-label" for="customCheck1">I Accept <a
                                                        data-toggle="modal" data-target="#terms" href="javascript:void(0)"
                                                        class="texty">Terms And Condition</a></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary"
                                            value="Apply Now">
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                            </form>
                            <!--end form-->
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of CSE Registration --}}

            {{-- Technician/Artisan Registration --}}
            <div class="row justify-content-center technician-registration d-none down-1">
                <div class="col-lg-10 col-md-12">
                    <div class="card custom-form border-0">
                        <div class="card-body">
                            <h4 class="title mb-4">Technician/Artisan Application Form</h4>
                            <form id="technician_application_form" class="rounded shadow p-4" enctype="multipart/form-data"
                                method="POST"
                                action="{{ route('frontend.technicain-artisan.store', app()->getLocale()) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="first_name" id="first_name" type="text" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="last_name" id="last_name" type="text" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Gender </label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <select name="gender" class="form-control custom-select pl-5"
                                                id="Sortbylist-Shop">
                                                <option selected disabled value="0">Select...</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Years of Experience <span class="text-danger">*</span></label>
                                            <i data-feather="calendar" class="fea icon-sm icons"></i>
                                            <input name="years_of_experience" id="years_of_experience" type="number"
                                                class="form-control pl-5" maxlength="2">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Your Email <span class="text-danger">*</span></label>
                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                            <input name="email" id="email" type="email" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Phone Number <span class="text-danger">*</span></label>
                                            <i data-feather="phone" class="fea icon-sm icons"></i>
                                            <input name="phone" id="phone" type="tel" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group position-relative">
                                            <label>Upload Certifications </label>
                                            <i data-feather="calendar" class="fea icon-sm icons"></i>
                                            <input name="certificate_upload[]" id="certificate_upload" type="file"
                                                accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                multiple class="form-control pl-5">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Residential Address <span class="text-danger">*</span></label>
                                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                            <textarea name="residential_address" id="user_address" rows="3"
                                                class="user_address form-control pl-5"
                                                placeholder="Your residential address :"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Postal Address </label>
                                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                            <textarea name="postal_address" rows="3" class="user_address form-control pl-5"
                                                placeholder="Your postal address :"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group position-relative">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="terms_technician"
                                                    class="form-control custom-control-input" id="terms_technician">

                                                <label class="custom-control-label" for="terms_technician">I Accept <a
                                                        data-toggle="modal" data-target="#terms" href="javascript:void(0)"
                                                        class="texty">Terms And Condition</a></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" id="submit" class="submitBnt btn btn-primary"
                                            value="Apply Now">
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                            </form>
                            <!--end form-->
                        </div>
                    </div>
                    <!--end custom-form-->
                </div>
            </div>
            {{-- End Technician/Artisan Registration --}}

            {{-- Supplier Registration --}}
            <div class="row justify-content-center supplier-registration d-none down-2">
                <div class="col-lg-10 col-md-12">
                    <div class="card custom-form border-0">
                        <div class="card-body">
                            <h4 class="title mb-4">Supplier Application Form</h4>
                            <form class="rounded shadow p-4" action="{{ route('frontend.supplier.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="first_name" id="first_name" type="text" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="last_name" id="last_name" type="text" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Your Email <span class="text-danger">*</span></label>
                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                            <input name="email" id="email" type="email" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Phone Number <span class="text-danger">*</span></label>
                                            <i data-feather="phone" class="fea icon-sm icons"></i>
                                            <input name="phone" id="phone" type="tel" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>CAC Number<span class="text-danger">*</span></label>
                                            <i data-feather="calendar" class="fea icon-sm icons"></i>
                                            <input name="cac_number" id="cac_number" type="text" class="form-control pl-5" minlength="5">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Company Name <span class="text-danger">*</span></label>
                                            <i data-feather="briefcase" class="fea icon-sm icons"></i>
                                            <input name="company_name" id="company_name" type="text" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Established On <span class="text-danger">*</span></label>
                                            <i data-feather="calendar" class="fea icon-sm icons"></i>
                                            <input name="establishment_date" id="establishment_date" type="date" class="form-control pl-5">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Service Category <span class="text-danger">*</span></label>
                                            <select class="form-control selectpicker @error('supplier_category') is-invalid @enderror" id="supplier_category" name="supplier_category[]" multiple="multiple" data-live-search="true">
                                                @foreach ($services as $service)
                                                <optgroup label="{{ $service->name }}">
                                                    @foreach($service->services as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Registered Address <span class="text-danger">*</span></label>
                                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                            <textarea name="registered_address" id="user_address" rows="3"
                                                class="user_address form-control pl-5"
                                                placeholder="Your registered address :"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Office Address <span class="text-danger">*</span></label>
                                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                            <textarea name="office_address" rows="3" class="user_address form-control pl-5"
                                                placeholder="Your office address :"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group position-relative">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="terms_supplier"
                                                    class="form-control custom-control-input" id="terms_supplier">

                                                <label class="custom-control-label" for="terms_supplier">I Accept <a
                                                        data-toggle="modal" data-target="#terms" href="javascript:void(0)"
                                                        class="texty">Terms And Condition</a></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary"
                                            value="Apply Now">
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                            </form>
                            <!--end form-->
                        </div>
                    </div>
                    <!--end custom-form-->
                </div>
            </div>
            {{-- End Supplier Registration --}}

        </div>
        <!--end container-->
    </section>
    <!--end section-->

    <!-- Modal Content Start -->
    <div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded shadow border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Terms & Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <h5>CSE Application Terms & Conditions</h5>
                    <ul class="list-unstyled text-mute">
                        <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I certify that the information
                            contained in this application is true and complete.</li>
                        <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I understand that false information
                            may be grounds for not hiring me or for immediate termination of the contract, if selected.</li>
                        <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I understand that if I am invited for
                            an interview, I will need to bring the printed application form, 2 passport photographs, a
                            formal proof of my identity and proof of my address.</li>
                        <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I understand that I will need to
                            provide at least 1 guarantor who must be between 30 - 70 years old and must be one of the
                            following:</li>
                        <ul class="list-unstyled text-muted">
                            <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> Civil Servant e.g.,
                                Principals, Teachers, State/Local Government Staff, etc.</li>
                            <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> Banker.</li>
                            <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> A practising
                                professional such as Lawyer, Doctor, Pilot, Chartered Accountant,
                                Registered Engineer, etc.</li>
                            <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> Lecturer II & above in a
                                reputable Higher Institution.</li>
                            <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> An Entrepreneur with a
                                registered business that has been operating for at least 5 years.</li>
                        </ul>

                        <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I authorise <span
                                class="text-primary">FixMaster</span> to verify any or all of the information provided
                            above, using all appropriate means.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Content End -->

    @push('scripts')
        <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ config('app.geolocation_api_key') }}&v=3.exp&libraries=places">
        </script>
        <script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>
        <script src="{{ asset('assets/js/geolocation.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/js/applicants.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.submitBnt').prop('disabled', false)
                $('.selectpicker').selectpicker();
                //Get list of L.G.A's in a particular state.
                $('#state_id').on('change', function() {
                    let stateId = $('#state_id').find('option:selected').val();
                    $.ajax({
                        url: "{{ route('lga_list', app()->getLocale()) }}",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "state_id": stateId
                        },
                        success: function(data) {
                            if (data) {
                                $('#lga_id').html(data.lgaList);
                            } else {
                                let stateName = $('#state_id').find('option:selected').text();
                                displayMessage('Error occured while trying to get L.G.A`s in ' +
                                    stateName + ' state', 'error');
                            }
                        },
                    })
                });
            });

        </script>
    @endpush
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/bootstrap-multiselect.css') }}">

        <style>
            .invalid-response {
                color: #e43f52;
            }

        </sty>
    @endpush
@endsection
