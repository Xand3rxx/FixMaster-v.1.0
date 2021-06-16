<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>FixMaster.ng - We Fix, You Relax!</title>
    <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" />
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@fixmaster.com.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />

    <!-- <link rel="shortcut icon" href="images/favicon.ico"> -->
    <link rel="icon" href="{{ asset('assets/images/home-fix-logo.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Slider -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.theme.default.min.css') }}" />
    <!-- Main Css -->
    <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/client/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #E97D1F;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#E97D1F"
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #E97D1F; max-width:670px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                 
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; -webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                <td>
                                    <div style="padding:0 35px">
                                    
                                    <br/>

                                        <p style="color:#8492a6; font-weight:500; margin:0;font-size:14px;font-family:'Rubik',sans-serif; text-align:right">

                                        <?= date('Y-m-d')?></p>
                                </div>
                                <span style="display:inline-block; vertical-align:middle; margin:10px 0 16px; border-bottom:1px solid #cecece; width:100%;"></span>
                                <td>
                                </tr>

                                <tr>
                                    <td style="padding:0 35px;">
                                  

                                            {!! $mail_message !!}

                                      
                                      <p>For further enquiries, please contact our call centre on 01-4447448 or email us on info@fixmaster.com.ng</p>
                                      
                                      <p>Thank you <br/> FixMaster Team</p>
                                         
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                 
                                <span style="display:inline-block;vertical-align:middle; margin:19px 0 26px; border-bottom:1px solid #cecece; width:100%;"></span>

                                 
                                 <div style="float:left;padding:0 35px">
                                 <p style="color: #8492a6; margin:5px 0px 2px; font-size:15px"> Connect With Us</p>
                                 <a href="javascript:void(0)">
                                <img src="{{ asset('assets/images/twitter.png') }}" height="20" alt="twitter"/>
                                </a>
                                <a href="javascript:void(0)" style="background-color: #007bb5; padding:0 5px;border-radius: 50%;  display: inline-block;  margin: 5px 3px;">
                                <img src="{{ asset('assets/images/facebook.png') }}" height="15" alt="facebook" style=""/>
                                </a>

                                <a href="javascript:void(0)" style="margin: 5px 2px;">
                                <img src="{{ asset('assets/images/index.jpeg') }}" height="23" alt="instagram" style=""/>
                                </a>
                                <a href="javascript:void(0)" style="background-color: #007bb5; padding:0 5px;border-radius: 50%;  display: inline-block;  margin: 5px 3px;">
                                <img src="{{ asset('assets/images/linkedin.png') }}" height="15" alt="linkedin" style=""/>
                                </a>
                                 </div>

                                 <div style="float:right;padding:0 35px; text-align:right">
                                 <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" height="45" alt="FixMaster Logo">
                                             <p style="text-align:right;margin-top: 5px; font-size: 13px; color: #8492a6">(+234) 0813-286-3878</p>
                                             <p style="text-align:right; margin-top: -5px; font-size: 13px;color: #8492a6">info@fixmaster.com.ng</p>
                                             <p style="text-align:right; margin-top: -5px; font-size: 13px; color: #8492a6">www.fixmaster.com.ng</p>
                                             <p style="text-align:right; margin-top: -5px; font-size: 13px;color: #8492a6">FixMaster ,Ajose Adeogun, Lagos, Nigeria</p>

                                </div>
               
                                <td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                   
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>