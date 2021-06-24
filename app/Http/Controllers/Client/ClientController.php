<?php

namespace App\Http\Controllers\Client;

use File;
use Image;
use Session;
use Carbon\Carbon;
use App\Models\Lga;
use App\Models\Town;
use App\Models\User;
use App\Models\Media;
use App\Models\State;
use App\Models\Client;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Service;
use App\Traits\Utility;
use App\Traits\Loggable;
use App\Traits\Services;
use Illuminate\Http\Request;
use App\Traits\CancelRequest;
use App\Models\PaymentGateway;
use App\Models\ServiceRequest;
use App\Traits\PasswordUpdator;
use App\Models\LoyaltyManagement;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestMedia;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestSetting;
use Illuminate\Support\Facades\Route;

use App\Models\ServiceRequestWarranty;
use Illuminate\Support\Facades\Config;
use App\Models\ClientLoyaltyWithdrawal;
use App\Http\Controllers\RatingController;
use App\Traits\RegisterPaymentTransaction;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Messaging\MessageController;
use App\Http\Controllers\Payment\FlutterwaveController;


class ClientController extends Controller
{
    use RegisterPaymentTransaction, Generator, Services, PasswordUpdator, Utility, Loggable, CancelRequest;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get total available serviecs
        $totalServices = Service::get();

