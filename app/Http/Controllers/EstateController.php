<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DiscountHistory;
use App\Models\EstateDiscountHistory;
use Route;
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Estate;
use App\Models\State;
use App\Traits\Loggable;

class EstateController extends Controller
{
    use Loggable;

    public function __construct() {
        // $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $approvedBy = '';
        $estates = Estate::select('id', 'uuid', 'estate_name', 'first_name', 'last_name', 'email', 'phone_number', 'state_id', 'lga_id', 'is_active', 'created_by', 'approved_by', 'slug', 'created_at')
            ->orderBy('estates.estate_name', 'ASC')
            ->latest('estates.created_at')
            ->get();

        $getAdminId = Estate::select('approved_by')->pluck('approved_by');
        $approvedBy = User::find($getAdminId);

//        $clientEstateCount = Client::where('estate_id', 1)->count();
//         dd($clientEstateCount);

        return view('admin.estate.list', compact('estates', 'approvedBy'));
    }

    public function showEstates()
    {
        $estates = Estate::select('id', 'uuid', 'estate_name', 'first_name', 'last_name', 'email', 'phone_number', 'state_id', 'lga_id', 'is_active'. 'created_by', 'approved_by', 'slug', 'created_at')
            ->orderBy('estates.estate_name', 'ASC')
            ->latest('estates.created_at')
            ->get();

        return $estates;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();
        return response()->view('admin.estate.add', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get users url
        $userRole = '';

        if(Auth::user()){
            $userRole = Auth::user()->type->role->url;
        }

        //Validate users input
        $this->validateRequest();
        $is_active = '';
        $created_by = '';
        $approved_by = null;


        if($userRole === 'admin') {
            $is_active = 'reinstated';
            $created_by = Auth::user()->email;
            $approved_by = Auth::user()->id;
        }else{
            $is_active = 'pending';
            $created_by = $request->input('first_name').' '.$request->input('last_name');
            $approved_by = null;
        }

        //Create new estate record
        $storeEstate = Estate::create([
            'uuid' => Str::uuid('uuid'),
            'state_id' => $request->input('state_id'),
            'lga_id' => $request->input('lga_id'),
            'created_by' => $created_by,
            'approved_by' => $approved_by,
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'date_of_birth' => $request->input('date_of_birth'),
            'identification_type' => $request->input('identification_type'),
            'identification_number' => $request->input('identification_number'),
            'expiry_date' => $request->input('expiry_date'),
            'full_address' => $request->input('full_address'),
            'estate_name' => $request->input('estate_name'),
            'town' => $request->input('town'),
            'landmark' => $request->input('landmark'),
            'is_active' => $is_active,
            'slug' => Str::slug($request->input('estate_name'))
        ]);
        if($storeEstate) {
            if($userRole === 'admin'){
                $type = 'Request';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' created '.$request->input('estate_name');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.list_estate', app()->getLocale())->with('success', 'Estate has been added successfully');
            }
            return back()->with('success', 'Estate has been added successfully');
        } else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to create '.$request->input('estate_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.create_estate', app()->getLocale())->with('error', 'An error occurred');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function estateSummary($language, Estate $estate)
    {
        $registeredClients = Client::where('estate_id', $estate->id)->get();
        $estateDiscounts = EstateDiscountHistory::where('estate_id', $estate->id)->get();
        return view('admin.estate.summary', compact('estate', 'registeredClients', 'estateDiscounts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function edit($language, Estate $estate)
    {
        $states = State::all();
        return view('admin.estate.edit', compact('estate', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function update($language, Request $request, Estate $estate)
    {
        $this->validateUpdateRequest();

        $updateEstateRecord = $estate->update([
            'state_id' => $request->input('state_id'),
            'lga_id' => $request->input('lga_id'),
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'date_of_birth' => $request->input('date_of_birth'),
            'identification_type' => $request->input('identification_type'),
            'identification_number' => $request->input('identification_number'),
            'expiry_date' => $request->input('expiry_date'),
            'full_address' => $request->input('full_address'),
            'estate_name' => $request->input('estate_name'),
            'town' => $request->input('town'),
            'landmark' => $request->input('landmark'),
            'slug' => Str::slug($request->input('estate_name'))
        ]);

        if($updateEstateRecord) {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.$request->input('estate_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.list_estate', app()->getLocale())->with('success', 'Estate has been updated successfully');
        } else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to update '.$request->input('estate_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.edit_estate', ['estate' => $estate, 'locale' => app()->getLocale()])->with('error', 'An error occurred');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function delete($language, $estate)
    {
        $estateExists = Estate::where('uuid', $estate)->first();

        $softDeleteEstate = $estateExists->delete();
        if ($softDeleteEstate){
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$estateExists->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.list_estate', app()->getLocale())->with('success', 'Estate has been deleted');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to delete '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function reinstate($language, Estate $estate)
    {
        $reinstateEstate = $estate->update([
           'is_active'  => 'reinstated'
        ]);

        if($reinstateEstate) {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' reinstated '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.list_estate', app()->getLocale())->with('success', 'Estate has been reinstated');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to reinstate '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function deactivate($language, Estate $estate)
    {
        $deactivateEstate = $estate->update([
            'is_active'  => 'deactivated'
        ]);

        if($deactivateEstate) {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deactivated '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.list_estate', app()->getLocale())->with('success', 'Estate has been deactivated');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to deactivate '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function approve($language, Estate $estate, User $user) {
        $approveEstate = $estate->update([
            'approved_by'   =>      Auth::user()->id,
            'is_active'     =>      'reinstated'
        ]);

        $approvedBy = User::where('id', $estate->approved_by)->get();

        if($approveEstate) {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' approved '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.list_estate', app()->getLocale())->with('success', 'Estate has been approved');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to approve '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }

    }

    public function decline($language, Estate $estate) {
        $declineEstate = $estate->update([
            'approved_by'   =>      Auth::user()->id,
            'is_active'     =>      'declined'
        ]);

        if($declineEstate) {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' declined '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.list_estate', app()->getLocale())->with('success', 'Estate has been declined');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to decline '.$estate->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }

    }

    private function validateRequest() {
        return request()->validate([
            'state_id'              => 'required',
            'lga_id'                => 'required',
            'first_name'            => 'required',
            'middle_name'           => '',
            'last_name'             => 'required',
            'email'                 => 'required|email',
            'phone_number'          => 'required|Numeric',
            'date_of_birth'         => 'required',
            'identification_type'   => 'required',
            'identification_number' => 'required',
            'expiry_date'           => 'required',
            'full_address'          => 'required',
            'estate_name'           => 'required',
            'town'                  => 'required',
            'landmark'              => 'required'
        ]);
    }

    private function validateUpdateRequest()
    {
        return request()->validate([
            'state_id'              => 'required',
            'lga_id'                => 'required',
            'first_name'            => 'required',
            'middle_name'           => '',
            'last_name'             => 'required',
            'email'                 => 'required|email',
            'phone_number'          => 'required|Numeric',
            'date_of_birth'         => 'required',
            'identification_type'   => 'required',
            'identification_number' => 'required',
            'expiry_date'           => 'required',
            'full_address'          => 'required',
            'estate_name'           => 'required',
            'town'                  => 'required',
            'landmark'              => 'required'
        ]);
    }

    public function showActiveEstates()
    {
        //Get all the active estates from the db
        $activeEstates = Estate::select('id', 'estate_name')
        ->orderBy('estates.estate_name', 'ASC')
        ->where('estates.is_active', '1')
        ->get();
        return $activeEstates;

    }
}
