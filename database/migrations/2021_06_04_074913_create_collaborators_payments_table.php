<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaboratorsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborators_payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('service_request_id');
            $table->foreignId('user_id');
            $table->enum('service_type', ['Regular', 'Warranty']);
            $table->float('flat_rate')->nullable();
            $table->float('actual_labour_cost')->nullable();
            $table->float('actual_material_cost')->nullable();
            $table->float('amount_to_be_paid')->nullable();
            $table->float('amount_after_retention')->nullable();
            $table->float('retention_fee')->nullable();
            $table->enum('retention_cronjob_update', ['Update', 'Pending'])->default('Pending');
            $table->float('labour_markup_cost')->nullable();
            $table->float('material_markup_cost')->nullable();
            $table->float('royalty_fee')->nullable();
            $table->float('logistics_cost')->nullable();
            $table->float('tax_fee')->nullable();
            $table->enum('status', ['Pending', 'Paid']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collaborators_payments');
    }
}
