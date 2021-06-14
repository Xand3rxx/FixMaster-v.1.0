<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('payment_id');
            $table->integer('amount')->unsigned();
            $table->enum('payment_type', ['funding','service-request','refund', 'loyalty']);
            $table->string('unique_id', 191)->comment('e.g. WAL-36786429');
            $table->enum('transaction_type', ['debit', 'credit']);
            $table->unsignedInteger('opening_balance');
            $table->unsignedInteger('closing_balance');
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
        Schema::dropIfExists('wallet_transactions');
    }
}