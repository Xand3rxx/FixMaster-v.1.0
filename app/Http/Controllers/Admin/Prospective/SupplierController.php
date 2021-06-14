<?php

namespace App\Http\Controllers\Admin\Prospective;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.prospective.supplier.index')->with([
            'users' => Applicant::where('user_type', Applicant::USER_TYPES[1])->get(),
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $locale
     * @param  string  $uuid
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(string $locale, string $uuid)
    {
        // dd(Applicant::where('uuid', $uuid)->with('category')->firstOrFail());
        return view('admin.prospective.supplier.show', [
            'user' => Applicant::where('uuid', $uuid)->firstOrFail()
        ]);
    }

     /**
     * Handling of CSE Application Decision
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decision(Request $request)
    {
        (array)$decision = $request->validate([
            'decision' => 'required|string|in:approve,decline',
            'user' => 'required|uuid|exists:applicants,uuid'
        ]);
        return $this->handleDecision($decision);
    }

    /**
     * Handling of CSE Application Decision
     *
     * @param  string  $decision
     * @return \Illuminate\Http\Response
     */
    protected function handleDecision(array $decision)
    {
        $applicant = Applicant::where('uuid', $decision['user'])->firstOrfail();
        switch ($decision['decision']) {
            case 'approve': # approve cse...
                $applicant->update(['status' =>  Applicant::STATUSES[1]]);
                session(['applicant' => $applicant]);
                return redirect()->route('admin.users.supplier.create', app()->getLocale());
                break;

            case 'decline': # declined cse...
                $applicant->update(['status' =>  Applicant::STATUSES[2]]);
                return redirect()->route('admin.prospective.supplier.index', app()->getLocale())->with('success', 'Application Rejected Successfully!!');
                break;

            default:
                return back()->with('error', 'Error Occured Updating Application Decision');
                break;
        }
    }
    
}
