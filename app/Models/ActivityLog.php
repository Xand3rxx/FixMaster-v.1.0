<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'severity', 'action_url', 'message',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'updated_at',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($log) {
            $log->user_id = request()->user()->id; // The User making the Request, If not Authenticated, Null is stored
            $log->ip_address = request()->ip(); // Ip Address of the user making the request
            $log->user_agent = request()->userAgent(); // User Agent of the user making the request
            $log->request_url = request()->fullUrl(); // The full url the request is from
        });
    }

    /**
     * Get the Type associated with the user.
     */
    public function type()
    {
        return $this->hasOne(UserType::class, 'user_id', 'user_id');
    }

    /**
     * Get the Account associated with the user.
     */
    public function account()
    {
        return $this->hasOne(Account::class, 'user_id', 'user_id');
    }
}
