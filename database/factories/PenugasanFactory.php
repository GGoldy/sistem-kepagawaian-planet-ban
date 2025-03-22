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
            'perusahaan'=> $this->faker->randomElement(['SMI']),
            'area'=> $this->faker->randomElement(['Kantor Cabang Surabaya', 'Semarang', 'Samarinda', 'Denpasar', 'Palembang']),
            'status_karyawan'=> $this->faker->randomElement(['Tetap', 'Kontrak', 'Magang']),
            'unit'=> $this->faker->randomElement(['Departemen A', 'Departemen B', 'Departemen C']),
            'position' => $this->faker->randomElement(['Posisi A', 'Posisi B', 'Posisi C']),
            'level' => $this->faker->numberBetween(25, 50),
            'grade' => $this->faker->sentence(),
            'karyawan_id' => Karyawan::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
