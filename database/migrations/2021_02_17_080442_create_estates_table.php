<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('state_id');
            $table->foreignId('lga_id');
            $table->string('created_by');
            $table->integer('approved_by')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number', '11');
            $table->string('date_of_birth');
            $table->string('identification_type');
            $table->string('identification_number');
            $table->string('expiry_date');
            $table->text('full_address');
            $table->string('estate_name')->unique();
            $table->string('town');
            $table->string('landmark');
            $table->enum('is_active', ['approved', 'declined', 'pending', 'deactivated', 'reinstated'])->default('pending');
            $table->string('slug');
            $table->json('discounted')->nullable();
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
        Schema::dropIfExists('estates');
    }
}
