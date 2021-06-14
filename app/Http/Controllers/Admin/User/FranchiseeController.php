<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Traits\RegisterFranchisee;
use Illuminate\Http\Request;

class FranchiseeController extends Controller
{
    use RegisterFranchisee;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.franchisee.index', [
            'users' => \App\Models\Franchisee::with('user')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.franchisee.create', [
            'states' => \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'banks' => \App\Models\Bank::select('id', 'name')->orderBy('name', 'ASC')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        (array) $valid = $this->validateCreatingFranchisee($request);
        // register using the validated Franchisee record
        (bool) $registered = $this->register($valid);

        return ($registered == true)
            ? redirect()->route('admin.users.franchisee.index', app()->getLocale())->with('success', "A Franchisee Account Created Successfully!!")
            : back()->with('error', "An error occurred while creating Account");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Validate the create franchisee user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreatingFranchisee(Request $request)
    {
        return $request->validate([
            'first_name'                =>   'required|string|max:180',
            'middle_name'               =>   'sometimes|max:180',
            'last_name'                 =>   'sometimes|string|max:180',
            'email'                     =>   'required|email|unique:users,email|bail',
            'phone_number'              =>   'required|numeric|unique:contacts,phone_number|bail',
            'franchisee_name'           =>   'required|string|max:180',
            'cac_number'                =>   'required|string|max:14|unique:franchisees,cac_number|bail',
            'established_on'            =>   'required|string|date',
            'franchisee_description'    =>   'required|string',
            'bank_id'                   =>   'required|numeric',
            'account_number'            =>   'required|numeric',
            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',
            'state_id'                  =>   'required|numeric',
            'lga_id'                    =>   'required|numeric',
            'town'                      =>   'required|string|max:180',
            'full_address'              =>   'required|string',
            'address_latitude'          =>   'required|string',
            'address_longitude'         =>   'required|string',
            'avatar'                    => 'sometimes|image'
        ]);
    }
}
