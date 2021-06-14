<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use App\Models\TaxHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Auth;
use Route;
use DB;

class TaxController extends Controller
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
        $taxes = Tax::Taxes()->get();

        //Append collections to $data array
        $data = [
            'taxes' =>  $taxes
        ];

        return view('admin.tax.index', $data)->with('i');
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
    public function store($language, Request $request)
    {
        try{

            //Validate user input fields
            $this->validateRequest();

            //Update colum to `No => 0` if `Yes = 1` is selected
            if((int)$request->applicable == 1){
                DB::table('taxes')->update(array('applicable' => 0));
            }

            //Create record for a new tax
            $createTax = Tax::create([
                'user_id'        =>  Auth::id(),
                'name'          =>   ucwords($request->name),
                'percentage'    =>   $request->percentage,
                'applicable'    =>   $request->applicable, 
                'description'   =>   $request->description,
            ]);

            $newTaxID = Tax::findOrFail($createTax->uuid);

            //Create record for a new tax history
            $createTaxHistory = TaxHistory::create([
                'user_id'       =>  Auth::id(),
                'tax_id'        =>  $newTaxID->id,
                'percentage'    =>  $request->percentage,
            ]);

            if($createTax AND $createTaxHistory){

                //Record crurrenlty logged in user activity
                $type = 'Others';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' created '.ucwords($request->input('name')).' tax.';
                $this->log($type, $severity, $actionUrl, $message);
    
                return redirect()->route('admin.taxes.index', app()->getLocale())->with('success', ucwords($request->name).' tax was successfully created.');
            }
 
        }catch(exception $e){
 
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to create tax.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return back()->with('error', 'An error occurred while trying to create tax.');
        }
 
    }

    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'name'          =>   'required|unique:taxes,name',
            'percentage'    =>   'required|numeric|between:0,99.99',
            'applicable'    =>   'required', 
            'description'   =>   '', 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        //Verify if uuid exists
        $tax = Tax::findOrFail($uuid);

        //Return all tax histories for a particular tax record
        $taxHistories = $tax->taxHistories;

        //Append variables & collections to $data array
        $data = [
            'taxName'       =>  $tax->name,
            'taxHistories'  =>  $taxHistories,
        ];

        //Return $data to partial cateogory view
        return view('admin.tax._show', $data)->with('i');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {
        $tax = Tax::findOrFail($uuid);

        $data = [
            'tax'    =>  $tax,
        ];

        return view('admin.tax._edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update($language, $uuid, Request $request)
    {
        //Validate user input fields
        $request->validate([
            'name'          =>   'required',
            'percentage'    =>   'required|numeric|between:0,99.99',
            'applicable'    =>   'required', 
            'description'   =>   '', 
        ]);

        //Update colum to `No => 0` if `Yes = 1` is selected
        if((int)$request->applicable == 1){
            DB::table('taxes')->update(array('applicable' => 0));
        }

        //Create record for a new tax history if percentage is different from the previous tax percentage
        if(strcmp($request->percentage, Tax::findOrFail($uuid)->percentage) != 0){

            // return 'true';
            $updateTaxHistory = TaxHistory::create([
                'user_id'       =>  Auth::id(),
                'tax_id'        =>  Tax::findOrFail($uuid)->id,
                'percentage'    =>  $request->percentage,
            ]);
        }

        //Update tax
        $updateTax = Tax::where('uuid', $uuid)->update([
            'name'          =>   ucwords($request->name),
            'percentage'    =>   $request->percentage,
            'applicable'    =>   $request->applicable, 
            'description'   =>   $request->description,
        ]);
        
        if($updateTax){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.ucwords($request->input('name')).' tax';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.taxes.index', app()->getLocale())->with('success', ucwords($request->input('name')).' tax was successfully updated.');

        }else{
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update tax.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update '.ucwords($request->input('name')).' tax.');
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $uuid)
    {
        //Verify if uuid exists
        $tax = Tax::findOrFail($uuid);

        $deleteTax = $tax->delete();

        if($deleteTax){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$tax->name.' tax';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', $tax->name. ' tax has been deleted.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to delete '.$tax->name.' tax.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to delete '.$tax->name);
        } 
    }
}
