<?php

namespace App\Http\Controllers\Client\Ewallet;

use App\Models\Payment;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class FundWalletController extends Controller
{
    use Loggable;
    
    public function init($locale, Payment $payment)
    {
        if($payment['status'] == Payment::STATUS['success'])
        {
            if(!\App\Models\WalletTransaction::where('user_id', request()->user()->id)->exists()){
                $openingBalance = 0;
            }elseif(request()->user()->clientWalletBalance->opening_balance == 0)
            {
                $openingBalance = request()->user()->clientWalletBalance->closing_balance;
            }else
            {
                $openingBalance = request()->user()->clientWalletBalance->closing_balance;
            }

            $closingBalance = !empty(request()->user()->clientWalletBalance->closing_balance) ? request()->user()->clientWalletBalance->closing_balance : 0;

            $saveWalletRecord = \App\Models\WalletTransaction::create([
                'user_id'           => request()->user()->id,
                'payment_id'        => $payment['id'],
                'amount'            => $payment['amount'],
                'payment_type'      => 'funding',
                'unique_id'         => $payment['unique_id'],
                'transaction_type'  => 'credit',
                'opening_balance'   => $openingBalance,
                'closing_balance'   => ($closingBalance + $payment['amount']),
                'status'            => $payment['status'],
            ]);

            if($saveWalletRecord){

                $this->log('Payment', 'Informational', Route::currentRouteAction(), request()->user()->email.' funded his wallet account.');

                return redirect()->route('client.wallet', app()->getLocale())->with('success', 'E-Wallet was successfully funded.');
            }
        }

        return back()->with('error', 'Sorry! E-Wallet funding failed.');
    }

    public static function payForServiceRequest($payment)
    {
        //Check if uesr has a wallet record and get last opening balance
        if(!\App\Models\WalletTransaction::where('user_id', request()->user()->id)->exists()){
            $openingBalance = 0;
        }elseif(request()->user()->clientWalletBalance->opening_balance == 0)
        {
            $openingBalance = request()->user()->clientWalletBalance->closing_balance;
        }else
        {
            $openingBalance = request()->user()->clientWalletBalance->closing_balance;
        }

        //Get last closing balance 
        $closingBalance = !empty(request()->user()->clientWalletBalance->closing_balance) ? request()->user()->clientWalletBalance->closing_balance : 0;

        if($payment['amount'] > $closingBalance){
            return back()->with('error', 'Sorry! Insufficient wallet balance. Please use a different payment option.');
        }

        //Set `debitWallet` to false before Db transaction
        (bool) $debitWallet  = false;

        DB::transaction(function () use ($payment, $openingBalance, $closingBalance, &$debitWallet) {

            \App\Models\Payment::where('id', $payment['id'])->update([
                'status'    =>  'success'
            ]);
            
            \App\Models\WalletTransaction::create([
                'user_id'           => request()->user()->id,
                'payment_id'        => $payment['id'],
                'amount'            => $payment['amount'],
                'payment_type'      => 'service-request',
                'unique_id'         => $payment['unique_id'],
                'transaction_type'  => 'debit',
                'opening_balance'   => $openingBalance,
                'closing_balance'   => ($closingBalance - $payment['amount']),
                'status'            => 'success'
            ]);

            $debitWallet = true;
        });

        if($debitWallet){
            //Get updated payment record
            $payment = \App\Models\Payment::where('id', $payment['id'])->firstOrFail();

            return redirect()->route($payment['return_route_name'], ['locale' => app()->getLocale(), 'payment' => $payment]);
        }
    }
}
