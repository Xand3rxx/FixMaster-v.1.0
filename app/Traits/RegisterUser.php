<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


trait RegisterUser
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function createUser(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
