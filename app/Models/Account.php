<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array 
     */
    protected $fillable = ['user_id', 'state_id',  'lga_id', 'town_id', 'first_name', 'middle_name', 'last_name', 'gender', 'account_number', 'bank_id', 'avatar'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['user'];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user'];

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function payment()
    {
        return $this->hasMany(PaymentDisbursed::class, 'user_id', 'user_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function lga()
    {
        return $this->belongsTo(Lga::class);
    }
    public function profession()
    {
        return $this->belongsTo(Profession::class, 'id');
    }

    public function client()
    {
        return $this->hasOne(client::class);
    }
    public function service_request()
    {
        return $this->hasMany(ServiceRequest::class, 'user_id', 'client_id');
    }

    /**
     * Get the Account associated with the contact.
     */
    public function usercontact()
    {
        return $this->hasOne(Contact::class, 'user_id', 'user_id');
    }

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    /**
     * Get the Supplier associated with the user.
     */
    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'user_id', 'user_id');
    }

    public function service_request_warranty_issued(){
        return $this->hasOne(ServiceRequestWarrantyIssued::class, 'cse_id', 'user_id');
    }

    public function warranty_issued(){
        return $this->hasOne(ServiceRequestWarrantyIssued::class, 'completed_by', 'user_id');
    }


}

