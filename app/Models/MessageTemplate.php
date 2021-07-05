<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MessageTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'sms',
        'content',
        'feature',
    ];

    protected $softDelete = true;

    const FEATURES = [
        'ADMIN_ASSIGNED_CSE_TO_A_JOB',
        'ADMIN_ASSIGNED_TECHNICIAN_TO_A_JOB',
        'ADMIN_ASSIGNED_QA_TO_A_JOB',
        'ADMIN_CUSTOMER_PAYMENT_SUCCESSFUL_NOTIFICATION',
        'ADMIN_CUSTOMER_JOB_COMPLETED_NOTIFICATION',
        'ADMIN_CSE_JOB_ACCEPTANCE_NOTIFICATION',
        'ADMIN_CSE_JOB_COMPLETED_NOTIFICATION',
        'ADMIN_CSE_SUPPLIER_INVOICE_APPROVAL_NOTIFICATION',
        'ADMIN_NEW_JOB_NOTIFICATION',
        'ADMIN_JOB_CANCELLATION_NOTIFICATION',
        'ADMIN_PENDING_JOB_REMINDER_NOTIFICATION',
        'ADMIN_SENT_ADMIN_MESSAGE_NOTIFICATION',
        'ADMIN_SENT_CSE_MESSAGE_NOTIFICATION',
        'ADMIN_SENT_CUSTOMER_MESSAGE_NOTIFICATION',
        'ADMIN_SENT_SUPPLIER_MESSAGE_NOTIFICATION',
        'ADMIN_SENT_SUPPLIER_INVOICE_NOTIFICATION',
        'ADMIN_SENT_TECHNICIAN_MESSAGE_NOTIFICATION',
        'ADMIN_SENT_QA_MESSAGE_NOTIFICATION',
        'ADMIN_SUPPLIER_DISPATCHED_PAID_INVOICE_NOTIFICATION',
        'ADMIN_SUPPLIER_DISPATCHED_MATERIALS_NOTIFICATION',
        'ADMIN_WARRANTY_CLAIM_NOTIFICATION',
        'ADMIN_WARRANTY_CLAIM_RESOLVED_NOTIFICATION',
        'ADMIN_SEND_CSE_WARRANTY_CLAIM_ASSIGN_NOTIFICATION',
        'CLIENT_FIRSTTIME_DISCOUNT_NOTIFICATION',
        'CLIENT_REFERRAL_NOTIFICATION',
        'CLIENT_SEND_RECEIVE_WARRANTY_NOTIFICATION',
        'CSE_REFERRAL_NOTIFICATION',
        'CSE_ACCOUNT_CREATION_NOTIFICATION',
        'CSE_APPLICATION_REJECTED',
        'CSE_APPLICATION_SUBMITTED',
        'CSE_APPLICATION_SUCCESSFUL',
        'CSE_ASSIGNED_TECHNICIAN_TO_A_JOB',
        'CSE_ASSIGNED_QA_TO_A_JOB',
        'CSE_CUSTOMER_PAID_FOR_MATERIALS',
        'CSE_NEW_JOB_NOTIFICATION',
        'CSE_JOB_COMPLETED_NOTIFICATION',
        'CSE_SENT_ADMIN_MESSAGE_NOTIFICATION',
        'CSE_SENT_CUSTOMER_MESSAGE_NOTIFICATION',
        'CSE_SENT_SUPPLIER_MESSAGE_NOTIFICATION',
        'CSE_SENT_TECHNICIAN_MESSAGE_NOTIFICATION',
        'CSE_SENT_QA_MESSAGE_NOTIFICATION',
        'CSE_SUPPLIER_DISPATCHED_MATERIALS_NOTIFICATION',
        'CSE_WARRANTY_CLAIM_NOTIFICATION',
        'CUSTOMER_CUSTOM_DISCOUNT',
        'CUSTOMER_EDITED_JOB_NOTIFICATION',
        'CUSTOMER_DIAGNOSIS_INVOICE',
        'CUSTOMER_FINAL_INVOICE',
        'CUSTOMER_JOB_COMPLETED_NOTIFICATION',
        'CUSTOMER_JOB_ACCEPTANCE_NOTIFICATION',
        'CUSTOMER_JOB_CANCELLATION_NOTIFICATION',
        'CUSTOMER_JOB_SCHEDULED_TIME_NOTIFICATION',
        'CUSTOMER_REDEEMED_LOYALTY',
        'CUSTOMER_PAYMENT_FAILED_NOTIFICATION',
        'CUSTOMER_PAYMENT_SUCCESSFUL_NOTIFICATION',
        'CUSTOMER_SENT_ADMIN_MESSAGE_NOTIFICATION',
        'CUSTOMER_SENT_ADMIN_JOB_COMPLETED_NOTIFICATION',
        'CUSTOMER_SENT_CSE_JOB_COMPLETED_NOTIFICATION',
        'CUSTOMER_SENT_CSE_MESSAGE_NOTIFICATION',
        'CUSTOMER_WARRANTY_CLAIM_NOTIFICATION',
        'CUSTOMER_WARRANTY_CLAIM_RESOLVED_NOTIFICATION',
        'CUSTOMER_WELCOME_DISCOUNT',
        'SUPPLIER_ACCOUNT_CREATION_NOTIFICATION',
        'SUPPLIER_ACCEPTED_INVOICE_NOTIFICATION',
        'SUPPLIER_APPLICATION_REJECTED',
        'SUPPLIER_APPLICATION_SUBMITTED',
        'SUPPLIER_APPLICATION_SUCCESSFUL',
        'SUPPLIER_DECLINED_INVOICE_NOTIFICATION',
        'SUPPLIER_DISPATCHED_ACCEPTED_INVOICE_NOTIFICATION',
        'SUPPLIER_DISPATCHED_INVOICE_NOTIFICATION',
        'SUPPLIER_DISPATCHED_PAID_INVOICE_NOTIFICATION',
        'SUPPLIER_DISPATCHED_REJECTED_INVOICE_NOTIFICATION',
        'SUPPLIER_NEW_RFQ_NOTIFICATION',
        'SUPPLIER_SENT_ADMIN_MESSAGE_NOTIFICATION',
        'SUPPLIER_SENT_CSE_MESSAGE_NOTIFICATION',
        'SUPPLIER_SENT_INVOICE_NOTIFICATION',
        'SUPPLIER_WARRANTY_CLAIM_NOTIFICATION',
        'TECHNICIAN_ACCOUNT_CREATION_NOTIFICATION',
        'TECHNICIAN_APPLICATION_REJECTED',
        'TECHNICIAN_APPLICATION_SUBMITTED',
        'TECHNICIAN_APPLICATION_SUCCESSFUL',
        'TECHNICIAN_JOB_COMPLETED_NOTIFICATION',
        'TECHNICIAN_SENT_ADMIN_MESSAGE_NOTIFICATION',
        'TECHNICIAN_SENT_CSE_MESSAGE_NOTIFICATION',
        'TECHNICIAN_WARRANTY_CLAIM_NOTIFICATION',
        'QA_ACCOUNT_CREATION_NOTIFICATION',
        'QA_JOB_COMPLETED_NOTIFICATION',
        'QA_JOB_CONSULTATION_NOTIFICATION',
        'QA_SENT_ADMIN_MESSAGE_NOTIFICATION',
        'QA_SENT_CSE_MESSAGE_NOTIFICATION',
        'QA_WARRANTY_CLAIM_NOTIFICATION',
        'USER_EMAIL_VERIFICATION'
        
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
