<?php

namespace App\Models;

use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use Generator;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['unique_id','created_at', 'updated_at'];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($technician) {
            $technician->unique_id = static::generate('technicians', 'TECH-'); // Create a Unique Technician/Artisan id
        });
    }

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with(['account', 'contact', 'roles']);
    }

    public function service_request_assgined()
    {
        return $this->hasMany(ServiceRequestAssigned::class, 'user_id', 'user_id');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function services()
    {
        return $this->hasMany(UserService::class, 'user_id', 'user_id')->with('service');
    }

}
