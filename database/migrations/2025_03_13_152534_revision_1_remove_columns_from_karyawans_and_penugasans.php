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
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn('personne_data');
        });

        Schema::table('penugasans', function (Blueprint $table) {
            $table->dropColumn(['position', 'status_karyawan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('personne_data')->nullable();
        });

        Schema::table('penugasans', function (Blueprint $table) {
            $table->string('position');
            $table->string('status_karyawan');
        });
    }
};
