<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueIdentity as Generator;

class Supplier extends Model
{
    use Generator;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['unique_id', 'created_at', 'updated_at'];

    const EDUCATIONLEVEL = ['none', 'primary-school', 'secondary-school', 'technical-school', 'college-of-education', 'polytechnic', 'university'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($supplier) {
            $supplier->unique_id = static::generate('suppliers', 'SUP-'); // Create a Unique Supplier id
        });
    }

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with(['account', 'contact', 'roles']);
    }
}
