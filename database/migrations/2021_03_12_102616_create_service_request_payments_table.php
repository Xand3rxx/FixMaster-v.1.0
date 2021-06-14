<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            //$table->uuid('uuid')->unique();
            $table->foreignId('user_id');
            $table->foreignId('payment_id');
            $table->foreignId('service_request_id');
            $table->integer('amount')->unsigned();
            $table->string('unique_id', 191)->comment('e.g. REF-36786429');
            $table->enum('payment_type', ['booking-fee', 'diagnosis-fee', 'rfq', 'final-invoice-fee']);
            $table->enum('status', ['success','pending','failed']);
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
        Schema::dropIfExists('service_request_payments');
    }
}
