<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstateDiscountHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_discount_histories', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->charset = 'utf8mb4'; 
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id(); 
            $table->uuid('uuid')->unique(); 
            $table->foreignId('discount_id')->nullable(); 
            $table->foreignId('discount_history_id')->nullable(); 
            $table->foreignId('estate_id')->nullable(); 
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
        Schema::dropIfExists('estate_discount_histories');
    }
}
