<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konsultan;
use Illuminate\Support\Facades\Hash;

class KonsultanSeeder extends Seeder
{
    public function run(): void
    {
        Konsultan::create([
            'nama' => 'Konsultan',
            'email' => 'konsultan@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
