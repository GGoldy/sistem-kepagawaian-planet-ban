<?php

namespace Database\Factories;

use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Karyawan>
 */
class KaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Karyawan::class;

    public function definition(): array
    {
        return [
            'personne_data' => $this->faker->sentence(),
            'jabatan' => $this->faker->jobTitle(),
            'nik' => $this->faker->unique()->numerify('############'),
            'nama' => $this->faker->name(),
            'tanggal_lahir' => $this->faker->date(),
            'tempat_lahir' => $this->faker->city(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'status_pernikahan' => $this->faker->randomElement(['Single', 'Menikah']),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'pendidikan_terakhir' => $this->faker->randomElement(['SMA', 'D3', 'S1', 'S2']),
            'alamat' => $this->faker->address(),
            'kota' => $this->faker->city(),
            'provinsi' => $this->faker->state(),
            'negara' => 'Indonesia',
            'kode_pos' => $this->faker->postcode(),
            'no_telepon_rumah' => $this->faker->numerify('####-######'),
            'no_telepon_handphone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
