<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestReport extends Model
{
    use HasFactory;

    protected $table = 'service_request_reports';

    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];

    const TYPES = ['Root-Cause', 'Other-Comment', 'Comment'];
    const STAGES = ['Service-Request', 'Warranty-Claim'];

    /**
     * Store record of a Assigned User on the Service Request Progress Table
     * 
     * @param  int          $user_id
     * @param  int          $service_request_id
     * @param  string       $stage \App\Models\ServiceRequestReport::STAGES
     * @param  string       $type \App\Models\ServiceRequestReport::TYPES
     * @param  string       $report
     * @param  int|Null     $sub_service_id
     * 
     * 
     * @return \App\Models\ServiceRequestReport|Null
     */
    public static function store(int $user_id, int $service_request_id, string $stage, string $type, string $report, int $sub_service_id = null)
    {
        return ServiceRequestReport::create([
            'user_id'              => $user_id,
            'service_request_id'   => $service_request_id,
            'stage'                 => $stage,
            'type'                  => $type,
            'report'                => $report,
            'sub_service_id'        => $sub_service_id
        ]);
    }
}
