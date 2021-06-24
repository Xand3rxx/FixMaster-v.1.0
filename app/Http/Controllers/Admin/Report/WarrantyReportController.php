<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequestAssigned;
use App\Models\Technician;
use App\Traits\Utility;
use App\Models\Warranty;
use App\Models\ServiceRequestWarranty;
use App\Models\ServiceRequestWarrantyIssued;
use Auth;


class WarrantyReportController extends Controller
{
    //

    public function index()
    {
    
    $issuedWarranties =  ServiceRequestWarranty::with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')->orderBy('has_been_attended_to', 'ASC')->latest()->get();
    $customers = \App\Models\Client::with('service_request', 'account', 'service_requests')->get();
    $states = \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')
    ->get();
    $category = \App\Models\Category::select('id', 'name', )->orderBy('name', 'ASC')
    ->get();
    $extendedWarranties =  ServiceRequestWarranty::where('warranty_id', '<>', '1')->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')->orderBy('has_been_attended_to', 'ASC')->latest()->get();

    // $issuedWarranties = \App\Models\ServiceRequestWarranty::with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')
    // ->whereHas('service_request_report.service', function ($query) {
    //     $query->where('category_id', '=', '7');
    // })->get(); 

     //dd($extendedWarranties);
     return view('admin.reports.warranty.index', compact('customers', 'issuedWarranties', 'states', 'category', 'extendedWarranties'));
    }
  


    public function listSorting($language, Request $request)
    {
        if ($request->ajax()) {
         

            $issuedWarranties='';
        
       
            (array) $filters = $request->only('user_id', 'job_status', 'jobId','sort_level', 'catIdList', 'lgaId', 'jobClaims','date');
     
            switch ($request->sort_level) {
                case 'SortType1':
                    if( count($request->user_id[0]) > 0) 
               $issuedWarranties =  ServiceRequestWarranty::where('warranty_id', '<>', '1')->whereIn('client_id',  $request->user_id[0] )->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')->orderBy('has_been_attended_to', 'ASC')->latest()->get();
                break;
                case 'SortType5':
            if(count($request->jobId[0]) > 0) {
                $issuedWarranties = \App\Models\ServiceRequestWarranty::where('warranty_id', '<>', '1')->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')
                ->whereHas('service_request', function ($query) use ($request) {
                    $query->whereIn('unique_id', $request->jobId[0]);
                })->get(); 
                
               }
                 //$query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                break;
              case 'SortType6':
                if(count($request->lgaId[0]) > 0) {
                    $issuedWarranties = \App\Models\ServiceRequestWarranty::with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')
                    ->whereHas('user.account', function ($query) use ($request) {
                        $query->whereIn('lga_id', $request->lgaId[0]);
                    })->get(); 
                    
                    }
                        //$query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                break;

        case 'SortType7':
                if(count($request->catIdList[0]) > 0) {
                    $issuedWarranties = \App\Models\ServiceRequestWarranty::with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')
                    ->whereHas('service_request_report.service', function ($query) use ($request) {
                        $query->whereIn('category_id', $request->catIdList[0]);
                    })->get(); 
                    
                    }
                        //$query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                break;

                case 'SortType4':
                    if($request->jobClaims) {
                    
                        $issuedWarranties =  ServiceRequestWarranty::where('initiated',  $request->jobClaims)->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')->orderBy('has_been_attended_to', 'ASC')->latest()->get();

                        }
                            //$query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                    break;

            default:
          
                break;
            }
          
            return view('admin.reports.warranty.tables._warranty_claims_list', compact('issuedWarranties'));


         }
    }

    public function extended_warranty(){
        
    $customers = \App\Models\Client::with('service_request', 'account', 'service_requests')->get();
    $states = \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')
    ->get();
    $category = \App\Models\Category::select('id', 'name', )->orderBy('name', 'ASC')
    ->get();
    $extendedWarranties =  ServiceRequestWarranty::where('warranty_id', '<>', '1')->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')->orderBy('has_been_attended_to', 'ASC')->latest()->get();

    // $issuedWarranties = \App\Models\ServiceRequestWarranty::with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')
    // ->whereHas('service_request_report.service', function ($query) {
    //     $query->where('category_id', '=', '7');
    // })->get(); 

     //dd($extendedWarranties);
     return view('admin.reports.warranty.extended_warranty', compact('customers',  'states', 'category', 'extendedWarranties'));
    }


    public function   extendedWarrantyListSorting($language, Request $request)
    {
        if ($request->ajax()) {
            $customers = \App\Models\Client::with('service_request', 'account', 'service_requests')->get();
            $states = \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')
            ->get();
            $category = \App\Models\Category::select('id', 'name', )->orderBy('name', 'ASC')
            ->get();
            $extendedWarranties='';
        
       
            (array) $filters = $request->only('user_id', 'job_status', 'jobId','sort_level', 'catIdList', 'lgaId', 'jobClaims','date');
     
            switch ($request->sort_level) {
                case 'SortType1':
                 if($request->user_id) { 
                $extendedWarranties =  ServiceRequestWarranty::where('warranty_id', '<>', '1')->whereIn('client_id',  $request->user_id[0] )->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')->orderBy('has_been_attended_to', 'ASC')->latest()->get();
                 }
                break;
                case 'SortType5':
            if(count($request->jobId[0]) > 0) {
                $extendedWarranties = \App\Models\ServiceRequestWarranty::where('warranty_id', '<>', '1')->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')
                ->whereHas('service_request', function ($query) use ($request) {
                    $query->whereIn('unique_id', $request->jobId[0]);
                })->get(); 
                
               }
                 //$query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                break;
              case 'SortType6':
                if(count($request->lgaId[0]) > 0) {
                    $extendedWarranties = \App\Models\ServiceRequestWarranty::where('warranty_id', '<>', '1')->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')
                    ->whereHas('user.account', function ($query) use ($request) {
                        $query->whereIn('lga_id', $request->lgaId[0]);
                    })->get(); 
                    
                    }
                        //$query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                break;

        case 'SortType7':
                if(count($request->catIdList[0]) > 0) {
                    $extendedWarranties = \App\Models\ServiceRequestWarranty::where('warranty_id', '<>', '1')->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')
                    ->whereHas('service_request_report.service', function ($query) use ($request) {
                        $query->whereIn('category_id', $request->catIdList[0]);
                    })->get(); 
                    
                    }
                        //$query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                break;

                case 'SortType4':
                    if($request->jobClaims) {
                    
                        $extendedWarranties =  ServiceRequestWarranty::where('warranty_id', '<>', '1')->where('initiated',  $request->jobClaims)->with('user.account', 'service_request', 'service_request_report','warranty', 'service_request_warranty_issued')->orderBy('has_been_attended_to', 'ASC')->latest()->get();

                        }
                            //$query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                    break;

            default:
                $query->latest('created_at');
                break;
            }
          
            return view('admin.reports.warranty.tables._extended_warranty_claims', compact('customers',  'states', 'category', 'extendedWarranties'));

         }
    }


}