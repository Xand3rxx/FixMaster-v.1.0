<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Models\Service;
use App\Models\Category;
use App\Traits\Loggable;
use App\Models\SubService;
use App\Traits\ImageUpload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    use Loggable, ImageUpload;

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
        //Return all services,including inactive ones
        $services = Service::Servicies()->get();

        //Return all active categories
        $categories = Category::ActiveCategories()->get();

        $data = [
            'services'      =>  $services,
            'categories'    =>  $categories,
        ];

        return view('admin.service.index', $data)->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create', [
            'categories'  =>  Category::ActiveCategories()->get()
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
        // return $request;

        //Validate user input fields
        $this->validateRequest();

        //Set `createService` to false before Db transaction
        (bool) $createService  = false;

        // Set DB to rollback DB transacations if error occurs
        DB::transaction(function () use ($request, &$createService) {

            //Image storage directory
            $imageDirectory = public_path('assets/service-images').'/';

             //Validate if an image file was selected
            $imageName = $this->verifyAndStoreImage($request, $imageDirectory, $width = 350, $height = 259);

            //Create record for a new service
            $createService = Service::create([
                'user_id'                           =>  Auth::id(),
                'category_id'                       =>  $request->category_id,
                'name'                              =>  ucwords($request->name),
                'service_charge'                    =>  $request->service_charge,
                'diagnosis_subsequent_hour_charge'  =>  $request->diagnosis_subsequent_hour_charge,
                'description'                       =>  $request->description,
                'image'                             =>  $imageName,
                'updated_at'                        =>  null,
            ]);

            //Create each record for sub service
            if(count($request->sub_service_name) > 0){
                foreach($request->sub_service_name as $item => $value){

                    SubService::create([
                        'user_id'       =>  Auth::id(),
                        'service_id'    =>  $createService->id,
                        'name'          =>  $request->sub_service_name[$item],
                        'labour_cost'   =>  $request->labour_cost[$item],
                        'cost_type'     =>  $request->cost_type[$item],
                    ]);
                }
            }

            $createService  = true;
        });

       if($createService){

           //Record crurrenlty logged in user activity
           $type = 'Others';
           $severity = 'Informational';
           $actionUrl = Route::currentRouteAction();
           $message = Auth::user()->email.' created '.ucwords($request->input('name')).' service.';
           $this->log($type, $severity, $actionUrl, $message);

           return redirect()->route('admin.services.index', app()->getLocale())->with('success', ucwords($request->name).' service was successfully created.');

       }else{

            if(\File::exists($imageDirectory.$imageName)){

                \File::delete($imageDirectory.$imageName);
            }

           //Record Unauthorized user activity
           $type = 'Errors';
           $severity = 'Error';
           $actionUrl = Route::currentRouteAction();
           $message = 'An error occurred while '.Auth::user()->email.' was trying to create service.';
           $this->log($type, $severity, $actionUrl, $message);

           return back()->with('error', 'An error occurred while trying to create service.');
       }

       return back()->withInput();
    }

    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'name'                              =>   'required|unique:services,name',
            'category_id'                       =>   'required',
            'service_charge'                    =>   'required|numeric',
            'diagnosis_subsequent_hour_charge'  =>   'required|numeric',
            'image'                             =>   'required|mimes:jpg,png,jpeg,gif,svg|max:512',
            'description'                       =>   'required',
            'sub_service_name'                  =>   'required|array|min:1',
            'sub_service_name.*'                =>   'required|string|distinct|unique:sub_services,name',
            'labour_cost'                       =>   'required|array|min:1',
            'labour_cost.*'                     =>   'required|numeric',
            'cost_type'                         =>   'required|array|min:1',
            'cost_type.*'                       =>   'required|in:Fixed,Variable',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        return view('admin.service._show', [
            'category'    =>  Service::where('uuid', $uuid)->firstOrFail()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {

        return view('admin.service.edit', [
            'service'       =>  Service::where('uuid', $uuid)->with('subServices')->firstOrFail(),
            'categories'    =>  Category::ActiveCategories()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($language, Request $request, $uuid)
    {
        $service = Service::where('uuid', $uuid)->firstOrFail();

        //Validate user input fields
        $validate = $request->validate([
            'name'                              =>   'required|unique:services,name,'.$service->id.',id',
            'category_id'                       =>   'required',
            'service_charge'                    =>   'required|numeric',
            'diagnosis_subsequent_hour_charge'  =>   'required|numeric',
            'image'                             =>   'sometimes|mimes:jpg,png,jpeg,gif,svg|max:512',
            'description'                       =>   'required',
            'sub_service_name'                  =>   'required|array',
            // 'sub_service_name.*'                =>   'required|string|distinct|unique:sub_services,name,'.$request->sub_service_id[0].',id',
            // 'sub_service_name.*'          =>   Rule::unique('sub_services', 'name')->ignore($request->sub_service_id[0]),
        ]);

        //Validate if name is unique updating and creating of record
        if(count($validate['sub_service_name']) > count($request['sub_service_id']))
        {
            if(!empty(SubService::where('name', ucwords(end($validate['sub_service_name'])))->withTrashed()->exists())){
                return back()->with('error', 'Sub Service name has already been taken.');
            }
        }

        //Set `updateService` to false before Db transaction
        (bool) $updateService  = false;

        DB::transaction(function () use ($request, $validate, $uuid, $service, &$updateService) {

            //Image storage directory
            $imageDirectory = public_path('assets/service-images').'/';

            //Get old service image name
            $oldImageName = $request->old_post_image;

            //Validate if an image file was selected
            if($request->hasFile('image')){
                //Validate and update image with ImageUpload Trait
                $imageName = $this->verifyAndStoreImage($request, $imageDirectory, $width = 350, $height = 259);

                //Delete old service image if new image name is given
                if(!empty($imageName) && ($imageName != $oldImageName)){
                    if(\File::exists($imageDirectory.$oldImageName)){

                        \File::delete($imageDirectory.$oldImageName);
                    }
                }

            }else{
                $imageName = $oldImageName;
            }

            //Update Service record
            Service::where('uuid', $uuid)->update([
                'category_id'    =>  $request->category_id,
                'name'           =>  ucwords($request->name),
                'service_charge' =>  $request->service_charge,
                'diagnosis_subsequent_hour_charge'  =>  $request->diagnosis_subsequent_hour_charge,
                'description'    =>  $request->description,
                'image'          =>  $imageName,
            ]);

            //Update each sub service records or create a record for a new sub service added
            foreach($validate['sub_service_name'] as $item => $value){

                $service->subServices()->updateOrCreate(
                    [
                        'id'    => $request->sub_service_id[$item] ?? $service->id,
                    ],
                    [
                        'user_id'       =>  Auth::id(),
                        'service_id'    =>  $service->id,
                        'name'          =>  $request->sub_service_name[$item],
                        'labour_cost'   =>  $request->labour_cost[$item],
                        'cost_type'     =>  $request->cost_type[$item],
                    ]
                );
            }

            //Set variables as true to be validated outside the DB transaction
            $updateService  = true;
        });


        if($updateService){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.ucwords($request->input('name')).' service';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.services.index', app()->getLocale())->with('success', ucwords($request->input('name')).' service was successfully updated.');

        }else{
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update '.ucwords($request->input('name')).' service.');
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $uuid)
    {
        //Verify if uuid exists
        $service = Service::where('uuid', $uuid)->firstOrFail();

        $deleteService = $service->delete();

        if($deleteService){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$service->name.' service';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', $service->name. ' service has been deleted.');

        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to delete '.$service->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to delete '.$service->name);
        }
    }

    public function deactivate($language, $uuid)
    {
        //Get service record
        $service = Service::where('uuid', $uuid)->firstOrFail();

        //Update service status to 0, indicating inactive
        $deactivateService = Service::where('uuid', $uuid)->update([
            'status'    => 0
        ]);

        if($deactivateService){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deactivated '.$service->name.' service';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.services.index', app()->getLocale())->with('success', $service->name.' service has been deactivated.');

        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to deactivate '.$service->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to deactivate service.');
        }

    }

    public function reinstate($language, $uuid)
    {
        //Get service record
        $service = Service::where('uuid', $uuid)->firstOrFail();

        //Update service status to 1, indicating active
        $reinstateService = Service::where('uuid', $uuid)->update([
            'status'    => 1
        ]);

        if($reinstateService){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' reinstated '.$service->name.' service';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.services.index', app()->getLocale())->with('success', $service->name.' service has been reinstated.');

        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to reinstate '.$service->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to reinstate service.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroySubService($language, $uuid)
    {
        //Verify if uuid exists
        $subService = SubService::where('uuid', $uuid)->firstOrFail();

        // return $subService;

        $deleteSubService = $subService->delete();

        if($deleteSubService){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$subService->name.' sub service';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', $subService->name. ' sub service has been deleted.');;


        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to delete '.$subService->name.' sub service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to delete '.$subService->name);
        }
    }
}
