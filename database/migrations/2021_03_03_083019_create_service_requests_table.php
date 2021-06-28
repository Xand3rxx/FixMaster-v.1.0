<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Temporary schema for Service Requests
        Schema::create('service_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('unique_id')->unique();
            $table->foreignId('client_id');
            $table->foreignId('client_discount_id')->nullable();
            $table->string('client_security_code')->unique();
            $table->dateTime('preferred_time')->nullable();

            $table->boolean('contactme_status', 1)->comment('I.e. 0 => Do not contact me, 1 => I can be contacted.')->default(1);
            $table->foreignId('contact_id');
            $table->longText('description');



            $table->foreignId('price_id');
            $table->bigInteger('total_amount')->unsigned();



            $table->foreignId('service_id')->nullable();
            $table->json('sub_services')->nullable();

            $table->enum('has_client_rated', ['Yes', 'No', 'Skipped'])->default('No');
            $table->enum('has_cse_rated', ['Yes', 'No', 'Skipped'])->default('No');

            $table->foreignId('status_id')->default(\App\Models\ServiceRequest::SERVICE_REQUEST_STATUSES['Pending']);
            $table->timestamp('date_completed')->nullable()->default(NULL);

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
        Schema::dropIfExists('service_requests');
    }
}
