<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;


trait SendVerificationMail
{

    /**
     * Send Email Verification to User Account Instance
     *
     * @param  \App\Models\Account $account
     * 
     * @return void
     */
    protected function sendVerificationEmail(\App\Models\Account $account)
    {
        $mail_data = [
            'lastname' => $account['last_name'],
            'firstname' => $account['first_name'],
            'email' => $account->user['email'],
            'url' => (string) $this->url($account->user)
        ];
        return \App\Traits\UserNotification::send($mail_data, 'USER_EMAIL_VERIFICATION');
    }


    /**
     * Get the verification URL for the given user.
     *
     * @param  \App\Models\User $user
     * @return string
     */
    public function url(\App\Models\User $user)
    {
        return $this->verificationUrl($user);
    }

    /**
     * Get the verification URL for the given user.
     *
     * @param  \App\Models\User $user
     * @return string
     */
    protected function verificationUrl($user)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 3600)),
            [
                'id' => $user->uuid,
                'hash' => sha1($user->email),
                'locale' => app()->getLocale()
            ]
        );
    }
}
