<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 250)->unique();
            $table->string('entity', 250);
            $table->string('created_by', 250);
            $table->string('apply_discount', 100);
            $table->float('rate');
            $table->enum('notify', [0, 1])->default(0);
            $table->dateTime('duration_start');
            $table->dateTime('duration_end');
            $table->longText('description')->nullable();
            $table->json('parameter')->nullable();
            $table->enum('status', ['activate', 'deactivate'])->default('activate');
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
        Schema::dropIfExists('discounts');
    }
}
