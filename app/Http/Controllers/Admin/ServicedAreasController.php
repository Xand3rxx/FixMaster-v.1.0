<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lga;
use App\Models\Town;
use App\Models\State;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Models\ServicedAreas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ServicedAreasController extends Controller
{
    use Loggable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['lgas'] = Lga::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['towns'] = Town::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['serviceAreas'] = ServicedAreas::orderBy('created_at','DESC')->with('state', 'lga', 'town')->get(); 
        
        return view('admin.serviced_areas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate user input fields
        $this->validateRequest();

        //Create record for a new serviced area
        $createServicedAreas = ServicedAreas::create([
            'state_id'       =>  $request->state_id,
            'lga_id'         =>  $request->lga_id,
            'town_id'        =>  $request->town_id,
        ]);

        if($createServicedAreas ){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = $request->user()->email.' created new serviced area.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', 'Serviced area was successfully created.');
        }else{

        //Record Unauthorized user activity
        $type = 'Errors';
        $severity = 'Error';
        $actionUrl = Route::currentRouteAction();
        $message = 'An error occurred while '.$request->user()->email.' was trying to create new serviced area.';
        $this->log($type, $severity, $actionUrl, $message);

        return back()->with('error', 'An error occurred while trying to create new serviced area.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        $actionUrl = Route::currentRouteAction();

        if(ServicedAreas::where('uuid', $uuid)->delete()){
            //Record crurrenlty logged in user activity
            $this->log('Others', 'Informational', $actionUrl, auth()->user()->email.' deleted serviced area.');

            return back()->with('success', 'Serviced area was successfully deleted.');
        }else{
            //Record authorized user activity
            $this->log('Errors', 'Error', $actionUrl, 'An error occurred while '.auth()->user()->email.' was trying to delete serviced area.');
 
            return back()->with('error', 'An error occurred while trying to delete serviced area.');
        }
    }
    
    /**
     * Validate user input fields
     */
    protected function validateRequest(){
        return request()->validate([
            'state_id'  =>   'bail|required',
            'lga_id'    =>   'bail|required',
            'town_id'   =>   'bail|required|unique:serviced_areas,town_id', 
        ]);
    }
}
