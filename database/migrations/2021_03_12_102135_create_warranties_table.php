<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('user_id');
            $table->string('unique_id')->comment('e.g. WAR-09328932');
            $table->string('name')->unique();
            $table->float('percentage')->nullable()->default(0);
            $table->enum('warranty_type', ['Free', 'Extended']);
            $table->unsignedInteger('duration')->comment('i.e 1month equals 30days.');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('warranties');
    }
}
