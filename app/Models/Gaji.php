<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
        // return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }
}
