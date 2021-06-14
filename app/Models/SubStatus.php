<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'status_id', 'name', 'phase', 'recurrence', 'status'
    ];

    const Substatus = [
        'Pending',
        'FixMaster AI assigned a CSE',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new sub status uuid is to be created
        static::creating(function ($subStatus) {
            $subStatus->uuid = (string) Str::uuid();
        });
    }

    /** 
     * Scope a query to only include active sub statuses
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    //Scope to return all services  
    public function scopeSubStatuses($query)
    {
        return $query->select('*')
            ->orderBy('id', 'ASC');
        // ->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id')->withDefault();
    }

    public function parentStatus()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
