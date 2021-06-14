<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RegisterTechnicianArtisan;
use App\Traits\Services;

class TechnicianArtisanController extends Controller
{
    use RegisterTechnicianArtisan, Services;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.technician-artisan.index')->with([
            'users' => \App\Models\Technician::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = $this->categoryAndServices();
        return view('admin.users.technician-artisan.create')->with([
            'states' => \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'banks' => \App\Models\Bank::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'services' => $service['services']
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
        (array) $valid = $this->validateCreateTechnicianArtisan($request);
        // Register a Technician-Artisan
        (bool) $registered = $this->register($valid);
        return ($registered == true)
            ? redirect()->route('admin.users.technician-artisan.index', app()->getLocale())->with('success', "A Technician/Artisan Created Successfully!!")
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
     * Validate the create administrator user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreateTechnicianArtisan(Request $request)
    {
        return $request->validate([
            'first_name'                =>   'required|string|max:180',
            'middle_name'               =>   'sometimes|max:180',
            'last_name'                 =>   'sometimes|string|max:180',
            'email'                     =>   'required|email|unique:users,email',
            'phone_number'              =>   'required|numeric|unique:contacts,phone_number|bail',
            'gender'                    =>   'required|in:Male,Female,Others',
            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',
            'bank_id'                   =>   'required|numeric',
            'account_number'            =>   'required|numeric',
            'state_id'                  =>   'required|numeric',
            'lga_id'                    =>   'required|numeric',
            'town'                      =>   'required|string',
            'full_address'              =>   'required|string',
            'address_latitude'          =>   'required|string',
            'address_longitude'         =>   'required|string',
            'avatar'                    => 'sometimes|image',
            'technician_category'       =>   'required|array',
            'technician_category.*'     =>   'required|string',
        ]);
    }
}
