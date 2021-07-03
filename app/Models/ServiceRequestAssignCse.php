<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestAssignCse extends Model
{
    protected $table = 'service_request_assign_cses';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * Get the service request assigned user
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with('account', 'roles');
    }

    /**
     * Get the service request of the assigned user
     */
    public function service_request()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }
}
