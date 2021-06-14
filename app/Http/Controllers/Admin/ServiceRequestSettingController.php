<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequestSetting;
use App\Traits\Loggable;

class ServiceRequestSettingController extends Controller
{
    use Loggable;

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Return all taxes
        $requestSetting = ServiceRequestSetting::latest()->get();

        //Append collections to $data array
        $data = [
            'requestSetting' =>  $requestSetting
        ];

        return view('admin.settings.service-req-criteria', $data)->with('i');
    }



}