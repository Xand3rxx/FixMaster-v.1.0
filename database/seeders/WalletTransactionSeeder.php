<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class WalletTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallet_transactions')->delete();

        $walletTransactions = array(

            array(
                'user_id'           =>  5,
                'payment_id'        =>  8,
                'amount'            =>  3000,
                'payment_type'      =>  'funding',
                'unique_id'         =>  'WAL-760BCC86',
                'transaction_type'  =>  'credit',
                'opening_balance'   =>  0,
                'closing_balance'   =>  3000,
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  5,
                'payment_id'        =>  2,
                'amount'            =>  2000,
                'payment_type'      =>  'service-request',
                'unique_id'         =>  'WAL-760BCC86',
                'transaction_type'  =>  'debit',
                'opening_balance'   =>  3000,
                'closing_balance'   =>  2000,
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  5,
                'payment_id'        =>  9,
                'amount'            =>  1300,
                'payment_type'      =>  'funding',
                'unique_id'         =>  'WAL-760BCC86',
                'transaction_type'  =>  'credit',
                'opening_balance'   =>  2000,
                'closing_balance'   =>  2000,
                'status'            =>  'pending',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  5,
                'payment_id'        =>  10,
                'amount'            =>  2800,
                'payment_type'      =>  'funding',
                'unique_id'         =>  'WAL-760BCC86',
                'transaction_type'  =>  'credit',
                'opening_balance'   =>  2000,
                'closing_balance'   =>  2000,
                'status'            =>  'failed',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  6,
                'payment_id'        =>  11,
                'amount'            =>  1200,
                'payment_type'      =>  'funding',
                'unique_id'         =>  'WAL-A3C9FAC4',
                'transaction_type'  =>  'credit',
                'opening_balance'   =>  1200,
                'closing_balance'   =>  1200,
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  7,
                'payment_id'        =>  12,
                'amount'            =>  3500,
                'payment_type'      =>  'funding',
                'unique_id'         =>  'WAL-1D61A777',
                'transaction_type'  =>  'credit',
                'opening_balance'   =>  0,
                'closing_balance'   =>  0,
                'status'            =>  'failed',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  8,
                'payment_id'        =>  13,
                'amount'            =>  1450,
                'payment_type'      =>  'funding',
                'unique_id'         =>  'WAL-DCE47AD1',
                'transaction_type'  =>  'credit',
                'opening_balance'   =>  0,
                'closing_balance'   =>  0,
                'status'            =>  'failed',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  6,
                'payment_id'        =>  14,
                'amount'            =>  2000,
                'payment_type'      =>  'refund',
                'unique_id'         =>  'WAL-A3C9FAC4',
                'transaction_type'  =>  'credit',
                'opening_balance'   =>  1200,
                'closing_balance'   =>  3200,
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            
        );

        DB::table('wallet_transactions')->insert($walletTransactions);
    }
}
