<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CollaboratorsPayment;
use App\Models\ServiceRequestPayment;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index',[
        'disbursedPayments' => CollaboratorsPayment::where('user_id', '!=', 1)->where('status', 'Paid')->get()->sum('amount_to_be_paid'),
        'receivedPayments' => ServiceRequestPayment::where('status','success')->get()->sum('amount')
        ]);
    }
}
