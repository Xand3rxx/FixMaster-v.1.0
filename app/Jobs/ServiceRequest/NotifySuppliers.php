<?php

namespace App\Jobs\ServiceRequest;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\Messaging\MessageController;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;

class NotifySuppliers implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 
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
            # Build Notification
            $params = [
                'recipient_email' => $supplier->email,
                // ''
            ];
            # send this supplier the notification... 
            $message = MessageController::multiple($params, 'ADMIN_CSE_JOB_ACCEPTANCE_NOTIFICATION');
            $this->send($mailer, $message);

            if ($mailer->failures()) {
                $this->send($mailer, $message);
            }
        }
    }

    protected function send($mailer, $message)
    {
        return $mailer->send('emails.message', ['mail_message' => $message->content], function ($mail) use ($message) {
            $mail->from($message['sender']['email'])->to($message['recipient']['email'])->subject($message['title']);
        });
    }
}
