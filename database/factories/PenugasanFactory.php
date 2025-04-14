<?php

namespace Database\Factories;

use App\Models\Penugasan;
use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penugasan>
 */
class PenugasanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Penugasan::class;

    public function definition(): array
    {
        return [
            'perusahaan'=> $this->faker->randomElement(['Toko', 'Kantor']),
            'area'=> $this->faker->randomElement(['Kantor Cabang Surabaya', 'Semarang', 'Samarinda', 'Denpasar', 'Palembang']),
            'unit'=> $this->faker->randomElement(['Departemen A', 'Departemen B', 'Departemen C']),
            'level' => $this->faker->numberBetween(1, 8),
            'grade' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'karyawan_id' => Karyawan::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
