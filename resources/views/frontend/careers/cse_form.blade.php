<form class="rounded shadow p-4" method="POST" action="{{route('frontend.customer-service-executive.store', app()->getLocale())}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label> {{__('First Name')}} <span class="text-danger">*</span></label>
                <i data-feather="user" class="fea icon-sm icons"></i>
                <input name="first_name_cse" id="first_name_cse" required type="text" class="form-control pl-5">
            </div>
        </div>
        <!--end col-->
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Last Name <span class="text-danger">*</span></label>
                <i data-feather="user" class="fea icon-sm icons"></i>
                <input name="last_name_cse" id="last_name_cse" required type="text" class="form-control pl-5">
            </div>
        </div>
        <!--end col-->
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Your Email <span class="text-danger">*</span></label>
                <i data-feather="mail" class="fea icon-sm icons"></i>
                <input name="email_cse" id="email_cse" type="tel" required class="form-control pl-5">
            </div>
        </div>
        <!--end col-->

        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Phone Number <span class="text-danger">*</span></label>
                <i data-feather="phone" class="fea icon-sm icons"></i>
                <input name="phone_cse" id="phone_cse" type="tel" required maxlength="11" class="form-control pl-5">
            </div>
        </div>
        <!--end col-->

        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Address <span class="text-danger">*</span></label>
                <i data-feather="map-pin" class="fea icon-sm icons"></i>
                <textarea name="address_cse" id="user_address" required rows="3" class="user_address form-control pl-5" placeholder="Your residential address :"></textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Referral Code </label>
                <i data-feather="key" class="fea icon-sm icons"></i>
                <input type="text" class="form-control pl-5 " placeholder="Referral Code" name="referral_code_cse" id="referral_code">

            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Are you 18yrs or above?<span class="text-danger">*</span></label>
                <div class="form-row ml-1">
                    <div class="custom-control custom-radio ">
                        <input type="radio" id="customRadio3" name="18_or_above" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio3">Yes</label>
                    </div>

                    <div class="custom-control custom-radio ml-4">
                        <input type="radio" id="customRadio4" name="18_or_above" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio4">No</label>
                    </div>
                </div>

            </div>
        </div>
        <!--end col-->

        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Do you have previous Work Experience?<span class="text-danger">*</span></label>
                <div class="form-row ml-1">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="work_experience_yes" name="work_experience_cse" class="custom-control-input">
                        <label class="custom-control-label" for="work_experience_yes">Yes</label>
                    </div>

                    <div class="custom-control custom-radio ml-4">
                        <input type="radio" id="work_experience_no" name="work_experience_cse" class="custom-control-input">
                        <label class="custom-control-label" for="work_experience_no">No</label>
                    </div>
                </div>

            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row previous-employment d-none">
        <div class="col-md-4">
            <div class="form-group position-relative">
                <label>Company Name <span class="text-danger">*</span></label>
                <i data-feather="home" class="fea icon-sm icons"></i>
                <input name="company_name" id="name" type="text" class="form-control pl-5">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group position-relative">
                <label>Start Date <span class="text-danger">*</span></label>
                <i data-feather="calendar" class="fea icon-sm icons"></i>
                <input name="name" id="name" type="date" class="form-control pl-5">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group position-relative">
                <label>End Date <span class="text-danger">*</span></label>
                <i data-feather="calendar" class="fea icon-sm icons"></i>
                <input name="name" id="name" type="date" class="form-control pl-5">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group position-relative">
                <label></label>
                <button type="button" class="form-control pl-5 mt-1 btn btn-icon btn-primary btn-block add-company"><i data-feather="plus" class="icons"></i></button>
            </div>
        </div>
    </div>

    <div id="add-companies"></div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Have you been convicted of any crime within the last five years?<span class="text-danger">*</span></label>
                <div class="form-row ml-1">
                    <div class="custom-control custom-radio form-group position-relative">
                        <input type="radio" id="convicted_yes" name="convicted" class="custom-control-input">
                        <label class="custom-control-label" for="convicted_yes">Yes</label>
                    </div>

                    <div class="custom-control custom-radio form-group position-relative ml-4">
                        <input type="radio" id="convicted_no" name="convicted" class="custom-control-input">
                        <label class="custom-control-label" for="convicted_no">No</label>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->

        <div class="col-md-6">
            <div class="form-group">
                <label>If hired, are you willing to submit to and pass a controlled substance test?<span class="text-danger">*</span></label>
                <div class="form-row ml-1">
                    <div class="custom-control custom-radio form-group position-relative">
                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio3">Yes</label>
                    </div>

                    <div class="custom-control custom-radio form-group position-relative ml-4">
                        <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio4">No</label>
                    </div>
                </div>

            </div>
        </div>
        <!--end col-->
    </div>

    <div class="row convicted d-none">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Nature of Crime <span class="text-danger">*</span></label>
                <i data-feather="hexagon" class="fea icon-sm icons"></i>
                <input name="name" id="name" type="text" class="form-control pl-5">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label> Date of Conviction<span class="text-danger">*</span></label>
                <i data-feather="calendar" class="fea icon-sm icons"></i>
                <input name="namer" id="name" type="date" class="form-control pl-5">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Can you work evenings?<span class="text-danger">*</span></label>
                <div class="form-row ml-1">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio3">Yes</label>
                    </div>

                    <div class="custom-control custom-radio ml-4">
                        <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio4">No</label>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->

        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Are you available to work overtime?<span class="text-danger">*</span></label>
                <div class="form-row ml-1">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio3">Yes</label>
                    </div>

                    <div class="custom-control custom-radio ml-4">
                        <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio4">No</label>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Do you own or have access to a car, bike or van that you can use for transport?<span class="text-danger">*</span></label>
                <div class="form-row ml-1">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio3">Yes</label>
                    </div>

                    <div class="custom-control custom-radio ml-4">
                        <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio4">No</label>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->

        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>If yes, Which do you own?<span class="text-danger">*</span></label>
                <select class="form-control custom-select" id="Sortbylist-Shop">
                    <option>Select...</option>
                    <option>Bus</option>
                    <option>Car</option>
                    <option>Motorcycle</option>
                    <option>Van/Pickup Truck</option>
                </select>
            </div>
        </div>
        <!--end col-->
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Do you believe you have what it takes to succeed as a CSE?<span class="text-danger">*</span></label>
                <div class="form-row ml-1">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio3">Yes</label>
                    </div>

                    <div class="custom-control custom-radio ml-4">
                        <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio4">No</label>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->

        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>If yes, Tell us why<span class="text-danger">*</span></label>
                <i data-feather="book" class="fea icon-sm icons"></i>
                <textarea name="message" id="message" rows="2" class="form-control pl-5" placeholder=""></textarea>
            </div>
        </div>
        <!--end col-->
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Upload Your Cv(DOC, DOCX or PDF) :</label>
                <input type="file" class="form-control-file" id="fileupload">
            </div>
        </div>
        <!--end col-->

        <div class="col-md-6">
            <div class="form-group position-relative">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">I Accept <a data-toggle="modal" data-target="#terms" href="javascript:void(0)" class="texty">Terms And Condition</a></label>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->

    <div class="row">
        <div class="col-sm-12">
            <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary" value="Apply Now">
        </div>
        <!--end col-->
    </div>
    <!--end row-->

</form>