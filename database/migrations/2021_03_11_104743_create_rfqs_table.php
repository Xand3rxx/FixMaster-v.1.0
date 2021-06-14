<?php

use App\Models\Rfq;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid');
            $table->string('unique_id')->unique()->comment('e.g RFQ-C85BEA04');
            $table->foreignId('issued_by');
            $table->foreignId('service_request_id');
            $table->enum('type', Rfq::TYPES);
            $table->enum('status', Rfq::STATUSES)->default(Rfq::STATUSES[0]);
            $table->enum('accepted',  Rfq::ACCEPTABLE)->default(Rfq::ACCEPTABLE[0]);
            $table->unsignedInteger('total_amount')->default(0);
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
        Schema::dropIfExists('rfqs');
    }
}