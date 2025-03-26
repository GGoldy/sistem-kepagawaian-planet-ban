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
        Schema::table('ketidakhadirans', function (Blueprint $table) {
            $table->json('tanggal_pengganti')->nullable()->after('tanggal_berakhir');
            $table->foreignId('approved_by_hcm')->nullable()->after('approved_by')->constrained('karyawans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ketidakhadirans', function (Blueprint $table) {
            $table->dropColumn('tanggal_pengganti'); // Rollback if needed
            $table->dropColumn('approved_by_hcm');
        });
    }
};
