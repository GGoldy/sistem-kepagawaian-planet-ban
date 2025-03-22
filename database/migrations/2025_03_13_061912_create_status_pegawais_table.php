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
        Schema::create('status_pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('status_kerja');
            $table->date('mulai_kerja');
            $table->date('akhir_kerja')->nullable();
            $table->string('alasan_berhenti')->nullable();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pegawais');
    }
};
