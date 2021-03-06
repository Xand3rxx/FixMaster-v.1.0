@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('content')

<section class="bg-home bg-circle-gradiant d-flex align-items-center">
    <div class="bg-overlay bg-overlay-white"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8"> 
                <div class="card login-page bg-white shadow rounded border-0">
                    <div class="card-body">
                        @include('layouts.partials._messages')

                        <div class="align-items-center text-center justify-content-center">   
                            <img src="{{ asset('assets/images/home-fix-logo.png')}}" class="img-fluid d-block mx-auto" alt="FixMaster Logo" style="width: 15em; height: 15em; margin-top: -100px !important; margin-bottom: -60px !important;">
                        </div>
                        <h4 class="card-title text-center">Forgot Password</h4>  
                        <form class="login-form mt-4" method="POST" action="{{ route('password.email', ['locale'=>app()->getLocale()]) }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group position-relative">
                                        <label>E-Mail <span class="text-danger">*</span></label>
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input type="email" class="form-control pl-5 @error('email') is-invalid @enderror"" placeholder="E-Mail Address" name="email" required="">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-0">
                                    <button type="submit" class="btn btn-primary btn-block">Send</button>
                                </div>
                                
                                <div class="col-12 text-center">
                                    <p class="mb-0 mt-3"><small class="text-dark mr-2">Remember your password ?</small> <a href="{{ url(app()->getLocale(), 'login') }}" class="text-dark font-weight-bold">Sign in</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!---->
            </div><!--end col-->
        </div><!--end row-->
    </div> <!--end container-->
</section>
@endsection
