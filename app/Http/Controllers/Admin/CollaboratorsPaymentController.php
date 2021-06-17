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
            $status = $request->get('status');
            $specificDate =  $request->get('date');
            $specificYear =  $request->get('year');
            $specificMonth =  $request->get('month');

            if($level === 'Level Two'){

                if(!empty($specificDate)){
                    $sort_results = CollaboratorsPayment::whereDate('created_at',  $specificDate)->with('service_request', 'users','users.roles')
                         ->where('status', $status)
                         ->where('user_id', '!=', 1)
                         ->orderBy('created_at', 'DESC')
                         ->get();

                    $message = 'Showing '.$status.' Payments for '.\Carbon\Carbon::parse($specificDate, 'UTC')->isoFormat('LL');
                
                }

               return $this->displaySorting($status,$sort_results,$message);
            }

            if($level === 'Level Three'){

                if(!empty($specificYear)){
                    $sort_results = CollaboratorsPayment::where('service_type',  $specificYear)->with('service_request', 'users','users.roles')
                         ->where('status', $status)
                         ->where('user_id', '!=', 1)
                         ->orderBy('created_at', 'DESC')
                         ->get();

                    $message = 'Showing '.$status.' Payments for '.$specificYear.' Service Type';
                }

                return $this->displaySorting($status,$sort_results,$message);
            }

            if($level === 'Level Four'){

                if(!empty($specificMonth)){
                    $sort_results = CollaboratorsPayment::where('service_request_id',  $specificMonth)->with('service_request', 'users','users.roles')
                         ->where('status', 'pending')
                         ->where('user_id', '!=', 1)
                         ->orderBy('created_at', 'DESC')
                         ->get();

                    foreach($sort_results as $result){
                        $response = $result->service_request->unique_id;
                    }

                    $message = 'Showing '.$status.' Payments for '.$response;
                }

                return $this->displaySorting($status,$sort_results,$message);
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
            'serve' => CollaboratorsPayment::select("service_request_id")
            ->groupBy('service_request_id')
            ->get(),

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

            }
        }else{
            return redirect()->back()->with('error', '  Please select an option');
        }
    
    }

    public function displaySorting($status,$sort_results,$message){

        if ($status == 'pending') {
            $pendingPayments = $sort_results;
            return view('admin.payments._payment_table', compact('pendingPayments', 'message'));
        }else{
            $disbursedPayments = $sort_results;
            return view('admin.payments._admin_disbursed_table', compact('disbursedPayments', 'message'));
        }
    }

}
