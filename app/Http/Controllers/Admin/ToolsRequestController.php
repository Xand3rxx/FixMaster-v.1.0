<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToolRequest;
use App\Models\ToolInventory;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Auth;
use Route;

class ToolsRequestController extends Controller
{
    use Loggable;
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index()
    {
        $toolRequests = ToolRequest::orderBy('created_at', 'DESC')->get();

        return view('admin.tool.requests', [
            'toolRequests'  =>  $toolRequests
        ])->with('i');
    }

    public function toolRequestDetails($language, $uuid){

        $toolRequestDetails = ToolRequest::where('uuid', $uuid)->firstOrFail();

        return view('admin.tool._request_details', [
            'toolRequestDetails'    =>  $toolRequestDetails,
        ])->with('i');

    }

    public function approveRequest($language, $uuid){

        $batchNumberExists = ToolRequest::where('uuid', $uuid)->firstOrFail();

        //Get all tools in the request batch
        $tools = $batchNumberExists->toolRequestBatches;

        $approveRequest = ToolRequest::where('uuid', $uuid)->update([
            'approved_by'   =>  Auth::id(),
            'status'        =>  'Approved',
            'updated_at'    =>  null,
        ]);

        if($approveRequest){

            //Create entries on `tool_request_batches` table for a single Tools request Batch record
            foreach ($tools as $item => $value){

                //Reduce available quantity for a particulat tool on `tool_inventories`  table
                ToolInventory::where('id', $value->tool_id)->decrement('available', $value->quantity);
            }

            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' approved Tools request with Bacth number: '.$batchNumberExists->unique_id.'.';
            $this->log($type, $severity, $actionUrl, $message);

            //Send Mail to CSE
            //Code goes here

            return redirect()->route('admin.tools_request', app()->getLocale())->with('success', $batchNumberExists->unique_id.' Tools request was approved.');

        }else{

            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to approve Tools request with Bacth number: '.$batchNumberExists->unique_id.'.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to approve '.$batchNumberExists->unique_id.' Tool request.');
        }
       
    }

    public function declineRequest($language, $uuid){

        $batchNumberExists = ToolRequest::where('uuid', $uuid)->firstOrFail();

        $batchNumber = $batchNumberExists->unique_id;

        $declineRequest = ToolRequest::where('uuid', $uuid)->update([
            'approved_by'   =>  Auth::id(),
            'status'        =>  'Declined',
            'updated_at'    =>  null,
        ]);

        if($declineRequest){

            //Record crurrenlty logged in user activity
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' declined Tools request with Bacth number: '.$batchNumberExists->unique_id.'.';
            $this->log($type, $severity, $actionUrl, $message);

            //Send Mail to CSE
            //Code goes here

            return redirect()->route('admin.tools_request', app()->getLocale())->with('success', $batchNumberExists->unique_id.' Tools request was declined.');

        }else{

            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' as trying to decline Tools request with Bacth number: '.$batchNumberExists->unique_id.'.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to decline '.$batchNumberExists->unique_id.' Tool request.');
        }
    }

    public function returnToolsRequested($language, $uuid){

        $batchNumberExists = ToolRequest::where('uuid', $uuid)->firstOrFail();

        $batchNumber = $batchNumberExists->unique_id;

        $tools = $batchNumberExists->toolRequestBatches;

        $markedRequest = ToolRequest::where('uuid', $uuid)->update([
            'is_returned'   =>  '1',
        ]);

        if($markedRequest){

            //Create entries on `tool_request_batches` table for a single Tools request Batch record
            foreach ($tools as $item => $value){

                //Reduce available quantity for a particulat tool on `tool_inventories`  table
                ToolInventory::where('id', $value->tool_id)->increment('available', $value->quantity);
            }

            //Record crurrenlty logged in user activity
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' marked Tools request with Bacth number: '.$batchNumberExists->unique_id.' as returned.';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.tools_request', app()->getLocale())->with('success', $batchNumberExists->unique_id.' Tools request was marked as returned.');

        }else{

            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to mark Tools request with Bacth number: '.$batchNumberExists->unique_id.' as returned.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to mark '.$batchNumberExists->unique_id.' Tool request as returned.');
        }
    }
}
