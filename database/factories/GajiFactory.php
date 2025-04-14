<?php

namespace Database\Factories;

use App\Models\Karyawan;
use App\Models\Gaji;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gaji>
 */
class GajiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uang_makan' => $this->faker->numberBetween(1000000, 10000000),
            'gaji_pokok' => $this->faker->numberBetween(1000000, 10000000),
            'tunjangan_bpjs' => $this->faker->numberBetween(1000000, 10000000),
            'karyawan_id' => Karyawan::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
