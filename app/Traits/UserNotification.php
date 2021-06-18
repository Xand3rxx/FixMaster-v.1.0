<?php

namespace App\Traits;

use App\Http\Controllers\Messaging\MessageController;
use App\Models\MessageTemplate;

trait UserNotification
{
    protected $params;
    protected $template_name;

    /**
     * Notify the user 
     *
     * @param  array $params
     * @param  string $template_name
     * 
     * @return void
     */
    public static function send(array $params, string $template_name)
    {
        if (!in_array($template_name, MessageTemplate::FEATURES)) {
            return abort(403, 'Template Doesnot Exist!');
        }
        return array_key_exists('recipient_email', $params) ? self::notify($params, $template_name) : abort(403, 'Recipient Email Address not included');
    }

    /**
     * Submit Notification for Queueing
     *
     * @param  array $params
     * @param  string $template_name
     * 
     * @return void
     */
    protected static function notify(array $params, string $template_name)
    {
        $messanger = new MessageController();
        return $messanger->sendNewMessage(null, null, $params['recipient_email'], $params, $template_name);
    }
}
