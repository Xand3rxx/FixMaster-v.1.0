<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CollaboratorsPayment;
use App\Models\ServiceRequest;
use App\Models\Cse;
class AdminController extends Controller
{
    public function index(){

        return view('admin.index', [
            'serviceRequests'   =>  [
                'totalRequests'     => ServiceRequest::count(),
                'pendingRequests'   => ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Pending'])->count(),
                'completedRequests' => ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Completed'])->count(),
                'cancelledRequests' => ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Canceled'])->count(),
                'ongoingRequests'   => ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Ongoing'])->count(),
            ],
            'users'             =>  [
                'admins'        =>  \App\Models\Administrator::count(),
                'clients'       =>  \App\Models\Client::count(),
                'cses'          =>  Cse::count(),
                'technicians'   =>  \App\Models\Technician::count(),
            ],
            'payments'          => [
                'received'      => (float) ServiceRequest::select('total_amount')->sum('total_amount'),
                'cancelled'     => (float) ServiceRequest::select('total_amount')->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Canceled'])->sum('total_amount'),
                'disbursed'     =>  (float) CollaboratorsPayment::select('amount_to_be_paid')->where('status', 'Paid')->get()->sum('amount_to_be_paid'),
            ],
            'others'            => [
                'recentPayments'        =>  \App\Models\Payment::with('user.account')->latest()->take(5)->get(),
                'cses'                  =>  Cse::with(['user.account', 'service_request_assgined' => function ($query) {
                    $query->withCount('completedCseServiceRequests');
                }])->limit(5)->get()->random(3),
                'highestReturningJobs'  =>  ServiceRequest::select('unique_id', 'client_id', 'total_amount', 'created_at')->with('client.account')->orderBy('total_amount', 'DESC')->limit(5)->get(),
                'highestLgaRequests'    =>  ServiceRequest::with('address.lga')->distinct('contact_id')->get('contact_id'),
                'highestLgaRequests'    =>  ServiceRequest::with('address.lga')->distinct('contact_id')->get('contact_id'),
            ],
        ]);
    }
}
