<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function lokasi_kerja()
    {
        return $this->belongsTo(LokasiKerja::class);
    }
}
