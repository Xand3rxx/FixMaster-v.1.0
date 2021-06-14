<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    // column name of key
    // protected $primaryKey = 'uuid';

    // type of key
    // protected $keyType = 'string';

    // whether the key is automatically incremented or not
    // public $incrementing = false;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'service_charge', 'diagnosis_subsequent_hour_charge', 'description', 'status', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'id'
    // ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new serivce uuid is to be created
        static::creating(function ($service) {
            $service->uuid = (string) Str::uuid();
        });
    }

     /**
     * Scope a query to only include active banches
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    //Scope to return all services
    public function scopeServicies($query){
        return $query->select('*')
            ->orderBy('name', 'ASC');
        // ->withTrashed();
    }

    /**
     * Scope a query to only include active banches
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    //Scope to return all active services
    public function scopeActiveServicies($query){
        return $query->select('*')
            ->where('status', '=', 1)
            // ->whereNull('deleted_at')
            ->orderBy('name', 'ASC');
    }

    
    public static function getServiceNameById(int $id){
        return Service::where('id', $id)->value('name');
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

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'service_id', 'id');
    }

    public function clientDiscount()
    {
        return $this->belongsTo(ClientDiscount::class, 'client_id');
    }

    public function serviceRequest()
    {
        return $this->hasOne(ServiceRequest::class, 'service_id', 'id');
    }

    public function clientDiscounts()
    {
        return $this->hasMany(ClientDiscount::class, 'client_id');
    }

    public function ratings(){

        return $this->hasMany(Rating::class,'service_id');

    }

    public function subServices(){

        return $this->hasMany(SubService::class);

    }
    

}
