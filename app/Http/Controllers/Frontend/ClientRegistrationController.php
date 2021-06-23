<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\RegisterClient;
use Illuminate\Http\Request;
use App\Traits\Utility;


class ClientRegistrationController extends Controller
{
    use RegisterClient, Utility;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        if ($request->code) {
            $link = $request->code;
            $authenticateReferral = $this->authenticateRefferralLink($link);
            if (!$authenticateReferral) {
                return abort(404);
            }
        }

        return view('frontend.registration.client.index', [
            'referralCode' => $request->code ?? '',
            'states' => \App\Models\State::all(),
            'activeEstates' => \App\Models\Estate::select('id', 'estate_name')
                ->orderBy('estates.estate_name', 'ASC')
                ->where('estates.is_active', 'reinstated')
                ->get(),
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
        // Validate Client Registration
        $valid = $this->validateCreateClient($request);
        if (isset($request->ref)) {
            $valid = array_merge($valid, ["ref" =>  $request->ref]);
        }
        // If registered, redirect to client url
        return ($this->register($valid) == true)
            ? redirect()->route('verification.notice', app()->getLocale())->with('success', "Email Verification Sent!")
            : back()->with('error', "An error occurred while creating User Account!!");
    }

    /**
     * Validate the create administrator user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreateClient(Request $request)
    {
        return $request->validate([
            'state_id'                  =>   'required|numeric',
            'lga_id'                    =>   'required|numeric',
            'first_name'                =>   'required|string|max:190',
            'middle_name'               =>   'sometimes|nullable|string|max:190',
            'last_name'                 =>   'required|string|max:190',
            'email'                     =>   'required|email|unique:users,email',
            'phone_number'              =>   'required|Numeric|unique:contacts,phone_number',
            'gender'                    =>   'required|in:Male,Female',
            'town_id'                   =>   'required|numeric',
            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',
            'full_address'              =>   'required|string',
            'terms_and_conditions'      =>   'required|accepted',
            'estate_id'                 =>   'nullable|numeric',
            'address_latitude'          =>   'required|string',
            'address_longitude'          =>   'required|string',
        ]);
    }
}
