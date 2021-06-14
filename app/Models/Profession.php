<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    public $table = "professions";

    public $timestamps = false;

    protected $fillable = [
        'name', 'description'
    ];

    public function client()
    {
        return $this->hasOne(Client::class, 'profession_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'profession_id');
    }

}
