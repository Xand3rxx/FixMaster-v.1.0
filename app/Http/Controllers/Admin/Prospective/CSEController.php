<?php

namespace App\Http\Controllers\Admin\Prospective;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CSEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.prospective.cse.index')->with([
            'users' => Applicant::where('user_type', Applicant::USER_TYPES[0])->latest()->get()->sortByDesc('status'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, string $uuid)
    {
        return view('admin.prospective.cse.show', [
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
                return redirect()->route('admin.users.cse.create', app()->getLocale());
                break;

            case 'decline': # declined cse...
                $applicant->update(['status' =>  Applicant::STATUSES[2]]);
                return redirect()->route('admin.prospective.cse.index', app()->getLocale())->with('success', 'Application Rejected Successfully!!');
                break;

            default:
                return back()->with('error', 'Error Occured Updating Application Decision');
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  string $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}