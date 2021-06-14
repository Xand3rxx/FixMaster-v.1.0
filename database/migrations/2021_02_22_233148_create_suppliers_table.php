<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('unique_id')->unique();

            $table->foreignId('user_id')->index();
            $table->foreignId('account_id')->index();

            $table->string('business_name')->unique();
            $table->date('established_on');
            $table->enum('education_level', \App\Models\Supplier::EDUCATIONLEVEL);

            $table->string('cac_number', 14)->unique();
            $table->longText('business_description');

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
        Schema::dropIfExists('suppliers');
    }
}
