<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'medias';
    
    protected $fillable = [
        'client_id', 'original_name', 'unique_name', 
    ];

    protected $guarded = ['deleted_at','created_at', 'updated_at'];

}
