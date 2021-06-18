<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\CollaboratorsPayment;
use App\Models\Invoice;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPayment;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\Client;
use App\Models\ServicedAreas;
use App\Models\Contact;
use App\Traits\AddCollaboratorPayment;

use App\Traits\RegisterPaymentTransaction;
use App\Traits\GenerateUniqueIdentity as Generator;

//use App\Http\Controllers\Payment\FlutterwaveController;

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\DB;
use Session;


class FlutterwaveController extends Controller
{
    use RegisterPaymentTransaction, Generator, AddCollaboratorPayment;


    public $public_key;
    private $private_key;

    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('flutterwave')->first()->convertAutoData();
        $this->public_key = $data['public_key'];
        $this->private_key = $data['private_key'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         return $request;
        $valid = $this->validate($request, [
            // List of things needed from the request like
            'booking_fee'      => 'required',
            'payment_channel'  => 'required',
            'payment_for'     => 'required',
            // 'myContact_id'    => 'required',
        ]);

        if($request['payment_for'] == 'invoice'){
            $data = [
                'logistics_cost' => $request['logistics_cost'],
                'retention_fee' => $request['retention_fee'],
                'tax' => $request['tax'],
                'actual_labour_cost' => $request['actual_labour_cost'],
                'actual_material_cost' => $request['actual_material_cost'],
                'labour_markup' => $request['labour_markup'],
                'material_markup' => $request['material_markup'],
                'cse_assigned' => $request['cse_assigned'],
                'technician_assigned' => $request['technician_assigned'],
                'supplier_assigned' => $request['supplier_assigned'],
                'qa_assigned' => $request['qa_assigned'],
                'royalty_fee' => $request['fixMasterRoyalty'],
                'booking_fee' => $request['booking_fee'],
                'payment_for' => $request['payment_for'],
                'invoiceUUID' => $request['uuid']
            ];

            $request->session()->put('collaboratorPayment', $data);
        }

        $selectedContact = Contact::where('id', $request->myContact_id)->first();
        if($request['payment_for'] == 'service-request'){
             $Serviced_areas = ServicedAreas::where('town_id', '=', $selectedContact['town_id'])->orderBy('id', 'DESC')->first();
               if ($Serviced_areas == null) {
                   return back()->with('error', 'sorry!, this area you selected is not serviced at the moment, please try another area');
               }

            //    if ($request->media_file) {
                // upload multiple media files
               foreach($request->media_file as $key => $file)
               {
                   $originalName[$key] = $file->getClientOriginalName();

                   $fileName = sha1($file->getClientOriginalName() . time()) . '.'.$file->getClientOriginalExtension();
                   $filePath = public_path('assets/service-request-media-files');
                   $file->move($filePath, $fileName);
                   $data[$key] = $fileName;
               }
                   $data['unique_name']   = json_encode($data);
                   $data['original_name'] = json_encode($originalName);
                   // return $data;

                // $request->session()->put('order_data', $request);
                $request->session()->put('order_data', $request->except(['media_file']));
                $request->session()->put('medias', $data);
            //    }



            }


        // return dd(  );

        // fetch the Client Table Record
        $client = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
        // generate reference ID
        $generatedVal = $this->generateReference();
        // save ordered items
        $payment = $this->payment($valid['booking_fee'], $valid['payment_channel'], $valid['payment_for'], $client['unique_id'], 'pending', $generatedVal);

        $payment_id = $payment->id;

        return $this->initiate($payment_id);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function initiate($paymentId)
    {
        //    dd($paymentId);
        $curl = curl_init();

        $payment = Payment::find($paymentId);

        $request = [
            'tx_ref' => $payment->reference_id,
            'amount' => $payment->amount,
            'currency' => 'NGN',
            'payment_options' => 'card',
            'redirect_url' => route('flutterwave-verify', app()->getLocale() ),
            'customer' => [
                'email' => auth()->user()->email,
            ],
            'meta' => [
                'price' => $payment->amount
            ],
            // 'customizations' => [
            //     'title' => 'Paying for a sample product',
            //     'description' => 'sample',
            //     'logo' => 'https://assets.piedpiper.com/logo.png'
            // ]
        ];

        //* Call fluterwave initiate payment endpoint
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$this->private_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response);

        if($res->status == 'success')
        {
            return redirect($res->data->link);
        }else
        {
            return back()->with('error', 'We can not process your payment: Curl returned error: ');
        }

    }


    public function verify(Request $request)
    {
        $input_data = $request->all();
        $paymentRecord = Session::get('collaboratorPayment');

        $trans_id = $request->get('tx_ref', '');

        $paymentDetails = Payment::where('reference_id', $trans_id)->orderBy('id', 'DESC')->first();

        if( $input_data['status']  == 'successful'){

            $txid = $request->get('transaction_id', '');
            $curl = curl_init();

            //* Call fluterwave verify endpoint
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer ".$this->private_key
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $resp = \json_decode($response);

            // return dd($resp);

            if(($resp->status ?? '') == "success"){
                $paymentDetails['transaction_id'] = $resp->data->flw_ref ?? '';
                $paymentDetails['status']         = 'success';
                //if the payment was updated to success

                /*************************************************************************************************
                 * Things to do if you want to use this function(Number 1 to 5) Not important if you don't need it
                 *************************************************************************************************/

                // NUMBER 1: Instantiate the clientcontroller class in this controller's method in order to save request
                $client_controller = new ClientController;
                $invoice_controller = new InvoiceController;

                if($paymentDetails->update())
                {
                    // NUMBER 2: add more for other payment process
                    if($paymentDetails['payment_for'] == 'invoice')
                    {
                        $savePayment = $invoice_controller->saveInvoiceRecord($paymentRecord, $paymentDetails);
                        if($savePayment){
                            return redirect()->route('invoice', [app()->getLocale(), $paymentRecord['invoiceUUID']])->with('success', 'Invoice payment was successful!');
                        }
                    }

                    if($paymentDetails['payment_for'] == 'service-request')
                    {
                        $client_controller->saveRequest( $request->session()->get('order_data'), $request->session()->get('medias') );
                        return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Service request was successful');
                    }

                    if($paymentDetails['payment_for'] == 'e-wallet')
                    {
                        $client_controller->addToWallet( $paymentDetails );
                        return redirect()->route('client.wallet', app()->getLocale())->with('success', 'Fund successfully added!');
                     }
                }
            }else {
                // NUMBER 3: add more for other payment process
                if($paymentDetails['payment_for'] == 'service-request' ){
                    return redirect()->route('client.services.list', app()->getLocale() )->with('error', 'Verification not successful, try again!');
                }
                else if($paymentDetails['payment_for'] == 'invoice')
                {
                    return redirect()->route('invoice', [app()->getLocale(), $paymentRecord['invoiceUUID']])->with('error', 'Invoice payment was unsuccessful!');
                }

            }

        }else {
            // NUMBER 4: add more for other payment process
            if($paymentDetails['payment_for'] = 'service-request' ){
                return redirect()->route('client.services.list', app()->getLocale() )->with('error', 'Could not initiate payment process because payment was cancelled, try again!');
            }
        }

        // NUMBER 5: add more for other payment process
        // if($paymentDetails['payment_for'] = 'service-request' ){
        //     return redirect()->route('client.services.list', app()->getLocale() )->with('error', 'there was an error, please try again!');
        // }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function verify()
    // {
    //     //
    //     // echo $payment;
    //     // dd(json_decode($payment));
    //     return view('payment.flutterwave-start');
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
