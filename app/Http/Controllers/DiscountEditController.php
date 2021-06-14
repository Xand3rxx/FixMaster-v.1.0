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
use App\Models\Service;
use App\Models\Category;
use App\Models\Account;
use App\Models\Estate;
use App\Models\DiscountHistory;
use App\Traits\Utility;
use App\Traits\Loggable;
use App\Models\EstateDiscountHistory;

class DiscountEditController extends Controller
{
    use Utility,Loggable;
    //
   


    public function edit($language, $discount)
    {
        $status = Discount::select('*')->where('uuid', $discount)->first();
        $data = ['status' => $status];
        $data['apply_discounts'] = ['Total bill', 'Materials', 'Labour cost', 'FixMaster royalty', 'Logistics'];
        $json = !empty($status->parameter) ? json_decode($status->parameter): [];
        $data['field']= $json ?? $json->field;
        $data['users']= $json ? json_encode($json->users):'';
        $data['estate']= $json ? json_encode($json->estate): '';
        $data['category']= $json ? json_encode($json->category):'';
        $data['services']= $json ? json_encode($json->services): '';
        $data['entities'] = $this->entityArray();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();
        $data['request_lga']= isset($data['field']->specified_request_lga)? Lga::select('*')->where('id',  $data['field']->specified_request_lga)->first(): '';
        $data['request_state']= isset($data['field']->specified_request_lga)? State::select('*')->where('id',  $data['request_lga']['state_id'])->first(): '';
        return response()->view('admin.discount.edit', $data);
    }

   


    public function categoryEdit(Request $request)
    {
        if ($request->ajax())
        {
            $category = [];
            parse_str($request->form, $fields);
            $entity = $fields['entity'];
            $replace_value = 'user_id';
            $edit_category = json_decode($fields['edit_category'][0]) == ""? []: json_decode($fields['edit_category'][0]);  
     
            $category = Category::select('id', 'uuid','name')->orderBy('name', 'ASC')
                ->get();
            $optionValue = '';
            $optionValue .= "<option value='all' class='select-all'>All Service Category </option>";
            foreach ($category as $row)
            {
              
                $selected = '';
                if(isset($edit_category)){
                    $selected = in_array($row->id, $edit_category)? 'selected': '';
                }
                $optionValue .= "<option value='$row->id'  $selected >$row->name</option>";
            }

            $data = array(
                'category' => $optionValue
            );
        }
        return response()->json($data);

    }


    public function categoryServicesEdit(Request $request)
    {
        if ($request->ajax())
        {
           
            parse_str($request->form, $fields);
            $services = json_decode($fields['edit_services'][0]);
            $category =  isset($fields['category'])? $fields['category'] : json_decode($fields['edit_category'][0]);
        
            $service = []; 
            if (in_array("all", $category))
            {
                $service = Service::select('id', 'name')->orderBy('name', 'ASC')
                    ->get();
            }
            else
            {
                $service = Service::select('id', 'name')->whereIn('category_id', $category)
                    ->orderBy('name', 'ASC')
                    ->get();
            }
            $optionValue = '';
            $optionValue .= "<option value='all-services' class='select-all'>All services </option>";

            foreach ($service as $row)
            {
                $selected = '';
                if($services){
                $selected = in_array($row->id, $services)? 'selected': '';
                }
                $optionValue .= "<option value='$row->id' $selected >$row->name</option>";
            }
           
            $data = array(
                'service' => $optionValue
            );
        }

        return response()->json($data);
    }


