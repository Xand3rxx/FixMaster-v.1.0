<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Supplier;
use App\Traits\Services;
use Illuminate\Http\Request;
use App\Traits\RegisterSupplier;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    use RegisterSupplier, Services;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.supplier.index', [
            'users' => Supplier::with('user')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(request()->session()->get('applicant')['form_data']['supplier_category'], in_array('3', request()->session()->get('applicant')['form_data']['supplier_category']));
        $service = $this->categoryAndServices();
        return view('admin.users.supplier.create', [
            'states' => \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'banks' => \App\Models\Bank::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'education_levels' => Supplier::EDUCATIONLEVEL,
            'services' => $service['services'],
            'applicant' => request()->session()->get('applicant')
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
        (array) $valid = $this->validateCreateSupplier($request);
        // Register a Supplier
        (bool) $registered = $this->register($valid);
        // Forget a single key...
        $request->session()->forget('applicant');
        return ($registered == true)
            ? redirect()->route('admin.users.supplier.index', app()->getLocale())->with('success', "A Supplier Created Successfully!!")
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
     * Validate the create supplier user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreateSupplier(Request $request)
    {
        return $request->validate([
            'first_name'                =>   'required|string|max:180',
            'middle_name'               =>   'sometimes|max:180',
            'last_name'                 =>   'sometimes|string|max:180',
            'email'                     =>   'required|email|unique:users,email|bail',
            'phone_number'              =>   'required|numeric|unique:contacts,phone_number|bail',
            'supplier_name'             =>   'required|string|max:180|unique:suppliers,business_name|bail',
            'cac_number'                =>   'required|string|max:14|unique:suppliers,cac_number|bail',
            'established_on'            =>   'required|string|date',
            'supplier_description'      =>   'required|string',
            'education_level'           =>   ['required', \Illuminate\Validation\Rule::in(Supplier::EDUCATIONLEVEL)],
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
            'avatar'                    =>   'sometimes|image',
            'supplier_category'         =>   'required|array',
            'supplier_category.*'       =>   'required|string',
        ]);
    }
}
