<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsDisbursedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_disbursed', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('recipient_id')->index()->comment('CSE/QA/Technician user ID');
            $table->foreignId('service_request_id');
            $table->foreignId('payment_mode_id');
            $table->string('payment_reference')->unique();
            $table->bigInteger('amount')->unsigned();
            $table->string('payment_date')->comment('Convert the Payment Date to human readable format e.g. January 6th 2021, 8:53:37pm');

            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments_disbursed');
    }
}
