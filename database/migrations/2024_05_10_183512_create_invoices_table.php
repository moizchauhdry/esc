<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('shipper_id');
            $table->integer('consignee_id');

            $table->dateTime('invoice_at')->nullable();

            $table->string('carrier', 100)->nullable();
            $table->string('mawb_no', 100)->nullable();
            $table->string('commodity')->nullable();
            $table->string('quantity', 100)->nullable();
            $table->string('weight', 100)->nullable();
            $table->string('afc_rate', 100)->nullable();

            $table->dateTime('departure_at')->nullable();
            $table->dateTime('landing_at')->nullable();

            $table->string('sender', 100)->nullable();
            $table->string('destination', 100)->nullable();

            $table->double('subtotal')->default(0);
            $table->double('total')->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('status_id')->unsigned()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
