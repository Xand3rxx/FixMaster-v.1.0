<?php

namespace App\Http\Controllers\Technician;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Models\PaymentDisbursed;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function get_technician_disbursed_payments(Request $request){

        // $user = Auth::user();
        // $payments = $user->payments();
        $payments = PaymentDisbursed::where('recipient_id',Auth::id())
        ->orderBy('created_at', 'DESC')->get();
        return view('technician.payments', compact('payments'));
    }

    public function sortDisbursedPayments(Request $request){
        if($request->ajax()){

            // return $request;
            //Get current activity sorting level
            $level =  $request->get('sort_level');
            //Get the activity sorting type
            $type =  $request->get('type');
            //Get activity log for a specific date
            $specificDate =  $request->get('date');
            //Get activity log for a specific year
            $specificYear =  $request->get('year');
            //Get activity log for a specific month
            $specificMonth =  date('m', strtotime($request->get('month')));
            //Get activity log for a specific month name
             $specificMonthName =  $request->get('month');
            //Get activity log for a date range
            $dateFrom =  $request->get('date_from');
            $dateTo =  $request->get('date_to');

            if($level === 'Level One'){

                $payments = PaymentDisbursed::where('type', $type)
                ->orderBy('created_at', 'DESC')->get();

                $message = 'Showing Disbursed Payment of "'.$type.'"';

                return view('quality-assurance._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Two'){

                if(!empty($specificDate)){
                    $payments = PaymentDisbursed::whereDate('created_at', $specificDate)
                    ->where('recipient_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for '.\Carbon\Carbon::parse($specificDate, 'UTC')->isoFormat('LL');
                }

                return view('quality-assurance._disbursed_table', compact('payments','message'));

            }

            if($level === 'Level Three'){

                if(!empty($specificYear)){
                    $payments = PaymentDisbursed::whereYear('created_at', $specificYear)
                    ->where('recipient_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for year '.$specificYear;
                }

                return view('quality-assurance._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Four'){

                if(!empty($specificYear) && !empty($specificMonth)){
                    $payments = PaymentDisbursed::whereYear('created_at', $specificYear)
                    ->whereMonth('created_at', $specificMonth)
                    ->where('recipient_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for "'.$specificMonthName.'" in year '.$specificYear;
                }

                return view('quality-assurance._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Five'){

                if(!empty($dateFrom) && !empty($dateTo)){
                    $payments = PaymentDisbursed::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->where('recipient_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments from "'.\Carbon\Carbon::parse($dateFrom, 'UTC')->isoFormat('LL').'" to "'.\Carbon\Carbon::parse($dateTo, 'UTC')->isoFormat('LL').'"';
                }

                 return view('quality-assurance._disbursed_table', compact('payments','message'));
            }
        }
    }
}