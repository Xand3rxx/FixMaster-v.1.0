<?php

use App\Models\RfqSupplierDispatch;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqSupplierDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_supplier_dispatches', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->foreignId('rfq_id');
            $table->foreignId('rfq_supplier_invoice');
            $table->foreignId('supplier_id');
            $table->string('unique_id')->unique()->comment('Supplier delivery code e.g DEV-C85BEA04');
            $table->string('courier_name');
            $table->string('courier_phone_number', 15);
            $table->string('delivery_medium');
            $table->enum('cse_status', RfqSupplierDispatch::CSE_STATUS)->default(RfqSupplierDispatch::CSE_STATUS[0]);
            $table->enum('cse_material_acceptance', RfqSupplierDispatch::CSE_MATERIAL_ACCEPTANCE)->nullable()->default(null);

            $table->enum('supplier_status', ['Processing', 'In-Transit', 'Delivered'])->default('Processing');
            $table->text('cse_comment')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('rfq_supplier_dispatches');
    }
}
