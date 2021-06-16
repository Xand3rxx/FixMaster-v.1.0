<?php

namespace App\Traits;

use App\Http\Controllers\Messaging\MessageController;


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
        return array_key_exists('email', $params) ? self::notify($params, $template_name) : abort(403, 'Receiver Email Address not included');
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
        return $messanger->sendNewMessage(null, null, $params['email'], $params, $template_name);
    }
}
