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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->foreignId('penilai_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->string('bulan_penilaian');
            $table->string('tahun_penilaian');
            $table->string('kinerja');
            $table->string('kehadiran');
            $table->string('kerjasama_tim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
