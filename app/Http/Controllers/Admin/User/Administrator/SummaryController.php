<?php

namespace App\Http\Controllers\Admin\User\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $language
     * @return \Illuminate\Http\Response
     */
    public function show($language, \App\Models\User $user)
    {
        return view(
            'admin.users.administrator.summary.show',
            [
                'user' => $user->load('administrator', 'contact', 'account', 'roles'),
                'last_seen' => $user->load(['logs' => function ($query) {
                    $query->where('type', 'logout')->orderBy('created_at', 'asc');}]),
                'logs' => $user->loadCount(['logs' => function ($query) {
                    $query->where('type', 'login');}]),
                'requests_supervised' => '0',
                'payments_disbursed' => '0',
                'messages_sent' => '0',
            ]
        );
    }
}