    public function discountUsersEdit(Request $request)
    {
        if ($request->ajax())
        {
            $wh = $whx = $d =  $est= [];
            $groupby = '';
            $replace_amount = 'middle_name';
            $replace_user = 'client_id';
         
            parse_str($request->form, $fields);
            $entity = $fields['entity'];
            $replace_value = 'client_id';
            $WHERE=$SQL= $SQLx='';
            $edit = $request->edit;
            
            $edit_users = $edit == 1 ? []: json_decode($fields['edit_users'][0]);  
            $fields['estate_name'] = isset($fields['estate_name']) && $fields['estate_name'] != '' ? $fields['estate_name']: str_replace('"', "", $fields['estate_value']);
   

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
              
                $est = ['estates.id' => $estate_id, 'estates.is_active'=>'reinstated' ];
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


                        $selected = '';
                        if(isset($edit_users) && count($edit_users) > 0){
                            $selected = in_array($row->client_id, $edit_users)? 'selected': '';
                        }
                        $optionValue .= "<option value='$row->client_id' $selected >$name</option>";
                  
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
                          
                            $selected = '';
                            if(isset($edit_users)){
                                $selected = in_array($row->user_id, $edit_users)? 'selected': '';
                            }
                            $optionValue .= "<option value='$row->user_id' $selected >$name</option>";
                      
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
                            $selected = '';
                            if(isset($edit_users) && count($edit_users) > 0){
                                $selected = in_array($row->client_id, $edit_users)? 'selected': '';
                            }

                            $optionValue .= "<option value='$row->client_id' $selected >$name</option>";
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
                            $selected = '';
                            if(isset($edit_users)){
                                $selected = in_array($row->user_id, $edit_users)? 'selected': '';
                            }
                            $optionValue .= "<option value='$row->user_id' $selected >$name</option>";
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
                            $selected = '';
                            if(isset($edit_users)){
                                $selected = in_array($row->user_id, $edit_users)? 'selected': '';
                            }
                            $optionValue .= "<option value='$row->user_id' $selected >$name</option>";
                        
                        }
    
                    }
                 
