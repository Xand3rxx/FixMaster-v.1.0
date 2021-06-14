<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Messaging\Template;
use App\Http\Controllers\Messaging\MessageController;
use App\Http\Controllers\Messaging\Message;
use App\Http\Controllers\CSE\RequestController;
use Illuminate\Support\Facades\DB;
use App\Models\User;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('template/features', function() {
   $template = new Template();
   return $template->getMessageModules();

});

Route::get('template/list', function() {
  $template = new Template();
   return $template->getAllTemplates();

});

Route::get('template/{id}', function($id) {
  $template = new Template();
   return $template->getTemplate($id);

});

Route::post('template/save', function(Request $request) {
   $template = new Template();
   return $template->saveMessageTemplate($request);

});

Route::post('template/update', function(Request $request) {
   $template = new Template();
   return $template->updateMessageTemplate($request);

});

Route::delete('template/delete/{id}', function($id) {
   $template = new Template();
   return $template->deleteMessageTemplate($id);

});

Route::post('message/send', function(Request $request) {
   $message = new Message();
   return $message->sendEmail($request);

});

Route::get('messaging/outbox', function(Request $request) {
   $messageController = new MessageController();
    return $messageController->getOutBox($request);

 });

 Route::get('messaging/inbox', function(Request $request) {
   $messageController = new MessageController();
    return $messageController->getInbox($request);

 });

 Route::get('messaging/getMessage', function(Request $request) {
   $messageController = new MessageController();
    return $messageController->getMessage($request);

 });


Route::get('messaging/roles', function() {
   $messageController = new MessageController();
    return $messageController->userRoles();

 });

 Route::post('messaging/save_email', function(Request $request) {
   $messageController = new MessageController();
    return $messageController->saveEmail($request);

 });

 Route::post('messaging/save_group_email', function(Request $request) {
   $messageController = new MessageController();
    return $messageController->saveGroupEmail($request);

 });

 Route::get('messaging/recipients', function(Request $request) {
   $messageController = new MessageController();
    return $messageController->getRecipients($request);

 });


 Route::get('requests/ongoing_jobs_technician', function(Request $request) {
   $requestController = new RequestController();
   return $requestController->getServiceRequestsByTechnician($request);
 });

 Route::get('requests/ongoing_jobs_cse', function(Request $request) {
   $requestController = new RequestController();
   return $requestController->getServiceRequestsByCse($request);
 });

 Route::get('requests/involved_users', function(Request $request) {
   $requestController = new RequestController();
   return $requestController->getUsersByReferenceID($request);
 });

Route::get('/',      [\App\Http\Controllers\EstateController::class, 'showEstates'])->name('list_estate');


