<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestMedia extends Model
{
    protected $table = 'service_request_medias';

    protected $guarded = ['created_at', 'updated_at'];

    public function media_files(){
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }
}