                    $data = array(
                        'options' => $optionValue,
                        'count'=> count($dataArry)
                    );
                   break;
                default:
                    # code...
                    $data=[]; 
                break;
            }
            return response()->json($data);

        }
    }

    public function editDiscount(Request $request)
    {

        $this->validateRequestEdit($request);
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
            'estate' => isset($request->estate_value) ? str_replace('"', "", $request->estate_value): ''
           ];
        
         $discount = Discount::where('uuid', $request->discount_id)->update([
        'name' => $request->input('discount_name') ,
          'entity' => $request->input('entity') , 
          'notify' => $request->input('notify') ,
           'rate' => $request->input('rate') ,
            'duration_start' => $request->input('start_date') , 
            'duration_end' => $request->input('end_date') , 
            'description' => $request->input('description') ,
            'parameter' => json_encode($parameterArray) ,
            'created_by' => Auth::user()->email,
            'apply_discount'=> $request->input('apply_discount') ,

            ]);

            if ($discount)
            {
    
                switch ($entity)
                {
                    case 'client':
                        $update = $this->updateUsersDiscount($request,  $discount);
                    break;
                    case 'estate':
                            $update = $this->updateEstateTypeUsersDiscount($request, $discount);
                     
                    break;
                    case 'service':
                        if (!empty($request->services)){
                            $update = $this->updateServiceDiscount($request, $discount);
                        }else{
                            $update = $this->updateAllServiceDiscount($request, $discount);
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
                $message = Auth::user()->email . ' Updated discount' . $request->input('discount_name');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.discount_list', app()
                    ->getLocale())
                    ->with('success', 'Discount updated successfully');
    
            }
            else
            {
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to update ' . $request->input('discount_name');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.discount_list', app()
                    ->getLocale())
                    ->with('error', 'An error occurred');
    
            }
    
        }
 



    private function validateRequestEdit($request)
    {
        if($request->entity == 'service'){
           
            return request()->validate(['discount_name' => 'required|max:250', 'apply_discount'=>'required', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'category' =>  'required|array|min:1', 'end_date' => 'required', 'description' => 'max:250']);
        }else{
            return request()->validate(['discount_name' => 'required|max:250', 'apply_discount'=>'required', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'users' => 'required|array|min:1', 'end_date' => 'required', 'description' => 'max:250']);

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



    private function updateUsersDiscount($request, $discounts)
    {
        $discount = Discount::select('id')->where('uuid', $request->discount_id)->first();
        ClientDiscount::where(['discount_id'=>$discount->id])->delete();
        DiscountHistory::where(['discount_id'=>$discount->id])->delete();
        $accounts = Account::select('first_name', 'last_name', 'user_id')->whereIn('user_id', $request->users)->get();

      
       foreach ($request->users as $user)
        {           
         ClientDiscount::create([
            'discount_id' => $discount->id,
            'client_id' => $user,
                ]);
        }
              
       
        foreach ($accounts as $user)
        {           
        DiscountHistory::create([
            'discount_id' => $discount->id,
            'client_name' => $user->first_name.' '.$user->last_name,
            'client_id' => $user->user_id,
           
                ]);
        }
  
        return true;  
    }
    
 

 

    private function updateEstateTypeUsersDiscount($request, $discounts)
    {
    
        $discount = Discount::select('id')->where('uuid', $request->discount_id)->first();
        ClientDiscount::where(['discount_id'=>$discount->id])->delete();
        DiscountHistory::where(['discount_id'=>$discount->id])->delete();
        EstateDiscountHistory::where(['discount_id'=>$discount->id])->delete();
    
        $accounts = Account::select('first_name', 'last_name', 'user_id')->whereIn('user_id', $request->users)->get();


        foreach ($request->users as $user)
        {           
         ClientDiscount::create([
            'discount_id' => $discount->id,
            'client_id' => $user,
            'estate_id' =>   $request->estate_name,
                ]);
        
        }
        foreach ($accounts as $user)
        {           
            $discountHistory = DiscountHistory::create([
            'discount_id' => $discount->id,
            'estate_id' =>  $request->estate_name,
            'client_name' => $user->first_name.' '.$user->last_name,
            'client_id' => $user->user_id,
            'estate_name'=>  $request->estate_name
           
                ]);

                EstateDiscountHistory::create([
                    'discount_id' => $discount->id,
                    'discount_history_id' => $discountHistory->id,
                    'estate_id' =>  $request->estate_name,
                ]);
        }
         
        return true;
    }






    private function updateServiceDiscount($request, $discounts)
    {    
        $discount = Discount::select('id')->where('uuid', $request->discount_id)->first();
        ClientDiscount::where(['discount_id'=>$discount->id])->delete();
        DiscountHistory::where(['discount_id'=>$discount->id])->delete();

        $services = Service::select('services.name as servicename', 'categories.name as catname','services.id as serviceid')
        ->join('categories', 'categories.id', '=', 'services.category_id')
        ->whereIn('services.id', $request->services)
        ->get();
    
            foreach ($services as $service)
            {           
             ClientDiscount::create([
                'discount_id' => $discount->id,
                'service_id' =>  $service->serviceid,
                'client_id' => 0,
                    ]);
            
            }
            foreach ($services as $service)
            {           
              $history = DiscountHistory::create([
                'discount_id' => $discount->id,
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
                    'discount_id' => $discount->id,
                    'client_id' => $user,
                        ]);
                }
    
        
                foreach ($accounts as $key => $user)
                {   
                 
                DiscountHistory::create([
                    'discount_id' => $discount->id,
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


    private function updateAllServiceDiscount($request, $discounts)
    {    
        $discount = Discount::select('id')->where('uuid', $request->discount_id)->first();
        ClientDiscount::where(['discount_id'=>$discount->id])->delete();
        DiscountHistory::where(['discount_id'=>$discount->id])->delete();

       
        $all_services= Service::select('services.name as servicename', 'categories.name as catname','services.id as serviceid')
        ->join('categories', 'categories.id', '=', 'services.category_id')
        ->whereIn('services.category_id', $request->category)
        ->get();
  

        foreach ($all_services as $service)
        {           
         ClientDiscount::create([
            'discount_id' => $discount->id,
            'service_id' =>  $service->serviceid,
                ]);
        
        }
        foreach ($all_services as $service)
        {           
          DiscountHistory::create([
            'discount_id' => $discount->id,
            'service_id' =>  $service->serviceid,
            'service_name' => $service->servicename,
            'service_category'=> $service->catname,
           
                ]);
        }

   
        return true;
    }


 

}

