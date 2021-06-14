<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Message extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'recipient',
        'content',
        'sender',
        'mail_status',
        'uuid',
    ];

   protected $softDelete = true;


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
