<?php

namespace App\Models;

use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Database\Eloquent\Model;

class Cse extends Model
{
    use Generator;

    const JOB_AVALABILITY = ['Yes', 'No'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['deleted_at', 'created_at', 'updated_at', 'unique_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['user_id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($cse) {
            $cse->unique_id = static::generate('cses', 'CSE-'); // Create a Unique cse id
            $cse->referral_id = static::createCSEReferralID($cse->user_id, $cse->unique_id); // Store referral details
        });
    }

    /**
     * Handle registration of a CSE referral 
     *
     * @param  int $user_id
     * @param  string $unique_id
     * @return bool 
     */
    protected static function createCSEReferralID($user_id, string $unique_id)
    {
        return collect($referral = Referral::create(['user_id' => $user_id, 'referral_code' => $unique_id, 'created_by' => auth()->user()->email ?? 'admin@fix-master.com']))->isNotEmpty()
            ? $referral->id : 0;
    }

    /**
     * Check if Authenticated User(CSE) is available
     *
     * @return bool 
     */
    public static function isAvailable()
    {
        return auth()->user()->cse->job_availability == CSE::JOB_AVALABILITY[0]
            ? true : false;
    }

    public function serviceRequest()
    {
        return $this->belongsTo(User::class)->with(['account', 'contact']);
    }

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with(['account', 'contact']);
    }

    /**
     * Get the user referral Account.
     */
    public function referral()
    {
        return $this->hasOne(Referral::class, 'id', 'referral_id')->withDefault(['referral_code' => 'UNAVAILABLE']);
    }

    /**
     * Get the user referral Account.
     */
    public function franchisee()
    {
        return $this->hasOne(Franchisee::class, 'id', 'referral_id')->withDefault(['name' => 'UNAVAILABLE']);
    }

    /**
     * Get the service request of the CSE
     */
    public function service_request_assgined()
    {
        return $this->hasMany(ServiceRequestAssigned::class, 'user_id', 'user_id');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
