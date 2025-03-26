<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketidakhadiran extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal_pengganti'];

    protected $casts = [
        'tanggal_pengganti' => 'array', // Automatically converts JSON to array in Laravel
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(Karyawan::class, 'approved_by');
    }

    public function approved_by_hcm()
    {
        return $this->belongsTo(Karyawan::class, 'approved_by_hcm');
    }
}
