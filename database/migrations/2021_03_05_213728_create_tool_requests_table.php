<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('unique_id')->unique()->comment('e.g TRF-C85BEA04');
            $table->foreignId('requested_by');
            $table->foreignId('approved_by')->nullable();
            $table->foreignId('service_request_id');
            $table->enum('status', ['Pending', 'Approved', 'Declined'])->default('Pending');
            $table->enum('is_returned', ['0', '1'])->nullable()->default(0);
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
        Schema::dropIfExists('tool_requests');
    }
}
