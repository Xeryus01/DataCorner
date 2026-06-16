<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'operator',
            'operator magang',
            'operator kepegawaian',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'admin',
            ]);
        }

        $accounts = [
            [
                'nama' => 'Admin',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'role' => 'admin',
            ],
            [
                'nama' => 'Operator Konten Edukasi',
                'email' => 'operator@example.com',
                'username' => 'operator',
                'role' => 'operator',
            ],
            [
                'nama' => 'Operator Magang',
                'email' => 'operator.magang@example.com',
                'username' => 'operator_magang',
                'role' => 'operator magang',
            ],
            [
                'nama' => 'Operator Kepegawaian',
                'email' => 'operator.kepegawaian@example.com',
                'username' => 'operator_kepegawaian',
                'role' => 'operator kepegawaian',
            ],
        ];

        foreach ($accounts as $account) {
            $admin = Admin::updateOrCreate(
                ['email' => $account['email']],
                [
                    'nama' => $account['nama'],
                    'username' => $account['username'],
                    'password' => Hash::make('password'),
                ]
            );

            $admin->syncRoles($account['role']);
        }
    }
}
