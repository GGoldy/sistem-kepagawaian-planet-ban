<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KetidakhadiranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ketidakhadirans')->insert([
            [
                'karyawan_id' => 1,
                'tanggal_pengajuan' => now(),
                'status_pengajuan' => false,
                'jenis_ketidakhadiran' => 'Sakit',
                'tanggal_mulai' => '2025-03-20',
                'tanggal_berakhir' => '2025-03-22',
                'tujuan' => 'Istirahat di rumah',
                'tanggal_sah' => null,
                'tanggal_aktif' => null,
                'approved_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'karyawan_id' => 2,
                'tanggal_pengajuan' => now(),
                'status_pengajuan' => true,
                'jenis_ketidakhadiran' => 'Cuti',
                'tanggal_mulai' => '2025-04-01',
                'tanggal_berakhir' => '2025-04-05',
                'tujuan' => 'Liburan ke Bali',
                'tanggal_sah' => '2025-03-25',
                'tanggal_aktif' => '2025-04-06',
                'approved_by' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
