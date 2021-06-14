<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Log;


use Mail;

class Message extends Controller
{
    //

    public function sendEmail(Request $request)
    {
        $feature = $request->input('feature');
        $subject = $request->input('subject');
        $to = $request->input('recipient');
        $mail_data = $request->input('mail_data');
        $template = MessageTemplate::select('content')
                                    ->where('feature', $feature)
                                    ->first();

        if(empty($template)){
            return response()->json(["message" => "Message Template not found!"], 404);

        }
        $message = $this->replacePlaceHolders($mail_data, $template->content);
        Log::debug($message);
        Mail::send('emails.message', ['mail_message' => $message], function ($m) use ($to, $subject) {
            $m->from('hello@fixmaster.com', $subject);

            $m->to($to, $to)->subject($subject);
        });
    }

    private function replacePlaceHolders($variables, $messageTemp){
        foreach($variables as $key => $value){
            if($key == '{url}'){
                $messageTemp = str_replace('{'.$key.'}', '<button style="background-color:red">'.$value.'<button>', $messageTemp);  
            }else{
                $messageTemp = str_replace('{'.$key.'}', $value, $messageTemp);
            }
           
        }

        return $messageTemp;
    }
}
