<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_batches', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->foreignId('rfq_id');
            $table->string('manufacturer_name');
            $table->string('model_number')->nullable();
            $table->string('component_name');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('size')->nullable();
            $table->string('unit_of_measurement')->nullable();
            $table->string('image')->unique()->nullable();
            $table->unsignedInteger('amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rfq_batches');
    }
}
