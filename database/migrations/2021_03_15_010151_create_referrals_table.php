<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('referral_code')->nullable();
            $table->integer('referral_count')->default(0);
            $table->string('referral')->nullable();
            $table->integer('referral_amount')->nullable();
            $table->integer('referral_discount')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('referrals');
    }
}
