<?php


namespace App\Traits;


use App\Models\Estate;

trait ActiveEstates
{
    public function showActiveEstates()
    {
        //Get all the active estates from the db
        $activeEstates = Estate::select('id', 'estate_name')
            ->orderBy('estates.estate_name', 'ASC')
            ->where('estates.is_active', 'reinstated')
            ->get();
        return $activeEstates;
    }

}
