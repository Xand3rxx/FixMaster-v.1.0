<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estate extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'state_id', 'lga_id', 'first_name', 'last_name', 'email', 'phone_number', 'date_of_birth', 'identification_type', 'identification_number', 'expiry_date', 'full_address', 'estate_name', 'town', 'landmark', 'is_active', 'created_by', 'approved_by', 'slug'
    ];

    use SoftDeletes;

    public function state()
    {
        return $this->belongsTo(State::class);
    }


    public function lga()
    {
        return $this->belongsTo(Lga::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function estatePromotion()
    {
        return $this->hasMany(EstatePromotion::class);
    }

}
