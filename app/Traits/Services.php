<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\Service;
use App\Models\ClientDiscount;

trait Services
{
    /**
     * Return a list of active categories and equivalent services
     * @return array
     */
    public function categoryAndServices()
    {
        //Get the list of all acrive categories excluding `Uncategorized`
        $categories = Category::ActiveCategories()->get();

        //Return all active categories with at least one Service
        $services = Category::ActiveCategories()
        ->where('id', '!=', 1)
        ->orderBy('name', 'ASC')
        ->with(['services'    =>  function($query){
            return $query->select('id','name', 'uuid', 'image', 'category_id');
        }])
        ->has('services')->get();

        return [
            'categories'    =>  $categories, 
            'services'      =>  $services
        ];
    }

    /**
     * Check if service uuid exist
     *
     * @param  App\Models\Service $uuid
     * @param  string  $uuid
     * 
     */
    public function service($uuid){

        return Service::where('uuid', $uuid)->select('id', 'uuid', 'name', 'image', 'description')
        ->firstOrFail();
    }

    /**
     * Return all active categories with at least one Service based on filter parameters
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $query
     * @param int $query
     * @return array
     *
     */
    public function searchKeywords($request){

        // return $request;

            $query = (string)$request->get('query');
            $query2 = $query;
            $type = $request->get('type');


            //Return array of services based on Service name parameter
            if($type == 'Name'){

                $services = Service::select('uuid', 'name', 'image')
                ->where('name', 'LIKE', '%'.$query.'%')
                ->orWhere('description', 'LIKE', '%'.$query.'%')
                ->get();
            }

            if($type == 'ID'){

                $services = Service::select('uuid', 'name', 'image')
                ->where('category_id', $query)
                ->with(['category'    =>  function($query){
                    return $query->select('name', 'id');
                }])->get();

                if(count($services) == 0){
                    $query = Service::where('id', $query2)->first()->name;
                }
            }

            return [
                'services'  =>  $services,
                'query'     =>  $query,
                'type'      =>  $type,
            ];
    }

    /**
     * Return booking fees
     *
     * @return array
     *
     */
    public function bookingFees(){

        return \App\Models\Price::all('id', 'name', 'description', 'amount');
    }

    /**
     * Return client active discounts
     *
     * @return array
     *
     */
    public function clientDiscounts(){

        return ClientDiscount::ClientServiceRequestsDiscounts()->get();
    }
}