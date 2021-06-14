<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ToolInventory extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "tool_inventories";

    // column name of key
    protected $primaryKey = 'uuid';

    // type of key
    protected $keyType = 'string';

    // whether the key is automatically incremented or not
    public $incrementing = false;
    
    protected $fillable = [
        'uuid', 'user_id', 'name', 'quantity', 'available',
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
        // Create a uuid when a new Tool is to be created 
        static::creating(function ($tool) {
            $tool->uuid = (string) Str::uuid(); 
        });
    }

    /** 
     * Scope a query to only include availaible tools
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    public function scopeAllTools($query){
        return $query->select('*')
        ->orderBy('name', 'ASC');
    }

    /** 
     * Scope a query to only include availaible tools
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    public function scopeAvalaibleTools($query){
        return $query->select('id', 'name')
        ->where('available', '>', '0')
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

    /**
     * Get the Account associated with the user.
     */
    public function account()
    {
        return $this->hasOne(Account::class, 'user_id', 'user_id');
    }
}
