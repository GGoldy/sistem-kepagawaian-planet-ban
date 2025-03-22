<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKerja extends Model
{
    use HasFactory;

    public function absen()
    {
        return $this->hasMany(Absen::class);
    }
}
