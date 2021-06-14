<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestWarrantiesIssuedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_warranties_issued', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('service_request_warranty_id');
            $table->foreignId('cse_id')->nullable();
            $table->foreignId('technician_id')->nullable();
            $table->dateTime('scheduled_datetime')->nullable();
            $table->foreignId('completed_by')->nullable();
            $table->string('admin_comment')->nullable();
            $table->string('cse_comment')->nullable();
            $table->dateTime('date_resolved')->nullable();
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
        Schema::dropIfExists('service_request_warranties_issued');
    }
}
