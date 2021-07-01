<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminRatingController extends Controller
{
    public function cseDiagnosis(Request $request){
        $diagnosisRatings = Rating::where('service_diagnosis_by', '!=', null)
        ->where('ratee_id', null)->with('clientAccount', 'cseAccount','service_request')->get();
        return view('admin.ratings.job-diagnosis_rating', compact('diagnosisRatings'));
    }

    public function servicePerformance(Request $request){
        $performanceRatings = Rating::where('service_performed_by', '!=', null)
        ->where('ratee_id', null)->with('clientAccount', 'cseAcc','service_request')->get();
        return view('admin.ratings.job-performance_rating', compact('performanceRatings'));
    }

    public function getServiceRatings(Request $request)
    {

        $cards = Rating::select([
            'service_request_id',
            'rater_id',
            DB::raw('COUNT(id) as id'),
            DB::raw('AVG(star) as starAvg')
        ])->with('client', 'service_request')
        ->where('service_id', '!=', null)
        ->where('service_diagnosis_by', null)
        ->where('rater_id', '!=', null)
        ->groupBy('service_request_id')
        ->groupBy('rater_id')->get();

    return view('admin.ratings.service_rating', compact('cards'));
    }

    public function getRatings(Request $request){
       $results = Rating::where('service_request_id', $request->id)->with('clientAccount', 'service_request','service')
                ->where('service_id', '!=', null)
                ->where('service_diagnosis_by', null)
                ->where('ratee_id', '!=', null)->get();
      return response()->json($results);
    }
}
