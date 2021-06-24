<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequestAssigned;
use App\Models\Technician;
use Auth;

class TechnicianReportController extends Controller
{
    public function index()
    {
        // $results = ServiceRequestAssigned::with('service_request', 'service_request.users', 'cses', 'service_request.status', 'service_request.users.account', 'service_request.users.roles')
        // ->latest('created_at')->get();

        $results = ServiceRequestAssigned::with('service_request', 'user')->whereHas('user.roles', function ($query){
              $query->where('slug', 'technician-artisans');
            })->latest('created_at')->get();

        $technicians  =  \App\Models\Role::where('slug', 'technician-artisans')->with('users')->firstOrFail();
          return view('admin.reports.technician.index', compact('results', 'technicians'));
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

            return view('admin.reports.technician.tables._job_assigned', [
                'results'   =>  ServiceRequestAssigned::jobAssignedSorting($filters)->with('service_request', 'user')
                ->whereHas('user.roles', function ($query){
                    $query->where('slug', 'technician-artisans');
                })->latest('created_at')->get()
            ]);

        }
    }

}
