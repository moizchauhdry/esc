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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->unsigned()->nullable();
            $table->integer('month')->unsigned()->nullable();
            $table->string('month_name')->nullable();
            $table->dateTime('expense_at')->nullable();
            $table->double('total_amount')->nullable();
            $table->integer('items_count')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
