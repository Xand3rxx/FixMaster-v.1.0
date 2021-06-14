<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\GenerateUniqueIdentity as Generator;

class ToolRequest extends Model
{
    use SoftDeletes, Generator;

    protected $fillable = [
        'unique_id', 'requested_by', 'approved_by', 'service_request_id', 'status', 'is_returned'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Tool Request is to be created
        static::creating(function ($toolRequest) {
            // Create a Unique Tool Request uuid id
            $toolRequest->uuid = (string) Str::uuid();
            // Create a Unique Tool Request Batch Number
            $toolRequest->unique_id = static::generate('tool_requests', 'TRF-');

        });

    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by')->with('account');
    }

    public function requesters()
    {
        return $this->hasMany(User::class, 'requested_by')->with('account');
    }
    
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by')->with('account');
    }

    public function approvers()
    {
        return $this->hasMany(User::class, 'approved_by')->with('account');
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id')->with('client');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'service_request_id')->withTrashed();
    }

    public function toolRequestBatch()
    {
        return $this->hasOne(ToolRequestBatch::class, 'tool_request_id');
    }

    public function toolRequestBatches()
    {
        return $this->hasMany(ToolRequestBatch::class, 'tool_request_id');
    }

    public function toolRequestBatchess()
    {
        return $this->belongsToMany(ToolRequestBatch::class, 'id', 'tool_request_id');
    }

    /** 
     * Scope a query to only include all pending requests
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    //Scope to return all services  
    public function scopePendingRequests($query)
    {
        return $query->select('*')
            ->where('status', 'Pending');
    }
}
