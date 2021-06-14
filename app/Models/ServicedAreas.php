<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServicedAreas extends Model
{
    protected $fillable = [
        'state_id', 'lga_id', 'town_id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new serivce uuid is to be created
        static::creating(function ($service) {
            $service->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the state
     */
    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    /**
     * Get the state
     */
    public function lga()
    {
        return $this->hasOne(LGA::class, 'id', 'lga_id');
    }

    /**
     * Get the state
     */
    public function town()
    {
        return $this->hasOne(Town::class, 'id', 'town_id');
    }
    
}