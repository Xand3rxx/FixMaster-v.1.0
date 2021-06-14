<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Lga;
use App\Models\Discount;
use App\Models\ClientDiscount;
use App\Models\ServiceDiscount;
use App\Models\ServiceRequest;
use App\Models\EstateDiscountHistory;
use App\Models\Service;
use App\Models\Category;
use App\Models\Account;
use App\Models\Estate;
use App\Models\DiscountHistory;
use App\Traits\Utility;
use App\Traits\Loggable;
use Carbon\Carbon;


class DiscountAutomationController extends Controller
{
    use Utility, Loggable;

    public function store(Request $request)
    {
        $today =Carbon::today()->addDays(0);
        
        $discounts = Discount::select('uuid', 'entity', 'parameter', 'name')->where(['status'=>'activate'])->whereDate('duration_end', '=', '2021-04-01' )->get();
             
        foreach ($discounts as $value) {
          
            $json = json_decode($value->parameter, true);
            $fields= $json['field'];
            
           if(count(array_filter($fields)) > 0){
            print_r( $fields);
               
            //  $specified_request_count_morethan =  isset($field->specified_request_count_morethan)? $data['field']->specified_request_count_morethan : '';
            // $specified_request_count_equalto =  isset($data['field']->specified_request_count_equalto)? $data['field']->specified_request_count_equalto : '';
            // $specified_request_amount_from =  isset($data['field']->specified_request_amount_from)? $data['field']->specified_request_amount_from : '';
            // $specified_request_amount_to =  isset($data['field']->specified_request_amount_to)? $data['field']->specified_request_amount_to : '';
            // $specified_request_start_date =  isset($data['field']->specified_request_start_date)? $data['field']->specified_request_start_date : '';
            // $specified_request_end_date =  isset($data['field']->specified_request_end_date)? $data['field']->specified_request_end_date : '';
            // $specified_request_lga = isset($data['field']->specified_request_lga)? $data['field']->specified_request_lga : '';
            // $specified_request_state = isset($data['field']->specified_request_state)? $data['field']->specified_request_state : '';
           }


           if(count(array_filter($fields)) < 1){
            print_r( 'days');
           }
           dd($discounts);
          
        }
       
    }

}