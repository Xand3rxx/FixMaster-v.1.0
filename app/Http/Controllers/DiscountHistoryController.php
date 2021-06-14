<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiscountHistory;
use App\Traits\Utility;
use App\Traits\Loggable;
use Carbon\Carbon;


class DiscountHistoryController extends Controller
{
    use Utility, Loggable;
    //
    public function index()
    {
        $discounts = DiscountHistory::select('discounts.name', 'discounts.entity', 'discounts.rate', 'discounts.apply_discount', 'availability',
        'discounts.duration_start', 'discounts.duration_end', 'discount_histories.*')
        ->orderBy('discount_histories.id', 'DESC')
        ->join('discounts', 'discounts.id', '=', 'discount_histories.discount_id')
        ->get();
        return response()->view('admin.discount.history', compact('discounts'));
    }

   



 


}

