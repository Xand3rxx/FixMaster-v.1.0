<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToolInventory;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Auth;
use Route;

class ToolInventoryController extends Controller
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
        $toolsInventories = ToolInventory::AllTools()->get();

        $data = [
            'toolsInventories'  =>  $toolsInventories,
        ];

        return view('admin.tool.index', $data)->with('i');
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
        $request->validate([
            'name'          => 'required|unique:tool_inventories,name',
            'quantity'      => 'required|Numeric|min:1',
        ]);

        $createToolInventory = ToolInventory::create([
            'user_id'       =>  Auth::id(),
            'name'          =>  ucwords($request->input('name')),
            'quantity'      =>  $request->input('quantity'),
            'available'     =>  $request->input('quantity'),
            'updated_at'    =>  null,
        ]);

        if($createToolInventory){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' added '.ucwords($request->input('name')).' to Tools Inventory';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', ucwords($request->input('name')).' Tools Inventory was successfully added.');
            
        }else{
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $controllerActionPath =URL::full();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to add '.ucwords($request->input('name')).' to Tools Inventory';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to add to Tools Inventory.');
        }

        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToolInventory  $toolInventory
     * @return \Illuminate\Http\Response
     */
    public function show(ToolInventory $toolInventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ToolInventory  $toolInventory
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {

        $tool = ToolInventory::findOrFail($uuid);

        $data = [
            'tool'    =>  $tool,
        ];

        return view('admin.tool._tools_inventory_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToolInventory  $toolInventory
     * @return \Illuminate\Http\Response
     */
    public function update($language, Request $request, $uuid)
    {
        $tool = ToolInventory::findOrFail($uuid);

        $request->validate([
            'name'          => 'required|unique:tool_inventories,name,'.$uuid.',uuid',
            'quantity'      => 'required|Numeric|min:1',
        ]);

        $oldQuantity = $tool->quantity;
        $oldAvailable = $tool->available;
        $oldName = $tool->name;

        if($request->input('quantity') > $oldQuantity){
            $available = ($request->input('quantity') - $oldQuantity) + $oldAvailable;
        }else{
            $available = $oldAvailable - ($oldQuantity - $request->input('quantity'));
        }


        $updateTool = ToolInventory::where('uuid', $uuid)->update([
            'name'          =>  ucwords($request->get('name')),
            'quantity'      =>  $request->input('quantity'),
            'available'     =>  $available,
        ]);

        if($updateTool){
        
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.$oldName.' Tool';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.tools.index', app()->getLocale())->with('success', 'Tool has been updated.');
            
        }else{

            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update '. $oldName.' tool.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update Tool.');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToolInventory  $toolInventory
     * @return \Illuminate\Http\Response
     */
    // public function destroy(ToolInventory $toolInventory)
    public function destroy($language, $uuid)
    {
        $tool = ToolInventory::findOrFail($uuid);

        $deleteTool = $tool->delete();

        if($deleteTool){
            
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$tool->name.' service';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.tools.index', app()->getLocale())->with('success', 'Tool has been deleted.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to delete '.$tool->name.' tool.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to delete tool.');
        } 
    }
}
