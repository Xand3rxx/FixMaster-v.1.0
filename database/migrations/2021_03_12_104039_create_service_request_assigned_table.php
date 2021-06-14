<?php

use App\Models\ServiceRequestAssigned;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_assigned', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('service_request_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->enum('job_accepted', ['Yes', 'No'])->nullable();
            $table->timestamp('job_acceptance_time')->nullable();
            $table->enum('qa_job_accepted', ['Yes'])->nullable();
            $table->timestamp('qa_job_acceptance_time')->nullable();
            $table->timestamp('job_diagnostic_date')->nullable();
            $table->timestamp('job_declined_time')->nullable();
            $table->timestamp('job_completed_date')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->nullable()->default('Inactive');
            $table->enum('assistive_role', ServiceRequestAssigned::ASSISTIVE_ROLE)->nullable()->default(ServiceRequestAssigned::ASSISTIVE_ROLE[0]);

            $table->primary(['user_id', 'service_request_id']);
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
        Schema::dropIfExists('service_request_assigned');
    }
}