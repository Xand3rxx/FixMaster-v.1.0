<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\LGA;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssigned;
use Illuminate\Http\Request;

class EssentialsController extends Controller
{

    public function getTowns(Request $request)
    {
        if ($request->ajax()) {
            $foundTowns = \App\Models\Town::where('state_id', $request['state_id'])->where('lga_id', $request['lga_id'])->get();
            $optionValue = '';
            $optionValue .= "<option disabled value='0' selected>Select A Town</option>";
            foreach ($foundTowns as $town) {

                $optionValue .= "<option value='$town->id' {{ old('town_id') == $town->id ? 'selected' : ''}}>$town->name</option>";
            }
            $towns = ['towns_list' => $optionValue];
        }
        return response()->json($towns);
    }

    public function lgasList(Request $request)
    {
        if ($request->ajax()) {

            $stateId = $request->get('state_id');

            $stateExists = State::findOrFail($stateId);

            $lgas =  $stateExists->lgas;

            $optionValue = '';
            $optionValue .= "<option value='' selected>Select L.G.A</option>";
            foreach ($lgas as $lga) {

                $optionValue .= "<option value='$lga->id' {{ old('lga_id') == $lga->id ? 'selected' : ''}}>$lga->name</option>";
            }

            $data = array(
                'lgaList' => $optionValue
            );
        }

        return response()->json($data);
    }


    public function wardsList(Request $request)
    {
        if ($request->ajax()) {

            $lgaId = $request->get('lga_id');

            $stateExists = Lga::findOrFail($lgaId);

            $towns =  $stateExists->towns;

            $optionValue = '';
            $optionValue .= "<option value='' selected>Select Town</option>";
            foreach ($towns as $town) {

                $optionValue .= "<option value='$town->id' {{ old('town_id') == $town->id ? 'selected' : ''}}>$town->name</option>";
            }

            $data = array(
                'townList' => $optionValue
            );
        }

        return response()->json($data);
    }


    public function getServiceDetails(Request $request)
    {
        // $serviceRequests = ServiceRequestAssigned::where('user_id', 1)->with('service_request')->get();
        $serviceRequests = ServiceRequest::with('serviceRequestAssigned')->get();
        return $serviceRequests;
    }

    public function Edit($id)
    {
        $data = ServiceRequestSettingController::find($id);
        return $data;
    }

    public function getAvailableToolQuantity(Request $request)
    {
        if ($request->ajax()) {
            $toolId = $request->get('tool_id');

            $toolExists = \App\Models\ToolInventory::findOrFail($toolId);

            $availableQuantity =  $toolExists->available;

            return $availableQuantity;
        }
    }
}
