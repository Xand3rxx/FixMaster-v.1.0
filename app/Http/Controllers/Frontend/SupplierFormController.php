<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierFormController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Validate Request
        (array) $valid = $this->validate($request, [
            'first_name'            => 'bail|required|string|max:180',
            'last_name'             => 'bail|required|string|max:180',
            'phone'                 => 'bail|required|numeric|min:8',
            'email'                 => 'bail|required|email|unique:users,email',

            'cac_number'            => 'required|string|max:180',
            'company_name'          => 'required|string|max:180',
            'establishment_date'    => 'required|string|date',
            
            'registered_address'    =>   'required|string',
            'office_address'        =>   'sometimes|string',

            'supplier_category'     => 'required|array',
            'supplier_category.*'   => 'required|string',

            'address_latitude'       =>   'sometimes|string',
            'address_longitude'      =>   'sometimes|string',
        ]);

        return collect(Applicant::create(['user_type' => Applicant::USER_TYPES[1],  'form_data' => $valid]))->isNotEmpty()
            ? back()->with('success', 'Application submitted successfully!!')
            : back()->with('error', 'Error Submitting Application, Retry!!');
    }
}