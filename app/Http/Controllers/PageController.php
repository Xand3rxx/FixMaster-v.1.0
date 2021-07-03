<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Rating;
use App\Models\Review;
use App\Traits\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;


class PageController extends Controller
{
    use Services;

    public function index()
    {
        $service = $this->categoryAndServices();
        return view('frontend.careers.index', [
            'states' => State::all(),
            'services' => $service['services']
        ]);
    }

    public function services(){

        //Return all active categories with at least one Service
        return view('frontend.services.index', $this->categoryAndServices());
    }

    public function serviceDetails($language, $uuid){
        //Return Service details
        $service = $this->service($uuid);
        $rating = Rating::where('service_id', $service->id)
                    //->where('service_request_id', null)
                    ->where('service_diagnosis_by', null)
                    ->where('ratee_id', '!=', null)->get();
        $reviews = Review::where('service_id', $service->id)->where('status', 1)->get();
        return view('frontend.services.show', compact('service','rating','reviews'));
    }

    public function search($language, Request $request){

        //Return all active categories with at least one Service of matched keyword or Category ID
        return view('frontend.services._search', $this->searchKeywords($request));
    }

    public function mail(){
        (string)$url = 'yyyyyyyyyyyyyyyyy';
        $messanger = new \App\Http\Controllers\Messaging\MessageController();
        // // $user this is the instance of the created applicant
        // $mail_data = "<h1> Hello, " . $account['first_name'] . " " . $account['last_name'] . "</h1> <br> <p> Thank you for registering with us, Kind use this link " . $url . " to verify your account. </p>";
        // return $messanger->sendNewMessage('email', 'Verify Email Address', 'info@fixmaster.com.ng', $account->user->email, $mail_data);
        $template_feature = 'USER_EMAIL_VERIFICATION';
        $mail_data = collect([
            'lastname' => 'dana',
            'firstname' =>'frshs',
            'email' => 'woorad7@gmail.com',
            'url' => $url
        ]);
        $messanger->sendNewMessage('', 'info@fixmaster.com.ng', $mail_data['email'], $mail_data, $template_feature);

    }

    
}