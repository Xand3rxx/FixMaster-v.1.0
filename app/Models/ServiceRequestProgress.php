<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestProgress extends Model
{
    protected $table = 'service_request_progresses';
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * Store record of a Assigned User on the Service Request Progress Table
     * 
     * @param  int          $user_id
     * @param  int          $service_request_id
     * @param  int          $status_id
     * @param  int|Null     $sub_status_id
     * @return \App\Models\ServiceRequestProgress|Null
     */
    public static function storeProgress(int $user_id, int $service_request_id, int $status_id, int $sub_status_id = null)
    {
        return ServiceRequestProgress::create([
            'user_id'              => $user_id,
            'service_request_id'   => $service_request_id,
            'status_id'            => $status_id,
            'sub_status_id'        => $sub_status_id,
        ]);
    }


    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with('account', 'roles');
    }

    /**
     * Get the user that owns the Account.
     */
    public function substatus()
    {
        return $this->hasOne(SubStatus::class, 'id', 'sub_status_id');
    }
}
