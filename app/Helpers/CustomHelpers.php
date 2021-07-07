<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\LoyaltyManagement;

class CustomHelpers
{
    static function displayTime($start, $end)
    {
        $date = Carbon::parse($start);
        $diff = $date->diffForHumans($end, true);
        return $diff;
    }

    static function discountCalculation($discount, $amount)
    {
        $amt = (float)$discount / 100 * $amount;
        $value = floor((float)$amount - (float)$amt);
        return  $value;
    }



    function generateRandomNumber()
    {
        // $number = mt_rand(1000000000, 9999999999); // better than rand()

        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $string = str_shuffle($pin);
        // dd($randomString);

        // call the same function if the barcode exists already
        if (checkIfStringExists($randomString)) {
            return generateRandomNumber();
        }

        // otherwise, it's valid and can be used
        return $string;
    }

    // function checkIfStringExists($randomString) {
    //     return User::whereRandomNumber($number)->exists();
    // }


    static function ifLoyaltyExist($user)
    {
        $loyaltyExist = LoyaltyManagement::select('client_id')->where('client_id', $user)->get();
        if (count($loyaltyExist) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    static function ifDateIsPast($date)
    {
        if (strtotime($date) < time())
            return  true;
        else
            return false;
    }


    static function arrayToList($array, $title)
    {
        $arr = [];
        foreach ($array as $assignee) {
            if ($assignee['user']['roles'][0]['slug'] == $title) {
                $arr[] =  $assignee['user']['account']['first_name'] . ' ' . $assignee['user']['account']['last_name'];
            }
        }
        if (empty($arr)) {
            return 'UNAVAILABLE';
        } else {
            return implode(", ", $arr);
        }
    }

    static function cse_warranty_claims($array)
    {
        $arr = [];
        foreach ($array as $warranty) {
            if (!empty($warranty->service_request_warranty)) {
                $arr[] = $warranty->service_request_warranty;
            }
        }
        return count($arr);
    }

    static function getWarrantTechnician($str)
    {
        $name =  \App\Models\Account::where('user_id', $str)->first();
        return  $name ? ucfirst($name->first_name) . ' ' . ucfirst($name->last_name) : 'UNAVAILABLE';
    }

    static function getUserDetail($str)
    {
        $detail =  \App\Models\User::where('id', $str)->with('account', 'roles')->first();
        return  $detail ?? 'UNAVAILABLE';
    }

    static function getExtention($str)
    {
        $string = $str;
        $output = explode(".", $string);
        return $output[count($output) - 1];
    }

    static function getHours($date1, $date2)
    {
        $date = Carbon::parse($date1);
        $diff = $date->diffForHumans($date2, true);
        $data =  explode(" ", $diff);
        $time = array("minutes", "seconds", 'second', 'minute');
        if (!in_array($data[1], $time))
            return $data[1];
        else
            return false;
    }

    static function getTotalAmmount($amount, $deduct)
    {
        $arr = [];
        $arr1 = [];
        $sum1 = '';
        $sum2 = '';

        if ($deduct != '0') {
            $amt = $deduct;
            foreach ($deduct as $item) {
                $arr1[] = $item['rfqInvoices']['total_amount'];
            }
            $sum1 = array_sum($arr1);

            $amt = $amount['supplierSentInvoices'];
            foreach ($amt as $val) {
                $arr[] = $val['total_amount'];
            }
            $sum2 = array_sum($arr);

            return   (int)$sum2 - (int)$sum1;
        }
    }

    /**
     * Check if Role exist within array of users
     * 
     * @param Illuminate\Database\Eloquent\Collection $users
     * @param string        $role
     * @param mixed|null    $needed_user
     * 
     * @return bool
     */
    public static function existRole(\Illuminate\Database\Eloquent\Collection $users, string $role)
    {
        (array)$arr = [];
        foreach ($users as $model) {
            if ($model['user']['roles'][0]['slug'] == $role) {
                $arr[] =  $model['user']['account']['first_name'] . ' ' . $model['user']['account']['last_name'];
            }
        }
        return !empty($arr) ? implode(", ", $arr) : false;
    }

    public static function supplyInvoiceBatch($id, $serviceid){

        $rfq =  \App\Models\Rfq::where('id', '!=', $id)->where(['service_request_id'=>$serviceid ])->where('type', '!=', 'Warranty')->first();
         $invoice = $rfq?  \App\Models\RfqSupplierInvoice::where('rfq_id', '=', $rfq->id)->first(): null;
         $invoiceBatch = $invoice?\App\Models\RfqSupplierInvoiceBatch::where(['rfq_supplier_invoice_id'=> $invoice->id ])->first(): null;
        return  $invoiceBatch??'UNAVAILABLE';
    }


    public static function deliveryFee($id, $serviceid){

        $rfq =  \App\Models\Rfq::where('id', '!=', $id)->where(['service_request_id'=>$serviceid ])->where('type', '!=', 'Warranty')->first();
         $invoice = $rfq?  \App\Models\RfqSupplierInvoice::where('rfq_id', '=', $rfq->id)->first(): null;
        return  $invoice??'UNAVAILABLE';
    }
}
