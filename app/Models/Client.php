<?php

namespace App\Models;

use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use Generator;

    /**
     *
     * The attributes that aren't mass assignable.
     *
     * @var array
     *
     */
    protected $guarded = ['created_at', 'updated_at', 'firsttime','unique_id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($client) {
            $client->unique_id = static::generate('clients', 'WAL-'); // Create a Unique Client id
        });
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class,'ratee_id');
    }

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with(['account', 'contact', 'clientWalletBalance']);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the service request of the Client
     */
    public function service_requests()
    {
        return $this->hasMany(ServiceRequest::class, 'client_id', 'user_id')->with('service', 'warranty', 'bookingFee', 'price', 'service_request_assignees', 'serviceRequestPayment')->orderBy('created_at','DESC');
    }

    public function service_request()
    {
        return $this->hasOne(ServiceRequest::class, 'client_id', 'user_id')->with('service');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'service_request_id');
    }

    public function clientAverageRating(){
        return round($this->ratings->avg('star'));
    }

    public function profession()
    {
        return $this->hasOne(Profession::class, 'id', 'profession_id');
    }

    public function walletTransaction()
    {
        return $this->hasOne(WalletTransaction::class, 'user_id', 'user_id');
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class, 'user_id', 'user_id')->with('payment');
    }
}

