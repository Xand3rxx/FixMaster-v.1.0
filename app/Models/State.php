<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
      'code', 'name' 
    ];

    public function lgas()
    {
        return $this->hasMany(Lga::class, 'state_id')->orderBy('name','ASC');
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
        return $this->hasOne(Estate::class,'state_id');
    }

    public function estates()
    {
        return $this->hasMany(Estate::class,'state_id');
    }
}
