<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Price extends Model
{
    use HasFactory;

    // column name of key
    protected $primaryKey = 'uuid';

    // type of key
    protected $keyType = 'string';

    // whether the key is automatically incremented or not
    public $incrementing = false;

    protected $table = 'prices';

    protected $fillable = [
        'uuid', 'user_id', 'name', 'description', 'amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Tax is to be created
        static::creating(function ($price) {
            $price->uuid = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id')->withDefault();
    }

    public function priceshistory()
    {
        return $this->belongsTo(PriceHistory::class, 'price_id', 'id');
    }

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class, 'price_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiveRequest::class, 'user_id')->withDefault();
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBookingFees($query)
    {
        return $query->select('id', 'name', 'description', 'amount');
    }
}
