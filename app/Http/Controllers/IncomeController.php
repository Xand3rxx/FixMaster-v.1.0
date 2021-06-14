<?php

namespace App\Http\Controllers;

use App\Models\EarningHistory;
use App\Models\IncomeHistory;
use Route;
use Auth;
use App\Models\Income;
use Illuminate\Http\Request;

use App\Traits\Loggable;

class IncomeController extends Controller
{
    use Loggable;

    public function __construct() {
        $this->middleware('auth:web');
    }


    public function index()
    {
        $incomes = Income::all();

        $data = [
            'incomes' => $incomes
        ];
        return view('admin.income.income', $data);
    }

    public function editIncome($language, $income)
    {
        $incomeExists = Income::where('uuid', $income)->first();
//        dd($incomeExists);

        $data = [
            'income' => $incomeExists
        ];
        return view('admin.income.editIncome', $data);
    }

    public function updateIncome($language, Request $request, Income $income)
    {
        $amount = '';
        $percentage = '';

        if ($request->input('type') === 'amount')
        {
            $amount = $request->input('amount');
            $percentage = null;
        }
        elseif ($request->input('type') === 'percentage')
        {
            $amount = null;
            $percentage = $request->input('percentage')/100;
        }


        $updateIncome = $income->update([
            'income_type' => $request->input('type'),
            'amount' => $amount,
            'percentage' => $percentage
        ]);

        if ($updateIncome)
        {
            $incomeHistory = new IncomeHistory();
            $incomeHistory->uuid = $income->uuid;
            $incomeHistory->income_name = $request->input('income_name');
            $incomeHistory->income_type = $request->input('type');
            $incomeHistory->amount = $amount;
            $incomeHistory->percentage = $percentage;
            $incomeHistory->save();

            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.$request->input('income_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.income', app()->getLocale())->with('success', $request->input('income_name').' has been updated successfully');
        }

        else{
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to update '.$request->input('income_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.earnings', app()->getLocale())->with('error', 'An error occurred');
        }
    }

    public function deleteIncome($language, $income)
    {
        $incomeExists = Income::where('uuid', $income)->first();

        $softDeleteIncome = $incomeExists->delete();
        if ($softDeleteIncome)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$incomeExists->income_name.'\'s income';
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.income', app()->getLocale())->with('success', 'Income has been deleted');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to delete '.$incomeExists->role_name.'\'s income';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function history()
    {
        return view('admin.income.histories')->with([
            'earnings' => EarningHistory::latest('updated_at')->get(),
            'incomes' => IncomeHistory::latest('updated_at')->get()
        ]);
    }
}
