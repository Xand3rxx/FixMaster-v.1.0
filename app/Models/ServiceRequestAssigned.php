<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestAssigned extends Model
{
    protected $table = 'service_request_assigned';

    const JOB_ACCEPTED = ['Yes', 'No'];
    const STATUS = ['Active', 'Inactive'];
    const ASSISTIVE_ROLE = ['Technician', 'Consultant', 'CSE'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * Get the authenticated user assigned to the request
     */
    public function service_request()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * Get the service request assigned user
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with('account', 'roles', 'ratings');
    }

    /**
     * Store record of a Assigned User on the Service Request Assigned Table
     *
     * @param  int      $user_id
     * @param  int      $service_request_id
     * @param  string   $job_accepted
     * @param  string   $job_acceptance_time
     * @param  string   $job_diagnostic_date
     * @param  string   $job_declined_time
     * @param  string   $job_completed_date
     *
     * @return \App\Models\ServiceRequestAssigned|Null
     */
    public static function assignUserOnServiceRequest(int $user_id, int $service_request_id, string $job_accepted = null, string $job_acceptance_time = null, string $status = null, string $job_diagnostic_date = null, string $job_declined_time = null, string $job_completed_date = null, $assitive_role = null)
    {
        return ServiceRequestAssigned::create([
            'user_id'                   => $user_id,
            'service_request_id'        => $service_request_id,
            'job_accepted'              => $job_accepted,
            'job_acceptance_time'      => \Carbon\Carbon::now(),
            'job_diagnostic_date'       => $job_diagnostic_date,
            'job_declined_time'         => $job_declined_time,
            'job_completed_date'        => $job_completed_date,
            'assistive_role'            => $assitive_role ?? ServiceRequestAssigned::ASSISTIVE_ROLE[0],
            'status'                    => $status
        ]);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id')->with('roles', 'account');
    }

    // public function cses()
    // {
    //     return $this->belongsTo(Cse::class, 'user_id');
    // }


    public function account()
    {
        return $this->belongsTo(Account::class, 'service_request_id', 'user_id');
    }


    public function service_requests()
    {
        return $this->belongsTo(ServiceRequest::class)->with('users', 'client');
    }

    public function request_status()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client_requesting_service()
    {
        return $this->belongsTo(Account::class, 'user_id');
    }

    public function tech_account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'service_id');
    }

    public function service_request_warranty()
    {
        return $this->belongsTo(ServiceRequestWarranty::class, 'service_request_id', 'service_request_id');
    }

    /**
     * Scope a query to sort and filter service_request_assigned table
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopejobAssignedSorting($query, array $filters)
    {
        // Split all filter parameters from the array of filters
        $query->when((string) $filters['sort_level'] ?? null, function ($query, $sortLevel) use ($filters) {
            switch ($sortLevel) {
                case 'SortType2':
                    $query->whereBetween('job_acceptance_time', [$filters['date']['date_from'], $filters['date']['date_to']]);
                    break;

                case 'SortType3':
                    $query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                    break;

                default:
                    $query->latest('created_at');
                    break;
            }
        })->when((array)$filters['cse_id'] ?? null, function ($query, array $cses) {
            $query->whereIn('user_id', $cses[0]);
        })->when((string)$filters['job_status'] ?? null, function ($query) use ($filters) {
            $query->whereHas('service_request', function ($query) use ($filters) {
                $query->where('status_id', $filters['job_status']);
            });
        });
    }

    /**
     * Scope a query to sort and filter service_request_assigned table
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAmountEarnedSorting($query, array $filters)
    {
        // Split all filter parameters from the array of filters
        $query->when((string) $filters['sort_level'] ?? null, function ($query, $sortLevel) use ($filters) {
            switch ($sortLevel) {
                case 'SortType2':
                    $query->whereBetween('job_acceptance_time', [$filters['date']['date_from'], $filters['date']['date_to']]);
                    break;

                case 'SortType3':
                    $query->whereBetween('job_completed_date', [$filters['date']['date_from'], $filters['date']['date_to']]);
                    break;

                default:
                    $query->latest('created_at');
                    break;
            }
        })->when((array)$filters['cse_id'] ?? null, function ($query, array $cses) {
            $query->whereIn('user_id', $cses[0]);
        })->when((string)$filters['job_status'] ?? null, function ($query) use ($filters) {
            $query->whereHas('service_request', function ($query) use ($filters) {
                $query->where('status_id', $filters['job_status']);
            });
        });
    }
    
}
