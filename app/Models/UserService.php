<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    // 
    protected $table = 'users_services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'role_id',  'service_id'];

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with('account');
    }

    /**
     * Store the User Service
     * 
     * @param  int   $user_id
     * @param  int   $service_id
     * @param  int   $role_id
     * 
     * @return \App\Model\UserService|Null
     */
    public static function storeUserService(int $user_id, int $service_id, int $role_id)
    {
        return self::storeService($user_id, $service_id, $role_id);
    }

    /**
     * Save the User service 
     * 
     * @param  int   $user_id
     * @param  int   $service_id
     * @param  int   $role_id
     * 
     * @return \App\Model\UserService|Null
     */
    protected static function storeService(int $user_id, int $service_id, int $role_id)
    {
        return UserService::create([
            'user_id'    => $user_id,
            'service_id' => $service_id,
            'role_id'    => $role_id,
        ]);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id')->with('category');
    }
}
