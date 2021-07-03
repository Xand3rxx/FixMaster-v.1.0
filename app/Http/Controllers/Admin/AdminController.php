<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CollaboratorsPayment;
use App\Models\ServiceRequestPayment;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index',[
        'disbursedPayments' => CollaboratorsPayment::where('user_id', '!=', 1)->where('status', 'Paid')->get()->sum('amount_to_be_paid'),
        'adminPayments' => CollaboratorsPayment::where('user_id', 1)->value(DB::raw("SUM(labour_markup_cost + material_markup_cost + logistics_cost + royalty_fee + tax_fee)")),
        'receivedPayments' => ServiceRequestPayment::where('status','success')->get()->sum('amount'),
        'recentPayments' => ServiceRequestPayment::with('clients', 'service_request')->where('status','success')->latest()->limit(1)->get()
        
        ]);
    }
}
