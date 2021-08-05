<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequestSetting;
use Illuminate\Support\Facades\Route;

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
        return view('admin.settings.service-req-criteria', [
            'setting' => ServiceRequestSetting::latest('created_at')->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {
        return view('admin.settings.service-req-criteria-edit', [
            'setting' => ServiceRequestSetting::where('uuid', $uuid)->firstOrFail()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($language, Request $request, $uuid)
    {
        //Validate if uuid exist
        $settingsExist = ServiceRequestSetting::where('uuid', $uuid)->firstOrFail();
        $actionUrl = Route::currentRouteAction();

        //Valid user input
        $valid = $request->validate([
            'radius'            =>   'required|numeric',
            'max_ongoing_jobs'  =>   'required|numeric|min:1|max:10',
        ]);

        //Update service request settings
        $updateSettings = $settingsExist->update([
            'radius'            => $valid['radius'], 
            'max_ongoing_jobs'  => $valid['max_ongoing_jobs']
        ]);

        //Record user activity
        if($updateSettings){
            $this->log('Others', 'Informational', $actionUrl, auth()->user()->email.' updated service request settings.');

            return back()->with('success', 'Service request settings was successfully updated.');
        }else{
            $this->log('Errors', 'Error', $actionUrl, 'An error occurred while '.auth()->user()->email.' was trying to update service request settings.');
 
            return back()->with('error', 'An error occurred while trying to update service request settings.');
        }
    }
}