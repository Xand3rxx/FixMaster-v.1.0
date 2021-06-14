<?php

namespace App\Traits;

use App\Models\ActivityLog;
trait Loggable
{
    /**
     * Create an activity log
     * 
     * @param  string  $type
     * @param  string  $severity
     * @param  string  $severity
     * @param  string  $request_from
     * @param  string  $message
     * 
     * @return boolean
     */
    public static function log(string $type, string $severity, string $actionUrl, string $message)
    {
        return self::attepmtLogging($type, $severity, $actionUrl, $message);
    }

    /**
     * Attempt to record the user log into the application.
     *
     * @param  string  $type
     * @param  string  $severity
     * @param  string  $severity
     * @param  string  $request_from
     * @param  string  $message
     * 
     * @return boolean
     */
    protected static function attepmtLogging(string $type, string $severity, string $actionUrl, string $message)
    {
        return collect(ActivityLog::create([
            'type'                      =>  $type,
            'severity'                  =>  $severity,
            'action_url'                =>  $actionUrl,
            'message'                   =>  $message,
        ]))->isNotEmpty() ? true : false;
    }
}
