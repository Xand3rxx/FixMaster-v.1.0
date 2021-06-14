<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\WalletTransaction;
use App\Models\Client;
use App\Models\ServicedAreas;
use App\Models\Contact;

use App\Traits\RegisterPaymentTransaction;
use App\Models\ServiceRequestPayment;
use App\Traits\GenerateUniqueIdentity as Generator;

use App\Http\Controllers\Client\ClientController;
use Session;
use Image;


class EwalletController extends Controller
{
    use RegisterPaymentTransaction, Generator;

    public function store(Request $request)
    {

        $valid = $this->validate($request, [
            // List of things needed from the request like
            'booking_fee'      => 'required',
            'payment_channel'  => 'required',
            'payment_for'     => 'required',
            // 'myContact_id'    => 'required',
        ]);
        $selectedContact = Contact::where('id', $request->myContact_id)->first();
        // check if the town
        $Serviced_areas = ServicedAreas::where('town_id', '=', $selectedContact['town_id'])->orderBy('id', 'DESC')->first();
        if ($Serviced_areas === null) {
            return back()->with('error', 'sorry!, this area you selected is not serviced at the moment, please try another area');
        }

        if ($request->media_file)
        {
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

                 // $request->session()->put('order_data', $request);
                 $request->session()->put('order_data', $request->except(['media_file']));
                 $request->session()->put('medias', $data);
        }


        $client_controller = new ClientController;


        if($request->balance > $request->booking_fee){
            // $SavedRequest = $this->saveRequest($request);
            // $SavedRequest = $client_controller->saveRequest( $request);
            $SavedRequest = $client_controller->saveRequest( $request->session()->get('order_data'), $request->session()->get('medias') );

            // dd($service_request);
            if ($SavedRequest) {
            // fetch the Client Table Record
            $client = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
            // generate reference string for this transaction
            $generatedVal = $this->generateReference();
            // call the payment Trait and submit record on the
            $payment = $this->payment($SavedRequest->total_amount, 'wallet', 'service-request', $client['unique_id'], 'success', $generatedVal);
            // save the reference_id as track in session
            // Session::put('Track', $generatedVal);
                if ($payment) {
                    // $track = Session::get('Track');
                    $pay =  Payment::where('reference_id', $generatedVal)->orderBy('id', 'DESC')->first();
                    //save to the wallet transaction table
                    if ($pay) {
                        $wallet_transaction = new WalletTransaction;
                        $wallet_transaction->user_id = auth()->user()->id;
                        $wallet_transaction->payment_id = $pay->id;
                        $wallet_transaction->amount = $pay->amount;
                        $wallet_transaction->payment_type = $pay->payment_for;
                        $wallet_transaction->unique_id = $pay->unique_id;
                        $wallet_transaction->transaction_type = 'debit';
                        $wallet_transaction->opening_balance = $request->balance ;
                        $wallet_transaction->closing_balance = $request->balance - $pay->amount;
                        $wallet_transaction->status = 'success';
                        $wallet_transaction->save();
                        // $this->getDistanceDifference();
                        // return back()->with('success', 'Success! Transaction was successful and your request has been placed.');

                        // save to ServiceRequestPayment table
                        $service_reqPayment = new ServiceRequestPayment;
                        $service_reqPayment->user_id = auth()->user()->id;
                        $service_reqPayment->payment_id = $pay->id;
                        $service_reqPayment->service_request_id = $SavedRequest->id;
                        $service_reqPayment->amount = $pay->amount;
                        $service_reqPayment->unique_id = $pay->unique_id;
                        $service_reqPayment->payment_type = $pay->payment_for;
                        $service_reqPayment->status = 'success';

                    }
                }
                return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Service Request was successful!');
            } else{
                return back()->with('error', 'sorry!, your service request is not successful');
            }

        }else{
            return back()->with('error', 'sorry!, booking fee is greater than wallet balance');
            }
        }


    }


