<?php

namespace App\Jobs\Servicerequest;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Controllers\Messaging\MessageController;
use App\Models\ServiceRequest;

class NotifyCse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Signed url
     * @var string
     */
    protected $url;

    /**
     * The podcast instance.
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
        // Get all cess with deleted_at of null status
        $users = User::all()->reject(function ($user) {
            return $user->hasRole('cse-user') === false;
        })->loadMissing(['account', 'cse']);
        // Loop through all cess and send each of them email
        foreach ($users as $key => $cse) {
            return $cse;
            $params = [
                'recipient_email' => $cse->email,
                'lastname' => $cse['account']['first_name'],
                'firstname' => $cse['account']['last_name'],
                'email' => $cse['email'],
                'url'  => (string)$this->url($this->service_request)
            ];
            # send this ces the notification... 
            $message = MessageController::multiple($params, 'CSE_NEW_JOB_NOTIFICATION');
            $this->send($mailer, $message);

            if ($mailer->failures()) {
                $this->send($mailer, $message);
            }
        }
    }

    protected function send($mailer, $message)
    {
        return $mailer->send('emails.message', ['mail_message' => $message['content']], function ($mail) use ($message) {
            $mail->from($message['from'])->to($message['to'])->subject($message['subject']);
        });
    }

    protected function url($service_request)
    {
        return URL::signedRoute(
            'cse.index',
            [
                'id' => auth()->user()->uuid,
                'hash' => sha1($service_request->uuid),
                'locale' => app()->getLocale()
            ]
        );
    }
}
