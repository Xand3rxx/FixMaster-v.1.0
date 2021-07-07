<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{

    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['uuid', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->uuid =  (string) \Illuminate\Support\Str::uuid(); 
        });
    }

    /**
     * Get the sender associated to the message
     */
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender');
    }

    /**
     * Get the recipient associated to the message
     */
    public function recipient()
    {
        return $this->hasOne(User::class, 'id', 'recipient');
    }
}
