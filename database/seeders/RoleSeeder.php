<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $konsultan = Role::create(['name' => 'konsultan']);

        User::create([
            'nama' => 'Admin User',
            'email' => 'admin@example.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('password'),
            'role_id' => $admin->id,
        ]);

        User::create([
            'nama' => 'Konsultan User',
            'email' => 'konsultan@example.com',
            'no_hp' => '081234567891',
            'password' => Hash::make('password'),
            'role_id' => $konsultan->id,
        ]);
    }
}

