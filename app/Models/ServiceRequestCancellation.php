<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestCancellation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'service_request_id', 'reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service_request(){
        return $this->belongsTo(ServiceRequest::class)->with('users', 'client');
    }


}
