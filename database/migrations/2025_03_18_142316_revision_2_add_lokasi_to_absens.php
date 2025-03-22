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
        Schema::table('absens', function (Blueprint $table) {
            $table->unsignedBigInteger('lokasi_kerja_id')->after('waktu')->nullable(); // Adjust 'id' to the column you want it after
            $table->foreign('lokasi_kerja_id')->references('id')->on('lokasi_kerjas')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absens', function (Blueprint $table) {
            $table->dropForeign(['lokasi_kerja_id']);
            $table->dropColumn('lokasi_kerja_id');
        });
    }
};
