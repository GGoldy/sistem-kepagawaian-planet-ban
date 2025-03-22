<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lokasi_kerjas')->insert([
            [
                'nama' => 'Main',
                'latitude' => -7.377876788058929,
                'longitude' => 112.6451005662962
            ],
        ]);
    }
}
