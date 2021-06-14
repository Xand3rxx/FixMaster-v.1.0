<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';


            $table->id();
            $table->string('unique_id')->unique();

            $table->foreignId('user_id')->index();
            $table->foreignId('account_id')->index();            
            $table->foreignId('referral_id')->index();
            
            $table->foreignId('franchisee_id')->nullable();
            $table->integer('firsttime')->default(0);
            $table->enum('job_availability', ['Yes', 'No'])->default('Yes');

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
        Schema::dropIfExists('cses');
    }
}
