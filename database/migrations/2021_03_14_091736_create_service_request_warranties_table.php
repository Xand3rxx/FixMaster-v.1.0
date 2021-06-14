<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_warranties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('client_id');
            $table->foreignId('warranty_id');
            $table->foreignId('service_request_id')->unique();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->integer('amount')->unsigned()->nullable()->default(0);
            $table->enum('status', ['used', 'unused'])->default('unused');
            $table->enum('initiated', ['Yes', 'No'])->default('No');
            $table->enum('has_been_attended_to', ['Yes', 'No'])->default('No');
            $table->text('reason')->nullable();
            $table->dateTime('date_initiated')->nullable();
            $table->dateTime('date_resolved')->nullable();
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
        Schema::dropIfExists('service_request_warranties');
    }
}
