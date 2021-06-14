<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\RegisterAdministrator;

class AdministratorController extends Controller
{
    use RegisterAdministrator;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find Administrators and use the user relationship
        return view('admin.users.administrator.index')->with([
            'users' => \App\Models\Administrator::with('user')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.administrator.create')->with([
            'roles' => \App\Models\Role::where('url', 'admin')->get(),
            'permissions' => [
                'administrators'        => 'Administrators',
                'clients'               => 'Clients',
                'location_request'      => 'Location Request',
                'cses'                  => "CSE's",
                'payments'              => 'Payments',
                'ratings'               => 'Rating',
                'requests'              => 'Requests',
                'rfqs'                  => "RFQ's",
                'service_categories'    => "Service & Category",
                'technicians'           => "Technicians",
                'tools'                 => "Tools",
                'utilities'             => "Utilities",
            ],
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
        // Validate Request
        $valid = $this->validateCreateAdministrator($request);
        // Register an Administrator
        $registered = $this->register($valid);

        return ($registered == true)
            ? redirect()->route('admin.users.administrator.index', app()->getLocale())->with('success', "An Administrator Created Successfully!!")
            : back()->with('error', "An error occurred while creating User");
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
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {
        return view('admin.users.administrator.edit', [
            'roles' => \App\Models\Role::where('url', 'admin')->get(),
            'permissions' => [
                'administrators'        => 'Administrators',
                'clients'               => 'Clients',
                'location_request'      => 'Location Request',
                'cses'                  => "CSE's",
                'payments'              => 'Payments',
                'ratings'               => 'Rating',
                'requests'              => 'Requests',
                'rfqs'                  => "RFQ's",
                'service_categories'    => "Service & Category",
                'technicians'           => "Technicians",
                'tools'                 => "Tools",
                'utilities'             => "Utilities",
            ],
            'user' => \App\Models\User::where('uuid', $uuid)->with('account', 'administrator', 'permissions', 'phones')->firstOrFail()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // validate request
        $valid = $this->validate($request, [
            'uuid'                      =>   'required|uuid',
            'first_name'                =>   'required|string',
            'middle_name'               =>   'sometimes',
            'last_name'                 =>   'required|string',
            'email'                     =>   'required|email',
            'phone_number'              =>   'required|numeric',
            'role_id'                   =>   'required|numeric',
        ]);
        $user = $this->updateAdministrator($valid);
        return collect($user)->isNotEmpty()
            ? redirect()->route('admin.users.administrator.index', app()->getLocale())->with('success', "The Administrator Profile Updated Successfully!!")
            : back()->with('error', "An error occurred while Updating Administrator Profile");
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
     * Validate the create administrator user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreateAdministrator(Request $request)
    {
        return $request->validate([
            'first_name'                =>   'required|string|max:180',
            'middle_name'               =>   'sometimes|max:180',
            'last_name'                 =>   'required|string|max:180',
            'email'                     =>   'required|email|unique:users,email',
            'phone_number'              =>   'required|numeric',
            'role_id'                   =>   'required|numeric',
            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',
            'permission'                => 'required|array',
            'permission.*'                => 'sometimes|required|string|in:on,off'
        ]);
    }
}
