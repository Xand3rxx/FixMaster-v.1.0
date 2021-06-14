<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TechnicianArtisanFormController extends Controller
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
            'first_name'             =>   'bail|required|string|max:180',
            'last_name'              =>   'bail|required|string|max:180',
            'phone'                 =>   'bail|required|numeric|min:8',
            'email'                 =>   'bail|required|email|unique:users,email',
            'gender'                => 'required|in:male,female,others,null',
            'years_of_experience'   => 'required|numeric',
            'residential_address'            =>   'required|string',
            'postal_address'            =>   'sometimes|string',
            'certificate_upload'      => 'sometimes|array',
            'certificate_upload.*'    => 'sometimes||max:3000|mimetypes:application/msword,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'address_latitude'       =>   'sometimes|string',
            'address_longitude'      =>   'sometimes|string',
        ]);

        if ($request->hasFile('certificate_upload')) {
            (array)$certificateUploaded = [];
            foreach ($valid['certificate_upload'] as $key => $certificate) {
                array_push($certificateUploaded, $certificate->store('assets/applicant-uploads', 'public'));
            }
            $valid = array_merge($valid, $certificateUploaded);
        }

        return collect(Applicant::create(['user_type' => Applicant::USER_TYPES[2],  'form_data' => $valid]))->isNotEmpty()
            ? back()->with('success', 'Application submitted successfully!!')
            : back()->with('error', 'Error Submitting Application, Retry!!');
    }
}