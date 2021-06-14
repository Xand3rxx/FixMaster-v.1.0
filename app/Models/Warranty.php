<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warranty extends Model
{
    use SoftDeletes, Generator;
    use HasFactory;

    protected $fillable = [
        'user_id','name', 'unique_id', 'percentage', 'warranty_type', 'duration', 'description'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Warranty is to be created
        static::creating(function ($warranties) {
            // Create a Unique Warranty uuid id
            $warranties->uuid = (string) Str::uuid();

            // Create a Unique Warranty id
            $warranties->unique_id = static::generate('warranties', 'WAR-');

        });

    }

    public function scopeWarranties($query){
        return $query->select('*')
        ->orderBy('name', 'ASC');
    }

    /**
     * Scope a query to only return all warranties either deleted or inactive
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllWarranties($query){
        return $query->select('*')
            // ->whereNull('deleted_at')
            ->orderBy('duration', 'ASC');
    }

    /**
     * Scope a query to only return all active warranties regardless of the stype
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveWarranties($query){
        return $query->select('*')
            ->whereNull('deleted_at')
            ->orderBy('name', 'ASC');
    }

    /**
     * Scope a query to only return all active extended warranties
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveExtendedWarranties($query){
        return $query->select('*')
            ->where('warranty_type', 'Extended')
            ->whereNull('deleted_at')
            ->orderBy('duration', 'ASC');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceRequestWarranty()
    {
        return $this->belongsTo(ServiceRequestWarranty::class, 'warranty_id', 'id');
    }
}
