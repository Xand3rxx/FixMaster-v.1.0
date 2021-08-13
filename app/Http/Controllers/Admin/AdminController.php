<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CollaboratorsPayment;
use App\Models\Service;
use App\Models\ServiceRequestPayment;
use App\Models\ServiceRequest;

class AdminController extends Controller
{
    public function index(){
        return  \App\Models\Payment::with('user.account')->latest()->take(5)->get();
        return view('admin.index', [
            'serviceRequests'   =>  [
                "totalRequests"   => ServiceRequest::count(),
                "pendingRequests"   => ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Pending'])->count(),
                "completedRequests" => ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Completed'])->count(),
                "cancelledRequests" => ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Canceled'])->count(),
                "ongoingRequests"   => ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Ongoing'])->count(),
            ],
            'users'             =>  [
                'admins'        =>  \App\Models\Administrator::count(),
                'clients'       =>  \App\Models\Client::count(),
                'cses'          =>  \App\Models\Cse::count(),
                'technicians'   =>  \App\Models\Technician::count(),
            ],
            'others'            => [
                'recentPayments'=>  ServiceRequest::with('client')->limit(5)->get(),
                'cses'          =>  \App\Models\Cse::with('user.account')->limit(5)->get()->random(3),
            ],
            'disbursedPayments' =>  CollaboratorsPayment::where('user_id', '!=', 1)->where('status', 'Paid')->get()->sum('amount_to_be_paid'),
            'adminPayments'     =>  CollaboratorsPayment::where('user_id', 1)->value(DB::raw("SUM(labour_markup_cost + material_markup_cost + logistics_cost + royalty_fee + tax_fee)")),
            'receivedPayments'  =>  ServiceRequestPayment::where('status','success')->get()->sum('amount'),
            'recentPayments'    =>  ServiceRequestPayment::with('clients', 'service_request')->where('status','success')->latest()->limit(1)->get()
        ]);
    }
}
