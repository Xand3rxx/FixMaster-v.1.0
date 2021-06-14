<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\RfqSupplier;
use Illuminate\Http\Request;

class SupplierReportController extends Controller
{
    //

    public function index()
    {
        return view('admin.reports.suppliers.index', [
            'results' => [],
            'suppliers' => \App\Models\Role::where('slug', 'supplier-user')->with('users')->firstOrFail(),
            'cses' => \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail(),
        ]);
    }

    public function itemDeliveredSorting($language, Request $request)
    {
//        (array) $filters = $request->only('supplier_id', 'sort_level', 'job_status', 'cse_id', 'data');
        if($request->ajax()) {
            (array) $filters = $request->only('supplier_id', 'sort_level', 'job_status', 'cse_id', 'data');

            return view('admin.reports.suppliers.tables._item_delivered', [
//                'results' => RfqSupplier::itemDeliveredSorting($filters)->with('service_request', 'users')
//                    ->latest('created_at')->get()
            'results' => RfqSupplier::all()
            ]);

        }
    }
}
