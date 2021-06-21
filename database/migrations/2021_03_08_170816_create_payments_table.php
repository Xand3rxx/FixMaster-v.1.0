<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->foreignId('user_id');
            $table->integer('amount')->unsigned();
            $table->enum('payment_channel', Payment::PAYMENT_CHANNEL);
            $table->enum('payment_for', Payment::PAYMENT_FOR);
            $table->string('unique_id')->comment('e.g. REF-330CB862, WAL-23782382, WAR-09328932');
            $table->string('reference_id', 191)->unique();
            $table->string('transaction_id', 191)->nullable();
            $table->string('return_route_name')->nullable();
            $table->json('meta_data')->nullable();
            $table->enum('status', Payment::STATUS);
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
        Schema::dropIfExists('payments');
    }
}
