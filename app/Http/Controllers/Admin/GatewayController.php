<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;

class GatewayController extends Controller
{
   public function index(){
       $data['paystack'] = PaymentGateway::find(1);
       $data['flutter'] = PaymentGateway::find(2);

       $payment_gateways = PaymentGateway::where('status',1)->get();
        // dd($payment_gateways);
        // return;
       return view('admin.payment_gateways.list', compact('payment_gateways')+$data);
   }

   public function paystackUpdate(Request $request){
    $paystack = PaymentGateway::find(1);
    $paystack->status = $request->status;

    $information = [];
    $information['private_key'] = $request->private_key;
    $information['public_key']  = $request->public_key;
    $information['text']        = 'Pay via Paystack';

    $paystack->information = json_encode($information);
    $paystack->save();
    return back()->with('success','paystack information updated successfully!');

   }

   public function flutterUpdate(Request $request){
    $flutter = PaymentGateway::find(2);
    $flutter->status = $request->status;

    $information = [];
    $information['private_key'] = $request->private_key;
    $information['public_key']  = $request->public_key;
    $information['text']        = 'Pay via Flutter';

    $flutter->information = json_encode($information);
    $flutter->save();
    return back()->with('success','flutter payment information updated successfully!');
}

}
