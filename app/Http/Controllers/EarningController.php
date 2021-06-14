<?php

namespace App\Http\Controllers;

use App\Models\EarningHistory;
use Route;
use Auth;
use App\Models\Earning;
use Illuminate\Http\Request;

use App\Traits\Loggable;


class EarningController extends Controller
{
    use Loggable;

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index()
    {
        $earnings = Earning::all();
        $data = [
            'earnings' => $earnings
        ];
        return view('admin.income.earnings', $data);
    }

    public function editEarning($language, $earning)
    {
        $earningExists = Earning::where('uuid', $earning)->first();
        $data = [
            'earnings' => $earningExists
        ];
        return view('admin.income.editEarning', $data);
    }

    public function updateEarnings($language, Request $request, Earning $earning)
    {
        // Validate Earnings
        $this->validateRequest();

        if($request->input('earnings') <= 0)
        {
            return redirect()->route('admin.edit_earnings', ['locale' => app()->getLocale(), 'earning' => $earning['uuid']])->with('error', 'Earnings must be greater than 0');
        }

//        dd($request->input('earnings')/100);

        $updateEarnings = $earning->update([
            'earnings' => $request->input('earnings')
        ]);

        if($updateEarnings)
        {
            $earningHistory = new EarningHistory();
            $earningHistory->uuid = $earning->uuid;
            $earningHistory->role_name = $request->input('role_name');
            $earningHistory->earnings = $request->input('earnings');
            $earningHistory->save();

            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.$request->input('role_name').'\'s earnings';
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.earnings', app()->getLocale())->with('success', $request->input('role_name').'\'s earnings has been updated successfully');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to update '.$request->input('role_name'). ' earnings';
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.earnings', app()->getLocale())->with('error', 'An error occurred');
        }

    }

    public function deleteEarning($language, $earning)
    {
        $earningExists = Earning::where('uuid', $earning)->first();

        $softDeleteEarnings = $earningExists->delete();
        if ($softDeleteEarnings){
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$earningExists->role_name.'\'s earnings';
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.earnings', app()->getLocale())->with('success', 'earnings has been deleted');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to delete '.$earningExists->role_name.'\'s earnings';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    private function validateRequest()
    {
        return request()->validate([
            'earnings' => 'numeric|min:1'
        ]);
    }
}
