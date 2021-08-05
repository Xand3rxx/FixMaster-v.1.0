<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

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
        return view('admin.ewallet.clients', [
            'transactions' => \App\Models\Client::with('user', 'walletTransactions')->has('walletTransactions')->get()
        ]);
    }

    public function transactions()
    {
        return view('admin.ewallet.transactions', [
            'walletTransactions'    => \App\Models\WalletTransaction::with('user')->get()
        ]);
    }
    

    public function clientHistory($language, $uuid)
    {
        return view('admin.ewallet.client_history', [
            'transaction' => \App\Models\User::where('uuid', $uuid)->with('account', 'client.walletTransactions')->firstOrFail()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This is an ajax call to Wallet transaction
     * present on click of action:details button
     */
    public function walletTransactionDetail($language, $id)
    {
        return view('admin.ewallet._client_history_detail', [
            'transaction' => \App\Models\WalletTransaction::where('id', $id)->with('payment')->firstOrFail()
        ]);
    }

}
