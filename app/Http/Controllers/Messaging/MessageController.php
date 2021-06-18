<?php


namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageTemplate;
use App\Models\User;
use App\Models\UserType;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Traits\Loggable;
use App\Jobs\PushEmails;
use App\Jobs\PushSMS;
use Mail;
use Route;
use Auth;
use App\Mail\MailNotify;

class MessageController extends Controller
{
    use Loggable;

    public function getInbox(Request $request)
    {
        $emails = DB::table('messages')
            ->join('accounts', 'messages.sender', '=', 'accounts.user_id')
            ->orderBy('messages.created_at', 'DESC')
            ->select('messages.*', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->where('messages.recipient',  $request->input('userid'))
            ->get();

        if (!empty($emails)) {
            return response()->json(["data" => $emails], 200);
        }
        return response()->json(["message" => "Inbox is empty!"], 404);
    }

    public function getOutBox(Request $request)
    {

        $emails = DB::table('messages')
            ->join('accounts', 'messages.recipient', '=', 'accounts.user_id')
            ->orderBy('messages.created_at', 'DESC')
            ->select('messages.*', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->where('messages.sender', $request->input('userid'))
            ->get();

        if (!empty($emails)) {
            return response()->json(["data" => $emails], 200);
        }
        return response()->json(["message" => "Inbox is empty!"], 404);
    }

    public function getMessage(Request $request)
    {
        $message_id = $request->input('message_id');
        $email = DB::table('messages')
            ->join('accounts', 'messages.recipient', '=', 'accounts.user_id')
            ->where('messages.uuid', $message_id)
            ->select('messages.*', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->first();

        $message = Message::find($email->id);
        $message->mail_status = 'read';
        $message->save();
        if (!empty($email)) {
            return response()->json(["data" => $email], 200);
        }
        return response()->json(["message" => "Message is empty!"], 404);
    }

    public function getRecipients(Request $request)
    {
        $searchVal = $request->input('search_val');
        $recipients = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->where('users.email', 'LIKE', "%{$searchVal}%")
            ->orWhere('accounts.first_name', 'LIKE', "%{$searchVal}%")
            ->orWhere('accounts.middle_name', 'LIKE', "%{$searchVal}%")
            ->orWhere('accounts.last_name', 'LIKE', "%{$searchVal}%")
            ->select('accounts.user_id', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name', 'users.email')
            ->get();
        Log::debug($recipients);

        if (!empty($recipients)) {
            return response()->json(["data" => $recipients], 200);
        }
        return response()->json(["message" => "data not found!"], 404);
    }

    public function saveEmail(Request $request)
    {
        $subject = $request->input('subject');
        $recipients = $request->input('recipients');
        $sender =  $request->input('sender');
        $mail_content = $request->input('mail_content');
        $mail_objects = [];
        $userIds = [];
        $receivers = [];
        $receiverDetails = [];

        $senderDetails = $this->getUser($sender);
        Log::debug($recipients);
        foreach ($recipients as $recipient) {
            array_push($receivers, $recipient['value']);
        }

        $users = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->whereIn('users.id', $receivers)
            ->select('users.id', 'users.email', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->get();



        foreach ($users as $user) {
            $mail_objects[] = [
                'title' => $subject,
                'content' => $mail_content,
                'recipient' => $user->id,
                'sender' => $sender,
                'uuid' => Str::uuid()->toString(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'mail_status' => 'Not Sent',
            ];
            $this->sendNewMessage($subject, $senderDetails->email, $user->email, $mail_content, "");
        }
        Message::insert($mail_objects);
        return response()->json([
            "message" => "Messages sent successfully!"
        ], 201);
    }



    public function saveGroupEmail(Request $request)
    {
        $subject = $request->input('subject');
        $recipients = $request->input('recipients');
        $sender =  $request->input('sender');
        $mail_content = $request->input('mail_content');
        $mail_objects = [];
        $userIds = [];
        $receivers = [];
        $receiverDetails = [];

        $senderDetails = $this->getUser($sender);
        foreach ($recipients as $recipient) {
            array_push($receivers, $recipient['value']);
        }

        $users = DB::table('user_types')
            ->join('accounts', 'user_types.user_id', '=', 'accounts.user_id')
            ->join('users', 'users.id', '=', 'user_types.user_id')
            ->whereIn('role_id', $receivers)
            ->select('user_types.user_id', 'users.email', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->get();



        foreach ($users as $user) {
            $mail_objects[] = [
                'title' => $subject,
                'content' => $mail_content,
                'recipient' => $user->user_id,
                'sender' => $sender,
                'uuid' => Str::uuid()->toString(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'mail_status' => 'Not Sent',
            ];
            $this->sendNewMessage("mail", $subject, $senderDetails->email, $user->email, $mail_content, "");
        }
        // Message::insert($mail_objects);
        return response()->json([
            "message" => "Messages sent successfully!"
        ], 201);
    }


    public function sendMessage(Request $request)
    {

        $subject = $request->input('subject');
        $to = $request->input('recipient');
        $mail_data = $request->input('mail_data');
        $from = $request->input('sender');
        $feature = $request->input('feature');


        $this->sendNewMessage($subject, $from, $to, $mail_data, $feature);
    }

    /**
     * Send message using Available Template Design
     * 
     * @param string $template_name ...use \App\Models\MessageTemplate::Feature
     * @param mixed $parameters 
     * 
     * @return \Illuminate\Http\Response
     */
    // public static function usingTemplate(string $template_name, mixed $parameters)
    // {
    //     if (!in_array($template_name, \App\Models\MessageTemplate::FEATURES)) {
    //         return response()->json(["message" => "Message Template not found!"], 404);
    //     }
    //     // Find needed Template
    //     $messageTemplate = MessageTemplate::select('content')->where('feature', $template_name)->first();
    //     // Build Message Body
    //     $message_body = self::buildMessageBody($parameters, $messageTemplate->content);
    // }

    /**
     * Build Message Body
     * 
     * @param string $template_name ...use \App\Models\MessageTemplate::Feature
     * @param mixed $parameters 
     * 
     * @return \Illuminate\Http\Response
     */
    // protected static function buildMessageBody($variables, $messageTemp)
    // {
    //     (array) $builtBody = [];
    //     foreach ($variables as $key => $value) {
    //         $builtBody = str_replace('{' . $key . '}', $value, $messageTemp);
    //     }
    //     return $builtBody;
    // }

    /**
     * Send message using feature
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendNewMessage($subject = "", $from = "", $to, $mail_data, $feature = "")
    {

        $message = $mail_data;
        $sms = "";
        $message_array = [];
        $template = null;
        $sender = null;
        $recipient = null;


        if (!empty($feature)) {
            $template = MessageTemplate::where('feature', $feature)->first();

            if (empty($template)) {
                return response()->json(["message" => "Message Template not found!"], 404);
            }
            $message = $this->replacePlaceHolders($mail_data, $template->content);
            //$sms = $this->replacePlaceHolders($mail_data, $template->sms);
            $subject = $template->title;
        }

        if ($from != "")
            $sender = DB::table('users')->where('users.email', $from)->first();
        else
            $from = "dev@fix-master.com";

        $recipient = DB::table('users')->where('users.email', $to)->first();

        if (!is_null($sender) && $from != "" && is_object($recipient)) {
            $mail_objects[] = [
                'title' => $subject,
                'content' => $message,
                'recipient' => $recipient->id,
                'sender' => $sender->id,
                'uuid' => Str::uuid()->toString(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'mail_status' => 'Not Sent',
            ];

            Message::insert($mail_objects);
        }


        $message_array = ['to' => $to, 'from' => $from, 'subject' => $subject, 'content' => $message];

        $mail = $this->dispatch(new PushEmails($message_array));

        return $mail;


        // if(!empty($feature) && $sms!=""){
        //     $this->dispatch(new PushSMS($sms));
        // }


    }



    private function replacePlaceHolders($variables, $messageTemp)
    {
        // foreach ($variables as $key => $value) {
        //     $messageTemp = str_replace('{' . $key . '}', $value, $messageTemp);
        // }

        // return $messageTemp;
      
        foreach ($variables as $key => $value) {
        if($key == 'url'){
            $messageTemp = str_replace('{'.$key.'}', '<a href="'.$value.'" style=" background-color: #E97D1F; border: none;color: white; padding:7px 32px;text-align: center;display: inline-block;font-size: 14px; border-radius:6px; text-decoration:none;">Here </a>', $messageTemp);  
        }else{
            $messageTemp = str_replace('{'.$key.'}', $value, $messageTemp);
        }
    }

        return $messageTemp;
    }

    private function getUser($userId)
    {
        $user = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->where('users.id', $userId)
            ->select('users.id', 'users.email', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->first();

        return $user;
    }

    public function userRoles()
    {
        return Role::all();
    }
}