<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     *
     */
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the user that owns the contact details.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the contact details.
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function lga()
    {
        return $this->belongsTo(Lga::class);
    }

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function service_requests()
    {
        return $this->hasMany(ServiceRequest::class, 'contact_id');
    }
    /**
     * The "booted" method of the model.
     * To be used during production for integrity reasons
     *
     * @return void
     */
    // protected static function booted()
    // {
    //     static::creating(function ($contact) {
    //         $contact->user_id = auth()->user()->id ?? rand(0, 5); //Automatically inject authenticated
    //         $contact->account_id = auth()->user()->account->id ?? rand(0, 5); //Automatically inject authenticated
    //     });
    // }

    /**
     * Store Contact Information of a User
     *
     * @param  string   $user_id
     * @param  string   $account_id
     * @param  int      $country_id
     * @param  string   $phone_number
     * @param  string   $address
     * @param  string   $address_longitude
     * @param  string   $address_latitude
     *
     * @return \App\Model\Contact|Null
     */
    public static function attemptToStore(string $user_id, string $account_id, int $country_id, string $phone_number, string $address, string $address_longitude, string $address_latitude)
    {
        return self::saveContactDetails($user_id, $account_id, $country_id, $phone_number, $address, $address_longitude, $address_latitude);
    }

    /**
     * Save contact details of a user
     *
     * @param  string   $user_id
     * @param  string   $account_id
     * @param  int      $country_id
     * @param  string   $phone_number
     * @param  string   $address
     * @param  string   $address_longitude
     * @param  string   $address_latitude
     *
     * @return \App\Model\Contact|Null
     */
    protected static function saveContactDetails(string $user_id, string $account_id, int $country_id, string $phone_number, string $address, string $address_longitude, string $address_latitude)
    {
        return Contact::create([
            'user_id'               => $user_id,
            'account_id'            => $account_id,
            'country_id'            => $country_id,
            'phone_number'          => $phone_number,
            'address'               => $address,
            'address_longitude'     => $address_longitude,
            'address_latitude'      => $address_latitude,
        ]);
    }

    /**
     * Get the user that owns the Account.
     */
    public function useraccount()
    {
        return $this->belongsTo(Account::class);
    }



}
