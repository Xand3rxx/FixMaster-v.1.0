<?php

namespace App\Http\Controllers\QualityAssurance;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Models\CollaboratorsPayment;
use App\Models\PaymentDisbursed;
use Illuminate\Http\Request;
use App\Traits\Utility;

class PaymentController extends Controller
{
    use Utility;

    public function get_qa_disbursed_payments(Request $request){

        // $user = Auth::user();
        // $payments = $user->payments();
        $years =  $this->getDistinctYears($tableName = 'payments_disbursed');

        $payments = CollaboratorsPayment::where('user_id',Auth::id())->with('service_request', 'users','users.roles')
        ->orderBy('created_at', 'DESC')->get();
        return view('quality-assurance.payments', compact('payments', 'years'));
    }

    public function sortDisbursedPayments(Request $request){
        if($request->ajax()){

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

                $payments = CollaboratorsPayment::where('type', $type)
                ->orderBy('created_at', 'DESC')->get();

                $message = 'Showing Disbursed Payment of "'.$type.'"';

                return view('quality-assurance._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Two'){

                if(!empty($specificDate)){
                    $payments = CollaboratorsPayment::whereDate('created_at', $specificDate)
                    ->where('user_id', Auth::id())->with('service_request', 'users','users.roles')
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for '.\Carbon\Carbon::parse($specificDate, 'UTC')->isoFormat('LL');
                }

                return view('quality-assurance._disbursed_table', compact('payments','message'));

            }

            if($level === 'Level Three'){

                if(!empty($specificYear)){
                    $payments = CollaboratorsPayment::whereYear('created_at', $specificYear)
                    ->where('user_id', Auth::id())->with('service_request', 'users','users.roles')
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for year '.$specificYear;
                }

                return view('quality-assurance._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Four'){

                if(!empty($specificYear) && !empty($specificMonth)){
                    $payments = CollaboratorsPayment::whereYear('created_at', $specificYear)->with('service_request', 'users','users.roles')
                    ->whereMonth('created_at', $specificMonth)
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for "'.$specificMonthName.'" in year '.$specificYear;
                }

                return view('quality-assurance._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Five'){

                if(!empty($dateFrom) && !empty($dateTo)){
                    $payments = CollaboratorsPayment::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments from "'.\Carbon\Carbon::parse($dateFrom, 'UTC')->isoFormat('LL').'" to "'.\Carbon\Carbon::parse($dateTo, 'UTC')->isoFormat('LL').'"';
                }

                 return view('quality-assurance._disbursed_table', compact('payments','message'));
            }
        }
    }

    public function paymentDetails($language, $payment)
    {
        return view('quality-assurance._payment_details',[
            'payment' => CollaboratorsPayment::where('id', $payment)->with('service_request', 'users','users.roles')->first()
        ]);
    }

    public function paymentDistory(){
        return view('payment.payment_history');
    }
}
