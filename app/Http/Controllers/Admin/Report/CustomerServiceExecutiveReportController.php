<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequestAssigned;
use Auth;

class CustomerServiceExecutiveReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return ServiceRequestAssigned::with('service_request', 'user')
            // ->whereHas('user.roles', function ($query){
            //     $query->where('slug', 'cse-user');
            // })->latest('created_at')->get(),

        return view('admin.reports.cse.index', [
            
            'results'   => [],

            'cses'  =>  \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This is an ajax call to CSE Job Assigned Report
     * present on change of sorting parameter select dropdown
     */
    public function jobAssignedSorting($language, Request $request)
    {
        if ($request->ajax()) {
            (array) $filters = $request->only('cse_id', 'job_status', 'sort_level', 'date');

            return view('admin.reports.cse.tables._job_assigned', [
                'results'   =>  ServiceRequestAssigned::jobAssignedSorting($filters)->with('service_request', 'user')
                ->whereHas('user.roles', function ($query){
                    $query->where('slug', 'cse-user');
                })->latest('created_at')->get()
            ]);
            
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This is an ajax call to CSE Job Assigned Report
     * present on change of sorting parameter select dropdown
     */
    public function amountEarnedSorting($language, Request $request)
    {
        if ($request->ajax()) {

            (array) $filters = $request->only('cse_id', 'job_status', 'sort_level', 'date');

            return view('admin.reports.cse.tables._amount_earned', [
                'results'   =>  ServiceRequestAssigned::amountEarnedSorting($filters)->with('service_request', 'user')
                ->whereHas('user.roles', function ($query){
                    $query->where('slug', 'cse-user');
                })->latest('created_at')->get()
            ]);
            
        }
    }
}
