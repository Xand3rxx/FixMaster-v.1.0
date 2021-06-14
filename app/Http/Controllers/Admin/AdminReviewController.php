<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Review;

class AdminReviewController extends Controller
{
    public function getServiceReviews(Request $request)
    {
        $serviceReviews = Review::all();
        //where('service_request_id', '!=', null)->where('ratee_id', null)->get();
        return view('admin.ratings.service_reviews', compact('serviceReviews'));
    }

    public function activate($language, Request $request, $uuid){
        Review::where('uuid', $uuid)->update(['status' => 1]);
        return back()->withSuccess('Review marked as active');
    }

    public function deactivate($language, Request $request, $uuid){
        Review::where('uuid', $uuid)->update(['status' => 0]);
        return back()->withSuccess('Review marked as Inactive');
    }

    public function delete($language, Request $request, $uuid){
        Review::where('uuid', $uuid)->delete();
        return back()->withSuccess('Review Deleted');
    }
}
