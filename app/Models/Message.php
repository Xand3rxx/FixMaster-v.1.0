<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Message extends Model
{
    protected $fillable = [
        'title',
        'recipient',
        'content',
        'sender',
        'mail_status',
        'uuid',
    ];

    protected $softDelete = true;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['recipient','sender'];

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

    /**
     * Get the sender associated to the message
     */
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender');
    }

    /**
     * Get the recipient associated to the message
     */
    public function recipient()
    {
        return $this->hasOne(User::class, 'id', 'recipient');
    }
}
