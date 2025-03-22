<?php

namespace Database\Factories;

use App\Models\StatusPegawai;
use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusPegawai>
 */
class StatusPegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = StatusPegawai::class;

    public function definition(): array
    {
        return [
            'status_kerja'=> $this->faker->randomElement(['Tetap', 'Kontrak', 'Magang']),
            'mulai_kerja' => $this->faker->date(),
            'akhir_kerja' => $this->faker->date(),
            'alasan_berhenti' => $this->faker->sentence(),
            'karyawan_id' => Karyawan::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
