<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InformasiRiset>
 */
class InformasiRisetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deskripsi' => $this->faker->paragraph(),
            'persyaratan' => $this->faker->paragraph(),
            'benefit' => $this->faker->paragraph(),
            'info_kontak' => $this->faker->paragraph(),
        ];
    }
}
