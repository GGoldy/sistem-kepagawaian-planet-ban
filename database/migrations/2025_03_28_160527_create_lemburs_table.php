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
        Schema::create('lemburs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->foreignId('approved_by_hcm')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->foreignId('atasan')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->string('signature')->nullable();
            $table->string('signature_hcm')->nullable();
            $table->dateTime('tanggal_pengajuan');
            $table->boolean('status_pengajuan')->default(false);
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->string('tugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lemburs');
    }
};
