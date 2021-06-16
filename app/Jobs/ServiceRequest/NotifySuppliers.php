<?php

namespace App\Jobs\ServiceRequest;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use App\Models\ServiceRequest;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;

class NotifySuppliers implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Notify all suppliers.
     *
     * @var \App\Models\ServiceRequest
     */
    protected $service_request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $service_request)
    {
        $this->service_request = $service_request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        // Get all suppliers with deleted_at of null status
        $suppliers = User::all()->reject(function ($user) {
            return $user->hasRole('supplier-user') === false;
        })->loadMissing(['account', 'supplier']);
        // Loop through all suppliers and send each of them email
        foreach ($suppliers as $key => $supplier) {
            # send this supplier the notification... 
            
        }
    }
}
