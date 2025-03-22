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
        Schema::create('ketidakhadirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->dateTime('tanggal_pengajuan');
            $table->boolean('status_pengajuan')->default(false);
            $table->string('jenis_ketidakhadiran');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->string('tujuan')->nullable();
            $table->date('tanggal_sah')->nullable();
            $table->date('tanggal_aktif')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketidakhadirans');
    }
};
