<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CollaboratorsPayment;
use Auth;

class CollaboratorsPaymentController extends Controller
{
    public function sortPayments(Request $request){
        if($request->ajax()){


            $level =  $request->get('sort_level');
            $type =  $request->get('type');
            $specificDate =  $request->get('date');
            $specificYear =  $request->get('year');
            $specificMonth =  $request->get('month');

            if($level === 'Level Two'){

                if(!empty($specificDate)){
                    $pendingPayments = CollaboratorsPayment::whereDate('created_at',  $specificDate)->with('service_request', 'users','users.roles')
                         ->where('status', 'pending')
                         ->where('user_id', '!=', 1)
                         ->orderBy('created_at', 'DESC')
                         ->get();

                    $message = 'Showing Pending Payments for '.\Carbon\Carbon::parse($specificDate, 'UTC')->isoFormat('LL');
                }

                return view('admin.payments._payment_table', compact('pendingPayments','message'));

            }

            if($level === 'Level Three'){

                if(!empty($specificYear)){
                    $pendingPayments = CollaboratorsPayment::where('service_type',  $specificYear)->with('service_request', 'users','users.roles')
                         ->where('status', 'pending')
                         ->where('user_id', '!=', 1)
                         ->orderBy('created_at', 'DESC')
                         ->get();

                    $message = 'Showing Pending Payments for '.$specificYear.' Service Type';
                }

                return view('admin.payments._payment_table', compact('pendingPayments','message'));
            }

            if($level === 'Level Four'){

                if(!empty($specificMonth)){
                    $pendingPayments = CollaboratorsPayment::where('service_request_id',  $specificMonth)->with('service_request', 'users','users.roles')
                         ->where('status', 'pending')
                         ->where('user_id', '!=', 1)
                         ->orderBy('created_at', 'DESC')
                         ->get();

                    foreach($pendingPayments as $result){
                        $response = $result->service_request->unique_id;
                    }

                    $message = 'Showing Pending Payments for '.$response;
                }

                return view('admin.payments._payment_table', compact('pendingPayments','message'));
            }

        }
    }


    public function getPendingPayments()
    {
        return view('admin.payments.pending',[
        'serve' => CollaboratorsPayment::select("service_request_id")
        ->groupBy('service_request_id')
        ->get(),

        'pendingPayments' => CollaboratorsPayment::where('user_id', '!=', 1)->with('service_request', 'users','users.roles')
        ->where('status', 'pending')
        ->orderBy('created_at', 'DESC')
        ->get()

        ]);
    }

    public function getdisbursedPayments()
    {
        return view('admin.payments.disbursed',[
        'disbursedPayments' => CollaboratorsPayment::where('user_id', '!=', 1)->with('service_request', 'users','users.roles')
        ->where('status', 'Paid')
        ->orderBy('created_at', 'DESC')
        ->get()

        ]);
    }


    public function getCheckbox(Request $request){
        (bool) $registred = false;
        if (!empty($request->checkBoxArray)) {
            foreach ($request->checkBoxArray as $res) {
                $options = $request->bulk;
                switch ($options) {
             case 'Paid':

             DB::transaction(function () use ($request, &$registred) {
                 foreach ($request->checkBoxArray as $recordId) {
                     CollaboratorsPayment::where('id', $recordId)->update([
                 'status' => 'Paid'
             ]);
                 }
                 $registred = true;
             });

             return redirect()->back()->with('success', 'Successfully marked as paid');
             break;

            }

                // switch($options){
            //     c
            // }
            }
        }else{
            return redirect()->back()->with('error', '  Please select an option');
        }
    }
}
