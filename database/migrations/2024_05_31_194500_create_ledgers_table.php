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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->dateTime('invoice_at')->nullable();
            $table->decimal('debit_amount', 50, 2)->default(0);
            $table->decimal('credit_amount', 50, 2)->default(0);
            $table->decimal('opening_balance', 50, 2)->default(0);
            $table->decimal('closing_balance', 50, 2)->default(0);
            $table->decimal('invoice_total', 50, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
