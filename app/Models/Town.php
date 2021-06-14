<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Save Town details
     * 
     * @param  string   $name
     * 
     * @return \App\Model\Town|Null
     */
    protected static function saveTown(string $name)
    {
        return Town::firstOrCreate(['name' => $name]);
    }

    public function lga()
    {
        return $this->belongsTo(LGA::class);
    }
}
