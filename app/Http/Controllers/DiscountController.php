<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Lga;
use App\Models\Discount;
use App\Models\ClientDiscount;
use App\Models\ServiceDiscount;
use App\Models\ServiceRequest;
use App\Models\EstateDiscountHistory;
use App\Models\Service;
use App\Models\Category;
use App\Models\Account;
use App\Models\Estate;
use App\Models\DiscountHistory;
use App\Traits\Utility;
use App\Traits\Loggable;
use Carbon\Carbon;


class DiscountController extends Controller
{
    use Utility, Loggable;
    //
    public function index()
    {
        $discounts = Discount::orderBy('id', 'DESC')->get();
        return response()->view('admin.discount.list', compact('discounts'));
    }



    public function create()
    {
        $data['entities'] = $this->entityArray();
        $data['apply_discount'] = ['Total bill', 'Materials', 'Labour cost', 'FixMaster royalty', 'Logistics'];
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')
            ->get();
        return response()
            ->view('admin.discount.add', $data);
    }

    public function store(Request $request)
    {
        //Validate discount input

        $this->validateRequest($request);
        $this->validateFieldRequest($request);


        $fields = [
        'specified_request_count_morethan' => $request->specified_request_count_morethan,
        'specified_request_count_equalto' => $request->specified_request_count_equalto,
        'specified_request_amount_from' => $request->specified_request_amount_from,
        'specified_request_amount_to' => $request->specified_request_amount_to,
        'specified_request_start_date' => $request->specified_request_start_date,
        'specified_request_end_date' => $request->specified_request_end_date,
        'specified_request_lga' => $request->specified_request_lga
         ];


        $entity = $request->input('entity');
        $users = $this->filterEntity($request);
        $update = '';
        $parameterArray = [
        'field' => array_filter($fields) ,
        'users' =>  $request->users,
        'category' => isset($request->category)? $request->category: '' ,
        'services' => isset($request->services)?$request->services:'',
        'estate' => isset($request->estate_name) ? $request->estate_name: ''
       ];


        $discount = Discount::create([
            'name' => $request->input('discount_name') ,
             'entity' => $request->input('entity') ,
             'notify' => $request->input('notify') ,
             'rate' => $request->input('rate') ,
             'duration_start' => $request->input('start_date') ,
             'duration_end' => $request->input('end_date') ,
             'description' => $request->input('description') ,
            'parameter' => json_encode($parameterArray) ,
            'created_by' => Auth::user()->email,
            'status' => 'activate',
            'apply_discount'=> $request->input('apply_discount'),
            ]);


        if ($discount)
        {

            switch ($entity)
            {
                case 'client':
                    $update = $this->createUsersDiscount($request, $discount);
                break;
                case 'estate':
                        $update = $this->createEstateTypeUsersDiscount($request, $discount);
                break;
                case 'service':
                    if (!empty($request->services)){
                        $update = $this->createServiceDiscount($request, $discount);
                    }else{
                        $update = $this->createAllServiceDiscount($request, $discount);
                    }

                break;
                default:
                    # code...

                break;
            }

        }

        if ($update)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' Created discount' . $request->input('discount_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.discount_list', app()
                ->getLocale())
                ->with('success', 'Discount created successfully');

        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to create ' . $request->input('discount_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.add_discount', app()
                ->getLocale())
                ->with('error', 'An error occurred');

        }

    }


    private function validateRequest($request)
    {
        if($request->entity == 'service'){

            return request()->validate(['discount_name' => 'required|unique:discounts,name|max:250', 'apply_discount'=>'required', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'category' =>  'required|array|min:1', 'end_date' => 'required', 'description' => 'max:250']);
        }else{
            return request()->validate(['discount_name' => 'required|unique:discounts,name|max:250', 'apply_discount'=>'required', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'users' => 'required|array|min:1', 'end_date' => 'required', 'description' => 'max:250']);

        }
    }

    private function validateFieldRequest($request)
    {
            return request()->validate([
                'specified_request_count_morethan' => 'nullable|numeric',
                'specified_request_count_equalto' => 'nullable|numeric',
                'specified_request_amount_from'  => 'nullable|numeric',
                'specified_request_amount_to'   => 'nullable|numeric',
           ]);

    }

    public function show($language, $discount)
    {
        $status = Discount::where('uuid', $discount)->first();
        $data = ['discount' => $status, ];
        $data['entities'] = $this->entityArray();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')
            ->get();
        return response()
            ->view('admin.discount.summary', $data);
    }



    public function delete($language, $discount)
    {

        $discountExists = Discount::where('uuid', $discount)->first();

        //Casted to SoftDelete
        $softDeleteUser = $discountExists->delete();
        if ($softDeleteUser)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deleted ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.discount_list', app()
                ->getLocale())
                ->with('success', 'Discount has been deleted');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to delete ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');

        }
    }

    public function deactivate($language, $discount)
    {

        $discountExists = Discount::where('uuid', $discount)->first();

        $deactivateDiscount = Discount::where('uuid', $discount)->update(['status' => 'deactivate', ]);

        if ($deactivateDiscount)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deactivated ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.discount_list', app()
                ->getLocale())
                ->with('success', 'Discount has been deactivated');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to deactivate ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function reinstate($language, $discount)
    {
        $status = '';
        $discountExists = Discount::where('uuid', $discount)->first();

        $activateDiscount = Discount::where('uuid', $discount)->update(['status' => 'activate', ]);


        if ($activateDiscount)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deactivated ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.discount_list', app()
                ->getLocale())
                ->with('success', 'Discount has been activated');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to activate ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function discountUsers(Request $request)
    {
        if ($request->ajax())
        {
            $wh = $whx = $d =  $est= [];
            $groupby = '';
            $replace_amount = 'ac.middle_name';
            $replace_user = 'client_id';
            parse_str($request->data, $fields);
            $entity = $fields['entity'];
            $replace_value = 'client_id';
            $WHERE=$SQL= $SQLx='';


            $chk_fields = ['specified_request_count_morethan' =>
             $fields['specified_request_count_morethan'],
             'specified_request_count_equalto' => $fields['specified_request_count_equalto'],
              'specified_request_amount_from' => $fields['specified_request_amount_from'],
               'specified_request_amount_to' => $fields['specified_request_amount_to'],
                'specified_request_start_date' => $fields['specified_request_start_date'],
                 'specified_request_end_date' => $fields['specified_request_end_date'],
                 'specified_request_lga' => isset($fields['specified_request_lga']) ? $fields['specified_request_lga']: '',
                 'specified_request_state' => isset($fields['specified_request_state'])? $fields['specified_request_state']: '',

                ];

            if ($fields['specified_request_count_morethan'] != '' && $fields['specified_request_count_equalto'] == '')
            {
                $whx[] ="sr.users >='".$fields['specified_request_count_morethan']."'";
                $groupby = 'group by client_id';

            }

            if ($fields['specified_request_count_equalto'] != '' && $fields['specified_request_count_morethan'] == '')
            {
                $whx[] ="sr.users <='".$fields['specified_request_count_equalto']."'";
                $groupby = 'group by client_id';
            }


            if ($fields['specified_request_count_equalto'] != '' && $fields['specified_request_count_morethan'] != '')
            {
                $equalto = (int) $fields['specified_request_count_equalto'] + 1;
                $whx[] ="sr.users between'".$fields['specified_request_count_morethan']."' and '".$equalto."'";
                $groupby = 'group by client_id';
            }

            if ($fields['specified_request_amount_from'] != '' && $fields['specified_request_amount_to'] == '')
            {
                $wh[] ="total_amount >='".$fields['specified_request_amount_from']."'";
                $replace_amount = "total_amount";
                $replace_user = 'total_amount, client_id';
                $groupby = 'group by total_amount';

            }

            if ($fields['specified_request_amount_to'] != '' && $fields['specified_request_amount_from'] == '')
            {

                $wh[] ="total_amount <='".$fields['specified_request_amount_to']."'";
                $replace_amount = "total_amount";
                $replace_user = 'total_amount, client_id';
                $groupby = 'group by total_amount';


            }

            if ($fields['specified_request_amount_to'] != '' && $fields['specified_request_amount_from'] != '')
            {
                $amount_to = (int) $fields['specified_request_amount_to'] + 1;
                $wh[] ="total_amount between'".$fields['specified_request_amount_from']."' and '".$amount_to."'";
                $replace_amount = "total_amount";
                $replace_user = 'total_amount, client_id';
                $groupby = 'group by total_amount';


            }
          
            if ($fields['specified_request_start_date'] != '' && $fields['specified_request_end_date'] == '')
            {
                $start_date = date('Y-m-d', strtotime($fields['specified_request_start_date']));
                $wh[] ="Date(created_at) >='".$start_date."'";
                $replace_amount = "sr.created_at";
                $replace_user = 'created_at, client_id';
                $groupby = 'group by client_id';

            }

            if ($fields['specified_request_end_date'] != '' && $fields['specified_request_start_date'] == '')
            {
                $end_date = date('Y-m-d', strtotime($fields['specified_request_end_date']));
                $wh[] ="Date(created_at) >='".$end_date."'";
                $replace_amount = "sr.created_at";
                $replace_user = 'created_at, client_id';
                $groupby = 'group by client_id';
            }

            if ($fields['specified_request_end_date'] != '' && $fields['specified_request_start_date'] != '')
            {
                $end_date = date('Y-m-d', strtotime($fields['specified_request_end_date']));
                $start_date = date('Y-m-d', strtotime($fields['specified_request_start_date']));              
                $wh[] ="Date(created_at) between'".$start_date."' and '".$end_date."'";
                $replace_amount = "sr.created_at";
                $replace_user = 'created_at, client_id';
                $groupby = 'group by client_id';

            }

            if (isset($fields['specified_request_state']) && $fields['specified_request_state'] != '')
            {

                $wh[] = "state_id = '".$fields['specified_request_state']."'";
                $groupby = 'group by client_id';

            }


            if (isset($fields['specified_request_lga']) && $fields['specified_request_lga'] != '')
            {

                $wh[] = "lga_id = '".$fields['specified_request_lga']."'";
                $groupby = 'group by client_id';

            }

            if (isset($fields['estate_name']) && $fields['estate_name'] != '')
            {
                $estate_id = $fields['estate_name'];
                $est = ['estates.id'=> $estate_id, 'estates.is_active' => 'reinstated' ];
                $whx[] = "est.id = '".$fields['estate_name']."' and est.is_active ='reinstated'";
                
            }

            if (count($wh) == 0 && count($whx) == 0 )
            {
                $groupby = 'group by user_id';


            }
            if (count($wh) > 0) {
                $WHERE = implode(' and ', $wh);
                $SQL .= "WHERE ( $WHERE )";
            }
            else
            {
                $SQL .= "WHERE (1)";
            }

            if (count($whx) > 0) {
                $WHERE = implode(' and ', $whx);
                $SQLx .= "WHERE ( $WHERE )";
            }
            else
            {
                $SQLx .= "WHERE (1)";
            }

            $name = $optionValue = '';
            switch ($entity)
            {
                case 'client':
                    if (count(array_filter($chk_fields)) > 0)
                    {
                        $dataArry = ServiceRequest::select('sr.client_id', $replace_amount, 'first_name', 'last_name')
                        ->from(ServiceRequest::raw("(select  $replace_user, count(client_id) as users from service_requests $SQL $groupby)
                        sr Join accounts ac ON sr.client_id=ac.user_id Join clients cs ON sr.client_id=cs.account_id  $SQLx"))
                        ->withTrashed()
                        ->get();
                        $optionValue .= "<option value='[all]' class='select-all'>All Users </option>";
                        $optionValue .= " <option value='' data-divider='true'></option>";
                        foreach ($dataArry as $row)
                        {
                            $name = $row->first_name . ' ' . $row->last_name;
                            $optionValue .= "<option value='$row->client_id' {{ old('lga') == $row->client_id ? 'selected' : ''}}>$name</option>";
                        }
                    }
                    else
                    {
                        $dataArry = Account::select('accounts.user_id', 'first_name', 'last_name')
                        ->join('clients', 'accounts.user_id', '=', 'clients.account_id')
                        ->join('users', 'users.id', '=', 'accounts.user_id')
                        ->orderBy('accounts.user_id', 'ASC')
                        ->get();

                        $optionValue .= "<option value='[all]' class='select-all'>All Users </option>";
                        $optionValue .= " <option value='' data-divider='true'></option>";
                        foreach ($dataArry as $row)
                        {
                            $name = $row->first_name . ' ' . $row->last_name;
                            $optionValue .= "<option value='$row->user_id' {{ old('lga') == $row->user_id ? 'selected' : ''}}>$name</option>";
                        }
                    }


                    $data = array(
                        'options' => $optionValue,
                        'count'=> count($dataArry)
                    );

                break;
                case 'estate':
                    $dataArry=[];
                 
                    if (count(array_filter($chk_fields)) > 0 && count($est) > 0)
                    {
                      
                            $dataArry = ServiceRequest::select('sr.client_id', 'ac.first_name', 'ac.last_name')
                            ->from(ServiceRequest::raw("(select  $replace_user, count(client_id) as users from service_requests $SQL $groupby)
                            sr Join accounts ac ON sr.client_id=ac.user_id Join clients cs ON sr.client_id=cs.account_id
                            Join estates est ON est.id=cs.estate_id $SQLx"))
                            ->withTrashed()
                            ->get();

                            $optionValue .= "<option value='[all]' class='select-all'>All Users </option>";
                            $optionValue .= " <option value='' data-divider='true'></option>";
                            foreach ($dataArry as $row)
                            {
                                $name = $row->first_name . ' ' . $row->last_name;
                                $optionValue .= "<option value='$row->user_id' {{ old('user') == $row->user_id ? 'selected' : ''}}>$name</option>";
                            }

                    }
                  if(count($est) > 0 && count(array_filter($chk_fields)) < 1)
                    {
                    
                        $dataArry = Account::select('accounts.user_id', 'accounts.first_name', 'accounts.last_name')
                        ->join('clients', 'accounts.user_id', '=', 'clients.account_id')
                        ->join('users', 'users.id', '=', 'accounts.user_id')
                        ->join('estates', 'estates.id', '=', 'clients.estate_id')
                        ->where($est)
                        ->orderBy('accounts.user_id', 'ASC')
                        ->get();

                        $optionValue .= "<option value='[all]' class='select-all'>All Users </option>";
                        $optionValue .= " <option value='' data-divider='true'></option>";
                        foreach ($dataArry as $row)
                        {
                            $name = $row->first_name . ' ' . $row->last_name;
                            $optionValue .= "<option value='$row->user_id' {{ old('user') == $row->user_id ? 'selected' : ''}}>$name</option>";
                        }

                    }

                    $data = array(
                        'options' => $optionValue,
                        'count'=> count($dataArry)
                    );

                break;
                case 'service':

                    if (count(array_filter($chk_fields)) > 0)
                    {
                        $dataArry = ServiceRequest::select('sr.client_id', $replace_amount, 'first_name', 'last_name')
                        ->from(ServiceRequest::raw("(select  $replace_user, count(client_id) as users from service_requests $SQL $groupby)
                        sr Join accounts ac ON sr.client_id=ac.user_id Join clients cs ON sr.client_id=cs.account_id  $SQLx"))
                        ->withTrashed()
                        ->get();

                        $optionValue .= "<option value='[all]' class='select-all'>All Users </option>";
                        $optionValue .= " <option value='' data-divider='true'></option>";
                        foreach ($dataArry as $row)
                        {
                            $name = $row->first_name . ' ' . $row->last_name;
                            $optionValue .= "<option value='$row->client_id' {{ old('lga') == $row->client_id ? 'selected' : ''}}>$name</option>";
                        }


                    }

                    else
                    {

                        $dataArry = Account::select('accounts.user_id', 'first_name', 'last_name')
                        ->join('clients', 'accounts.user_id', '=', 'clients.account_id')
                        ->join('users', 'users.id', '=', 'accounts.user_id')
                        ->orderBy('accounts.user_id', 'ASC')
                        ->get();

                        $optionValue .= "<option value='[all]' class='select-all'>All Users </option>";
                        $optionValue .= " <option value='' data-divider='true'></option>";
                        foreach ($dataArry as $row)
                        {
                            $name = $row->first_name . ' ' . $row->last_name;
                            $optionValue .= "<option value='$row->user_id' {{ old('lga') == $row->user_id ? 'selected' : ''}}>$name</option>";
                        }


                    }

                    $data = array(
                        'options' => $optionValue,
                        'count'=> count($dataArry)
                    );
                   break;
                default:
                $data =[];
                break;
            }
            return response()->json($data);

        }
    }

    public function getLGA(Request $request)
    {
        if ($request->ajax())
        {
            $lgas = [];
            $lgas = Lga::select('id', 'name')->where('state_id', $request->state_id)
                ->orderBy('name', 'ASC')
                ->get();
            $optionValue = '';
            $optionValue .= "<option value=''>Select </option>";
            foreach ($lgas as $row)
            {

                $optionValue .= "<option value='$row->id' {{ old('lga') == $row->id ? 'selected' : ''}}>$row->name</option>";
            }

            $data = array(
                'lgas' => $optionValue
            );

        }
        return response()->json($data);
    }

    public function estates(Request $request)
    {
        if ($request->ajax())
        {

            $estates = [];
            $estates = Estate::select('id', 'estate_name')->where('is_active', 'reinstated')->orderBy('estate_name', 'ASC')
                ->get();
            $estate_id = $request->estate_name_edit ? str_replace('"', "", $request->estate_name_edit ): $request->estate_name ;
        
            $optionValue = '';
            $optionValue .= "<option value=''>select</option>";
            foreach ($estates as $row)
            {
              $selected =  $estate_id  == $row->id ? 'selected': '';
                $optionValue .= "<option value='$row->id'  $selected>$row->estate_name</option>";
            }

            $data = array(
                'estates' => $optionValue
            );

        }

        return response()->json($data);

    }

    public function category(Request $request)
    {
        if ($request->ajax())
        {
            $category = [];
            $category = Category::select('id', 'name', )->orderBy('name', 'ASC')
                ->get();
            $optionValue = '';
            $optionValue .= "<option value='all' class='select-all'>All Service Category </option>";
            foreach ($category as $row)
            {
                if($row->name != 'Uncategorized')
                $optionValue .= "<option value='$row->id' >$row->name</option>";
            }

            $data = array(
                'category' => $optionValue
            );
        }
        return response()->json($data);

    }


    public function categoryServices(Request $request)
    {
        if ($request->ajax())
        {

            $service = [];
            if (in_array("all", $request->data))
            {
                $service = Service::select('id', 'name')->orderBy('name', 'ASC')
                    ->get();
            }
            else
            {
                $service = Service::select('id', 'name')->whereIn('category_id', $request->data)
                    ->orderBy('name', 'ASC')
                    ->get();
            }
            $optionValue = '';
            $optionValue .= "<option value='all-services' class='select-all'>All services </option>";
            foreach ($service as $row)
            {

                $optionValue .= "<option value='$row->id' >$row->name</option>";
            }
            $data = array(
                'service' => $optionValue
            );
        }

        return response()->json($data);
    }



    private function createUsersDiscount($request, $discounts)
    {
        $accounts = Account::select('first_name', 'last_name', 'user_id')->join('users', 'users.id', '=', 'accounts.user_id')->whereIn('user_id', $request->users)->get();

       foreach ($request->users as $user)
        {
        ClientDiscount::create([
            'discount_id' => $discounts->id,
            'client_id' => $user,
                ]);
        }

        foreach ($accounts as $user)
        {
        DiscountHistory::create([
            'discount_id' => $discounts->id,
            'client_name' => $user->first_name.' '.$user->last_name,
            'client_id' => $user->user_id,

                ]);
        }

        if($request->notify == '1'){
            foreach ($accounts as $user)
            {
            $mail_data_supplier = collect([
                'email' =>  $user->email,
                'template_feature' => 'CSE_SENT_SUPPLIER_MESSAGE_NOTIFICATION',
                'firstname' => $user->first_name.' '.$user->last_name,
               
            ]);
            }
            $mail1 = $this->mailAction($mail_data_supplier);
        }


        return true;
    }





    private function createEstateTypeUsersDiscount($request, $discounts)
    {
    
    
        $accounts = Account::select('first_name', 'last_name', 'user_id')->whereIn('user_id', $request->users)->get();


        foreach ($request->users as $user)
        {
         ClientDiscount::create([
            'discount_id' => $discounts->id,
            'client_id' => $user,
            'estate_id' =>   $request->estate_name,
                ]);

        }
        foreach ($accounts as $user)
        {
          $discountHistory = DiscountHistory::create([
            'discount_id' => $discounts->id,
            'estate_id' =>  $request->estate_name,
            'client_name' => $user->first_name.' '.$user->last_name,
            'client_id' => $user->user_id,
            'estate_name'=> $request->estate_name

                ]);

               
                EstateDiscountHistory::create([
                    'discount_id' => $discounts->id,
                    'discount_history_id' => $discountHistory->id,
                    'estate_id' =>  $request->estate_name
                ]);
        }


        return true;
    }



    private function createServiceDiscount($request, $discounts)
    {

        $services = Service::select('services.name as servicename', 'categories.name as catname','services.id as serviceid')
        ->join('categories', 'categories.id', '=', 'services.category_id')
        ->whereIn('services.id', $request->services)
        ->get();


        foreach ($services as $service)
        {
         ClientDiscount::create([
            'discount_id' => $discounts->id,
            'service_id' =>  $service->serviceid,
                ]);

        }
        foreach ($services as $service)
        {
          $history = DiscountHistory::create([
            'discount_id' => $discounts->id,
            'service_id' =>  $service->serviceid,
            'service_name' => $service->servicename,
            'service_category'=> $service->catname,

                ]);
        }

        if (!empty($request->users)){
            $accounts = Account::select('first_name', 'last_name', 'user_id')->whereIn('user_id', $request->users)
            ->get();

            foreach ($request->users as $user)
            {
           ClientDiscount::create([
                'discount_id' => $discounts->id,
                'client_id' => $user,
                    ]);
            }


            foreach ($accounts as $key => $user)
            {

            DiscountHistory::create([
                'discount_id' => $discounts->id,
                'client_id' => $user->user_id,
                'client_name' => $user->first_name.' '.$user->last_name,
                'service_name' =>  $history->service_name,
                'service_id' => $history->service_id,
                'service_category'=>  $history->catname,

                    ]);
             }

        }

        return true;
    }





    private function createAllServiceDiscount($request, $discounts)
    {

        $all_services= Service::select('services.name as servicename', 'categories.name as catname','services.id as serviceid')
        ->join('categories', 'categories.id', '=', 'services.category_id')
        ->whereIn('services.category_id', $request->category)
        ->get();

        foreach ($all_services as $service)
        {
         ClientDiscount::create([
            'discount_id' => $discounts->id,
            'service_id' =>  $service->serviceid,
                ]);

        }
        foreach ($all_services as $service)
        {
          DiscountHistory::create([
            'discount_id' => $discounts->id,
            'service_id' =>  $service->serviceid,
            'service_name' => $service->servicename,
            'service_category'=> $service->catname,
                ]);
        }


        return true;
    }


}

