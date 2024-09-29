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
        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('carrier_id')->unsigned()->after('carrier')->nullable();
            $table->float('due_carrier')->nullable()->after('total');
            $table->float('net_rate')->nullable()->after('due_carrier');
            $table->float('net_payable')->nullable()->after('net_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('carrier_id');
            $table->dropColumn('due_carrier');
            $table->dropColumn('net_rate');
            $table->dropColumn('net_payable');
        });
    }
};
