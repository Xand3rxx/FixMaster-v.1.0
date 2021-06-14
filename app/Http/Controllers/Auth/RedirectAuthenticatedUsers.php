<?php

namespace App\Http\Controllers\Auth;

trait RedirectAuthenticatedUsers
{
    /**
     * Set the redirect url of Authenticated user.
     * Determine redirection based on user role
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return app()->getLocale() .'/'.auth()->user()->type->url ?: app()->getLocale() .'/home';
    }
}
