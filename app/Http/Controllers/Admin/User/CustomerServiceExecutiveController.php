<?php

namespace App\Http\Controllers\Admin\User;

use App\Traits\Utility;
use App\Traits\RegisterCSE;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerServiceExecutiveController extends Controller
{
    use Utility, RegisterCSE;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.cse.index')->with([
            'users' => \App\Models\Cse::with('user', 'user.account', 'user.contact', 'user.roles')->withCount('service_request_assgined')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.users.cse.create')->with([
            'states' => \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'banks' => \App\Models\Bank::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'franchisees' => \App\Models\Franchisee::select('id', 'cac_number')->latest()->get(),
            'applicant' => $request->session()->get('applicant')
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
        (array) $valid = $this->validateCreateCustomerServiceExecutive($request);
        // Register a CSE
        (bool) $registered = $this->register($valid);
        // Forget a single key...
        $request->session()->forget('applicant');
        return ($registered == true)
            ? redirect()->route('admin.users.cse.index', app()->getLocale())->with('success', "A Customer Service Executive Account Created Successfully!!")
            : back()->with('error', "An error occurred while creating Account");
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $language
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        $user = \App\Models\User::where('uuid', $uuid)->with('account', 'cse', 'permissions', 'contact')->firstOrFail();
        return view('admin.users.cse.show', [
            'user' => $user,
            'last_seen' => $user->load(['logs' => function ($query) {
                $query->where('type', 'logout')->orderBy('created_at', 'asc');
            }]),
            'logs' => $user->loadCount(['logs' => function ($query) {
                $query->where('type', 'login');
            }])
        ]);
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
     * Validate the create customer service executive user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreateCustomerServiceExecutive(Request $request)
    {
        return $request->validate([
            'first_name'                =>   'required|string|max:180',
            'middle_name'               =>   'sometimes|max:180',
            'last_name'                 =>   'required|string|max:180',
            'email'                     =>   'required|email|unique:users,email',
            'franchisee_id'             =>   'required|numeric|exists:franchisees,id',
            'gender'                    =>   'required|in:Male,Female,Others',
            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',
            'bank_id'                   =>   'sometimes|nullable|numeric',
            'account_number'            =>   'sometimes|nullable|numeric',
            'state_id'                  =>   'required|numeric',
            'lga_id'                    =>   'required|numeric',
            'town'                      =>   'required|string',
            'full_address'              =>   'required|string',
            'address_latitude'          =>   'sometimes|string',
            'address_longitude'         =>   'sometimes|string',
            'phone_number'              =>   'required|numeric|unique:contacts,phone_number',
            'avatar'                    =>   'sometimes|image'
        ]);
    }
}
