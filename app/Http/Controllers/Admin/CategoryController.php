<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Illuminate\Support\Str;
use Auth;
use Route;

use App\Models\Category;
use App\Models\Service;

class CategoryController extends Controller
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
        //Return all categories, including inactive ones
        $categories = Category::Categories()->get();

        //Append collections to $data array
        $data = [
            'categories'    =>  $categories
        ];

        //Return $data to view
        return view('admin.category.index', $data)->with('i');
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
        try{

            // return $request->name;
            $request->validate([
                'name'              => 'required|unique:categories,name',
                'labour_markup'     => 'required',
                'material_markup'   => 'required',
            ]);

            //Create or update record on `categories`
            $createCategory = Category::create([
                'user_id'           =>  Auth::id(),
                'name'              =>  ucwords($request->name),
                'labour_markup'     =>  $request->labour_markup/100,
                'material_markup'   =>  $request->material_markup/100,
                'updated_at'        =>  null
            ]);

            // $createCategory = Category::updateOrInsert(
            //     ['uuid'         =>  Str::uuid()],
            //     ['user_id'      =>  Auth::id()],
            //     ['name'         =>  ucwords($request->name)],
            //     ['updated_at'   =>  null]
            // );

            if($createCategory){
                //Record crurrenlty logged in user activity
                $type = 'Others';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' created '.ucwords($request->input('name')).' Category';
                $this->log($type, $severity, $actionUrl, $message);

                return back()->with('success', ucwords($request->input('name')).' Category was successfully created.');
            }

        }catch(exception $e){

            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to create Service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to create '.ucwords($request->input('name')).' Category.')->withInput();
        }

        // return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid, Request $request)
    {
        //Verify if uuid exists
        $category = Category::findOrFail($uuid);

        //Return all services assigned to a service
        $categoryServices = $category->services()->get();

        //Append variables & collections to $data array
        $data = [
            'categoryName'      =>  $category->name,
            'categoryServices'  =>  $categoryServices,
        ];

        //Return $data to partial cateogory view
        return view('admin.category._show', $data)->with('i');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {
        //Get category record
        $category = Category::findOrFail($uuid);

        $data = [
            'category'    =>  $category,
        ];

        return view('admin.category._edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($language, $uuid, Request $request)
    {

        //Validate user input fields
        $request->validate([
            'name'              =>   'required',
            'labour_markup'     => 'required',
            'material_markup'   => 'required',
        ]);

        //Get old name of category before update
        $oldCategoryName = Category::findOrFail($uuid)->name;

        //New Records of category to be uodated
        $newCategoryName   = $request->name;
        $newLabourMarkup   = $request->labour_markup/100;
        $newMaterialMarkup = $request->material_markup/100;

        //Update category name record
        $updateCategory = Category::where('uuid', $uuid)->update([
            'name'              =>  ucwords($newCategoryName),
            'labour_markup'     => $newLabourMarkup,
            'material_markup'   => $newMaterialMarkup
        ]);

        if($updateCategory){
        
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' renamed '.$oldCategoryName.' category to '.$newCategoryName;
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.categories.index', app()->getLocale())->with('success', 'Category name has been updated.');
            
        }else{

            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to rename '. $oldCategoryName.' to service '.$newCategoryName;
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update category.');
        } 
    
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
        $category = Category::findOrFail($uuid);

        //Get number of services assigned to a Category
        $assignedServices = $category->services()->count();

        //If services count is greater than 0, reassign to Uncategorized Category
        if((int)$assignedServices > 0){

            //Get ID for each service assgined to a Category
            foreach($category->services as $service){
                Service::where('id', $service->id)->update([
                    'category_id'    => 1
                ]);
            }
            //Delete Category
            $deleteCategory = $category->delete();

        }else{

            //Delete Category if assigned services count is zero
            $deleteCategory = $category->delete();
        }

        if($deleteCategory){
            
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$category->name.' category';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', $category->name. ' category has been deleted and services have been moved to Uncategorized Category.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to delete '.$category->name.' category.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to delete '.$category->name);
        } 
    }

    public function reassign($language, $uuid, Request $request)
    {

        //Verify if uuid exists
        $category = Category::findOrFail($uuid);

        //Return all services assigned to a service
        $categoryServices = $category->services()->get();

        //Return only active categories
        $categories = Category::ActiveCategories()->get();

        //Append variables & collections to $data array
        $data = [
            'categoryName'      =>  $category->name,
            'categoryServices'  =>  $categoryServices,
            'categories'        =>  $categories,
            'categoryId'        =>  $uuid,
        ];

        //Return $data to partial cateogory view
        return view('admin.category._reassign', $data)->with('i');
    }

    public function deactivate($language, $uuid)
    {
        //Get category record
        $category = Category::findOrFail($uuid);

        // $deactivateCategory = $category->delete();

        //Update category record with softDelete
        $deactivateCategory = Category::where('uuid', $uuid)->update([
            'deleted_at'    => \Carbon\Carbon::now()
        ]);

        if($deactivateCategory){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deactivated '.$category->name.' category';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.categories.index', app()->getLocale())->with('success', $category->name.' category has been deactivated.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to deactivate '.$category->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to deactivate category.');
        } 
        
    }

    public function reinstate($language, $uuid)
    {
        //Get category record
        $category = Category::findOrFail($uuid);

        //Update category record with softDelete
        $reinstateCategory = Category::where('uuid', $uuid)->update([
            'deleted_at'    => null
        ]);

        if($reinstateCategory){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' reinstated '.$category->name.' category';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.categories.index', app()->getLocale())->with('success', $category->name.' category has been reinstated.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to reinstate '.$category->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to reinstate category.');
        } 
    }

    public function reassignService(Request $request)
    {

        if($request->ajax()){

            //Get variables from ajax call
            $categoryId =  $request->get('categoryId');
            $categoryName =  $request->get('categoryName');

            $serviceId = $request->get('serviceId');
            $serviceName =  $request->get('serviceName');

            $updateService = Service::where('id', $serviceId)->update([
                'category_id'    =>  $categoryId
            ]);

            $categories = Category::ActiveCategories()->get();

            if($updateService){

                //Record crurrenlty logged in user activity
                $type = 'Others';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' reassigned '.$serviceName.'service to '.$categoryName.' category';
                $this->log($type, $severity, $actionUrl, $message);

                // return 'success';

                $data = [
                    'status'        =>  'success',
                    'categories'    =>  $categories
                ];

                return view('admin.category._table', $data)->with('i');

            }else{

                //Record crurrenlty logged in user activity
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An error occurred while '.Auth::user()->email.' was trying to reassign '.$serviceName.' service to '.$categoryName.' category';
                $this->log($type, $severity, $actionUrl, $message);

                // return 'failed';

                $data = [
                    'status'        =>  'failed',
                    'categories'    =>  $categories
                ];

                return view('admin.category._table', $data)->with('i');
            }
        }

    }
}
