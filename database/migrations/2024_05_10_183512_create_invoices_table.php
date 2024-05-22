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
            $table->string('carrier', 100)->nullable();
            $table->string('mawb_no', 100)->nullable();
            $table->string('quantity', 100)->nullable();
            $table->string('weight', 100)->nullable();
            $table->string('commodity', 100)->nullable();
            $table->string('sender', 100)->nullable();
            $table->string('destination', 100)->nullable();
            $table->decimal('subtotal', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->default(0);
            $table->integer('created_by')->unsigned();
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
