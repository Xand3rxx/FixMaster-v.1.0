  <!-- Footer Start -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                <a href="{{ route('frontend.index', app()->getLocale()) }}" class="logo-footer">
                        <img class=" preload-me" src="{{ asset('assets/images/home-fix-logo-new.png') }}"
                        style="margin-top: -65px !important; margin-bottom: -38px !important;" height="160" alt="FixMaster.ng">
                    </a>
                    <p class="mt-4">FixMaster is Nigeria’s Topmost maintenance service provider. We install service and repair all household and office appliances. We also provide maintenance and service facilities for all plumbing, electrical, security, interior decorations, carpentry, cleaning, and gardening services. When FixMaster repairs - you RELAX!!!</p>
                    <ul class="list-unstyled social-icon social mb-0 mt-4">
                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                    data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                    data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                    data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                    data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                    </ul>
                    <!--end icon-->
                </div>
                <!--end col-->

                <div class="col-lg-2 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <h4 class="text-light footer-head">Company</h4>
                    <ul class="list-unstyled footer-list mt-4">
                        <li><a href="{{ route('frontend.about', app()->getLocale()) }}" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> About Us</a></li>
                        <li><a href="{{ route('frontend.about', app()->getLocale()) }}" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> FAQ</a></li>
                        <li><a href="{{ route('frontend.careers', app()->getLocale()) }}" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> Join Us</a></li>
                        <li><a href="{{ route('frontend.faq', app()->getLocale(), ) }}" class="text-foot js-scroll-trigger"><i class="mdi mdi-chevron-right mr-1"></i> How It Works</a></li>
                        <li><a href="{{ route('services.list', app()->getLocale()) }}" class="text-foot js-scroll-trigger"><i class="mdi mdi-chevron-right mr-1"></i> Services</a></li>
                        <li><a href="{{ route('frontend.why_home_fix', app()->getLocale()) }}" class="text-foot js-scroll-trigger"><i class="mdi mdi-chevron-right mr-1"></i>  Why FixMaster?</a></li>

                    </ul>
                </div>
                <!--end col-->

                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <h4 class="text-light footer-head">Useful Links</h4>
                    <ul class="list-unstyled footer-list mt-4">
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> Terms & Conditions</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> Privacy Policy</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> Refund Policy</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> Disclaimer</a></li>
                    </ul>
                </div>
                <!--end col-->

                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <h4 class="text-light footer-head">Contact Us</h4>
                    <p class="mt-4">284 Ajose Adeogun Street, Victoria Island, Lagos, Nigeria</p>
                    <p style="font-size:20px; font-weight:700; color:#ffffff; margin:15px 0px 2px 0px;">
                        <a href="tel:+2348132863878">(+234) 0813-286-3878</a></p>
                    <p style="font-size:20px; font-weight:700; color:#ffffff; margin:15px 0px 2px 0px;"><a href="mailto:info@fixmaster.com.ng" style="color: grey;">info@fixmaster.com.ng</a></p>
                    
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <div class="row">
                <div class="container" style="margin-top: 1rem;">
                    <div class="row justify-content-center">
                        {{-- <x-map-location-view /> --}}
                        <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d3964.70913512724!2d3.4337298145814796!3d6.43139829534688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x103bf523987b2019%3A0xcc13c7ff493f6e39!2s284%20Ajose%20Adeogun%20St%2C%20Victoria%20Island%2C%20Lagos!3m2!1d6.4313983!2d3.4359184999999997!5e0!3m2!1sen!2sng!4v1604627184133!5m2!1sen!2sng" width="1200" height="350" frameborder="0" style="border:0;" allowfullscreen="true" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->
    </footer>
    <!--end footer-->
    <footer class="footer footer-bar" id="contact">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="text-sm-left">
                        <p class="mb-0">© {{ date('Y') }} FixMaster. All Rights Reserved.
                        </p>
                    </div>
                </div>
                <!--end col-->


                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </footer>
    <!--end footer-->
    <!-- Footer End -->

    