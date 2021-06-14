<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;
use App\Controllers\Messaging\MessageController;
use Illuminate\Support\Facades\Log;


class PushEmails  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $message_object;
    public function __construct($message_array)
    {
        $this->message_object = (object) $message_array;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $message = $this->message_object;
        $to = $message->to;
        $from = $message->from;
        $subject = $message->subject;
       return  $mailer->send('emails.message', ['mail_message' => $message->content], function ($m) use ($to, $from, $subject) {
            $m->from($from, $subject);
    
            $m->to($to, $to)->subject($subject);
            });
        
         
            // $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // // More headers
            // $headers .= 'From: <'.$from.'>' . "\r\n";

            // mail($to,$subject,$message->content,$headers);
    }
}
