<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;

class CSEFormController extends Controller
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
            'first_name'         =>   'bail|required|string|max:180',
            'last_name'          =>   'bail|required|string|max:180',
            'phone'              =>   'bail|required|min:8',
            'email'              =>   'bail|required|email|unique:users,email',
            'gender'             => 'required|in:male,female,others',
            'date_of_birth'      => 'required|date|max:' . now()->subYears(18)->toDateString(),
            'address'            =>   'required|string',
            'address_latitude'       =>   'sometimes|string',
            'address_longitude'      =>   'sometimes|string',
            'cv'                 => 'required||max:3000|mimetypes:application/msword,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'referral_code'      => 'sometimes|string|nullable',

        ]);

        if ($request->hasFile('cv')) {
            $valid = array_merge($valid, ['cv' => $valid['cv']->store('assets/applicant-uploads', 'public')]);
        }

        return collect(Applicant::create(['user_type' => Applicant::USER_TYPES[0],  'form_data' => $valid]))->isNotEmpty()
            ? back()->with('success', 'Application submitted successfully!!')
            : back()->with('error', 'Error Submitting Application, Retry!!');
    }
}
