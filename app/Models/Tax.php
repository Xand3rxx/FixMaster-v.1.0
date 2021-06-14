<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tax extends Model
{
    use HasFactory;

    // column name of key
    protected $primaryKey = 'uuid';

    // type of key
    protected $keyType = 'string';

    // whether the key is automatically incremented or not
    public $incrementing = false;
    
    protected $fillable = [
        'uuid', 'user_id', 'name', 'percentage', 'applicable', 'description',
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
        static::creating(function ($tax) {
            $tax->uuid = (string) Str::uuid(); 
        });
    }

    /** 
     * Scope a query to only include availaible tools
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    public function scopeTaxes($query){
        return $query->select('*')
        ->orderBy('name', 'ASC');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id')->withDefault();
    }

    public function taxHistory()
    {
        return $this->belongsTo(TaxHistory::class, 'tax_id', 'id');
    }

    public function taxHistories()
    {
        return $this->hasMany(TaxHistory::class, 'tax_id', 'id')->orderBy('created_at', 'DESC');
    }

}
