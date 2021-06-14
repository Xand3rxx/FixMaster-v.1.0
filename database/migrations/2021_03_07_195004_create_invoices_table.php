<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('client_id');
            $table->foreignId('service_request_id');
            $table->foreignId('rfq_id')->nullable();
            $table->foreignId('warranty_id')->nullable();
            $table->foreignId('sub_service_id')->nullable();
            $table->string('unique_id');
            $table->string('invoice_type');
            $table->decimal('labour_cost', 8,3)->nullable();
            $table->decimal('materials_cost', 8,3)->nullable();
            $table->integer('hours_spent')->nullable();
            $table->float('total_amount', 8,3)->nullable();
            $table->float('amount_due', 8,3)->nullable();
            $table->float('amount_paid', 8,3)->nullable();
            $table->enum('status', ['0' ,'1' ,'2'])->default('0');
            $table->enum('phase', ['0' ,'1', '2'])->default('0');
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
        Schema::dropIfExists('invoices');
    }
}
