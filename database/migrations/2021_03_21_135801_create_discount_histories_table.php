<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_histories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->foreignId('discount_id');
            $table->foreignId('client_id')->nullable();
            $table->foreignId('estate_id')->nullable();
            $table->foreignId('service_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('service_category')->nullable();
            $table->string('service_name')->nullable();
            $table->string('estate_name')->nullable();
            $table->enum('availability', ['used', 'unused'])->default('unused');
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
        Schema::dropIfExists('discount_histories');
    }
}
