<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\PriceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Auth;
use Route;
use DB;

class PriceController extends Controller
{
    use Loggable;
    
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookingFees = Price::all();

        // return $bookingFees;

        $data = [
            'bookingFees'   =>  $bookingFees,
        ];

        return view('admin.booking_fee.index', $data)->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        //Verify if uuid exists
        $price = Price::findOrFail($uuid);

        //Return all price histories for a particular price record
        $priceHistories = $price->priceHistories;

        //Append variables & collections to $data array
        $data = [
            'priceName'       =>  $price->name,
            'priceHistories'  =>  $priceHistories,
        ];

        //Return $data to partial cateogory view
        return view('admin.booking_fee._show', $data)->with('i');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {
        $bookingFee = Price::findOrFail($uuid);

        $data = [
            'bookingFee'    =>  $bookingFee,
        ];

        return view('admin.booking_fee._edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update($language, $uuid, Request $request)
    {
        //Validate user input fields
        $request->validate([
            'name'          =>   'required',
            'amount'    =>   'required|numeric',
            'description'   =>   '', 
        ]);

        //Create record for a new price history if amount is different from the previous booking fee amount
        if(strcmp($request->amount, Price::findOrFail($uuid)->amount) != 0){
            $updateBookingFeeHistory = PriceHistory::create([
                'user_id'   =>  Auth::id(),
                'price_id'  =>  Price::findOrFail($uuid)->id,
                'amount'    =>  $request->amount,
            ]);
        }

        //Update booking fee
        $updateBookingFee = Price::where('uuid', $uuid)->update([
            'name'          =>   ucwords($request->name),
            'amount'        =>   $request->amount,
            'description'   =>   $request->description,
        ]);
        
        if($updateBookingFee){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.ucwords($request->input('name')).' booking fee';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.booking-fees.index', app()->getLocale())->with('success', ucwords($request->input('name')).' booking fee was successfully updated.');

        }else{
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update booking fee.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update '.ucwords($request->input('name')).' booking fee.');
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        //
    }
}
