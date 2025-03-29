<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lemburs';

    protected $casts = [
        'jam_lembur' => 'array',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Karyawan::class, 'approved_by', 'id');
    }

    public function approvedByHcm()
    {
        return $this->belongsTo(Karyawan::class, 'approved_by_hcm', 'id');
    }

    public function perintahatasan()
    {
        return $this->belongsTo(Karyawan::class, 'atasan', 'id');
    }
}
