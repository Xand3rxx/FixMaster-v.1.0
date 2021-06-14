<?php

namespace App\Models;

use App\Traits\RolesAndPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserType extends Model
{
    use RolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'role_id',  'url'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id', 'user_id',];

    /**
     * The roles relationship.
     * @return mixed
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    /**
     * Create a User Type
     * 
     * @param  int      $user_id
     * @param  int      $role_id
     * @param  string   $url
     * 
     * @return boolean
     */
    public static function store(int $user_id, int $role_id, string $url)
    {
        return self::attepmtCreatingUserType($user_id, $role_id, $url);
    }

    /**
     * Attempt to Create a User Type
     * 
     * @param  int      $user_id
     * @param  int      $role_id
     * @param  string   $url
     * 
     * @return boolean
     */
    protected static function attepmtCreatingUserType(int $user_id, int $role_id, string $url)
    {
        return collect(UserType::create(['user_id' => $user_id, 'role_id' => $role_id,  'url' => $url,]))->isNotEmpty() ? true : false;
    }
}
