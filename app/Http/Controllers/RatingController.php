<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Traits\Loggable;
use App\Models\LoyaltyManagement;
use Illuminate\Support\Facades\DB;
use App\Models\ClientLoyaltyWithdrawal;
use App\Models\LoyaltyManagementHistory;

class RatingController extends Controller
{
    use Loggable;
    /**
     * Handle Ratings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handleRatings(Request $request)
    {
        //dd($request->all());
        (array) $valid = $this->validateRatingsRequest($request);
        //return $request->clientStar."<br>".$request->getClient."<br>".$request->star."<br>".$request->usersIdentity."<br>".$request->serviceRequestId;
        return self::store($valid, $request->user()->id) == true
            ? back()->with('success', 'Thank you for rating the request')
            : back()->with('error', 'Sorry! An error occured while recording rating the request.');
    }

    public function handleClientRatings(Request $request)
    {
        //dd($request->all());
        (array) $valid = $this->validateClientRatingsRequest($request);
        return self::storeClientRating($valid, $request->user()->id) == true
            ? back()->with('success','Thank you for rating this service, you have qualified for a loyalty reward.')
            : back()->with('error', 'Sorry! An error occured while recording rating the request.');
    }

    public function handleServiceRatings(Request $request)
    {
        $rese = ServiceRequest::find($request->serviceRequestId);
        $rese->has_cse_rated = "Skipped";
        $rese->touch();
        $rese->save();

        return response()->json("Yea, It is updated");
    }

    public function handleUpdateServiceRatings(Request $request)
    {
        $resp = ServiceRequest::find($request->serviceRequestId);
        $resp->has_client_rated = "Skipped";
        $resp->touch();
        $resp->save();

        return response()->json("Yea, Client Rating is updated");
    }

    protected static function store(array $valid, int $user_id)
    {
        (bool) $registred = false;

        DB::transaction(function () use ($valid, $user_id, &$registred) {
            // Record each User rating
            foreach ($valid['users_id'] as $key => $user) {
                Rating::create([
                    'rater_id' => $user_id,
                    'ratee_id' => $user,
                    'service_request_id' => $valid['serviceRequestId'],
                    'star' => $valid['users_star'][$key],
                ]);
            }
            // Record Client Rating
            Rating::create([
                'rater_id' => $user_id,
                'ratee_id' => $valid['client_id'],
                'service_request_id' => $valid['serviceRequestId'],
                'star' => $valid['client_star'],
            ]);
            // Update the service request to indicate rated
            ServiceRequest::where('id', $valid['serviceRequestId'])->first()->update(['has_cse_rated' => 'Yes']);
            // update registered to be true
            $registred = true;
        });
        return $registred;

    }

    protected static function storeClientRating(array $valid, int $user_id)
    {
        (bool) $registred = false;

        DB::transaction(function () use ($valid, $user_id, &$registred) {
            // Record each User rating
            foreach ($valid['users_id'] as $key => $user) {
                Rating::create([
                    'rater_id' => $user_id,
                    'ratee_id' => $user,
                    'service_request_id' => $valid['serviceRequestId'],
                    'service_id' => $valid['serviceId'],
                    'star' => $valid['users_star'][$key],
                ]);
            }
            // Record CSE Diagnosis Rating
            Rating::create([
                'rater_id' => $user_id,
                'service_request_id' => $valid['serviceRequestId'],
                'star' => $valid['diagnosis_star'],
                'service_diagnosis_by' => $user,
            ]);

            //Record Review for Service
            Review::create([
                'client_id' => $user_id,
                //'service_request_id' => $valid['serviceRequestId'],
                'service_id' => $valid['serviceId'],
                'reviews' => $valid['review'],
            ]);

            // Update the service request to indicate rated
            ServiceRequest::where('id', $valid['serviceRequestId'])->first()->update(['has_client_rated' => 'Yes']);

            //Record Loyalty Reward for client
            $point = 10;
            $wallet_value = (float)$point/100 * (float)$valid['totalAmount'];
            $loyalty = LoyaltyManagement::create([
                'client_id' => $user_id,
                 'points' => $point,
                 'type' => 'credited',
                 'amount'=> $valid['totalAmount']

                ]);

                $loyalty_history = LoyaltyManagementHistory::create([
                    'loyalty_mgt_id'=> $loyalty->id,
                    'client_id' => $user_id ,
                    'points' => $point,
                    'type' => 'credited',
                    'amount'=> $valid['totalAmount']

                   ]);

                   //if clientloyalty wallet exist
               $ifClientLoyalty =  ClientLoyaltyWithdrawal::where('client_id', $user_id)->first();
               if($ifClientLoyalty){
                ClientLoyaltyWithdrawal::where(['client_id'=> $user_id])->increment(
                    'wallet',(float) $wallet_value);
               }else{
                ClientLoyaltyWithdrawal::create([
                    'loyalty_mgt_id'=> $loyalty->id,
                    'client_id' => $user_id,
                    'wallet' => $wallet_value
                ]);
               }

               if( $loyalty_history  &&   $loyalty ){
                //LoyaltyManagement::where(['uuid'=>$request->loyalty_uuid, 'client_id' => $request->edit_client])->delete();
                //LoyaltyManagementHistory::where(['loyalty_mgt_id'=>$request->loyalty_id,'client_id' => $request->edit_client])->delete();

                $type = 'Request';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email . ' Qualified for loyalty';
                self::log($type, $severity, $actionUrl, $message);
            }
            else
            {
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An Error Occured while ' . Auth::user()->email. 'was about rating';
                self::log($type, $severity, $actionUrl, $message);
            }
            // update registered to be true
            $registred = true;
        });
        return $registred;
    }

    /**
     * Validate the ratings request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateRatingsRequest(Request $request)
    {
        return $this->validate($request, [
            'client_star' => 'required|numeric|between:1,5',
            'client_id' => 'required|numeric',
            'users_id' => 'required|array',
            'users_id.*' => 'required|numeric',
            'users_star' => 'required|array',
            'users_star.*' => 'required|numeric|between:1,5',
            'client' => 'required',
            'serviceRequestId' => 'required|numeric'
        ]);
    }

    protected function validateClientRatingsRequest(Request $request)
    {
        return $this->validate($request, [
            'review' => 'required|max:255',
            'diagnosis_star' => 'required|numeric|between:1,5',
            'users_id' => 'required|array',
            'users_id.*' => 'required|numeric',
            'users_star' => 'required|array',
            'users_star.*' => 'required|numeric|between:1,5',
            'serviceRequestId' => 'required|numeric',
            'serviceId' => 'required',
            'totalAmount' => 'required'
        ]);
    }
}
