<?php

namespace Database\Factories;

use App\Models\Pensiun;
use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pensiun>
 */
class PensiunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Pensiun::class;

    public function definition(): array
    {
        return [
            'tanggal_pensiun' => $this->faker->date(),
            'keterangan' => $this->faker->sentence(),
            'karyawan_id' => Karyawan::factory(), // Relate to a Karyawan
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
