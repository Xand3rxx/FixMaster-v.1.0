<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('rater_id')->comment('User doing the rating');
            $table->foreignId('ratee_id')->comment('User being rated')->nullable();
            $table->foreignId('service_request_id')->nullable();
            $table->foreignId('service_id')->nullable();
            $table->integer('star');
            $table->integer('service_diagnosis_by')->comment('CSE that performed the diagnosis')->nullable();
            $table->integer('service_performed_by')->comment('CSE that performed the job')->nullable();

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
        Schema::dropIfExists('ratings');
    }
}
