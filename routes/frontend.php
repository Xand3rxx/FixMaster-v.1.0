<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Frontend\CSEFormController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\SupplierFormController;
use App\Http\Controllers\Frontend\ClientRegistrationController;
use App\Http\Controllers\ServiceRequest\ClientDecisionController;
use App\Http\Controllers\Frontend\TechnicianArtisanFormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| This routes contain the following middleware
| 1. web -> Laravels web group middlewares
| 2. setlocale -> Middleware to set user language using $request->segment(1)
|                 if $request->segment(1) is not in config('app.available_locales')
|                  default of config('app.locale') is used.
|
*/

Auth::routes([
    'login'    => true,
    'logout'   => true,
    'reset'    => false,   // for resetting passwords
    'confirm'  => false,  // for additional password confirmations
    'verify'   => false,  // for email verification
]);

Route::get('email/verify', [VerificationController::class, 'show'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification',  [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::view('/', 'frontend.index')->name('frontend.index');

Route::prefix('registration')->name('frontend.registration.')->group(function () {
    Route::resource('client', ClientRegistrationController::class)->middleware('guest');
});

Route::view('/about',                       'frontend.about')->name('frontend.about');
Route::view('/how-it-works',                'frontend.how_it_works')->name('frontend.how_it_works');
Route::view('/why-home-fix',                'frontend.why_home_fix')->name('frontend.why_home_fix');
Route::get('/join-us',                      [App\Http\Controllers\PageController::class, 'index'])->name('frontend.careers');
Route::post('/estate/add',                  [\App\Http\Controllers\EstateController::class, 'store'])->name('frontend.store_estate');
Route::view('/faq',                         'frontend.faq')->name('frontend.faq');
Route::view('/register',                    'auth.register')->name('frontend.register');
Route::get('/referral/',                 [ClientRegistrationController::class, 'index'])->name('frontend.registration');

// Form Creation 
Route::post('customer-service-executive', [CSEFormController::class, '__invoke'])->name('frontend.customer-service-executive.store');
Route::post('technicain-artisan', [TechnicianArtisanFormController::class, '__invoke'])->name('frontend.technicain-artisan.store');
Route::post('supplier', [SupplierFormController::class, '__invoke'])->name('frontend.supplier.store');


Route::get('/invoice/{invoice:uuid}', [InvoiceController::class, 'invoice'])->name('invoice');
//Route::get('/invoice/', [InvoiceController::class, 'invoice'])->name('invoice');

Route::post('/client-decision', [ClientDecisionController::class, '__invoke'])->name('client.decisions');
Route::post('/client-decline', [ClientDecisionController::class, 'clientDecline'])->name('client.decline');
Route::post('/client-accept', [ClientDecisionController::class, 'clientAccept'])->name('client.accept');
Route::post('/client-return', [ClientDecisionController::class, 'clientReturn'])->name('client.return');

Route::get('/contact-us',                   [App\Http\Controllers\PageController::class, 'contactUs'])->name('frontend.contact');
Route::post('/contact-us',                  [App\Http\Controllers\PageController::class, 'sendContactMail'])->name('frontend.send_contact_mail');

Route::get('/mail',                  [App\Http\Controllers\PageController::class, 'mail'])->name('frontend.mail');

// //Essential Routes
Route::post('towns-list',                    [App\Http\Controllers\EssentialsController::class, 'getTowns'])->name('towns.show');
Route::post('/lga-list',                    [App\Http\Controllers\EssentialsController::class, 'lgasList'])->name('lga_list');
Route::post('/ward-list',                    [App\Http\Controllers\EssentialsController::class, 'wardsList'])->name('ward_list');
Route::get("/getServiceDetails",            [App\Http\Controllers\EssentialsController::class, 'getServiceDetails'])->name("getServiceDetails");
Route::post('/avalaible-tool-quantity',     [App\Http\Controllers\EssentialsController::class, 'getAvailableToolQuantity'])->name('available_quantity');
Route::get("/getServiceDetails",            [App\Http\Controllers\EssentialsController::class, 'editCriteria'])->name("getServiceDetails");
Route::get("/editCriteria",   [App\Http\Controllers\EssentialsController::class, 'Edit'])->name("editServiceRequestCriteria");

Route::prefix('payment')->name('payment.')->group(function () {
    Route::prefix('verification')->name('verify.')->group(function () {
        Route::get('paystack', function () {
           return  \App\PaymentProcessor\Facades\PaystackPayment::isTransactionVerificationValid();
        })->name('paystack');
        Route::get('flutterwave', function () {
            return  \App\PaymentProcessor\Facades\FlutterwavePayment::isTransactionVerificationValid();
         })->name('flutterwave');
    });
});

//Paystack Routes
Route::post('/payment/paystack/submit',                [App\Http\Controllers\Payment\PaystackController::class, 'store'])->name('paystack-submit');
Route::get('/payment/paystack/{paymentId}/initiate',   [App\Http\Controllers\Payment\PaystackController::class, 'initiate'])->name('paystack-start');
Route::get('/payment/paystack/verify',                 [App\Http\Controllers\Payment\PaystackController::class, 'verify'])->name('paystack-verify');

//Flutterwave Routes
Route::post('/payment/flutterwave/submit',                [App\Http\Controllers\Payment\FlutterwaveController::class, 'store'])->name('flutterwave-submit');
Route::get('/payment/flutterwave/{paymentId}/initiate',   [App\Http\Controllers\Payment\FlutterwaveController::class, 'initiate'])->name('flutterwave-start');
Route::get('/payment/flutterwave/verify',                 [App\Http\Controllers\Payment\FlutterwaveController::class, 'verify'])->name('flutterwave-verify');

//E-wallet Routes
Route::post('/payment/ewallet/submit',                [App\Http\Controllers\Payment\EwalletController::class, 'store'])->name('wallet-submit');


//All frontend routes for Services
Route::prefix('/services')->name('services.')->group(function () {
    Route::get('/',                     [PageController::class, 'services'])->name('list');
    Route::get('/details/{service}',    [PageController::class, 'serviceDetails'])->name('details');
    Route::post('/search',              [PageController::class, 'search'])->name('search');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function ($language, Request $request) {

    $valid = $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        // $request->only('email')
        $valid
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');