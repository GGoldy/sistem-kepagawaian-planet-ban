<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use App\Models\LokasiKerja;
use App\Models\Ketidakhadiran;
use App\Models\Pensiun;
use App\Models\StatusPegawai;
use App\Models\Penugasan;
use App\Models\Gaji;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $karyawans = Karyawan::factory(30)->create();

        // $karyawans->each(function ($karyawan) {

        //     StatusPegawai::factory()->create([
        //         'karyawan_id' => $karyawan->id
        //     ]);

        //     Penugasan::factory()->create([
        //         'karyawan_id' => $karyawan->id
        //     ]);

        //     Gaji::factory()->create([
        //         'karyawan_id' => $karyawan->id
        //     ]);
        // });

        $this->call([
            // LokasiKerjaSeeder::class
            // KetidakhadiranSeeder::class
            // RoleSeeder::class,
            // LokasiKerjaSeeder::class,
            UserSeeder::class,
        ]);
    }
}