        return view('client.home', [
            // data
            'totalRequests'         => auth()->user()->clientRequests()->count(),
            'completedRequests'     => auth()->user()->clientRequests()->where('status_id', 4)->count(),
            'cancelledRequests'     => auth()->user()->clientRequests()->where('status_id', 3)->count(),
            'user'                  => User::where('id', Auth()->user()->id)->with('client', 'contact', 'account')->firstOrFail(),
            'popularRequests'       =>  ($totalServices->count() < 3) ? $totalServices->take(10)->random(1) : $totalServices->take(10)->random(3),
            'userServiceRequests'   =>  Client::where('user_id', auth()->user()->id)->with('service_requests')->first()
        ]);
    }

    public function clientRequestDetails($language, $uuid)
    {

        // return $requestDetail = ServiceRequest::where('uuid', $uuid)->with('price', 'service', 'client', 'serviceRequestMedias', 'service_request_assignees', 'address', 'payment')->firstOrFail();

        return view('client.request_details', [

            'requestDetail'     =>  ServiceRequest::where('uuid', $uuid)->with('price', 'service', 'client', 'serviceRequestMedias', 'service_request_assignees', 'address', 'payment')->firstOrFail()
        ]);
    }

    public function settings(Request $request)
    {
        $data['client'] = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();

        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['lgas'] = Lga::select('id', 'name')->where('state_id', Account::where('user_id', auth()->user()->id)->orderBy('id', 'ASC')->firstOrFail()->state_id)->orderBy('name', 'ASC')->get();

        $data['towns'] = Town::select('id', 'name')->where('lga_id', Account::where('user_id', auth()->user()->id)->orderBy('id', 'ASC')->firstOrFail()->lga_id)->orderBy('name', 'ASC')->get();

        return view('client.settings', $data);
    }


    public function update_profile(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'  => 'required|max:255',
            'gender'   => 'required',
            'phone_number'   => 'required|max:255',
            'email'       => 'required|email|max:255',
            'state_id'   => 'required|max:255',
            'lga_id'   => 'required|max:255',
            'full_address'   => 'required|max:255',
        ]);

        // update contact table
        $contact = Contact::where('user_id', auth()->user()->id)->orderBy('id', 'ASC')->firstOrFail();
        $contact->name              = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
        $contact->state_id          = $request->state_id;
        $contact->lga_id            = $request->lga_id;
        $contact->town_id           = $request->town_id;
        $contact->account_id        = Client::where('user_id', auth()->user()->id)->orderBy('id', 'ASC')->firstOrFail()->account_id;
        $contact->country_id        = '156';
        $contact->phone_number      = $request->phone_number;
        $contact->address           = $request->full_address;
        $contact->address_longitude = $request->user_longitude;
        $contact->address_latitude  = $request->user_latitude;
        $contact->update();

        // update account table
        $account = Account::where('user_id', auth()->user()->id)->orderBy('id', 'ASC')->firstOrFail();
        $account->state_id = $request->state_id;
        $account->lga_id = $request->lga_id;
        $account->town_id = $request->town_id;
        $account->first_name = $request->first_name;
        $account->middle_name = $request->middle_name;
        $account->last_name = $request->last_name;
        $account->gender = $request->gender;
        // $account->avatar = $request->input('old_avatar');

        if ($request->hasFile('profile_avater')) {
            $image = $request->file('profile_avater');
            $imageName = sha1(time()) . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('assets/user-avatars') . '/' . $imageName;
            if (\File::exists(public_path('assets/user-avatars/' . $request->input('old_avatar')))) {
                $done = \File::delete(public_path('assets/user-avatars/' . $request->input('old_avatar')));
                if ($done) {
                    // echo 'File has been deleted';
                }
            }
            //Move new image to `client-avatars` folder
            Image::make($image->getRealPath())->resize(220, 220)->save($imagePath);
            $account->avatar = $imageName;
        }

        $account->update();

        Session::flash('success', 'Profile updated successfully!');
        return redirect()->back();
    }


    public function wallet()
    {
        $data['gateways']     = PaymentGateway::whereStatus(1)->orderBy('id', 'DESC')->get();
        $data['mytransactions']   = Payment::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->with('wallettransactions')->get();
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // return $data['mytransactions'][0]->wallettransactions->transaction_type;
        // return view('client.wallet', $data);
        return view('client.wallet', compact('myWallet') + $data);
    }

    public function walletSubmit(Request $request)
    {
        // get the last wallet transaction of the loggedIn client
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // validate Request
        $valid = $this->validate($request, [
            // List of things needed from the request
            'amount'           => 'required',
            'payment_channel'  => 'required',
            'payment_for'      => 'required',
        ]);

        // fetch the Client Table Record of loggedIn user
        $client = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();

        // generate random string
        $generatedVal = $this->generateReference();
        $track  = Session::put('Track', $generatedVal);

        // call the payment Trait and submit record on the payment table
        $payment = $this->payment($valid['amount'], $valid['payment_channel'], $valid['payment_for'], $client['unique_id'], 'pending', $generatedVal);

        // initiate the paystack controller to use its method
        $paystack_controller = new PaystackController;
        // initiate the flutterwave controller to use its method
        $flutterwave_controller = new FlutterwaveController;

        // if a payment record is saved to the payment table
        if ($payment) {
            // get the payment record saved in the DB using the generated Value as refId
            $paymentRecord =  Payment::where('reference_id', $generatedVal)->orderBy('id', 'DESC')->first();
            $payment_id = $payment->id;
            // authenticated user
            $user = User::find($paymentRecord->user_id);

            // if there is no payment record saved
            if (is_null($paymentRecord)) {
                return redirect()->route('client.wallet', app()->getLocale())->with('error', 'Invalid Deposit Request');
            }
            // if the payment record have been saved and has a status of pending
            if ($paymentRecord->status != 'pending') {
                $return = redirect()->route('client.wallet', app()->getLocale())->with('error', 'Transaction already saved');
            }
            //check the payment method selected
            switch ($paymentRecord->payment_channel) {

                case 'paystack':
                    $return = $paystack_controller->initiate($payment_id);
                    break;
                case 'flutterwave':
                    $return = $flutterwave_controller->initiate($payment_id);

                    break;

                default:

                    $return = redirect()->route('client.wallet', app()->getLocale())->with('error', 'Please select a payment method');
            }
            return (!$return) ? redirect()->route('client.wallet', app()->getLocale())->with('error', 'an error occured') : $return;
        }
    }


    /**
     * Return a list of all active FixMaster services.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        return $this->passwordUpdator($request);
    }

    /**
     * Return a list of all active FixMaster services.
     *
     * @return \Illuminate\Http\Response
     */
    public function services()
    {
        //Return all active categories with at least one Service
        return view('client.services.index', $this->categoryAndServices());
    }

    /**
     * Display a service request quote page.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceQuote($language, $uuid, Request $request)
    {

        $data['gateways']     = PaymentGateway::whereStatus(1)->orderBy('id', 'DESC')->get();
        $data['service']      = $this->service($uuid);
        $data['bookingFees']  = $this->bookingFees();
        $data['discounts']    = $this->clientDiscounts();

        $data['balance']      = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
        // [
        //     'service'       =>  $this->service($uuid),
        //     'bookingFees'   =>  $this->bookingFees(),
        //     'discounts'     =>  $this->clientDiscounts(),
        // ]
        // dd($data['balance']->closing_balance );
        // dd($data['discounts'] );

        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();

        // $data['lgas'] = Lga::select('id', 'name')->orderBy('name', 'ASC')->get();

        //Return Service details
        $data['myContacts'] = Contact::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
        //Return Service details
        // $data['myContacts'] = Contact::where('user_id', auth()->user()->id)->get();
        // dd($data['myContacts']);

        $data['registeredAccount'] = Account::where('user_id', auth()->user()->id)
            ->with('usercontact')
            ->orderBy('id', 'DESC')
            ->firstOrFail();

        $data['displayDescription'] = 'blank';

        // dd($data['registeredAccount']);
        return view('client.services.quote', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This is an ajax call to save a new client contact.
     * Present on click of Create button from the form.
     */
    public function createNewClientContact(Request $request)
    {
        if ($request->ajax()) {

            //Validate data from ajax request
            $validatedData = $request->validate([
                'first_name'        =>   'bail|required|string',
                'last_name'         =>   'bail|required|string',
                'phone_number'      =>   'bail|required||unique:contacts,phone_number',
                'state_id'          =>   'bail|required|integer',
                'lga_id'            =>   'bail|required|integer',
                'town_id'           =>   'sometimes|integer',
                'address'           =>   'bail|required',
                'user_latitude'     =>   'bail|required',
                'user_longitude'    =>   'bail|required',
            ]);

            //Set `createService` to false before Db transaction
            (bool) $createContact  = false;

            $actionUrl = Route::currentRouteAction();

            // Set DB to rollback DB transacations if error occurs
            DB::transaction(function () use ($request, $validatedData, &$createContact) {

                Contact::create([
                    'user_id'           =>   $request->user()->id,
                    'account_id'        =>   $request->user()->account->id,
                    'name'              =>   ucwords($validatedData['first_name'] . ' ' . $validatedData['last_name']),
                    'phone_number'      =>   $validatedData['phone_number'],
                    'country_id'        =>   156,
                    'state_id'          =>   $validatedData['state_id'],
                    'lga_id'            =>   $validatedData['lga_id'],
                    'town_id'           =>   $validatedData['town_id'],
                    'address'           =>   $validatedData['address'],
                    'address_latitude'     =>   $validatedData['user_latitude'],
                    'address_longitude'    =>   $validatedData['user_longitude'],
                ]);
                $createContact  = true;
            });

            if ($createContact) {

                $this->log('Profile', 'Informational', $actionUrl, $request->user()->account->first_name . ' ' . $request->user()->account->last_name . ' successfully created a new contact address');

                return view('client.services._contactList', [
                    'myContacts'    => $request->user()->contacts,
                ]);
            } else {

                $this->log('Errors', 'Error', $actionUrl, 'An error occurred while ' . $request->user()->account->first_name . ' ' . $request->user()->account->last_name . ' was trying to create a new contact address');

                return back()->with('error', 'Sorry! An error occurred while to create a new contact address');
            }

        }
    }

    public function getDistanceDifference(Request $request)
    {

        $client = Client::where('user_id', $request->user()->id)->with('user')->orderBy('id', 'DESC')->firstOrFail();

        // $latitude  = '3.921007';
        $latitude  = $client->user->contact->address_latitude;
        // $longitude = '1.8386';
        $longitude = $client->user->contact->address_longitude;
        // $radius    = 325;
        $radius        = ServiceRequestSetting::find(1)->radius;

        $cse = DB::table('cses')
            ->join('contacts', 'cses.user_id', '=', 'contacts.user_id')
            ->join('users', 'cses.user_id', '=', 'users.id')
            ->join('accounts', 'cses.user_id', '=', 'accounts.user_id')
            // // // ->select(DB::raw('contacts.*,1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - abs(address_latitude)) *  pi()/180 / 2), 2) + COS(" . $latitude . " * pi()/180) * COS(abs(address_latitude) * pi()/180) * POWER(SIN((" . $longitude . " - address_longitude) * pi()/180 / 2), 2)  )) AS calculatedDistance'))
            ->select(DB::raw('cses.*, contacts.address, accounts.first_name, users.email,  6353 * 2 * ASIN(SQRT( POWER(SIN((' . $latitude . ' - abs(address_latitude)) * pi()/180 / 2),2) + COS(' . $latitude . ' * pi()/180 ) * COS(abs(address_latitude) *  pi()/180) * POWER(SIN((' . $longitude . ' - address_longitude) *  pi()/180 / 2), 2) )) as distance'))
            ->having('distance', '<=', $radius)
            // // ->having('town', '=', '')
            ->orderBy('distance', 'DESC')
            ->get();

        if (count($cse) > 0) {
            // dd($cse);
            foreach ($cse as $key => $cses) {
                // dd($cse);
                dd($cses->id);
                // dd($cses->distance);
            }
        }
    }

    /**
     * Display a more details about a FixMaster service.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceDetails($language, $uuid)
    {
        //Return Service details
        $service = $this->service($uuid);
        $rating = Rating::where('service_id', $service->id)
            ->where('service_request_id', null)
            ->where('service_diagnosis_by', null)
            ->where('ratee_id', '!=', null)->get();
        $reviews = Review::where('service_id', $service->id)->where('status', 1)->get();
        return view('client.services.show', compact('service', 'rating', 'reviews'));
        //return view('client.services.show', ['service' => $this->service($uuid)]);
    }
    /**
     * Search and return a list of FixMaster services.
     * This is an ajax call to sort all FixMaster services
     * present on change of Category select dropdown
     *
     * @return \Illuminate\Http\Response
     */
    public function search($language, Request $request)
    {

        //Return all active categories with at least one Service of matched keyword or Category ID
        return view('client.services._search', $this->searchKeywords($request));
    }

    /**
     * Request for a Custom Service frpm FixMaster.
     * Save custom request ['service_requests']
     * @return \Illuminate\Http\Response
     */
    public function customService()
    {
        $user = Auth::user()->loadMissing('contacts', 'account');

        return view('client.services.service_custom', [
            'discounts'             => \App\Models\ClientDiscount::ClientServiceRequestsDiscounts()->get(),
            'bookingFees'           => \App\Models\Price::bookingFees()->get(),
            'states'                => \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'gateways'              => PaymentGateway::where('status', PaymentGateway::STATUS['active'])->orderBy('id', 'DESC')->get(),
            'displayDescription'    => 'blank',
            'myContacts'            => $user['contacts'],
            'registeredAccount'     => $user['account']
        ]);
    }


    public function myServiceRequest()
    {
        return view('client.services.list', [
            'myServiceRequests' =>  Client::where('user_id', auth()->user()->id)->with('service_requests.invoices', 'service_requests.payment')
                ->whereHas('service_requests', function ($query) {
                    $query->orderBy('created_at', 'ASC');
                })->first(),
        ]);
    }

    public function loyalty()
    {
        $data['title']     = 'Fund your Loyalty wallet';
        $data['loyalty']   = ClientLoyaltyWithdrawal::select('wallet', 'withdrawal')->where('client_id', auth()->user()->id)->first();
        $total_loyalty    = LoyaltyManagement::selectRaw('SUM(amount) as amounts, SUM(points) as total_points, COUNT(amount) as total_no_amount')->where('client_id', auth()->user()->id)->get();

        $data['total_loyalty'] = ($total_loyalty[0]->total_points *  $total_loyalty[0]->amounts) / ($total_loyalty[0]->total_no_amount * 100);

        $json = $data['loyalty']->withdrawal != NULL ? json_decode($data['loyalty']->withdrawal) : [];


        $ifwithdraw = isset($json->withdraw) ? $json->withdraw : '';
        $ifwithdraw_date = isset($json->date) ? $json->date : '';
        $data['withdraws'] =  empty($json) ? [] : (is_array($ifwithdraw) ? $ifwithdraw : [0 => $ifwithdraw]);
        $data['withdraw_date'] = empty($json) ? [] : (is_array($ifwithdraw_date) ?  $ifwithdraw_date : [0 =>  $ifwithdraw_date]);

        $data['sum_of_withdrawals'] = empty($json) ? 0 : (is_array($ifwithdraw) ? array_sum($ifwithdraw) : $ifwithdraw);


        $data['mytransactions']    = Payment::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $walTrans = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();

        $data['ewallet'] =  !empty($walTrans->closing_balance) ? $walTrans->closing_balance : 0;
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('client.loyalty', compact('myWallet') + $data);
    }


    public function loyaltySubmit(Request $request)
    {
        // dd($request);


        $wallet  = ClientLoyaltyWithdrawal::select('wallet', 'withdrawal')->where('client_id', auth()->user()->id)->first();
        if ($wallet->withdrawal != NULL) {
            $other_withdrawals = json_decode($wallet->withdrawal, true);
            $withdrawal = array_merge_recursive($other_withdrawals,  ['withdraw' => $request->amount, 'date' => date('Y-m-d h:m:s')]);
        }

        if ($wallet->withdrawal == NULL) {
            $withdrawal = [
                'withdraw' => $request->amount,
                'date' => date('Y-m-d h:m:s')
            ];
        }

        if ((float)$wallet->wallet > (float)$request->amount) {
            $client = Client::where('user_id', auth()->user()->id)->first();
            $generatedVal = $this->generateReference();
            $payment = $this->payment($request->amount, 'loyalty', 'e-wallet', $client->unique_id, 'success', $generatedVal);
            if ($payment) {

                $walTrans = new WalletTransaction;
                $walTrans->user_id = auth()->user()->id;
                $walTrans->payment_id = $payment->id;
                $walTrans->amount =  $payment->amount;
                $walTrans->payment_type = 'loyalty';
                $walTrans->unique_id = $payment->unique_id;
                $walTrans->transaction_type = 'credit';
                $walTrans->opening_balance = $request->opening_balance;
                $walTrans->closing_balance = (float)$payment->amount + (float)$request->opening_balance;
                $walTrans->save();

                $update_wallet = (float)$wallet->wallet - (float)$request->amount;
                ClientLoyaltyWithdrawal::where(['client_id' => auth()->user()->id])->update([
                    'withdrawal' => json_encode($withdrawal),
                    'wallet' =>  $update_wallet
                ]);

                return redirect()->route('client.loyalty', app()->getLocale())
                    ->with('success', 'Funds transfered  successfully ');
            } else {

                return redirect()->route('client.loyalty', app()->getLocale())
                    ->with('error', 'Insufficient Loyalty Wallet Balance');
            }
        }
    }

    public function payments()
    {
        return view('client.payment.list')->with([
            'payments' => \App\Models\Payment::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get(),
        ]);
    }

    public function paymentDetails($language, Payment $payment)
    {
        return view('client.payment._payment_details')->with([
            'payment' => $payment
        ]);
    }

    public function client_rating(Request $request, RatingController $clientratings)
    {
        return $clientratings->handleClientRatings($request);
    }

    public function update_client_service_rating($language, Request $request, RatingController $updateClientRatings)
    {
        return $updateClientRatings->handleUpdateServiceRatings($request);
    }

    public function saveRequest($request, $media)
    {

        $service_request                        = new ServiceRequest();
        $service_request->client_id             = auth()->user()->id;
        if ($request['service_id']) {
            $service_request->service_id            = $request['service_id'];
        }
        // auth-uuid, serviceRequest-uuid
        // $service_request->unique_id             = 'REF-'.$this->generateReference();
        $service_request->price_id              = $request['price_id'];
        $service_request->contact_id              = $request['myContact_id'];
        // $service_request->client_discount_id    = $request['client_discount_id'];
        // $service_request->client_security_code  = 'SEC-'.strtoupper(substr(md5(time()), 0, 8));
        $service_request->status_id             = '1';
        $service_request->description           = $request['description'];
        $service_request->total_amount          = $request['booking_fee'];
        $service_request->preferred_time        = Carbon::parse($request['timestamp'], 'UTC');
        $service_request->has_client_rated      = 'No';
        $service_request->has_cse_rated         = 'No';
        $service_request->created_at            = Carbon::now()->toDateTimeString();
        $service_request->contactme_status      = $request['contacted'];
        // $service_request->updated_at         = Carbon::now()->toDateTimeString();

        if ($service_request->save()) {
            $saveToMedia = new Media();
            $saveToMedia->client_id     = auth()->user()->id;
            $saveToMedia->original_name = $media['original_name'];
            $saveToMedia->unique_name   = $media['unique_name'];
            $saveToMedia->save();
        }

        $cses    =  \App\Models\Cse::where('job_availability', 'Yes')->with('user')->get();
        // $url = "http://127.0.0.1:8000/en/client/requests/";
        (string)$url = $this->url($service_request);

        foreach ($cses as $cse) {
            $template_feature = 'CSE_NEW_JOB_NOTIFICATION';
            if (!empty((string)$template_feature)) {
                $messanger = new MessageController();
                $mail_data = collect([
                    'lastname' => $cse['user']['account']['first_name'],
                    'firstname' => $cse['user']['account']['last_name'],
                    'email' => $cse['user']['email'],
                    'url'  => (string)$url
                ]);
                $messanger->sendNewMessage('', 'info@fixmaster.com.ng', $mail_data['email'], $mail_data, $template_feature);
            }
        }


        return $service_request;
    }

    public function url($service_request)
    {
        return $this->newJobNotifictaionUrl($service_request);
    }

    protected function newJobNotifictaionUrl($service_request)
    {
        return URL::temporarySignedRoute(
            'cse.index',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 3600)),
            [
                'id' => auth()->user()->uuid,
                'hash' => sha1($service_request->uuid),
                'locale' => app()->getLocale()
            ]
        );

        return $service_request;
    }

    public function editRequest($language, $uuid)
    {

        // return $userServiceRequest = ServiceRequest::where('uuid', $uuid)->with('serviceRequestMedias')->firstOrFail();

        $data = [
            'userServiceRequest'    =>  ServiceRequest::where('uuid', $uuid)->with('serviceRequestMedias')->firstOrFail(),
        ];

        return view('client._request_edit', $data);
    }

    public function updateRequest(Request $request, $language, $id)
    {
        // return $request->servicereq;
        $requestExist = ServiceRequest::where('uuid', $id)->first();

        $request->validate([
            'timestamp'             =>   'required',
            // 'phone_number'          =>   'required',
            // 'address'               =>   'required',
            'description'           =>   'required',
        ]);


        $timestamp = \Carbon\Carbon::parse($request->input('timestamp'), 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa');

        $updateServiceRequest = ServiceRequest::where('uuid', $id)->update([
            'preferred_time'             =>   $request->input('timestamp'),
            'description'           =>   $request->description,
        ]);

        $updateContactRequest = Contact::where(['user_id' => auth()->user()->id, 'id' =>   $requestExist->contact_id])->update([
            'phone_number'          =>   $request->phone_number,
            'address'               =>   $request->address,
        ]);

        // upload multiple media files
        foreach ($request->media_file as $key => $file) {
            $originalName[$key] = $file->getClientOriginalName();

            $fileName = sha1($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
            $filePath = public_path('assets/service-request-media-files');
            $file->move($filePath, $fileName);
            $data[$key] = $fileName;
        }
        $unique_name   = json_encode($data);
        $original_name = json_encode($originalName);

        $saveToMedia = new Media();
        $saveToMedia->client_id     = auth()->user()->id;
        $saveToMedia->original_name = $original_name;
        $saveToMedia->unique_name   = $unique_name;
        $saveToMedia->save();

        $saveServiceRequestMedia = new ServiceRequestMedia;
        $saveServiceRequestMedia->media_id            = $saveToMedia->id;
        $saveServiceRequestMedia->service_request_id  = $request->servicereq;
        $saveServiceRequestMedia->save();

        if ($updateServiceRequest) {
            //acitvity log
            return back()->with('success', $requestExist->unique_id . ' was successfully updated.');
        } else {

            //acitvity log
            return back()->with('error', 'An error occurred while trying to update a ' . $requestExist->unique_id . ' service request.');
        }

        return back()->withInput();
    }


    public function cancelRequest(Request $request, $language, $uuid)
    {

        //Validate the incoming request.
        $request->validate([
            'reason'    =>  'bail|required|string',
        ]);

        //Check if uuid exists on `users` table.
        $serviceRequest = ServiceRequest::where('uuid', $uuid)->with('client', 'price', 'payment', 'status')->firstOrFail();

        return (($this->initiateCancellation($request, $serviceRequest) == true) ? back()->with('success', $serviceRequest->unique_id . ' request has been cancelled.') : back()->with('error', 'An error occurred while trying to to assign cancel ' . $serviceRequest->unique_id . ' request.'));
    }

    public function addToWallet($data)
    {
        // client
        $client = Client::where('user_id', auth()->user()->id)->firstOrFail();
        // get last payment details
        $lastPayment  = Payment::where('unique_id', $client->unique_id)->orderBy('id', 'DESC')->first();

        $walTrans = new WalletTransaction;
        $walTrans['user_id'] = auth()->user()->id;
        $walTrans['payment_id'] = $lastPayment->id;
        $walTrans['amount'] = $data->amount;
        $walTrans['payment_type'] = 'funding';
        $walTrans['unique_id'] = $data->unique_id;
        $walTrans['transaction_type'] = 'debit';
        // if the user has not used this wallet for any transaction
        if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
            $walTrans['opening_balance'] = '0';
            $walTrans['closing_balance'] = $data->amount;
        } else {
            $previousWallet = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
            $walTrans['opening_balance'] = $previousWallet->closing_balance;
            $walTrans['closing_balance'] = $previousWallet->closing_balance + $data->amount;
        }
        $walTrans->save();
        // return redirect()->route('client.wallet', app()->getLocale());
    }

    public function warrantyInitiate(Request $request, $language, $id)
    {

        $request->validate([
            'reason'       =>   'required',
        ]);

        $mail1 = '';
        $mail2 = '';
        $mail3 = '';
        $admin = User::where('id', 1)->with('account')->first();
        $requestExists = ServiceRequest::where('uuid', $id)->with('client', 'service_request_assignees')->first();
        $rfq        = \App\Models\Rfq::where('service_request_id',  $requestExists->id)->first();
        $rfqInvoice        = \App\Models\RfqSupplierInvoice::where('rfq_id', '=', $rfq->id)->where('accepted', '=', 'Yes')->first();
        $supplier =  \App\Models\User::where('id',   $rfqInvoice->supplier_id)->with('account')->first();
        $cse = [];
        $initateWarranty = '';

        if ($requestExists->service_request_assignees) {
            foreach ($requestExists->service_request_assignees as $item) {
                if ($item->user->roles[0]->url == 'cse') {
                    $cse[] = [
                        'email' => $item->user->email,
                        'first_name' => $item->user->account->first_name,
                        'last_name' => $item->user->account->last_name
                    ];
                }
            }
        }

        (bool)  $initiate = false;

        DB::transaction(function () use ($request,  $initateWarranty, $cse, $requestExists, $admin, $supplier, &$initiate) {

            $initateWarranty = ServiceRequestWarranty::where('service_request_id',  $requestExists->id)->update([
                'status'            => 'used',
                'initiated'         => 'Yes',
                'reason'            => $request->reason,
                'date_initiated'    =>  \Carbon\Carbon::now('UTC'),
            ]);

            //send mail 1, admin, 2, client, 3 cse
            if ($initateWarranty) {

                $mail_data_admin = collect([
                    'email' =>  $admin->email,
                    'template_feature' => 'ADMIN_WARRANTY_CLAIM_NOTIFICATION',
                    'firstname' =>  $admin->account->first_name,
                    'lastname' =>  $admin->account->last_name,
                    'job_ref' =>  $requestExists->unique_id
                ]);
                $mail1 = $this->mailAction($mail_data_admin);




                if ($mail1 == '0') {
                    $mail_data_client = collect([
                        'email' =>  Auth::user()->email,
                        'template_feature' => 'ADMIN_WARRANTY_CLAIM_NOTIFICATION',
                        'firstname' => Auth::user()->account->first_name,
                        'lastname' => Auth::user()->account->last_name,
                        'job_ref' =>  $requestExists->unique_id
                    ]);
                    $mail2 = $this->mailAction($mail_data_client);
                }



                if ($mail2 == '0') {
                    foreach ($cse as $value) {
                        $mail_data_cse = collect([
                            'email' =>  $value['email'],
                            'template_feature' => 'ADMIN_CSE_JOB_COMPLETED_NOTIFICATION',
                            'firstname' =>   $value['first_name'],
                            'lastname' =>   $value['last_name'],
                            'job_ref' =>  $requestExists->unique_id,
                            // 'customer_name' => Auth::user()->account->first_name.' '.Auth::user()->account->last_name,
                            // 'customer_email' => Auth::user()->email,
                        ]);
                        $mail3 = $this->mailAction($mail_data_cse);
                    };
                }

                if ($mail3 == '0') {
                    $mail_data_admin = collect([
                        'email' =>  $supplier->email,
                        'template_feature' => 'SUPPLIER_WARRANTY_CLAIM_NOTIFICATION',
                        'firstname' =>  $supplier->account->first_name,
                        'lastname' =>  $supplier->account->last_name,
                        'job_ref' =>  $requestExists->unique_id
                    ]);
                    $mail1 = $this->mailAction($mail_data_admin);
                }


                $initiate = true;
            }
        });

        if ($initiate) {

            return redirect()->route('client.service.all', app()->getLocale())->with('success', $requestExists->unique_id . ' warranty was successfully initiated.Please check your mail for notification');
        } else {
            return back()->with('error', 'An error occurred while trying to initiate warranty for' .  $requestExists->unique_id . ' service request.');
        }
    }


    public function reinstateRequest(Request $request, $language, $id)
    {

        $requestExists = ServiceRequest::where('uuid', $id)->firstOrFail();
        //service_request_status_id = Pending(1), Ongoing(2), Completed(4), Cancelled(3)
        $reinstateRequest = ServiceRequest::where('uuid', $id)->update([
            'status_id' =>  '1',
        ]);

        $jobReference = $requestExists->unique_id;

        //Create record in `service_request_progress` table
        // $recordServiceProgress = ServiceRequestProgress::where(['service_request_id'=> $requestExists->id, 'user_id' => Auth::id()])->update([
        //     'status_id'                     => '1',
        //     'sub_status_id'                 => '1'
        // ]);

        // $recordCancellation = ServiceRequestCancellation::where(['service_request_id'=> $requestExists->id, 'user_id' => Auth::id()])->delete();

        // if($cancelRequest AND $recordServiceProgress AND $recordCancellation){
        if ($reinstateRequest) {

            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') reinstated ' . $jobReference . ' service request.');

            return back()->with('success', $jobReference . ' service request was reinstated successfully.');
        } else {
            //Record Unauthorized user activity
            //activity log
            return back()->with('error', 'An error occurred while trying to cancel ' . $jobReference . ' service request.');
        }
    }

    public function markCompletedRequest($language, $uuid)
    {

        //Check if uuid exists on `users` table.
        $serviceRequest = ServiceRequest::where('uuid', $uuid)->with('client', 'price', 'payment')->firstOrFail();

        return (($this->markCompletedRequestTrait($serviceRequest) == true) ? back()->with('success', $serviceRequest->unique_id.' request has been marked as completed.') : back()->with('error', 'An error occurred while trying to mark'. $serviceRequest->unique_id.' request as completed.'));
    }


    public function discount_mail(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->user;

            $response =  $this->addDiscountToFirstTimeUserTrait($request->user());
            if ($response == '1') {
                $referralResponse = $this->updateVerifiedUsers($request->user());
            }

            return response()->json($referralResponse);
        }
    }
}
