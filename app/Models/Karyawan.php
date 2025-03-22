<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function statuspegawai()
    {
        return $this->hasOne(StatusPegawai::class);
    }

    public function pensiun()
    {
        return $this->hasOne(Pensiun::class);
    }

    public function penugasan()
    {
        return $this->hasOne(Penugasan::class);
    }

    public function gaji()
    {
        return $this->hasOne(Gaji::class);
    }

    public function absen()
    {
        return $this->hasMany(Absen::class);
    }

    public function ketidakhadiran()
    {
        return $this->hasMany(Ketidakhadiran::class);
    }
}
