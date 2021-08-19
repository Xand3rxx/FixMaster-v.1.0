<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    use HasFactory;

    protected $fillable = [
      'state_id', 'name'
    ];

    public function state()
    {
        return $this->belongsTo(State::class)->orderBy('name','ASC');
    }

    public function towns()
    {
        return $this->hasMany(Town::class, 'lga_id')->orderBy('name','ASC');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'state_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'state_id');
    }

    public function estate()
    {
        return $this->hasOne(Estate::class, 'state_id');
    }

    public function estates()
    {
        return $this->hasMany(Estate::class, 'state_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
