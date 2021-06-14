@extends('layouts.auth')
@section('title', 'E-Mail Verification')
@section('content')
<section class="bg-home bg-circle-gradiant d-flex" style="align-items: center; padding: 150px 0;">
    <div class="bg-overlay bg-overlay-white"></div>

    <div class="container">
        <div class="row" style="justify-content: center;">
            <div class="col-lg-6 col-md-8">
                <table style="box-sizing: border-box; width: 100%; border-radius: 6px; overflow: hidden; background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);">
                    <thead>
                        <tr style="background-color: #E97D1F; text-align: center; color: #fff; font-size: 24px; font-weight: 700; letter-spacing: 1px;">
                            <th scope="col"><img src="{{ asset('assets/images/home-fix-logo-new.png') }}" height="170" style="margin-top: -50px !important; margin-bottom: -50px !important;" alt=""></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="padding: 48px 24px 0; color: #161c2d; font-size: 18px; font-weight: 600;">
                                Hello,
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px 24px 15px; color: #8492a6;">
                                Thanks for creating a <span class="font-weight-bold">Fix<span style="color: #E97D1F;">Master</span></span> account. To complete your registration, simply click the link in the email we just sent to <a href="mailto: {{$email}}" class="text-primary">{{$email}}</a>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding: 15px 24px 15px; color: #8492a6;">
                                <a class="btn btn-primary btn-block" onclick="event.preventDefault(); document.getElementById('verify-email').submit();" href="{{ route('verification.notice', app()->getLocale()) }}"> Resend Verification</a>
                            </td>
                            <form id="verify-email" action="{{ route('verification.send', app()->getLocale()) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </tr>


                        <tr>
                            <td style="padding: 15px 24px 15px; color: #8492a6;">
                                Thanks, <br> FixMaster Management
                            </td>
                        </tr>

                        <tr>
                            <td style="padding: 16px 8px; color: #8492a6; background-color: #f8f9fc; text-align: center;">
                                © {{ date('Y') }} FixMaster. All Rights Reserved.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
<!--end section-->
@endsection