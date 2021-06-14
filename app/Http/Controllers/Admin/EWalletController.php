<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

use App\Models\WalletTransaction;
use App\Models\Payment;

class EWalletController extends Controller
{
     /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function clients()
    {

        // $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // return view('client.wallet', compact('myWallet')+$data);

        return view('admin.ewallet.transactions')->with('i');

    }

    public function transactions(){

        $walletTransactions = WalletTransaction::with('user')->get();
        return view('admin.ewallet.transactions', compact('walletTransactions'));

        // return view('admin.ewallet.transactions')->with('i');
    }

    public function clientHistory(){

        return view('admin.ewallet.client_history')->with('i');
    }
}
