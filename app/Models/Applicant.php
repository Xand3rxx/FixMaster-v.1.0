<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Messaging\MessageController;

class Applicant extends Model
{
    use SoftDeletes;

    const USER_TYPES = ['cse', 'supplier', 'technician'];

    const STATUSES = ['pending', 'approved', 'declined'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'form_data' => 'array',
    ];

    protected $template_feature;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Status is to be created
        static::creating(function ($applicant) {
            $applicant->uuid = (string) \Illuminate\Support\Str::uuid();
        });
        static::created(function ($applicant) {
            (string) $template_feature = NULL;
            switch ($applicant->user_type) {
                case Applicant::USER_TYPES[0]: // CSE...
                    $template_feature = 'CSE_ACCOUNT_CREATION_NOTIFICATION';
                    break;
                case Applicant::USER_TYPES[1]: // SUPPLIER...
                    $template_feature = 'SUPPLIER_ACCOUNT_CREATION_NOTIFICATION';
                    break;
                case Applicant::USER_TYPES[2]: // TECHNICIAN...
                    $template_feature = 'TECHNICIAN_ACCOUNT_CREATION_NOTIFICATION';
                    break;
                default:
                    # Ask for default Notification...
                    $template_feature = '';
                    break;
            }
            if (!empty((string)$template_feature)) {
                $messanger = new MessageController();
                $mail_data = collect([
                    'lastname' => $applicant->form_data['last_name'],
                    'firstname' => $applicant->form_data['first_name'],
                    'email' => $applicant->form_data['email'],
                ]);
                $messanger->sendNewMessage('Account Created', 'info@fixmaster.com.ng', $mail_data['email'], $mail_data, $template_feature);
                // $messanger->sendNewMessage('email', Str::title(Str::of($template_feature)->replace('_', ' ',)), 'info@fixmaster.com.ng', $mail_data['email'], $mail_data, $template_feature);
            }
        });
    }
}