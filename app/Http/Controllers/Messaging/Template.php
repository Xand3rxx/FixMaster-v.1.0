<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\EnumHelper;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Log;


class Template extends Controller
{ 
    public function getMessageModules()
    {
        $enumHelper = new EnumHelper();
         return $enumHelper->getPossibleEnumValues('feature', 'message_templates');

    }

    public function getAllTemplates()
    {
        //return MessageTemplate::select('id', 'uuid','title',  'feature')->paginate(10);
        $messageTemplates = MessageTemplate::select(['id', 'title', 'uuid', 'feature'])->get();
        return view('admin.messaging.template.template', ['templates'=>$messageTemplates]);
    }

    public function getTemplate($uuid)
    {
         $template = MessageTemplate::where('uuid', $uuid)->first();
        if(!empty($template)){
           return response()->json(["data" => $template], 200);
        }
        return response()->json(["message" => "Template not found!"], 404);

    }

    public function saveMessageTemplate(Request $request)
    {
        try{
            $feature = $request->input('feature');
            $title = $request->input('title');
            $content = $request->input('content');
            $sms = $request->input('sms');
            $template = MessageTemplate::select('*')
                        ->where('feature', $feature)
                        ->first();
            if(!empty($template)){
                return response()->json(["message" => "There is already a template for this feature!"], 400);
            }

            MessageTemplate::create(['title'=>$title, 'content'=>$content, 'sms'=>$sms, 'feature'=>$feature]);
            return response()->json([
            "message" => "Template created successfully!", "data"=>$template
        ], 201);
        }catch(Throwable $e){
          return response()->json([
        "message" => "Internal server error!"
    ], 500);
        }

    }

    public function updateMessageTemplate(Request $request)
    {
        try{
        $feature = $request->input('feature');
        $title = $request->input('title');
        $content = $request->input('content');
        $sms = $request->input('sms');

        $template = MessageTemplate::updateOrCreate(
            ['feature'=> $feature],
            ['title' => $title, 'content' => $content, 'sms' => $sms]
        );
        return response()->json([
        "message" => "Template updated successfully!", "data"=>$template
        ], 201);
        }catch(Throwable $e){
          return response()->json([
        "message" => "Internal server error!"
    ], 500);
        }
    }

    public function deleteMessageTemplate($uuid)
    {
        $template = MessageTemplate::where('uuid', $uuid)->first();
        if(!empty($template)){
           $template->delete();
           return response()->json(["message" => "Template deleted successfully!", "data"=>[]], 200);
        }
        return response()->json(["message" => "Template not found!"], 404);

    }
}

    public function see(){
        return view('emails.message', ['mail_message'=> 'Your job rating counts! Remember to request for a rating and review on all completed diagnosis and job repairs completed.']);

       
    }

}
